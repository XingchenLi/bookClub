<?php

require_once("models/config.php");

// Public page

setReferralPage(getAbsoluteDocumentPath(__FILE__));

//Forward the user to their default page if he/she is already logged in
if(isUserLoggedIn()) {
	addAlert("warning", "You're already logged in!");
	header("Location: account");
	exit();
}
global $email_login;

if ($email_login == 1) {
    $user_email_placeholder = 'Username or Email';
}else{
    $user_email_placeholder = 'Username';
}
?>

<!DOCTYPE html>
<html lang="en">
  <?php
	echo renderTemplate("head.html", array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Login"));
  ?>

  <body>
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills navbar pull-right">
        </ul>
        <h3 class="text-muted">BookClub</h3>
      </div>
      <div class="jumbotron">
        <h1>Welcome to BookClub!</h1>
        <p class="lead">Find out friends with same interest !</p>
		<small>Please sign in here:</small>
		<form class='form-horizontal' role='form' name='login' action='api/process_login.php' method='post'>
		  <div class="row">
			<div id='display-alerts' class="col-lg-12">

			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-offset-3 col-md-6">
			  <input type="text" class="form-control" id="inputUserName" placeholder="<?php echo $user_email_placeholder; ?>" name = 'username' value=''>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-offset-3 col-md-6">
			  <input type="password" class="form-control" id="inputPassword" placeholder="Password" name='password'>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-12">
			  <button type="submit" class="btn btn-primary submit" value='Login'>Login</button>
			</div>
		  </div>
		  <div class="jumbotron-links">
		  </div>
		</form>
      </div>
      <?php echo renderTemplate("footer.html"); ?>

    </div> <!-- /container -->

	<script>
        $(document).ready(function() {
		  // Load navigation bar
		  $(".navbar").load("header-loggedout.php", function() {
			  $(".navbar .navitem-login").addClass('active');
		  });
		  // Load jumbotron links
		  $(".jumbotron-links").load("jumbotron_links.php");

		  alertWidget('display-alerts');

		  $("form[name='login']").submit(function(e){
			var form = $(this);
			var url = 'api/process_login.php';
			$.ajax({
			  type: "POST",
			  url: url,
			  data: {
				username:	form.find('input[name="username"]').val(),
				password:	form.find('input[name="password"]').val(),
				ajaxMode:	"true"
			  },
			  success: function(result) {
				var resultJSON = processJSONResult(result);
				if (resultJSON['errors'] && resultJSON['errors'] > 0){
				  alertWidget('display-alerts');
				} else {
				  window.location.replace("account");
				}
			  }
			});
			// Prevent form from submitting twice
			e.preventDefault();
		  });

		});
	</script>
  </body>
</html>
