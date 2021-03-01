<?php
include("../../config/koneksi.php");
$aRange = (isset($_GET['aRange']))?($_GET['aRange']):($_POST['aRange']);
$bRange = (isset($_GET['bRange']))?($_GET['bRange']):($_POST['bRange']);
$tipe = (isset($_GET['tipe']))?($_GET['tipe']):($_POST['tipe']);

switch($tipe){
    case "bulan":
        $custSelect = "LEFT(p.`paiddt`,7) grup, ";
        $custGroup = "GROUP BY LEFT(p.`paiddt`,7) ";
        $custOrder = "ORDER BY LEFT(p.`paiddt`,7) ";
        break;
    case "minggu":
        $custSelect = "CONCAT (str_to_date(concat(yearweek(p.`paiddt`, 2),' Sunday'), '%X%V %W'), ' s/d ', str_to_date(concat(yearweek(p.`paiddt`, 2),' Sunday'), '%X%V %W') + interval 6 day ) grup, ";
        $custGroup = "GROUP BY CONCAT (str_to_date(concat(yearweek(p.`paiddt`, 2),' Sunday'), '%X%V %W'), ' s/d ', str_to_date(concat(yearweek(p.`paiddt`, 2),' Sunday'), '%X%V %W') + interval 6 day ) ";
        $custOrder = "ORDER BY CONCAT (str_to_date(concat(yearweek(p.`paiddt`, 2),' Sunday'), '%X%V %W'), ' s/d ', str_to_date(concat(yearweek(p.`paiddt`, 2),' Sunday'), '%X%V %W') + interval 6 day ) ";
        break;
    case "hari":
        $custSelect = "LEFT(p.`paiddt`,10) grup, ";
        $custGroup = "GROUP BY LEFT(p.`paiddt`,10) ";
        $custOrder = "ORDER BY LEFT(p.`paiddt`,10) ";
        break;
}

$sqlPremi = "SELECT ".$custSelect."Sum(`premi`) premi, sum(`up`) up
                        FROM        `tr_sppa` t
                        INNER JOIN  `tr_sppa_paid` p ON p.`regid` = t.`regid`
                        WHERE  `status` >= 5
                               AND `status` NOT IN ( 10, 11, 12, 13 )
                               AND p.`paiddt` BETWEEN '".$aRange."' AND '".$bRange."'
                        ".$custGroup.$custOrder." ";

$resPremi = $db->query($sqlPremi);

// echo $sqlPremi;

while ($rowPremi = $resPremi->fetch_assoc()) {
    $label[] = $rowPremi['grup'];
    $premi[] = $rowPremi['premi'];
    $up[] = $rowPremi['up'];
}
$dataReturn = array('label'=>$label,'premi'=>$premi,'up'=>$up);
echo json_encode($dataReturn);

?>