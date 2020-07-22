<?php
    class Abonnement_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Abonnement";
            $this->_pk = "abon_id";
            $this->_link = array(
                'Etudiant'=>array(
                    'columnLinked' => 'abon_etu_id',
                    'columnLink'   => 'etu_id',
                    'typeJoin'         => 'INNER'
                )
            );
        }

        public function getAbonWithEtudiant(){
            $this->db->select('Etudiant.etu_id, Etudiant.etu_nom as abon_etu_nom, Etudiant.etu_prenom as abon_etu_prenom, get_avalaible_credit(etu_id) as somme_ticket, get_close_abon_date(etu_id) as abon_min_date')
            ->from($this->_table);
            return $this->link('Etudiant')
                    ->group_by('Etudiant.etu_id, abon_etu_nom, abon_etu_prenom, somme_ticket, abon_min_date')
                    ->get()
                    ->result();
        }

        public function getListAvalaibleTickets($etu_id){
            return $this->db->select('*, uti_nom, uti_prenom')
                ->from($this->_table)
                ->where('abon_etu_id', $etu_id)
                ->join('users', 'users.id = '.$this->_table.'.abon_uti_id', 'INNER')
                ->get()
                ->result();
        }
        public function getByPseudoEtudiant($pseudo){
            $this->db->select('abon_id, date_validite, nombre_ticket, abon_etu_id')
                ->from($this->_table);
            return $this->link('Etudiant')
                    ->where(array(
                        'nombre_ticket > 0'=>NULL,
                        'date_validite >= (SELECT CURRENT_DATE)'=>NULL,
                        'Etudiant.pseudo'=>$pseudo
                    ))
                    ->limit(1)
                    ->order_by('date_validite asc')
                    ->get()
                    ->result();
        }
    }