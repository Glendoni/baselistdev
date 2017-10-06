<?php
class Test_model extends CI_Model {
    
    
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
       
	}
        
    function putTestData($post)
    {
        
      
        
         $data = array('test' => $post['test']);
			$this->db->insert('test', $data);
        
        return true;
       
    }   
        
        
    function getTestData()
	{
		
        
		$this->db->select('id, test');

$query = $this->db->get('test')->result_array();
        
        return $query;
	}
        
  
    
}
    