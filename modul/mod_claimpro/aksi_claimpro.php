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
	$spenyebab=$_POST['sebab'];
	$tnilaios=$_POST['nilaios'];
	$snopk=$_POST['nopk'];

	

	if($_GET['module']=='add'){
		


			$snilaios=str_replace('.', '', $_POST['tnilaios']);
			$sqle = "insert into tr_claim(regclaim,	regid,tgllapor,tmpkejadian,tglkejadian,detail,statclaim, ";
			$sqle=  $sqle . " createdt,createby,penyebab,nopk,nilaios) ";
			$sqle = $sqle . " values ('$sregclaim',	'$sregid','$stgllapor','$stmpkejadian','$stglkejadian','$sdetail',";
			$sqle = $sqle . "'90',	'$sdate','$userid','$spenyebab','$snopk','$snilaios') ";
			file_put_contents('eror.txt', $sqle, FILE_APPEND | LOCK_EX);  
			$hasill = mysql_query($sqle);
			$sqlr="UPDATE tr_sppa SET status='90', editby='$userid',editdt='$sdate' WHERE regid='$sregid'";
			$query=mysql_query($sqlr);


			header("location:../../media.php?module=claim");
	}
	
	elseif($_GET['module']=='update'){
			$sregclaim=$_POST['regclaim'];
			
			$snilaios=str_replace('.', '', $_POST['tnilaios']);
			$sqlu="UPDATE tr_claim SET tgllapor='$stgllapor',tmpkejadian='$stmpkejadian',nilaios='$snilaios', ";
			$sqlu=$sqlu . " tglkejadian='$stglkejadian',penyebab='$spenyebab',createby='$userid',editdt ='$sdate' ";
			$sqlu=$sqlu . " WHERE regid='$sregclaim'";
			 file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   
			$query=mysql_query($sqlu);

			
			header("location:../../media.php?module=claim");
	}


	elseif($_GET['module']=='approve'){

			$sregclaim=$_GET['id'];
	
			$sqlu="UPDATE tr_claim SET ";
			$sqlu=$sqlu . " statclaim='91' ";
			$sqlu=$sqlu . " WHERE regid='$sregclaim'";
			/* file_put_contents('eroru.txt', $sqlu, FILE_APPEND | LOCK_EX); */
			$query=mysql_query($sqlu);

			
			$sqlv="update tr_sppa set status='91' ";
			$sqlv=$sqlv .  " where regid in (select regid from tr_claim where regclaim='$sregclaim')";
			/* file_put_contents('erorv.txt', $sqlv, FILE_APPEND | LOCK_EX); */
			$query=mysql_query($sqlv);
			
			header("location:../../media.php?module=claim");
	}	

	elseif($_GET['module']=='rollback') {	
			$sregclaim=$_GET['id'];
	
			$sqlu="UPDATE tr_claim SET ";
			$sqlu=$sqlu . " statclaim='91' ";
			$sqlu=$sqlu . " WHERE regid='$sregclaim'";
			/* file_put_contents('eroru.txt', $sqlu, FILE_APPEND | LOCK_EX); */
			$query=mysql_query($sqlu);

			
			$sqlv="update tr_sppa set status='91' ";
			$sqlv=$sqlv .  " where regid in (select regid from tr_claim where regclaim='$sregclaim')";
			/* file_put_contents('erorv.txt', $sqlv, FILE_APPEND | LOCK_EX); */
			$query=mysql_query($sqlv);
		
	}
?>