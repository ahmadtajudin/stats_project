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
        font-size: 20px;
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
    
    #legend_chart
    {
        margin-top: 10px;
        width:650px;
        /*
        border:solid 1px;
        */
    }
    #legend_chart .legend_rectangle_holder
    {
        padding-top: 5px;
    }
    #legend_chart .legent_label
    {
        line-height: 20px;
        margin-left: 5px;
    }
    .legend_rectangle
    {
        width:10px;
        height:10px;
        background-color: #000000;
    }
    .legend_label_holder
    {
        margin-left:10px;
        margin-right:10px;
        float:left;
    }
    
    #average_form
    {
        position:absolute;
        /*left:740px;*/
        left:10px;
        top:50px;
        padding:20px;
        background-color: #ffffff;
    }
    .average_form___results
    {
        font-size:20px;
    }
    .avetage_form_line
    {
        line-height: 20px;
    }
    .average_form_title
    {
        margin-bottom: 10px;
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
        <div id="legend_chart" class="displayNone">
            
            <div id="legend_label_holder_template" class="displayNone">
                <div class="legend_label_holder">
                    <div>
                        <div class="floatLeft legend_rectangle_holder"><div class="legend_rectangle"></div></div>
                        <div class="floatLeft legent_label">Πολύ απογοητευμένος (1)</div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="clearBoth"></div>
    </div>
    
    <div id="average_form" class="displayNone">
        <div class="avetage_form_line average_form_title">Μέσος όρος</div>
        <div class="avetage_form_line" id="average_form___resulta_A_holder">Group A: <span class="average_form___results">-</span></div>
        <div class="avetage_form_line displayNone" id="average_form___resulta_B_holder">Group B: <span class="average_form___results">-</span></div>
    </div>
    <script>
        $('#average_form')
    .shadow({type:'sides', sides:'hz-1'});
    </script>
    
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
        .simple_line_left_right_question .line_color_width
        {
            position:relative;
        }
        .simple_line_left_right_question .line_percent
        {
            /*float: left;*/
            position: absolute;
            right:-105px;
            width:100px;
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
            left: -155px;
            width: 150px;
            text-align: right;
            font-size: 12px;
        }
    </style>
    <div id="template_simple_line_left_right_question" class="displayNone">
        <div class="simple_line_left_right_question">
            <div class="posRel">
                <div class="chart_label tool_tip_labels" data-toggle="tooltip" data-placement="top" title="">
                    Line1<br/>Line2<br/>Line3
                </div>
                <div class="simple_line_left_question line">
                    <div>
                        <div class="line_color_width">
                            <div class="line_percent">100%</div>
                        </div>
                    </div>
                </div>
                <div class="simple_line_right_question line">
                    <div>
                        <div class="line_color_width">
                            <div class="line_percent">100%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .xN_AreasLine
        {
            position:absolute;
        }
        .xN_AreasLine_line
        {
            position: absolute;
        }
        .xN_AreasLine_right
        {
            border-top:solid 2px #000000;
        }
        .xN_partHolder
        {
            float: left;
            height: 30px;
        }
        .xN_partHolder_percent_label
        {
            text-align: center;
            line-height: 30px;
            overflow: hidden;
            /*
            border:solid 1px;
            */
        }
        .xN_AreasLine_label
        {
            position:absolute;
            width: 130px;
            font-size: 12px;
        }
        .xN_AreasLine_left_label
        {
            text-align: left;
            background:url('images/bg_gray_to_white.jpg') repeat-y;
            padding-left: 10px;
        }
        .xN_AreasLine_right_label
        {
            text-align: left;
        }
        .xN_AreasLine_left_coeficient
        {
            position:absolute;
            left:-50px;
            top:0px;
            font-size: 9px;
            font-weight: bold;
            line-height: 15px;
            /*border:solid 1px;*/
            text-align: right;
            width:45px;
        }
    </style>
    <div id="template_xN_AreasLine"  class="displayNone">
        <div class="xN_AreasLine">
            <div class="posRel">
                <div class="xN_AreasLine_left_label xN_AreasLine_label tool_tip_labels" 
                     data-toggle="tooltip" data-placement="top" data-original-title="not defined">
                </div>
                <div class="xN_AreasLine_right xN_AreasLine_line">
                    <div class="posRel">
                        <div class="xN_AreasLine_left_coeficient">
                            -
                        </div>
                    </div>
                    <div class="xN_AreasLine_parts_holder"></div>
                    <div class="clearBoth"></div>
                </div>
                <div class="xN_AreasLine_left xN_AreasLine_line">
                    <div class="posRel">
                        <div class="xN_AreasLine_left_coeficient">
                            -
                        </div>
                    </div>
                    <div class="xN_AreasLine_parts_holder"></div>
                    <div class="clearBoth"></div>
                </div>
                <div class="xN_AreasLine_right_label xN_AreasLine_label"></div>
            </div>
        </div>
    </div>
    <div id="template_xN_partHolder" class="displayNone">
        <div class="xN_partHolder ">
            <div class="posRel">
                <div class="xN_partHolder_percent_label">-
                </div>
            </div>
        </div>
    </div>
    
</div>
<!--Templates-->
