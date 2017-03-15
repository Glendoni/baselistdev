 <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" 
      aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog small-modal">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add Company</h4>
                </div>
            
                <div class="modal-body">
                   
                    <p>Are you sure you want to add this company?</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default confirm_delete_cancel btn-block" 
                            data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-8">
                    <a class="btn btn-warning btn-ok btn-block confirm_ch_add btn-warning">Add</a>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
    <!-- #wrapper -->
    <!-- jQuery Version 1.11.0 -->
      
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript"  src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>   
      
      
      
		<script src="<?php echo asset_url();?>js/external/jquery.hotkeys.js"></script>
    <script type="text/javascript" src="<?php echo asset_url();?>js/bootstrap.min.js"></script>
    <script src="<?php echo asset_url();?>js/external/google-code-prettify/prettify.js"></script>


 

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript"  src="<?php echo asset_url();?>js/sb-admin-2.js"></script>


    <script type="text/javascript" src="<?php echo asset_url();?>js/ladda.min.js"></script>


    <script type="text/javascript"  src="<?php echo asset_url();?>js/pace.min.js"></script>     
    <!-- DATE TIME PICKER -->
    <!--<script type="text/javascript" src="https://eonasdan.github.io/bootstrap-datetimepicker/scripts/moment.js"></script>-->
    <script type="text/javascript" src="<?php echo asset_url();?>js/moment.js"></script>

    <script type="text/javascript" src="<?php echo asset_url();?>js/bootstrap-datetimepicker.js"></script>

<!--FORMAT NUMBERS WITH COMMAS (ADD CLASS NUMBER TO INPUT)-->
    <script type="text/javascript" src="<?php echo asset_url();?>js/format-numbers.js"></script>
   <script type="text/javascript" src="<?php echo asset_url();?>js/actions.js"></script>
 <script src="<?php echo asset_url();?>js/bootbox.js"></script>
<script src="<?php echo asset_url();?>js/fe_tagging.js"></script>

    <script src="<?php echo asset_url();?>js/bootstrap-wysiwyg.js"></script>
<?php if(isset($privileges) ){ ?>
<script src="<?php echo $privileges; ?>" type="text/javascript"></script>
<?php } ?>
<?PHP



$owned_urls= array('fe_read_tag', 'fe_get_tag', 'getAction', 'operation_read', 'autopilotActions', 'getCompletedActions', 'notForInvoices',  'campaign_page_getter', 'loaddata', 'getTeamStats', 'refactorFavorites','login');
   $string = current_full_url();
        for($iLpage=0; $iLpage < count($owned_urls); $iLpage++)
        {
            if(strpos($string,$owned_urls[$iLpage]) != false)
                $redirect = true;
        }
                if($redirect){
                    //echo 'Found yes';
                }else{
                    $cookie = array(
                    'name'   => 'lastpagevisited',
                    'value'  => $string,
                    'expire' =>  (86400 * 30),
                    'secure' => false
                    );

                    
                    if($string != base_url() && $string != base_url().'campaigns'){
                    
                    $this->input->set_cookie($cookie);
                    //echo  $this->input->cookie('lastpagevisited', TRUE);  
            }}

/*

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script src="<?php echo asset_url();?>js/external/jquery.hotkeys.js"></script>

*/

