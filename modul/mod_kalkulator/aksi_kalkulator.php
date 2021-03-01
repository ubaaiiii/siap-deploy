<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
/* 	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php"); */
	
	$scalreg=$_POST['calreg'];
	$snama=$_POST['nama'];
	$sjkel=$_POST['jkel'];
	$snoktp=$_POST['noktp'];
	$spekerjaan=$_POST['pekerjaan'];
	$scabang=$_POST['cabang'];
	$stgllahir=$_POST['tgllahir'];	
	$smulai=$_POST['mulai'];
	$smasa=$_POST['masa'];
	$sproduk=$_POST['produk'];
	$sgp=$_POST['gp'];
	$stunggakan=$_POST['gp'];
	$smitra=$_POST['mitra'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$status='0';


	

	if($_GET['module']=='add'){
			$sup=str_replace('.', '', $_POST['up']);
			
			

			/* $susia = date_diff(date_create($stgllahir), date_create($smulai));  */
		    $susia=hitung_umur($stgllahir);  
			/* $ntgllahir=$stgllahir;
			$nmulai=$smulai;
			$nusia=$nmulai->diff($ntgllahir);  */
			/* $susia=round($nusia/365,0); */ 
			$sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
			$sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) between umurb and umura and insperiodmm='$smasa'";
			$sqlq = $sqlq . " and '$stunggakan' between gpb and gpa  and  '$sup' between minup and maxup ";
			file_put_contents('erorr.txt', $sqlq, FILE_APPEND | LOCK_EX); 
			$hasilq = $db->query($sqlq);
			$barisq = $hasilq->fetch_array();
			$srates = $barisq[0];
			$sratesoth = $barisq[1];
			$stunggakan1 = $barisq[2];
			$sbunga= $barisq[0];
			$sumurb= $barisq[4];
			$sumura= $barisq[5];
			$susia= $barisq[6];
			$spremi=($sup*$srates)/100;
			$sepremi=($sup*$sratesoth)/100;
			$stpremi=($spremi+$sepremi);


			$sakhir=tgl_akhir($smulai,$smasa);
			
			$sqlt = "select  umurb,umura,maxup   ";
			$sqlt = $sqlt . " from  tr_term  where produk='$sproduk'  ";
			$hasilt = $db->query($sqlt);
			$barist = $hasilt->fetch_array();
			$sbumurb = $barist[0];
			$sbumura = $barist[1];
			$smaxup = $barist[2];
			if ($susia<$sbumurb and $stpremi==0) 
			{
					$scomment=$scomment . " ".  'rate=0-->kriteria tidak ada dalam table tarif';
					$spremi=0;
					$sepremi=0;
					$stpremi=0;
			}

			if ($susia>$sbumura and $stpremi==0 ) 
			{
					$scomment=$scomment . " ".'rate=0-->kriteria tidak ada dalam table tarif ';
					$spremi=0;
					$sepremi=0;
					$stpremi=0;
			}	
			
			if ($sup>$smaxup ) 
			{
					$scomment=$scomment . " "."Pinjaman-->pinjaman melebih maksimum pinjaman sebesar "  ;
					$spremi=0;
					$sepremi=0;
					$stpremi=0;
			}	
			
			if (($susia+($smasa/12))>$sbumura ) 
			{
					$scomment=$scomment . " "."usia-->usia melebih maksimum usia pinjaman "  ;
					$spremi=0;
					$sepremi=0;
					$stpremi=0;
			}	
			if ($susia=='' )
			{
				$susia=0;
				$susia=hitung_umur($stgllahir);
			}
			if ($sbunga=='' )
			{
				$sbunga=0;
			}
			if ($stunggakan=='' )
			{
				$stunggakan=0;
			}
			
			$sqle = "insert into tr_calc(calreg,jkel, ";
			$sqle = $sqle . " tgllahir,	mulai,	akhir,	masa,	up,createby,createdt,premi,epremi,tpremi,usia,produk,tunggakan,bunga,comment) ";
			$sqle = $sqle . " values ('$scalreg',	'$sjkel', ";
			$sqle = $sqle . " '$stgllahir',	'$smulai','$sakhir','$smasa',	'$sup','$userid','$sdate','$spremi', ";
			$sqle = $sqle . " '$sepremi','$stpremi','$susia','$sproduk','$sgp','$sbunga','$scomment') ";
			file_put_contents('erorc.txt', $sqle, FILE_APPEND | LOCK_EX);  
			$hasill = $db->query($sqle);
			

			
			


			header("location:../../media.php?module=kalkulator&&act=update&&id=".$scalreg );
	}
	
	elseif($_GET['module']=='update'){
		
			$sregid=$_POST['regid'];
			$sup=str_replace(',', '', $_POST['up']);

			$susia=hitung_umur($stgllahir);
			$sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
			$sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) between umurb and umura and insperiodmm='$smasa'";
			$sqlq = $sqlq . " and '$stunggakan' between gpb and gpa  and  '$sup' between minup and maxup ";
			/* file_put_contents('erorp.txt', $sqlq, FILE_APPEND | LOCK_EX);   */

			$hasilq = $db->query($sqlq);
			$barisq = $hasilq->fetch_array();
			$srates = $barisq[0];
			$sratesoth = $barisq[1];
			$stunggakan = $barisq[2];
			$sbunga= $barisq[3];
			
			$spremi=($sup*$srates)/100;
			$sepremi=($sup*$sratesoth)/100;
			$stpremi=($spremi+$sepremi);

			$sakhir=tgl_akhir($smulai,$smasa);
			
			header("location:../../media.php?module=kalkulator&&act=update&&id=".$scalreg );
	}
	
	
	

	
?>