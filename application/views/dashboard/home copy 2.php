<div class="row" style="
    height: 35px;
">
<?php echo $config['sess_expiration']; ?>
          <div class="col-sm-12 " style="margin-bottom: 43px;z-index: 999;top: 57px;position: fixed;background: rgba(248, 248, 248, 0.95); padding: 12px 0px 9px 12px;">

      <?php 
    
    
    if ($current_user['department'] == 'support'){  ?>
              <!-- Nav tabs -->
              <ul class="nav nav-tabs dashboard" role="tablist">
                  
                  
                  
                <li role="presentation" class="active"><button href="#team_stats" aria-controls="team_stats" role="tab" data-toggle="tab" class="btn btn-primary btn-sm " style="margin-right:10px;" onclick="ga('send','event','Clicks','Stats','<?php echo $current_user['id'];?>')">Pods</button></li>
                  
                <li role="presentation">
                    <button href="#calls" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm c-a-m" style="margin-right:10px;" >Schedule</button>
                  </li>
              </ul>
              
              
              
              
<?php } else {?>
<!-- Nav tabs -->
              <ul class="nav nav-tabs dashboard" role="tablist">
              
                <li role="presentation" class="active"><button href="#calls" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm c-a-m calls" style="margin-right:10px;" >Schedule</button></li>
            <li role="presentation"><button href="#emailegagement" aria-controls="emailegagement" role="tab" data-toggle="tab" class="btn btn-primary btn-sm emailegagement" style="margin-right:10px;" onclick="ga('send','event','Clicks','Email Engagement','<?php echo $current_user['id'];?>')"> Engagement</button></li>   
                  
                  
                   <li role="presentation"><button href="#dasboardviews" aria-controls="recent_viewed_companies" role="tab" data-toggle="tab" class="btn btn-primary btn-sm recent_viewed_companies" style="margin-right:10px;" onclick="ga('send','event','Clicks','dasboardviews','<?php echo $current_user['id'];?>')">View</button></li>
                
                   <li role="presentation"><button href="#coadded" aria-controls="companies_added" role="tab" data-toggle="tab" class="btn btn-primary btn-sm coadded" style="margin-right:10px;" onclick="ga('send','event','Clicks','','<?php echo $current_user['id'];?>')">Co Added</button></li> 
                     <li role="presentation"><button href="#assigned" aria-controls="favorites" role="tab" data-toggle="tab" class="btn btn-primary btn-sm  favorites" style="margin-right:10px;" onclick="ga('send','event','Clicks','Favourites','<?php echo $current_user['id'];?>')">Favourite</button></li>
                  
               <!-- <li><button href="companies/pipeline"role="tab" class="button btn btn-primary btn-sm deals_pipeline" style="margin-right:10px;" onclick="window.location ='companies/pipeline'">Deals Forecast</button></li> -->
               
                  
                  
                     <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                  
                      <li role="presentation"><button href="#intents" aria-controls="intents" role="tab" data-toggle="tab" class="btn btn-primary btn-sm intents" style="margin-right:10px;" onclick="ga('send','event','Clicks','Intents','<?php echo $current_user['id'];?>')">Intent</button></li> 
                       
                  <li role="presentation"><button href="#proposals" aria-controls="proposals" role="tab" data-toggle="tab" class="btn btn-primary btn-sm proposals" style="margin-right:10px;" onclick="ga('send','event','Clicks','Proposals','<?php echo $current_user['id'];?>')">Proposal</button></li> 
                  
                           
                   <li role="presentation"><button href="#customerdeal" aria-controls="customer_deal" role="tab" data-toggle="tab" class="btn btn-primary btn-sm customer_deal" style="margin-right:10px;" onclick="ga('send','event','Clicks','Customerdeal','<?php echo $current_user['id'];?>')">Customer</button></li>
              </ul>
  <?php }; ?>
          </div>
        </div>
<div class="row dashboardmaincontainer">    

