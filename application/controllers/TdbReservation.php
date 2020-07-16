<?php
    class TdbReservation extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->load->library(array('ion_auth'));
            $this->_data['name_controller'] = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            $this->_blocked = array(['save', 'update', 'delete', 'lister']);
            
            $this->verify_me();
        }

        public function index(){
            $this->_data['contenu'] = "TdbReservation/page";
            $this->load->model(["reservation_m", "Itineraire_m"]);
            $this->_data['scripts'][] = "lib/Chart.min.js";


            $this->_data['listAnnee'] = $this->reservation_m->getAnnees();
            $this->_data['listMois'] = $this->reservation_m->getMois();
            $this->_data['listItineraire'] = $this->Itineraire_m->get();
            $this->_data['lastAnnee'] = $this->reservation_m->getLastAnnee()[0];
            $this->_data['lastMois'] = $this->reservation_m->getLastMois()[0];

            $this->_data['titre'] = $this->load->view('TdbReservation/titre',$this->_data, TRUE);

            // $this->_data['listTraceur'] = $this->traceur_m->getAllNumero();
            $this->charger_page();
        }
        public function getStatByAnnee(){
            $this->load->model('Reservation_m');


            $annee = $this->get_all_data('get', ['annee']);

            $this->_data['data'] = $this->Reservation_m->getStatByAnnee($annee['annee']);
            $this->charger_page();
        }
        public function getStatByMois(){
            $this->load->model('Reservation_m');


            $data = $this->get_all_data('get', ['mois']);

            $this->_data['data'] = $this->Reservation_m->getStatByMois($data['mois']);
            $this->charger_page();
        }
        public function getStatOnAnnee(){
            $this->load->model('Reservation_m');

            $this->_data['data'] = $this->Reservation_m->getStatOnAnnee();
            $this->charger_page();
        }
        

    }