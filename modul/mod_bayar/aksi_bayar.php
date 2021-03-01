<?php
    session_start();
	include("../../config/koneksi.php");
// 	include("../../config/fungsi_indotgl.php");
	include("../../config/fungsi_all.php");
	date_default_timezone_set('Asia/Jakarta');
	
	
	
// 	$sregid     = encrypt_decrypt("decrypt",$_POST['regid']);
	$sregid     = $_POST['regid'];
	$stglbayar  = $_POST['tglbayar'];	
	$jenisTrans = $_POST['jenis-transaksi'];
	$backUrl    = $_POST['url'];
	$userid     = $_SESSION['idLog'];
	$modul      = $_GET['module'];
	$comment    = $_POST['subject'];
	$jenisKas   = $_POST['jenis-kas'];
	$sdate      = date('Y-m-d H:i:s');
	$ajax       = $_POST['dajax'];

	if($modul=='add'){
	    // Hitung PaidID
		$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno 
		         FROM tbl_lastno_form a 
		         LEFT JOIN tbl_lastno_trans b ON a.trxid=b.trxid  
		         WHERE a.trxid= 'paidid'";
		$hasill = $db->query($sqll);
		$barisl = $hasill->fetch_array();
		$nourut = $barisl[0];

		$sqln = "UPDATE tbl_lastno_trans SET lastno=lastno+1
		          WHERE trxid= 'paidid'";
		$hasiln = $db->query($sqln);
		$paidid = $nourut;
        
        if ($jenisTrans=='premi') {
            if ($comment == '') {
                $comment = "Pembayaran Premi";
            } 
            $insPaid = "INSERT INTO tr_sppa_paid(paidid, regid, paiddt, paidamt, createdt, createby,paidtype) 
                        SELECT '$paidid',
                               regid,
                               '$stglbayar',
                               premi,
                               '$sdate',
                               '$userid',
								'PREMI'
                        FROM tr_sppa
                        WHERE regid='$sregid' ";

			$insLog = "INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) 
			            SELECT regid,
			                   '20',
			                   '$sdate',
			                   '$userid',
			                   '$comment'
			            FROM tr_sppa 
			            WHERE regid='$sregid' ";
			
			$updSPPA = "UPDATE tr_sppa SET status = '20'
			              WHERE regid='$sregid'";
        }
        
        elseif ($jenisTrans=='refund') {
            
			$insPaid = "INSERT INTO tr_sppa_paid (paidid, regid, paiddt, paidamt, createdt, createby,paidtype)
    		            SELECT '$paidid',
    		                   sp.regid,
    		                   '$stglbayar',
		                       IF (bd.regid IS NOT NULL,
		                           IF (DATEDIFF(sc.tglbatal,'$stglbayar')>30,
		                               sc.refund,
		                               sp.premi),
		                           sp.premi),
    		                   '$sdate',
    		                   '$userid',
							   'REFUND'
    		            FROM tr_sppa sp
    		            LEFT JOIN tr_bordero_dtl bd ON bd.regid = sp.regid
    		            LEFT JOIN tr_sppa_cancel sc ON sc.regid = sp.regid
    		            WHERE sp.regid='$sregid'";
			
// 			//Bodero = True & Date > 30 Days -> Refund Prorate
// 			$sqlBT = "INSERT INTO tr_sppa_paid (paidid, regid, paiddt, paidamt, createdt, createby)
//     		            SELECT '$paidid',
//     		                   sp.regid,
//     		                   '$stglbayar',
//     		                   sc.refund,
//     		                   '$sdate',
//     		                   '$userid' 
//     		            FROM tr_sppa sp
//     		            LEFT JOIN tr_bordero_dtl bd ON bd.regid = sp.regid AND bd.regid IS NOT NULL
//     		            LEFT JOIN tr_sppa_cancel sc ON sc.regid = sp.regid AND datediff(sc.tglbatal,'$stglbayar')>30
//     		            WHERE sp.regid='$sregid'";
// 			$hasilBT = $db->query($sqlBT);
			
// 			//Bordero = True & Date < 30 Days -> Refund 100 %
// 			$sqlBTFull = "INSERT INTO tr_sppa_paid (paidid, regid, paiddt, paidamt, createdt, createby)
//         		            SELECT '$paidid',
//         		                   sp.regid,
//         		                   '$stglbayar',
//         		                   sp.premi,
//         		                   '$sdate',
//         		                   '$userid' 
//         		            FROM tr_sppa sp
//         		            LEFT JOIN tr_bordero_dtl bd ON bd.regid = sp.regid AND bd.regid IS NOT NULL
//         		            LEFT JOIN tr_sppa_cancel sc ON sc.regid = sp.regid AND datediff(sc.tglbatal,'$stglbayar')<30
//         		            WHERE sp.regid='$sregid'";
// 			$hasilBTFull = $db->query($sqlBTFull);
			
            if ($jenisKas == 'masuk') {               // kas masuk dari asuransi
                if ($comment !== '') {
                    $comment = "Refund Kas Masuk, ket: ".$comment;
                } else {
                    $comment = "Refund Kas Masuk";
                }
                $insLog = "INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) 
    			            SELECT regid,
    			                   '85',
    			                   '$sdate',
    			                   '$userid',
    			                   '$comment'
    			            FROM tr_sppa
    			            WHERE regid='$sregid' ";
    			
    			$updSPPA = "UPDATE tr_sppa SET status = '85'
    			              WHERE regid='$sregid'";
            }
            
            elseif ($jenisKas == 'keluar') {
                if ($comment !== '') {
                    $comment = "Refund Kas Keluar, ket: ".$comment;
                } else {
                    $comment = "Refund Kas Keluar";
                }
                $insLog = "INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) 
    			            SELECT regid,
    			                   '84',
    			                   '$sdate',
    			                   '$userid',
    			                   '$comment'
    			            FROM tr_sppa
    			            WHERE regid='$sregid' ";
    			
    			$updSPPA = "UPDATE tr_sppa SET status = '84'
    			              WHERE regid='$sregid'";
            }
            
        }
        
        elseif ($jenisTrans=='claim') {
            if ($comment == '') {
                $comment = "Pembayaran Claim";
            } 
            $jmlbayarclaim = str_replace('.', '', $_POST['jmlbyr']);
            $insPaid = "INSERT INTO tr_sppa_paid(paidid, regid, paiddt, paidamt, createdt, createby,paidtype) 
                         SELECT '$paidid',
                                a.regid,
                                '$stglbayar',
                                '$jmlbayarclaim',
                                '$sdate',
                                '$userid',
								'CLAIM'
                         FROM tr_sppa a
                         INNER JOIN tr_claim b
                                 ON b.regid = a.regid
                         WHERE a.regid='$sregid' ";

			$insLog = "INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) 
			             SELECT regid,
			                    '95',
			                    '$sdate',
			                    '$userid',
			                    '$comment'
			             FROM tr_sppa 
			             WHERE regid='$sregid' ";
			
			$updSPPA = "UPDATE tr_sppa SET status = '95'
			             WHERE regid='$sregid'";
			
			$updClaim = "UPDATE tr_claim SET statclaim = '95'
    		             WHERE regid='$sregid'";
        }
        
        if ( $db->query($insPaid) ) {
            file_put_contents('SQL-log.txt', "[".date("Y-m-d h:i:s")."] ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insPaid))."\r\n", FILE_APPEND | LOCK_EX);
            if ( $db->query($insLog) ) {
                file_put_contents('SQL-log.txt', "[".date("Y-m-d h:i:s")."] ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                if ( $db->query($updSPPA) ) {
                    file_put_contents('SQL-log.txt', "[".date("Y-m-d h:i:s")."] ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                    if ( $jenisTrans == 'claim' ) {
                        if ( $db->query($updClaim) ) {
                            file_put_contents('SQL-log.txt', "[".date("Y-m-d h:i:s")."] ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                			if ( isset($ajax) ) {
                                // header("location:../mod_email/email.php?regid=$sregid&&jenis=claimpaid");
                                echo "berhasil";
                            } else {
                                // header("location:../mod_email/email.php?regid=$sregid&&jenis=claimpaid&&url=$backUrl");
                                header("location:../../media.php?module=claim");
                            }
                        } else {
            			    file_put_contents('SQL-error.txt', "[".date("Y-m-d h:i:s")."] ---- Error Update tr_claim\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
        			        echo "Gagal Update SPPA";
            			}
                    } else {
                        if (isset($ajax)) {
                            echo "berhasil";
                        } else {
                            header("location:../../media.php?module=$backUrl" );
                        }
                    }
                } else {
    			    file_put_contents('SQL-error.txt', "[".date("Y-m-d h:i:s")."] ---- Error Update tr_sppa\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
			        echo "Gagal Update SPPA";
    			}
            } else {
			    file_put_contents('SQL-error.txt', "[".date("Y-m-d h:i:s")."] ---- Error Insert Log\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
		        echo "Gagal Insert Log";
			}    
        } else {
		    file_put_contents('SQL-error.txt', "[".date("Y-m-d h:i:s")."] ---- Error Insert Paid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insPaid))."\r\n", FILE_APPEND | LOCK_EX);
	        echo "Gagal Insert Paid";
		}
			
	}
	
	elseif($modul=='update'){
		
			$paidid = $_POST['paid-id'];
			$userid = $_POST['userid'];
			$status = $_POST['data-status'];
			$regid  = $_POST['reg-id'];
			$stglbayar = $_POST['paid-dt'];
			
			$sqlu="UPDATE tr_sppa_paid SET paiddt='$stglbayar' WHERE paidid='$paidid'";
			$query=$db->query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
			$sqll = $sqll . " select '$regid','$status','$userid',now(),'Edit Tanggal Bayar'";
			$query=$db->query($sqll);
			
			header("location:../../media.php?module=bayar");
	}
	
	

	elseif($modul=='delete') {	
				
			$paidid=$_GET['id'];
			$sregid=$_GET['regid'];
			$userid=$_GET['uid'];
			
			$cekData = $db->query("SELECT status
			                        FROM tr_sppa
			                        WHERE regid = '$sregid'");
            while ($row = mysql_fetch_assoc($cekData)) {
                switch($row['status']) {
                    case '20':                  // Paid
                        $statusBaru = '5';      // Validasi
                        break;
                    case '84':                  // Refund Paid Broker
                        $statusBaru = '83';     // Refund Validasi
                        break;
                    case '85':                  // Refund Paid Asuransi
                        $statusBaru = '84';     // Refund Paid Broker
                        break;
                    case '95':                  // Claim Paid
                        $statusBaru = '93';     // Claim Valid
                        break;
                }
            }

            $sqlu="delete from tr_sppa_paid ";
			$sqlu=$sqlu . " WHERE paidid='$paidid'  ";
			$query=$db->query($sqlu);
			
			$sqll = "INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) 
			            SELECT '$sregid',
			                   '$statusBaru',
			                   now(),
			                   '$userid',
			                   'Hapus Pembayaran' ";
			$query=$db->query($sqll);
			
			$sqlup="UPDATE tr_sppa SET status='$statusBaru' 
			        WHERE regid='$sregid'";
			$queryup = $db->query($sqlup);
			
			header("location:../../media.php?module=bayar");
	}
	
	elseif($modul=='cari') {
	    $id = $_POST['id'];
	    $cariData = $db->query("SELECT sp.paidid,
	                                    tr.regid,
	                                    tr.nama,
	                                    sp.paiddt
	                             FROM tr_sppa_paid sp
	                             LEFT JOIN tr_sppa tr ON tr.regid = sp.regid
	                             WHERE sp.paidid = '$id'");
	    while ($row = mysql_fetch_assoc($cariData)){
	        $result = $row;
	    }
	    
	    echo json_encode($result);
	}
?>