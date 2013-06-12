<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CHART_Dealer
{
    /*
     * It is holding the dealers by the dealer code from logged user.
     * Is using when logged user is dealer
     */
    public static $all_dealers_according_to_user = array();
   
    /*
     * It is holding all delears in case of admin or client type
     */
    public static $all_dealers = array();
    
    /*
     * It is just reference to $all_dealers or $all_dealers_according_to_user
     */
    public static $dealers_list_for_using;
    
    public $id, $dealer_code, $dealer_name, $dealer_area, $chain;
    
    public function  CHART_Dealer($row____data)
    {
        $this->id = $row____data["id"];
        $this->dealer_code = $row____data["dealer_code"];
        $this->dealer_name = $row____data["dealer_name"];
        $this->dealer_area = $row____data["dealer_area"];
        $this->chain = $row____data["chain"];
    }
    
    /*
     * This x2 functions must be init before using them.
     */
    public static function init_dealers_according_to_user()
    {
        self::$all_dealers_according_to_user = 
        DB_DETAILS::ADD_ACTION("
            SELECT * FROM dealers WHERE dealer_code='".CHART_User::$LOGGED_USER->dealer_code."'
        ", DB_DETAILS::$TYPE_SELECT);     
    }
    public static function init_all_dealers()
    {
        self::$all_dealers = 
        DB_DETAILS::ADD_ACTION("
            SELECT * FROM dealers GROUP BY dealer_code ORDER BY dealer_name
        ", DB_DETAILS::$TYPE_SELECT);  
    }
    
    public static  function GET_BY_DEALER_CODE($dealer_code)
    {
        $dealers_data = 
        DB_DETAILS::ADD_ACTION("
            SELECT * FROM dealers 
            WHERE dealer_code='".$dealer_code."'
        ", DB_DETAILS::$TYPE_SELECT); 
        if(count($dealers_data)==2)
        {
            return new CHART_Dealer($dealers_data[1]);
        } 
        if(count($dealers_data)==1)
        {
            return new CHART_Dealer($dealers_data[0]);
        }
        return NULL;
    }
}
?>
