<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    protected $_table = "";
    protected $_pk = "";
    protected $_filter = "intval";
    protected $_order = "";
    protected $_get_join  = [];
    protected $_link = [];
	
    public function __construct(){
        parent::__construct();
    }
	
    /*CRUD Générique*/
    public function where($where) {
        if(count($where)){
            $this->db->where($where);
        }
    }

    public function get($id = NULL, $single= false){
        if($single){
            $method = "row";
        } else { 
            $method = "result";
            if($this->_order != "")
            {
                $this->db->order_by($this->_order);
            }
        }
        $this->db->select("*");
        $this->db->from($this->_table);
        // foreach ($this->_get_join as $join) {
        //     $this->db->join($join['table'],$this->_table.'.'.$join['ref1'].'='.$join['table'].'.'.$join['ref2'],$join['type']);
        // }
        if($id != NULL) 
        {
            $filter = $this->_filter;
            $id = $filter($id);
            $this->db->where(array($this->_pk=>$id)); 
        }
        return $this->db->get()->$method();
    }
    
    
    public function save($data,$id = NULL)
    {
        $this->db->set($data);        
        if($id != NULL)
        {
            $filter = $this->_filter;
            $id = $filter($id);
            $this->db->update($this->_table, $data, array($this->_pk=>$id));
            return $id;
        } else {
            $this->db->insert($this->_table,$data);
            // return $this->db->insert_id();
        }   
    } 
    public function findRow($data){
        return $this->db->select("*")->from($this->_table)->where($data)->get()->row();
    }
    
    public function delete($id)
    {
        $filter = $this->_filter;
        $id = $filter($id);  
        $this->db->where(array($this->_pk=>$id));
        return $this->db->delete($this->_table);
    }
    
    public function clause($where,$single = false)
    {
        if($single){
            $method = "row";
        } else {
            $method = "result";
        }
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where($where); 
        return $this->db->get()->$method();
    }

    public function query($query,$single=false){
        $res = $this->db->query($query);
		if($single) return $res->row();
		else return $res->result();
    }

    public function link($linkedTable){
        if ($this->_link[$linkedTable] == ''){
            return $this->db;
        }else{
            $linkForTable = $this->_link[$linkedTable];
            return $this->db->join($linkedTable, $this->_table.'.'.$linkForTable['columnLinked'].'='.$linkedTable.'.'.$linkForTable['columnLink'], $linkForTable['typeJoin']);
        }
    }
    
}