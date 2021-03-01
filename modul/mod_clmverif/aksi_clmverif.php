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

	

	if($_GET['module']=='add'){
		


		
			$sqle = "insert into tr_claim(regclaim,	regid,tgllapor,tmpkejadian,tglkejadian,detail,statclaim, ";
			$sqle=$sqle= " createdt,createby,penyebab,nopk) ";
			$sqle = $sqle . " values ('$sregclaim',	'$sregid','$stgllapor','$stmpkejadian','$stglkejadian','$sdetail',";
			$sqle = $sqle . "'1',	'$sdate','$userid','$spenyebab','$snopk') ";
			$hasill = mysql_query($sqle);
			$sqlr="UPDATE tr_sppa SET status='80', editby='$userid',editdt='$sdate' WHERE regid='$sregid'";
			$query=mysql_query($sqlr);


			header("location:../../media.php?module=clmverif");
	}
	
	elseif($_GET['module']=='approve'){
			$sregclaim=$_GET['id'];
			$sqlu="UPDATE tr_claim SET ";
			$sqlu=$sqlu . " statclaim='92' ";
			$sqlu=$sqlu . " WHERE regclaim='$sregclaim'";
			file_put_contents('erorq.txt', $sqlu, FILE_APPEND | LOCK_EX);
			$query=mysql_query($sqlu);

			
			$sqlv="update tr_sppa set status='92' ";
			$sqlv=$sqlv . " where regid in (select regid from tr_claim where regclaim='$sregclaim')";
			file_put_contents('erorv.txt', $sqlv, FILE_APPEND | LOCK_EX);
			$query=mysql_query($sqlv);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','92','$userid','$sdate') ";
			$query=mysql_query($sqll);
			header("location:../../media.php?module=clmverif");
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

			
			header("location:../../media.php?module=clmverif");
	}	

	
?>