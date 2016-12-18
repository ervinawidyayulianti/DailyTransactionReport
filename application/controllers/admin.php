<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

       public function __construct() {
               parent::__construct();
               $this->load->model('Auth_model');
        }
    
       public function index(){
        $this->sign_in();
       }
        
       public function login(){
           $this->form_validation->set_rules('username','Username','required');
           $this->form_validation->set_rules('password','Password','required');
            
            if ($this->form_validation->run() == FALSE){
		  echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>';
            }
            else {
                    $name = $this->input->post('username');
                    $password = $this->input->post('password');
                    if($this->Auth_model->auth($name, $password)){
                    }
                    else{
                        echo'<div class="alert alert-dismissable alert-danger"><small>Please Check Username or Password</small></div>';
                    }
            }
        }
        
       public function logout()
        {
        $this->session->sess_destroy();
        delete_cookie();
            redirect('admin/' ,'refresh');
            exit;
        }
       public function sign_in()
        {
         $this->load->view('admin/view_login');   
        }
       public function sign_up()
        {
          $this->load->view('view_register');  
        }
        
       
        
            
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */