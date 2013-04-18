<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'php/tools.php';

/*
 * Init the data for the dealers
 */
CHART_Dealer::init_dealers_according_to_user();
CHART_Dealer::init_all_dealers();

/*
 * Init the data for the chains
 */
CHART_Chain::init_all();
CHART_Chain::init_for_dealer();

/*
 * Init the data for the areas
 */
CHART_Area::init_all_areas();
CHART_Area::init_areas_for_dealer();

/*
 * Init all years and months from data 
 */
ChartData::init_all_years();
ChartData::init_all_months_periods();
?>
<link rel="stylesheet" href="graphs/css/charts_style.css" />
<script src="graphs/js/tools.js"></script>
<style>
    #chart_filters_block_holder
    {
        border:solid 1px #cccccc;
    }
</style>
<div id="chart_filters_block_holder">
<?php
require_once 'templates/chart_holder.php';
require_once 'templates/filters.php';
?>
</div>
<script>
    //ChartModerator.CHART = new ChartTest();
    ChartModerator.CHART = new Chart__ReasonToVisit();
</script>
