<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php");


	
	$sregid=$_POST['regid'];
	$stglkejadian=$_POST['tglkejadian'];
	$stgllapor=$_POST['tgllapor'];
	$spekerjaan=$_POST['subject'];
	$spelapor=$_POST['pelapor'];
	$stgllahir=$_POST['tgllahir'];	
	$smulai=$_POST['mulai'];
	$smasa=$_POST['masa'];
	$sproduk=$_POST['produk'];
	$sup=$_POST['up'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$sdetail=$_POST['subject'];
	


	

	if($_GET['module']=='add'){
		
			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'regclm'";
			$hasill = mysql_query($sqll);
			$barisl = mysql_fetch_array($hasill);
			$nourut = $barisl[0];

			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'regclm'";
			$hasiln = mysql_query($sqln);
			$sregclaim=$nourut;
			

		
			$sqle = "insert into tr_claim(regclaim,	regid,tgllapor,pelapor,tglkejadian,detail,statclaim,createdt,createby) ";
			$sqle = $sqle . " values ('$sregclaim',	'$sregid','$stgllapor','$spelapor','$stglkejadian','$sdetail','1',	'$sdate','$userid') ";
			
			file_put_contents('eror.txt', $sqle, FILE_APPEND | LOCK_EX);  
			$hasill = mysql_query($sqle);
			


			header("location:../../media.php?module=claim");
	}
	
	elseif($_GET['module']=='update'){
			$sregid=$_POST['regid'];
			

			$susia=hitung_umur($stgllahir);
			$sqlq = "select  rates,ratesother,tunggakan,bunga  ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' and '$susia' between umurb and umura and insperiodmm='$smasa'";
			/* file_put_contents('erorp.txt', $sqlq, FILE_APPEND | LOCK_EX);   */

			$hasilq = mysql_query($sqlq);
			$barisq = mysql_fetch_array($hasilq);
			$srates = $barisq[0];
			$sratesoth = $barisq[1];
			$stunggakan = $barisq[2];
			$sbunga= $barisq[3];
			
			$spremi=($sup*$srates)/100;
			$sepremi=($sup*$sratesoth)/100;
			$stpremi=($spremi+$sepremi);


			$sakhir=tgl_akhir($smulai,$smasa);
			
			
			$sqlu="UPDATE tr_sppa SET usia='$susia',tgllahir='$stgllahir', premi='$spremi',epremi=0,status='2',editby='$userid',editdt ='$sdate' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);

			
			header("location:../../media.php?module=verif");
	}


	elseif($_GET['module']=='reject'){
			$sid=$_POST['id'];
			
			$sqlr="UPDATE tr_sppa SET comment='$scomment', status='5', editby='$userid',editdt='$sdate' WHERE regid='$sid'";
			/* file_put_contents('eror.txt', $sqlr, FILE_APPEND | LOCK_EX); */
			
			$query=mysql_query($sqlr);

			
			header("location:../../media.php?module=verif");
	}	

	elseif($_GET['module']=='print') {	
	
		
	}
?>