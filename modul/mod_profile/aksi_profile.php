<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi.php");
	$clientcd='12131';
	$clientname='aaaa adasf asd';
	$sdate = date('Y/m/d H:i:s');
	$suser= 'admin';
	$username= $_POST['username'];
	$eid=$_POST['eid'];
	$pass=$_POST['pass'];
	$empname=$_POST['empname'];
	$pob=$_POST['pob'];
	$dob=$_POST['dob'];
	$sex=$_POST['sex'];
	$email=$_POST['email'];
	
	
	if($_GET['module']=='add'){
		$sqlp="insert into ms_profile (clientcd,clientname)";
		$sqlp= $sqlp . " values ('$clientcd','$clientname')";
		$query=$db->query($sqlp);
		header("location:../../media.php?module=profile");
		}
		
	elseif($_GET['module']=='update'){
			$query=$db->query("UPDATE ms_employee SET pob='$pob',email='$email',jk='$sex',editby='$suser',editdt='$sdate' WHERE eid='$eid'");
			header("location:../../media.php?module=profile");
		}

	elseif($_GET['module']=='updatepass'){
		
			$sqlc="UPDATE tbl_admin SET password=md5('$pass') WHERE username='$username'";
			/* file_put_contents('erorc.txt', $sqlc);   */
			$query=$db->query($sqlc);
			header("location:../../media.php?module=profile");
		}		
	
?>