?>
<script>
    
 
    function blankWindowEval(window = false){
        
     if(window == 't'){
         
      $('.dashboardmaincontainer  a').attr('target',"_blank");
     }   
    }
  
  $(function(){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('.editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('.editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
  });
    
    
    $('.editorAction, .btn-group a').on('keyup mouseleave click', function(){

$('.completed-details').val($('.editorAction').html())

});
</script>
 
<script type="text/javascript">
   
    
    function mysql_to_unix(date) {
    return Math.floor(new Date(date).getTime() / 1000);
}
    
    
   
    
$(document).ready(function(){
    
 
    
    //if(history.length>0)alert("the user clicked back!")
    
 
    
    
        if((/dashboard/.test(window.location.href)) && (/dashboard\/team/.test(window.location.href)!= true)) {
      //BACK BUTTON READER      

                    $('.dashboard button').hover(function(){


if(!$(this).hasClass('requested') && $(this).attr('aria-controls') !=  'emailegagement'  && $(this).attr('aria-controls') !=  'proposals'  && $(this).attr('aria-controls') !=  'intents' && $(this).attr('aria-controls') !=  'favorites'){
    
//alert($(this).attr('aria-controls'))
    $(this).addClass('requested');  
    
    var clickedBtnVal = $(this).attr('aria-controls');
    
    var para;
    // dashboardTabLoader()    //MANAGES BACK BUTTON FUNCTIONALITY
            delete para;
               para = {'pulldetails':clickedBtnVal};
          
            $.ajax({
            type: "post",
                dataType: "json",
                data: para,
            url: "Dashboard/workflow",
            success: function(data) {
                var action;
                var coaddedres = [];
                    var recent_viewed_companies = [];
                    var customer_deal = [];
                 var idfk;
var customer_to =[];
                var  turnover = [];
                var  planned = [];
                var  action = [];
                var  actioned = [];
                 var  age_at_joining_months = [];
                var by = [];
    var name = '';
                $.each( data, function( key, val ) {
                      
                
                    switch (clickedBtnVal) {
                            
                           
    case 'customer_deal':
    $.each( val, function( keye, vale ) {
                 customer_to = vale.customer_to ? vale.customer_to : '' ;
                 turnover = vale.turnover ? vale.turnover : '';
                 planned  = vale.planned ? vale.planned :  ''; 
                 action   = vale.action ? vale.action :  '';
                actioned  = vale.actioned ? vale.actioned:  '';
         age_at_joining_months = vale.age_at_joining_months ? vale.age_at_joining_months.replace(0,''):  '';
                 by = vale.by   ? vale.by: '';  
//name = vale.name_;
   name = vale.name_.replace(/Limited|Ltd|ltd|limited/gi, function myFunction(x){return ''});                      

                     customer_deal.push('<div class="row record-holder"> <div class="col-xs-8 col-sm-4 col-md-1">'+vale.customer_from+'</div> <div class="col-xs-8 col-sm-4 col-md-1">'+customer_to+'</div><div class="col-xs-8 col-sm-4 col-md-2"><a href=companies/company?id='+vale.company_id+'>  '+name+'</a></div><div class="col-xs-12 col-sm-2 col-md-1"> '+vale.class+'</div><div class="col-xs-4 col-sm-1 col-md-1">'+vale.initial_rate+'</div><div class="col-xs-6 col-sm-2 col-md-1"> '+vale.lead_source+'</div><div class="col-xs-6 col-sm-3 col-md-1">'+age_at_joining_months+'</div><div class="col-xs-12 col-sm-2 col-md-1">'+planned+'</div><div class="col-xs-12 col-sm-2 col-md-1">'+actioned+'</div><div class="col-xs-12 col-sm-2 col-md-1">'+action+'</div><div class="col-xs-12 col-sm-2 col-md-1">'+by+'</div></div>');
                                           });
                            
                              $('#customer_deal').html(customer_deal.join( "" ));
                                   $('.customerdealcount').html(customer_deal.length); //update engagement counter

                    break;
                    case 'companies_added':

                                $.each( val, function( keye, vale ) {
                                   //   console.log(vale);
                                   name = vale.company_name.replace(/Limited|Ltd|ltd|limited/gi, function myFunction(x){return ''});
                                   coaddedres.push('<div class="row record-holder"> <div class="col-md-2">'+vale.created+'</div><div class="col-xs-4 col-sm-1 col-md-6"><a href="companies/company?id='+vale.company_id+'">'+name+'</a></div><div class="col-xs-8 col-sm-4 col-md-4"><span class="label label-'+vale.pipeline+'" style="margin-top: 3px;"> '+vale.pipeline+' </span></div></div>');
                               });

  $('#companies_addedwf').html(coaddedres.join( "" ));
                              $('.coaddedrescount').html(coaddedres.length); //update engagement counter
                                       //  
                        break;
                    case 'recent_viewed_companies':
                                         $.each( val, function( keye, vale ) {
                                             
                                              name = vale.company_name.replace(/Limited|Ltd|ltd|limited/gi, function myFunction(x){return ''});
                 recent_viewed_companies.push('<div class="row record-holder"> <div class=" col-md-2">'+vale.visit_date+'</div><div class="col-xs-4 col-sm-1 col-md-6"><a href="companies/company?id='+vale.company_id+'">  '+name+'</a></div><div class="col-xs-8 col-sm-4 col-md-2"><span class="label label-'+vale.pipeline+'" style="margin-top: 3px;"> '+vale.pipeline+' </span></div></div>');


                                         })
 $('#recent_viewed_companies').html(recent_viewed_companies.join( "" ));
                              $('.dasboardviewscount').html(recent_viewed_companies.length); //update engagement counter

                        break;   
                                    }
                    
                      
                
                });
                   
             //   Revision 1
               
             
                
                
 
//Glen
         
              
                
               
                
                blankWindowEval('<?php echo $window;?>');
            }
    
        });
            
         
            
}

})            
            
            
            
            
            
            
            $('.dashboard .btn-sm').click(function(){
 $('html, body').animate({scrollTop: $('.dashboardmaincontainer').offset().top -280 }, 'fast');   
         var  dashboardButtonClicked  = $(this).attr('href');      
       createCookie('94e5f7986ab2d1cba8be016aae11263c', dashboardButtonClicked,14);         
})
          
        
       
        
        }
    
     $('.dashboardSidebarCol').hide()
      if($('.dashboard .active button').attr('aria-controls') == "calls"){
          
           $('.dashboardSidebarCol').show()
       
      }else{
        
           $('.dashboardMainContent').addClass('col-sm-12')
            $('.dashboardMainContent').removeClass('col-sm-9')
                    $('.dashboardMainContent').addClass('col-sm-12')
      }
  
        $('.btn-sm').click(function(){
        
        if($(this).attr('aria-controls') ==  'calls'){
 

                    $('.dashboardSidebarCol').show()
                  //  $('.dashboardMainContent').addClass('col-sm-push-3')
                    $('.dashboardMainContent').addClass('col-sm-9')
                    $('.dashboardMainContent').removeClass('col-sm-12')
 

}else{
    
     $('.dashboardSidebarCol').hide()
                   // $('.dashboardMainContent').removeClass('col-sm-push-3')
                    $('.dashboardMainContent').removeClass('col-sm-9')
                    $('.dashboardMainContent').addClass('col-sm-12')
    
    
}


    });
 
    
    
      
  
        $('.btn-sm').click(function(){
        
        if($(this).attr('aria-controls') ==  'calls'){
 

                    $('.dashboardSidebarCol').show()
                   // $('.dashboardMainContent').addClass('col-sm-push-3')
                    $('.dashboardMainContent').addClass('col-sm-9')
                    $('.dashboardMainContent').removeClass('col-sm-12')
 

}else{
    
     $('.dashboardSidebarCol').hide()
                    //$('.dashboardMainContent').removeClass('col-sm-push-3')
                    $('.dashboardMainContent').removeClass('col-sm-9')
                    $('.dashboardMainContent').addClass('col-sm-12')
    
    
}


    });
    
    
var scheduleTotal  =  parseInt($('.scheduleBadge').text());
 
if(scheduleTotal <1){

$('.scheduleBtn').removeAttr('onClick').css('font-style', 'italic');

}
    
    
    
    
     var pageEval = [];
    if((/companies\/company/.test(window.location.href))) {
        pageEval = GetUrlParamID();
    }
    bindFavorites()
        //QUICKVIEW SLIDE
        var operations = [];
        var repLimited = [];
        var name = [];
    var ourconcatstring = [];
  //var pageEval = GetUrlParamID();
   
        $.ajax({
            type: "GET",
                dataType: "json",
            url: "<?php echo base_url(); ?>Actions/operations_read/"+pageEval,
            success: function(data) {
  //dont know what the fucks up with the replace array function not working ?????? Must investigate 
                 //console.log(data)   
                 $.each( data.operations, function( key, val ) {
    
                     if(typeof val != null){
                         
                           ourconcatstring  =   val.split('_');   
             repLimited =  ourconcatstring[1];
                    repLimited = ['Limited','ltd', 'LTD'];
                    name = ourconcatstring[1]
                    repLimited =   ourconcatstring[1].replace('Limited', "");
                    repLimited =   repLimited.replace('ltd', "");
                    repLimited =   repLimited.replace('Ltd', "");
                    repLimited =   repLimited.replace('LTD', "");
                   // console.log('<li><a href="<?php echo base_url();?>companies/company?id='+val.comp_id+'" >'+repLimited+'</a></li>');
                    
                     
                    
                         
                         
                 
                        // console.log(ourconcatstring[0])
                         
                         $('.tr-actions').append('<li><a href="<?php echo base_url();?>companies/company?id='+ourconcatstring[0]+'" >'+repLimited+'</a></li>');
                     }
                 })
 
                 
                if(!data.operations.length){
                    
                  $('.recent_visited_header').html('<strong>No Recently Visited Companies</strong>'); 
                    
                }
                        
              }
         });
    

 if(!(/companies\/company/.test(window.location.href))) {
     
    $('.pageQvNav').remove();
    $('.recentlyVisited').css('width', '100%');
    $('.recentlyVisited').css('border', 'none');
    $('.pageQvNav').css('border', 'none');
    $('.myActiveDiv').css('min-width', '249px');

     
 }

    if((/campaign_id/.test(window.location.href))) {
        
      $.urlParams = function(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return results[1] || 0;
}
        
        
        
        $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}
        
      var campaign_id  =   $.urlParam('campaign_id');
          var campaign_ids  =   $.urlParams('campaign_id');
     
      var para = ({'company_id':GetUrlParamID(), 'campaign_id' : campaign_id});
                          $.ajax({
                            type: "POST",
                              data: para,
                                dataType: "json",
                             url: "<?php echo site_url();?>Companies/campaign_page_getter",
                            success: function(data) {

                               if(data.Previous !== null){
                                    $('.return_to_campaign').prepend('<a class="btn btn-default btn-sm" href="<?php echo site_url();?>companies/company?id='+data.Previous+'&campaign_id='+campaign_id+'" role="button">Previous</a>');
                                }

                                if(data.NextId){
                                    $('.return_to_campaign').append('<a class="btn btn-default btn-sm" href="<?php echo site_url();?>companies/company?id='+data.NextId+'&campaign_id='+campaign_id+'" role="button">Next</a>');
                                }
                            }
                        });
            
    }
    
 
    $('.qvlink  li a').on('click', function(){
        var location = $(this).attr('data');
      //$('html, body').animate({scrollTop: $('#'+location).offset().top -280 }, 'slow');
       // $(".qv").slideToggle();  
           
               
    })
       
    $(".qvSlidebtn").click(function(){
        $(".qv").slideToggle();
              
    });
    

 
    
        $('#myTabs a').click(function (e) {
          e.preventDefault()
          $(this).tab('show')
        });
    
    
    
    
            var BreakException = {};

            try {
              $('.pipelineSelectSearch option').each( function(e){

              if( $(this).attr('selected') == 'selected'){ 
          setfilterVerbiage()
            throw BreakException;  }
             });

            } catch (e) {
              if (e !== BreakException) throw e;
            }

})






