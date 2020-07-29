<?php 
header('Content-Type: application/json');
require __DIR__ . '\vendor\autoload.php';
require __DIR__ . '\vendor\fonctions.php';
$file = '../config.json'; 
// chargement de la configuration
$data = file_get_contents($file); 
// décoder le flux JSON
$objJson = json_decode($data);
// dl('php_pgsql.dll');

// Configuration de l'application
$timeOfCycle = 20;
$tick = 0;
$etatApplication = "ACTIVE";
$vitesseMax = $objJson->vitesseMax;

// Creation de l'objet connection et initialisation de la connection
$connection = '';
try {
  $connection = new Connection();
} catch (Exception $e) {
  echo "Echec de la connection de la base de donnee---->".$e->getMessage();
  die();
}

$voyages= [];
function isTime($tick, $indexTime){
  return ($tick%$indexTime == 0);
}
function notifier($resultat, $typeEvent = 'my-event', $voya_id=0, $tracer_id = 0, $voitu_id = 0){
  $options = array(
    'cluster' => 'mt1',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '4311697e4aa8adaa8ba8',
    '056fd9016f03b597e6ce',
    '1021403',
    $options
  );
  $pusher->trigger('my-channel', $typeEvent, $resultat, null, false, true);
  if(($typeEvent != 'my-event')&($typeEvent != '')){
    $connection->saveNotification(array(
      "noti_nom"=>$typeEvent, 
      "noti_message"=>$resultat,
      "noti_voya_id"=>$voya_id,
      "noti_tracer_id"=>$tracer_id,
      "noti_voitu_id"=>$voitu_id
    ));
  }
}

function distanceInKmBetweenEarthCoordinates($lat1, $lon1, $lat2, $lon2) {
  $R = 6371; // km
  $dLat = deg2rad($lat2-$lat1);
  $dLon = deg2rad($lon2-$lon1);
  $lat1 = deg2rad($lat1);
  $lat2 = deg2rad($lat2);

  $a = sin($dLat/2) * sin($dLat/2) + sin($dLon/2) * sin($dLon/2) * cos($lat1) * cos($lat2); 

  $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
  return $R * $c;
}

