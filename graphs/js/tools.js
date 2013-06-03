function Eventor()
{
    this.events = [];
    this.add_event = function(type, f)
    {
        this.set_events_array(type);
        this.events[type].push(f);
    }
    this.remove_event = function(type, f)
    {
    }
    this.dispatch_event = function(type, data)
    {
        this.set_events_array(type);
        for (var i = 0; i < this.events[type].length; i++)
        {
            this.events[type][i](data);
        }
    }
    this.set_events_array = function(type)
    {
        if (this.events[type] == null)
            this.events[type] = [];
    }
} 

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function Animator(){}
Animator.SPEED_ANIMATION = 500;

function Point(x,y)
{
    this.x = x;
    this.y = y;
}
function Rectangle(x,y,w,h)
{
    this.x = x;
    this.y = y;
    this.w = w;
    this.h = h;
}
function ResizerPozicioner(){}
ResizerPozicioner.resize = function(element_id_or_class, rect_size)
{
    $(element_id_or_class).width(rect_size.w);
    $(element_id_or_class).height(rect_size.h);
}
ResizerPozicioner.pozicion = function(element_id_or_class, point_pozicion)
{
    $(element_id_or_class).css("left", point_pozicion.x + "px");
    $(element_id_or_class).css("top", point_pozicion.y + "px");
}
ResizerPozicioner.resize_pozicion = function(element_id_or_class, rect_size_position)
{
    ResizerPozicioner.resize(element_id_or_class, rect_size_position);
    ResizerPozicioner.pozicion(element_id_or_class, new Point(rect_size_position.x, rect_size_position.y));
}

function ChartLineBase()
{
    /*
     * 
     * @type Boolean
     * It is adding false, when line is first of the array of chart.
     * In another case stay false.
     */
    this.isTopMain = false;
    
    this.average_A = "-";
    this.average_B = "-";
    
    /*
     * 
     * @type String
     * It will hold part html for parsing for the 
     * pdf printing.
     * It will hold N=XXX, or C=XXX
     */
    this.html_count_for_pring_pdf__A = "";
    this.html_count_for_pring_pdf__B = "";
    
    /*
     * If Right question available, then second line of the lines should be visible,
     * in another case should be invisible
     * @type Boolean
     */
    this.right_question_is_visible = function(){return $("input[name=show_or_hider_line_B]:checked").val()=="1";}
    /*
     * this.id_or_class_reference should have each object
     * children of this class.this.id_or_class_reference is #+the id of the created div.
     * @type type
     */
    this.id_or_class_reference = null;
    
    /*
     * Predefined animation for width of the div line
     * @param {type} new_width
     * @returns {undefined}
     */
    this.animate_width = function( new_width )
    {
        $(this.id_or_class_reference).stop().animate({width:new_width+"px"}, 500);
    }
    
    /*
     * 
     * @returns {undefined}
     * Function for showing or hidiing right column
     */
    this.set_visibility_line_B = function()
    {
        var top_position = $(this.line__left).height();
        var top_position_minus = top_position*-1;
        var top_position_minus_vrz_dva = -1*top_position/2;
        if(this.right_question_is_visible())
        {
            $(this.line_right).removeClass("displayNone");
            $(this.line__left).stop().animate({top:top_position_minus+"px"}, 500);
            $(this.line_right).stop().animate({opacity:1, top:"0px"}, 500);
            $("#chart_left_right_data_filter_above_the_cahrt_info_right").stop().animate({opacity:1}, 500);
        }
        else
        {
            $(this.line__left).stop().animate({top:top_position_minus_vrz_dva+"px"}, 500);
            $(this.line_right).stop().animate({opacity:0, top:top_position_minus_vrz_dva+"px"}, 500, function(e)
            {
                $(this).addClass("displayNone");
            }); 
            $("#chart_left_right_data_filter_above_the_cahrt_info_right").stop().animate({opacity:0}, 500);
        }
    }
    
    this.resize = function(){}
    
    /*
     * Each children class of this should init base_init function.
     * It is creating base simple functions and styles that are same for each lines,
     * vertical or horisontal.
     * @returns {undefined}
     */
    this.base_init = function()
    {
        ChartLineBase.REFERENCES[this.id_or_class_reference] = this;
        $(this.id_or_class_reference).click(function(e)
        {
            ChartLineBase.REFERENCES["#"+$(this).attr("id")].animate( Math.random()*500 );
        });
    }
}
ChartLineBase.REFERENCES = [];

function ChartSimpleLineHorizontal(id_or_class_reference)
{
    this.id_or_class_reference = "#"+id_or_class_reference;
    this.animate = function( new_width )
    {
        this.animate_width( new_width );
    }
    /*
     * Add html holder please
     */
    $("#chart_holder_lines").append(
            '<div class="chart_holder_line_test" id="' + id_or_class_reference + '"></div>'
            );
    /*
     * On start 0 width
     * @type Arguments
     */
    //$(this.id_or_class_reference).width(0);
    this.base_init();
}
ChartSimpleLineHorizontal.prototype = new ChartLineBase();

function SimpleLine_LeftRightQuestions(chart, position, label_txt, full_text)
{
    this.line_type = "line_type_simple_horizontal";
    this.line_label = label_txt;
    this.line_label_full = full_text;
    
    this.percentA = 0;
    this.percentB = 0;
    
    this.position = position;
    this.chart = chart;
    $("#chart_holder_lines").append( $("#template_simple_line_left_right_question").html() );
    this.line_holder = $("#chart_holder_lines").find( ".simple_line_left_right_question" ).last();
    this.line__left = this.simple_line_left_question = $(this.line_holder).find(".simple_line_left_question").get(0);
    this.line_right = this.simple_line_right_question = $(this.line_holder).find(".simple_line_right_question").get(0);
    this.line_percent_left = $(this.simple_line_left_question).find(".line_percent").get(0);
    this.line_percent_right = $(this.simple_line_right_question).find(".line_percent").get(0);
    //var top_position = Math.random()*400;
    $(this.line_holder).css("top", this.position.y+"px");
    $($(this.line_holder).find(".line")).width( this.chart.chart_diagram_poz_size.w );
    $(this.line_holder).find(".chart_label").html( label_txt );
    $(this.line_holder).find(".chart_label").attr("title", full_text);
    var label_top_position = -1*$(this.line_holder).find(".chart_label").height()/2;
    $(this.line_holder).find(".chart_label").css("top", label_top_position+"px");
    /*
     * 
     * @type ChartLineBase
     * .simple_line_left_question
     * .simple_line_right_question
     */
    this.init = function(above_valueA, under_valueA, above_valueB, under_valueB)
    {
        if(under_valueA == 0){above_valueA=0;under_valueA=1;}
        if(under_valueB == 0){above_valueB=0;under_valueB=1;}
        var percentA = above_valueA/under_valueA;
        var percentA100 = parseFloat( percentA*100 ).toFixed(1);
        var percentB = above_valueB/under_valueB;
        var percentB100 = parseFloat( percentB*100 ).toFixed(1);
        
        this.percentA = percentA;
        this.percentB = percentB;
        
        var widthA = this.chart.chart_diagram_poz_size.w*percentA;
        var widthB = this.chart.chart_diagram_poz_size.w*percentB;
        $($(this.line_holder).find(".simple_line_left_question .line_color_width")).stop().animate({width:widthA}, 500);
        //$($(this.line_holder).find(".simple_line_left_question")).css("color", "#ff0000");
        $($(this.line_holder).find(".simple_line_right_question .line_color_width")).stop().animate({width:widthB}, 500);
        //$($(this.line_holder).find(".simple_line_right_question")).css("color", "#00ff00");
        $(this.line_percent_left).html( percentA100+"%" );
        $(this.line_percent_right).html( percentB100+"%" );
    }
    if (!this.right_question_is_visible())
    {
        var top_position = $(this.line__left).height();
        var top_position_minus = top_position * -1;
        var top_position_minus_vrz_dva = -1 * top_position / 2;
        $(this.line__left).css("top", top_position_minus_vrz_dva + "px");
        $(this.line_right).css("top", top_position_minus_vrz_dva + "px");
        $(this.line_right).css("opacity", 0);
        $(this.line_percent_left).html( "" );
        $(this.line_percent_right).html( "" );
        $($(this.line_holder).find(".simple_line_left_question .line_color_width")).width(0);
        $($(this.line_holder).find(".simple_line_right_question .line_color_width")).width(0);
    }
    
    this.get_percent_value_for_print = function(filter_type)
    {
        return this["percent"+filter_type];
    }
}
SimpleLine_LeftRightQuestions.prototype = new ChartLineBase();