function setfilterVerbiage(){


var att;

$('.searchcriteria').prepend('<strong>Pipeline Filter: </strong>')
$('.pipelineSelectSearch option').each(function(){
attr = $(this).attr('selected');

// For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
if (typeof attr !== typeof undefined && attr !== false) {
  // Element has this attribute

if($(this).val() == 0){

$('.searchcriteria').append('All ');
}else{
$('.searchcriteria').append('  ' + $(this).val()+' <span class="lastclass">|</span>');
//$('.searchcriteria').append(' <span class="filtersearch"> | </span> ');

}
}

})




}

bindFavorites();
    
    
    
    
     
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('.editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('.editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
 
   $('.editor').on('keyup mouseleave click', function(){
var texteditor  = $(this).attr('addOutcomeEditor');
$('.textarea'+texteditor).val($(this).html())

});
    
    
    
    

function bindFavorites(){

    $('form .unassigned-star').click(function(e){
 
        e.preventDefault();
        var btnData  = $(this).attr('data');

        if($('.favForm'+btnData+' button').hasClass('unassigned-star')){

            var userBackgroundColor = []; 
            var userBackgroundColor = $('.user-profile div').css('background-color'); 
            var userColor = $('.user-profile div').css('color'); 
            var current_user_name =  $(".user-profile span").text(); //current_user_name
            var actUrl = [];

            var favformAttr  = $('.favForm'+btnData).attr('action');
            var url = favformAttr.replace('unassign','assignto');
            var addFav = $('.favForm'+btnData).serialize();

            $('.star_assigned'+ btnData).css('color',userBackgroundColor);
            $('.label-assigned'+btnData).append('<span class="label label-assigned " id="label-assigned'+btnData+'" style="background-color:'+userBackgroundColor+'; color:'+userColor+';"><i class="fa fa-star"></i>'+current_user_name+'</span>');

            $(this).hide();             
            $(this).unbind( "click" );

            //disable click temporary to stop user hitting the button whilst processing
            $.post(url,addFav, function(response){
                bindFavorites();
            })

            $(this).addClass('assigned-star');
            $(this).removeClass('unassigned-star');
            $(this).show();

         }
    });
    
    $('.qvlink  li a').on('click', function(){
        var location = $(this).attr('data');
        $.scrollTo('#'+location, 1000, { easing: 'easeInOutExpo', offset: -210, 'axis': 'y' });
        $(".qv").slideToggle();                   
    })
       
    $(".qvSlidebtn").click(function(){
        $(".qv").slideToggle();    
    });

    $('form .assigned-star').click(function(e){
        e.preventDefault();
        var btnData  = $(this).attr('data');
        if($('.favForm'+ btnData +' button').hasClass('assigned-star')){
            var favformAttr  = $('.favForm'+btnData).attr('action');
            var url = favformAttr.replace('assignto', 'unassign');
            var addFav = $('.favForm'+btnData).serialize();
            $(this).unbind( "click" );
            
            $.post(url,addFav,function(response){
                bindFavorites();
            })

            $('.star_assigned'+ btnData).css('color','#DCDCDC');
            $('#label-assigned'+ btnData).remove()
        }
        $(this).addClass('unassigned-star');
        $(this).removeClass('assigned-star');
    });  
}
</script>



<!--EMAIL DUPLICATE CHECK-->
 <script type="text/javascript">
    $(document).ready(function() {






        
        $('.search_box_cancel').click(function(){
                $('#agency_name').val('');
        })
        
        $('#message').hide();
        /// make loader hidden in start
        $("#email").bind('keyup paste', function() {
        var email_val = $("#email").val();
        var filter = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9]+.[a-z]/;
        if(filter.test(email_val)){
            // show loader
            $.post("<?php echo site_url()?>contacts/email_check", {
                email: email_val
            }, function(response){
            $('#message').html('').html(response.message).show().delay(4000).fadeOut();
            });
            return false;
        }

            });
       
    }); //end document.write
     

     
     
     
     
