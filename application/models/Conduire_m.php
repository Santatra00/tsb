<?php
    class Conduire_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Conduire";
            $this->_pk = "cond_voitu_id";
        }

    }