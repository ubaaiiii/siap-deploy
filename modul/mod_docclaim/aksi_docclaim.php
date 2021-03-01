<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi.php");
	date_default_timezone_set('Asia/Jakarta');
	define('MB', 1048576);

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
				
			$sqlq="INSERT INTO tr_document (regid,tglupload,nama_file,tipe_file,ukuran_file,file,jnsdoc,catdoc) ";
			$sqlq=$sqlq . " VALUES('$regid', '$sdate', '$snamafile', '$file_ext', '$file_size', '$lokasi','$sjdoc','clm')";
			$query = mysql_query($sqlq);

			header("location:../../media.php?module=docclaim&&id=".$regid);
	}
	
	
	elseif($_GET['module']=='delete'){
		$id=$_GET['sedit'];
		$regid=substr($id,0,12);
		$query=mysql_query("DELETE FROM tr_document WHERE concat(regid,seqno)='$id'");
		header("location:../../media.php?module=docclaim&&id=".$regid);
	}
	
	elseif($_GET['module']=='upload'){
		$allowed_ext	= array('doc', 'docx', 'pdf', 'jpg', 'tif', 'png');
		$file_name		= $_FILES['fupload']['name'];
		$file_ext		= strtolower(end(explode('.', $file_name)));
		$file_size		= number_format($_FILES['fupload']['size']/1024,2,",",".")." KB";
		$file_tmp		= $_FILES['fupload']['tmp_name'];
		$regid			= $_POST['regid'];
		$snamafile		= $_POST['regid'] . $_POST['jdoc']  ;
		$tgl			= date("Y-m-d");
		$sjdoc			= $_POST['jdoc'];

		if(in_array($file_ext, $allowed_ext) === true){
			if($file_size < 5*MB){
				$lokasi = 'modul/files/'.$snamafile.'.'.$file_ext;
				if (move_uploaded_file($file_tmp, '../../'.$lokasi)) {
				    $sqlq="INSERT INTO tr_document (regid,tglupload,nama_file,tipe_file,ukuran_file,file,jnsdoc,catdoc) ";
    				$sqlq=$sqlq . " VALUES('$regid', '$tgl', '$snamafile', '$file_ext', '$file_size', '$lokasi','$sjdoc','clm')";
    				$query = mysql_query($sqlq);
				}
				if ($query) {
				    echo "berhasil";
				} else {
				    echo "gagal";
				}
			}
		} else {
		    echo "wrong";
		}
	}
?>
