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

function SimpleLine_LeftRightQuestions(chart, position, label_txt)
{
    this.position = position;
    this.chart = chart;
    $("#chart_holder_lines").append( $("#template_simple_line_left_right_question").html() );
    this.line_holder = $("#chart_holder_lines").find( ".simple_line_left_right_question" ).last();
    this.simple_line_left_question = $(this.line_holder).find(".simple_line_left_question").get(0);
    this.simple_line_right_question = $(this.line_holder).find(".simple_line_right_question").get(0);
    this.line_percent_left = $(this.simple_line_left_question).find(".line_percent").get(0);
    this.line_percent_right = $(this.simple_line_right_question).find(".line_percent").get(0);
    //var top_position = Math.random()*400;
    $(this.line_holder).css("top", this.position.y+"px");
    $($(this.line_holder).find(".line")).width( this.chart.chart_diagram_poz_size.w );
    $(this.line_holder).find(".chart_label").html( label_txt );
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
        var percentA100 = Math.round( percentA*100 );
        var percentB = above_valueB/under_valueB;
        var percentB100 = Math.round( percentB*100 );
        var widthA = this.chart.chart_diagram_poz_size.w*percentA;
        var widthB = this.chart.chart_diagram_poz_size.w*percentB;
        $($(this.line_holder).find(".simple_line_left_question .line_color_width")).stop().animate({width:widthA}, 500);
        //$($(this.line_holder).find(".simple_line_left_question")).css("color", "#ff0000");
        $($(this.line_holder).find(".simple_line_right_question .line_color_width")).stop().animate({width:widthB}, 500);
        //$($(this.line_holder).find(".simple_line_right_question")).css("color", "#00ff00");
        $(this.line_percent_left).html( percentA100+"%" );
        $(this.line_percent_right).html( percentB100+"%" );
    }
    this.set_visibility_line_B = function()
    {
        var top_position = $(this.simple_line_left_question).height();
        var top_position_minus = top_position*-1;
        var top_position_minus_vrz_dva = -1*top_position/2;
        if(this.right_question_is_visible())
        {
            $(this.simple_line_right_question).removeClass("displayNone");
            $(this.simple_line_left_question).stop().animate({top:top_position_minus+"px"}, 500);
            $(this.simple_line_right_question).stop().animate({opacity:1, top:"0px"}, 500);
            $("#chart_left_right_data_filter_above_the_cahrt_info_right").stop().animate({opacity:1}, 500);
        }
        else
        {
            $(this.simple_line_left_question).stop().animate({top:top_position_minus_vrz_dva+"px"}, 500);
            $(this.simple_line_right_question).stop().animate({opacity:0, top:top_position_minus_vrz_dva+"px"}, 500, function(e)
            {
                $(this).addClass("displayNone");
            }); 
            $("#chart_left_right_data_filter_above_the_cahrt_info_right").stop().animate({opacity:0}, 500);
        }
    }
    if(!this.right_question_is_visible())
    {
        var top_position = $(this.simple_line_left_question).height();
        var top_position_minus = top_position*-1;
        var top_position_minus_vrz_dva = -1*top_position/2;
        $($(this.simple_line_left_question).find(".line_color_width").get(0)).width(0);
        $($(this.simple_line_right_question).find(".line_color_width").get(0)).width(0);
        $(this.simple_line_left_question).css("top", top_position_minus_vrz_dva+"px");
        $(this.simple_line_right_question).css("top", top_position_minus_vrz_dva+"px");
        $(this.simple_line_right_question).css("opacity", 0);
        $(this.line_percent_left).html( "" );
        $(this.line_percent_right).html( "" );
    }
}
SimpleLine_LeftRightQuestions.prototype = new ChartLineBase();

