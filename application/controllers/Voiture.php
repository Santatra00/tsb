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
            $this->_data['listChauffeur'] = $this->chauffeur_m->get();
            $this->_data['listTraceur'] = $this->traceur_m->getAllNumero();
            
            $this->charger_page();
        }
        public function ajouter(){
            $my_model = $this->load_my_model();
            $this->load->model("Conduire_m");

            // Enregistrer voiture
            $dataVoiture = $this->get_all_data('post', $this->_propertiesLists['save']);
            $idData = $this->get_all_data('post', ['id']);
            $id = NULL;
            if(isset($idData['id'])){
                $id=$idData['id'];
            }
            $id = $this->$my_model->save($dataVoiture, $id);

            // Enregistrer Chauffeur qui a conduit
            $this->Conduire_m->save(array(
                "cond_chauf_id"=>  $this->get_all_data('post', ['cond_chauf_id'])['cond_chauf_id'],
                "cond_voitu_id"=> $id
            ));
            $this->charger_page();
        } 

        public function getByVoyage(){
            $model_name = $this->load_my_model();

            $voya_id = $this->input->get('voya_id');
            $itine_id = $this->input->get('itine_id');

            if($voya_id != 0){
                $this->_data['data'] = $this->$model_name->getByVoyage($voya_id, $itine_id);
            }else if($itine_id != 0){
                // get all voiture in voyage now
                $this->_data['data'] = $this->$model_name->getInVoyageNow($itine_id);
            }else{
                // get all voiture
                $this->_data['data'] = $this->$model_name->get();
            }
            $this->charger_page();
        }
        
        public function getPositionByVoyage(){
            $my_model = $this->load_my_model();

            $voya_id = $this->input->get('voya_id');
            $this->_data['data'] = $this->$my_model->getPositionByVoyage($voya_id);
            $this->charger_page();
        }
        public function getVoiture(){
            $my_model = $this->load_my_model();

            $voitu_id = $this->input->get('id', TRUE);
            $this->_data['data'] = $this->$my_model->getWithChauffeur($voitu_id)[0];
            $this->charger_page();
        }
    }