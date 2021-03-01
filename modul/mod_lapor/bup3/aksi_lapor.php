<style>
    /*-------------------------------*/
    .lds-facebook {
      display: inline-block;
      position: absolute;
      z-index: 1;
      left: 50%;
      top: 50%;
      width: 80px;
      height: 80px;
    }
    .lds-facebook div {
      display: inline-block;
      position: absolute;
      left: 8px;
      width: 16px;
      background: #3691ED;
      animation: lds-facebook 0.5s cubic-bezier(0, 0.5, 0.5, 1) infinite;
    }
    .lds-facebook div:nth-child(1) {
      left: 8px;
      animation-delay: -0.24s;
    }
    .lds-facebook div:nth-child(2) {
      left: 32px;
      animation-delay: -0.12s;
    }
    .lds-facebook div:nth-child(3) {
      left: 56px;
      animation-delay: 0;
    }
    @keyframes lds-facebook {
      0% {
        top: 8px;
        height: 64px;
      }
      50%, 100% {
        top: 24px;
        height: 32px;
      }
    }

</style>
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>


<?php
// session_start();
include("../../config/koneksi.php");
date_default_timezone_set('Asia/Jakarta');
$providerid = $_POST['providerid'];	
$tgl1       = $_POST['tgl1'];
$tgl2       = $_POST['tgl2'];
$sfilter1   = $_POST['sfilter1'];
$sfilter2   = $_POST['sfilter2'];
$sfilter3   = $_POST['sfilter3'];
$slvl       = $_POST['level'];
$suid       = $_POST['uid'];
$scab       = $_POST['cab'];
$sreport    = $_POST['treport'];	
$stfile     = $_POST['tipe-ekstensi'];	
$exdate     = date("YmdHis");
		
// $contgl     = substr($tgl1,3,2);		
// $conbln     = substr($tgl1,0,2);		
// $conthn     = substr($tgl1,6,9);		
// $tglcon1    = $conthn."-".$conbln."-".$contgl;		
// $contgl2    = substr($tgl2,3,2);		
// $conbln2    = substr($tgl2,0,2);		
// $conthn2    = substr($tgl2,6,9);		
// $tglcon2    = $conthn2."-".$conbln2."-".$contgl2;	
$speriode   = "Periode ~ " . $tgl1 . ' s/d ' . $tgl2 ;

$sqlc       = "SELECT msdesc scab FROM ms_master where mstype='cab'  and  msid='$sfilter2' ";
$data       = $db->query($sqlc)->fetch_assoc();
$cabang     = $data['scab'];
// $scabang    = "Cabang ~ " . $data['scab'];

$sqlc       = "SELECT msdesc sprod  FROM ms_master where mstype='produk' and  msid='$sfilter1' ";
$data       = $db->query($sqlc)->fetch_assoc();
$produk     = $data['sprod'];
// $sproduk    = "Produk ~" . $data['sprod'];

$sqlc       = "SELECT  msdesc sins FROM ms_master where mstype='asuransi'  and  msid='$sfilter3'  ";
$data       = $db->query($sqlc)->fetch_assoc();
$asuransi   = $data['sins'];
// $sasuransi  = "Asuransi ~" . $data['sins'];

echo "<h3 id='judul'></h3>
      <table style='border-left: 5px solid red;'>
        <tr><td>Periode</td><td>:</td><td>$tgl1 s/d $tgl2</td></tr>
        <tr><td>Asuransi</td><td>:</td><td>$asuransi</td></tr>
        <tr><td>Produk</td><td>:</td><td>$produk</td></tr>
        <tr><td>Cabang</td><td>:</td><td>$cabang</td></tr>
      </table>";


