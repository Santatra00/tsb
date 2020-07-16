<?php
    class Traceur_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "traceur";
            $this->_pk = "tracer_id";
        }

        public function getAllNumero(){
            return $this->db->select('tracer_numero')->from($this->_table)->group_by('tracer_numero')->get()->result();
        }
        public function getPositionDuring($date, $voitu_id=0){
            // get all position puring the date given
            $this->db->select($this->_table.'.*, voitu_id')
                ->from('Voiture')
                ->join($this->_table, $this->_table.'.tracer_numero = Voiture.voitu_tracer_numero', 'INNER')
                ->where(array('Voiture.voitu_id '=> $voitu_id));
            
            if((!isset($date['day']))||($date['day']=='')){
                $date['day'] = date('Y/m/d');
            }
            // Heure de depart par defaut est -1H avant l'heure actuel
            // utile pour le day selected = now sy live ny mode
            if(!isset($date['heure_depart'])){
                $this->config->load('config');
                $date['heure_depart'] = date('H:i',time() - $this->config->item('delaisTrace')*60*60);
            }
            
            if(!isset($date['heure_arrive'])){
                $this->db->where(array(
                    $this->_table.".tracer_date >= (date '".$date['day']."' +  time '".$date['heure_depart']."') "=> NULL
                ));
            }else{
                $this->db->where(array(
                    $this->_table.".tracer_date BETWEEN (date '".$date['day']."' + time '".$date['heure_depart']."') AND (date '".$date['day']."' + time '".$date['heure_arrive']."')" => NULL
                ));
            }
            
            return $this->db->order_by('tracer_date')->get()->result();
        }

    }