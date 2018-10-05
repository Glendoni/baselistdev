<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="apple-touch-icon-precomposed" sizes="180x180" href="<?php echo asset_url();?>images/apple-icon.png" />

    <title><?php echo (isset($page_title))? html_entity_decode ($page_title): 'Baselist'; ?></title>
    
    <?php if (ENVIRONMENT  =='staging'){?>
    <link rel="icon" type="image/png" href="<?php echo asset_url();?>images/favicon-staging.jpg">
    <?php
} else {?>

    <link rel="icon" type="image/jpg" href="<?php echo asset_url();?>images/favicon.png">
<?php
}; ?>

    <!-- Timeline CSS -->
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/plugins/timeline.css" rel="stylesheet"> -->

    <!-- MetisMenu CSS -->
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet"> -->

    
    
  
   
 
		<link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    

    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/bootstrap-datetimepicker.css">
    <!-- Bootstrap Core CSS -->
    
    
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/bootstrap.min.css" rel="stylesheet">
    
    
 
    <!-- Bootstrap Core CSS -->
    <!-- <link href="<?php echo asset_url();?>css/font-awesome.min.css" rel="stylesheet"> -->
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/sb-admin-2.css" rel="stylesheet">
 
    <!-- Morris Charts CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/morris-5.1.css">

    <!-- BTN animation -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/ladda.min.css" rel="stylesheet">

    <!-- PAGE LOADING BAR -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/pace.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> -->

    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/style.css" rel="stylesheet">
    <!-- Custom Fonts -->
  
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
      
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    

  
  
</head>

<body>


    <div id="wrapper">
        <!-- Navigation -->
<!--<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">--> 
 <?php  $stag_distinct = ''; if (ENVIRONMENT  =='staging'){ $stag_distinct = "background:#2eaf09;"; }?>
 <?php  if (ENVIRONMENT  =='development'){ $stag_distinct = "background:#1385c1;"; }?>
        
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0; <?php echo $stag_distinct; ?>">
<!-- Brand and toggle get grouped for better mobile display -->
<!--<div class="navbar-header">-->
<div class="col-sm-3 col-md-3">
 <a class="navbar-brand" href="<?php echo site_url();?>" ><img src="<?php echo asset_url();?>images/baselist-logo-white.svg" style="width:120px;"><br> <div style="    font-size: 10px;
    font-weight: 300;
    text-align: left;
    line-height: 40px;
    padding-left: 71px;
    margin-top: -13px;">
     <?php if (isset($current_user)): ?>
        <?php if (ENVIRONMENT  =='staging'){?>
<div style="font-size: 10px;font-weight: 600;text-align: right;float: right;line-height: 40px;padding-left: 5px;">Staging</div>
<?php
} ?>
     
     Version S6</div>
    </a>
    
        <?php 
    
    
    if ($current_user['department'] != 'support'){  ?>
     <a href="<?php echo site_url(); ?>dashboard/team" ><div class="btn btn-warning"style="margin-top: 15px;  margin-left: 2px;
    padding: 2px 20px;">Team</div>
         
         <?php } ?>
         <br>  
         
         

<?php endif; ?>
</a>

