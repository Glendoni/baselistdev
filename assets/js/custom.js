function dateRequired()     {
    var contact_type = document.getElementById("action_type_planned").value;
    if (contact_type > '0'){
        $(".follow-up-date").attr('required', true)
    }     
    else{
        $(".follow-up-date").attr('required', false)
    }
}


    $(document).ready(function() {
        
        
           //////////NOTES///////////////////////////////////////////////
    // Configure/customize these variables.

    
                $(".noteinput").keyup(function(){
                    // $(".morelink").unbind('click');
                            var attr = $(this).attr('note');
                            // For some browsers, `attr` is undefined; for others,
                            // `attr` is false.  Check for both.
                            if (typeof attr !== typeof undefined && attr !== false) {
                                // ...
$("#noteoutput"+attr).html($(this).html()+'<br><button type="button" class="btn btn-primary action_submit action_submit'+attr+' " data="'+attr+'">Save & Update</button>');
                                
     
  $('.action_submit').click(function(){
//alert();
                    var noteid = $(this).attr('data');
                    $('.submit'+noteid).trigger('click');
                 
    
                     
      
  })
                                
                                
                            }
                });
    
                $('.noteform').submit(function(){ //Get 
                    var noteid = $(this).attr('data');
var outbound_content   = $('.noteinput'+noteid).html() ;
         
                        //JS JASON WITH POST PARAMETER
                         var para = {'notes':outbound_content, 'noteid': noteid};
                          $.ajax({
                            type: "POST",
                              data: para,
                                dataType: "json",
                            url: "sector_note_update",
                            success: function(data) {
                                
                                    noteid = data['id']; 
                                    //console.log(outbound_content);

                                    $('.noteoutputcopy'+noteid).html('');
                                    $('.noteoutputcopy'+noteid).html(outbound_content);

                                    $('.note_cancel'+noteid).trigger('click');
                                    $('.action_submit'+noteid).remove();
                                
                               // console.log(outbound_content);
                            }
                            });
     
                    
                });
    
    
    
                $('.note_edit').click(function(){

                   var noteid = $(this).attr('data');
                    
                     $('.noteoutputcopy'+noteid).remove();
                   var output  =  $('#noteoutput'+noteid).html();
                    //alert(output);
                    $('.noteinput'+noteid).append('<div class="noteoutputcopy'+noteid+' hidden">'+output+'</div>')
                    $('#noteinput'+noteid).show();
                    $(this).hide();
                    $('.highlighter'+noteid).addClass('notehiglighter'); 
 
                });
    
    
                $('.note_cancel').click(function(){

                    var noteid = $(this).attr('data');
                    
                    var n_copy = $('.noteoutputcopy'+noteid).html();
                    
                    //console.log('+++++'+n_copy);
                    
                    $('.noteoutput'+noteid+', .noteinput'+noteid).html(n_copy);
                    $('#noteinput'+noteid).hide();
                    $('.note_edit'+noteid).show();
                  
                     $('.highlighter'+noteid).removeClass('notehiglighter'); 


    
      $('.action_submit'+noteid).remove();


                });


    
    ////////////NOTES END ///////////////////////////////////////////
    
    
    
    
    ////EVERGREENS
    
    evergreen_read();
evergreen_cancel();
add_evergreen_user_interface();
//evergreen_save();


    
    
    
    
    $('#description_dropdown').change(function(){


      
             
          var user_dropdown = $(this).val();
        $('#evg_id_ropdown').val(user_dropdown);
        
          set_dropdown_user_evergreens(user_dropdown)
      



})
    
    
    
    
    
    
    
    
    
    ////////EVERGREENS  END
    
    
    
    
$('.comp_details_edit_btn').click(function(){
 
 confidentialHandler();

})
    
    
    if((/users\/profile/.test(window.location.href))) {
    $('#userupdatepassword').click(function(){

$('.updatepassword').toggle(function(){
    
  // console.log($(this).css('display')); 
    var displayPasswordStatus  = $(this).css('display');
    if(displayPasswordStatus == 'block'){
        
        $('.updatepasswordinput').attr('required', 'required');

        $('#update_profile').prop('disabled', true);
        

    }else{
        $('.passwordsdonotmatch').hide();
        $('.pass_enter').val('');
         $('.re_pass_enter').val('');
          $('.updatepasswordinput').removeAttr('required');
         $('#update_profile').prop('disabled', false);
    }
    
    
});


})
    
    
      $('.updatepasswordinput').keyup(function(){
        
       var enter = $('.pass_enter').val();
          var reenter = $('.re_pass_enter').val();
          var enterlenth =  enter.length;
          
          console.log(enter  +  ' ' +reenter)
         
          
          
          
          
          if(enter == reenter && enterlenth > 2 ){
              
           $('#update_profile').prop('disabled', false);
              
              $('.passwordsdonotmatch').hide();
          }else{
              
               $('#update_profile').prop('disabled', true);
              if(enterlenth > 2 ){
                $('.passwordsdonotmatch').show();
              }
          }
          
    })
    
    
    
    
    }
    
   // addActionMultipleFileFields();
      if((/contacts/.test(window.location.href))) {
            $("[data=contacts]").trigger('click')
    
      }
    
    
    $('#addMoreMultipleFileFields').click(function(){

addActionMultipleFileFields()

})
    
             // ADD EVERGREEN
 $('.myevergreenaddcompanies').click(function(){  
                      $('.myevergreenaddcompanies').text('Processing...')
                      
                   $('.myevergreenaddcompanies').attr("disabled","disabled");
     
   var campid = $(this).attr('data');
      var evergreen = $(this).attr('evergreen');
         //Add EVERGREEN
         var para = {'campid': campid, 'evergreen': evergreen};
           $.ajax({
             type: "POST",
               data: para,
                 dataType: "json",
             url: "evergreen/updateTagCampaignRun",
             success: function(data) {
                 
                 //alert(campid)
                 
console.log(data.success);
if(data.success == 202){
$('.myevergreenaddcompanies').text('Campaign has reached max allowed')
}else{
            //location.reload();
    window.location = "campaigns/display_campaign/?evergreen="+evergreen+"&id="+campid;
                 //http://localhost:8888/baselist/campaigns/display_campaign/?id=1
    
}
             }
             });
        
 //location.reload();
                        
                    })
    
    
    //INVOICE FINANCE
$('.debmortgage').on('click', function(){
 
        event.preventDefault();
    var param = $('#debmortgage form').serialize();

 
    //JS JASON WITH POST PARAMETER
    
      $.ajax({
        type: "POST",
          data: param,
            dataType: "json",
        url: "../companies/notForInvoices",
        success: function(data) {
          $('#debmortgage').modal('toggle');
      
if(data.success){  
   // $('table .inv'+data.success).hide(); 

 $('table .cont'+data.success).removeClass('success'); 
     $('table .cont'+data.success).addClass('danger'); 
      
  if(data.debenturemortgage == 'P'){
                        $('.inv'+data.success).html('Probably Related To Invoice Finance');
                        $('table .cont'+data.success).removeClass('danger'); 
                        $('table .cont'+data.success).addClass('success'); 
      
       $('#morprov'+data.success).attr('providerstatus', 3)
      
  }
    
    if(data.debenturemortgage == 'N'){
       $('.inv'+data.success).html('Not Related To Invoice Finance');
       $('#morprov'+data.success).attr('providerstatus', 1)
      
  }
    
   
}
            
         if(data.debenturemortgage == 'Y'){   $('.inv'+data.success).show(); 
                        
                         $('table .cont'+data.success).removeClass('danger'); 
                         $('table .cont'+data.success).addClass('success'); 
                        
                         $('#morprov'+data.success).attr('providerstatus', 2)
                        // console.log('table Not_related_to_Invoice_Finance .inv'+data.error)
                            $('.inv'+data.success).html('Related To Invoice Finance');
                          }
                        }
      
        
        });
    
  

})
    
            $('.providerStatus').click(function(){
  $('#debenturemortgage').prop('checked', false); 
            var  outstandingID  = $(this).attr('data-id')
            var  providerStatus  = $(this).attr('providerStatus')

            
        // $('#debenturemortgage').prop('checked', true);   outstandingID
     
            $("#radio_"+providerStatus).prop('checked', true);
            
      
                
            var parid = GetUrlParamID();
                
            $('.providerid').val(outstandingID);
             $('.providercompanyid').val(parid);

            })







$('#debenturemortgage').change(function() {
    if(this.checked) {
   
        
      // $('#debmortgage form lable').text('Not related to Invoice Finance ');  
      
    }
});
function confidentialHandler(){
  
        $('.enterpriseBoxBtn').on('click', function(){

    if($(this).hasClass('active')){		
    $('.enterpriseBox').show();
    $('.enterpriseBox strong').text('( Enterprise )');
    }else{

    $('.enterpriseBox').hide();
    $('.enterpriseBox strong').text('');
    }

    })
    
    
}
function gettagscampList_(param){
    
   
//console.debug(param)
  //var param = 154537;
     var parent_tag_name_holder = [];
    var parent_tag_name = [];
     var para = {'companyID': param};
             $.ajax({
        type: "POST",
            data: para,
            dataType: "json",
                 url: 'companies/fe_get_tag',
            success: function(data) {  
                $.each( data, function( key, val) {
                 //parent_tag_name_holder.push('<ul class="tagLists'+param+val['parent_tag_id']+'"><li>'+val['name']+'<li></ul>')  
 //console.log(parent_tag_name_holder.indexOf('tagLists'+val['parent_tag_id']))
//console.log(parent_tag_name_holder.indexOf(val['parent_tag_name']+val['parent_tag_id']) )
        if(parent_tag_name_holder.indexOf(val['parent_tag_name']) == -1){
//console.log(val['parent_tag_name']);
        parent_tag_name_holder.push(val['parent_tag_name']);
if(val['parent_tag_name'] != 'SIC Code'  ){
    
    $('.tagLists'+param).append('<div class="col-xs-6 col-sm-3  tag_display_holder"><div class="tag-display-header">'+val['parent_tag_name']+'</div><ul class="listTagSummary tagLists'+param+val['parent_tag_id']+'"></ul></div>');
    
}else{
    
   $('.tagLists'+param).prepend('<div class="col-xs-6 col-sm-3  tag_display_holder"><div class="tag-display-header">'+val['parent_tag_name']+'</div><ul class="listTagSummary tagLists'+param+val['parent_tag_id']+'"></ul></div>'); 
    
    
}
        
            //console.log("Needle found.");

        };
  })
                
                //console.log(parent_tag_name_holder.join(""));
                
                // $('.tagLists'+param).append(parent_tag_name_holder.join(""));
              populateGetTagsCampList(data,param);
if(data.length) $('.tagLists'+param).show(); 
                
            
                
                var secId;
var secEntryLength;
var dq;
$('.sectorIdentifier').each(function(){
secId = $(this).attr('data');
secEntryLength   = $('.sectorEntry_'+secId).length;

dq = $('.tagLists'+ secId+'  .listTagSummary').hasClass('tagLists'+secId+'18');

if(secEntryLength == false &&  dq == false ){
//console.log('show Sector alert');
//$('.pulser_'+secId).show();
}else{

//console.log('hide Sector alert');

}

})
               //console.log(parent_tag_name_holder.join())
        
            }
                  
        })
    }




function populateGetTagsCampList(data,param){
    
    
     var parent_tag_name_holder = [];
     var parent_tag_name = [];
     var para = {'companyID': param};
         $.each( data, function( key, val) {

                       if(val['parent_tag_name'] != null){
                              parent_tag_name =    val['parent_tag_name'].replace(' ', '');
                            //if(parent_tag_name != 'Downloads'){
                                   //console.log(val['name']);
                              $('.tagLists'+param+val['parent_tag_id']).append('<li class="subTags" ><span class="hint--top-right" data-hint="'+val['username']+' on '+formattDateTags(val['tagcreatedat'], true)+'">'+val['name']+'</span></li>');
                                        //parent_tag_name_holder.push(val['parent_tag_name']);
                              //  }
                       }
                 }) 
         
         

    
    
}

$(window).load(function(){
    window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove(); 
    });
    }, 2000);
});
$('#action_type_completed').change(function(){
         $('.action_verbiage').hide();
    $('.mainUploader input').prop('required', false);
        var action_verbiage_text = $(this).val();

       $('.action_verbiage_text'+action_verbiage_text).show();

    $('#action-error .editBoxInstruction').text('Source');
var source_check = $("input[name=source_check]").val();
    var phone_check = $("#phone").val();
    var contact_check = $(".companyDetailsContacts").length;
var company_pipeline = $("input[name=company_pipeline]").val();
    var sourceRequiredTitle = 'Source';
      var check = 'Source';

if ((this.value == '16' || this.value == '8' || this.value == '32') && (!source_check || ( this.value == '16' && phone_check== false) || ( this.value == '16' && contact_check== false))) 
{
 
 
   $('#add_action .disable_no_source').prop('disabled', 'true');
    $('.actionEvalPipeline').show()
     $('.action_file_uploader').hide();
    
            if(this.value == '16' || this.value == '8'){ 
                $('.completed-details').attr('required', 'required');
                $('.actionEvalPipeline').show();
                 $('.addActionOutcome').show();

            }else{
                $('.completed-details').prop('required', false);
                $('.actionEvalPipeline').hide();

                //$('.addActionOutcome').hide();
              //if (this.value ==32){ 
                                //  $('.addActionOutcome').hide();
                              //}else{
                                   $('.addActionOutcome').show();

                              //}
            }
    
    $('.sourceRequiredDropDownItem').text($('#action_type_completed option:selected').text());
    $(".no-source").slideDown(600);
    
    
   
    
    
    
    if(this.value == '16' && (!source_check) && (!phone_check)){
       
       
       
       }
    
     if(this.value == '16' && (!phone_check)){
      
         check = 'Phone Number';
         
         sourceRequiredTitle = check ;
    }
    
       if(this.value == '16' && (!source_check)){
      
       check =  'Source';
            sourceRequiredTitle = check ;
    }
    
           if(this.value == '16' && (!contact_check)){
      
       check =  'Contact';
                sourceRequiredTitle = check+' Details' ;
    }
    
    
    
    
      if(this.value == '16' && (!source_check) && (!phone_check) && (!contact_check)){
       
       check =  'Company Source Phone Number and Contact Details';
          
           sourceRequiredTitle = 'Source, Phone Number, Contact Details' ;
          
       }
    
   if(this.value == '16' && (source_check) && (!phone_check) && (!contact_check)){
       
        check =    'Company Phone Number and Contact Details';
       
       sourceRequiredTitle = 'Phone Number, Contact Details';
       
    }
    
    if(this.value == '16' && (phone_check) && (!source_check) && (!contact_check)){
       
        check =   'Company Source and Contact Details';
        
         sourceRequiredTitle = 'Source, Contact Details';

       
    }
    
    
    if(this.value == '16' && (contact_check) && (!source_check) && (!phone_check)){
       
        check =   'Source and Phone Number';
        
         sourceRequiredTitle = 'Source, Phone Number';
       
    }
    
    
    
    $(".sourceRequiredTitle").html(sourceRequiredTitle);
     $('#action-error .editBoxInstruction').html(check);
    
    
    
   /// console.log('the phone number  is '+$("#phone").val());
    
    //$(".no-source").show();
    //$(".disable_no_source").attr('disabled', 'disabled');
    }
        else if(this.value == '42'){
         $('#add_action .disable_no_source').prop('disabled', '') ;
       $('.action_file_uploader').show();
            $('.addActionOutcome').show();
        $('.btn-file').show();
            $('.mainUploader input').attr('required', 'required');
        
         
    }else{
    
        $(".no-source").slideUp(600);

        $('#add_action .disable_no_source').prop('disabled', '') ;


        var actionArr = ['31','32','33','34'];
        
    if (actionArr.indexOf(this.value) >=0){ 
         $('.completed-details').prop('required', false);
         $('#add_action .disable_no_source').prop('disabled', false);
         $('.actionEvalPipeline').hide();

                      //if (this.value ==32){ 
                        //  $('.addActionOutcome').hide();
                      //}else{
                           $('.addActionOutcome').show();

                      //}
         //
          
    }else{
        
        $('.completed-details').attr('required', 'required');
        $('.addActionOutcome').show();
        $('.actionEvalPipeline').show()
    }
    //$(".no-source").hide();
    //$(".disable_no_source").removeAttr('disabled', 'disabled'); 
if(!this.value){
    
    //alert();
    $('#add_action .disable_no_source').prop('disabled', true);
      $('.addActionOutcome').hide();
}


}
    
});

/*
$(".pipeline-validation-check").change(function() {
    
 
var company_source = $("select[name=company_source]").val();
var company_pipeline = $("select[name=company_pipeline]").val();
var pipeline_check = $("input[name=pipeline_check]").val();
var company_class = $("select[name=company_class]").val();
if ((this.value !== 'Prospect' && this.value !== 'Lost' && this.value !== 'Unsuitable') && (!company_source || company_source==0||company_class=='Unknown')) 
{
$(".no-source-pipeline").slideDown(600);
alert();
$(".disable_no_source").attr('disabled', 'disabled');
    
    alert();
}
else
{
$(".no-source-pipeline").slideUp(600);
//$(".disable_no_source").removeAttr('disabled', 'disabled');
}
});



*/

$(".pipeline-validation-check").change(function() {
        var company_source = $("select[name=company_source]").val();

            var companysourceArr = ['7','8','10','11']; //Source id to force user to enter special insight 


        if (companysourceArr.indexOf(company_source) >=0) 
        {
            $(".show_si_box").slideDown(600);
            $(".source_explanation").attr('required','required');
            $(".disable_no_si").attr('disabled', 'disabled');
        }
        else
        {
            $(".show_si_box").slideUp(600);
            $(".source_explanation").attr('required',false);
            $(".disable_no_si").removeAttr('disabled');
        }

          var company_class = $("select[name=company_class]").val();

        if (company_source==0 ) 
        {
            //$(".no-source-pipeline").slideDown(600);
            //$(".disable_no_source").attr('disabled', 'disabled');
        }
        else
        {
            $(".no-source-pipeline").slideUp(600);
            //$(".disable_no_source").removeAttr('disabled', 'disabled');
//console.log(company_source )
        if(company_source == "0" ){

            $(".disable_no_si").removeAttr('disabled');

        }


        }

 
    
});


        $(".source_explanation").keyup(function() {
            var si_check = $("input[name=source_explanation]").val();
            var company_source = $("select[name=company_source]").val();
            
            //    /^[a-z0-9]+$/i
            
            
              var companysourceArr =  ['2','3','4','5','6','7','8','9','14','15'];
            
     var str = si_check;
    var patt1 = /[^a-z\d]/i;
    var result = str.match(patt1);
 
            
            
            
           //console.log('Result: '+ result + ' siCheck '+si_check.trim().length + ' comapny of source'+ companysourceArr.indexOf(company_source))
        if (si_check.trim().length <= 0  &&  companysourceArr.indexOf(company_source) >=0) {

            // console.log('What the FALSE amn'+si_check);
            
            $(".disable_no_si").attr('disabled', 'disabled');
        }
        else
        {
            
            $(".disable_no_si").removeAttr('disabled');
        }
        });

 
    function getDealAvg(){

               var avg;
        var sum =0;
        var val = 0;
        var count_lines  = $('.us-initial-rate').length;
            //loop thru totals
        $('.us-initial-rate').each(function(){
            if(parseFloat($(this).text())){
              val = parseFloat($(this).text()) + val;
            }else{
              count_lines -1;
            }
            });
        val = val/count_lines;
        //console.log(parseFloat( val.toFixed(3) ));
        avg = val ? 'Avg '+ parseFloat( val ).toFixed(2)+'%' : '';
        $('.us-initial-rate-total').text(avg);
    }

  if((/companies\/create_company/.test(window.location.href))) {
        
        $('.company_class').change(function(){
            if($(this).val()  == 'PreStartUpWithoutAddress'){
                $('.cr_address, .cr_address_trading').hide();   
                
                $('.tradingType').prop( "disabled", true );

                $('#address').removeAttr('required');
            }else{
                    if(typeof $('#address').attr('required') === 'undefined'){
                       // $('#address').attr('required', 'required');
                    }
                 $('.tradingType').prop( "disabled", false );
                $('.cr_address').show();
            }
         }) 
    }
    
   if((/campaigns/.test(window.location.href)) ||(/companies/.test(window.location.href))) { 

            var regArray = [];
            $('.company-header a').each(function(e,i){

               // gettagscampList($(this).attr('comp').trim());
                  //console.warn($(this).attr('comp').trim());
            })
            
            if(parseInt($('.remaining').text()) == 0 && $('.remaining').text() != "" || $('.company-header').length ==0 ){
                $('.myevergreenaddcompanies').show();
                
                   }
             
                   

 }
    
    
    
  
        

     if((/companies\/company/.test(window.location.href))) {
         
        
        $(document).ready(function($){
            
            $('.contact_role').change(function(){

var roleAllowSubmitEval = $(this).val();
var contactRoleId = $(this).attr('data');
//console.log(roleAllowSubmitEval)

if(roleAllowSubmitEval == 1){

$('.contact_sumit_'+contactRoleId).prop("disabled",true);
$('.historic_'+contactRoleId).show();

}else{

$('.contact_sumit_'+contactRoleId).prop("disabled",false);
$('.historic_'+contactRoleId).hide();

}

                                          })
            

                if($('#bespokeEval').val() == 'support'){ //evaluates support services


                    $('.checkbox_bespoke').click(function(){

                        if($('#serviceoffering .bespoke_checkbox  .active').length){
                                $('#serviceoffering .submit_btn').prop("disabled",false);
                        }else{
                                $('#serviceoffering .submit_btn').prop("disabled",true);
                        }
                    })

                    if($('#serviceoffering .bespoke_checkbox  .active').length >0){
                        $('#serviceoffering .btn-checkbox').attr("disabled", true);  
                         //$('#serviceoffering .submit_btn').prop("disabled",true);  
                    }else{
                       // $('#serviceoffering .submit_btn').prop("disabled",true);  

                    }

                }

        });




    if($('#source_explanation').val()){
       
       $('.show_si_box').show();
       
       }
         
         // event.preventDefault()
         
        // var simplemde = new SimpleMDE({ element: $(".completed-details")[0] });
         
         //simplemde.value("Add **Outcomer**");
       $(window).scroll(stickyActionsMenu);
      
         $('.other_sectors .button-checkbox .btn-checkbox, .target_sectors .button-checkbox .btn-checkbox').click(function(){ //Target sectors event visiual manager
             
            if($(this).hasClass('btn-default')){
                        $(this).addClass('tsector');
                        $(this).removeClass('active');
                        $(this).removeClass('btn-default');
                    }
            });
         
            $('.tsector').removeClass('tsector'); 
        $("form").submit(function () {
            if ($(this).valid()) {
            $(this).submit(function () {
            return false;
            });
            return true;
            }
            else {
            return false;
            }
            });
     }

//Prevents form from subitting     
    
            

    
    
    $('#add_action_request').click(function(e){
        
      
        var check  = /^\d+\.\d{0,2}?/.test($('#amount').val());
        if(check === false){ 
            $('#amount').val('')
            var elements = document.getElementsByTagName("INPUT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function (e) {
                    if (!e.target.validity.valid) {
                        switch (e.srcElement.id) {
                            case "amount":
                            e.target.setCustomValidity("Decimal number required");
                            break;
                        }
                    }
                };
                elements[i].oninput = function (e) {
                }
            };
        }else{
       // console.log('Check me out '+check); 
            e.target.setCustomValidity("");  
            var elements = document.getElementsByTagName("INPUT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function (e) {
                    if (!e.target.validity.valid) {
                        switch (e.srcElement.id) {
                            case "amount":
                            e.target.setCustomValidity("");
                            break;
                        }
                    }
                };
                elements[i].oninput = function (e) {
                e.target.setCustomValidity("");
                $('#amount').trigger('click');
              }
            }
            e.target.setCustomValidity("");
        }
});
    
     getDealAvg(); //Get Deal Average used for user stats
    ////////End stats counter//////////////////////
    var autopilotEmailCompany = window.location.href.split("id="); 

    
           if((/dashboard/.test(window.location.href)) && (/dashboard\/team/.test(window.location.href)!= true)) {
         $('.mycampaignajaxcount').html('<img style="-webkit-user-select: none" src="assets/images/ajax-loader.gif">');
       $('.myevergreencount').html('<img style="-webkit-user-select: none" src="assets/images/ajax-loader.gif">');
                
          $.ajax({
                        type: "GET",
                    dataType: "json",
                url: "evergreen/getMyEvergreenCampaign",
                success: function(data) {
                    var action;
                    var itemss = [];
                     var idfk;
                   var uimage;
                    
                    
                    
                   // console.log(data)
        if(data.success == 'not ok'){
             $('.myevergreencount').html('0');
        }else{
                    $.each( data, function( key, val ) {
                          idfk = val.company_id;
                        
           // console.log(val.id);            
                        
              if(val.id != 'undefined'){          
                  uimage = val.image.split(',');
 
                      
                    itemss.push( '<a href="campaigns/display_campaign/?id='+val.id+'&evergreen='+val.evergreen_id+'" class="load-saved-search" title="" data-original-title="'+val.datecreated+'"><div class="row"><div class="col-xs-1"><span class="label label-info" style="margin-right:3px;background-color: '+uimage[1]+';font-size:8px; color: '+uimage[2]+'"><b>'+uimage[0]+'</b></span></div><div class="col-xs-9" style="min-height:30px;overflow:hidden">'+val.name+'<br><span style="font-size:9px;">Created: '+val.datecreated+'</span></div><div class="col-xs-1" style="padding: 0 0 0 0px; font-size: 11px;"></div></div></a>');
                  
                        }
                    });
                    
                        
                
                    $('.myevergreenajax').html(itemss.join( "" ));
                    //$('.mycampaignajaxcount').html('<img style="-webkit-user-select: none" src="http://localhost:8888/baselist/assets/images/ajax-loader.gif">');
                    $('.myevergreencount').html(itemss.length); //update engagement counter
                }
                }
            });
        
        
        
        $.ajax({
                type: "GET",
                    dataType: "json",
                url: "dashboard/private_campaigns_new_ajax",
                success: function(data) {
                    var action;
                    var items = [];
                     var idfk;
                   var uimage;
        if(data.success == 'not ok'){
             $('.mycampaignajaxcount').html('0');
        }else{
                    $.each( data, function( key, val ) {
                          idfk = val.company_id;
uimage = val.image.split(',')
 
                      
                       items.push( '<a href="campaigns/display_campaign/?id='+val.id+'&private=true" class="load-saved-search" title="" data-original-title="'+val.datecreated+'"><div class="row"><div class="col-xs-1"><span class="label label-info" style="margin-right:3px;background-color: '+uimage[1]+';font-size:8px; color: '+uimage[2]+'"><b>'+uimage[0]+'</b></span></div><div class="col-xs-9" style="min-height:30px;overflow:hidden">'+val.name+'<br><span style="font-size:9px;">Created: '+val.datecreated+'</span></div></div></a>');
                  
                    
                    });


                       
                    $('.mycampaignajax').html(items.join( "" ));
                    //$('.mycampaignajaxcount').html('<img style="-webkit-user-select: none" src="http://localhost:8888/baselist/assets/images/ajax-loader.gif">');
                    $('.mycampaignajaxcount').html(items.length); //update engagement counter
                }
                }
            });
            
        
            
var username  =  [];
        
        var pods = [];
             $.ajax({
        type: "GET",
            dataType: "json",
        url: "dashboard/getActionsProposals",
        success: function(data) {
            var planned_at;
            var  createdAt; 
            var company_name = [];
            var pipleine =  ['intents', 'proposals'];
            var pad = [];
               var username = [];
            var associated_company = [];
            var completed
       
  //console.log(data.intents);
            
           
                            
 //pods.acudate.split("-").reverse().join("-")
                     var    actionedAt;
                        $.each( data['pods'], function(  index, pods ) {


                           // console.warn( pods[0]['account_manager'][0]['name']);

                       // console.log(pods[1]['account_manager'][0]['name']);
                            pad  = pods[1]['account_manager'][0];  

                                    $(pad).each(function(inx, val){
                                        if(typeof pods[1]['account_manager'][0] ){
                                            //console.log(val['name']);
                                            associated_company.push(val['name']);
                                            username.push(val['name']+'_'+val['tag_id']);
                                        }
                                    //console.debug(pods[1]);    
                                    })

                        });

 
                         if( data.window == 't'){

                             $('.dashboardmaincontainer  a').attr('target',"_blank");

                         }
            
            
            
                         var uniqueNames = [];
                        $.each(username, function(i, el){
                            if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                        });
            
           
            
                        var splitname = [];

                        var tagid = [];
                       $.each(uniqueNames , function(key,name){

                          name =  name.split('_');
                          tagid =name[1];
                          name=name[0];

          
             $('.tab-content').append( '<div role="tabpanel" class="tab-pane fade" id="'+name.replace(' ','')+'"> <div class="panel panel-default"> <div class="panel-heading" id="'+name.replace(' ','')+'"> <h3 class="panel-title">Account Manager '+name+'<span class="badge pull-right eventcountpods200"></span></h3> </div><div class="panel-body" style="font-size:12px;"> <div class="row record-holder-header mobile-hide"> <div class="col-xs-5 col-sm-4 col-md-4"><strong>Company</strong></div><div class="col-xs-4 col-sm-4 col-md-4"><strong>Last Action</strong></div><div class="col-xs-8 col-sm-2 col-md-2"><strong>Pipeline</strong></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <div class="row record-holder-pods'+tagid+'"></div></div></div></div></div>');
                
                        })
            
            
                var unique_associated_company = [];
                $.each(associated_company, function(i, el){
                    if($.inArray(el, unique_associated_company) === -1) unique_associated_company.push(el);
                }); 
            
            
                $.each(unique_associated_company , function(key,name){
                
                //console.log(name);
                    
                      name =  name.split('_');
                          tagid =name[1];
                          name=name[0];
             
                $('.dashboardpods').append('<li role="presentation"><button href="#'+name.replace(' ','')+'" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm c-a-m" style="margin-right:10px;" >'+name+'</button></li> ');
                

                     //$('.tab-content').append( '<div role="tabpanel" class="tab-pane fade" id="'+name.replace(' ','')+'"> <div class="panel panel-default"> <div class="panel-heading" id="'+name.replace(' ','')+'"> <h3 class="panel-title">Account Manager '+name+'<span class="badge pull-right eventcountpods200"></span></h3> </div><div class="panel-body" style="font-size:12px;"> <div class="row record-holder-header mobile-hide"> <div class="col-xs-5 col-sm-4 col-md-4"><strong>Company</strong></div><div class="col-xs-8 col-sm-2 col-md-2"><strong>Last Action</strong></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <div class="row record-holder-pods660"></div></div></div></div></div>');
                
                
            })
            
          var topid = 21;
            
         
                
                
                
                    if(!typeof data.intents != 'undefined'){

                                $.each( pipleine, function(  index, keyval ) {
                                    $('.record-holder-'+keyval).html('');
                                 $.each( data[keyval], function( key, val ) {
//console.log(keyval)
                                   createdAt = val.intent ? val.intent : val.proposal;
                                        company_name = val.name.replace(/Limited|Ltd|ltd|limited/gi, function myFunction(x){return ''});
                        $('.record-holder-'+keyval).append('<div class="row record-holder"><div class="col-xs-2 col-sm-2 col-md-2">'+createdAt+'</div><div class="col-xs-4 col-sm-4 col-md-4"><a href="companies/company?id='+val.id+'">'+company_name+'</a></div><div class="col-xs-2 col-sm-2 col-md-2  "><span class="pipeline ">'+(val.planned ? val.planned : '') +'</span></div><div class="col-xs-2 col-sm-2 col-md-2  "><span class="pipeline ">'+ (val.action ? val.action : '')  +'</span></div><div class="col-xs-2 col-sm-2 col-md-2  "><span class="pipeline ">'+(val.by ? val.by : '')   +'</span></div></div>');

                                 })
                                        var record_holder_propsals_length =    $('.record-holder-'+keyval+' .record-holder').length;
                                        record_holder_propsals_length = record_holder_propsals_length ? record_holder_propsals_length :'0';
                                        $('.eventcount'+keyval).text(record_holder_propsals_length);
                                 })


                                }
            
            
            
            
            
                   $.each( data['pods'], function(  index, pods ) {
                 
                  actionedAt  =   pods[0]['last_action'][0]['acudate']? pods[0]['last_action'][0]['acudate'] : pods[0]['last_action'][0]['createdatac'] ;
       // console.log('Glennnnn '+pods.tagid);
       $('.record-holder-pods'+pods.tag_id).append('<div class="row record-holder"><div class="col-xs-4 col-sm-4 col-md-4"><a href="companies/company?id='+pods.id+'">'+pods.name+'</a></div><div class="col-xs-4 col-sm-4 col-md-4">'+pods[0]['last_action'][0]['actionname']+'<br> '+pods[0]['last_action'][0]['username']+' on '+ actionedAt.split("-").reverse().join("-")+'</div><div class="col-md-2"><span class="label  label-'+pods.pipeline+'">'+pods.pipeline+'</div></div>');
        
        
        
          var record_holder_propsals_length =    $('.record-holder-pods'+pods.tag_id+' .record-holder').length;
                    record_holder_propsals_length = record_holder_propsals_length ? record_holder_propsals_length :'0';
                    $('.eventcountpods'+pods.tag_id).text(record_holder_propsals_length);  
                 
                 
                 
             })
                
             // console.log(uniqueNames.join("")); 
              //console.debug(username.join());   
        }

                 
             
    });

 
        
        
        
        
      
        
        
       $('.emailegagement').hover(function(){
        

if(!$(this).hasClass('requested') && $(this).attr('aria-controls') ==  'emailegagement'){
    
//alert($(this).attr('aria-controls'))
    $(this).addClass('requested'); 
    
        
        $.ajax({
        type: "GET",
        dataType: "json",
        url: "Marketing/loaddata",
        success: function(data) {
        var action;
        var items = [];
        var idfk;
        $.each( data, function( key, val ) {
            idfk = val.company_id;
            if(val.action == "4"){ action =  'Un-subscribed'; }else if(val.action == "2"){ action =  'Clicked'; }else{action  = 'Opened';}  
            if( typeof idfk !== 'undefined'){
            var company = val.company.replace(/Limited|Ltd|ltd|limited/gi, function myFunction(x){return ''});
            var pipeline = val.pipeline.charAt(0).toUpperCase() + val.pipeline.slice(1);    
            items.push( '<div class="row record-holder"><div class="col-xs-8 col-sm-4 col-md-3"><a href="companies/company?id='+idfk+'">'+company+'</a></div><div class="col-xs-8 col-sm-4 col-md-2">'+val.campaign+'</div><div class="col-xs-4 col-sm-1 col-md-1 text-left"><span class="label pipeline label-'+pipeline+'">'+pipeline+'</span></div><div class="col-xs-6 col-sm-2 col-md-2"><a href="companies/company?id='+idfk+'#contacts">'+val.username+'</a></div><div class="col-xs-6 col-sm-3 col-md-2 align-right "> <span class="label label-primary">'+action+'</span></div><div class="col-xs-12 col-sm-2 col-md-2 contact-phone">'+val.date+'</div></div>' );
            } 
        }); 
        $('#stat').html(items.join( "" ));
        $('.eventcount').html(items.length); //update engagement counter
        }

        });

       

}
        
       })
                     }
        
        
        if((/dashboard/.test(window.location.href))&& (/dashboard\/team/.test(window.location.href)== true)){
               
        //GET TEAM STATS VIA JSON
       $.ajax({
            type: "GET",
                dataType: "json",
            url: "getTeamStats",
            success: function(data) {
                $.each( data, function( key, val ) {
            //key = tslastweek, tscurrentmonth , tslastmonth
                   $('#ts'+key).html(val);
                   
                })  
               tsTotalConfig();
            }
        });
        
      
        
           $.ajax({
            type: "GET",
                dataType: "json",
            url: "getTeamStats/uf",
            success: function(data) {
                $.each( data, function( key, val ) {
            //key = tslastweek, tscurrentmonth , tslastmonth
                   
                    $('#uts'+key).html(val);
                })  
               tsTotalConfig();
            }
        });
            
           } 
    
    
     if((/dashboard/.test(window.location.href))&& (/dashboard\/team/.test(window.location.href)!= true)){
         //GET TEAM STATS END 
           
                $('.favorites').hover(function(){
        

    if(!$(this).hasClass('requested') && $(this).attr('aria-controls') ==  'favorites'){

    //alert($(this).attr('aria-controls'))
        $(this).addClass('requested'); 

             getUserFavourites();   //trigger favorites 

        } 
    })
         
        $('.sortform form select').change(function(){
            getUserFavourites(); //Trigger alt sort on change

        })
        
        
     }
   
    if(autopilotEmailCompany[1]){ 
    var myParam = window.location.href.split("id=");
    var action ;
    $.ajax({
    type: "GET",
    dataType: "json",
    url: "../Marketing/autopilotActions/"+GetUrlParamID(),
    success: function(data) {
    var action;
    var items = [];
    var idfks;
    var  i = 0 
    $.each( data, function( key, val ) {              
        switch (val.action) {
            case '1':
            action  = '<span class="label label-success">Opened</span>'; 
            break;
            case '4':    
            action  = '<span class="label label-success">Unsubscribed</span>'; 
            break;
            case '2':
            action =  '<span class="label label-success">Clicked</span>';
            break;
        }
        if( val.campaign !== null ){
            if(val.action != '3'){
                i++;
                $( '<li class="list-group-item"><div class="row"><div class="col-xs-6 col-md-7"><h4 style="margin:0;">'+val.campaign_name+'<div class="mic-info">'+val.date+ ' by '+val.email+
                '</div></h4></div><!--END COL-MD-4--><div class="col-xs-6 col-md-5" style="text-align:right;"><span class="label label-primary" style="font-size:11px;  ">'+val.first_name+ ' '+ val.last_name+
                '</span> '+action+' </div></div></li>' ).prependTo('#marketing ul');
            }
        }
            //$('#sidebar').hide();
        
       // show();
       // $(window).scroll(show);
    });
    $('.marketingAcitonCtn').text(parseInt($('.marketingAcitonCtn').text()) + i);
    $(items.join( "" )).prependTo('#marketing ul');
    //if(i) $('#outstanding h4,.actionMsg h4').hide();
    }
    });
    }
    var source_explanation = $("input[name=source_explanation]").val();
    var company_source = $("select[name=company_source]").val();
    if (company_source=='8') {
    $(".show_si_box").slideDown(600);
    }
    $('#action_type_completed').on('change',function(){

        if($('#action_type_completed').val() == 16 || $('#action_type_completed').val() == 8  && $('.initialfee').length !=1){
            
            
     
            if($('.initialfee').length ==1){
            $('.onInitialFee').addClass('col-md-2');
                $('.followup').addClass('col-md-2');
            $('.initialfee').show();
            $('.initialfee input').attr('required', 'required');
            }else{
                
               $('.followup').addClass('col-md-2');
            $('.initialfee').show();
            $('.initialfee input').attr('required', 'required');  
                
                
                
            }
                
                
                
                
            //checkInitialFee()
        }else if($('#action_type_completed').val() == 42 ){
            
            
               if($('.who').length ==1){
            
               
                $('.who').show();
                $('.who select').attr('required', 'required');
                $('.onwhocontacthide').hide();
            }
            
            
            
        }else{
            
            
            $('.onwho').removeClass('col-md-3');
            $('.onInitialFee').removeClass('col-md-3');
            
             $('.followup').removeClass('col-md-2');
            $('.initialfee input').val('').removeAttr('required');
            $('.who select').val('').removeAttr('required');
            
            $('.initialfee').hide();
         
            $('.actionContact').show();
             $('.onwhocontacthide').show();
        }

    })

 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
});




