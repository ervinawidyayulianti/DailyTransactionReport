<?php

class Dashbord_model extends CI_Model
{
    
   function __construct() {
        parent::__construct();
    }
    
   function add_transaction($item, $price, $nug, $transaction_type, $date, $comment){
        $total_price = ($price * $nug);
        $transaction = array('item_id'=>$item,
                            'price'=>$price,
                            'nug'=>$nug,
                            'total_price'=>$total_price,
                            'transaction_type'=>$transaction_type,
                            'comment'=>$comment,
                            'created'=>$date);
        
       $this->db->insert('transaction', $transaction);
       if($this->db->affected_rows()>0){
            echo'<div class="alert alert-dismissable alert-success"><h4>Transaction Successfull</h4></div>';
            exit;
//            Set transaction history
//            $this->updateReport($item, $price, $nug, $transaction_type, $date);
            
       }
       else{
            echo'<div class="alert alert-dismissable alert-danger"><h4>Transaction Unsuccessfull</h4></div>';
            exit;
       }
    }
    
   function delete_post($id){
       if($this->session->userdata('role') == 'admin'){
            $this->db->delete('transaction',  array('id'=>$id));
            }
            else{
            echo'invalid user'; 
            exit;
        }
        }
        
    
   function do_edit($item, $price, $nug, $transaction_type, $date, $comment, $id){
        $data = array(
               'item_id' => $item,
               'price' => $price,
               'nug' => $nug,
               'transaction_type' => $transaction_type,
               'comment' => $comment,
               'created' => $date,
            );

        $this->db->where('id', $id);
        $this->db->update('transaction', $data); 
        if($this->db->affected_rows()>0){
            echo'<div class="alert alert-dismissable alert-success alert-cus"><h4>This Post Edited Successfully</h4></div>';
        }
        else{
            echo'<div class="alert alert-dismissable alert-danger alert-cus"><h4>No Change found to update entry!</h4></div>';
        }
   }
   
   function searchItem($item){
       $item = trim($item);
       $sql = "SELECT item.item, item.id as itemID, transaction.id, transaction.price, transaction.nug, transaction.transaction_type, transaction.comment, transaction.created from item RIGHT JOIN transaction ON transaction.item_id = item.id WHERE transaction.item_id = $item";        
        $query = $this->db->query($sql);
//       $query = 'SELECT item.item, transaction.id, transaction.price, transaction.nug, transaction.transaction_type, transaction.comment, transaction.created';        
//       $this->db->from('item');
//       $this->db->join('transaction', 'transaction.item_id = item.id', 'right');
//       //$this->db->order_by("transaction.id", "desc"); 
//       $this->db->where('transaction.item_id', $item);
//       $query = $this->db->get();
       $sno = 1;
       foreach ($query->result() as $row)
       {    
           $created = strtotime($row->created);
           echo'<tr><td>'.$sno.'</td><td>'.$row->item.'</td><td>'.$row->price.'</td><td>'.$row->nug.'</td><td>'.($row->price * $row->nug).'</td><td>'.$row->transaction_type.'</td><td>'.date('F jS Y', $created ).'</td><td>'.$row->comment.'</td><td>
                <div class="btn-group"><a href="'.base_url().'dashbord/edit_entry/'.$row->id.'/'.$row->item.'" class="btn btn-info btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                <a href="#" db_id="'.$row->id.'" class="btn btn-danger btn-sm btn_delete" title="Delete"><i class="glyphicon glyphicon-remove"></i></a></div>
                </td></tr>';
           
           $sno = $sno+1; 
       }
       
       
   }
   
   function searchAdvance($from , $to){
       $form = trim($from);
       $to = trim($to);
       $condition = "between '$from' And '$to' ";
       if(empty($from)){
           echo'<tr><td colspan="9"><h2 style="color: #9F6000;">Sorry ! invalid date option</h2></td></tr>';
           exit;
       }
       if(!empty($form) AND empty($to)){
       $condition = "='$form'";
       }
       
       
       $sql = "SELECT item.item, item.id as itemID, transaction.id, transaction.price, transaction.nug, transaction.transaction_type, transaction.comment, transaction.created from item RIGHT JOIN transaction ON transaction.item_id = item.id WHERE transaction.created $condition ";        
       $query = $this->db->query($sql);
       $sno = 1;
       foreach ($query->result() as $row)
       {    
           $created = strtotime($row->created);
           echo'<tr><td>'.$sno.'</td><td>'.$row->item.'</td><td>'.$row->price.'</td><td>'.$row->nug.'</td><td>'.($row->price * $row->nug).'</td><td>'.$row->transaction_type.'</td><td>'.date('F jS Y', $created ).'</td><td>'.$row->comment.'</td><td>
                <div class="btn-group"><a href="'.base_url().'dashbord/edit_entry/'.$row->id.'/'.$row->item.'" class="btn btn-info btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                <a href="#" db_id="'.$row->id.'" class="btn btn-danger btn-sm btn_delete" title="Delete"><i class="glyphicon glyphicon-remove"></i></a></div>
                </td></tr>';
           $sno = $sno+1; 
       }
   }
//   update transction history every time
   public function updateReport($item, $price, $quantity, $type, $date){
       
        $get_histoty =  $this->db->get_where('report', array('item_id'=>$item),1);
        $u_price = 0;
        $u_quantity = 0;
        foreach ($get_histoty->result() as $row){
        $u_price = $row->price;
        $u_quantity = $row->quantity;
        }
        if($type == 'buy'){
            $u_price = ($price + $u_price);
            $u_quantity = ($quantity + $u_quantity);
            }
        if($type == 'sale'){
            if( ($u_price > $price) && ($u_quantity > $quantity) ){
            $u_price = ($u_price - $price );
            $u_quantity = ($u_quantity - $quantity);
            }
            else{
            echo' Sorry ! Not enought stock for sale ';
            exit;
            }
        }
        $data = array(
        'price' => $u_price,
        'quantity' => $u_quantity,
        'created' => $date
        );

        $this->db->where('item_id', $item);
        $this->db->update('report', $data); 


        if($this->db->affected_rows()>0){
        echo'updated';
        }
       exit;
   }
   
   function createUser(){
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = sha1($this->input->post('cpassword'));
        $role = $this->input->post('role');
        $is_active = $this->input->post('is_active');
        $created = date("Y/m/d");
        
        $data = array('user_name'=>$name,
            'user_email'=>$email,
            'password'=>$password,
            'role'=>$role,
            'is_active'=>$is_active,
            'd_o_c'=>$created);
        $this->db->insert('auth', $data);
        if($this->db->affected_rows()>0){
            return true;
        }
        else{
            return FALSE;}
   }
    
   
}