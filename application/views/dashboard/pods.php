<div class="row">
<?php echo $config['sess_expiration']; ?>
          <div class="col-sm-9" style="margin-bottom:20px;">

      <?php 
    
    
    if ($current_user['department'] == 'support'){  ?>
              <!-- Nav tabs -->
              <ul class="nav nav-tabs dashboard" role="tablist">
              
                                                 <li role="presentation" class="active"><button href="#podone" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm c-a-m" style="margin-right:10px;" >Pod 1</button></li>
                             <li role="presentation"><button href="#podtwo" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm c-a-m" style="margin-right:10px;" >Pod 2</button></li>
                               <li role="presentation"><button href="#podthree" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm c-a-m" style="margin-right:10px;" >Pod 3</button></li> 
                <li role="presentation"><button href="#calls" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm c-a-m" style="margin-right:10px;" >Schedule</button></li>
              </ul>
<?php }  ?>
          </div>
        </div>
<div class="row">          
<div class="col-sm-12">
<!-- Tab panes -->
<div class="tab-content">
 
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
            <div class="col-md-3"><strong>Company</strong></div>
            <div class="col-md-2"><strong>Phone</strong></div>
            <div class="col-md-2"><strong>Action</strong></div>
            <div class="col-md-2  "><strong>Due</strong></div>
            <div class="col-md-3 "><strong>Actions</strong></div>
            </div>


                    <?php foreach ($pending_actions as $action): 
                         // print_r('<pre>');print_r($action);print_r('</pre>');
                        // die;
                      ?>
                          <div class="row list-group-item <?php if( strtotime($action->planned_at) < strtotime('today')  ) { echo ' delayed';} ?> " style="font-size:12px;">
                            <div class="col-md-3"> 
                              <a href="<?php echo site_url();?>companies/company?id=<?php echo $action->company_id;?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>
                                  <?php $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );echo str_replace($words, ' ',$action->company_name); ?>

                              </a>
                              <?php if(!empty($action->first_name)) { $contact_details_for_calendar = urlencode('Meeting with '.$action->first_name.' '.$action->last_name).'%0A'.urlencode($action->email.' '.$action->phone).'%0D%0D';?>
                              <div style="clear:both"><?php echo $action->first_name.' '.$action->last_name;?></div>
                              <?php } else { $contact_details_for_calendar="";};?>
                            </div>
                             <div class="col-md-2">
                              <div><?php echo $action->company_phone;?></div>
                              <div><?php echo $action->contact_phone;?></div>
                            </div>
                            <div class="col-md-2">
                              <?php echo $action_types_array[$action->action_type_id]; ?>
                            </div>
                            <div class="col-md-2  ">
                            <?php   $now = $action->duedate; 
                                    $timestamp = strtotime($action->planned_at);
                                    $round = 5*60;
                                    $rounded = round($timestamp / $round) * $round;
                                    
                                    echo date('d/m/y', $timestamp)." ";
                                echo date("H:i", $rounded);
                                    ?>
                              
                            </div>
                            <div class="col-md-3"  >
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



  <?php if (!$current_user['department'] == 'support'){  ?>

 
          <!--END ASSIGNED-->
          <!--ASSIGNED-->
  
          <!--END ASSIGNED-->
          <!--PROPOSALS-->
   
    <!--START MARKETING STATS-->
    
            
</div><!--END OF PROPOSALPANEL-->
          <!--ASSIGNED-->
 
</div><!--END OF PANEL-->

<?php }else{ ?>
<div role="tabpanel" class="tab-pane  active" id="podone">
                <!--Pod One-->

                        <div class="panel panel-default">
                            <div class="panel-heading" id="podone">
                                <h3 class="panel-title">Pod 1<span class="badge pull-right eventcountpods200"></span></h3>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body" style="font-size:12px;">
                                <div class="row record-holder-header mobile-hide">
                                <div class="col-xs-8 col-sm-2 col-md-2"><strong>Created</strong></div>
                                <div class="col-xs-5 col-sm-4 col-md-4"><strong>Company</strong></div>
                                <!--   <div class="col-xs-4 col-sm-2 col-md-2"><strong>Planned</strong></div>
                                <div class="col-xs-4 col-sm-2 col-md-2"><strong>Action</strong></div>
                                <div class="col-xs-4 col-sm-2 col-md-2"><strong>By</strong></div> -->
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row record-holder-pods200"></div>
                            </div>

                            <!--AUTO PILOT END  -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div><!--END OF Pod One-->



                <div role="tabpanel" class="tab-pane fade" id="podtwo">
                <!--Pod One-->

                        <div class="panel panel-default">
                            <div class="panel-heading" id="podtwo">
                                <h3 class="panel-title">Pod 2<span class="badge pull-right eventcountpods201"></span></h3>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body" style="font-size:12px;">
                                <div class="row record-holder-header mobile-hide">
                                <div class="col-xs-8 col-sm-2 col-md-2"><strong>Created</strong></div>
                                <div class="col-xs-5 col-sm-4 col-md-4"><strong>Company</strong></div>
                             <!--   <div class="col-xs-4 col-sm-2 col-md-2"><strong>Planned</strong></div>
                                <div class="col-xs-4 col-sm-2 col-md-2"><strong>Action</strong></div>
                                <div class="col-xs-4 col-sm-2 col-md-2"><strong>By</strong></div> -->
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row record-holder-pods201"></div>
                            </div>

                            <!--AUTO PILOT END  -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div><!--END OF Pod One-->





                <div role="tabpanel" class="tab-pane fade" id="podthree">
                <!--Pod One-->

                        <div class="panel panel-default">
                            <div class="panel-heading" id="podthree">
                                <h3 class="panel-title">Pod 3<span class="badge pull-right eventcountpods202"></span></h3>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body" style="font-size:12px;">
                                <div class="row record-holder-header mobile-hide">
                                <div class="col-xs-8 col-sm-2 col-md-2"><strong>Created</strong></div>
                                <div class="col-xs-5 col-sm-4 col-md-4"><strong>Company</strong></div>
                               <!--   <div class="col-xs-4 col-sm-2 col-md-2"><strong>Planned</strong></div>
                                <div class="col-xs-4 col-sm-2 col-md-2"><strong>Action</strong></div>
                                <div class="col-xs-4 col-sm-2 col-md-2"><strong>By</strong></div> -->
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row record-holder-pods202"></div>
                            </div>

                            <!--AUTO PILOT END  -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div><!--END OF Pod One-->

<?php } ?>
<!--END ASSIGNED-->
</div><!--END TAB PANES-->
</div><!--END-COL-SM-9-->
<div class="col-sm-3 col-sm-pull-9" style="display:none;">
              <div class="panel panel-default">
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
            <div class="panel panel-default" style="display:none;">
              <div class="panel-heading">
                <h3 class="panel-title">Recent Campaigns<span class="badge pull-right"><?php //echo count($shared_campaigns); ?></span></h3>    
              </div>
              <div class="panel-body" style="padding:0;">
              <div id="campaignList">
                  <!-- SHARED SEARCHES -->
                  <?php foreach ($shared_campaigns as $campaign):?>
                    <?php $user_icon = explode(",", $campaign->image);$bg_colour = $user_icon[1];$bg_colour_text = $user_icon[2];$bg_colour_name = $user_icon[0];?>
                    <a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $campaign->id; ?>" class="load-saved-search" <?php echo strlen($campaign->name) > 36 ? 'title="'.$campaign->name.'"':"" ?>><div class="row">
                  <div class="col-xs-1"><span class="label label-info" style="margin-right:3px;background-color: <?php echo $bg_colour; ?>;font-size:8px; color: <?php echo $bg_colour_text;?>"><b><?php echo $bg_colour_name; ?></b>
                    </span></div>
                  <div class="col-xs-9" style="max-height:15px;overflow:hidden"><?php echo $campaign->name;?></div>
                  <div class="col-xs-1" style="padding: 0 0 0 5px;"><b><?php //echo $campaign->campaigncount; ?></b></div>
                  </div>
                  </a>
                    <?php endforeach; ?>
              </div><!--END CAMPAIGN LIST-->
          <!--<button type="submit" class="btn btn-success btn-block" id="loadMore">Load More</button>-->

              </div>
            </div>
          </div><!--END COL-3-->
</div><!--END ROW-->