</script>

<!--AUTO COMPLETE-->


<style>
    .toLowerCase{ text-transform:capitalize;}
</style>

<script type="text/javascript">
// AJAX SEARCH AUTOCOMPlETE
function ajaxSearch() {
    var input_data = $('#agency_name').val();
    
if(!$('.advanced-search').hasClass('show')){
$('.search_box_cancel').show();
    $('.loading-btn-search').hide();
}
   input_data =  input_data.replace("'", "&#39;");
    //input_data =  input_data.replace("&", "&amp;");
    
    if (input_data.length < 1) {
$('#suggestions').hide();
$('#agency_name').removeClass('autocomplete-live');
    } else {
        input_data =  input_data.replace("\'", "");
var post_data = {
    'search_data': input_data,
    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
};
$.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>companies/autocomplete/",
    data: post_data,
    success: function(data) {
        //alert();
// return success
// console.log(data.html);

        
        
        $('#suggestions').show();
        
        
        
$('#autoSuggestionsList').addClass('auto_list');
$('#autoSuggestionsList').html(data.html);
$('#agency_name').addClass('autocomplete-live');
          if (data.callCH ===true) { 
          // alert('I worked');
              input_data =  input_data.replace("\'", "");
         getCompany(input_data);     
       }
    }
});
    }
}
    
    
     
    
     function dashboardTabLoader(){
        
        var readLastButtonClickedInDashboardHeaderMenuTab  = readCookie('94e5f7986ab2d1cba8be016aae11263c');
        
if(readLastButtonClickedInDashboardHeaderMenuTab){
var LastMenuTabClicked = readLastButtonClickedInDashboardHeaderMenuTab.replace('#','.');
         
        $(LastMenuTabClicked).trigger('click');
    
}
        
    }
    
    function createCookie(name, value, days) {
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                var expires = "; expires=" + date.toGMTString();
            }
            else var expires = "";               

            document.cookie = name + "=" + value + expires + "; path=/";
        }

        function readCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function eraseCookie(name) {
            createCookie(name, "", -1);
        }
    
