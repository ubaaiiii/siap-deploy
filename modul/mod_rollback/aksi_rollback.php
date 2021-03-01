<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php");


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
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$tstatus=$_POST['status'];
	$scomment=$_POST['subject'];

	

	if($_GET['module']=='add'){
		
			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'regid'";
			$hasill = $db->query($sqll);
			$barisl = $hasill->fetch_array();
			$nourut = $barisl[0];



			header("location:../../media.php?module=rollback");
	}
	

	elseif($_GET['module']=='update'){
		
			$userid=$_POST['uid'];
			$sqlu="update tr_sppa set ";
			$sqlu=$sqlu . " status='$tstatus' , comment='$scomment' where regid='$sregid'";
			$query=$db->query($sqlu);			
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " select regid,'$tstatus','$userid','$sdate','$scomment' from tr_sppa where regid='$sregid'  ";
			$query=$db->query($sqll);			
		
			header("location:../../media.php?module=rollback");
			


	}
	
	elseif($_GET['module']=='reject'){
			$userid=$_POST['uid'];
 

			$sqlu="update tr_sppa set ";
			$sqlu=$sqlu . " status='12',comment=concat(comment,' ; data di cancel request by ao')  where regid='$sregid' and status<>'5' ";
			/* file_put_contents('erore.txt', $sqlu, FILE_APPEND | LOCK_EX);    */
			$query=$db->query($sqlu);
			
		

			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " select regid,'12','$userid','$sdate',concat(comment,' ; aplikasi di cancel request ao') from tr_sppa where regid='$sregid' and status<>'5' ";
			$query=$db->query($sqll);	
			
			header("location:../../media.php?module=rollback");
			


	}


?>