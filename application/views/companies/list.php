<div class="row page-results-list">

	<h1 class="page-header">Companies<small> <?php echo $companies_count; ?> </small> 
	
	<?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id): ?>
		<div class="btn-group pull-right">
			<button type="button" class="btn btn-default "><?php echo $current_campaign_name;?></button>
			<?php if($current_campaign_editable): ?>
				<button type="button" class="btn btn-default btn-info dropdown-toggle" data-toggle="dropdown">
				edit <span class="caret"></span>
				</button>
				<ul class="dropdown-menu campaing_edit_options" role="menu">
				<?php echo form_open(site_url().'campaigns/edit', 'name="edit_campaign" role="form"'); echo form_hidden('campaign_id', $current_campaign_id); ?>
					<?php if($current_campaign_is_shared == False): ?>
						<li><button type="" class="btn btn-default btn-sm  btn-block disabled " name="" >is Private</button></li>
					<li><button type="submit" class="btn btn-warning btn-sm  btn-block" name="make_public" >Make public</button></li>
					
					<?php else: ?>
					<li><button type="" class="btn btn-default  btn-sm  btn-block disabled " name="" >is Public</button></li>
					<li><button type="submit" class="btn btn-warning btn-success btn-sm  btn-block" name="make_private" >Make private</button></li>
					<?php endif; ?>
					<li class="divider"></li>
					<li><button type="submit" class="btn btn-danger btn-sm btn-block" name="delete" >Delete</button></li>
				<?php echo form_close(); ?>
				</ul>
				
			<?php endif; ?>
		</div>
	<?php else: ?>
		<div class="btn-group pull-right">
			<buttom class="btn btn-success " data-toggle="modal" data-target="#createcampaign" >
				<span class="glyphicon glyphicon-floppy-save"></span> Save results
			</buttom>
			<?php if($search_results_in_session = $this->session->userdata('companies')): ?>
				<a type="button" class="btn btn-primary" href="<?php echo site_url();?>companies/refreshsearch">
					<i class="fa fa-refresh"></i> Refresh results
				</a>
			<?php endif; ?>
			
		</div>
	<?php endif; ?>
	    
	

	<!-- <div class="btn-group btn-group-justified">
		<?php if($search_results_in_session = $this->session->userdata('companies')): ?>
			<div class="btn-group">
		<a type="button" class="btn btn-default" href="<?php echo site_url();?>companies/refreshsearch"><i class="fa fa-refresh"></i> Refresh search</a>
		</div>
		<?php endif; ?>
		<div class="btn-group">
	  <buttom class="btn btn-primary " data-toggle="modal" data-target="#createcampaign" ><span class="glyphicon glyphicon-floppy-save"></span> Save results</buttom>
	  	</div>
	  	<div class="btn-group">
	  <button type="button" class="btn btn-default">Right</button>
	  </div>
	</div> -->
	
		
		<div class="modal fade" id="createcampaign" tabindex="-1" role="dialog" aria-labelledby="Create Campaign" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Save Results</h4>
				</div>
				<?php echo form_open(site_url().'campaigns/create', 'name="create_campaign" class="create_campaign" role="form"'); ?>
				<div class="modal-body">
			     	<div class="form-group">
						<input type="text" name="name" class="form-control" id="name" placeholder="Name">
				    </div>
					<div class="btn-group toggle-btn-group" data-toggle="buttons">
						<label class="btn  active">
							<input type="radio" name="private" id="sharedfalse" > private
						</label>
						<label class="btn ">
							<input type="radio" name="public" id="sharedtrue">  public
						</label>
					</div>
		      	</div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-primary">Save changes</button>
		      </div>
		      <?php echo form_close(); ?>
		    </div>
		  </div>
		</div>
	
	</h1>
	<p >Page <?php echo $current_page_number; ?> of <?php echo $page_total ?></p>
	<ul class="pager">
		<?php if($previous_page_number): ?>
	  	<li class="previous"><a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a></li>
	  	<?php else: ?>
	  	<li class="previous disabled"><a href="#">&larr; Previous</a></li>
	    <?php endif; ?>

	    <?php if($next_page_number): ?>
	  	<li class="next"><a href="?page_num=<?php echo $next_page_number; ?>">Next &rarr;</a></li>
	  	<?php else: ?>
	  	<li class="next disabled"><a href="#">Next &rarr;</a></li>
		<?php endif; ?>
	</ul>

	
	<?php 
	// Display companies
	$this->load->view('companies/companies_list.php');
	?>
	
	<ul class="pager">
		<?php if($previous_page_number): ?>
	  	<li class="previous"><a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a></li>
	  	<?php else: ?>
	  	<li class="previous disabled"><a href="#">&larr; Previous</a></li>
	    <?php endif; ?>

	    <?php if($next_page_number): ?>
	  	<li class="next"><a href="?page_num=<?php echo $next_page_number; ?>">Next &rarr;</a></li>
	  	<?php else: ?>
	  	<li class="next disabled"><a href="#">Next &rarr;</a></li>
		<?php endif; ?>
	</ul>
</div>