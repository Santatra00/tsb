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
            $sql = "select  public.\"Voiture\".voitu_id, voitu_matricule, chauf_adresse, chauf_nom,chauf_prenom, chauf_tel,cond_chauf_id
from public.\"Conduire\" left join public.\"Voiture\" on (cond_voitu_id=voitu_id)
left join public.\"Chauffeur\"  on  (cond_chauf_id=chauf_id), 
(select  voitu_id, public.\"Conduire\".date as max
from public.\"Conduire\" left join public.\"Voiture\" on (cond_voitu_id=voitu_id)
left join public.\"Chauffeur\"  on  (cond_chauf_id=chauf_id)
where  public.\"Conduire\".date = (SELECT max(public.\"Conduire\".date) FROM public.\"Conduire\" where cond_voitu_id=voitu_id )
group by voitu_id, public.\"Conduire\".date
order by public.\"Conduire\".date desc)
as voiturechauf
where (voiturechauf.voitu_id  = public.\"Voiture\".voitu_id) and (date = voiturechauf.max) 
order by public.\"Voiture\".voitu_id desc;";
            $query =  $this->db->query($sql);
            return $query->result();
        }
}