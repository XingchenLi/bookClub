<?php


require_once("../models/config.php");


setReferralPage(getAbsoluteDocumentPath(__FILE__));

?>
<!DOCTYPE HTML>
<html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="isbn_send_script.js"></script>
  <?php
  echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Books"));
  ?>
  <!-- Begin page contents here -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php
    echo renderMenu("users");
    ?>

    <div id="page-wrapper">
      <div class="row">
        <div id='display-alerts' class="col-lg-12">
        </div>
      </div>
      <div class="row">
        <div id='widget-user-info' class="col-lg-6">
          <form id="bookform" name="bookform_name" method="post">
            <label> ISBN :</label>
            <input id="isbnvalue" type="text">
            <input id="submit" type="button" value="SUBMIT">
          </form>

          <li id = "bookItem" class="list-group-item">
            <div class="media">
              <a class="media-left" href="#">
                <img id= "currentImage" src="http://icdn.pro/images/en/j/a/jack-skellington-icone-3829-128.png" alt="...">

              </a>
              <div class="media-body">
                <a href="#" class="list-group-item" >
                  <h4 id = "searchBN" class="list-group-item-heading"> Book Name: </h4>
                  <p id = "searchAN" class="list-group-item-text">Author Name: </br>
                  </p>
                  <p id = "searchPublishDate" class="list-group-item-text">Publish Date: </br>
                  </p>
                  <p id = "searchISBN" class="list-group-item-text">ISBN: </br>
                  </p>

                  <!-- I am thinking that we can use form action to send data to database-->
                  <!-- The problem of doing that is that we will have a submit button on every book item panel-->
                  <form action= "">
                    <!-- still have to figure out how to uncheck the radio-->
                    <input type="radio" name="add" value="1" checked> add
                    <input type="radio" name="add" value="0"> ignore
                    <br>
                    <input type="submit" class = btn btn-primary value="Submit">
                  </form>
                </a>
              </div>

            </li>
        </div>
      </div>
    </div><!-- /#page-wrapper -->

  </div><!-- /#wrapper -->

</div>

</html>
