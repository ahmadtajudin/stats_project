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
    //const top_diagram = 200;
    private  static function top_diagram()
    {
        if($_SESSION["line_type_0"] == self::line_type_xNParts){return 270;}
        return 200;
    }
    const parce_diagram_width = 70;
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
    private  static function difference_top_position_between_lines()
    {
        return self::diagram_height()/(self::count_lines()+1);
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
        return '<div class="top_left_title">'.self::chart_title().'</div>';
    }
    private static function top_filter_results()
    {
        $group_A_details = explode(";", $_SESSION["groupADetails"]);
        $group_B_details = explode(";", $_SESSION["groupBDetails"]);
        $leftHTML = 
        '<div class="absolute" style="left:100px;top:50px; color:'.self::colorA.';">
                    <div>Group A</div>
                    <div>Αντιπρόσωποι:<b>'.$group_A_details[0].'</b></div>
                    <div>Αλυσίδα:<b>'.$group_A_details[1].'</b></div>
                    <div>Περιοχή:<b>'.$group_A_details[2].'</b></div>
                    <div>Περίοδος:<b>'.$group_A_details[3].'</b></div>
               </div>';
        $rightHTML =        
        '<div class="absolute" style="left:500px;top:50px; color:'.self::colorB.';">
                    <div>Group B</div>
                    <div>Αντιπρόσωποι:<b>'.$group_B_details[0].'</b></div>
                    <div>Αλυσίδα:<b>'.$group_B_details[1].'</b></div>
                    <div>Περιοχή:<b>'.$group_B_details[2].'</b></div>
                    <div>Περίοδος:<b>'.$group_B_details[3].'</b></div>
               </div>';
        if(!self::group_B_is_visible()){$rightHTML = "";}
        return  $leftHTML.$rightHTML;
    }
    
    private  static function titles_top_for_xNCharts()
    {
        if($_SESSION["line_type_0"] == self::line_type_simple_horizontal)
                        return '';
        return '
            <div class="absolute" style="left:'.self::left_diagram.'px;top:200px;">
                <img src="images/1.png" />&nbsp;&nbsp;Πολύ απογοητευμένος (1) &nbsp;&nbsp;&nbsp;&nbsp;
                <img src="images/2.png" />&nbsp;&nbsp;Απογοητευμένος (2) &nbsp;&nbsp;&nbsp;&nbsp;
                <img src="images/3.png" />&nbsp;&nbsp;Ικανοποιημένος (3)<br/>
                <img src="images/4.png" />&nbsp;&nbsp;Πολύ ικανοποιημένος (4) &nbsp;&nbsp;&nbsp;&nbsp;
                <img src="images/5.png" />&nbsp;&nbsp;Εξαιρετικά ικανοποιημένος (5)
            </div>
            ';
    }


    private static function draw_last_date_label()
    {
        return '<div class="last_date_label">'.$_SESSION["last_date_changed"].'</div>'; 
    }
    
    private static function  draw_line( $index )
    {
        if($_SESSION["line_type_".$index] == self::line_type_simple_horizontal)
        {
            return self::draw_line_line_type_simple_horizontal($index);
        }
        else if($_SESSION["line_type_".$index] == self::line_type_xNParts)
        {
            return self::draw_line_line_type_xNParts($index);
        }
        /*if(self::line_type() == self::line_type_simple_horizontal)
        {
            return self::draw_line_line_type_simple_horizontal($index);
        }
        else if(self::line_type() == self::line_type_xNParts)
        {
            return self::draw_line_line_type_xNParts($index);
        }*/
        return "<div>undefined lines</div>";
    }
    private  static function line_title_draw($index)
    {
        $line_top_position = ($index+1)*self::difference_top_position_between_lines()+self::top_diagram();
        $title_left_position = self::left_diagram-150;
        return '<div class="line_title_draw" style="left:'.$title_left_position.'px;top:'.$line_top_position.'px;">'.$_SESSION["line_label_".$index].'</div>';
    }
    private  static function draw_line_line_type_simple_horizontal($index)
    {
        if(!isset($_SESSION["width_A_".$index])){$_SESSION["width_A_".$index] = RAND(1);}
        if(!isset($_SESSION["width_B_".$index])){$_SESSION["width_B_".$index] = RAND(1);}
        $line_percent_width_A = $_SESSION["width_A_".$index];
        $line_percent_width_B = $_SESSION["width_B_".$index];
        
        $widthA = self::diagram_width()*$line_percent_width_A;
        $widthB = self::diagram_width()*$line_percent_width_B;
        
        $line_top_position = ($index+1)*self::difference_top_position_between_lines()+self::top_diagram();
        
        $labelPercentLeftA = self::left_diagram+$widthA;
        $labelPercentLeftB = self::left_diagram+$widthB;
        
        $percentA = number_format($line_percent_width_A*100, 0);
        $percentB = number_format($line_percent_width_B*100, 0);
        
        if(!self::group_B_is_visible())
        {
            return 
            self::line_title_draw($index).'
                <div class="absolute line_horizontal_A" style="left:'.self::left_diagram.'px; top:'.$line_top_position.'px; width:'.$widthA.'px;"></div>
                <div class="line_horizontal_percent_right" style="left:'.$labelPercentLeftA.'px; top:'.$line_top_position.'px;">'.$percentA.'%</div>
                    ';
        }
        else
        {
            $line_top_positionA = $line_top_position-15;
            $line_top_positionB = $line_top_position+15;
            return 
            self::line_title_draw($index).'
                <div class="absolute line_horizontal_A" style="left:'.self::left_diagram.'px; top:'.$line_top_positionA.'px; width:'.$widthA.'px;"></div>
                <div class="line_horizontal_percent_right" style="left:'.$labelPercentLeftA.'px; top:'.$line_top_positionA.'px;">'.$percentA.'%</div>
                    
                <div class="absolute line_horizontal_B" style="left:'.self::left_diagram.'px; top:'.$line_top_positionB.'px; width:'.$widthB.'px;"></div>
                <div class="line_horizontal_percent_right" style="left:'.$labelPercentLeftB.'px; top:'.$line_top_positionB.'px;">'.$percentB.'%</div>
                    ';
        }
        
        return '<div>draw_line_line_type_simple_horizontal, undefiend</div>';
    }
    private static function draw_line_line_type_xNParts($index)
    {
        $line_top_position = ($index+1)*self::difference_top_position_between_lines()+self::top_diagram();
        $index_plus_1 = $index + 1;
        //$sessijaa_temp_label = $_SESSION["line_label_".$index];
        $_SESSION["line_label_".$index] = "(".$index_plus_1.")".$_SESSION["line_label_".$index];
        if(!self::group_B_is_visible())
        {
            return self::line_title_draw($index).self::draw_line_line_type_xNParts_get_line($_SESSION["width_A_".$index], $line_top_position, false);
        }
        else
        {
            $line_top_positionA = $line_top_position - 15;
            $line_top_positionB = $line_top_position + 15;
            return 
            self::line_title_draw($index).self::draw_line_line_type_xNParts_get_line($_SESSION["width_A_".$index], $line_top_positionA, false).
            self::draw_line_line_type_xNParts_get_line($_SESSION["width_B_".$index], $line_top_positionB, true);
        }
        //$_SESSION["line_label_".$index] = $sessijaa_temp_label;
    }
    private  static function draw_line_line_type_xNParts_get_line($width_details, $line_top_position, $isB)
    {
        $array_colors = array("#339966","#99cc00","#ffff00","#ff9900","#ff0000");
        $array_percents = explode(";", $width_details);
        $left_parce_position = self::left_diagram;
        $classForB = "";
        if($isB)
        {
            $classForB = "parce_for_xNLineB";
        }
        $html_line = "";
        for($i=count($array_percents)-1;$i>=0;$i--)
        {
            $width_parce = $array_percents[$i]*self::diagram_width();
            $percent_100 = number_format($array_percents[$i]*100, 1);
            if($percent_100 > 3){$percent_100 = $percent_100."%";}
            else{$percent_100 = "";}
            $html_line .= 
            '<div class="parce_for_xNLine '.$classForB.'" style="left:'.$left_parce_position.'px;top:'.$line_top_position.'px;width:'.$width_parce.'px;background-color:'.$array_colors[4-$i].';">
            '.$percent_100.'    
            </div>';
            
            $left_parce_position += $width_parce;
        }
        return $html_line;
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
            $html_base_chart .= DomPDFTool::draw_rectangle($left_position, self::top_diagram(), self::parce_diagram_width, 
                    self::diagram_height(), $bg_color);
            if($i%2==0)
            {
                $html_base_chart .= DomPDFTool::draw_rectangle($left_position, self::top_diagram()+self::diagram_height(), 2, 7, "#3873b7");
                $html_base_chart .= DomPDFTool::add_text_absolute($left_position-5, self::top_diagram()+self::diagram_height()+2, $percent_for_chart, "#3873b7");
                $percent_for_chart += 20;
            }
        }
        
        for($i=0;$i<self::count_lines();$i++)
        {
            $html_base_chart .= self::draw_line( $i );
        }
        
        $html_base_chart .= DomPDFTool::draw_rectangle(self::left_diagram, self::top_diagram(), 2, self::diagram_height()+5, "#3873b7");
        $html_base_chart .= DomPDFTool::draw_rectangle(self::left_diagram-5, self::top_diagram()+self::diagram_height(), self::diagram_width()+5, 2, "#3873b7");
       //return '<div class="top_left_title">Λόγοι Επίσκεψης</div>'; 
        
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
        $passby_interviews_data = explode(";", $_SESSION["passByData".$is_for_group]);
        $top_position = self::top_diagram()+self::diagram_height()+50;
        return '<div class="absolute" style="left:'.$left.'px;top:'.$top_position.'px;font-size:14px;">
                    <div style="color:'.$color.';">Group '.$is_for_group.'</div>
                    <div>Σύνολο συνεντεύξεων:<b style="color:'.$color.';">'.$passby_interviews_data[0].'</b></div>
                    <div>Σύνολο διελέυσεων:<b style="color:'.$color.';">'.$passby_interviews_data[1].'</b></div>
                </div>';
    }

    public static function draw()
    {
        return self::top_left_title().self::top_filter_results().self::draw_last_date_label().self::titles_top_for_xNCharts().
            self::draw_chart().self::draw_filter_details(self::GROUP_A).self::draw_filter_details(self::GROUP_B);
    }
    
    //////////////////////////////////////////////////////////////////////////////
    public static function ADD_DATA_INTO_SESSION()
    {
        $_SESSION["chart_title"] = $_POST["chart_title"];
        $_SESSION["diagram_height"] = $_POST["diagram_height"];
        $_SESSION["count_lines"] = $_POST["count_lines"];
        
        $_SESSION["groupADetails"] = $_POST["groupADetails"];
        $_SESSION["groupBDetails"] = $_POST["groupBDetails"];
        
        $_SESSION["last_date_changed"] = $_POST["last_date_changed"];
        
        //$_SESSION["line_type"] = $_POST["line_type"];
        //group_B_is_visible is 0 or 1
        $_SESSION["group_B_is_visible"] = $_POST["group_B_is_visible"];
        
        for($i=0;$i<15;$i++)
        {
            if(isset($_SESSION["width_A_".$i]))unset($_SESSION["width_A_".$i]);
            if(isset($_SESSION["width_B_".$i]))unset($_SESSION["width_B_".$i]);
        }
            
        for($i=0;$i<$_SESSION["count_lines"];$i++)
        {
            //for simple lines give percent of width, from 0 to 1
            //for xN lines it gives data 1-5[percent;percent;percent;percent;percent]
            $_SESSION["width_A_".$i] = $_POST["width_A_".$i];
            $_SESSION["width_B_".$i] = $_POST["width_B_".$i];
            $_SESSION["line_type_".$i] = $_POST["line_type_".$i];
            $_SESSION["line_label_".$i] = $_POST["line_label_".$i];
        }
        
        $_SESSION["passByDataA"] = $_POST["passByDataA"];
        $_SESSION["passByDataB"] = $_POST["passByDataB"];
        
        print_r($_SESSION);
    }
}

if(isset($_POST["ADD_DATA_INTO_SESSION"]))
{
    ChartDrawer::ADD_DATA_INTO_SESSION();
}
?>