<div class="col-sm-9    dashboardMainContent">
<!-- Tab panes -->
<div class="tab-content">
<div role="tabpanel" class="tab-pane fade in active" id="team_stats">
<?php if ($_GET['search']==2) { ?>
<!--GET SEARCH DATES TO DISPLAY-->
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">
<?php
    foreach($userimage as $userimage)
    {
      $user_icon = explode(",",$userimage->image); echo "<div class='circle name-circle' style='width:25px;height: 25px;line-height: 25px;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";}?>User Stats</h3> </div>
              <div class="panel-body">
                  <div class="clearfix"></div>
                  <div clas="list-group">


                    <?php if(empty($stats)) : ?>
                      <div class="col-md-12">
                      <div style="margin:10px 0;">
                      <h4 style="margin: 50px 0 40px 0; text-align: center;">You have no recent activity.</h4>
                      </div>
                      </div>
                    <?php else: ?>
                    <!-- Nav tabs -->
                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="col-md-12">
                      <div class="row list-group-item">
                         <div class="col-md-3">
                           <strong>Deals</strong>
                             <div class="pull-right"> 
                                                       <span class="badge us-initial-rate-total" style="margin-right: 4px;font-size: 12px;"></span>

                                 <span class="badge" style="background-color:#428bca;"><?php echo count($getuserplacements);?></span>
                             </div>
                        </div>
                          
                         <div class="col-md-3">
                           <strong>Proposals</strong><div class="pull-right"><span class="badge badge-warning" style="background-color:#45AE7C;"><?php echo count($getuserproposals)?></span></div>
                        </div>
                        <div class="col-md-3">
                          <strong>Meetings</strong><div class="pull-right"><span class="badge badge-warning"><?php echo count($getusermeetings)?></span></div>
                          </div>
                          <div class="col-md-3"> 
                           <strong>Demos</strong><div class="pull-right"><span class="badge badge-warning"><?php echo count($getuserdemos)?></span></div>
                        </div>
                      
                        </div>
                          <div class="row list-group-item">
                            
                            <div class="col-md-3">
                             <?php foreach ($getuserplacements as $get_user_placements): ?>
                            <li class="user-stat-holder">
                            <div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_placements['id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>><?php echo $get_user_placements['name'];?></a></div>
                        <?php 
    
    
    if ($current_user['permission'] == 'admin' || $get_user_placements['created_by'] == $current_user['id']):  ?>
                            <div class="row">
  <div class="col-sm-8 user-stat company action_date">
<?php echo $get_user_placements['lead_name'];?>
     
</div>
                                
                                
  <div class="col-sm-4 user-stat company action_date">
  <?php if(!empty($get_user_placements['initial_rate'])): ?>
<?php echo '<span class="us-initial-rate">'.($get_user_placements['initial_rate']*100).'</span>';?>%
<?php endif; ?>
</div>
                             
    <div class="col-sm-8 user-stat company action_date">
        <?php //echo $get_user_placements['compid'];
        
      $sql =  "select   ls.id, s.name as nm,o.company_id from companies c 
         inner join actions a on c.id = a.company_id
         left join lead_sources ls on c.lead_source_id = ls.id
        left join operates o on a.company_id=   o.company_id
        left join sectors s on o.sector_id = s.id 
         where o.company_id='".$get_user_placements['compid']."' AND o.active=TRUE
         GROUP BY s.name,ls.id,o.company_id";
   if(false){
        $query = $this->db->query($sql);
                echo '<strong>Source</strong><br>';
                foreach ($query->result_array() as $row)
                {
                    echo $row['nm'].'<br>';
        
                }
}
        
        
        ?>
    </div>
                             
</div> 
<?php endif; ?>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_placements['actioned_at']));?>
                            </div>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3"> 

                            <?php foreach ($getuserproposals as $get_user_proposals): ?>
                            <li class="user-stat-holder">
                            <div class="user-stat company"><div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_proposals['id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>><?php echo $get_user_proposals['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_proposals['created_at']));?></div>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3">
                            <?php foreach ($getusermeetings as $get_user_meetings): ?>
                              <li class="user-stat-holder">
                            <div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_meetings['id'] ?>"  <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>><?php echo $get_user_meetings['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <b>Created: </b> <?php echo  date('D jS M y',strtotime($get_user_meetings['created_at']));?></div>
                            <?php if(!empty($get_user_meetings['actioned_at'])): ?>
                            <div class="user-stat company action_date">
                            <span class="label label-success"><?php echo  date('D jS M y',strtotime($get_user_meetings['actioned_at']));?></span>
                            </div><?php else: ?>
                            <div class="user-stat company action_date">
                            <span class="label label-default"><?php echo  date('D jS M y',strtotime($get_user_meetings['planned_at']));?></span>
                            </div>
                            <?php endif ?>

                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3"> 
                            <?php foreach ($getuserdemos as $get_user_demos): ?>
                            <li class="user-stat-holder">
                            <div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_demos['id'] ?>"  <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>><?php echo $get_user_demos['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <b>Created: </b> <?php echo  date('D jS M y',strtotime($get_user_demos['created_at']));?></div>
                            <?php if(!empty($get_user_demos['actioned_at'])): ?>
                            <div class="user-stat company action_date">
                            <span class="label label-success"><?php echo  date('D jS M y',strtotime($get_user_demos['actioned_at']));?></span>
                            </div><?php else: ?>
                            <div class="user-stat company action_date">
                            <span class="label label-default"><?php echo  date('D jS M y',strtotime($get_user_demos['planned_at']));?></span>
                            </div>
                            <?php endif ?>
                            </li>
                            <?php endforeach ?>
                            </div>
                          </div>     
                      </div><!--END THIS TAB-->
                      </div>
                      <?php endif ?>
                      </div>
                      </div>
                      </div><!--END PANEL-->
                      <?php };?>                

         

  
 

     
