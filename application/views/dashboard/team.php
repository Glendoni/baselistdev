<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
var stat =[
          ['Mushrooms', 3],
          ['Onions', 1],
          ['Olives', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ];
         
                 $.ajax({
        type: "GET",
            
            dataType: "json",
                 url: 'googleapitest',
            success: function(data) {  
              //console.log(data)
                 var tags=[]; 
             $.each( data, function( key, val) {
                 
        tags.push([val['person'],parseInt(val['days'])]);
                 
             }) 
            
           
                
               //console.log(tags.join(","))
         
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping',  {className: 'text-right'});
        data.addColumn('number', 'Slices',{className: 'text-right'});
        data.addRows(tags);

        // Set chart options
        var options = {'title':'Tagged in the last 100 days',
                       'width':600,
                       'height':500};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div')
                                                     );
        chart.draw(data, options);
                $('rect').attr("fill", "rgba(51, 51, 51, 0)" );
                
                $('text').click(function(){

//console.log($(this).text())

});
                   }
          });
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>