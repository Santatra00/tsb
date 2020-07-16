<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class HistoriqueModel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->_tracer = "tracer";

    }
	public function getHistorique($numeroTraceur)
        {
            //$this->db->order_by('proprietaire.n_contribuable','DESC');
            $sql = "select ".$this->_tracer.".*, \"Voiture\".* ,CAST(".$this->_tracer.".tracer_date AS DATE) as jour, CAST(".$this->_tracer.".tracer_date as TIME) as heur
				from ".$this->_tracer." inner join \"Voiture\"
				on (".$this->_tracer.".tracer_numero = \"Voiture\".voitu_tracer_numero)
				where  CAST(".$this->_tracer.".tracer_date AS DATE)  =  now()::Date and \"Voiture\".voitu_id = ".$numeroTraceur." order by voitu_id desc;";
        	$query =  $this->db->query($sql);
        	return $query->result();
        }

}