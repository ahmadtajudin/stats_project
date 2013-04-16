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
    public function filter()
    {
        ?>
        <div class="floatLeft">
            <div>Group A</div>
            
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
                        <select></select>
                    </div>
                    <div>
                        <select></select>
                    </div>
                    <div>
                        <select></select>
                    </div>
                    <div>
                        <select></select>
                        <select></select>
                    </div>
                </div>
                <div class="clearBoth"></div>
            </div>
            
        </div>
        <?php
    }
}
ChartFilters::$FILTER = new ChartFilters();
?>
<style>
    #charts_filter_holder
    {
        height:200px;
        background-color:#cccccc; 
    }
</style>
<div id="charts_filter_holder">
    <?php ChartFilters::$FILTER->header(); ?>
    <div>
        <?php ChartFilters::$FILTER->filter(); ?>
        <?php ChartFilters::$FILTER->filter(); ?>
        <div class="clearBoth"></div>
    </div>
    
</div>
