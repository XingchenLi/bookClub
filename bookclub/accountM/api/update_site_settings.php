<?php
/*



*/
require_once("../models/config.php");
require_once("../models/validation/validate_form.php");

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
    addAlert("danger", "You must be logged in to access this resource.");
    echo json_encode(array("errors" => 1, "successes" => 0));
    exit();
}

$validator = new Validator();
//Forms posted
if (isset($_POST)){
    $newSettings = $_POST;
}

if(!empty($newSettings)) {

	// Sanitize and validate data
	unset($newSettings['ajaxMode']);	// Sloppy way to remove metadata
	$errors = validateSiteSettings($newSettings);

	if (count($errors) == 0) {
		// Post-process certain fields before inserting into DB

		// Append a slash to the end of 'website_url', if not present
		if (substr($newSettings['website_url'], -1) != "/"){
		  $newSettings['website_url'] .= "/";
		}

	    // Convert 'token_timeout' from hours to seconds
		$newSettings['token_timeout'] = $newSettings['token_timeout'] *60 *60;

		// Update configuration table with new settings
		if (updateSiteSettings($newSettings)){
			// Immediately replaces "settings" array in config.php.  TODO: get rid of these global variables!  They're nothing but trouble!
			$settings = $newSettings;
			$emailDate = date('dmy');
			$emailActivation = $settings['activation'];
			$can_register = $settings['can_register'];
			$websiteName = $settings['website_name'];
			$websiteUrl = $settings['website_url'];
			$emailAddress = $settings['email'];
			$resend_activation_threshold = $settings['resend_activation_threshold'];
			$language = $settings['language'];
			$new_user_title = $settings['new_user_title'];
			$email_login = $settings['email_login'];
			$token_timeout = $settings['token_timeout'];

			$successes[] = lang("CONFIG_UPDATE_SUCCESSFUL");
		}
	}
} else {
	$errors[] = lang("NO_DATA");
}

restore_error_handler();

foreach ($errors as $error){
  addAlert("danger", $error);
}
foreach ($successes as $success){
  addAlert("success", $success);
}

if (isset($_POST['ajaxMode']) and $_POST['ajaxMode'] == "true" ){
  echo json_encode(array(
	"errors" => count($errors),
	"successes" => count($successes)));
} else {
  header('Location: ' . getReferralPage());
  exit();
}

?>
