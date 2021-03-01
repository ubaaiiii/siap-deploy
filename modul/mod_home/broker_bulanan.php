<?php
include("../../config/koneksi.php");
if (isset($_GET['bulannya'])) {
    $bulannya = $_GET['bulannya'];   
} else {
    $bulannya = $_POST['bulannya'];
}
$cekBroker = $db->query("   SELECT b.username,
                                   b.id_admin,
                                   Count(c.regid)
                                   jumlah,
                                   Round(Count(c.regid) / (SELECT Count(regid)
                                                           FROM   tr_sppa_log
                                                           WHERE  status IN ( 10, 12, 20, 7,71, 72, 8, 81,82, 90, 91 )
                                                              AND createby IN (SELECT username
                                                                               FROM   ms_admin a
                                                                               INNER JOIN ms_contact b
                                                                                   ON a.id_admin =
                                                                                      b.id_contact
                                                                                      AND b.dashboard = 1)
                                                              AND LEFT(createdt, 7) = '$bulannya') * 100,2) perc
                            FROM   ms_contact a
                                   INNER JOIN ms_admin b
                                        ON a.id_contact = b.id_admin
                                            AND b.level = 'broker'
                                   LEFT JOIN tr_sppa_log c
                                        ON b.username = c.createby
                                            AND c.status IN ( 10, 12, 20, 7,71, 72, 8, 81,82, 90, 91 )
                                             AND LEFT(c.createdt, 7) = '$bulannya'
                            WHERE  a.dashboard = 1
                            GROUP  BY b.username
                            ORDER  BY b.username ASC  ");

$i = 0;
while ($row = $cekBroker->fetch_assoc()) {
    // switch($row['createby']){
    //     case "BROKER3151":
    //         $bayu['jumlah'] = $row['jumlah'];
    //         $bayu['perc'] = $row['perc'];
    //         break;
    //     case "BRONDA3154":
    //         $dinda['jumlah'] = $row['jumlah'];
    //         $dinda['perc'] = $row['perc'];
    //         break;
    //     case "BRONIS3172":
    //         $tony['jumlah'] = $row['jumlah'];
    //         $tony['perc'] = $row['perc'];
    //         break;
    //     case "BRONUR3153":
    //         $fanur['jumlah'] = $row['jumlah'];
    //         $fanur['perc'] = $row['perc'];
    //         break;
    //     case "BROSTB3105":
    //         $nindy['jumlah'] = $row['jumlah'];
    //         $nindy['perc'] = $row['perc'];
    //         break;
    //     case "BROZIE3191":
    //         $zyah['jumlah'] = $row['jumlah'];
    //         $zyah['perc'] = $row['perc'];
    //         break;
    // }
    
    $id[$i]     = $row['id_admin'];
    $jumlah[$i] = $row['jumlah'];
    $perc[$i]   = $row['perc'];
    $i++;
}

$arrID     = [];
$arrJumlah = [];
$arrPersen = [];
for($j=0;$j<$i;$j++) {
    array_push($arrID,$id[$j]);
    array_push($arrJumlah,$jumlah[$j]);
    array_push($arrPersen,$perc[$j]);
}
$result = array(
    'id'    =>$arrID,
    'jumlah'=>$arrJumlah,
    'persen'=>$arrPersen,
    'tony'=>array($tony['jumlah']),
    );

echo json_encode($result);

?>