</div><!--END TAB-->
  
    <div role="tabpanel" class="tab-pane active" id="calls"><div class="panel panel-default">
              <div class="panel-heading">
              <h3 class="panel-title">Schedule<span class="badge pull-right"><?php echo count($pending_actions); ?></span></h3>
              </div>
             
              <div class="panel-body no-padding">
              <div class="col-md-12">
                  <div class="clearfix"></div>
                  <div clas="list-group">

                    <?php if(empty($pending_actions)) : ?>
                    <div class="col-md-12">
                      <div style="margin:10px 0;">
                      <h4 style="margin: 50px 0 40px 0; text-align: center;">You have no recent activity.</h4>
                      </div>
                      </div>
                    <?php else: ?>
            <div class="row record-holder-header mobile-hide" style="
    font-size: 12px;
">
            <div class="col-md-3" style="
    padding-left: -0px;
"><strong>Company &amp; Contact</strong></div>
            <div class="col-md-2" style="
    padding-left: 6px;
"><strong>Pipline</strong></div>
            <div class="col-md-2"><strong>Phone</strong></div>
            <div class="col-md-2"><strong>Action</strong></div>
            <div class="col-md-2  "><strong>Scheduled</strong></div>
            <div class="col-md-2 "><strong> </strong></div>
            </div>


                    <?php foreach ($pending_actions as $action): 
                         // print_r('<pre>');print_r($action);print_r('</pre>');
                        // die;
                      ?>
                          <div class="row list-group-item <?php if( strtotime($action->planned_at) < strtotime('today')  ) { echo ' delayed';} ?> " style="font-size:12px;" >
                            <div class="col-md-3"> 
                          
                              <a href="<?php echo site_url();?>companies/company?id=<?php echo $action->company_id;?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                                  <?php $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );echo str_replace($words, ' ',$action->company_name); ?>
   
                              </a>
                                
                              <?php if(!empty($action->first_name)) { $contact_details_for_calendar = urlencode('Meeting with '.$action->first_name.' '.$action->last_name).'%0A'.urlencode($action->email.' '.$action->phone).'%0D%0D';?>
                              <div style="clear:both"><?php echo $action->first_name.' '.$action->last_name;?></div>
                              <?php } else { $contact_details_for_calendar="";};?>
                            </div>
                                <div class="col-md-2">
                             


   <div><span class="label  label-<?php echo $action->pipeline;?>"><?php echo $action->pipeline;?></span><?php  if(($action->assign_date)  && ($action->userID == $current_user['id'])){ 
    $user_icon = explode(",", ($current_user['image'])); 
    echo "<span class='circle scheduelFavorite' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'> Fav
    </span>"; ?> 
                                
                                  <?php } ?>
                                </div>
                             
                            </div>
                             <div class="col-md-2">
                              <div><?php echo $action->company_phone;?></div>
                              <div><?php echo $action->contact_phone;?></div>
                            </div>
                            <div class="col-md-2">
                              <?php echo $action_types_array[$action->action_type_id]; ?>
                            </div>
    <div class="col-md-1 homeSchedule" style="
    width: 104px;
">
                               
                            <?php   $now = $action->duedate; 
                                    $timestamp = strtotime($action->planned_at);
                                    $round = 5*60;
                                    $rounded = round($timestamp / $round) * $round;
                                    echo date('D jS M', $timestamp);
                                    //echo date('Y m d', $timestamp);
                               // echo date("H:i", $rounded);
                                    ?>
                        
                             
                            </div>
                            <div class="col-md-1">
                            <a class="btn btn-default btn-xs add-to-calendar" href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo urlencode($action_types_array[$action->action_type_id].' | '.$action->company_name); ?>&dates=<?php echo date("Ymd\\THi00",strtotime($action->planned_at));?>/<?php echo date("Ymd\\THi00\\Z",strtotime($action->planned_at));?>&details=<?php echo $contact_details_for_calendar;?><?php echo urlencode('http://baselist.herokuapp.com/companies/company?id='.$action->company_id);?>%0D%0DAny changes made to this event are not updated in Baselist.%0D%23baselist"target="_blank" rel="nofollow">Add to Calendar</a>
                                

                                
                              <?php $hidden = array('action_id' => $action->action_id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' , 'company_id' => $action->company_id);
                               echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->action_id.'" style="display:inline-block;" role="form"',$hidden); ?>
                               <button class="btn btn-xs btn-success"  style="display:none;">Completed</button> 
                               </form>
                               <?php $hidden = array('action_id' => $action->action_id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' , 'company_id' => $action->company_id,'page' => 'home' ,);
                               echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action" style="display:none;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->action_id.'" role="form"',$hidden); ?>
                               <button class="btn btn-xs btn-overdue" >Cancel</button>
                               </form>
                      
                  </div>
                   
                          </div>
                          <div class="list-group-item" id="action_outcome_box_<?php echo $action->action_id ?>" style="display:none;">
                          
                          <label>Comment<span class="actionEvalPipeline" style=" color: red;">*</span></label>
                          <textarea class="form-control textarea<?php echo $action->action_id ?>" name="outcome" rows="3" style="display: none;"></textarea>

 <div class="editor addOutcomeEditor" addoutcomeeditor="<?php echo $action->action_id ?>" style="margin-bottom: 5px; min-height: 70px;"></div>

                          <button class="btn btn-primary btn-block">Add Outcome</button>
                          
                          </div>
                 
                      <?php endforeach ?>
                    <?php endif ?>
                  </div>
              </div>
              </div>
    
          </div><!--END OF PANEL--></div>
  
    
    
        <div role="tabpanel" class="tab-pane fade" id="customerdeal">
    <!--START MARKETING STATS-->
            <div class="panel panel-default">
    <div class="panel-heading"  style="
    background: #0971af;
