<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi.php");
	date_default_timezone_set('Asia/Jakarta');

	$regid=$_POST['regid'];
	$snama=$_POST['snama'];
	$sjdoc=$_POST['jdoc'];
	
	$userid=$_SESSION['idLog'];
	$sdate = date('Y/m/d H:m:s');
	if($_GET['module']=='add'){
				$allowed_ext	= array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip','jpg','tif','png');
				$file_name		= $_FILES['fupload']['name'];
				$file_ext		= strtolower(end(explode('.', $file_name)));
				$file_size		= $_FILES['fupload']['size'];
				$file_tmp		= $_FILES['fupload']['tmp_name'];
				$snamafile		= $file_name ;
				$lokasi 		= 'files/'.$snamafile.'.'.$file_ext;
				move_uploaded_file($file_tmp, $lokasi);
				
			$sqlq="INSERT INTO tr_document (regid,tglupload,nama_file,tipe_file,ukuran_file,file) ";
			$sqlq=$sqlq . " VALUES('$regid', '$sdate', '$snamafile', '$file_ext', '$file_size', '$lokasi')";
			$query = mysql_query($sqlq);

			header("location:../../media.php?module=doc&&id=".$regid);
	}
	
	elseif($_GET['module']=='update'){
			$query=mysql_query("UPDATE ms_employee_dep SET depname='$depname',editby='$userid',editdt='$sdate' WHERE  concat(eid,seqno)='$id'");
			header("location:../../media.php?module=doc&&id=".$regid);
	}
	elseif($_GET['module']=='delete'){
		$id=$_GET['sedit'];
		$regid=substr($id,0,12);
		$query=mysql_query("DELETE FROM tr_document WHERE regid='$id'");
		header("location:../../media.php?module=doc&&id=".$regid);
	}
?>
