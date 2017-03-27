<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
    protected $userPermission;
    
	function __construct() 
    {
        parent::__construct();
        // Some models are already been loaded on MY_Controller
        $this->load->model('Evergreen_model');
        $this->load->model('Workflows_model');
        $this->userPermission = $this->data['current_user']['permission']? $this->data['current_user']['permission'] :   $this->userMarket = $this->data['current_user']['market'];
		
	}
	
    public function index() 
    {	
        
       
        // Clear search in session 
        $this->clear_search_results();
        $this->clear_campaign_from_session();
        $this->data['hide_side_nav'] = true;
        $this->data['full_container'] = True;
        // Getting all sectors
        // Add options
        // array_unshift($providers_options,'All');
        $this->data['department'] =   $this->data['current_user']['department'] ;
        $this->data['pending_actions'] = $this->Actions_model->get_pending_actions($this->get_current_user_id());
        //$this->data['assigned_companies'] = $this->Actions_model->get_assigned_companies($this->get_current_user_id());
        
       
        
        $this->data['action_types_array'] = $this->Actions_model->get_action_types_array();
        if($this->data['current_user']['department'] == 'support'){
            $this->data['main_content'] = 'dashboard/pods';
        }else{
        $permission = 'admin';
        if($this->userPermission == 'uf') $permission = 'uf';
            $this->data['getuserplacements'] = $this->Actions_model->get_user_placements($_GET['period']);
            $this->data['getuserproposals'] = $this->Actions_model->get_user_proposals($_GET['period']);
            $this->data['getusermeetings'] = $this->Actions_model->get_user_meetings($_GET['period']);
            $this->data['getuserdemos'] = $this->Actions_model->get_user_demos($_GET['period']);
            $this->data['dates'] = $this->Actions_model->dates();
            $this->data['userimage'] = $this->Users_model->get_user_image();
                //$this->data['stats'] = $this->Actions_model->get_recent_stats('week', 'np');
                //$this->data['ustats'] = $this->Actions_model->get_recent_stats('week', $permission);
                //$this->data['lastweekstats'] = $this->Actions_model->get_recent_stats('lastweek');
                //$this->data['thismonthstats'] = $this->Actions_model->get_recent_stats('thismonth');
                //$this->data['lastmonthstats'] = $this->Actions_model->get_recent_stats('lastmonth');
                //if($_GET['search']) $this->data['getstatssearch'] = $this->Actions_model->get_recent_stats('search','np');
                //if($_GET['search']) $this->data['ugetstatssearch'] = $this->Actions_model->get_recent_stats('search', 'uf');
                //$this->data['pipelinecontacted'] = $this->Actions_model->get_pipeline_contacted();
                //$this->data['pipelinecontactedindividual'] = $this->Actions_model->get_pipeline_contacted_individual($this->get_current_user_id());
                //$this->data['pipelineproposal'] = $this->Actions_model->get_pipeline_proposal($this->get_current_user_id());
                //$this->data['pipelineproposalindividual'] = $this->Actions_model->get_pipeline_proposal_individual($this->get_current_user_id());
                //$this->data['pipelinecustomer'] = $this->Actions_model->get_pipeline_customer($this->get_current_user_id());
                //$this->data['pipelinecustomerindividual'] = $this->Actions_model->get_pipeline_customer_individual($this->get_current_user_id());
                //$this->data['pipelinelost'] = $this->Actions_model->get_pipeline_lost($this->get_current_user_id());
                //$this->data['pipelinelostindividual'] = $this->Actions_model->get_pipeline_lost_individual($this->get_current_user_id());
                //$this->data['campaignsummary'] = $this->Campaigns_model->get_user_campaigns($this->get_current_user_id());
                //$this->data['tagssummary'] = $this->Tagging_model->get_tagging_stats();
                //$this->data['teamcampaignsummary'] = $this->Campaigns_model->get_team_campaigns();
                //$this->data['private_campaigns_new'] = $this->Campaigns_model->private_campaigns_new($this->get_current_user_id());
                //$this->data['marketing_actions'] = $this->Actions_model->get_marketing_actions($this->get_current_user_id());
           
        
            $this->data['main_content'] = 'dashboard/home';
        }
        
          $this->data['window']  = $this->data['current_user']['new_window'];
            $this->load->view('layouts/default_layout', $this->data);	
    }
    
    public function team() 
	{	
    // Clear search in session 
        $this->clear_search_results();
        $this->clear_campaign_from_session();
        $this->data['hide_side_nav'] = true;
        $this->data['full_container'] = True;
        // Getting all sectors 
        // Add options
        // array_unshift($providers_options,'All');
        $this->data['department'] =   $this->data['current_user']['department'] ;
        $this->data['pending_actions'] = $this->Actions_model->get_pending_actions($this->get_current_user_id());
    //$this->data['assigned_companies'] = $this->Actions_model->get_assigned_companies($this->get_current_user_id());
        $this->data['action_types_array'] = $this->Actions_model->get_action_types_array();
    
        if($this->data['current_user']['department'] == 'support'){
            $this->data['main_content'] = 'dashboard/pods';
        }else{
            $permission = 'admin'; 
            if($this->userPermission == 'uf') $permission = 'uf';
            $this->data['stats'] = $this->Actions_model->get_recent_stats('week', 'np');
            $this->data['ustats'] = $this->Actions_model->get_recent_stats('week', $permission);
            //$this->data['lastweekstats'] = $this->Actions_model->get_recent_stats('lastweek');
//$this->data['thismonthstats'] = $this->Actions_model->get_recent_stats('thismonth');
            //$this->data['lastmonthstats'] = $this->Actions_model->get_recent_stats('lastmonth');
            if($_GET['search']) $this->data['getstatssearch'] = $this->Actions_model->get_recent_stats('search','np');
            if($_GET['search']) $this->data['ugetstatssearch'] = $this->Actions_model->get_recent_stats('search', 'uf');
            $this->data['pipelinecontacted'] = $this->Actions_model->get_pipeline_contacted();
            $this->data['pipelinecontactedindividual'] = $this->Actions_model->get_pipeline_contacted_individual($this->get_current_user_id());
            $this->data['pipelineproposal'] = $this->Actions_model->get_pipeline_proposal($this->get_current_user_id());
            $this->data['pipelineproposalindividual'] = $this->Actions_model->get_pipeline_proposal_individual($this->get_current_user_id());
            $this->data['pipelinecustomer'] = $this->Actions_model->get_pipeline_customer($this->get_current_user_id());
            $this->data['pipelinecustomerindividual'] = $this->Actions_model->get_pipeline_customer_individual($this->get_current_user_id());
            $this->data['pipelinelost'] = $this->Actions_model->get_pipeline_lost($this->get_current_user_id());
            $this->data['pipelinelostindividual'] = $this->Actions_model->get_pipeline_lost_individual($this->get_current_user_id());
            $this->data['getuserplacements'] = $this->Actions_model->get_user_placements($_GET['period']);
            $this->data['getuserproposals'] = $this->Actions_model->get_user_proposals($_GET['period']);
            $this->data['getusermeetings'] = $this->Actions_model->get_user_meetings($_GET['period']);
            $this->data['getuserdemos'] = $this->Actions_model->get_user_demos($_GET['period']);
            $this->data['dates'] = $this->Actions_model->dates();
            $this->data['campaignsummary'] = $this->Campaigns_model->get_user_campaigns($this->get_current_user_id());
            $this->data['tagssummary'] = $this->Tagging_model->get_tagging_stats();
            //$this->data['teamcampaignsummary'] = $this->Campaigns_model->get_team_campaigns();
            //$this->data['private_campaigns_new'] = $this->Campaigns_model->private_campaigns_new($this->get_current_user_id());
            $this->data['userimage'] = $this->Users_model->get_user_image();
            //$this->data['marketing_actions'] = $this->Actions_model->get_marketing_actions($this->get_current_user_id());
            $this->data['main_content'] = 'dashboard/team';
        }
            $this->load->view('layouts/default_layout', $this->data);	
	}
    
   
     function getTeamStats($userGroup = 'np')
     { //json request
        	//$userGroup =  $this->userPermission;
        $output =  array(
            'lastweek' => $this->lastweek($userGroup),
            'currentmonth' => $this->currentmonth($userGroup),
            'lastmonth'=> $this->lastmonths($userGroup)
        );
        header('Content-Type: application/json');
        echo json_encode($output);  
    }
    
    function lastweek($userGroup){
        $this->data['lastweekstats'] = $this->Actions_model->get_recent_stats('lastweek',$userGroup);
        $this->data['prefix'] = $userGroup;
        return  $this->load->view('dashboard/lastweek', $this->data, true);	
        //echo json_encode(array('stats' => $lastweek));  
    }
    
    function currentmonth($userGroup)
    {
       $this->data['thismonthstats'] = $this->Actions_model->get_recent_stats('thismonth', $userGroup);
       $this->data['prefix'] = $userGroup;
       return  $this->load->view('dashboard/thismonth', $this->data, true);	
        //echo json_encode(array('stats' => $thismonth)); 
        //return   array('stats' => $thismonth));  
    }
    
    function lastmonths($userGroup)
    {
           //$this->data['lastmonthstats'] = array();
       $this->data['lastmonthstats'] = $this->Actions_model->get_recent_stats('lastmonth', $userGroup);
       $this->data['prefix'] = $userGroup;
       return $this->load->view('dashboard/lastmonth', $this->data, true);	
        //echo json_encode(array('stats' => $lastmonth));  
    }
    
    function refactorFavourites($order =false)
    {
        $output = (array)$this->Actions_model->get_assigned_companies_ajax($this->get_current_user_id(),$order);
        echo json_encode($output);
        //echo '<pre>'; print_r($output); echo '</pre>';
    }    
    

    public function getActionsProposals()
    {
      $output['proposals']  =  $this->Actions_model->getActionsProposals($this->data['current_user']['id']);
      $output['intents']  =  $this->Actions_model->getActionsIntents($this->data['current_user']['id']);
        
                                            $output['pods']  =  $this->Actions_model->getPods($this->data['current_user']['id']);
                                                $output['userpermission'] =  $this->userPermission;
                                                    $output['window']   = $this->data['current_user']['new_window'];
      echo json_encode($output);
        //echo '<pre>'; print_r($output); echo '</pre>';  
    }  

    public function getPods()
    {
        $output['pods']  =  $this->Actions_model->getActionsProposals($this->data['current_user']['id']);
        echo json_encode($output);
        //echo '<pre>'; print_r($output); echo '</pre>';  
    } 
    
    function private_campaigns_new()
    { //dElete this function when finished there are no dependentcies
        $output   = $this->data['private_campaigns_new'] = $this->Campaigns_model->private_campaigns_new($this->get_current_user_id());
        echo json_encode($output);
    }
    
    function private_campaigns_new_ajax()
    {

    $department =  $this->data['current_user']['department'];       
    $output   = $this->data['private_campaigns_new'] = $this->Campaigns_model->private_campaigns_new_ajax($this->get_current_user_id(), $department);
     echo json_encode($output);
     //echo '<pre>'; print_r($output); echo '</pre>';
    }
    
    function evergreenman_()
    {   //dummy function 
         $output   =   $this->Evergreen_model->evergreenHeaderInfo($this->get_current_user_id());
        echo '<pre>'; print_r($output); echo '</pre>';
    //echo json_encode($output);   
    }  
    
    
    function private_campaigns_news($user_id= 31)
	{
		$this->db->distinct();
		$this->db->select('c.name,c.id as id,c.user_id as userid,u.name as searchcreatedby,u.image as image,c.shared, c.created_at as datecreated');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		$this->db->join('targets t', 'c.id = t.campaign_id');
		$this->db->join('companies comp', 't.company_id = comp.id');
		// Apply this to find saved searches only
		//$this->db->where('criteria IS NULL', null, false);
		$this->db->where('u.active', 'True');
		//$this->db->where('c.shared', 'True');
		$this->db->where('comp.active', 'True');
		$this->db->where('c.user_id', 55);
		$this->db->order_by("c.created_at", "desc");
		//$this->db->limit(20);
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$this->db->group_by("1,2,3,4,5");
        $this->db->limit(20);
		$query = $this->db->get();
             //$this->db->last_query();
		//print_r($query->result());
        
        //exit();
        foreach ($query->result_array() as $row)
        {
        // $get_campaign_pipeline_new  =  $this->get_campaign_pipeline($row['id'],true);
            $output[] = array('id' => $row['id'],
            'name' =>   $get_campaign_pipeline_new->campaignname,
            'image' => $get_campaign_pipeline_new->image,
            'datecreated' => date('d-m-Y', strtotime($get_campaign_pipeline_new->datecreated)),
            'percentage' => $get_campaign_pipeline_new->contacted
            );
        }        
            
        return $output;               
    }
    
    function workflow()
    {
        $pulldetails = $this->input->post('pulldetails');
 

 //print_r($pulldetails);

 //if post  favorites, coadded, views
 
switch ($pulldetails){
	case "customer_deal":
	      $data['customer_deal']  = $this->allUserCustomersRun();
		break;
	case "companies_added":
		 $data['companies_added']  = $this->companiesCreatedUsersRun();
		break;	
	case "recent_viewed_companies":
	     $data['recent_viewed_companies']  = $this->recentViewedCompaniesRun();
		break;	
 	
}

  echo json_encode($data);



 


       // $data['customer_deal']  = $this->allUserCustomersRun();
        //$data['companies_added']  = $this->companiesCreatedUsersRun();
        //$data['recent_viewed_companies']  = $this->recentViewedCompaniesRun();
        
      
        //print '<pre>'; print_r($data); print '</pre>';  
    }

    function allUserCustomersRun()
    {
        $output   =   $this->Workflows_model->allUserCustomers($this->get_current_user_id());
        return  $output;
    }
    
    function companiesCreatedUsersRun()
    { 
        $output = $this->Workflows_model->companiesCreatedUser($this->get_current_user_id());
        return $output;   
    }
    
    function recentViewedCompaniesRun()
    {  
        $output   =   $this->Workflows_model->recentViewedCompanies($this->get_current_user_id());
        return $output;
    }
        /*
        By: Glen 20/04/2016

        ONE OFF FUNCTION TO REFORMAT LEGACY INITIAL RATES

        The two function below are to be used to reformat legacy inital_fee
        values into the new decimal point format.

        Pre Check using the url dashboard/setupdateintialrate

        This will return a list containing the current values that do not conform to
        the new format distinctly grouped 

        On the left is the new format on the right the original


        If happy with the result set hit append the word true after the url: dashboard/setupdateintialrate/true

        This will run through the values and change them programatically


        function setupdateintialrate($debug = false){

                $query = $this->db->query("SELECT DISTINCT initial_rate FROM companies");

                foreach ($query->result_array() as $row)
                {
                   if(strlen($row['initial_rate']) <= 9 && $row['initial_rate'] == true)
                    echo  $this->updateInitialValues($row['initial_rate'],$debug);

                }
        }

            function updateInitialValues($initialRates,$debug){

                if(!$debug){
                return  $initialRates. ' - original '. str_replace(0,'',$initialRates).'<br>' ;
                }else{
                      $initialRatesMinusZeros =  str_replace(0,'',$initialRates);
                $newvalue = '0.0'.str_replace('.','',$initialRatesMinusZeros);
                $data = array(
                               'initial_rate' => $newvalue
                            );

                $this->db->where('initial_rate', $initialRates);
                $this->db->update('companies', $data);
                }
            }
        */
    
    
    
    function actester(){
        
        //$data =  $this->data['getaccountmanager'] = $this->Actions_model->get_account_manager();

 $data  =  $this->Actions_model->getPods($this->data['current_user']['id']);
print '<pre>'; print_r($data); print '</pre>'; 
        
        
    }
    
    
function googleapitest(){
    
  $op  =       $this->data['tagssummary'] = $this->Tagging_model->get_tagging_stats();
    
    
    //echo '<pre>'; 
    //echo print_r($op); 
    
     //echo '</pre>';
    echo json_encode($op);
}

}
