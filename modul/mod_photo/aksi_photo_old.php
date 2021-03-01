<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi.php");
	date_default_timezone_set('Asia/Jakarta');

	$regid=$_POST['regid'];
	$snama=$_POST['snama'];
	$snamafile=$_POST['namafile'];
	$userid=$_SESSION['idLog'];
	$sdate = date('Y/m/d H:m:s');
	if($_GET['module']=='add'){
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}

			header("location:../../media.php?module=photo&&id=".$regid);
	}
	
	elseif($_GET['module']=='update'){

			$sumber = $_FILES['userfile']['tmp_name'];
			$lregid=$_POST['regid'];
			$sregid=$_POST['regid'] . '.jpg';
			$target = '../../photo/'. $sregid ; 

			if(move_uploaded_file($sumber, $target))
			{
			 echo "File Uploaded Successfully";
			 echo "Uploaded File : 
			 ";
			 echo "<img src='$target'>";
			}
			else 
				echo"Can't Upload Selected File ";

	
			header("location:../../media.php?module=photo&&act=view&&id=".$lregid);
	}
	elseif($_GET['module']=='delete'){
		$id=$_GET['sedit'];
		$eid=substr($id,0,8);
		$query=mysql_query("DELETE FROM ms_employee_dep WHERE concat(eid,seqno)='$id'");
	header("location:../../media.php?module=dependent&&eid=".$eid);
	}
?>
