<!--<div class="assign-to-wrapper ">-->
<!--<a class="btn btn-primary btn-block btn-sm edit-btn"  href="<?php echo site_url();?>companies/company?id=<?php echo $company['id'];?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>View Company</a>-->
	<!--<button class="btn btn-warning btn-block btn-sm edit-btn" data-toggle="modal" id="editbtn<?php echo $company['id']; ?>"  data-target="#editModal<?php echo $company['id']; ?>">
        <span class="ladda-label"> Edit </span>
    </button>-->
	<!--<?php if(isset($company['assigned_to_name']) and !empty($company['assigned_to_name'])): ?>
		<?php if($company['assigned_to_id'] == $current_user['id']) : ?>	
		<div style="  margin: 5px 0;">		
			<?php  $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
			echo form_open('companies/unassign',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
			<button type="submit" class="btn  btn-danger btn-block btn-sm  ladda-button" data-style="expand-right" data-size="1">
			    <span class="ladda-label"> Stop Watching </span>
			</button>
			<?php echo form_close(); ?>
			</div>
		<?php endif; ?>
	<?php else: ?>
		<div style="  margin: 5px 0;">
	<?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
	echo form_open(site_url().'companies/assignto',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
	<button type="submit" assignto="<?php echo $current_user['name']; ?>" class="btn  btn-success btn-block btn-sm ladda-button" data-style="expand-right" data-size="1">
        <span class="ladda-label">Watch</span>
    </button>
	<?php echo form_close(); ?>
	</div>
	<?php endif; ?>-->
<!--</div>-->