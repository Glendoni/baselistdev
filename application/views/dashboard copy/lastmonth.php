<?php if($prefix == 'np'){ $prefix= 'lm'; }else{ $prefix= 'ulm'; } ?>     

<?php foreach ($lastmonthstats as $lastmonthstat): ?>
                          <div class="row list-group-item stats-row active-<?php echo $lastmonthstat['active'];?>">
                            <div class="col-xs-2 col-md-1">
                            <a href = "?search=2&user=<?php echo $lastmonthstat['user'];?>&period=lastmonth"> 
                            <?php $user_icon = explode(",",$lastmonthstat['image']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
                            </a>
                            </div>
                            <div class="col-xs-2 col-md-1 text-center">
                            <a href = "?search=2&user=<?php echo $lastmonthstat['user'];?>&period=lastmonth"><span class="<?php echo $prefix; ?>-deals" ><?php echo $lastmonthstat['deals'];?></span></a>
                            </div>
                              <div class="col-xs-2 col-md-1 text-center"> 
                              <?php echo '<div class="'.$prefix.'-proposals">'.$lastmonthstat['proposals'].'</div>';?>
                              </div>
                              <div class="col-xs-2 col-md-2 text-center"> 
                            <span class="<?php echo $prefix; ?>-demobookedcount"><?php echo $lastmonthstat['demobookedcount'];?></span> / <span class="<?php echo $prefix; ?>-democount"><?php echo $lastmonthstat['democount'];?></span>
                            </div>
                            <div class="col-xs-1 col-md-1 text-center">
                            <span class="<?php echo $prefix; ?>-meetingbooked"><?php echo $lastmonthstat['meetingbooked'];?></span> / <span class="<?php echo $prefix; ?>-meetingcount"><?php echo $lastmonthstat['meetingcount'];?></span>
                            </div>
                            <div class="col-xs-2 col-md-2 text-center"> 
                            <span class="<?php echo $prefix; ?>-salescall"><?php echo $lastmonthstat['salescall'];?></span> / <span class="<?php echo $prefix; ?>-introcall"><?php echo $lastmonthstat['introcall'];?></span>
                            </div>
                            <div class="col-md-2 hidden-xs text-center">
                              <span class="<?php echo $prefix; ?>-key_review_added"><?php echo $lastmonthstat['key_review_added'];?></span> / <span class="<?php echo $prefix; ?>-key_review_occuring"><?php echo $lastmonthstat['key_review_occuring'];?></span>
                            </div>
                            <div class="col-md-1 hidden-xs text-center">
                              <span class="<?php echo $prefix; ?>-duediligence"><?php echo $lastmonthstat['duediligence'];?></span>
                            </div>
                          </div> <!--END ROW-->    
                      <?php endforeach ?>