<?php
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
}
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
//whether ip is from remote address
else {
    $ipaddress = $_SERVER['REMOTE_ADDR'];
}

$sesid      = $_SESSION['idLog'];
$seslev     = $_SESSION['idLevel'];
$sestok     = $_SESSION['token'];
$module     = $_GET['module'];
$filephp    = explode("/",$_SERVER['PHP_SELF']);
$jumdir     = count($filephp) - 1;
$filephp    = $filephp[$jumdir];

if (!$sesid) {
    header("location:../../index.php");
    break;
}

else {
    if ($seslev !== 'broker') {
        // if(!defined('__NOT_DIRECT')){
        //     //mencegah akses langsung ke file ini
        //     die('Akses langsung tidak diizinkan!');
        //     break;
        // }
    }
    $res    = $db->query("SELECT *
                          FROM log_temp WHERE tgl_temp IN (
                            SELECT MAX( tgl_temp )
                              FROM log_temp WHERE ipaddress = '$ipaddress' GROUP BY ipaddress
                          )");
    $num    = $res->num_rows;
    $data   = $res->fetch_assoc();
    if ($num = 0) {
        echo "ga ada log temp";
        die;
        header("location:../../index.php");
        break;
    }
    elseif ($sestok !== $data['token']) {
        echo "token beda";
        header("location:../../media.php?module=keluar");
        break;
    }
    else {
        $res = $db->query(" SELECT    *
                            FROM      ms_menu a
                            LEFT JOIN ms_submenu b
                                ON    a.id = b.menu_id
                            WHERE     a.userlevel = '$seslev' 
                                AND (Concat('aksi_',a.module,'.php') = '$filephp' OR
                                     Concat('data_',a.module,'.php') = '$filephp' OR
                                     Concat('aksi_',b.submenulink,'.php') = '$filephp' OR
                                     Concat('data_',b.submenulink,'.php') = '$filephp') ");
        if ($res->num_rows == 0) {
            echo "menu/submenu ga sesuai atau level ga ada";
            die;
            header("location:../../index.php");
            break;
        }
    }
}
?>