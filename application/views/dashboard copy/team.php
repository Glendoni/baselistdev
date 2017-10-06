<div class="row">
<?php echo $config['sess_expiration']; ?>
          <div class="col-sm-12" style="margin-bottom:20px;">

      <?php 
    
    
    if ($current_user['department'] == 'support'){  ?>
              <!-- Nav tabs -->
              <ul class="nav nav-tabs dashboard" role="tablist">
                <li role="presentation" class="active"><button href="#team_stats" aria-controls="team_stats" role="tab" data-toggle="tab" class="btn btn-primary btn-sm" style="margin-right:10px;" onclick="ga('send','event','Clicks','Stats','<?php echo $current_user['id'];?>')">Pods</button></li>
                <li role="presentation"><button href="#calls" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm c-a-m" style="margin-right:10px;" >Schedule</button></li>
              </ul>
<?php } else {?>
<!-- Nav tabs -->

<?php /* ?>
              <ul class="nav nav-tabs dashboard" role="tablist">
                <li role="presentation" class="active"><button href="#team_stats" aria-controls="team_stats" role="tab" data-toggle="tab" class="btn btn-primary btn-sm" style="margin-right:10px;" onclick="ga('send','event','Clicks','Stats','<?php echo $current_user['id'];?>')">Stats</button></li>
                <li role="presentation"><button href="#calls" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm c-a-m" style="margin-right:10px;" >Schedule</button></li>
                <li role="presentation"><button href="#pipeline" aria-controls="pipeline" role="tab" data-toggle="tab" class="btn btn-primary btn-sm" style="margin-right:10px;" onclick="ga('send','event','Clicks','Pipeline','<?php echo $current_user['id'];?>')">Pipeline</button></li>
                  
                   <li role="presentation"><button href="#intents" aria-controls="assigned" role="tab" data-toggle="tab" class="btn btn-primary btn-sm" style="margin-right:10px;" onclick="ga('send','event','Clicks','Intents','<?php echo $current_user['id'];?>')">Intent</button></li> 
                  
                  <li role="presentation"><button href="#proposals" aria-controls="assigned" role="tab" data-toggle="tab" class="btn btn-primary btn-sm" style="margin-right:10px;" onclick="ga('send','event','Clicks','Proposals','<?php echo $current_user['id'];?>')">Proposals</button></li> 
                  
                   <li role="presentation"><button href="#assigned" aria-controls="assigned" role="tab" data-toggle="tab" class="btn btn-primary btn-sm" style="margin-right:10px;" onclick="ga('send','event','Clicks','Favourites','<?php echo $current_user['id'];?>')">Favourites</button></li>
               <!-- <li><button href="companies/pipeline"role="tab" class="button btn btn-primary btn-sm deals_pipeline" style="margin-right:10px;" onclick="window.location ='companies/pipeline'">Deals Forecast</button></li> -->
                  
                <li role="presentation"><button href="#emailegagement" aria-controls="emailegagement" role="tab" data-toggle="tab" class="btn btn-primary btn-sm" style="margin-right:10px;" onclick="ga('send','event','Clicks','Email Engagement','<?php echo $current_user['id'];?>')">Email Engagement</button></li>   


<?php */ ?> 
              </ul>
  <?php }; ?>
          </div>
        </div>
<div class="row">          
<div class="col-sm-12">

      <div class="panel panel-default">
          <div class="panel-heading">
          <h3 class="panel-title">Date Range Search</h3>
          </div>
          <div class="panel-body">
            <form class="form-inline" role="form">
            <div class="form-group col-md-3 col-sm-push-3 ">
            <label for="start-date">From</label>
            <input type="text" class="form-control" id="start_date" data-date-format="DD-MM-YYYY" name="start_date" placeholder="" value="<?php echo  date('d-m-Y',strtotime($dates['start_date']));?>">
            </div>
            <div class="form-group col-md-3 col-sm-push-2" style="
    margin-left: 10px;
">
            <label for="end-date">To</label>
            <input type="text" class="form-control" id="end_date" data-date-format="DD-MM-YYYY" name="end_date" placeholder="" value="<?php echo  date('d-m-Y',strtotime($dates['end_date']));?>">
            </div>
            <div class="form-group col-md-1 col-sm-push-1" style="
    margin-left: 0px;
