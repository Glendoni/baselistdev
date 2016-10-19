        <?php  $company = $companies[0]; ?>
            <?php if (!empty($_GET['campaign_id'])): 
                    $campaign_id = $_GET['campaign_id'];
                endif; ?>
            <?php if (!isset($company['id'])): ?>
                    <div class="alert alert-danger" role="alert">This company is no longer active.</div>
            <?php endif; ?>
            <?php //hide core page content if no company is found ?>
                <?php if (isset($company['id'])): ?>
                    <div class="page-results-list" id="parent">
                    <breadcrumbscroll>
                    <div class="row top-info-holder">
                    <div class="col-md-9 piplineUdate" style="padding-left: 31px;">
                                <!-- <breadcrumbscroll> -->
    <h2 class="company-header" id="logo">
                <?php $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' ); echo html_entity_decode (str_replace($words, ' ',$company['name'])); ?></h2>
    <?php if (isset($company['trading_name'])): ?>
        <h5 class="trading-header">
        <small><b>T/A</b></small>  <?php echo $company['trading_name'];?>
        </h5>
    <?php endif; ?>
    <div class="spacer" style="clear: both;"></div>


                      
                             
                        
                                <!--  </breadcrumbscroll> /breadcrumbscroll -->
                                <!--END ASSIGN-->

                                                <!-- Button trigger modal -->
 
                                        <?php 
                        if(!empty($company['pipeline'])):
                       
                        ?>
                        
                                        
                                        <span class="label  label-<?php echo str_replace(' ', '', $company['pipeline']); ?>"><?php echo $company['pipeline']?>   
                                        <?php endif; ?>     
                                        <?php if (isset($company['customer_from'])&&($company['pipeline']=='Customer')):?>  <?php echo date("d/m/y",strtotime($company['customer_from']));?><?php  
                                        $number  = $company['initial_rate'];
                                        //$number = 5.00;
                                        $number =  preg_match('[-+]?([0-9]*\.[0]+|[0]+', $number) ? false : $number;
                                        echo $number ? '<span class="initial_rate_found">  - &#64;'.($number*100).'%</span>' : '<span class="initial_rate_not_found"> - Rate Not Set</span>' ;  ?>
                                        <?php endif; ?>
                                        </span>

                        <?php if(!$company['customer_to']){  ?> 
                         <?php 

                                                          
                        if($last_pipeline_created_at  && $company['pipeline'] != 'Prospect' && $company['pipeline'] != 'Suspect' ){ ?>
                    
                        <span class="last_pipeline_created_at">
                        <?php
 //echo $last_pipeline_created_at;
                            $your_date = date('Y-m-d' , strtotime($last_pipeline_created_at));
                            $datetime1 = date_create(date('Y-m-d'));
                            $datetime2 = date_create($your_date);
                            $interval = date_diff($datetime1, $datetime2);
                             $interval = $interval->format('%a');
                        
             if($interval == 1){ echo  $interval.' day ago' ;}  elseif($interval == 0){ echo 'Today'; }else{ echo $interval. ' days ago' ;}        
                        

 ?>
      </span>
               <?php }} ?>  
                        
                        
                                        <?php if($company['customer_to']){  ?>
                                        <span class="label  label-<?php echo str_replace(' ', '', $company['pipeline']); ?> cancelledPill">
                                        Cancelled <?php echo date('d/m/Y',strtotime($company['customer_to'])); ?>
                                        </span>
                                        <?php } ?>

                                        <?php if(isset($company['assigned_to_name'])): ?>
                                        <span class="label label-assigned"
                                        <?php $user_icon = explode(",", ($company['image']));echo "style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'";?>>
                                        <i class="fa fa-star"></i>
                                        <?php echo $company['assigned_to_name']; ?>
                                        </span>

                                        <?php else: ?>
                                        <?php endif; ?>

       
                        
                   
                        
                        
                        
                        </div><!--END ROW-->

               <!--END ROW-->
 <div class="col-md-3">
     
     
  
           <div class="col-md-12" style="min-height: 50px;">

                       <!-- Fravorite Star -->
                                                        <?php if(isset($company['assigned_to_name']) and !empty($company['assigned_to_name'])): ?>
                                                            <?php if($company['assigned_to_id'] == $current_user['id']) : ?>	
                                                                    <?php  $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
                                                                        echo form_open('companies/unassign',array('name' => 'assignto', 'class'=>'assign-to-form', 'style'=>'display: inline; padding-right: 12px;    float: right;'),$hidden); 
                                                                    ?>
                                                                                <?php $bgcolor =  explode(',',$current_user['image']) ?>
                                                                                <button type="submit" class="assigned-star ladda-button starbtn" data-style="expand-right" data-size="1"   style="color:<?php echo $bgcolor[1]; ?>;">
                                                                                    <i class="fa fa-star " style="font-size: 27px;"></i>
                                                                                </button>
                                                                    <?php echo form_close(); ?>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                        <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
                                                        echo form_open(site_url().'companies/assignto',array('name' => 'assignto', 'class'=>'assign-to-form', 'style'=>'display: inline; padding-right: 12px; float: right;'),$hidden); ?>
                                                                <button type="submit" assignto="<?php echo $current_user['name']; ?>" class="unassigned-star ladda-button starbtn" data-style="expand-right" data-size="1">
                                                                    <i class="fa fa-star"  style="color:#DCDCDC; font-size: 27px;"></i>
                                                                </button>
                                                        <?php echo form_close(); ?>

                                                        <?php endif; ?>

                                                 
                                                    <!-- Fravorite Star End -->
          </div>
     
     
         <div class="col-md-12" >
               
             
            

                 <span class="label   btn-info comp_details_edit_btn mainedit" data-toggle="modal" id="editbtn<?php echo $company['id']; ?>" data-target="#myModal<?php echo $company['id']; ?>" style="
    font-size: 12px;     float: right;
