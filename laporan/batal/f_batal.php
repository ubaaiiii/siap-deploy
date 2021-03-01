<?php
    ob_start();
    include "batal.php";
    $content = ob_get_clean();
    $date=date('d-m-Y');
	$fregid=$_GET['id'].'.pdf';
	$sid=$_GET['id'];
    // conversion HTML => PDF
    require_once "../../pdf/html2pdf.class.php";
    try {
        $html2pdf = new HTML2PDF('P','A4', 'en', false, 'ISO-8859-15');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($sid.$date.'"-vbpd.pdf'); 

    }
    catch(HTML2PDF_exception $e) { echo $e; }
	header("location:../../laporan/batal/".$fregid  );
?>
