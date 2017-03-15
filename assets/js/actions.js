var $;
$(document).ready(function () {
 bindTextEditor()
  if ((/companies\/company/.test(window.location.href))) {
      
      $('#sidebar').css('width', '140px')

//BEGIN BREAD SCROLL
    function initbreadscroll() {
        window.addEventListener('scroll', function(e){
            var distanceY = window.pageYOffset || document.documentElement.scrollTop,
                shrinkOn = 300,
                header = document.querySelector("breadcrumbscroll");
            if (distanceY > shrinkOn) {
                classie.add(header,"smaller");
            } else {
                if (classie.has(header,"smaller")) {
                    classie.remove(header,"smaller");
                }
            }
        });
    }
    window.onload = initbreadscroll();


/*!
 * classie v1.0.0
 * class helper functions
 * from bonzo https://github.com/ded/bonzo
 * MIT license
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true, unused: true */
/*global define: false */

( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else {
  // browser global
  window.classie = classie;
}

})( window );
///END OFBREAD SCROLL

        $('.timeline-header .showText').click(function () {
            var activeMenu =  $('.activeMenu').attr('data');
            var status = $('.actionMsg').css('display'); 
            $('.callbackActionTextBox').toggle(false);
            
            if (status === 'block' || status === 'inline') { $('.actionMsg').hide();  $('.showText').text('Show/Comment');} else {
                $('.actionMsg').show();
                $('.showText').text('Hide/Comment');
                 
            }
        });
        
            $('.showCommentAddBtn').hide();
      $('.showCommentsearch').hide();
           // $('.showText').hide();
  
            $('.showCommentAddForm').hide();
       $('.showCommentAddBtn').on('click', function(){
           
            var blockStatus  = $('.showCommentAddForm').css('display');
            if (blockStatus === "block"){
                $('.showCommentAddForm').toggle(false);
                
            } else {
                 $('.showCommentAddForm').toggle(true);
                
            }
           
              var parid = GetUrlParamID();
           $('#comcompany_id').val(parid);
           
        });
        
    
        $('#actionSendComment').submit(function(e){
            e.preventDefault();
           var param =  $('#actionSendComment').serialize();
        
                $.ajax({
                  type: "POST",
                    data: param,
                      dataType: "json",
                  url: "../Actions/addActionsComment",
                  success: function(data) {  
                 $('.timeline_inner').html('');
                      $('#commentcontent').val('');
                      
                     getActionData('comment',true);
                      $('.actionAll').trigger('click');
                       $('.showCommentAddForm').hide();
                  }
                  });
              
            $('.timeline-entry').show();
            
        })
      $('#btn-input').val('');  
        getActionData(); //Get actions
      
  }
      
  });
function getActionData(scope = false){ //get all actions in multidimentional json array
        if ((/companies\/company/.test(window.location.href))) {
            
            var parid = GetUrlParamID();
        $.ajax({
            type: "GET",
            url: "../companies/getAction/"+parid,
            success: function(data) {
                $('.timeline_inner').html('');
                $('.timeline_inner').append(writeactions(data)); 

                //ADD ALL AFTER LOAD BINGING HERE
                callbackActionTextBox();
                getemailengagement(scope);
                bindAddCallBackToCompletedAction();
                add_outcome();
                bindPillerTitles();
                removeOutsandingAction();
                mainMenuQty(scope);
                comments_decoder();
                
                  adjustment_process_timeline();
                 //  adjustment_set_required();

                //$('.follow-up-date').datepicker();
                var dateToday = new Date();
                $('.actiondate').datetimepicker({ minDate: dateToday });
               
                $('.form .actionContact').clone().prependTo('.actionForm');
                  
                $('.form #action_type_planned').clone().prependTo('.formOutcome');
             
                $('.form #who_user_id').clone().prependTo('.formOutcome .who_is_clone');
                $('select[name="action_type_planned"]').addClass('action_type_planned');
                //bindfollowUpInfoBtn(); 


              //  $('.9714596251932ddaee51f652b03586a7d3abc0e7').prepend('<span class="btn btn-default btn-xs btn-danger triggerdownload hint--top-right" data-hint="Download Attached File" data="9714596251932ddaee51f652b03586a7d3abc0e7" style="float: right;text-transform:capitalize;margin-left: 2px;">Download  upppp text nut</span>')
                    // $('.outcomeform .actionContact ').prop('disabled', false);
                    //$('.outcomeform .actionContact').attr("disabled", "disabled");
                    //$('.outcomeform .actiondate').attr("disabled", "disabled"); 
 
 
$.each( data[4][0], function( k, val ) {
                    
                       
                       
                       $('.file'+val.action_id).prepend('<span class="btn btn-default btn-xs btn-danger triggerdownload hint--top-right" data-hint="Download Attached File" data="'+val.encryption_name+'" style="float: right;text-transform:capitalize;margin-left: 2px;">Download '+ val.name+'</span>')
                       
 })
 
  
                
            } //end success
        });   

            
            
     
            
            
        $('.timeline-entry').show();
            
        }
            comments_decoder();
     }


function comments_decoder(){
    
                    $(".comment").each(function(){
//console.log($(this).text());
                    $(this).html($(this).text())
})
    
    
}

function writeactions(data, scope = false){

    //dealTemplate()
        var useractionsections;
        var action_types_array;
        var  action_types_list;
        var actionType = [];
        var icon;
        var initial_fee=[] ;
        var initial_fee_cal;
        var  actions_outstanding = false;
        var actions_cancelled = false;
        var comments = [];
        var pipeline;
        var commentMenu =  [];
        var actionresulted = [];
        var actionresult = [];
        var actionresults = [];

        stickMenu() // sticky menu  check to see if still valid ==
        var obj= data //$.parseJSON(data

            $.each( obj, function( k, val ) {

                if ( val[0]['action_types_array'] !== 'undefined'){
                        action_types_array  =   val[0]['action_types_array'];
                }

               if (typeof action_types_array !== 'undefined'){
                   action_types_list  = action_types_array; 
                   //console.log(pipeline);
                }   
            })

            jQuery.each( obj, function( k, val ) {
                useractionsections  =  val[0];
                 if( typeof useractionsections === "object" && !Array.isArray(useractionsections) && useractionsections !== null){
                   jQuery.each( useractionsections, function( kp, valp ) {
                    //getAction
                       jQuery.each( valp, function( kpt, action ) { 

                            actionType = action_types_list[action['action_type_id']] ;

                            switch (kp) {
                                case 'actions':

                                break;
                                case 'actions_outstanding':

                                if(action['initial_rate']){
                                    initial_fee = (parseFloat(action['initial_rate']*100).toFixed(2));
                                }                    

                                    actions_outstanding = action['action_id']?action['action_id'] : '';

                                       // console.warn('outstanding--------------------------------'+action['action_id'])
                                break;
                                case 'actions_completed':
                                    //console.info('actions_completed-- '+actionType+ action['image']);
                                          //console.log('  waaaaaarn '+action['comments'])
                                    
                                      if(action['initial_rate']){
                                    initial_fee = (parseFloat(action['initial_rate']*100).toFixed(2));

                                            //initial_fee.push(initial_fee);
                                } 
                                            pipeline =  action['comments'];   
                                break;
                                case 'actions_cancelled':
                                    //console.info('actions_cancelled-- '+actionType+ action['image']);
                                        actions_cancelled = action['comments'];
                                         //console.warn('actions_cancelled-------------------------------'+actions_cancelled);
                                break;
                                case 'Comments':

                                        comments = action['comments'];    
                                break;
                            }

                            if (typeof action['image'] !== 'undefined' || actions_cancelled !='' || comments !=''){   

                                  if(pipeline != 'Pipeline changed to Customer' ){

                                        pipeline = false;
                                    }

                            if (typeof actionType !== 'undefined'){

                                icon =  getIcon(actionType);



                                actionresults  =    actionProcessor(actionType ,action,icon,initial_fee,pipeline,actions_outstanding,actions_cancelled,comments,kp);

                                actionresult.push(actionresults)

                                  // $('.timeline_inner').append(actionresults);
                                actions_outstanding = '';
                                //actions_cancelled = '';

                            }


                    }

              })

        })
                        if(scope){
                            $('.'+scope).trigger('click');
                        }
        }

     });  //loop end
       actionresult = actionresult.join("");
comments_decoder()
           return actionresult;  
    
   

}
    function callbackActionTextBox(){
        $('.callbackAction').on('click', function(){

            var dat = $(this).attr('data');
            var blockStatus  = $('.box'+dat).css('display');
            var username;
            var listName =[];
            var usernameID = [];

             $('#formcallback'+dat+' select > option').each(function(){
             username  = $('.actionMsg'+dat+' span').text();
            username  = username.replace(' ','');
            listName = this.text.replace(' ','');
            usernameID = parseInt(this.value);
                if(username){
                    if(username.replace(' ', '') === listName){

                    $('#formcallback'+dat+' .actionContact option[value='+usernameID+']').prop('selected','selected');

                    }

                }
            })


            $('.textarea'+dat).attr('placeholder', 'Add outcome');

          if(!$(this).hasClass('appendCallbackContacts')){
                $('.box'+dat+'  .action_type_planned option[value=]').prop('selected','selected');
                $('.box'+dat+'  .actionContact option[value=]').prop('selected','selected');    
                $('.box'+dat+' .actionContact ').prop('disabled', false);
                $('.box'+dat+' .actionContact').attr("disabled", "disabled");
                $('.box'+dat+' .actiondate').attr("disabled", "disabled");
                $('.box'+dat+' .actiondate').val("");
                $('.box'+dat+' .actionContact option[value=]').attr('selected','selected');
                $('.box'+dat+' .formOutcome').show();
            


        }
            if ($('#callBackActionStatus'+dat).val() == 'cancelled'){
                $('#callBackActionStatus'+dat).val('completed'); 
            } else { 
                    $('#callBackActionStatus'+dat).val('completed');

                    $('.actionMsg'+dat).toggle(true);
                    $('.outcomeMsg'+dat).toggle(true);
                    $('#callBackActionStatus'+dat).val('completed');

                    if (blockStatus === "block"){
                        $('.box'+dat).toggle(false);

                        $('.actionMsg'+dat).toggle(false);
                        $('.outcomeMsg'+dat).toggle(false);
                        $('#callBackActionStatus'+dat).val('');
                    } else {
                        $('.box'+dat).toggle(true);
                    }
            }
            
            
            
             
            bindTextEditor()
            
            
        })
    }
    function add_outcome(){ //Redundent function
        
        $('.callbackActionTextBox_ form').submit(function(e){
            e.preventDefault();
            var urll = $(this).attr('action');
            //alert(urll)
            var outcomeId = $(this).attr('data');
           // alert(outcomeId) 
          //JS JASON WITH POST PARAMETER
                 var para = $(this).serialized();
                  $.ajax({
                        type: "POST",
                          data: para,
                            dataType: "json",
                        url: urll,
                        success: function(data) {
                         getActionData(true);
                        
                          
                        }
                    }); 
            
               // $('.actionAll').trigger('click');
        })
    } 





function bindTextEditor(){
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
    
	$('.editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
  });
    
    
    
}
function bindAddCallBackToCompletedAction(){
    var followUpCompleteddate = [];
    var param =  $(this).serialize();
    var followup = [];
    var contactDetails = [];
    var actionOutcome = [];
    var overdueStatus = []
    var cancellation = '';
  var getUrlIdParam = GetUrlParamID();
        $.ajax({
          type: "POST",
          data: param,
          dataType: "json",
          url: "../companies/getCompletedActions/"+getUrlIdParam,
          success: function(data) {
                   var obj= data     
                   var i = 1 ;

                      $.each( obj, function( k, action ) {
                            //console.debug(val[0]['action_types_array']);
                       if(i===1){
                         $('.outcomeMsg'+action['followup_action_id']).append('<br /><hr />')
                       }

                        if(action['action_type_id'] == 11  && action['followup_action_id'] != null && action['followup_action_id'] != null ){

                            followUpCompleteddate = '<span class="label label-warning" style="margin-right: 3px;">Follow up planned: '+ formattDate(action['planned_at'])+' </span>';
                           if (action['cancelled_at'] != null){
                                     cancellation = '<span class="label label-danger" style="margin-left: 5px;">Cancelled: '+formattDate(action['cancelled_at'])+ '</span>';
                           }
                       }

                      if (action['action_type_id'] == 11  && action['followup_action_id'] != null && action['planned_at'] == null && typeof action['planned_at'] != 'undefined' && typeof action['planned_at'] != null){
                                followup = '<span class="label label-warning" style="margin-right: 3px;"> Follow Up Action:  '+formattDate(action['planned_at'])+' </span>';
                            }

                      if (action['action_type_id'] == 11  && action['followup_action_id'] != null && typeof action['planned_at'] != 'undefined' && typeof action['planned_at'] != null){

                          if (action['first_name'] != null){

                             contactDetails = ' <span class="label label-primary">Contact: '+action['first_name']+' '+action['last_name']+' </span><br>';

                          }

                      }

                       if (action['action_type_id'] == 11 ){

                            overdueStatus = '<span class="label label-danger">Overdue</span>' ;
                         
                          var dateCompare = (new Date() - Date.parse(action['planned_at'])) >= 1000 * 60 * 30;
                            
                          if (dateCompare == false && typeof action['planned_at'] != 'undefined'){
                                overdueStatus = '';
                          }

                         if (typeof action['outcome'] == 'undefined'  || action['outcome'] == null){
                             actionOutcome = ''
                         } else { 
                             actionOutcome = '<div class="actionOutcomeText"><strong>Outcome: </strong></br><span class="commentFUA">'+action['outcome']+'</span></div>';

                         }           

                            //$('.outcomeMsg'+action['followup_action_id']).append('<div class="followcont">'+followup+ ' ' +followUpCompleteddate+cancellation+contactDetails+
                        //' <hr><span class="comments"><br><strong>Action: </strong></br><span class="commentFUA">'+action['comments']+'</span><br>'+actionOutcome+
                        //'</span></div>'); 
                        }
                        followUpCompleteddate = '';
                        cancellation = '';
                        i++;
                })


            } 

        })

        $('.callbackActionTextBox form').submit(function(e){
           
                e.preventDefault();
                var url = $(this).attr('action');
               var outcomeId = $(this).attr('data');
 
                //JS JASON WITH POST PARAMETER
                var para = $(this).serialize();
                $.ajax({
                    type: "POST",
                    data: para,
                    dataType: "json",
                    url: "../"+url,
                    success: function(data) {

                        
                        
                        if(data.action_type_planned){
                        getActionData(true);
                        }else{
                          getActionData();  
                        }

                        var submittedFormId = data.followup_action_id;

                         $('.box'+submittedFormId+ ' .actionContact').val('')
                         $('.box'+submittedFormId+ '  .planned_at').val('');
                         $('.box'+submittedFormId+ ' textarea').val('');

                         $('.outcome'+ outcomeId).hide();
                    }
                });

            })

}
    function bindPillerTitles(){

        $('.pillerTitle').click(function(){
            var dat = $(this).attr('data');
            var blockStatus  = $('.piller'+dat).css('display');
            
            if (blockStatus === "inline"){
                $('.piller'+dat).toggle(false);
                $('.box'+dat).toggle(false);
              
                
           // $('.textarea'+dat).toggle(false);
            } else {
           if ($(this).hasClass('showOutstandingForm')){
                 //$('.box'+dat).toggle(true);
           }
                $('.piller'+dat).toggle(true);
            }

        });
    }
     function removeOutsandingAction(){
         
          $('.removeOutsandingAction').click(function(){
             var dat = $(this).attr('data');
                $('.textarea'+dat).attr('placeholder', 'Add cancellation reason'); 
    $('.box'+dat+' .formOutcome').hide();
    $('.box'+dat+'  .action_type_planned option[value=]').prop('selected','selected');
    $('.box'+dat+'  .actionContact option[value=]').prop('selected','selected');    
    $('.box'+dat+' .actionContact ').prop('disabled', false);
    $('.box'+dat+' .actionContact').attr("disabled", "disabled");
    $('.box'+dat+' .actiondate').attr("disabled", "disabled");
    $('.box'+dat+' .actiondate').val("");
    $('.box'+dat+' .actionContact option[value=]').attr('selected','selected');

              
              if ($('#callBackActionStatus'+dat).val() == 'completed'){
                 $('#callBackActionStatus'+dat).val('cancelled');   
              } else { 
                $('#callBackActionStatus'+dat).val('cancelled'); 
                $('.actionMsg'+dat).toggle(true);
                $('.outcomeMsg'+dat).toggle(true);
                 var blockStatus  = $('.box'+dat).css('display');
                if(blockStatus === "block"){
                     $('.outcome'+dat+ ' .box'+dat).toggle(false);
                     $('.actionMsg'+dat).toggle(false);
                     $('.outcomeMsg'+dat).toggle(false);
                     $('#callBackActionStatus'+dat).val('');
                } else {
                     $('.outcome'+dat+ ' .box'+dat).toggle(true);
                 }
              }
            });
         
         //getActionData();
         
     }
    function getemailengagement(scope){
     
    var myParam = window.location.href.split("id=");
    var action ;
        var i = [];
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "../companies/autopilotActions/"+myParam,
        success: function(data) {

            var action;
            var items = [];
            var idfks;
            var  i = 0
            var email_by  = [];
            var contactName = [];
            $.each( data, function( key, val ) {              
                switch (val.action) {
                    case '1':
                    action  = '<span class="label label-success">Opened</span>'; 
                    break;
                    case '4':    
                    action  = '<span class="label label-danger">Unsubscribed</span>'; 
                    break;
                    case '2':
                    action =  '<span class="label label-success">Clicked</span>';
                    break;
                }


                  if (val.first_name != null){
                      contactName = '<div class="label label-primary hint--top-right"   data-hint="Name" style="float:right; margin-top:-19px; ">'+val.first_name+ ' '+ val.last_name+'</div>';
                        }

                if ( val.campaign !== null ){
                    if (val.action != '3'){
                        i++;
                        /*
                        $( '<li class="list-group-item"><div class="row"><div class="col-xs-6 col-md-7"><h4 style="margin:0;">'+val.campaign_name+'<div class="mic-info">'+val.date+ ' by '+val.email+
                        '</div></h4></div><!--END COL-MD-4--><div class="col-xs-6 col-md-5" style="text-align:right;"><span class="label label-primary" style="font-size:11px;  ">'+val.first_name+ ' '+ val.last_name+
                        '</span> '+action+' </div></div></li>' ).prependTo('#marketing_action ul'); */
                        if(val.email != null){
                        
                           email_by = 'by '+val.email;
                        
                        }
                        
                $('.timeline_inner').append('<div class="timeline-entry   actionIdactions_marketing" style="dislay:none;"> <div class="timeline-stat"> <div class="timeline-icon label-primary " style="color: white;"><i class="fa fa-envelope-o fa-lg"></i></div></div><div class="timeline-label"> <div class="mar-no pad-btm" style="margin-bottom:4px;"><h4 class="mar-no pad-btm"><a href="javascript:;" class="actionPillHeaderTitle"> '+val.campaign_name+' <span class"eeprefix">(Outbound Marketing)</span> </a>   </h4>'+'<span class="label label-warning">'+val.date+'</span></div><div style="float:right; margin-top:-40px; margin-left:3px;">'+action+'</div>'+contactName+'<div class="actionMsgText"><span class="actionMsg commentsComment"></span><hr></div><div> <div class="mic-info"> '+email_by+'</div></div></div>')
                    }
                }
                    //$('#sidebar').hide();

          
                //$(window).scroll(show);
            });
       
            $('.marketingAcitonCtn').text(parseInt($('.marketingAcitonCtn').text()) + i);
            
            $(items.join( "" )).prependTo('#marketing_action ul');
            //if(i) $('#outstanding h4,.actionMsg h4').hide();

 
            if(i < 1){
             $('a[data="actions_marketing"]').attr('disabled', true);
            }

            mainMenuQty(scope);   
         
        }


    });
}
    function mainMenuQty(showSchduledMenu = false){

        var action;
        var qtyaction;
        var i =0;
        $('.nav-stacked li a').each(function(){
            action  = $(this).attr('data');
            qtyaction = $('.actionId'+action).length;
            $('.qty'+action).text(qtyaction);
                //console.debug($('.actionId'+action).length);
            
            //console.log(qtyaction  + ' ====='+action )
            if(qtyaction < 1 && action != 'All' && action != 'actions_marketing' ){
            //console.log('actionId'+action)
            $('a[data="'+action+'"]').attr('disabled', true);
            }
            
            i = (qtyaction+i);
            action = '';
        })
       
        $('.qtyAll').text(i)

        var overdueStatus = $(".overdueAction").length;
        if (overdueStatus){
            $('.qtyactions_outstanding').css({'background': '#d9534f','color': '#ffffff', 'font-weight' : '600'});
        }
                       intefaceVisibility();
                         $('.actionMsg').show();  

                    $('.formOutcome .action_type_planned').change(function(){

                        var followupOutcomeShowHide  = $(this).val();
                        var bun = $(this).closest("form").attr('data');
                                    var boxeval ;
                        formBox  = '.box'+bun;

                          if(followupOutcomeShowHide){
                            
                        $(formBox+' .actionContact ').prop('disabled', true);
                        $(formBox+' .actionContact').removeAttr("disabled");
                        $(formBox+' .actiondate').removeAttr("disabled");
                            boxeval = $(formBox+' .actiondate').attr('disabled');

                        var username;
                        var listName =[];
                        var usernameID =  [] ;
                            
                             $('.box'+bun+' select > option').each(function(){
 //alert($('.box'+bun+'  .actionContact').text())
                                 usernameID = this.value;
                             username  = $('.piller'+bun+' span').text();
                            username  = username.replace(' ','');
                            listName = this.text.replace(' ','');

                            if(username.replace(' ', '') === listName){
                                
                                if(!$('.outcome'+bun+' .actionContact').val())
                                    $('.box'+bun+'  .actionContact option[value='+parseInt(usernameID)+']').prop('selected','selected');
                             }
                            })
                        }else{
                            $(formBox+' .actiondate').val("");
                           $('.outcome'+bun+' .actionContact option[value=]').attr('selected','selected');

$('.box'+bun+'  .actionContact option[value=]').prop('selected','selected');

                            $(formBox+' .actionContact ').prop('disabled', false);
                            $(formBox+' .actionContact').attr("disabled", "disabled");
                            $(formBox+' .actiondate').attr("disabled", "disabled");
                        }
                    })

        if(showSchduledMenu){
      //   $('.actionNav a[data="actions_outstanding"]').trigger('click')
        }
      
            $('.editor').on('keyup mouseleave click', function(){
            var texteditor  = $(this).attr('addOutcomeEditor');
            $('.textarea'+texteditor).val($(this).html())

            });


            //Handles action follow up actions output
            $(".commentFUA").each(function(){
            //console.log($(this).text());
            var kip = $(this).text()
            $(this).html(kip)
            })
    
              jQuery.fn.highlight = function (str, className) {
                            var regex = new RegExp(str, "gi");
                            return this.each(function () {
                                $(this).contents().filter(function() {
                                    return this.nodeType == 3 && regex.test(this.nodeValue);
                                }).replaceWith(function() {
                                    return (this.nodeValue || "").replace(regex, function(match) {
                                        return "<span class=\"" + className + "\">" + match + "</span>";
                                    });
                                });
                            });
                          };
        
       updateDateTime();
       downloadattachedfile();  
    } 

