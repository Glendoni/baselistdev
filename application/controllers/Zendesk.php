<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zendesk extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url','zendeskv3'));
	}

  function get_tickets()
  {
       
      $zd_id = $this->input->get('zd_id');
      $responsea  = sonovate_zendesk($zd_id, false, false,'get_all_tickets_regarding_a_specific_user');
      $response =   json_decode($responsea);
      $responsed[] = $response->tickets;
      $rounded  = ceil( $response->count / 100 ) * 100;
        $s=$rounded/100;
      
      for ($x = 0; $x <= $s; $x++) {
           
          if($x >=2){
             
                 $responser  = sonovate_zendesk($zd_id, false, false,'get_all_tickets_regarding_a_specific_user' , false,$x);
              
               $responser =   json_decode($responser);
                   $responsed[] =  $responser->tickets;
                    $responser = false;
          }
      }

      echo json_encode(array('tickets' => $responsed));
      
  }
  
}
