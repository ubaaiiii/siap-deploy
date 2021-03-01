<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	date_default_timezone_set('Asia/Jakarta');
	$sregid=$_GET['id'];
	include "../../phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA
	$tempdir = "../../temp/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
	if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
		mkdir($tempdir);
		//lanjutan yang tadi
	#parameter inputan
	$isi_teks = sregid;
	$namafile = $sregid.".png";
	$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
	$ukuran = 2; //batasan 1 paling kecil, 10 paling besar
	$padding = 0;
	QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
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
			<!-- <div class="kops">
			<table class="kop">
				<tr style="width: 100%;">
					<td class="judul_kop_rl">
						<img src="../../images/logo_kop.png" class="logo">
					</td>
					<td  class="judul_kop">
					<?php
					// get providerid
					$query_prov = mysql_query("select providerid from tr_eligtrans where ALTCLAIMNO='$idclaimno'");
					$prov_row = mysql_fetch_assoc($query_prov);
					$providerid = $prov_row['providerid'];
					$query=mysql_query("SELECT providername,building,street1,street2,phone1, phone2,fax1,email FROM tr_provider where providerid='$providerid' ");
					$r=mysql_fetch_array($query);
					$providername = $r['providername'];
					?>
						<H3> </H3>
						<h2><?php echo $providername; ?> </h2>
                        <h5><?php echo $r['building'];?></h5>
						<h5><?php echo $r['street1'] . " " .$r['street2'] ;?></h5>
						<h5><?php echo "Telpon : " . $r['phone1'] . " " . $r['phone2'] . " Fax. : " . $r['fax1'];?></h5>
						<h5><?php echo ($r['email']!=''?'Email : '.$r['email']:'');?></h5>
					</td>
				</tr>
			</table>
		</div>
		<div class="garis">
			<hr class="line1"/>
			<hr class="line2"/>
		</div> -->
			<div class="judul">
				<b></b><br>
				<b>SURAT PERMOHONAN ASURANSI KREDIT</b><br>
			</div>
			<?php
			// header transaction
			$sqlm="select aa.*,ab.msdesc jkeldesc,ac.msdesc kerja,aa.cabang,aa.mitra,aa.createby suser,aa.createdt,aa.produk,ad.msdesc prodname,ae.msdesc scab,af.msdesc smitra ";
			$sqlm=$sqlm ." from tr_sppa aa inner join ms_master ab on aa.jkel=ab.msid and ab.mstype='JKEL' ";
			$sqlm=$sqlm ." left join  ms_master ac on aa.pekerjaan=ac.msid and ac.mstype='kerja'  ";
			$sqlm=$sqlm ." left join  ms_master ad on aa.produk=ad.msid and ad.mstype='PRODUK'";
			$sqlm=$sqlm ." left join  ms_master ae on aa.cabang=ae.msid and ae.mstype='cab'";
			$sqlm=$sqlm ." left join  ms_master af on aa.mitra=af.msid and af.mstype='mitra'";
			$sqlm=$sqlm ." where aa.regid='$sregid' ";
			//echo $sqlm;
			$query1=mysql_query($sqlm);
			$r1=mysql_fetch_array($query1);
			$policyno= $r1['policyno'];
			$subprodid= $r1['subprodid'];
			$membid= $r1['membid'];
			$jtangung="MENURUN";
			$tunggakan=$r1['tunggakan'];
			$resiko="MENINGGAL DUNIA";
			$validdt='Jakarta , ' . substr($r1['validdt'],0,10);
			?>
			<p class="space"></p>
			<div class="juduls">
				<p align="center">INFORMASI NASABAH</p> <br>
			</div>
			<table class="table_new">
			
				<tr>
					<td style="width: 40%">Produk </td><td  style="width: 50%"><?php echo $r1['prodname']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">No Register </td><td  style="width: 50%"><?php echo $r1['regid']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">No Pinjaman </td><td  style="width: 50%"><?php echo $r1['nopeserta']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Nama Peserta </td><td  style="width: 50%"><?php echo $r1['nama']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Tanggal Lahir </td><td  style="width: 50%"><?php echo tglindo_balik($r1['tgllahir']); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Jenis Kelamin </td><td  style="width: 50%"><?php echo $r1['jkeldesc']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">No KTP </td><td  style="width: 50%"><?php echo $r1['noktp']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Pekerjaan</td><td  style="width: 50%"><?php echo $r1['kerja']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Mulai Asuransi</td><td  style="width: 50%"><?php echo tglindo_balik($r1['mulai']); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Akhir Asuransi</td><td  style="width: 50%"><?php echo tglindo_balik($r1['akhir']); ?></td>
				</tr>
								<tr>
					<td style="width: 40%">Masa Asuransi</td><td  style="width: 50%"><?php echo $r1['masa'] . ' Bulan'; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Uang Pertanggungan</td><td  style="width: 50%"><?php echo number_format($r1['up'],0); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Jenis Pertanggungan </td><td  style="width: 50%"><?php echo $jtangung; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Resiko Yang Dijamin</td><td  style="width: 50%"><?php echo $resiko; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Grace Period (Khusus MPP) </td><td  style="width: 50%"><?php echo $tunggakan;  ?></td>
				</tr>

				<tr>
					<td style="width: 40%">Premi</td><td  style="width: 50%"><?php echo number_format($r1['premi'],0); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Account Officer</td><td  style="width: 50%"><?php echo $r1['suser']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Mitra</td><td  style="width: 50%"><?php echo $r1['smitra']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Cabang</td><td  style="width: 50%"><?php echo $r1['scab']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Tanggal Input</td><td  style="width: 50%"><?php echo $r1['createdt']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Nama User </td><td  style="width: 50%"><?php echo $r1['suser']; ?></td>
				</tr>
				
				
			</table>
			<div class="info">
				<p class="space"></p>
				<p align="justify">Saya menyatakan, bahwa keterangan-keterangan tersebut di atas diberikan dengan sejujur-jujurnya dan saya mengetahui serta menyadari bahwa jika terdapat sesuatu hal yang dengan sengaja tidak diberitahukan atau tidak benar, maka PT Bina Dana Sejahtera  berhak membatalkan perjanjian asuransi atau menolak dan tidak membayar Klaim Manfaat Asuransi.
				</p>
				<p class="space"></p>
				<p class="space"></p>
			</div>
			<table class="table_new_nb">
				<tr>
					<td style="width: 18%;"></td>
					<td style="width: 30%; text-align: center;"></td>
					<td style="width: 18%"></td>
					<td style="width: 30%; text-align: center;"><?php echo date("d-m-Y"); ?> <br> Pemohon</td>
				</tr>
			</table>
			<table class="table_new_nb">
			<td class="info">
			</td>
			</table>
			<br><br><br><br><br><br><br><br>
			<table class="table_new_nb">
				<tr>
					<td style="width: 18%;"></td>
					<td style="width: 30%; text-align: center;"></td>
					<td style="width: 18%"></td>
					<td style="width: 30%; text-align: center;"><?php echo $r1['nama']; ?> </td>
				</tr>
		</table>
		</div>
		<page_footer>
			<div class="" style="font-size:10px">
				Dicetak secara otomatis pada system pada <?php echo date("d-m-Y H:i:s"); ?>
			</div>
		</page_footer>
	</body>
</html>