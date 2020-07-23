<?php 
header('Content-Type: application/json');
require __DIR__ . '\vendor\autoload.php';
require __DIR__ . '\vendor\fonctions.php';
// dl('php_pgsql.dll');

// Configuration de l'application
$timeOfCycle = 20;
$etatApplication = "ACTIVE";

// Creation de l'objet connection et initialisation de la connection
$connection = '';
try {
  $connection = new Connection();
} catch (Exception $e) {
  echo "Echec de la connection de la base de donnee---->".$e->getMessage();
  die();
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
      $timeOfCycle = 20;
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
      
      // get voyage concerned in 5Min
      $allVoyage = $connection->getVoyageAfter(5);
      $voyages = addNew($voyages, $allVoyage);
      

      // get voiture concerned 
      
      // si (inTrajet(voiture))
        // si isVoyageBegin(voiture)
          // 
        // else
          // beginVoyage(voiture) commencer le voyage pour cette voiture
      // else
      break;
    case 'SLOW':
      // isExistVoyageProche
        // set state PREPARATION
      // else
        // isExistQueVoyageLoin
          // set state DESACTIVE
        // else continue
      if($connection->isExistVoyageAfter(10)){
        $etatApplication = 'ACTIVE';
      }else{
        if(!$connection->isExistVoyageNow()){
          $etatApplication = 'DESACTIVE';
        }
      }
      $timeOfCycle = 5 * 60;
      break;
    default:
      // isExistVoyageOnDay
        // set state SLOW
      if($connection->isExistVoyageNow()){
        $etatApplication = 'SLOW';
      }else{
        $timeOfCycle = 10 * 60;
        $etatApplication = 'DESACTIVE';
      }
      break;
  }

  // Envoye de donnees
  $resultat =  json_encode($rows);
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
  $pusher->trigger('my-channel', 'my-event', $resultat, null, false, true);
  echo "Envoye de donnees[state::".$etatApplication."]";
  sleep($timeOfCycle);
}