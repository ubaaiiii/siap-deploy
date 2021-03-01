<?php
include("../../config/koneksi.php");
if (isset($_POST['bulannya'])) {
    $bulannya = $_POST['bulannya'];    
} else {
    $bulannya = $_GET['bulannya'];
}

$resPremi = $db->query("SELECT Sum(t.`premi`) premi
                        FROM   `tr_sppa` t
                        JOIN   `tr_sppa_paid` p on t.`regid` = p.`regid`
                        WHERE  t.`status` = 20
                               AND LEFT(p.`paiddt`, 7) = '$bulannya'  ");

while ($rowPremi = $resPremi->fetch_assoc()) {
	$dataPremi = $rowPremi['premi'];
// 	$dataPremi = 16200000000;
}

if ($dataPremi == null) {
    $dataPremi = 0;
}

echo json_encode($dataPremi);

?>