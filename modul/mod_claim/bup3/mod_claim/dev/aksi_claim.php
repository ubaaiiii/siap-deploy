<?php
    session_start();
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php");


	$sregclaim     = $_POST['regclaim'];
	$sregid        = $_POST['regid'];
	$stglkejadian  = $_POST['tglkejadian'];
	$stgllapor     = $_POST['tgllapor'];
	$spekerjaan    = $_POST['subject'];
	$stmpkejadian  = $_POST['tmpkejadian'];
	$stgllahir     = $_POST['tgllahir'];	
	$smulai        = $_POST['mulai'];
	$smasa         = $_POST['masa'];
	$sproduk       = $_POST['produk'];
	$sup           = $_POST['up'];
	$requestid     = $_POST['requestid'];
	$sdetail       = $_POST['subject'];
	$spenyebab     = $_POST['sebab'];
	$tnilaios      = $_POST['nilaios'];
	$snopeserta    = $_POST['nopeserta'];
	$userid        = $_SESSION['idLog'];
	$vlevel        = $_SESSION['idLevel'];
	$sdate         = date('Y-m-d H:i:s');
	$sdoctype      ='CL'.$stmpkejadian.$sproduk;
	

   if($_GET['module']=='add'){
	    
	    if ($vlevel == 'broker') {
	        $status = "91";
			
	    } else {
	        $status = "90";
	        
	    }
	    
	    $snilaios=str_replace('.', '', $tnilaios);
	    
		$sqle = mysql_query("INSERT INTO tr_claim 
                                        (regclaim, regid, tgllapor, tmpkejadian, tglkejadian, detail, statclaim, createdt, createby, penyebab, nopk, nilaios,doctype) 
                             VALUES     ('$sregclaim',
                                         '$sregid',
                                         '$stgllapor',
                                         '$stmpkejadian',
                                         '$stglkejadian',
                                         '$sdetail',
                                         '$status',
                                         '$sdate',
                                         '$userid',
                                         '$spenyebab',
                                         '$snopeserta',
                                         '$snilaios',
        								 '$sdoctype') ");
		/* file_put_contents('sqle.txt', $sqle, FILE_APPEND | LOCK_EX);   */
		$sqlr = mysql_query("UPDATE tr_sppa 
                             SET    status = '$status', 
                                    editby = '$userid', 
                                    editdt = '$sdate' 
                             WHERE  regid  = '$sregid' ");
							 
		/* file_put_contents('sqlr.txt', $sqlr, FILE_APPEND | LOCK_EX);   */
		$sqll = mysql_query("INSERT INTO tr_sppa_log 
                                         (regid,status,createby,createdt,comment) 
                             VALUES      ('$sregid',
                                          '$status',
                                          '$userid',
                                          '$sdate',
                                          'Input claim dilakukan oleh ".ucwords($vlevel).".') ");
		/* file_put_contents('sqll.txt', $sqll, FILE_APPEND | LOCK_EX);   */
		header("location:../../media.php?module=claim");
	}
	
	elseif($_GET['module']=='update'){
		$sregclaim = $_POST['regclaim'];
		
		$snilaios=str_replace('.', '', $tnilaios);
		$sqlu = mysql_query("UPDATE tr_claim 
                             SET    tgllapor    = '$stgllapor', 
                                    tmpkejadian = '$stmpkejadian', 
                                    nilaios     = Replace('$snilaios', ',', ''), 
                                    tglkejadian = '$stglkejadian', 
                                    penyebab    = '$spenyebab', 
                                    editdt      = '$sdate', 
                                    doctype     = '$sdoctype' 
                             WHERE  regclaim = '$sregclaim' ");
		
		header("location:../../media.php?module=claim");
	}


	elseif($_GET['module']=='approve'){
	    
	    if ($vlevel == 'schecker') {
	        $status  = "91";
	        $uField1 = "";
	        $uField2 = "";
	        $comment = "Checker Menyatakan Dokumen Claim Sudah Lengkap";
	    } elseif ($vlevel == 'broker') {
	        $status  = "92";
	        $uField1 = ", verifby = '$userid'";
	        $uField2 = ", verifdt = '$sdate'";
	        $comment = "Broker Menyatakan Dokumen Claim Sudah Benar dan Sesuai Isinya";
	    } elseif ($vlevel == 'insurance') {
	        $status  = "93";
	        $uField1 = ", validby = '$userid'";
	        $uField2 = ", validdt = '$sdate'";
	        $comment = "Asuransi Menyatakan Claim Diterima, Menunggu Untuk Dibayarkan";
	    } else {
	        header("location:../../media.php?module=claim");
	    }
	    
		$sregclaim=$_GET['id'];
		$sregid=$_GET['regid'];

		$sqlu = mysql_query("UPDATE tr_claim 
                             SET    statclaim = '$status'
                                    $uField1
                                    $uField2
                             WHERE  regclaim  = '$sregclaim' ");

		$sqlv = mysql_query("UPDATE tr_sppa 
                             SET    status = '$status' 
                             WHERE  regid  = '$sregid' ");
		
		$sqll = mysql_query("INSERT INTO tr_sppa_log 
                                         (regid, status, createby, createdt, comment) 
                             VALUES      ('$sregid', 
                                          '$status', 
                                          '$userid', 
                                          '$sdate', 
                                          '$comment') ");
		
		header("location:../../media.php?module=claim");
	}	
	
	elseif ($_GET['module'] == 'cekdata') {
	    $id = $_GET['id'];
	    $query = mysql_query("select * from tr_claim where regid = '$id'");
	    $num = mysql_num_rows($query);
	    
	    echo $num;
	}
	
	elseif ($_GET['module'] == 'rollback') {
	    $regid   = $_GET['regid'];
	    $comment = $_GET['comment'];
	    
	    if ($vlevel == 'broker') {
	        $status  = "90";
	        
	    } elseif ($vlevel == 'insurance') {
	        $status  = "93";
	        
	    } else {
	        header("location:../../media.php?module=claim");
	    }

		$sqlu = mysql_query("UPDATE tr_claim 
                             SET    statclaim = '$status'
                             WHERE  regid     = '$regid' ");

		$sqlv = mysql_query("UPDATE tr_sppa 
                             SET    status = '$status',
                                    comment= '$comment'
                             WHERE  regid  = '$regid' ");
		
		$sqll = mysql_query("INSERT INTO tr_sppa_log 
                                         (regid, status, createby, createdt, comment) 
                             VALUES      ('$regid', 
                                          '$status', 
                                          '$userid', 
                                          '$sdate', 
                                          '$comment') ");
		
		echo "berhasil";
	}
	
	elseif ($_GET['module'] == 'reject') {
	    $regid   = $_GET['regid'];
	    $comment = $_GET['comment'];
	    
	    if ($vlevel == 'insurance') {
	        $status  = "94";
	        
	    } else {
	        header("location:../../media.php?module=claim");
	    }

		$sqlu = mysql_query("UPDATE tr_claim 
                             SET    statclaim = '$status'
                             WHERE  regid     = '$regid' ");

		$sqlv = mysql_query("UPDATE tr_sppa 
                             SET    status = '$status',
                                    comment= '$comment'
                             WHERE  regid  = '$regid' ");
		
		$sqll = mysql_query("INSERT INTO tr_sppa_log 
                                         (regid, status, createby, createdt, comment) 
                             VALUES      ('$regid', 
                                          '$status', 
                                          '$userid', 
                                          '$sdate', 
                                          '$comment') ");
		
		if ($sqlu and $sqlv and $sqll) {
		    echo "berhasil";
		} else {
		    echo "Update tr_claim       = $sqlu <br><br>";
		    echo "Update tr_sppa        = $sqlv <br><br>";
		    echo "Insert tr_sppa_log    = $sqll <br><br>";
		}
	}
	


?>