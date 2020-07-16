<?php
    class Historique extends MY_Controller{

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
            $this->_data['contenu'] = "Historique/page";
            $model_name = $this->load_my_model();

            $this->_data['listConnexion'] = $this->$model_name->get();
            $this->charger_page();
        }

    } 