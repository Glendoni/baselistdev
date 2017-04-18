    <div class="modal draggable-modal fade" id="editModal<?php echo $company['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="Edit <?php echo $company['name']; ?>" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            
            
        
            
            <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'edit_company'=>'1', 'class_check' => $company['class'], 'pipeline_check' => $company['pipeline']);
                 echo form_open(site_url().'companies/edit', 'name="edit_company" class="edit_company" role="form"',$hidden); ?>
            
            
            
            
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <?php if ($current_user['permission'] == 'admin'|| $current_user['department'] == 'data'): ?>
                <div>
                    <h4 class="modal-title" id="myModalLabel">
                        <input type="text" name="reg_name" value="<?php echo isset($company['name'])?$company['name']:''; ?>" id="trading_name" class="form-control" style="padding: 0;border: none;box-shadow: none;font-size: 18px;max-width: 500px;">
                        <span style="font-size: 11px;"><?php echo $company['trading_name']; ?>  </span>
                    </h4>

                </div>
                <?php else: ?>
                    <h4 class="modal-title" id="myModalLabel">
                        <?php echo $company['name']; ?>
                        <input type="hidden" name="reg_name" value="<?php echo $company['name']; ?>" id="reg_name" class="hidden" >
                       
                    </h4>
                <?php endif; ?>
              
            </div>
            
            
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div id="action-errorss" class="no-source-pipeline alert alert-warning" role="alert" style="display:none">
                <strong>Source & Class Required</strong><br> Please add a Source &amp; Class to this company.
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-sm-6 col-md-2" style="display:none;">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6" style="padding-right:2px;">
                        <div class=" form-group ">
                            <label for="turnover" class="control-label">Turnover</label>                            
                            <input type="text" name="turnover" value="" id="turnover" maxlength="50" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left:2px;">
                        <label for="turnover" class="control-label">Method</label>   
                        <select name="method" class="form-control">
                        <option value=""></option>
                        <option value="actual">Actual</option>
                        <option value="projected">Projected</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2" style="display:none;">
                <div class=" form-group ">
                    <?php
                    
                    /*
                    if (($company['pipeline']=="Customer") || ($company['pipeline']=="Proposal")){ 
                            echo form_label('Pipeline', 'company_pipeline');?>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $company['pipeline']); ?>" style="display: block;clear: left;padding: 11px; margin:0;"><?php echo ucfirst($company['pipeline']); ?></span>
                            <input type="hidden" name="company_pipeline" value="<?php echo $company['pipeline'];?>" />
                    <?php
                        } else {
                                echo form_label('Pipeline', 'company_pipeline');
                                echo form_dropdown('company_pipeline', $companies_pipeline, (isset($company['pipeline'])?$company['pipeline']:'') ,'class="form-control pipeline-validation-check"' );
                        }; 
                        
                        */
                    ?>
                </div>
            </div>
    
            <div class="col-sm-6 col-md-4">
                <div class=" form-group ">
                    <?php
                    echo form_label('Source', 'company_source');
                    echo form_dropdown('company_source', $company_sources, (isset($company['source'])?$company['source']:'') ,'class="form-control pipeline-validation-check"');
                    ?>
                    <input type="hidden" name="original_source" value="<?php echo $company['source'];?>" />
                    <input type="hidden" name="original_source_date" value="<?php echo $company['source_date'];?>" />
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class=" form-group ">
                    <label for="url" class="control-label">Website</label>                            
                    <input type="text" name="url" value="<?php echo isset($company['url'])?$company['url']:''; ?>" id="url" maxlength="100" class="form-control">
                </div>
            </div>
             <div class="col-sm-6 col-md-4">
                        <div class=" form-group ">
                            <label for="linkedin_id" class="control-label">Linkedin ID</label>                            
                            <input type="text" name="linkedin_id" value="<?php echo isset($company['linkedin_id'])?$company['linkedin_id']:''; ?>" id="linkedin_id" maxlength="50" class="form-control">
                        </div>
                    </div>
            
          
    </div>
    <div class="row">
            
                  
                  
                       <!-- Recruitment Type -->
            <!--
                                <div class="col-sm-6 col-md-4" style="display:none">
                                    <div class=" form-group ">
                                        <label for="url" class="control-label">Recruitment Type</label>
                                        <div class="tag-holder">  
                                            <span class="button-checkbox" id="contract">
                                                <button type="button" class="btn btn-default" data-color="primary" id="contract" style="width:49%;"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Contract</button>
                                                <input type="checkbox" name="contract" value="1" id="contract" class="hidden" <?php echo isset($company['contract'])? 'checked': '' ; ?> >                          
                                            </span>
                                            <span class="button-checkbox" id="contract">
                                                <button type="button" class="btn btn-default" data-color="primary" id="permanent" style="width:49%;"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Permanent</button>
                                                <input type="checkbox" name="perm" value="1" id="permanent" class="hidden" <?php echo isset($company['perm'])? 'checked': '' ; ?> >
                                            </span>
                                        </div>
                                    </div>
                                </div>