function updateDateTime(){
      // alert()data-date-format="YYYY/MM/DD"
       $('.datechanger').datetimepicker({
         dateFormat: 'yyyy/mm/dd H:m',
        // your options
    }) 
 
$('.datechanger').change(function(){
      $('datechanger').css('color', '#f0ad4e');
    //alert($(this).val())
    
})
 
    $('.datechanger').on("dp.change",function (e) {
       // alert('helllo'+$(this).val())
    
        
        var datechangerData =  $(this).attr('data'); // data action id 9163
    
     
     var datehidden = $('.datechangerh'+datechangerData).val($(this).val());
          $('.datechanger').css('color', '#f0ad4e');
    } ); 
    
    
    $('.datechanger').on("dp.show",function (e) {
        
          $('.datechanger').css('color', '#f0ad4e');
        
          var datechangerData =  $(this).attr('data'); // data action id 9163
    
     var datehidden = $('.datechangerh'+datechangerData).val('');
        
          $('.datechanger').css('color', '#f0ad4e');
    } );
    
    $('.datechanger').on("dp.hide",function (e) {
        
    
    var datechangerData =  $(this).attr('data'); // data action id 9163
    
     var datehidden = $('.datechangerh'+datechangerData).val();
    var datechanger =  $(this).val(); // get main value
           
        if(datehidden){
                      var para = { "datechanger": datechanger  , "id": datechangerData };
                      $.ajax({
                        type: "POST",
                          data: para,
                            dataType: "json",
                        url: "../actions/changeActionDate",
                        success: function(data) {
                              $('#ui-datepicker-div').hide();
                             $('.bootstrap-datetimepicker-widget').hide();
                            mainMenuQty();
                            getActionData();
                            
                            // mainMenuQty();
                          //  updateDateTime();
                         //console.log(data);
                        }
                        });
       }else{
        
          $('.datechanger').val('');
             $('datechanger').css('color', '#ffffff');
       }
       
        
    } );
 
    $('.datechangersss').datepicker({
        useCurrent: false,
    dateFormat: 'yyyy/mm/dd H:m', 
    onClose: function() { 
        
         $('.bootstrap-datetimepicker-widget').hide(); // hide datepicker
    
    var datechangerData =  $(this).attr('data'); // data action id 9163
    
     var datehidden = $('.datechangerh'+datechangerData).val();
     
   // console.log('datechangerData '+datechangerData);
    var datechanger =  $(this).val(); // get main value
    
     //console.log('datechanger '+datechanger);
    // var id =  $(this).attr('data'); // 
    
    
     $('.datechangerh'+datechangerData).val(datechanger);
        
       if(datechanger  != datehidden) {
        
           console.log(datehidden)
        if(datechanger){
                      var para = { "datechanger": datechanger  , "id": datechangerData };
                      $.ajax({
                        type: "POST",
                          data: para,
                            dataType: "json",
                        url: "../actions/changeActionDate",
                        success: function(data) {
                              $('#ui-datepicker-div').hide();
                             $('.bootstrap-datetimepicker-widget').hide();
                            mainMenuQty();
                            getActionData();
                            
                            
                           
                            
                            
                            // mainMenuQty();
                          //  updateDateTime();
                         //console.log(data);
                        }
                        });
       }
       }
        
}});  
     
}


function  downloadattachedfile(){
     $('.triggerdownload').unbind('click')
                $('.triggerdownload').click(function(){
var filestring  = $(this).attr('data');
                            //alert();8151325dcdbae9e0ff95f9f9658432dbedfdb209
                            $('body').append('<iframe src="downloadking/'+filestring+'" id="documentdownload" style="display:none;"></iframe>');
                })
    
    
    
}



function intefaceVisibility(){
    
         if(parseInt($(".qtyAll").text()) == 0){

$('#sidebar').hide();
 $('.timeline').hide();
             $('.noactionmsg').show();

}else{
 $('#sidebar').show();
 $('.timeline').show(); 
     $('.noactionmsg').hide();
    
    
}
    
    
}
     function stickMenu(){
            $('.sticky li a').click(function(){
        var    showtext  = $(this).attr('data'); 
                
              
                    
                  //callbackActionTextBox();
                $('.showText').show(); 
                $('.sticky a').removeClass('activeMenu');
                $('.actionMsg').hide();
                $('.showCommentAddForm').hide();
                $(".callbackActionTextBox").hide();
                
                // $('.callbackContacts .actionContact').remove(
                 $('html,body').animate({ scrollTop: $("#stickMenu").offset().top},'slow');
                   $('.timeline-entry').hide()
                   var action =  $(this).attr('data');  
                   $('.actionId'+action).show();
                        $('.pipeline').hide();     
                  
                //alert(action)
                var numberofactions  = $('.actionId'+action).length
                var acctionqty  = '<span class="circle actionTotal">'+numberofactions+'</span>'
                      
                if(action == 'actions_marketing') action = 'Marketing';   
                if(action == 'actions_cancelled') action = 'Cancelled';  
                if(action == 'actions_outstanding') action = 'Scheduled';  
                if(action == 'actions_completed') action = 'Completed';  
                $('.actiontitle').html(action+ acctionqty);
      
                
            
                $('.showText').html('Show/Text');

                $(this).addClass('activeMenu');

                 if(action  == 'All'){
                   
                     $('.showText').html('Show/Text');   
                            $('.timeline-entry').show();
                            $('.actiontitle').html('History');
                             $('.pipeline').show();
                       }
                  if($('.qty'+showtext).text() != 0){
 
           
                if(action == 'Marketing'){
                            $('.showText').hide();

                    } 
                                
                    if(action  == 'Comment'){  
                            $('.showCommentAddBtn').show();
                         $('.showCommentsearch').show();
                        }else{
                            $('.showCommentAddBtn').hide();
                             $('.showCommentsearch').hide();
                      }

                    if(action == 'actions_marketing'){
                        $('.showText').hide();
                    }
                  }else{
                      $('.actiontitle').html('No Actions Found' );
                        
                       $('.showText').hide();
                       if( action  == 'Comment'){
                       $('.actiontitle').html('no comments' );
                     $('.showCommentAddBtn').show();
                    
                    
                }
                  }
                
               
                
                
            })
            
        updateDateTime();
          adjustments_process();
         }
    (function($) {
        $.fn.goTo = function() {
        $('html, body').animate({
        scrollTop: ($(this).offset().top)-200 + 'px'
        }, 'fast');
        return this; // for chaining...
        }
        })(jQuery);
     function bindfollowUpInfoBtn(){
                $('.follow_up_action_btn_').on('click' , function(){
                    var   actionId = $(this).attr('data');
                    //$("a[data='actions_completed']" ).trigger('click');
                    scroller(parseInt(actionId));
                });
                   
    }
     function scroller(actionId){
         //alert(actionId)
         var tech = parseInt(actionId);
            //a[data='"+tech+"']
         $("a[data='actions_completed']" ).trigger('click');
          $('a[data='+actionId+']').trigger('click');
            $('a[data='+actionId+']').goTo(0);
         
     }
     function getIcon(actionType){
            //console.log(actionType)
         var icon;
//console.log(actionType)
              switch (actionType){
                    
                      //Quote to : 
                    case 'Attempted Call':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                       case 'Callback':case 'Call':case 'Called Us':
                         icon = '<div class="timeline-icon label-danger "style="color: white;"><i class="fa fa-phone fa-lg"></i></div>';
                    break;
                    case 'Campaign - Lack of Info':
                           icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
                    break;
                    case 'Check-In Call':
                        icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
                    break;
                    case 'Pipeline - Deal':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-o-up  fa-lg"></i></div>';
                    break;
                    case 'Demo':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Email':
                        icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
                    break;
                    case 'InMail':
                        icon = '<div class="timeline-icon bg-info"><i class="fa fa-envelope fa-lg"></i></div>';
                    break;
                       case 'Intro Call':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Meeting':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Met at Event':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                      case 'Proposal Sent':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Quote Requested':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-sticky-note fa-lg"></i></div>';
                    break;
                    case 'Sales Ledger Due Diligence':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    case 'Comment - Old':
                        icon = '<div class="timeline-icon bg-primary"><i class="fa fa-comments fa-lg"></i></div>';
                    break; case 'Comment':
                        icon = '<div class="timeline-icon bg-primary"><i class="fa fa-comments fa-lg"></i></div>';
                    break;
                      
                    case 'Web Form - Demo Requested':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                      case 'Web Form - Call Me Requested':
                        icon = '<div class="timeline-icon bg-success"><i class="fa fa-thumbs-up fa-lg"></i></div>';
                    break;
                    default: 
                        icon = '<div class="timeline-icon bg-info"><i class="fa fa-comments fa-lg"></i></div>';
              }
                     //console.debug(icon);
     
           return icon;
         
     }


