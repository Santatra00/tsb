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
            $this->db->select('voitu_id, voitu_matricule, chauf_adresse, chauf_nom, chauf_prenom, chauf_tel,cond_chauf_id');
            $this->db->from('Conduire');
            $this->db->join('Voiture','cond_voitu_id=voitu_id','left');
            $this->db->join('Chauffeur','cond_chauf_id=chauf_id','left');
            $this->db->order_by('voitu_id','desc');
            $query = $this->db->get();
                    return $query->result();
        }
}