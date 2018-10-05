////////////////THE HOLY GRAIL
    var d = new Date();
      d.setMonth(d.getMonth()+4);   //change retruned months here
      var   montheval =""+d.getMonth()+"" ;
      montheval =  montheval.substr(1, 1) ? d.getMonth() : '0'+d.getMonth() ;
      monthevalconcat = d.getFullYear()+"-"+(montheval)+"-01";
    //console.log(monthevalconcat);

          ////////////////////THE HOLY GRAIL END
    var dateObj = new Date();
    var month = dateObj.getUTCMonth() + 1; //months from 1-12
    var day = dateObj.getUTCDate();
    var year = dateObj.getUTCFullYear();
    //newdate = year + "-" + month + "-" + day;
          newdate = year + "-" + month + "-01";
    var start = new Date(newdate); //yyyy-mm-dd
    var end = new Date(monthevalconcat); //yyyy-mm-dd
    var mon =['January','February','March','April','May','June','July','August','September','October','November','December' ];
        while(start <= end){
          console.log('fuck');
            var mm = ((start.getMonth()+2)>=12)?(start.getMonth()+1):'0'+(start.getMonth()+1);
            var dd = ((start.getDate())>=12)? (start.getDate()) : '0' + (start.getDate());
            var yyyy = start.getFullYear();
            var date = yyyy +"-"+mm+"-"+dd; //yyyy-mm-dd
            if(dd == 1){
//console.log(mon[(mm-1)]); 
$(' <div class="col-md-2 reduced-padding"><div class="colum-header"><h2>'+mon[(mm-1)]+' <span class="header-bold pipeline_will">Will </span> <span class="badge wc pcountwc'+date+' pipeListCounter"></span></h2> </div></div>').appendTo('#pipeline_labels'); 
$(' <div class="col-md-2 reduced-padding"><div class="colum-header"><h2>'+mon[(mm-1)]+' <span class="header-bold pipeline_should">Intent</span> <span class="badge sc pcountsc'+date+' pipeListCounter"></span></div> </h2></div>').appendTo('#pipeline_labels'); 
//$(' <div class="column col-md-2" placement="sc'+date+'"><h2>'+mon[(mm-1)]+'<br/>SHOULD</h2></div>').appendTo('#pipeline_content'); 
//$(' <div class="column col-md-2" placement="wc'+date+'"><h2>'+mon[(mm-1)]+'<br/>WILL</h2></div>').appendTo('#pipeline_content');
$('<div class="col-md-2 reduced-padding"><div class="column wc'+date+' wc"  placement="wc'+date+'"></div></div> <div class="col-md-2 reduced-padding"><div class="column sc'+date+' sc"  placement="sc'+date+'"></div></div>').appendTo('#pipeline_content');
}
start = new Date(start.setDate(start.getDate() + 1)); //date increase by 1
}
  $(function() {
 
    $( ".column" ).sortable({
      connectWith: ".column",
      handle: ".portlet-header",
      cancel: ".portlet-toggle",
      placeholder: "portlet-placeholder ui-corner-all",
        receive : function(event, ui) {
				                //console.log($(this).data().uiSortable);
            var newMonth = $('.active').parent().attr('placement');
            var elementId = $('.active .portlet-header').text();
            var companyId  = $('.active').attr('company_id');
            var params = { 
                monthupdate:newMonth, 
                companyId:companyId };
            var str = jQuery.param( params );
            //console.log(newMonth);     
          //  var call = pipm();
          // console.log('Portal headers '+$('.active .portlet-header').text() + ' id '+$('.active').parent().attr('placement') );   
            //console.log('Portal header '+$('.active .portlet-header').text() + ' id '+$('.active').parent().attr('placement') );
            dragg(str);
            $('.portlet').removeClass('active');
						return true;
        },
             update: function( event, ui ) {
                addListQuantity();
             }
    });
      
    $( ".portlet" )
      .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
      .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
 
    $( ".portlet-toggle" ).click(function() {
      var icon = $( this );
      icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
      icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();

    }); 
  });
        
   function replaceAll(str, find, replace) {

    if(str){
        return str.replace(new RegExp(find, 'g'), replace);
    }else{
        return false;
    }
}      
    $(document).ready(function(){
        /*Refresh pipleine code 
        $('#pipeline_content .column').html('');initialize_dragg();
        */
         initialize_dragg(); // get drag and drop entries from server   
    })
        function initialize_dragg()
        { //gets entries from server
               $.ajax({
                        dataType: "json",
                        url: "../companies/drag",
                        success: function (data) {
                                  var placement_holder_prefix; 
                            var res;
                            for (var key in data) {
                                if(data[key]['status']== 1 ){
                                placement_holder_prefix = 'sc';
                                }else{
                                   placement_holder_prefix = 'wc';
                                }
                                disc = data[key]['image'].split(",");
                              //console.log(disc[1]); 
                              var pipeline = data[key]['pipeline']; 
                              if (pipeline === undefined || pipeline === null) {
                                var pipelinecheck = "Unknown";
                                }
                              else {
                                  var pipelinecheck = data[key]['pipeline'];


}

 var datechanged = data[key]['pipeline_date_updated']; 
                              if (datechanged === undefined || datechanged === null) {
                                var datechanged = data[key]['pipeline_date_created'];
                                }
                              else {
                                  var datechanged = data[key]['pipeline_date_updated'];
}

                    res = data[key]['companyname'].replace(/Limited|Ltd|ltd/gi, function myFunction(x){return ''});
     $('<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" company_id="'+data[key]['company_id'] +'"><div> <div class="portlet-header ui-sortable-handle ui-widget-header ui-corner-all"><div class="c_name">'+ res +'<a target="_blank" href="../companies/company?id='+data[key]['company_id'] +'" style="font-size: 7px;"><i class="glyphicon glyphicon-edit"></i></a></div></div> <div class="col-xs-12 no-padding split-label" style="background-color:#E4E3E3;"">'+datechanged+'</div><div class="col-xs-6 no-padding split-label" style="background-color:'+disc[1]+'; color:'+disc[2]+';">'+data[key]['name']+'</div><div class="col-xs-6 no-padding split-label label-'+pipelinecheck+'">'+pipelinecheck+'</div> ').appendTo("[placement="+placement_holder_prefix+data[key]['efffrom']+"]" );
                                    jsonBinder(); //binds listeners to JSON  generated elements retruned back from the server           
                                addListQuantity();
                        }
                    }
             });
    }
    function  jsonBinder()
    { //binds listeners to JSON  generated elements retruned back from the server
        $('.portlet').click(function(){
            $(this).addClass('active');
        })
        $('.portlet').mouseup(function(){
            $('.portlet').removeClass('active');
            $(this).addClass('active');
            var placement = $(this).parent().attr('placement');
            //console.log('What was the original placement  '+ placement);
        })
    }
    function addListQuantity(){
        var clid;
        var clidListQty;
        $.each($('.column'), function(index) { 
            clid =$(this).attr('placement');
            clidListQty  = $('.'+clid + ' .portlet').length;
            $('.pcount'+clid).text(clidListQty);

        });

    }    