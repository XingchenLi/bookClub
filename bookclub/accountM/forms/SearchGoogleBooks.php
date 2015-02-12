<?php

$isbn = get_post('ISBN');

$page = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn");

$data = json_decode($page, true);

// Return book info (image, title, author, date published)
$bookImage = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
echo $bookImage . "*";

$bookTitle = $data['items'][0]['volumeInfo']['title'];
echo $bookTitle . "*";

$bookAuthors = @implode(", ", $data['items'][0]['volumeInfo']['authors']);
echo $bookAuthors . "*";

$publishDate = $data['items'][0]['volumeInfo']['publishedDate'];
echo $publishDate . "*";

echo $isbn . "*";


// Method for escaping characters
function get_post($var) {
  return mysql_real_escape_string($_POST[$var]);
}


?>
