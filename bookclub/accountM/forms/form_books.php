<?php


// Request method: GET

require_once("../models/config.php");

// Request method: GET
$ajax = checkRequestMode("get");

// TODO: allow setting default groups

// Sanitize input data
$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);

// Parameters: box_id, render_mode, [user_id, show_dates, disabled]
// box_id: the desired name of the div that will contain the form.
// render_mode: modal or panel
// user_id (optional): if specified, will load the relevant data for the user into the form.  Form will then be in "update" mode.
// show_dates (optional): if set to true, will show the registered and last signed in date fields (fields will be read-only)
// show_passwords (optional): if set to true, will show the password creation fields
// disabled (optional): if set to true, disable all fields

// Set up Valitron validator
$v = new Valitron\DefaultValidator($get);

$v->rule('required', 'box_id');
$v->rule('required', 'render_mode');
$v->rule('in', 'render_mode', array('modal', 'panel'));
$v->rule('integer', 'user_id');

$v->setDefault('user_id', null);
$v->setDefault('fields', array());
$v->setDefault('buttons', array());

// Validate!
$v->validate();

// Process errors
if (count($v->errors()) > 0) {
  foreach ($v->errors() as $idx => $error){
    addAlert("danger", $error);
  }
  apiReturnError($ajax, ACCOUNT_ROOT);
} else {
    $get = $v->data();
}

$fields_default = [
    'user_name' => [
        'type' => 'text',
        'label' => 'Username',
        'display' => 'disabled',
        'validator' => [
            'minLength' => 1,
            'maxLength' => 25,
            'label' => 'Username'
        ],
        'placeholder' => 'Please enter the user name'
    ],
    'display_name' => [
        'type' => 'text',
        'label' => 'Display Name',
        'display' => 'disabled',
        'validator' => [
            'minLength' => 1,
            'maxLength' => 50,
            'label' => 'Display name'
        ],
        'placeholder' => 'Please enter the display name'
    ],
    'title' => [
        'type' => 'text',
        'label' => 'Title',
        'display' => 'disabled',
        'validator' => [
            'minLength' => 1,
            'maxLength' => 100,
            'label' => 'Title'
        ],
        'default' => 'New User'
    ]\
];

// Buttons (optional)
// submit: display the submission button for this form.
// edit: display the edit button for panel mode.
// disable: display the enable/disable button.
// delete: display the deletion button.
// activate: display the activate button for inactive users.

$buttons_default = [
  "btn_submit" => [
    "type" => "submit",
    "label" => $button_submit_text,
    "display" => "hidden",
    "style" => "success",
    "size" => "lg"
  ],
  "btn_edit" => [
    "type" => "launch",
    "label" => "Edit",
    "icon" => "fa fa-edit",
    "display" => "show"
  ],
  "btn_activate" => [
    "type" => "button",
    "label" => "Activate",
    "icon" => "fa fa-bolt",
    "display" => (isset($user['active']) && $user['active'] == '0') ? "show" : "hidden",
    "style" => "success"
  ],
  "btn_disable" => [
    "type" => "button",
    "label" => "Disable",
    "icon" => "fa fa-minus-circle",
    "display" => (isset($user['enabled']) && $user['enabled'] == '1') ? "show" : "hidden",
    "style" => "warning"
  ],
  "btn_enable" => [
    "type" => "button",
    "label" => "Enable",
    "icon" => "fa fa-plus-circle",
    "display" => (isset($user['enabled']) && $user['enabled'] == '1') ? "hidden" : "show",
    "style" => "warning"
  ],
  "btn_delete" => [
    "type" => "launch",
    "label" => "Delete",
    "icon" => "fa fa-trash-o",
    "display" => "show",
    "data" => array(
        "label" => $deleteLabel
    ),
    "style" => "danger"
  ],
  "btn_cancel" => [
    "type" => "cancel",
    "label" => "Cancel",
    "display" => ($get['render_mode'] == 'modal') ? "show" : "hidden",
    "style" => "link",
    "size" => "lg"
  ]
];

$response = "
<div class='modal fade' id='uploadBook' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
<div class='modal-dialog'>
<div class='modal-content'>
<div class='modal-header'>
<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
<h4 class='modal-title' id='exampleModalLabel'>New message</h4>
</div>
<div class='modal-body'>
<form>
<div class='form-group'>
<label for='recipient-name' class='control-label'>Recipient:</label>
<input type='text' class='form-control' id='recipient-name'>
</div>
<div class='form-group'>
<label for='message-text' class='control-label'>Message:</label>
<textarea class='form-control' id='message-text'></textarea>
</div>
</form>
</div>
<div class='modal-footer'>
<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
<button type='button' class='btn btn-primary'>Send message</button>
</div>
</div>
</div>
</div>

";


if ($ajax)
    echo json_encode(array("data" => $response), JSON_FORCE_OBJECT);
else
    echo $response;

?>
