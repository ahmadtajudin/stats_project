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
    this.right_question_is_availble = true;
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

function SimpleLine_LeftRightQuestions()
{
    $("#chart_holder_lines").append( $("#template_simple_line_left_right_question").html() );
    this.line_holder = $("#chart_holder_lines").find( ".simple_line_left_right_question" ).last();
}
SimpleLine_LeftRightQuestions.prototype = new ChartLineBase();

function ChartBase()
{
    /*
     * 
     * Chart diagram coordinates, backgrounds, numbers, and rectangles variables
     */
    this.chart_diagram_bg_parce_width = 70;
    this.chart_diagram_poz_size = null;
    this.chart_min_value = 0;
    this.chart_max_value = 2;
    this.coordinates_weight = 2;
    /*
     * 
     * @type type
     */
    this.chart_poz_size         = null;
    /*
     * this.get_data will take the data from MySQL
     * according to selected variables trought the filter
     */
    this.get_data = function()
    {
    }
    
    /*
     * this.draw_background is function for drawing the background of the 
     * chart.....
     * this.draw_coordinates for drawing cordinates
     */
    this.draw_background = function()
    {
    }
    this.draw_coordinates = function(rang_from, rang_to, rang_delta_plus)
    {
    }
    /*
     * this.init
     * 1.Init all chart, labels and results objects
     * 2.Init position of the chart, coordinates, background and lines
     */
    this.init = function(chart_poz_size, chart_diagram_poz_size)
    {
        this.chart_poz_size = chart_poz_size;
        this.chart_diagram_poz_size = chart_diagram_poz_size;
        ResizerPozicioner.resize("#chart_main_holder", this.chart_poz_size);
        ResizerPozicioner.resize_pozicion("#charts__holder", this.chart_diagram_poz_size);
        ResizerPozicioner.resize("#chart_holder_lines", this.chart_diagram_poz_size);
        this.draw_the_background();
        this.draw_the_coordinates();
    }
    this.count_bg_parcinja = function(){return Math.floor(this.chart_diagram_poz_size.w/this.chart_diagram_bg_parce_width);}
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
                    this.chart_diagram_bg_parce_width 
                    +
                    this.chart_diagram_poz_size.w-this.count_bg_parcinja()*this.chart_diagram_bg_parce_width
            );
            else
            $($("#charts__holder .background").find(".chart_bg_parce").last()).width(this.chart_diagram_bg_parce_width);
            $($("#charts__holder .background").find(".chart_bg_parce").last()).height(this.chart_diagram_poz_size.h);
        }
    }
    this.draw_the_coordinates = function()
    {
        var delta_cordinate_out = 5;
        var delta_values_plus = (this.chart_max_value-this.chart_min_value)/(Math.floor(this.count_bg_parcinja()/2)), 
        values_to_x_coordinate=this.chart_min_value;
        $(".coordinate_x").width( this.chart_diagram_poz_size.w+delta_cordinate_out );
        $(".coordinate_x").height( this.coordinates_weight );
        $(".coordinate_y").width( this.coordinates_weight );
        $(".coordinate_y").height( this.chart_diagram_poz_size.h+delta_cordinate_out );
        ResizerPozicioner.pozicion( ".coordinate_x", new Point(-1*delta_cordinate_out, this.chart_diagram_poz_size.h) );
        ResizerPozicioner.pozicion( ".coordinate_y", new Point(0, 0) );
        for(var i=0;i<this.count_bg_parcinja();i+=2)
        {
            $("#charts__holder .holder").append( $("#chart_coordinates_numbers_template").html() );
            var last_dash_number_coordinate = $("#charts__holder .holder").find(".chart_coordinates_numbers").last();
            $(last_dash_number_coordinate).find(".number").html( values_to_x_coordinate );
            $(last_dash_number_coordinate).find(".dash").height( delta_cordinate_out );
            $(last_dash_number_coordinate).find(".dash").width(this.coordinates_weight);
            var left_position = i*this.chart_diagram_bg_parce_width-$(last_dash_number_coordinate).width()/2;
            $(last_dash_number_coordinate).css("left", left_position+"px");
            $(last_dash_number_coordinate).css("top", this.chart_diagram_poz_size.h+"px");
            values_to_x_coordinate += delta_values_plus;
        }
    }
    /*
     * This function is for init line in y position, in height
     * And that line will be using in future for showing the result 
     * of the diagram
     * The name of the line is simple line
     * All references for the simple lines, all ids will be store into 
     * an array.With for loop should setup the results.
     * On start they will have value 0
     */
    this.simple_horizontal_lines_reference = [];
    this.add_simple_horizontal_line = function(id_line)
    {
        this.simple_horizontal_lines_reference.push( new ChartSimpleLineHorizontal( id_line ) );
    }
}

function ChartTest()
{
    this.init
    (
            new Rectangle(0,0,900,700),
            new Rectangle(30,30,770,400)
    );
    this.add_simple_horizontal_line("test_1");
    this.add_simple_horizontal_line("test_2");
    this.add_simple_horizontal_line("test_3");
}
ChartTest.prototype = new ChartBase();


function ChartModerator(){}
ChartModerator.CHART = null;

