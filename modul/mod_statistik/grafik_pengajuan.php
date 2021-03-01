<?php
include("../../config/koneksi.php");
$aRange = (isset($_GET['aRange']))?($_GET['aRange']):($_POST['aRange']);
$bRange = (isset($_GET['bRange']))?($_GET['bRange']):($_POST['bRange']);
$tipe = (isset($_GET['tipe']))?($_GET['tipe']):($_POST['tipe']);

switch($tipe){
    case "bulan":
        $custSelect = "LEFT(`createdt`,7) grup, ";
        $custGroup = "GROUP BY LEFT(`createdt`,7) ";
        $custOrder = "ORDER BY LEFT(`createdt`,7) ";
        break;
    case "minggu":
        $custSelect = "CONCAT (str_to_date(concat(yearweek(`createdt`, 2),' Sunday'), '%X%V %W'), ' s/d ', str_to_date(concat(yearweek(`createdt`, 2),' Sunday'), '%X%V %W') + interval 6 day ) grup, ";
        $custGroup = "GROUP BY CONCAT (str_to_date(concat(yearweek(`createdt`, 2),' Sunday'), '%X%V %W'), ' s/d ', str_to_date(concat(yearweek(`createdt`, 2),' Sunday'), '%X%V %W') + interval 6 day ) ";
        $custOrder = "ORDER BY CONCAT (str_to_date(concat(yearweek(`createdt`, 2),' Sunday'), '%X%V %W'), ' s/d ', str_to_date(concat(yearweek(`createdt`, 2),' Sunday'), '%X%V %W') + interval 6 day ) ";
        break;
    case "hari":
        $custSelect = "LEFT(`createdt`,10) grup, ";
        $custGroup = "GROUP BY LEFT(`createdt`,10) ";
        $custOrder = "ORDER BY LEFT(`createdt`,10) ";
        break;
}

$sqlPengajuan = "SELECT ".$custSelect."
                        COUNT(`regid`)                        pengajuan,
                        SUM(IF(`policyno` IS NOT NULL, 1, 0)) sertifikat,
                        SUM(IF(`status` = 12, 1, 0))          reject
                        FROM    `tr_sppa` t
                        WHERE `createdt` BETWEEN '".$aRange."' AND '".$bRange."'
                        ".$custGroup.$custOrder." ";

$resPengajuan = $db->query($sqlPengajuan);

// echo $sqlPengajuan;

while ($rowPengajuan = $resPengajuan->fetch_assoc()) {
    $label[] = $rowPengajuan['grup'];
    $pengajuan[] = $rowPengajuan['pengajuan'];
    $sertifikat[] = $rowPengajuan['sertifikat'];
    $reject[] = $rowPengajuan['reject'];
}
$dataReturn = array('label'=>$label,'pengajuan'=>$pengajuan,'sertifikat'=>$sertifikat,'reject'=>$reject);
echo json_encode($dataReturn);

?>