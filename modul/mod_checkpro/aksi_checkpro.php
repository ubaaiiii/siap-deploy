<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');

	
	$snopeserta=$_POST['nopeserta'];
	$snama=$_POST['nama'];
	$sjkelamin=$_POST['jkel'];
	$snoktp=$_POST['noktp'];
	$spekerjaan=$_POST['pekerjaan'];
	$scabang=$_POST['cabang'];
	$stgllahir=simpantglidtodb($_POST['tgllahir']);	
	$smulai=$_POST['mulai'];
	$smasa=$_POST['masa'];
	$sproduk=$_POST['produk'];
	$sup=str_replace(',', '', $_POST['up']);
	$smitra=$_POST['mitra'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	


	

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
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkelamin' and '$susia' between umurb and umura and insperiodmm='$smasa'";
			
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
			$sqle = $sqle . " tgllahir,	mulai,	akhir,	masa,	up,nopeserta,status,createby,createdt,premi,epremi,tpremi, ";
			$sqle = $sqle . " usia,produk,tunggakan,bunga,mitra) ";
			$sqle = $sqle . " values ('$regid',	'$snama','$snoktp',	'$sjkelamin','$spekerjaan',	'$scabang', ";
			$sqle = $sqle . " '$stgllahir',	'$smulai',	'$sakhir',	'$smasa',	'$sup','$snopeserta', ";
			$sqle = $sqle . "'$status','$userid','$sdate','$spremi', ";
			$sqle = $sqle . " '$sepremi','$stpremi','$susia','$sproduk','$stunggakan','$sbunga','$smitra') ";
			/* file_put_contents('eror.txt', $sqlq, FILE_APPEND | LOCK_EX);  */
			$hasill = mysql_query($sqle);
			


			header("location:../../media.php?module=checkpro&&act=update&&id=".$regid );
	}
	
	elseif($_GET['module']=='update'){
		
			$sregid=$_POST['regid'];
			$sqld="SELECT a.* from  ";
			$sqld= $sqld . " tr_sppa a  where regid='$sregid' ";  
			$query=mysql_query($sqld);
			while($r=mysql_fetch_array($query)){
				$sjkelamin=$r['jkel'];
				$stgllahir=$r['tgllahir'];
			}
			$susia=hitung_umur($stgllahir);
			$sqlq = "select  rates,ratesother,tunggakan,bunga  ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkelamin' and '$susia' between umurb and umura and insperiodmm='$smasa'";
			file_put_contents('erorcc.txt', $sqlq, FILE_APPEND | LOCK_EX);   
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
			
			
			$sqlu="UPDATE tr_sppa SET masa='$smasa',mulai='$smulai',akhir='$sakhir',usia='$susia', ";
			$sqlu= $sqlu . " up='$sup',nopeserta='$snopeserta',premi='$spremi' where regid='$sregid'";
			file_put_contents('eroraa.txt', $sqlu, FILE_APPEND | LOCK_EX);   
			$query=mysql_query($sqlu);

			

			
			header("location:../../media.php?module=checkpro");
	}
	
	elseif($_GET['module']=='print') {	
	
		
	}
	
	elseif($_GET['module']=='approve') {	
			$sregid=$_GET['id'];
			$slvl=$_GET['lvl'];
			if ($slvl=="checker")
			{
			$sts='2';	
			}
			if ($slvl=="schecker")
			{
			$sts='3';	
			}
			
			$sqlu="UPDATE tr_sppa SET status='$sts',editby='$slvl' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'  ";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','$sts','$userid','$sdate') ";
			$query=mysql_query($sqll);	
			
			header("location:../../media.php?module=checkpro");
		
	}
	
	elseif($_GET['module']=='rollback') {	
			$sregid=$_GET['id'];
			$slvl=$_GET['lvl'];
			$sqlu="UPDATE tr_sppa SET status='0',editby='$slvl' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','0','$userid','$sdate','rollback') ";
			$query=mysql_query($sqll);	
			
			header("location:../../media.php?module=checkpro");
		
	}
?>