function set_dropdown_user_evergreens(user_dropdown){
    
    
      
        
    var    param  = {'user_dropdown': user_dropdown};
      
                $.ajax({
                type: "POST",
                    dataType: "json",
                    data: param,
                url: "Evergreen/user_dropdown",
                success: function(data) {
                    var action;
                    var items = [];
                     var idfk;
        
                    $.each( data, function( key, val ) {
                   // console.log(val);
                        items.push( '<option value="'+val.id+'">'+val.name+'</option>' );
                    });
                      $('#user_evergreen_dropdown').html(""); 
                    $('#user_evergreen_dropdown').append(items.join( "" ));
                    //$('.eventcount').html(items.length); //update engagement counter
                }
        
            });
    
}
function add_user_to_campaign(){
    
     $('.evg_add_user_save').click(function(){
        event.preventDefault();

        var para = $('#add_user_to_campaign').serialize();
            
     // alert();
         
        $.ajax({
            type: "POST",
            dataType: "json",
            data: para,
            url: "evergreen/add_user_to_campaign",
        success: function(data) {
            
           //console.log(data);

alert('saved'); 
            
            
            
        }
            
        }); 
         
         
     });
    
    
}
function add_evergreen_user_interface(){
    
    //evg_add_user_save
    $('.add_evg_user').click(function(){
        
        
        $('#get_evegreen_results, .get_evegreen_results').hide();
    $('#get_evegreen_results_users,.get_evegreen_results_users').hide(); 
        $('#add_evegreen_results_detail').show();
        var description_dropdown_id   = $("#description_dropdown option:first").val()
          set_dropdown_user_evergreens(description_dropdown_id);
        
         $('.evg_id').val(description_dropdown_id);
        
        add_user_to_campaign();
        
    })
    
    
    
}



