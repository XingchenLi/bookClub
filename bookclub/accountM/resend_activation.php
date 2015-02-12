<?php


require_once("models/config.php");

setReferralPage(getAbsoluteDocumentPath(__FILE__));

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) {
	addAlert("danger", "I'm sorry, you cannot request an activation email while logged in.  Please log out first.");
	apiReturnError(false, SITE_ROOT);
}

?>

<!DOCTYPE html>
<html lang="en">
  <?php
	echo renderTemplate("head.html", array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Resend Activation"));
  ?>

  <body>
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills navbar pull-right">
        </ul>
        <h3 class="text-muted">UserFrosting</h3>
      </div>
      <div class="jumbotron">
        <h1>Account Activation</h1>
        <p class="lead">Please enter your username and the email address you used to sign up, and an activation email will be resent.</p>
		<form class='form-horizontal' role='form' name='resend' action='api/user_resend_activation.php' method='post'>
		  <div class="row">
			<div id='display-alerts' class="col-lg-12">

			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-offset-3 col-md-6">
			  <input type="text" class="form-control" placeholder="Username" name = 'username' value=''>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-offset-3 col-md-6">
			  <input type="email" class="form-control" placeholder="Email" name='email'>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-12">
			  <button type="submit" class="btn btn-success submit" value='Resend'>Resend Activation</button>
			</div>
		  </div>
		</form>
      </div>
      <?php echo renderTemplate("footer.html"); ?>

    </div> <!-- /container -->

	<script>
        $(document).ready(function() {
			// Load the header
			$(".navbar").load("header-loggedout.php", function() {
				$(".navbar .navitem-login").addClass('active');
			});

			alertWidget('display-alerts');

		  	$("form[name='resend']").submit(function(e){
				var form = $(this);
				var url = APIPATH + 'user_resend_activation.php';
				$.ajax({
				  type: "POST",
				  url: url,
				  data: {
					username:	form.find('input[name="username"]').val(),
					email:		form.find('input[name="email"]').val(),
					ajaxMode:	"true"
				  }
				}).done(function(result) {
				  resultJSON = processJSONResult(result);
				  alertWidget('display-alerts');
				});
				// Prevent form from submitting twice
				e.preventDefault();
		    });
		});
	</script>
  </body>
</html>
