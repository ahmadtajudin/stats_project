<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CHART_Area
{
    public $id,$area,$area_name_gr,$area_name_en;
    
    public function CHART_Area($row_data)
    {
        $this->id = $row_data["id"];
        $this->area = $row_data["area"];
        $this->area_name_en = $row_data["area_name_en"];
        $this->area_name_gr = $row_data["area_name_gr"];
    }
    
    /*
     * Array all areas
     */
    public static $all_areas;
    
    /*
     * All areas for dealers
     */
    public static $all_areas_for_dealer;
    
    /*
     * All areas for using
     */
    public static $all_areas_for_using;
    
    
    /*
     * Before to use areas data i must init the data
     */
    public static function init_all_areas()
    {
        self::$all_areas =
        DB_DETAILS::ADD_ACTION("SELECT * FROM areas", DB_DETAILS::$TYPE_SELECT);
        array_push(self::$all_areas, array("id"=>"atina_solun", "area"=>"", "area_name_en"=>"", "area_name_gr"=>"Αθήνα + Θεσσαλονίκη"));
        array_push(self::$all_areas, array("id"=>"eparhija", "area"=>"", "area_name_en"=>"", "area_name_gr"=>"Επαρχία"));
    }
    public static function init_areas_for_dealer()
    {
        $dealer_data = DB_DETAILS::ADD_ACTION("
            SELECT * FROM dealers WHERE dealer_code='".CHART_User::$LOGGED_USER->dealer_code."'
        ", DB_DETAILS::$TYPE_SELECT);
        self::$all_areas_for_dealer = array();
        
        /*
         * If not dealer, array will be empthy...
         * When logged user is dealer, and this is empthy, then we have error.
         * So, pass the error please
         */
        if(count($dealer_data) == 0)
        {
            if(CHART_User::$LOGGED_USER->user_type == CHART_User::TYPE_DEALER)
            {
                print "error: Area::init_areas_for_dealer, error, for dealer not options.";
            }
            return;
        }
        else
        {
            //array_push(self::$all_areas_for_dealer, $dealer_data[0]);
            $area_row = DB_DETAILS::ADD_ACTION("
                SELECT * FROM areas WHERE 
                area_name_gr='".$dealer_data[0]["dealer_area"]."'
            ", DB_DETAILS::$TYPE_SELECT);
            if(count($area_row) == 1)
            array_push(self::$all_areas_for_dealer, $area_row[0]);
        }
        
        /*for($i=0;$i<count(self::$all_areas);$i++)
        if(self::$all_areas[$i]["area"] == $dealer_data[0]["dealer_area"])
        {
            array_push(self::$all_areas_for_dealer, self::$all_areas[$i]);
        }*/
        if($dealer_data[0]["chain"]=="1" || $dealer_data[0]["chain"]=="2")
        array_push(self::$all_areas_for_dealer, 
                array("id"=>"atina_solun", "area"=>"", "area_name_en"=>"", "area_name_gr"=>"Αθήνα + Θεσσαλονίκη"));
    }
}
?>
