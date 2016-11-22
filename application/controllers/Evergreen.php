<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evergreen extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		// load database
        $this->load->database();
        // load form validation library
        $this->load->library('form_validation');
        $this->load->model('Evergreen_model');
	}

    public function index()
    {
        // allow only Ajax request 
        $this->data['main_content'] = 'evergreen/evergreen';
		$this->data['full_container'] = True;
		$this->load->view('layouts/default_layout', $this->data);
        
    }
    
     public function admin()
    {
        // allow only Ajax request    
     
        $this->data['main_content'] = 'evergreen/evergreen_edit';
		$this->data['full_container'] = True;
		$this->load->view('layouts/default_layout', $this->data);
        
    }
    
    function updateTagCampaignRun()
    { //updates the campaign with 5 more 
        
        $user_id =  $this->get_current_user_id();
        $current_campaign_id =  $this->input->post('campid');
         $evergreenID =  $this->input->post('evergreen');
         //echo json_encode(array('success' => $user_id));
        
        
        //echo  'Hlendn '.$evergreenID;
       echo json_encode($this->Evergreen_model->updateTagCampaign($current_campaign_id,$user_id,$evergreenID));
        
    }
	   
    function getMyEvergreenCampaign()
    { //Gets the evergreen campaign 
         $user_id =  $this->get_current_user_id();
        echo json_encode($this->Evergreen_model->getMyEvergreenCampaign($user_id));
       
    }
    
    function campaigncountCheckerRun()
    {
        
        echo json_encode($this->Evergreen_model->campaigncountChecker());
        
    }
    
    
    function test(){
       
        $out  = $this->Evergreen_model->evergreenHeaderInfo(1,4);
 if(!$out[0]['remaining']){
echo 'YEss';
}
        
    }
    
    
    function testlimiter(){
      $sqlCheck = 'SELECT evg.max_allowed as maxallowed,count(ta.id)  FROM targets ta
LEFT JOIN evergreens evg
ON ta.evergreen_id = evg.id

 WHERE ta.campaign_id=661 AND ta.evergreen_id is not null

 GROUP BY 1';
        $query = $this->db->query($sqlCheck);
        $row  =     $query->result_array(); 
        echo $row[0]['maxallowed'];
       if($row[0]['maxallowed'] > $row[0]['count']){
                  //echo 'yessss';
              }
        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}