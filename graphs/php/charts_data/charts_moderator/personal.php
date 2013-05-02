<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Προσωπικό(Personal)
 * c1) Πως θα αξιολογούσατε το προσωπικό του συγκεκριμένου συνεργείου(Ц1) Како вие ја оценувате персоналот на оваа работилница)
 * c2) Αισθανθήκατε ότι σας αντιμετώπισαν σαν ένα σημαντικό πελάτη; (В2) Вие сте почувствувале дека сте ме третира како важен клиент?)
 * 
 * Διερευνητικές Ερωτήσεις(прелиминарни прашања)
 * c3. Πώς θα αξιολογούσατε την φιλικότητα του προσωπικού;(C3. Како вие ја оценувате стил на персоналот?)
 * c4. Πώς θα αξιολογούσατε την εξυπηρέτηση του προσωπικού;(C4. Како вие ја оценувате услугата персоналот?)
 * c5. Την ειλικρίνεια και την αξιοπιστία τους;(c5. Чесност и кредибилитет?)
 * c6. Τον χειρισμό των τηλεφωνικών ερωτήσεων;(C6. Ракување на телефонски прашања?)
 * c7. Την προθυμία να ακούσουν και να κατανοήσουν τα προβλήματα;(C7. Подготвеност да се слуша и да се разбере проблеми?)
 * c8. Την επεξήγηση της εργασίας που πρέπει να γίνει;(В8. Објаснување на работа да се направи?)
 * c9. Την ικανότητα τους να διαγνώσουν προβλήματα;(C9. Нивната способност да дијагностицирање на проблемите?)
 */
class Personal extends ChartData
{
    public function Personal()
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
                    array("column"=>"c1", "column_xml_additional_reference"=>""),
                    array("column"=>"c2", "column_xml_additional_reference"=>""),
                    array("column"=>"c3", "column_xml_additional_reference"=>""),
                    array("column"=>"c4", "column_xml_additional_reference"=>""),
                    array("column"=>"c5", "column_xml_additional_reference"=>""),
                    array("column"=>"c6", "column_xml_additional_reference"=>""),
                    array("column"=>"c7", "column_xml_additional_reference"=>""),
                    array("column"=>"c8", "column_xml_additional_reference"=>""),
                    array("column"=>"c9", "column_xml_additional_reference"=>"")
                    ), 
                array("from"=>"1", "to"=>"5"),
        "quantity");
        $data_for_back .= $this->get_data_xml_total_passby_and_interviews("q7");
        $data_for_back .= "</".$group_data_reference.">";
        return $data_for_back;
    }
}
if(isset($_POST["Personal"]))
{
    new Personal();
}
?>
