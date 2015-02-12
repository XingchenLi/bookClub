<?php


// Request method: GET

include('../models/db-settings.php');
include('../models/config.php');

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

// GET Parameters: [user_id, group_id]
// If a user_id is specified, attempt to load group information for all groups associated with the specified user.
// If a group_id is specified, attempt to load information for the specified group.
// Otherwise, attempt to load all groups.
$validator = new Validator();
$user_id = $validator->optionalGetVar('user_id');
$group_id = $validator->optionalGetVar('group_id');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

if ($user_id){
  // Special case to load groups for the logged in user
  if ($user_id == "0"){
    $user_id = $loggedInUser->user_id;
  }

  // Attempt to load group information for the specified user.
  if (!($results = loadUserGroups($user_id))){
      echo json_encode(array("errors" => 1, "successes" => 0));
      exit();
  }
} else if ($group_id){
  // Attempt to load information for the specified group.
  if (!($results = loadGroup($group_id))){
      echo json_encode(array("errors" => 1, "successes" => 0));
      exit();
  }
} else {
  // Attempt to load information for all groups
  if (!($results = loadGroups())){
      echo json_encode(array("errors" => 1, "successes" => 0));
      exit();
  }
}

restore_error_handler();

echo json_encode($results);

?>