function evergreen_cancel(){
    
        $('.evg_cancel').on('click', function(){
evergreen_read()
            event.preventDefault();
            $('#get_evegreen_results,.get_evegreen_results').show();
            $('#get_evegreen_results_users').html("");
            $('#get_evegreen_results_users,.get_evegreen_results_users').hide();
            $('#get_evegreen_results_detail').hide();
             $('#add_evegreen_results_detail').hide();
    
        })
    
    
}


 function evergreen_save(){
    
        $('#evg_save').click(function(){
            
          event.preventDefault();

        var para = $('#evegreen_form').serialize();
            
     // alert();
         
        $.ajax({
            type: "POST",
            dataType: "json",
            data: para,
            url: "evergreen/update_evergreens",
        success: function(data) {
            
           //console.log(data);

alert('saved'); 
            
            
            
        }
            
        });
            
            
    
})
    
    
}
 

function evergreen_read(){

      if((/evergreen/.test(window.location.href))){
        $.ajax({
        type: "GET",
            dataType: "json",
        url: "evergreen/read_evergreens",
        success: function(data) {
            var action;
            var items = [];
            var description_dropdown = [];
             var idfk;
 var updated = true;
            $.each( data, function( key, val ) {
              //    idfk = val.company_id;
            //if(val.action == "4"){ action =  'Un-subscribed'; }else if(val.action == "2"){ action =  'Clicked'; }else{action  = 'Opened';}  
              
                if (val.updated_at ==  val.created_at) {updated = false};
               items.push( '<div class="row record-holder"><div class="col-xs-8 col-sm-4 col-md-3"> '+val.description+' </div><div class="col-xs-8 col-sm-4 col-md-2">'+formattDate(val.created_at)+'</div><div class="col-xs-4 col-sm-1 col-md-1 text-left"><span class=" ">'+(val.number_of_users? val.number_of_users : 0 )+'</span></div><div class="col-xs-6 col-sm-2 col-md-2"> '+(updated ? formattDate(val.updated_at)  : '' )+'</div><div class="col-xs-6 col-sm-3 col-md-2 align-right "> <span class="label label-primary"></span></div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><button class="btn btn-sm btn-primary btn-block evergreen_users" data="'+val.id+'">Users</button></div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><button class="btn btn-sm btn-warning btn-block evergreen_edit" data="'+val.id+'">Edit</button></div></div>' );



description_dropdown.push('<option value="'+val.id+'">'+val.description+'</option>');

          
              updated = true;
                
               
            });
               
            $('#get_evegreen_results').html(items.join( "" ));
            $('#description_dropdown').html(description_dropdown.join( "" ));
            //$('.eventcount').html(items.length); //update engagement counter
           
            
           
      $('.evg_description, evg_max_allowed').val("");
            evergreen_edit();
        }

    });
 
 }


}



