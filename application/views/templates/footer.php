      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--<script src="js/bootstrap.min.js"></script>-->
	<script type="text/javascript">
		var pros_1 = $('input[name=pros_1]');
		var pros_2 = $('input[name=pros_2]');
		var pros_3 = $('input[name=pros_3]');
		$(".pros").click(function(event){
			pros_1.attr('value', pros_2.attr('value'));
			pros_2.attr('value', pros_3.attr('value'));
			pros_3.attr('value', event.target.innerHTML);
		});
		var cons_1 = $('input[name=cons_1]');
		var cons_2 = $('input[name=cons_2]');
		var cons_3 = $('input[name=cons_3]');
		$(".cons").click(function(event){
			cons_1.attr('value', cons_2.attr('value'));
			cons_2.attr('value', cons_3.attr('value'));
			cons_3.attr('value', event.target.innerHTML);
		});
		function copyToClipboard(text) {
			window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
		}
	</script>
	<!--<script type="text/javascript">
		// using JQUERY's ready method to know when all dom elements are rendered
		$( document ).ready(function () {
		  // set an on click on the button
		  $(".agree").click(function () {
			$.ajax({
				type:'POST',
				url:'/index.php/agree/' + this.id + '/<?=$current_user_id?>',
				data:{},
				success:function(data){
					var a = document.getElementById(data + "_agree");
					if (a != null) {
						a.innerHTML++;
					} else {
						alert(data);
					}
				}
			});
		  });
		  $(".disagree").click(function () {
			$.ajax({
				type:'POST',
				url:'/index.php/disagree/' + this.id + '/<?=$current_user_id?>',
				data:{},
				success:function(data){
					var d = document.getElementById(data + "_disagree");
					if (d != null) {
						d.innerHTML++;
					} else {
						alert(data);
					}
				}
			});
		  });
		});
	</script>-->
  </body>
</html>