function xN_AreasLine(chart, position, label_txt, details, column_name, labelLeftRightTexts)
{
    this.line_type = "line_type_xNParts";
    this.line_label = labelLeftRightTexts.left_label;
    this.line_label_full = labelLeftRightTexts.left_label_full_text;
    
    this.dataAXML = function(){return $($(this.chart.data_xml).find("group_A_data").get(0)).find("data").get(0);}
    this.dataBXML = function(){return $($(this.chart.data_xml).find("group_B_data").get(0)).find("data").get(0);}
    
    this.leftTotal = function(){return parseFloat($(this.dataAXML()).find("count_total_"+this.column_name).text());}
    this.rightTotal = function(){return parseFloat($(this.dataBXML()).find("count_total_"+this.column_name).text());}
    
    this.details = details;
    this.column_name = column_name;
    this.count_areas = function()
    {
        return Math.abs(this.details.range_from-this.details.range_to)+1;
    }
    this.middle_width_part = function()
    {
        return Math.floor( this.chart.chart_diagram_poz_size.w/this.count_areas() );
    }
    this.position = position;
    this.chart = chart;
    $("#chart_holder_lines").append( $("#template_xN_AreasLine").html() );
    this.line = $("#chart_holder_lines").find(".xN_AreasLine").last();
    this.line__left = $(this.line).find(".xN_AreasLine_left").last();
    this.line_right = $(this.line).find(".xN_AreasLine_right").last();
    $(this.line).css("top", this.position.y+"px");
    $(this.line).width( this.chart.chart_diagram_poz_size.w );
    
    //{left_label:"Άριστη", right_label:"Πολύ κακή"}) );
    $(this.line).find(".xN_AreasLine_left_label").html( labelLeftRightTexts.left_label );
    $(this.line).find(".xN_AreasLine_right_label").html( labelLeftRightTexts.right_label );
    $(this.line).find(".xN_AreasLine_left_label").attr("data-original-title", labelLeftRightTexts.left_label_full_text);
    
    var margin_label_left_right = 45;
    var left_label_x = 0-$(this.line).find(".xN_AreasLine_left_label").width()-margin_label_left_right;
    var right_label_x = this.chart.chart_diagram_poz_size.w+margin_label_left_right;
    var left_label_y = 0-$(this.line).find(".xN_AreasLine_left_label").height()/2;
    var right_label_y = 0-$(this.line).find(".xN_AreasLine_right_label").height()/2;
    $(this.line).find(".xN_AreasLine_left_label").css("left", left_label_x+"px");
    $(this.line).find(".xN_AreasLine_right_label").css("left", right_label_x+"px");
    $(this.line).find(".xN_AreasLine_left_label").css("top", left_label_y+"px");
    $(this.line).find(".xN_AreasLine_right_label").css("top", right_label_y+"px");
    
    this.array_parts = [];
    
    this.from_to = function()
    {
        if(details.range_from<details.range_to)
        {
            return {from:details.range_from, to:details.range_to};
        }
        else
        {
            return {from:details.range_to, to:details.range_from};
        }
    }
    
    this.add_add_part = function(index)
    {
        $($(this.line__left).find(".xN_AreasLine_parts_holder").last()).append($("#template_xN_partHolder").html());
        $($(this.line_right).find(".xN_AreasLine_parts_holder").last()).append($("#template_xN_partHolder").html());
        
        var left_last_last_part = 
        $($(this.line__left).find(".xN_AreasLine_parts_holder").last()).find(".xN_partHolder").last();
        var right_last_last_part = 
        $($(this.line_right).find(".xN_AreasLine_parts_holder").last()).find(".xN_partHolder").last();
        
        var class_reference = "line_part_"+index+"_";
        $(left_last_last_part).addClass( class_reference );
        $(right_last_last_part).addClass( class_reference );
        $(left_last_last_part).addClass( "tool_tip_labels" );
        $(right_last_last_part).addClass( "tool_tip_labels" );
        $(left_last_last_part).attr("data-toggle", "tooltip");
        $(left_last_last_part).attr("data-placement", "top");
        $(left_last_last_part).attr("data-original-title", "");
        $(right_last_last_part).attr("data-toggle", "tooltip");
        $(right_last_last_part).attr("data-placement", "top");
        $(right_last_last_part).attr("data-original-title", "");
        
        this.array_parts[index] = {left:left_last_last_part, right:right_last_last_part};
        
        $(this.line_right).css("top", "-30px");
        $(left_last_last_part).width( this.middle_width_part() );
        $(right_last_last_part).width( this.middle_width_part() );
        $(left_last_last_part).css( "backgroundColor", this.details["color_"+index] );
        $(right_last_last_part).css( "backgroundColor", this.details["color_"+index] );
        
        //alert("->"+$(left_last_last_part).attr("title"));
    }
    if(details.range_from<details.range_to)
    for(i=details.range_from;i<=details.range_to;i++)
    {
        this.add_add_part(i);
    }
    else
    for(i=details.range_from;i>=details.range_to;i--)
    {
        this.add_add_part(i);
    }
    
    /*
     * 
     * @returns {undefined}
     * <root><group_A_data><data><count_q7_1>8</count_q7_1><count_q7_2>3</count_q7_2><count_q7_3>24</count_q7_3><count_q7_4>109</count_q7_4>
     * <count_q7_5>438</count_q7_5><count_total_q7>582</count_total_q7><count_q8_1>19</count_q8_1><count_q8_2>7</count_q8_2><count_q8_3>23</count_q8_3>
     * <count_q8_4>87</count_q8_4><count_q8_5>446</count_q8_5><count_total_q8>582</count_total_q8></data><total_pass_by>134872</total_pass_by>
     * <total_interviews>582</total_interviews></group_A_data><group_B_data><data><count_q7_1>0</count_q7_1><count_q7_2>0</count_q7_2><count_q7_3>0</count_q7_3>
     * <count_q7_4>1</count_q7_4><count_q7_5>2</count_q7_5><count_total_q7>3</count_total_q7><count_q8_1>0</count_q8_1><count_q8_2>0</count_q8_2>
     * <count_q8_3>1</count_q8_3><count_q8_4>0</count_q8_4>
     * <count_q8_5>2</count_q8_5><count_total_q8>3</count_total_q8></data><total_pass_by>1146</total_pass_by><total_interviews>3</total_interviews></group_B_data></root> 
     */
    this.percents = [];
    this.init = function()
    {
       this.percents = [];
       var dataAXML = $($(this.chart.data_xml).find("group_A_data").get(0)).find("data").get(0);
       var dataBXML = $($(this.chart.data_xml).find("group_B_data").get(0)).find("data").get(0);
       var leftTotal =  parseFloat($(dataAXML).find("count_total_"+this.column_name).text());
       var rightTotal =  parseFloat($(dataBXML).find("count_total_"+this.column_name).text());
       for(i=this.from_to().from;i<=this.from_to().to;i++)
       {
           //$(this.line__left).find(reference_class).get(0)
           var left_val = parseFloat($(dataAXML).find("count_"+this.column_name+"_"+i).text());
           var right_val = parseFloat($(dataBXML).find("count_"+this.column_name+"_"+i).text());
           this.animate_part( i, left_val/leftTotal, right_val/rightTotal );
           this.percents.push({A:left_val/leftTotal, B:right_val/rightTotal});
       } 
       var average_left = parseFloat($(dataAXML).find("sum_total_for_average_"+this.column_name).text())/
                          parseFloat($(dataAXML).find("count_total_"+this.column_name).text());
       var average_right = parseFloat($(dataBXML).find("sum_total_for_average_"+this.column_name).text())/
                          parseFloat($(dataBXML).find("count_total_"+this.column_name).text());
       this.average_A = average_left;
       this.average_B = average_right;
       
       /*
        * 
        * @type String
        * Top count should be, total top count line-second, tirth....or N line count
        * Actualy, all other lines have same count.
        * Top have total - SAME_COUNT
        */
       var count_data_readed_left = "", count_data_readed_right="";
       if(!this.isTopMain)
       {
           count_data_readed_left = "<br/>(N="+leftTotal+")";
           count_data_readed_right = "<br/>(N="+rightTotal+")";
       }
       else
       {
           var left_total_top_minues_next___A = this.leftTotal()-this.chart.lines[1].leftTotal();
           var left_total_top_minues_next___B = this.rightTotal()-this.chart.lines[1].rightTotal();
           count_data_readed_left = "<br/>(N="+left_total_top_minues_next___A+")";
           count_data_readed_right = "<br/>(N="+left_total_top_minues_next___B+")";
       }
       
       this.html_count_for_pring_pdf__A = count_data_readed_left;
       this.html_count_for_pring_pdf__B = count_data_readed_right;
       
       $(this.line__left).find(".xN_AreasLine_left_coeficient").html
       (
               "A:"+average_left.toFixed(1)+count_data_readed_left
       );
       $(this.line_right).find(".xN_AreasLine_left_coeficient").html
       (
               "B:"+average_right.toFixed(1)+count_data_readed_right
       );
    }
    
    this.get_percent_value_for_print = function(filter_type)
    {
        var percent_text = "";
        for(var i=0;i<this.percents.length;i++)
        {
            if(i>0)
            {
                percent_text += ";";
            }
            percent_text += this.percents[i][filter_type];
        }
        return percent_text;
    }
    
    this.animate_part = function(index, percentLeft, percentRight)
    {
        var reference_class = ".line_part_"+index+"_";
        var new_width_left =  percentLeft*this.chart.chart_diagram_poz_size.w;
        var new_width_right =  percentRight*this.chart.chart_diagram_poz_size.w;
        $($(this.line__left).find(reference_class).get(0)).animate({width:new_width_left+"px"}, 500);
        $($(this.line_right).find(reference_class).get(0)).animate({width:new_width_right+"px"}, 500);
        var percent_left = Math.round(percentLeft*1000)/10;
        var percent_rigt = Math.round(percentRight*1000)/10;
        $($(this.line__left).find(reference_class).get(0)).find(".xN_partHolder_percent_label").html
        (
                percent_left+"%"
        );
        $(this.array_parts[index].left).attr("data-original-title", percent_left+"%");
        //$(this.array_parts[index].left).tooltip();
        //console.log($(this.array_parts[index].left).attr("data-toggle"));
        //console.log($(this.array_parts[index].left).attr("data-placement"));
        //console.log($(this.array_parts[index].left).attr("title"));
        //$($(this.line__left).find(reference_class).get(0)).attr("title", percent_left+"%");
        $($(this.line_right).find(reference_class).get(0)).find(".xN_partHolder_percent_label").html
        (
                percent_rigt+"%"
        );
        //$($(this.line_right).find(reference_class).get(0)).attr("title", percent_rigt+"%");
        //alert($(this.array_parts[index].right).tooltip);
        $(this.array_parts[index].right).attr("data-original-title", percent_rigt+"%");
        //$(this.array_parts[index].right).tooltip();
    }
    if (!this.right_question_is_visible())
    {
        var top_position = $(this.line__left).height();
        var top_position_minus = top_position * -1;
        var top_position_minus_vrz_dva = -1 * top_position / 2;
        $(this.line_right).css("top", top_position_minus_vrz_dva + "px");
        $(this.line__left).css("top", top_position_minus_vrz_dva + "px");
        $(this.line_right).css("opacity", 0);
    }
}
xN_AreasLine.prototype = new ChartLineBase();

