<?php
    class Groupe extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->_data['name_controller'] = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            $this->_propertiesLists['save'] =  ['name', 'description'];
            $this->_propertiesLists['update'] =  $this->_propertiesLists['save'];
        
            $this->verify_me();
        }

        public function index(){
            $this->_data['contenu'] = "Groupe/page";
            $model_name = $this->load_my_model();

            $this->_data['listGroupe'] = $this->$model_name->get();
            $this->charger_page();
        }

    }