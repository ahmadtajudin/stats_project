<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ChartData extends DataModerator
{
    public function ChartData()
    {
    }
    
    /*
     * All years for filter
     */
    public static $all_years;
    public static function init_all_years()
    {
        self::$all_years = 
        DB_DETAILS::ADD_ACTION("SELECT DISTINCT(Year) FROM data ORDER BY Year", DB_DETAILS::$TYPE_SELECT);
    }
    
    /*
     * All months periods
     */
    public static $all_months_periods;
    public static function init_all_months_periods()
    {
        self::$all_months_periods = 
        DB_DETAILS::ADD_ACTION("SELECT * FROM months", DB_DETAILS::$TYPE_SELECT);
    }
}
?>
