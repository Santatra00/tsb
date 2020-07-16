<?php
    class Historique_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "login_attempts";
            $this->_pk = "id";
        }

    }