function actionProcessor(actionType = 0 ,action = 0 ,icon = 0,initial_fee,pipeline =0,actions_outstanding=0,actions_cancelled=0,comments=0,kp=0){

    var actionImg = '';
    var actionsummary = [];

    if(comments != false || typeof action['image'] !== 'undefined' || actions_cancelled != '') {
        var createdAt  = action['created_at'];
        var updated_at  = action['updated_at'];

        if(comments  == false){
            actionImg = '-,#000,#ffffff';
            if(!actions_cancelled ){
                if(typeof action['image'] !== 'undefined' && action['image'] != null){
                    actionImg =   action['image'];
                    actionImg =   actionImg.split(',');
                }
            }
        }
            actionsummary = actionSummary(actionImg,icon,actionType,createdAt,initial_fee,pipeline,actions_outstanding,updated_at,actions_cancelled, comments,action,kp);
    }
        boxActionTextBox();

    return   actionsummary;

} 


    function boxActionTextBox(){
        
        $('.boxAction').on('click', function(){
            var dat = $(this).attr('data');
            var blockStatus  = $('.boxcom'+dat).css('display');
            if(blockStatus === "block"){
                $('.boxcom'+dat).toggle(false);
            }else{
                $('.boxcom'+dat).toggle(true);
            }
        })

    }
     function showmenu_(){
         
         
   
     }
     
     function actionSummary(actionImg =0,icon=0,actionType=0,createdAt=0,initial_fee=0,pipeline =0, actions_outstanding=false, updated_at = 0, actions_cancelled=false, comments=0,action=0,kp){
    // console.log(actionType);
         
     actionType =     actionType.replace('Comment - Old','Comment')
        boxActionTextBox();
         var header;
         var deal = [];
         var tagline = [];
         var calenderbtn = [];
         var outcomeRemove = [];
         var overdueStatus = [];
         var actions = []
         var icon ;
         var badge = ''
         var textbox;
         var actionTypeOverwrite = false;
         var actions_outstanding = (actions_outstanding);
         var planned_at = [];
         var cancelled_at = [];
         var textbox = [];
         var classCompleted = '';
         var kpStr = [];
         var outcome = [];
         var contactName = [];
         var actionTypeName= [];
         var followupAlert = [];
         var created_by  = [];
         var actionId = [];
         var status = 'Created by '
         var showOutstandingForm = [];
         var getUrlIdParam = GetUrlParamID();
         var kps_cancelled;
         var updatemeeting = [];
         var turnover = [];
          var turnoverAction = [];
         var employees = [];
         var tfer_runners ;
        var tfer_turnover;
        var  createfollowername;
var editAdjustment;
         var filename = [];
      var originalcreator;
         
         if(action['action_type_id'] == 42  ){
               filename = action['file_location'];
             
             filename= '<div class="file'+action['id']+'"></div>';
             actionType = 'Files';
         }
         
         
        // console.log(action['originalcreator'] + action['id']);
         
             if(typeof action['name'] !== 'undefined'  && action['name'] !== null &&  action['name'] !== 'null'   ){
            created_by = action['name'];
                 
                
                  if(typeof action['creater'] !== 'undefined' && action['creater'] != action['name'] && action['creater'] !== null &&  action['creater'] !== 'null' && action['action_type_id'] == 11){
                   // console.log(action['action_type_id']   + action['name']  + action['creater']);
                     //created_by = action['creater']  + ' forwarded to ' +action['name'];
                }
                 
                 
                     if(typeof action['campaign_id'] !== 'undefined' && action['campaign_id'] !== null &&  action['campaign_id'] !== 'null' && action['creater'] != null ){
                           // console.log(action['action_type_id']   + action['name']  + action['creater']);
                     created_by = action['creater']  + ' forwarded to ' +action['name'];
                }
                 
                 
           
         }else{
             created_by = action['created_by'];   
         }
         
         
            if(typeof action['originalcreator'] !== 'undefined'  && action['originalcreator'] !== null &&  action['originalcreator'] !== 'null'   ){
             
               
                originalcreator = action['originalcreator'] + ' - ' + formattDate(action['outcome_action_date'], true);
           
                
                 //console.log(action['actioned_at']);
                
         } 
         
         
         actionId = action['action_id'];
         if(typeof action['id'] != 'undefined'){
            actionId = action['id'];
          }
         
         if(typeof action['outcome'] !== 'undefined'  && action['outcome'] !== null &&  action['outcome'] !== 'null'){
             outcome = '<div class="actionOutcomeText"><span class="actionMsg piller'+actionId+' outcomeMsg'+actionId+' comments'+actionType+'"><strong>Outcome: </strong><br>Created by: '+ (originalcreator? originalcreator:action['name']) +'<br><span class="comment">'+ action['outcome'] +'</span></span></div>'; 
            
         } 
         actionTypeName = actionType;
         if(action['first_name'] != null){
             contactName = '<span class="label label-primary" style="margin-left:3px;" > Contact: '+action['first_name']+' '+action['last_name']+'</span>';  
         }
         
         if(action['comments']){
             tagline = '<span class="actionMsg piller'+actionId+' actionMsg'+actionId+  ' comments'+actionType+'"><strong>Comment: </strong></br><span class="comment" data="'+actionId+'">'+action['comments']+'</span></span>'+outcome;
             

//alert()
         }   
         
         if(actionTypeName == 'Comment' ){
    if( typeof actionImg[2]  !== 'undefined' )  icon = '<div class="timeline-icon" style="font-weight: 700; font-size: 0.7em;background-color:'+actionImg[1]+'; color:'+actionImg[2]+';">'+actionImg[0]+'</div>';  
             

//alert()
         }


         if(actionType == 'Adjustments'){
            
            tagline = '<form action="actions/adjustments" data="'+action['id']+'" id="adjformid'+action['id']+'"  class="adjform"><div class="adjcontactions adjcont'+action['id']+'" data="'+action['id']+'" style="height: 300px;"><div class="col-sm-8"> <div class="form-group"> <label>Adjustment</label> <select name="adjustment_type_id" class="form-control  adjustmentSelectordefaultaction" title="Choose one of the following..." data="'+action['id']+'"> <option value="1" >Charge Only</option> <option value="2" '+(action['id'] ? 'selected="selected"' : "" )+'>Pay &amp; Charge</option> <option value="3">Client VAT Adjustment</option> <option value="4">Pay Rate Adjustment</option> <option value="5">Agency VAT Adjustment</option> <option value="6">Contractor VAT Adjustment</option> <option value="7">Change of Supplier</option> </select> </div> </div> <div class="col-sm-4 "> <div class="form-group"> <label>Status</label> <select class="form-control"  placeholder="Adjustment"> <option ="0">Open</option> <option ="1">Close</option> </select> </div> </div> <div class="col-sm-4 adj'+action['id']+' group1"> <div class="form-group"> <label>Client Name<span class="">*</span></label> <input name="cc_name" type="text" class="form-control selectpicker rqd_group1 name" id="name" placeholder="Client name"> </div> </div> <div class="col-sm-4 adj'+action['id']+' group2"> <div class="form-group"> <label>Candidate<span class="">*</span></label> <input type="text" class="form-control selectpicker candidate rqd_group2 candidate_adjustment" name="candidate" id="pra_candidate_adjustment" placeholder="Candidiate name"> </div> </div> <div class="col-sm-4 adj'+action['id']+' group2"> <div class="form-group"> <label>Client<span class="">*</span></label> <input type="text" class="form-control  client rqd_group2 client_adjustment" id="f_client" name="f_client" placeholder="Client name"> </div> </div> <div class="col-sm-4 adj'+action['id']+' group1"> <div class="form-group"> <label>Invoice number<span class="">*</span></label> <input type="number" name="invoice_id" class="form-control invoice_number rqd_group1" id="invoice_id" placeholder="Invoice number"> </div> </div> <div class="col-sm-4 adj'+action['id']+' group1"> <div class="form-group"> <label>Remittance number<span class="">*</span></label> <input type="number" name="remittance_id" class="form-control remittance_number rqd_group1" id="remittance_id" placeholder="Remittance number" value="'+action['remittance_id']+'"> </div> </div> <div class="col-sm-2 adj'+action['id']+' group2"> <div class="form-group"> <label>Week Ending<span class="">*</span></label> <input type="text" class="form-control weekending weekending rqd_group2" id="weekending" name="weekending" data-date-format="DD/MM/YYYY" placeholder="Select date"> </div> </div> <div class="col-sm-4 adj'+action['id']+' group_default"> <div class="form-group"> <label>Currency<span class="">*</span></label> </div> <div class="form-group" style="margin-top:-12px"> <label class="radio-inline"><input name="currency" class="selectpicker client_currency rqd_group_default" type="radio" checked="checked" value="GBP"> Sterling</label> <label class="radio-inline"><input name="currency" class="selectpicker client_currency rqd_group_default" type="radio" value="EUR"> Euros</label> <label class="radio-inline "><input name="currency" class=" client_currency rqd_group_default" type="radio" value="USD"> Dollars</label> </div> </div> <div class="col-sm-4 adj'+action['id']+' group_default"> <div class="form-group"> <label>Amount of Adjustment<span class="">*</span></label> <input type="number" name="adjustment_amount" class="form-control adjustment_amount rqd_group2"   placeholder="Adjustment amount"> </div> </div> <div class="col-sm-3 adj group_default"> <div class="form-group"> <label>Reason<span class="">*</span></label> <select class="form-control selectpicker contractvatreason adjrqd6 reason" name="reason" title="Select a reason..."> <option value="">--- Select a Reason ---</option> <option value="1">Agency provided incorrect information (e.g. rates)</option> <option value="2">Placement error</option> <option value="3">Timesheet error</option> <option value="4">Credit Control - incorrect adjustment</option> <option value="5">Credit Control - customer billing incorrect</option> <option value="6">Other</option> </select> </div> </div> <div class="col-sm-12 adj'+action['id']+' group_default"> <div class="form-group"> <label>Details of Change<span class="">*</span></label> <textarea type="text" name="change_details" class="form-control selectpicker rqd_group_default change_details" id="change_details" placeholder="Change details"></textarea><input type="hidden"><input type="hidden" name="action_id" value="'+action['id']+'"><input type="submit" id="adjsub'+action['id']+'" class="adjsubmit" data="'+action['id']+'" style="display:none;"> </div> </div></div></form>';
            
             
             editAdjustment = '<span class="btn btn-warning btn-xs btn-primary adj_action_btn_edit adj_action_btn_edit'+action['id']+'   hint--top-right"data-hint="Edit" data="'+action['id']+
                 '">Edit</span><span class="btn btn-primary btn-xs btn-primary adj_action_btn_save adj_action_btn_save'+action['id']+'   hint--top-right"data-hint="Update Adjustment" data="'+action['id']+'">Save</span> <span class="btn btn-danger btn-xs btn-primary adj_action_btn_cancel adj_action_btn_cancel'+action['id']+'  hint--top-right"data-hint="Cancel" data="'+action['id']+
                 '">Cancel</span>';
         }
         if(actionType == 'Pipeline - Deal'){ 
             
           
             actionTypeOverwrite = actionType+'@'+initial_fee+'%';
         }
            
             
           if(actionType == 'Pipeline - Deal' || actionType == 'Pipeline - Proposal'  && (parseFloat(action['initial_fee']*100).toFixed(2))  != 0.00){ 
            if(typeof action['tfer_turnover'] !== 'undefined' ){
                
              
                
               
                
                
                
                if(action['tfer_turnover'] != null){
                turnoverAction =  (parseFloat(action['tfer_turnover']).toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,').split('.'));
                
     turnover =  '<span> <strong style="color: black;"> :: </strong> Projected Annual Contract Turnover £' + turnoverAction[0]+'</span>' ;  
    
           
                }
                 
               
                if(action['tfer_runners']  != null){
                        employees  = '<span> Contractors  ' + action['tfer_runners']+' </span>' ;   
                        turnover = employees+' '+turnover+'<br>';
                }
                
            
                
                    
                }
                                             
                        
             }
         
         
         //console.log(action['initial_fee']);
         
         if(actionType == 'Pipeline - Proposal'  &&  (parseFloat(action['initial_fee']*100).toFixed(2)) != 0.00){ 
             
     
        actionTypeOverwrite = actionType+'@'+ (parseFloat(action['initial_fee']*100).toFixed(2))+'%';
             
             
         }
        
             if(!actions_cancelled || typeof actionImg !== 'undefined'){
                badge = '<span class="circle" style="float: left;margin-top: 0px;margin-right: 10px;width: 20px;height: 20px;border-radius: 15px;font-size: 8px;line-height: 20px;text-align: center;font-weight: 700;background-color:'+actionImg[1]+'; color:'+actionImg[2]+';">'+actionImg[0]+'</span>';

            if(actionImg[2])  icon = '<div class="timeline-icon" style="font-weight: 700; font-size: 0.7em;background-color:'+actionImg[1]+'; color:'+actionImg[2]+';">'+actionImg[0]+'</div>';  

             }
        // if(actionType == 'actions_outstanding') alert()
            if(kp == 'actions_outstanding'  ){ //if outstanding
             
                showOutstandingForm = 'showOutstandingForm';
                
                if(action['planned_at'] )
                  var  timestamp =  Date.now();
                 
                 var timestamp2 = new Date(''+action['planned_at']+''.replace(' ', 'T')).getTime();
              
            if(timestamp2 < timestamp && action['action_type_id'] == 11 )
                  icon = '<div class="timeline-icon label-danger "style="color: white;"><i class="fa fa-phone"></i></div>';               
            }
          
        header = '<a href="javascript:;" class="text-danger '+showOutstandingForm+' pillerTitle" data-name="'+actionType+'" data="'+actionId+'">'+(actionTypeOverwrite ? actionTypeOverwrite : actionType)+ '</a> ';
         
        if( actions_cancelled == '' && typeof action['action_id'] != 'undefined' || actions_outstanding == true &&  actions_cancelled == '' && typeof action['action_id'] != 'undefined' ){ 
//console.log(action['planned_at']);
        var planned_at = action['planned_at'];
        planned_at = planned_at.replace(/-/g, "");
        planned_at = planned_at.replace(/ /g, "T");
        planned_at = planned_at.replace(/:/g, ""); 
        var  pageAddress = window.location.href;

        pageAddress = pageAddress.split('#');

        pageAddress = pageAddress[0];

        var  msg = 'Callback+%7C+Sonovate+Limited';
        var contact =  action['first_name']+ ' '+action['last_name'];
        var email = action['email'];
        var calendarBtnDetail;
        var detail = 'Meeting+with+'+contact+'%0A'+email+'+%0D%0D'+pageAddress; 

           // console.log('============'+parseInt(action['action_type_id'])+actionType);
            
            
        //console.log(actionType);
            if(actionType =='Meeting' || actionType =='Demo Requested'){
var updatemeeting   = '<span  class="datechangerTrigger"><input type="text"  data-date-format="YYYY/MM/DD HH:mm"  class="form-control datechanger datechangerb'+actionId+'"  placeholder="Change Date" name="planned_at" data="'+actionId+'"   value="" ><input type="hidden" class="datechangerh'+actionId+'" name="datechanger"  value=""></span> ';
            }
            
            
        calendarBtnDetail = '<a class="btn btn-xs btn-info addtocalender" href="http://www.google.com/calendar/event?action=TEMPLATE&amp;text='+msg+'&amp;dates='+ planned_at +'/'+ planned_at +'Z&amp;details='+detail+'%0D%0DAny changes made to this event are not updated in Baselist. %0D%23baselist" target="_blank" rel="nofollow">Add to Calendar</a>';


        calenderbtn = calendarBtnDetail +'<span class="btn btn-default btn-xs btn-primary callbackAction callbackActionOutcome hint--top-right"  data-hint="Add Action Outcome" data="'+action['action_id']+'">Add Outcome</span> <span class="btn btn-default btn-xs btn-danger callbackAction removeOutsandingAction hint--top-right"  data-hint="Cancel Callback Action" data="'+action['action_id']+'" >Remove</span>';

         if(action['action_id'])                                                                                                                                          
            textbox= '<div class="form-group callbackActionTextBox  box'+action['action_id']+'" style="display:none">'+
                '<form action="Actions/addOutcome" class="outcomeform" data="'+action['action_id']+'" >'+
                '<textarea class="form-control   textarea'+action['action_id']+'  " name="outcome" placeholder="Add outcome" required="required" rows="2" style="margin-bottom:5px;"></textarea><div class="editor addOutcomeEditor" addOutcomeEditor="'+action['action_id']+'" ></div>'+
                ' <div class="form-group form-inline actionForm formOutcome">'+
                                            '<span class="who_is_clone"></span><input type="text" class="form-control actiondate" data-date-format="YYYY/MM/DD H:m" name="planned_at" required="required" placeholder="Follow Up Date">'+
                                        '</div>'+
                '<input type="hidden" name="outcomeActionId" value="'+action['action_id']+'" /><input type="hidden" name="company_id" value="'+getUrlIdParam+'" /> <input type="hidden" name="status" id="callBackActionStatus'+action['action_id']+'" value="" />'+
                '<input type="submit" class="btn btn-primary btn-block actionSubmit box'+action['action_id']+' submit'+action['action_id']+'" "  style="float:right;" value="Save"></form><br /></div>';

        //console.log('box_'+action['action_id'])
            
            
       
//var tm  = action['planned_at'];
 

            
var tm =  dateDiffChecker(action['planned_at']);

if(tm > 1){ tm = tm + ' Days Overdue'; }else if(tm == 1){ tm  = tm + ' Day Overdue'; }else{ tm = tm +  ' Due Today'; } 
            
        overdueStatus = '<span class="label label-danger overdueAction ">'+tm +'</span>';
        var dateCompare = (new Date() - Date.parse(action['planned_at'])) >= 1000 * 60 * 30;

        if(dateCompare == false && typeof action['planned_at'] != 'undefined'){
            overdueStatus = '';
        }
        planned_at = 'Due: '+formattDate(action['planned_at']);

        }

        if((false))
        outcomeRemove ='<span class=" btn btn-default btn-xs label label-success" style="font-size:10px; margin:0 0px;">Add Outcome</span> <span class="btn btn-default btn-xs label label-danger">Remove</span>';
//console.log(action['cancelled_at'] )
        if( action['cancelled_at'] != null){
            kpStr   ='<span class="label label-danger" style="font-size:10px; margin:0 0px; float:right;">Cancelled: '+action['cancelled_at']+'</span>';
            badge = '';   
            overdueStatus = '';
               icon = '<div class="timeline-icon label-danger "style="color: white;"><i class="fa fa-phone fa-lg"></i></div>';
        }
        if(comments !=''){
            //console.warn('Play '+comments);
            outcomeRemove ='<span class="label label-info boxAction" style="font-size:10px; margin:0 0px;" data="'+action['id']+'">Add Comment</span>';
            outcomeRemove = '';
            badge = ''; 
            
 
        }
        if(actionType == 'Callback' && typeof action['action_id'] != 'undefined' || actionType == 'Call' && actions_outstanding == true && typeof action['action_id'] != 'undefined') 
        overdueStatus = overdueStatus ; 
    
        classCompleted = 'outcome'+action['action_id'];

         
        if(parseInt(action['action_type_id']) == 11  && actionTypeName == 'Callback' && isNaN(action['followup_action_id']) == false &&   action['followup_action_id'] != null){

 

        followupAlert = '<span class="label label-primary follow_up_action_btn hint--top-right" style="float:right;" onClick="scroller('+parseInt(action['followup_action_id'])+')" data="'+action['followup_action_id']+'"  " data-hint="Click to Go To &#10; Follow Up Group">+</span>';

        }
            
           if(kp == 'actions_completed'){
               
               
                if(actionType === 'Callback'){
                      
             
                   var company_id =    $("form input[name='company_id']").val();
                    var user_id =   $("form input[name='user_id']").val();
                    var done =   $("form input[name='done']").val();
                    var campaign_id =   $("form input[name='campaign_id']").val();
                    var class_check =   $("form input[name='class_check']").val();
                    var source_check =    $("form input[name='source_check']").val();
                    var sector_check =    $("form input[name='sector_check']").val();
                    
                    calenderbtn = '<span class="label label-primary callbackAction appendCallbackContacts followupactionBtn'+action['id']+' " style="font-size:10px; margin:0 0px;" data="'+action['id']+'">+ Follow Up Action</span>';
                  
                  textbox= '<div class="form-group callbackActionTextBox callbackContacts box'+action['id']+'" style="display:none">'+
                                '<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">'+
                                    '<form   action="Actions/addActionsCallback" id="formcallback'+action['id']+'" class="callbackForm" role="form" data="'+action['action_id']+'" >'+
                                            '<input type="hidden" name="company_id" value="'+company_id+'">'+
                                            '<input type="hidden" name="user_id" value="'+user_id+'" >'+
                                            '<input type="hidden" name="followup_action_id" value="'+action['id']+'" >'+
                                            '<input type="hidden" name="done" value="'+done+'" >'+
                                            '<input type="hidden" name="campaign_id" value="'+campaign_id+'" >'+
                                            '<input type="hidden" name="class_check" value="'+class_check+'" >'+
                                            '<input type="hidden" name="source_check" value="'+source_check+'" >'+
                                            '<input type="hidden" name="sector_check" value="'+sector_check+'" >'+  
                                        '<div class="form-group form-inline actionForm">'+
                                        '<input type="hidden" name="action_type_planned" required="required" value="11" >'+
                                            '<input type="text" class="form-control actiondate" data-date-format="YYYY/MM/DD H:m" name="planned_at" required="required" placeholder="Follow Up Date">'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            ' <textarea class="form-control  textarea'+action['id']+'" name="comment" placeholder="Add outcome"  required="required" rows="2" required="required"></textarea>'+
                                        '</div>'+
                       '<div class="">'+
                                        '<div class="form-group"><div class="editor addOutcomeEditor addOutcomeFollowupEditor" addoutcomeeditor="'+action['id']+'" ></div></div>'+
                                            ' <input type="submit" class="btn btn-primary btn-block" value="Add Outcome">'+
                                        '</div>'+
                                   '</form>'+
                               '</div>'+
                       '</div>'+
                        '</div>';
               }
             
             kpStr = '<span class="label label-success">Completed:  '+formattDate(action['actioned_at'])+'</span>';
               
              // console.log()
             actionType =kp;
           
               
         }else if(kp == 'actions_cancelled'){
              status ='Cancelled';
             
              created_by = '';  
             actionType = kp;
             
                  }else if(kp == 'actions_outstanding'){
            
             actionType = kp;         
         }else{

         }
         
        if(action['action_type_id'] == 7 || action['action_type_id'] == 30  ){
            actionType = 'Comment';
        }
         
          createfollowername  = action['createfollowername']; 
      if(createfollowername  != null  ) {
          createfollowername = action['createfollowername'] + ' forwarded to ';
          
          //console.log(action['createfollowername'] );
      }else{
          
          createfollowername = '';
      }  
        
       
      if(actionTypeName != 'Pipeline Update'  )   
            actions  ='<div class="timeline-entry actionId'+actionType+'  '+classCompleted+' pillid'+actionId+'" pillid='+actionId+'> <div class="timeline-stat"> '+icon+'</div><div class="timeline-label"> <div class="mar-no pad-btm"><h4 class="mar-no pad-btm">'+header+deal+'  </h4><div class="actions-info" ><span class="label label-warning"  >'+planned_at+'</span>'+kpStr+ ' '+overdueStatus+ ' '+updatemeeting+contactName+filename+' <span class="classActions" style="float:right; margin-top:0; margin-left:3px;">'+calenderbtn+outcomeRemove+followupAlert+editAdjustment+'</span></div></div><div class="mic-info"> '+status+': '+createfollowername+created_by+' - '+formattDate(createdAt, true)+' </div> <div class="actionMsgText">'+turnover+''+tagline+' </div>'+textbox+ ' </div></div>';
         
        if(actionTypeName == 'Pipeline Update' ){
              actions  = '<div class="timeline-entry actionId'+actionType+' '+classCompleted+'" > <div class="timeline-stat"> '+icon+'</div> <div class="timeline-label pipe" style="margin-bottom: 50px;"> <div class="mar-no pad-btm" ><h4 class="mar-no pad-btm">'+header+' <span class="classActions" style="margin-top:0; margin-left:3px; float:right;">'+calenderbtn+outcomeRemove+'</span></h4>' +kpStr+overdueStatus+'</div><div class="actionMsgText">'+action['comments']+'</div> </div>';
         }
     
         
         if(actionType == 'Adjustments'){
             
            // actions = adjustments;
             
         }
         
        return actions;
       }


function dateDiffChecker(tm){
 

tm = tm.split(' ');

tm = tm[0].split('-');

tm = tm[1]+'/'+tm[2]+'/'+tm[0];
            
            
            
            
            
            var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd='0'+dd
} 

if(mm<10) {
    mm='0'+mm
} 

today = mm+'/'+dd+'/'+yyyy;
       
        return  daydiff(parseDate(tm),parseDate(today));
}
function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}
function daydiff(first, second) {
    return Math.round((second-first)/(1000*60*60*24));
}
function formattDate(createdAt, showtime = true){
        // Split timestamp into [ Y, M, D, h, m, s ]

var coeff = 1000 * 60 * 5;
var date_r = new Date(createdAt);  //or use any other date
var date_r1 = new Date(date_r.getTime() + 150000);
var rounded = new Date(Math.round(date_r1.getTime() / coeff) * coeff);


// Apply each element to the Date function

  var now = rounded;

var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];
  var dateSuffix = 'th';