">Add Tag</span>
             
             
             
            <span class="label  btn-warning comp_details_edit_btn mainedit" data-toggle="modal" id="editbtn<?php echo $company['id']; ?>" data-target="#editModal<?php echo $company['id']; ?>" style="
    font-size: 12px;     float: right;
">Edit</span>
             
           
         
        </div>

     
      
     
    </div>



      


        <!-- // POPUP BOXES -->
        </div><!--END TOP INFO HOLDER-->
  <div class="row">
        <?php if (isset($company['parent_name'])): ?>
        <div class="subsidiary">
        <span class="label label-danger"><a href="<?php echo site_url();?>companies/company?id=<?php echo $company['parent_id'];?>" target="_blank">Subsidiary of <?php echo $company['parent_name'];?> <i class="fa fa-external-link"></i></a></span>
        </div>
        <?php elseif (isset($company['parent_registration'])): ?>
        <div class="subsidiary">
        <span class="label label-danger"><a href="https://beta.companieshouse.gov.uk/company/<?php echo $company['parent_registration'];?>" target="_blank">Parent Registration: <?php echo $company['parent_registration'];?> <i class="fa fa-external-link"></i></a></span>
        </div>
        <?php endif; ?>


        </div>
        </div><!--END TOP INFO HOLDER-->
</breadcrumbscroll>
    
    
 

<!-- POPUP BOXES -->
	<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
	<?php $this->load->view('companies/create_contact_box.php',array('company'=>$company)); ?>
	<?php $this->load->view('companies/create_address_box.php',array('company'=>$company)); ?>
   
<div class="panel panel-primary">
	<div class="panel-body">
    	<div class="row"><!--FINISHED AT THE END OF PANEL-->
		<div class="col-sm-9">
		<div class="row">
<div class="col-sm-12 action-details">
<div class="row"> 
<div class="col-md-4 col-lg-4 col-sm-4">
<div><strong>Last Contact</strong></div>
<div>
<?php if (empty($company['actioned_at1'])): ?>
Never
<?php else: ?>
<div class="action_type"><?php echo $company['action_name1']." by ".$company['action_user1']; ?></div>
<div class="action_date_list">
<?php echo date("l jS F Y",strtotime($company['actioned_at1']));?>
<?php
$now = time (); // or your date as well


$your_date = strtotime($company['actioned_at1']);
$datediff = abs($now - $your_date);
$days_since = floor($datediff/(60*60*24));
if ($company['actioned_at1'] > 0){
	echo "<br> ".$days_since." days ago";
	} else {
	echo "<br> ".$days_since." day ago)";;
	}
?></div>

<?php endif; ?>

</div>
</div>
<div class="col-md-4 col-lg-4 col-sm-4">
<div><strong>Scheduled</strong></div>
  
<?php if (empty($company['planned_at2'])): ?>
	None
<?php else: ?>
	<div class="action_type"><?php echo $company['action_name2']." by ".$company['action_user2']; ?></div>

	<div class="action_date_list">
<?php echo date("l jS F Y",strtotime($company['planned_at2']));?>
</div>
<?php
$now = time ();
    $compdate = explode('T',$company['planned_at2']);
$your_date = strtotime($compdate[0]);
if ($your_date < $now){; 
     $datediff = $now - $your_date;
     $daysoverdue = floor($datediff/(60*60*24));?>
<div><span class="label label-danger" style="font-size:10px;">
<?php   if ($daysoverdue > 1) {echo $daysoverdue." Days Overdue";} elseif($daysoverdue == 1){  echo $daysoverdue." Day Overdue";   }else{echo "Due Today";};?>   </span></div>

<?php } else {}?>
<?php endif; ?>
    
    
    

</div>
    
		<div class="col-xs-6 col-md-3" >
				<label>Class</label><br>
				<p>	
		            <!--CLASS IF APPLICABLE-->
		          
                  <?php if (isset($company['class']) && $company['class'] != 'Unknown' ): ?>
					 <?php echo  $company['class']; ?> 	
					<?php else: 
                    
                    //echo '-';
                    
                    ?>
						
		            <?php endif; ?>
	            </p>
			</div>	 
    
</div><!--END ROW-->
<hr>
    
