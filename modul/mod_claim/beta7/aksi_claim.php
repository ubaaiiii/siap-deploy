<?php
    session_start();
    header("X-Frame-Options: SAMEORIGIN");
    header("Access-Control-Allow-Origin: *");
	ini_set('session.cookie_secure', 1);
	ini_set('session.use_only_cookies', 1);
	ini_set('session.cookie_httponly', 1);
	include("../../config/koneksi.php");
// 	include("../../config/fungsi_indotgl.php");
	include("../../config/fungsi_all.php");
	date_default_timezone_set('Asia/Jakarta');
	define('MB', 1048576);

	$sregclaim     = $_POST['regclaim'];
// 	$sregid        = encrypt_decrypt("decrypt",$_POST['regid']);
	$sregid        = $_POST['regid'];
	$stglkejadian  = $_POST['tglkejadian'];
	$stgllapor     = $_POST['tgllapor'];
	$catatan       = $_POST['subject'];
	$stmpkejadian  = $_POST['tmpkejadian'];
	$stgllahir     = $_POST['tgllahir'];	
	$smulai        = $_POST['mulai'];
	$smasa         = $_POST['masa'];
	$sproduk       = $_POST['produk'];
	$sinsurance    = $_POST['insurance'];
	$sup           = $_POST['up'];
	$requestid     = $_POST['requestid'];
	$sdetail       = $_POST['subject'];
	$spenyebab     = $_POST['sebab'];
	$tnilaios      = $_POST['nilaios'];
	$snopeserta    = $_POST['nopeserta'];
	$userid        = $_SESSION['idLog'];
	$vlevel        = $_SESSION['idLevel'];
	$sdate         = date('Y-m-d H:i:s');
	$sdoctype      ='CL'.$sinsurance.$stmpkejadian.$sproduk;
	
	$sqlSPPA = "SELECT a.regid,
                       b.msdesc+b.createby wktclm
                FROM tr_sppa a
                    LEFT JOIN  (SELECT msid, msdesc, createby FROM ms_master WHERE mstype='WKTCLM') b
                        ON b.msid = concat(a.asuransi,a.produk) 
                WHERE a.regid ='$sregid' ";
    $s       = $db->query($sqlSPPA)->fetch_assoc();
    $wktclm  = $s['wktclm'];
    
    $tglexpired = date_create($stglkejadian);
    date_add($tglexpired,date_interval_create_from_date_string($wktclm." days"));
    $tglexpired = date_format($tglexpired,'Y-m-d');
    if (isset($_SESSION['idLog'])) {
        if($_GET['module']=='add'){
    	    
    	    if ($vlevel == 'broker') {
    	        $status = "91";
    	    } else {
    	        $status = "90";
    	    }
    	    
    	    $snilaios = str_replace('.', '', $tnilaios);
    	    
    		$insClaim = "INSERT INTO tr_claim 
                                    (regclaim, regid, tgllapor, tmpkejadian, tglkejadian, detail, statclaim, createdt, createby, penyebab, expireddt, nopk, nilaios,doctype) 
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
                                     '$tglexpired',
                                     '$snopeserta',
                                     '$snilaios',
        							 '$sdoctype') ";
    		
    		$updSPPA = "UPDATE tr_sppa 
                        SET    status = '$status', 
                               editby = '$userid', 
                               editdt = '$sdate' 
                        WHERE  regid  = '$sregid' ";
    		
    		$insLog = " INSERT INTO tr_sppa_log 
                                    (regid, status, createby, createdt, comment) 
                        VALUES      ('$sregid',
                                     '$status',
                                     '$userid',
                                     '$sdate',
                                     '$catatan') ";
                                     
            if ($db->query($insClaim)) {
                file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insClaim))."\r\n", FILE_APPEND | LOCK_EX);
                if ($db->query($updSPPA)) {
                    file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                    if ($db->query($insLog)) {
                        file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                        header("location:../../media.php?module=claim");
                        // header("location:../mod_email/email.php?regid=$sregid&&jenis=pengajuan"); 
                    } else {
                        echo "Insert Log Gagal";
                        file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                    }
                } else {
                    echo "Update SPPA Gagal";
                    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                }
            } else {
                echo "Insert Claim Gagal";
                file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insClaim))."\r\n", FILE_APPEND | LOCK_EX);
            }
            file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insClaim))."\r\n", FILE_APPEND | LOCK_EX);
    	}
    	
    	elseif($_GET['module']=='update'){
    		$sregclaim  = $_POST['regclaim'];
    		$snilaios   = str_replace('.', '', $tnilaios);
    		
    		$sqlClaim = " SELECT a.regid,
                                 b.*,
                                 c.msdesc tmpt,
                                 d.msdesc sbb
                          FROM tr_sppa a
                          LEFT JOIN tr_claim b
                               ON b.regid = a.regid
                          LEFT JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='TMPCLM') c
                               ON c.msid = b.tmpkejadian
                          LEFT JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='SBBCLM') d
                               ON d.msid = b.penyebab
                          WHERE b.regclaim = '$sregclaim'";
                          
    		$dataClaim = $db->query($sqlClaim);
    		$d = $dataClaim->fetch_assoc();
    		
    		// ====================== Komentar Edit Claim =========================
    		$comment = "Perubahan Data Claim, Sebelumnya:";
    		if ($d['tgllapor'] !== $stgllapor) {
    		    $comment .= "<br>- Tgl Lapor: ".$d['tgllapor'];
    		    $custField = ",tgllapor    = '$stgllapor' ";
    		}
    		if ($d['tmpkejadian'] !== $stmpkejadian) {
    		    $comment .= "<br>- Tempat Kejadian: ".$d['tmpt'];
    		    $custField = ",tmpkejadian = '$stmpkejadian' ";
    		}
    		if ($d['nilaios'] !== $snilaios) {
    		    $comment .= "<br>- Nilai OS: ".number_format($d['nilaios'],0,",",".");
    		    $custField = ",nilaios     = Replace('$snilaios', ',', '') ";
    		  //  echo "masuk";
    		}
    		
    		if ($d['tglkejadian'] !== $stglkejadian) {
    		    $comment .= "<br>- Tanggal Kejadian: ".$d['tglkejadian'];
    		    $custField = ",tglkejadian = '$stglkejadian'
    		                  ,expireddt = '$tglexpired' ";
    		}
    		if ($d['penyebab'] !== $spenyebab) {
    		    $comment .= "<br>- Penyebab Kematian: ".$d['sbb'];
    		    $custField = ",penyebab    = '$spenyebab' ";
    		}
    		if ($catatan) {
    		    $comment .= "<br>Catatan: ".$catatan;
    		}
    		
    		$updClaim = "UPDATE tr_claim 
                         SET    editdt      = '$sdate', 
                                editby      = '$userid',
                                doctype     = '$sdoctype' 
                                $custField
                         WHERE  regclaim = '$sregclaim' ";
                         
            $insLog = " INSERT INTO tr_sppa_log 
                                    (regid, status, createby, createdt, comment) 
                        VALUES      ('$sregid',
                                     '14',
                                     '$userid',
                                     '$sdate',
                                     '$comment')";
            
            if ($db->query($updClaim)) {
                file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                if ($db->query($insLog)) {
                    file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                    header("location:../../media.php?module=claim");
                } else {
                    echo "gagal insert log";
                    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                }
            } else {
                file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
            }
    	}
    
    
    	elseif($_GET['module']=='approve'){
    	    
    	    if ($vlevel == 'schecker') {
    	        $status  = "91";
    	        $uField1 = "";
    	        $uField2 = "";
    	        $comment = "ADMK Menyatakan Dokumen Claim Sudah Lengkap";
    	    } elseif ($vlevel == 'broker') {
    	        $status  = "92";
    	        $uField1 = ", verifby = '$userid'";
    	        $uField2 = ", verifdt = '$sdate'";
    	        $comment = "Broker Menyatakan Dokumen Claim Sudah Benar dan Sesuai Isinya";
    	    } elseif ($vlevel == 'insurance') {
    	        $status  = "93";
    	        $uField1 = ", validby = '$userid'";
    	        $uField2 = ", validdt = '$sdate'";
    	        $comment = "Asuransi Menyatakan Claim Diterima, Menunggu Kelengkapan Dokumen Tiba di Asuransi";
    	    } else {
    	        return "Gagal, anda tidak memiliki hak akses";
    	    }
    	    
    		$sregclaim = $_POST['id'];
    
    		$updClaim = "UPDATE tr_claim 
                         SET    statclaim = '$status'
                                $uField1
                                $uField2
                         WHERE  regid  = '$sregid' ";
    
    		$updSPPA = "UPDATE tr_sppa 
                        SET    status = '$status' 
                        WHERE  regid  = '$sregid' ";
    		
    		$insLog = " INSERT INTO tr_sppa_log 
                                 (regid, status, createby, createdt, comment) 
                        VALUES   ('$sregid', 
                                  '$status', 
                                  '$userid', 
                                  '$sdate', 
                                  '$comment') ";
                                  
            if ($db->query($updClaim)) {
                file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                if ($db->query($updSPPA)) {
                    file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                    if ($db->query($insLog)) {
                        file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                        echo "berhasil";
                    } else {
                        echo "Insert Log Gagal";
                        file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                    }
                } else {
                    echo "Update SPPA Gagal";
                    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                }
            } else {
                echo "Update Claim Gagal";
                file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
            }
    	}	
    	
    	elseif ($_GET['module'] == 'cekdata') {
    	    $id = $_GET['id'];
    	   // $id = encrypt_decrypt("decrypt",$_GET['id']);
    	    $query = $db->query("select * from tr_claim where regid = '$id'");
    	    $num = $query->num_rows;
    	    
    	    echo $num;
    	}
    	
    	elseif ($_GET['module'] == 'rollback') {
    	    $sregid  = $_GET['regid'];
    	   // $sregid  = encrypt_decrypt("decrypt",$_GET['regid']);
    	    $comment = $_GET['comment'];
    	    
    	    if ($vlevel == 'broker' or $vlevel == 'schecker') {
    	        $status  = "90";
    	        
    	    } elseif ($vlevel == 'insurance') {
    	        $status  = "90";
    	        
    	    } else {
    	        header("location:../../media.php?module=claim");
    	    }
    
    		$updClaim = "UPDATE tr_claim 
                         SET    statclaim = '$status'
                         WHERE  regid     = '$sregid' ";
    
    		$updSPPA = "UPDATE tr_sppa 
                        SET    status = '$status',
                               comment= '$comment'
                        WHERE  regid  = '$sregid' ";
    		
    		$insLog = "INSERT INTO tr_sppa_log 
                                   (regid, status, createby, createdt, comment) 
                       VALUES      ('$sregid', 
                                    '$status', 
                                    '$userid', 
                                    '$sdate', 
                                    '$comment') ";
                                    
            if ($db->query($updClaim)) {
                file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                if ($db->query($updSPPA)) {
                    file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                    if ($db->query($insLog)) {
                        file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                        echo "berhasil";
                    } else {
                        file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                        echo "Insert tr_sppa_log Gagal";
                    }
                } else {
                    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                    echo "Update tr_sppa Gagal";
                }
            } else {
                file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                echo "Update tr_claim Gagal";
            }
    	}
    	
    	elseif ($_GET['module'] == 'reject') {
    	    
    	    if ($vlevel == 'insurance') {
    	        $status  = "94";
    	    } else {
    	        return "Gagal, Anda tidak memiliki akses ke modul ini";
    	    }
    	    
    	    $keterangan = $_POST['keterangan'];
    	    $alasan     = $_POST['alasan'];
    	    
    	    $allowed_ext= array('doc', 'docx', 'pdf', 'jpg', 'tif', 'png');
    		$file_name	= $_FILES['fupload']['name'];
    		$file_ext	= strtolower(end(explode('.', $file_name)));
    		$file_size	= number_format($_FILES['fupload']['size']/1024,2,",",".")." KB";
    		$file_tmp	= $_FILES['fupload']['tmp_name'];
    		$sjdoc		= 'SKC';
    		$snamafile	= $sregid . $sjdoc  ;
    		$tgl		= date("Y-m-d");
    		$lokasi     = "modul/files/$snamafile.$file_ext";
    		
    		$insDoc = " INSERT INTO tr_document
                                   (regid, tglupload, nama_file, tipe_file, ukuran_file, FILE, jnsdoc, catdoc)
                        VALUES     ('$sregid',
                                    '$tgl',
                                    '$snamafile',
                                    '$file_ext',
                                    '$file_size',
                                    '$lokasi',
                                    '$sjdoc',
                                    'SKC') ";
            
            $updClaim = "UPDATE tr_claim 
                         SET    statclaim = '$status',
                                comment   = '$keterangan',
                                detail    = '$alasan'
                         WHERE  regid     = '$sregid' ";
    
            $updSPPA = "UPDATE tr_sppa 
                        SET    status    = '$status',
                               comment   = '$alasan, $keterangan'
                        WHERE  regid     = '$sregid' ";
                        
            $insLog = " INSERT INTO tr_sppa_log 
                                (regid, status, createby, createdt, comment) 
                        SELECT  '$sregid', 
                                '$status', 
                                '$userid', 
                                '$sdate', 
                                concat('Alasan: ',msdesc,', $keterangan')
                        FROM ms_master
                        WHERE mstype='REJECTTYPE' AND msid = '$alasan'";
    		
    		if(in_array($file_ext, $allowed_ext)){
    			if($file_size < 5*MB){
    				if (move_uploaded_file($file_tmp,  '../../'.$lokasi)) {
        				if ($db->query($insDoc)) {
        				    file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insDoc))."\r\n", FILE_APPEND | LOCK_EX);
                            if ($db->query($updClaim)) {
                                file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                                if ($db->query($updSPPA)) {
                                    file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                                    if ($db->query($insLog)) {
                                        file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                                        echo "berhasil";
                                    } else {
                                        file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                                        echo "Insert tr_sppa_log Gagal";
                                    }
                                } else {
                                    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                                    echo "UPDATE tr_sppa Gagal";
                                }
                            } else {
                                file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                                echo "UPDATE tr_claim Gagal";
                            }
        				} else {
        				    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insDoc))."\r\n", FILE_APPEND | LOCK_EX);
        				    echo "INSERT tr_document Gagal";
        				}
    				} else {
    				    echo "move_uploaded_file Gagal";
    				}
    			} else {
    			    echo "File Terlalu Besar";
    			}
    		} else {
    		    echo "wrong extension: ".$file_ext;
    		}
    	}
    	
    	elseif ($_GET['module'] == 'delete') {
    	    $comment = $_POST['comment'];
    	    if ($comment == "") {
    	        $comment = "Batal Claim";
    	    } else {
    	        $comment = "Batal Claim: ".$comment;
    	    }
    	    
    	    $delClm = "DELETE FROM tr_claim
    	               WHERE regid = '$sregid'";
    	    
    	    $updSPPA= "UPDATE tr_sppa SET
    	                    status = '20'
    	               WHERE regid ='$sregid' ";   //dibalikin ke paid
    	                    
    	    $insLog = " INSERT INTO tr_sppa_log 
                                (regid, status, createby, createdt, comment) 
                        VALUES  ('$sregid', 
                                 '20', 
                                 '$userid', 
                                 '$sdate', 
                                 '$comment') ";
                                 
    	    if ($db->query($delClm)) {
    	        file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $delClm))."\r\n", FILE_APPEND | LOCK_EX);
    	        if ($db->query($updSPPA)) {
    	            file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
    	            if ($db->query($insLog)){
    	                file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
    	                echo "berhasil";
    	            } else {
    	                echo "gagal insert Log";
    	            }
    	        } else {
    	            echo "gagal update SPPA";
    	        }
    	    } else {
    	        echo "gagal delete claim";
    	    }
    	}
    	
    	elseif ($_GET['module'] == 'receive') {
    	    $sdate = $_POST['tgl'];
    	   // $sregid = $_GET['regid'];
    	    if ($vlevel == 'insurance') {
    	        $status = "96";
    	        $comment = "Hardcopy Dokumen Klaim Telah Diterima oleh Asuransi";
    	    } else {
    	        return "Gagal, anda bukan Asuransi";
    	    }
    	    
    	    $cekLog = " SELECT * FROM tr_sppa_log
    	                WHERE   regid   = '$sregid'
    	                AND     status  = '96'";
    	    
    	    $insLog = " INSERT INTO tr_sppa_log 
                                (regid, status, createby, createdt, comment) 
                        SELECT  '$sregid', 
                                '$status', 
                                '$userid', 
                                '$sdate', 
                                '$comment'";
                                
            $updClaim = "UPDATE tr_claim 
                         SET    statclaim  = '$status',
                                comment    = '$comment',
                                hardcopydt = '$sdate'
                         WHERE  regid      = '$sregid' ";
                         
            $updSPPA = "UPDATE tr_sppa 
                                SET    status    = '$status',
                                       comment   = '$comment'
                                WHERE  regid     = '$sregid'";
            
            if ($db->query($cekLog)->num_rows == 0) {
                if ($db->query($insLog)) {
                    file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                    if ($db->query($updClaim)) {
                        file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                        if ($db->query($updSPPA)) {
                            file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                            echo "berhasil";
                        } else {
                            file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                            echo "Update tr_sppa Gagal";
                        }
                    } else {
                        file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                        echo "Update tr_claim Gagal";
                    }
                } else {
                    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $insLog))."\r\n", FILE_APPEND | LOCK_EX);
                    echo "Insert tr_sppa_log Gagal";
                }
            } else {
                if ($db->query($updClaim)) {
                    file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                    if ($db->query($updSPPA)) {
                        file_put_contents('SQL-Log.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                        echo "berhasil";
                    } else {
                        file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updSPPA))."\r\n", FILE_APPEND | LOCK_EX);
                        echo "Update tr_sppa Gagal";
                    }
                } else {
                    file_put_contents('SQL-error.txt', date("Y-m-d h:i:s")." ---- $sregid\r\n\t".trim(preg_replace('/\s+/S', ' ', $updClaim))."\r\n", FILE_APPEND | LOCK_EX);
                    echo "Update tr_claim Gagal";
                }
            }
    	}
    } else {
        header("location:../../media.php?module=claim");
    }

?>