function ChartBase()
{
    this.chart_have_average_form = false;
    this.chart_have_average_form_for_database = function(){if(this.chart_have_average_form)return "1";return "0";}
    this.setup_average_form = function()
    {
        this.chart_have_average_form = true;
        $("#average_form").removeClass("displayNone");
        this.add_event(ChartBase.ON_CHANGE_VISIBILITY_RESULT_B, function(data)
        {
            if(data.is_visible_line_b)
            {
                $("#average_form___resulta_B_holder").removeClass("displayNone");
            }
            else
            {
                $("#average_form___resulta_B_holder").addClass("displayNone");
            }
        });
    }
    this.average_A = 0;
    this.average_B = 0;
    
    this.chart_title = "undefined";
    /*
     * 
     * Chart diagram coordinates, backgrounds, numbers, and rectangles variables
     */
    this.chart_diagram_bg_parce_width = function()
    {
        return (this.chart_diagram_poz_size.w/((this.chart_max_value-this.chart_min_value)/this.delta_plus))/2;
    }
    this.chart_diagram_poz_size = null;
    this.chart_min_value = 0;
    this.chart_max_value = 2;
    this.delta_plus = 0.1;
    this.coordinates_weight = 2;
    /*
     * 
     * @type type
     */
    this.chart_poz_size         = null;
    /*
     * this.init
     * 1.Init all chart, labels and results objects
     * 2.Init position of the chart, coordinates, background and lines
     */
    this.init = function(range, chart_poz_size, chart_diagram_poz_size)
    {
        this.chart_title = range.chart_label;
        this.chart_min_value = range.chart_min_value;
        this.chart_max_value = range.chart_max_value;
        this.delta_plus = range.delta_plus;
        this.data_type_chart = range.data_type_chart;
        this.chart_poz_size = chart_poz_size;
        this.chart_diagram_poz_size = chart_diagram_poz_size;
        $("#filter_chart_label").html(range.chart_label);
        $("#chart_top_left_title").html(range.chart_label);
        //ResizerPozicioner.resize("#chart_main_holder", this.chart_poz_size);
        //$("#chart_main_holder").width( this.chart_poz_size.w );
        $("#chart_main_holder").height( this.chart_poz_size.h );
        ResizerPozicioner.resize_pozicion("#charts__holder", this.chart_diagram_poz_size);
        ResizerPozicioner.resize("#chart_lines", this.chart_diagram_poz_size);
        this.draw_the_background();
        this.draw_the_coordinates();
    }
    this.count_bg_parcinja = function(){return Math.floor(this.chart_diagram_poz_size.w/this.chart_diagram_bg_parce_width());}
    this.draw_the_background = function()
    {
        $("charts__holder .background").html();
        for(var i=0;i<this.count_bg_parcinja();i++)
        {
            if(i%2==0)
            {
                $("#charts__holder .background").append( $("#chart_bg_blue_template").html() );
            }
            else
            {
                $("#charts__holder .background").append( $("#chart_bg_white_template").html() );
            }
            if(i==this.count_bg_parcinja()-1)
            $($("#charts__holder .background").find(".chart_bg_parce").last()).width
            (
                    this.chart_diagram_bg_parce_width()
                    +
                    this.chart_diagram_poz_size.w-this.count_bg_parcinja()*this.chart_diagram_bg_parce_width()
            );
            else
            $($("#charts__holder .background").find(".chart_bg_parce").last()).width(this.chart_diagram_bg_parce_width());
            $($("#charts__holder .background").find(".chart_bg_parce").last()).height(this.chart_diagram_poz_size.h);
        }
    }
    this.draw_the_coordinates = function()
    {
        var delta_cordinate_out = 5;
        //var delta_values_plus = (this.chart_max_value-this.chart_min_value)/(Math.floor(this.count_bg_parcinja()/2)), 
        values_to_x_coordinate=this.chart_min_value;
        $(".coordinate_x").width( this.chart_diagram_poz_size.w+delta_cordinate_out );
        $(".coordinate_x").height( this.coordinates_weight );
        $(".coordinate_y").width( this.coordinates_weight );
        $(".coordinate_y").height( this.chart_diagram_poz_size.h+delta_cordinate_out );
        ResizerPozicioner.pozicion( ".coordinate_x", new Point(-1*delta_cordinate_out, this.chart_diagram_poz_size.h) );
        ResizerPozicioner.pozicion( ".coordinate_y", new Point(0, 0) );
        for(var i=0;i<=this.count_bg_parcinja();i+=2)
        {
            $("#charts__holder .holder").append( $("#chart_coordinates_numbers_template").html() );
            var last_dash_number_coordinate = $("#charts__holder .holder").find(".chart_coordinates_numbers").last();
            $(last_dash_number_coordinate).find(".number").html( values_to_x_coordinate );
            $(last_dash_number_coordinate).find(".dash").height( delta_cordinate_out );
            $(last_dash_number_coordinate).find(".dash").width(this.coordinates_weight);
            var left_position = i*this.chart_diagram_bg_parce_width()-$(last_dash_number_coordinate).width()/2;
            $(last_dash_number_coordinate).css("left", left_position+"px");
            $(last_dash_number_coordinate).css("top", this.chart_diagram_poz_size.h+"px");
            values_to_x_coordinate += this.delta_plus;
        }
    }
    
    /*
     * 
     * @type Array
     * Refference to all lines for the charts.
     */
    this.lines = [];
    
    /*
     * This function is for init line in y position, in height
     * And that line will be using in future for showing the result 
     * of the diagram
     * The name of the line is simple line
     * All references for the simple lines, all ids will be store into 
     * an array.With for loop should setup the results.
     * On start they will have value 0
     */
    /*
    this.add_simple_horizontal_line = function(id_line)
    {
        this.lines.push( new ChartSimpleLineHorizontal( id_line ) );
    }*/
    /*
     * 
     * @returns {undefined}
     * Functions for adding x2, group A,B lines.
     */
    /*
    this.add_simple_left_right_questions_line = function( position, label_txt )
    {
        var new_line = new SimpleLine_LeftRightQuestions( this, position, label_txt );
        this.lines.push( new_line );
        return new_line;
    }*/
    /*
     * Function for addin a line into the chart
     */
    this.add_line = function( line )
    {
        if(this.lines.length == 0)
        {
            line.isTopMain = true;
        }
        this.lines.push( line );
        return line;
    }
    
    
    /*
     * 
     * this.data_type_chart will be variable
     * that will sent to server, and acording to that variable will load the data for the 
     * chart
     */
    this.data_type_chart = "undefined";
    this.data_xml = null;
    this.load_data = function()
    {
        var object_data = {};
        object_data[this.data_type_chart] = "Yes i will do this without a problem.:).";
        FiltersModerator.FM.add_variables_to_object( object_data );
        $.post("graphs/php/tools.php", object_data, 
        function(data)
        {
            console.log(data);
            ChartModerator.CHART.data_xml = $.parseXML( data );
            ChartModerator.CHART.show_data_to_diagram(  );
            ChartModerator.CHART.show_data_to_filter(  );
            ChartModerator.CHART.dispatch_event(ChartBase.ON_CHART_DATA_LOAD, {});
        });
    }
    /*
     * 
     * @returns {undefined}
     * Get quantity and total quantity from this.data_xml, by data table MySQL column
     */
    this.get_quantity = function(column_name, data_type_A_or_B)
    {
        var quantity_xml = $($(this.data_xml).find("group_"+data_type_A_or_B+"_data")).find("quantity").get(0);
        return parseFloat( $(quantity_xml).find("quantity").find(column_name).text() );
    }
    this.get_quantity_total = function(column_name, data_type_A_or_B)
    {
        var quantity_xml = $($(this.data_xml).find("group_"+data_type_A_or_B+"_data")).find("quantity").get(0);
        return parseFloat( $(quantity_xml).find("quantity_total").find(column_name).text() ); 
    }
    
    /*
     * 
     * @returns {undefined}
     * Rigth line visible or not visible.
     */
    this.set_visibility_line_B = function()
    {
        for(var i=0;i<this.lines.length;i++)
        {
            this.lines[i].set_visibility_line_B();
        }
        var is_visible_line_b = 
                    $("input:radio[name='show_or_hider_line_B']:checked").val()=="1";
        this.dispatch_event(ChartBase.ON_CHANGE_VISIBILITY_RESULT_B,
                {is_visible_line_b:is_visible_line_b});
    }
    /*
     * 
     * @returns {undefined}
     * Standard function for all charts
     */
    this.show_data_to_filter = function()
    {
        //total_interviews, total_passby
        $("#total_interviews__A").html( this.get_total_interviews(FiltersModerator.TYPE_ORANGE) );
        $("#total_interviews__B").html( this.get_total_interviews(FiltersModerator.TYPE___BLUE) );
        $("#total_passby__A").html( this.get_total_passby(FiltersModerator.TYPE_ORANGE) );
        $("#total_passby__B").html( this.get_total_passby(FiltersModerator.TYPE___BLUE) );
    }
    this.get_total_interviews = function(filter_type)
    {
        return $(this.data_xml).find("group_"+filter_type+"_data").find("total_interviews").text();
    }
    this.get_total_passby = function(filter_type)
    {
        return $(this.data_xml).find("group_"+filter_type+"_data").find("total_pass_by").text(); 
    }
    
    this.get_average_coeficient = function(filter_type)
    {
        var count = parseFloat($(this.data_xml).find("group_"+filter_type+"_data").find("count").text());
        var average = parseFloat($(this.data_xml).find("group_"+filter_type+"_data").find("average_total").text());
        var coef = average/count;
        console.log("average:["+average+"]")
        console.log("count:["+count+"]")
        return coef.toFixed(2);
    }
    
    /*
     * 
     * @param {type} line_details
     * @returns {undefined}
     * If need legend, this function will show legend on top
     */
    this.line_details = null;
    this.init_legend = function(line_details)
    {
        this.line_details = line_details;
        var from = line_details.range_from;
        var to = line_details.range_to;
        if(from > line_details.range_to)
        {
            from = line_details.range_to;
            to = line_details.range_from;
        }
        $("#legend_chart").removeClass("displayNone");
        for(var i=from;i<=to;i++)
        {
            $("#legend_chart").append( $("#legend_label_holder_template").html() );
            $($("#legend_chart").find(".legend_label_holder").last()).find(".legend_rectangle").css
            ("backgroundColor", line_details["color_"+i]);
            $($("#legend_chart").find(".legend_label_holder").last()).find(".legent_label").html
            (line_details["label_"+i]+" ("+i+")");
        }
    }
    
    /*
     * 
     * @type Eventor
     * 
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        line_1:"Πολύ απογοητευμένος",
        line_2:"Απογοητευμένος",
        line_3:"Ικανοποιημένος",
        line_4:"Πολύ ικανοποιημένος",
        line_5:"Εξαιρετικά ικανοποιημένος"
    };
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"Costs", chart_label:"Κόστη"},
            new Rectangle(0,0,860,830),
            new Rectangle(200,210,665,520)
    );
    
    this.init_legend( line_details );
     * 
     */
}
ChartBase.prototype = new Eventor();
ChartBase.ON_CHART_DATA_LOAD = "ON_CHART_DATA_LOAD";
ChartBase.ON_CHANGE_VISIBILITY_RESULT_B = "ON_CHANGE_VISIBILITY_RESULT_B";

