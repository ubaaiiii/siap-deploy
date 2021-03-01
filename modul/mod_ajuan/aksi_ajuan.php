<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');

	
	$snopeserta=$_POST['nopeserta'];
	$snama=str_replace("'","`",$_POST['nama']);
	$sjkel=$_POST['jkel'];
	$snoktp=$_POST['noktp'];
	$spekerjaan=$_POST['pekerjaan'];
	$scabang=$_POST['cabang'];
	$stgllahir=$_POST['tgllahir'];	
	$smulai=$_POST['mulai'];
	$smasa=$_POST['masa'];
	$sproduk=$_POST['produk'];
	$stunggakan=$_POST['tunggakan'];
	
	$smitra=$_POST['mitra'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$status='0';
	$scomment=$_POST['subject'];
	

	if($_GET['module']=='add'){
			$sup=str_replace('.', '', $_POST['up']);
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
			$sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
			$sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) between umurb and umura and insperiodmm='$smasa'";
			$sqlq = $sqlq . " and '$stunggakan' between gpb and gpa  and $sup between minup and maxup";
			/* file_put_contents('erorq.txt', $sqlq, FILE_APPEND | LOCK_EX);  */
			
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
			
			
			$sqle = "insert into tr_sppa(regid,	nama,noktp,	jkel,pekerjaan,	cabang, ";
			$sqle = $sqle . " tgllahir,	mulai,	akhir,	masa,	up,nopeserta,status,createby,createdt,premi,epremi,tpremi,usia,produk,tunggakan,bunga,mitra,comment) ";
			$sqle = $sqle . " values ('$regid',	'$snama','$snoktp',	'$sjkel','$spekerjaan',	'$scabang', ";
			$sqle = $sqle . " '$stgllahir',	'$smulai','$sakhir','$smasa',	'$sup','$snopeserta','$status','$userid','$sdate','$spremi', ";
			$sqle = $sqle . " '$sepremi','$stpremi','$susia','$sproduk','$stunggakan','$sbunga','$smitra','$scomment') ";
			file_put_contents('eror.txt', $sqle, FILE_APPEND | LOCK_EX);  
			$hasill = mysql_query($sqle);
			

			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$regid','0','$userid','$sdate') ";
			/* file_put_contents('eror111.txt', $sqll, FILE_APPEND | LOCK_EX); */
			$query=mysql_query($sqll);

			header("location:../../media.php?module=ajuan&&act=update&&id=".$regid );
	}
	
	
		elseif($_GET['module']=='addsalin'){
			$sreffregid=$_POST['reffregid'];
			$sup=str_replace('.', '', $_POST['up']);
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
			$sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
			$sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) between umurb and umura and insperiodmm='$smasa'";
			$sqlq = $sqlq . " and '$stunggakan' between gpb and gpa  and $sup between minup and maxup";
			/* file_put_contents('eror.txt', $sqlq, FILE_APPEND | LOCK_EX); */
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
			$sqle = "insert into tr_sppa(regid,	nama,noktp,	jkel,pekerjaan,	cabang, ";
			$sqle = $sqle . " tgllahir,	mulai,	akhir,	masa,	up,nopeserta,status,createby,createdt,premi,epremi,tpremi,usia,produk,tunggakan,bunga,mitra) ";
			$sqle = $sqle . " values ('$regid',	'$snama','$snoktp',	'$sjkel','$spekerjaan',	'$scabang', ";
			$sqle = $sqle . " '$stgllahir',	'$smulai','$sakhir','$smasa',	'$sup','$snopeserta','$status','$userid','$sdate','$spremi', ";
			$sqle = $sqle . " '$sepremi','$stpremi','$susia','$sproduk','$stunggakan','$sbunga','$smitra') ";
			/* file_put_contents('eror.txt', $sqle, FILE_APPEND | LOCK_EX);  */
			$hasill = mysql_query($sqle);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$regid','0','$userid','$sdate') ";
			/* file_put_contents('eror111.txt', $sqll, FILE_APPEND | LOCK_EX); */
			$query=mysql_query($sqll);
			


			$sqll="insert into tr_sppa_reff(regid,reffregid,remark,createby,createdt) ";
			$sqll=$sqll . " values ('$regid','$sreffregid','','$userid','$sdate') ";
			/* file_put_contents('eror111.txt', $sqll, FILE_APPEND | LOCK_EX); */
			$query=mysql_query($sqll);

			header("location:../../media.php?module=ajuan&&act=update&&id=".$regid );
	}
	
	
	
	elseif($_GET['module']=='update'){
		
			$sregid=$_POST['regid'];
			$sup=str_replace(',', '', $_POST['up']);
			

			$susia=hitung_umur($stgllahir);
			$sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
			$sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) between umurb and umura and insperiodmm='$smasa'";
			$sqlq = $sqlq . " and '$stunggakan' between gpb and gpa and  $sup between minup and maxup ";
			/* file_put_contents('erorp.txt', $sqlq, FILE_APPEND | LOCK_EX);   */

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
			
			
			$sqlu="UPDATE tr_sppa SET nama='$snama',cabang='$scabang',mitra='$smitra',usia='$susia',tgllahir='$stgllahir', up=$sup, jkel='$sjkel',pekerjaan='$spekerjaan', ";
			$sqlu=$sqlu . " noktp='$snoktp',tpremi='$spremi',premi='$spremi',epremi=0,status='0',editby='$userid',editdt ='$sdate',masa='$smasa',akhir='$sakhir', ";
			$sqlu=$sqlu . " mulai='$smulai' , tunggakan='$stunggakan',comment='$scomment' WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);     */
			$query=mysql_query($sqlu);
			
			

			
			header("location:../../media.php?module=ajuan");
	}
	
	
	

	elseif($_GET['module']=='approve') {	
				
			$sregid=$_GET['id'];
			$userid=$_GET['uid'];
			$sqlu="UPDATE tr_sppa SET status='1',editby='$userid',editdt ='$sdate' ";
			$sqlu=$sqlu . " WHERE regid='$sregid' and premi<>0 and masa <>0 and usia<> 0  ";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','1','$userid','$sdate','approve by ao spv') ";
			$query=mysql_query($sqll);			
			/* file_put_contents('eror111.txt', $sqll, FILE_APPEND | LOCK_EX); */
			
			
			
			header("location:../../media.php?module=ajuan");
		
	}
?>