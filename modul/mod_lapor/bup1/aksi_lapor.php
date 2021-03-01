<?php
session_start();
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
		
$contgl     = substr($tgl1,3,2);		
$conbln     = substr($tgl1,0,2);		
$conthn     = substr($tgl1,6,9);		
$tglcon1    = $conthn."-".$conbln."-".$contgl;		
$contgl2    = substr($tgl2,3,2);		
$conbln2    = substr($tgl2,0,2);		
$conthn2    = substr($tgl2,6,9);		
$tglcon2    = $conthn2."-".$conbln2."-".$contgl2;	
$speriode   = "Periode ~ " . $tgl1 . ' s/d ' . $tgl2 ;


$sqlc       = "SELECT msdesc scab FROM ms_master where mstype='cab'  and  msid='$sfilter2' ";
$data       = $db->query($sqlc)->fetch_assoc();
$scabang    = "Cabang ~ " . $data['scab'];

$sqlc       = "SELECT msdesc sprod  FROM ms_master where mstype='produk' and  msid='$sfilter1' ";
$data       = $db->query($sqlc)->fetch_assoc();
$sproduk    = "Produk ~" . $data['sprod'];

$sqlc       = "SELECT  msdesc sins FROM ms_master where mstype='asuransi'  and  msid='$sfilter3'  ";
$data       = $db->query($sqlc)->fetch_assoc();
$sasuransi  = "Asuransi ~" . $data['sins']; ;


