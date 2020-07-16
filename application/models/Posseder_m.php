<?php
    class Posseder_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Posseder";
            $this->_pk = "poss_voitu_id";
        }

    }