if($_GET['module'] == 'print') {		
	if ($sreport == 'siap1') {		
		$file_name  = "lappending" . $exdate;				
		$stitle     = "Laporan Data Pending";		
		$sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No Register',
                       a.nopeserta                               'No Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama AO',
                       i.username                                'Username AO',
                       a.createdt                                'Tgl Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '0', '1' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
                  
		if ($sfilter1!='ALL') 
		{
			$sql .= " AND a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " AND a.cabang = '$sfilter2'";
		} 
		if ($sfilter3!='ALL') 
		{
			$sql .= " AND a.asuransi =  '$sfilter3'";
		} 		
		
		}				
	if ($sreport == 'siap2') {		
		$stitle = "Laporan Data Cek Foto";			
		$file_name = "lapcekfoto" . $exdate;				
		$sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No Register',
                       a.nopeserta                               'No Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama AO',
                       i.username                                'Username AO',
                       a.createdt                                'Tgl Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '11' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang = '$sfilter2'";
		} 
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
		}				
	if ($sreport == 'siap3') {		
		$stitle = "Laporan Data Active";		
		$file_name = "lapactive" . $exdate;				
		$sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No Register',
                       a.nopeserta                               'No Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama AO',
                       i.username                                'Username AO',
                       a.createdt                                'Tgl Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '2' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang =  '$sfilter2'";
		} 
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
		}				
	if ($sreport == 'siap4') {		
		$stitle = "Laporan Data Realisasi ";		
		$file_name = "lapreal" . $exdate;				
		$sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No Register',
                       a.nopeserta                               'No Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama AO',
                       i.username                                'Username AO',
                       a.createdt                                'Tgl Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '3' )
                       AND LEFT(a.mulai, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang =  '$sfilter2'";
		} 		
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
	}		
	if ($sreport == 'siap5') {		
		$stitle = "Laporan Data Verifikasi ";		
		$file_name = "lapverif" . $exdate;				
		$sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No Register',
                       a.nopeserta                               'No Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       a.up,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama AO',
                       i.username                                'Username AO',
                       a.createdt                                'Tgl Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '4' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang = '$sfilter2'";
		} 		
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
	
	}		
	if ($sreport == 'siap6' or $sreport == 'siapck6'  or $sreport == 'siapin6'   ) {		
		$stitle = "Laporan Data Validasi ";		
		$file_name = "lapvalid" . $exdate;				
		$sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No Register',
                       a.nopeserta                               'No Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl Lahir',
                       mulai                                     Mulai,
                       a.akhir                                   Akhir,
                       a.masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama AO',
                       i.username                                'Username AO',
                       a.createdt                                'Tgl Input',
                       Concat('`', a.policyno)                   'No Sertifikat',
                       a.validdt                                 'Tgl Validasi'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '5' )
                       AND LEFT(a.validdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang =  '$sfilter2'";
		} 		
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
		
	}		
	
	if ($sreport == 'siap7' or $sreport == 'siapck7' or $sreport == 'siapmk7') {		
		$file_name = "lapbatal" . $exdate;				
		$stitle = "Laporan Data Pembatalan";		
		$sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No Register',
                       a.nopeserta                               'No Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No KTP',
                       jkel                                      Jkel,
                       If(i.msdesc IS NULL, pekerjaan, i.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl Lahir',
                       mulai                                     Mulai,
                       a.akhir                                   Akhir,
                       a.masa                                    Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       j.nama                                    'Nama AO',
                       j.username                                'Username AO',
                       d.paiddt                                  'Tgl Bayar',
                       a.createdt                                'Tgl Input',
                       a.validdt                                 'Tgl Validasi',
                       Concat('`', a.policyno)                   'No Sertifikat',
                       h.tglbatal                                'Tgl Batal'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN tr_sppa_paid d
                              ON d.regid = a.regid
                                 AND d.paidtype = 'PREMI'
                       LEFT JOIN tr_sppa_cancel h
                              ON a.regid = h.regid
                       LEFT JOIN ms_master i
                              ON a.pekerjaan = i.msid
                                 AND i.mstype = 'KERJA'
                       LEFT JOIN ms_admin j
                              ON a.createby = j.username
                WHERE  a.status IN ( '7', '71', '72', '73' )
                       AND LEFT(h.tglbatal, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk='$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang='$sfilter2'";
		} 		
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
	}		
	
	if ($sreport == 'siap8' or $sreport == 'siapck8' ) {		
		$file_name = "laprefund" . $exdate;			
		$stitle = "Laporan Data Refund";		
		$sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No Register',
                       a.nopeserta                               'No Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No KTP',
                       jkel                                      Jkel,
                       If(i.msdesc IS NULL, pekerjaan, i.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl Lahir',
                       mulai                                     Mulai,
                       a.akhir                                   Akhir,
                       a.masa                                    Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  'Status',
                       j.nama                                    'Nama AO',
                       j.username                                'Username AO',
                       a.createdt                                'Tgl Input',
                       a.validdt                                 'Tgl Validasi',
                       Concat('`', a.policyno)                   'No Sertifikat',
                       e.paiddt                                  'Tgl Bayar Premi',
                       e.paidamt                                 'Jml Bayar Premi',
                       h.tglbatal                                'Tgl Batal',
                       h.sisa                                    'Sisa',
                       d.paiddt                                  'Tgl Refund Dibayar',
                       h.refund                                  'Jml Refund Dibayar'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN tr_sppa_paid d
                              ON d.regid = a.regid
                                 AND d.paidtype = 'REFUND'
                       LEFT JOIN tr_sppa_paid e
                              ON e.regid = a.regid
                                 AND e.paidtype = 'premi'
                       LEFT JOIN tr_sppa_cancel h
                              ON a.regid = h.regid
                       LEFT JOIN ms_master i
                              ON a.pekerjaan = i.msid
                                 AND i.mstype = 'KERJA'
                       LEFT JOIN ms_admin j
                              ON a.createby = j.username
                WHERE  a.status IN ( '8', '81', '82', '83', '84', '85' )
                       AND LEFT(h.tglbatal, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk='$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang='$sfilter2'";
		} 		
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
	}		
	
	if ($sreport == 'siap9' or $sreport == 'siapck9'  or $sreport == 'siapin9' ) {		
		$file_name = "lapclaim" . $exdate;			
		$stitle = "Laporan Data Claim";		
		$sql = "SELECT f.msdesc                Produk,
                       Concat('`', a.regid)    'No Register',
                       Concat('`', a.policyno) 'No Sertifikat',
                       a.nopeserta             'No Pinjaman',
                       a.nama                  Nama,
                       a.jkel                  JenisKelamin,
                       o.msdesc                Pekerjaan,
                       b.msdesc                Cabang,
                       tgllahir                'Tgl Lahir',
                       mulai                   TglMulai,
                       Concat('`', a.noktp)    'No KTP',
                       akhir                   Tglakhir,
                       masa                    'Masa(bulan)',
                       a.tunggakan             Graceperiod,
                       a.up                    Plafond,
                       tpremi                  Premi,
                       g.msdesc                Asuransi,
                       c.msdesc                'Status',
                       p.nama                  'Nama AO',
                       p.username              'Username AO',
                       a.createdt              'Tgl Input',
                       e.paiddt                'Tgl Bayar Premi',
                       e.paidamt               'Jml Bayar Premi',
                       Concat('`', h.regclaim) 'No Claim',
                       h.tglkejadian           'Tgl Kejadian',
                       h.tgllapor              'Tgl Lapor Claim',
                       h.nilaios               'Nilai OS',
                       DATE_ADD(h.tglkejadian,INTERVAL (wkc.msdesc + wkc.createby) DAY) 'Tgl Jatuh Tempo',
                       a.validdt               'Tgl Validasi',
                       h.validdt               'Tgl Valid Claim',
                       k.createdt              'Tgl Reject Claim',
                       n.msdesc                'Alasan Reject',
                       h.comment               Keterangan,
                       j.createdt              'Tgl Terima Dokumen',
                       d.paiddt                'Tgl Bayar Claim',
                       d.paidamt               'Jml Bayar Claim',
                       IF (dok.hasil IS NULL,
                            'Lengkap',
                            'Belum Lengkap')   'Status Dokumen',
                       kurang.kelengkapan	     Kekurangan
                FROM   tr_sppa a
                       INNER JOIN ms_master b
                               ON a.cabang = b.msid AND b.mstype = 'cab'
                       INNER JOIN ms_master c
                               ON a.status = c.msid AND c.mstype = 'streq'
                       LEFT JOIN tr_sppa_paid d
                              ON d.regid = a.regid AND d.paidtype = 'CLAIM'
                       LEFT JOIN tr_sppa_paid e
                              ON e.regid = a.regid AND e.paidtype = 'PREMI'
                       INNER JOIN ms_master f
                               ON a.produk = f.msid AND f.mstype = 'produk'
                       INNER JOIN ms_master g
                               ON a.asuransi = g.msid AND g.mstype = 'asuransi'
                       INNER JOIN tr_claim h
                               ON a.regid = h.regid
                       LEFT JOIN ms_master i
                              ON i.msid = Concat(a.asuransi, a.produk) AND i.mstype = 'wktclm'
                       LEFT JOIN tr_sppa_log j
                              ON j.regid = a.regid AND j.status = '96'
                       LEFT JOIN tr_sppa_log k
                              ON k.regid = a.regid AND k.status = '94'
                       LEFT JOIN  (SELECT mstype,COUNT(msid) 'jmldokumen' FROM ms_master GROUP BY mstype) l
                              ON l.mstype = h.doctype
                       LEFT JOIN  (SELECT regid,COUNT(regid) 'uploaded' FROM tr_document WHERE catdoc='clm' GROUP BY regid) m
                              ON m.regid = a.regid 
                       LEFT JOIN  (SELECT msid, msdesc FROM ms_master WHERE mstype = 'REJECTTYPE') n
                              ON n.msid  = h.detail
                       INNER JOIN  (SELECT msid, msdesc FROM ms_master WHERE mstype = 'KERJA') o
                              ON o.msid  = a.pekerjaan
                       LEFT JOIN ms_admin p
                              ON a.createby = p.username
                       LEFT JOIN  (SELECT msid, msdesc, createby FROM ms_master WHERE mstype='WKTCLM') wkc
                              ON wkc.msid = concat(a.asuransi,a.produk)
                       LEFT JOIN  (SELECT a.regid,
                                          GROUP_CONCAT(DISTINCT IF (b.editby = 'wajib' AND c.jnsdoc IS NULL,
                                          'Dokumen Belum Lengkap',
                                          null) SEPARATOR ', ')hasil
                                   FROM   tr_claim a
                                          INNER JOIN ms_master b
                                                  ON b.mstype = a.doctype
                                                     AND b.editby = 'wajib'
                                          LEFT JOIN tr_document c
                                                  ON c.regid = a.regid
                                                     AND c.jnsdoc = b.msid
                                   WHERE  b.createby IS NULL
                                          AND c.jnsdoc IS NULL
                                   GROUP BY regid) dok
                              ON dok.regid = a.regid
                        LEFT JOIN (SELECT a.regid,GROUP_CONCAT(trim(msdesc) SEPARATOR ', ') kelengkapan
                                   FROM tr_claim a
                                   INNER JOIN ms_master b 
                                        	ON a.doctype = b.mstype  
                                   LEFT JOIN tr_document c
                                        	ON c.regid = a.regid
                                           	AND c.jnsdoc = b.msid
                                   WHERE b.editby = 'wajib' and c.jnsdoc is null
                                   GROUP BY a.regid) kurang
                              ON kurang.regid = a.regid
                        WHERE  a.status IN ( '90', '91', '92', '93', '94', '95', '96' )
                              AND LEFT(h.tgllapor, 10) BETWEEN '$tgl1' AND '$tgl2'  ";
                    
		if ($sfilter1 != 'ALL') 
		{
			$sql .= " AND  a.produk='$sfilter1' ";
		}
		if ($sfilter2 != 'ALL') 
		{
			$sql .= " AND  a.cabang='$sfilter2'";
		} 	
		if ($sfilter3 != 'ALL') 
		{
			$sql .= " AND  a.asuransi =  '$sfilter3'";
		} 				
	}		
	
if ($sreport == 'siap10' or $sreport == 'siapck10') {		
		$file_name = "lapbayar" . $exdate;			
		$stitle = "Laporan Data Produksi Dibayar";		
		$sql = "SELECT f.msdesc                Produk,
                       Concat('`', a.regid)    'No Register',
                       a.nopeserta             'No Pinjaman',
                       a.nama                  Nama,
                       Concat('`', a.noktp)    'No KTP',
                       jkel                    Jkel,
                       pekerjaan               Pekerjaan,
                       b.msdesc                Cabang,
                       tgllahir                'Tgl Lahir',
                       mulai                   Mulai,
                       akhir                   Akhir,
                       masa                    Masa,
                       a.tunggakan             Graceperiod,
                       up                      UP,
                       tpremi                  Premi,
                       g.msdesc                Asuransi,
                       c.msdesc                Status,
                       d.paiddt                'Tgl Bayar',
                       d.paidamt               'Jml Bayar',
                       a.createdt              'Tgl Input',
                       Concat('`', a.policyno) 'No Sertifikat',
                       h.msdesc                Mitra
                FROM   tr_sppa a
                       INNER JOIN ms_master b
                               ON a.cabang = b.msid
                                  AND b.mstype = 'cab'
                       INNER JOIN ms_master c
                               ON a.status = c.msid
                                  AND c.mstype = 'streq'
                       INNER JOIN tr_sppa_paid d
                               ON d.regid = a.regid
                                  AND d.paidtype = 'PREMI'
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       INNER JOIN ms_master g
                               ON a.asuransi = g.msid
                                  AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.mitra = h.msid
                                 AND h.mstype = 'mitra'
                WHERE  a.status = '20'
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang = '$sfilter2'";
		} 
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 				
	}		

	if ($sreport == 'siap11' or $sreport == 'siapck11' or $sreport == 'siapin11' ) {		
		$stitle = "Laporan Data Outstanding ";		
		$file_name = "lapdataos" . $exdate;			
		$sql = " SELECT f.msdesc             Produk,
                       Concat('`', a.regid) 'No Register',
                       a.nopeserta          'No Pinjaman',
                       a.nama               Nama,
                       Concat('`', a.noktp) 'No KTP',
                       jkel                 Jkel,
                       d.msdesc             Pekerjaan,
                       b.msdesc             Cabang,
                       tgllahir             'Tgl Lahir',
                       mulai                Mulai,
                       akhir                Akhir,
                       masa                 Masa,
                       a.tunggakan          Graceperiod,
                       up                   UP,
                       tpremi               Premi,
                       g.msdesc             Asuransi,
                       c.msdesc             Status,
                       e.nama               'Nama AO',
                       e.username           'Username AO',
                       a.createdt           'Tgl Input',
                       a.policyno           'No Sertifikat'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master d
                              ON a.pekerjaan = d.msid
                                 AND d.mstype = 'KERJA'
                       LEFT JOIN ms_admin e
                              ON a.createby = e.username
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                WHERE  a.status IN ( 2, 3, 4, 5 )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang = '$sfilter2'";
		} 
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 				
	}	


