    <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    
        function __construct() {
            parent::__construct();
        }
        
        
         function index(){
            $this->get_pagination();
            $data['query'] = $this->db->get('item');
            $this->load->view('head_section', $data);
            $this->load->view('view_home', $data);
            $this->load->view('footer');
            
	}
                
        function search(){
            $s = $this->input->post('s');
            $data['title']='Blog';
            $data['heading'] = 'Search result';
            $data['query'] = $this->db->query("select * from entries where body LIKE '% $s %' ");
            $this->load->view('head_section', $data);
            $this->load->view('search_view',$data);
            $this->load->view('footer');
        }
        
        function reportcard(){
            $id = $this->uri->segment(3);
//          use item variable for show in heading
            $data['item'] = str_replace('%20', ' ', $this->uri->segment(2));
            $data['query'] = $this->db->get_where('transaction', array('item_id' => $id));
            $data['date'] = $this->db->query("SELECT created FROM transaction where id= $id ORDER BY id DESC LIMIT 1;");
            $quantity = 0;
            $price = 0.0000;
                foreach ($data['query']->result() as $row){
                    $type =  ($row->transaction_type =='buy')?'+':'-';
                    $quantity =$quantity . $type.$row->nug;
                    $price =$price . $type.$row->total_price;
                }
            $data['quantity'] = eval("return($quantity);");
            $data['price'] = eval("return($price);");
            $this->load->view('head_section');
            $this->load->view('view_reportcard', $data);
            $this->load->view('footer');
        }
        
        
        function reportPdf(){
            // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
            $pdfFilePath = FCPATH."/downloads/reports/$filename.pdf";
            $data['page_title'] = 'Hello world'; // pass data to the view

            if (file_exists($pdfFilePath) == FALSE)
            {
                ini_set('memory_limit','32M'); // boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
                $html = $this->load->view('pdf_report', $data, true); // render the view into HTML

                $this->load->library('pdf');
                $pdf = $this->pdf->load();
                $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
                $pdf->WriteHTML($html); // write the HTML into the PDF
                $pdf->Output($pdfFilePath, 'F'); // save to file because we can
            }

            redirect("/downloads/reports/$filename.pdf"); 
        }
                
        function get_pagination()
        {
            $config['base_url'] = base_url().'/home/index/';
            
            $config['total_rows'] = $this->db->get('item')->num_rows();
            
            $config['per_page'] = 4;
            
            $config['num_links'] = 5;
            
            //appy css on pagination
            
//            $config['page_query_string'] = TRUE;
//            // $config['use_page_numbers'] = TRUE;
//            $config['query_string_segment'] = 'page';

            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul><!--pagination-->';

            $config['first_link'] = '&laquo; First';
            $config['first_tag_open'] = '<li class="prev page">';
            $config['first_tag_close'] = '</li>';
//
            $config['last_link'] = 'Last &raquo;';
            $config['last_tag_open'] = '<li class="next page">';
            $config['last_tag_close'] = '</li>';
//
            $config['next_link'] = 'Next &rarr;';
            $config['next_tag_open'] = '<li class="next page">';
            $config['next_tag_close'] = '</li>';
//
            $config['prev_link'] = '&larr; Previous';
            $config['prev_tag_open'] = '<li class="prev page">';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="active"><a href="">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li class="page">';
            $config['num_tag_close'] = '</li>';

            //   $config['display_pages'] = FALSE;
            // 
//          $config['anchor_class'] = 'follow_link';
            
            $this->pagination->initialize($config);
            
            
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */