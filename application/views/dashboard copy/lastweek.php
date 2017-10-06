<?php if($prefix == 'np'){ $prefix= 'lw'; }else{ $prefix= 'ulw'; } ?> 
<?php foreach ($lastweekstats as $lastweekstat): ?>
                        <div class="row list-group-item stats-row active-<?php echo $lastweekstat['active'];?>">

                            <div class="col-xs-2 col-md-1"> 
                            <a href = "?search=2&user=<?php echo $lastweekstat['user'];?>&period=lastweek">
                            <?php $user_icon = explode(",",$lastweekstat['image']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
                            </a>
                            </div>
                            <div class="col-xs-2 col-md-1 text-center">
                            <a href = "?search=2&user=<?php echo $lastweekstat['user'];?>&period=lastweek"><span class="<?php echo $prefix; ?>-deals" ><?php echo $lastweekstat['deals'];?></span></a>
                            </div>
                            <div class="col-xs-2 col-md-1 text-center"> 
                              <?php echo '<div class="'.$prefix.'-proposals" >'.$lastweekstat['proposals'].'</div>';?>
                              </div>
                         
                            <div class="col-xs-2 col-md-2 text-center"> 
                            <span class="<?php echo $prefix; ?>-demobookedcount"><?php echo $lastweekstat['demobookedcount'];?></span> / <span class="<?php echo $prefix; ?>-democount"><?php echo $lastweekstat['democount'];?></span>
                            </div>
                            <div class="col-xs-1 col-md-1 text-center">
                            <span class="<?php echo $prefix; ?>-meetingbooked"><?php echo $lastweekstat['meetingbooked'];?></span> / <span class="<?php echo $prefix; ?>-meetingcount"><?php echo $lastweekstat['meetingcount'];?></span>
                            </div>
                            <div class="col-xs-2 col-md-2 text-center"> 
                            <span class="<?php echo $prefix; ?>-salescall"><?php echo $lastweekstat['salescall'];?></span> / <span class="<?php echo $prefix; ?>-introcall"><?php echo $lastweekstat['introcall'];?></span>
                            </div>
                            <div class="col-md-2 hidden-xs text-center">
                              <span class="<?php echo $prefix; ?>-key_review_added"><?php echo $lastweekstat['key_review_added'];?></span> / <span class="<?php echo $prefix; ?>-key_review_occuring"><?php echo $lastweekstat['key_review_occuring'];?></span>
                            </div>
                            <div class="col-md-1 hidden-xs text-center">
                              <span class="<?php echo $prefix; ?>-duediligence"><?php echo $lastweekstat['duediligence'];?></span>
                            </div>
                          </div> <!--END ROW-->    
                      <?php endforeach ?>
                     