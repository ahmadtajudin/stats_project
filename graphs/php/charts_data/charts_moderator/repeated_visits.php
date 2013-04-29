<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RepeatedVisits extends ChartData
{
    public function RepeatedVisits()
    {
        parent::__construct();
        $this->print_back_to_client( $this );
    }
    public function get_data_for_group( $group_type_left_or_right )
    {
        $this->area_year_month_dealercode_chain__SQL_condition_init( $group_type_left_or_right );
        
        $group_data_reference = "group_".$group_type_left_or_right."_data";
        $data_for_back = "<".$group_data_reference.">";
        $data_for_back .= $this->get_quantity_xml_data_for_array
        (
                array
                    (
                    array("column"=>"Q17Α", "value"=>"0", "column_xml_additional_reference"=>"_0"), 
                    array("column"=>"Q17Α", "value"=>"1", "column_xml_additional_reference"=>"_1"), 
                    array("column"=>"Q17Α", "value"=>"2", "column_xml_additional_reference"=>"_2"), 
                    array("column"=>"Q17Α", "value"=>"3", "column_xml_additional_reference"=>"_3"), 
                    array("column"=>"Q17Α", "value"=>"4", "column_xml_additional_reference"=>"_4")
                    ), 
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("Q17Α");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["RepeatedVisits"]))
{
    new RepeatedVisits();
}
?>
