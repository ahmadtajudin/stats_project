<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="graphs/css/charts_style.css" media="screen" />
        <link rel="stylesheet" href="graphs/css/charts_style.css" media="print" />
        
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" media="screen" />

        <link rel="stylesheet" href="bootstrap/css/datepicker.css" media="screen" />
        <link rel="stylesheet" href="bootstrap/css/datepicker.css" media="print" />
        <link rel="stylesheet" href="style.css" media="screen" />
        <link rel="stylesheet" href="style.css" media="print" />
        
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.file-input.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/tools.js"></script>
        
        <style>
            .window_roll_over_disablator
            {
                position:fixed;
                width:100%;
                height:100%;
                /*
                background-color: #ff0000;
                */
                left:0px;
                top:0px;
            }
            .window_roll_over_disablator img
            {
                top: 100px;
                right: 100px;
            }
        </style>
    </head>
    <body>
        <div id="html_hodler_for_print">
            <!--
            <div class="window_roll_over_disablator test_print">
                <div class="posRel">
                    <img src="images/print-icon.png" />
                </div>
            </div>
            -->
        </div>
        <div class="window_roll_over_disablator">
            <div class="posRel">
                <img class="posAbs" id="image_print" src="images/print-icon.png" />
            </div>
        </div>
        <script>
            $(".window_roll_over_disablator").click(function(e)
            {
                $("#image_print").addClass("displayNone");
                window.print();
            });
            /*
            $(".window_roll_over_disablator").mouseover(function(e)
            {
                $("#image_print").show(500);
            });
            $(".window_roll_over_disablator").mouseout(function(e)
            {
                $("#image_print").hide(500); 
            });*/
            function init(html)
            {
                $("#html_hodler_for_print").append(html);
                $("#filter_header").addClass("displayNone");
                $("#filter_show_hide_group_B").addClass("displayNone");
                $("#filter_options_group__A").addClass("displayNone");
                $("#filter_options_group__B").addClass("displayNone");
                $("#reset_button").addClass("displayNone");
            }
        </script>
        <!--
        -->
    </body>
</html>
