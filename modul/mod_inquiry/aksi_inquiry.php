<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');

	$snopeserta = $_POST['nopeserta'];
	$snama      = $_POST['nama'];
	$sjkel      = $_POST['jkel'];
	$snoktp     = $_POST['noktp'];
	$spekerjaan = $_POST['pekerjaan'];
	$scabang    = $_POST['cabang'];
	$stgllahir  = $_POST['tgllahir'];	
	$smulai     = $_POST['mulai'];
	$smasa      = $_POST['masa'];
	$sproduk    = $_POST['produk'];
	$sup        = $_POST['up'];
	$sdate      = date('Y-m-d H:i:s');
	$requestid  = $_POST['requestid'];
	$userid     = $_POST['userid'];
	$status     = '1';


	

	if($_GET['module']=='add'){
		
			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'regid'";
			$hasill = $db->query($sqll);
			$barisl = $hasill->fetch_array();
			$nourut = $barisl[0];



			header("location:../../media.php?module=inquiry");
	}
	

	elseif($_GET['module']=='approve'){
		
			$sregid=$_GET['id'];

			

			$sqle="select aa.*,round(DATEDIFF(mulai,tgllahir)/365) nusia ";
			$sqle= $sqle . " from tr_sppa aa ";
			$sqle= $sqle . " where aa.regid='$sregid'";

			/* echo $sqle; */
			$query      = $db->query($sqle);
			$r          = $query->fetch_array();
			$sjkel      = $r['jkel'];
			$susia      = $r['nusia'];
			$sproduk    = $r['produk'];
			$smasa      = $r['masa'];
			$sbunga     = $r['bunga'];
			$stunggakan = $r['tunggakan'];
			$spremi     = $r['premi'];
			$sup        = $r['up'];
			$smulai     = $r['mulai'];
			$stgllahir  = $r['tglllahir'];
			

			
			$sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
			$sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) between umurb and umura and insperiodmm='$smasa'";
			$sqlq = $sqlq . " and '$stunggakan' between gpb and gpa ";
			/* file_put_contents('erorp.txt', $sqlq, FILE_APPEND | LOCK_EX);   */

			$hasilq         = $db->query($sqlq);
			$barisq         = $hasilq->fetch_array();
			$srates         = $barisq[0];
			$sratesoth      = $barisq[1];
			$stunggakan1    = $barisq[2];
			$sbunga         = $barisq[0];
			$sumurb         = $barisq[4];
			$sumura         = $barisq[5];
			$susia          = $barisq[6];
			$spremi         = ($sup*$srates)/100;
			$sepremi        = ($sup*$sratesoth)/100;
			$stpremi        = ($spremi+$sepremi);
			$sakhir         = tgl_akhir($smulai,$smasa);
			
			$sqlt = "select  umurb,umura,maxup   ";
			$sqlt = $sqlt . " from  tr_term  where produk='$sproduk'  ";
			
			$hasilt     = $db->query($sqlt);
			$barist     = $hasilt->fetch_array();
			$sbumurb    = $barist[0];
			$sbumura    = $barist[1];
			$smaxup     = $barist[2];
			
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
			
			
			$sqlu="UPDATE tr_sppa SET tpremi='$spremi',tpremi='$spremi',bunga='$sbunga',comment='$scomment' WHERE regid='$sregid'";
			file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   
			$query=$db->query($sqlu);
			
			$sqlb="update `tr_billing` set grossamt='$spremi',nettamt='$spremi',totalamt='$spremi' WHERE reffno='$sregid'";
			file_put_contents('erorb.txt', $sqlb, FILE_APPEND | LOCK_EX);   
			$query=$db->query($sqlu);
			
			header("location:../../media.php?module=inquiry");

	}
	
	


?>