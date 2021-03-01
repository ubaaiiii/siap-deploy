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
	$smitra=$_POST['mitra'];
	$stgllahir=$_POST['tgllahir'];	
	$smulai=$_POST['mulai'];
	$smasa=$_POST['masa'];
	$sproduk=$_POST['produk'];
	$sup=$_POST['up'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$scomment=$_POST['subject'];
	$sasuransi=$_POST['asuransi'];



	

	if($_GET['module']=='update'){
			$sregid=$_POST['id'];
			

			$susia=hitung_umur($stgllahir);
			$sqlq = "select  rates,ratesother,tunggakan,bunga  ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' and '$susia' between umurb and umura and insperiodmm='$smasa'";
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
			

			$sqlu="UPDATE tr_sppa SET nopeserta='$snopeserta', nama='$snama',noktp='$snoktp', asuransi='$sasuransi',status='4',editby='$userid',editdt ='$sdate', ";
			$sqlu=$sqlu . " comment='$scomment',cabang='$scabang',mitra='$smitra' WHERE regid='$sregid'";
			file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   
			$query=$db->query($sqlu);

			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','4','$userid','$sdate','$scomment') ";
			$query=$db->query($sqll);	
			
			header("location:../../media.php?module=verif");
	}
		elseif($_GET['module']=='rollback'){
			$sregid=$_POST['id'];
			$userid=$_POST['uid'];
			$sqlu="update tr_sppa set ";
			$sqlu=$sqlu . " status='2',comment='$scomment' where regid='$sregid'";
			
			/* $sqlu="update tr_sppa set ";
			$sqlu=$sqlu . " status='3',comment=concat(comment,' ; no pinjaman harus di isi')  where regid='$sregid' and status='4' "; */
			/* file_put_contents('erore.txt', $sqlu, FILE_APPEND | LOCK_EX);    */
			$query=$db->query($sqlu);
			
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " select regid,'2','$userid','$sdate','$scomment' from tr_sppa where regid='$sregid'  ";
			$query=$db->query($sqll);			

			/* $sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " select regid,'3','$userid','$sdate',concat(comment,' ; no pinjaman harus di isi') from tr_sppa where regid='$sregid' and status='4' ";
			$query=$db->query($sqll);	 */
			
			header("location:../../media.php?module=verif");
			


	}

	elseif($_GET['module']=='reject'){
			$sid=$_POST['id'];
			
			$sqlr="UPDATE tr_sppa SET comment='$scomment', status='12', editby='$userid',editdt='$sdate' WHERE regid='$sid'";
			/* file_put_contents('eror.txt', $sqlr, FILE_APPEND | LOCK_EX); */
			
			$query=$db->query($sqlr);

			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll=$sqll . " values ('$sregid','12','$userid','$sdate','$scomment') ";
			$query=$db->query($sqll);	
			
			
			header("location:../../media.php?module=verif");
	}	

?>