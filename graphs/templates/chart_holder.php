<style>
    
    #chart_main_holder
    {
        /*
        border:solid 1px #ff0000;
        */
        position: relative;
        background-color: #ffffff;
    }
    #charts__holder
    {
        position: absolute;
        /*
        border:solid 1px #00ff00;
        */
    }
    #charts__holder .holder
    {
        position: relative;
    }
    #charts__holder .background
    {
        position: absolute;
    }
    .chart_bg_parce
    {
        float: left;
    }
    .chart_bg_blue
    {
        background-color: #e4f1fb;
    }
    .chart_bg_white
    {
        background-color: #f7fafd;
    }
    .coordinates
    {
        position: absolute;
        background-color: #3873b7;
    }
    .chart_coordinates_numbers
    {
        position: absolute;
    }
    .chart_coordinates_numbers .dash
    {
        margin:0 auto;
        background-color: #3873b7;
    }
    .chart_coordinates_numbers .number
    {
        font-family: "Arial";
        font-size: 12px;
        font-weight: bold;
        text-align: center;
        color:#3873b7;
    }
    #chart_lines
    {
        position: absolute;
        /*
        border:solid 1px #ff0000;
        */
        /*
        overflow: hidden;
        */
    }
    #chart_holder_lines
    {
        position:relative;
    }
    .chart_holder_line_test
    {
        background-color:#00ff00;height: 30px; width: 200px; margin-top: 30px;
    }
    
    #chart_top_left_title
    {
        position:absolute;
        left:20px;
        top:20px;
    }
    #chart_left_right_data_filter_above_the_cahrt
    {
        position:absolute;
        left:180px;
        top:50px;
    }
    #chart_left_right_data_filter_above_the_cahrt__date_info
    {
        margin-top: 10px;
        font-weight: bold;
    }
    
</style>

<div id="chart_main_holder">
    <div id="chart_top_left_title"></div>
    <div id="chart_left_right_data_filter_above_the_cahrt">
        <div>
            <div id="chart_left_right_data_filter_above_the_cahrt_info_left" class="floatLeft">
                <div>
                    <div class="floatLeft">
                        <img src="graphs/images/group_a_rectangle.jpg" />
                    </div>
                    <div class="floatLeft color_orange marginLeft10px">
                        <div>Αντιπρόσωποι:<b id="dealer_selected_info_A">Όλα</b></div>
                        <div>Αλυσίδα:<b id="chain_selected_info_A">Όλα</b></div>
                        <div>Περιοχή:<b id="area_selected_A">Όλα</b></div>
                        <div>Περίοδος:<b id="period_selected_A">Όλα</b></div>
                    </div>
                </div>
            </div>
            <div id="chart_left_right_data_filter_above_the_cahrt_info_right" class="floatLeft marginLeft50px">
                <div>
                    <div class="floatLeft">
                        <img src="graphs/images/group_b_rectangle.jpg" />
                    </div>
                    <div class="floatLeft color_blue marginLeft10px">
                        <div>Αντιπρόσωποι:<b id="dealer_selected_info_B">Όλα</b></div>
                        <div>Αλυσίδα:<b id="chain_selected_info_B">Όλα</b></div>
                        <div>Περιοχή:<b id="area_selected_B">Όλα</b></div>
                        <div>Περίοδος:<b id="period_selected_B">Όλα</b></div>
                    </div>
                </div>
            </div>
            <div class="clearBoth"></div>
        </div>
        <?php
        Chart_Year::init_last_date_changing();
        //print_r(Chart_Year::$last_date_changing_data);
        ?>
        <div id="chart_left_right_data_filter_above_the_cahrt__date_info">
            Τελευταία ενσωμάτωση δεδομένων: 
                <?php print Chart_Month::$months_labels_el[Chart_Year::$last_date_changing_data["Months"]-1]; ?> <?php print Chart_Year::$last_date_changing_data["Year"]; ?>
        </div>
    </div>
    
    <div id="charts__holder">
        <div class="holder">
            <div class="background"></div>
            
            <!--This div is holder for lines, vertical, or horizontal, that are showing 
            the resuluts
            it is resizing into js.
            it is hold div <div id="chart_holder_lines">, relative holder
            -->
            <div id="chart_lines">
                <!--
                <div style=""></div>
                -->
                <div id="chart_holder_lines">
                    
                </div>
            </div>
            
            <div class="coordinate_x coordinates"></div>
            <div class="coordinate_y coordinates"></div>
            
        </div>
    </div>
    
</div>
<script>
    $("#chart_left_right_data_filter_above_the_cahrt_info_right").css("opacity", 0);
</script>

<!--Templates-->
<div class="displayNone">
    <div id="chart_bg_blue_template">
        <div class="chart_bg_blue chart_bg_parce"></div>
    </div>
    <div id="chart_bg_white_template">
        <div class="chart_bg_white chart_bg_parce"></div>
    </div>
    <div id="chart_coordinates_numbers_template">
        <div class="chart_coordinates_numbers">
            <div class="dash"></div>
            <div class="number">100</div>
        </div>
    </div>
    
    <!--
    Template chart line, x2 lines, percent, left label
    -->
        
    <style>
        .simple_line_left_right_question
        {
            position:absolute;
        }
        .simple_line_left_question
        {
            position:absolute;
            top: -30px;
        }
        .simple_line_right_question
        {
            position:absolute;
            top:0px;
        }
        .simple_line_left_right_question .line_color_width, .simple_line_left_right_question .line_percent
        {
            float: left;
        }
        .simple_line_left_right_question .line_percent
        {
            line-height: 30px;
        }
        .simple_line_left_question .line_color_width
        {
            background-color: #f89734;
        }
        .simple_line_right_question .line_color_width
        {
            background-color: #0066ff;
        }
        .simple_line_left_right_question .simple_line_left_question .line_color_width
        {
            height: 30px;
            width:50px;
        }
        .simple_line_left_right_question .simple_line_right_question .line_color_width
        {
            height: 30px;
            width:200px;
        }
        .simple_line_left_right_question .chart_label
        {
            position:absolute;
            left: -105px;
            width: 100px;
            text-align: right;
        }
    </style>
    <div id="template_simple_line_left_right_question" class="displayNone">
        <div class="simple_line_left_right_question">
            <div class="posRel">
                <div class="chart_label">
                    Line1<br/>Line2<br/>Line3
                </div>
                <div class="simple_line_left_question line">
                    <div>
                        <div class="line_color_width"></div>
                        <div class="line_percent">100%</div>
                        <div class="clearBoth"></div>
                    </div>
                </div>
                <div class="simple_line_right_question line">
                    <div>
                        <div class="line_color_width"></div>
                        <div class="line_percent">100%</div>
                        <div class="clearBoth"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>
<!--Templates-->