">
    <h3 class="panel-title">Customers - Current & Cancelled<span class="badge pull-right customerdealcount"></span></h3>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body" style="font-size:12px;">
        <!--AUTO PILOT  -->
        <div class="row record-holder-header mobile-hide">
            <div class="col-xs-8 col-sm-4 col-md-1"><strong>Customer From</strong></div>
            <div class="col-xs-8 col-sm-4 col-md-1"><strong>Customer To</strong></div>
            <div class="col-xs-4 col-sm-1 col-md-2"><strong>Company</strong></div>
             <div class="col-xs-12 col-sm-2 col-md-1"><strong>Class</strong></div>
            <div class="col-xs-6 col-sm-2 col-md-1"><strong>Initial Rate</strong></div>
            <div class="col-xs-6 col-sm-3 col-md-1"><strong>Lead Source</strong></div>
            <div class="col-xs-12 col-sm-2 col-md-1"><strong>Age at Joining <br>(months)</strong></div>
            
           
             
           
              <div class="col-xs-12 col-sm-2 col-md-1"><strong>Planned</strong></div>
             <div class="col-xs-12 col-sm-2 col-md-1"><strong>Actioned</strong></div>
              <div class="col-xs-12 col-sm-2 col-md-1"><strong>Action</strong></div>
             <div class="col-xs-12 col-sm-2 col-md-1"><strong>By</strong></div>
           
        </div>
        
        <div id="customer_deal">Loading...</div>   
        <!--AUTO PILOT END  -->
</div>
<!-- /.panel-body -->
</div>
</div><!--END OF PANEL-->   
    
    
    
    
    <div role="tabpanel" class="tab-pane fade" id="coadded">
    <!--START MARKETING STATS-->
            <div class="panel panel-default">
    <div class="panel-heading"  >
    <h3 class="panel-title">Companies Added<span class="badge pull-right coaddedrescount"></span></h3>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body" style="font-size:12px;">
        <!--AUTO PILOT  -->
        <div class="row record-holder-header mobile-hide">
            <div class="col-xs-8 col-sm-4 col-md-2"><strong>Added</strong></div>
            <div class="col-xs-4 col-sm-1 col-md-6"><strong>Company</strong></div>
            <div class="col-xs-6 col-sm-2 col-md-2"><strong>Pipeline</strong></div>
          
        </div>
        
        <div id="companies_addedwf">Loading...</div>   
        <!--AUTO PILOT END  -->
</div>
<!-- /.panel-body -->
</div>
</div><!--END OF PANEL-->
    
  
    
    
    
        <div role="tabpanel" class="tab-pane fade" id="dasboardviews">
    <!--START MARKETING STATS-->
            <div class="panel panel-default">
    <div class="panel-heading"  >
  <h3 class="panel-title">Recently Viewed Companies<span class="badge pull-right dasboardviewscount"></span></h3>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body" style="font-size:12px;">
        <!--AUTO PILOT  -->
        <div class="row record-holder-header mobile-hide">
            <div class="col-xs-8 col-sm-4 col-md-2"><strong>Viewed</strong></div>
           
            <div class="col-xs-4 col-sm-1 col-md-6"><strong>Company</strong></div>
            <div class="col-xs-6 col-sm-2 col-md-2"><strong>Pipeline</strong></div>
          
        </div>
        
        <div id="recent_viewed_companies"></div>   
        <!--AUTO PILOT END  -->
