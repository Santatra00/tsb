<?php
    class Voiture extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->load->library(array('ion_auth'));
            $this->_data['name_controller'] = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            $this->_propertiesLists['save'] =  ['voitu_matricule', 'voitu_marque', 'voitu_edition', 'voitu_nbr_place', 'voitu_tracer_numero', 'voitu_photo'];
            $this->_propertiesLists['update'] =  $this->_propertiesLists['save'];
            
            $this->verify_me();
        }

        public function index(){
            $this->_data['contenu'] = "Voiture/page";
            $model_name = $this->load_my_model();
            $this->load->model(["traceur_m", "chauffeur_m"]);

            $this->_data['listVoiture'] = $this->$model_name->get();
            $this->_data['listVoiture'] = $this->chauffeur_m->get();
            $this->_data['listTraceur'] = $this->traceur_m->getAllNumero();
            
            $this->charger_page();
        }
        public function save(){
            $model_name = $this->load_my_model();
            $this->load->model(["traceur_m", "chauffeur_m"]);
            
            $this->charger_page();
        } 

        public function getByVoyage(){
            $model_name = $this->load_my_model();

            $voya_id = $this->input->get('voya_id');
            $itine_id = $this->input->get('itine_id');

            if($voya_id != 0){
                $this->_data['data'] = $this->$model_name->getByVoyage($voya_id, $itine_id);
            }else{
                // get all voiture in voyage now
                $this->_data['data'] = $this->$model_name->getInVoyageNow($itine_id);
            }
            $this->charger_page();
        }
        
        public function getPositionByVoyage(){
            $my_model = $this->load_my_model();

            $voya_id = $this->input->get('voya_id');
            $this->_data['data'] = $this->$my_model->getPositionByVoyage($voya_id);
            $this->charger_page();
        }
    }