function ChartBase()
{
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
    this.add_simple_horizontal_line = function(id_line)
    {
        this.lines.push( new ChartSimpleLineHorizontal( id_line ) );
    }
    /*
     * 
     * @returns {undefined}
     * Functions for adding x2, group A,B lines.
     */
    this.add_simple_left_right_questions_line = function( position, label_txt )
    {
        var new_line = new SimpleLine_LeftRightQuestions( this, position, label_txt );
        this.lines.push( new_line );
        return new_line;
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
}
ChartBase.prototype = new Eventor();
ChartBase.ON_CHART_DATA_LOAD = "ON_CHART_DATA_LOAD";

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
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"ReasonToVisit", chart_label:"ΛΟΓΟΙ ΕΠΙΣΚΕΨΗΣ"},
            new Rectangle(0,0,900,550),
            new Rectangle(140,170,665,314)
    );
    this.q6_1 = this.add_simple_left_right_questions_line( new Point(0, 55), "Service" );
    this.q6_2 = this.add_simple_left_right_questions_line( new Point(0, 160), "Επισκευή για την οποία πληρώσατε εσείς");
    this.q6_3 = this.add_simple_left_right_questions_line( new Point(0, 265), "Επισκευή εντός εγγύησης" );
    
    this.show_data_to_diagram = function(  )
    {
        this.q6_1.init( this.get_quantity("q6_1", "A"), this.get_quantity_total("q6_1", "A"), 
                        this.get_quantity("q6_1", "B"), this.get_quantity_total("q6_1", "B") );
        this.q6_2.init( this.get_quantity("q6_2", "A"), this.get_quantity_total("q6_2", "A"), 
                        this.get_quantity("q6_2", "B"), this.get_quantity_total("q6_2", "B") );
        this.q6_3.init( this.get_quantity("q6_3", "A"), this.get_quantity_total("q6_3", "A"), 
                        this.get_quantity("q6_3", "B"), this.get_quantity_total("q6_3", "B") );
    }
}
Chart__ReasonToVisit.prototype = new ChartBase();

/*
 * Repeated visits
 */
function Chart__RepeatedVisits()
{
    this.init
    (
            {chart_min_value:0, chart_max_value:100, delta_plus:20, data_type_chart:"RepeatedVisits", chart_label:"ΕΠΑΝΑΛΗΨΗ ΕΠΙΣΚΕΨΗΣ"},
            new Rectangle(0,0,860,650),
            new Rectangle(170,180,665,430)
    );
    this.Q17Α_0 = this.add_simple_left_right_questions_line( new Point(0, 43), "Τέσσερις και περισσότερες " );
    this.Q17Α_1 = this.add_simple_left_right_questions_line( new Point(0, 125), "Τρεις" );
    this.Q17Α_2 = this.add_simple_left_right_questions_line( new Point(0, 206), "Δύο" );
    this.Q17Α_3 = this.add_simple_left_right_questions_line( new Point(0, 292), "Μία" );
    this.Q17Α_4 = this.add_simple_left_right_questions_line( new Point(0, 376), "Καμία" );
    
    this.show_data_to_diagram = function(  )
    {
        this.Q17Α_0.init( this.get_quantity("Q17Α_0", "A"), this.get_quantity_total("Q17Α_0", "A"), 
                          this.get_quantity("Q17Α_0", "B"), this.get_quantity_total("Q17Α_0", "B") );
        this.Q17Α_1.init( this.get_quantity("Q17Α_1", "A"), this.get_quantity_total("Q17Α_1", "A"), 
                          this.get_quantity("Q17Α_1", "B"), this.get_quantity_total("Q17Α_1", "B") );
        this.Q17Α_2.init( this.get_quantity("Q17Α_2", "A"), this.get_quantity_total("Q17Α_2", "A"), 
                          this.get_quantity("Q17Α_2", "B"), this.get_quantity_total("Q17Α_2", "B") );
        this.Q17Α_3.init( this.get_quantity("Q17Α_3", "A"), this.get_quantity_total("Q17Α_3", "A"), 
                          this.get_quantity("Q17Α_3", "B"), this.get_quantity_total("Q17Α_3", "B") );
        this.Q17Α_4.init( this.get_quantity("Q17Α_4", "A"), this.get_quantity_total("Q17Α_4", "A"), 
                          this.get_quantity("Q17Α_4", "B"), this.get_quantity_total("Q17Α_4", "B") );
    }
}
Chart__RepeatedVisits.prototype = new ChartBase();


function ChartModerator(){}
ChartModerator.CHART = null;

