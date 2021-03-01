<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php"); 


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
			$hasilq = $db->query($sqlq);
			$barisq = $hasilq->fetch_array();
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
		
		$query=$db->query($sql);
		header("location:../../media.php?module=msuser");

	}
	
	elseif($_GET['module']=='update'){
		$sql="UPDATE ms_admin SET mitra='$smitra',level='$slevel' , ";
		$sql= $sql . " nama='$snama',email='$semail',nohp='$snohp', parent='$sparent',cabang='$scabang', ";
		$sql= $sql . " editby='$userid',editdt='$sdate' WHERE username='$suname' ";
		file_put_contents('erorsql.txt', $sql, FILE_APPEND | LOCK_EX); 
		$query=$db->query($sql);
		header("location:../../media.php?module=msuser");
	}
	elseif($_GET['module']=='delete'){
		$id=$_GET['id'];
		$sqld="update  ms_admin set password=MD5('#*xxxxx@!') sWHERE username='$id' ";
		$query=$db->query($sqld);
		header("location:../../media.php?module=msuser");
	}
	elseif($_GET['module']=='reset') {	
		$id=$_GET['id'];
		$sqlu="update  ms_admin set password=md5(CONCAT(SUBSTR(username,4,2),id_ADMIN,'@!')),supervisor=CONCAT(SUBSTR(username,4,2),id_ADMIN,'@!') ";
		$sqlu=$sqlu . " WHERE username='$id'";
		$query=$db->query($sqlu);
		header("location:../../media.php?module=msuser");
		
	}
	
	elseif($_GET['module']=='email') {	
	$id=$_GET['id'];
			
	$equery = $db->query("select  a.email usremail ,
							b.email broemail,
							c.email insemail,
							'nusafams@gmail.com' cliemail
							from ms_admin a 
							left join ms_systab b on a.username<>b.companycd
							left join ms_insurance c on c.asuransi<>b.companycd
							and c.asuransi=(select asuransi from tr_sppa where regid='211907002688')
							where a.username='BROSTB3105'");
	$e = $equery->fetch_array();
	/* $usremail = $e['usremail'];
	$insemail = $e['insemail'];
	$broemail = $e['broemail'];
	$cliemail= $e['cliemail']; */
	
	$usremail = 'nusafams@gmail';
	$insemail ='askestkp@gmail.com';
	$broemail = 'nurman@tugukresna.com';
	$cliemail= 'renozfams@gmail.com';
	
    $query = $db->query("select a.regid,a.regclaim,b.nama,b.up,b.produk,a.tglkejadian,a.tgllapor,b.noktp,a.nilaios,a.detail,
							c.msdesc stat,d.msdesc sproduk,e.msdesc cab,f.nama ao 
							from tr_claim a 
							inner join tr_sppa b on a.regid=b.regid
							inner join (select msid,msdesc from ms_master where mstype='streq') c on b.`status`=c.msid
							left join (select msid,msdesc from ms_master where mstype='produk') d on d.msid=b.produk
							left join (select msid,msdesc from ms_master where mstype='cab') e on e.msid=b.cabang
							left join (select username,nama from ms_admin ) f on f.username=b.createby
							where a.regclaim='221910000045'
                          ");
    $r = $query->fetch_array();
	$regid = $r['regid'];
	$regclaim = $r['regclaim'];
	$nama= $r['nama'];
	$up= $r['up'];
	$sproduk= $r['sproduk'];
	$tglkejadian = $r['tglkejadian'];
	$tgllapor= $r['tgllapor'];
	$detail= $r['detail'];
	$noktp= $r['noktp'];
	$nilaios= $r['nilaios'];
	$stat= $r['stat'];
	$ao= $r['ao'];
	$cab= $r['cab'];
	
 
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPSecure = 'tls';
			$mail->SMTPDebug  = 0;  
			$mail->Port       = 2525;
			$mail->SMTPAuth = true;
			$mail->Host       = "smtp.elasticemail.com";
			$mail->Username = "siaplakusupp@gmail.com";
			$mail->Password = "1A66F61A80F126D9C492BCDC0A2E20077BEC";
			$mail->SetFrom("noreply@siap-laku.com", "SIAP Informasi"); 
			$mail->AddReplyTo("noreply@siap-laku.com", "SIAP Informasi"); 
			$mail->AddAddress($usremail);  
			$mail->addCC($broemail);
			$mail->addCC($cliemail);
			$mail->addCC($insemail);
			$mail->addBCC("siaplakusupp@gmail.com");
			$mail->Subject =  "Informasi Claim  No Register " . $regid . " - " . $nama ;
			$mail->WordWrap   = 100;
		
		
			$message = '<html><body>';
			$message .= ' <br> ';	
			$message .= 'Yth. Bapak/Ibu';
			$message .= ' <br> ';
			$message .= ' <br> ';
			$message .= 'Kami telah menerima pengajuan  klaim sebagai berikut : ';
			$message .= ' <br>';
			$message .= ' <br> ';	
			$message .= '<table style="width:100%">';
			$message .= "<tr><td><strong>No Register</strong> </td><td>" .': '. strip_tags($regid) . "</td></tr>";
			$message .= "<tr><td><strong>No Claim</strong> </td><td>" .': '.  strip_tags($regclaim) . "</td></tr>";
			$message .= "<tr><td><strong>Nama </strong> </td><td>" .': '.  strip_tags($nama) . "</td></tr>";
			$message .= "<tr><td><strong>No KTP</strong> </td><td>" .': '.  strip_tags($noktp) . "</td></tr>";
			$message .= "<tr><td><strong>Produk</strong> </td><td>" .': '.  strip_tags($sproduk) . "</td></tr>";
			$message .= "<tr><td><strong>UP</strong> </td><td>" .': '.  strip_tags($up) . "</td></tr>";
			$message .= "<tr><td><strong>Tgl Lapor</strong> </td><td>" .': '.  strip_tags($tgllapor) . "</td></tr>";
			$message .= "<tr><td><strong>Tgl Meninggal</strong> </td><td>" .': '.  strip_tags($tglkejadian) . "</td></tr>";
			$message .= "<tr><td><strong>Nilai </strong> </td><td>" .': '.  strip_tags($nilaios) . "</td></tr>";
			$message .= "<tr><td><strong>AO </strong> </td><td>" .': '.  strip_tags($ao) . "</td></tr>";
			$message .= "<tr><td><strong>Cabang </strong> </td><td>" .': '.  strip_tags($cab) . "</td></tr>";
			$message .= "<tr><td><strong>Status </strong> </td><td>" .': '.  strip_tags($stat) . "</td></tr>";
			
			$message .= "</table>";
			$message .= ' <br> ';	
			$message .= 'Salam';
			$message .= ' <br> ';	
			$message .= 'PT. Bina Dana Sejahtera ';
			$message .= ' <br> ';	
			$message .= ' <br> ';
			$message .= ' <br> ';	
			$message .= 'Mohon untuk tidak membalas email ini. untuk pertanyaan silahkan email ke personal.bdspt@gmail.com';
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