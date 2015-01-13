<?php


require_once("../models/config.php");


setReferralPage(getAbsoluteDocumentPath(__FILE__));

?>
<!DOCTYPE html>
<html lang="en">
<?php
echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Books"));
?>

<body>

  <div id="wrapper">


    <div id="page-wrapper">
      <div class="row">
        <div id='display-alerts' class="col-lg-12">

        </div>
      </div>
      <div class="row">
        <div id='book' class="col-lg-12">

        </div>
      </div><!-- /.row -->

    </div><!-- /#page-wrapper -->

  </div><!-- /#wrapper -->

  <script src="../js/bookInfo.js"></script>
  <script>
  $(document).ready(function() {
  bookTable('#book');

  });
</script>
</body>
</html>
