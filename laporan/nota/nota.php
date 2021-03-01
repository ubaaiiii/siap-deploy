<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	$sregid=$_GET['id'];
	//$id_pegawai=$_POST['id_pegawai'];

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
				<b>FORM KLAIM CASHLESS</b>
			</div>
			<div class="info">
				<p class="space"></p>
				<p>Formulir Klaim ini diisi oleh Peserta dan Dokter yang merawat sesuai dengan data medis atau keadaan kesehatan yang sebenarnya. Formulir Klaim ini harus dilengkapi dengan tanda tangan Peserta beserta tanda tangan dan SIP Dokter yang merawat dengan mencantumkan stempel dari tempat Peserta mendapatkan pelayanan kesehatan. Agar Formulir Klaim ini dapat diisi dengan lengkap dan dikirimkan kepada ISOmedik dengan mencantumkan kwitansi asli beserta perincian biaya pelayanan kesehatan, copy resep, hasil pemeriksaan penunjang diagnostik, fotocopy Kartu Peserta Asuransi, beserta dokumen pendukung lain yang dianggap penting. Formulir Klaim yang tidak diisi dengan lengkap tidak dapat diproses. Untuk klaim rawat inap agar dapat melampirkan copy Resume Medis dari tempat Peserta mendapatkan pelayanan kesehatan.
				</p>
			</div>
			<?php

			// header transaction
			$sqlm="select a.altmembid,a.membid,a.policyno,a.fullname,b.payornm,b.clientname ,d.subprodnm2 benefit, date_format(a.BIRTHDATE, '%d-%m-%Y') as tanggal_lahir, a.sex, a.empname ";
			$sqlm=$sqlm ." ,c.altclaimno,e.deskripsi status,date_format(c.eligdt, '%d-%m-%Y') as tanggal_masuk,date_format(c.admissiondt, '%d-%m-%Y') as admissiondt, c.eligdt,c.createdt,c.refno ,c.subprodid, ";
			$sqlm=$sqlm ." case when tch.DIAGID2 ='' then tch.DIAGID else concat(tch.DIAGID,', ', tch.DIAGID2 ) end as diagnosa, ";
			$sqlm=$sqlm ." case when c.refout = '' then 'Ya' else 'Tidak' end as isrujukan,tci.*, tp.providername ";
			$sqlm=$sqlm ." from tr_polmember a inner join tr_policy b on a.policyno=b.policyno inner join tr_eligtrans c ";
			$sqlm=$sqlm ." on c.altmembid=a.altmembid inner join tbl_subproduct d on d.subprodid=c.subprodid  ";
			$sqlm=$sqlm ." inner join tbl_code e on e.kode=c.status and e.type='status'  ";
			$sqlm=$sqlm ." left join tr_claim_hdr tch on (c.altclaimno = tch.CLAIMREF) left join tr_claim_info tci on (c.altclaimno = tci.CLAIMREF) left join tr_provider tp on (tci.refprovider = tp.PROVIDERID) ";
			$sqlm=$sqlm ." where c.altclaimno='$idclaimno' ";

			//echo $sqlm;

			$query1=mysql_query($sqlm);
			$r1=mysql_fetch_array($query1);
			$policyno= $r1['policyno'];
			$subprodid= $r1['subprodid'];
			$membid= $r1['membid'];

			?>


			<p class="space"></p>
			<div class="juduls">
				<p>INFORMASI PASIEN</p> <br>
			</div>
			<table class="table_new">
				<tr>
					<td style="width: 20%">Nama Pasien</td><td  style="width: 30%"><?php echo $r1['fullname']; ?></td>
					<td  style="width: 20%">Asuransi/Perusahaan</td><td style="width: 30%"><?php echo $r1['payornm']; ?></td>
				</tr>
				<tr>
					<td>Nama Karyawan</td><td><?php echo $r1['empname']; ?></td>
					<td>Perusahaan</td><td><?php echo $r1['clientname']; ?></td>
				</tr>
				<tr>
					<td>Tanggal Lahir</td><td><?php echo $r1['tanggal_lahir']; ?></td>
					<td>No. Polis</td><td ><?php echo $r1['policyno']; ?></td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td><td><?php echo ($r1['sex']=='M'?'Pria':'Wanita'); ?></td>
					<td>No. Peserta/No. Kartu</td><td ><?php echo $r1['altmembid']; ?></td>
				</tr>
			</table>



			<p class="space"></p>
			<div class="juduls">
				<p>INFORMASI PELAYANAN KESEHATAN</p> <br>
			</div>
			<table class="table_new">
				<tr>
					<td style="width: 20%">Nama RS/Klinik/ <br>Tempat Pelayanan </td><td style="width: 30%"><?php echo $r1['empname']; ?></td>
					<td style="width: 20%">Tanggal Perawatan</td><td style="width: 30%"><?php echo $r1['tanggal_masuk']; ?><</td>
				</tr>
				<tr>
					<td>Jenis Pelayanan</td><td><?php echo $r1['benefit']; ?></td>
					<td>Nomor Transaksi</td><td ><?php echo $r1['altclaimno']; ?></td>
				</tr>
			</table>

			<p class="space"></p>

			<table class="table_new">

				<tr>
					<td rowspan="2" style="width: 50%">1.a. Anamnesa</td>
					<td style="width:50%">b. Pemeriksaan fisik</td>
				</tr>
				<tr>
					<td style="border-left: none;">c. Riwayat kesehatan sebelumnya</td>
				</tr>
				<tr>
					<td colspan="2">d. Tanda-Tanda Vital : <br>
						Tekanan Darah : ___/___ mmHg                    Nadi : _____/Menit                     Pernafasan : _____/Menit
					</td>
				</tr>
				<tr>
					<td>e. Tanggal/Waktu Pemeriksaan  :  ___/ ___ / ______ Pkl. ______</td>
					<td>f. Tanggal pertama kali konsultasi   :  ___/ ___ / ______ </td>
				</tr>
				<tr>
					<td colspan="2">g. Hasil Pemeriksaan Penunjang Diagnostik : <br><br></td>
				</tr>
				<tr>
					<td>2. Diagnosa masuk : <br></td>
					<td>b. Diagnosa Keluar : <br></td>
				</tr>
				<tr>
					<td colspan="2">3. Terapi yang diberikan : <br><br></td>
				</tr>
				<tr>
					<td  style="border-bottom: none !important;" colspan="2">4. Apakah diagnosa berhubungan atau disebabkan oleh : [X] sesuai dengan kondisi pasien</td>
				</tr>
			</table>
			<table class="chlist">
				<tr style="border: solid 1">
					<td style="width: 25%; border: none !important;padding-left: 10px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Kelainan Bawaan</td>
					<td style="width: 25%; border: none !important;padding-left: 20px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Kehamilan</td>
					<td style="width: 25%; border: none !important;padding-left: 35px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Olahraga Berbahaya</td>
					<td style="width: 25%; border: none !important;padding-left: 70px;padding-right:100px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Lainnya, sebutkan : <br></td>
				</tr>
				<tr style="border: none !important;">
					<td style="border: none !important;padding-left: 10px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Penyakit Keturunan</td>
					<td style="border: none !important; padding-left: 20px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Hormonal</td>
					<td  style="border: none !important;padding-left: 35px;" colspan="2">[&nbsp;&nbsp;&nbsp;]&nbsp;Tindak Kekerasan</td>
				</tr>
				<tr>
					<td style="border: none !important;padding-left: 10px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Infertilitas/Usaha Mempunyai Keturunan</td>
					<td style="border: none !important; padding-left: 20px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Kosmetika</td>
					<td  style="border: none !important;padding-left: 35px;" colspan="2">[&nbsp;&nbsp;&nbsp;]&nbsp;Huru-hara/Demontrasi/Pemogokan</td>
				</tr>
				<tr>
					<td style="border: none !important;padding-left: 10px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Penyakit Menular Seksual</td>
					<td style="border: none !important;padding-left: 20px;">[&nbsp;&nbsp;&nbsp;]&nbsp;Olahraga berbahaya</td>
					<td  style="border: none !important;padding-left: 35px;" colspan="2">[&nbsp;&nbsp;&nbsp;]&nbsp;Perbuatan melanggar Hukum</td>
				</tr>
				<tr>
					<td style="border: none !important;padding-left: 10px;" >[&nbsp;&nbsp;&nbsp;]&nbsp;Gangguan Kejiwaan/Psikosomatis <br><br></td>
					<td style="border: none !important;padding-left: 20px;" >[&nbsp;&nbsp;&nbsp;]&nbsp;Tindak kekerasan</td>
					<td style="border: none !important;padding-left: 35px;" colspan="2">[&nbsp;&nbsp;&nbsp;]&nbsp;Ritual Keagamaan</td>
				</tr>
			</table>
			<table class="table_new">
				<tr>
					<td style="text-align: justify;width: 100%;">
						Dengan ini Saya memberikan kuasa kepada ISOmedik untuk mendapatkan informasi mengenai
						kesehatan saya dari RS/Klinik/Dokter untuk penilaian klaim yang Saya ajukan.
						Saya mengerti bahwa pengajuan klaim ini tunduk sepenuhnya kepada ketentan
						Polis yang berlaku dan apabila diagnosa Saya termasuk dalam pengecualian Polis atau
						terdapat biaya yang melebihi batas atau diluar manfaat yang saya miliki maka saya bersedia membayar selisih biaya yang terjadi.
					</td>
				</tr>
			</table>
			<br><br><br><br><br><br><br><br><br><br>
			<table class="table_new_nb">
				<tr>
					<td style="width: 18%;">___/ ___ / ______ <br> Tanggal</td>
					<td style="width: 30%; text-align: center;">____________________________<br> Nama dan Tanda Tangan <br>Peserta atau Wali </td>
					<td style="width: 18%">___/ ___ / ______  <br> Tanggal</td>
					<td style="width: 30%; text-align: center;">____________________________<br> Nama dan Tanda Tangan Dokter <br> Stempel RS/Dokter</td>
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
