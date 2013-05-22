<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Επικοινωνία πελάτη με αντιπροσωπεία
 * 
H3-BC column: Υπήρξαν θέματα για τα οποία χρειάστηκε να επικοινωνήσετε με την αντιπροσωπεία μετά το τελευταίο service που κάνατε;
 * Имаше прашања што мораше да се јавите на Застапништва по последната услуга што направи? 
H4-BD column: Λύθηκαν τα θέματα σας;
 * Реши вашите проблеми?

do not use H3,4 in chart ;-)
h3, h4 replies are 1= yes, 2 = no.
 */

class ContactClientDelegation extends ChartData
{
    public function ContactClientDelegation()
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
                    array("column"=>"h3", "value"=>"1", "column_xml_additional_reference"=>""), 
                    array("column"=>"h4", "value"=>"1", "column_xml_additional_reference"=>"")
                    ), 
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("h3");
        //$data_for_back .= $this->get_data_xml_average("q5b");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["ContactClientDelegation"]))
{
    new ContactClientDelegation();
}

?>
