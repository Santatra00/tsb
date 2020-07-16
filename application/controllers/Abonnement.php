<?php
    class Abonnement extends MY_Controller{

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
            $this->_data['contenu'] = "Abonnement/page";
            $model_name = $this->load_my_model();
            $this->_data['data']['titre']="Abonnement";

            // $this->_data['listAbonnement'] = $this->$model_name->getListWithEtudiant();
            $this->_data['listAbonnement'] = $this->$model_name->getAbonWithEtudiant();
            $this->charger_page();
        }
        
        public function ajouter(){
            $this->_data['contenu'] = "Abonnement/page";
            $model_name = $this->load_my_model();

            if($this->input->post('id') == ''){
                $data = $this->get_all_data('post', ['abon_date', 'date_validite', 'nombre_ticket', 'abon_etu_id']);
                $data['abon_uti_id'] = $this->session->userdata('user_id');
                $this->$model_name->save($data);
            }else{
                $data = $this->get_all_data('post', ['abon_date', 'date_validite', 'nombre_ticket', 'abon_etu_id']);
                $data['abon_uti_id'] = $this->session->userdata('user_id');
                $this->$model_name->save($data, $this->input->post('id'));
            }
            $this->send_response('Abonnement ajoutee');
        }
        public function getAbonnement(){
            $model_name = $this->load_my_model();
            $this->load->model('Etudiant_m');


            $idData = $this->get_all_data('get', ['id']);
            $tickets = [];
            $etudiant = $this->Etudiant_m->get($idData['id'], TRUE);
            $ticketsData = $this->$model_name->getListAvalaibleTickets($idData['id']);
            $tickets = [];
            for ($i=0; $i < count($ticketsData); $i++) { 
                $ticket = $ticketsData[$i];
                if(intval($ticket->nombre_ticket) > 0){
                    array_push($tickets, array(
                        'abon_date'=>$ticket->abon_date, 
                        'date_validite'=>$ticket->date_validite, 
                        'nombre_ticket'=>$ticket->nombre_ticket, 
                        'abon_id'=>$ticket->abon_id,
                        'abon_uti_nom'=>$ticket->uti_nom.' '.$ticket->uti_prenom
                    ));
                }
            }
            $data = array(
                "abon_etu_nom"=>$etudiant->etu_nom.' '.$etudiant->etu_prenom,
                "abon_etu_id"=>$etudiant->etu_id,
                "tickets"=>$tickets
            );
            $this->send_response($data);
        }

    } 