function ChartTest()
{
    this.init
    (
            new Rectangle(0,0,900,700),
            new Rectangle(140,170,665,314)
    );
    this.add_simple_horizontal_line("test_1");
    this.add_simple_horizontal_line("test_2");
    this.add_simple_horizontal_line("test_3");
}
ChartTest.prototype = new ChartBase();


/*
 * ΛΟΓΟΙ ΕΠΙΣΚΕΨΗΣ 
 * Reason to visit
 * data holder charts_moderator/reason_to_visit.php
 */
function Chart__ReasonToVisit()
{
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"ReasonToVisit", chart_label:"Λόγοι Επίσκεψης"},
            new Rectangle(0,0,900,550),
            new Rectangle(200,170,665,314)
    );
        
    this.q61 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 55), "Service") );
    this.q62 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 160), "Επισκευή για την οποία πληρώσατε εσείς") );
    this.q63 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 265), "Επισκευή για την οποία δεν πληρώσατε γιατί την κάλυπτε η εγγύηση") );
    
    /*
    this.q6_1 = this.add_simple_left_right_questions_line( new Point(0, 55), "Service" );
    this.q6_2 = this.add_simple_left_right_questions_line( new Point(0, 160), "Επισκευή για την οποία πληρώσατε εσείς");
    this.q6_3 = this.add_simple_left_right_questions_line( new Point(0, 265), "Επισκευή εντός εγγύησης" );
    */
    
    this.show_data_to_diagram = function(  )
    {
        this.q61.init( this.get_quantity("q61", "A"), this.get_quantity_total("q61", "A"), 
                        this.get_quantity("q61", "B"), this.get_quantity_total("q61", "B") );
        this.q62.init( this.get_quantity("q62", "A"), this.get_quantity_total("q62", "A"), 
                        this.get_quantity("q62", "B"), this.get_quantity_total("q62", "B") );
        this.q63.init( this.get_quantity("q63", "A"), this.get_quantity_total("q63", "A"), 
                        this.get_quantity("q63", "B"), this.get_quantity_total("q63", "B") );
    }
}
Chart__ReasonToVisit.prototype = new ChartBase();

