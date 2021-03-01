<?php
	include("../../config/koneksi.php");
	include("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	$id=$_POST['id'];
	
	$scode=$_POST['code'];
	$sdesk=$_POST['desk'];
	$stype='CAB';
	$userid=$_POST['userid'];
	$sdate = date('Y-m-d H:i:s');
	if($_GET['module']=='add'){
		$sql="INSERT INTO ms_master (msid,msdesc,mstype,createby,createdt) VALUES ('$scode','$sdesk','$stype','$userid','$sdate')";
		/* file_put_contents('eror.txt', $sql, FILE_APPEND | LOCK_EX); */
		
		$query=mysql_query($sql);
		header("location:../../media.php?module=mscab");
	}
	
	elseif($_GET['module']=='update'){
		$query=mysql_query("UPDATE ms_master SET desck='$sdesk',editby='$userid',editdt='$sdate' WHERE msid='$id' and mstype='$stype' ");
		header("location:../../media.php?module=mscab");
	}
	elseif($_GET['module']=='delete'){
		$id=$_GET['id'];
		$query=mysql_query("DELETE FROM ms_master WHERE msid='$id'");
		header("location:../../media.php?module=mscab");
	}
	elseif($_GET['module']=='ganti-log') {	
	    $jenis  = $_GET['jenis'];
	    $id     = $_GET['id'];
	    if ($jenis == 'LTALL') {
	        $status = "LIKE '%%'";
	    }
	    elseif ($jenis == 'LTCLM') {
	        $status = "IN ( '90','91','92','93','94','95','96',14 )";
	    }
	    elseif ($jenis == 'LTRFN') {
	        $status = "IN ( '8','81','82','83','84','85',14 )";
	    }
	    elseif ($jenis == 'LTBTL') {
	        $status = "IN ( '7','71','72','73',14 )";
	    }
	    elseif ($jenis == 'LTPGJ') {
	        $status = "NOT IN ( '7','71','72','73',
                                '8','81','82','83','84','85',
                                '90','91','92','93','94','95','96',
                                '14' )";
	    }
		$sqll=" SELECT     a.regid,
                           a.status,
                           a.comment,
                           a.createdt,
                           a.createby,
                           b.msdesc statpol
                FROM       tr_sppa_log a
                INNER JOIN ms_master b
                ON         a.status=b.msid
                AND        b.mstype='STREQ'
                WHERE      a.regid='$id'
                AND        status $status
                ORDER BY   a.createdt DESC ";
		/* echo $sqll; */
		$query=mysql_query($sqll);
		$num=mysql_num_rows($query);
		while($r=mysql_fetch_array($query)){
            $data .= "<tr>
                        <td>{$r['status']}</td>
                        <td>{$r['statpol']}</td>
                        <td>{$r['createby']}</td>
                        <td>{$r['createdt']}</td>
                        <td>{$r['comment']}</td>
                      </tr>";
		}
	}
    
    echo $data;
?>