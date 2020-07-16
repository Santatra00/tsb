<?php
    class Voyage_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Voyage";
            $this->_pk = "voya_id";
            // $this->_link = array(
            //     'Traceur'=>array(
            //         'columnLinked' => 'voit_tracer_numero',
            //         'columnLink'   => 'tracer_numero',
            //         'typeJoin'         => 'INNER'
            //     )
            // );
        }
        public function getByDate($voya_date){
            // format date MM/JJ/AAAA
            return $this->db->select('*')->from($this->_table)->where('voya_date', $voya_date)->get()->result();
        }
        public function getByDateAndHeur($date){
            // format date MM/JJ/AAAA
            return $this->db->select('*')->from($this->_table)
                    ->where($date)->get()->result();
        }
        

    }