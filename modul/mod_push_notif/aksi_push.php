<?php
    include("../../config/koneksi.php");
    date_default_timezone_set('Asia/Jakarta');
    $userid=$_SESSION['idLog'];
    
    if (isset($_GET['module'])) {
        if ($_GET['module']=='simpan') {
            $level = $_POST['level'];
            $cabang = $_POST['cabang'];
            $username = $_POST['user'];
            $tipe = $_POST['tipe'];
            $judul = $_POST['judul'];
            $pesan = $_POST['pesan'];
            $tgl_mulai = $_POST['tgl-mulai'];
            $tgl_selesai = $_POST['tgl-selesai'];
            
            $pesannya = $tipe."-".$judul."-".$pesan;
            
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $sqlSimpan = "UPDATE `tbl_push_notif` SET `level`='$level',`cabang`='$cabang',`username`='$username',`pesan`='$pesannya',`tgl_mulai`='$tgl_mulai',`tgl_selesai`='$tgl_selesai',`createby`='$userid' WHERE `id`='$id'";
            } else {
                $sqlSimpan = "INSERT INTO `tbl_push_notif`(`level`, `cabang`, `username`, `pesan`, `tgl_mulai`, `tgl_selesai`,`createby`) VALUES ('$level', '$cabang', '$username', '$pesannya', '$tgl_mulai', '$tgl_selesai', '$userid')";
            }
            
            $resSimpan = mysql_query($sqlSimpan);
            
            if ($resSimpan) {
                header("location:../../media.php?module=push_notif");
            } else {
                echo $sqlSimpan;
            }
            
        } else if ($_GET['module']=='edit') {
            $id = $_GET['id'];
            $resCari = mysql_query("SELECT * FROM `tbl_push_notif` WHERE id='$id'");
            while ($rowCari = mysql_fetch_assoc($resCari)) {
                $dataCari = $rowCari;
            }
            echo json_encode($dataCari);
            
        } else if ($_GET['module']=='hapus') {
            $id = $_GET['id'];
            $resHapus = mysql_query("DELETE FROM `tbl_push_notif` WHERE id='$id'");
            if ($resHapus) {
                echo "true";
            } else {
                echo mysqli_connect_errno().": ".mysqli_connect_error();
            }
        } else {
            header("location:../../media.php?module=push_notif");
        }
    } else {
        header("location:../../media.php?module=push_notif");
    }

?>