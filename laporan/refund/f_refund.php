<?php
ob_start();
 include "refund.php";
 date_default_timezone_set('Asia/Jakarta');
 $content = ob_get_clean();
$date=date('d-m-Y');
// conversion HTML => PDF
 require_once "../../pdf/html2pdf.class.php";
 try
 {
 $html2pdf = new HTML2PDF('P','A4', 'en', false, 'ISO-8859-15');
 $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
 $html2pdf->Output('""'.$date.'"-vbpd.pdf');
 }
 catch(HTML2PDF_exception $e) { echo $e; }
?>