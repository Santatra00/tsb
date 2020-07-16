<?php
    class Login extends MY_Controller{
        public $message="";

        function __construct(){
            parent::__construct();
            $this->load->library("ion_auth");
            $this->message = $this->session->flashdata("message");
        }

        public function index(){

            // $this->_data['contenu'] = 'login/login';
            $data["message"]=$this->message;
            $this->load->view("login/login", $data);
            // $this->charger_page();
        }
        public function login(){
		// $this->data['title'] = $this->lang->line('login_heading');

		// this->session->userdata('item');
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/Carte', 'refresh');
			}else{
				echo "echec";
				// if the login was un-successful
                // redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
		}
		
        public function logout(){
            $this->data['title'] = "Logout";

            // log the user out
            $logout = $this->ion_auth->logout();

            // redirect them to the login page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect('/login', 'refresh');
		}
		

        private function isAuthorised($controller, $methode){
            return $this->Ion_auth_model->isAuthorised($controller, $methode, $this->ion_auth->get_user_id());
        }
        // private function getUser(){
        //     $this->load->model("Ion_auth_model");
        //     return $this->Ion_auth_model->getInfoUser($this->ion_auth->get_user_id()) ;
        // }

    public function forbidden(){
		//selecter le user
		$this->load->model("compte_m");
		$ident= $this->input->post('identity');
		$thisUser=$this->compte_m->getUserByName($ident);
		$thisUser=$thisUser[0];

		$code=$this->ion_auth_model->forgotten_password($ident);

		if($this->envoieMail($thisUser,$code)){
			$this->load->view("login/email_envoyer");
		}else{
			$this->load->view("login/compte_empty");
		}
	}

	public function recuperer_compte($selector=null){
		if($selector==null){
			return "";
		}
		$this->load->view("login/newpassword",array("message"=>$this->message, "selector"=>$selector));
	}

	public function autoriser_modification_mot_pass(){
		$password= $this->input->post('password');
		$selector= $this->input->post('selector');

		//modifier user
		$this->load->model("compte_m");
		$password=$this->ion_auth->hash_password($password);
		$this->compte_m->newPassword($password, $selector);
		
		//rediriger vers loginPage
		$this->session->set_flashdata("message", "Veuillez vous connecter avec votre nouveau mot de pass");

	}

	private function envoieMail($thisUser, $selector){
		$this->load->library('email');
		$config=$this->config->item('configuration', 'ion_auth');

		$this->email->initialize($config);

		$this->email->from("santatra00@gmail.com", "Test ITDC");

		$this->email->to($thisUser->pers_mail);

		$this->email->subject("Recuperation de Mot de pass - BNGRC");
		$this->email->message("Bonjour, Votre mot de pass va etre modifier. Pour cela veuillez suivre ce lien <a href=".base_url('login/recuperer_compte/'.$selector).">BNGRC</a>");
		if($this->email->send()){
			return TRUE;
		}else{
			return FALSE;
		}
	}

		
	

    }