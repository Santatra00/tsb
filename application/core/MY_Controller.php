<?php
    class MY_Controller extends CI_Controller{
        protected $_data = array('name_controller'=>'', 'titre'=>'');
        protected $_client = 'web';
        protected $_blocked = array();
        protected $_model_name = '';
        protected $propertiesList =  array(
            'update'=>['solution']
        );
        function _construct(){
            parent::__construct();
            // $this->load->database();
            // $this->load->library(array('ion_auth', 'form_validation', 'session'));	
        }

        public function charger_page($fullsize = FALSE){
            if($this->_data['titre'] == ''){
                $this->_data['titre'] = $this->_data['name_controller'];
            }
            switch ($this->_client) {
                case 'web':
                    $this->load->view('_com/layout', $this->_data);
                    break;
                case 'ws':
                    $this->send_response($this->_data['data']);
                    break;
                case 'page':
                    $this->_data['isPage'] = TRUE;
                    $page = $this->load->view($this->_data['contenu'], $this->_data, TRUE);
                    
                    header('Content-type: application/json');
                    echo json_encode(array(
                        'page'=>$page,
                        'title'=> $this->_data['titre'],
                        'fullsize'=> $fullsize
                    ));
                    // $this->send_response('hello');
                    break;
                default:
                    $this->load->view('security');
                    break;
            }
        }
        
        public function verify_me(){
            $this->load->library(array('ion_auth', 'form_validation', 'session'));	

            if(!$this->ion_auth->logged_in()){
                redirect("/login", "refresh");
            }
        }
        public function set_client_type($me = ''){
            switch ($me) {
                case 'ws':
                    $this->_client = 'ws';
                    break;
                case 'page':
                    // si rien n'est donnees c'est un web
                    $this->_client = 'page';
                    break;
                default:
                    // si rien n'est donnees c'est un web
                    $this->_client = 'web';
                    break;
            }
        }

        private function is_blocked(){
            // Verifier si l'argument n'est pas parmis les bloquers le regardant 
            // si son nom n'apparait dans le _blocked
            $function_name = $this->uri->rsegments[2];
            $isBlocked = FALSE;
            for ($i=0; $i < count($this->_blocked); $i++) { 
                if($this->_blocked[$i] == $function_name){
                    return TRUE;
                }
            }
            return $isBlocked;
        }

        protected function get_all_data($protocole_type, $propertiesList = []){
            // Retirage de donnees reserver pour cette methode 
            // et inscrit dans le _propertiesLists[$nom du methode], ou dans le second parametre
            $function_name = $this->uri->rsegments[2];
            if(count($propertiesList)==0){
                $propertiesList = (isset($this->_propertiesLists[$function_name]))?$this->_propertiesLists[$function_name]:[];
            }
            $protocole_type = strtolower($protocole_type);
            $dataNeeded = array();
            for ($i=0; $i < count($propertiesList); $i++) { 
                if($this->input->$protocole_type($propertiesList[$i]) != ''){
                    // transformation en nombre typee String en type int ou float
                    $value = json_decode($this->input->$protocole_type($propertiesList[$i]));
                    if($value != NULL){
                        $dataNeeded[$propertiesList[$i]]= $value;
                    }else{
                        $dataNeeded[$propertiesList[$i]] = $this->input->$protocole_type($propertiesList[$i]);
                    }
                }
            }
            return $dataNeeded;
        }

        public function save(){
            if(!$this->is_blocked()){
                $model_name = $this->load_my_model();
                $data = $this->get_all_data('post');
                $this->$model_name->save($data);
                $this->send_response($this->_data['name_controller'].' enregistrer');
            }else{
                $this->send_response('Service non authorisee', 'Acces refusee');
            }
        }

        public function update(){
            if(!$this->is_blocked()){
                $model_name = $this->load_my_model();
                $data = $this->get_all_data('post');
                $idData = $this->get_all_data('post', ['id']);
                $this->$model_name->save($data, $idData['id']);
                $this->send_response($this->_data['name_controller'].' mis a jour');
            }else{
                $this->send_response('Service non authorisee', 'Acces refusee');
            }
        }

        public function delete(){
            if(!$this->is_blocked()){
                $model_name = $this->load_my_model();
                $data = $this->get_all_data('post', ['id']);
                $this->$model_name->delete($data['id']);
                $this->send_response($data);
            }else{
                $this->send_response('Service non authorisee', 'Acces refusee');
            }
        }

        public function lister(){
            if(!$this->is_blocked()){
                $model_name = $this->load_my_model();

                $idData = $this->get_all_data('get', ['id']);
                $data = [];
                if ($idData['id'] != ''){
                    $data = $this->$model_name->get($idData['id'], TRUE);
                }else{
                    $data = $this->$model_name->get();
                }
                $this->send_response($data);
            }else{
                $this->send_response('Service non authorisee', 'Acces refusee');
            }
        }

        public function load_my_model(){
            if($this->_model_name == ''){
                $this->_model_name = $this->_data['name_controller'] . '_m';
            }
            $model_name = $this->_model_name;
            $this->load->model($model_name);
            return $model_name;
        }
        
        protected function send_response($msg, $status = 'Reussi'){
            header('Content-type: application/json');
            echo json_encode(array(
                'msg'=>$msg,
                'status'=> $status
            ));
        }
        
    }