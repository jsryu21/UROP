<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkee</title>

    <!-- Bootstrap -->
    <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	
    <!-- Custom styles for this template -->
    <link href="/checkee.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?=$this->config->item('facebook_api_id')?>',
          xfbml      : true,
          version    : 'v2.0'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <?php
			if ($current_facebook_id == FALSE) {
				echo '<a class="navbar-brand" href="/index.php"><img src="/images/1.png" /></a>';
			} else {
				echo '<a class="navbar-brand" href="/index.php/friends/'.$current_facebook_id.'"><img src="/images/1.png" /></a>';
			}
		  ?>
        </div>
		<?php
			if ($current_facebook_id) {
				echo '<div class="navbar-collapse collapse">';
				echo '<ul class="nav navbar-nav navbar-right">';
				echo '<li><a href="/index.php/friends/'.$current_facebook_id.'">친구</a></li>';
				echo '<li><a href="/index.php/user/'.$current_facebook_id.'">나</a></li>';
				echo '<li><a href="/index.php/logout">로그아웃</a></li>';
				echo '</ul>';
				echo '</div><!--/.navbar-collapse -->';
			}
		?>
      </div>
    </div>