<?php
    class Ramassage_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Ramassage";
            $this->_pk = "point_id";
            $this->_link = array(
                'Itineraire'=>array(
                    'columnLinked' => 'point_itine_id',
                    'columnLink'   => 'itine_id',
                    'typeJoin'         => 'INNER'
                )
            );
        }
        public function getListeWithItineraire(){
            $this->db->select('*, Itineraire.itine_nom as point_itine_nom')
                    ->from($this->_table);
            return $this->link('Itineraire')
                    ->get()
                    ->result();
        }
        public function getByItineraire($itine_id){
            $this->db->select('*, itine_nom as point_itine_nom')
                    ->from($this->_table)
                    ->where('itine_id', $itine_id);
            return $this->link('Itineraire')
                    ->get()
                    ->result();
        }
        

        
    }