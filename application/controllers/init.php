<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Init extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
//        $this->is_logged_in();
        $this->load->model('Init_model');
        $this->load->model('Auth_model');
        $this->load->library('excel');
    }
    
    
    public function index(){
    
    }
    
//    public function itemExcel(){
//        $header = '';
//        $result ='';
//        $query = $this->db->get('item');
//        $fields = $this->db->list_fields('item');
//        
//        foreach ($fields as $field)
//            {
//               $header .=  $field . "\t";
//            } 
//        foreach ($query->result() as $row)
//            {
//            $line = '';
//            foreach( $row as $value )
//                {
//                if ( ( !isset( $value ) ) || ( $value == "" ) )
//                {
//                $value = "\t";
//                }
//                else
//                {
//                $value = str_replace( '"' , '""' , $value );
//                $value = '"' . $value . '"' . "\t";
//                }
//                $line .= (string)$value;
//                }
//                 $result .= trim( $line ) . "\n";
//            }
//            $result = str_replace( "\r" , "" , $result );
//            
//            if ( $result == "" )
//                {
//                 $result = "\nNo Record(s) Found!\n";
//                }
//                $file_name = 'item-'.date('d/m/y');
//                header("Content-type: application/octet-stream");
//                header("Content-Disposition: attachment; filename=$file_name.xls");
//                header("Pragma: no-cache");
//                header("Expires: 0");
//                print "$header\n$result";
//    }
//    
//    
//    public function transactionExcel(){
//        $header = '';
//        $result ='';
//        $sql = "SELECT transaction.id, item.item,  transaction.price, transaction.nug, transaction.total_price, transaction.transaction_type, transaction.comment, transaction.created from transaction LEFT JOIN item ON transaction.item_id = item.id  ";        
//        $query = $this->db->query($sql);
//        $fields = $this->db->list_fields('transaction');
//        
//        foreach ($fields as $field)
//            {
//               $header .=  $field . "\t";
//            } 
//        foreach ($query->result() as $row)
//            {
//            $line = '';
//            foreach( $row as $value )
//                {
//                if ( ( !isset( $value ) ) || ( $value == "" ) )
//                {
//                $value = "\t";
//                }
//                else
//                {
//                $value = str_replace( '"' , '""' , $value );
//                $value = '"' . $value . '"' . "\t";
//                }
//                $line .= (string)$value;
//                }
//                 $result .= trim( $line ) . "\n";
//            }
//            $result = str_replace( "\r" , "" , $result );
//            
//            if ( $result == "" )
//                {
//                 $result = "\nNo Record(s) Found!\n";
//                }
//                 $file_name = 'transaction-'.date('d/m/y');
//                header("Content-type: application/octet-stream");
//                header("Content-Disposition: attachment; filename=$file_name.xls");
//                header("Pragma: no-cache");
//                header("Expires: 0");
//                print "$header\n$result";
//    }


    public function exportTransactionExcel(){
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Transaction');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Transaction Excel Sheet');
        
        $this->excel->getActiveSheet()->setCellValue('A4', 'Item Name');
        $this->excel->getActiveSheet()->setCellValue('B4', 'price');
        $this->excel->getActiveSheet()->setCellValue('C4', 'Quantity');
        $this->excel->getActiveSheet()->setCellValue('D4', 'Total price');
        $this->excel->getActiveSheet()->setCellValue('E4', 'Transaction Type');
        $this->excel->getActiveSheet()->setCellValue('F4', 'Any notes');
        $this->excel->getActiveSheet()->setCellValue('G4', 'Date');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        
       for($col = ord('A'); $col <= ord('G'); $col++){
                //set column dimension
        $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
         //change the font size
        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
        //retrive contries table data
        $sql = "SELECT item.item,  transaction.price, transaction.nug, transaction.total_price, transaction.transaction_type, transaction.comment, transaction.created from transaction LEFT JOIN item ON transaction.item_id = item.id  ";        
        $rs = $this->db->query($sql);
//        $rs = $this->db->get('countries');
        $exceldata="";
        foreach ($rs->result_array() as $row){
                $exceldata[] = $row;
        }
                //Fill data 
                $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A5');
                
                $this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                $filename='Transaction-'.date('d/m/y').'.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache

                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');
    }
    
    public function exportItemExcel(){
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Item');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Item Excel Sheet');
        
        $this->excel->getActiveSheet()->setCellValue('A4', 'Item Name');
        $this->excel->getActiveSheet()->setCellValue('B4', 'Any Notes');
        $this->excel->getActiveSheet()->setCellValue('C4', 'Date');
        
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:C1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        
       for($col = ord('A'); $col <= ord('C'); $col++){
                //set column dimension
        $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
         //change the font size
        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
        //retrive contries table data
        $sql = "SELECT item, comment, created From item  ";        
        $rs = $this->db->query($sql);
//        $rs = $this->db->get('countries');
        $exceldata="";
        foreach ($rs->result_array() as $row){
                $exceldata[] = $row;
        }
                //Fill data 
                $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A5');
                
                $this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                $filename='Item-'.date('d/m/y').'.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache

                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');
    }
    
    
    
    public function resetData(){
         if($this->session->userdata('role') == 'admin'){
            $this->load->view('admin/view_header');
            $this->load->view('admin/view_resetData');
         }
         else{
         $this->load->view('head_section');
         $this->load->view('invaliduser');
         }
    }
    
    public function resetTransactionItem(){
        $password =  $this->input->get_post('password');
        $table =  $this->input->get_post('tabl');
        $uname =  $this->session->userdata('username');
        if($this->Auth_model->auth($uname, $password)){
            if($table == 'transaction'){
            $this->db->truncate($table);
            echo '<p class="alert alert-success"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;'.$table.' reset successfully ! Thanks</p>';
            exit;
            }
            else{
                $sql = "ALTER TABLE transaction  DROP FOREIGN KEY fk";
                $sql1 = "DROP TABLE IF EXISTS transaction, item";
                $sql2 = sprintf("CREATE TABLE IF NOT EXISTS `item` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `item` varchar(11) NOT NULL,
                            `comment` text NOT NULL,
                            `created` date NOT NULL,
                            PRIMARY KEY (`id`),
                            KEY `item` (`item`)
                          )");
                $sql3 = sprintf("CREATE TABLE IF NOT EXISTS `transaction` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `item_id` int(11) NOT NULL,
                        `price` int(11) NOT NULL,
                        `nug` int(11) NOT NULL,
                        `total_price` int(11) NOT NULL,
                        `transaction_type` varchar(155) NOT NULL,
                        `comment` text NOT NULL,
                        `created` date NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `item-id` (`item_id`)
                      )");
                $sql4 = "ALTER TABLE transaction  ADD CONSTRAINT fk FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE ON UPDATE CASCADE;";
                
                $this->db->trans_start();
                $this->db->query($sql);
                $this->db->query($sql1);
                $this->db->query($sql2);
                $this->db->query($sql3);
                $this->db->query($sql4);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE)
                    {
                    $this->db->query($sql);
                    echo '<p class="alert alert-danger"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp; Sorry! reset Unsuccessfully !</p>';
                    exit;
                    }
                    else{
                        echo '<p class="alert alert-success"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp; Reset successfully ! Thanks</p>';
                        exit;
                    }
                
            }
        }
        else{
            echo'<p class="alert alert-danger"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Invalid User</p>';
            exit;
        }
    }
   
}
