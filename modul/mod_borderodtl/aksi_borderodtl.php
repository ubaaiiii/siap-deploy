<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	$id=$_POST['id'];
	
	$period1=$_POST['period1'];
	$period2=$_POST['period2'];
	$sfilter3=$_POST['sfilter3'];
	$sfilter4=$_POST['sfilter4'];
	$userid=$_POST['userid'];
	$sdate = date('Y-m-d H:i:s');
	$reffdt= date('Y-m-d');
	if($_GET['module']=='add'){
		
		$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
		$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
		$sqll = $sqll = $sqll . " where a.trxid= 'regbor'";
		$hasill = mysql_query($sqll);
		$barisl = mysql_fetch_array($hasill);
		$nourut = $barisl[0];

		$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'regbor'";
		$hasiln = mysql_query($sqln);
		$borderono=$nourut;
			
		
		$sql="INSERT INTO tr_bordero (borderono,reffdt,period1,period2,reffamt,createby,createdt) ";
		$sql= $sql . " VALUES ('$borderono','$reffdt','$period1','$period2',0,'$userid','$sdate')";
		/* file_put_contents('eror.txt', $sql, FILE_APPEND | LOCK_EX); */
		$query=mysql_query($sql);
		
		$sqld= " insert into tr_bordero_dtl (borderono,regid,createdt,createby,lststatus,premi)";
		$sqld= $sqld . " select '$borderono',a.regid,'$sdate','$userid',a.status,a.premi from tr_sppa a left join tr_bordero_dtl b on a.regid=b.regid ";
		$sqld= $sqld . "  where (a.createdt between '$period1' and '$period2' ) ";
		$sqld= $sqld . "  and a.produk='$sfilter3' and a.status='$sfilter4' ";
		file_put_contents('erorb.txt', $sqld, FILE_APPEND | LOCK_EX); 
		$query=mysql_query($sqld);
		
		$sqld= "update tr_bordero set reffamt=(select sum(premi) from tr_bordero_dtl a ";
		$sqld= $sqld . "inner join tr_sppa b on a.regid=b.regid ";
		$sqld= $sqld . "where a.borderono='$borderono') ";
		$sqld= $sqld . "where borderono='$borderono' ";
		$query=mysql_query($sqld);
		
		header("location:../../media.php?module=bordero");
	}
	
	elseif($_GET['module']=='update'){
		$query=mysql_query("UPDATE ms_master SET desck='$sdesk',editby='$userid',editdt='$sdate' WHERE msid='$id' and mstype='$stype' ");
		header("location:../../media.php?module=bordero");
	}

	elseif($_GET['module']=='adddetail'){
		$borderono=$_POST['borderono'];
		$regid=$_POST['regid'];
		$sql="INSERT INTO tr_bordero_dtl (borderono,regid,createby,createdt) VALUES ('$borderono','$regid','$userid','$sdate')";
		 /* file_put_contents('eror.txt', $sql, FILE_APPEND | LOCK_EX); */
		$query=mysql_query($sql);
		
		
		$sqld= "update tr_bordero set reffamt=(select sum(premi) from tr_bordero_dtl a ";
		$sqld= $sqld . "inner join tr_sppa b on a.regid=b.regid ";
		$sqld= $sqld . "where a.borderono='$borderono') ";
		$sqld= $sqld . "where borderono='$borderono' ";
		$query=mysql_query($sqld);
		header("location:../../media.php?module=bordero&&act=detail&&id=".$borderono);
	}
	
	elseif($_GET['module']=='delete'){
		$id=$_GET['id'];
		$query=mysql_query("DELETE FROM ms_master WHERE msid='$id'");
		header("location:../../media.php?module=bordero");
	}
	elseif($_GET['module']=='print') {	
	
		
	}
?>