/*
 * Repeated visits
 */
function Chart__TotalVisits()
{
    this.setup_average_form();
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"TotalVisits", chart_label:"Συνολικές επισκέψεις"},
            new Rectangle(0,0,860,820),
            new Rectangle(200,180,665,600)
    );
    this.q5b_1 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 43), "1 φορά") );
    this.q5b_2 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 125), "2 φορά") );
    this.q5b_3 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 206), "3 φορά") );
    this.q5b_4 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 292), "4 φορά") );
    this.q5b_5 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 376), "5 φορά") );
    this.q5b_6 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 460), "6 φορά") );
    this.q5b_7 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 544), "7+ φορά") );
    /*
    this.Q17Α_0 = this.add_simple_left_right_questions_line( new Point(0, 43), "Τέσσερις και περισσότερες " );
    this.Q17Α_1 = this.add_simple_left_right_questions_line( new Point(0, 125), "Τρεις" );
    this.Q17Α_2 = this.add_simple_left_right_questions_line( new Point(0, 206), "Δύο" );
    this.Q17Α_3 = this.add_simple_left_right_questions_line( new Point(0, 292), "Μία" );
    this.Q17Α_4 = this.add_simple_left_right_questions_line( new Point(0, 376), "Καμία" );*/
    
    this.show_data_to_diagram = function(  )
    {
        for(var i=1;i<=7;i++)
        this["q5b_"+i].init( this.get_quantity("q5b_"+i, "A"), this.get_quantity_total("q5b_"+i, "A"), 
                          this.get_quantity("q5b_"+i, "B"), this.get_quantity_total("q5b_"+i, "B") );
       
        $("#average_form___resulta_A_holder").find(".average_form___results").html(this.get_average_coeficient("A"));
        $("#average_form___resulta_B_holder").find(".average_form___results").html(this.get_average_coeficient("B"));
        this.average_A = this.get_average_coeficient("A");
        this.average_B = this.get_average_coeficient("B");
    }
}
Chart__TotalVisits.prototype = new ChartBase();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Γενικές Εντυπώσεις
 * Генерални Импресии
 * General Impresions
 * q7. Συνολικά, πόσο ικανοποιημένος μείνατε με την εμπειρία σας σε από αυτό το εξουσιοδοτημένο συνεργείο;
 (Q7. Генерално, колку се задоволни бевте со вашето искуство во овој овластени работилница?)
 * q8.Με βάση την εμπειρία σας από το συγκεκριμένο συνεργείο πόσο πιθανό θα ήταν να συστήσετε το συγκεκριμένο συνεργείο σε κάποιον φίλο σας /γνωστό σας / συγγενή σας
 * (q8.Me вашето искуство на оваа работилница како најверојатно би им препорачале оваа работилница на пријател / познаник / роднина)
 */
