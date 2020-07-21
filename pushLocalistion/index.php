<?php 
header('Content-Type: application/json');
require __DIR__ . '\vendor\autoload.php';
require __DIR__ . '\vendor\fonctions.php';
// dl('php_pgsql.dll');

// Configuration de l'application
$timeOfCycle = 20;
$etatApplication = "ACTIVE";

// Configuration de la BD
$dbName = 'tsb';
$host = '41.188.47.76';
$utilisateur = 'postgres';
$motDePasse = 'post@emitbase';
$port='5432';
$dns = 'pgsql:host='.$host .';dbname='.$dbName.';port='.$port;

// Boucle principale
while(true){
  sleep($timeOfCycle);
  $rows = [];

  try {
    // Connection
    $connection = new PDO( $dns, $utilisateur, $motDePasse,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requete voiture
    $sqll = 'select count("Voiture".*) from "Voiture"';
    $stmtt = $connection->prepare($sqll);
    $stmtt->execute();
    $rowss = $stmtt->fetchAll(PDO::FETCH_ASSOC);
    print_r($rowss);
    $sql = 'select tracer_x, tracer_y, tracer_date, voitu_id, voitu_matricule, chauf_id, chauf_nom, chauf_prenom
      from public."traceur", public."Voiture", public."Conduire", public."Chauffeur"
      where (tracer_numero = voitu_tracer_numero) and (voitu_id = cond_voitu_id)
      and (chauf_id = cond_chauf_id) order by voitu_id, tracer_date desc limit '.$rowss[0][count].';';
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  } catch ( Exception $e ) {
    echo "Connection à la BDD impossible : ", $e->getMessage();
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
      break;
    case 'PREPARATION':
      // Load voyage proche
        // Mettre en ecoute pour chaque voyages s'il doivent etre commencer
      $timeOfCycle = 45;
      break;
    case 'SLOW':
      // isExistVoyageProche
        // set state PREPARATION
      // else
        // isExistQueVoyageLoin
          // set state DESACTIVE
        // else continue
      $timeOfCycle = 5 * 60;
      break;
    default:
      // isExistVoyageOnDay
        // set state SLOW
      $timeOfCycle = 10 * 60;
      $etatApplication = 'DESACTIVE';
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
}