var day = now.getDate();
if(day == 1 || day == 21 || day == 31) dateSuffix = 'st';
// Create an array with the current month, day and time
  var date = [now.getDate()+dateSuffix, monthNames[now.getMonth()+ 0] ,  now.getFullYear() ];

// Create an array with the current hour, minute and second date.join("")
  var time = [ now.getHours(), now.getMinutes()];

// Determine AM or PM suffix based on the hour + suffix
  var suffix = ( time[0] < 12 ) ? "am" : "pm";

// Convert hour from military time
  time[0] = ( time[0] < 12 ) ? time[0] : time[0] - 12;

// If hour is 0, set it to 12
  time[0] = time[0] || 12;

// If seconds and minutes are less than 10, add a zero
  for ( var i = 1; i < 3; i++ ) {
    if ( time[i] < 10 ) {
      time[i] = "0" + time[i];
    }
  }

// Return the formatted string
      //  console.log(time.join(":"))
        
 return (showtime? date.join(" ") + " - " + time.join(":")+suffix : '') + " " ; 
    } 

/**
 * Copyright (c) 2007-2015 Ariel Flesler - aflesler<a>gmail<d>com | http://flesler.blogspot.com
 * Licensed under MIT
 * @author Ariel Flesler
 * @version 2.1.1
 */
