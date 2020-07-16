<?php 
header('Content-Type: application/json');
 require __DIR__ . '\vendor\autoload.php';
 require __DIR__ . '\vendor\autoload.php';
      // dl('php_pgsql.dll');

while(true){

  sleep(20);
  try {
    $dbName = 'tsb';
    $host = '41.188.47.76';
    $utilisateur = 'postgres';
    $motDePasse = 'post@emitbase';
    $port='5432';
    $dns = 'pgsql:host='.$host .';dbname='.$dbName.';port='.$port;
    $connection = new PDO( $dns, $utilisateur, $motDePasse,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqll = 'select count("Voiture".*) from "Voiture"';
    $stmtt = $connection->prepare($sqll);
    $stmtt->execute();
    $rowss = $stmtt->fetchAll(PDO::FETCH_ASSOC);
    print_r($rowss);
    $sql = 'select tracer_x, tracer_y, tracer_date, voitu_id, voitu_matricule, chauf_id, chauf_nom, chauf_prenom
      from public."Traceur", public."Voiture", public."Conduire", public."Chauffeur"
      where (tracer_numero = voitu_tracer_numero) and (voitu_id = cond_voitu_id)
      and (chauf_id = cond_chauf_id) order by voitu_id, tracer_date desc limit '.$rowss[0][count].';';
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  } catch ( Exception $e ) {
    echo "Connection à la BDD impossible : ", $e->getMessage();
    die();
  }
             
  $resultat =  json_encode($rows);
  echo $resultat;
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
  echo "mandeha";

}