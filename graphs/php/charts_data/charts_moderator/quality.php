<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * ΠΟΙΌΤΗΤΑ(Quality)
 * e1) Παρακαλώ αξιολογήστε την εμπιστοσύνη σας στις εργασίες που πραγματοποιήθηκαν στο αυτοκίνητο σας κατά τη διάρκεια του τελευταίου service.
 * (Е1) Ве молиме дадете вашата доверба во работата на вашиот автомобил во текот на последните услуга.)
 * e2) Σε ποιο βαθμό ολοκληρώθηκαν οι εργασίες που ζητήσατε;(Е2) До кој степен делата ќе побара?)
 * 
 * Διερευνητικές Ερωτήσεις(прелиминарни прашања)
 * e3. Πώς θα αξιολογούσατε την καθαριότητα του οχήματός σας μετά  το service ή  την επισκευή;
 * (Е3. Како вие ја оценувате чистотата на вашето возило по услуга или поправка?)
 * e4. Παρακαλώ βαθμολογήστε την εμπιστοσύνη σας στην τεχνική κατάρτιση της αντιπροσωπείας:
 * (е4. Ве молиме дадете вашата доверба во техничка обука на делегацијата:)
 */
class Quality extends ChartData
{
    public function Quality()
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
                    array("column"=>"e1", "column_xml_additional_reference"=>""),
                    array("column"=>"e2", "column_xml_additional_reference"=>""),
                    array("column"=>"e3", "column_xml_additional_reference"=>""),
                    array("column"=>"e4", "column_xml_additional_reference"=>"")
                    ), 
                array("from"=>"1", "to"=>"5"),
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q7");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["Quality"]))
{
    new Quality();
}
?>
