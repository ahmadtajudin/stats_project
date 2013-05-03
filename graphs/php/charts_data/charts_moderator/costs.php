<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * ΚΌΣΤΗ(Trosoci)
 * Ζ1) Από άποψη κόστους, παρακαλώ αξιολογήστε την υπηρεσία που λάβατε(Z1) Во однос на цената, ве молиме стапка на услуга, која доби)
 * 
 * Διερευνητικές Ερωτήσεις(прелиминарни прашања)
 * Ζ2. Παροχή σαφών πληροφοριών σχετικά με το κόστος πριν την έναρξη της εργασίας;(Z2. Обезбеди јасни информации за цената пред отпочнување на работа?)
 * Ζ3. Επεξήγηση των εργασιών που έγιναν;(Z3. Објаснување на работа?)
 * Ζ4. Πόσο λογικό ήταν το κόστος των εργασιών και των ανταλλακτικών;(Z4. Како разумен беше на трошоците за работа и делови?)
 * Ζ5. Επεξήγηση των χρεώσεων του service?(Z5. Објаснување на платежна услуга?)
 * Z6. Επεξήγηση του μελλοντικού προγραμμάτος συντήρησης και επισκευής;(Z6. Објаснување на идната програма за одржување и поправка?)
 */
class Costs extends ChartData  
{
    public function Costs()
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
                    array("column"=>"Z1", "column_xml_additional_reference"=>""),
                    array("column"=>"Z2", "column_xml_additional_reference"=>""),
                    array("column"=>"Z3", "column_xml_additional_reference"=>""),
                    array("column"=>"Z4", "column_xml_additional_reference"=>""),
                    array("column"=>"Z5", "column_xml_additional_reference"=>""),
                    array("column"=>"Z6", "column_xml_additional_reference"=>"")
                    ), 
                array("from"=>"1", "to"=>"5"),
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q7");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    } 
}
if(isset($_POST["Costs"]))
{
    new Costs();
}
?>
