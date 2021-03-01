<?php
    session_start();
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');

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
		
			
			$scanceldt=$_POST['tglbatal'];
			$scatreason=$_POST['catreason'];
			$sreason=$_POST['reason'];
			
			$sqle = "INSERT INTO tr_sppa_cancel
                                (regid, tglbatal, refund, masa, sisa, createby, createdt, statcan, catreason, reason)
                     SELECT regid,
                            '$scanceldt',
                            0,
                            masa,
                            Floor(Datediff(akhir, '$scanceldt') / 30.4),
                            '$userid',
                            '$sdate',
                            '1',
                            '$scatreason',
                            '$sreason'
                     FROM   tr_sppa
                     WHERE  regid = '$sregid'
                            AND Datediff('$scanceldt', mulai) > 30 ";
			file_put_contents('erorcan.txt', $sqle, FILE_APPEND | LOCK_EX);
			$hasill = mysql_query($sqle);

			$sqle = "INSERT INTO tr_sppa_cancel
                                (regid, tglbatal, refund, masa, sisa, createby, createdt, statcan, catreason, reason)
                     SELECT regid,
                            '$scanceldt',
                            0,
                            masa,
                            Floor(Datediff(akhir, '$scanceldt') / 30.4),
                            '$userid',
                            '$sdate',
                            '1',
                            '$scatreason',
                            '$sreason'
                     FROM   tr_sppa
                     WHERE  regid = '$sregid'
                            AND Datediff('$scanceldt', mulai) < 30 ";
			$hasill = mysql_query($sqle);
			
			$sqlu = "UPDATE tr_sppa
                     SET    status = '7'
                     WHERE  regid = '$sregid'  ";
			$hasill = mysql_query($sqlu);
			
			$sqll = "INSERT INTO tr_sppa_log
                                 (regid, status, createby, createdt)
                     VALUES      ('$sregid',
                                  '7',
                                  '$userid',
                                  '$sdate')   ";
			$query=mysql_query($sqll);


			header("location:../../media.php?module=cancel");
	}
	
	
	else if($_GET['module']=='refund'){
		
			$scanceldt=$_POST['tglbatal'];
			$scatreason=$_POST['catreason'];
			$sreason=$_POST['reason'];
			
            $sqle = "insert into tr_sppa_cancel(regid,tglbatal,refund,masa,sisa,createby,createdt,statcan,catreason,reason)";
			$sqle = $sqle . " select a.regid,'$scanceldt',0,masa,floor(DATEDIFF(akhir,'$scanceldt')/30.4), ";
			$sqle = $sqle . " '$userid','$sdate','1','$scatreason','$sreason' from tr_sppa a left join tr_sppa_paid b on a.regid=b.regid   ";
			$sqle = $sqle . " where a.regid='$sregid' and b.regid is null ";
			file_put_contents('erorcan.txt', $sqle, FILE_APPEND | LOCK_EX);
			$query=mysql_query($sqle);
			
			$sqle = "insert into tr_sppa_cancel(regid,tglbatal,refund,masa,sisa,createby,createdt,statcan,catreason,reason)";
			$sqle = $sqle . " select a.regid,'$scanceldt',(floor(DATEDIFF(akhir,'$scanceldt')/30.4)/masa)*(tpremi*50/100),";
			$sqle = $sqle . " masa,floor(DATEDIFF(akhir,'$scanceldt')/30.4), ";
			$sqle = $sqle . " '$userid','$sdate','1','$scatreason','$sreason' from tr_sppa a left join tr_sppa_paid b on a.regid=b.regid   ";
			$sqle = $sqle . " where a.regid='$sregid' and datediff('$scanceldt',b.paiddt)>30  and b.regid is not null ";
			file_put_contents('erorcan.txt', $sqle, FILE_APPEND | LOCK_EX);
			$query=mysql_query($sqle);

			$sqle = "insert into tr_sppa_cancel(regid,tglbatal,refund,masa,sisa,createby,createdt,statcan,catreason,reason)";
			$sqle = $sqle . " select a.regid,'$scanceldt',a.premi,masa,floor(DATEDIFF(akhir,'$scanceldt')/30.4), ";
			$sqle = $sqle . " '$userid','$sdate','1','$scatreason','$sreason' from tr_sppa a left join tr_sppa_paid b on a.regid=b.regid  ";
			$sqle = $sqle . " where a.regid='$sregid' and datediff('$scanceldt',b.paiddt)<30 and b.regid is not null ";
			file_put_contents('erorcan.txt', $sqle, FILE_APPEND | LOCK_EX);
			$query=mysql_query($sqle);
			
			$sqlu="UPDATE tr_sppa SET status='8'  ";
			$sqlu=$sqlu . " WHERE regid='$sregid'  ";
			$hasill = mysql_query($sqlu);
			
			$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
			$sqll=$sqll . " values ('$sregid','8','$userid','$sdate') ";
			$query=mysql_query($sqll);


			header("location:../../media.php?module=cancel");
	}
	elseif($_GET['module']=='approve'){
	    $sregid     = $_GET['regid'];
	    $querycek   = mysql_query("SELECT status from tr_sppa where regid = '$sregid'");
        $dcek       = mysql_fetch_array($querycek);
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
			
			$sqlb= "INSERT INTO tr_billing
                                (billno,
                                 billdt,
                                 duedt,
                                 policyno,
                                 reffno,
                                 grossamt,
                                 nettamt,
                                 admamt,
                                 discamt,
                                 totalamt,
                                 remark,
                                 billtype)
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
			file_put_contents('erorb.txt', $sqlb, FILE_APPEND | LOCK_EX); 
			$hasilb = mysql_query($sqlb);

			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'billpre'";
			$hasiln = mysql_query($sqln);
	    }
	    
	    $sqlu="UPDATE tr_sppa SET status='$statBaru',editby='$userid',editdt ='$sdate' ";
		$sqlu=$sqlu . " WHERE regid='$sregid' and status='$dstatus' ";
		/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
		$query=mysql_query($sqlu);
		
		$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
		$sqll=$sqll . " values ('$sregid','$statBaru','$userid','$sdate') ";
		$query=mysql_query($sqll);
		
	    
		header("location:../../media.php?module=cancel");
	}

	elseif($_GET['module']=='update'){
		
			$sregid=$_POST['regid'];
			$scanceldt=$_POST['tglbatal'];
			$scatreason=$_POST['catreason'];
			$sreason=$_POST['reason'];
			
			$sqlu="UPDATE tr_sppa_cancel SET tglbatal='$scanceldt' ,catreason='$scatreason',reason='$sreason' ";
			$sqlu=$sqlu . " WHERE regid='$sregid'  ";
			/* file_put_contents('eroru.txt', $sqlu, FILE_APPEND | LOCK_EX);    */
			$query=mysql_query($sqlu);

			
			header("location:../../media.php?module=cancel");
	}

	elseif($_GET['module']=='appbro'){
			
			header("location:../../media.php?module=cancel");
		}	
		
	elseif($_GET['module']=='appins'){
			
			header("location:../../media.php?module=cancel");
	}

	elseif($_GET['module']=='rollback') {	
			$sregid = $_POST['id'];
			$comment= $_POST['comment'];
			if ($comment == '') {
			    $comment = $comment;
			} else {
			    $comment = ", catatan: ".$comment;
			}
			
			$cekid  = mysql_query("SELECT status FROM tr_sppa WHERE regid = '$sregid'");
			$data   = mysql_fetch_array($cekid);
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
			
			$sqlu   = " UPDATE tr_sppa 
                        SET   status = '$statBaru', 
                              editby = '$userid', 
                              editdt = '$sdate'
                        WHERE  regid = '$sregid' ";
			/* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
			$query1  = mysql_query($sqlu);
			
			$sqll   = " INSERT INTO tr_sppa_log 
                                    (regid, 
                                     status, 
                                     createby, 
                                     createdt, 
                                     comment) 
                        VALUES      ('$sregid', 
                                     '$statBaru', 
                                     '$userid', 
                                     '$sdate', 
                                     'Rollback$comment') ";
			$query2  = mysql_query($sqll);			
			/* file_put_contents('eror111.txt', $sqll, FILE_APPEND | LOCK_EX); */
			
			if ($query1 and $query2) {
			    echo json_encode("berhasil");
			} else {
			    echo json_encode("gagal");
			}
	}
	
	
	elseif ($_GET['module'] == 'cekbordero') {
	    $id = $_GET['id'];
	    
	    $sql = mysql_query("SELECT * FROM tr_bordero_dtl WHERE `regid` = '$id'");
	    $num = mysql_num_rows($sql);
	    echo json_encode($num);
	}
?>