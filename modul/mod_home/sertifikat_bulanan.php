<?php
include("../../config/koneksi.php");
date_default_timezone_set('Asia/Jakarta');
if (isset($_POST['bulannya'])) {
    $bulannya = $_POST['bulannya'];   
} else {
    $bulannya = $_GET['bulannya'];
}

$resSerti = $db->query("SELECT `asuransi`,
                                count(`policyno`) sertifikat,
                                ROUND(count(`policyno`)/(SELECT COUNT(`policyno`) 
                                                         FROM `tr_sppa` t
                                                         INNER JOIN `tr_sppa_paid` p ON p.`regid` = t.`regid`
                                                         WHERE  `status` >= 5
                                                            AND `status` NOT IN ( 10, 11, 12, 13 )
                                                            AND `asuransi` !=''
                                                            AND LEFT(p.`paiddt`,7)='$bulannya')*100,2) perc
                        FROM `tr_sppa` t
                        INNER JOIN `tr_sppa_paid` p ON p.`regid` = t.`regid`
                        WHERE  `status` >= 5
                            AND `status` NOT IN ( 10, 11, 12, 13 )
                            AND `asuransi` !=''
                            AND LEFT(p.`paiddt`,7)='$bulannya'
                        GROUP BY `asuransi` ");

$eti['sertifikat'] = 0;
$eti['perc'] = 0;
$mpm['sertifikat'] = 0;
$mpm['perc'] = 0;
$tkp['sertifikat'] = 0;
$tkp['perc'] = 0;


while ($rowSerti = $resSerti->fetch_assoc()){
    switch($rowSerti['asuransi']) {
        case "ETI":
            $eti['sertifikat'] = $rowSerti['sertifikat'];
            $eti['perc'] = $rowSerti['perc'];
            break;
        case "MPM":
            $mpm['sertifikat'] = $rowSerti['sertifikat'];
            $mpm['perc'] = $rowSerti['perc'];
            break;
        case "TKP":
            $tkp['sertifikat'] = $rowSerti['sertifikat'];
            $tkp['perc'] = $rowSerti['perc'];
            break;
    }
}

$result = array(
    'sertifikat'=>array($eti['sertifikat'],$mpm['sertifikat'],$tkp['sertifikat']),
    'persen'=>array($eti['perc'],$mpm['perc'],$tkp['perc']),
    );
/* Urutan Array:
[0]: Etiqa
[1]: MPM
[2]: TKP
*/

echo json_encode($result);

?>