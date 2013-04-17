<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CHART_User
{
    //Reference to the session holder of the user data
    const SESSION_LOGGED_USER_REFERENCE = "user_data_lgd";
    
    /*
     * Users types
     */
    const TYPE_ADMIN = "Admin";
    const TYPE_CLIENT = "Client";
    const TYPE_DEALER = "Dealer";
    
    //Logged user.It must init into the tools.php file.
    public static $LOGGED_USER = NULL;
    
    public $id,
            $user_type,
            $dealer_code;
    
    public function  CHART_User($row____data)
    {
        $this->id = $row____data["id"];
        $this->user_type = $row____data["user_type"];
        $this->dealer_code = $row____data["dealer_code"];
    }
    
    public static function init_logged_user()
    {
        /*
         * Just for testing
         */
        $_SESSION[self::SESSION_LOGGED_USER_REFERENCE] = new ArrayObject();
        $_SESSION[self::SESSION_LOGGED_USER_REFERENCE]->id = "281";//Admin
        //$_SESSION[self::SESSION_LOGGED_USER_REFERENCE] = array("id"=>"283");//Client
        //$_SESSION[self::SESSION_LOGGED_USER_REFERENCE] = array("id"=>"192");//Dealer
        /*
         * Just for testing
         */
        
        $logged_user_data = $_SESSION[self::SESSION_LOGGED_USER_REFERENCE];
        $sql_command_select_logged_user = "SELECT * FROM users WHERE id='".$logged_user_data->id."'";
        $row_user = DB_DETAILS::ADD_ACTION($sql_command_select_logged_user, DB_DETAILS::$TYPE_SELECT);
        self::$LOGGED_USER = new CHART_User( $row_user[0] );
    }
}
?>
