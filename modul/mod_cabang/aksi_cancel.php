<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php");
	
	$snopeserta=$_POST['nopeserta'];
	$snama=$_POST['nama'];
	$sjkel=$_POST['jkel'];
	$snoktp=$_POST['noktp'];
	$spekerjaan=$_POST['pekerjaan'];
	$scabang=$_POST['cabang'];
	$stgllahir=$_POST['tgllahir'];	
	$smulai=$_POST['mulai'];
	$smasa=$_POST['masa'];
	$sproduk=$_POST['produk'];
	$sup=$_POST['up'];
	$smitra=$_POST['mitra'];
	$sdate = date('Y-m-d H:i:s');
	$requestid=$_POST['requestid'];
	$userid=$_POST['userid'];
	$status='1';


	

	if($_GET['module']=='add'){
		
			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'regid'";
			$hasill = mysql_query($sqll);
			$barisl = mysql_fetch_array($hasill);
			$nourut = $barisl[0];

			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'regid'";
			$hasiln = mysql_query($sqln);
			$regid=$nourut;
			

			/* $susia = date_diff(date_create($stgllahir), date_create($smulai)); */
			$susia=hitung_umur($stgllahir);
			$sqlq = "select  rates,ratesother,tunggakan,bunga  ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' and '$susia' between umurb and umura and insperiodmm='$smasa'";
			
			/* file_put_contents('eror.txt', $sqlq, FILE_APPEND | LOCK_EX); */
			$hasilq = mysql_query($sqlq);
			$barisq = mysql_fetch_array($hasilq);
			$srates = $barisq[0];
			$sratesoth = $barisq[1];
			$stunggakan = $barisq[2];
			$sbunga= $barisq[3];
			
			$spremi=($sup*$srates)/100;
			$sepremi=($sup*$sratesoth)/100;
			$stpremi=($spremi+$sepremi);


			$sakhir=tgl_akhir($smulai,$smasa);
			$sqle = "insert into tr_sppa(regid,	nama,noktp,	jkel,pekerjaan,	cabang, ";
			$sqle = $sqle . " tgllahir,	mulai,	akhir,	masa,	up,nopeserta,status,createby,createdt,premi,epremi,tpremi,usia,produk,tunggakan,bunga,mitra) ";
			$sqle = $sqle . " values ('$regid',	'$snama','$snoktp',	'$sjkel','$spekerjaan',	'$scabang', ";
			$sqle = $sqle . " '$stgllahir',	'$smulai',	'$sakhir',	'$smasa',	'$sup','$snopeserta','$status','$userid','$sdate','$spremi', ";
			$sqle = $sqle . " '$sepremi','$stpremi','$susia','$sproduk','$stunggakan','$sbunga','$smitra') ";
			/* file_put_contents('eror.txt', $sqlq, FILE_APPEND | LOCK_EX);  */
			$hasill = mysql_query($sqle);
			


			header("location:../../media.php?module=ajuan&&act=update&&id=".$regid );
	}
	
	elseif($_GET['module']=='approve'){
		
			$sregid=$_GET['id'];
			


			
			$sqlu="UPDATE tr_sppa SET status='71',editby='$userid',editdt ='$sdate' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);

			

			
			header("location:../../media.php?module=cancel");
	}


	elseif($_GET['module']=='appbro'){
		
			$sregid=$_GET['id'];
			


			
			$sqlu="UPDATE tr_sppa SET status='72' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);

			

			
			header("location:../../media.php?module=cancel");
		}	
		
	elseif($_GET['module']=='appins'){
		
			$sregid=$_GET['id'];
			

			/* $susia=hitung_umur($stgllahir);
			$sqlq = "select  rates,ratesother,tunggakan,bunga  ";
			$sqlq = $sqlq . " from  tr_rates  ";
			$sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' and '$susia' between umurb and umura and insperiodmm='$smasa'"; */
			/* file_put_contents('erorp.txt', $sqlq, FILE_APPEND | LOCK_EX);   */

		/* 	$hasilq = mysql_query($sqlq);
			$barisq = mysql_fetch_array($hasilq);
			$srates = $barisq[0];
			$sratesoth = $barisq[1];
			$stunggakan = $barisq[2];
			$sbunga= $barisq[3];
			
			$spremi=($sup*$srates)/100;
			$sepremi=($sup*$sratesoth)/100;
			$stpremi=($spremi+$sepremi);


			$sakhir=tgl_akhir($smulai,$smasa); */
			
			
			$sqlu="UPDATE tr_sppa SET status='73' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query=mysql_query($sqlu);

			

			
			header("location:../../media.php?module=cancel");
	}