function evergreen_edit(){



$('.evergreen_edit').on('click', function(){
    
    
    //$('#get_evegreen_results').html("");
   
    $('#get_evegreen_results, .get_evegreen_results').hide();
    $('#get_evegreen_results_users,.get_evegreen_results_users').hide();
    $('#get_evegreen_results_detail').show();
    
   
 $('.evg_description').val("");
              $('.evg_max_allowed').val("");
              $('#evg_sql').val("");
    
      $('#add_evegreen_results_detail').hide();
    
    var evergreen_id = $(this).attr('data');
    
      var action;
            var items = [];
             var idfk;
    
      var para = {'evergreen_id':evergreen_id};
    $.ajax({
        type: "POST",
            dataType: "json",
        data: para,
        url: "evergreen/get_evergreens",
        success: function(data) {
            
          $.each( data, function( key, val ) {
               // console.log(val.id);

                $('.evg_description').val(val.description);
              $('.evg_max_allowed').val(val.max_allowed);
              $('#evg_sql').val(val.sql);
              $('.evg_id').val(val.id);
  //evergreen_save() ;
//items.push( '<div class="row record-holder"><div class="col-xs-8 col-sm-4 col-md-3"><a href="companies/company?id='+idfk+'">'+val.description+'</a></div><div class="col-xs-8 col-sm-4 col-md-2">'+val.created_at+'</div><div class="col-xs-4 col-sm-1 col-md-1 text-right"><span class="label pipeline label-Prospect">'+val.created_by+'</span></div><div class="col-xs-6 col-sm-2 col-md-2"><a href="companies/company?id='+idfk+'#contacts">'+val.username+'</a></div><div class="col-xs-6 col-sm-3 col-md-2 align-right "> <span class="label label-primary"></span></div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><button class="btn btn-sm btn-warning btn-block evergreen_edit" data="'+val.id+'">Edit</button></div></div>' );
          
              
            });
               
           // $('#get_evegreen_results').html(items.join( "" ));
            //$('.eventcount').html(items.length); //update engagement counter
            
           // evergreen_edit();

            $('#evg_save').unbind('click');
             evergreen_save() ;
          }
        
          
        });
     
 //console.log($(this).attr('data'));

})
 


$('.evergreen_users').on('click', function(){
    
    
    //$('#get_evegreen_results').html("");
    $('#get_evegreen_results,.get_evegreen_results').hide();
    $('#get_evegreen_results_detail').hide();
     $('#get_evegreen_results_users, .get_evegreen_results_users').show();
    
   
              $('.evg_description').val("");
              $('.evg_max_allowed').val("");
              $('#evg_sql').val("");
    
    var evergreen_id = $(this).attr('data');
 
      var action;
            var items = [];
             var idfk;
    
      var para = {'evergreen_id':evergreen_id};
    $.ajax({
        type: "POST",
            dataType: "json",
        data: para,
        url: "evergreen/get_evergreens_users",
        success: function(data) {
            
          $.each( data, function( key, val ) {
               // console.log(val.id);

                //$('.evg_description').val(val.description);
              //$('.evg_max_allowed').val(val.max_allowed);
              //$('#evg_sql').val(val.sql);

items.push( '<div class="row record-holder"><div class="col-xs-8 col-sm-4 col-md-3">'+val.name+'</div><div class="col-xs-8 col-sm-4 col-md-2">'+val.campaign_description+'</div><div class="col-md-2"><span class="label pipeline label-Prospect">'+val.created_at+'</span></div><div class="col-xs-6 col-sm-2 col-md-2"><a href="companies/company?id='+idfk+'#contacts"></a></div><div class="col-xs-6 col-sm-3 col-md-2 align-right "> <span class="label label-primary"></span></div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"> <button id="button2id" name="button2id" class="btn btn-danger evg_cancel">Remove</button></div></div>' );
          
              
            });
               items.push( '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"> <button id="button2id" name="button2id" class="btn btn-danger evg_cancel">Cancel</button></div>')
            $('#get_evegreen_results_users').html(items.join( "" ));
            //$('.eventcount').html(items.length); //update engagement counter
            
           // evergreen_edit();
            
            evergreen_cancel();

          }
            
        });
     
 //console.log($(this).attr('data'));

})




}
 function addActionMultipleFileFields(){
    
    
      $('#addActionMultipleFileFields').append('<div class="col-sm-4 col-md-8 col-md-push-4 alert alert-info alert-dismissable  "><div class="col-md-8 "><input type="text" name="userfilename[]" required="required" class="form-control" placeholder="Please name your file" style="margin-top:-7px; text-transform:capitalize;"></div><div class="col-xs-4 col-sm-3 col-md-3 col-lg-3"><input type="file" name="userfile[]" id="userfile" required="required" size="20" /> </div> <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><button type="button" class="btn btn-warning btn-xs multifileremover">Remove</button></div></div>');
    
    bindMultipleFileRemover();
}
   
    
      function addActionChange(){
        //console.log('france')
               $('.actionrequired').click(function(){


//console.log()
                        if($('#action-error').css('display') != 'none'){
                            event.preventDefault();
                        }


})
               
               
}

