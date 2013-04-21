<?php
session_start();
require_once('./php-tools/db_actions.php');
require_once('./php-tools/tools.php');
require_once('./php-tools/user.php');

if (!isset($_SESSION[Tools::$LOGGED_SSNAME]) || $_SESSION[Tools::$LOGGED_SSNAME] != Tools::$LOGGED_SSID) {
    header('Location: login.php');
}
Tools::redirectUserByPermissions();
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
        <script type="text/javascript" src="bootstrap/js/bootstrap.file-input.js"></script>
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
                <header id="top-header" class="container row-center">
                    <div class="span12">
                        <div class="top-nav">
                            <ul>
                                <li>Συνδεθήκατε ως <?php echo $userData->username; ?></li>
                                <li><a href="php-tools/tools.php?logout=1">Αποσύνδεση</a></li>
                            </ul>
                        </div>
                        <div class="logo"><a href="index.php"><img src="images/logo-hyundai.jpg" /></a></div>
                    </div>
                </header>
                <nav id="main-menu" class="full-row">
                    <?php Tools::generatePrimaryNav(); ?>
                </nav>
            </div>
            <div class="clearfix"></div>
            <div class="content-container">
                <div class="clearfix"></div>