function Chart__GeneralImpresions()
{
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        label_1:"Πολύ Κακή",
        label_2:"Κακή",
        label_3:"Ούτε καλή ούτε κακή",
        label_4:"Καλή",
        label_5:"Άριστη "
    };
    
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"GeneralImpresions", chart_label:"Γενικές Εντυπώσεις"},
            new Rectangle(0,0,900,610),
            new Rectangle(180,230,665,314)
    );
    
    this.init_legend( line_details );
    
    //Συνολικά, πόσο ικανοποιημένος μείνατε με την εμπειρία σας σε από αυτό το εξουσιοδοτημένο συνεργείο; Παρακαλώ απαντήστε μου δίνοντας μία απάντηση από το (1 Πολύ Κακή έως το 10 Άριστη)
    this.q7 = this.add_line ( new xN_AreasLine(this, new Point(0, 105), "q7 need label", line_details, "q7", 
    {left_label:"Συνολικά, πόσο ...", right_label:"", 
        left_label_full_text:"Συνολικά, πόσο ικανοποιημένος μείνατε με την εμπειρία σας σε από αυτό το εξουσιοδοτημένο συνεργείο."}) );
    this.q8 = this.add_line ( new xN_AreasLine(this, new Point(0, 210), "q8 need label", line_details, "q8", 
    {left_label:"Με βάση την εμπειρία ...", right_label:"", 
        left_label_full_text:"Με βάση την εμπειρία σας από το συγκεκριμένο συνεργείο πόσο πιθανό θα ήταν να συστήσετε το συγκεκριμένο συνεργείο σε κάποιον φίλο σας /γνωστό σας / συγγενή σας"}) );
    
    
    this.show_data_to_diagram = function(  )
    {
        this.q7.init();
        this.q8.init();
    }
}
Chart__GeneralImpresions.prototype = new ChartBase();

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
function Chart__Objects()
{
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        label_1:"Πολύ Κακή",
        label_2:"Κακή",
        label_3:"Ούτε καλή ούτε κακή",
        label_4:"Καλή",
        label_5:"Άριστη "
    };
    
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"Objects", chart_label:"Εγκαταστάσεις"},
            new Rectangle(0,0,860,700),
            new Rectangle(180,230,665,430)
    );
        
    this.init_legend( line_details );
    
    this.b1 = this.add_line ( new xN_AreasLine(this, new Point(0, 43), "q7 need label", line_details, "b1", 
    {left_label:"Πως θα αξιολογούσατε τις ...", right_label:"",
        left_label_full_text:"Πως θα αξιολογούσατε τις εγκαταστάσεις του συγκεκριμένου συνεργείου."}) );
    this.b2 = this.add_line ( new xN_AreasLine(this, new Point(0, 125), "q7 need label", line_details, "b2", 
    {left_label:"Πώς θα αξιολογούσατε ...", right_label:"",
        left_label_full_text:"Πώς θα αξιολογούσατε την εμφάνιση του τμήματος Service"}) );
    this.b3 = this.add_line ( new xN_AreasLine(this, new Point(0, 206), "q7 need label", line_details, "b3", 
    {left_label:"Την άνεση του ...", right_label:"",
        left_label_full_text:"Την άνεση του χώρου αναμονής (π.χ. καθίσματα, μηχανές καφέ, κλπ….)"}) );
    this.b4 = this.add_line ( new xN_AreasLine(this, new Point(0, 292), "q7 need label", line_details, "b4", 
    {left_label:"Τη γενική καθαριότητα ...", right_label:"",
        left_label_full_text:"Τη γενική καθαριότητα της αντιπροσωπείας."}) );
    this.b5 = this.add_line ( new xN_AreasLine(this, new Point(0, 376), "q7 need label", line_details, "b5", 
    {left_label:"Την ευκολία στάθμευσης", right_label:"",
        left_label_full_text:"Την ευκολία στάθμευσης."}) );
    /*
    this.b1 = this.add_simple_left_right_questions_line( new Point(0, 43), "b1 need label" );
    this.b2 = this.add_simple_left_right_questions_line( new Point(0, 125), "b2 need label" );
    this.b3 = this.add_simple_left_right_questions_line( new Point(0, 206), "b3 need label" );
    this.b4 = this.add_simple_left_right_questions_line( new Point(0, 292), "b4 need label" );
    this.b5 = this.add_simple_left_right_questions_line( new Point(0, 376), "b5 need label" );
    */
    
    this.show_data_to_diagram = function(  )
    {
        for(var i=1;i<=5;i++)
        {
            this["b"+i].init();
        }
    }
}
Chart__Objects.prototype = new ChartBase();

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
function Chart__Personal()
{
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        label_1:"Πολύ Κακή",
        label_2:"Κακή",
        label_3:"Ούτε καλή ούτε κακή",
        label_4:"Καλή",
        label_5:"Άριστη "
    };
    
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"Personal", chart_label:"Προσωπικό"},
            new Rectangle(0,0,860,1000),
            new Rectangle(180,230,665,730)
    );
    
    this.init_legend( line_details );
    
    this.c1 = this.add_line ( new xN_AreasLine(this, new Point(0, 43), "q7 need label", line_details, "c1", 
    {left_label:"Πως θα αξιολογούσατε ...", right_label:"",
    left_label_full_text:"Πως θα αξιολογούσατε το προσωπικό του συγκεκριμένου συνεργείου"}) );
    this.c2 = this.add_line ( new xN_AreasLine(this, new Point(0, 125), "q7 need label", line_details, "c2", 
    {left_label:"Αισθανθήκατε ότι ...", right_label:"",
    left_label_full_text:"Αισθανθήκατε ότι σας αντιμετώπισαν σαν ένα σημαντικό πελάτη"}) );
    this.c3 = this.add_line ( new xN_AreasLine(this, new Point(0, 206), "q7 need label", line_details, "c3", 
    {left_label:"Πώς θα αξιολογούσατε ...", right_label:"",
    left_label_full_text:"Πώς θα αξιολογούσατε την φιλικότητα του προσωπικού"}) );
    this.c4 = this.add_line ( new xN_AreasLine(this, new Point(0, 292), "q7 need label", line_details, "c4", 
    {left_label:"Πώς θα αξιολογούσατε ...", right_label:"",
    left_label_full_text:"Πώς θα αξιολογούσατε την εξυπηρέτηση του προσωπικού"}) );
    this.c5 = this.add_line ( new xN_AreasLine(this, new Point(0, 376), "q7 need label", line_details, "c5", 
    {left_label:"Την ειλικρίνεια ...", right_label:"",
    left_label_full_text:"Την ειλικρίνεια και την αξιοπιστία τους"}) );
    this.c6 = this.add_line ( new xN_AreasLine(this, new Point(0, 456), "q7 need label", line_details, "c6", 
    {left_label:"Τον χειρισμό ...", right_label:"",
    left_label_full_text:"Τον χειρισμό των τηλεφωνικών ερωτήσεων"}) );
    this.c7 = this.add_line ( new xN_AreasLine(this, new Point(0, 526), "q7 need label", line_details, "c7", 
    {left_label:"Την προθυμία να ...", right_label:"",
    left_label_full_text:"Την προθυμία να ακούσουν και να κατανοήσουν τα προβλήματα"}) );
    this.c8 = this.add_line ( new xN_AreasLine(this, new Point(0, 606), "q7 need label", line_details, "c8", 
    {left_label:"Την επεξήγηση της ...", right_label:"",
    left_label_full_text:"Την επεξήγηση της εργασίας που πρέπει να γίνει"}) );
    this.c9 = this.add_line ( new xN_AreasLine(this, new Point(0, 686), "q7 need label", line_details, "c9", 
    {left_label:"Την ικανότητα τους ...", right_label:"",
    left_label_full_text:"Την ικανότητα τους να διαγνώσουν προβλήματα"}) );
        /*
    this.c1 = this.add_simple_left_right_questions_line( new Point(0, 43), "c1 need label" );
    this.c2 = this.add_simple_left_right_questions_line( new Point(0, 125), "c2 need label" );
    this.c3 = this.add_simple_left_right_questions_line( new Point(0, 206), "c3 need label" );
    this.c4 = this.add_simple_left_right_questions_line( new Point(0, 292), "c4 need label" );
    this.c5 = this.add_simple_left_right_questions_line( new Point(0, 376), "c5 need label" ); 
    this.c6 = this.add_simple_left_right_questions_line( new Point(0, 456), "c6 need label" ); 
    this.c7 = this.add_simple_left_right_questions_line( new Point(0, 526), "c7 need label" ); 
    this.c8 = this.add_simple_left_right_questions_line( new Point(0, 606), "c8 need label" ); 
    this.c9 = this.add_simple_left_right_questions_line( new Point(0, 686), "c9 need label" ); 
    */
    
    this.show_data_to_diagram = function(  )
    {
        for(var i=1;i<=9;i++)
        this["c"+i].init();
    }
}
Chart__Personal.prototype = new ChartBase();

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
function Chart__QuestionsOnTime()
{
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        label_1:"Πολύ Κακή",
        label_2:"Κακή",
        label_3:"Ούτε καλή ούτε κακή",
        label_4:"Καλή",
        label_5:"Άριστη "
    };
    
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"QuestionsOnTime", chart_label:"Θέματα Χρόνου"},
            new Rectangle(0,0,860,920),
            new Rectangle(180,230,665,650)
    );
        
    this.init_legend( line_details );
    
    this.d1 = this.add_line ( new xN_AreasLine(this, new Point(0, 43), "q7 need label", line_details, "d1", 
    {left_label:"Τύχατε της προσοχή ...", right_label:"",
    left_label_full_text:"Τύχατε της προσοχή του προσωπικού (σας είχε το προσωπικό στο νού του)καθ’ όλη την διάρκεια της επίσκεψης σας"}) );
    this.d2 = this.add_line ( new xN_AreasLine(this, new Point(0, 125), "q7 need label", line_details, "d2", 
    {left_label:"Πώς θα αξιολογούσατε ...", right_label:"",
    left_label_full_text:"Πώς θα αξιολογούσατε την ευκολία να κλείσετε ραντεβού"}) );
    this.d3 = this.add_line ( new xN_AreasLine(this, new Point(0, 206), "q7 need label", line_details, "d3", 
    {left_label:"Την προσοχή που ...", right_label:"",
    left_label_full_text:"Την προσοχή που σας δόθηκε κατά την άφιξή σας"}) );
    this.d4 = this.add_line ( new xN_AreasLine(this, new Point(0, 292), "q7 need label", line_details, "d4", 
    {left_label:"Τον χρόνο αναμονής ...", right_label:"",
    left_label_full_text:"Τον χρόνο αναμονής όταν πήρανε το όχημά σας"}) );
    this.d5 = this.add_line ( new xN_AreasLine(this, new Point(0, 376), "q7 need label", line_details, "d5", 
    {left_label:"Την ικανότητα τους ...", right_label:"",
    left_label_full_text:"Την ικανότητα τους να ανταποκριθούν στο χρονοδιάγραμμα που σας είχαν δώσει αρχικά"}) );
    this.d6 = this.add_line ( new xN_AreasLine(this, new Point(0, 456), "q7 need label", line_details, "d6", 
    {left_label:"τον συνολικό ...", right_label:"",
    left_label_full_text:"τον συνολικό χρόνο που απαιτήθηκε ώστε να ολοκληρωθεί το service του οχήματός σας"}) );
    this.d7 = this.add_line ( new xN_AreasLine(this, new Point(0, 526), "q7 need label", line_details, "d7", 
    {left_label:"Την ευελιξία της ...", right_label:"",
    left_label_full_text:"Την ευελιξία της αντιπροσωπείας να σας κλείσει το ραντεβού που θέλατε"}) );
    this.d8 = this.add_line ( new xN_AreasLine(this, new Point(0, 606), "q7 need label", line_details, "d8", 
    {left_label:"Την ευκολία ωραρίου", right_label:"",
    left_label_full_text:"Την ευκολία ωραρίου"}) );
        /*
    this.d1 = this.add_simple_left_right_questions_line( new Point(0, 43), "d1 need label" );
    this.d2 = this.add_simple_left_right_questions_line( new Point(0, 125), "d2 need label" );
    this.d3 = this.add_simple_left_right_questions_line( new Point(0, 206), "d3 need label" );
    this.d4 = this.add_simple_left_right_questions_line( new Point(0, 292), "d4 need label" );
    this.d5 = this.add_simple_left_right_questions_line( new Point(0, 376), "d5 need label" ); 
    this.d6 = this.add_simple_left_right_questions_line( new Point(0, 456), "d6 need label" ); 
    this.d7 = this.add_simple_left_right_questions_line( new Point(0, 526), "d7 need label" ); 
    this.d8 = this.add_simple_left_right_questions_line( new Point(0, 606), "d8 need label" ); 
    */
    
    this.show_data_to_diagram = function(  )
    {
        for(var i=1;i<=8;i++)
        this["d"+i].init( );
    }
}
Chart__QuestionsOnTime.prototype = new ChartBase();


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
function Chart__Quality()
{
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        label_1:"Πολύ Κακή",
        label_2:"Κακή",
        label_3:"Ούτε καλή ούτε κακή",
        label_4:"Καλή",
        label_5:"Άριστη "
    };
    
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"Quality", chart_label:"Ποιότητα"},
            new Rectangle(0,0,860,650),
            new Rectangle(180,230,665,360)
    );
        
    this.init_legend( line_details );    
        
    this.e1 = this.add_line ( new xN_AreasLine(this, new Point(0, 43), "e1 need label", line_details, "e1", 
    {left_label:"Παρακαλώ αξιολογήστε ...", right_label:"",
    left_label_full_text:"Παρακαλώ αξιολογήστε την εμπιστοσύνη σας στις εργασίες που πραγματοποιήθηκαν στο αυτοκίνητο σας κατά τη διάρκεια του τελευταίου service"}) );
    this.e2 = this.add_line ( new xN_AreasLine(this, new Point(0, 125), "e2 need label", line_details, "e2", 
    {left_label:"Σε ποιο βαθμό ...", right_label:"",
    left_label_full_text:"Σε ποιο βαθμό ολοκληρώθηκαν οι εργασίες που ζητήσατε"}) );
    this.e3 = this.add_line ( new xN_AreasLine(this, new Point(0, 206), "e3 need label", line_details, "e3", 
    {left_label:"Πώς θα αξιολογούσατε ...", right_label:"",
    left_label_full_text:"Πώς θα αξιολογούσατε την καθαριότητα του οχήματός σας μετά  το service ή  την επισκευή"}) );
    this.e4 = this.add_line ( new xN_AreasLine(this, new Point(0, 292), "e4 need label", line_details, "e4", 
    {left_label:"Παρακαλώ βαθμολογήστε ...", right_label:"",
    left_label_full_text:"Παρακαλώ βαθμολογήστε την εμπιστοσύνη σας στην τεχνική κατάρτιση της αντιπροσωπείας"}) );
    /*
    this.e1 = this.add_simple_left_right_questions_line( new Point(0, 43), "e1 need label" );
    this.e2 = this.add_simple_left_right_questions_line( new Point(0, 125), "e2 need label" );
    this.e3 = this.add_simple_left_right_questions_line( new Point(0, 206), "e3 need label" );
    this.e4 = this.add_simple_left_right_questions_line( new Point(0, 292), "e4 need label" );
    */
    
    this.show_data_to_diagram = function(  )
    {
        for(var i=1;i<=4;i++)
        this["e"+i].init(  );
    }  
}
Chart__Quality.prototype = new ChartBase();

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
function Chart__Quality_again_testing()
{
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"Quality_again_testing", 
        chart_label:"Ποιότητα – Δεύτερη επίσκεψη"},
            new Rectangle(0,0,860,950),
            new Rectangle(200,180,665,670)
    );
    this.e61 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 43), 
    "Δεν ήταν αρκετός ο ...",
    "Δεν ήταν αρκετός ο χρόνος / το πρόγραμμα ήταν γεμάτο") );
    this.e62 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 125), 
    "Δεν μπορούσαν να ...",
    "Δεν μπορούσαν να βρουν το πρόβλημα") );
    this.e63 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 206), 
    "Δεν ήταν διαθέσιμα ...",
    "Δεν ήταν διαθέσιμα τα ανταλλακτικά") );
    this.e64 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 292), 
    "Τα ανταλλακτικά που ...",
    "Τα ανταλλακτικά που χρησιμοποιήθηκαν ήταν ελαττωματικά") );
    this.e65 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 372), 
    "Το τμήμα του service ...",
    "Το τμήμα του service δεν μπόρεσε να βρει το πρόβλημα την πρώτη φορά") );
    this.e66 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 452), 
    "Το τμήμα του service ...",
    "Το τμήμα του service επιχείρησε την επισκευή αλλά δεν διόρθωσε το πρόβλημα") );
    this.e67 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 532), 
    "Το πρόβλημα διορθώθηκε ...",
    "Το πρόβλημα διορθώθηκε αλλά παρουσιάστηκε άλλο πρόβλημα") );
    this.e68 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 612), 
    "Άλλος λόγος",
    "") );
    /*
    this.e61 = this.add_simple_left_right_questions_line( new Point(0, 43), "e61 need label" );
    this.e62 = this.add_simple_left_right_questions_line( new Point(0, 125), "e62 need label" );
    this.e63 = this.add_simple_left_right_questions_line( new Point(0, 206), "e63 need label" );
    this.e64 = this.add_simple_left_right_questions_line( new Point(0, 292), "e64 need label" );
    this.e65 = this.add_simple_left_right_questions_line( new Point(0, 372), "e65 need label" );
    this.e66 = this.add_simple_left_right_questions_line( new Point(0, 452), "e66 need label" );
    this.e67 = this.add_simple_left_right_questions_line( new Point(0, 532), "e67 need label" );
    this.e68 = this.add_simple_left_right_questions_line( new Point(0, 612), "e68 need label" );
    */
    
    this.show_data_to_diagram = function(  )
    {
        for(var i=1;i<=8;i++)
        this["e6"+i].init( this.get_quantity("e6"+i, "A"), this.get_quantity_total("e6"+i, "A"), 
                          this.get_quantity("e6"+i, "B"), this.get_quantity_total("e6"+i, "B") );
    }   
}
Chart__Quality_again_testing.prototype = new ChartBase();


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
function Chart__Costs()
{
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        label_1:"Πολύ Κακή",
        label_2:"Κακή",
        label_3:"Ούτε καλή ούτε κακή",
        label_4:"Καλή",
        label_5:"Άριστη "
    };
    
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"Costs", chart_label:"Κόστη"},
            new Rectangle(0,0,860,850),
            new Rectangle(180,230,665,520)
    );
    
    this.init_legend( line_details );
    
    this.Z1 = this.add_line ( new xN_AreasLine(this, new Point(0, 43), "e1 need label", line_details, "Z1", 
    {left_label:"Από άποψη κόστους ...", right_label:"",
    left_label_full_text:"Από άποψη κόστους, παρακαλώ αξιολογήστε την υπηρεσία που λάβατε"}) );
    this.Z2 = this.add_line ( new xN_AreasLine(this, new Point(0, 125), "e1 need label", line_details, "Z2", 
    {left_label:"Παροχή σαφών πληροφοριών ...", right_label:"",
    left_label_full_text:"Παροχή σαφών πληροφοριών σχετικά με το κόστος πριν την έναρξη της εργασίας"}) );
    this.Z3 = this.add_line ( new xN_AreasLine(this, new Point(0, 206), "e1 need label", line_details, "Z3", 
    {left_label:"Επεξήγηση των εργασιών που έγιναν", right_label:"",
    left_label_full_text:""}) );
    this.Z4 = this.add_line ( new xN_AreasLine(this, new Point(0, 292), "e1 need label", line_details, "Z4", 
    {left_label:"Πόσο λογικό ήταν ...", right_label:"",
    left_label_full_text:"Πόσο λογικό ήταν το κόστος των εργασιών και των ανταλλακτικών"}) );
    this.Z5 = this.add_line ( new xN_AreasLine(this, new Point(0, 372), "e1 need label", line_details, "Z5", 
    {left_label:"Επεξήγηση των χρεώσεων του service?", right_label:"",
    left_label_full_text:""}) );
    this.Z6 = this.add_line ( new xN_AreasLine(this, new Point(0, 452), "e1 need label", line_details, "Z6", 
    {left_label:"Επεξήγηση του μελλοντικού ...", right_label:"",
    left_label_full_text:"Επεξήγηση του μελλοντικού προγραμμάτος συντήρησης και επισκευής"}) );
    /*
    this.Z1 = this.add_simple_left_right_questions_line( new Point(0, 43), "Z1 need label" );
    this.Z2 = this.add_simple_left_right_questions_line( new Point(0, 125), "Z2 need label" );
    this.Z3 = this.add_simple_left_right_questions_line( new Point(0, 206), "Z3 need label" );
    this.Z4 = this.add_simple_left_right_questions_line( new Point(0, 292), "Z4 need label" );
    this.Z5 = this.add_simple_left_right_questions_line( new Point(0, 372), "Z5 need label" );
    this.Z6 = this.add_simple_left_right_questions_line( new Point(0, 452), "Z6 need label" );
    */
    
    this.show_data_to_diagram = function(  )
    {
        for(var i=1;i<=6;i++)
        this["Z"+i].init();
    } 
}
Chart__Costs.prototype = new ChartBase();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * FOLLOW UP
 * h1. Πως θα αξιολογούσατε την επικοινωνία που είχατε με την αντιπροσωπεία από το τελευταίο service / επισκευή που είχατε;
 * (Н1. Како вие ја оценувате комуникација сте имале со делегација од последната услуга / поправка дека сте имале?)
 * h5. Πώς θα αξιολογούσατε τον τρόπο που αντιμετωπίστηκε το θέμα σας;
 * (Х5. Како вие ја оценувате начинот на кој ќе се обрати вашиот проблем?)
 */