function bindMultipleFileRemover(){
    
    $('.multifileremover').click(function(){

$(this).parent().parent().remove();
        
  

})
    
    
}
function getUserFavourites(){ // Dashbord favorites
    
    var order = $('.sortform form select').val();
    var pipeline = [];
        var favourites = [];
    var company_name  = [];
    
        var Customer  = [];
        var Proposal = [];
        var Intent  = [];
        var Prospect  = [];
        var Suspect = [];
    var interface = [];
        $.ajax({
            type: "GET",
                dataType: "json",
            url: "dashboard/refactorFavourites/"+order,
            success: function(data) {
                
                $.each( data, function( key, val ) {
                     company_name = val.name.replace(/Limited|Ltd|ltd|limited/gi, function myFunction(x){return ''});
                    
                    
                    pipeline =   val.pipeline ? val.pipeline : '';
                    
                    
                    interface  = '<a href="companies/company?id='+val.id+'" class="load-saved-search"> <div class="row"> <div class="col-xs-6">'+company_name +'</div><div class="col-xs-4"> <span class="label label-'+pipeline+'" style="margin-top: 3px;"> '+pipeline+' </span> </div></div></a>';
                    
                     if(!order){
                     favourites.push(interface);
                     }
                    
                    if(order){
                    if(val.pipeline == 'Customer') Customer.push(interface);
                     if(val.pipeline == 'Proposal') Proposal.push(interface);
                     if(val.pipeline == 'Intent') Intent.push(interface);
                     if(val.pipeline == 'Prospect')Prospect.push(interface);
                     if(val.pipeline == 'Suspect')Suspect.push(interface);
                    
                    }
                }) 
                
                
                //console.log(Customer.join(""))
                
                    $('#assigned .panel-body').html('');   
                
                if(!order){
                $('#assigned .panel-body').prepend(favourites.join(""));
                }
                if(order){
                       $('#assigned .panel-body').prepend(Suspect.join(""));
                      $('#assigned .panel-body').prepend(Prospect.join(""));
                    $('#assigned .panel-body').prepend(Intent.join(""));
                    $('#assigned .panel-body').prepend(Proposal.join(""));
                $('#assigned .panel-body').prepend(Customer.join(""));
                  
                
              
                 
                }
                
              
              

                    var favouritesCount =  $('#assigned .panel-body a').length;

                    if(favouritesCount != 0){
                        var favouritesCount = $('#assigned .panel-body a').length;
                        $('.favouritesCount').text(favouritesCount);
                        $('.sortform').show();
                    
                    }else{

                        $('.sortform').hide();
                        $('.favouritesCount').text(0);
                        $('#assigned .panel-body').prepend('<div class="col-md-12"> <div style="margin:10px 0;"> <h4 style="margin: 50px 0 40px 0; text-align: center;">You have no recent activity.</h4> </div></div>');

                    }
            }
        });  
    
}

    function tsTotalConfig(){

        if($('.mainAddrType').length > 1) $('.copyRegAddr').remove(); // Removes add copy address check button if more than 1 address exist 
            //counts the totals in team stats columns
            var mycolumnArray = ["tw","lw","tm","lm","sr","utw","ulw","utm","ulm","usr"];
            var mycolumnArrayLength = mycolumnArray.length;
            var myStringArray = ["deals","proposals","demobookedcount","democount","meetingbooked","meetingcount","salescall","introcall","pipelinecount","key_review_added","key_review_occuring","duediligence"];
            var arrayLength = myStringArray.length;
            var total; 
            var list;
            for (var s = 0; s < mycolumnArrayLength; s++) {
            for (var i = 0; i < arrayLength; i++) {
                list = 	getlisttotal(myStringArray[i], mycolumnArray[s]);
            };
        };


    }

