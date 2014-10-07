
<?php if(empty($companies)): ?>
	<div class="alert alert-warning">No companies found</div>
<?php else: ?>

<?php  foreach ( $companies as $company):  ?>
<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
<div class="panel <?php if(isset($company['assigned_to_name'])): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> company">
	<?php if(isset($company['assigned_to_name'])): ?>
	<div class="panel-heading text-center" >
        <span class="assigned-image-holder" style="max-width:30px; float:left;"><img src="<?php echo asset_url();?>images/profiles/<?php echo isset($system_users[$company['assigned_to_id']]['image'])? $system_users[$action->user_id]['image']:'none' ;?>.jpg" class="img-circle img-responsive" alt="" /></span>
        <span style="line-height:28px;">
        Assigned to <?php echo $company['assigned_to_name']; ?> 
        </span>    </div>
	<?php endif; ?>
	<div class="panel-body">
		<div class="col-md-12">
			<div class="pull-right assign-to-wrapper">
				<?php if(isset($company['assigned_to_name']) and !empty($company['assigned_to_name'])): ?>
					<?php if($company['assigned_to_id'] == $current_user['id']) : ?>			
						<?php  $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => $current_page_number );
						echo form_open('companies/unassign',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
						<button type="submit" class="btn  btn-primary  ladda-button" data-style="expand-right" data-size="1">
						    <span class="ladda-label"> Unassign from me </span>
						</button>
						<?php echo form_close(); ?>
					<?php endif; ?>
				<?php else: ?>
				<?php 
				$hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => $current_page_number );
				echo form_open(site_url().'companies/assignto',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
				<button type="submit" assignto="<?php echo $current_user['name']; ?>" class="btn  btn-primary  ladda-button" data-style="expand-right" data-size="1">
			        <span class="ladda-label"> Assign to me </span>
			    </button>
				<?php echo form_close(); ?>
				<?php endif; ?>
				<button class="btn btn-warning ladda-button edit-btn" data-toggle="modal" id="editbtn<?php echo $company['id']; ?>" data-style="expand-right" data-size="1" data-target="#editModal<?php echo $company['id']; ?>">
                    <span class="ladda-label"> Edit </span>
                </button>  
			</div>
			<h3 class="name">
				<a href="<?php echo site_url();?>companies/company?id=<?php echo $company['id'];?>">
					<?php echo $company['name']; ?>
				</a>
				<?php if (isset($company['url'])): ?>
				<a class="btn btn-link" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { echo 'http://' . ltrim($company['url'], '/'); }else{ echo $company['url']; } ?>" target="_blank">
				<?php echo str_replace("http://"," ",str_replace("www.", "", $company['url']))?>
				</a>
				<?php endif; ?>
			</h3>
			<?php if (isset($company['class'])): ?>
				<span class="label label-info"><?php echo $companies_classes[$company['class']] ?></span>
			<?php endif; ?>
			<small><?php echo $company['address']; ?> </small>
		</div>
		
		<div class="col-md-12">
			<hr>
		</div>
		
		<!-- TURNOVER -->
		<div class="col-md-3 centre">
		<strong>Turnover</strong>
			<h3 class="details">
				<strong>£<?php echo isset($company['turnover'])? number_format (round($company['turnover'],-3)):'';?></strong>
				<br>
				<small><?php  echo isset($company['turnover_method'])?$company['turnover_method']:'';?></small>
			</h3>
			<h5>Founded</h5>
			<h5 class="details"><strong><?php echo isset($company['eff_from'])?$company['eff_from']:''; ?></strong></h5>
		</div>

		<!-- EMPLOYEES -->
		<div class="col-md-3 centre">
			<strong>Employees</strong>
			<?php if (isset($company['emp_count'])): ?>
			<h3 class="details"><strong><span class="label label-info"><?php echo $company['emp_count'];?> </span></strong></h3>
			<?php endif; ?>
		</div>

		<!-- SECTORS -->
		<div class="col-md-3 centre">
			<strong>Sectors</strong> 
			<?php 
			if (isset($company['sectors'])) {
				foreach ($company['sectors'] as $key => $name) {
					echo '<h5>'.$name.'</h5>';
				}
			}
			?>
		</div>

		<!-- LINKS AND BTN -->
		<div class="col-md-3">
			<?php if (isset($company['ddlink'])): ?>
			<a class="btn  btn-info btn-sm btn-block duedil" href="<?php echo $company['ddlink'] ?>" target="_blank">Duedil</a>
			<?php endif; ?>
			<?php if (isset($company['linkedin_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block linkedin" href="https://www.linkedin.com/company/<?php echo $company['linkedin_id'] ?>"  target="_blank">LinkedIn</a>
			<?php endif; ?>

		</div>
			
			<!-- MORTGAGES -->
			
			<div class="col-md-12">
			<?php if(!empty($company['mortgages'])): ?>
				<table class="table table-hover" style="margin-top:10px;">
				<thead>
					<tr>
						<th class="col-md-7">Provider</th>
						<th class="col-md-3">Status</th>
						<th class="col-md-2">Started</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($company['mortgages'] as $mortgage):?>
					<tr <?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'class="danger"' : 'class="success"' ?> >
						<td class="col-md-7" ><?php echo $mortgage['name']; ?></td>
						<td class="col-md-3"><?php echo $mortgage['stage']; ?></td>
						<td class="col-md-2"><?php echo $mortgage['eff_from']; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
				<?php else: ?>
				<div class="alert alert-info" style="margin-top:10px;">
	                No mortgage data registered.
	            </div>
			<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<?php endif; ?>