// Boucle principale
while(true){
  $rows = [];

  try {
    // get nombre de voiture
    $numberVoitures = $connection->countVoiture();
    print_r($numberVoitures);

    // get position de la voiture
    $rows = $connection->getPositionVoiture($numberVoitures[0][count]);

  } catch ( Exception $e ) {
    echo "Erreur lors du lancement de la requette : ", $e->getMessage();
    die();
  }

  switch ($etatApplication) {
    case 'ACTIVE':
      // verifier pour chaque voiture s'il est hors trajet
        // select voyage en cours + itineraire
        // verifier si chaque point du trajet(position superieur a celle montionnee dernierement)
        //  durant cette voyage est dans la route

      // verifier vitesse (MAX, MIN, NORMAL)
      // isExistVoyageProche
        // Load voyage proche
          // Mettre en ecoute pour chaque voyages s'il doivent etre commencer ou terminer
      // else
        // set state SLOW
      
      // actualiser la liste des voyages only each 5 min
      if(isTime($tick, 15)){ 
        // get voyage concernee in 5Min interval
        $newVoyage = $connection->getVoyageAfter(5, $voyages);

        // get voiture concernee with 2 point activation
        $voitures = $connection->getVoitureByVoyage($newVoyage);

        // On ajoute les voitures dans les voyages correspondants
        // and ajouter isVoyageBegin
        $newVoyage = attachVoiture($newVoyage, $voitures);
        $voyages = array_merge($voyages, $newVoyage);
      }

      // Pour chaque voiture
        // si isVoyageBegin(voiture)
          // get position and calcule the vitesse etc
        // else
          // si (inTrajet(voiture))
            // beginVoyage(voiture) commencer le voyage pour cette voiture
      $newArrayVoyages = [];
      for ($indexVoyage=0; $indexVoyage < count($voyages); $indexVoyage++) { 
        $voyage = $voyages[$indexVoyage];
        $newArrayVoitures = [];
        for ($indexVoiture=0; $indexVoiture < count($voyage['voitures']); $indexVoiture++) { 
          $voiture = $voitures[$indexVoiture];
          $isVoyageFinish = FALSE;
          if($voiture['isVoyageBegin']){
            // filtrer les positions qui ne sont pas sur la route prevu
            $listPosition = $connection->positionOutOfTrajet($voiture['voitu_id'], $voiture['positions'][count($voiture['positions'])-1]['tracer_id']);
            for ($i=0; $i < count($listPosition); $i++) { 
              $position = $listPosition[$i];
              // Declarer une notification de "HORS TRAJET" -> la voiture n'est pas dans le trajet definit
              // $typeEvent = 'my-event', $voya_id=0, $tracer_id = 0, $voitu_id = 0
              notifier("La voiture n'est pas dans le trajet definit", "HORS TRAJET", $voyage['voya_id'], $position['tracer_id'], $voiture['voitu_id']);
            }
            
            // get vitesse
            $nbNewPosition = count($listPosition);
            $indexNewPosition = count($voyages[$indexVoyage]['voitures'][$indexVoiture]['positions']);
            array_merge($voyages[$indexVoyage]['voitures'][$indexVoiture]['positions'], $listPosition);
            $distances = [];
            $vitesses = [];
            $tempsDeParcours = 0;
            for ($indexDistances= $indexNewPosition; $indexDistances < $nbNewPosition+$indexNewPosition; $indexDistances++) { 
              $lat1 = $voiture['positions'][$indexDistances - 1]['tracer_y'];
              $lon1 = $voiture['positions'][$indexDistances - 1]['tracer_x'];
              $lat2 = $voiture['positions'][$indexDistances]['tracer_y'];
              $lon2 = $voiture['positions'][$indexDistances]['tracer_x'];
              $distance = distanceInKmBetweenEarthCoordinates($lat1, $lon1, $lat2, $lon2);
              array_push($distances, $distance);
              
              // calcule de vitesse et stocker dans une array ayant un taille t - 1 tel que t=count(distances)
              $instantT = floatval($voyages[$indexVoyage]['voitures'][$indexVoiture]['positions'][$indexDistances]['time']);
              if($instantPrecedent != 0){
                $vitesse = $distance/($instantT - $instantPrecedent);
                array_push($vitesses, $vitesse);
                // Vitesse max
                if($vitesse >= $vitesseMax){
                  notifier("La voiture a depassee les ".$vitesseMax." Km/h (".$vitesse.")", "VITESSE MAX", $voyage['voya_id'], $voiture['positions'][$indexDistances]['tracer_id'], $voiture['voitu_id']);
                }
                // Vitesse normal
                if(isset($voyages[$indexVoyage]['voitures'][$indexVoiture]['vitesseNormale'])){
                  $vNormal = 0;
                }else{
                  $vNormal = $voyages[$indexVoyage]['voitures'][$indexVoiture]['vitesseNormale'];
                }
                // nombre de position
                $nbPosition = $indexDistances;
                $vTotal = $nbPosition * $vNormal;
                $vTotal += $vitesse;
                $vNormal = $vTotal/($nbPosition +1);
                $voyages[$indexVoyage]['voitures'][$indexVoiture]['vitesseNormale'] = $vNormal;
                // Fin de trajet ?
                if($connection->isFinTrajet($voiture, $position)){
                  notifier("La vitesse normale de la voiture est de ".$vNormal."Km/h", "VITESSE NORMALE", $voyage['voya_id'], $voiture['positions'][$indexDistances]['tracer_id'], $voiture['voitu_id']);
                  if(isset($voyages[$indexVoyage]['voitures'][$indexVoiture]['finTrajet'])&!$voyages[$indexVoyage]['voitures'][$indexVoiture]['finTrajet']){
                    $voyages[$indexVoyage]['voitures'][$indexVoiture]['finTrajet'] = TRUE;
                    $isVoyageFinish = TRUE;
                  }
                  $connection->finVoyageVoiture($voiture["voitu_id"], $voyage["voya_id"]); 
                  // analyse if its en retard
                }
              }
              $instantPrecedent = $instantT;
            }
          }else{
            if(count($connection->positionOutOfTrajet($voiture['voitu_id'], 0)) == 0){
              $voyages[$indexVoyage]['voitures'][$indexVoiture]['isVoyageBegin'] = TRUE;
              $voyages[$indexVoyage]['voitures'][$indexVoiture]['positions'] = [];
              // Notifier "VOYAGE COMMENCER" -> une voiture a commencer son voyage
              $positionActuelle = $connection->getLastPosition($voiture['voitu_id']);
              notifier("Une voiture a commencer son voyage.", "VOYAGE COMMENCER", $voyage['voya_id'], $positionActuelle[0]['tracer_id'], $voiture['voitu_id']);
            }else{
              notifier("le voyage va commencer mais la voiture n'est pas encore dans le trajet.", "ATTENTE VOITURE", $voyage['voya_id'], 0, $voiture['voitu_id']);
              // Notifier "ATTENTE VOITURE" -> le voyage va commencer mais la voiture n'est pas encore dans le trajet 
            }
          }
          if(!$isVoyageFinish){
            array_push($newArrayVoitures, $voyages[$indexVoyage]['voitures'][$indexVoiture]);
          }
        }
        if(count($newArrayVoitures)>0){
          $voyage['voitures'] = $newArrayVoitures;
          array_push($newArrayVoyages, $voyage);
        }else{
          // le voyage prend fin
          $connection->finVoyage($voyage["voya_id"]);
        }
      }
      $voyages = $newArrayVoyages;
      
      break;
    case 'SLOW':
      // isExistVoyageProche
        // set state PREPARATION
      // else
        // isExistQueVoyageLoin
          // set state DESACTIVE
        // else continue
      if(isTime($tick, 10)){ /* 2 minutes */
        if($connection->isExistVoyageAfter(10)){
          $etatApplication = 'ACTIVE';
        }else{
          if(!$connection->isExistVoyageNow()){
            $etatApplication = 'DESACTIVE';
          }
        }  
      }
      break;
    default:
      if(isTime($tick, 45)){ /* 15 minutes */ 
        if($connection->isExistVoyageNow()){
          $etatApplication = 'SLOW';
        }
      }
      break;
  }

  // Envoye de donnees
  $resultat =  json_encode($rows);
  notifier($resultat);
  echo "Envoye de donnees[state::".$etatApplication."]";
  sleep($timeOfCycle);
  $tick++;
}