</div>
<!-- /.panel-body -->
</div>
</div><!--END OF PANEL-->
    
    
    
    
    
    
    <div role="tabpanel" class="tab-pane fade" id="pipeline">
      <div class="panel panel-default">
              <div class="panel-heading">
              <h3 class="panel-title">Pipeline</h3>
              </div>
             <div class="panel-body">
              <div clas="list-group">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="active"><a href="#individual_pipeline" role="tab" data-toggle="tab">My Pipeline</a></li>
                      <li><a href="#team_pipeline" role="tab" data-toggle="tab">Team Pipeline</a></li>
                    </ul>
                      <div class="tab-content">
                      <div class="tab-pane fade in active" id="individual_pipeline">
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Intent <div class="pull-right"><span class="badge"><?php echo count($pipelinecontactedindividual)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinecontactedindividual as $pipelinecontactedindividual): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelinecontactedindividual['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";
                             }
                            else if ($date_since<20) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";
                             }
                              else if ($date_since>19) {
                             $display_date = "<div class='col-md-12 pipeline-days overdue'><strong>OVERDUE:</strong> ".$date_since." Days</div>";}?>
                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecontactedindividual['company_id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinecontactedindividual['company_name']); 
                            ?>
                            </a></div>
                                                      <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecontactedindividual['pipeline']); ?>"><?php echo $pipelinecontactedindividual['pipeline'] ?></span> <small><?php echo $pipelinecontactedindividual['username'] ?></small>

                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Proposals <div class="pull-right"><span class="badge"><?php echo count($pipelineproposalindividual)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelineproposalindividual as $pipelineproposalindividual): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelineproposalindividual['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";
                             }
                            else if ($date_since<20) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";
                             }
                              else if ($date_since>29) {
                             $display_date = "<div class='col-md-12 pipeline-days overdue'><strong>OVERDUE:</strong> ".$date_since." Days</div>";
                             }
                            ?>

                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelineproposalindividual['company_id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelineproposalindividual['company_name']); 
                            ?>
                          </a></div>
                          <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelineproposalindividual['pipeline']); ?>"><?php echo $pipelineproposalindividual['pipeline']; ?></span> <small><?php echo $pipelineproposalindividual['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
    
              </div><!--END COL-MD-3-->


              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Deals <div class="pull-right"><span class="badge"><?php echo count($pipelinecustomerindividual)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinecustomerindividual as $pipelinecustomerindividual): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelinecustomerindividual['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";
                             }
                            else {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";
                             }
                            ?>
                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecustomerindividual['company_id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinecustomerindividual['company_name']); 
                            ?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecustomerindividual['pipeline']); ?>"><?php echo $pipelinecustomerindividual['pipeline']; ?></span> <small><?php echo $pipelinecustomerindividual['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
                  <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Lost <?php if (!isset($_GET['start_date'])) { echo"<small>(This Month)</small>";}?> <div class="pull-right"><span class="badge badge-warning"><?php echo count($pipelinelostindividual)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinelostindividual as $pipelinelostindividual): ?>
                                                     
                            <div class='col-md-12 pipeline-days overdue'><strong>Lost</strong></div>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinelostindividual['company_id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            ?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinelostindividual['pipeline']); ?>"><?php echo $pipelinelostindividual['pipeline']; ?></span> <small><?php echo $pipelinelostindividual['username'] ?></small>
                            </div>
                            
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
                            </div><!--END COL-MD-3-->
                            </div><!--END THIS TAB-->
      <div class="tab-pane fade" id="team_pipeline">
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Intent <div class="pull-right"><span class="badge"><?php echo count($pipelinecontacted)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinecontacted as $pipelinecontacted): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelinecontacted['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";
                             }
                            else if ($date_since<20) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";
                             }
                              else if ($date_since>19) {
                             $display_date = "<div class='col-md-12 pipeline-days overdue'><strong>OVERDUE:</strong> ".$date_since." Days</div>";
                             }
                            ?>

                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecontacted['company_id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinecontacted['company_name']); 
                            ?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecontacted['pipeline']); ?>"><?php echo $pipelinecontacted['pipeline']; ?></span> <small><?php echo $pipelinecontacted['username'] ?></small>
                            </div>

                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Proposals <div class="pull-right"><span class="badge"><?php echo count($pipelineproposal)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelineproposal as $pipelineproposal): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelineproposal['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";
                             }
                            else if ($date_since<20) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";
                             }
                             else if (($date_since>14) && ($date_since<30)) {
                             $display_date = "<div class='col-md-12 pipeline-days warning'><strong>WARNING: </strong>".$date_since." Days</div>";
                             }
                              else if ($date_since>29) {
                             $display_date = "<div class='col-md-12 pipeline-days overdue'><strong>OVERDUE:</strong> ".$date_since." Days</div>";
                             }
                            ?>

                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelineproposal['company_id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelineproposal['company_name']); 
                            ?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelineproposal['pipeline']); ?>"><?php echo $pipelineproposal['pipeline']; ?></span> <small><?php echo $pipelineproposal['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->


              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Deals <div class="pull-right"><span class="badge"><?php echo count($pipelinecustomer)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinecustomer as $pipelinecustomer): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelinecustomer['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";
                             }
                            else {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";
                             }
                            ?>
                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecustomer['company_id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                                                        <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinecustomer['company_name']); 
                            ?>
                            </a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecustomer['pipeline']); ?>"><?php echo $pipelinecustomer['pipeline']; ?></span> <small><?php echo $pipelinecustomer['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
                  <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Lost <?php if (!isset($_GET['start_date'])) { echo"<small>(This Month)</small>";}?> <div class="pull-right"><span class="badge badge-warning"><?php echo count($pipelinelost)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinelost as $pipelinelost): ?>
                                                     
                            <div class='col-md-12 pipeline-days overdue'><strong>Lost</strong></div>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinelost['company_id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinelost['company_name']); 
                            ?>

                            </a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinelost['pipeline']); ?>"><?php echo $pipelinelost['pipeline']; ?></span> <small><?php echo $pipelinelost['username'] ?></small>
                            </div>
                            
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
                            </div>
