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
	$sucab=$_POST['ucab'];
	$sstatus=$_POST['status'];
	$scomment=$_POST['subject'];

	
	if($_GET['module']=='update'){
			$sid=$_POST['id'];
			if ($sstatus=='4'){
			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'polno'";
			$hasill = mysql_query($sqll);
			$barisl = mysql_fetch_array($hasill);
			$nourut = $barisl[0];

			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'polno'";
			$hasiln = mysql_query($sqln);
			$policyno=$nourut;
			
			$sqlu="UPDATE tr_sppa SET nopeserta='$snopeserta',policyno='$policyno',status='5', validby='$userid',validdt='$sdate' WHERE regid='$sid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);
			
			$sqlb= " insert into tr_billing (billno,billdt,duedt,policyno,reffno,grossamt,nettamt,admamt,discamt,totalamt,remark,billtype) ";
			$sqlb= $sqlb . "select concat(aa.prevno,DATE_FORMAT(now(),aa.formdt),aa.billno) sbillno, ";
			$sqlb= $sqlb . " now(),date_add(now(),interval 15 day),bb.policyno,regid endorsno,gpremi,gpremi,0,0,gpremi,'Premi New business',1   ";
			$sqlb= $sqlb . "from (select a.prevno, concat(right(concat(a.formseqno,b.lastno),formseqlen)) billno ,formdt  ";
			$sqlb= $sqlb . " from tbl_lastno_form a inner join tbl_lastno_trans b on a.trxid=b.trxid  where a.trxid='billpre') aa ,  ";
			$sqlb= $sqlb . " (select regid,policyno,sum(tpremi) gpremi from tr_sppa  ";
			$sqlb= $sqlb . " where regid='$sid' group by policyno,regid) bb ";
		
			$hasiln = mysql_query($sqln);
			$query=mysql_query($sqlb);
			
			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'billpre'";
			$hasiln = mysql_query($sqln);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " select regid,'5','$userid','$sdate','$scomment' from tr_sppa where regid='$sid'  ";
			$query=mysql_query($sqll);	
			}
			if ($sstatus=='10'){
			$sqlu="UPDATE tr_sppa SET nopeserta='$snopeserta',status='11', validby='$userid',validdt='$sdate' WHERE regid='$sid'   ";
			file_put_contents('eror1.txt', $sqlu, FILE_APPEND | LOCK_EX);  
			$query=mysql_query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " select regid,'11','$userid','$sdate','$scomment' from tr_sppa where regid='$sid'  ";
			file_put_contents('eror2.txt', $sqll, FILE_APPEND | LOCK_EX);   
			$query=mysql_query($sqll);	
			}
			
			header("location:../../media.php?module=valid");
	}
	elseif($_GET['module']=='reject'){
		
		
			$sid=$_POST['regid'];
			$sqlr="UPDATE tr_sppa SET comment='$scomment', status='12', validby='$userid',validdt='$sdate' WHERE regid='$sid'";
			$query=mysql_query($sqlr);	
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " select regid,'12','$userid','$sdate',concat(comment,' ; aplikasi di cancel request ao') from tr_sppa where regid='$sid'  ";
			$query=mysql_query($sqll);	
			
			
			header("location:../../media.php?module=valid");
		

	}
	elseif($_GET['module']=='rollback'){
		
		
			$sid=$_POST['regid'];
			$sqlr="UPDATE tr_sppa SET comment='$scomment', status='1' WHERE regid='$sid' and status='4' ";
			$query=mysql_query($sqlr);	
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " select regid,'3','$userid','$sdate','$scomment' from tr_sppa where regid='$sid'  ";
			$query=mysql_query($sqll);	
			
			$sqlr="UPDATE tr_sppa SET comment='$scomment', status='1' WHERE regid='$sid' and status='10' ";
			$query=mysql_query($sqlr);	
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " select regid,'10','$userid','$sdate','$scomment' from tr_sppa where regid='$sid'  and status='10' ";
			$query=mysql_query($sqll);	
			
			header("location:../../media.php?module=valid");
	}


?>