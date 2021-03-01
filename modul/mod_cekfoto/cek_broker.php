<?php
include("../../config/koneksi.php");
date_default_timezone_set('Asia/Jakarta');
$hariIni = $_POST['hariIni'];
$cekBroker = $db->query("SELECT createby,count(regid) jumlah
                          FROM `tr_sppa_log` 
                          WHERE `status` in (10,12,20,7,8,90) 
                          AND `createby` in ('BROKER3151','BRONIS3172','BRONUR3153','BROSTB3105','BROZIE3191','BRONDA3154')
                          AND LEFT(`createdt`,10) = '".$hariIni."'
                          GROUP BY `createby`");
while ($row = $cekBroker->fetch_assoc()) {
    switch($row['createby']){
        case "BROKER3151":
            $data['bayu'] = $row['jumlah'];
            break;
        case "BRONDA3154":
            $data['dinda'] = $row['jumlah'];
            break;
        case "BRONIS3172":
            $data['tony'] = $row['jumlah'];
            break;
        case "BRONUR3153":
            $data['fanur'] = $row['jumlah'];
            break;
        case "BROSTB3105":
            $data['nindy'] = $row['jumlah'];
            break;
        case "BROZIE3191":
            $data['zyah'] = $row['jumlah'];
            break;
    }
}

echo json_encode($data);

?>