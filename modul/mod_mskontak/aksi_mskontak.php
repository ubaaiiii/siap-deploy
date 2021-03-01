<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	
	$sdate  = date('Y-m-d H:i:s');
	$modul  = $_GET['module'];
	$userid = $_POST['userid'];
	$nama   = ucwords($_POST['nama']);
	$nohp   = $_POST['no_telp'];
	$tipe   = $_POST['tipe'];
    $contactid = $_POST['id-contact'];

    if($modul=='cari') {
	    $cariData = $db->query("SELECT a.id_contact, b.nama, b.nohp
	                             FROM ms_contact a
	                             INNER JOIN ms_admin b ON a.id_contact = b.id_admin
	                             WHERE a.id_contact = '$contactid'");
	    while ($row = $cariData->fetch_assoc()){
	        $result = $row;
	    }
	    
	    echo json_encode($result);
	}
	
	elseif ($modul=='simpan') {
	    $insertData = $db->query("INSERT
    	                           INTO `ms_contact`
    	                                  (`nama`, `nohp`)
    	                           VALUES ('$nama','$nohp')");
	    
	    if ($insertData) {
	        echo json_encode("true");
	    } else {
	        echo json_encode("false");
	    }
	    
	}
	
	elseif ($modul=='edit') {
	    if ($tipe == 'check') {
	        $valuenya = $_POST['val'];
	        $fieldnya = $_POST['field'];
	        $updCont = "UPDATE ms_contact
                        SET `$fieldnya`='$valuenya'
                        WHERE id_contact = '$contactid'";
	    } else {
	        $updCont = "UPDATE ms_contact a 
                        INNER JOIN  
                        ms_admin b 
                        ON a.id_contact = b.id_admin  
                        SET a.nama = '$nama',
                            b.nama = '$nama',
                            b.nohp = '$nohp'
                        WHERE a.id_contact = '$contactid'";
	    }
	    
	    if ($db->query($updCont)) {
	        echo "berhasil";
	    } else {
	        echo "gagal";
	    }
	}
	
	elseif ($modul=='hapus') {
	    $hapusData = $db->query("DELETE
	                             FROM ms_contact
	                             WHERE id_contact = '$contactid'");
	    
	    if ($hapusData) {
	        echo json_encode("true");
	    } else {
	        echo json_encode("false");
	    }
	}
	
?>