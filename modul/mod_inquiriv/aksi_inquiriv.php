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
	$sup=$_POST['up'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$status='1';


	

	if($_GET['module']=='approve'){
		
			$sregid=$_GET['id'];

			

			$sqle="select aa.jkel,aa.produk,aa.masa,aa.bunga,aa.tunggakan,aa.premi,aa.up,aa.mulai,aa.tgllahir,round(DATEDIFF(mulai,tgllahir)/365) nusia ";
			$sqle= $sqle . " from tr_sppa aa ";
			$sqle= $sqle . " where aa.regid='$sregid'";

			/* echo $sqle; */
			$query=mysql_query($sqle);
			$r=mysql_fetch_array($query);
			$sjkel=$r['jkel'];
			$susia=$r['nusia'];
			$sproduk=$r['produk'];
			$smasa=$r['masa'];
			$sbunga=$r['bunga'];
			$stunggakan=$r['tunggakan'];
			$spremi=$r['premi'];
			$sup=$r['up'];
			$smulai=$r['mulai'];
			$stgllahir=$r['tgllahir'];
			

			
			$sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
			$sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) between umurb and umura and insperiodmm='$smasa'";
			$sqlq = $sqlq . " and '$stunggakan' between gpb and gpa  and $sup between minup and maxup";
			file_put_contents('erorp.txt', $sqlq, FILE_APPEND | LOCK_EX);  

			$hasilq = mysql_query($sqlq);
			$barisq = mysql_fetch_array($hasilq);
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
			$hasilt = mysql_query($sqlt);
			$barist = mysql_fetch_array($hasilt);
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
			
			
			$sqlu="UPDATE tr_sppa SET premi='$spremi',tpremi='$spremi',bunga='$sbunga',comment='$scomment' WHERE regid='$sregid'";
			file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   
			$query=mysql_query($sqlu);
			
			$sqlb="update `tr_billing` set grossamt='$spremi',nettamt='$spremi',totalamt='$spremi' WHERE reffno='$sregid'";
			file_put_contents('erorb.txt', $sqlb, FILE_APPEND | LOCK_EX);   
			$query=mysql_query($sqlu);
			
			
			
			header("location:../../media.php?module=inquiriv");
			
			


	}
	
	


?>