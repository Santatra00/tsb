<?php
    class Etudiant_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Etudiant";
            $this->_pk = "etu_id";
        }

    }