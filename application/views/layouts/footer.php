	    	</div>
	        <!-- /#page-wrapper -->
		</div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo asset_url();?>/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    
 	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 	<script src="http://cdn.oesmith.co.uk/morris-0.5.1.min.js"></script>

 	<!-- Custom Theme JavaScript -->
    <script src="<?php echo asset_url();?>/js/sb-admin-2.js"></script>


    <script src="<?php echo asset_url();?>/js/ladda.min.js"></script>


 	<script type="text/javascript">
 	$( document ).ready(function() {
 	//  	$(".assign-to-form").submit(function() {

		//     var url = $(this).attr('action'); // the script where you handle the form input.
		//     $.ajax({
		//            type: "POST",
		//            url: url,
		//            data: $(this).serialize(), // serializes the form's elements.
		//            success: function(data)
		//            {
		//                alert('success'); // show response from the php script.
		//            }
		//          });

		//     return false; // avoid to execute the actual submit of the form.
		// });

		$('.assign-to-form button').click(function(e){
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
		 	    
		 	  })
		 	.always(function() { textbtn.text('Assigned to '+name );  l.stop(); btn.attr('disabled','disabled'); });

		 	return false;
		});

 	});


 	</script>
 <?php if(ENVIRONMENT == 'development'): ?>
 	<div class="alert alert-warning" role="alert">
 	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
 	</div>
 <?php endif; ?>
</body>

</html>