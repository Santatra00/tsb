<?php
    class Groupe_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "groups";
            $this->_pk = "id";
            $this->_link = array(
                'users_groups'=>array(
                    'columnLinked' => 'id',
                    'columnLink'   => 'user_id',
                    'typeJoin'         => 'INNER'
                )
            );
        }

    }