<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * ΣΤΟ ΜΈΛΛΟΝ(vo idnina)
 * u1. Θα πάτε ξανά στο συγκεκριμένο συνεργείο για κάποια μελλοντική εργασία;(U1. Ќе се вратиме на оваа работилница за некои идни работа?)
 * u2. Θα συνιστούσατε τα αυτοκίνητα της Hyundai στην οικογένειά σας και στους φίλους σας;(U2. Дали ви препорачуваме автомобилите на Hyundai во вашето семејство и пријатели?)
 * u3. Θα αγοράζατε ξανά ένα αυτοκίνητο Hyundai;(U3. Ќе купи автомобил повторно Хјундаи;)
 */
class InFuture extends ChartData 
{
    public function InFuture()
    {
        parent::__construct();
        $this->print_back_to_client( $this );
    }
    public function  get_data_for_group($group_type_left_or_right)
    {
        $this->area_year_month_dealercode_chain__SQL_condition_init( $group_type_left_or_right );
        
        $group_data_reference = "group_".$group_type_left_or_right."_data";
        $data_for_back = "<".$group_data_reference.">";
        $data_for_back .= $this->get_quantity_xml_data_for_array
        (
                array
                    (
                    array("column"=>"u1", "value"=>"1", "column_xml_additional_reference"=>""), 
                    array("column"=>"u2", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"u3", "value"=>"1", "column_xml_additional_reference"=>"")
                    ), 
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q7");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["InFuture"]))
{
    new InFuture();
}
?>