</div>
</div><!--END THIS TAB-->
</div>
</div>
</div><!--END PANEL-->
</div>
<!--ASSIGNED-->
    <div role="tabpanel" class="tab-pane fade" id="assigned"><div class="panel panel-default">
              <div class="panel-heading">
                  
              <h3 class="panel-title">Favourites</h3>
                    <span class="badge pull-right sortform" style="margin-top: -22px; margin-left: 5px;">
                 <form><lable>Display By:</lable>
                     <select id="favoritesSelectBtn" >
                        
                         <option value>Company</option>
                         <option value="1">Pipeline</option>
                      
                     </select></form>
                  </span>
                 
              </div>
        
        
        
         
       
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">         
          <div class="row record-holder-header mobile-hide" style="
    font-size: 12px;
">
                <div class="col-xs-8 col-sm-8 col-md-6" style="margin-"><strong style="
    margin-left: -14px;
">Company</strong></div>
                <div class="col-xs-4 col-sm-1 col-md-4"><strong>Pipeline</strong></div>
            </div>
        </div>
               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
<div class="panel-body" style="padding:0;">

 





                    <?php   if(empty($assigned_companies)) :  ?>
                    
                    <?php    else: ?>

                    <?php foreach ($assigned_companies as $assigned):?>

                
                  <div class="row">
                  <div class="col-xs-5">
                        <a href="<?php echo site_url();?>companies/company?id=<?php echo $assigned->id;?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?> class="load-saved-search">
                  <?php $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' ); echo str_replace($words, ' ',$assigned->name); ?>
                  </div>
                        </a>
                  <div class="col-xs-4">
                  <span class="label label-<?php echo str_replace(' ', '', $assigned->pipeline); ?>" style="margin-top: 3px;"><?php echo $assigned->pipeline;?>
                    <?php if (isset($company['customer_from'])):?> from <?php echo date("d/m/y",strtotime($company['customer_from']));?><?php endif; ?>
                  </span>
                  </div>
                  </div>
                





                         
                      <?php endforeach ?>
                    <?php endif ?>
                </div>
   
</div>
              </div>
          </div><!--END OF PANEL-->
          <!--END ASSIGNED-->
          <!--ASSIGNED-->
    <div role="tabpanel" class="tab-pane fade" id="emailstats">
    <!--START MARKETING STATS-->
            <div class="panel panel-default">
    <div class="panel-heading" id="contacts">
    <h3 class="panel-title">Email Engagement<span class="badge pull-right"><?php echo count($marketing_actions); ?></span></h3>
    </div>
    <!-- /.panel-heading -->
    
    <div class="panel-body" style="font-size:12px;">
<?php if(!empty($marketing_actions)) : ?>
<div class="row record-holder-header mobile-hide">
<div class="col-xs-8 col-sm-4 col-md-4"><strong>Company</strong></div>
<div class="col-xs-4 col-sm-1 col-md-1"><strong>Pipeline</strong></div>
<div class="col-xs-6 col-sm-2 col-md-2"><strong>Contact</strong></div>
<div class="col-xs-6 col-sm-3 col-md-3"><strong>Action</strong></div>
<div class="col-xs-12 col-sm-2 col-md-2"><strong>Date</strong></div>
</div>
<?php foreach ($marketing_actions as $marketing): ?>
<div class="row record-holder">
<div class="col-xs-8 col-sm-4 col-md-4">
<a href="<?php echo site_url();?>companies/company?id=<?php echo $marketing->company_id;?>"><?php echo ucfirst($marketing->company); ?></a>
</div>
<div class="col-xs-4 col-sm-1 col-md-1 text-right">
<span class="label pipeline label-<?php echo str_replace(' ', '', $marketing->pipeline); ?>"><?php echo $marketing->pipeline;?>
</span>
</div>

<div class="col-xs-6 col-sm-2 col-md-2"><a href="<?php echo site_url();?>companies/company?id=<?php echo $marketing->company_id;?>#contacts"><?php echo ucfirst($marketing->first_name).' '.ucfirst($marketing->last_name); ?></a></div>
<div class="col-xs-6 col-sm-3 col-md-3 align-right ">
<?php if (isset($marketing->sent_id)):?><a href="http://www.sonovate.com/?p=<?php echo $marketing->sent_id;?>" style="padding-right:5px;" target="_blank"><i class="fa fa-eye"></i></a><?php endif; ?> 

  <?php if (($marketing->email_action_type)=='2'): ?>
    <span class="label label-primary">Opened</span>
    <?php elseif (!empty($marketing->url)):?>
    <span class="label label-success"><a href="<?php echo $marketing->url;?>" style="color:#fff;">
    <?php 
    $urlwords = array( 'http://', 'https://', 'www.');
    $link = str_replace($urlwords, "", $marketing->url);
    $link = (strlen($link) > 23) ? substr($link,0,20).'...' : $link;
    echo $link;?>
    </a>
    </span>
    <?php else:?>
    <?php endif;?>
