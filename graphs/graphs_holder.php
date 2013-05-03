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
        min-width: 930px;
    }
</style>
<div id="chart_filters_block_holder">
<?php
require_once 'templates/chart_holder.php';
require_once 'templates/filters.php';
?>
</div>
<?php if(!isset($_GET["chart"])){$_GET["chart"] = "le";} ?>
<script>
    //ChartModerator.CHART = new ChartTest();
    <?php
    switch($_GET["chart"])
    {
        case "le":{ ?> ChartModerator.CHART = new Chart__ReasonToVisit(); <?php }break;
        case "ee":{ ?> ChartModerator.CHART = new Chart__RepeatedVisits(); <?php }break;
        case "1":{ ?> ChartModerator.CHART = new Chart__GeneralImpresions(); <?php }break;
        case "2":{ ?> ChartModerator.CHART = new Chart__Objects(); <?php }break;
        case "3":{ ?> ChartModerator.CHART = new Chart__Personal(); <?php }break;
        case "4":{ ?> ChartModerator.CHART = new Chart__QuestionsOnTime(); <?php }break;
        case "5":{ ?> ChartModerator.CHART = new Chart__Quality(); <?php }break;
        case "6":{ ?> ChartModerator.CHART = new Chart__Quality_again_testing(); <?php }break;
        case "7":{ ?> ChartModerator.CHART = new Chart__Costs(); <?php }break;
        case "8":{ ?> ChartModerator.CHART = new Chart__FollowUp(); <?php }break;
        case "9":{ ?> ChartModerator.CHART = new Chart__InFuture(); <?php }break;
        case "10":{ ?> ChartModerator.CHART = new Chart__CloseCall(); <?php }break;
    }
    ?>
</script>
