<?php
require_once 'dompdf_tools.php';
require_once("dompdf_config.inc.php");

//$html_for_chart = $_SESSION["html_temp_for_pdf"];
$html_for_chart = "Λόγοι Επίσκεψης";
//require_once 'chart_html_example.php';

$html =
  '<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="style_chart_for_pdf.css" rel="stylesheet">
</head>
<body>
    <div class="relative">'.ChartDrawer::draw().'</div>
</body>
</html>';
//print $html;
 
$dompdf = new DOMPDF();

//$dompdf->set_paper('a4', 'landscape');
//$dompdf->set_paper(array(0,0,100,100), 'portrait');
$dompdf->set_paper( array(0,0, 12 * 72, 12 * 72), "portrait" ); // 12" x 12"

$dompdf->load_html($html);
$dompdf->render();
//$dompdf->output(array("compress"=>"0"));
//file_put_contents("chart_pdf_for_print.pdf", $dompdf->output(   ));
$dompdf->stream("chart_pdf_for_print.pdf", array('Attachment' => 0));
?>