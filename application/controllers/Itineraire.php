<?php
    class Itineraire extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->load->library(array('ion_auth'));
            $this->_data['name_controller'] = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            $this->_propertiesLists['save'] =  ['itine_nom', 'itine_description', 'coordonnees'];
            $this->_propertiesLists['update'] =  $this->_propertiesLists['save'];
            // $this->verify_me();
        }

        public function index(){
            $this->_data['contenu'] = "Itineraire/page";
            $model_name = $this->load_my_model();
            $this->load->model("traceur_m");

            $this->_data['listItineraire'] = $this->$model_name->getListWithNbItineraire();
            
            $this->charger_page();
            $this->verify_me();

        }

        public function getItineraireByVoyage(){           
            $model_name = $this->load_my_model();

            $voya_id = $this->input->get('voya_id');
            $this->_data['data'] = $this->$model_name->getByVoyage($voya_id);
            $this->charger_page();
        }
    }