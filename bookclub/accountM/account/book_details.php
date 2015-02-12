<?php


require_once("../models/config.php");

?>

<!DOCTYPE html>
<html lang="en">
  <?php
  	echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "User Details"));
  ?>
<body>

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

			</div>
		</div>
  </div><!-- /#page-wrapper -->

</div><!-- /#wrapper -->

    <script src="../js/bookInfo.js"></script>
    <script>
		$(document).ready(function() {
			userDisplay('bookName');

			alertWidget('display-alerts');

    });

    </script>
  </body>
</html>
