<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!--<link rel="stylesheet" href="/resources/demos/style.css"> -->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/deals_pipeline.css" rel="stylesheet"> 
<script>
function  dragg(str){
    if($('.active').parent().attr('placement') == 'delete'){
        $('.active').hide();
    }
    if(str){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../companies/dragupdate",
            data: str,
            success: function (data) {
            //alert('From Server')
            }
        })
    }   
}
</script> 
<style type="text/css">
    html, body {
  height: 100%;}
</style>
<!--<div class="row">
  <div class="col-sm-9 col-sm-offset-3 " style="margin-bottom:20px;">
      <ul class="nav nav-tabs dashboard" role="tablist">
        <li><button role="tab" class="button btn btn-primary btn-sm deals_pipeline" style="margin-right:10px;" onclick="window.location ='<?php echo base_url(); ?>dashboard'">Dashboard</button></li>
      </ul>
  </div>
  <div class="col-sm-9 col-sm-push-3"></div>
</div>-->
<div  class="mainboxs " style="overflow: hidden; margin-top: 0px;">
<div  class="column delete" placement="delete" aria-hidden="true"></div>

    <div class="row ">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <h2 class="company-header">Deals Forecast</h2>
        </div>
        <div class="col-md-2"></div>
    </div> 
    <div class="row" style="margin-top:20px;">
        <div class="col-md-12">
            <div id="pipeline_labels"></div>
        </div>
        <div class="col-md-12">
            <div id="pipe">
                <div id="pipeline_content"></div>
            </div>
        </div>
    </div> <!--END ROW-->   
</div>
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript"  src="<?php echo asset_url();?>js/deals-pipeline.js"></script>