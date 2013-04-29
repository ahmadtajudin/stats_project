<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * ΣΕ ΠΕΡΊΠΤΩΣΗ ΠΟΥ ΧΡΕΙΆΣΤΗΚΕ ΝΑ ΕΠΙΣΤΡΈΨΕΤΕ ΣΤΗΝ ΑΝΤΙΠΡΟΣΩΠΕΊΑ ΓΙΑ ΕΠΙΠΛΈΟΝ ΕΡΓΑΣΊΑΣ
 * (Во случај ми требаше да се вратат на делегацијата дополнителна работа)
 * одговори:
 * e61 Δεν ήταν αρκετός ο χρόνος / το πρόγραμμα ήταν γεμάτο(E61 не беше доволно време / програмата беше полн)
 * e62 Δεν μπορούσαν να βρουν το πρόβλημα(E62 Тие не можеа да се најдат на проблемот)
 * e63 Δεν ήταν διαθέσιμα τα ανταλλακτικά(E63 не беше достапен резервни)
 * e64 Τα ανταλλακτικά που χρησιμοποιήθηκαν ήταν ελαττωματικά(на E64 деловите употребени биле неисправни)
 * e65 Το τμήμα του service δεν μπόρεσε να βρει το πρόβλημα την πρώτη φορά(E65 На дел од услугата не може да се најде на проблемот прв пат)
 * e66 Το τμήμα του service επιχείρησε την επισκευή αλλά δεν διόρθωσε το πρόβλημα(E66 На дел од услугата обиде да се поправи, но не го поправите проблемот)
 * e67 Το πρόβλημα διορθώθηκε αλλά παρουσιάστηκε άλλο πρόβλημα(e67 Проблемот коригира, но има уште еден проблем)
 * e68 Άλλος λόγος(E68 Друга причина)
 */
class InCaseWhenBackForAdditionalWork extends ChartData
{
    public function InCaseWhenBackForAdditionalWork()
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
                    array("column"=>"e61", "value"=>"1", "column_xml_additional_reference"=>""), 
                    array("column"=>"e62", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"e63", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"e64", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"e65", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"e66", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"e67", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"e68", "value"=>"1", "column_xml_additional_reference"=>"")
                    ), 
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q7");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["InCaseWhenBackForAdditionalWork"]))
{
    new InCaseWhenBackForAdditionalWork();
}
?>
