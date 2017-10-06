<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tests extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		// load database
         $this->load->model('Test_model');
        // load form validation library
        $this->load->library('form_validation');
	}

 public function index()
    {
      
            
        
        
            $this->data['main_content'] = 'dashboard/test';
            $this->data['window']  = $this->data['current_user']['new_window'];
            $this->load->view('layouts/default_layout', $this->data);
    }

	
 public function show()
 {
     
     
           $post = $this->input->post();
     
     
     
       //$this->Test_model->putTestData($post);
     
     //exit();
     //add conditions
     
           $read_test = $this->Test_model->getTestData();
     
     
     	    $this->data['main_content'] = 'dashboard/testsuccess';
            $this->data['window']  = $this->data['current_user']['new_window'];
     
            $this->data['test']  = $read_test; //arrayObject
            $this->load->view('layouts/default_layout', $this->data);
     
 }
}