<?php


require_once("../models/config.php");

if (!securePage(__FILE__)){
  // Forward to index page
  addAlert("danger", "Whoops, looks like you don't have permission to view that page.");
  header("Location: index.php");
  exit();
}

setReferralPage(getAbsoluteDocumentPath(__FILE__));

?>
<!DOCTYPE html>
<html lang="en">
  <?php
  	echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Users"));
  ?>

  <body>

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
          <div id='widget-users' class="col-lg-12">

          </div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <script src="../js/widget-users.js"></script>
    <script>
        $(document).ready(function() {

          alertWidget('display-alerts');

          userTable('widget-users');
        });
    </script>
  </body>
</html>
