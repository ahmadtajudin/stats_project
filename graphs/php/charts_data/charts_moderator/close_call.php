<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * ΚΛΕΊΣΙΜΟ ΚΛΉΣΗΣ(blisku povik)
 * i1. Πώς θα αξιολογούσατε την συνολική ποιότητα του αυτοκινήτου σας;(i1. Како вие ја оценувате целокупниот квалитет на вашиот автомобил?)
 * i2. Θα ήθελα να μου πείτε συνολικά για την μάρκα HYUNDAI σε σχέση με άλλες μάρκες που ξέρετε, θα λέγατε ότι είναι μια άριστη μάρκα
 * (I2. Јас би рекол мојот Вкупно за брендот HYUNDAI во однос на другите брендови кои знаете, дали би рекле дека е одличен бренд)
 */
class CloseCall extends ChartData
{
    public function CloseCall()
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
                    array("column"=>"i1", "value"=>"1", "column_xml_additional_reference"=>""), 
                    array("column"=>"i2", "value"=>"1", "column_xml_additional_reference"=>"")
                    ), 
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q7");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["CloseCall"]))
{
    new CloseCall();
}
?>
