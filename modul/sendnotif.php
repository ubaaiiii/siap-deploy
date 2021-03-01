<?php
	date_default_timezone_set('Asia/Jakarta');
	include("../../config/koneksi.php");
	include("../../config/fungsi.php");
	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php");
	
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;
			/* $mail->SMTPAuth = TRUE; */
		 	/* $mail->SMTPSecure = "ssl";  */
			$mail->Port     = 26;  
			$mail->Username = "noreply@tugukresna.com";
			$mail->Password = "p4nc0r4n5jkt!";
			$mail->Host     = "mail.tugukresna.com";
			$mail->SetFrom("noreply@tugukresna.com", "Asuransi Tugu Kresna Pratama");
			$mail->AddReplyTo("noreply@tugukresna.com", "Asuransi Tugu Kresna Pratama");
/* 			$mail->AddAddress($pemail);
			$mail->AddAddress($semail);
			$mail->addBCC("sdm@tugukresna.com");   */
			$mail->addBCC("norman@tugukresna.com");
			$mail->Subject =  "[SIDAMAN] [". $nourut . "] Laporan Kehadiran Karyawan  "  ;
			$mail->WordWrap   = 100;
		
		
			$message = '<html><body>';
			$message .= ' <br> ';	
			$message .= 'Yth. Bapak/Ibu';
			$message .= ' <br> ';
			$message .= ' <br> ';
			$message .= 'Mohon di berikan persetujuan kepada karyawan sebagai berikut : ';
			$message .= ' <br>';
			$message .= ' <br> ';	
			$message .= '<table cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td><strong>Nama:</strong> </td><td>" . strip_tags($sempname) . "</td></tr>";
			$message .= "<tr><td><strong>Bagian:</strong> </td><td>" . strip_tags($deptnm) . "</td></tr>";
			$message .= "<tr><td><strong>Cabang:</strong> </td><td>" . strip_tags($branchnm) . "</td></tr>";
			$message .= "<tr><td><strong>NIP:</strong> </td><td>" . strip_tags($_POST['eid']) . "</td></tr>";
			$message .= "<tr><td><strong>Tanggal:</strong> </td><td>" . strip_tags($_POST['startdt']) . "</td></tr>";
			$message .= "<tr><td><strong>Jenis:</strong> </td><td>" . strip_tags($stype) . "</td></tr>";
			$message .= "<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($_POST['reason']) . "</td></tr>";
			$message .= '<tr><td><strong>Konfirmasi:</strong> </td><td><a href="http://tugukresna.com/hrs/media.php?module=approval" target="_blank">Approve</a></td></tr>';
			$message .= "</table>";
			$message .= ' <br> ';	
			$message .= 'Bagian SDM & Umum';
			$message .= ' <br> ';	
			$message .= 'PT. Tugu Kresna Pratama ';
			$message .= "</body></html>";
		
		

		
		
			$mail->MsgHTML($message);
			$mail->IsHTML(true);
			if(!$mail->Send()) {
			echo "Problem sending email.";
			else 
			echo "email sent.";
			}
?>