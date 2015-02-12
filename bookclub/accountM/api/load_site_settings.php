<?php


require_once("../models/config.php");

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

$languages = getLanguageFiles(); //Retrieve list of language files

//Retrieve settings
if (!($result = loadSiteSettings())){
	echo json_encode(array("errors" => 1, "successes" => 0));
	exit();
}

$result['language_options'] = $languages;

if (!file_exists($language)) {
	$language = "models/languages/en.php";
}

if(!isset($language)) $language = "models/languages/en.php";

restore_error_handler();

echo json_encode($result, JSON_FORCE_OBJECT);

?>