elseif($_GET['module']=='reject'){
		$sregid=$_POST['regid'];
		$query=mysql_query("update tr_request set streq='12' WHERE requestid='$id'");
		$query=mysql_query("UPDATE tr_leave SET streq='12' WHERE leaveid='$id'");
		$query=mysql_query(" insert into tr_request_log(reqid,streq,editby,editdt) values ('$id','12','$userid','$sdate') ");
		
		
		$sqle = "select a.empname,c.msdesc,e.msdesc branchnm,d.msdesc deptnm,f.email pemail,a.eid,b.startdt,b.enddt,b.duration,b.reason ";
			$sqle = $sqle . " from ms_employee a inner join tr_leave b on a.eid=b.eid  ";
			$sqle = $sqle . " inner join ms_master c on c.msid=b.leavetype ";
			$sqle = $sqle . " inner join ms_master d on d.msid=a.dept ";
			$sqle = $sqle . " inner join ms_master e on e.msid=a.branch ";
			$sqle = $sqle . " inner join ms_employee f on a.parentid=f.eid ";
			$sqle = $sqle . " where b.leaveid= '$requestid'";
			/* file_put_contents('eror.txt', $sqle, FILE_APPEND | LOCK_EX); */
			
			$hasill = mysql_query($sqle);
			$barisl = mysql_fetch_array($hasill);
			$sempname = $barisl[0];
			$deptnm = $barisl[3];
			$branchnm = $barisl[2];
			$stype = $barisl[1];
			$pemail = $barisl[4];
			$eid = $barisl[5];
			$startdt = $barisl[6];
			$enddt = $barisl[7];
			$duration = $barisl[8];
			$reason = $barisl[9];
			
			
			
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
			$mail->AddAddress($pemail);
			$mail->AddAddress("sdm@tugukresna.com");  
			$mail->addBCC("norman@tugukresna.com");
			$mail->Subject =  "[SIDAMAN] Akses aplikasi SIDAMAN   " . $sempname ;
			$mail->WordWrap   = 100;
			
			
			$message = '<html><body>';
			$message .= ' <br> ';	
			$message .= 'Yth. Bapak/Ibu';
			$message .= ' <br> ';
			$message .= ' <br> ';
			$message .= 'Permohonan untuk  ' . $stype . ' di bawah ini telah di setujui : ' ;
			$message .= ' <br>';
			$message .= ' <br> ';	
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td><strong>Nama:</strong> </td><td>" . strip_tags($sempname) . "</td></tr>";
			$message .= "<tr><td><strong>NIP:</strong> </td><td>" . strip_tags($eid) . "</td></tr>";
			$message .= "<tr><td><strong>Bagian:</strong> </td><td>" . strip_tags($branchnm) . "</td></tr>";
			$message .= "<tr><td><strong>Cabang:</strong> </td><td>" . strip_tags($deptnm) . "</td></tr>";
			$message .= "<tr><td><strong>Mulai Tgl:</strong> </td><td>" . strip_tags($startdt) . "</td></tr>";
			$message .= "<tr><td><strong>S.d. Tgl:</strong> </td><td>" . strip_tags($enddt) . "</td></tr>";
			$message .= "<tr><td><strong>Lama:</strong> </td><td>" . strip_tags($duration) . "</td></tr>";
			$message .= "<tr><td><strong>Jenis:</strong> </td><td>" . strip_tags($stype) . "</td></tr>";
			$message .= "<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($reason) . "</td></tr>";
			$message .= "<tr><td><strong>Konfirmasi:</strong> </td><td>" . $linkapprove . "</td></tr>";
			$message .= "</table>";
			$message .= ' <br> ';	
			$message .= 'Bagian SDM & Umum';
			$message .= ' <br> ';	
			$message .= 'PT. Tugu Kresna Pratama ';
			$message .= "</body></html>";
			$mail->MsgHTML($message);
			$mail->IsHTML(true);
			if(!$mail->Send()) 
			echo "Problem sending email.";
			else 
			echo "email sent.";
		
		header("location:../../media.php?module=approval");
	}
	
	

	elseif($_GET['module']=='print') {	
	
		
	}
?>