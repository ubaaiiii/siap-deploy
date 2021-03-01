<?php

	date_default_timezone_set("Asia/Jakarta");

	include("../../config/koneksi.php");
	include("../../config/fungsi.php");
	$sreptype=$_POST['reptype'];
	$sdate = date('Y/m/d H:i:s');
	$suser= 'admin';
	
	if($_GET['module']=='print'){
		

		$fildir='modul/filing/policy/' ;
		if (is_dir($fildir)){
			if ($dh = opendir($fildir)){
			while (($file = readdir($dh)) !== false ){
		
				$sfileop=$fildir . '/' . $file;
				$sqlt="insert into tr_filing  (docno)";
				$sqlt= $sqlt . "select '$sfileop' from tr_filing limit 1 ";
				file_put_contents('erorxx.txt', $sqlt, FILE_APPEND | LOCK_EX);
				$query=mysql_query($sqlt);
			}
			}
		}
/* 			$fildir='modul/filing/policy/' ;
			if (is_dir($fildir)){
			if ($dh = opendir($fildir)){
			while (($file = readdir($dh)) !== false ){
				$sfileop=$fildir . '/' . $file;
				$sqlt="insert into tr_filing  (docno)";
				$sqlt= $sqlt . "select '$sfileop' from tr_filing limit 1 ";
				file_put_contents('erorxx.txt', $sqlt, FILE_APPEND | LOCK_EX);
				$sql = $db->prepare($sqlt);
				
				}
				closedir($dh);
				}
				} */
				
		header("location:../../media.php?module=util");
	}

	
?>