<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Θέματα Χρόνου(Questions on time)
 * 
 * d1) Τύχατε της προσοχή του προσωπικού (σας είχε το προσωπικό στο νού του)καθ’ όλη την διάρκεια της επίσκεψης σας; 
 * (D1) ја зема вниманието на персонал (имавме кадар во неговиот ум) во текот на времетраењето на Вашата посета?)
 * 
 * Διερευνητικές Ερωτήσεις(Preliminarni prasanja)
 * d2. Πώς θα αξιολογούσατε την ευκολία να κλείσετε ραντεβού;(D2. Како вие ја оценувате леснотијата да се резервира закажете состанок?)
 * d3. Την προσοχή που σας δόθηκε κατά την άφιξή σας;(Д3. Внимание се посветува и на Ваше пристигнување?)
 * d4. Τον χρόνο αναμονής όταν πήρανε το όχημά σας;(d4. Време на чекање, кога тие се на вашето возило?)
 * d5. Την ικανότητα τους να ανταποκριθούν στο χρονοδιάγραμμα που σας είχαν δώσει αρχικά;(d5. Нивната способност да ги задоволи распоред дека сте имале првично дадена?)
 * d6. τον συνολικό χρόνο που απαιτήθηκε ώστε να ολοκληρωθεί το service του οχήματός σας;(d6. вкупното време потребно да се заврши во служба на вашето возило?)
 * d7. Την ευελιξία της αντιπροσωπείας να σας κλείσει το ραντεβού που θέλατε;(D7. Флексибилност на делегацијата ќе книга вашето назначување што сакавте?)
 * d8. Την ευκολία ωραρίου;(D8. Леснотијата часа?)
 */
class QuestionsOnTime extends ChartData
{
    public function QuestionsOnTime()
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
                    array("column"=>"d1", "value"=>"1", "column_xml_additional_reference"=>""), 
                    array("column"=>"d2", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"d3", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"d4", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"d5", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"d6", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"d7", "value"=>"1", "column_xml_additional_reference"=>""),
                    array("column"=>"d8", "value"=>"1", "column_xml_additional_reference"=>"")
                    ), 
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q7");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["QuestionsOnTime"]))
{
    new QuestionsOnTime();
}
?>
