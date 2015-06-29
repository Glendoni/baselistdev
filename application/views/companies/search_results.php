<div class="row page-results-list">

	<ul class="pager">
		<?php if($previous_page_number): ?>
	  	<li class="previous">
	  		<a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a>
	  	</li>
	    <?php endif; ?>
        <span class="count_of_results">
			<strong><?php echo $companies_count; ?> <?php if ($companies_count<> "1") {echo "Companies";} else { echo "Company";}?></strong> <small>(Page <?php echo $current_page_number; ?> of <?php echo $page_total ?>)</small>
		</span>
	    <?php if($next_page_number): ?>
	  	<li class="next">
	  		<a href="?page_num=<?php echo $next_page_number; ?>">Next &rarr;</a>
	  	</li>
		<?php endif; ?>
	</ul>

	<nav class="navbar navbar-default companies-list-header" role="navigation">
	  <div class="container-fluid">
	    <!-- Collect the nav links, forms, and other content for toggling -->
<div class="row" style="text-align:center;">
	      	<?php if(($companies_count > 0)): ?>
				<?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id ): ?>	
					<div class="navbar-text saved-search-text">
						<span style="font-weight:300; font-size:16px;"><?php echo $results_type ?>:
						<strong><?php echo $current_campaign_name; ?></strong></span>
					</div>
				<?php if($current_campaign_is_shared == False): ?>
					<div class="navbar-text saved-search-text">
						<div style="font-weight:300; font-size:12px;">
						<span class="label label-default">
						Private
						</span>
						</div>
					</div>	
				<?php else: ?> 
					<div class="navbar-text saved-search-text">
						<div style="font-weight:300; font-size:12px;">
						<span class="label label-success">
						Public
						</span>
						</div>
					</div>	
				<?php endif;?>  
				<?php if($current_campaign_editable): ?>
	                <?php echo form_open(site_url().'campaigns/'.$edit_page, 'name="edit_campaign" role="form"'); echo form_hidden('campaign_id', $current_campaign_id); ?>
	                <?php if($current_campaign_is_shared == False): ?>
						<button type="submit" class="btn btn-warning btn-sm btn-search-edit" name="make_public" >Make Public</button>
					<?php else: ?>
						<button type="submit" class="btn btn-warning btn-success btn-sm btn-search-edit" name="make_private" >Make Private</button>
					<?php endif; ?> 
					<button type="submit" class="btn btn-danger btn-sm btn-search-edit" name="delete" >Delete</button>
					<?php echo form_close(); ?>
			  	<?php endif; ?>
			</div>	
			<?php else: ?>
			<?php echo form_open(site_url().'campaigns/create', 'name="create_campaign" class="create_campaign navbar-form navbar-left" style="width:100%;" role="form"'); ?>
			<div class="col-md-5"   style="padding-top: 3px;">
			 	<div class="form-group" style="width:100%">
					<input type="text" name="name" class="form-control col-md-6" style="width:100%" id="name" placeholder="Enter search name...">
			    </div>
			    </div>
			    <div class="col-md-7" style="text-align:center;">
				<div class="btn-group toggle-btn-group btn-sm" data-toggle="buttons">
					<label class="btn btn-sm active">
						<input type="radio" name="private" id="sharedfalse" ><i class="fa fa-user"></i> Private
					</label>
					<label class="btn btn-sm">
						<input type="radio" name="public" id="sharedtrue"><i class="fa fa-users"></i> Public
					</label>
				</div>
				|
			    <button type="submit" name="save_search" value='1' class="btn btn-primary btn-sm">Save Search</button>
			    or
			    <button type="submit" name="save_campaign" value='1' class="btn btn-warning btn-sm">Save Campaign</button>
			    </div>
			  <?php echo form_close(); ?>
			<?php endif; ?>
		<?php endif; ?>
	  </div><!-- /.row -->
	</nav>


	
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
</div>