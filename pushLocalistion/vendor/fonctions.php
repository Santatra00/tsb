<?php
    $voyages = [];
    $voitures = [];
    $nouveauNotification = [];
    function verifierVitesse(){

    }
    function enregistrerNotification(){

    }
    function nouveauNotification(){

    }
    function getNotification(){
        $notification = $nouveauNotification;
        $nouveauNotification = [];
        return $notification;
    }
    function getVoyage(){

    }
    class Connection{
        // Configuration de la BD
        protected $dbName;
        protected $host;
        protected $utilisateur;
        protected $motDePasse;
        protected $port;
        protected $dns;
        protected $connection;
        
        function __construct(){
        // Configuration de la BD
            $file = '../config.json'; 
            // chargement de la configuration
            $data = file_get_contents($file); 
            // décoder le flux JSON
            $obj = json_decode($data);
            // assignation au propriete de la class
            $this->dbName = $obj->dbName;
            $this->host = $obj->host;
            $this->utilisateur = $obj->utilisateur;
            $this->motDePasse = $obj->motDePasse;
            $this->port = $obj->port;
            $this->dns = 'pgsql:host='.$this->host .';dbname='.$this->dbName.';port='.$this->port;

        // Initialisation de PDO
            $this->connection = new PDO( $this->$dns, $this->$utilisateur, $this->$motDePasse,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        function countVoiture(){
            // retourne le nombre de voiture enregistrer
            $query = 'select count("Voiture".*) from "Voiture"';
            $statement = $this->connection->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        function getPositionVoiture($number){
            // retourne la position actuelle de la voiture
            // le parametre {number} designe le nombre de voiture en cours
            $query = 'select tracer_x, tracer_y, tracer_date, voitu_id, voitu_matricule, chauf_id, chauf_nom, chauf_prenom
                from public."traceur", public."Voiture", public."Conduire", public."Chauffeur"
                where (tracer_numero = voitu_tracer_numero) and (voitu_id = cond_voitu_id)
                and (chauf_id = cond_chauf_id) order by voitu_id, tracer_date desc limit '.$number.';';
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }