<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ChartData extends DataModerator
{
    const GROUP_A="A";
    const GROUP_B="B";
    

    public function ChartData()
    {
    }
    
    /*
     * functions for init and clausule for MySQL selecting
     * It depend from a lot of variables
     */
    const AREA_ATINA_SOLUN   = "atina_solun";
    const AREA_REST_OF_STATE = "eparhija";
    
    public function SQLforAND_area($areaID) {
        if ($areaID != "-1") {
            $areaANDClausule = " Area='" . $areaID . "' ";
        } else {
            $areaANDClausule = " Area<>'-1' ";
        }
        if ($areaID == self::AREA_ATINA_SOLUN) {
            $areaANDClausule = " (Area='1' OR Area='2') ";
        } else if ($areaID == self::AREA_REST_OF_STATE) {
            $areaANDClausule = " Area<>'1' AND Area<>'2' ";
        }
        return $areaANDClausule;
    }

    public function SQLforAND_chain($chainID) {
        if ($chainID != "-1") {
            $chainANDClausule = " Chains='" . $chainID . "' ";
        } else {
            $chainANDClausule = " Chains<>'-1' ";
        }
        return $chainANDClausule;
    }

    public function SQLforAND_dealer($dealerID) {
        if ($dealerID != "-1") {
            $delearANDClausule = " dealerCode='" . $dealerID . "' ";
        } else {
            $delearANDClausule = " dealerCode<>'-1' ";
        }
        return $delearANDClausule;
    }

    public function SQLforAND_year($yearFromOut) {
        if ($yearFromOut != "-1") {
            $yearANDClausule = " Year='" . $yearFromOut . "' ";
        } else {
            $yearANDClausule = " Year<>'-1' ";
        }
        return $yearANDClausule;
    }
    public function MONTHs_OR_CLAUSULE($months) {
        if ($months == "-1") {
            $months = "1,2,3,4,5,6,7,8,9,10,11,12";
        }
        $monthsARR = explode(",", $months);
        $sqlClaus = " ( ";
        for ($i = 0; $i < count($monthsARR); $i++) {
            $sqlClaus .= "Months='" . $monthsARR[$i] . "'";
            if ($i < count($monthsARR) - 1) {
                $sqlClaus .= " OR ";
            }
        }
        $sqlClaus .= " ) ";
        return $sqlClaus;
    }
    protected $area_year_month_dealercode_chain__SQL_condition;
    protected function area_year_month_dealercode_chain__SQL_condition_init( $group_type )
    {
        $this->area_year_month_dealercode_chain__SQL_condition = 
                $this->SQLforAND_area( $_POST["areas_options__".$group_type] )." AND ".
                $this->SQLforAND_year( $_POST["years_options__".$group_type] )." AND ".
                $this->MONTHs_OR_CLAUSULE( $_POST["months_periods_options__".$group_type] )." AND ".
                $this->SQLforAND_dealer( $_POST["dealers_options__".$group_type] )." AND ".
                $this->SQLforAND_chain( $_POST["chains_options__".$group_type] );
    }
    
    /*
     * Quanity XML line, for colum from data, with total count of the variables
     * selected by value "get_quantity"
     * and
     * selected by total count "get_quantity_total"
     */
    protected function get_quantity_xml_line( $column_variable, $value_column, $column_variable_addtional_reference )
    {
        $sql_select_quantity = "SELECT COUNT(".$column_variable.") AS ___COUNT___ FROM data WHERE " . 
                $this->area_year_month_dealercode_chain__SQL_condition . " AND ".$column_variable."='".$value_column."'";
        //print $sql_select_quantity;
        $quantity = DB_DETAILS::ADD_ACTION($sql_select_quantity, DB_DETAILS::$TYPE_SELECT);
        return "<".$column_variable.$column_variable_addtional_reference.">".$quantity[0]["___COUNT___"]."</".$column_variable.$column_variable_addtional_reference.">";
    }
    protected function get_quantity_total_xml_line( $column_variable, $column_variable_addtional_reference )
    {
        $sql_select_quantity_total = "SELECT COUNT(".$column_variable.") AS ___COUNT___ FROM data WHERE ".
                $this->area_year_month_dealercode_chain__SQL_condition." AND ".$column_variable."<>'' ";
        //print "[".$sql_select_quantity_total."]";
        $quantity = DB_DETAILS::ADD_ACTION($sql_select_quantity_total, DB_DETAILS::$TYPE_SELECT);
        return "<".$column_variable.$column_variable_addtional_reference.">".$quantity[0]["___COUNT___"]."</".$column_variable.$column_variable_addtional_reference.">";
    }
    protected function get_quantity_xml_data_for_array($array_variables, $xml_data_holder_name="quantity")
    {
        $data_quantity = "<".$xml_data_holder_name.">";
        $data_quantity .= "<quantity>";
        for($i=0;$i<count($array_variables);$i++)
        {
            $data_quantity .= $this->get_quantity_xml_line($array_variables[$i]["column"], $array_variables[$i]["value"], 
                                $array_variables[$i]["column_xml_additional_reference"]);
        }
        $data_quantity .= "</quantity>";
        $data_quantity .= "<quantity_total>";
        for($i=0;$i<count($array_variables);$i++)
        {
            $data_quantity .= $this->get_quantity_total_xml_line($array_variables[$i]["column"], $array_variables[$i]["column_xml_additional_reference"]);
        }
        $data_quantity .= "</quantity_total>";
        $data_quantity .= "</".$xml_data_holder_name.">";
        return $data_quantity;
    }

    /*
     * function for sending the variables XML back to client
     * It is using in constructor of each data moderator for charts
     */
    protected function print_back_to_client( $chart_moderator )
    {
        $this->data_xml_total .= "<root>";
        $this->data_xml_total .= $chart_moderator->get_data_for_group( self::GROUP_A );
        $this->data_xml_total .= $chart_moderator->get_data_for_group( self::GROUP_B );
        $this->data_xml_total .= "</root>";
        /*
        DB_DETAILS::$VARs["data"] = $this->data_xml_total;
        DB_DETAILS::PRINT_VARS();*/
        print $this->data_xml_total;
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
    
    /*
     * get total passby and total interviews
     */
    protected function get_data_xml_total_passby_and_interviews($column_init_for_intervews)
    {
        $sql_total_passBY = 
                "SELECT SUM(passby) AS totalPassBy FROM passby WHERE ".$this->area_year_month_dealercode_chain__SQL_condition;
        //print $sql_total_passBY;
        $total_pass_by = DB_DETAILS::ADD_ACTION($sql_total_passBY, DB_DETAILS::$TYPE_SELECT);
        $sql_select_total_interviews = "SELECT COUNT(".$column_init_for_intervews.") AS ___COUNT___ FROM data WHERE ".
                $this->area_year_month_dealercode_chain__SQL_condition." AND ".$column_init_for_intervews."<>''";
        //print $sql_select_total_interviews;
        $total_interviews = DB_DETAILS::ADD_ACTION($sql_select_total_interviews, DB_DETAILS::$TYPE_SELECT);
        return "<total_pass_by>".$total_pass_by[0]["totalPassBy"]."</total_pass_by><total_interviews>".
                $total_interviews[0]["___COUNT___"]."</total_interviews>";
    }
    
    protected  function get_data_xml_average($column_init_for_average)
    {
        $SQLSelectAverageSUM = 
                "SELECT SUM(".$column_init_for_average.") AS ___SUM___ FROM data 
                    WHERE ".$this->area_year_month_dealercode_chain__SQL_condition." 
                    AND ".$column_init_for_average."<>''";
        $average_row = DB_DETAILS::ADD_ACTION($SQLSelectAverageSUM, DB_DETAILS::$TYPE_SELECT);
        if($average_row[0]["___SUM___"] == ""){$average_row[0]["___SUM___"] = "0";}
        $SQLSelectAverageCOUNT = 
                "SELECT COUNT(".$column_init_for_average.") AS ___COUNT___ FROM data 
                    WHERE ".$this->area_year_month_dealercode_chain__SQL_condition." 
                    AND ".$column_init_for_average."<>''";
        //print $SQLSelectAverageSUM;
        $averagecount_row = DB_DETAILS::ADD_ACTION($SQLSelectAverageCOUNT, DB_DETAILS::$TYPE_SELECT);
        //print $SQLSelectAverageSUM;
        return "<average><average_total>".$average_row[0]["___SUM___"]."</average_total><count>".$averagecount_row[0]["___COUNT___"]."</count></average>";
    }


    /*
     * Function for get data for the parts.
     * It should get back count of total, and count of all parts.
     * For example if we have parts with values 1,2,3,4 and 5.
     * It count all count with 1, then with 2, then with 3, ....5.
     * Then sent back.
     */
    protected function get_counts_for_parts($arr_details_parts, $range_from_to)
    {
        $data_for = "<data>";
        for($i=0;$i<count($arr_details_parts);$i++)
        {
            for($j=$range_from_to["from"];$j<=$range_from_to["to"];$j++)
            {
                $column_variable = $arr_details_parts[$i]["column"];
                $count_sql = "
                    SELECT COUNT(".$column_variable.") AS __COUNT__ FROM data WHERE ".$this->area_year_month_dealercode_chain__SQL_condition
                        ." AND ".$column_variable."='".$j."'
                ";
                $count = DB_DETAILS::ADD_ACTION($count_sql, DB_DETAILS::$TYPE_SELECT);
                //print $count_sql;
                $data_for .= "<count_".$column_variable."_".$j.">".$count[0]["__COUNT__"]."</count_".$column_variable."_".$j.">";
            }
            $count_total_sql = "
                    SELECT COUNT(".$column_variable.") AS __COUNT__ FROM data WHERE ".$this->area_year_month_dealercode_chain__SQL_condition
                    ." AND ".$column_variable."<>'0' AND ".$column_variable."<>'' ";
            $count_total = DB_DETAILS::ADD_ACTION($count_total_sql, DB_DETAILS::$TYPE_SELECT);
            $count_total_other_sql = "
                    SELECT COUNT(".$column_variable.") AS __COUNT__ FROM data WHERE ".$this->area_year_month_dealercode_chain__SQL_condition
                    ." AND ".$column_variable."<>'0' AND ".$column_variable."<>'5' AND ".$column_variable."<>'' ";
            $count_total_other = DB_DETAILS::ADD_ACTION($count_total_other_sql, DB_DETAILS::$TYPE_SELECT);
            //print $count_total_sql;
            if($count_total[0]["__COUNT__"] == "0")
            {
                $count_total[0]["__COUNT__"] = "1";
            }
            if($count_total_other[0]["__COUNT__"] == "0")
            {
                $count_total_other[0]["__COUNT__"] = "1";
            }
            $data_for .= "<count_total_1234_".$column_variable.">".$count_total_other[0]["__COUNT__"]."</count_total_1234_".$column_variable.">";
            $data_for .= "<count_total_".$column_variable.">".$count_total[0]["__COUNT__"]."</count_total_".$column_variable.">";
            
            $sumtotal_for_average = DB_DETAILS::ADD_ACTION("
      SELECT SUM(".$column_variable.") AS __SUM__ FROM data WHERE ".$this->area_year_month_dealercode_chain__SQL_condition
                    , DB_DETAILS::$TYPE_SELECT);
            $data_for .= "<sum_total_for_average_".$column_variable.">".$sumtotal_for_average[0]["__SUM__"]."</sum_total_for_average_".$column_variable.">";
            /*if($i==0)
            {
                $count_total_sql = "
                        SELECT COUNT(".$column_variable.") AS __COUNT__ FROM data WHERE ".$this->area_year_month_dealercode_chain__SQL_condition
                        ." AND ".$column_variable."<>'0' AND ".$column_variable."<>'' ";
                $count_total_withou_other_results__xN = DB_DETAILS::ADD_ACTION($count_total_sql, DB_DETAILS::$TYPE_SELECT);
                $data_for .= "<count_total_topmainline_withou_other_results__xN_".$column_variable.">".
                        $count_total_withou_other_results__xN[0]["__COUNT__"].
                             "</count_total_topmainline_withou_other_results__xN_".$column_variable.">";
            }*/
        }
        $data_for .= "</data>";
        return $data_for;
    }
}
?>