</div>

    <div class="col-sm-4 col-sm-push-5" >
            <!-- Top Menu Items -->
            <?php if (isset($current_user)): ?>

        <ul class=" nav navbar-top-links navbar-right  " >
                   

                    <li class="dropdown" style="display:none;">
                        <div class="btn-group">
                                  <button type="button" class="btn btn-default scheduleBtn" onclick="location.href='<?php echo site_url();?>dashboard&#35;calls'"><span class="myactivity">Scheduled  <span class="badge scheduleBadge"><?php echo count($pending_actions); ?></span></span></button>
                                  <button type="button" class="btn btn-default dropdown-toggle sublinkMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu contActive">
                                    <li> 
                                                <div style="min-width:479px; padding:0px 10px;" class="myActiveDiv ">  
                                                    <div style="float:left; padding: 0px 5px; width: 60%;  border: solid thin #fff; border-right-color: #e1e1e1;" class="recentlyVisited">
                                                    <p class="recent_visited_header"  style="margin-left: 18px;"><strong>Recently Visited</strong></p> 
                                                    <ul class="tr-actions" style="padding: 0px;"></ul>
                                                    </div>  
                                                    <div style="float:left; padding: 0px 0px; width: 30%;  " class="pageQvNav">
                                                    <p class="recent_visited_header" style="    margin-left: 41px;">
                                                    <strong>Page Sections</strong>
                                                    </p> 
                                                    <ul class="qvlink" style="margin-left: -15px;">
                                                    <li><a href"javascript:;"  data="qvfinancials"><i class="fa fa-money" aria-hidden="true"></i> Financials</a></li>
                                                    <li><a href"javascript:;"  data="addresses"><i class="fa fa-globe" aria-hidden="true"></i> Locations</a></li>
                                                    <li><a href"javascript:;"  data="contacts"><i class="fa fa-user" aria-hidden="true"></i> Contacts</a></li>
                                                    <li><a href"javascript:;"  data="qvTags"><i class="fa fa-tags" aria-hidden="true"></i> Tags</a></li>
                                                    <li><a href"javascript:;"  data="add_action"><i class="fa fa-calendar" aria-hidden="true"></i> Add Action</a></li>
                                                    <li><a href"javascript:;"  data="actions"><i class="fa fa-info-circle" aria-hidden="true"></i> Actions</a></li>
                                                    </ul>

                                                    </div>

                                                </div>
                                            </li>
                                  </ul>
                        </div>
                    </li>


 

                        <li class="dropdown">

                                    <a href="#" class="dropdown-toggle user-profile" data-toggle="dropdown">
                                    <?php $user_icon = explode(",", ($current_user['image'])); echo "<div class='circle' style='float: left;margin-top: 0px;margin-right: 10px;width: 20px;height: 20px;border-radius: 15px;font-size: 8px;line-height: 20px;text-align: center;font-weight: 700;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
                                   <span id="current_user_name"> <?php echo $current_user['name'] ?></span> <b class="caret"></b>
                                </a>

                                <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url(); ?>users/profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                                          </li>
                                          <li>
                                             <a href="<?php echo site_url(); ?>users/settings"><i class="fa fa-fw fa-envelope"></i> Email Settings</a>
                                          </li>
                                         <li>
                                            <a href="https://status.heroku.com/" target="_blank"><i class="fa fa-fw fa-tasks"></i> Hosting Status</a>
                                         </li>
                                            <li class="divider"></li>
                                            
                                    
                                     <?php
                                  
                                    if(  in_array($current_user['id'],access_permission_nav('access_email_template'))){ ?> 
                                        <li>
                                            <a href="<?php echo base_url(); ?>email_templates/" ><i class="fa fa-envelope"></i> Manage Email Templates</a>
                                        </li>
                                    
                                    <?php } ?>
                                    
                                       <li>
                                            <a href="<?php echo base_url(); ?>companies/pipeline" ><i class="fa fa-plus-circle"></i> Pipeline</a>
                                        </li>
                                    <?php 
                                    
                                    
                                  
                                    if ($current_user['department'] == 'development'  || $current_user['department'] ==  'board'): ?>
                                         <li>
                                            <a href="<?php echo base_url(); ?>companies/create_company" ><i class="fa fa-plus-circle"></i> Add Company</a>
                                        </li>
                                      <li>
                                                <a href="<?php echo site_url(); ?>Privilege"><i class="fa fa-shield fa-rotate-270"></i> User Management</a>
                                          </li>
                                   
                                        <li>
                                            <a href="<?php echo base_url(); ?>tagging/tag_categories" ><i class="fa fa-plus-circle"></i> Tagging</a>
                                        </li>
                                    <li>
                                            <a href="<?php echo base_url(); ?>evergreen" ><i class="fa fa-plus-circle"></i> Evergreen Maintenance</a>
                                        </li>
                                 
                                    <li class="divider"></li>
                                    <?php endif; ?>
                                            <li>
                                                <a href="<?php echo site_url(); ?>login/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                            </li>
                             </ul>
                    </li>
        </ul>
            <?php endif; ?>

 </div>



