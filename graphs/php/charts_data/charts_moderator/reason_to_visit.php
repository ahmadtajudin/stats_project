<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Reason to visit, or ΛΟΓΟΙ ΕΠΙΣΚΕΨΗΣ.
 */
class ReasonToVisit extends ChartData
{
    public function ReasonToVisit()
    {
        parent::__construct();
        
        $this->data_xml_total .= "<root>";
        $this->data_xml_total .= $this->get_data_for_group( ChartData::GROUP_A );
        $this->data_xml_total .= $this->get_data_for_group( ChartData::GROUP_B );
        $this->data_xml_total .= "</root>";
        
        $this->print_back_to_client();
    }
    public function get_data_for_group( $group_type_left_or_right )
    {
        /*
        $SQLSelectq6_1 = "SELECT COUNT(q6_1) AS ___COUNT___ FROM data WHERE " . $variableSQLUSLOV . " AND q6_1='1'";
        $SQLSelectq6_2 = "SELECT COUNT(q6_2) AS ___COUNT___ FROM data WHERE " . $variableSQLUSLOV . " AND q6_2='1'";
        $SQLSelectq6_3 = "SELECT COUNT(q6_3) AS ___COUNT___ FROM data WHERE " . $variableSQLUSLOV . " AND q6_3='1'";
        $SQLSelectq6_1_total = "SELECT COUNT(q6_1) AS ___COUNT___ FROM data WHERE " . $variableSQLUSLOV;
        $SQLSelectq6_2_total = "SELECT COUNT(q6_2) AS ___COUNT___ FROM data WHERE " . $variableSQLUSLOV;
        $SQLSelectq6_3_total = "SELECT COUNT(q6_3) AS ___COUNT___ FROM data WHERE " . $variableSQLUSLOV;
        */
        
        $this->area_year_month_dealercode_chain__SQL_condition_init( $group_type_left_or_right );
        
        $group_data_reference = "group_".$group_type_left_or_right."_data";
        $data_for_back = "<".$group_data_reference.">";
        $data_for_back .= $this->get_quantity_xml_data_for_array
        (
                array
                    (
                    array("column"=>"q6_1", "value"=>"1"), 
                    array("column"=>"q6_2", "value"=>"1"), 
                    array("column"=>"q6_3", "value"=>"1")
                    ), 
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q6_1");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["ReasonToVisit"]))
{
    new ReasonToVisit();
}
?>
