<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
// 	require("../../phpmailer/class.phpmailer.php");
// 	require("../../phpmailer/class.smtp.php");
// 	require("../../phpmailer/class.pop3.php");

	$sregid=$_POST['id'];
	$spaiddt=$_POST['paiddt'];
	$spaidamt=$_POST['premi'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];


	

	if($_GET['module']=='add'){

			header("location:../../media.php?module=certificate");
	}
	
	elseif($_GET['module']=='update'){
			
			header("location:../../media.php?module=certificate");
	}
	
	elseif($_GET['module']=='cancel'){
		
			$scanceldt=$_POST['canceldt'];
			$scatreason=$_POST['catreason'];
			$sreason=$_POST['reason'];
			
			$sqle = "insert into tr_sppa_cancel(regid,tglbatal,refund,masa,sisa,createby,createdt,statcan,catreason,reason)";
			$sqle = $sqle . " select regid,'$scanceldt',0,masa,floor(DATEDIFF(akhir,'$scanceldt')/30.4), ";
			$sqle = $sqle . " '$userid','$sdate','1','$scatreason','$sreason' from tr_sppa  ";
			$sqle = $sqle . " where regid='$sregid' and datediff('$scanceldt',mulai)>30 ";
			$hasill = $db->query($sqle);

			$sqle = "insert into tr_sppa_cancel(regid,tglbatal,refund,masa,sisa,createby,createdt,statcan,catreason,reason)";
			$sqle = $sqle . " select regid,'$scanceldt',tpremi,masa,floor(DATEDIFF(akhir,'$scanceldt')/30.4), ";
			$sqle = $sqle . " '$userid','$sdate','1','$scatreason','$sreason' from tr_sppa  ";
			$sqle = $sqle . " where regid='$sregid' and datediff('$scanceldt',mulai)<30 ";
			$hasill = $db->query($sqle);
			
			$sqlu="UPDATE tr_sppa SET status='7'  ";
			$sqlu=$sqlu . " WHERE regid='$sregid'  ";
			$hasill = $db->query($sqlu);
		header("location:../../media.php?module=certificate");
	}
	elseif($_GET['module']=='refund'){
		
			$scanceldt=$_POST['canceldt'];
			$scatreason=$_POST['catreason'];
			$sreason=$_POST['reason'];
			
			$sqle = "insert into tr_sppa_cancel(regid,tglbatal,refund,masa,sisa,createby,createdt,statcan,catreason,reason)";
			$sqle = $sqle . " select regid,'$scanceldt',floor(DATEDIFF(akhir,'$scanceldt')/30.4)/masa*(60*tpremi),masa,floor(DATEDIFF(akhir,'$scanceldt')/30.4), ";
			$sqle = $sqle . " '$userid','$sdate','1','$scatreason','$sreason' from tr_sppa  ";
			$sqle = $sqle . " where regid='$sregid' and datediff('$scanceldt',mulai)>30 ";
			$hasill = $db->query($sqle);

			$sqle = "insert into tr_sppa_cancel(regid,tglbatal,refund,masa,sisa,createby,createdt,statcan,catreason,reason)";
			$sqle = $sqle . " select regid,'$scanceldt',tpremi,masa,floor(DATEDIFF(akhir,'$scanceldt')/30.4), ";
			$sqle = $sqle . " '$userid','$sdate','1','$scatreason','$sreason' from tr_sppa  ";
			$sqle = $sqle . " where regid='$sregid' and datediff('$scanceldt',mulai)<30 ";
			file_put_contents('eror.txt', $sqlq, FILE_APPEND | LOCK_EX); 
			$hasill = $db->query($sqle);
			
			$sqlu="UPDATE tr_sppa SET status='8'  ";
			$sqlu=$sqlu . " WHERE regid='$sregid'  ";
			$hasill = $db->query($sqlu);
			
			$sqlb= " insert into tr_billing (billno,billdt,duedt,policyno,reffno,grossamt,nettamt,admamt,discamt,totalamt,remark,billtype) ";
			$sqlb= $sqlb . "select concat(aa.prevno,DATE_FORMAT(now(),aa.formdt),aa.billno) sbillno, ";
			$sqlb= $sqlb . " now(),date_add(now(),interval 15 day),bb.policyno,regid endorsno,gpremi*-1,gpremi*-1,0,0,gpremi*-1,'Refund Premi',1   ";
			$sqlb= $sqlb . "from (select a.prevno, concat(right(concat(a.formseqno,b.lastno),formseqlen)) billno ,formdt  ";
			$sqlb= $sqlb . " from tbl_lastno_form a inner join tbl_lastno_trans b on a.trxid=b.trxid  where a.trxid='billpre') aa ,  ";
			$sqlb= $sqlb . " (select regid,policyno,sum(tpremi) gpremi from tr_sppa  ";
			$sqlb= $sqlb . " where regid='$sregid' group by policyno,regid) bb ";
		
			$hasiln = $db->query($sqlb);

			
			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'billpre'";
			$hasiln = $db->query($sqln);
			
		header("location:../../media.php?module=certificate");
	}
	

	elseif($_GET['module']=='paid') {	
	
			$npaidamt=str_replace(',', '', $spaidamt);
			$sqle = "update tr_sppa set status='20'";
			$sqle = $sqle . " where regid='$sregid' ";
			$hasill = $db->query($sqle); 
			
			$sqll="insert into tr_sppa_paid(regid,paiddt,paidamt,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','$spaiddt','$npaidamt','$userid','$sdate') ";
			
			/* file_put_contents('erorl.txt', $sqll, FILE_APPEND | LOCK_EX);  */
			$query=$db->query($sqll);	
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','20','$userid','$sdate') ";
			$query=$db->query($sqll);			
			
			header("location:../../media.php?module=certificate");	
		
	}
	
	elseif($_GET['module']=='topup') {	
			$sup=str_replace('.', '', $_POST['up']);
			$sproduk=$_POST['produk'];		
			$sjkel=$_POST['jkel'];		
			$smasa=$_POST['masa'];		
			$stunggakan=$_POST['tunggakan'];		
			$smulai=$_POST['mulai'];		
			$stgllahir=$_POST['tgllahir'];		
			
			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'regid'";
			$hasill = $db->query($sqll);
			$barisl = $hasill->fetch_array();
			$nourut = $barisl[0];

			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'regid'";
			$hasiln = $db->query($sqln);
			$regid=$nourut;
			
			
			/* $susia = date_diff(date_create($stgllahir), date_create($smulai)); */
			
			$sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
			$sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) between umurb and umura and insperiodmm='$smasa'";
			$sqlq = $sqlq . " and '$stunggakan' between gpb and gpa  and $sup between minup and maxup";
			file_put_contents('erorrate.txt', $sqlq, FILE_APPEND | LOCK_EX); 
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
			
			$sqlt="insert into tr_sppa ( ";
			$sqlt= $sqlt . " regid,nama,noktp,jkel,pekerjaan,cabang,tgllahir,mulai,akhir,masa, ";	
 			$sqlt= $sqlt . " up,status,createdt,createby,nopeserta,usia,";	
 			$sqlt= $sqlt . " premi,epremi,tpremi,bunga,tunggakan,produk,mitra,comment,asuransi,policyno ) ";
			$sqlt= $sqlt . " select   '$regid',aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,'$smulai','$sakhir','$smasa', ";	
 			$sqlt= $sqlt . " '$sup',	'0','$sdate','$userid','','$susia',";	
 			$sqlt= $sqlt . " '$spremi','$sepremi','$stpremi','$sbunga','$stunggakan1','$sproduk',aa.mitra,'$scomment','',''  ";
			$sqlt= $sqlt . " from tr_sppa aa where aa.regid='$sregid' ";
			/* file_put_contents('erortopup.txt', $sqlt, FILE_APPEND | LOCK_EX);  */
			$query=$db->query($sqlt);	
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$regid','0','$userid','$sdate') ";
			$query=$db->query($sqll);			
			
			header("location:../../media.php?module=certificate&&act=topuphsl&&id=".$regid );
		
	}
?>