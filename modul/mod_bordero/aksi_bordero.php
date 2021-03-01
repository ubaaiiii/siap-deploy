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
	$exdate=date("YmdHis");
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
		$sqld= $sqld . " select '$borderono',a.regid,'$sdate','$userid',a.status,a.premi from tr_sppa a ";
		$sqld= $sqld . " inner join tr_sppa_paid c on a.regid=c.regid ";
		$sqld= $sqld . " left join tr_bordero_dtl b on a.regid=b.regid ";
		$sqld= $sqld . "  where (c.paiddt between '$period1' and '$period2' ) ";
		$sqld= $sqld . "  and a.produk='$sfilter3' and b.regid is null ";
		/* file_put_contents('erordtl.txt', $sqld, FILE_APPEND | LOCK_EX);   */
		$query=mysql_query($sqld);

		$sqld= "update tr_bordero set reffamt=(select sum(a.premi) from tr_bordero_dtl a ";
		$sqld= $sqld . "inner join tr_sppa b on a.regid=b.regid ";
		$sqld= $sqld . "where a.borderono='$borderono') ";
		$sqld= $sqld . "where borderono='$borderono' ";
		$query=mysql_query($sqld);
		
		
		
		/* insert into tr_bordero_dtl (borderono,regid,createdt,createby,lststatus,premi)
		select d.borderono,a.regid,d.createdt,d.createby,a.status,a.premi from tr_sppa a 
		inner join tr_sppa_paid c on a.regid=c.regid 
		inner join tr_bordero d on a.produk=d.produk and a.asuransi=d.branch 
		left join tr_bordero_dtl b on a.regid=b.regid 
		where (c.paiddt between d.period1 and d.period2) 
		and  b.regid is null  */
		
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
		
		
		$sqld= "update tr_bordero set reffamt=(select sum(a.premi) from tr_bordero_dtl a ";
		$sqld= $sqld . "inner join tr_sppa b on a.regid=b.regid ";
		$sqld= $sqld . "where a.borderono='$borderono') ";
		$sqld= $sqld . "where borderono='$borderono' ";
		$query=mysql_query($sqld);
		header("location:../../media.php?module=bordero&&act=detail&&id=".$borderono);
	}
	

	elseif($_GET['module']=='export') {	
		$sid=$_GET['id'];
		
		$stitle="Laporan Data Bordero ";		
		$file_name="lapbordet". $exdate;							
		$sql = "select d.borderono, f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql=$sql . " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql=$sql . " akhir,masa,a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,a.createdt tglinput, ";
		$sql=$sql . " concat('`',a.policyno) nosertifikat  from tr_sppa a ";
		$sql=$sql . " inner join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql=$sql . " inner join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql=$sql . " inner join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql=$sql . " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql=$sql . " inner join tr_bordero_dtl d on d.regid=a.regid  where d.borderono='$sid'  ";
		
	

//create query to select as data from your table
//run mysql query and then count number of fields
$export = mysql_query ( $sql ) ;
$fields = mysql_num_fields ( $export );
//create csv header row, to contain table headers 
//with database field names
for ( $i = 0; $i < $fields; $i++ ) {
	$header .= mysql_field_name( $export , $i ) . ",";
}
//this is where most of the work is done. 
//Loop through the query results, and create 
//a row for each
while( $row = mysql_fetch_row( $export ) ) {
	$line = '';
	//for each field in the row
	foreach( $row as $value ) {
		//if null, create blank field
		if ( ( !isset( $value ) ) || ( $value == "" ) ){
			$value = ",";
		}
		//else, assign field value to our data
		else {
			$value = str_replace( '"' , '""' , $value );
			$value = '"' . $value . '"' . ",";
		}
		//add this field value to our row
		$line .= $value;
	}
	//trim whitespace from each row
	$data .= trim( $line ) . "\n";
}
//remove all carriage returns from the data
$data = str_replace( "\r" , "" , $data );
//create a file and send to browser for user to download
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: xls" . date("Y-m-d") . ".xls");
header("Content-disposition: filename=".$file_name.".xls");
print "$stitle\n\n\n$header\n$data";
exit;
		
		
	}
		
	
?>