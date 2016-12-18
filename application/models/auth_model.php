<?php

class Auth_model extends CI_Model
{
    
    function __construct() {
        parent::__construct();
    }
    
    function auth($name,$password){
        $password = sha1($password);
        $this->db->where('user_name',$name);
        $this->db->where('password',$password);
        $this->db->where('is_active',1);
        $query = $this->db->get('auth');
        if($query->num_rows()==1){
            foreach ($query->result() as $row){
                $data = array(
                            'username'=> $row->user_name,
                            'logged_in'=>TRUE,
                            'role'=>$row->role
                        );
            }
            $this->session->set_userdata($data);
            return TRUE;
        }
        else{
            return FALSE;
      }
        
    }
    
}