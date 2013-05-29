<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * FOLLOW UP
 * h1. Πως θα αξιολογούσατε την επικοινωνία που είχατε με την αντιπροσωπεία από το τελευταίο service / επισκευή που είχατε;
 * (Н1. Како вие ја оценувате комуникација сте имале со делегација од последната услуга / поправка дека сте имале?)
 * h5. Πώς θα αξιολογούσατε τον τρόπο που αντιμετωπίστηκε το θέμα σας;
 * (Х5. Како вие ја оценувате начинот на кој ќе се обрати вашиот проблем?)
 */
class FollowUp extends ChartData 
{
    public function FollowUp()
    {
        parent::__construct();
        $this->print_back_to_client( $this );
    }
    public function  get_data_for_group($group_type_left_or_right)
    {
        $this->area_year_month_dealercode_chain__SQL_condition_init( $group_type_left_or_right );
        
        $group_data_reference = "group_".$group_type_left_or_right."_data";
        $data_for_back = "<".$group_data_reference.">";
        $data_for_back .= $this->get_counts_for_parts
        (
                array
                    (
                    array("column"=>"h1", "column_xml_additional_reference"=>""),
                    array("column"=>"h5", "column_xml_additional_reference"=>"")
                    ), 
                array("from"=>"1", "to"=>"5"),
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("h1");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["FollowUp"]))
{
    new FollowUp();
}
?>