if($_GET['module'] == 'print') {		
	if ($sreport == 'siap1') {		
		$file_name  = "lappending" . $exdate;				
		$stitle     = "Laporan Data Pending";		
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " akhir,masa,a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,a.createdt tglinput from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " left join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " where a.status in ('0','1') and left(a.createdt,10) between '$tglcon1'	and '$tglcon2' ";
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
	if ($sreport == 'siap2') {		
		$stitle = "Laporan Data Cek Foto";			
		$file_name = "lapcekfoto" . $exdate;				
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " akhir,masa, a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,a.createdt tglinput from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " left join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " where a.status in ('11') and left(a.createdt,10) between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " akhir,masa,a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,a.createdt tglinput from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " left join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " where a.status in ('2') and left(a.createdt,10) between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " akhir,masa,a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,a.createdt tglinput from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " inner join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " where a.status in ('3') and left(a.mulai,10) between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " akhir,masa,a.tunggakan graceperiod,a.up,tpremi premi,g.msdesc Asuransi,c.msdesc status,a.createdt tglinput from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " left join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " where a.status in ('4')and  left(a.createdt,10)  between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,a.akhir,a.masa,a.tunggakan graceperiod,up, ";		
		$sql .= " tpremi premi,g.msdesc Asuransi,c.msdesc status,a.createdt tglinput,concat('`',a.policyno) nosertifikat,a.validdt tglvalidasi ";
		$sql .= " from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " where a.status in ('5') and left(a.validdt,10) between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " a.akhir,a.masa,a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,d.paiddt tglbayar, ";
		$sql .= " a.createdt tglinput,a.validdt tglvalidasi,concat('`',a.policyno) nosertifikat,h.tglbatal from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " inner join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " left join tr_sppa_paid d on d.regid=a.regid  and d.paidtype='PREMI' ";
		$sql .= " left join tr_sppa_cancel h on a.regid=h.regid    ";
		$sql .= " where a.status in  ('7','71','72','73')  and  left(h.tglbatal,10)  between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "SELECT f.msdesc               Produk,
                      Concat('`', a.regid)    Noregister,
                      a.nopeserta             Nopinjaman,
                      a.nama,
                      Concat('`', a.noktp)    noktp,
                      jkel,
                      pekerjaan,
                      b.msdesc                cabang,
                      tgllahir,
                      mulai,
                      a.akhir,
                      a.masa,
                      a.tunggakan             graceperiod,
                      up,
                      tpremi                  premi,
                      g.msdesc                Asuransi,
                      c.msdesc                'status',
                      a.createdt              tglinput,
                      a.validdt               tglvalidasi,
                      Concat('`', a.policyno) nosertifikat,
                      e.paiddt                tglbayarpremi,
                      e.paidamt               JmlbayarPremi,
                      h.tglbatal,
                      h.sisa,
                      d.paiddt                tglrefundbayar,
                      h.refund                refundbayar
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
                WHERE  a.status IN ( '8', '81', '82', '83',
                                    '84', '85' )
                      AND LEFT(h.tglbatal, 10) BETWEEN '$tglcon1' AND '$tglcon2'";
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
                       Concat('`', a.regid)    NoRegister,
                       Concat('`', a.policyno) NoSertifikat,
                       a.nopeserta             NoPinjaman,
                       a.nama                  Nama,
                       a.jkel                  JenisKelamin,
                       o.msdesc                Pekerjaan,
                       b.msdesc                Cabang,
                       tgllahir                TglLahir,
                       mulai                   TglMulai,
                       Concat('`', a.noktp)    NoKTP,
                       akhir                   TglAkhir,
                       masa                    'Masa(bulan)',
                       a.tunggakan             Graceperiod,
                       a.up                    Plafond,
                       tpremi                  Premi,
                       g.msdesc                Asuransi,
                       c.msdesc                'Status',
                       a.createdt              TglInput,
                       e.paiddt                TglBayarPremi,
                       e.paidamt               JmlBayarPremi,
                       Concat('`', h.regclaim) NoClaim,
                       h.tglkejadian           TglKejadian,
                       h.tgllapor              TglLaporClaim,
                       h.nilaios               NilaiOS,
                       DATE_ADD(h.tglkejadian,INTERVAL (wkc.msdesc + wkc.createby) DAY) TglJatuhTempo,
                       a.validdt               TglValidasi,
                       h.validdt               TglValidClaim,
                       k.createdt              TglRejectClaim,
                       n.msdesc                AlasanReject,
                       h.comment               Keterangan,
                       j.createdt              TglTerimaDokumen,
                       d.paiddt                TglBayarClaim,
                       d.paidamt               JmlBayarClaim,
                       IF (dok.hasil IS NULL,
                            'Lengkap',
                            'Belum Lengkap')   StatusDokumen,
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
                       INNER JOIN  (SELECT msid, msdesc FROM ms_master WHERE mstype = 'KERJA') o
                              ON o.msid  = a.pekerjaan
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
                              AND LEFT(h.tgllapor, 10) BETWEEN '$tglcon1' AND '$tglcon2'  ";
                    
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
		$stitle = "Laporan Data produksi di bayar";		
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " akhir,masa,a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,d.paiddt tglbayar,d.paidamt jmlbayar,a.createdt tglinput, ";
		$sql .= " concat('`',a.policyno) nosertifikat,h.msdesc mitra   from tr_sppa a ";
		$sql .= " inner join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " inner join ms_master c on a.status=c.msid and c.mstype='streq'    ";	
		$sql .= " inner join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " inner join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master h on a.mitra=h.msid and h.mstype='mitra'    ";
		$sql .= " inner join tr_sppa_paid d on d.regid=a.regid  and d.paidtype='PREMI' ";
		$sql .= " where  a.status='20' and left(a.createdt,10) between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " akhir,masa,a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,a.createdt tglinput,a.policyno nosertifikat  from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " inner join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " where a.status in (2,3,4,5) and left(a.createdt,10) between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " akhir,masa,a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,d.paiddt tglbayar,d.paidamt jmlbayar,a.createdt tglinput, ";
		$sql .= " concat('`',a.policyno) nosertifikat,h.msdesc mitra  from tr_sppa a ";
		$sql .= " inner join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " inner join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " inner join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " inner join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " left join ms_master h on a.mitra=h.msid and h.mstype='mitra'    ";
		$sql .= " inner join tr_sppa_paid d on d.regid=a.regid and d.paidtype='PREMI'  ";
		$sql .= " where   left(d.paiddt,10) between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,";		
		$sql .= " akhir,masa,a.tunggakan graceperiod,up,tpremi premi,g.msdesc Asuransi,c.msdesc status,d.paiddt tglbayar,d.paidamt jmlbayar,a.createdt tglinput, ";
		$sql .= " concat('`',a.policyno) nosertifikat  from tr_sppa a ";
		$sql .= " inner join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " inner join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " inner join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " left join tr_sppa_paid d on d.regid=a.regid  and d.paidtype='PREMI'";
		$sql .= " where   left(a.createdt,10)  between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,akhir,masa,a.tunggakan graceperiod,up,tpremi premi, ";		
		$sql .= " g.msdesc Asuransi,c.msdesc status,a.createdt tglinputa,a.nopeserta nopinjaman,REPLACE(REPLACE(REPLACE(concat(h.comment,' ',a.comment),'\n',''),'\t',''),'\r','') Ket  from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " left join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " left join tr_sppa_log h on a.regid=h.regid and h.status='12'    ";
		$sql .= " where a.status in ('12') and left(a.createdt,10) between '$tglcon1'	and '$tglcon2' ";
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
		$sql = "select f.msdesc produk,concat('`',a.regid) Noregister,a.nopeserta nopinjaman,a.nama,concat('`',a.noktp) noktp,";
		$sql .= " jkel,pekerjaan,b.msdesc cabang,tgllahir,mulai,a.akhir,a.masa,a.tunggakan graceperiod,up, ";		
		$sql .= " tpremi premi,g.msdesc Asuransi,c.msdesc status,a.createdt tglinput,concat('`',a.policyno) nosertifikat,a.validdt tglvalidasi, ";
		$sql .= " d.paiddt Tglbayar,d.paidamt Jmlbayar ";
		$sql .= " from tr_sppa a ";
		$sql .= " left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";		
		$sql .= " left join ms_master f on a.produk=f.msid and f.mstype='produk'    ";
		$sql .= " left join ms_master c on a.status=c.msid and c.mstype='streq'    ";
		$sql .= " left join ms_master g on a.asuransi=g.msid and g.mstype='asuransi'    ";
		$sql .= " left join tr_sppa_paid d on d.regid=a.regid  and d.paidtype='premi' ";
		$sql .= " where a.status in ('5','20') and left(a.validdt,10) between '$tglcon1'	and '$tglcon2' ";

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
	$data = "";
	if ($stfile=="xls" ) {
		$export = mysql_query ( $sql ) ;
        $fields = mysql_num_fields ( $export );
        $table  = "<table border=1><thead><tr style='white-space: nowrap;'>";            // Generate Table
        for ( $i = 0; $i < $fields; $i++ ) {
        // 	$header .= mysql_field_name( $export , $i ) . ",";
        	$table .= "<th>".mysql_field_name( $export, $i )."</th>";           // Generate Table
        }
        
        $table  .= "</tr></thead><tbody>";                                      // Generate Table
        
        while( $row = mysql_fetch_row( $export ) ) {
        // 	$line = '';
        	$table .= "<tr style='white-space: nowrap;'>";                      // Generate Table
        	foreach( $row as $value ) {
        		if ( ( !isset( $value ) ) || ( $value == "" ) ){
        // 			$value = ",";
        			$table .= "<td></td>";                                      // Generate Table
        		}
        		
        		else {
        			$value = str_replace( '\r' , '' , $value );
        			$value = str_replace( '\t' , '' , $value );
        			$value = str_replace( '\n' , '' , $value );
        			$value = str_replace( '\s' , '' , $value );
        			$value = str_replace( '"' , '' , $value );
        // 			$value = str_replace( ',' , ';' , $value );
        // 			$value = '"' . $value . '",';
        			$table .= "<td>".$value."</td>";                            // Generate Table
        		}
        		
        // 		$line .= $value;
        	}
        // 	$data .= trim( $line ) . "\n";
        	$table .= "</tr>";                                                  // Generate Table
        }
        $table .= "</tbody></table>";                                           // Generate Table
        
        $data = str_replace( "\r" , "" , $data );
        header("Content-type: application/vnd-ms-excel");
        header("Content-disposition: filename = ".$file_name.".xls");
        // print "$stitle\n$speriode\n$sproduk\n$scabang\n$sasuransi\n\n$header\n$data";
        print "<b>$stitle</b><br>$speriode<br>$sproduk<br>$scabang<br>$sasuransi<br><br>$table";// Generate Table
        exit;
	}
		
	else if ($stfile=="csv" ) {
        $export = mysql_query ( $sql ) ;
        $fields = mysql_num_fields ( $export );
    
        for ( $i = 0; $i < $fields; $i++ ) {
        	$header .= mysql_field_name( $export , $i ) . ",";
        }
        
        while( $row = mysql_fetch_row( $export ) ) {
        	$line = '';
        	foreach( $row as $value ) {
        		if ( ( !isset( $value ) ) || ( $value == "" ) ){
        			$value = ",";
        		}
        		
        		else {
        // 			$value = str_replace( '"' , '""' , $value );
        			$value = '"' . $value . '"' . ",";
        		}
        		
        		$line .= $value;
        	}
        	$data .= trim( $line ) . "\n";
        }
        
        $data = str_replace( "\r" , "" , $data );
        $data = str_replace( "`" , "" , $data );
        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: csv" . date("Y-m-d") . ".csv");
        header("Content-disposition: filename = ".$file_name.".csv");
        print "$stitle\n$speriode\n$sproduk\n$scabang\n$sasuransi\n\n$header\n$data";
        exit;
		
	}
			
	else if ($stfile=="doc" ) {
		$sexp = $db_handle->runQuery($sql);
		header("Content-Type: application/vnd.ms-word");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-disposition: attachment; filename=".$file_name . ".doc");


		$isPrintHeader = false;
		echo $stitle . "\n";
		echo $stitle1 . "\n";
		echo $stitle2 . "\n";
		echo $stitle3 . "\n";
		if (! empty($sexp)) {
			foreach ($sexp as $row) {
				if (! $isPrintHeader) {
					echo implode("\t", array_keys($row)) . "\n";
					$isPrintHeader = true;
				}
				echo implode("\t", array_values($row)) . "\n";
			}
		}
		exit();	
		
		}
	
	}
?>