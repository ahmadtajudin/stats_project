<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'php/tools.php';
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
    ChartModerator.CHART = new ChartTest();
</script>
