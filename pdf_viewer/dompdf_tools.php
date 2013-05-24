<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
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
    const line_type_simple_horizontal="line_type_simple_horizontal";
    const line_type_xNParts="line_type_xNParts";
    const colorA = "#f89876";
    const colorB = "#0166f6";
    const GROUP_A="A";
    const GROUP_B="B";
    const left_diagram = 150;
    const top_diagram = 200;
    const parce_diagram_width = 80;
    private static function diagram_height()
    {
        if(isset($_SESSION["diagram_height"])){return $_SESSION["diagram_height"];}
        return 600;
    }
    private  static function diagram_width()
    {
        return 10*self::parce_diagram_width;
    }
    private static function count_lines()
    {
        if(isset($_SESSION["count_lines"])){return $_SESSION["count_lines"];}
        return 4;
    }
    /*private  static function line_type()
    {
        if(isset($_POST["line_type"]))
        {
            return $_POST["line_type"];
        }
        return self::line_type_simple_horizontal;
    }*/
    private static function group_B_is_visible()
    {
        if(isset($_SESSION["group_B_is_visible"])){return $_SESSION["group_B_is_visible"]=="1";}
        return true;
    }
    private static function chart_title()
    {
        if(isset($_SESSION["chart_title"])){return $_SESSION["chart_title"];}
        return "undefined";
    }


    private  static function top_left_title()
    {
        return '<div class="top_left_title">Λόγοι Επίσκεψης</div>';
    }
    private static function top_filter_results()
    {
        return '<div class="absolute" style="left:100px;top:50px; color:'.self::colorA.';">
                    <div>Group A</div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
                    <div>Αντιπρόσωποι:<b>10081-ΜΑΝΘΑΤΗΣ (ΑΓΡΙΝΙΟ)</b></div>
               </div>
               <div class="absolute" style="left:500px;top:50px; color:'.self::colorB.';">
                    <div>Group B</div>
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
    
    private static function  draw_line( $index )
    {
        /*if(self::line_type() == self::line_type_simple_horizontal)
        {
            return self::draw_line_line_type_simple_horizontal($index);
        }
        else if(self::line_type() == self::line_type_xNParts)
        {
            return self::draw_line_line_type_xNParts($index);
        }*/
        return "";
    }
    private  static function draw_line_line_type_simple_horizontal($index)
    {
        if(!isset($_SESSION["width_A_".$index])){$_SESSION["width_A_".$index] = RAND(1);}
        if(!isset($_SESSION["width_B_".$index])){$_SESSION["width_B_".$index] = RAND(1);}
        $line_percent_width_A = $_SESSION["width_A_".$index];
        $line_percent_width_B = $_SESSION["width_B_".$index];
        return '';
    }
    private static function draw_line_line_type_xNParts($index)
    {
        
    }

    private static function draw_chart()
    {
        $height_parce_diagram = 200;
        $html_base_chart = "";
        $percent_for_chart = 0;
        //drawing the parts of the diagram
        for($i=0;$i<=10;$i++)
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
            if($i<10)
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
        
        for($i=0;$i<self::count_lines();$i++)
        {
            self::draw_line( $i );
        }
        
        return $html_base_chart;
    }

    private  static function draw_filter_details($is_for_group)
    {
        $color = self::colorA;
        $left = 100;
        if($is_for_group == self::GROUP_B)
        {
            $color = self::colorB;
            $left = 400;
        }
        $top_position = self::top_diagram+self::diagram_height()+50;
        return '<div class="absolute" style="left:'.$left.'px;top:'.$top_position.'px;font-size:14px;">
                    <div style="color:'.$color.';">Group '.$is_for_group.'</div>
                    <div>Σύνολο συνεντεύξεων:<b style="color:'.$color.';">2000</b></div>
                    <div>Σύνολο διελέυσεων:<b style="color:'.$color.';">10000</b></div>
                </div>';
    }

    public static function draw()
    {
        return self::top_left_title().self::top_filter_results().self::draw_last_date_label().
            self::draw_chart().self::draw_filter_details(self::GROUP_A).self::draw_filter_details(self::GROUP_B);
    }
    
    //////////////////////////////////////////////////////////////////////////////
    public static function ADD_DATA_INTO_SESSION()
    {
        $_SESSION["diagram_height"] = $_POST["diagram_height"];
        $_SESSION["count_lines"] = $_POST["count_lines"];
        //$_SESSION["line_type"] = $_POST["line_type"];
        //group_B_is_visible is 0 or 1
        $_SESSION["group_B_is_visible"] = $_POST["group_B_is_visible"];
        for($i=0;$i<$_SESSION["count_lines"];$i++)
        {
            //for simple lines give percent of width, from 0 to 1
            //for xN lines it gives data 1-5[percent;percent;percent;percent;percent]
            $_SESSION["width_A_".$i] = $_POST["width_A_".$i];
            $_SESSION["width_B_".$i] = $_POST["width_B_".$i];
            $_SESSION["line_type_".$i] = $_POST["line_type_".$i];
            $_SESSION["line_label_".$i] = $_POST["line_label_".$i];
        }
        print_r($_SESSION);
    }
}

if(isset($_POST["ADD_DATA_INTO_SESSION"]))
{
    ChartDrawer::ADD_DATA_INTO_SESSION();
}
?>