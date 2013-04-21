<?php

class Admin_User {
    public function __construct() {
        
    }
    ///////////////////////////////////////////////////////////////////////
    /* @method void Create new user */
    public static function createNewUser() {

        $last_ID = Db_Actions::DbInsert2("users", array(
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'user_type' => $_POST['userType']
        ));
        $_SESSION[Tools::$USER_MESSAGE] = "User Created";
        ?><script type="text/javascript">window.location = "../superadmin.php";</script><?php
    }
    ///////////////////////////////////////////////////////////////////////
    /* @method void Update user */
    public static function updateUser() {
        $user_ID = $_POST['update_user'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type'];
        $dealer_code = $_POST['dealer_code'];
        
        $affected_rows = Db_Actions::DbUpdate2("users", array(
            'username' => $username,
            'password' => $password,
            'user_type' => $user_type,
            'dealer_code' => $dealer_code
        ),"id=".  Db_Actions::DbSanitizeData($user_ID) );
        if($affected_rows == 1 || $affected_rows == 0){
            echo "1";
        }
    }
    ///////////////////////////////////////////////////////////////////////
    /* @method void get user data by id */
    public static function getUserDataByID($id) {
        $data = Db_Actions::DbSelectRowByID("users", Db_Actions::DbSanitizeData($id));
        echo $data->id . "#|#";
        echo $data->username . "#|#";
        echo $data->user_type . "#|#";
        echo $data->dealer_code;
    }
    ///////////////////////////////////////////////////////////////////////
    /* @method void delete user */
    public static function deleteUser($id) {
        $userID = Db_Actions::DbSanitizeData($id);
        $affectedRows = Db_Actions::DbDelete("DELETE FROM users WHERE id=" . $userID . " LIMIT 1");
        if ($affectedRows == 1) {
            $_SESSION[Tools::$USER_MESSAGE] = "User Deleted";
        }
    }
    ///////////////////////////////////////////////////////////////////////
    /* @method void list users */
    public static function getAllUsers() {
        Db_Actions::DbSelect("SELECT * FROM users ORDER BY id DESC");
        $data = Db_Actions::DbGetResults();
        return $data;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
//Create new user
if (isset($_POST['add_user'])) {
    session_start();
    require_once("db_actions.php");
    require_once("tools.php");
    Admin_User::createNewUser();
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
//Get user data by id
if (isset($_POST['edit_user_id'])) {
    session_start();
    require_once("db_actions.php");
    require_once("tools.php");
    Admin_User::getUserDataByID($_POST['edit_user_id']);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////
// Update user
if (isset($_POST['update_user'])) {
    session_start();
    require_once("db_actions.php");
    require_once("tools.php");
    Admin_User::updateUser();
}
?>