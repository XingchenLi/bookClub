
$("#bookform").ready(function() {
$("#submit").click(function() {
var isbn = $("#isbnvalue").val();
var dataString = 'ISBN='+ isbn;

// Ajax code to submit form
  $.ajax({
  type: "POST",
  url: "SearchGoogleBooks.php",
  data: dataString,
  cache: false,
  success: function(result) {

    alert(result);
    // parse string
    var string = result;
    var newBookImage = string.split('*')[0];
    var bookTitle = string.split('*')[1];
    var bookAuthors = string.split('*')[2];
    var bookPublishDate = string.split('*')[3];
    var bookISBN = string.split('*')[4];


    // return book info to html client
    $("#searchBN").html(bookTitle);
    $("#searchAN").html(bookAuthors);
    $("#searchISBN").html(bookISBN);
    $("#searchPublishDate").html(bookPublishDate);
    document.getElementById("currentImage").src = newBookImage;
    $("#bookform")[0].reset();
  }
  });

return false;
});
});