</div>
<div class="col-xs-12 col-sm-2 col-md-2 contact-phone">
<?php echo date("d/m/Y",strtotime($marketing->created_at));?>
</div>
</div>


      <?php endforeach; ?>
      <?php else: ?>
      <div class="alert alert-info" style="margin-top:10px;">
                You currently have no marketing actions.
            </div>
    <?php endif; ?>

    </div>
    <!-- /.panel-body -->
    </div>
          </div><!--END OF PANEL-->
          <!--END ASSIGNED-->
          <!--PROPOSALS-->
    <div role="tabpanel" class="tab-pane fade" id="proposals">
    <!--START MARKETING STATS-->
    
            <div class="panel panel-default">
    
    <div class="panel-heading" id="proposals" style="background:#45AE7C">
        <h3 class="panel-title">Outstanding Proposals<span class="badge pull-right eventcountproposals"></span></h3>
    </div>
                
                
             
                
           
    <!-- /.panel-heading -->
    <div class="panel-body" style="font-size:12px;">
        
                 <div class="row record-holder-header mobile-hide">
            <div class="col-xs-8 col-sm-2 col-md-2"><strong>Created</strong></div>
            <div class="col-xs-5 col-sm-4 col-md-4"><strong>Company</strong></div>
            <div class="col-xs-4 col-sm-2 col-md-2"><strong>Planned</strong></div>
           <div class="col-xs-4 col-sm-2 col-md-2"><strong>Action</strong></div>
                     <div class="col-xs-4 col-sm-2 col-md-2"><strong>By</strong></div>
            
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="row record-holder-proposals">loading...</div>
</div>


        
        
        <!--AUTO PILOT 
        <div class="row record-holder-header mobile-hide">
            <div class="col-xs-8 col-sm-4 col-md-3"><strong>Company</strong></div>
            <div class="col-xs-8 col-sm-4 col-md-2"><strong>Campaign</strong></div>
            <div class="col-xs-4 col-sm-1 col-md-1"><strong>Pipeline</strong></div>
            <div class="col-xs-6 col-sm-2 col-md-2"><strong>Contact</strong></div>
            <div class="col-xs-6 col-sm-3 col-md-2"><strong>Last Action</strong></div>
            <div class="col-xs-12 col-sm-2 col-md-1"><strong>Date</strong></div>
        </div>
        
        <div id="stat"></div> 
 -->
        <!--AUTO PILOT END  -->
</div>
<!-- /.panel-body -->
</div>
</div><!--END OF PROPOSALPANEL-->
          <!--ASSIGNED-->

 <div role="tabpanel" class="tab-pane fade" id="intents">
    <!--START MARKETING STATS-->
            <div class="panel panel-default">
    <div class="panel-heading" id="contacts" style="
    background: #f0ad4e;
">
    <h3 class="panel-title">Intents<span class="badge pull-right eventcountintents"></span></h3>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body" style="font-size:12px;">
        <!--AUTO PILOT  -->
          <div class="row record-holder-header mobile-hide">
            <div class="col-xs-8 col-sm-2 col-md-2"><strong>Created</strong></div>
            <div class="col-xs-5 col-sm-4 col-md-4"><strong>Company</strong></div>
            <div class="col-xs-4 col-sm-2 col-md-2"><strong>Planned</strong></div>
           <div class="col-xs-4 col-sm-2 col-md-2"><strong>Action</strong></div>
                     <div class="col-xs-4 col-sm-2 col-md-2"><strong>By</strong></div>
            
        </div>
        <div cl
        
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="row record-holder-intents">loading...</div>
</div> 
        <!--AUTO PILOT END  -->
</div>
<!-- /.panel-body -->
</div>
</div><!--END OF PANEL-->

    <div role="tabpanel" class="tab-pane fade" id="emailegagement">
    <!--START MARKETING STATS-->
            <div class="panel panel-default">
    <div class="panel-heading" id="contacts">
    <h3 class="panel-title">Email Engagement<span class="badge pull-right eventcount"></span></h3>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body" style="font-size:12px;">
        <!--AUTO PILOT  -->
        <div class="row record-holder-header mobile-hide">
            <div class="col-xs-8 col-sm-4 col-md-3"><strong>Company</strong></div>
            <div class="col-xs-8 col-sm-4 col-md-2"><strong>Campaign</strong></div>
            <div class="col-xs-4 col-sm-1 col-md-1"><strong>Pipeline</strong></div>
            <div class="col-xs-6 col-sm-2 col-md-2"><strong>Contact</strong></div>
            <div class="col-xs-6 col-sm-3 col-md-2"><strong>Last Action</strong></div>
            <div class="col-xs-12 col-sm-2 col-md-1"><strong>Date</strong></div>
        </div>
        
        <div id="stat"></div>   
        <!--AUTO PILOT END  -->
</div>
<!-- /.panel-body -->
</div>
</div><!--END OF PANEL-->
<!--END ASSIGNED-->
</div><!--END TAB PANES-->
</div><!--END-COL-SM-9-->
    <div class="col-sm-3   dashboardSidebarCol" style="display:none;">
    
    
    
     <?php   $dept = array('data','sales');

