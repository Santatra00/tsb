<?php
    class Compte extends MY_Controller{

        function __construct(){
            parent::__construct();
            $this->load->database();
            $this->load->library(array('ion_auth'));

            $this->_data['name_controller'] = $this->uri->rsegments[1];
            $this->set_client_type($this->input->get('me'));
            $this->_propertiesLists['save'] =  ['chauf_nom', 'chauf_prenom', 'chauf_tel', 'chauf_adresse'];
            $this->_propertiesLists['update'] =  $this->_propertiesLists['save'];
            
            $this->verify_me();
        }

        public function getListeCompte($id=NULL){
            $this->load->model('compte_m');
            $compte = $this->compte_m->getAll();
            // echo(json_encode($compte));
            return $compte;
        }

        public function index(){
            $this->_data['data']['titre']="Compte";

            $this->load->model(array('Groupe_m', 'Ion_auth_model'));
            $this->_data['listeNoUser'] = $this->Ion_auth_model->getNoUser();
            $this->_data['contenu'] = "Compte/page";
            $this->_data['scripts'] = array("js/compte.js");
            $model_name = $this->load_my_model();

            $this->_data['listeCompte'] = $this->$model_name->getAll();
            $this->_data['listeGroupe'] = $this->Groupe_m->get();
            $this->_data['urlSave'] = 'ajouterCompte';
            $this->_data['urlGet'] = 'getInfoUser';
            $this->charger_page();
        }

        public function ajouterCompte(){
            $this->load->model(['ion_auth_model', "compte_m"]);
            $info_compte = $this->input->post('compte');
            $compte=$this->input->post('compte');
            $groups=$compte["id_group"];
            unset($compte["id_group"]);
            $id=$this->input->post('id');
            if($id == ''){
                $identity = $this->input->post('username');
                $password = $this->input->post('password');

                $additional_data = [
                    'uti_nom' => $this->input->post('uti_nom'),
                    'uti_prenom' => $this->input->post('uti_prenom'),
                    'email' => $this->input->post('email'),
                    'uti_tel' => $this->input->post('uti_tel')
                ];
                $newId=($this->ion_auth_model->register($identity, $password, $additional_data, $groups));
                echo $newId;
            }else{
                $data = [
                    'username' => $this->input->post('username'),
                    'uti_nom' => $this->input->post('uti_nom'),
                    'uti_prenom' => $this->input->post('uti_prenom'),
                    'email' => $this->input->post('email'),
                    'uti_tel' => $this->input->post('uti_tel')
				];

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}
				
                echo json_encode($this->ion_auth_model->update($this->input->post('id'), $data));
                //effacer tous les données
                $this->compte_m->deleteUserGroup($this->input->post('id'));
                $this->compte_m->insertUserGroup($this->input->post('id'), $groups);
                //enregistrer données
            }
            //$id = $this->compte_m->save($info_compte,$id);
            // print_r($info_compte);
            // echo json_encode(array("id" => $id ));
        }

        public function listeCompte(){
            $this->load->view('Compte/listeCompte',array('listeCompte'=>$this->getListeCompte()));
        }

        public function detailCompte($id=null){
            if($id == null){
                $id = $this->input->get('id');
            }
            $this->load->model('compte_m');
            $this->load->model(array('Ion_auth_model'));

            $compte = ($this->Ion_auth_model->getInfoUserByPersonnel($id));
            $data=array(
                'compte' => $compte,
                'listeNoUser'=>$this->compte_m->getById($id),
                'listeGroupe'=>$this->Ion_auth_model->getNoGroup(),
                "listeGroupeSelected"=>$this->Ion_auth_model->getNoGroupSelected($id),
            );
            // print_r($data);
            $this->load->view('Compte/formulaireCompte', $data);
        }

        public function getInfoUser($id = null){
            if($id == null){
                $id = $this->input->get('id');
            }
            $compte_m = $this->load_my_model();
            $this->load->model('Ion_auth_model');


            $this->_data['data'] = Array($this->$compte_m->getById($id));
            $this->_data['data'] = (Array)$this->_data['data'][0][0];
            $groups = $this->Ion_auth_model->getNoGroupSelected($id);
            $this->_data['data']['id_group'] = [];
            for ($i=0; $i < count($groups); $i++) { 
                array_push($this->_data['data']['id_group'], intval($groups[$i]->id));
            }
            $this->charger_page();
        }

        public function etest($id){
            $this->load->model(array('Ion_auth_model'));

            print_r($this->Ion_auth_model->getNoGroupSelected($id));
        }

        public function nouveauCompte(){
            $this->load->model(array('Ion_auth_model'));

            $this->load->view('Compte/formulaireCompte', array(
                'compte' => null,
                'listeNoUser'=>$this->Ion_auth_model->getNoUser(),
                'listeGroupe'=>$this->Ion_auth_model->getNoGroup(),
            ));
        }

        public function isExistUsername($username){
            $this->load->model('compte_m');
            echo json_encode(array(
                "result"=> empty($this->compte_m->isUsernameExiste($username))?"false":"true")
            );
        }

    }