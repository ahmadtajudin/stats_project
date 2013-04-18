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
        <div>
            <div class="floatLeft">
                <input type="button" value="Εκτύπωση" />
            </div>
            <div class="floatLeft">ΛΟΓΟΙ ΕΠΙΣΚΕΨΗΣ</div>
            <div class="clearBoth"></div>
        </div>
        <?php
    }
    public function filter($filter_type)
    {
        ?>
        <div class="floatLeft">
            <div>
                <div class="floatLeft">
                    <?php
                    if($filter_type == self::GROUP_A)
                    {
                        ?>
                    Group A
                    <?php
                    }
                    else
                    {
                        ?>
                    Group B
                    <?php
                    }
                    ?>
                </div>
                <div class="floatLeft">
                    Ενεργοποίηση <input type="radio" />
                    Απενεργοποίηση σύγκρισης <input type="radio" />
                </div>
                <div class="clearBoth"></div>
            </div>
            
            <!--
            Total interviews+total passby values
            start
            -->
            <div>
                <div class="floatLeft">
                    <div>Σύνολο συνεντεύξεων:</div>
                    <div>Σύνολο διελέυσεων:</div>
                </div>
                <div class="floatLeft">
                    <div>8443</div>
                    <div>134872</div>
                </div>
                <div class="clearBoth"></div>
            </div>
            <!--
            Total interviews+total passby values
            end
            -->
            <div>
                <div class="floatLeft">
                    <div>Αντιπρόσωποι:</div>
                    <div>Αλυσίδα:</div>
                    <div>Περιοχή:</div>
                    <div>Περίοδος:</div>
                </div>
                <div class="floatLeft">
                    <div>
                        <select <?php $this->add_name_id("dealers_options", $filter_type); ?> class="filter_global_select">
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
                            <option value="<?php print $dealer->id; ?>"><?php print $dealer->dealer_name; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <select <?php $this->add_name_id("chains_options", $filter_type); ?> class="filter_global_select">
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
                        <select <?php $this->add_name_id("areas_options", $filter_type); ?> class="filter_global_select">
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
                        <select <?php $this->add_name_id("years_options", $filter_type); ?> class="filter_global_select">
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
                        <select <?php $this->add_name_id("months_periods_options", $filter_type); ?> class="filter_global_select">
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
                <input id="reset_button" type="button" value="Επαναφορά φίλτρων" />
            </div>
            <?php }else if($filter_type == self::GROUP_B){ ?>
            <!--Draw chart button-->
            <div>
                <input type="button" value="Σχεδίαση γραφήματος" />
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
        padding: 50px 20px 50px 20px;
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
}
FiltersModerator.FM = new FiltersModerator();

$("#reset_button").click(function(e)
{
    FiltersModerator.FM.reset();
});
$(".filter_global_select").change(function(e)
{
    ChartModerator.CHART.load_data(e);
});
</script>