function Chart__FollowUp()
{
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        label_1:"Πολύ Κακή",
        label_2:"Κακή",
        label_3:"Ούτε καλή ούτε κακή",
        label_4:"Καλή",
        label_5:"Άριστη "
    };
    
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"FollowUp", chart_label:"Follow Up"},
            new Rectangle(0,0,860,700),
            new Rectangle(180,230,665,410)
    );
        
    this.init_legend( line_details );
    
    this.h1 = this.add_line ( new xN_AreasLine(this, new Point(0, 120), "h1 need label", line_details, "h1", 
    {left_label:"Πως θα αξιολογούσατε ...", right_label:"",
    left_label_full_text:"Πως θα αξιολογούσατε την επικοινωνία που είχατε με την αντιπροσωπεία από το τελευταίο service / επισκευή που είχατε"}) );
    this.h5 = this.add_line ( new xN_AreasLine(this, new Point(0, 250), "h5 need label", line_details, "h5", 
    {left_label:"Πώς θα αξιολογούσατε ...", right_label:"",
    left_label_full_text:"Πώς θα αξιολογούσατε τον τρόπο που αντιμετωπίστηκε το θέμα σας"}) );
    /*
    this.h1 = this.add_simple_left_right_questions_line( new Point(0, 120), "h1 need label" );
    this.h5 = this.add_simple_left_right_questions_line( new Point(0, 250), "h5 need label" );
    */
    
    this.show_data_to_diagram = function(  )
    {
        this.h1.init(  );
        this.h5.init(  );
    } 
}
Chart__FollowUp.prototype = new ChartBase();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * ΣΤΟ ΜΈΛΛΟΝ(vo idnina)
 * u1. Θα πάτε ξανά στο συγκεκριμένο συνεργείο για κάποια μελλοντική εργασία;(U1. Ќе се вратиме на оваа работилница за некои идни работа?)
 * u2. Θα συνιστούσατε τα αυτοκίνητα της Hyundai στην οικογένειά σας και στους φίλους σας;(U2. Дали ви препорачуваме автомобилите на Hyundai во вашето семејство и пријатели?)
 * u3. Θα αγοράζατε ξανά ένα αυτοκίνητο Hyundai;(U3. Ќе купи автомобил повторно Хјундаи;)
 */
