<?php 
header('Content-Type: application/json');
require __DIR__ . '\vendor\autoload.php';
require __DIR__ . '\vendor\fonctions.php';
// dl('php_pgsql.dll');

// Configuration de l'application
$timeOfCycle = 20;
$tick = 0;
$etatApplication = "ACTIVE";

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
function notifier($resultat, $typeEvent = 'my-event'){
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

        // get voiture concernee
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
      for ($indexVoyage=0; $indexVoyage < count($voyages); $indexVoyage++) { 
        $voyage = $voyages[$indexVoyage];
        for ($indexVoiture=0; $indexVoiture < count($voyage['voitures']); $indexVoiture++) { 
          $voiture =$voitures[$indexVoiture];

          if($voiture['isVoyageBegin']){
            // filter les positions qui ne sont pas sur la route prevu
            $listPosition = $connection->positionOutOfTrajet($voiture['voitu_id'], $voiture['positions'][count($voiture['positions'])-1]);
            for ($i=0; $i < count($listPosition); $i++) { 
              $position = $listPosition[$i];
              // Declarer une notification de "HORS TRAJET" -> la voiture n'est pas dans le trajet definit
            }

            // get vitesse

          }else{
            if(count($connection->positionOutOfTrajet($voiture['voitu_id'], 0)) == 0){
              $voyages[$indexVoyage]['voitures'][$indexVoiture]['isVoyageBegin'] = TRUE;
              $voyages[$indexVoyage]['voitures'][$indexVoiture]['positions'] = [];
              // Notifier "VOYAGE COMMENCER" -> une voiture a commencer son voyage
            }else{
              // Notifier "ATTENTE VOITURE" -> le voyage va commencer mais la voiture n'est pas encore dans le trajet 
            }
          }
        }
      }
      
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