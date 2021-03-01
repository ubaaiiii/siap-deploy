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
	


	
	if($_GET['module']=='update'){
			$sregid=$_POST['regid'];


			$sup=str_replace(',', '', $_POST['up']);
			$sqle="select aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai, ";
			$sqle= $sqle . " aa.akhir,aa.masa,aa.up,aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby, ";
			$sqle= $sqle . " aa.validdt,aa.nopeserta,aa.usia,aa.premi,aa.epremi,aa.tpremi, ";
			$sqle= $sqle . " aa.bunga,aa.tunggakan, aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno ";
			$sqle= $sqle . " from tr_sppa aa where  regid='$sregid' ";  
			file_put_contents('erore.txt', $sqle, FILE_APPEND | LOCK_EX);   
			$query=$db->query($sqle);
			while($r=$query->fetch_array()){
				$sjkel=$r['jkel'];
				$stgllahir=$r['tgllahir'];
				$stunggakan=$r['tunggakan'];
				$smasa=$r['masa'];
			}
		
			$sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
			$sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) ";
			$sqlq = $sqlq . " between umurb and umura and insperiodmm='$smasa'";
			$sqlq = $sqlq . " and '$stunggakan' between gpb and gpa and  $sup between minup and maxup  ";
			file_put_contents('erorq.txt', $sqlq, FILE_APPEND | LOCK_EX);   
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
			
		
			$sqlu="UPDATE tr_sppa SET masa='$smasa',mulai='$smulai',akhir='$sakhir',usia='$susia', ";
			$sqlu= $sqlu . " up='$sup',nopeserta='$snopeserta' where regid='$sregid'";
			$query=$db->query($sqlu);
			file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   


			header("location:../../media.php?module=checker");
	}
	

	elseif($_GET['module']=='approve') {	
			$sregid=$_GET['id'];
			$slvl=$_GET['lvl'];
			$userid=$_GET['uid'];
			if ($slvl=="checker")
			{
	
			$sqlu="UPDATE tr_sppa SET status='2',editby='$userid' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'  ";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=$db->query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','2','$userid','$sdate','approve checker') ";
			$query=$db->query($sqll);	
			}
			if ($slvl=="schecker")
			{

			/*update status spv checker*/
			$sqlu="UPDATE tr_sppa SET status='3',editby='$userid' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'  ";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=$db->query($sqlu);
			/*isi log status untuk spv checker*/
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','3','$userid','$sdate','approve checker') ";
			$query=$db->query($sqll);	

			
			$sqlu="UPDATE tr_sppa SET status='4',editby='$userid' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'  and status='3'  ";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=$db->query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','4','system','$sdate','verification by system') ";
			$query=$db->query($sqll);	
			
			
			
			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'polno'";
			$hasill = $db->query($sqll);
			$barisl = mysql_fetch_array($hasill);
			$nourut = $barisl[0];

			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'polno'";
			$hasiln = $db->query($sqln);
			$policyno=$nourut;
			
			$sqlu="UPDATE tr_sppa SET policyno='$policyno',status='5', validby='$userid',validdt='$sdate' WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=$db->query($sqlu);
			
			$sqlb= " insert into tr_billing (billno,billdt,duedt,policyno,reffno,grossamt,nettamt,admamt,discamt,totalamt,remark,billtype) ";
			$sqlb= $sqlb . "select concat(aa.prevno,DATE_FORMAT(now(),aa.formdt),aa.billno) sbillno, ";
			$sqlb= $sqlb . " now(),date_add(now(),interval 15 day),bb.policyno,regid endorsno,gpremi,gpremi,0,0,gpremi,'Premi New business',1   ";
			$sqlb= $sqlb . "from (select a.prevno, concat(right(concat(a.formseqno,b.lastno),formseqlen)) billno ,formdt  ";
			$sqlb= $sqlb . " from tbl_lastno_form a inner join tbl_lastno_trans b on a.trxid=b.trxid  where a.trxid='billpre') aa ,  ";
			$sqlb= $sqlb . " (select regid,policyno,sum(tpremi) gpremi from tr_sppa  ";
			$sqlb= $sqlb . " where regid='$sregid' group by policyno,regid) bb ";
			$query=$db->query($sqlb);
			
			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'billpre'";
			$query=$db->query($sqln);


			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','5','system','$sdate','valid by system') ";
			$query=$db->query($sqll);	
			
			}
			

			header("location:../../media.php?module=checker");
		
	}
	
	elseif($_GET['module']=='rollback') {	
			$sregid=$_GET['id'];
			$slvl=$_GET['lvl'];
			$userid=$_GET['uid'];
			$sqlu="UPDATE tr_sppa SET status='0',editby='$userid' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=$db->query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','0','$userid','$sdate','rollback by checker/schecker') ";
			$query=$db->query($sqll);	
			
			header("location:../../media.php?module=checker");
		
	}
?>