<?php
    class TdbVoiture extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->load->library(array('ion_auth'));
            $this->_data['name_controller'] = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            $this->_blocked = array(['save', 'update', 'delete', 'lister']);
            
            $this->verify_me();
        }

        public function index(){
            $this->_data['contenu'] = "TdbVoiture/page";
            $this->load->model("voiture_m");
            $this->_data['styles'][] = "css/TdbVoiture.css";

            $this->_data['titre'] = "Tableau de bord Voiture&Chauffeur";

            $this->_data['listVoiture'] = $this->voiture_m->getWithChauffeur();
            $this->charger_page();
        }

    }