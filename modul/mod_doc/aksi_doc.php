<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi.php");
	date_default_timezone_set('Asia/Jakarta');
	define('MB', 1048576);

	$regid = $_POST['regid'];
	$snama = $_POST['snama'];
	$sjdoc = $_POST['jdoc'];
	$catdoc= $_POST['catdoc'];
	
	$userid=$_SESSION['idLog'];
	$sdate = date('Y/m/d H:m:s');
	
	if($_GET['module']=='delete'){
		$id     = $_POST['sedit'];
		$sqlDoc = "DELETE FROM tr_document WHERE concat(regid,seqno)='$id'";
		if ($db->query($sqlDoc)) {
		    echo "berhasil";
		} else {
		    echo "gagal";
		}
	}
	
	elseif($_GET['module']=='upload'){
		$allowed_ext	= array('doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png');
		$file_name		= $_FILES['fupload']['name'];
		$file_ext		= strtolower(end(explode('.', $file_name)));
		$file_size		= number_format($_FILES['fupload']['size']/1024,2,",",".")." KB";
		$file_tmp		= $_FILES['fupload']['tmp_name'];
		$regid			= $_POST['regid'];
		$snamafile		= $_POST['regid'] . $_POST['jdoc'];
		$tgl			= date("Y-m-d");

		if(in_array($file_ext, $allowed_ext) === true){
			if($file_size < 5*MB){
				$lokasi = 'modul/files/'.$snamafile.'.'.$file_ext;
				if (move_uploaded_file($file_tmp, '../../'.$lokasi)) {
				    $sqlq=" INSERT INTO tr_document
                                        (regid,tglupload,nama_file,tipe_file,ukuran_file,FILE,jnsdoc,catdoc)
                            VALUES     ('$regid',
                                        '$tgl',
                                        '$snamafile',
                                        '$file_ext',
                                        '$file_size',
                                        '$lokasi',
                                        '$sjdoc',
                                        '$catdoc')  ";
    				$query = $db->query($sqlq);
    				if ($query) {
    				    if ($catdoc == 'clm') {
    				        $cekDoc = $db->query(" SELECT b.jmldokumen,
                                                           c.uploaded
                                                    FROM   tr_claim a
                                                           LEFT JOIN (SELECT mstype,
                                                                             Count(msid) 'jmldokumen'
                                                                      FROM   ms_master
                                                                      GROUP  BY mstype) b
                                                                  ON b.mstype = a.doctype
                                                           LEFT JOIN (SELECT regid,
                                                                             Count(regid) 'uploaded'
                                                                      FROM   tr_document
                                                                      WHERE  catdoc = 'clm'
                                                                      GROUP  BY regid) c
                                                                  ON c.regid = a.regid
                                                    WHERE  a.regid = '$regid' ");
                            $d  = $cekDoc->fetch_array();
                            if ($d['uploaded'] >= $d['jmldokumen']) {
                                $updClm = "UPDATE tr_claim SET
                                                softcopydt = '$sdate'
                                           WHERE regid ='$regid'
                                                AND `softcopydt` = 0";       //cegah update, saat dokumen diupload ulang
                                if ($db->query($updClm)) { 
                                    echo "berhasil";
                                } else {
                                    echo "gagal";
                                }
                            } else {
                                echo "berhasil";
                            }
    				    } else {
        				    echo "berhasil";
    				    }
    				} else {
    				    echo "gagal";
    				}
				} else {
				    echo "gagal move";
				}
			}
		} else {
		    echo "wrong";
		}
	}
?>
