<?php
include ("../../config/koneksi.php");
include ("../../config/fungsi_all.php");
$aksi="modul/mod_cekfoto/aksi_cekfoto.php";

$tablenya  = "<table class='table table-bordered'>";
$tablenya .= "<thead>";
$tablenya .= "<tr>";
$tablenya .= "<th>Cabang </th>";
$tablenya .= "<th>Produk </th>";
$tablenya .= "<th>No Register </th>";
$tablenya .= "<th>Nama</th>";
$tablenya .= "<th>UP</th>";
$tablenya .= "<th></th>";
$tablenya .= "</tr>";
$tablenya .= "</thead>";
$tablenya .= "<tbody>";

    $sqlr = "select a.regid,a.nama,a.noktp,tgllahir,up,nopeserta,up,premi,mulai,ab.msdesc cab,ac.msdesc proddesc,a.createby,a.createdt ";
    $sqlr.= "from tr_sppa a ";
    $sqlr.= "left join (select regid from tr_sppa_log where  status=13) b on a.regid = b.regid ";
    $sqlr.= "left join ms_master ab on a.cabang=ab.msid and ab.mstype='cab' ";
    $sqlr.= "left join ms_master ac on ac.msid=a.produk and ac.mstype='produk' ";
    $sqlr.= "where b.regid is null and a.status='1' ";
    $sqlr.= "order by a.createdt asc";

		$query=mysql_query($sqlr);
		$num=mysql_num_rows($query);
		$no=1;
		$i=0;
		while($r=mysql_fetch_array($query)){
			$tablenya .= '<tr>';
            $tablenya .= '<td>'.$r['cab'].'</td>';
            $tablenya .= '<td>'.$r['proddesc'].'</td>';
            $tablenya .= '<td>'.$r['regid'].'</td>';
            $tablenya .= '<td>'.$r['nama'].'</td>';
            $tablenya .= '<td>'.number_format($r['up'],0).'</td>';
            $tablenya .= '<td>';
            $tablenya .= '<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location=\'media.php?module=cekfoto&&act=update&&id='.$r['regid'].'\'"><i class="fa fa-search"></i> Edit</button>';
            $tablenya .= '<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Revisi" onclick="window.location=\'media.php?module=cekfoto&&act=revisi&&id='.$r['regid'].'\'"><i class="fa fa-search"></i> Revisi</button>';
            $tablenya .= '<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="sppa" onclick="window.location=\'laporan/sppa/f_sppa.php?id='.$r['regid'].'\'"><i class="fa fa-print"></i> SPPA</button>';
            $tablenya .= '<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location=\'media.php?module=polhist&&act=update&&id='.$r['regid'].'\'"><i class="fa fa-search"></i> Log</button>';
            $tablenya .= '<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location=\''.$aksi.'?module=approve&&id='.$r['regid'].'\'"><i class="fa fa-check-square"></i> Approve</button>';
            $tablenya .= '<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Reject" onclick="window.location=\''.$aksi.'?module=reject&&id='.$r['regid'].'\'"><i class="fa fa-trash"></i> Reject</button>';
            $tablenya .= '</td>';
            $tablenya .= '</tr>';
            if ($i==10) {
                break;
            } else {
                $i++;
            }
		}
		$tablenya .= '</tbody></table>';
		$result = array(
		    'num' => $num,
		    'table' => $tablenya);
		echo json_encode($result);
		?>
	
