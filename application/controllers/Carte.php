<?php
    class Carte extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->load->library(array('ion_auth'));
            $this->_data['name_controller'] = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            $this->_propertiesLists['save'] =  ['chauf_nom', 'chauf_prenom', 'chauf_tel', 'chauf_adresse'];
            $this->_propertiesLists['update'] =  $this->_propertiesLists['save'];

            $this->verify_me();
        }

        public function index(){
            $this->_data['contenu'] = "Carte/page";

            $this->_data['scripts'][] = "lib/mapbox/mapbox-gl.js";
            $this->_data['scripts'][] = "lib/mapbox/leaflet-omnivore.min.js";
            $this->_data['scripts'][] = "lib/jszip.min.js";


            $this->_data['scripts'][] = "js/map.js"; 
 
            $this->_data['styles'][] = "lib/mapbox/mapbox-gl.css";

            $this->_data['titre'] = $this->load->view('Carte/titre', [], TRUE);

            $this->load->model('Ramassage_m');

            $this->_data['listPointRamassage'] = $this->Ramassage_m->get();
            $this->charger_page(TRUE);
        }
        public function getVoyageOnDate(){           
            $this->load->model('Voyage_m');

            $voya_date = $this->input->get('voya_date');
            $this->_data['data'] = $this->Voyage_m->getByDate($voya_date);
            $this->charger_page();
        }
        public function getMarkerOfVoiture($voitu_id = 0){
            $this->load->model('Traceur_m');

            if($voitu_id == 0){
                $v = $this->get_all_data('get', ['voitu_id']);
                if(isset($v['voitu_id'])){
                    $voitu_id = $v['voitu_id'];
                }
            }            
            $heures = $this->get_all_data('get', ['heure_depart', 'heure_arrive', 'day']);

            $this->_data['data'] = [];

            if($voitu_id == 0){
                $this->load->model('Voiture_m');
                $listVoiture = $this->Voiture_m->get();
                
                for ($i=0; $i < count($listVoiture); $i++) { 
                    // print_r($listVoiture[$i]);
                    array_push($this->_data['data'], $this->Traceur_m->getPositionDuring($heures, $listVoiture[$i]->voitu_id));
                }
            }else{
                array_push($this->_data['data'], $this->Traceur_m->getPositionDuring($heures, $voitu_id));
            }
            $this->charger_page();
        }
        public function test(){
            print_r(date('H:i',time() - 3600));
        }
        
    }