">
            <input type="hidden" name="search" value="3">
            <?php if (isset($_GET['user'])) { ?>
             <input type="hidden" name="user" value="<?php echo $_GET['user'];?>"> <?php
             };?>
            <button type="submit" class="btn btn-primary btn-block btn-warning">Search</button>
            </div>
            </form>
          </div>
        </div><!--END PANEL-->

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
                            <div class="user-stat company"><a href="<?php echo site_url(); ?>companies/company?id=<?php echo $get_user_placements['id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>><?php echo $get_user_placements['name'];?></a></div>
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
                            <div class="user-stat company"><div class="user-stat company"><a href="<?php echo site_url(); ?>companies/company?id=<?php echo $get_user_proposals['id'] ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>><?php echo $get_user_proposals['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_proposals['created_at']));?></div>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3">
                            <?php foreach ($getusermeetings as $get_user_meetings): ?>
                              <li class="user-stat-holder">
                            <div class="user-stat company"><a href="<?php echo site_url(); ?>companies/company?id=<?php echo $get_user_meetings['id'] ?>"  <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>><?php echo $get_user_meetings['name'];?></a></div>
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
                            <div class="user-stat company"><a href="<?php echo site_url(); ?>companies/company?id=<?php echo $get_user_demos['id'] ?>"  <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>><?php echo $get_user_demos['name'];?></a></div>
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

        <?php
        //Level 0
        ob_start();
        ?>
        <div class="panel panel-default ff">
        <div class="panel-heading">
        <h3 class="panel-title">FF - Team of 6</h3>
        </div>
        <div class="panel-body" style="font-size:12px;">
        <div class="list-group">
        <?php if(empty($stats)) : ?>
        <div class="col-md-12">
        <div style="margin:10px 0;">
        <h4 style="margin: 50px 0 40px 0; text-align: center;">You have no recent activity.</h4>
        </div>
        </div>
        <?php else: ?>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
        <li <?php if ($_GET['period'] == 'lastmonth'): ?>class="active"<?php endif; ?>><a href="#lastmonth" class="stats" role="tab" data-toggle="tab">Last Month</a></li>
        <li <?php if ($_GET['period'] == 'month'): ?>class="active"<?php endif; ?>><a href="#currentmonth"  class="stats" role="tab" data-toggle="tab">This Month</a></li>
        <li <?php if ($_GET['period'] == 'lastweek'): ?>class="active"<?php endif; ?>><a href="#lastweek"  class="stats" role="tab" data-toggle="tab">Last Week</a></li>
        <li <?php if (($_GET['period'] == 'week') ||  (empty($_GET['period'])) && ($_GET['search'] !=='3')): ?>class="active"<?php endif; ?>><a href="#this" role="tab" data-toggle="tab">This Week</a></li>



        <?php if ($_GET['search'] == '3'): ?>
        <li <?php if ($_GET['search'] == '3'): ?>class="active"<?php endif; ?>><a href="#searchresults" role="tab" data-toggle="tab">Search Results</a></li>
        <?php endif; ?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
        <div class="tab-pane fade <?php if (($_GET['period'] == 'week') ||  (empty($_GET['period'])) && ($_GET['search'] !=='3')): ?>active in <?php endif; ?>" id="this">
        <div class="col-md-12">
        </div>
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>

        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="tw-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="tw-proposals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="tw-demobookedcount-total stat-total" >4</span> /
        <span class="tw-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="tw-meetingbooked-total stat-total" >0</span> /  
        <span class="tw-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="tw-salescall-total stat-total" >0</span> / 
        <span class="tw-introcall-total stat-total">0</span>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="tw-key_review_added-total stat-total">0</span> / 
        <span class="tw-key_review_occuring-total stat-total">5</span>
        </div>

        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="tw-duediligence-total stat-total">0</span>
        </div>
        </div>


        <?php foreach ($stats as $stat): ?>
        <div class="row list-group-item stats-row active-<?php echo $stat['active'];?>">
        <div class="col-xs-2 col-md-1"> 
        <a href = "?search=2&user=<?php echo $stat['user'];?>&period=week">
        <?php $user_icon = explode(",",$stat['image']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
        </a>
        </div>
        <div class="col-xs-1 col-md-1 text-center">
        <a href = "?search=2&user=<?php echo $stat['user'];?>&period=week"><span class="tw-deals"><?php echo $stat['deals'];?></span></a>
        </div>
        <div class="col-xs-2 col-md-1 text-center"> 
        <?php echo '<div class="tw-proposals">'.$stat['proposals'].'</div>';?>
        </div>
        <div class="col-xs-2 col-md-2 text-center"> 
        <span class="tw-demobookedcount"><?php echo $stat['demobookedcount'];?></span> / <span class="tw-democount"><?php echo $stat['democount'];?></span>
        </div>
        <div class="col-xs-2 col-md-1 text-center">
        <span class="tw-meetingbooked"><?php echo $stat['meetingbooked'];?></span> / <span class="tw-meetingcount"><?php echo $stat['meetingcount'];?></span>
        </div>
        <div class="col-xs-2 col-md-2 text-center"> 
        <span class="tw-salescall"><?php echo $stat['salescall'];?></span> / <span class="tw-introcall"><?php echo $stat['introcall'];?></span>
        </div>
        <div class="col-md-2 hidden-xs text-center">
        <span class="tw-key_review_added"><?php echo $stat['key_review_added'];?></span> / <span class="tw-key_review_occuring"><?php echo $stat['key_review_occuring'];?></span>
        </div>
        <div class="col-md-1 hidden-xs text-center">
        <span class="tw-duediligence"><?php echo $stat['duediligence'];?></span>
        </div>
        </div> <!--END ROW-->    
        <?php endforeach ?>
        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->

        <div class="tab-pane fade <?php if ($_GET['period'] == 'lastweek'): ?>active in <?php endif; ?>" id="lastweek">
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>
        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="lw-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="lw-proposals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="lw-demobookedcount-total stat-total" >16</span> /
        <span class="lw-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="lw-meetingbooked-total stat-total" >0</span> /  
        <span class="lw-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="lw-salescall-total stat-total" >1</span> / 
        <span class="lw-introcall-total stat-total">0</span>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="lw-key_review_added-total stat-total">0</span> / 
        <span class="lw-key_review_occuring-total stat-total">5</span>
        </div>


        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="lw-duediligence-total stat-total">0</span>

        </div>

        </div>

        <div id="tslastweek" ></div>


        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->


        <div class="tab-pane fade <?php if ($_GET['period'] == 'month'): ?>active in <?php endif; ?>" id="currentmonth">
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>

        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="tm-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="tm-proposals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="tm-demobookedcount-total stat-total" >16</span> /
        <span class="tm-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="tm-meetingbooked-total stat-total" >0</span> /  
        <span class="tm-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="tm-salescall-total stat-total" >1</span> / 
        <span class="tm-introcall-total stat-total">0</span>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="tm-key_review_added-total stat-total">0</span> / 
        <span class="tm-key_review_occuring-total stat-total">5</span>
        </div>


        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="tm-duediligence-total stat-total">0</span>

        </div>

        </div>

        <div id="tscurrentmonth"></div>

        <div id="thismonthstats"></div>

        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->

        <div class="tab-pane fade <?php if ($_GET['period'] == 'lastmonth'): ?>active in <?php endif; ?>" id="lastmonth">
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>

        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="lm-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="lm-proposals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="lm-demobookedcount-total stat-total" >16</span> /
        <span class="lm-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="lm-meetingbooked-total stat-total" >0</span> /  
        <span class="lm-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="lm-salescall-total stat-total" >1</span> / 
        <span class="lm-introcall-total stat-total">0</span>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="lm-key_review_added-total stat-total">0</span> / 
        <span class="lm-key_review_occuring-total stat-total">5</span>
        </div>


        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="lm-duediligence-total stat-total">0</span>

        </div>

        </div>


        <div id="tslastmonth"></div>

        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->

        <div class="tab-pane fade <?php if ($_GET['search'] == '3'): ?>active in <?php endif; ?>" id="searchresults">
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>

        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="sr-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="sr-proposals-total stat-total" >0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="sr-demobookedcount-total stat-total" >0</span> /
        <span class="sr-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="sr-meetingbooked-total stat-total" >0</span> /  
        <span class="sr-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="sr-salescall-total stat-total" >1</span> / 
        <span class="sr-introcall-total stat-total">0</span>
        </div>
       
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="sr-key_review_added-total stat-total">0</span> / 
        <span class="sr-key_review_occuring-total stat-total">0</span>
        </div>


        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="sr-duediligence-total stat-total">0</span>

        </div>

        </div>








        <?php foreach ($getstatssearch as $getstatssearch): ?>
        <div class="row list-group-item stats-row active-<?php echo $lastmonthstat['active'];?>">
        <div class="col-xs-2 col-md-1">
        <a href = "?search=2&user=<?php echo $getstatssearch['user'];?>&period=lastmonth"> 
        <?php $user_icon = explode(",",$getstatssearch['image']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
        </a>
        </div>
        <div class="col-xs-2 col-md-1 text-center">
        <a href = "?search=2&user=<?php echo $getstatssearch['user'];?>&start_date=<?php echo $_GET['start_date']?>&end_date=<?php echo $_GET['end_date']?>&period=search"><span class="sr-deals"><?php echo $getstatssearch['deals'];?></span></a>
        </div>
        <div class="col-xs-2 col-md-1 text-center"> 
        <?php echo '<div class=" sr-proposals" >'.$getstatssearch['proposals'].'</div>';?>
        </div>
        <div class="col-xs-2 col-md-2 text-center"> 
        <span class="sr-demobookedcount"><?php echo $getstatssearch['demobookedcount'];?></span> / <span class="sr-democount"><?php echo $getstatssearch['democount'];?></span>
        </div>
        <div class="col-xs-1 col-md-1 text-center">
        <span class="sr-meetingbooked"><?php echo $getstatssearch['meetingbooked'];?></span> / <span class="sr-meetingcount"><?php echo $getstatssearch['meetingcount'];?></span>
        </div>
        <div class="col-xs-2 col-md-2 text-center"> 
        <span class="sr-salescall"><?php echo $getstatssearch['salescall'];?></span> / <span class="sr-introcall"><?php echo $getstatssearch['introcall'];?></span>
        </div>
        
        <div class="col-md-2 hidden-xs text-center">
        <span class="sr-key_review_added"><?php echo $getstatssearch['key_review_added'];?></span> / <span class="sr-key_review_occuring"><?php echo $getstatssearch['key_review_occuring'];?></span>
        </div>
        <div class="col-md-1 hidden-xs text-center">
        <span class="sr-duediligence"><?php echo $getstatssearch['duediligence'];?></span>
        </div>
        </div> <!--END ROW-->    
        <?php endforeach ?>
        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->

        </div>
        <?php endif ?>
        </div>
        </div>

        </div><!--END PANEL-->  
        <?php 
        $out1 = ob_get_contents();
        ob_end_clean();
        ?> 
        <?php
        //Level 0
        ob_start();
        ?>
        <div class="panel panel-default uf">
        <div class="panel-heading">
        <h3 class="panel-title">With Finance - Team of 8</h3>
        </div>
        <div class="panel-body" style="font-size:12px;">
        <div class="list-group">
        <?php if(empty($stats)) : ?>
        <div class="col-md-12">
        <div style="margin:10px 0;">
        <h4 style="margin: 50px 0 40px 0; text-align: center;">You have no recent activity.</h4>
        </div>
        </div>
        <?php else: ?>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
        <li <?php if ($_GET['period'] == 'lastmonth'): ?>class="active"<?php endif; ?>><a href="#ulastmonth" class="stats" role="tab" data-toggle="tab">Last Month</a></li>
        <li <?php if ($_GET['period'] == 'month'): ?>class="active"<?php endif; ?>><a href="#ucurrentmonth"  class="stats" role="tab" data-toggle="tab">This Month</a></li>
        <li <?php if ($_GET['period'] == 'lastweek'): ?>class="active"<?php endif; ?>><a href="#ulastweek"  class="stats" role="tab" data-toggle="tab">Last Week</a></li>
        <li <?php if (($_GET['period'] == 'week') ||  (empty($_GET['period'])) && ($_GET['search'] !=='3')): ?>class="active"<?php endif; ?>><a href="#uthis" role="tab" data-toggle="tab">This Week</a></li>



        <?php if ($_GET['search'] == '3'): ?>
        <li <?php if ($_GET['search'] == '3'): ?>class="active"<?php endif; ?>><a href="#usearchresults" role="tab" data-toggle="tab">Search Results</a></li>
        <?php endif; ?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
        <div class="tab-pane fade <?php if (($_GET['period'] == 'week') ||  (empty($_GET['period'])) && ($_GET['search'] !=='3')): ?>active in <?php endif; ?>" id="uthis">
        <div class="col-md-12">
        </div>
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>

        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="utw-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="utw-proposals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="utw-demobookedcount-total stat-total" >0</span> /
        <span class="utw-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="utw-meetingbooked-total stat-total" >0</span> /  
        <span class="utw-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="utw-salescall-total stat-total" >0</span> / 
        <span class="utw-introcall-total stat-total">0</span>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="utw-key_review_added-total stat-total">0</span> / 
        <span class="utw-key_review_occuring-total stat-total">0</span>
        </div>

        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="utw-duediligence-total stat-total">0</span>
        </div>
        </div>


        <?php foreach ($ustats as $stat): ?>
        <div class="row list-group-item stats-row active-<?php echo $stat['active'];?>">
        <div class="col-xs-2 col-md-1"> 
        <a href = "?search=2&user=<?php echo $stat['user'];?>&period=week">
        <?php $user_icon = explode(",",$stat['image']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
        </a>
        </div>
        <div class="col-xs-1 col-md-1 text-center">
        <a href = "?search=2&user=<?php echo $stat['user'];?>&period=week"><span class="utw-deals"><?php echo $stat['deals'];?></span></a>
        </div>
        <div class="col-xs-2 col-md-1 text-center"> 
        <?php echo '<div class="utw-proposals">'.$stat['proposals'].'</div>';?>
        </div>
        <div class="col-xs-2 col-md-2 text-center"> 
        <span class="utw-demobookedcount"><?php echo $stat['demobookedcount'];?></span> / <span class="utw-democount"><?php echo $stat['democount'];?></span>
        </div>
        <div class="col-xs-2 col-md-1 text-center">
        <span class="utw-meetingbooked"><?php echo $stat['meetingbooked'];?></span> / <span class="utw-meetingcount"><?php echo $stat['meetingcount'];?></span>
        </div>
        <div class="col-xs-2 col-md-2 text-center"> 
        <span class="utw-salescall"><?php echo $stat['salescall'];?></span> / <span class="utw-introcall"><?php echo $stat['introcall'];?></span>
        </div>
        <div class="col-md-2 hidden-xs text-center">
        <span class="utw-key_review_added"><?php echo $stat['key_review_added'];?></span> / <span class="utw-key_review_occuring"><?php echo $stat['key_review_occuring'];?></span>
        </div>
        <div class="col-md-1 hidden-xs text-center">
        <span class="utw-duediligence"><?php echo $stat['duediligence'];?></span>
        </div>
        </div> <!--END ROW-->    
        <?php endforeach ?>
        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->

        <div class="tab-pane fade <?php if ($_GET['period'] == 'lastweek'): ?>active in <?php endif; ?>" id="ulastweek">
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>
        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="ulw-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="ulw-proposals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="ulw-demobookedcount-total stat-total" >0</span> /
        <span class="ulw-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="ulw-meetingbooked-total stat-total" >0</span> /  
        <span class="ulw-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="ulw-salescall-total stat-total" >0</span> / 
        <span class="ulw-introcall-total stat-total">0</span>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="ulw-key_review_added-total stat-total">0</span> / 
        <span class="ulw-key_review_occuring-total stat-total">5</span>
        </div>


        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="ulw-duediligence-total stat-total">0</span>

        </div>

        </div>

        <div id="utslastweek" ></div>


        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->


        <div class="tab-pane fade <?php if ($_GET['period'] == 'month'): ?>active in <?php endif; ?>" id="ucurrentmonth">
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>

        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="utm-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="utm-proposals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="utm-demobookedcount-total stat-total" >16</span> /
        <span class="utm-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="utm-meetingbooked-total stat-total" >0</span> /  
        <span class="utm-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="utm-salescall-total stat-total" >1</span> / 
        <span class="utm-introcall-total stat-total">0</span>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="utm-key_review_added-total stat-total">0</span> / 
        <span class="utm-key_review_occuring-total stat-total">5</span>
        </div>


        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="utm-duediligence-total stat-total">0</span>

        </div>

        </div>

        <div id="utscurrentmonth"></div>

        <div id="uthismonthstats"></div>

        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->

        <div class="tab-pane fade <?php if ($_GET['period'] == 'lastmonth'): ?>active in <?php endif; ?>" id="ulastmonth">
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>

        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="ulm-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="ulm-proposals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="ulm-demobookedcount-total stat-total" >16</span> /
        <span class="ulm-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="ulm-meetingbooked-total stat-total" >0</span> /  
        <span class="ulm-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="ulm-salescall-total stat-total" >1</span> / 
        <span class="ulm-introcall-total stat-total">0</span>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="ulm-key_review_added-total stat-total">0</span> / 
        <span class="ulm-key_review_occuring-total stat-total">5</span>
        </div>


        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="ulm-duediligence-total stat-total">0</span>

        </div>

        </div>


        <div id="utslastmonth"></div>

        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->

        <div class="tab-pane fade <?php if ($_GET['search'] == '3'): ?>active in <?php endif; ?>" id="usearchresults">
        <div class="col-md-12">
        <div class="row list-group-item">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Name</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <strong class="tsDealTitle">Deals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow" >
        <strong class="tsPropTitle">Proposals</strong>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow">
        <strong>Demos</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <strong>Meetings</strong><br>
        <Small>Booked/Done</Small>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow"> 
        <strong>Call Activity</strong><br>
        <Small>Total Calls/Intro</Small>
        </div>
        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
        <strong>Review Months</strong><br>
        <Small>Added/Occuring</Small>
        </div>
        <div class="col-md-1 hidden-xs text-center hide-overflow">
        <strong>DueDil</strong>
        </div>
        </div>

        <div class="row list-group-item dashboardTotalheaders">
        <div class="col-xs-2 col-md-1 hide-overflow"> 
        <strong>Totals</strong>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="usr-deals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow">
        <span class="usr-proposals-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-2 text-center hide-overflow" >
        <span class="usr-demobookedcount-total stat-total" >0</span> /
        <span class="usr-democount-total stat-total"  >0</span>
        </div>
        <div class="col-xs-1 col-md-1 text-center hide-overflow">
        <span class="usr-meetingbooked-total stat-total" >0</span> /  
        <span class="usr-meetingcount-total stat-total" >0</span>
        </div>

        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="usr-salescall-total stat-total" >1</span> / 
        <span class="usr-introcall-total stat-total">0</span>
        </div>
        
        <div class="col-md-2 hidden-xs text-center hide-overflow">
        <span class="usr-key_review_added-total stat-total">0</span> / 
        <span class="usr-key_review_occuring-total stat-total">0</span>
        </div>
        <div class="col-xs-2 col-md-1 text-center hide-overflow"> 
        <span class="usr-duediligence-total stat-total">0</span>

        </div>

        </div>

        <?php 
           
            foreach ($ugetstatssearch as $getstatssearch): ?>
            
            
        <div class="row list-group-item stats-row active-<?php echo $lastmonthstat['active'];?>">
        <div class="col-xs-2 col-md-1">
        <a href = "?search=2&user=<?php echo $getstatssearch['user'];?>&period=lastmonth"> 
        <?php $user_icon = explode(",",$getstatssearch['image']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
        </a>
        </div>
        <div class="col-xs-2 col-md-1 text-center">
        <a href = "?search=2&user=<?php echo $getstatssearch['user'];?>&start_date=<?php echo $_GET['start_date']?>&end_date=<?php echo $_GET['end_date']?>&period=search"><span class="usr-deals"><?php echo $getstatssearch['deals'];?></span></a>
        </div>
        <div class="col-xs-2 col-md-1 text-center"> 
        <?php echo '<div class="usr-proposals">'.$getstatssearch['proposals'].'</div>';?>
        </div>
        <div class="col-xs-2 col-md-2 text-center"> 
        <span class="usr-demobookedcount"><?php echo $getstatssearch['demobookedcount'];?></span> / <span class="usr-democount"><?php echo $getstatssearch['democount'];?></span>
        </div>
        <div class="col-xs-1 col-md-1 text-center">
        <span class="usr-meetingbooked"><?php echo $getstatssearch['meetingbooked'];?></span> / <span class="usr-meetingcount"><?php echo $getstatssearch['meetingcount'];?></span>
        </div>
        <div class="col-xs-2 col-md-2 text-center"> 
        <span class="usr-salescall"><?php echo $getstatssearch['salescall'];?></span> / <span class="usr-introcall"><?php echo $getstatssearch['introcall'];?></span>
        </div>
      
        <div class="col-md-2 hidden-xs text-center">
        <span class="usr-key_review_added"><?php echo $getstatssearch['key_review_added'];?></span> / <span class="usr-key_review_occuring"><?php echo $getstatssearch['key_review_occuring'];?></span>
        </div>
        <div class="col-md-1 hidden-xs text-center">
        <span class="usr-duediligence"><?php echo $getstatssearch['duediligence'];?></span>
        </div>
        </div> <!--END ROW-->    
        <?php endforeach ?>
        </div><!--END COL-MD-12-->
        </div><!--END THIS TAB-->

        </div>
        <?php endif ?>
        </div>
        </div>

        </div><!--END PANEL-->  

        <?php 
        $out2 = ob_get_contents();
        ob_end_clean();

        ?>
        <?php 
        if($current_user['market'] == 'uf'){
            echo $out2 . $out1;
        }else{
            echo $out1.$out2;
        } ;
        ?>

  

    

<div class="tab-content mobile-hide" style="display:none;">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Tagging Summary</h3>
</div>
<div class="panel-body">

<div class="col-md-12">
                      <div class="row list-group-item">

                        <div class="col-xs-2 col-md-2 hide-overflow"> 
                            <strong>Name</strong>
                        </div>
                        <div class="col-xs-2 col-md-2 text-center hide-overflow">
                            <strong>Last 7 Days</strong>
                        </div>
                        <div class="col-xs-2 col-md-2 text-center hide-overflow">
                            <strong>Last 30 Days</strong>
                        </div>
                        <div class="col-xs-2 col-md-2 text-center hide-overflow">
                            <strong>Last 100 Days</strong><br>
                        </div>
                        <div class="col-xs-2 col-md-2 text-center hide-overflow">
                            <strong>Days Since Last Tag</strong><br>
                        </div>
                      </div>
                    
                      <?php foreach ($tagssummary as $tagsummary): ?>
                    <div class="row list-group-item stats-row" style="font-size:12px;    padding: 5px 0;">
                      <div class="col-xs-2 col-md-2" style="padding-top: 9px;">
                            <?php $user_icon = explode(",",$tagsummary['image']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";    margin-top:-10px;'>".$user_icon[0]."</div>";?>
                      </div>
                            <div class="col-xs-2 col-md-2 text-center" style="padding-top: 9px;">
                            <?php echo $tagsummary['7days'];?>
                            </div>
                             <div class="col-xs-2 col-md-2 text-center" style="padding-top: 9px;">
                            <?php echo $tagsummary['30days'];?>
                            </div>
                             <div class="col-xs-2 col-md-2 text-center" style="padding-top: 9px;">
                            <?php echo $tagsummary['100days'];?>
                            </div>
                            <div class="col-xs-2 col-md-2 text-center" style="padding-top: 9px;">

<?php if ($tagsummary['lasttag'] < 1): ?>

        Today

<?php elseif ($tagsummary['lasttag'] <2): ?>

        1 Day

<?php else: echo $tagsummary['lasttag']." Days" ?>

    

<?php endif; ?>
                            </div>
                          </div> <!--END ROW-->    
      <?php endforeach ?>



</div>
</div>
</div>
</div>

        <?php foreach($campaignsummary as $get_user_campaign)
        {?>

<div class="tab-content mobile-hide">
<div class="panel panel-default" style="display:none;">
<div class="panel-heading">

<h3 class="panel-title pull-left">Campaign Summary</h3>
<?php if ($current_user['permission'] == 'admin'): ?>
<ul class="nav nav-tabs dashboard" role="tablist">
<li role="presentation" class="active"><button href="#campaign_user" aria-controls="campaign_user" role="tab" data-toggle="tab" class="btn btn-primary btn-xs pull-right" style="margin-right:10px; margin-left:10px;    font-size: 10px;">My Campaigns</button></li>
<li role="presentation"><button href="#campaign_team" aria-controls="campaign_team" role="tab" data-toggle="tab" class="btn btn-primary btn-xs pull-right" style="margin-right:10px;    font-size: 10px;">Team Campaign</button></li>

              </ul>

<?php endif; ?>
        <div class="clearfix"></div>

</div>
<div class="panel-body">
  <div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="campaign_user">


<div class="col-sm-2 mobile-hide">
<div class="circle-responsive_campiagns black-circle-campaign  <?php echo empty($this->session->userdata('pipeline'))? 'active':'';?>"><div class="circle-content mega">
<div class="large-number"><?php echo $get_user_campaign->campaign_total; ?></div> <div class="small-text">Companies
</div>

</div>
</div>
<div class="small-text-unsuitable"><?php if ($get_user_campaign->campaign_unsuitable > "0") {echo "Includes ".$get_user_campaign->campaign_unsuitable." marked as unsuitable";} else {}?></div>
</div>
<div class="col-sm-2 mobile-hide">
<div class="circle-responsive_campiagns cyan-circle contacted_percentage_campaign">
<div class="circle-content mega">
<div class="large-number"><?php echo $get_user_campaign->contacted; ?><span style="font-size:32px;">%</span></div>
<div class="small-text">Contacted</div>


</div>
</div>
<div class="small-text-unsuitable"><?php if ($get_user_campaign->campaign_unsuitable > "0") {echo "Companies marked as Unsuitable are not included in this figure.";} else {}?></div>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($get_user_campaign->campaign_prospects>0): ?>
<?php else: endif; ?>
<div class="circle-responsive prospect-circle <?php if ($this->session->userdata('pipeline')=='prospect'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $get_user_campaign->campaign_prospects; ?></div>
<div class="small-text"><?php echo "Prospect" ; ?></div></div>
</div>
<?php if ($get_user_campaign->campaign_prospects>0): ?>
<?php else: endif; ?>
</div>

<div class="col-sm-2 mobile-hide">
<?php if ($get_user_campaign->campaign_intent>0): ?>
<?php else: endif; ?>
<div class="circle-responsive intent-circle <?php if ($this->session->userdata('pipeline')=='intent'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $get_user_campaign->campaign_intent; ?></div>
<div class="small-text">Intent</div></div>
</div>
<?php if ($get_user_campaign->campaign_intent>0): ?>
<?php else: endif; ?>
</div>

<div class="col-sm-2 mobile-hide">
<?php if ($get_user_campaign->campaign_proposals>0): ?>
<?php else: endif; ?>
<div class="circle-responsive proposal-circle <?php if ($this->session->userdata('pipeline')=='proposal'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $get_user_campaign->campaign_proposals; ?></div>
<div class="small-text"><?php  echo "Proposal";?></div></div>
</div>
<?php if ($get_user_campaign->campaign_proposals>0): ?>
<?php else: endif; ?>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($get_user_campaign->campaign_customers>0): ?>
<?php else: endif; ?>
<div class="circle-responsive customer-circle <?php if ($this->session->userdata('pipeline')=='customer'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $get_user_campaign->campaign_customers; ?></div>
<div class="small-text"><?php if ($get_user_campaign->campaign_customers <> "1") {echo "Customer";} else { echo "Customer";}?></div></div>
</div>
<?php if ($get_user_campaign->campaign_customers>0): ?>
<?php else: endif; ?>
</div>

</div>
<?php if ($current_user['permission'] == 'admin'): ?>

    <div role="tabpanel" class="tab-pane fade" id="campaign_team">
      <div class="col-md-12">
                      <div class="row list-group-item">
                        <div class="col-xs-2 col-md-1 hide-overflow"> 
                            <strong>Name</strong>
                        </div>
                        <div class="col-xs-2 col-md-2 text-center hide-overflow">
                            <strong>Company</strong>
                        </div>
                        <div class="col-xs-3 col-md-2 text-center hide-overflow">
                            <strong>Contacted</strong>
                        </div>
                        <div class="col-xs-2 col-md-1 text-center hide-overflow">
                            <strong>Prospect</strong>
                        </div>
                        <div class="col-xs-3 col-md-1 text-center hide-overflow"> 
                           <strong>Intent</strong>
                        </div>
                        <div class="col-md-1 hidden-xs text-center hide-overflow">
                           <strong>Proposal</strong>
                        </div>
                        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
                           <strong>Customer</strong>
                        </div>
                        <div class="col-md-2 hidden-xs text-center hide-overflow">
                           <strong>Other</strong></br>
                          <Small>Lost / Unsuitable</Small>
                        </div>
                        </div>
                            <?php foreach ($teamcampaignsummary as $teamcampaigns): ?>
                              <div class="row list-group-item stats-row">
                            <div class="col-xs-2 col-md-1"> 
                            <?php $user_icon = explode(",",$teamcampaigns['userimage']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
                            </div>

                    
                        <div class="col-xs-2 col-md-2 text-center hide-overflow">
                            <?php echo $teamcampaigns['campaign_total'];?>
                        </div>
                        <div class="col-xs-3 col-md-2 text-center hide-overflow">
                            <?php echo $teamcampaigns['contacted'];?>%
                        </div>
                        <div class="col-xs-2 col-md-1 text-center hide-overflow">
                            <?php echo $teamcampaigns['campaign_prospects'];?>
                        </div>
                        <div class="col-xs-3 col-md-1 text-center hide-overflow"> 
                            <?php echo $teamcampaigns['campaign_intent'];?>
                        </div>
                        <div class="col-md-1 hidden-xs text-center hide-overflow">
                            <?php echo $teamcampaigns['campaign_proposals'];?>
                        </div>
                        <div class="col-md-2 hidden-xs text-center hide-overflow"> 
                            <?php echo $teamcampaigns['campaign_customers'];?>
                        </div>
                          <div class="col-md-2 hidden-xs text-center hide-overflow">
                          <?php echo $teamcampaigns['campaign_lost'];?> / <?php echo $teamcampaigns['campaign_unsuitable'];?>
                          </div>
                        </div>
                      <?php endforeach ?>
      </div><!--END COL-MD-12-->
    </div><!--END TEAM CAMPAIGN SUMMARY-->
                <?php endif; ?>



  </div><!--END CONTENT-->





</div>
</div>
</div>

<?php }?>
</div><!--END TAB-->
    <div role="tabpanel" class="tab-pane fade" id="calls"><div class="panel panel-default">
              <div class="panel-heading">
              <h3 class="panel-title">Your Schedule<span class="badge pull-right"><?php echo count($pending_actions); ?></span></h3>
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
            <div class="row record-holder-header mobile-hide">
            <div class="col-md-3" style="
    padding-left: -0px;
"><strong>Company</strong></div>
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
    <div class="col-md-1 homeSchedule">
                               
                            <?php   $now = $action->duedate; 
                                    $timestamp = strtotime($action->planned_at);
                                    $round = 5*60;
                                    $rounded = round($timestamp / $round) * $round;
                                    
                                    echo date('d/m/y', $timestamp)." ";
                                echo date("H:i", $rounded);
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
                    <span class="badge pull-right sortform" style="margin-top: -22px; margin-left: 0px;">
                 <form><lable>Display By:</lable>
                     <select   name="" >
                        
                         <option value>Company</option>
                         <option value="1">Pipeline</option>
                      
                     </select></form>
                  </span>
                <span class="badge pull-right favouritesCount" style="margin-top: -19px; apdding:5px;"><?php echo count($assigned_companies); ?></span>    
              </div>
<div class="panel-body" style="padding:0;">


                    <?php   if(empty($assigned_companies)) :  ?>
                    
                    <?php    else: ?>

                    <?php foreach ($assigned_companies as $assigned):?>

                              <a href="<?php echo site_url();?>companies/company?id=<?php echo $assigned->id;?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?> class="load-saved-search">
                              <div class="row">
                              <div class="col-xs-8">
                              <?php $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' ); echo str_replace($words, ' ',$assigned->name); ?>
                              </div>
                              <div class="col-xs-4">
                              <span class="label label-<?php echo str_replace(' ', '', $assigned->pipeline); ?>" style="margin-top: 3px;"><?php echo $assigned->pipeline;?>
                              <?php if (isset($company['customer_from'])):?> from <?php echo date("d/m/y",strtotime($company['customer_from']));?><?php endif; ?>
                              </span>
                              </div>
                              </div>
                              </a>

                      <?php endforeach ?>
                    <?php endif ?>
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
<?php if (isset($marketing->sent_id)) {?><a href="http://www.sonovate.com/?p=<?php echo $marketing->sent_id;?>" style="padding-right:5px;" target="_blank"><i class="fa fa-eye"></i></a><?php;}?> 

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
    
    <div class="panel-heading" id="proposals">
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
      <div class="row record-holder-proposals"></div>
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
    <div class="panel-heading" id="contacts">
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
      <div class="row record-holder-intents"></div>
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
<div class="col-sm-3 col-sm-pull-9">
    
    
    
     <?php   $dept = array('data','sales');

if(in_array($current_user['department'],$dept) ){ ?>
        
            <div class="panel panel-default"  style="display:none;">
              <div class="panel-heading">
                <h3 class="panel-title">My Evergreen Campaigns <span class="badge pull-right myevergreencount"></span></h3>
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
    
    
              <div class="panel panel-default"  style="display:none;">
              <div class="panel-heading">
                <h3 class="panel-title">My Campaigns <span class="badge pull-right mycampaignajaxcount"></span></h3>
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
          
                
          </div><!--END COL-3-->
</div><!--END ROW-->

