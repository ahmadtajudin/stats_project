<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Εγκαταστάσεις(Објекти)
 * b1 Πως θα αξιολογούσατε τις εγκαταστάσεις του συγκεκριμένου συνεργείου. 
 (б1 Како вие ја оценувате објекти на оваа работилница.)
 * 
 * Διερευνητικές Ερωτήσεις(прелиминарни прашања)
 * b2. Πώς θα αξιολογούσατε την εμφάνιση του τμήματος Service;(Б2. Како вие ја оценувате изгледот на делот служба;)
 * b3. Την άνεση του χώρου αναμονής (π.χ. καθίσματα, μηχανές καφέ, κλπ….)(Б3. Удобноста на чекање област (на пример, седишта, кафе машини, итн ....))
 * b4. Τη γενική καθαριότητα της αντιπροσωπείας;(b4. Општата чистотата на делегацијата?)
 * b5. Την ευκολία στάθμευσης;(b5. Леснотијата на паркинг?)
 */
class Objects extends ChartData
{
    public function Objects()
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
                    array("column"=>"b1", "column_xml_additional_reference"=>""), 
                    array("column"=>"b2", "column_xml_additional_reference"=>""), 
                    array("column"=>"b3", "column_xml_additional_reference"=>""), 
                    array("column"=>"b4", "column_xml_additional_reference"=>""), 
                    array("column"=>"b5", "column_xml_additional_reference"=>"")
                    ), 
                array("from"=>"1", "to"=>"5"),
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("b1");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["Objects"]))
{
    new Objects();
}
?>
