<?php


require_once("../models/config.php");

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

// POST: page_id, group_id, checked.  if group_id is set to "private", will change private/public status of page.

$validator = new Validator();
$page_id = $validator->requiredPostVar('page_id');
$group_id = $validator->requiredPostVar('group_id');
$checked = $validator->requiredPostVar('checked');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

//Forms posted
if($page_id !== null && $group_id !== null && $checked !== null ){
  if (!updatePageGroupLink($page_id, $group_id, $checked)){
	echo json_encode(array("errors" => 1, "successes" => 0));
	exit();
  }
}

restore_error_handler();

if (isset($_POST['ajaxMode']) and $_POST['ajaxMode'] == "true" ){
  echo json_encode(array(
	"errors" => 0,
	"successes" => 1));
} else {
  header('Location: ' . getReferralPage());
  exit();
}
?>
