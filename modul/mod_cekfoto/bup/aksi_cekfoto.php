<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php");
	
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
	
	
	$smitra=$_POST['mitra'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$sasuransi=$_POST['asuransi'];
	$scomment=$_POST['subject'];

	

	if($_GET['module']=='update'){
		
			$sregid=$_POST['regid'];
			

			$sqlu="UPDATE tr_sppa SET status='10',asuransi='$sasuransi',editby='$userid',editdt ='$sdate' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   
			$query=mysql_query($sqlu);
			
			$sqld="DELETE FROM tr_sppa_log WHERE regid='$sregid' and status='13'";
			$queryd=mysql_query($sqld);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','10','$userid','$sdate') ";
			$query=mysql_query($sqll);			
			/* file_put_contents('eror111.txt', $sqll, FILE_APPEND | LOCK_EX); */

			header("location:../../media.php?module=cekfoto");
	}
	
	
	

	elseif($_GET['module']=='approve') {	
				
			$sregid=$_GET['id'];
			$userid=$_GET['uid'];		
			$sqlu="UPDATE tr_sppa SET status='10',editby='$userid',editdt ='$sdate' ";
			$sqlu=$sqlu . " WHERE regid='$sregid' ";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','10','$userid','$sdate') ";
			$query=mysql_query($sqll);			
			/* file_put_contents('eror111.txt', $sqll, FILE_APPEND | LOCK_EX); */
			
			header("location:../../media.php?module=cekfoto");
		
	}
	
	elseif($_GET['module']=='reject') {	
				
			$sregid=$_GET['id'];
			$userid=$_GET['uid'];
			$sqlu="UPDATE tr_sppa SET status='12',asuransi='$sasuransi',editby='$userid',editdt ='$sdate' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','12','$userid','$sdate') ";
			$query=mysql_query($sqll);			
			/* file_put_contents('eror111.txt', $sqll, FILE_APPEND | LOCK_EX); */
			
			header("location:../../media.php?module=cekfoto");
		
	}
	
		elseif($_GET['module']=='revisi'){
		
			$sregid=$_POST['regid'];
			$userid=$_GET['uid'];			
			
			$sqlu="UPDATE tr_sppa SET comment='$scomment',status='0' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);
			
			$sqld="DELETE FROM tr_sppa_log WHERE regid='$sregid' and status='13'";
			$queryd=mysql_query($sqld);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','0','$userid','$sdate','$scomment') ";
			$query=mysql_query($sqll);		
					
			

			
			header("location:../../media.php?module=cekfoto");
	}
	
?>