if(in_array($current_user['department'],$dept) ){ ?>
        
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Evergreen Campaign<span class="badge pull-right myevergreencount"></span></h3>
              </div>
              <div class="panel-body myevergreenajax" style="padding:0;">
                  <!-- PRIVATE SEARCHES -->
                 
                  
                  <?php /* foreach ($private_campaigns_new as $campaign):?>
                  <?php $user_icon = explode(",", $campaign['image']);$bg_colour = $user_icon[1];$bg_colour_text = $user_icon[2];$bg_colour_name = $user_icon[0];?>
                    <a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $campaign['id']; ?>" class="load-saved-search" <?php echo strlen($campaign['name']) > 36 ? 'title="'.$campaign['name'].'"':"" ?>><div class="row">
                  <div class="col-xs-1"><span class="label label-info" style="margin-right:3px;background-color: <?php echo $bg_colour; ?>;font-size:8px; color: <?php echo $bg_colour_text;?>"><b><?php echo $bg_colour_name; ?></b>
                    </span></div>
                  <div class="col-xs-9" style="min-height:30px;overflow:hidden"><?php echo $campaign['name'];?><br><span style="font-size:9px;"><?php echo 'Created: '. $campaign['datecreated'];?></span></div>
                  <div class="col-xs-1" style="padding: 0 0 0 0px; font-size: 11px;"><?php echo $campaign['percentage']; ?>%</div>
                  </div>
                  </a>
                  <?php endforeach;  */ ?>
                  
                </div>
    </div>
    <?php } ?>
    
    
              <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Campaign<span class="badge pull-right mycampaignajaxcount"></span></h3>
              </div>
              <div class="panel-body mycampaignajax" style="padding:0;">
                  <!-- PRIVATE SEARCHES -->
                 
                  
                  <?php /* foreach ($private_campaigns_new as $campaign):?>
                  <?php $user_icon = explode(",", $campaign['image']);$bg_colour = $user_icon[1];$bg_colour_text = $user_icon[2];$bg_colour_name = $user_icon[0];?>
                    <a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $campaign['id']; ?>" class="load-saved-search" <?php echo strlen($campaign['name']) > 36 ? 'title="'.$campaign['name'].'"':"" ?>><div class="row">
                  <div class="col-xs-1"><span class="label label-info" style="margin-right:3px;background-color: <?php echo $bg_colour; ?>;font-size:8px; color: <?php echo $bg_colour_text;?>"><b><?php echo $bg_colour_name; ?></b>
                    </span></div>
                  <div class="col-xs-9" style="min-height:30px;overflow:hidden"><?php echo $campaign['name'];?><br><span style="font-size:9px;"><?php echo 'Created: '. $campaign['datecreated'];?></span></div>
                  <div class="col-xs-1" style="padding: 0 0 0 0px; font-size: 11px;"><?php echo $campaign['percentage']; ?>%</div>
                  </div>
                  </a>
                  <?php endforeach;  */ ?>
                  
                  
              </div>
            </div>
                
               <?php   if($current_user['department'] != 'data'){ ?>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Recent Campaigns<span class="badge pull-right"><?php //echo count($shared_campaigns); ?></span></h3>    
              </div>
              <div class="panel-body" style="padding:0;">
              <div id="campaignList">
                  <!-- SHARED SEARCHES -->
                  
                  
                 

<?php   $showCampaignType  = 'private=true'; ?>

                  <?php foreach ($shared_campaigns as $campaign):?>
                  
                  <?php
                                                                 
              $showCampaignType  = 'private=true';
             if(($campaign->evergreen_id)){
                    //echo $campaign->evergreen_id;
             $showCampaignType =  'evergreen='.$campaign->evergreen_id; 
             } ?>
                  
                  
              
                    <?php $user_icon = explode(",", $campaign->image);$bg_colour = $user_icon[1];$bg_colour_text = $user_icon[2];$bg_colour_name = $user_icon[0];?>
                    <a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $campaign->id; ?>&<?php echo   $showCampaignType; ?>" class="load-saved-search" <?php echo strlen($campaign->name) > 36 ? 'title="'.$campaign->name.'"':"" ?>><div class="row">
                  <div class="col-xs-1"><span class="label label-info" style="margin-right:3px;background-color: <?php echo $bg_colour; ?>;font-size:8px; color: <?php echo $bg_colour_text;?>"><b><?php echo $bg_colour_name; ?></b>
                    </span></div>
                  <div class="col-xs-9" style="max-height:15px;overflow:hidden"><?php echo $campaign->name;?></div>
                  <div class="col-xs-1" style="padding: 0 0 0 5px;"><b><?php //echo $campaign->campaigncount; ?></b></div>
                  </div>
                  </a>
                    <?php 
                                                                 
                                                                 //unset($showCampaignType);
                     endforeach; ?>
              </div><!--END CAMPAIGN LIST-->
          <!--<button type="submit" class="btn btn-success btn-block" id="loadMore">Load More</button>-->

              </div>
            </div>
                      <?php } ?>
                
          </div><!--END COL-3-->
</div><!--END ROW-->

