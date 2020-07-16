<?php
    class Itineraire_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Itineraire";
            $this->_pk = "itine_id";
            $this->_link = array(
                'Ramassage'=>array(
                    'columnLinked' => 'itine_id',
                    'columnLink'   => 'point_itine_id',
                    'typeJoin'         => 'LEFT'
                )
            );
        }
        
        public function getListWithNbItineraire(){
            $this->db->select('public."Itineraire".*, count(point_id) as nb_point')
                    ->from($this->_table);
            return $this->link('Ramassage')
                    ->group_by(['itine_id'])
                    ->get()
                    ->result();
        }

        public function getByVoyage($voya_id){
            $this->db->select('Itineraire.*')
                ->from($this->_table);
                if($voya_id != 0){
                    $this->db->join('Posseder', 'Posseder.poss_itine_id = Itineraire.itine_id', 'INNER')
                    ->where('poss_voya_id', $voya_id)
                    ->group_by(['Itineraire.itine_id']);
                }
                return $this->db->get()->result();
        }

    }