-->

              <!-- EFFECTIVE FROM -->
            
            
                                <?php /* if($deals_pipline->eff_from){ ?>

                                        <div class="col-sm-6 col-md-3 pipeline_text"  > 


                                            <div class="col-xs-6 col-sm-6 col-md-8" style="right: 14px;">
                                                <label for="pipeline_text">Pipeline Status (Drag &amp; Drop)</label>
                                               
                                                <?php echo $company['pipeline']; ?>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-4" >
                                                <label for="exampleSelect1">Delete</label>
                                                <br/>
                                                <input type="checkbox" name="remove_pipeline" style="margin-left: 18px;">
                                                <br/>
                                            </div>
                                        </div>

                                <?php }else{ ?>    

                                        <div class="col-sm-6 col-md-3 pipeline_form">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px;padding-right: 2px;">
                                                <label for="exampleSelect1">Pipeline Status</label>
                                                    <?php echo form_dropdown('pipeline_status', $deals_pipeline_status , 0,'class="form-control"' );    ?>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-right: 0px;padding-left: 2px;">
                                                <label for="exampleSelect1"> Month Due</label>        
                                                <?php // echo form_dropdown('pipeline_month', $deals_pipeline_months , 0,'class="form-control"' );    ?>
                                                <select id="mounthdue" name="pipeline_month" class="form-control"></select>
                                            </div>
                                        </div>

                                <?php }  */?>
                                
                                
             <?php /*
        if (isset($company['emp_count']) && $company['emp_count'] = false ):?>
                        <div class="col-sm-6 col-md-4">
                            <div class=" form-group">
                                <label for="emp_count" class="control-label">Employees</label>                            
                                <input type="text" name="emp_count" value="" id="emp_count" maxlength="50" class="form-control">
                            </div>
                        </div>
                        <?php endif;  */?>
               
                    <div class="col-md-6">
                            <div class=" form-group ">
                                <label for="trading_name" class="control-label">Trading Name</label>                            
                                <input type="text" name="trading_name" value="<?php echo isset($company['trading_name'])?$company['trading_name']:''; ?>" id="trading_name" class="form-control">
                           
                            </div>
                        <div class="row"> </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class=" form-group ">
                            <label for="phone" class="control-label">Phone</label>                            
                            <input type="text" name="phone" value="<?php echo isset($company['phone'])?$company['phone']:''; ?>" id="phone" maxlength="50" class="form-control">
                            
                        </div>
                    </div>
                   
          <!--HIDDEN UNLESS SPECIAL INSIGHT-->
                    <div class="col-sm-12">
                        <div id="show_si_box" class="show_si_box" style="display:none">
                                    <div class="alert alert-info" role="alert">
                            <div class=" form-group ">
                                <label for="source_explanation" class="control-label">Special Insight <span id="specialInsightRequired">(Required)</span></label>
                                <input type="text" name="source_explanation" value="<?php echo isset($company['source_explanation'])?$company['source_explanation']:NULL; ?>" id="source_explanation" class="form-control source_explanation">
                            </div>
                            </div>
                        </div>
                    </div>
 
                        
     
        
        <div class="col-md-12 target_sectors  ">
            <label for="sectors" class="control-label">Target Sectors</label>
            <div class="tag-holder">
            <?php   
            foreach ($target_sectors_list as $key => $value): ?>
                <span class="button-checkbox">
                    <button type="button" class="btn btn-checkbox" data-color="primary" >&nbsp;<?php echo $value; ?></button>
                    <input type="checkbox" name="add_sectors[]" value="<?php echo $key; ?>" class="hidden" <?php echo (isset($company['sectors']) and array_key_exists($key,$company['sectors']))? 'checked': '' ; ?>  />
                </span>
            <?php endforeach ?>
            </div>

        </div>
    </div> <!--End of row -->
    
         <div class="row">
            <div class="col-md-12 other_sectors <?php echo $sectorEval; ?>" style="margin-top:10px;">
                <label for="sectors" class="control-label">Other Sectors</label>
                <div class="tag-holder">
                <?php   
                foreach ($not_target_sectors_list as $key => $value): ?>
                    <span class="button-checkbox">
                        <button type="button" class="btn btn-checkbox" data-color="primary" >&nbsp;<?php echo $value; ?></button>
                        <input type="checkbox" name="add_sectors[]" value="<?php echo $key; ?>" class="hidden" <?php echo (isset($company['sectors']) and array_key_exists($key,$company['sectors']))? 'checked': '' ; ?>  />
                    </span>
                <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="modal-loading-display text-center " id="loading-display-<?php echo $company['id']; ?>" style="display:none;">
            <span class="btn btn-default btn-lg" ><i class="fa fa-refresh fa-spin"></i></span>
        </div>
    </div> <!-- END of modal-body -->
            
    <div class="modal-footer bespoke_submit_btn">
        <button type="submit" class="btn btn-sm btn-warning btn-block ladda-button  submit_btn disable_no_source disable_no_si" edit-btn="editbtn<?php echo $company['id']; ?>" loading-display="loading-display-<?php echo $company['id']; ?>" data-style="expand-right" data-size="1" >
            <span class="ladda-label">Save</span>
        </button>
    </div>
    <div class="modal-footer">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <small class="popUpCreatedAt">
            <b>Company Created:</b> <?php echo date("d/m/Y",strtotime($company['created_at']));?> - <?php echo $created_by_name['name']; ?>
            </small>
        </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <small>
        <b>Last Updated:</b>
        <?php echo isset($company['updated_at'])?date("d/m/Y",strtotime($company['updated_at']))." - ".$company['updated_by_name']:'Never'; ?>   
        </small>
    </div>
    </div>
    <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>










