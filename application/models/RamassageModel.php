<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class RamassageModel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function getRamassage()
        {
            //$this->db->order_by('proprietaire.n_contribuable','DESC');
            $this->db->select('*');
            $this->db->from('Ramassage');
            $query = $this->db->get();
                    return $query->result();
        }
}