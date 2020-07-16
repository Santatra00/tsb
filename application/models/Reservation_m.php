<?php
    class Reservation_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "Reservation";
            $this->_pk = "reserv_id";
            $this->_link = array(
                'Abonnement'=>array(
                    'columnLinked' => 'reserv_abon_id',
                    'columnLink'   => 'abon_id',
                    'typeJoin'         => 'INNER'
                ),
                'Ramassage'=>array(
                    'columnLinked' => 'reserv_point_id',
                    'columnLink'   => 'point_id',
                    'typeJoin'         => 'INNER'
                )
            );
        }

        public function getListWithAbonAndRam($date){
            $this->db->select([
                    'Itineraire.itine_id',
                    'Itineraire.itine_nom as reserv_itine_nom',
                    'point_nom as reserv_point_nom',
                    'reserv_heure',
                    'count(abon_id) as reserv_etu_total',
                    'reserv_allee',
                ])
                ->from($this->_table);
            $this->link('Abonnement');
            $this->link('Ramassage');
            return $this->db
                ->where('reserv_date', $date)
                ->join('Itineraire', 'Ramassage.point_itine_id = Itineraire.itine_id', 'INNER')
                ->group_by("itine_nom, point_nom, reserv_date, reserv_heure, abon_id, reserv_allee, itine_id")
                ->get()->result();
        }
        public function getNbVoitureCochee($voya_date, $voya_heure_arrivee, $itine_id, $allee){
            return $this->db->select([
                    'count(voitu_id) as nbVoitureCochee'
                ])
                ->from('Posseder')
                ->join('Voyage', 'Voyage.voya_id = Posseder.poss_voya_id', 'INNER')
                ->where(array(
                    'voya_date'=>$voya_date, 
                    'voya_heure_arrivee'=>$voya_heure_arrivee,
                    'poss_itine_id'=>$itine_id,
                    'voya_allee'=>$allee
                ))
                ->group_by("poss_voitu_id")
                ->get()->result();
        }
        public function getNbReservationCochee($voya_date, $voya_heure_arrivee, $itine_id, $allee){
            return $this->db->select([
                    'count(reserv_id) as nbReservationCochee'
                ])
                ->from('Reservation')
                ->join('Ramassage', 'Ramassage.point_id = Reservation.reserv_point_id', 'INNER')
                ->where(array(
                    'reserv_date'=>$voya_date, 
                    'reserv_heure'=>$voya_heure_arrivee,
                    'point_itine_id'=>$itine_id,
                    'reserv_allee'=>$allee,
                    'reserv_voya_id IS NOT NULL'=>NULL
                ))
                ->group_by("reserv_id")
                ->get()->result();
        }
        public function getAnnees(){
            return $this->db->select("TO_CHAR(reserv_date, 'yyyy') as annee")->from('Reservation')
                ->group_by('annee')    
                ->get()->result();
        }
        public function getMois(){
            return $this->db->select("TO_CHAR(reserv_date, 'mm/yyyy') as mois")->from('Reservation')
                ->group_by('mois')    
                ->get()->result();
        } 
        public function getStatOnAnnee(){
            return $this->db->select("TO_CHAR(reserv_date, 'yyyy') as annee, count(reserv_id) as nombre, itine_nom as itineraire")->from('Reservation')
                ->join('Ramassage', 'Ramassage.point_id = Reservation.reserv_point_id', 'INNER')
                ->join('Itineraire', 'Itineraire.itine_id = Ramassage.point_itine_id', 'INNER')
                ->group_by('annee, itine_id')    
                ->get()->result();
        }
        public function getStatByAnnee($annee){
            return $this->db->select("TO_CHAR(reserv_date, 'mm/yyyy') as mois, count(reserv_id) as nombre, itine_nom as itineraire")->from('Reservation')
                ->join('Ramassage', 'Ramassage.point_id = Reservation.reserv_point_id', 'INNER')
                ->join('Itineraire', 'Itineraire.itine_id = Ramassage.point_itine_id', 'INNER')
                ->where("TO_CHAR(reserv_date, 'yyyy')='".$annee."'", NULL)
                ->group_by('mois, itine_id')    
                ->get()->result();
        }
        public function getStatByMois($mois){
            return $this->db->select("TO_CHAR(reserv_date, 'dd') as jour, count(reserv_id) as nombre, itine_nom as itineraire")->from('Reservation')
                ->join('Ramassage', 'Ramassage.point_id = Reservation.reserv_point_id', 'INNER')
                ->join('Itineraire', 'Itineraire.itine_id = Ramassage.point_itine_id', 'INNER')
                ->where("TO_CHAR(reserv_date, 'mm/yyyy')='".$mois."'", NULL)
                ->group_by('jour, itine_id')    
                ->get()->result();
        }
        public function getLastAnnee(){
            return  $this->db->select("TO_CHAR(reserv_date, 'yyyy') as lastAnnee, MAX(reserv_id)")->from('Reservation')
                ->group_by('reserv_id')
                ->get()->result();
        }
        public function getLastMois(){
            return $this->db->select("TO_CHAR(reserv_date, 'mm/yyyy') as lastMois, MAX(reserv_id)")->from('Reservation')
                ->group_by('reserv_id')
                ->get()->result();
        }
        public function getByCondition($condition){
            $this->db->select([
                    "Etudiant.etu_nom",
                    "Etudiant.etu_prenom",
                    "Reservation.reserv_date_creation",
                    "Reservation.reserv_etat"
                ])
                ->from($this->_table);
            $this->link('Abonnement');
            $this->link('Ramassage');
            return $this->db
                ->where($condition)
                ->join('Itineraire', 'Ramassage.point_itine_id = Itineraire.itine_id', 'INNER')
                ->join('Etudiant', 'Etudiant.etu_id = Abonnement.abon_etu_id', 'INNER')
                ->group_by(["Etudiant.etu_nom",
                    "Etudiant.etu_prenom",
                    "Reservation.reserv_heure",
                    "Reservation.reserv_date_creation",
                    "Reservation.reserv_etat"])
                ->get()->result();
        }
        public function getNombreByDateAndItineraire($condition){
            return $this->db->select([
                    "Reservation.reserv_heure",
                    "count(reserv_heure) as reserv_nombre"
                ])
                ->from($this->_table)
                ->where($condition)
                ->join('Ramassage', 'Ramassage.point_id = Reservation.reserv_point_id', 'INNER')
                ->group_by("reserv_heure")
                ->get()->result();

        }
    }