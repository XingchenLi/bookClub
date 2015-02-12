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
  	echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Groups"));
  ?>

    <div id="wrapper">

        <?php
          echo renderMenu("groups");
        ?>

      <div id="page-wrapper">
	  	<div class="row">
          <div id='display-alerts' class="col-lg-12">

          </div>
        </div>
		<div class='row'>
		  <div class='col-lg-6'>
			<div id='widget-groups'>
			</div>
		  </div>
		  <div id='info' class='col-lg-6'>

          </div>
		</div>
      </div>
	</div>
	<script src="../js/widget-groups.js"></script>
	<script>
        $(document).ready(function() {
		  alertWidget('display-alerts');
		  groupsWidget('widget-groups', {});

		});
	</script>
  </body>
</html>
