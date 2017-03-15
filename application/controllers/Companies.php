<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Companies extends MY_Controller {
	
    
     public $userid;
    public $jqScript;
	function __construct() 
	{
		parent::__construct();
        
          $this->userid = $this->data['current_user']['id']; 
        
        $this->jqScript =  '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>' ;
        //$this->input->get('id')
        ///$this->input->post(),$this->data['current_user']['id']
		$this->load->model('Tagging_model');
        $this->load->model('Files_model'); 
        $this->load->model('Sectors_model'); 
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
 
        
	}
	
	public function index($ajax_refresh = False) 
	{	
		$session_result = $this->session->userdata('companies');
        $this->session->unset_userdata('pipedate');
       
		$search_results_in_session = unserialize($session_result);
		$refresh_search_results = $this->session->flashdata('refresh');
		$saved_search = $this->session->userdata('saved_search_id');

		if($this->input->post('submit') and !$refresh_search_results and !$ajax_refresh and !$saved_search )
		{ 
			
			$this->clear_saved_search_from_session();
			// $this->clear_search_results();
			$this->load->library('form_validation');
			$this->form_validation->set_rules('agency_name', 'agency_name', 'xss_clean');
			$this->form_validation->set_rules('turnover_from', 'turnover_from', 'xss_clean');
			$this->form_validation->set_rules('turnover_to', 'turnover_to', 'xss_clean');
			$this->form_validation->set_rules('employees_from', 'employees_from', 'xss_clean');
			$this->form_validation->set_rules('employees_to', 'employees_to', 'xss_clean');
			$this->form_validation->set_rules('company_age_from', 'company_age_from', 'xss_clean');
			$this->form_validation->set_rules('company_age_to', 'company_age_to', 'xss_clean');
			$this->form_validation->set_rules('sectors', 'sectors', 'xss_clean');
			$this->form_validation->set_rules('providers', 'providers', 'xss_clean');
			$this->form_validation->set_rules('mortgage_from', 'anniversary_from', 'xss_clean');
			$this->form_validation->set_rules('mortgage_to', 'anniversary_to', 'xss_clean');
			$this->form_validation->set_rules('assigned', 'assigned', 'xss_clean');
			$this->form_validation->set_rules('class', 'class', 'xss_clean');
			if($this->form_validation->run())
			{	
				// Result set to session and current search 
				$this->seve_current_search($this->input->post());
				$raw_search_results = $this->Companies_model->search_companies_sql($this->input->post());
                
				
				$result = $this->process_search_result($raw_search_results);
			 
				if(empty($result))
				{
					$this->session->unset_userdata('companies');
					unset($search_results_in_session);
				}
				else
				{
					$session_result = serialize($result);
					$this->session->set_userdata('companies',$session_result);
				}
			}else{
				$this->set_message_error(validation_errors());
			}
		}
		elseif ($refresh_search_results or $ajax_refresh) 
		{
			$post = $this->session->userdata('current_search');
			foreach ($post as $key => $value) {
				$_POST[$key] = $value;
			}
			$raw_search_results = $this->Companies_model->search_companies_sql($post);


			$result = $this->process_search_result($raw_search_results);
			if(empty($result))
			{
				$this->session->unset_userdata('companies');
				unset($search_results_in_session);
			}
			else
			{
				$session_result = serialize($result);
				$this->session->set_userdata('companies',$session_result);
			}
		}
		elseif (!$this->input->post('submit') and !$search_results_in_session and !$refresh_search_results) {
			$this->session->unset_userdata('companies');
			unset($search_results_in_session);
		}
		
		$companies_array = isset($result) ? $result : $search_results_in_session;
		// if campaign exist set this variables
		$this->data['current_campaign_name'] = ($this->session->userdata('saved_search_name') ?: FALSE );
		$this->data['current_campaign_owner_id'] = ($this->session->userdata('saved_search_owner') ?: FALSE );
		$this->data['current_campaign_id'] = ($this->session->userdata('saved_search_id') ?: FALSE );
		$this->data['current_campaign_editable'] = ($this->data['current_campaign_owner_id'] == $this->get_current_user_id() ? TRUE : FALSE );
		
		$this->data['current_campaign_is_shared'] = $this->session->userdata('saved_search_shared') == 'f'? FALSE : TRUE; 
		if(empty($companies_array))
		{
			$this->session->unset_userdata('companies');
			$this->data['companies_count'] = 0;
			$this->data['page_total'] = 0;
			$this->data['current_page_number'] = 0;
			$this->data['next_page_number'] = FALSE;
			$this->data['previous_page_number'] =  FALSE;
			$this->data['companies'] = array();
		}else{
			// get companies from recent result or get it from session
			$companies_array_chunk = array_chunk($companies_array, RESULTS_PER_PAGE);
			$current_page_number = $this->input->get('page_num') ? $this->input->get('page_num') : 1;
			$this->data['companies_count'] = count($companies_array);
			$pages_count = ceil(count($companies_array)/RESULTS_PER_PAGE);
			$this->data['page_total'] = ($pages_count < 1)? 1 : $pages_count;
			$this->data['current_page_number'] = $current_page_number;
			$this->data['next_page_number'] = ($current_page_number+1) <= $this->data['page_total'] ? ($current_page_number+1) : FALSE;
			$this->data['previous_page_number'] = ($current_page_number-1) >= 0 ? ($current_page_number-1) : FALSE;
			$this->data['companies'] = $companies_array_chunk[($current_page_number-1)];
		}
        
        
         $frontend_taging_js =    asset_url().'js/fe_tagging.js';
        
        $this->data['fetagging'] =  $frontend_taging_js;
		$this->data['results_type'] = 'Saved Search';
		$this->data['edit_page'] = 'edit_saved_search';
		$this->data['main_content'] = 'companies/search_results';
		$this->data['full_container'] = True;
		$this->load->view('layouts/default_layout', $this->data);

	}
	public function _valid_name()
    {
		$result_name = $this->Companies_model->get_company_by_name($this->input->post('name'));
	
		if(empty($result_name)){
			return TRUE;
		}else{
			$this->form_validation->set_message('_valid_name', 'Company already in database with that name');
			return FALSE;
		}
	}
	public function _valid_registration()
    {
		if($this->input->post('registration')){
			$result_registration = $this->Companies_model->get_company_by_registration($this->input->post('registration'));
			if(!empty($result_registration)){
				$this->form_validation->set_message('_valid_registration', 'Company already in database with that registration');
				return FALSE;
			}
		}
		return TRUE;
	}
	public function create_company()
    {
        
		if($this->input->post('create_company_form')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('linkedin_id', 'linkedin id', 'xss_clean');
			$this->form_validation->set_rules('registration', 'registration', 'xss_clean|callback__valid_registration');
			$this->form_validation->set_rules('name', 'name', 'xss_clean|required|callback__valid_name');
			$this->form_validation->set_rules('url', 'url', 'xss_clean');
			$this->form_validation->set_rules('employees', 'employees', 'xss_clean');
			$this->form_validation->set_rules('contract', 'contract', 'xss_clean');
			$this->form_validation->set_rules('perm', 'perm', 'xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('company_class', 'company_class', 'xss_clean');
			$this->form_validation->set_rules('eff_from','eff_from','xss_clean');
			// address
			$this->form_validation->set_rules('country_id', 'country_id', 'xss_clean');
			$this->form_validation->set_rules('address', 'address', 'xss_clean'); 
            // removed required to allow pre startup w/n address
			$this->form_validation->set_rules('lat', 'latitude', 'xss_clean');
			$this->form_validation->set_rules('lng', 'longitude', 'xss_clean');
			$this->form_validation->set_rules('type', 'type', 'xss_clean');
            $this->form_validation->set_rules('trading_same_as_address', 'trading_same_as_address', 'xss_clean');

			if($this->form_validation->run())
			{
                //if($this->input->post('company_class')){   
                //}else{
                     //if(!$this->input->post('address')){ // 
                        
                        //$this->set_message_error('Error in the database while creating company');
                      //  redirect('/companies/create_company','location');
                    //} 
            //}
				$result = $this->Companies_model->create_company($this->input->post());
				if($result == TRUE) {
					$this->set_message_success('New company successfully created');
					redirect('/companies/create_company','location');
				}else{
					$this->set_message_error('Error in the database while creating company');
					redirect('/companies/create_company','location');
				}
			}else{
				$this->set_message_error(validation_errors());
				redirect('/companies/create_company','location');
			}
		}
		
		$this->data['country_options'] = $this->Companies_model->get_countries_options();
		$this->data['hide_side_nav'] = True;
		$this->data['main_content'] = 'companies/create_company';
		$this->data['full_container'] = True;
		$this->load->view('layouts/single_page_layout', $this->data);
		
	}
    
    public function  pipeline(){
        
        $this->data['hide_side_nav'] = True;
		$this->data['main_content'] = 'companies/deals_pipeline';
		$this->data['full_container'] = True;
		$this->load->view('layouts/single_page_layout', $this->data);
        
    }

	public function assignto()
	{
		if($this->input->post('company_id') && $this->input->post('user_id'))
		{
			$rows_affected = $this->Companies_model->assign_company($this->input->post('company_id'),$this->input->post('user_id'));
			if($rows_affected > 0)
			{
				// Clear search in session 
				$this->refresh_search_results();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
			else
			{
				$this->set_message_error('Error while inserting to database');
				$this->refresh_search_results();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
		}
		return True;
	}
	public function unassign()
	{
		if($this->input->post('company_id') && $this->input->post('user_id'))
		{
			$rows_affected = $this->Companies_model->unassign_company($this->input->post('company_id'));
			if($rows_affected > 0)
			{
				// Clear search in session 
				$this->refresh_search_results();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
			else
			{
				$this->set_message_error('Error while inserting to database');
				$this->refresh_search_results();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
		}
		echo json_encode(array());
	}
	
	public function company()
	{
      $getallusers =   $this->data['getallusers'] =  $this->Users_model->get_all_users($this->data['current_user']['id']);
       $this->data['currentuserid']   = $this->data['current_user']['id'];
      
     //   print_r($getallusers);
        
       // exit();
        if($this->input->get('id'))
		{
 
            $inputID = $this->input->get('id');
            
            if($inputID){
           $this->Actions_model->operations_store($inputID, $this->data['current_user']['id'], 1);
            }
            
            $company_id = array(
                   'selected_company_id'  => $this->input->get('id')
               );

                $this->session->set_userdata($company_id);
            
            //END
			$months = array();
			$currentMonth = (int)date('m');
			for ($x = $currentMonth; $x < $currentMonth + 12; $x++) {
			$monthArr[] = date('M y', mktime(0, 0, 0, $x, 1));
			}

           $deals_pipeline_statusArr  = array(0=>'Please select', 1 => 'Should Close',2 => 'Will Close'); //Move will be moved to a new array file.
			$this->load->model('Email_templates_model');
			$this->data['email_templates'] = $this->Email_templates_model->get_all();
            $raw_search_results = $this->Companies_model->search_companies_sql(FALSE,$this->input->get('id'));
            $this->data['companieshack'] = $this->Companies_model->hackmorgages($this->input->get('id'));
            $company = $this->process_search_result($raw_search_results);
            $this->data['companieshack'] = $this->Companies_model->hackmorgages($this->input->get('id'));
			$this->data['contacts'] = $this->Contacts_model->get_contacts_s($this->input->get('id'));
           // $this->data['bespoke'] = $this->Companies_model->bespoke_array();
            $address = $this->Companies_model->get_addresses($this->input->get('id'));
            
            foreach ($address as $row)
            {
                if($row->created_by){
                    $user_id =  $row->created_by; 
                break; 
                }
            }
			$this->data['addresses'] = $address;
           // $this->data['deals_pipline'] = $this->Companies_model->get_deals_pipeline($this->input->get('id'),$this->data['current_user']['id'],false);
            $this->data['campaigns'] = $this->Campaigns_model->get_campaigns($this->input->get('id'));
            $this->data['created_by_name'] = $this->Users_model->get_user($user_id);
           $this->data['bespokeSelected'] = $this->Sectors_model->bespokeSelected($this->input->get('id'));
			$option_contacts =  array();
			foreach ($this->data['contacts'] as $contact) {
				$option_contacts[$contact->id] = $contact->first_name.' '.$contact->last_name;
			}
 
             $this->data['cont_roleArray'] = array('Account Director' => 'Account Director',
'Account Manager' => 'Account Manager',
'Accountant' => 'Accountant',
'Administrator' => 'Administrator',
'Business Development Manager' => 'Business Development Manager',
'CEO' => 'CEO',
'Consultant' => 'Consultant',
'Managing Director' => 'Managing Director',
'CFO' => 'CFO',
'CTO' => 'CTO',
'Director' => 'Director',
'Financial Controller' =>'Financial Controller',
'Manager' => 'Manager',
'Marketing Manager' => 'Marketing Manager',
'Non Exec Director' => 'Non Exec Director',
'Operations Manager' => 'Operations Manager');
            
            
            $this->data['deals_pipeline_months'] = $monthArr;
            $this->data['deals_pipeline_status'] = $deals_pipeline_statusArr;
            $this->data['option_contacts'] = $option_contacts;
			$this->data['action_types_done'] = $this->Actions_model->get_action_types_done();
			$this->data['action_types_planned'] = $this->Actions_model->get_action_types_planned();
            $this->data['last_pipeline_created_at'] = $this->Actions_model->actiondata($this->input->get('id'));
			//$this->data['action_types_array'] = $this->Actions_model->get_action_types_array();
			//$this->data['actions_outstanding'] = $this->Actions_model->get_actions_outstanding($this->input->get('id'));
			//$this->data['actions_completed'] = $this->Actions_model->get_actions_completed($this->input->get('id'));
			//$this->data['actions_cancelled'] = $this->Actions_model->get_actions_cancelled($this->input->get('id'));
			//$this->data['actions_marketing'] = $this->Actions_model->get_actions_marketing($this->input->get('id'));
			//$this->data['get_actions'] = $this->Actions_model->get_actions($this->input->get('id'));
			//$this->data['comments'] = $this->Actions_model->get_comments($this->input->get('id'));
			$this->data['page_title'] = $company[0]['name'];
			$this->data['companies'] = $company;
			$this->data['hide_side_nav'] = True;
			$this->data['main_content'] = 'companies/company';
			$this->data['full_container'] = True;
            $this->load->view('layouts/single_page_layout', $this->data);
		}
		else
		{
			$this->set_message_error('No company id passed.');
			redirect('/dashboard','refresh');
		}
	}
        
    public function hackmorgages()
    {
        // this is a redunudent function
        $compohack =  $this->Companies_model->hackmorgages(346339);
    }
    
	public function edit()
	{
		

if($this->input->post('edit_company'))
		{
  
			$post = $this->input->post();
            
            //print_r($post);
			// We need to clean the post and validate the post fields *pending*
			$result = $this->Companies_model->update_details($this->input->post(),$this->data['current_user']['id']);
            
             $this->Companies_model->cronPipeline(0,$post['company_id']);
            
			$this->refresh_search_results();
			$this->set_message_success('Company Updated');
			redirect('/companies','refresh');
			return True;
		
		}
        
        
           if($this->input->post('edit_service_level'))
                    {

                        $post = $this->input->post();
                        // We need to clean the post and validate the post fields *pending*
                        $result = $this->Companies_model->add_Services_Level($this->input->post(),$this->data['current_user']['id']);
 
                       //  $this->Companies_model->cronPipeline(0,$post['company_id']);

                        $this->refresh_search_results();
                        $this->set_message_success('Company Updated');
                        redirect('/companies','refresh');
                        return True;

                    }

        
        
        
        
	}

    public function create_address()
    {
		if($this->input->post('create_address')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('country_id', 'country_id', 'xss_clean|required');
			$this->form_validation->set_rules('address', 'address', 'xss_clean|required');
			$this->form_validation->set_rules('address_types', 'address_types', 'xss_clean');
			if($this->form_validation->run())
			{
				$rows_affected = $this->Companies_model->create_address($this->input->post());


				if($rows_affected  > 0)
				{
				$this->set_message_success('Address has been added.');
					redirect('/companies/company?id='.$this->input->post('company_id'));
					// $this->refresh_search_results();
				}
				else
				{
					$array = array('error'=>'<p>Error while creating address</p>');
					$this->output->set_status_header('400');
					$this->output->set_output(json_encode($array));
				}
			}
			else
			{
				
				$array = array('error'=>validation_errors());
				$this->output->set_status_header('400');
				$this->output->set_output(json_encode($array));
			}
		}else{
			
			$array = array('error'=>'<p>Missing information on form</p>');
			$this->output->set_status_header('400');
			$this->output->set_output(json_encode($array));
		}

	}

		public function update_address()
        {
		if($this->input->post('update_address'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('address', 'address', 'xss_clean|required');
			$this->form_validation->set_rules('address_types', 'address_types', 'xss_clean|required');
			$this->form_validation->set_rules('country_id', 'country_id', 'xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			
			if($this->form_validation->run())
			{
				$rows_affected = $this->Companies_model->update_address($this->input->post());
				if($rows_affected)
				{
					$this->set_message_success('Address has been updated.');
					redirect('/companies/company?id='.$this->input->post('company_id'));
					// $this->refresh_search_results();
				}
				else
				{
					$this->set_message_error('Error while updating contact.');
					redirect('/companies/company?id='.$this->input->post('company_id'));
				}
			}
			else
			{
				
				$this->set_message_error(validation_errors());
				redirect('/companies/company?id='.$this->input->post('company_id'));
			}
		}
	}

    public function autocomplete() 
    {
        
        $callCH = false;
        $search_data = trim($this->input->post("search_data"));
		$response = "<div class='autocomplete-full-holder'><div class='col-md-6 clearfix no-padding'><ul class='autocomplete-holder'>";
       
        $search_data  = str_replace('\'', '',$search_data);
        $query = $this->Companies_model->get_autocomplete($search_data);
        
        
        $rowcount = $query->num_rows();
		if ($rowcount> 0) {
			$response= $response."<li class='autocomplete-item split-heading'><i class='fa fa-caret-square-o-down'></i> Companies</li>";
        $callCH = false;
		}
		else
		{
            
            $response= $response."<li class='autocomplete-item split-heading autocomplete-no-results'><i class='fa fa-times'></i> No Companies Found</li>";
          $callCH = true;
            
		}
        $words = array( 'Limited', 'LIMITED', 'LTD','ltd','Ltd' );
        foreach ($query->result() as $row):
        	if(!empty($row->user)) { 
        		$user_icon = explode(",", $row->image);
        		$assigned_label = " <span class='label label-primary pull-right' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$row->user."</span>";} else {$assigned_label="";};

		if($row->active=='f') { 
		$response= $response."<li class='autocomplete-item autocomplete-company inactive'><strong>" . str_replace($words, ' ',$row->name). "</strong><div style='min-height:14px'><small>Company no longer active.<span class='label label-danger pull-right'>Inactive</span></small></div></li>";} 

		else {$response= $response."<a href='". base_url() . "companies/company?id=" . $row->id . "'><li class='autocomplete-item autocomplete-company'><strong>" . str_replace($words, ' ',$row->name). "</strong><div style='min-height:14px'><small>".$row->pipeline." ".$assigned_label."</small></div></li></a>";};
	
        	 
		
         //$callCH = false;
        endforeach;
        $response= $response."</ul></div>";
        $response= $response."<div class='col-md-6 no-padding'><ul class='autocomplete-holder'>";

		$query = $this->Companies_model->get_autocomplete_contact($search_data);

		$rowcount = $query->num_rows();
		if ($rowcount> 0) {
			$response= $response."<li class='autocomplete-item split-heading'><i class='fa fa-caret-square-o-down'></i> Contacts</li>";
           $callCH = false;
		} else{
			$response= $response."<li class='autocomplete-item split-heading autocomplete-no-results'><i class='fa fa-times'></i> No Contacts Found</li>";
          
		}
        
     
 		foreach ($query->result() as $row):
 					if($row->companyactive=='f') { 
 						 $response= $response."<li class='autocomplete-item autocomplete-contact inactive'><strong>" . str_replace($words, ' ',$row->name). "</strong><br><small>".$row->company_name."</small><br><small>Company no longer active.<span class='label label-danger pull-right'>Inactive</span></small></li>";}

else {
            $response= $response."<a href='". base_url() . "companies/company?id=" . $row->id . "#contacts'><li class='autocomplete-item autocomplete-contact'><strong>" . str_replace($words, ' ',$row->name). "</strong><br><small>".$row->company_name."</small></li></a>";};
           //
        endforeach;
        $response= $response."</ul></div>";
        $this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('html'=> $response, 'callCH'=> $callCH))); //callCH = return true or false (default) call company house function
       // $responsed=  $this->getCompanyHouseDetails(08245800);
    }
    	public function getCompany() 
        {
            header('Content-Type : application/json');
            $obj = json_decode($_POST);
            $output = array(
                'registration' => $_POST['registration'],
                'user_id' => $_POST['user_id'],
                'company_type' => $_POST['company_type']   
                
            );
            
            if($this->input->post('postal_code')){  

                $this->load->library('form_validation');
                $this->form_validation->set_rules('registration', 'registration', 'xss_clean');
                $this->form_validation->set_rules('name', 'name', 'xss_clean|required');
                $this->form_validation->set_rules('address', 'address', 'xss_clean|required');
                $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
                $this->form_validation->set_rules('company_type', 'company_type', 'xss_clean|required'); 
                $this->form_validation->set_rules('date_of_creation', 'date_of_creation', 'xss_clean|required');
                $rows_affected = $this->Companies_model->create_company_from_CH($this->input->post(),$this->data['current_user']['id']);

                if($rows_affected)
                {
                    if(is_array($rows_affected)){
                        
                        echo  json_encode(array('status' => 200, 'message' => $rows_affected['row_id']));
                        
                     exit();
                    }
                    
                       // file_put_contents('apitext.txt', 'Initial stage two'.PHP_EOL, FILE_APPEND);            
                        $chargesResponse = $this->getCompanyHouseCharges($this->input->post('registration'));

                        //file_put_contents('apitext.txt', 'This has ran retured a $chargesResponse condition bbb:'.$rows_affected, FILE_APPEND); 

                        if($chargesResponse){      
                         //   file_put_contents('apitext.txt', 'Initial stage three'.PHP_EOL, FILE_APPEND); 
                            $this->Companies_model->insert_charges_CH($chargesResponse,$rows_affected,$this->data['current_user']['id']);  

    
                        }
                            echo json_encode(array('status' => 200, 'message' => $rows_affected));
                    }else{
                              echo json_encode(array('status' =>202, 'message' => 'Something went wrong'));
                   
                }
            }
             
        }
    
    public function getCompanyHouseCharges($id)
    { 
       $response =  $this->getCompanyHouseChargesApi($id);
      
       if($response['items'][0]['status'] == 'outstanding'){
            return $response;
       } 
 
    }
    
    public function getCompanyHouseDetails($id = 0) 
	{
          
            $words = array(' ', '&#39\;', '\'', '  ',  ' \'');
            $id = str_replace($words, '', trim($id));
     
            $server_output = array();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.companieshouse.gov.uk/search/companies?q=".$id);
            curl_setopt($ch, CURLOPT_GET, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $headers = array();
            $headers[] = 'Authorization: Basic RWFpN0V2N0JOSk1wcDlkcThUTWxkdHZzOXBDSzRTdmt0UGpzVjduWDo=';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             $server_output = curl_exec ($ch);
               
             return   json_encode($server_output);
            curl_close ($ch);  
    }
    
    public function getCompanyHouseChargesApi($id = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.companieshouse.gov.uk/company/".$id."/charges");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json;',
            'Authorization: Basic RWFpN0V2N0JOSk1wcDlkcThUTWxkdHZzOXBDSzRTdmt0UGpzVjduWDo=' 

          ]
        );

        $result = curl_exec($ch);
        // Check for errors
        if($result === FALSE){

          die(curl_errno($ch).': '.curl_error($ch));
        }

        return json_decode($result,TRUE);
        
    }
    
    public function dragupdate()
    {
        $post =  $this->input->post();    
        $user = $this->data['current_user']['id'];
        $pipeline = $this->Companies_model->update_pipline_from_drag_and_drop($post,$user);

        echo $pipeline;
        
    }
    
    public function drag()
    {
				$pipeline = $this->Companies_model->get_pipline_deals();
        
        echo json_encode($pipeline);
    }    
    
    //TAGGING

   function _index()
{
      $call_taggin_js_file =    asset_url().'js/tagging.js';
   //echo file_exists(base_url().'assets/tagging.js');
       $this->data['test'] =   $call_taggin_js_file ;
       $this->data['jq'] = $this->jqScript;
       $this->data['so'] =  $this->Tagging_model->add_category();
       	$this->data['main_content'] = 'tagging/home';
		$this->load->view('layouts/default_layout', $this->data);	
       
}	
    
    //Add Categories
    public function tag_categories($route =false)
    {
    if (!$current_user['permission'] == 'admin'){
        exit('wrong access permission ');
    } 
        if($this->input->post() != NULL){
            
            $this->form_validation->set_rules('name', 'Name', 'required');
            
            $rap = $this->input->post();
            header('Content-Type: application/json');
            $name = $this->input->post('name'); 
            $eff_from = $this->input->post('eff_from');
            $eff_to = $this->input->post('eff_to');
            
            $master_cat_id =  $this->input->post('masterID')?  $this->input->post('itemid') : ''; 
            
            $msg = false;
            $checkEffTo =true;
            
            if($route != 'addTag') {
            $checkName = $this->Tagging_model->checkCategoryName($name,$master_cat_id);
            }else{
                $checkName = $this->Tagging_model->checkTagName($name,$master_cat_id);
            }
            $checkEffFrom = $this->Tagging_model->check_if_date_in_past(date('Y-m-d',strtotime($this->input->post('eff_from'))));
            
            if($eff_to){
             $checkEffTo = $this->Tagging_model->check_if_date_in_past(date('Y-m-d',strtotime($this->input->post('eff_to'))));
            }
            
            //Codeignighter does not support pre date check validation
           
           
              if(!$name){
                 $msg['catName'] = 'This field is required!';
            } 
           
             if(!$this->input->post('eff_from')){
                    $msg['eff_from'] = 'This field is required!';
                }
            
            if(!$route){
                $msg['missing_action'] = $route;
            } 
            
            if($route != 'edit'){
                if(!$checkName){
                     $msg['catName'] = 'This name is already taken!';
                } 

                if(!$checkEffFrom){
                    $msg['eff_from'] = 'dates cannot be set in the past';
                }

                if(isset( $checkEffTo)){
                if(!$checkEffTo){
                    $msg['eff_to'] = 'dates cannot be set in the past';
                } }
                
            }
    
            if(!$msg ){
               
                if($route == 'create') { 
                    $this->Tagging_model->add_category($this->input->post(),$this->userid); 
                }
                if($route == 'edit') {
                    $this->Tagging_model->update_category($this->input->post(),$this->userid); 
                }
                 if($route == 'sub') {
                    $this->Tagging_model->create_sub($this->input->post(),$this->userid); 
                }
                 if($route == 'addTag') {
                    $this->Tagging_model->add_tag($this->input->post(),$this->userid); 
                }
                if($route == 'editTag') {
                    $this->Tagging_model->edit_tag($this->input->post(),$this->userid); 
                }
                
                 if($route == 'deleteTag') {
                    $this->Tagging_model->delete_tag($this->input->post(),$this->userid); 
                }
                
                    echo json_encode(array('success' =>$rap ));         
             }else{
                    echo json_encode(array('error' =>$msg )); 
             }
            
              exit();
		}
            
        
            $call_taggin_js_file =    asset_url().'js/tagging.js';
            //echo file_exists(base_url().'assets/tagging.js');
            $this->data['jq'] =  $this->jqScript;
            $this->data['test'] =   $call_taggin_js_file ;
            $post= array();
            $post['userID'] = $this->userid;
            if($route){
            //echo $this->Tagging_model->$route($post);
            }
            $this->data['main_content'] = 'tagging/categories';
            $this->load->view('layouts/default_layout', $this->data);  
        
    }
    
   
    
    public function tags($route,$post)
    {

    $post= array();
    $post['userID'] = $this->userid;

    $this->data['main_content'] = 'tagging/tags';
    $this->load->view('layouts/default_layout', $this->data); 
    
    }

public function contacts($post,$route)
{
$post= array();
$post['userID'] = $this->userid;

echo $this->Tagging_model->$route($post); 
}
    
    public function distroy($id)
    {
       
     echo $this->Tagging_model->delete_tag($id); 
    }
    
    
 function test($id =false)
 {
     //echo 'Glen';
    echo  $this->Tagging_model->show_category($id);
     
 }
    
    
    function gettags($id)
    {
        //Get main tag listing
        echo  $this->Tagging_model->getEditTags($id); 
        
    }
    
    function showtags($id)
    {
        
        echo  $this->Tagging_model->show_tag($id); 
          
    }
     function tag_cat($id =false){ //loads tag category: used to get tab headers
     
     echo  $this->Tagging_model->show_category($id);
     
 }
    
    function fe_tag_index()
    {
        
             $frontend_taging_js =    asset_url().'js/fe_tagging.js';
        
        $this->data['fetagging'] =  $frontend_taging_js;
         $this->data['main_content'] = 'tagging/test';
        $this->load->view('layouts/default_layout', $this->data); 
        
    }
    
    function fe_read_tag()
    {
       
        echo   $this->Tagging_model->feReadTag();
        
       
        
    }
    
    function fe_read_cat()
    {
       
        echo   $this->Tagging_model->fegetcategories();
        
    }
  function fe_get_tag()
    {
       
        echo   $this->Tagging_model->fegettags($this->input->post(), $this->userid);
        
    }
    function fe_add_tag()
    {
        echo    $this->Tagging_model->feAddTag($this->input->post(), $this->userid);  
    }
    
    function fe_delete_tag()
    {
        
       echo  $this->Tagging_model->feDeleteTag($this->input->post(), $this->userid);
        
        
    }    
    
    // NEW AJAX/JSON ACTIONS FUNCTIONS
       public function autopilotActions($id =154537){
        
           
        $id = $this->session->userdata('selected_company_id');
           
           
        header('Content-Type: application/json');
       
        $marketing_events  = (array)$this->Actions_model->get_actions_marketing($id);
    
        echo json_encode($marketing_events);
    }
    
    function getAction($id = 154537 ){
        
         //$id = $this->session->userdata('selected_company_id');
        //$query[]['actions'] = $this->Actions_model->get_actions(154537); //$this->input->get('id')
        $query[]['actions_outstanding'] = $this->Actions_model->get_actions_outstanding($id);
    
        $query[]['action_types_array'] = (array)$this->Actions_model->get_action_types_array();
            $query[]['actions_completed'] = $this->Actions_model->get_actions_completed($id);
        $query[]['actions_cancelled'] = $this->Actions_model->get_actions_cancelled($id);
            $query['files'] = $this->Actions_model->get_actions_files($id);
       // $query[]['comments'] = array_reverse($this->Actions_model->get_comments_two($id));
        
        foreach($query  as $key => $value){
            
                $action[][] = $value; 
        }
        if($query[0]['actions_completed'][0]->initial_rate){
            $action['initial_rate'] = $query[0]['actions_completed'][0]->initial_rate;
        }
        
         //$action['initial_fee']['initial_rate']  =  ($initial_rate/100);
        // echo '<pre>'; print_r($action); echo '</pre>';
        header('Content-Type: application/json');
       echo json_encode($action);
 
    }
    
    function getActionArray($id = 355634 ){
        
        $query[]['actions_outstanding'] = $this->Actions_model->get_actions_outstanding($id);
        $query[]['action_types_array'] = (array)$this->Actions_model->get_action_types_array();
        $query[]['actions_completed'] = $this->Actions_model->get_actions_completed($id);
        $query[]['actions_cancelled'] = $this->Actions_model->get_actions_cancelled($id);
        //$query[]['files'] = $this->Actions_model->get_actions_files($id);
      //  $query[]['comments'] = array_reverse($this->Actions_model->get_comments_two($id));
        
        foreach($query  as $key => $value){
            
                $action[][] = $value; 
        }
        if($query[0]['actions_completed'][0]->initial_rate){
            $action['initial_rate'] = $query[0]['actions_completed'][0]->initial_rate;
        }


         //$action['initial_fee']['initial_rate']  =  ($initial_rate/100);
      echo '<pre>'; print_r($action); echo '</pre>';
        header('Content-Type: application/json');
        //echo json_encode($action);
 
    }
    
    
    function getCompletedActions($id = 154537)
    {
        
        //$id = $this->session->userdata('selected_company_id');
        $actions =  $this->Actions_model->get_follow_up_actions($id);
        echo json_encode($actions);  
    }
    
    
        function campaign_page_getter()
        {


            $company_id = $this->input->post('company_id');


            $campaign_id = $this->input->post('campaign_id');

            // $company_id = $this->input->post('company_id');

            $campaign = $this->Campaigns_model->get_campaign_by_id($campaign_id);


        //print_r($campaign);


            if ($campaign[0]->id == False) {
                print_r('No campaign');
                return False;
            }
            $pipeline = $this->input->get('pipeline');
            $companies = $this->Campaigns_model->get_companies_for_campaign_id($campaign_id,$pipeline);
            // print '<pre>';
            // print_r($companies);
            // die;	
            $this->refresh_search_results();
            $this->session->set_userdata('campaign_id',$campaign[0]->id);
            $this->session->set_userdata('campaign_name',$campaign[0]->name);
            $this->session->set_userdata('campaign_owner',$campaign[0]->user_id);
            $this->session->set_userdata('campaign_shared',$campaign[0]->shared);
            $this->session->unset_userdata('current_search');

            $result = $this->process_search_result($companies);

        //print_r($result);


            if(empty($result))
            {

               $this->session->unset_userdata('companies');
                unset($search_results_in_session);
            }
            else
            {

                    foreach($result as $item => $value){
                    // echo $value['id'];
                    $dt =     $this->data['last_pipeline_created_at'] = $this->Actions_model->actiondata($value['id']);
                    $dta[] = array('id' => $value['id'], 'last_pipeline_date' =>  $dt );      

                    }

                $this->session->set_userdata('pipedate',$dta);
                $session_result = serialize($result);
                $this->session->set_userdata('pipeline',$pipeline);
                $this->session->set_userdata('companies',$session_result);
            }

/*
        $session_result = $this->session->userdata('companies');
            $search_results_in_session = unserialize($session_result);
            $campaign = $this->session->userdata('campaign_id');
            $companies_array = $search_results_in_session;
            // if campaign exist set this variables
                // get companies from recent result or get it from session
                $companies_array_chunk = array_chunk($companies_array, RESULTS_PER_PAGE);
                $current_page_number = $this->input->get('page_num') ? $this->input->get('page_num') : 1;
                $pages_count = ceil(count($companies_array)/RESULTS_PER_PAGE);
                //$prev = array();

                */
                $i = 0 ;
                    foreach($result as $key=>$item){
                           // echo $i;
                        if($i ==1){
                            $data['NextId'] = $item['id'];
                        $i = 0;

                        }
                        if($item['id'] == $company_id){
                            $data['Current'] = $item['id'];
                            $data['Previous'] = $prev;
                            $i = 1;
                        }
                            $prev = $item['id'];

            }
                            echo json_encode($data);
                     //echo '<pre>'; print_r($data); echo '</pre>';
                    //echo '<pre>'; print_r($companies_array_chunk[($current_page_number-1)]); echo '</pre>';
                    //exit();

        }
    
        function pipert()
        {


                $this->data['main_content'] = 'companies/editor';
            $this->load->view('layouts/default_layout', $this->data);	

        }
    
  
        public function notForInvoices()
        {

            $rap = $this->input->post();

           $this->get_current_user_id();



         $output =  $this->Companies_model->update_not_for_invoices($rap,$this->get_current_user_id());


            //echo $rap['debenturemortgage'] ? 'Yes': 'Nooooo';
            if($output ){

              echo json_encode(array('success' =>$rap['providerid'], 'debenturemortgage' => $rap['debenturemortgage']));  
            }else{
                 echo json_encode(array('error' =>$rap['providerid']));  
            }
            //echo json_encode(array('glen' =>$rap, 'userid' =>  $this->get_current_user_id()));


        }
    
        function recent()
        { //recently visited pages

                $query = $this->db->query("SELECT DISTINCT v.created_at,c.id as company,  c.name as name FROM views v 
                LEFT JOIN companies c
                ON v.company_id = c.id 
                WHERE v.user_id = 3
                GROUP BY c.id,v.created_at
                ORDER BY v.created_at DESC");
                        $i=0;
                        foreach ($query->result_array() as $row)
                        {
                            $comlist[$row['company']] =  $row['name'];

                             if(count($comlist)=== 15)   break;
                        }

                //print '<pre>';
                  // print_r($comlist);
                    //print '</pre>';

        }
       
        function real()
        {

           $this->Companies_model->cronPipeline(0,335504);   
        }
    
    
    
        function findTime(){

            $query = $this->db->query("SELECT * FROM actions WHERE company_id=109673 AND action_type_id=32 order by updated_at DESC LIMIT 1");
            $now = time(); // or your date as well
            foreach ($query->result_array() as $row)
            {

            //echo date( 'Y-m-d' , strtotime($row['created_at'])).'<br>';

            $your_date =  strtotime($row['created_at']);
            }

            $datediff = $now - $your_date;

            echo floor($datediff / (60 * 60 * 24));

        }

    
      function querychecker()
      {   
 
        if(isset($_SERVER['SERVER_PORT'])){     

            //echo 'Current full'.  site_url();
                if($_SERVER['SERVER_PORT'] == 80){ // server =  80 localhost =  8888
                    // server =  80 localhost =  8888)

                    $a =  str_replace('http://','https://', site_url());

                    echo 'Current full'. site_url().$_SERVER['REQUEST_URI'];

                    echo '<br>';
                    $mystring = current_full_url();

                    $findme   = 'https://';
                    $pos = strpos($mystring, $findme);

                    // Note our use of ===.  Simply == would not work as expected
                    // because the position of 'a' was the 0th (first) character.
                    if ($pos === false) {
                        echo "The string '$findme' was not found in the string '$mystring'";

                        redirect($a, 'location');
                    //   header( 'Location: '.$a ) ;
                } else {        
                    echo "The string '$findme' was found in the string '$mystring'";
                    echo " and exists at position $pos";
                }
            }

        }
  
    }
    
    
    function downloadking($sha)
    {

        $this->load->helper('download');
        $this->load->helper('MY_azurefile');
        $encyption_file_name  = $this->Files_model->getfile_($sha);
        $fileExt    =   explode('.',$encyption_file_name[0]['file_location']);
        $nme =  str_replace(' ','_', trim($encyption_file_name[0]['name'].'.'.$fileExt[1]));
        $src  =  file_get_contents('https://baselisttemp.blob.core.windows.net/baselisttemp/'.$encyption_file_name[0]['file_location']);

        force_download($nme, $src);  
     
    }
    
    
    
    function filetester($id = 352533){
        //line 158
        $query[]['files'] = $this->Actions_model->get_actions_files($id);
        foreach($query  as $key => $value){

        $action[][] = $value; 
        }

        echo '<pre>'; print_r($action); echo '</pre>';

    }
    
    
function deleteTest_(){
    
    
    $bsp = $this->bespoke_array();
$i =56;
foreach($bsp as $ky=>$value){
    
    
    echo $i++.'<br>';
    
    
   $data = array(
       'id' => $i,
      'name' => $value,
      'display' => TRUE ,
      'created_at' => date('Y-m-d H:i:s'),
       'updated_at' => date('Y-m-d H:i:s'),
       'created_by' => 1,
       'updated_by' => 1,
       'target' => TRUE,
       'sector_group' => 1
   );
   
   $this->db->insert('sectors', $data);
   
}
    

}
     function bespoke_array()
	{
		$bespokeArr = array(
	'Timesheets issued on behalf of agency'  => 'Timesheets issued on behalf of agency',
	'Full Breakdown of Timesheets'  => 'Full Breakdown of Timesheets',
	'Placements Reworked'  => 'Placements Reworked',
	'Agency Specific Contracts Used'  => 'Agency Specific Contracts Used',
	'Unusual Approvals Process?'  => 'Unusual Approvals Process?',
	'External System Used for Timesheets'  => 'External System Used for Timesheets',
	'Mixture of Payment Terms?'  => 'Mixture of Payment Terms?',
	'Mon AM Timesheet Report'  => 'Mon AM Timesheet Report',
	'Tues AM Timesheet Report'  => 'Tues AM Timesheet Report',
	'Tue PM Timesheet Report'  => 'Tue PM Timesheet Report',
	'Wed AM Self Bill emailed report'  => 'Wed AM Self Bill emailed report',
	'Wed Client Invoice Report'  => 'Wed Client Invoice Report',
	'Timesheet report week before and week after month end'  => 'Timesheet report week before and week after month end',
	'Wed timesheet deadline'  => 'Wed timesheet deadline',
	'External System Used for Invoicing/ Self Bills'  => 'External System Used for Invoicing/ Self Bills',
	'Monthly Payments Outside Payrun'  => 'Monthly Payments Outside Payrun',
	'Commission Report'  => 'Commission Report',
	'Debt Management Report'  => 'Debt Management Report',
	'Advances on demand'  => 'Advances on demand',
	'CONSTRUCTION INDUSTRY?'  => 'CONSTRUCTION INDUSTRY?'
);

		return 	$bespokeArr;
	}
    
}
 