<?php
    session_start();
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	date_default_timezone_set('Asia/Jakarta');
	$sregid=$_GET['id'];
	$jenis = $_GET['jenis'];
	$vlevel= $_SESSION['idLog'];
	
	?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../img/laporan.png">
		<link rel="stylesheet" type="text/css" href="../../css/laporan.css">
		<style>
		table{
			font-size: 11px;
		}
		.logo{
			width:180px;
			/*padding: 50px 50px 50px 50px;*/
			margin: 30px 50px 10px 10px;
		}
		.judul_kop{
			text-align:center;
			display: block;
			width: 10000px !important;
		}
		.judul_kop_rl{
			width: 25% !important;
		}
		.kop{
			border-collpase:collapse;
		}
		.kop .header{
			width:130px;
		}
		.kop .judul{
			text-align:center;
		}
		.kop table{
			text-align:left;
			border-collpase:collapse;
		}
		.kop table .cel1{
			width:200px;
		}
		.kop table .cel2{
			width:170px;
		}
		.kop table .cel3{
			width:170px;
		}
		.kop table td{
			font-size:11px;
		}
		.garis{
			line-height:1.5px;
		}
		.garis .line1{
			border:1px solid #000;
		}
		.garis .line2{
			border:0.5px solid #000;
		}
		.tbl_lap1{
			margin:20px 0px;
		}
		.tbl_lap1 .cel1{
			width:180px;
		}
		.tbl_lap1 .cel2{
			width:200px;
		}
		.tbl_lap1 .cel3{
			width:290px;
		}
		.judul{
			text-align:center;
		}
		.tbl_lap2{
			border-collapse:collapse;
			border:1px solid #000;
		}
		.tbl_lap2 .cel1{
			width:20px;
		}
		.tbl_lap2 .cel2{
			width:200px;
		}
		.tbl_lap2 .cel3{
			width:400px;
		}
		.tbl_lap2 td{
			padding:5px 2px;
		}
		.space{
			padding:10px;
		}
		.tbl_lap3 .cel1{
			width:300px;
		}
		.tbl_lap3 .cel2{
			width:100px;
		}
		.tbl_lap3 .cel3{
			width:300px;
		}
		.table_new{
			border-collapse: collapse;
			padding-left:40px;
			width:100%;
		}
		.table_new td{
			padding: 5px 5px 5px 5px;
		 }
		.table_new, .table_new th, .table_new td {
    		border: 1px solid black;
		}
		.table_new_nb{
			border-collapse: collapse;
		}
		.table_new_head{
			border-collapse: collapse;
		}
		.table_new_nb head{
			padding: 10px 5px 5px 0px;
		 }
		 .list_1 li{
			 list-style: lower-alpha;
		 }
		 .list_check {
			 list-style: square;
		 }
		 .catatan{
			 font-size: 11px;
			 width: 94%;
		 }
		 .info{
			 text-align: justify;
			 font-size: 11px;
			 padding-left:25px;
		 }
		 .juduls{
			 font-size: 11px;
			 font-weight: bold;
		 }
		 .chlist{
			 font-size: 10px;
			 border-left: 1px solid #000;
			 border-right: 1px solid #000;
		 }
		</style>
	</head>
	<body>
		<div class="page">
		
			<div class="judul">
				<b></b><br>
				<b>FORMULIR PENGAJUAN PEMBATALAN ASURANSI KREDIT</b><br>
			</div>
			<?php
			// header transaction
			$sqlm = mysql_query(" SELECT aa.*,
                                         ab.msdesc jkeldesc,
                                         ac.msdesc kerja,
                                         aa.cabang,
                                         aa.mitra,
                                         aa.createby,
                                         aa.createdt,
                                         aa.produk,
                                         ad.msdesc prodname,
                                         ae.msdesc scab,
                                         af.msdesc smitra,
                                         ag.nama   aoname,
                                         agg.nama  parentname,
                                         ai.nmasuransi,
                                         ai.alamat1,
                                         tc.reason,
                                         tc.tglbatal,
                                         tc.sisa,
                                         tc.catreason,
                                         ah.msdesc ctreason
                                  FROM   tr_sppa aa
                                         INNER JOIN ms_master ab
                                                 ON aa.jkel = ab.msid
                                                    AND ab.mstype = 'JKEL'
                                         LEFT JOIN ms_master ac
                                                ON aa.pekerjaan = ac.msid
                                                   AND ac.mstype = 'kerja'
                                         LEFT JOIN ms_master ad
                                                ON aa.produk = ad.msid
                                                   AND ad.mstype = 'PRODUK'
                                         LEFT JOIN ms_master ae
                                                ON aa.cabang = ae.msid
                                                   AND ae.mstype = 'cab'
                                         LEFT JOIN ms_master af
                                                ON aa.mitra = af.msid
                                                   AND af.mstype = 'mitra'
                                         LEFT JOIN ms_admin ag
                                                ON ag.username = aa.createby
                                         LEFT JOIN ms_admin agg
                                                ON agg.username = ag.parent
                                         LEFT JOIN tr_sppa_cancel tc
                                                ON tc.regid = aa.regid
                                         LEFT JOIN ms_master ah
                                                ON tc.catreason = ah.msid
                                                   AND ah.mstype = '$jenis'
                                         LEFT JOIN ms_insurance ai
                                                ON aa.asuransi = ai.asuransi 
                                  WHERE  aa.regid = '$sregid' ");
			
			$r1         = mysql_fetch_array($sqlm);
			$policyno   = $r1['regid'];
			$subprodid  = $r1['subprodid'];
			$membid     = $r1['membid'];
			$jtangung   = "MENURUN";
			$resiko     = "MENINGGAL DUNIA";
			$validdt    = 'Jakarta , ' . substr($r1['validdt'],0,10);
			?>
			<div class="juduls">
				<p align="center">No Register : <?=$policyno;?> </p> <br>
			</div>
			<div class="info">
				<p class="space"></p>
				<p align="justify">
				    <?= ucwords(strtolower($r1['scab'])) ;?>, <?=tgl_indo(date('d-m-Y'));?> <br>
				    <br>
				    <br>
				    Kepada Yth.<br>
				    PT. <?=ucwords(strtolower($r1['nmasuransi']));?> <br>
				    <?= wordwrap($r1['alamat1'],35,"<br>\n");?><br>
				    <br>
				    <br>
				    Dengan hormat,<br>
				    Bersama ini kami sampaikan permohonan pembatalan kepesertaan asuransi atas nama:<br>
			    </p>
			</div>
			<p class="space"></p>
			<table class="table_new">
				<tr>
					<td style="width: 40%">Produk </td><td  style="width: 50%"><?=$r1['prodname'];?></td>
				</tr>
				<tr>
					<td style="width: 40%">No Pinjaman </td><td  style="width: 50%"><?=$r1['nopeserta'];?></td>
				</tr>
				<tr>
					<td style="width: 40%">Nama Peserta </td><td  style="width: 50%"><?=$r1['nama'];?></td>
				</tr>
				<tr>
					<td style="width: 40%">Tanggal Lahir </td><td  style="width: 50%"><?=tglindo_balik($r1['tgllahir']);?></td>
				</tr>
				<tr>
					<td style="width: 40%">Jenis Kelamin </td><td  style="width: 50%"><?=$r1['jkeldesc'];?></td>
				</tr>
				<tr>
					<td style="width: 40%">No KTP </td><td  style="width: 50%"><?=$r1['noktp'];?></td>
				</tr>
				<tr>
					<td style="width: 40%">Pekerjaan</td><td  style="width: 50%"><?=$r1['kerja'];?></td>
				</tr>
				<tr>
					<td style="width: 40%">Mulai Asuransi</td><td  style="width: 50%"><?=tglindo_balik($r1['mulai']);?></td>
				</tr>
				<tr>
					<td style="width: 40%">Akhir Asuransi</td><td  style="width: 50%"><?=tglindo_balik($r1['akhir']);?></td>
				</tr>
				<tr>
					<td style="width: 40%">Masa Asuransi</td><td  style="width: 50%"><?=$r1['masa']. ' Bulan' ;?></td>
				</tr>
				
				<tr>
					<td style="width: 40%">Jenis Pertanggungan </td><td  style="width: 50%"><?=$jtangung;?></td>
				</tr>
				<tr>
					<td style="width: 40%">Resiko Yang Dijamin</td><td  style="width: 50%"><?=$resiko;?></td>
				</tr>
				<tr>
					<td style="width: 40%">Uang Pertanggungan</td><td  style="width: 50%">Rp. <?=number_format($r1['up'],2,",",".");?></td>
				</tr>
				<tr>
					<td style="width: 40%">Premi</td><td  style="width: 50%">Rp. <?=number_format($r1['premi'],2,",",".");?></td>
				</tr>
				<tr>
					<td style="width: 40%">Account Officer</td><td  style="width: 50%"><?=$r1['aoname'];?></td>
				</tr>
				<tr>
					<td style="width: 40%">Mitra</td><td  style="width: 50%"><?=$r1['smitra'];?></td>
				</tr>
				<tr>
					<td style="width: 40%">Cabang</td><td  style="width: 50%"><?=$r1['scab'];?></td>
				</tr>
				<!--<tr>-->
				<!--	<td style="width: 40%">Alasan</td><td  style="width: 50%"><?=$r1['ctreason'];?></td>-->
				<!--</tr>-->
				<!--<tr>-->
				<!--	<td style="width: 40%">Keterangan</td><td  style="width: 50%"><?=$r1['reason'];?></td>-->
				<!--</tr>-->
				<!--<tr>-->
				<!--	<td style="width: 40%">Tanggal Batal</td><td  style="width: 50%"><?=$r1['tglbatal'];?></td>-->
				<!--</tr>-->
				<!--<tr>-->
				<!--	<td style="width: 40%">Sisa Asuransi</td><td  style="width: 50%"><?=$r1['sisa'] . ' Bulan' ;?></td>-->
				<!--</tr>-->
			</table>
			<div class="info">
				<p class="space"></p>
				<p align="justify">
				    Demikian kami sampaikan informasi tersebut diatas. Kami harap permohonan ini dapat segera diproses.<br>
				    Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br>
				    <br>
				    <br>
				    <br>
				    <br><br>
				    Hormat kami,<br>
				    PT. Bank Bukopin Tbk<br>
				    Cabang <?=ucwords(strtolower($r1['scab']));?>
				</p>
				<p class="space"><br></p>
			</div>
			<table class="table_new_nb">
				<tr>
				    <td style="width: 10%;"></td>
					<td style="width: 30%; text-align: center;">Yang Mengajukan</td>
					<td style="width: 18%;"></td>
					<td style="width: 30%; text-align: center;">Yang Menyetujui</td>
				</tr>
			</table>
			<table class="table_new_nb">
			<td class="info">
			</td>
			
			</table>
			<br><br><br><br><br><br><br><br>
			<table class="table_new_nb">
				<tr>
				    <td style="width: 10%;"></td>
					<td style="width: 30%; text-align: center;"><b><u>(&nbsp;<?=$r1['aoname'];?>&nbsp;)</u></b></td>
					<td style="width: 18%;"></td>
					<td style="width: 30%; text-align: center;"><b><u>(&nbsp;<?=$r1['parentname'];?>&nbsp;)</u></b></td>
				</tr>
		</table>
		</div>
		<page_footer>
			<div class="" style="font-size:10px;padding-left:25;">
		        Note: Harap form pembatalan ini ditandatangani dan dibubuhkan cap Bank Bukopin. <br>
				Dicetak secara otomatis oleh sistem SIAP pada <?=date("d-m-Y H:i:s");?>
			</div>
		</page_footer>
	</body>
</html>