function getCompany(input_data){
    
    input_data =  input_data.replace(" ", "");
    input_data = input_data.replace('\'', ''); 
    input_data = input_data.replace('&#39;', ''); 
    
    
    $.ajax({type:"GET",url:"<?php echo base_url(); ?>companies/getCompanyHouseDetails/"+input_data,success:function(data){var obj=$.parseJSON(data);var i=0;var text="";var preview=[];var out=[];while(obj.items[i]){if(obj.items[i].company_status=='active'){out+='<a href="javascript:;" company_number="'+obj.items[i].company_number+'" title="'+obj.items[i].title+'" postal_code="'+obj.items[i].address.postal_code+'" address_line_1="'+obj.items[i].address.address_line_1+'" locality="'+obj.items[i].address.locality+'" snippet="'+obj.items[i].address_snippet+'" company_type="'+obj.items[i].company_type+'" company_status="'+obj.items[i].company_status+'" description="'+obj.items[i].description+'" date_of_creation="'+obj.items[i].date_of_creation+'" class="companyHouseRegNum"><li class="autocomplete-item autocomplete-company toLowerCase ch_drop_title"><strong>'+ucwords(obj.items[i].title)+'</strong><br><small>Add to Baselist</small></li></a>';preview+='<a target="_blank" href="https://beta.companieshouse.gov.uk/company/'+obj.items[i].company_number+'"><li class="autocomplete-item autocomplete-contact preview_slogan" > View at Companies House   <i class="fa fa-external-link"></i><br><small>&nbsp;</small></li></a>';}
i++;if(i===7){break;}}
$('#suggestions').show();$('#autoSuggestionsList').addClass('auto_list');$('#autoSuggestionsList').html('<div class="autocomplete-full-holder"><div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 clearfix no-padding"><ul class="autocomplete-holder"><li class="autocomplete-item split-heading"><i class="fa fa-caret-square-o-down"></i> Companies</li>'+out+'</ul></div><div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 no-padding"><ul class="autocomplete-holder"><li class="autocomplete-item split-heading autocomplete-no-results"><i class="fa fa-times"></i> Preview</li>'+preview+'</ul></div></div>');if(i==0){$('#autoSuggestionsList').html('<div class="autocomplete-full-holder"><div class="col-xs-12 col-sm-12 col-md-5 col-lg-12 no-padding"><ul class="autocomplete-holder"><li class="autocomplete-item split-heading autocomplete-no-results"><i class="fa fa-times"></i> No records found</li></ul></div></div>');}
$('#agency_name').addClass('autocomplete-live');saveCompanyHandler();}});}
function saveCompanyHandler(){$('.ch_drop_title').css('background','#7fe3d5');$('.ch_drop_title').css('color','#2d2d2d');$('.ch_drop_title strong').css('font-weight','300');$('.companyHouseRegNum').click(function(){var mode="create";var user_id=<?php echo $current_user['id'];?>;var data={"registration":$(this).attr('company_number'),"date_of_creation":$(this).attr('date_of_creation'),"name":$(this).attr('title'),"postal_code":$(this).attr('postal_code'),"address":$(this).attr('snippet'),"user_id":user_id,"company_status":$(this).attr('company_status'),"address_line_1":$(this).attr('address_line_1'),"company_type":$(this).attr('company_type'),"description":$(this).attr('description'),"date_of_creation":$(this).attr('date_of_creation'),};bootbox.confirm("Are you sure want to add this company?",function(result){if(result){data=$.param(data);$.ajax({type:"POST",dataType:"json",url:"<?php echo base_url(); ?>companies/getCompany",data:data,success:function(data){if(data.status==200){window.location.href="<?php echo base_url(); ?>companies/company?id="+data.message;}}});}else{}})});};
    function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}
    $( document ).ready(function() {
        
            $('body').click(function(){
                $('#suggestions').hide();
                 $('.search_box_cancel').hide();

            });
        
            // Datetime picker
            $('#start_date').datetimepicker();
            $('#end_date').datetimepicker();
            $('#planned_at').datetimepicker();
      
            $('.planned_at').datetimepicker();
           $('#pra_weekending').datetimepicker();
           $('.weekending').datetimepicker();
            $('#actioned_at').datetimepicker();
            $('.button-checkbox').each(function () {
            // Settings
            var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
            on: {
            //icon: 'glyphicon glyphicon-check'
            },
            off: {
            //icon: 'glyphicon glyphicon-unchecked'
            }
            };
            // Event Handlers
            $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
            });
            $checkbox.on('change', function () {
            updateDisplay();
            });
            // Actions
            function updateDisplay() {
            var isChecked = $checkbox.is(':checked');
            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");
            // Set the button's icon
            $button.find('.state-icon')
            .removeClass()
            .addClass('state-icon ' + settings[$button.data('state')].icon);
            // Update the button's color
            if (isChecked) {
            $button
            .removeClass('btn-default')
            .addClass('btn-' + color + ' active');
            }
            else {
            $button
            .removeClass('btn-' + color + ' active')
            .addClass('btn-default');
            }
            }
            // Initialization
            function init() {
            updateDisplay();
            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
            $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
            }
            init();
            });
            
        
        
        
        
        
        
        $('.assign-to-form .starbtn').click(function(e){
             
            var btn = $(this);
            var form = btn.closest('form');
            var url = form.attr('action');
            var textbtn = btn.find('span.ladda-label');
            var name = btn.attr('assignto');
            e.preventDefault();
            var l = Ladda.create(this);
            l.start();
            $.post(url, form.serialize(),
            function(response){
                whenFravoriteIsClicked()


            })
            .always(function() { 
            if(typeof name != 'undefined'){
            //textbtn.text('Watched by '+name ); 
             
            }else{
            //textbtn.text('No Longer Watching');
            //form.closest('.panel').children('.panel-heading').hide();
            }  
            l.stop(); 
            //btn.attr('disabled','disabled'); 
            });
            return false;
        });
        
        
        function whenFravoriteIsClicked(){
          
                var favType  = $('.assign-to-form').attr('action');
                var favTypeEval = favType.search('assignto');
       
                var userBackgroundColor = []; 
                var userColor = $('.user-profile div').css('color'); 
                var current_user_name = $(".user-profile span").text(); //current_user_name
                var actUrl = '';
        
            if(favTypeEval >= 1 ){
                
                $('.label-assigned').remove();
                
                //console.warn('greater or equal to 1');
                userBackgroundColor = $('.user-profile div').css('background-color'); 
                $('.assign-to-form i').css('color', userBackgroundColor);
                $('.piplineUdate').append('<span class="label label-assigned" style="background-color:'+userBackgroundColor+'; color:'+userColor+';"><i class="fa fa-star"></i>'+current_user_name+'</span>');    
               actUrl = favType.replace('assignto', 'unassign');
                
                  // console.warn('asign unasign')
                   
                    // console.warn(actUrl)

            }else if($('.label-assigned').css('display') == 'none' && favTypeEval < 1 ){

 //console.warn('Less or equal to 1');
                 userBackgroundColor = $('.user-profile div').css('background-color'); 
                $('.label-assigned').show();
                $('.assign-to-form i').css('color', userBackgroundColor);
                actUrl = favType.replace('assignto', 'unassign'); 
                
            }else{

                $('.label-assigned').hide();
                $('.assign-to-form i').css('color', '#DCDCDC');
                
                    actUrl = favType.replace('unassign', 'assignto');    
            }
            
            
            
              //console.warn(actUrl)
            $('.assign-to-form').attr('action', actUrl);
        }
        
        

            // reset button on page load
            $('.submit_btn').button('reset');
            // on click action
            // VALIDATION FOR CONTACT FORM 
            $('.submit_btn').click(function(e){

            var btn = $(this);
            var form = btn.closest('form');
            var url = form.attr('action');
            var loading_display_id = btn.attr('loading-display');
            var loading_display = $('#'+loading_display_id);
            loading_display.attr('style','display:block;');
            e.preventDefault();
            btn.button('loading');
            $.post(url, form.serialize(),
            function(response){
            btn.removeClass('btn-primary').addClass('btn-success').text('Saving...');
            })
            .fail(function(response) {
            var error = jQuery.parseJSON(response.responseText)
            console.log(error['error']);
            form.find('#error_box').html(error['error']);
            form.find('#error_box').show();
            btn.addClass('btn-primary').removeClass('btn-success').text('Save');
            btn.button('reset');
            })
            .success(function(){
            location.reload(true); 
            })
            .always(function() {  

            });
            return true;
            });
            // reset button on load 
            $('.loading-btn').button('reset');
            // Click function  
            $('.loading-btn').click(function () {
            var btn = $(this)
            btn.button('loading')
            });
            // Email pop up form 
            $('.template_selector').change(function() {
            form = $(this).closest("form");
            form.find(".info_box").hide();
            form.find(".template_"+$(this).val()).show();
            });
        
           fravoriteIcon();
        
}); //end of document ready
    // Email pop up form 
    // function validate_form_email(form){
    //     if(form.)
    //     return false;
    // }
    function fravoriteIcon(){
    
    if(typeof $('.top-info-holder .label-assigned').css('background-color') != 'undefined'){
    //var  userBackgroundColor = $('.user-profile div').css('background-color'); $('.assign-to-form i').css('color', userBackgroundColor);
    }else{
        
       //$('.assign-to-form i').css('color', '#DCDCDC'); 
        
    }
        
        
        
    
}
    
    

    function validateActionForm(form){
        $(form).siblings().hide();
        var outcome_box_id = $(form).attr('outcome-box');
        var outcome_box = $('#'+outcome_box_id);
        console.log(outcome_box.find('textarea').val());
        if(!outcome_box.find('textarea').val())
        {
    outcome_box.show('slow');
    outcome_box.children('textarea').focus();
    outcome_box.children('button').click(function() {
        $(form).submit();
    });
    return false;
        }
        else
        {
    $(form).find('input[name="outcome"]').val(outcome_box.find('textarea').val());
    return true;
        }
    }
        </script>
    <script type="text/javascript" src="<?php echo asset_url();?>js/custom.js"></script>
        <script type="text/javascript">
    $(document).ready(function(){
        $(".include-exclude-drop").change(function(){
    $( ".include-exclude-drop option:selected").each(function(){
        if($(this).val()=="exclude"){
    $(".contacted-show").show();
        }
        if($(this).val()=="include"){
    $(".contacted-show").hide();
        }
    });
        });
});
    </script>
 <?php //if(ENVIRONMENT !== 'production'): ?>
  <?php if($current_user['permission'] == 'admin' || ENVIRONMENT == 'development'): ?>
    <div class="alert alert-warning" role="alert">
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
    </div> <?php endif; ?>
     <?php if((ENVIRONMENT == 'production') && ($current_user['id'] != '1') && ($current_user['id'] != '6')): ?>

 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-64636609-1', 'auto');
  ga('send', 'pageview');

