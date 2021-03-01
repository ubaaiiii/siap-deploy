<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	require("../../phpmailer/class.phpmailer.php");
	require("../../phpmailer/class.smtp.php");
	require("../../phpmailer/class.pop3.php");
	
	$sregid     = $_POST['regid'];
	$sdate      = date('Y-m-d H:i:s');
	$sjnsrev    = $_POST['jenrev'];
	$userid     = $_POST['userid'];
	$comment    = $_POST['subject'];

	if($_GET['module']=='add'){
		
			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'regrev'";
			$hasill = $db->query($sqll);
			$barisl = $hasill->fetch_array();
			$nourut = $barisl[0];

			$sqln  = "update tbl_lastno_trans set lastno=lastno+1 where trxid= 'regrev'";
			$hasiln = $db->query($sqln);
			$regrev=$nourut;
			
			$sqlRev     = $db->query("SELECT * FROM ms_master WHERE `mstype`='revisi' AND `msid`='$sjnsrev'");
			$fetchRev   = $sqlRev->fetch_array();
			$awal       = $fetchRev['editby']."-sebelumnya";
			$dataAwal   = $_POST[$fetchRev['editby']."-sebelumnya"];
			$dataAkhir  = $_POST[$fetchRev['editby']];
			
			$sqlDataRev = $db->query("SELECT * FROM ms_master WHERE `msid` = '$sjnsrev'");
			$fetchDaRev = $sqlDataRev->fetch_array();
			$dataRevisi = $fetchDaRev['msdesc'];
			
			if (!in_array($sjnsrev, array('R1','R6','R7'))) {   // Nama, No Pinjaman, No KTP
			    
			    $sqlDataAwal= $db->query("SELECT * FROM ms_master WHERE `msid` = '$dataAwal'");
    			$sqlDataAkhir= $db->query("SELECT * FROM ms_master WHERE `msid`= '$dataAkhir'");
    			$fetchAwal  = $sqlDataAwal->fetch_array();
    			$fetchAkhir = $sqlDataAkhir->fetch_array();
    			
    			$dataMasterAwal = $fetchAwal['msdesc'];
    			$dataMasterAkhir  = $fetchAkhir['msdesc'];
    			
    			$komen      = $dataRevisi."<br>Sebelumnya : ".$dataMasterAwal."<br>Diubah Menjadi : ".$dataMasterAkhir."<br>Catatan: ".$comment;
			} else {
			    $komen      = $dataRevisi."<br>Sebelumnya : ".$dataAwal."<br>Diubah Menjadi : ".$dataAkhir."<br>Catatan: ".$comment;
			}

            $insertRevisi   = $db->query("INSERT INTO tr_sppa_revisi 
                                                      (regrev, regid, tglrevisi, comment, jnsrev, createdt, createby, dataawal, dataakhir) 
                                          SELECT '$regrev', '$sregid', '$sdate', '$comment', '$sjnsrev', '$sdate', '$userid', '$dataAwal', '$dataAkhir' ");
			
			$insertLog      = $db->query("INSERT INTO tr_sppa_log
			                                           (regid, status, createdt, createby, comment) 
                    			           SELECT '$sregid', '14', '$sdate', '$userid', '$komen'");
			
			$updateData     = $db->query("UPDATE tr_sppa
    			                           SET `".$fetchRev['editby']."` = '$dataAkhir'
    			                           WHERE `regid`='$sregid'");
				
			header("location:../../media.php?module=inquirib");
	}
	
	elseif($_GET['module']=='update'){
		
			$sregid=$_POST['regid'];

			$sqlu="insert into tr_sppa_revlog ";
			$sqlu=$sqlu . " (regid,nama,noktp,jkel,pekerjaan,cabang,tgllahir,mulai,  ";
			$sqlu=$sqlu . " akhir,masa,up,status,createdt,createby,editdt,editby,validby,  ";
			$sqlu=$sqlu . " validdt,nopeserta,usia,premi,epremi,tpremi,  ";
			$sqlu=$sqlu . " bunga,tunggakan, produk,mitra,comment,asuransi,policyno,revlogdt  ) ";
			$sqlu=$sqlu . " select aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai,  ";
			$sqlu=$sqlu . " aa.akhir,aa.masa,aa.up,aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby,  ";
			$sqlu=$sqlu . " aa.validdt,aa.nopeserta,aa.usia,aa.premi,aa.epremi,aa.tpremi,  ";
			$sqlu=$sqlu . " aa.bunga,aa.tunggakan, aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno,'$sdate'   ";
			$sqlu=$sqlu . " from tr_sppa aa where aa.regid='$sregid' ";
			file_put_contents('eroru.txt', $sqlu, FILE_APPEND | LOCK_EX); 
			$query=$db->query($sqlu);
			
			header("location:../../media.php?module=revisi");
	}
	
	elseif ($_GET['module']=='data') {
	    if(!isset($_POST['searchTerm'])){
          $fetchData = $db->query("select regid, nama, status from tr_sppa where `status` != '12' order by `nama` limit 10");
        } else {
          $search = $_POST['searchTerm'];
          $fetchData = $db->query("select regid, nama, status from tr_sppa where (`nama` like '%".$search."%' or `regid` like '%".$search."%') and `status` != '12' order by `nama` limit 10");
        }
        
        $data = array();
        while ($row = mysql_fetch_array($fetchData)) {
          $data[] = array("id"=>$row['regid'], "text"=>$row['regid']." - ".$row['nama'], "dStatus"=>$row['status']);
        }
        echo json_encode($data);
	}
?>