<div class="modal draggable-modal  fade" id="editTag<?php echo $company['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="Edit <?php echo $company['name']; ?>" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 130%;
">
            <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'edit_company'=>'1', 'class_check' => $company['class'], 'pipeline_check' => $company['pipeline']);
                 echo form_open(site_url().'companies/edit', 'name="edit_company" class="edit_company" role="form"',$hidden); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <?php if ($current_user['permission'] == 'admin'): ?>
                                            <h4 class="modal-title" id="myModalLabel">
                                                <p  class="form-control" style="padding: 0;border: none;box-shadow: none;font-size: 18px;max-width: 500px;"><?php echo isset($company['name'])?$company['name']:''; ?>  Tags </p>
                                                
                                                <span style="font-size: 11px;"><?php echo $company['trading_name']; ?></span>
</h4>
                                            
                <?php else: ?>
                                <h4 class="modal-title" id="myModalLabel">
<?php echo $company['name'] . ' Tags'; ?>
                          

</h4>

                                <?php endif; ?>

            </div>
    <div class="modal-body">
       
    <div class="row">
            
                
        <div id="popuptag"></div>
        
        
       
                <div class="col-md-12 target_sectors" style="display:none;">
                    <label for="sectors" class="control-label">Target Sectors</label>
                    <div class="tag-holder">
                    <?php   
                    foreach ($target_sectors_list as $key => $value): ?>
                        <span class="button-checkbox">
                            <button type="button" class="btn btn-checkbox" data-color="primary" >&nbsp;<?php echo $value; ?></button>
                            <input type="checkbox" name="add_sectors[]" value="<?php echo $key; ?>" class="hidden" <?php echo (isset($company['sectors']) and array_key_exists($key,$company['sectors']))? 'checked': '' ; ?>  />
                        </span>
                    <?php endforeach ?>
                    </div>

                </div>
            </div>
    
       
        <div class="modal-loading-display text-center " id="loading-display-<?php echo $company['id']; ?>" style="display:none;">
            <span class="btn btn-default btn-lg" ><i class="fa fa-refresh fa-spin"></i></span>
        </div>
    </div>
            
           
            <div class="modal-footer">
                
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
               <small class="popUpCreatedAt">
                    <b>Company Created:</b> <?php echo date("d/m/Y",strtotime($company['created_at']));?> - <?php echo $created_by_name['name']; ?>
                   </small>
            </div>
                
                
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <small>
                      <b>Last Updated:</b>
                    <?php echo isset($company['updated_at'])?date("d/m/Y",strtotime($company['updated_at']))." - ".$company['updated_by_name']:'Never'; ?>   
                </small>
                   </div>
                
                
                
                
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>





