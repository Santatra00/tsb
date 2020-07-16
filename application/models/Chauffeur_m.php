<?php
    class Chauffeur_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Chauffeur";
            $this->_pk = "chauf_id";
            $this->_link = array(
                'Conduire'=>array(
                    'columnLinked' => 'chauf_id',
                    'columnLink'   => 'cond_chauf_id',
                    'typeJoin'         => 'INNER'
                )
            );
        }

    }