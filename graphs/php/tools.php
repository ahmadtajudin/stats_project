<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class DataModerator
{
    public function DataModerator()
    {
    } 
    public function get_xml_data_for_all_rows($data_rows, $root_xml_data_name="root", $child_xml_data_name="item") 
    {
        $xml_data = "<".$root_xml_data_name.">";
        for($i = 0; $i < count($data_rows); $i++) 
        {  
            $xml_data .= $this->get_xml_data_for_single_row($data_rows[$i], $child_xml_data_name);
        }
        $xml_data .= "</".$root_xml_data_name.">";
        return $xml_data;
    }
    public function get_xml_data_for_single_row($data_single_row, $root_xml_data_name="item")
    {
        $xml_data = "<".$root_xml_data_name.">";
        foreach ($data_single_row as $key => $value) 
        {
            $xml_data .= "<" . $key . "><![CDATA[" . $value . "]]></" . $key . ">";
        }
        $xml_data .= "</".$root_xml_data_name.">"; 
        return $xml_data;
    }
}

class ChartData extends DataModerator
{
    public function ChartData()
    {
    }
}
?>
