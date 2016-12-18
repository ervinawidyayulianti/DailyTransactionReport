<?php

class Upload_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }
    
    public function save_upload($file_title, $file_path, $file_title2)
    {
        $today = date('y/m/d');
        $this->db->set('name', $file_title);
        $this->db->set('path', $file_path);
        $this->db->set('uploaded', $today);
        $this->db->set('title', $file_title2);
        $this->db->insert('files'); 
        
        if($this->db->affected_rows()>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
        
    }
    
    
    
}