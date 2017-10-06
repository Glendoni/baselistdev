<?php if($prefix == 'np'){ $prefix= 'tm'; }else{ $prefix= 'utm'; } ?>  
<?php foreach ($thismonthstats as $thismonthstat): ?>
                          <div class="row list-group-item stats-row active-<?php echo $thismonthstat['active'];?>">
                            <div class="col-xs-2 col-md-1">
                            <a href = "?search=2&user=<?php echo $thismonthstat['user'];?>&period=month">
                            <?php $user_icon = explode(",",$thismonthstat['image']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
                            </a>
                            </div>
                            <div class="col-xs-2 col-md-1 text-center">
                            <a href = "?search=2&user=<?php echo $thismonthstat['user'];?>&period=month"><span class="<?php echo $prefix; ?>-deals" ><?php echo $thismonthstat['deals'];?></span></a>
                            </div>
                            <div class="col-xs-2 col-md-1 text-center"> 
                              <?php echo '<div class="'.$prefix.'-proposals">'.$thismonthstat['proposals'].'</div>';?>
                              </div>
                          
                            <div class="col-xs-2 col-md-2 text-center"> 
                            <span class="<?php echo $prefix; ?>-demobookedcount"><?php echo $thismonthstat['demobookedcount'];?></span> / <span class="<?php echo $prefix; ?>-democount"><?php echo $thismonthstat['democount'];?></span>
                            </div>
                            <div class="col-xs-1 col-md-1 text-center">
                            <span class="<?php echo $prefix; ?>-meetingbooked"><?php echo $thismonthstat['meetingbooked'];?></span> / <span class="<?php echo $prefix; ?>-meetingcount"><?php echo $thismonthstat['meetingcount'];?></span>
                            </div>
                            <div class="col-xs-2 col-md-2 text-center"> 
                            <span class="<?php echo $prefix; ?>-salescall"><?php echo $thismonthstat['salescall'];?></span> / <span class="<?php echo $prefix; ?>-introcall"><?php echo $thismonthstat['introcall'];?></span>
                            </div>
                            <div class="col-md-2 hidden-xs text-center">
                              <span class="<?php echo $prefix; ?>-key_review_added"><?php echo $thismonthstat['key_review_added'];?></span> / <span class="<?php echo $prefix; ?>-key_review_occuring"><?php echo $thismonthstat['key_review_occuring'];?></span>
                            </div>
                            <div class="col-md-1 hidden-xs text-center">
                              <span class="<?php echo $prefix; ?>-duediligence"><?php echo $thismonthstat['duediligence'];?></span>
                            </div>
                          </div> <!--END ROW-->    
                      <?php endforeach ?>
                    