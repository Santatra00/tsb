<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class ItineraireModel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function getItineraire()
        {
            //$this->db->order_by('proprietaire.n_contribuable','DESC');
            $this->db->select('*');
            $this->db->from('Itineraire');
            $query = $this->db->get();
                    return $query->result();
        }

    public function getItineRamassages()
        {
        $sql = 'select public."Itineraire".* , public."Ramassage".point_id, public."Ramassage".point_nom
        , count(public."Reservation".reserv_id) as nombre_reserv from
        public."Ramassage" left join public."Reservation" on(
        public."Ramassage".point_id  = public."Reservation".reserv_point_id
        ) , public."Itineraire"
        where (public."Itineraire".itine_id = public."Ramassage".point_itine_id)
        and ((public."Reservation".reserv_date = now()::date) or (public."Reservation".reserv_date is null))
        group by public."Ramassage".point_id, public."Itineraire".itine_id order by public."Itineraire".itine_id;';
        $query =  $this->db->query($sql);
        return $query->result();
        }
}