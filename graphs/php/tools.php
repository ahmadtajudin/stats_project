<?php
if(!isset($_SESSION))
{
    session_start();
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'settings.php';
require_once 'db_details.php';
require_once 'charts_data/data_moderator.php';
require_once 'charts_data/chart_data.php';
require_once 'user.php';
require_once 'dealer.php';
require_once 'chain.php';
require_once 'area.php';
require_once 'month.php';
require_once 'year.php';

CHART_User::init_logged_user();
/*
 * Loading library for data passing to the charts.
 */
require_once 'charts_data/charts_moderator/reason_to_visit.php';
require_once 'charts_data/charts_moderator/total_visits.php';
require_once 'charts_data/charts_moderator/general_impresions.php';
require_once 'charts_data/charts_moderator/objects.php';
require_once 'charts_data/charts_moderator/personal.php';
require_once 'charts_data/charts_moderator/questions_on_time.php';
require_once 'charts_data/charts_moderator/quality.php';
require_once 'charts_data/charts_moderator/quality_again_testing.php';
require_once 'charts_data/charts_moderator/costs.php';
require_once 'charts_data/charts_moderator/follow_up.php';
require_once 'charts_data/charts_moderator/in_future.php';
require_once 'charts_data/charts_moderator/close_call.php';
require_once 'charts_data/charts_moderator/contact_client_delegation.php';

if(isset($_GET["ADD_RANDOM_PASSWORDS_TO_DEALERS"]))
{
    CHART_User::ADD_RANDOM_PASSWORDS_TO_DEALERS();
}


?>
