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
        
    }
    ///////////////////////////////////////////////////////////////////////
    /* @method void delete user */
    public static function deleteUser() {
        
    }
    ///////////////////////////////////////////////////////////////////////
    /* @method void list users */
    public static function getAllUsers() {
        Db_Actions::DbSelect("SELECT * FROM users");
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
?>