if ($sreport == 'siap12' or $sreport == 'siapck12' or $sreport == 'siapin12'  or $sreport == 'siapmk12' ) {		
		$file_name = "lapbayar" . $exdate;				
		$stitle = "Laporan Data Pembayaran";		
		$sql = "SELECT f.msdesc                Produk,
                       Concat('`', a.regid)    'No Register',
                       a.nopeserta             'No Pinjaman',
                       a.nama                  Nama,
                       Concat('`', a.noktp)    'No KTP',
                       jkel                    Jkel,
                       i.msdesc                Pekerjaan,
                       b.msdesc                Cabang,
                       tgllahir                'Tgl Lahir',
                       mulai                   Mulai,
                       akhir                   Akhir,
                       masa                    Masa,
                       a.tunggakan             Graceperiod,
                       up                      UP,
                       tpremi                  Premi,
                       g.msdesc                Asuransi,
                       c.msdesc                Status,
                       e.nama                  'Nama AO',
                       e.username              'Username AO',
                       d.paiddt                'Tgl Bayar',
                       d.paidamt               'Jml Bayar Premi',
                       a.createdt              'Tgl Input',
                       Concat('`', a.policyno) 'No Sertifikat',
                       h.msdesc                mitra
                FROM   tr_sppa a
                       INNER JOIN ms_master b
                               ON a.cabang = b.msid
                                  AND b.mstype = 'cab'
                       INNER JOIN ms_master c
                               ON a.status = c.msid
                                  AND c.mstype = 'streq'
                       INNER JOIN (select * from tr_sppa_paid WHERE  LEFT(paiddt, 10) BETWEEN '$tgl1' AND '$tgl2') d
                               ON d.regid = a.regid
                                  AND d.paidtype = 'PREMI'
                       LEFT JOIN ms_admin e
                              ON a.createby = e.username
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       INNER JOIN ms_master g
                               ON a.asuransi = g.msid
                                  AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.mitra = h.msid
                                 AND h.mstype = 'mitra'
                       LEFT JOIN ms_master i
                              ON a.pekerjaan = i.msid
                                 AND i.mstype = 'KERJA'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang = '$sfilter2'";
		} 	
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 				
	}			
	
	if ($sreport == 'siap13' or $sreport == 'siapck13') {		
		$file_name = "lapallstatus" . $exdate;			
		$stitle = "Laporan Data produksi All Status";		
		$sql = "SELECT f.msdesc                Produk,
                       Concat('`', a.regid)    'No Register',
                       a.nopeserta             'No Pinjaman',
                       a.nama                  Nama,
                       Concat('`', a.noktp)    'No KTP',
                       jkel                    Jkel,
                       h.msdesc                Pekerjaan,
                       b.msdesc                Cabang,
                       tgllahir                'Tgl Lahir',
                       mulai                   Mulai,
                       akhir                   Akhir,
                       masa                    Masa,
                       a.tunggakan             Graceperiod,
                       up                      UP,
                       tpremi                  Premi,
                       g.msdesc                Asuransi,
                       c.msdesc                Status,
                       e.nama                  'Nama AO',
                       e.username              'Username AO',
                       d.paiddt                'Tgl Bayar Premi',
                       d.paidamt               'Jml Bayar Premi',
                       a.createdt              'Tgl Input',
                       Concat('`', a.policyno) 'No Sertifikat'
                FROM   tr_sppa a
                       INNER JOIN ms_master b
                               ON a.cabang = b.msid
                                  AND b.mstype = 'cab'
                       INNER JOIN ms_master c
                               ON a.status = c.msid
                                  AND c.mstype = 'streq'
                       LEFT JOIN tr_sppa_paid d
                              ON d.regid = a.regid
                                 AND d.paidtype = 'PREMI'
                       LEFT JOIN ms_admin e
                              ON a.createby = e.username
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                WHERE  LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang = '$sfilter2'";
		} 		
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
	}		

	if ($sreport == 'siap14' or  $sreport == 'siapck14' or  $sreport == 'siapin14') {		
		$file_name = "lapreject" . $exdate;		
		$stitle = "Laporan Data Reject";		
		$sql = "SELECT f.msdesc             Produk,
                       Concat('`', a.regid) 'No Register',
                       a.nama               Nama,
                       Concat('`', a.noktp) 'No KTP',
                       jkel                 Jkel,
                       d.msdesc             Pekerjaan,
                       b.msdesc             Cabang,
                       tgllahir             'Tgl Lahir',
                       mulai                Mulai,
                       akhir                Akhir,
                       masa                 Masa,
                       a.tunggakan          Graceperiod,
                       up                   UP,
                       tpremi               Premi,
                       g.msdesc             Asuransi,
                       c.msdesc             Status,
                       e.nama               'Nama AO',
                       e.username           'Username AO',
                       a.createdt           'Tgl Input',
                       a.nopeserta          'No Pinjaman',
                       Replace(Replace(Replace(Concat(h.comment, ' ', a.comment), '\n', ''),
                               '\t', ''),
                       '\r', '')            Ket
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master d
                              ON a.pekerjaan = d.msid
                                 AND d.mstype = 'KERJA'
                       LEFT JOIN ms_admin e
                              ON a.createby = e.username
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN tr_sppa_log h
                              ON a.regid = h.regid
                                 AND h.status = '12'
                WHERE  a.status IN ( '12' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang = '$sfilter2'";
		} 
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
		
		}
	
	if ($sreport == 'siap15' or $sreport == 'siapck15'     ) {		
		$stitle = "Laporan Data Peuntupan ";		
		$file_name = "laptutup" . $exdate;				
		$sql = "SELECT f.msdesc                Produk,
                       Concat('`', a.regid)    'No Register',
                       a.nopeserta             'No Pinjaman',
                       a.nama                  Nama,
                       Concat('`', a.noktp)    'No KTP',
                       jkel                    Jkel,
                       h.msdesc                Pekerjaan,
                       b.msdesc                Cabang,
                       tgllahir                'Tgl Lahir',
                       mulai                   Mulai,
                       a.akhir                 Akhir,
                       a.masa                  Masa,
                       a.tunggakan             Graceperiod,
                       up                      UP,
                       tpremi                  Premi,
                       g.msdesc                Asuransi,
                       c.msdesc                Status,
                       e.nama                  'Nama AO',
                       e.username              'Username AO',
                       a.createdt              'Tgl Input',
                       Concat('`', a.policyno) 'No Sertifikat',
                       a.validdt               'Tgl Validasi',
                       d.paiddt                'Tgl Bayar',
                       d.paidamt               Jmlbayar
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN tr_sppa_paid d
                              ON d.regid = a.regid
                                 AND d.paidtype = 'premi'
                       LEFT JOIN ms_admin e
                              ON a.createby = e.username
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                WHERE  a.status IN ( '5', '20' )
                       AND LEFT(a.validdt, 10) BETWEEN '$tgl1' AND '$tgl2'";

		if ($sfilter1!='ALL') 
		{
			$sql .= " and  a.produk = '$sfilter1' ";
		}
		if ($sfilter2!='ALL') 
		{
			$sql .= " and  a.cabang =  '$sfilter2'";
		} 		
		if ($sfilter3!='ALL') 
		{
			$sql .= " and  a.asuransi =  '$sfilter3'";
		} 		
		
	}		
	
	if ( $slvl == "smkt"  )
	{
			$sql .= " and a.createby in ";
			$sql .= " (select  case when a.parent=a.username ";
			$sql .= " then a.parent else a.username end from ms_admin a ";
			$sql .= " where (a.username='$suid' or a.parent='$suid')) ";
											
	}
	
	if ( $slvl == "mkt"  )
	{
			$sql .= " and a.createby in ";
			$sql .= " (select  case when a.parent=a.username ";
			$sql .= " then a.parent else a.username end from ms_admin a ";
			$sql .= " where (a.username='$suid' or a.parent='$suid')) ";
											
	}
	
	$mitra = ($_SESSION['idMitra'] == NULL)?('NOM'):($_SESSION['idMitra']);
	
	if ($mitra !== 'NOM') {
	    $sql .= " AND mitra = '$mitra' ";
	}
	
	file_put_contents('erorsst.txt', $sql, FILE_APPEND | LOCK_EX);
	
	// -----------------------------------------------------------------------------------
	
    // 
		
	// -----------------------------------------------------------------------------------
