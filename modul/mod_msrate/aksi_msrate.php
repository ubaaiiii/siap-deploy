<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	$id=$_POST['id'];
	
	$scode=$_POST['code'];
	$sdesk=$_POST['desk'];
	$stype='MITRA';
	$userid=$_POST['userid'];
	$sdate = date('Y-m-d H:i:s');
	if ($_GET['module']=='add') {
		$sql="INSERT INTO ms_master (msid,msdesc,mstype,createby,createdt) VALUES ('$scode','$sdesk','$stype','$userid','$sdate')";
		file_put_contents('eror.txt', $sql, FILE_APPEND | LOCK_EX);
		
		$query=$db->query($sql);
		header("location:../../media.php?module=msmitra");
	}
	
	elseif ($_GET['module']=='update') {
		$query=$db->query("UPDATE ms_master SET desck='$sdesk',editby='$userid',editdt='$sdate' WHERE msid='$id' and mstype='$stype' ");
		header("location:../../media.php?module=msmitra");
	}
	elseif ($_GET['module']=='delete') {
		$id=$_GET['id'];
		$query=$db->query("DELETE FROM ms_master WHERE msid='$id'");
		header("location:../../media.php?module=msmitra");
	}
	elseif ($_GET['module']=='print') {	
	
		
	}
?>