function timerounder(incomingtime){
  var s = [];
 incomingtime =   incomingtime.split(':')
   var minutes = incomingtime[1];
var hours = incomingtime[0];
var m = (parseInt((minutes + 7.5)/15) * 15) % 60;
var h = minutes > 52 ? (hours === 23 ? 0 : ++hours) : hours; 
    if(m ===0) s=0;
    return h+':'+m+s;
    
}








//////////////Controls pipline pick date
var d = new Date();
var n = d.getMonth();
console.log(12-n);
d.setMonth(d.getMonth()+(13-n));   //change retruned months here
var   montheval =""+d.getMonth()+"" ;
montheval =  montheval.substr(1, 1) ? d.getMonth() : '0'+d.getMonth() ;
monthevalconcat = d.getFullYear()+"-"+(montheval)+"-01";
////////////////////THE HOLY GRAIL END///////////
$(' <option value=0>Please select</option>').appendTo('#mounthdue'); 
var dateObj = new Date();
var month = dateObj.getUTCMonth() + 1; //months from 1-12
var day = dateObj.getUTCDate();
var year = dateObj.getUTCFullYear();
//newdate = year + "-" + month + "-" + day;
newdate = year + "-" + month + "-01";

var start = new Date(newdate); //yyyy-mm-dd
var end = new Date(monthevalconcat); //yyyy-mm-dd
var mon =['January','Feburary','March','April','May','June','July','Auguast','September','October','November','December' ];
while(start <= end){
var mm = ((start.getMonth()+1)>=10)?(start.getMonth()+1):'0'+(start.getMonth()+1);
var dd = ((start.getDate())>=10)? (start.getDate()) : '0' + (start.getDate());
var yyyy = start.getFullYear();
var date = yyyy +"-"+mm+"-"+dd; //yyyy-mm-dd
if(dd == 01){
$(' <option value="'+date+'">' +mon[(mm-1)]+'</option>').appendTo('#mounthdue');    
}
start = new Date(start.setDate(start.getDate() + 1)); //date increase by 1
}
$(window).load(function(){
$(".draggable-modal").draggable({
handle: ".modal-header"
});
});
/*$(document).ready(function () {
size_li = $("#campaignList a").size();
x=15;
$('#campaignList a:lt('+x+')').css('display', 'block');
$('#loadMore').click(function () {
x= (x+5 <= size_li) ? x+20 : size_li;
$('#campaignList a:lt('+x+')').css('display', 'block');
});
});*/
$(window).load(function(){
$(".draggable-modal").draggable({
handle: ".modal-header"
});
});


function getlisttotal(col,item){
//used to count team stat column totals
    
    
var lm = 0;
    
    
$('.'+item+'-'+col).each(function(){
   
lm  = (lm+parseInt($(this).text()));
  
    
});
$('.'+item+'-'+col+'-total').text(lm);
    
return lm;
}

$('.tradingType').on('change', function() {
var trAddress =  $(this).val(); 
if(trAddress === "Registered Address"){ $('.tradingTypeOptions').show(); } else{ $('.tradingTypeOptions, .addrTrading').hide(); $(".def").prop("checked", true); $('.tradingAddress').val('');   }
}); 
$('.tradingArr').on('change', function() {
var trAddress =  $(this).val(); 
if(trAddress == 2){ $('.addrTrading').show();  $('#tradingAddress').attr('Required', 'Required');  } else{ $('.addrTrading').hide(); $('#tradingAddress').val(''); $('#tradingAddress').removeAttr('Required', 'Required');   }
});
if($('.popUpAddress').val() && $('.mainAddrType').text() != 'Trading Address'){$('.copyRegAddr').hide() }
$('#copymainaddr').click(function(){
if($(this).prop("checked")){ $('.popUpAddress').val($('.mainAddress').text()) }else{ $('.popUpAddress').val('') }
})
function triggerOpenEditbox(){
         console.log('I am legend'); 
    $('.mainedit').trigger('click');
    
    
}
