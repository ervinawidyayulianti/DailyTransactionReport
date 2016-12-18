<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashbord extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Dashbord_model');
        $this->load->model('Init_model');
        
    }
    
    public function index(){
        $this->is_logged_in();
      //$data['query'] = $this->db->query("SELECT item.`item`, transaction.`id`, transaction.`comment`, transaction.`created` FROM item  RIGHT JOIN TRANSACTION ON item.`id` = transaction.`item-id` LIMIT 0,5");
        $data['query'] = $this->Init_model->init();
        $data['listquery'] = $this->Init_model->listItem();
        $this->load->view('admin/view_header');
        $this->load->view('admin/view_dashbord', $data);
    }
    
    


    public function is_logged_in(){
        
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        $is_logged_in = $this->session->userdata('logged_in');
        
        if(!isset($is_logged_in) || $is_logged_in!==TRUE)
        {
            redirect('admin/');
        }
    }
    
    function add_transaction(){
            
            $this->form_validation->set_rules('item','Item','required');
            $this->form_validation->set_rules('price','price','required|min_length[1]|max_length[7]|numeric');
            $this->form_validation->set_rules('nug','Nug','required|min_length[1]|max_length[3]|numeric');
            $this->form_validation->set_rules('transaction_type','Transaction Type','required');
            $this->form_validation->set_rules('date','Date','required');
            
            if($this->form_validation->run()==FALSE){
                    
                echo '<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><small>'.  validation_errors().'</small></div>';
                exit;
            }
            else {
                $item = $this->input->post('item');
                $price = $this->input->post('price');
                $nug = $this->input->post('nug');
                $transaction_type = $this->input->post('transaction_type');
                $date = $this->input->post('date');
                $comment = $this->input->post('comment');
                $this->Dashbord_model->add_transaction($item, $price, $nug, $transaction_type, $date, $comment);
               
            }
                
            }
            
    function do_edit(){
        
                $item = $this->input->post('item');
                $price = $this->input->post('price');
                $nug = $this->input->post('nug');
                $transaction_type = $this->input->post('transaction_type');
                $date = $this->input->post('date');
                $comment = $this->input->post('comment');
                $id = $this->input->post('id');
                $this->Dashbord_model->do_edit($item, $price, $nug, $transaction_type, $date, $comment, $id);

            }

    function edit_entry(){
               $id = $this->uri->segment(3);
               $data['item_val'] = str_replace("%20"," ",$this->uri->segment(4));
               $data['query'] =   $this->db->get_where('transaction', array('id'=>$id));
               $data['listquery'] = $this->Init_model->listItem();
               $this->load->view('admin/view_header');
               $this->load->view('admin/view_edit_entry',$data);

            }
            
    function delete_entry(){
                $this->Dashbord_model->delete_post($this->input->post('id'));
            }
            
    function searchTransaction(){
                $data['query'] = $this->db->get('item');
                $this->load->view('admin/view_header');
                $this->load->view('admin/view_searchEntry', $data);
            }
            
    function searchItem(){
             $item = $this->input->post('q');
             if(!empty($item)){
                 $this->Dashbord_model->searchItem($item);
             }
             else{
                 echo'<tr><td colspan="9"><h2 style="color: #9F6000;">Sorry ! no search result found</h2></td></tr>';
             }
            }
            
    function searchAdvance(){
             $from = $this->input->post('from');
             $to = $this->input->post('to');
             if(empty($from) && empty($to)){
                 echo'<tr><td colspan="9"><h2 style="color: #9F6000;">Sorry ! no search result found</h2></td></tr>';
                 exit;
             }
             else{
                 $this->Dashbord_model->searchAdvance($from , $to);
             }
   }
   
   function  batchDelete(){
        if($this->session->userdata('role') == 'admin'){
       
       $ids = ( explode( ',', $this->input->get_post('ids') ));
       
        foreach ($ids as $id){
           $did = intval($id).'<br>';
            $this->db->where('id', $did);
            $this->db->delete('transaction');  
       }
       if($this->db->affected_rows()>0){
        echo'<div class="alert alert-success" style="margin-top:-17px;font-price:bold">
            '.$this->db->affected_rows().'Item deleted successfully
            </div>';
        exit;
       }
       else{
           echo'<div class="alert alert-danger" style="margin-top:-17px;font-price:bold">
            Sorry error in deleting entries ! please try again.
            </div>';
           exit;
       }
   }
   else{
       echo'<div class="alert alert-danger" style="margin-top:-17px;font-price:bold">
            INVALID USER
            </div>';
           exit;
   }
   }
   
   function manageUser(){
       if($this->session->userdata('role') == 'admin'){
        $data['query'] =  $this->db->get('auth');
        $this->load->view('admin/view_header');
        $this->load->view('admin/viewuser', $data);
       }
       else{
         $this->load->view('head_section');
         $this->load->view('invaliduser');
       }
   }
   
   function delUser(){
        if($this->session->userdata('role') == 'admin'){
       $id = $this->input->get_post('id');
       $this->db->where('id', $id);
       $this->db->delete('auth');
       if($this->db->affected_rows()>0){
       $this->session->set_flashdata('falsh', '<p class="alert alert-success">One item deleted successfully</p>');    
       }
       else{
           $this->session->set_flashdata('falsh', '<p class="alert alert-danger">Sorry! deleted unsuccessfully</p>');    
       }
       
        }
        else{
            $this->session->set_flashdata('falsh', '<p class="alert alert-danger">Sorry! You have no rights to deltete</p>');    
            
        }
        redirect('dashbord/manageUser');
       exit;
   }
   
   function createUser(){
       if($this->session->userdata('role') == 'admin'){
        $this->form_validation->set_rules('name', 'Username', 'callback_username_check');
        $this->form_validation->set_rules('email', 'Email Address', 'callback_email_check');
        
                if ($this->form_validation->run() == FALSE){       
                    echo validation_errors('<div class="alert alert-danger">', '</div>');
                        exit;
		}
		else{
                    if($this->Dashbord_model->createUser()){
                        echo '<div class="alert alert-success">This user created successfully</div>';
                        exit;
                    }
                    else{
                        echo '<div class="alert alert-danger">Sorry ! something went wrong </div>';
                        exit;
                    }
                }
       }
       else{
           echo '<div class="alert alert-danger">Invalid user</div>';
                        exit;
       }
   }
   
   public function username_check($str){       
               $query =  $this->db->get_where('auth', array('user_name'=>$str));
               
		if (count($query->result())>0)
		{
			$this->form_validation->set_message('username_check', 'The %s already exists');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
        
   public function email_check($str){
            $query =  $this->db->get_where('auth', array('user_email'=>$str));
		if (count($query->result())>0)
		{
                    	$this->form_validation->set_message('email_check', 'The %s already exists');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
    }
    
    function updateUserPass(){
        if($this->session->userdata('role') == 'admin'){
        $val = sha1($this->input->post('value'));
        $pk =  $this->input->post('pk');
        $data = array(
               'password' => $val
            );

            $this->db->where('id', $pk);
            $this->db->update('auth', $data); 
        }
        
    }
    
    function updateUserStstus(){
        if($this->session->userdata('role') == 'admin'){
        $val = $this->input->post('value');
        $pk =  $this->input->post('pk');
        
        $data = array(
               'is_active' => $val
            );

            $this->db->where('id', $pk);
            $this->db->update('auth', $data); 
        
        }
    }
    
    
    
    function evaluate(){
        $rs =  $this->db->get('transaction');
        $operation1 = 0;
        $operation2 = 0.0000;
        foreach ($rs->result() as $row){
            $type =  ($row->transaction_type =='buy')?'+':'-';
            $operation1 =$operation1 . $type.$row->nug;
            $operation2 =$operation2 . $type.$row->total_price;
        }
        echo 'Total Quantity = '. $operation1 = eval("return($operation1);");
        echo '<br> Total price = '. $operation2 = eval("return($operation2);");
    }
}
   

