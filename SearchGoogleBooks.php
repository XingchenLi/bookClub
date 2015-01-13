<?php

require_once 'DatabaseAccess.php';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database, $db_server)
  or die("Unable to select database: " . mysql_error());


$isbn = get_post('ISBN');

$page = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn");

$data = json_decode($page, true);

$cover = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];

$guid = NewGuid();

$currentUser = "";


// Display book info (image, title, author, date published) to the user
echo "<img src='$cover' /><br>";
echo "Title: " . $data['items'][0]['volumeInfo']['title'] . "<br>";
echo "Authors: " . @implode(", ", $data['items'][0]['volumeInfo']['authors']) . "<br>";
echo "Date Published: " . $data['items'][0]['volumeInfo']['publishedDate'] . "<br>";

// Form for inputing ISBN
echo <<<_END
<form action="SearchGoogleBooks.php" method="post"><pre>
ISBN: <input type="text" name="ISBN"><br>
<input type="submit" name="submit" value="SUBMIT"><br>
</pre></form>
_END;

// Insert book selection into database
$query_1 = "INSERT INTO BOOK VALUES" .
"('$guid', '$isbn', '$price', '$condition')";

$upload_1 = mysql_query($query_1);
if(!upload) die ("Book upload was not successful: " . mysql_error());

$query_2 = "INSERT INTO BOOK_OWNER VALUES" .
"('$guid', '$currentUser')";

$upload_2 = mysql_query($query_2);

// close connection to database server
mysql_close($db_server);

// Method for escaping characters
function get_post($var) {
  return mysql_real_escape_string($_POST[$var]);
}

// Method to generate unique id
function NewGuid() {
    $s = strtoupper(md5(uniqid(rand(),true)));
    $guidText =
        substr($s,0,8) . '-' .
        substr($s,8,4) . '-' .
        substr($s,12,4). '-' .
        substr($s,16,4). '-' .
        substr($s,20);
    return $guidText;
}



?>