function Chart__InFuture()
{
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        label_1:"Σίγουρα Όχι",
        label_2:"Μάλλον Όχι",
        label_3:"Ούτε ναι ούτε όχι",
        label_4:"Μάλλον Ναι",
        label_5:"Σίγουρα Ναι "
    };
    
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"InFuture", chart_label:"Στο μέλλον"},
            new Rectangle(0,0,860,700),
            new Rectangle(180,230,665,410)
    );
    
    this.init_legend( line_details );
    
    this.u1 = this.add_line ( new xN_AreasLine(this, new Point(0, 100), "u1 need label", line_details, "u1", 
    {left_label:"Θα πάτε ξανά στο ...", right_label:"",
    left_label_full_text:"Θα πάτε ξανά στο συγκεκριμένο συνεργείο για κάποια μελλοντική εργασία"}) );
    this.u2 = this.add_line ( new xN_AreasLine(this, new Point(0, 200), "u2 need label", line_details, "u2", 
    {left_label:"Θα συνιστούσατε τα ...", right_label:"",
    left_label_full_text:"Θα συνιστούσατε τα αυτοκίνητα της Hyundai στην οικογένειά σας και στους φίλους σας"}) );
    this.u3 = this.add_line ( new xN_AreasLine(this, new Point(0, 300), "u3 need label", line_details, "u3", 
    {left_label:"Θα αγοράζατε ξανά ένα αυτοκίνητο Hyundai", right_label:"",
    left_label_full_text:""}) );
    /*
    this.u1 = this.add_simple_left_right_questions_line( new Point(0, 100), "u1 need label" );
    this.u2 = this.add_simple_left_right_questions_line( new Point(0, 200), "u2 need label" );
    this.u3 = this.add_simple_left_right_questions_line( new Point(0, 300), "u3 need label" );
    */
    
    this.show_data_to_diagram = function(  )
    {
        for(var i=1;i<=3;i++)
        this["u"+i].init(  );
    } 
}
Chart__InFuture.prototype = new ChartBase();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * ΚΛΕΊΣΙΜΟ ΚΛΉΣΗΣ(blisku povik)
 * i1. Πώς θα αξιολογούσατε την συνολική ποιότητα του αυτοκινήτου σας;(i1. Како вие ја оценувате целокупниот квалитет на вашиот автомобил?)
 * i2. Θα ήθελα να μου πείτε συνολικά για την μάρκα HYUNDAI σε σχέση με άλλες μάρκες που ξέρετε, θα λέγατε ότι είναι μια άριστη μάρκα
 * (I2. Јас би рекол мојот Вкупно за брендот HYUNDAI во однос на другите брендови кои знаете, дали би рекле дека е одличен бренд)
 */
function Chart__CloseCall()
{
    var line_details = 
    {
        range_from:5,range_to:1,
        
        color_5:"#339966",
        color_4:"#99cc00",
        color_3:"#ffff00",
        color_2:"#ff9900",
        color_1:"#ff0000",
        
        label_1:"Πολύ Κακή",
        label_2:"Κακή",
        label_3:"Ούτε καλή ούτε κακή",
        label_4:"Καλή",
        label_5:"Άριστη "
    };
    
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"CloseCall", chart_label:"Κλείσιμο Κλήσης"},
            new Rectangle(0,0,860,700),
            new Rectangle(180,230,665,410)
    );
        
    this.init_legend( line_details )
        
    this.i1 = this.add_line ( new xN_AreasLine(this, new Point(0, 120), "i1 need label", line_details, "i1", 
    {left_label:"Πώς θα αξιολογούσατε την ...", right_label:"",
    left_label_full_text:"Πώς θα αξιολογούσατε την συνολική ποιότητα του αυτοκινήτου σας"}) );
    this.i2 = this.add_line ( new xN_AreasLine(this, new Point(0, 250), "i1 need label", line_details, "i2", 
    {left_label:"Θα ήθελα να μου πείτε ...", right_label:"",
    left_label_full_text:"Θα ήθελα να μου πείτε συνολικά για την μάρκα HYUNDAI σε σχέση με άλλες μάρκες που ξέρετε, θα λέγατε ότι είναι μια άριστη μάρκα"}) );
    /*
    this.i1 = this.add_simple_left_right_questions_line( new Point(0, 120), "i1 need label" );
    this.i2 = this.add_simple_left_right_questions_line( new Point(0, 250), "i2 need label" );
    */
    
    this.show_data_to_diagram = function(  )
    {
        for(var i=1;i<=2;i++)
        this["i"+i].init(   );
    } 
}
Chart__CloseCall.prototype = new ChartBase();


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Επικοινωνία πελάτη με αντιπροσωπεία
 * 
H3-BC column: Υπήρξαν θέματα για τα οποία χρειάστηκε να επικοινωνήσετε με την αντιπροσωπεία μετά το τελευταίο service που κάνατε;
 * Имаше прашања што мораше да се јавите на Застапништва по последната услуга што направи? 
H4-BD column: Λύθηκαν τα θέματα σας;
 * Реши вашите проблеми?

do not use H3,4 in chart ;-)
h3, h4 replies are 1= yes, 2 = no.
 */
function Chart__ContactClientDelegation()
{
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"ContactClientDelegation", 
                                    chart_label:"Επικοινωνία πελάτη με αντιπροσωπεία"},
            new Rectangle(0,0,860,600),
            new Rectangle(180,180,665,335)
    );
        
    this.h3 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 100), 
    "Υπήρξαν θέματα για τα οποία ...",
    "Υπήρξαν θέματα για τα οποία χρειάστηκε να επικοινωνήσετε με την αντιπροσωπεία μετά το τελευταίο service που κάνατε") );
    this.h4 = this.add_line( new SimpleLine_LeftRightQuestions( this, new Point(0, 250), 
    "Λύθηκαν τα θέματα σας",
    "") ); 
    this.show_data_to_diagram = function(  )
    {
        for(var i=3;i<=4;i++)
        this["h"+i].init( this.get_quantity("h"+i, "A"), this.get_quantity_total("h"+i, "A"), 
                          this.get_quantity("h"+i, "B"), this.get_quantity_total("h"+i, "B") );
    }
}
Chart__ContactClientDelegation.prototype = new ChartBase();


function ChartModerator(){}
ChartModerator.CHART = null;