// 	echo $sql;die;
	echo "<br><div id='loader' class='lds-facebook'><div></div><div></div><div></div></div>";
	$export = $db->query($sql) ;
	echo "<table class='display' id='table-export'>
	        <thead>
	          <tr style='white-space: nowrap;'>";
	while ($field = $export -> fetch_field()) {
	    echo "<th>".$field->name."</th>";
    }
    echo "    </tr>
            </thead>
            <tbody>";
    while ($row = $export->fetch_row()) {
        echo "<tr style='white-space: nowrap;'>";
        foreach( $row as $value ) {
            // echo "<td>".$value."</td>";
            if ( ( !isset( $value ) ) || ( $value == "" ) ){
    			echo "<td></td>";
    		} else {
    			$value = str_replace( '\r' , '' , $value );
    			$value = str_replace( '\t' , '' , $value );
    			$value = str_replace( '\n' , '' , $value );
    			$value = str_replace( '\s' , '' , $value );
    			$value = str_replace( '"' , '' , $value );
    			$value = str_replace( '`' , '' , $value );
    			echo "<td>".$value."</td>";
    		}
        }
        echo "</tr>";
    }
    echo "  </tbody>
          </table>";
    echo "<script>$('#loader').remove();</script>";
	
} else {
    echo "modul salah";
}
?>
<script>
    $(document).ready(function(){
        document.title = '<?=$stitle;?>';
        $('#judul').html('<?=$stitle;?>');
        $('#table-export').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5'
            ]
        });
    })
</script>