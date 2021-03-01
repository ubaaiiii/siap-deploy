<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');

	
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
	$status='1';


	

	if($_GET['module']=='add'){
		
			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'regid'";
			$hasill = mysql_query($sqll);
			$barisl = mysql_fetch_array($hasill);
			$nourut = $barisl[0];

			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'regid'";
			$hasiln = mysql_query($sqln);
			$regid=$nourut;
			

			/* $susia = date_diff(date_create($stgllahir), date_create($smulai)); */
			$susia=hitung_umur($stgllahir);
			$sqlq = "select  rates,ratesother,tunggakan,bunga  ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' and '$susia' between umurb and umura and insperiodmm='$smasa'";
			
			/* file_put_contents('eror.txt', $sqlq, FILE_APPEND | LOCK_EX); */
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
			$sqle = "insert into tr_sppa(regid,	nama,noktp,	jkel,pekerjaan,	cabang, ";
			$sqle = $sqle . " tgllahir,	mulai,	akhir,	masa,	up,nopeserta,status,createby,createdt,premi,epremi,tpremi,usia,produk,tunggakan,bunga) ";
			$sqle = $sqle . " values ('$regid',	'$snama','$snoktp',	'$sjkel','$spekerjaan',	'$scabang', ";
			$sqle = $sqle . " '$stgllahir',	'$smulai',	'$sakhir',	'$smasa',	'$sup','$snopeserta','$status','$userid','$sdate','$spremi', ";
			$sqle = $sqle . " '$sepremi','$stpremi','$susia','$sproduk','$stunggakan','$sbunga') ";
			file_put_contents('eror.txt', $sqlq, FILE_APPEND | LOCK_EX); 
			$hasill = mysql_query($sqle);
			


			header("location:../../media.php?module=valid");
	}
	
	elseif($_GET['module']=='update'){
			$sid=$_POST['id'];
			$sqlu="UPDATE tr_sppa SET status='3', validby='$userid',validdt='$sdate' WHERE regid='$sid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);

			header("location:../../media.php?module=valid");
	}
	elseif($_GET['module']=='reject'){
		
		
			$sid=$_POST['id'];
			$sqlr="UPDATE tr_sppa SET comment='$scomment', status='5', validby='$userid',validdt='$sdate' WHERE regid='$sid'";
			header("location:../../media.php?module=valid");
		

	}
	
	

	elseif($_GET['module']=='print') {	
	
		
	}
?>