</div>
	

        	<div class="col-xs-6 col-md-4" style="margin-top:10px;">
        	<label>Founded</label><br>
			<p>	
				<?php echo isset($company['eff_from'])?$company['eff_from']:''; ?>
			</p>
		</div>
            <div class="col-xs-6 col-md-4 details" style="margin-top:10px; ">
			<label>Company Number</label><br>
			<p>	
			 <!--COMPANY NUMBER IF APPLICABLE-->
			<?php echo isset($company['registration'])?$company['registration']:''; ?>
         	</p>
        	</div>

        <div class="col-xs-6 col-md-3" style="margin-top:10px;">
        		<label>Phone</label><br>
        		<p>
        		<?php echo isset($company['phone'])?$company['phone']:''; ?>                
           		</p>
			</div><!--END PHONE NUMBER-->
	
            <?php /* ?>
		<div class="col-md-6">
				<label>Registered Address</label>
				<p>	

                <?php echo isset($company['address'])?'<a href="http://maps.google.com/?q='.urlencode($company['address']).'" target="_blank">'.$company['address'].'<span style="    line-height: 15px;font-size: 10px;padding-left: 5px;"><i class="fa fa-external-link"></i></span></a>':'-'; ?>  
				</p>
		</div>
        
            <?php  */ ?>
            <!--END ADDRESS-->
		

            
            <!--END TRADING NAME-->
            
		</div><!--END ROW-->
        </div><!--CLOSE MD-9-->
		<div class="col-sm-3">
		<!--Check if company is blacklisted - if so hide the actions boxes -->
		<?php if ($company['pipeline']=='Blacklisted'): ?>
		<?php else: ?>
		<?php $this->load->view('companies/actions_box.php',array('company'=>$company)); ?>

		<!-- LINKS AND BTN -->
			<?php if (isset($company['sonovate_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block sonovate" href="https://members.sonovate.com/agency-admin/<?php echo $company['sonovate_id'] ?>/profile"  target="_blank">Sonovate 3.0</a>
			<?php endif; ?>
	<?php if (($current_user['department']) =='support' && isset($company['zendesk_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block zendesk" href="https://sonovate.zendesk.com/agent/organizations/<?php echo $company['zendesk_id'] ?>"  target="_blank">ZenDesk</a>
			<?php endif; ?>
			<?php if (isset($company['linkedin_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block linkedin" href="https://www.linkedin.com/company/<?php echo $company['linkedin_id'] ?>"  target="_blank">LinkedIn</a>
            <?php else: ?>
		<?php $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
		$name_no_ltd = str_replace($words, '',$company['name']); ?>

              <a class="btn  btn-primary btn-sm btn-block" href="https://www.linkedin.com/vsearch/f?type=all&keywords=<?php echo  urlencode($name_no_ltd) ?>"  target="_blank">LinkedIn <i class="fa fa-search" aria-hidden="true"></i> </a>
            <?php endif; ?>
					 <?php if (isset($company['url'])): ?>
		<a class="btn btn-default btn-sm btn-block btn-url" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { echo 'http://' . ltrim($company['url'], '/'); }else{ echo $company['url']; } ?>" target="_blank">
		<label style="margin-bottom:0;"></label> <?php echo str_replace("http://"," ",str_replace("www.", "", $company['url']))?>
		</a>
		<?php else: ?>
    <a class="btn  btn-default btn-sm btn-block " href="https://www.google.co.uk/search?q=<?php echo urlencode(htmlspecialchars_decode($company['name'], ENT_QUOTES));  ?>"  target="_blank">Google <i class="fa fa-search" aria-hidden="true"></i></a>
            <?php endif; ?>
			
			<?php if (isset($company['registration'])): ?>
			<a class="btn  btn-info btn-sm btn-block companieshouse" href="https://beta.companieshouse.gov.uk/company/<?php echo $company['registration'] ?>" target="_blank">Companies House</a>
			<?php endif; ?>
		<?php endif; ?>
         
        </div><!--CLOSE COL-MD-3-->
		
            
            
            
            
            <div class="col-md-12">
			<hr>
		
<div class="row  details">
	
	 
                
            <div class="col-md-3" style="display:none;">
					<!-- CONTACTS -->
            	<label>Contacts</label> 		
			<?php if (isset($company['contacts_count'])): ?>
			<p class="details"><?php echo $company['contacts_count'] ?  $company['contacts_count'] : '';?></p>
			<?php endif; ?>
			 
		</div>
    
    
	 <div class="col-xs-4 col-sm-3">
			<label><span style="text-transform: capitalize"><?php echo isset($company['turnover_method'])?$company['turnover_method']:'';?></span> Turnover</label><br>
			<p class="details" style="margin-bottom:5px;"><?php echo isset($company['turnover'])? '£'.number_format (round($company['turnover'],-3)):'';?></p>
            
            
        </div>
            
              <div class="col-md-3" >
				<label>Lead Source</label>
				<p style="
    margin-top: -4px;
"><?php echo  $company_sources[$company['source']]  ? $company_sources[$company['source']]. ''  : '';?><br>
                 <strong><?php echo  $company_sources[$company['source']]  ? ''  : '';?></strong> <span class="leadSourceSubText"><?php echo $company['source_explanation'] ? $company['source_explanation'] : ''; ?></span></p>
			 
		</div>
            
            
    
    
                
		<!-- EMPLOYEES -->
		<div class="col-xs-4 col-sm-3">
			<strong>Employees</strong><br>
			<?php if (isset($company['emp_count'])): ?>
			<p class="details"><?php echo $company['emp_count'];?> </p>
			<?php else: ?>
            <p class="details"></p>
			<?php endif; ?>
            </div>
		<!-- SECTORS -->
		<div class="col-xs-4 col-sm-3">
			<div class="tag_sectortagheading"><strong>Sectors</strong></div>
			<?php
			if(isset($company['sectors'])){
		
				foreach ($company['sectors'] as $key => $name)
				{
				echo '<div class="details detailsTagFormat" >'.$name.'</div>';
				}
			}
			?>
            
            
            


<?php /* if (isset($company['perm'])): ?>
<p class="details detailsTagFormat" style="margin-bottom:0; text-align:centre; font-size:11px;">Permanent</p>
<?php endif; ?>
<?php if (isset($company['contract'])): ?>
<p class="details detailsTagFormat" style="margin-bottom:0; text-align:centre; font-size:11px;">Contract</p>
<?php endif;  */ ?>
</div>
    
    
    
    
		</div>
            </div>
            
		<div class="row">
		<div class="col-xs-12 details" >
		 
            

            
            
            
            

	
            

            
               <div class="subcont"> 

                    <!-- <h4 class="ta"></h4> -->
                    <!--<ul id="fetags"></ul> -->
                    </div>
            
		</div>
		</div>
		</div>
		<div class="col-md-12">
			<hr>
		</div>

		
       
		<!-- MORTGAGES -->
	<div class="col-md-12">
		<div class="panel panel-default">
<?php if(!empty($company['mortgages'])): ?>
		
	
		<div class="panel-heading" id="qvfinancials">
		Financials
            
            <span><?php
                /*  $number = 80020; //$company['turnover'] .'<br>';
                if($number){
                        if($number < 100000  ) {
                         echo '£'.round(number_format($number),0);
                        }else{                    
                                 echo '£'. number_format(floor($number / 10) * 10);  

                        }
                }
                
                */
                ?>
		</div>
		<!-- /.panel-heading -->
 
		<div class="panel-body">
            
		
			<table class="table">
			<thead>
				<tr>
					<th class="col-md-4">Mortgage Provider</th>
                    <th class="col-md-3">&nbsp;</th>
					<th class="col-md-3">Started</th>
					<th class="col-md-3">Status</th>
                <th class="col-md-2">Finished</th>
                    <th class="col-md-2">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
                
     //print_r($company['mortgages']);
               $tdbgcolorclass = 'success';
                foreach ($company['mortgages'] as $mortgage):?>
                <?php
                
               
       
             if( $mortgage['Inv_fin_related'] == 'Y' || $mortgage['Inv_fin_related'] == 'P') {  
                $tdbgcolorclass =   'success'  ;//$tdbgcolorclass = 'danger';
                }
                
                
                  if( $mortgage['Inv_fin_related'] == 'N'){
                    
                  $tdbgcolorclass =   'danger' ;  
                    
                }
                
                
                
                ?>
				<tr <?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'class="danger cont'.$mortgage['id'].'"' : 'class="'.$tdbgcolorclass.' cont'.$mortgage['id'].'"' ?>>
				<td class="col-md-4" >
					<?php if(isset($mortgage['url'])) : ?>
						<a href="http://<?php echo $mortgage['url']; ?>" target="_blank"><?php echo $mortgage['name']; ?> <span style="font-size:10px;"><i class="fa fa-external-link"></i></span></a>
	    			<?php else: ?>
						<?php echo $mortgage['name'] ?>
					<?php endif; ?>
				<div style="font-size:10px;">
				<?php echo $mortgage['type']; ?>
				</div>
				</td>
                    <td class="col-md-2">
                        
                     <?php 
                      
                        if($mortgage['stage'] == 'Outstanding'){ 
    
    
  
    
    
    
    if($mortgage['Inv_fin_related'] == 'N'){ echo '<span  class="related_to_Invoice_Finance inv'.$mortgage['id'].'">Not Related To Invoice Finance</span>'; 
                }elseif($mortgage['Inv_fin_related'] == 'Y'){
        
    echo  '<span  class="Not_related_to_Invoice_Finance inv'.$mortgage['id'].'">Related To Invoice Finance</span>'; 
    
    
    } 
         if($mortgage['Inv_fin_related'] == 'P'){
        echo  '<span  class="Properly_related_to_Invoice_Finance inv'.$mortgage['id'].'">Probably Related To Invoice Finance</span>'; 
        
    } 
                        
                        
}?>
                    </td>
				<td class="col-md-1">
				<?php $mortgages_start  = $mortgage['eff_from'];$date_pieces = explode("/", $mortgages_start);$formatted_mortgage_date = $date_pieces[2].'/'.$date_pieces[1].'/'.$date_pieces[0];echo date("F Y",strtotime($formatted_mortgage_date));?>
                  
				</td>
				<td class="col-md-1">
				<?php echo ucfirst($mortgage['stage']); ?><?php if(!empty($mortgage['eff_to'])){
    //echo ' on '.$mortgage['eff_to'];
  
} ?>
				</td> 

	<td class="col-md-2" style="text-align:center;">
				<?php  echo $mortgage['eff_to'] ?  $mortgage['eff_to'] : '<span>-</span>'; ?>
				</td>
                    
	<td class="col-md-2">
        <?php 
        if($mortgage['stage'] == 'Outstanding'){ 
            
              if($mortgage['Inv_fin_related'] == 'Y') $prob = 2;
                    if($mortgage['Inv_fin_related'] == 'P') $prob = 3;
                          if($mortgage['Inv_fin_related'] == 'N') $prob = 1;
           
            
        ?>
				<span  class="label  btn-warning comp_details_edit_btn providerStatus" id="morprov<?php echo $mortgage['id']; ?>" data-id="<?php echo $mortgage['id']; ?>" providerStatus="<?php echo $prob; ?>" data-toggle="modal" data-target="#debmortgage" style="font-size: 12px; float: right;">Edit</span>
        <?php } ?>
				</td>
		 
				</tr>
				<?php endforeach; ?>
			</tbody>
			</table>
	
		<?php endif; ?>
		</div>
 
		<!-- /.panel-body -->
		</div>
		</div>

<!--ADDRESSES-->
            
         



		<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading" id="addresses">
		Locations
		<div class="pull-right">
            
		<div class="btn-group">
            <button  class="btn btn-primary edit-btn btn-xs" data-toggle="modal" id="create_address_<?php echo $company['id']; ?>"  data-target="#create_address_<?php echo $company['id']; ?>" >
            <span class="ladda-label"> Add Location </span>
            </button>
		</div>
            
		</div>
		</div>
              <?php if(isset($addresses) and !empty($addresses)) : ?>
		<!-- /.panel-heading -->
		<div class="panel-body">
		
            <?php 
          // echo   print_r($addresses);
            
            
            if(($address->address) || ($company['address']) ) { ?>
            
            
            	<table class="table">
            
	      <thead>
	        <tr>
	          <th class="col-md-7">Address</th>
	          <th class="col-md-2">Type</th>
	          <th class="col-md-2">Phone</th>
				<th class="col-md-1"></th>

	        </tr>
	      </thead>
            <?php } ?>
	      <tbody>
	      	<?php
              $ai =  0 ;
              foreach ($addresses as $address):?>
              
              
            <?php  if($address->address != 'Unknown' && $address->address != '' ): ?>
	      	<tr>
				<td class="col-md-6">
                 <a target="_blank" href="http://maps.google.com/?q=<?=$address->address; ?>" ><span class="mainAddress"><?=$address->address; ?></span><span style="line-height: 15px;font-size: 10px;padding-left: 5px;"><i class="fa fa-external-link"></i></span></a></td>
				<td class="col-md-3 mainAddrType"><?php echo $address->type;?></td>
				<td class="col-md-2 mainPhone"><?php echo $address->phone ? $address->phone : $company['phone']; ?></td>
				<td  class="col-md-3">
                <?php if ($address->type<>'Registered Address'): ?>
                        <div class=" pull-right ">
	                       <?php $this->load->view('companies/action_box_addresses.php',array('address'=>$address)); ?>
	                   </div>
                    
                    
	            <?php
                      
                    else: ?>
	        	<?php endif;
               $ai = ($ai+1);      
endif;
                     
                    
                    ?>
	            </td>
        	</tr>
			<?php 
              
          
              endforeach; ?>  
	      </tbody>
	    </table>
	    <?php else: ?>
			
    
            
		<?php endif; ?>


<?php     if(!$ai) //echo   '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p class="noactionmsglisting">No address data registered</p></div>';
            ?>

		</div>
		<!-- /.panel-body -->
		</div>
		</div>

 
		<!--CAMPAIGNS-->
		<?php if(isset($campaigns) and !empty($campaigns)) : ?>
		<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading" id="campaigns">
		Campaigns
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
		<table class="table">
	      <thead>
	        <tr>
	          <th class="col-md-6">Name</th>
	          <th class="col-md-3">Owner</th>
	          <th class="col-md-3">Created</th>
	        </tr>
	      </thead>
	      <tbody>
	      	<?php foreach ($campaigns as $campaign): ?>
	      	<tr>
				<td class="col-md-6"><a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $campaign->id;?>"><?php echo $campaign->campaign_name;?></a></td>
				<td class="col-md-3"><?php echo $campaign->name;?></td>
				<td class="col-md-2"><?php echo date("d/m/y",strtotime($campaign->created_at));?></td>
				<td  class="col-md-3">
	            </td>
        	</tr>
			<?php endforeach; ?>  
	      </tbody>
	    </table>
		

		</div>
		<!-- /.panel-body -->
		</div>
		</div>
		<?php endif; ?>


		<!--CONTACTS-->
		<div class="col-md-12">
		<div class="panel panel-default">

		<div class="panel-heading" id="contacts">
		Contacts

		<div class="pull-right">
		<div class="btn-group">
		<button  class="btn btn-primary edit-btn btn-xs" data-toggle="modal" id="create_contact_<?php echo $company['id']; ?>"  data-target="#create_contact_<?php echo $company['id']; ?>" >
        <span class="ladda-label"> Add Contact </span>
		</button>
		</div>
		</div>
               

		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
		<?php if(isset($contacts) and !empty($contacts)) : ?>

			<table class="table">
	      <thead>
	        <tr>
	          	<th class="col-md-2">Name</th>
	          	<th class="col-md-2">Role</th>
	          	<th class="col-md-3">Email</th>
				<th class="col-md-2">Phone</th>
				<th class="col-md-3"></th>


	        </tr>
	      </thead>
	      <tbody>
<?php foreach ($contacts as $contact): ?>
	      	<tr>
				<td class="col-md-2 companyDetailsContacts">
				<?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name); ?>
				</td>
				<td class="col-md-2"><?php echo ucfirst($contact->role); ?></td>
				<td class="col-md-3"><?php echo $contact->email; ?>&nbsp;
	<?php if (!empty($contact->email_opt_out_date)): ?>
		<span class="label label-danger contact-opt-out">Email Marketing Opt-Out</span>
	<?php endif;?></td>
				<td  class="col-md-2"><?php echo $contact->phone; ?></td>
								<td  class="col-md-3"><div class="pull-right mobile-left actionsactionscontact-options">
				<?php if ($company['pipeline']=='Blacklisted'): ?>
				<?php else: ?>
	            <?php $this->load->view('companies/action_box_contacts.php',array('contact'=>$contact)); ?>
	        	<?php endif; ?>
	            </div></td>

        	</tr>
			<?php endforeach; ?>  
	      </tbody>
	    </table>

	    <?php else: ?>
		
		<?php endif; ?>

		</div>
		<!-- /.panel-body -->
		</div>
		</div>
        
        <!-- TAGGING  START-->
        
        <div class="tag-tabs" id="tags-anchor" style="display:none;">
                <div class="col-md-12">
                    <div class="panel panel-default">
                    <div class="panel-heading" id="qvTags">Tags</div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    <div>


                        <!-- Nav tabs -->
                        <!--<ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#cat1"  class="cat1" aria-controls="cat1" role="tab" data-toggle="tab"> </a></li>
                        <li role="presentation"><a href="#cat2" class="cat2" aria-controls="cat2" role="tab" data-toggle="tab"> </a></li>
                        <li role="presentation"><a href="#cat3"  class="cat3" aria-controls="cat3" role="tab" data-toggle="tab"> </a></li>
                        <li role="presentation"><a href="#cat4"  class="cat4" aria-controls="cat4" role="tab" data-toggle="tab"> </a></li>
                        <li role="presentation"><a href="#cat5"  class="cat5" aria-controls="cat5" role="tab" data-toggle="tab"> </a></li>
                        <li role="presentation"><a href="#cat6"  class="cat6" aria-controls="cat6" role="tab" data-toggle="tab"> </a></li>
                        </ul>-->

                        <!-- Tab panes -->
                        <!-- <div class=" col-lg-12 tafixed">
                        <p align="center" style="margin-left: 35px;">Tags</p>

                        </div>
                        <div class="tadefault col-lg-12">

                        <p>Tags are used to provide <strong>Sonovate</strong> with a better insight into current and potential clients </p>
                        </div>-->

   
                </div>   
                 
                        
                        
                        </div>
                    </div>   
            </div>
    </div>
        
        
        
        
          <!-- Modal -->
  <div class="modal draggable-modal full-screen fade" id="myModal<?php echo $company['id']; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tags</h4>
        </div>
        <div class="modal-body">
      
            
            
            
           <div id="myNav" class="overlay">
 
  <div class="overlay-content">
  
      
                        <div class="col-sm-12 no-padding">
                            <div class="row tag-search-holder ">
                                <div class="col-sm-12">         
                                    <form id="live-search" action="" method="post">
                                    <fieldset>
                                    <input type="text" class="form-control tag-search-form" placeholder="Search Tags" id="filter" value="" />
                                    <div><span id="filter-count" class="filter-count label label-count label-success" style="right: 71px;"></span> 
                                    <span  class="filter-count filter-count-cancel label label-count label-danger"></span></div>
                                    </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="cat1">    
                                    <div class="col-sm-12 no-padding">  
                                        <div class="loading_div sk-circle">
                                            <div class="sk-circle1 sk-child"></div>
                                            <div class="sk-circle2 sk-child"></div>
                                            <div class="sk-circle3 sk-child"></div>
                                            <div class="sk-circle4 sk-child"></div>
                                            <div class="sk-circle5 sk-child"></div>
                                            <div class="sk-circle6 sk-child"></div>
                                            <div class="sk-circle7 sk-child"></div>
                                            <div class="sk-circle8 sk-child"></div>
                                            <div class="sk-circle9 sk-child"></div>
                                            <div class="sk-circle10 sk-child"></div>
                                            <div class="sk-circle11 sk-child"></div>
                                            <div class="sk-circle12 sk-child"></div>
                                        </div>
                                        <div id="" class="tagContainer"> 
                                            <ul class="list-group main main_ProductType"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div> 
  </div>
</div> 
            
            
            
            
            
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
        
        
        
        

        <!--TAGGING END -->


		<!--ACTIONS-->
		<div class="col-md-12" id="add_action">
		<div class="panel panel-default ">
		  <div class="panel-heading">Add Action</div>
		  <div class="panel-body">
		   <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'done'=>'1','campaign_id' => $campaign_id, 'class_check' => $companies_classes[$company['class']],'source_check' => $company['source'],'sector_check' => count($company['sectors']),);
			echo form_open(site_url().'actions/create', 'name="create" class="form" role="form"',$hidden); ?>
			<!--THE BELOW PASSES THE CLASS FIELD ACROSS PURELY FOR VALIDATION - IF THERE IS A BETTER WAY OF DOING THIS THEN IT NEEDS TO BE HERE-->
			
			<!--VALIDATION ERROR IF NO ACTION IS SELECTED
<option value="16">Pipeline - Deal</option>
<a href="javascript:;" onclick="return triggerOpenEditbox();"> <i class="fa fa-external-link"></i></a>
-->

			<div id="action-error" class="no-source alert alert-warning" role="alert" style="display:none">
                <strong><span class="sourceRequiredTitle" >Source</span> Required.</strong><br> To add a <span class="sourceRequiredDropDownItem"></span>&#44; please add a <span class="editBoxInstruction">Source</span> to this company.
            </div>
            <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group ">
                                <label>New Action</label>
                                
                                
                               
                                
                                
                                
                                <select id="action_type_completed" name="action_type_completed" class="form-control" >
                                    <option value="">--- Select an Action ---</option>
                                    <option value="8">Pipeline - Proposal</option>
                                    <?php foreach($action_types_done as $action ): 

                                    if($action->id == 16 && $company['pipeline'] == 'Customer'|| $action->id == 31 && $company['pipeline'] == 'Customer' || $action->id == 32 && $company['pipeline'] == 'Customer' || $action->id == 33  && $company['pipeline'] == 'Customer'|| $action->id == 34 && $company['pipeline'] == 'Customer' ){ }else{ ?>
                                   
                                    <?php  if($action->id != 8 ){ ?>
                                      <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
                                    
                                    <?php } ?>
                                    <?php 
                                    } endforeach; ?>
                                </select>
                                
                                
                               
                            </div>
                        </div>
                     <div class="col-sm-2 col-md-2 initialfee fee">
                            <div class="form-group ">
                                <label>Initial Fee</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="initialfee" placeholder="0.00" min="0.01" max="9.99" class="form-control" id="amount" >
                                    <div class="input-group-addon">%</div>
                                </div>
                            </div>
                        </div>
                
               
                

                        <div class="col-sm-2 col-md-2  onInitialFee">
                            <?php if(isset($contacts) and !empty($contacts)) : ?>
                                <div class="form-group ">
                                    <label>Contact</label>
                                    <select name="contact_id" class="form-control actionContact">
                                        <option value="">--- Select a Contact ---</option>
                                        <?php foreach($contacts as $contact ): ?>
                                          <option value="<?php echo $contact->id; ?>"><?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>
                         <div class="col-sm-2 col-md-2 onInitialFee">
                            <div class="form-group ">
                                <label>Follow Up Action</label>

                                <select id="action_type_planned" name="action_type_planned" class="form-control" onchange="dateRequired()">
                                <option value="">--- No Follow Up ---</option>
                                    <?php foreach($action_types_planned as $action ): ?>
                                      <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-4 followup">
                            <div class="form-group" >
                                <label>Follow Up Date</label>
                                <input type="text" class="form-control follow-up-date" id="planned_at" data-date-format="YYYY/MM/DD H:m" name="planned_at" placeholder="">
                            </div>
                        </div>
                                        <div class="col-sm-4 col-md-4">

                <?php foreach($action_types_done as $action ):  
                                
                                echo '<div class="alert alert-info action_verbiage action_verbiage_text'.str_replace(' ', '',$action->id ).'" >'
                                    
                                    
                                    .$action->how_used.
                                    
                                    
                                    
                                    '</div>';
                                
                                endforeach;
                                ?>
                </div>
                   
                 
                <?php if ($current_user['permission'] == 'admin' || $current_user['permission'] == 'data' || $current_user['permission'] == 'uf'): ?>

                <div class="col-sm-4  initialfee">
        <div class="form-group ">
            <label>Contractors</label>
            <div class="input-group">  <div class="input-group-addon">Runners</div>
                <input type="number" step="1" name="runners" placeholder="0" min="0" class="form-control" id="runners" >
              
            </div>
        </div>
    </div>
                
                <div class="col-sm-4   initialfee">
        <div class="form-group ">
            <label>Turnover</label>
            <div class="input-group">   <div class="input-group-addon">£</div>
                <input type="number" step="0.01" name="turnover" placeholder="0.00" min="0.01" max="25000000"   class="form-control" id="turnover" >
             
            </div>
        </div>
    </div>

                 <?php endif; ?>
                
                
                
                
                
                
                
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group addActionOutcome">
                                 
                                
                                
                                
                                
                                
                                
                                
                                
                                <label>Comment<span class="actionEvalPipeline"style=" color: red;">*</span></label>
                                
                                
                                  
                                <textarea class="form-control completed-details" name="comment" rows="3" required="required"></textarea>

                                <!---
                            Please read this before copying the toolbar:

                            * One of the best things about this widget is that it does not impose any styling on you, and that it allows you 
                            * to create a custom toolbar with the options and functions that are good for your particular use. This toolbar
                            * is just an example - don't just copy it and force yourself to use the demo styling. Create your own. Read 
                            * this page to understand how to customise it:
                            * https://github.com/mindmup/bootstrap-wysiwyg/blob/master/README.md#customising-
                            --->
                    <div id="alerts"></div>
                    <div class="btn-toolbar btn-toolbarAction" data-role="editor-toolbar" data-target="#editor">
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a data-edit="fontSize 5"><font size="5">Huge</font></a>
                                </li>
                                <li><a data-edit="fontSize 3"><font size="2">Normal</font></a>
                                </li>
                                <li><a data-edit="fontSize 1"><font size="1">Small</font></a>
                                </li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                            <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                            <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                            <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
                            <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
                            <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                            <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                            <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                            <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
                            <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
                            <div class="dropdown-menu input-append">
                                <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                <button class="btn" type="button">Add</button>
                            </div>
                            <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

                        </div>
                        <div class="btn-group">
                            <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
                            <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                            <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                        </div>
                        <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
                    </div>

                    <div class="editor editorAction"></div>





                            </div>
                            <button type="submit" name="no contno con" class="btn btn-primary form-control disable_no_source " id="add_action_request" disabled="disabled">Add Action</button>
                        </div><!--END MD-12-->
                        <?php echo form_close(); ?>
</div>
		  </div>
		</div>
		</div>
        
          <div class="col-md-12 child" id="stickMenu" >
    
    
    
    
		<div class="panel panel-default " id="actions">
			<div class="panel-heading">
			Actions
			</div>
			<div class="panel-body">

				<div class="row">
                    
                    <div class="col-md-1" id="leftCol">
              
              	<ul class="nav nav-stacked actionNav sticky  " style="list-style: none;     z-index: 999;  margin-bottom: auto; " id="sidebar">
                 
                    
                    <li class="active activeMenu"><a href="javascript:;" class="btn btn-default btn-circle actionAll hint--top-right"  data-hint="All" data="All"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></a><span class="actionMenuQty qtyAll" aria-hidden="true"></span></li>
                    
                     <li class="" ><a href="javascript:;" class="btn btn-default btn-circle hint--top-right"  data-hint="Scheduled" data="actions_outstanding"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></a><span class="actionMenuQty qtyactions_outstanding" aria-hidden="true"></span></li>    
                        
                     <li class="" ><a href="javascript:;" class="btn btn-default btn-circle hint--top-right" data-hint="Completed" data="actions_completed"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a><span class="actionMenuQty qtyactions_completed" aria-hidden="true"></span></li>
                    
                        <li class="" ><a href="javascript:;" class="btn btn-default btn-circle hint--top-right" data-hint="Marketing" data="actions_marketing"><span class="glyphicon glyphicon-envelope
                        " aria-hidden="true"></span></a><span class="actionMenuQty qtyactions_marketing" aria-hidden="true"></span></li>
                   
                    
                    
                    <li class="" ><a href="javascript:;" class="btn btn-default btn-circle hint--top-right" data-hint="Comments" data="Comment"><i class="fa fa-comments fa-lg"></i></a><span class="actionMenuQty qtyComment" aria-hidden="true"><span></li>

                    
                    
                    <li class=""><a href="javascript:;" class="btn btn-default btn-circle hint--top-right"  data-hint="Cancelled" data="actions_cancelled"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span></a><span class="actionMenuQty qtyactions_cancelled" aria-hidden="true"></span></li>

                  
               
              	</ul>
              
      		</div>
                  
				    <div class="col-sm-1 col-md-10">
                        
                        
                        <div id="marketing_action">
                        <ul></ul>
                        
                        </div>
                        

	<!-- Timeline -->
    		<!--===================================================-->
    		<div class="timeline">
    
    			<!-- Timeline header -->
 
                    <div class="timeline-header">
    				<div class="timeline-header-title bg-dark actiontitle"  style="margin-top:10px;">History</div>
                        <div class="timeline-header-title bg-dark showCommentAddBtn hint--top-right"  data-hint="Add Comment" style="float:right; margin-left:11px; margin-top:10px;">  <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span></div>
                        <div class="timeline-header-title bg-dark showText" style="float:right;  margin-top:10px;     margin-left: 10px;">Hide/Text</div>

 <div class="timeline-header-title bg-dark showCommentsearch" style="float: right;
    margin-top: 10px;
    display: block;
    height: 37px;
    border-radius: 5px;
    width: 300px;">  <form style="    float: right;
    margin-top: 0px;
    display: block;
    height: 37px;
    border-radius: 5px;
    width: 270px;"><input type="text" id="filtercomment" onkeyup=" return callfunction(); " placeholder=" Search Comments" style="
 margin-top: -53px;
    width: 270px;
    outline: none;
    border: none;
     color: #555;
" /></form></div>
                         
    			</div>
                
                <div class="timeline-entry showCommentAddForm" style="display: block;">
                    <div class="timeline-stat"> </div>
                    
                    
                    <div class="timeline-label showCommentAddForm"> <div class="mar-no pad-btm"><span class="label label-warning"></span><div class="" style="float:right; margin-top:0; margin-left:3px;"></div></div>
                      
                                    <form action="<?php echo site_url(); ?>baselist/actions/create" name="create" class="showCommentAddForm" id="actionSendComment" role="" method="post" accept-charset="utf-8">
                            <input type="hidden" name="company_id" value="154537" id="comcompany_id" >
                            <input type="hidden" name="user_id" value="31"  >
                            <input type="hidden" name="done" value="1"  >
                            <input type="hidden" name="campaign_id" value="" id="comcampaign_id">
                            <input type="hidden" name="action_type_completed" id="comaction_type_completed" value="7">
                            <div class="col-md-10">					
                            <input id="btn-input" type="text" class="form-control input-md" name="comment" id="commentcontent"  required="required" placeholder="Type your comment here...">
                            </div>
                            <div class="col-md-2">	
                            <input type="submit" class="btn btn-primary btn-md btn-block" id="btn-chat">
	                          
	                    </div>
			            </form>
                        
                    </div>
                </div>
                    <div class="timeline_inner"></div>

                    </div>
                </div>
       

                </div>
            </div>
    </div>
            
            

     </div>        
        

<div class="row" id="parent">

</div>
</div>
</div><!--CLOSE ROW-->
    <?php //hide core page END ?>
       <?php endif; ?>
    
    
    <div class="bottom-alert">

</div>
    
        
        

        
  <!-- Modal -->
<div class="modal fade" id="debmortgage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      
      </div>
      <div class="modal-body" style="
    padding-bottom: 37px;
">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">



          <form>
 <label class="checkbox-inline"><input type="radio"  name="debenturemortgage" id="radio_3" value="P"> Probably Related to Invoice Finance</label>
<label class="checkbox-inline"><input type="radio"  name="debenturemortgage" id="radio_2" value="Y"> Related to Invoice Finance</label>
<label class="checkbox-inline"><input type="radio" name="debenturemortgage"   id="radio_1" value="N" > Not Related to Invoice Finance</label>
              
              
              
              
              <input name="providerid" type="hidden" class="providerid"  value=""> 
                <input name="companyid" type="hidden" class="providercompanyid" value=""> 
          </form>
              
              </div>
      </div>
      <div class="modal-footer">
    
     <button type="submit" class="btn btn-sm btn-warning btn-block ladda-button debmortgage" edit-btn=""   data-style="expand-right" data-size="1">
                    <span class="ladda-label">Save</span>
                </button>
      </div>
    </div>
  </div>
</div>  
 </div>
 
 
 


 


    
    <script>
function openNav() {
    document.getElementById("myNav").style.height = "100%";
}

function closeNav() {
    document.getElementById("myNav").style.height = "0%";
}
</script>
    
    
    
    <script>
 
    
    function stickyActionsMenu() {
      
                var offset = $(".child").offset();
                var posY = (offset.top) - ($(window).scrollTop());
                var posX = offset.left - $(window).scrollLeft();
                var  breadcrumbHeightEval  =  $('.top-info-holder').height() +  20;
                if(posY < 0){
                    $('.sticky').addClass('affix');
                    $('.affix').css('padding-top', + breadcrumbHeightEval +'px');
                }else{
                    $('.sticky').removeClass('affix');
                }

        
    }
    
    function callfunction() {
                    
     
        var pillid;
        var valcont 
        var n
        var str 
          
         //  valcont = $("#filtercomment").val();
      // processHiglighter(valcont);
        
          //str = $(this).text().toLowerCase();

        $(".comment").each(function() {
            pillid= $(this).attr('data');
            valcont = $("#filtercomment").val();
   
        
             str = $(this).text().toLowerCase();
             if (str.search(valcont.toLowerCase()) < 0) {
                $(this).closest('.pillid'+pillid).fadeOut(100);
                     if(valcont == ''){
                    $('.actionIdComment').fadeIn(100);
                }
                }else{
                       //console.log($(this).attr('data'))
                    $(this).closest('.actionIdComment .pillid'+pillid).fadeIn(100);
               
                if(findWord(valcont.toLowerCase(), str.toLowerCase()) && valcont.length >1){

                    $(".commentsComment *").highlight(valcont.toLowerCase(), "filterhighlight");
                }

                     if(valcont == '' ){
                    $('.actionIdComment').fadeIn(100);
                }
            }

        });
            
        if($('.commentsComment').css('display') == 'none' || $('.commentsComment').css('display') == 'inline'){

           $('.commentsComment').css('display', 'block'); 
        }else{

        }
        
      if(valcont == '' ){
            $('.actionIdComment').fadeIn(100);
            $('.commentsComment').css('display', 'none'); 
            $('span').removeClass('filterhighlight');
        }
       // $(".commentsComment *").highlight(valcont, "filterhighlight");
        
        valcont ='';
    } 
    
  
    function findWord(word, str) {
  return RegExp('\\b'+ word +'\\b').test(str)
}
    
    

</script>
 