</script>
   
<?php endif; ?>
<script type="text/javascript">
$('.toggle').click(function (event) {
    event.preventDefault();
    var target = $(this).attr('href');
    $(target).toggleClass('hidden show');
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
  $(window).bind('scroll', function() {
    var navHeight = 300; // custom nav height
    ($(window).scrollTop() > navHeight) ? $('nav').addClass('goToTop') : $('nav').removeClass('goToTop');
  });
});

    $('.nav-tabs a').click(function (e) {
    // No e.preventDefault() here
    $(this).tab('show');
});
</script>
<script type="text/javascript">
        $(document).ready(function() {
            $('.tr-actions').click(function(){
$('.c-a-m').trigger('click');
});
            // Javascript to enable link to tab
var hash = document.location.hash;
var prefix = "tab_";
if (hash) {
    $('.nav-tabs [href='+hash.replace(prefix,"")+']').tab('show');
} 
// Change hash for page-reload
$('.nav-tabs ').on('shown.bs.tab', function (e) {
    //window.location.hash = e.target.hash.replace("#", "#" + prefix);
});
      });    
    function ga(){}
        </script>

    <script type="text/javascript">//<![CDATA[
$(window).load(function(){
$(document).ready(function(){
   
});
});//]]> 

   
        
         function GetUrlParamID(){
var para = window.location.href.split("id=");
    var param;
        param = para[1];
    if(isInt(param)){
//console.log('jinn'+param[1])
        return param = para[1];
    }else{
        param  = param.split('&');

    if(!isInt(param)){
        param  = param[0].split('#');  

    }


    }
    return param = param[0]; 
} 

 if((/companies\/company/.test(window.location.href))) {
     
     
     var name = 'qvfinancials';
  if($("#" + name).length == 0) {
$('.qvlink a[data="qvfinancials"]').parent().remove()
}
     
$(function(){
    $("[href^='#']").not("[href~='#']").click(function(evt){
        evt.preventDefault();
        var obj = $(this),
        getHref = obj.attr("href").split("#")[1],
        offsetSize = 1450;
        $(window).scrollTop($("[name*='"+getHref+"']").offset().top - offsetSize);
    });
});
 }
        $.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}
</script>



<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>

 


<!--COMBINE MULTIPLE JS FILES-->
<?php if (isset($current_user)): ?>
<div class="col-lg-12">    
<ul class="nav nav-pills nav-justified">
<li>© <?php echo date("Y");?> Sonovate</li>
</ul>
</div>
<?php endif; ?>

 
</body>
</html>