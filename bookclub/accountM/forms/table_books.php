<?php

require_once("../models/config.php");

// Request method: GET
$ajax = checkRequestMode("get");



// Sanitize input data
$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);

// Parameters: [title, limit, columns, actions, buttons]
// title (optional): title of this table.
// limit (optional): if specified, loads only the first n rows.
// columns (optional): a list of columns to render.
// actions (optional): a list of actions to render in a dropdown in a special 'action' column.
// buttons (optional): a list of buttons to render at the bottom of the table.

// Set up Valitron validator
$v = new Valitron\DefaultValidator($get);

// Add default values
$v->setDefault('title', 'Books');
$v->setDefault('limit', null);
$v->setDefault('columns',
    [
      'book_info' =>  [
        'label' => 'Book/Info',
        'sort' => 'asc',
        'sorter' => 'metatext',
        'sort_field' => 'book_name',
        'template' => "

        <div class='media'>
        <a class='media-left' href='#'>
        <img src='http://icdn.pro/images/en/j/a/jack-skellington-icone-3829-128.png' alt='...'>
        </a>
        <div class='media-body'>
        <div class='h4'>
        <a href='book_details.php?term=book'>Book Name</a>
        </div>
        <div>
        <i>AuthorName: </i>
        </div>
        <div>
        <i></i> <a >ISBN : </a>
        </div>
        <div>
        <i>Publisher: </i>
        </div>
        </div>
        </div>"
    ]
]);

$v->setDefault('menu_items',
    [
    'user_edit' => [
        'template' => "<a href='#' data-id='book_id' class='btn-edit-book' data-target='#user-update-dialog' data-toggle='modal'><i class='fa fa-edit'></i> Edit Book</a>"
    ],
    'user_disable' => [
        'template' => "<a href='#' data-id='book_id' class='{{toggle_book_class}}'><i class='{{toggle_sale_icon}}'></i> {{toggle_sale_label}}</a>"
    ],
    'user_delete' => [
        'template' => "<a href='#' data-id='book_id' class='btn-delete-user' data-user_name='{{user_name}}' data-target='#user-delete-dialog' data-toggle='modal'><i class='fa fa-trash-o'></i> Delete Book</a>"
    ]
]);

$v->setDefault('buttons',
    [
    'add' => ""
]);

// check the data validation
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

// Generate button display modes
$buttons_render = ['add', 'view_all'];
if (isset($get['buttons']['add'])){
    $buttons_render['add']['hidden'] = "";
} else {
    $buttons_render['add']['hidden'] = "hidden";
}
if (isset($get['buttons']['view_all'])){
    $buttons_render['view_all']['hidden'] = "";
} else {
    $buttons_render['view_all']['hidden'] = "hidden";
}

// Load Book here!! i am using user database as a test(using loadUsers function)
if (($books = loadUsers($get['limit'])) === true) {
  apiReturnError($ajax, ACCOUNT_ROOT);
}

// Compute book table properties
foreach($books as $book_id => $book){
    $books[$book_id]['user_status'] = "Active";
    $books[$book_id]['user_status_style'] = "primary";

    $date_disp = formatDateComponents($book['sign_up_stamp']);
    $books[$book_id]['sign_up_day'] = $date_disp['day'];
    $books[$book_id]['sign_up_date'] = $date_disp['date'];
    $books[$book_id]['sign_up_time'] = $date_disp['time'];

    if ($book['active'] == '1')
        $books[$book_id]['hide_activation'] = "hidden";
    else {
        $books[$book_id]['hide_activation'] = "";
        $books[$book_id]['user_status'] = "Unactivated";
        $books[$book_id]['user_status_style'] = "warning";
    }

    if ($book['enabled'] == '1') {
        $books[$book_id]['toggle_disable_class'] = "btn-disable-user";
        $books[$book_id]['toggle_sale_icon'] = "fa fa-usd";
        $books[$book_id]['toggle_sale_label'] = "Sale Book";
    } else {
        $books[$book_id]['toggle_disable_class'] = "btn-enable-user";
        $books[$book_id]['toggle_disable_icon'] = "fa fa-usd";
        $books[$book_id]['toggle_disable_label'] = "Enable user";
        $books[$book_id]['user_status'] = "Disabled";
        $books[$book_id]['user_status_style'] = "default";
    }
}


// Load CSRF token
$csrf_token = $loggedInUser->csrf_token;

$response = "
<div class='panel panel-primary'>
  <div class='panel-heading'>
    <h3 class='panel-title'><i class='fa fa-book'></i> {$get['title']}</h3>
  </div>
  <div rel = 'test' class='guidePage'>
  <ul rel = 'switchPanel' class='nav nav-tabs'>
  <li id ='panel1' rel = 'panelBook'  class='active'><a href='#'>Mybook</a></li>
  <li id ='panel2' rel = 'panelSearch' ><a href='#'>Find Book</a></li>
  <li id ='panel3' rel = 'panelTrades' ><a href='#'>Trades</a></li>
  </ul>
  </div>
  <div class='panel-body'>
    <input type='hidden' name='csrf_token' value='$csrf_token'/>";

// Don't bother unless there are some records found
if (count($books) > 0) {
    $tb = new TableBuilder($get['columns'], $books, $get['menu_items'], "Status/Actions", null, null);
    $response .= $tb->render();
    $response .= "</div>";
} else {
    $response .= "<div class='alert alert-info'>No books found.</div>";
}

$response .= "
        <div class='row'>
            <div class='col-md-6 {$buttons_render['add']['hidden']}'>
                <button type='button' class='btn btn-success btn-add-book' data-toggle='modal' data-target='#user-create-dialog'>
                    <i class='fa fa-plus-square'></i>  upload New Books
                </button>
            </div>
        </div>
    </div> <!-- end panel body -->
</div> <!-- end panel -->";


if ($ajax)
    echo json_encode(array("data" => $response), JSON_FORCE_OBJECT);
else
    echo $response;

?>
