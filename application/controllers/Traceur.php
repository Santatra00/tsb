<?php
    class Traceur extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->load->library(array('ion_auth'));
            $this->_name_controller = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            
            $this->verify_me();
        }

        public function index(){
            $this->_data['contenu'] = "Traceur/page";
            $this->_data['data'] = "haha";
            // $this->_data['scripts'] = array("js/groupe.js");
            $this->charger_page();
        }

    }