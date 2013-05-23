<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//session_start();
//$_SESSION["html_temp_for_pdf"] = $_POST["html_temp_for_pdf"];
class DomPDFTool
{
    public static function add_text_absolute($left, $top, $text, $color)
    {
        return '<div class="absolute" style="left:'.$left.'px;top:'.$top.'px; color:'.$color.';">'.$text.'</div>';
    }
    public static function draw_rectangle($left, $top, $width, $height, $bgcolor)
    {
        return 
        '<div class="absolute" style="left:'.$left.'px;top:'.$top.'px;width:'.$width.'px;height:'.$height.'px;background-color:'.$bgcolor.';"></div>';
    }
}

class ChartDrawer
{
    const colorA = "#f89876";
    const colorB = "#0166f6";
    const GROUP_A="A";
    const GROUP_B="B";
    const left_diagram = 100;
    const top_diagram = 200;
    const parce_diagram_width = 70;
    private static function diagram_height()
    {
        if(isset($_POST["diagram_height"])){return $_POST["diagram_height"];}
        return 600;
    }
    private  static function diagram_width()
    {
        return 10*self::parce_diagram_width;
    }


    private  static function top_left_title()
    {
        return '<div class="top_left_title">Λόγοι Επίσκεψης</div>';
    }
    private static function top_filter_results()
    {
        return '<div class="absolute" style="left:100px;top:50px;">
                    <div>rectangle</div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
               </div>
               <div class="absolute" style="left:400px;top:50px;">
                    <div>rectangle</div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
               </div>';
    }
    private static function draw_last_date_label()
    {
        return '<div class="last_date_label">Τελευταία ενσωμάτωση δεδομένων: Μάρτιος 2013</div>'; 
    }
    private static function draw_chart()
    {
        $height_parce_diagram = 200;
        $html_base_chart = "";
        $percent_for_chart = 0;
        //drawing the parts of the diagram
        for($i=0;$i<10;$i++)
        {
            if($i%2==0)
            {
                $bg_color = "#e4f1fb";
            }
            else
            {
                $bg_color = "#f7fafd";
            }
            $left_position = $i*self::parce_diagram_width+self::left_diagram;
            $html_base_chart .= DomPDFTool::draw_rectangle($left_position, self::top_diagram, self::parce_diagram_width, 
                    self::diagram_height(), $bg_color);
            if($i%2==0)
            {
                $html_base_chart .= DomPDFTool::draw_rectangle($left_position, self::top_diagram+self::diagram_height(), 2, 7, "#3873b7");
                $html_base_chart .= DomPDFTool::add_text_absolute($left_position-5, self::top_diagram+self::diagram_height()+2, $percent_for_chart, "#3873b7");
                $percent_for_chart += 20;
            }
        }
        $html_base_chart .= DomPDFTool::draw_rectangle(self::left_diagram, self::top_diagram, 2, self::diagram_height()+5, "#3873b7");
        $html_base_chart .= DomPDFTool::draw_rectangle(self::left_diagram-5, self::top_diagram+self::diagram_height(), self::diagram_width()+5, 2, "#3873b7");
       //return '<div class="top_left_title">Λόγοι Επίσκεψης</div>'; 
        return $html_base_chart;
    }

    private  static function draw_filter_details($is_for_group)
    {
        $color = self::colorB;
        if($is_for_group == self::GROUP_A)
        {
            $color = self::colorA;
        }
        $top_position = self::top_diagram+self::diagram_height()+20;
        return '<div class="absolute" style="top:'.$top_position.'px;font-size:14px;">
                    <div style="color:'.$color.';">Group A</div>
                    <div>Σύνολο συνεντεύξεων:<b>2000</b></div>
                    <div>Σύνολο διελέυσεων:<b>10000</b></div>
                </div>';
    }

    public static function draw()
    {
        return self::top_left_title().self::top_filter_results().self::draw_last_date_label().
            self::draw_chart().self::draw_filter_details(self::GROUP_A).self::draw_filter_details(self::GROUP_B);
    }
}
?>
