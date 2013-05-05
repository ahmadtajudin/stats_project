<style>
    
    .filter_global_select
    {
        width:120px;
    }
    
</style>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ChartFilters
{
    const GROUP_A="A";
    const GROUP_B="B";
    public static $FILTER = NULL;
    
    public function ChartFilters(){}
    
    /*
     * Using this function will add the header of the filter.
     * One button + the label of the chart
     */
    public function header()
    {
        ?>
        <div id="filter_header" class="marginBottom15px">
            <div class="floatLeft">
                <!--
                <input type="button" value="Εκτύπωση" />
                -->
                <button id="print_button" class="btn btn-inverse" type="button">Εκτύπωση</button>
            </div>
            <div class="floatLeft marginLeft10px lineHeight30px"><b id="filter_chart_label"></b></div>
            <div class="clearBoth"></div>
        </div>
        <?php
    }
    public function filter($filter_type)
    {
        ?>
        <div class="floatLeft <?php if($filter_type==self::GROUP_B)print "marginLeft50px"; ?>">
            <div class="marginBottom5px">
                
                    <?php
                    if($filter_type == self::GROUP_A)
                    {
                        ?>
                <div class="floatLeft color_orange"><b>Group A</b></div>
                    <?php
                    }
                    else
                    {
                        ?>
                <div class="floatLeft color_blue"><b>Group B</b></div>
                    <?php
                    }
                    ?>
                
                <?php if($filter_type == self::GROUP_B){ ?>
                <div id="filter_show_hide_group_B" class="floatLeft marginLeft50px">
                    Ενεργοποίηση             <input value="1" name="show_or_hider_line_B" class="show_or_hider_line_B" type="radio" />
                    Απενεργοποίηση σύγκρισης <input value="0" name="show_or_hider_line_B" class="show_or_hider_line_B" type="radio" checked="checked" />
                </div>
                <?php } ?>
                <div class="clearBoth"></div>
            </div>
            
            <!--
            Total interviews+total passby values
            start
            -->
            <div class="marginBottom15px">
                <div class="floatLeft">
                    <div>Σύνολο συνεντεύξεων:</div>
                    <div>Σύνολο διελέυσεων:</div>
                </div>
                <div class="floatLeft <?php if($filter_type==self::GROUP_A)print "color_orange";else print "color_blue"; ?> marginLeft10px">
                    <div><b <?php $this->add_name_id("total_interviews", $filter_type); ?>>-</b></div>
                    <div><b <?php $this->add_name_id("total_passby", $filter_type); ?>>-</b></div>
                </div>
                <div class="clearBoth"></div>
            </div>
            <!--
            Total interviews+total passby values
            end
            -->
            <div <?php $this->add_name_id("filter_options_group", $filter_type); ?> class="marginBottom15px">
                <div class="floatLeft labels_select_for_boxes">
                    <div>Αντιπρόσωποι:</div>
                    <div>Αλυσίδα:</div>
                    <div>Περιοχή:</div>
                    <div>Περίοδος:</div>
                </div>
                <div class="floatLeft">
                    <div>
                        <select <?php $this->add_name_id("dealers_options", $filter_type); ?> for_type="<?php print $filter_type; ?>" 
                                                                                         class="filter_global_select filter_global_select_for_type_<?php print $filter_type; ?>">
                            <option value="-1">Όλα</option>
                            <?php
                            if($filter_type == self::GROUP_A)
                            {
                                CHART_Dealer::$dealers_list_for_using = CHART_Dealer::$all_dealers;
                            }
                            else if($filter_type == self::GROUP_B && 
                                    CHART_User::$LOGGED_USER->user_type == CHART_User::TYPE_DEALER)
                            {
                                CHART_Dealer::$dealers_list_for_using = CHART_Dealer::$all_dealers_according_to_user;
                            }
                                for($i=0;$i<count(CHART_Dealer::$dealers_list_for_using);$i++)
                                {
                                    $dealer = new CHART_Dealer(CHART_Dealer::$dealers_list_for_using[$i]);
                            ?>
                            <option value="<?php print $dealer->dealer_code; ?>"><?php print $dealer->dealer_name; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <select <?php $this->add_name_id("chains_options", $filter_type); ?> for_type="<?php print $filter_type; ?>" 
                                                                                             class="filter_global_select filter_global_select_for_type_<?php print $filter_type; ?>">
                            <option value="-1">Όλα</option>
                            <?php
                            if($filter_type == self::GROUP_A)
                            {
                                CHART_Chain::$chains_for_using = CHART_Chain::$all_chains;
                            }
                            else if($filter_type == self::GROUP_B && 
                                    CHART_User::$LOGGED_USER->user_type == CHART_User::TYPE_DEALER)
                            {
                                CHART_Chain::$chains_for_using = CHART_Chain::$all_chains_when_dealer;
                            }
                            for($i=0;$i<count(CHART_Chain::$chains_for_using);$i++)
                            {
                                $chain = new CHART_Chain( CHART_Chain::$chains_for_using[$i] );
                            ?>
                            <option value="<?php print $chain->id; ?>"><?php print $chain->chain_name_en; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <select <?php $this->add_name_id("areas_options", $filter_type); ?> for_type="<?php print $filter_type; ?>" 
                                                                                            class="filter_global_select filter_global_select_for_type_<?php print $filter_type; ?>">
                            <option value="-1">Όλα</option>
                            <?php
                            if($filter_type == self::GROUP_A)
                            {
                                CHART_Area::$all_areas_for_using = CHART_Area::$all_areas;
                            }
                            else if($filter_type == self::GROUP_B && 
                                    CHART_User::$LOGGED_USER->user_type == CHART_User::TYPE_DEALER)
                            {
                                CHART_Area::$all_areas_for_using = CHART_Area::$all_areas_for_dealer;
                            }
                            for($i=0;$i<count(CHART_Area::$all_areas_for_using);$i++)
                            {
                                $area_object = new CHART_Area( CHART_Area::$all_areas_for_using[$i] );
                            ?>
                            <option value="<?php print $area_object->id; ?>"><?php print $area_object->area_name_gr; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <select <?php $this->add_name_id("years_options", $filter_type); ?> for_type="<?php print $filter_type; ?>" 
                                                                                            class="filter_global_select filter_global_select_for_type_<?php print $filter_type; ?>">
                            <option value="-1">Όλα</option>
                            <?php
                            for($i=0;$i<count(ChartData::$all_years);$i++)
                            {
                            ?>
                            <option value="<?php print ChartData::$all_years[$i]["Year"]; ?>">
                                <?php print ChartData::$all_years[$i]["Year"]; ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                        <select <?php $this->add_name_id("months_periods_options", $filter_type); ?> for_type="<?php print $filter_type; ?>" 
                                                                                                     class="filter_global_select filter_global_select_for_type_<?php print $filter_type; ?>">
                            <option value="-1">Όλα</option>
                            <?php
                            for($i=0;$i<count(ChartData::$all_months_periods);$i++)
                            {
                            ?>
                            <option value="<?php print ChartData::$all_months_periods[$i]["id"]; ?>">
                                <?php print ChartData::$all_months_periods[$i]["month_name_gr"]; ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="clearBoth"></div>
            </div>
            
            <?php if($filter_type == self::GROUP_A){ ?>
            <!--Set start values button-->
            <div>
                <!--
                <input id="reset_button" type="button" value="Επαναφορά φίλτρων" />
                -->
                <button id="reset_button" class="btn btn-inverse" type="button">Επαναφορά φίλτρων</button>
            </div>
            <?php }else if($filter_type == self::GROUP_B){ ?>
            <!--Draw chart button-->
            <div>
                <!--
                <input type="button" value="Σχεδίαση γραφήματος" />
                -->
                <!--
                <button class="btn btn-inverse" type="button">Σχεδίαση γραφήματος</button>
                -->
            </div>
            <?php } ?>
            
        </div>
        <?php
    }
    private function add_name_id($name_form, $filter_type)
    {
        print 'id="'.$name_form.'__'.$filter_type.'" name="'.$name_form.'__'.$filter_type.'"';
    }
}
ChartFilters::$FILTER = new ChartFilters();
?>
<style>
    #charts_filter_holder
    {
        background-color:#cccccc; 
        padding: 30px 50px 30px 50px;
    }
    .filter_global_select
    {
        margin:0px;
    }
    .labels_select_for_boxes div
    {
        line-height: 29px;
    }
</style>
<div id="charts_filter_holder">
    <?php ChartFilters::$FILTER->header(); ?>
    <div>
        <?php ChartFilters::$FILTER->filter( ChartFilters::GROUP_A ); ?>
        <?php ChartFilters::$FILTER->filter( ChartFilters::GROUP_B ); ?>
        <div class="clearBoth"></div>
    </div>
    
</div>


<script>
function FiltersModerator()
{
    this.reset = function()
    {
        $(".filter_global_select").prop("selectedIndex", 0);
    }
    
    /*
     * It is adding all variables from #charts_filter_holder, to object
     * and that object pass data to server
     */
    this.add_variables_to_object = function(object_ref)
    {
        for(var i=0;i<$("#charts_filter_holder").find("select").length;i++)
        {
            var select = $("#charts_filter_holder").find("select").get(i);
            object_ref[$(select).attr("name")] = $(select).val();
        }
    }
   
    /*
     * Above charts there are labels, they should show the info about selected values
     * into the filter.
     * 
                        <div>Αντιπρόσωποι:<b id="dealer_selected_info_A">Όλα</b></div>
                        <div>Αλυσίδα:<b id="chain_selected_info_A">Όλα</b></div>
                        <div>Περιοχή:<b id="area_selected_A">Όλα</b></div>
                        <div>Περίοδος:<b id="period_selected_A">Όλα</b></div>
     */
    this.show_filter_selected_to_the_top_label = function()
    {
        this.show_filter_selected_to_the_top_label_by_group( FiltersModerator.TYPE_ORANGE );
        this.show_filter_selected_to_the_top_label_by_group( FiltersModerator.TYPE___BLUE );
    }
    this.show_filter_selected_to_the_top_label_by_group = function(group_type)
    {
        $("#dealer_selected_info_"+group_type).html( $("#dealers_options__"+group_type+" option:selected").text() );
        $("#chain_selected_info_"+group_type).html( $("#chains_options__"+group_type+" option:selected").text() );
        $("#area_selected_"+group_type).html( $("#areas_options__"+group_type+" option:selected").text() );
        $("#period_selected_"+group_type).html
        ( 
                $("#years_options__"+group_type+" option:selected").text()
                    +
                $("#months_periods_options__"+group_type+" option:selected").text()
        );
    }
    
    /*
     * Function for printing the page
     */
    this.print = function()
    {
        //window.frames["window_for_print"] = new Window();
        //alert(window.frames.length);
        var wind_temp = window.open("print_the_chart.php", "my_window_for_print");
        /*
        for(var i in wind_temp.document)
        {
            //console.log(i+":"+wind_temp.document[i])
        }*/
        //alert(wind_temp.document.innerHTML);
        //wind_temp.document
        
        //alert(wind_temp.document.body.innerHTML);
        //wind_temp.document.body.innerHTML += $("#chart_filters_block_holder").html();
        wind_temp.onload = function()
        {
        wind_temp.init( $("#chart_filters_block_holder").html() ); 
        }
        /*
        wind_temp.document.body.innerHTML += ( 
                "<script>$(window).click(function(e){window.print();});alert(12);<'/script>" 
    );*/
        /*
        wind_temp.focus();
        wind_temp.print();
        wind_temp.close();
        */
        //window.print();
    }
}
FiltersModerator.FM = new FiltersModerator();
FiltersModerator.TYPE_ORANGE = "A";
FiltersModerator.TYPE___BLUE = "B";

$("#reset_button").click(function(e)
{
    FiltersModerator.FM.reset();
    ChartModerator.CHART.load_data(e);
    FiltersModerator.FM.show_filter_selected_to_the_top_label();
});
$(".filter_global_select").change(function(e)
{
    ChartModerator.CHART.load_data(e);
    FiltersModerator.FM.show_filter_selected_to_the_top_label();
});
$(".show_or_hider_line_B").click(function(e)
{
    ChartModerator.CHART.set_visibility_line_B();
    //alert($("input[name='show_or_hider_line_B']").val());
    //alert($("input[name='show_or_hider_line_B']").val()=="1");
    $(".filter_global_select_for_type_B").prop("disabled", $("input:radio[name='show_or_hider_line_B']:checked").val()=="0");
});
$("#print_button").click(function(e)
{
    FiltersModerator.FM.print();
});
</script>
