<?php

require_once("../models/config.php");
//check about security page function
setReferralPage(getAbsoluteDocumentPath(__FILE__));

?>

<!DOCTYPE html>
<html lang="en">
<?php
echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Dashboard"));
?>

<body>

  <div id="wrapper">

    <!-- Sidebar -->
    <?php
    echo renderMenu("home");
    ?>

    <div id="page-wrapper">
      <div class="row">
        <div id='display-alerts' class="col-lg-12">
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="#" class="list-group-item">Home</a></li>
            <li role="presentation"><a href="profile.html">Profile</a></li>
            <li role="presentation"><a href="#">Messages</a></li>
          </ul>
          <div class="panel panel-default">

            <div class="list-group">
              <li class="list-group-item"><a href="#" class="list-group-item" >
                <h4 class="list-group-item-heading">User friend's Name1</h4>
                <p class="list-group-item-text">laksj;dlajd
                  alsdla
                  lasjdlaskjd</p>
                </a></li>
                <li class="list-group-item"><a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">User friend's Name2</h4>
                  <p class="list-group-item-text">alsdj
                    alsdjlasjd
                    lkasjdlkasd</p>
                  </a></li>
                  <li class="list-group-item"><a href="#" class="list-group-item">
                    <h4 class="list-group-item-heading">User friend's Name3</h4>
                    <p class="list-group-item-text">alsdjals
                      alsdjlakd</p>
                    </a></li>
                    <li class="list-group-item"><a href="#" class="list-group-item">
                      <h4 class="list-group-item-heading">User friend's Name4</h4>
                      <p class="list-group-item-text">aldjal
                        alsdkja
                        lajsdl</p>
                      </a></li>
                      <li class="list-group-item"><a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">User friend's Name5</h4>
                        <p class="list-group-item-text">asdljaslkdj
                          alsjdlas
                          laskjd</p>
                        </a></li>
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