;(function(f){"use strict";"function"===typeof define&&define.amd?define(["jquery"],f):"undefined"!==typeof module&&module.exports?module.exports=f(require("jquery")):f(jQuery)})(function($){"use strict";function n(a){return!a.nodeName||-1!==$.inArray(a.nodeName.toLowerCase(),["iframe","#document","html","body"])}function h(a){return $.isFunction(a)||$.isPlainObject(a)?a:{top:a,left:a}}var p=$.scrollTo=function(a,d,b){return $(window).scrollTo(a,d,b)};p.defaults={axis:"xy",duration:0,limit:!0};$.fn.scrollTo=function(a,d,b){"object"=== typeof d&&(b=d,d=0);"function"===typeof b&&(b={onAfter:b});"max"===a&&(a=9E9);b=$.extend({},p.defaults,b);d=d||b.duration;var u=b.queue&&1<b.axis.length;u&&(d/=2);b.offset=h(b.offset);b.over=h(b.over);return this.each(function(){function k(a){var k=$.extend({},b,{queue:!0,duration:d,complete:a&&function(){a.call(q,e,b)}});r.animate(f,k)}if(null!==a){var l=n(this),q=l?this.contentWindow||window:this,r=$(q),e=a,f={},t;switch(typeof e){case "number":case "string":if(/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(e)){e= h(e);break}e=l?$(e):$(e,q);if(!e.length)return;case "object":if(e.is||e.style)t=(e=$(e)).offset()}var v=$.isFunction(b.offset)&&b.offset(q,e)||b.offset;$.each(b.axis.split(""),function(a,c){var d="x"===c?"Left":"Top",m=d.toLowerCase(),g="scroll"+d,h=r[g](),n=p.max(q,c);t?(f[g]=t[m]+(l?0:h-r.offset()[m]),b.margin&&(f[g]-=parseInt(e.css("margin"+d),10)||0,f[g]-=parseInt(e.css("border"+d+"Width"),10)||0),f[g]+=v[m]||0,b.over[m]&&(f[g]+=e["x"===c?"width":"height"]()*b.over[m])):(d=e[m],f[g]=d.slice&& "%"===d.slice(-1)?parseFloat(d)/100*n:d);b.limit&&/^\d+$/.test(f[g])&&(f[g]=0>=f[g]?0:Math.min(f[g],n));!a&&1<b.axis.length&&(h===f[g]?f={}:u&&(k(b.onAfterFirst),f={}))});k(b.onAfter)}})};p.max=function(a,d){var b="x"===d?"Width":"Height",h="scroll"+b;if(!n(a))return a[h]-$(a)[b.toLowerCase()]();var b="client"+b,k=a.ownerDocument||a.document,l=k.documentElement,k=k.body;return Math.max(l[h],k[h])-Math.min(l[b],k[b])};$.Tween.propHooks.scrollLeft=$.Tween.propHooks.scrollTop={get:function(a){return $(a.elem)[a.prop]()}, set:function(a){var d=this.get(a);if(a.options.interrupt&&a._last&&a._last!==d)return $(a.elem).stop();var b=Math.round(a.now);d!==b&&($(a.elem)[a.prop](b),a._last=this.get(a))}};return p});