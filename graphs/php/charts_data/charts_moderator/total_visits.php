<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TotalVisits extends ChartData
{
    public function TotalVisits()
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
                    array("column"=>"q5b", "value"=>"1", "column_xml_additional_reference"=>"_1"), 
                    array("column"=>"q5b", "value"=>"2", "column_xml_additional_reference"=>"_2"), 
                    array("column"=>"q5b", "value"=>"3", "column_xml_additional_reference"=>"_3"), 
                    array("column"=>"q5b", "value"=>"4", "column_xml_additional_reference"=>"_4"),
                    array("column"=>"q5b", "value"=>"5", "column_xml_additional_reference"=>"_5"), 
                    array("column"=>"q5b", "value"=>"6", "column_xml_additional_reference"=>"_6"),  
                    array("column"=>"q5b", "value"=>"7", "column_xml_additional_reference"=>"_7")
                    ), 
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q5b");
        $data_for_back .= $this->get_data_xml_average("q5b");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["TotalVisits"]))
{
    new TotalVisits();
}
?>
