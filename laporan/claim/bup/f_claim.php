<?php
    ob_start();
    include "claim.php";
    $content = ob_get_clean();
    $date=date('d-m-Y');
	$fregid=$_GET['id'].'.pdf';
    // conversion HTML => PDF
    require_once "../../pdf/html2pdf.class.php";
    try {
        $html2pdf = new HTML2PDF('P','A4', 'en', false, 'ISO-8859-15');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Checklist Claim-'.$r1['nama'].'-'.$r1['regid'].'.pdf'); 
		/* $html2pdf->Output($fregid,'f');  */
    }
    catch(HTML2PDF_exception $e) { echo $e; }
	/* header("location:../../laporan/claim/".$fregid  ); */
?>
