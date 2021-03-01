<?php
    session_start();
	include("../../config/koneksi.php");
// 	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	define('MB', 1048576);

	$sregid     = $_POST['regid'];
	$snopeserta = $_POST['nopeserta'];
	$snama      = $_POST['nama'];
	$sjkel      = $_POST['jkel'];
	$snoktp     = $_POST['noktp'];
	$spekerjaan = $_POST['pekerjaan'];
	$scabang    = $_POST['cabang'];
	$stgllahir  = $_POST['tgllahir'];	
	$smulai     = $_POST['mulai'];
	$smasa      = $_POST['masa'];
	$sproduk    = $_POST['produk'];
	$sup        = $_POST['up'];
	$smitra     = $_POST['mitra'];
	$sdate      = date('Y-m-d H:i:s');
	$requestid  = $_POST['requestid'];
	$userid     = $_SESSION['idLog'];
	$vlevel     = $_SESSION['idLevel'];

	if($_GET['module']=='add'){
		
		$scanceldt  = $_POST['tglbatal'];
		$scatreason = $_POST['catreason'];
		$sreason    = $_POST['reason'];

		$insCan = " INSERT  INTO tr_sppa_cancel
                            (regid, tglbatal, refund, masa, sisa, createby, createdt, statcan, catreason, reason)
                    SELECT  regid,
                            '$scanceldt',
                            0,
                            masa,
                            Floor(Datediff(akhir, '$scanceldt') / 30.4),
                            '$userid',
                            '$sdate',
                            '1',
                            '$scatreason',
                            '$sreason'
                    FROM    tr_sppa
                    WHERE   regid = '$sregid' ";
		
		$updSPPA = "UPDATE tr_sppa
                    SET    status = '7'
                    WHERE  regid = '$sregid' ";
		
		$insLog = " INSERT INTO tr_sppa_log
                                (regid, status, createby, createdt)
                    VALUES      ('$sregid',
                                 '7',
                                 '$userid',
                                 '$sdate') ";
                                 
        if ($db->query($insCan)) {
            file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insCan))."\r\n", FILE_APPEND | LOCK_EX);
			if ($db->query($updSPPA)) {
			    file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
    			if ($db->query($insLog)) {
    			    file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
        			header("location:../../media.php?module=cancel");
    			} else {
    			    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
			        echo "Gagal Insert Log";
    			}
			} else {
			    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
		        echo "Gagal Update SPPA";
			}
        } else {
            file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insCan))."\r\n", FILE_APPEND | LOCK_EX);
	        echo "Gagal Insert Cancel";
        }
	}
	
	else if($_GET['module']=='refund'){
		
		$scanceldt  = $_POST['tglbatal'];
		$scatreason = $_POST['catreason'];
		$sreason    = $_POST['reason'];
		
        $insCan = " INSERT  INTO tr_sppa_cancel
                            (regid, tglbatal, refund, masa, sisa, createby, createdt, statcan, catreason, reason)
                    SELECT a.regid,
                           '$scanceldt',
                           IF (b.regid IS NULL, 
                               0, 
                               IF (Datediff('$scanceldt', b.paiddt) < 30,
                           			a.premi,
                                   (Floor(Datediff(akhir, '$scanceldt') / 30.4) / masa ) * (tpremi * 50 / 100 ))),
                           masa,
                           Floor(Datediff(akhir, '$scanceldt') / 30.4),
                           '$userid',
                           '$sdate',
                           '1',
                           '$scatreason',
                           '$sreason'
                    FROM   tr_sppa a
                           LEFT JOIN tr_sppa_paid b
                              ON a.regid = b.regid
                              AND b.paidtype = 'PREMI'
                    WHERE  a.regid = '$sregid'
                    	AND b.regid IS NOT NULL ";
		
		$updSPPA = "UPDATE tr_sppa
                    SET    status = '8'
                    WHERE  regid = '$sregid'";
		
		$insLog = " INSERT INTO tr_sppa_log
                                (regid, status, createby, createdt)
                    VALUES      ('$sregid',
                                 '8',
                                 '$userid',
                                 '$sdate')  ";
		
		if ($db->query($insCan)) {
    		file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insCan))."\r\n", FILE_APPEND | LOCK_EX);
		    if ($db->query($updSPPA)) {
        		file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
		        if ($db->query($insLog)) {
            		file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
		            header("location:../../media.php?module=cancel");
		        } else {
		            file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
			        echo "Gagal Insert Log";
		        }
		    } else {
		        file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
		        echo "Gagal Update SPPA";
		    }
		} else {
		    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insCan))."\r\n", FILE_APPEND | LOCK_EX);
		    echo "Gagal Insert Cancel";
		}
	}
	
	elseif($_GET['module']=='approve'){
	    $sregid     = $_GET['regid'];
	    $querycek   = $db->query("SELECT status from tr_sppa where regid = '$sregid'");
        $dcek       = $querycek->fetch_assoc();
        $dstatus    = $dcek['status'];

        if ($vlevel == 'insurance') {
            $statBatal  = ['72'];
            $statRefund = ['82'];
            
            if (in_array($dstatus, $statBatal)) {
                $statBaru = '73';
            } elseif (in_array($dstatus, $statRefund)) {
                $statBaru = '83';
            }
		}
		
		elseif ($vlevel == 'broker') {
		    $statBatal  = ['7','71'];
		    $statRefund = ['8','81'];
		    
		    if (in_array($dstatus, $statBatal)) {
		        $statBaru = '72';
		    } elseif (in_array($dstatus, $statRefund)) {
		        $statBaru = '82';
		        $insBil = " INSERT INTO tr_billing
                                        (billno, billdt, duedt, policyno, reffno, grossamt, nettamt, admamt, discamt, totalamt, remark, billtype)
                            SELECT Concat(aa.prevno, Date_format(Now(), aa.formdt), aa.billno) sbillno,
                                  Now(),
                                  Date_add(Now(), interval 15 day),
                                  bb.policyno,
                                  regid                                                       endorsno,
                                  gpremi,
                                  gpremi,
                                  0,
                                  0,
                                  gpremi,
                                  Concat('Refund Premi ; tanggal batal ', bb.tglbatal),
                                  1
                            FROM   (SELECT a.prevno,
                                          Concat(Right(Concat(a.formseqno, b.lastno), formseqlen)) billno,
                                          formdt
                                    FROM   tbl_lastno_form a
                                          inner join tbl_lastno_trans b
                                                  ON a.trxid = b.trxid
                                    WHERE  a.trxid = 'billpre') aa,
                                  (SELECT a.regid,
                                          b.policyno,
                                          SUM(a.refund) *- 1 gpremi,
                                          a.tglbatal
                                    FROM   tr_sppa_cancel a
                                          inner join tr_sppa b
                                                  ON a.regid = b.regid
                                    WHERE  a.regid = '$sregid'
                                    GROUP  BY b.policyno,
                                              a.regid) bb  ";
                                              
    			$updLast = "UPDATE tbl_lastno_trans
                            SET    lastno = lastno + 1
                            WHERE  trxid = 'billpre'  ";
    			    
    			if ($db->query($insBil)) {
    			    file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insBil))."\r\n", FILE_APPEND | LOCK_EX);
    			    if ($db->query($updLast)) {
    			        file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updLast))."\r\n", FILE_APPEND | LOCK_EX);
    			    } else {
    			        file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updLast))."\r\n", FILE_APPEND | LOCK_EX);
            		    echo "Gagal Update Last Number";
            		    break;
    			    }
    			} else {
    			    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insBil))."\r\n", FILE_APPEND | LOCK_EX);
        		    echo "Gagal Insert Billing";
        		    break;
    			}
		    }
	    }
	    
	    elseif ($vlevel == 'schecker') {
	        $statBatal  = ['7'];
	        $statRefund = ['8'];
	        
	        if (in_array($dstatus, $statBatal)) {
	            $statBaru = '71';
	        } elseif (in_array($dstatus, $statRefund)) {
	            $statBaru = '81';
	        }
			
	    }
	    
	    $updSPPA = "UPDATE tr_sppa
                    SET    status = '$statBaru',
                          editby = '$userid',
                          editdt = '$sdate'
                    WHERE  regid = '$sregid'
                          AND status = '$dstatus'  ";
		
		$insLog = " INSERT INTO tr_sppa_log
                                (regid, status, createby, createdt)
                    VALUES      ('$sregid',
                                 '$statBaru',
                                 '$userid',
                                 '$sdate')  ";
		if ($db->query($updSPPA)) {
		    file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
		    if ($db->query($insLog)) {
		        file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
        		header("location:../../media.php?module=cancel");
		    } else {
		        file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
    		    echo "Gagal Insert Log";
		    }
		} else {
		    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
		    echo "Gagal Update SPPA";
		}
	}

	elseif($_GET['module']=='update'){
		
		$sregid     = $_POST['regid'];
		$scanceldt  = $_POST['tglbatal'];
		$scatreason = $_POST['catreason'];
		$sreason    = $_POST['reason'];
                        
		$updCan = " UPDATE tr_sppa_cancel
                    SET    tglbatal = '$scanceldt',
                          catreason = '$scatreason',
                          reason = '$sreason'
                    WHERE  regid = '$sregid'  ";
		if ($db->query($updCan)) {
		    file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updCan))."\r\n", FILE_APPEND | LOCK_EX);
		    header("location:../../media.php?module=cancel");    
		} else {
		    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updCan))."\r\n", FILE_APPEND | LOCK_EX);
		    echo "Gagal Insert Cancel";
		}
	}

	elseif($_GET['module']=='rollback') {
		$sregid      = $_POST['id'];
		$comment     = $_POST['comment'];
		if ($comment == '') {
		    $comment = $comment;
		} else {
		    $comment = ", catatan: ".$comment;
		}
		
		$cekid  = $db->query("SELECT status FROM tr_sppa WHERE regid = '$sregid'");
		$data   = $cekid->fetch_assoc();
		$dstatus= $data['status'];
		
		if ($dstatus == '7') {
		    $statBaru = '5';
		} elseif ($dstatus == '71') {
		    $statBaru = '7';
		} elseif ($dstatus == '72') {
		    $statBaru = '71';
		} elseif ($dstatus == '73') {
		    $statBaru = '72';
		} elseif ($dstatus == '8') {
		    $statBaru = '20';
		} elseif ($dstatus == '81') {
		    $statBaru = '8';
		} elseif ($dstatus == '82') {
		    $statBaru = '81';
		} elseif ($dstatus == '83') {
		    $statBaru = '82';
		}
		
		$updSPPA = "UPDATE tr_sppa 
                    SET   status = '$statBaru', 
                          editby = '$userid', 
                          editdt = '$sdate'
                    WHERE  regid = '$sregid' ";
		
		$insLog = " INSERT INTO tr_sppa_log 
                                (regid, status, createby, createdt, comment) 
                    VALUES      ('$sregid', 
                                 '$statBaru', 
                                 '$userid', 
                                 '$sdate', 
                                 'Rollback$comment') ";
		
		if ($db->query($updSPPA)) {
		    file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
		    if ($db->query($insLog)) {
		        file_put_contents('SQL-log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
    		    echo json_encode("berhasil");
		    } else {
    		    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
    		    echo json_encode("gagal");
		    }
		} else {
		    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
		    echo json_encode("gagal");
		}
	}
	
	
	elseif ($_GET['module'] == 'cekbordero') {
	    $id    = $_GET['id'];
	    $sql   = $db->query("SELECT * FROM tr_bordero_dtl WHERE `regid` = '$id'");
	    $num   = $sql->num_rows;
	    echo json_encode($num);
	}
?>