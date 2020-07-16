<?php
    class Voiture_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Voiture";
            $this->_pk = "voitu_id";
            $this->_link = array(
                'traceur'=>array(
                    'columnLinked' => 'voit_tracer_numero',
                    'columnLink'   => 'tracer_numero',
                    'typeJoin'         => 'INNER'
                )
            );
        }
        public function getByVoyage($voya_id, $itine_id){
            return $this->db->select('*')
                ->from($this->_table)
                ->join('Posseder', 'Posseder.poss_voitu_id = Voiture.voitu_id', 'INNER')
                ->where(array(
                    "poss_itine_id"=>$itine_id,
                    'poss_voya_id'=> $voya_id
                ))
                ->get()
                ->result();
        }
        public function getInVoyageNow($itine_id){
            // L'heure utiliser est l'heure de POSTGRES comme toujours
            // get voiture actuellement en voyage
            return $this->db->select('Posseder.*, Voiture.*')
                ->from($this->_table)
                ->join('Posseder', 'Posseder.poss_voitu_id = Voiture.voitu_id', 'INNER')
                ->join('Voyage', 'Voyage.voya_id = Posseder.poss_voya_id', 'INNER')
                ->where("NOW() BETWEEN (voya_date + voya_heure_depart::time) AND (voya_date + voya_heure_arrivee::time)")
                ->where(array(
                    "poss_itine_id"=>$itine_id
                ))
                ->get()->result();
        }
        public function getPositionByVoyage($voya_id){
            return $this->db->select('*')
                ->from($this->_table)
                ->join('Posseder', 'Posseder.poss_voitu_id = Voiture.voitu_id', 'INNER')
                ->join('traceur', 'traceur.tracer_numero = Voiture.voitu_tracer_numero', 'INNER')
                ->where('poss_voya_id', $voya_id)
                ->get()
                ->result();
        }
        public function getWithChauffeur($voitu_id = 0){
            $this->db->select('MAX(date) as dateDepuis, Chauffeur.*, "voitu_matricule", "voitu_marque","voitu_edition", "voitu_nbr_place", "voitu_photo", "voitu_tracer_numero", "cond_chauf_id"')
                ->from($this->_table)
                ->join('Conduire', 'Conduire.cond_voitu_id = Voiture.voitu_id', 'INNER')
                ->join('Chauffeur', 'Chauffeur.chauf_id = Conduire.cond_chauf_id', 'INNER');
            if($voitu_id != 0){
                $this->db->where('voitu_id', $voitu_id);
            }
            return $this->db->group_by('"voitu_id", "chauf_id", "voitu_matricule", "voitu_marque","voitu_edition", "voitu_nbr_place", "voitu_tracer_numero", "voitu_photo", "cond_chauf_id"')
                ->get()
                ->result();
        }

    }