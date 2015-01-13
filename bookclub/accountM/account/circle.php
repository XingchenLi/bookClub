<?php

require_once("../models/config.php");
//check about security page function
setReferralPage(getAbsoluteDocumentPath(__FILE__));

?>

<!DOCTYPE html>
<html lang="en">
<?php
echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Circle"));
?>

<body>

  <div id="wrapper">

    <!-- Sidebar -->
    <?php
    echo renderMenu("circle");
    ?>

    <div id="page-wrapper">
      <div class="row">
        <div id='display-alerts' class="col-lg-12">
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 col-xs-12">

          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="circle.html">News</a></li>
            <li role="presentation"><a href="friends.html">Friends</a></li>
            <li role="presentation"><a href="event.html">Events</a></li>
          </ul>
          <div class="panel panel-default">
            <div class="list-group">
              <a href="#" class="list-group-item ">
                <h6 class="list-group-item-heading">User's friendsName</h6>
                <p class="list-group-item-text"><img src="http://a-fib.com/wp-content/uploads/2014/02/Apple-and-tape-measure-weight-loss-200-pix-by-96-res.png" alt="#"> </p>
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Like
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> unlike
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> delete

              </a>
              <a href="#" class="list-group-item ">
                <h4 class="list-group-item-heading">User's friendsName</h4>
                <p class="list-group-item-text"> <img src="http://deniseuyehara.com/wp-content/uploads/2011/05/Denise.offering.300pix.jpg" alt="#"></p>
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Like
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> unlike
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> delete

              </a>
              <a href="#" class="list-group-item ">
                <h4 class="list-group-item-heading">User's friendsName</h4>
                <p class="list-group-item-text"> </p>
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Like
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> unlike
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> delete

              </a>
              <a href="#" class="list-group-item ">
                <h4 class="list-group-item-heading">User's friendsName</h4>
                <p class="list-group-item-text"> </p>
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Like
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> unlike
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> delete

              </a>
              <a href="#" class="list-group-item ">
                <h4 class="list-group-item-heading">User's friendsName</h4>
                <p class="list-group-item-text"> </p>
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Like
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> unlike
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> delete

              </a>
              <a href="#" class="list-group-item ">
                <h4 class="list-group-item-heading">User's friendsName</h4>
                <p class="list-group-item-text"> </p>
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Like
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> unlike
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> delete

              </a>
              <a href="#" class="list-group-item ">
                <h4 class="list-group-item-heading">User's friendsName</h4>
                <p class="list-group-item-text"> </p>
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Like
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> unlike
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> delete

              </a>
              <a href="#" class="list-group-item ">
                <h4 class="list-group-item-heading">User's friendsName</h4>
                <p class="list-group-item-text"> </p>
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Like
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> unlike
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> delete

              </a>
            </div>
          </div>
        </div>

                </div><!-- /.row -->
              </div><!-- /#page-wrapper -->

            </div><!-- /#wrapper -->

            <script>
              $(document).ready(function() {
                alertWidget('display-alerts');
              });
            </script>
          </body>
          </html>
