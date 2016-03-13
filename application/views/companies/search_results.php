<div class="page-results-list">
		<ul class="pager">
		<div class="col-xs-2">
		<?php if($previous_page_number): ?>
	  	<li class="previous">
	  		<a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a>
	  	</li>
	    <?php endif; ?>
		</div>
		<div class="col-xs-8 ">
        <span class="count_of_results">
        <?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id ): ?>
				<?php else: ?>
				<?php echo number_format($companies_count); ?> <?php if ($companies_count<> "1") {echo "Companies";} else { echo "Company";}?>
				<?php endif; ?>
				<?php if($previous_page_number or $next_page_number): ?><span style="font-size:15px; font-weight:700;"> Page <?php echo $current_page_number; ?> of <?php echo $page_total ?> </span><?php endif; ?>
		</span>
		</div>    
	<div class="col-xs-2">
	    <?php if($next_page_number): ?>
	  	<li class="next">
	  		<a href="?page_num=<?php echo $next_page_number; ?>">Next &rarr;</a>
	  	</li>
		<?php endif; ?>
		</div>
	</ul>

	    <!-- Collect the nav links, forms, and other content for toggling -->
		<div>
	      	<?php if(($companies_count > 0)): ?>
				<?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id ): ?>

					<?php foreach($current_campaign_stats as $current_campaign_stats){?>
						<div style="font-weight:300; font-size:32px; margin-bottom: 20px; margin-top: -20px; text-align:center;">
						<?php echo $current_campaign_name; ?> <?php if($current_campaign_is_shared == False): ?>
						</div>	
						<?php else: ?>	
						<?php endif;?>
					<?php foreach($current_campaign_owners as $current_campaign_owner): echo "<div style='text-align: center;font-weight: 300; font-size:12px;'>Owned by <b>".$current_campaign_owner->username."</b> | Created on <b>".date('jS F Y',strtotime($current_campaign_stats->created))."</b></div>"; endforeach ?>	
					<?php if(!empty($current_campaign_stats->description)): ?>
						<p style="font-size:14px"><?php echo $current_campaign_stats->description; ?></p>
					<?php endif;?>

						<div><a class="btn btn-info btn-xs" href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_id; ?>">Refresh</a></div>

						
<div class="row campaign" style="margin-bottom: 20px;">
<div class="col-sm-2 mobile-hide">
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>">
<div class="circle-responsive_campiagns black-circle-campaign  <?php echo empty($this->session->userdata('pipeline'))? 'active':'';?>"><div class="circle-content mega">
<div class="large-number"><?php echo number_format($current_campaign_stats->campaign_total); ?></div> <div class="small-text"><?php if ($companies_count<> "1") {echo "Companies in</br>$results_type";} else { echo "Company in</br>$results_type";}?></div>
</div>
</div>
</a>
<div class="small-text" style="font-weight:300; font-size:9px; max-width:80%; margin-left:auto; margin-right:auto;"><?php if ($current_campaign_stats->campaign_unsuitable > "0") {echo "Includes ".$current_campaign_stats->campaign_unsuitable." marked as unsuitable";} else {}?></div>
</div>
<div class="col-sm-2 mobile-hide">
<div class="circle-responsive_campiagns cyan-circle contacted_percentage_campaign">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->contacted; ?><span style="font-size:18px;">%</small></div>
<div class="small-text">Contacted </div>


</div>
</div>
<div class="small-text" style="font-weight:300; font-size:9px; max-width:80%; margin-left:auto; margin-right:auto;"><?php if ($current_campaign_stats->campaign_unsuitable > "0") {echo "Companies marked as Unsuitable are not included in this figure";} else {}?></div>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_prospects>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>&pipeline=prospect">
<?php else: endif; ?>
<div class="circle-responsive_campiagns prospect-circle_campaign <?php if ($this->session->userdata('pipeline')=='prospect'): echo 'Prospect active';else: endif; ?>
">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_prospects; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_prospects <> "1") {echo "Prospects";} else { echo "Prospect";}?></div></div>
</div>
<?php if ($current_campaign_stats->campaign_prospects>0): ?>
</a><?php else: endif; ?>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_intent>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>&pipeline=intent">
<?php else: endif; ?>
<div class="circle-responsive_campiagns intent-circle_campaign <?php if ($this->session->userdata('pipeline')=='intent'): echo 'Intent active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_intent; ?></div>
<div class="small-text">Intent & Qualified</div></div>
</div>
<?php if ($current_campaign_stats->campaign_intent>0): ?>
</a>
<?php else: endif; ?>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_proposals>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>&pipeline=proposal">
<?php else: endif; ?>
<div class="circle-responsive_campiagns proposal-circle_campaign <?php if ($this->session->userdata('pipeline')=='proposal'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_proposals; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_proposals <> "1") {echo "Proposals";} else { echo "Proposal";}?></div></div>
</div>
<?php if ($current_campaign_stats->campaign_proposals>0): ?>
</a>
<?php else: endif; ?>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_customers>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>&pipeline=customer">
<?php else: endif; ?>
<div class="circle-responsive_campiagns customer-circle-campaign <?php if ($this->session->userdata('pipeline')=='customer'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_customers; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_customers <> "1") {echo "Customers";} else { echo "Customer";}?></div></div>
</div>
<?php if ($current_campaign_stats->campaign_customers>0): ?>
</a><?php else: endif; ?>
</div>
<?php
}
?>
		
</div><!--END ROW-->
					
<?php else: ?>
<?php endif; ?>					
<?php endif; ?>
</div><!-- /.row -->


	
	<?php 
	// Display companies
	$this->load->view('companies/list.php');
	?>
	<ul class="pager">
		<?php if($previous_page_number): ?>
	  	<li class="previous"><a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a></li>
	    <?php endif; ?>

	    <?php if($next_page_number): ?>
	  	<li class="next"><a href="?page_num=<?php echo $next_page_number; ?>">Next &rarr;</a></li>
		<?php endif; ?>
	</ul>

				<?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id ): ?>
<div class="col-sm-12">

<p style="margin-top:3px;text-align: center;"><b>Note:</b> Campaigns are ordered so companies not contacted recently will appear first.</p>
<?php endif; ?>
</div>