<?php
session_start();
require_once("dompdf_config.inc.php");

//$html_for_chart = $_SESSION["html_temp_for_pdf"];
$html_for_chart = "Λόγοι Επίσκεψης";
//require_once 'chart_html_example.php';

$html =
  '<html><head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style></style>
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
        </head><body>'.$html_for_chart.'</body></html>';
//print $html;
 
$dompdf = new DOMPDF(); 
$dompdf->load_html($html);
$dompdf->render();
$dompdf->set_paper('a4', 'portrait');
//$dompdf->output(array("compress"=>"0"));
//file_put_contents("chart_pdf_for_print.pdf", $dompdf->output(   ));
$dompdf->stream("chart_pdf_for_print.pdf", array('Attachment' => 0));
?>