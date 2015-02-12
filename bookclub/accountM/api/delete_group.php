<?php

require_once("../models/config.php");
set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

$validator = new Validator();
$group_id = $validator->requiredPostVar('group_id');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

//Forms posted
if($group_id){
	if (!deleteGroup($group_id)){
	  echo json_encode(array("errors" => 1, "successes" => 0));
	  exit();
	}
} else {
	echo json_encode(array("errors" => 1, "successes" => 0));
	exit();
}

restore_error_handler();

// Allows for functioning in either ajax mode or graceful degradation to PHP/HTML only
if (isset($_POST['ajaxMode']) and $_POST['ajaxMode'] == "true" ){
  echo json_encode(array(
	"errors" => 0,
	"successes" => 1));
} else {
  header("Location: " . getReferralPage());
  exit();
}

?>
