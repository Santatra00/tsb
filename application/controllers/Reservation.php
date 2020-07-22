<?php
    class Reservation extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->load->library(array('ion_auth'));
            $this->_data['name_controller'] = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            $this->_propertiesLists['save'] =  ['reserv_date', 'reserv_abon_id', 'reserv_point_id'];
            $this->_propertiesLists['update'] =  $this->_propertiesLists['save'];
            
            $this->verify_me();
        }

        public function index(){
            $this->_data['contenu'] = "Reservation/page";
            $this->_data['titre']=$this->load->view('Reservation/titre', [], TRUE);

            $model_name = $this->load_my_model();
            $this->load->model("voiture_m");


            $this->_data['date'] = $this->input->get('date'); 
            if($this->_data['date']==''){
                $this->_data['date'] = date('d/m/Y');
                // si la datestyle est comme m/d/Y decommenter la ligne ci-dessus
                // $this->_data['date'] = date('m/d/Y');
            }   
            $this->_data['listReservation'] = $this->$model_name->getListWithAbonAndRam($this->_data['date']);
            $this->_data['listVoiture'] = $this->voiture_m->get();

            // print_r($this->_data);
            $this->charger_page();
        }
        public function getReservation(){
            $model_name = $this->load_my_model();
            $this->load->model('Itineraire_m');


            $idData = $this->get_all_data('get', ['id']);
            $dateData = $this->get_all_data('get', ['date']);

            $tickets = [];
            $itineraire = $this->Itineraire_m->get($idData['id'], TRUE);
            $ticketsData = $this->$model_name->getByDate();
            $tickets = [];

            $data = array(
                "itine_nom"=>$itineraire->itine_nom,
            );

            // Heure d'arrivee et de depart
            // nombre de reservation with heure_arrive pour chaque heure by date(onChange(this){change nombre de passager restant et donnees select})

            $this->send_response($data);
        }
        public function assignerVoiture(){
            $model_name = $this->load_my_model();
            $this->load->model(['Itineraire_m', 'Voyage_m', 'Posseder_m']);

            $dataVoyage = $this->get_all_data('post', ['voya_date', 'voya_heure_depart', 'voya_heure_arrivee', 'voya_allee']);
            
            // voire si il y a deja un voyage comportant les specifications suivant heure debut, heure fin, allee, date
            $voyages = $this->Voyage_m->getByDateAndHeur($dataVoyage);
            switch (count($voyages)) {
                case 0:
                    # Le voyage n'existe pas encore
                    // on creer d'abord le voyage
                    $voya_id = $this->Voyage_m->save($dataVoyage);
                    break;
                case 1:
                    $voya_id = $voyages[0]->voya_id;
                    break;
                default:
                    // Il y a une erreur ie il existe une doublon 
                    $voya_id = 0;
                    break;
            }

            // si non cree le voyage de atsofoka anaty posseder ny id (en fonction du voiture choisi)
            $dataPosseder = $this->get_all_data('post', ['poss_voitu_id', 'poss_itine_id']);
            $dataPosseder['poss_voya_id'] = $voya_id;
            $this->Posseder_m->save($dataPosseder);

            // Relier le voyage et la reservation et changer l'etat de la reservation a etat:ACCEPTER
            // Remarque : 
            // 1. Ny voiture handehanan'ny mpianatra tsy fantatra
            // 2. Fantatra ny ordre de priorite ny fidiran'ny mpianatra ao
            // 3. Fantatra koa ny allee


            $dataReservation = $this->get_all_data('post', ['reservation']);
            $this->send_response("Success");
        }
        public function getReservationByDateHeureAllee(){
            $model_name = $this->load_my_model();

            $condition = $this->get_all_data('get', ['reserv_date', 'reserv_heure', 'reserv_allee', "itine_id"]);

            $data = $this->$model_name->getByCondition($condition);
            $this->send_response($data);
        }
        public function getNombreByDateAndItineraire(){
            $model_name = $this->load_my_model();

            $condition = $this->get_all_data('get', ['reserv_date', "point_itine_id"]);

            $data = $this->$model_name->getNombreByDateAndItineraire($condition);
            $this->send_response($data);
        }
    }