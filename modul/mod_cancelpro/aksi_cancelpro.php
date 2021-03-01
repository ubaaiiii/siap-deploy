<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');

	$sregid=$_POST['regid'];
	$snopeserta=$_POST['nopeserta'];
	$snama=$_POST['nama'];
	$sjkel=$_POST['jkel'];
	$snoktp=$_POST['noktp'];
	$spekerjaan=$_POST['pekerjaan'];
	$scabang=$_POST['cabang'];
	$stgllahir=$_POST['tgllahir'];	
	$smulai=$_POST['mulai'];
	$smasa=$_POST['masa'];
	$sproduk=$_POST['produk'];
	$sup=$_POST['up'];
	$smitra=$_POST['mitra'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$status='1';


	

	if($_GET['module']=='rollback') {	
	
			elseif($_GET['module']=='rollback') {	
			$sregid=$_GET['id'];
			$sqlu="UPDATE tr_sppa SET status='20',editby='$userid',editdt ='$sdate' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','20','$userid','$sdate') ";
			$query=mysql_query($sqll);			
			/* file_put_contents('eror111.txt', $sqll, FILE_APPEND | LOCK_EX); */
			header("location:../../media.php?module=cancelpro");
	}
		
	}
?>