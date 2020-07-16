<?php
    class Compte_m extends MY_model{

        function __construct(){
            parent::__construct();
            $this->_table = "users";
            $this->_pk = "id";
            // $this->_get_join[] = array(
            //     'table' => 'personnel',
            //     'ref1' => 'chef_mission',
            //     'ref2' => 'id',
            //     'type' => 'INNER JOIN'
            // );
        }
        public function getAll(){
            return $this->db->select("*")
                    ->get($this->_table)->result();
       }
       public function getById($id){
        return $this->db->select(["uti_nom","uti_prenom", "uti_tel", "username", "email"])
                ->where(array(
                    "users.id"=>$id
                ))
                ->get($this->_table)->result();
   }
   public function getPersonnelById($id){
    return $this->db->select(["personnel.pers_id","personnel.pers_nom", "personnel.pers_prenom ", "users.id_personnel", "users.id"])
            ->join("personnel", "personnel.pers_id=users.id_personnel", "INNER")
            ->where(array(
                "personnel.pers_id"=>$id
            ))
            ->get($this->_table)->result();
}
       public function isUsernameExiste($username){
            return $this->db->select('username')
                ->where(array(
                    'username'=>$username
                ))
                ->get($this->_table)->result();
       }
       public function getUserByName($username){
            return $this->db->select("*")
            ->where(array(
                    'username'=>$username
                ))
                ->get($this->_table)->result();
        }

   public function getUserBySelector($selector){
    return $this->db->select("*")
        ->where(array(
                'users.forgotten_password_selector'=>$selector
            ))
        ->get($this->_table)->result();
}
public function newPassword($password, $selector){
    return $data = array(
        'forgotten_password_selector' => '',
        'forgotten_password_code'  => '',
        'forgotten_password_time'  => '',
        'password'=>$password
);

    $this->db->replace('table', $data);
    return $this->db->select("*")
        ->where(array(
                'users.forgotten_password_selector'=>$selector
            ))
        ->get($this->_table)->result();
}

public function deleteUserGroup($id_user){
    $this->db->where("user_id", $id_user)
        ->delete("users_groups");
}

public function insertUserGroup($id_user, $liste_group){
    foreach ($liste_group as $k => $group) {
        $this->db->insert("users_groups",array(
            "user_id"=>$id_user,
            "group_id"=>$group
        ));
    }
}

    }