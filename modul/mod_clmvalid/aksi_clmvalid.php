<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
/* 	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php"); */


	$sregclaim=$_POST['regclaim'];
	$sregid=$_POST['regid'];
	$stglkejadian=$_POST['tglkejadian'];
	$stgllapor=$_POST['tgllapor'];
	$spekerjaan=$_POST['subject'];
	$stmpkejadian=$_POST['tmpkejadian'];
	$stgllahir=$_POST['tgllahir'];	
	$smulai=$_POST['mulai'];
	$smasa=$_POST['masa'];
	$sproduk=$_POST['produk'];
	$sup=$_POST['up'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$sdetail=$_POST['subject'];
	$spenyebab=$_POST['penyebab'];
	$nilaios=$_POST['nilaios'];
	$snopk=$_POST['nopk'];

	

if($_GET['module']=='approve'){
			
			$sregclaim=$_GET['id'];
			$sregid=$_GET['regid'];
			$userid=$_GET['userid'];
	
			$sqlu="UPDATE tr_claim SET ";
			$sqlu=$sqlu . " statclaim='92' ";
			$sqlu=$sqlu . " WHERE regid='$sregclaim'";
			$query=mysql_query($sqlu);

			
			$sqlv="update tr_sppa set status='93' ";
			$sqlv=$sqlv .  " where regid in (select regid from tr_claim where regclaim='$sregclaim')";
			$query=mysql_query($sqlv);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','93','$userid','$sdate','Klaim Diselesaikan') ";
			$query=mysql_query($sqll);
			
			header("location:../../media.php?module=clmvalid");
	}


elseif($_GET['module']=='reject'){

			$sregclaim=$_GET['id'];
	
			$sqlu="UPDATE tr_claim SET ";
			$sqlu=$sqlu . " statclaim='94' ";
			$sqlu=$sqlu . " WHERE regid='$sregclaim'";
			
			$query=mysql_query($sqlu);

			
			$sqlv="update tr_sppa set status='94' ";
			$sqlv=$sqlv .  " where regid in (select regid from tr_claim where regclaim='$sregclaim')";
			$query=mysql_query($sqlv);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','94','$userid','$sdate') ";
			$query=mysql_query($sqll);
			
			header("location:../../media.php?module=clmvalid");
	}	

	
?>