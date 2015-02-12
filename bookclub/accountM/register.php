<?php

require_once("models/config.php");

setReferralPage(getAbsoluteDocumentPath(__FILE__));

if (!userIdExists('1')){
	addAlert("danger", lang("MASTER_ACCOUNT_NOT_EXISTS"));
	header("Location: install/wizard_root_user.php");
	exit();
}

// If registration is disabled, send them back to the home page with an error message
if (!$can_register){
	addAlert("danger", lang("ACCOUNT_REGISTRATION_DISABLED"));
	header("Location: login.php");
	exit();
}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) {
	addAlert("danger", "I'm sorry, you cannot register for an account while logged in.  Please log out first.");
	apiReturnError(false, SITE_ROOT);
}

?>

<!DOCTYPE html>
<html lang="en">
  <?php
	echo renderTemplate("head.html", array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Register"));
  ?>

  <body>
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills navbar pull-right">
        </ul>
        <h3 class="text-muted">BookClub</h3>
      </div>
      <div class="jumbotron">
        <h1>Let's get started!</h1>
        <p class="lead">Registration is fast and simple.</p>
		<form name='newUser' id='newUser' class='form-horizontal' role='form' action='api/create_user.php' method='post'>
		  <div class="row">
				<div id='display-alerts' class="col-lg-12">

				</div>
		  </div>
		  <div class="row form-group">
			<label class="col-sm-4 control-label">Username</label>
			<div class="col-sm-8">
			    <div class="input-group">
                    <span class='input-group-addon'><i class='fa fa-edit'></i></span>
					<input type="text" class="form-control" placeholder="Username" name = 'user_name' value='' data-validate='{"minLength": 1, "maxLength": 25, "label": "Username" }'>
				</div>
			</div>
		  </div>
		  <div class="row form-group">
			<label class="col-sm-4 control-label">Display Name</label>
			<div class="col-sm-8">
				<div class="input-group">
					<span class='input-group-addon'><i class='fa fa-edit'></i></span>
					<input type="text" class="form-control" placeholder="Display Name" name='display_name' data-validate='{"minLength": 1, "maxLength": 50, "label": "Display Name" }'>
				</div>
			</div>
		  </div>
		  <div class="row form-group">
			<label class="col-sm-4 control-label">Email</label>
			<div class="col-sm-8">
				<div class="input-group">
					<span class='input-group-addon'><i class='fa fa-envelope'></i></span>
					<input type="email" class="form-control" placeholder="Email" name='email' data-validate='{"email": true, "minLength": 1, "maxLength": 150, "label": "Email" }'>
				</div>
			</div>
		  </div>
		  <div class="row form-group">
			<label class="col-sm-4 control-label">Password</label>
			<div class="col-sm-8">
				<div class="input-group">
					<span class='input-group-addon'><i class='fa fa-lock'></i></span>
					<input type="password" class="form-control" placeholder="Password" name='password' data-validate='{"minLength": 8, "maxLength": 50, "passwordMatch": "passwordc", "label": "Password" }'>
				</div>
			</div>
		  </div>
		  <div class="row form-group">
			<label class="col-sm-4 control-label">Confirm Password</label>
			<div class="col-sm-8">
			  	<div class="input-group">
					<span class='input-group-addon'><i class='fa fa-lock'></i></span>
					<input type="password" class="form-control" placeholder="Confirm Password" name='passwordc' data-validate='{"minLength": 8, "maxLength": 50, "label": "Confirm Password" }'>
				</div>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-4 control-label">Confirm Security Code</label>
			<div class="col-sm-4">
				<div class="input-group">
					<span class='input-group-addon'><i class='fa fa-eye'></i></span>
					<input type="text" class="form-control" name='captcha' data-validate='{"minLength": 1, "maxLength": 50, "label": "Confirm Security Code" }'>
				</div>
			</div>
			<div class="col-sm-4">
			  <img src='<?php echo generateCaptcha(); ?>' id="captcha">
			</div>
		  </div>
		  <br>
		  <div class="form-group">
			<div class="col-sm-12">
			  <button type="submit" class="btn btn-primary submit" value='Register'>Register</button>
			</div>
		  </div>
		</form>
	  </div>
      <?php echo renderTemplate("footer.html"); ?>

    </div> <!-- /container -->

<script>
	$(document).ready(function() {
		// Load navigation bar
		$(".navbar").load("header-loggedout.php", function() {
            $(".navbar .navitem-register").addClass('active');
        });

		// Process submission
        $("form[name='newUser']").submit(function(e){
			e.preventDefault();
            var form = $(this);
            var errorMessages = validateFormFields('newUser');
			if (errorMessages.length > 0) {
				$('#display-alerts').html("");
				$.each(errorMessages, function (idx, msg) {
					$('#display-alerts').append("<div class='alert alert-danger'>" + msg + "</div>");
				});
			} else {
                var url = APIPATH + 'create_user.php';
                $.ajax({
                  type: "POST",
                  url: url,
                  data: {
					user_name: 		form.find('input[name="user_name"]' ).val(),
					display_name: 	form.find('input[name="display_name"]' ).val(),
					email: 			form.find('input[name="email"]' ).val(),
					password: 		form.find('input[name="password"]' ).val(),
					passwordc: 		form.find('input[name="passwordc"]' ).val(),
					captcha: 		form.find('input[name="captcha"]' ).val(),
                    ajaxMode:		"true"
                  }
                }).done(function(result) {
                  var resultJSON = processJSONResult(result);
                  if (resultJSON['errors'] && resultJSON['errors'] > 0){
                        console.log("error");
						// Reload captcha
						var img_src = 'models/captcha.php?' + new Date().getTime();
						$('#captcha').attr('src', img_src);
						form.find('input[name="captcha"]' ).val("");
                        alertWidget('display-alerts');
                        return;
                  } else {
                    window.location.replace('login.php');
                  }
                });
            }
		});
	});
</script>
</body>
</html>
