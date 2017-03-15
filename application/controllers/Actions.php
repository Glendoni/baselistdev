<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actions extends MY_Controller {

	function __construct() 
	{
		parent::__construct();
        
         $this->load->model('Files_model');
        $this->load->helper(array('form', 'url'));
         $this->load->helper('MY_azurefile');
		
	}

	public function _valid_date(){
		$now = date('Y-m-d H:i:s',time());
		$date = date('Y-m-d H:i:s',strtotime($this->input->post('planned_at')));
		if($date > $now){
			return TRUE;
		}else{
			$this->form_validation->set_message('_valid_date', 'Planned date for action must be in the future');
			return FALSE;
		}

	}
	public function create()
    {
        
        
     //print_r('<pre>');print_r($this->input->post());print_r('</pre>'); exit();
      
        /*
        
         $post = $this->input->post();
        
        // print_r('<pre>');print_r($this->input->post());print_r('</pre>');
        
        $userfilename = $this->input->post('userfilename');
        $uploadedfilename = $_FILES['userfile']['name'];
        

foreach($userfilename as $key => $value){
    
     echo $userfilename[$key] .''.$uploadedfilename[$key];
    
}

       
     
        echo 'Yes Glen';
        exit();
        */
        
        
    
			if (!empty($post['campaign_id'])) {
			 $campaign_redirect ='&campaign_id='.$post['campaign_id'];
			}
             // print_r('<pre>');print_r($this->input->post());print_r('</pre>');
            $post = $this->input->post();
            if ((empty($post['action_type_completed'])) && (empty($post['action_type_planned']))) {
                $this->set_message_action_error('Please select either a new or follow up action.');
                $message = $post['comment'];
                redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'&message='.urlencode($message).'#action-error','location');
                }
                else
                {
                    if (!empty($post['campaign_id'])) {
                    $campaign_redirect ='&campaign_id='.$post['campaign_id'];
                    }


                if($this->input->post('done'))
                {	
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('actioned_at', 'actioned_at', 'xss_clean');
                    $this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
                    $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
                    $this->form_validation->set_rules('contact_id', 'contact_id', 'xss_clean');
                    if($this->form_validation->run())
                    {	$post = $this->input->post();

                        if (($post['action_type_completed']=='16') && (empty($post['class_check'] ))){
                            $this->set_message_error('Please set a company class before adding a deal.');
                            redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#add_action','location');
                            }

                        else if (($post['action_type_completed']=='16') && ($post['source_check'] < 1 )){
                            $this->set_message_error('<strong>Deal Not Added</strong></br> Please add a source.');
                            redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#add_action','location');
                            }
                        else if (($post['action_type_completed']=='8') && ($post['source_check'] < 1 )){
                            $this->set_message_error('<strong>Proposal Not Added</strong></br> Please add a source.');
                            redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#add_action','location');
                            }

                        else if (($post['action_type_completed']=='16') && ($post['sector_check'] < 1 )){
                            $this->set_message_error('<strong>Deal Not Added</strong></br> Please add at least one sector to this company.');
                            redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#add_action','location');
                            }
                            else 
                            {
                        $result = $this->Actions_model->create($this->input->post());
                                if(!$result)     redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#actions','location');
                            }
                        if(empty($result))
                            {
                            $this->set_message_warning('Error while inserting details to database');
                            }
                        else
                            {
                            
                            
                            
                                     
                            if(($post['action_type_completed']=='42')){


                               //  file_put_contents('./uploads/glen.txt', 'hello');

                                $userfilename = $this->input->post('userfilename'); 

                                $img = $_FILES['userfile'];

                                if(!empty($img))
                                {
                                    $img_desc = $this->reArrayFiles($img);
                                    //print_r($img_desc);

                                    foreach($img_desc as $val)
                                    {

                                        $newname = date('YmdHis',time()).mt_rand().'.'.pathinfo($val['name'],PATHINFO_EXTENSION);
                                        $locationName[] = $newname;
                                        $src =  file_get_contents($val['tmp_name']);

                                         uploadBlob($src, $newname); //Sends file and custom filename to Azure

                                    }
                                }

                                foreach($locationName as $key => $value){
 
                                            $filename_encrypted  = sha1($value . date('YmdHis'));
                                            $file_action_post = array(
                                            'action_id' => $result,
                                            'name' => $userfilename[$key],
                                            'file_location' =>  $value,
                                            'created_at' => date('Y-m-d'),
                                            'company_id' => $this->input->post('company_id'),
                                            'created_by' => $this->data['current_user']['id'],
                                            'encryption_name' => $filename_encrypted
                                            );

                                            $this->Files_model->file_uploader($file_action_post);

                                }                        

                            }
                            
                          
                            // after the initial action has been successfully created we can continue with the following login
                            // *** TRY TO KEEP LOGIC IN THE CONTROLLER AND DATABASE COMMITS IN THE MODELS***
                            $post = $this->input->post();
                            $company_id = $post['company_id'];
                            if ($post['action_type_completed']=='16') {

                                // if action type completed is a deal then company is a now a customer
                                // companies model update the company to customer
                                $result = $this->Companies_model->update_company_to_customer($company_id);
                                if(empty($result)){
                                    $this->set_message_warning('Error while updating company.');	
                                }
                                else{
                                    // actions models, register the update of a company to customer status 
                                    $result = $this->Actions_model->company_updated_to_customer($post);
                                    $result1 = $this->Actions_model->add_to_zendesk($post);
                                    if(empty($result)) $this->set_message_warning('Error while updating action for the company.');
                                }

                            }else if($post['action_type_completed']=='8'){
                                // proposal sent to company 
                                
                                 if($this->Companies_model->company_select($company_id)){ //prevents proposal being updated if company is a customer
                                
                                        $result = $this->Companies_model->update_company_to_proposal($company_id);
                                 }
                                //if(empty($result)){
                                  //  $this->set_message_warning('Error while updating company.');
                                //}else{
                                    // action model, update register an action for the proposal
                                    $result = $this->Actions_model->company_updated_to_proposal($post); 
                                    $result1 = $this->Actions_model->add_to_zendesk($post); 
                                    if(empty($result)) $this->set_message_warning('Error while updating action for the company.');
                                
                                //}
                            }else if($post['action_type_completed']=='31' || $post['action_type_completed']=='32' || $post['action_type_completed']=='33' || $post['action_type_completed']=='34'|| $post['action_type_completed']=='35'){
                                // proposal sent to company 
                                
                                 if($this->Companies_model->company_select($company_id)){ //prevents proposal being updated if company is a customer
                                
                                            if($post['action_type_completed']=='31')    $actionName = 'Prospect'; 
                                            if($post['action_type_completed']=='32')    $actionName = 'Intent';
                                            if($post['action_type_completed']=='33')    $actionName = 'Unsuitable';      
                                            if($post['action_type_completed']=='34')    $actionName = 'Lost'; 
                                            if($post['action_type_completed']=='35')    $actionName = 'Suspect'; 

                                     
                                     
                                      if($actionName)  $result = $this->Actions_model->company_updated_to_action($post,$actionName);//update action
                                            if($result)  $result = $this->Companies_model->update_company_to_action($company_id,$actionName); //update pipeline
                                        }
                                //if(empty($result)){
                                  //  $this->set_message_warning('Error while updating company.');
                                //}else{
                                    // action model, update register an action for the proposal
                                    //$result = $this->Actions_model->company_updated_to_proposal($post); 
                                
                                
                                  //$result1 = $this->Actions_model->add_to_zendesk($post); 
                                    if(empty($result)) $this->set_message_warning('Error while updating action for the company.');
                                //}
                            }
                            
                            
                            $this->set_message_success('Action successfully inserted');
                            redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#actions','location');
                        }
                    }else{
                        $this->set_message_error(validation_errors());
                        redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect,'location');
                    }

                    }
                    elseif($this->input->post('follow_up')){

                        $this->load->library('form_validation');
                        $this->form_validation->set_rules('action_type_completed', 'action_type_completed', 'xss_clean|required');
                        $this->form_validation->set_rules('comment', 'comment', 'xss_clean|required');
                        $this->form_validation->set_rules('planned_at', 'planned_at', 'required|callback__valid_date');
                        $this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
                        $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
                        $this->form_validation->set_rules('contact_id', 'contact_id', 'xss_clean');

                        if($this->form_validation->run())
                        {
                                        if (!empty($post['campaign_id'])) {
                        $campaign_redirect ='&campaign_id='.$post['campaign_id'];
                        }

                            $result = $this->Actions_model->create($this->input->post(),$this->data['current_user']['id']);
                            if(empty($result))
                            {
                                $this->set_message_warning('Error while inserting details to database');
                            }
                            else
                            {
                                
                                
                       
                                
                                
                                
                                
                                
                                
                                
                                
                                $this->set_message_success('Action successfully inserted');
                                redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect,'location');
                            }
                        }else{
                            $this->set_message_error(validation_errors());
                            redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect,'location');
                        }
                    }
            }
	} 

	
   
    
    
    
        function reArrayFiles($file)
        {
            $file_ary = array();
            $file_count = count($file['name']);
            $file_key = array_keys($file);

            for($i=0;$i<$file_count;$i++)
            {
                foreach($file_key as $val)
                {
                    $file_ary[$i][$val] = $file[$val][$i];
                }
            }
            return $file_ary;
        }
    
    
    
    public function edit()
    {
		


if($this->input->post('action_id'))
		{
			if($this->input->post('action_do') == 'completed')
			{   
				$this->load->library('form_validation');
				$this->form_validation->set_rules('action_type', 'action_type', 'xss_clean');
				$this->form_validation->set_rules('comment', 'comment', 'xss_clean');
				$this->form_validation->set_rules('planned_at', 'planned_at', 'xss_clean');
				$this->form_validation->set_rules('actioned_at', 'actioned_at', 'xss_clean');
				$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean');
				$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean');

				if($this->form_validation->run())
				{
					if (!empty($post['campaign_id'])) {
					$campaign_redirect ='&campaign_id='.$post['campaign_id'];
					}


					$outcome = $this->input->post('outcome');
					$result = $this->Actions_model->set_action_state($this->input->post('action_id'),$this->input->post('user_id'),'completed',$outcome);
					if($result)
					{
						$this->set_message_success('Action updated successfully.');
					}
					else
					{
						$this->set_message_warning('Error while updating action');
					}
				}else{
					$this->set_message_error(validation_errors());
				}

				redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#actions','location');
			}

			else if($this->input->post('action_do') == 'cancelled')
			{	
				$outcome = $this->input->post('outcome');
                $result = $this->Actions_model->set_action_state($this->input->post('action_id'),$this->input->post('user_id'),'cancelled',$outcome);				
				if($result)
				{
					$this->set_message_success('Action set to cancelled.');
				}
				else
				{
					$this->set_message_warning('Error while canceling action');
				}
			if (empty($this->input->post('page'))) {
				redirect('companies/company?id='.$this->input->post('company_id'),'location');
			}
			else
			{redirect('/dashboard#calls','location');}
			}
		}
	}
    
    
    public function addActionsComment()
    {
        $rqst = $this->input->post();
        $output = array('call'=>$rqst, 'pattern'=>'Wake up');
        $this->Actions_model->create($this->input->post());
        
        echo   json_encode($rqst); 
    }
    
     public function addActionsCallback()
     {
        $rqst = $this->input->post();
        $output =     array('call'=>$rqst, 'pattern'=>'Wake up');
        $this->Actions_model->create($this->input->post());
        
        echo   json_encode($output);
             
    }
    
    public function addOutcome()
    {
        
       $inputpost = $this->input->post();
                    //set_action_state($action_id,$user_id,$state,$outcome);
         //$rap = json_decode($rap);
        $user_id = $this->data['current_user']['id'];
       $action_id = $inputpost['outcomeActionId'];
       $outcome = htmlentities(rtrim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '',$inputpost['outcome'])));
        $state = $inputpost['status'];
        $atp = $inputpost['action_type_planned'];
        $result  =  $this->Actions_model->set_action_state($action_id,$user_id,$state,$outcome,$inputpost);
        $output = array(
            'action' => $action_id,
            'user_id' =>$user_id ,
            'state' => $state,
            'result' => $result,
            'action_type_planned' => $atp ? $atp : false,
            'outcome' => $outcome
        
        );
            echo json_encode($output);
    }

    function _removeOutsandingaction()
    {
     
    }
    function _operations_store()
    {
    }
    
    function operations_read($pageEval = false)
    {
        
       //$pageEval = $pageEval?  $this->session->userdata('selected_company_id') : 0;
        
        header('Content-Type: application/json');
       $input['operations'] =  $this->Actions_model->operations_store_get($this->data['current_user']['id'],  $pageEval);
        echo  json_encode($input);
        

    }
    
    function _qvActions() //This can be removed part of quickview protoype which was rejected. Maybe store for future use
    {
        
        return   $this->Actions_model->get_actions_outstanding(154537,5);
        
    }
    
    function _mycampaigns() //This can be removed part of quickview protoype which was rejected. Maybe store for future use
    {
        $campaign_comp_id  = $this->input->post('campID');
        $campaign = $this->session->userdata('campaign_id');
        $query  =   (array)$this->Campaigns_model->get_all_private_campaigns($this->data['current_user']['id']);

        $i  =  0 ;
        $a = array(); 
        $campAll = []; $narrAct = [];
            foreach ($query as $key  => $row)
            {

                 $a[] =  $row->id;
                $b =  $a[$i];
                $i++;
                if($b == $campaign_comp_id){
                    array_push($narrAct, $i);   
                }

            }

        array_push($campAll, $a); 

        $campKey = ($narrAct[0] - 1);
        $campKeyPrev = ($narrAct[0] - 2);
        $campKeyNext = ($narrAct[0] - 0);
        $next =  isset($campAll[0][$campKeyNext]) ? $campAll[0][$campKeyNext] : '';
        $previous =   isset($campAll[0][$campKeyPrev]) ? $campAll[0][$campKeyPrev] : '';
        $output  = array(  

            'SearchStr' => $campaign_comp_id,
            'campaign' => $campaign,
            'current' => $campAll[0][$campKey], 
            'previous' => $previous, 
            'next' => $next 
        );

        echo json_encode($output);
    } 
    
    function changeActionDate()
    {
        
        $this->Actions_model->changeActionDate($this->input->post(),$this->data['current_user']['id']);
        
        echo  json_encode($this->input->post());
        
    }
    
    function getfilesh($id = '2fc563a34b29bd3986e649674c0e2a48d28f7d5f')
    {
        
        $query = $this->db->query("SELECT file_location FROM files WHERE encryption_name='".$id."' LIMIT 1");
              $output =   $query->result_array();
               
    echo $output[0]['file_location'];
        
    }

    
    
    
function adjustments(){
    
    //echo 'Yes';
    
  $this->Actions_model->update_adjustments($this->input->post(),$this->data['current_user']['id']);  
    
    echo json_encode(array('success' => 'ok'));
    
    
}
 
    
}