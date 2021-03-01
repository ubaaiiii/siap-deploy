<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	/* require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php"); */
	use PHPMailer\src\PHPMailer;
	use PHPMailer\src\SMTP;

	date_default_timezone_set('Asia/Jakarta');
	
	$suname=$_POST['uname'];
	$semail=$_POST['email'];
	$snohp=$_POST['nohp'];
	$snama=$_POST['nama'];
	$smitra=$_POST['mitra'];
	$sparent=$_POST['parent'];
	$scabang=$_POST['cabang'];
	$slevel=$_POST['level'];
	$userid=$_POST['userid'];
	$sdate = date('Y-m-d H:i:s');


	
	if($_GET['module']=='add'){
	
			$sqlq = " select id_admin from ms_admin order by id_admin desc limit 1 ";
			$hasilq = mysql_query($sqlq);
			$barisq = mysql_fetch_array($hasilq);
			$surut = $barisq[0]+1;
	
		$snama1=str_replace(' ', '',$snama).$surut;
		$suname=substr($snama1,0,6) . substr($surut,0,4) ;
		$supass=substr($snama1,4,2) . $surut . "@!";
		
		if ($slevel=='smkt')
		{
			$sparent=$suname;
		}
		$sql="INSERT INTO ms_admin (username,id_peg,password,level,nama,email,nohp,mitra,photo, ";
		$sql= $sql . " cabang,parent,createby,createdt,supervisor) ";
		$sql= $sql . " VALUES ('$suname','$suname',md5('$supass'),'$slevel','$snama','$semail','$snohp','$smitra','$sphoto', ";
		$sql= $sql . " '$scabang','$sparent','$userid','$sdate','$supass')";
		file_put_contents('eror.txt', $sql, FILE_APPEND | LOCK_EX);  
		
		$query=mysql_query($sql);
		header("location:../../media.php?module=msuser");

	}
	
	elseif($_GET['module']=='update'){
		$sql="UPDATE ms_admin SET mitra='$smitra',level='$slevel' , ";
		$sql= $sql . " nama='$snama',email='$semail',nohp='$snohp', parent='$sparent',cabang='$scabang', ";
		$sql= $sql . " editby='$userid',editdt='$sdate' WHERE username='$suname' ";
		file_put_contents('erorsql.txt', $sql, FILE_APPEND | LOCK_EX); 
		$query=mysql_query($sql);
		header("location:../../media.php?module=msuser");
	}
	elseif($_GET['module']=='delete'){
		$id=$_GET['id'];
		$sqld="update  ms_admin set password=MD5('#*xxxxx@!') sWHERE username='$id' ";
		$query=mysql_query($sqld);
		header("location:../../media.php?module=msuser");
	}
	elseif($_GET['module']=='reset') {	
		$id=$_GET['id'];
		$sqlu="update  ms_admin set password=md5(CONCAT(SUBSTR(username,4,2),id_ADMIN,'@!')),supervisor=CONCAT(SUBSTR(username,4,2),id_ADMIN,'@!') ";
		$sqlu=$sqlu . " WHERE username='$id'";
		$query=mysql_query($sqlu);
		header("location:../../media.php?module=msuser");
		
	}
	
	elseif($_GET['module']=='email') {	
			$id=$_GET['id'];
			

 
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPSecure = 'tls';
			$mail->SMTPDebug  = 2;  
			$mail->Port       = 2525;
			$mail->Host       = "smtp.elasticemail.com";
			$mail->Username = "siaplakusupp@gmail.com";
			$mail->Password = "1A66F61A80F126D9C492BCDC0A2E20077BEC";
			$mail->SetFrom("noreply@siap-laku.com", "SIAP Informasi"); 
			$mail->AddReplyTo("noreply@siap-laku.com", "SIAP Informasi"); 
			/* $mail->SMTPSecure = 'ssl';
			$mail->Host = 'ssl://smtp.gmail.com';
			$mail->Port = 465; 
			$mail->Username = "askestkp@gmail.com";
			$mail->Password = "k182k182"; */
			/* $mail->SMTPSecure = 'ssl'; 
			$mail->Port     = 587;  
			$mail->Username = "noreply@siap-laku.com";
			$mail->Password = "s1@pb0squ!";
			$mail->Host     = "mail.siap-laku.com";
			$mail->SetFrom("noreply@siap-laku.com", "Asuransi Tugu Kresna Pratama");
			 $mail->AddReplyTo("noreply@siap-laku.com", "Asuransi Tugu Kresna Pratama"); 
			$mail->AddReplyTo("noreply@siap-laku.com", "SIAP Informasi"); */
			$mail->AddAddress("nurman@tugukresna.com");  
			$mail->addBCC("nurman@tugukresna.com");
			$mail->Subject =  "Informasi Claim  " . $id ;
			$mail->WordWrap   = 100;
		
		
			$message = '<html><body>';
			$message .= ' <br> ';	
			$message .= 'Yth. Bapak/Ibu';
			$message .= ' <br> ';
			$message .= ' <br> ';
			$message .= 'Mohon di berikan persetujuan kepada karyawan sebagai berikut : ';
			$message .= ' <br>';
			$message .= ' <br> ';	
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td><strong>Nama:</strong> </td><td>" . strip_tags($id) . "</td></tr>";
			$message .= "<tr><td><strong>Bagian:</strong> </td><td>" . strip_tags($id) . "</td></tr>";
			$message .= "<tr><td><strong>Cabang:</strong> </td><td>" . strip_tags($id) . "</td></tr>";
			$message .= "<tr><td><strong>NIP:</strong> </td><td>" . strip_tags($id) . "</td></tr>";
			$message .= "<tr><td><strong>Tanggal:</strong> </td><td>" . strip_tags($id) . "</td></tr>";
			$message .= "<tr><td><strong>Jenis:</strong> </td><td>" . strip_tags($id) . "</td></tr>";
			$message .= "<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($id) . "</td></tr>";
			$message .= '<tr><td><strong>Konfirmasi:</strong> </td><td><a href="http://tugukresna.com/esdeem/media.php?module=approval" target="_blank">Approve</a></td></tr>';
			$message .= "</table>";
			$message .= ' <br> ';	
			$message .= 'Salam';
			$message .= ' <br> ';	
			$message .= 'PT. Bina Dana Sejahtera ';
			$message .= "</body></html>";
			
			
			$mail->MsgHTML($message);
			$mail->IsHTML(true);
			if (!$mail->send()) {
			 echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
			 echo "Message sent!";
			}
			
			header("location:../../media.php?module=msuser");
		
	}
	

?>