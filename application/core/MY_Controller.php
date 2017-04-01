<?php header( 'X-Frame-Options: DENY' );
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	protected $current_user = ""; // Logged in user
	protected $data = array(); // Data array to be passed to views
	var $url;

	  
		
	public function __construct() {	

		parent::__construct();
        
    	try {
			$url = getHttpsUrl($_SERVER['HTTP_X_FORWARDED_PROTO'], current_url());
			redirect($url, 'location');
		} catch (Exception $e) {
			// Do nothing
		}
        
		set_time_limit(6000); 
		ini_set("memory_limit", -1);
		
		// Debugging funcionality, set it only when on development 
		switch (ENVIRONMENT) {
		case 'development':
		        $this->output->enable_profiler(FALSE);
		break;
		case 'staging':
		        $this->output->enable_profiler(FALSE);  
		break;
		case 'production':
				$this->output->enable_profiler(FALSE);  
		break;

		default:
		        // $config['s3_bucket'] = 'mybucket_production';
		break;
		}

		// Check Browser
		$this->load->library('user_agent');

		
		// Load User model for all the controllers
		$this->load->model('Campaigns_model');
		$this->load->model('Sectors_model');
		$this->load->model('Users_model');
		$this->load->model('Providers_model');
		$this->load->model('Actions_model');
		$this->load->model('Companies_model');
		$this->load->model('Contacts_model');
		$this->load->model('Tagging_model');
		$this->data['pending_actions'] = $this->Actions_model->get_pending_actions($this->get_current_user_id());
        
        
        
        
        
                if(isset($_SERVER['SERVER_PORT'])){
          
          //echo 'Current full'.  site_url();
         
    
     
      }
        
        
        
        
        
        	if($_GET['id'] && (!$this->session->userdata('logged_in'))) 
		{
                   $string = current_full_url();
         
   
        
          //$string =  'http://localhost:8888/baselist/companies/company?id=112170';
            //$string current_full_url();    
                
                   $cookie = array(
                    'name'   => 'lastpagevisited',
                    'value'  => $string,
                    'expire' =>  (86400 * 30),
                    'secure' => false
                    );

                    $this->input->set_cookie($cookie);
                
                
            }else{
                
                
                
                
                
                
            }
     
		// $this->load->helper('mobile');
		
		// loging checking and redirect
		// try getting logged in user from session
		if($this->session->userdata('logged_in')) 
		{
			$logged_in = $this->session->userdata('logged_in');
            $logged_in_user_details  = $this->Users_model->get_user($logged_in['user_id']);
			$this->data['current_user'] = $logged_in_user_details;
			$this->session->unset_userdata('last_page');	
		}
		else
		{
			//user not in session and segment 1 exist then redirect to login
			if($this->uri->segment(1)){
				//$this->session->set_userdata('last_page', current_full_url());
 $gotUrlAfterLogin   =$this->input->cookie('lastpagevisited', TRUE) ?  $this->input->cookie('lastpagevisited', TRUE) : current_full_url();

                $this->session->set_userdata('last_page', $gotUrlAfterLogin);
				redirect('/','location');
			}
		}

        // session data only test for positve so be careful with the if stataments


		if($this->session->userdata('sectors_search'))
		{	
			$sectors_search = $this->session->userdata('sectors_search');
			$sectors_list = $this->session->userdata('sectors_list');
		}
		else
		{
			$sectors_search = $this->Sectors_model->get_all_for_search();
			$sectors_list = $this->Sectors_model->get_all();
			// asort($sectors_options);
			$this->session->set_userdata('sectors_list',$sectors_list);
			$this->session->set_userdata('sectors_search',$sectors_search);
		}

				if($this->session->userdata('sectors_targets'))
		{
			$sectors_targets = $this->session->userdata('sectors_targets');
		}
		else
		{
			$sectors_targets = $this->Sectors_model->get_all_target_in_array();
			asort($sectors_targets);
			$this->session->set_userdata('sectors_targets',$sectors_targets);
		}
		//TARGET SECTORS
		if($this->session->userdata('target_sectors_list'))
		{	
			$target_sectors_list = $this->session->userdata('target_sectors_list');
			$not_target_sectors_list = $this->session->userdata('not_target_sectors_list');
            $bespoke_target_sectors_list = $this->session->userdata('bespoke_target_sectors_list');

		}
		else
		{
			$target_sectors_list = $this->Sectors_model->get_all_target();
			$this->session->set_userdata('target_sectors_list',$target_sectors_list);
            $bespoke_target_sectors_list = $this->Sectors_model->get_bespoke_target();
			$this->session->set_userdata('bespoke_target_sectors_list',$bespoke_target_sectors_list);
			$not_target_sectors_list = $this->Sectors_model->get_all_not_target();
			$this->session->set_userdata('not_target_sectors_list',$not_target_sectors_list);
		}

		
		if($this->session->userdata('providers_options'))
		{
			$providers_options = $this->session->userdata('providers_options');
		}
		else
		{
			$providers_options = $this->Providers_model->get_all_in_array();
			asort($providers_options);
			$this->session->set_userdata('providers_options',$providers_options);
		}

		if($this->session->userdata('providers_options_top'))
		{
			$providers_options_top = $this->session->userdata('providers_options_top');
		}
		else
		{
			$providers_options_top = $this->Providers_model->get_top_10_in_array();
			asort($providers_options_top);
			$this->session->set_userdata('providers_options_top',$providers_options_top);
		}
 		// $this->session->unset_userdata('system_users');
		if($this->session->userdata('system_users'))
		{
			$system_users = $this->session->userdata('system_users');
			$this->data['system_users_images'] = $this->session->userdata('system_users_images');
		}
		else
		{
			$system_users = $this->Users_model->get_users_for_select();
			$this->session->set_userdata('system_users',$system_users['users']);
			$this->session->set_userdata('system_users_images',$system_users['images']);
		}

		if($this->session->userdata('sales_users'))
		{
			$sales_users = $this->session->userdata('sales_users');
		}
		else
		{
			$sales_users = $this->Users_model->get_sales_users_for_select();
			$this->session->set_userdata('sales_users',$sales_users['users']);
		}

		// SET CONSTANTS AND DEFAULTS
		if ($this->input->post('new_search')){
			// print('clearing');
			$this->clear_campaign_from_session();
			$this->clear_saved_search_from_session();
			unset($_POST['new_search']);
		}
		// Keep post data on the search , either get it from post or from sessins
		if($this->session->userdata('current_search') and !$this->input->post('main_search') and ($this->uri->segment(1) !== 'dashboard'))
		{

			$post = $this->session->userdata('current_search');
			foreach ($post as $key => $value) {
				$_POST[$key] = $value;
			}
		}
		
		if($this->session->userdata('companies_classes'))
		{
			$class_options = $this->session->userdata('companies_classes');
		}else
		{
			$class_options = $this->Companies_model->get_companies_classes();
			$this->session->set_userdata('companies_classes',$class_options);
		}

		if($this->session->userdata('companies_pipeline'))
		{
			$pipeline_options = $this->session->userdata('companies_pipeline');
		}else
		{
			$pipeline_options = $this->Companies_model->get_companies_pipeline();
			$this->session->set_userdata('companies_pipeline',$pipeline_options);
		}

		if($this->session->userdata('address_types'))
		{
			$address_types = $this->session->userdata('address_types');
		}else
		{
			$address_types = $this->Companies_model->get_address_types();
			$this->session->set_userdata('address_types',$address_types);
		}

		if($this->session->userdata('get_pipeline_show_source'))
		{
			$show_sources = $this->session->userdata('get_pipeline_show_source');
		}else
		{
			$show_sources = $this->Companies_model->get_pipeline_show_source();
			$this->session->set_userdata('get_pipeline_show_source',$show_sources);
		}
		if($this->session->userdata('companies_pipeline_search'))
		{
			$pipeline_options_search = $this->session->userdata('companies_pipeline_search');
		}else
		{
			$pipeline_options_search = $this->Companies_model->get_companies_pipeline_search();
			$this->session->set_userdata('companies_pipeline_search',$pipeline_options_search);
		}
		if($this->session->userdata('contact_titles'))
		{
			$title_options = $this->session->userdata('contact_titles');
		}else
		{
			$title_options = $this->Contacts_model->get_contact_titles();
			$this->session->set_userdata('contact_titles',$title_options);
		}


		// Pass variables to template views 
		$this->data['companies_classes'] = array(NULL=>'--- Select Class ---') + $class_options;
		$this->data['companies_pipeline'] =  array(NULL=>'--- Select Pipeline ---') + $pipeline_options;		
		$this->data['address_types'] =  $address_types;
		$this->data['country_options'] = $this->Companies_model->get_countries_options();
		$this->data['company_sources'] =  array(0=> '--- Select a Source ---') + $this->Companies_model->get_company_sources();
		$this->data['show_sources'] =  $show_sources;



		// Pipeline
		// edit box options 
		$this->data['sectors_list'] = $sectors_list;
		$this->data['target_sectors_list'] = $target_sectors_list;
		$this->data['not_target_sectors_list'] = $not_target_sectors_list;
        $this->data['bespoke_target_sectors_list'] = $bespoke_target_sectors_list;

		// Add options 
		$system_users = array(0=>'All') + $system_users;
		$this->data['system_users'] = array(-1=>'Not Set as Favourite') + $system_users;
		$this->data['assigned_default'] = '0';
		if($sectors_search){
			$sectors_search = array(-1=>'All Target Sectors',0=>'Any') +  $sectors_search;
		}

		$sales_users = array(0=>'All') + $sales_users;
		$this->data['sales_users'] = array(-1=>'Not Set as Favourite') + $sales_users;
		$this->data['assigned_default'] = '0';
		if($sectors_search){
			$sectors_search = array(-1=>'All Target Sectors',0=>'Any') +  $sectors_search;
		}
		
		
		// $sectors_options = array(-1=>'No sectors') + $sectors_options;
		$this->data['sectors_search'] = $sectors_search;
		$this->data['sectors_default'] ='0';
		
		$this->data['class_options'] = array(0=>'All') + $class_options;
 
            switch ($logged_in_user_details['market']){
                case 'np':
                    $class_default = 'FF';
                    break;
                case "uf":
                    $class_default = 'Using Finance';
                    break;	
               default :
                    $class_default = '0';


            }

        $this->data['class_default'] =$class_default;

		$this->data['pipeline_options'] = array(0 => 'All') + $pipeline_options_search;
		$this->data['pipeline_default'] ='0';

		$this->data['title_options'] = array(NULL=>'--') +  $title_options;
		$this->data['pipeline_default'] =NULL;




		//$providers_options = array(-1=>'No current provider') + $providers_options_top + $providers_options;
		//$providers_options = array(0=>'All') + $providers_options;
		$providers_options = array(
			'With / Without Mortgage' => array(
			'-2'  => 'Has provider',
        	'-1'  => 'No current provider',
            '0'  => 'All'),
			'Top 10 Providers' => $providers_options_top,
      		'All Providers' => $providers_options
      		);
		$this->data['providers_options'] = $providers_options;
		$this->data['providers_default'] ='0';

		$this->data['exclude_options'] = array(
			' ' => 'All',
			'include'=>'Include',
			'exclude'=>'Exclude'
			);	
		// CAMPAIGN TABLE WITH CRITERIA FIELDS
		//$this->data['shared_searches'] = $this->Campaigns_model->get_all_shared_searches($this->get_current_user_id());
		//$this->data['private_searches'] = $this->Campaigns_model->get_all_private_searches($this->get_current_user_id());

		// CAMPAIGN TABLE WITHOUT CRITERIA FIELDS
		$this->data['shared_campaigns'] = $this->Campaigns_model->get_all_shared_campaigns($this->get_current_user_id());
		//$this->data['private_campaigns'] = $this->Campaigns_model->get_all_private_campaigns($this->get_current_user_id());
		
		//var_dump($this->session->userdata('campaign_shared'));
		// var_dump($this->data['own_campaigns']);
		//var_dump($this->session->all_userdata());
		// var_dump($this->input->post());

		

	}

	protected function add_notification($message,$url)
	{	
		$notifications = array();
		$notifications = $this->session->userdata('notifications');
		$notifications[] = array('message'=>$message,'url' => $url,'date'=> date('Y-m-d H:i:s'));
		$this->session->set_userdata('notifications',$notifications);
	}
	
	protected function clear_saved_search_from_session(){
		$this->session->unset_userdata('saved_search_name');
		$this->session->unset_userdata('saved_search_owner');
		$this->session->unset_userdata('saved_search_id');
		$this->session->unset_userdata('current_saved_search_owner_id');
		$this->session->unset_userdata('saved_search_shared');
		$this->session->unset_userdata('current_search');
	}

	protected function clear_campaign_from_session()
	{
		$this->session->unset_userdata('campaign_name');
		$this->session->unset_userdata('campaign_owner');
		$this->session->unset_userdata('campaign_id');
		$this->session->unset_userdata('current_campaign_owner_id');
		$this->session->unset_userdata('campaign_shared');
		$this->session->unset_userdata('current_search');
	}
	protected function seve_current_search($post)
	{
		$this->session->set_userdata('current_search',$post);
	}

	protected function get_current_user_id()
	{
		$session = $this->session->userdata('logged_in');
		return $session['user_id'];
	}

	protected function get_current_search()
	{
		return $this->session->userdata('current_search');
	}

	protected function refresh_search_results()
	{
		$this->session->set_flashdata('refresh', TRUE);
	}

	protected function set_message_success($message)
	{
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', 'success');
	}

	protected function set_message_info($message)
	{
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', 'info');
	}

	protected function set_message_warning($message)
	{
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', 'warning');
	}

	protected function set_message_action_error($message)
	{
		$this->session->set_flashdata('message_action', $message);
		$this->session->set_flashdata('message_type', 'danger');
	}

	protected function set_message_error($message)
	{
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', 'danger');
	}
	
	protected function clear_search_results()
	{
		$this->session->unset_userdata('companies');
		$this->session->unset_userdata('current_search');
	}

	protected function process_search_result($raw_search_results){
		 // print_r($raw_search_results[0]['json_agg']);
		
		$companies_json = json_decode($raw_search_results[0]['json_agg']);

		if(empty($companies_json )) return false;

		$companies_array = array();
		foreach ($companies_json as $company) {
			$mapped_companies_array = array();
			if($company->company->f1->f1)$mapped_companies_array['id'] = $company->company->f1->f1;
			if($company->company->f1->f2)$mapped_companies_array['name'] = $company->company->f1->f2;
			if($company->company->f1->f3)$mapped_companies_array['url'] = $company->company->f1->f3;
			if($company->company->f1->f4)$mapped_companies_array['eff_from'] = $company->company->f1->f4;
			// if($company->company->f1->f5)$mapped_companies_array['ddlink'] = $company->company->f1->f5;
			if($company->company->f1->f5)$mapped_companies_array['linkedin_id'] = $company->company->f1->f5;
			if($company->company->f1->f6)$mapped_companies_array['assigned_to_name'] = $company->company->f1->f6;
			if($company->company->f1->f20)$mapped_companies_array['assigned_to_image'] = $company->company->f1->f20;
			if($company->company->f1->f19)$mapped_companies_array['class'] = $company->company->f1->f19;
			if($company->company->f1->f22)$mapped_companies_array['address_lat'] = $company->company->f1->f20;
			if($company->company->f1->f21)$mapped_companies_array['address_lng'] = $company->company->f1->f21;
			if($company->company->f1->f23)$mapped_companies_array['phone'] = $company->company->f1->f23;


			if($company->company->f1->f7)$mapped_companies_array['assigned_to_id'] = $company->company->f1->f7;
			if($company->company->f1->f8)$mapped_companies_array['address'] = $company->company->f1->f8;
		
			if($company->company->f1->f9)$mapped_companies_array['active'] = (bool)$company->company->f1->f9;
			if($company->company->f1->f10)$mapped_companies_array['created_at'] = $company->company->f1->f10;
			if($company->company->f1->f11)$mapped_companies_array['updated_at'] = $company->company->f1->f11;
			if($company->company->f1->f12)$mapped_companies_array['created_by'] = $company->company->f1->f12;
			if($company->company->f1->f13)$mapped_companies_array['updated_by'] = $company->company->f1->f13;
			if($company->company->f1->f14)$mapped_companies_array['registration'] = $company->company->f1->f14;
			if($company->company->f1->f15)$mapped_companies_array['turnover'] = $company->company->f1->f15;
			if($company->company->f1->f16)$mapped_companies_array['turnover_method'] = $company->company->f1->f16;
			if($company->company->f1->f17)$mapped_companies_array['emp_count'] = $company->company->f1->f17;
			if($company->company->f1->f18)$mapped_companies_array['image'] = $company->company->f1->f18;

			if($company->company->f1->f24)$mapped_companies_array['pipeline'] = $company->company->f1->f24;
			if($company->company->f1->f25)$mapped_companies_array['contacts_count'] = $company->company->f1->f25;
			if($company->company->f1->f26)$mapped_companies_array['parent_registration'] = $company->company->f1->f26;
			if($company->company->f1->f27)$mapped_companies_array['zendesk_id'] = $company->company->f1->f27;
			if($company->company->f1->f28)$mapped_companies_array['customer_from'] = $company->company->f1->f28;
			if($company->company->f1->f29)$mapped_companies_array['sonovate_id'] = $company->company->f1->f29;
			if($company->company->f1->f30)$mapped_companies_array['actioned_at1'] = $company->company->f1->f30;
			if($company->company->f1->f31)$mapped_companies_array['action_name1'] = $company->company->f1->f31;
			if($company->company->f1->f32)$mapped_companies_array['action_user1'] = $company->company->f1->f32;
			if($company->company->f1->f33)$mapped_companies_array['planned_at2'] = $company->company->f1->f33;
			if($company->company->f1->f34)$mapped_companies_array['action_name2'] = $company->company->f1->f34;
			if($company->company->f1->f35)$mapped_companies_array['action_user2'] = $company->company->f1->f35;
			if($company->company->f1->f36)$mapped_companies_array['trading_name'] = $company->company->f1->f36;
			if($company->company->f1->f37)$mapped_companies_array['source'] = $company->company->f1->f37;
			if($company->company->f1->f38)$mapped_companies_array['source_date'] = $company->company->f1->f38;
			if($company->company->f1->f39)$mapped_companies_array['parent_name'] = $company->company->f1->f39;
			if($company->company->f1->f40)$mapped_companies_array['parent_id'] = $company->company->f1->f40;
			if($company->company->f1->f41)$mapped_companies_array['source_explanation'] = $company->company->f1->f41;
			if($company->company->f1->f42)$mapped_companies_array['created_by_name'] = $company->company->f1->f42;
			if($company->company->f1->f43)$mapped_companies_array['updated_by_name'] = $company->company->f1->f43;
            if($company->company->f1->f44)$mapped_companies_array['initial_rate'] = $company->company->f1->f44;
            if($company->company->f1->f45)$mapped_companies_array['customer_to'] = $company->company->f1->f45;
            if($company->company->f1->f46)$mapped_companies_array['account_manager'] = $company->company->f1->f46;
            if($company->company->f1->f47)$mapped_companies_array['confidential_flag'] = $company->company->f1->f47;
             if($company->company->f1->f48)$mapped_companies_array['permanent_funding'] = $company->company->f1->f48;
             if($company->company->f1->f49)$mapped_companies_array['staff_payroll'] = $company->company->f1->f49;
             if($company->company->f1->f50)$mapped_companies_array['management_accounts'] = $company->company->f1->f50;
            if($company->company->f1->f51)$mapped_companies_array['paye'] = $company->company->f1->f51; 
            if($company->company->f1->f52)$mapped_companies_array['permanent_invoicing'] = $company->company->f1->f52;
			// sectors

			if(!empty($company->company->f1->f22)){
				$sectors = array();
				foreach ($company->company->f1->f22 as $sector) {

					if(isset($sector->f1) && !empty($sector->f1)) 
						$sectors[$sector->f1] = $sector->f2;
				}
				if(!empty($sectors)) $mapped_companies_array['sectors'] = $sectors;
			}
			    if(isset($company->company->f3) && (empty($company->company->f3) == False)){
                $tags_array = array();
     
                foreach ($company->company->f3 as $tag) {
                    $tags = array();
                    $tags['category_name'] = $tag->f1;
                    $tags['id'] = $tag->f2;
                    $tags['name'] = $tag->f3;
                    $tags['created_by'] = $tag->f4;
                    $tags['created_at'] = $tag->f5;
            

                    $tags_array[] = $tags;
                }
                $mapped_companies_array['tags'] = $tags_array;
            }
			// mortgages 
			if(isset($company->company->f2) && (empty($company->company->f2) == False)){
				$mortgages_array = array();
      
				foreach ($company->company->f2 as $mortgage) {
					$mortgages = array();
					$mortgages['id'] = $mortgage->f1;
					$mortgages['name'] = $mortgage->f2;
					$mortgages['stage'] = $mortgage->f3;
					$mortgages['eff_from'] = $mortgage->f4;
					$mortgages['eff_to'] = $mortgage->f5;
					$mortgages['type'] = $mortgage->f6;
					$mortgages['url'] = $mortgage->f7;
$mortgages['Inv_fin_related'] = $mortgage->f8;

					$mortgages_array[] = $mortgages;
				}
				$mapped_companies_array['mortgages'] = $mortgages_array;
			}
			$companies_array[]= $mapped_companies_array;
		}
        
        
        
               // print_r($companies_array);

//exit();
		return $companies_array;
	}

	// Helper function to validade is user agent is a mobile
	protected function isMobileBrowser(){
 		if(!isset($_SERVER['HTTP_USER_AGENT'])) return FALSE;
		$mobile_browser = '0';
 
		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    $mobile_browser++;
		}
		 
		if((isset($_SERVER['HTTP_ACCEPT']) && strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
		    $mobile_browser++;
		}    
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
		$mobile_agents = array(
		    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
		    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		    'wapr','webc','winw','winw','xda','xda-');
		 
		if(in_array($mobile_ua,$mobile_agents)) {
		    $mobile_browser++;
		}
		 
		if (isset($_SERVER['ALL_HTTP']) && strpos(strtolower($_SERVER['ALL_HTTP']),'operamini')>0) {
		    $mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),' ppc;')>0) {
			$mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows ce')>0) {
			$mobile_browser++;
		}
		else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
		    $mobile_browser=0;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iemobile')>0) {
			$mobile_browser++;
		}


		if ($mobile_browser > 0) {
		   return TRUE;
			
		} else {
		   return FALSE;
		}
	}

	protected function is_ajax_request(){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			return TRUE;
		}else{
			return FALSE;
		} 	
	}
      function accessArr($access){ // Any changes here must eb made in the header.php accessArr method
        
      
          switch ($access){
        	case 'edit_template':
        		return array(31,21,7,25,17,1,61,3,6,78);
        		break;
        	case "delete_email_template":
              return  array(31,1,6);
        		//return array(31,1,12,21);
        		
        		break;
                  case "access_email_template":
              return  array(31,21,7,25,17,1,61,3,6,78);
        		//return array(31,1,12,21);
        		
        		break;
                  case "add_email_template":
              return  array(31,21,1,6,3,45);
        		//return array(31,1,12,21);
        		
        		break;
              default:
                  //return array(21,7,25,17,1,61,3,6,78);
        	 	
                  
                    
        }
        
     
    }
    
    
    
}