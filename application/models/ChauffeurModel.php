<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class ChauffeurModel extends CI_Model {
public function __construct()
    {
        parent::__construct();
    }
public function getChauffeur()
        {
            //$this->db->order_by('proprietaire.n_contribuable','DESC');
            $sql = "select voitu_id, voitu_matricule, chauf_adresse, chauf_nom, chauf_prenom, chauf_tel,cond_chauf_id
from public.\"Conduire\" left join public.\"Voiture\" on (cond_voitu_id=voitu_id)
left join public.\"Chauffeur\"  on  (cond_chauf_id=chauf_id)
where date = now()::Date
order by voitu_id desc;";
            $query =  $this->db->query($sql);
            return $query->result();
        }
}