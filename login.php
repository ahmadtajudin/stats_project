<?php
session_start();
require_once('./php-tools/db_actions.php');
require_once('./php-tools/tools.php');
if (isset($_SESSION[Tools::$LOGGED_SSNAME]) || $_SESSION[Tools::$LOGGED_SSNAME] == Tools::$LOGGED_SSID) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="bootstrap/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/tools.js"></script>
        <!--[if lt IE 9]>
          <script src="js/html5.js" type="text/javascript"></script>
        <![endif]-->
    </head>
    <body>
        <div class="main-container">
            <div class="full-row black-bg">
                <header id="top-header" class="row-center">
                    <div class="logo centered"><a href="index.php"><img src="images/logo-hyundai.jpg" /></a></div>
                </header>
                <nav id="main-menu" class="full-row">
                </nav>
            </div>
            <div class="clearfix"></div>
            <div class="content-container">
                <div class="clearfix"></div>
                <form action="php-tools/tools.php" id="login-form" method="post">
                    <?php
                      if(isset($_SESSION[Tools::$USER_MESSAGE]) && !empty($_SESSION[Tools::$USER_MESSAGE]) ){
                          echo "<div class='alert alert-error'>".$_SESSION[Tools::$USER_MESSAGE]."</div>";
                          unset($_SESSION[Tools::$USER_MESSAGE]);
                      }
                    ?>
                    <h4>Σύνδεση</h4>
                    <div class="form-row">
                        <label for="username">Όνομα χρήστη</label>
                        <input type="text" name="username" id="username" class="input-xlarge"  >
                    </div>
                    <div class="form-row">
                        <label for="passwd">Κωδικός</label>
                        <input type="password" name="passwd" id="passwd" class="input-xlarge" >
                    </div>
                    <input type="hidden" name="process_login_req" value="1" >
                    <button type="submit" class="btn">Σύνδεση</button>
                </form>
            </div><!-- Content end -->
            <div class="clearfix"></div>
            <footer class="full-row fotter-main">
                <div class="foot-copyright">
                    <img src="images/login_glob_img.jpg" width="197" height="77" /><br />
                    <p class="pad-left">Copyright ©<a href="http://www.elasticreality.gr" target="_blank">Elastic Reality</a></p>
                </div>
            </footer>
        </div><!-- Container end -->
        <script type="text/javascript">
            $(document).ready(function() {
                $("#login-form").validate({
                    rules: {
                        username: "required",
                        passwd: "required"
                    },
                    messages: {
                        username: "Enter your username",
                        passwd: "Provide your password"
                    },
                    // set new class to error-labels to indicate valid fields
                    success: function(label) {
                        // set &nbsp; as text for IE
                        label.remove();
                    }
                });
            });
        </script>
    </body>
</html>