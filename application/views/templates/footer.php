		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script><!-- http://stackoverflow.com/questions/5150363/onchange-open-url-via-select-jquery -->
			$(function(){
			  // bind change event to select
			  $('#dynamic_select').bind('change', function () {
				  var url = $(this).val(); // get selected value
				  if (url) { // require a URL
					  window.location = url; // redirect
				  }
				  return false;
			  });
			});
		</script>
	</body>
</html>