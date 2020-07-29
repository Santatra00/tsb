<?php
    class Ramassage extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->load->library(array('ion_auth'));
            $this->_data['name_controller'] = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            $this->_propertiesLists['save'] =  ['point_nom', 'point_x', 'point_y', 'point_itine_id', 'point_bout_trajet'];
            $this->_propertiesLists['update'] =  $this->_propertiesLists['save'];
            
            $this->verify_me();
        }

        public function index(){
            $this->_data['contenu'] = "Ramassage/page";
            $model_name = $this->load_my_model();
            $this->load->model("itineraire_m");

            $this->_data['listRamassage'] = $this->$model_name->getListeWithItineraire();
            $this->_data['listItineraire'] = $this->itineraire_m->get();

            $this->charger_page();
        }

        public function getRamassageByItineraire(){           
            $model_name = $this->load_my_model();

            $itine_id = $this->input->get('itine_id');
            $this->_data['data'] = $this->$model_name->getByItineraire($itine_id);
            $this->charger_page();
        }
        
        
    }