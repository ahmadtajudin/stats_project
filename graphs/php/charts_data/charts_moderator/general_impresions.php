<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Γενικές Εντυπώσεις
 * Генерални Импресии
 * General Impresions
 * q7. Συνολικά, πόσο ικανοποιημένος μείνατε με την εμπειρία σας σε από αυτό το εξουσιοδοτημένο συνεργείο;
 (Q7. Генерално, колку се задоволни бевте со вашето искуство во овој овластени работилница?)
 * q8.Με βάση την εμπειρία σας από το συγκεκριμένο συνεργείο πόσο πιθανό θα ήταν να συστήσετε το συγκεκριμένο συνεργείο σε κάποιον φίλο σας /γνωστό σας / συγγενή σας
 * (q8.Me вашето искуство на оваа работилница како најверојатно би им препорачале оваа работилница на пријател / познаник / роднина)
 */
class GeneralImpresions extends ChartData
{
    public function GeneralImpresions()
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
                    array("column"=>"q7", "column_xml_additional_reference"=>""), 
                    array("column"=>"q8", "column_xml_additional_reference"=>"")
                    ), 
                array("from"=>"1", "to"=>"5"),
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q7");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["GeneralImpresions"]))
{
    new GeneralImpresions();
}
?>
