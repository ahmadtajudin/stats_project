<?php

class Tools {
    //User types
    //@var string admin user type
    public static $SUPER_ADMIN = "Admin";
    //@var string dealer user type
    public static $SUPER_CLIENT = "Dealer";
    //@var string client user type
    public static $CLIENT = "Client";
    //@var string logged user session
    public static $LOGGED_SSID = "A54GG6yn";
    //@var string logged user session name
    public static $LOGGED_SSNAME = "loggedSessionN";
    //@var array logged user data
    public static $LOGGED_USER_DATA = "user_data_lgd";
    //@var string store messages to display to user
    public static $USER_MESSAGE;
    public function __construct() {
        
    }
    ///////////////////////////////////////////////////////////
    /* @method void login request */
    public static function loginUser() {
        //Sanitize Data
        $username = Db_Actions::DbSanitizeData($_POST['username']);
        $password = Db_Actions::DbSanitizeData($_POST['passwd']);
        //Check if user exists
        $userData = Db_Actions::DbSelectRow("SELECT id, username, password, user_type, dealer_code FROM users WHERE username='" . $username . "' AND password=SHA1('" . $password . "')");
        //We have a match
        if (!isset($userData->empty_result)) {
            //Get data from dealers table
            $dealersData = Db_Actions::DbSelectRow("SELECT id AS dealer_id, dealer_name, dealer_area, dealer_password, chain FROM dealers WHERE dealer_code='" . $userData->dealer_code . "'");
            foreach ($dealersData as $key => $val) {
                $userData->$key = $val;
            }
            //Set sesion for logged user
            $_SESSION[self::$LOGGED_SSNAME] = self::$LOGGED_SSID;
            //Assign all data for logged user to session
            $_SESSION[self::$LOGGED_USER_DATA] = $userData;
            //redirect user to dashboard.php
            ?><script type="text/javascript">window.location = "../index.php";</script><?php
        }
        else {
            //Login failed
            $_SESSION[self::$USER_MESSAGE] = "Invalid username or password";
            //redirect user to login.php
            ?><script type="text/javascript">window.location = "../login.php";</script><?php
        }
    }
    ///////////////////////////////////////////////////////////
    /* @method void destroy login sessioon */
    public static function logoutUser() {
        if (isset($_SESSION[self::$LOGGED_SSNAME]) && $_SESSION[self::$LOGGED_SSNAME] == self::$LOGGED_SSID) {
            unset($_SESSION[self::$LOGGED_SSNAME]);
            if (isset($_SESSION[self::$LOGGED_USER_DATA])) {
                unset($_SESSION[self::$LOGGED_USER_DATA]);
            };
            //redirect user to login.php
            ?><script type="text/javascript">window.location = "../login.php";</script><?php
        }
    }
    ///////////////////////////////////////////////////////////
    /* @method void generate primary navigation */
    public static function generatePrimaryNav() {
        global $userData;
        ?>
        <div class="container">
            <ul class="span12">
                <li><a href="index.php">Πίνακας ελέγχου</a></li>
                <?php if ($userData->user_type === self::$SUPER_ADMIN) { ?><li><a href="superadmin.php">Διαχείριση</a></li> <?php } ?>
                <li><a href="graphs.php">Γραφήματα</a></li>
                <li><a href="questions.php">Ερωτηματολόγιο</a></li>
            </ul>
        </div>    

        <?php
    }
    ///////////////////////////////////////////////////////////
    /* @method void get current page name */
    public static function redirectUserByPermissions() {
        $pageName = pathinfo($_SERVER['SCRIPT_FILENAME'], 2);
        global $userData;
        switch ($pageName) {
            case 'superadmin.php':
            case 'users.php':
                if ($userData->user_type !== self::$SUPER_ADMIN) {
                    header('Location: index.php');
                }
                break;
        }
    }
    ///////////////////////////////////////////////////////////
    /* @method int get count data from data table */
    public static function getDataCount() {
        return Db_Actions::DbGetTableRows("data");
    }
    ///////////////////////////////////////////////////////////
    /* @method mixed get last row from data table */
    public static function getDataTableLastRow() {
        $data = Db_Actions::DbSelectLastRow("data");
        ?>
        <td>data</td>
        <td><?php echo $data->id; ?></td>
        <td><?php echo $data->serial; ?></td>
        <td><?php echo $data->dealerCode; ?></td>
        <td><?php echo $data->Area; ?></td>
        <td><?php echo $data->Chains; ?></td>
        <td><?php echo $data->Months; ?></td>
        <td><?php echo $data->Year; ?></td>
        <?php
    }
    ///////////////////////////////////////////////////////////
    /* @method mixed get last row from passby table */
    public static function getPassbyTableLastRow() {
        $data = Db_Actions::DbSelectLastRow("passby");
        ?>
        <td>passby</td>
        <td><?php echo $data->id; ?></td>
        <td><?php echo $data->Months; ?></td>
        <td><?php echo $data->year; ?></td>
        <td><?php echo $data->passby; ?></td>
        <td><?php echo $data->dealerCode; ?></td>
        <td><?php echo $data->Months; ?></td>
        <td><?php echo $data->Year; ?></td>
        <?php
    }
    ///////////////////////////////////////////////////////////
    /* @method mixed get last row from dealers table */
    public static function getDealersTableLastRow() {
        $data = Db_Actions::DbSelectLastRow("dealers");
        ?>
        <td>dealers</td>
        <td><?php echo $data->id; ?></td>
        <td><?php echo $data->dealer_code; ?></td>
        <td><?php echo $data->dealer_name; ?></td>
        <td><?php echo $data->dealer_area; ?></td>
        <td><?php echo $data->chain; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
//Login User
if (isset($_POST['process_login_req'])) {
    session_start();
    require_once("db_actions.php");
    Tools::loginUser();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//Logout User
if (isset($_GET['logout'])) {
    session_start();
    Tools::logoutUser();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//Assign user data to variable
if (isset($_SESSION[Tools::$LOGGED_USER_DATA])) {
    global $userData;
    $userData = $_SESSION[Tools::$LOGGED_USER_DATA];
}
?>