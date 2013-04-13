<style>
    
    #chart_main_holder
    {
        border:solid 1px #ff0000;
        position: relative;
    }
    #charts__holder
    {
        position: absolute;
        border:solid 1px #00ff00;
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
        background-color: #ff0000;
    }
    .chart_bg_white
    {
        background-color: #cccccc;
    }
    .coordinates
    {
        position: absolute;
        background-color: #0000ff;
    }
    .chart_coordinates_numbers
    {
        position: absolute;
    }
    .chart_coordinates_numbers .dash
    {
        margin:0 auto;
        background-color: #00ff00;
    }
    .chart_coordinates_numbers .number
    {
        font-family: "Arial";
        font-size: 12px;
        font-weight: bold;
        text-align: center;
    }
    #chart_holder_lines
    {
        position: absolute;
        border:solid 1px #ff0000;
        overflow: hidden;
    }
    .chart_holder_line_test
    {
        background-color:#00ff00;height: 30px; width: 200px; margin-top: 30px;
    }
    
</style>

<div id="chart_main_holder">
    <div id="charts__holder">
        <div class="holder">
            <div class="background"></div>
            <div class="coordinate_x coordinates"></div>
            <div class="coordinate_y coordinates"></div>
            
            <!--This div is holder for lines, vertical, or horizontal, that are showing 
            the resuluts-->
            <div id="chart_holder_lines">
                <!--
                <div style=""></div>
                -->
                <div id="template_simple_line_left_right_question">
                    <div class="simple_line_left_right_question">
                        <div class="simple_line_left_question">
                            
                        </div>
                        <div class="simple_line_right_question">
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!--Templates-->
<div style="display: none;">
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
</div>
<!--Templates-->
