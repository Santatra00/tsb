<?php
    class Upload extends CI_Controller{

        function __construct(){
            parent::__construct();
        }

        public function do_upload()
        {
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'jfif|gif|jpg|png|kmz|jpeg|JPEG|JPG|PNG|GIF';
            $config['max_size']             = 5000;
            $config['encrypt_name']         = TRUE;

            $this->load->library('upload', $config);

            $res = array();

            if ( ! $this->upload->do_upload('file'))
            {
                $error = array('error' => $this->upload->display_errors());
                $res['status'] = false;
                $res['error'] = $error;
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                $res['status'] = true;
                $res['link'] = 'uploads/'.$data['upload_data']['file_name'];
            }
            header('Content-type: application/json');
            echo json_encode($res);
        }
        public function insertReservation(){
            
            // Decrementation du nombre de ticket
            $this->load->model('Abonnement_m');
            $idData =  $this->get_all_data('post', ['reserv_abon_id']);
            $abonnement = $this->Abonnement_m->get($idData["reserv_abon_id"]);

            header('Content-type: application/json');
            if(count($abonnement)==1){
                $abonnement = $abonnement[0];
                if(intval($abonnement->nombre_ticket) > 0){
                    $abonnement->nombre_ticket --;
                    $this->Abonnement_m->save((Array) $abonnement, $abonnement->abon_id);

                    // Enregistrement de la reservation
                    if($this->enregistrerReservation()){
                        echo json_encode(array(
                            "message"=>"Enregistrement de la reservation reussi",
                            "status"=>TRUE
                        )); 
                    }else{
                        $abonnement->nombre_ticket++;
                        $this->Abonnement_m->save((Array) $abonnement, $abonnement->abon_id);
                        echo json_encode(array(
                            "message"=>"Enregistrement de la reservation echouee",
                            "status"=>FALSE
                        ));
                    }
                }else{
                    echo json_encode(array(
                        "message"=>"Nombre de ticket inferieur a 0",
                        "status"=>FALSE
                    ));  
                }
            }else{
                echo json_encode(array(
                    "message"=>"Cet abonnement n'existe pas",
                    "status"=>FALSE
                ));
            }



        }
        public function getAbonnement(){
            $dataEtudiant = $this->get_all_data('get', ['pseudo']);
            $this->load->model('Abonnement_m');

            header('Content-type: application/json');
            $abonnement = [];
            if(gettype($dataEtudiant["pseudo"])=='string'){
                try {
                    $abonnement = $this->Abonnement_m->getByPseudoEtudiant($dataEtudiant["pseudo"]);
                } catch (Exception $e) {
                    echo json_encode(array(
                        "status"=>FALSE,
                        "message"=> "Erreur lors du chargement des abonnements",
                        "data"=>$abonnement
                    ));
                }
            }else{
                echo json_encode(array(
                    "status"=>FALSE,
                    "message"=> "Pseudo doit etre une chaine de character",
                    "data"=>$abonnement
                ));
                return;
            }
            

            if(count($abonnement)==1){
                echo json_encode(array(
                    "status"=>TRUE,
                    "message"=> "Cet abonnement existe",
                    "data"=>$abonnement
                ));
            }else{
                echo json_encode(array(
                    "status"=>FALSE,
                    "message"=> "Cet abonnement n'existe pas",
                    "data"=>$abonnement
                ));
            }
        }
        private function enregistrerReservation(){
            $dataReservation = $this->get_all_data('post', ['reserv_date', 'reserv_abon_id', 'reserv_point_id', 'reserv_heure', 'reserv_allee']);
            $this->load->model('Reservation_m');
            try {
                $this->Reservation_m->save($dataReservation);
                return TRUE;
            } catch (Exception $e) {
                return FALSE;
            }
        }
        private function get_all_data($protocole_type, $propertiesList = []){
            // Retirage de donnees reserver pour cette methode 
            // et inscrit dans le _propertiesLists[$nom du methode], ou dans le second parametre
            $function_name = $this->uri->rsegments[2];
            if(count($propertiesList)==0){
                $propertiesList = (isset($this->_propertiesLists[$function_name]))?$this->_propertiesLists[$function_name]:[];
            }
            $protocole_type = strtolower($protocole_type);
            $dataNeeded = array();
            for ($i=0; $i < count($propertiesList); $i++) { 
                if($this->input->$protocole_type($propertiesList[$i]) != ''){
                    // transformation en nombre typee String en type int ou float
                    $value = json_decode($this->input->$protocole_type($propertiesList[$i]));
                    if($value != NULL){
                        $dataNeeded[$propertiesList[$i]]= $value;
                    }else{
                        $dataNeeded[$propertiesList[$i]] = $this->input->$protocole_type($propertiesList[$i]);
                    }
                }
            }
            return $dataNeeded;
        }

        public function getRamassageByItineraire(){
            $this->load->model('Ramassage_m');

            $itine_id = $this->input->get('itine_id');
            $data = $this->Ramassage_m->getByItineraire($itine_id);
            header('Content-type: application/json');
            echo json_encode(array(
                "status"=>TRUE,
                "message"=> "Liste des points de ramassages by itineraire",
                "data"=>$data
            ));
        }
        public function getItineraire(){
            $this->load->model('Itineraire_m');

            $itine_id = $this->input->get('itine_id');
            $data = $this->Itineraire_m->get($itine_id, TRUE);
            header('Content-type: application/json');
            echo json_encode(array(
                "status"=>TRUE,
                "message"=> "Itineraire",
                "data"=>$data
            ));
        }
    }