<?php if (isset($current_user)): ?>
<!--TOP SEARCH BAR-->
<?php if (isset($_GET['id'])) { 
$company = $companies[0];
$search_default = ''; //html_entity_decode ($company['name']);
} else {
$search_default = $this->input->post('agency_name');
}?>

    <div class="col-sm-5 col-md-5 col-sm-pull-3 large-form-holder clearfix">
            <div class="" id="adv-search">
             <?php echo form_open(site_url().'companies', 'id="main_search" novalidate="novalidate" name="main_search" class="" role="form"'); ?>
                <?php echo form_hidden('main_search','1');?>
                                    


                    <input name="agency_name" id="agency_name" type="text" onkeyup="ajaxSearch();" class="form-control large-search-height large-search" autocomplete="off" autofocus value="<?php echo trim($search_default);?>" placeholder="Search">
                    <div class="alert alert-warning alert-dismissible" style="display:none;" id="empty_form_error" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <strong>Warning!</strong> Please enter at least one search criteria.
                    </div>          
                      <div id="suggestions">
                      <div id="autoSuggestionsList"></div>
                      </div>
                       <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg ">
                            <button href="#credits" type="button" class="toggle btn btn-default dropdown-toggle large-search-height" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                        </div>
                        
                            <a href="javscript:;" class="search_box_cancel btn btn-danger " value="Go" name="submit" style="width: 100%; padding-top:7px;">X</a>
                        
                        
                        <?php if (isset($_POST['main_search'])): ?>
                                    <a href="<?php echo site_url();?>" class="loading-btn btn btn-danger  loading-btn-search" value="Go" name="submit" style="width: 100%; padding-top:7px;">X</a>
                                    <?php endif; ?>
                        
                    <input type="submit" class="loading-btn btn btn-warning " value="Go" name="submit" style="width: 100%;">
                        <?php if (validation_errors()): ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo validation_errors(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
<!--<?php if (isset($_POST['main_search'])): ?>
                                    <div class='form-row'>
                                        <div class="col-md-12 form-group ">
                                            <a class="btn btn-block clear-fields" href="<?php echo site_url();?>">
                                                <span class="glyphicon glyphicon-remove"></span> Clear Search
                                            </a>
                                        </div>
                                    </div>
                                    <?php endif; ?>-->
            <?php if (!isset($_GET['id']) && (isset($_POST['main_search']) || (isset($_GET['search'])))) : ?>
                                <!--         <div class="col-md-12 no-padding" style="margin-top:20px;">
                                            <a class="btn btn-block clear-fields" href="<?php echo site_url();?>">
                                                <span class="glyphicon glyphicon-remove"></span> Clear fields
                                            </a>
                                        </div> -->
                                    <?php endif; ?>
                    <div id="credits" class="well hidden advanced-search">
                            <div class="form-row" style="margin-bottom:50px;">
                                    <div class="col-xs-6 col-md-6 no-padding">
                                         <?php  echo form_label('Company Age (Months) ', 'company_age_from', array('class'=>'control-label')); ?>
                                         <div class="form-group" >
                                            <div class="col-xs-6 col-md-6 no-padding"> 
                                            <?php echo form_input(array('name' => 'company_age_from', 'id' => 'company_age_from', 'maxlength' => '100','class'=>'form-control','placeholder'=>'From'), set_value('company_age_from',$this->input->post('company_age_from')));?>
                                            </div>
                                            <div class="col-xs-6 col-md-6 no-padding">
                                            <?php echo form_input(array('name' => 'company_age_to', 'id' => 'company_age_to', 'maxlength' => '100','class'=>'form-control','placeholder'=>'To'), set_value('company_age_to',$this->input->post('company_age_to')));?>    
                                            </div>
                                        </div>
                                    </div>
                           
                                    <div class="col-xs-6 col-md-6 no-padding">
                                <?php  echo form_label('Turnover (£)', 'turnover_from', array('class'=>'control-label')); ?>
                                         <div class="form-group"> 
                                        <div class="col-xs-6 col-md-6 no-padding"> 
                                        <?php echo form_input(array('name' => 'turnover_from', 'id' => 'turnover_from', 'maxlength' => '100','class'=>'form-control number','placeholder'=>'From'), set_value('turnover_from',$this->input->post('turnover_from')));?>
                                        </div>
                                        <div class="col-xs-6 col-md-6 no-padding">
                                         <?php echo form_input(array('name' => 'turnover_to', 'id' => 'turnover_to', 'maxlength' => '100','class'=>'form-control number','placeholder'=>'To'), set_value('turnover_to',$this->input->post('turnover_to')));?>   
                                        </div>
                                    </div>
                                    </div>
                            </div><!--END FORM ROW-->



                                    <div class='form-row'>
                                        <div class="form-group">
                                            <div class="col-xs-6 col-md-6 no-padding"> 

                                        <?php
                                        echo form_label('Provider', 'providers');
                                        echo form_dropdown('providers', $providers_options, ($this->input->post('providers')?$this->input->post('providers'):$providers_default) ,'class="form-control"');
                                    
                                        ?>
                                            </div>
                                        </div>
                                    </div><!--END FORM ROW-->
                                    <div class='form-row'>
                                        <div class="form-group">
                                        <div class="col-xs-6 col-md-6 no-padding">
                                        <?php 
                                        echo form_label('Sectors', 'sectors');
                                        echo form_dropdown('sectors', $sectors_search, ($this->input->post('sectors')?$this->input->post('sectors'):$sectors_default),'class="form-control"');
                                        ?>
                                        </div>
                                        </div>
                                    </div><!--END FORM ROW-->
                                  
                                    <div class='form-row'>
                                        <div class="form-group">
                                            <?php
                                            
                                            
                                                  $mystring = $_SERVER['HTTP_USER_AGENT'];
$findme   = 'Macintosh';
$pos = strpos($mystring, $findme);

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
  $piplelineStapLine  = 'Pipeline <span class="piplineverbiagekeayboard">- Hold ctrl key to select multiples</span>';
} else {
    $piplelineStapLine  = 'Pipeline <span class="piplineverbiagekeayboard">- Hold cmd &#8984; key to select multiples </span>';
}
                                            
                                            
                                            
                                            echo form_label($piplelineStapLine, 'pipeline');
                                                echo form_multiselect('pipeline[]', $pipeline_options,
                                                    ($this->input->post('pipeline')?$this->input->post('pipeline'):$pipeline_default),'class="form-control pipelineSelectSearch"');?>
                                         </div> 
                                    </div>
                                    <div class='form-row'>
                                        <div class="form-group">
                                            
                                            <?php
                                           
                                            
                                           
                                                echo form_label('Class', 'class');
                                                echo form_dropdown('class', $class_options, ($this->input->post('class')?$this->input->post('class'):$class_default) ,'class="form-control"');
                                                ?>         
                                         </div> 
                                    </div>
                                    <?php /* ?>
                                    <div class='form-row hideme'>
                                        <div class="col-md-6 no-padding">
                                            <?php
                                            echo form_label('Contacted', 'contacted');
                                            echo form_dropdown('contacted', $exclude_options, ($this->input->post('contacted')?$this->input->post('contacted'):' ') ,'class="form-control include-exclude-drop"');
                                            ?>
                                         </div> 

                                         <div class="col-md-6 no-padding hideme"> 
                                         <label>Last # days</label>
                                            <?php   
                                            echo form_input(array('name' => 'contacted_days', 'id' => 'contacted_days', 'maxlength' => '100','class'=>'form-control','placeholder'=>'','type'=>'number','min'=>'0'), set_value('contacted_days',$this->input->post('contacted_days')));?>
                                        
                                        </div>
                                        
                                    </div><!--END FORM ROW-->
                                    <?php */ ?>
                          <div class='form-row'>
                                        <div class="form-group">
                                            <?php
                                            echo form_label('Favourites', 'assigned');
                                            echo form_dropdown('assigned', $sales_users, ($this->input->post('assigned')?$this->input->post('assigned'):$assigned_default) ,'class="form-control"');
                                            ?>
                                         </div> 
                                    </div>
                                    <div class="form-row"  >
                                    <input type="submit" class="loading-btn btn btn-warning btn-block" value="Go" name="submit"  style="margin-top: 30px;">

</div>
</div><!--END ADVANCED SEARCH-->
</div>


            

<?php echo form_close(); ?>
<?php endif; ?>

           
        </nav>
        
        
        <?php 
      function access_permission_nav($access){ // Any changes here must eb made in the My_controller accessArr method
        switch ($access){
        
        	case 'edit_template':
        		return array(31,21,7,25,17,1,61,3,6,78);
        		break;
        	case "delete_email_template":
              return  array(31,1,6);
        		//return array(31,1,12,21);
        		
        		break;
                case "access_email_template":
              return  array(31,21,1,6,3,45);
        		//return array(31,1,12,21);
        		
        		break;
                  case "add_email_template":
              return  array(31,21,1,6,3,45);
        		//return array(31,1,12,21);
        		
        		break;
                  
              default:
                  //return
        	 	
        }
        
     
    }
        ?>
 