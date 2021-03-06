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
        <td><?php if(isset($data->id)) echo $data->id; ?></td>
        <td><?php if(isset($data->serial)) echo $data->serial; ?></td>
        <td><?php if(isset($data->dealerCode)) echo $data->dealerCode; ?></td>
        <td><?php if(isset($data->Area)) echo $data->Area; ?></td>
        <td><?php if(isset($data->Chains)) echo $data->Chains; ?></td>
        <td><?php if(isset($data->Months)) echo $data->Months; ?></td>
        <td><?php if(isset($data->Year)) echo $data->Year; ?></td>
        <?php
    }
    ///////////////////////////////////////////////////////////
    /* @method mixed get last row from passby table */
    public static function getPassbyTableLastRow() {
        $data = Db_Actions::DbSelectLastRow("passby");
        ?>
        <td>passby</td>
        <td><?php if(isset($data->id)) echo $data->id; ?></td>
        <td><?php if(isset($data->Months)) echo $data->Months; ?></td>
        <td><?php if(isset($data->year)) echo $data->year; ?></td>
        <td><?php if(isset($data->passby)) echo $data->passby; ?></td>
        <td><?php if(isset($data->dealerCode)) echo $data->dealerCode; ?></td>
        <td><?php if(isset($data->Months)) echo $data->Months; ?></td>
        <td><?php if(isset($data->Year)) echo $data->Year; ?></td>
        <?php
    }
    ///////////////////////////////////////////////////////////
    /* @method mixed get last row from dealers table */
    public static function getDealersTableLastRow() {
        $data = Db_Actions::DbSelectLastRow("dealers");
        ?>
        <td>dealers</td>
        <td><?php if(isset($data->id)) echo $data->id; ?></td>
        <td><?php if(isset($data->dealer_code)) echo $data->dealer_code; ?></td>
        <td><?php if(isset($data->dealer_name)) echo $data->dealer_name; ?></td>
        <td><?php if(isset($data->dealer_area)) echo $data->dealer_area; ?></td>
        <td><?php if(isset($data->chain)) echo $data->chain; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
    }
    ///////////////////////////////////////////////////////////////////////
    /* @method void Import data in user, daelars or passby tables from excel file */
    public static function ImportUserDataFromExcelFile() {
       
        $uploader = new Uploader();
        $uploader->max_file_size = 2000000; //2MB
        $uploader->allowed_extensions = array('xlsx');
        $uploader->temp_path = "../temp";
        $uploader->upload_path = "../uploads";
        $fileName = $uploader->uploadFile("excel_file_data");
        if($fileName !== false){
            
            //process uploaded excel file
            //Load excel data
            $data = PhpExcelHelper::importData("../uploads/".$fileName);
           
            //Column Names
            $columns = PhpExcelHelper::getColumnsNames();
            //Build the mysql query
            //Create mysql column names
            $database_table = Db_Actions::DbSanitizeData($_POST['table_name']);
            $query = "INSERT INTO ". $database_table . " (";
            for($i=0; $i<= count($columns); $i++){
                $query .= $columns[$i] . ($i < count($columns) - 1 ? "," : "");
            }
            $query .= ") VALUES";
            //Create query with all the data
            for($j=0; $j<= count($data); $j++){
                if($j == 0){ continue; } // Skip first row, as that row contains our column names
                
                $query .= "(";
                for($k=0; $k< count($columns); $k++){
                    $curr_row = trim($data[$j][$k]);
                    $curr_row = empty($curr_row) && '0' != $curr_row ? "' '" : "'".$curr_row."'";
                    $query .= $curr_row . ($k < count($columns) - 1 ? "," : "");
                }
                $query .= ")" . ($j <= count($data) - 1 ? "," : "");
            }
           
            $lastID = Db_Actions::DbInsert($query);
            
            $_SESSION[Tools::$USER_MESSAGE] = "Data succesfully imported.";
            ?><script type="text/javascript">window.location = "../superadmin.php";</script><?php
        }
        else{
            $warnings = $uploader->displayErrors();
            $_SESSION[Tools::$USER_MESSAGE] = $warnings;
            ?><script type="text/javascript">window.location = "../superadmin.php";</script><?php
        }
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
//////////////////////////////////////////////////////////////////////////////////////////////////////
//Import data from excel file
if (isset($_POST['add_excel_data'])) {
    session_start();
    require_once("db_actions.php");
    require_once("uploader.php");
    require_once("phpexcelhelper.php");
    Tools::ImportUserDataFromExcelFile();
}
?>