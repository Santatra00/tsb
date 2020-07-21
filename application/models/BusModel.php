<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class BusModel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function getBus()
        {
            //$this->db->order_by('proprietaire.n_contribuable','DESC');
            $sql = "select voitu_id, voitu_matricule, chauf_adresse,chauf_prenom
from public.\"Conduire\" left join public.\"Voiture\" on (cond_voitu_id=voitu_id)
left join public.\"Chauffeur\"  on  (cond_chauf_id=chauf_id)
where date = now()::Date
order by voitu_id desc;";
            $query =  $this->db->query($sql);
            return $query->result();
        }

    public function getTraceurPosition(){
        $sqll = 'select count("Voiture".*)  from "Voiture"';
        $qu =  $this->db->query($sqll);
        $nombre = $qu->result()[0]->count;
        $sql = 'select tracer_x, tracer_y, tracer_date, voitu_id, voitu_matricule, chauf_id, chauf_nom, chauf_prenom
        from traceur, public."Voiture", public."Conduire", public."Chauffeur"
        where (tracer_numero = voitu_tracer_numero) and (voitu_id = cond_voitu_id)
        and (chauf_id = cond_chauf_id) order by voitu_id, tracer_date desc limit '.$nombre.';';
        $query =  $this->db->query($sql);
            return $query->result();
    }
}