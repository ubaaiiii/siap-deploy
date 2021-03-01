<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	date_default_timezone_set('Asia/Jakarta');
	$sregid=$_GET['id'];
	
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
		.table_new td, .table_new th{
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
		 .ket th, .ket td {
             padding: 5px;
         }
		</style>
	</head>
	<body>
		<div class="page">
		<div class="kops">
			<table class="kop">
				<tr style="width: 100%;">
					<td class="l">
								<img src="../../images/logoinv.jpg" class="logo" >
					</td>
					
				</tr>
			</table>
		</div>
		<div class="garis">
			<hr class="line1"/>
			<hr class="line2"/>
		</div> 
			<div class="judul">
				<b></b><br>
				<b>CHECK LIST KELENGKAPAN DOKUMEN KLAIM</b><br>
			</div>
			<?php
			// header transaction
			$sqlm   = " SELECT aa.*,                ab.msdesc jkeldesc,
                               ac.msdesc kerja,     aa.cabang,
                               aa.mitra,            aa.createby,
                               ah.nopk,             ah.nilaios,
                               ah.penyebab,         ah.tglkejadian,
                               aj.msdesc sebabclm,  ai.msdesc tmpjadi,
                               aa.createdt,         aa.produk,
                               ad.msdesc prodname,  ae.msdesc scab,
                               af.msdesc smitra,    ag.nama   aoname,
                               ah.regclaim,         ak.msdesc asuransi,
                               ah.tgllapor          
                        FROM   tr_sppa aa
                               INNER JOIN ms_master ab
                                       ON aa.jkel = ab.msid         AND ab.mstype = 'JKEL'
                               LEFT JOIN ms_master ac
                                      ON aa.pekerjaan = ac.msid     AND ac.mstype = 'kerja'
                               LEFT JOIN ms_master ad
                                      ON aa.produk = ad.msid        AND ad.mstype = 'PRODUK'
                               LEFT JOIN ms_master ae
                                      ON aa.cabang = ae.msid        AND ae.mstype = 'cab'
                               LEFT JOIN ms_master af
                                      ON aa.mitra = af.msid         AND af.mstype = 'mitra'
                               LEFT JOIN ms_admin ag
                                      ON ag.username = aa.createby
                               LEFT JOIN tr_claim ah
                                      ON ah.regid = aa.regid
                               LEFT JOIN ms_master ai
                                      ON ai.msid = ah.tmpkejadian   AND ai.mstype = 'tmpclm'
                               LEFT JOIN ms_master aj
                                      ON aj.msid = ah.penyebab      AND aj.mstype = 'sbbclm'
                               LEFT JOIN ms_master ak
                                      ON ak.msid = aa.asuransi      AND ak.mstype = 'asuransi'
                        WHERE  aa.regid = '$sregid'  ";
			//echo $sqlm;
			//die;
			
			$r1         = $db->query($sqlm)->fetch_assoc();
			$policyno   = $r1['regclaim'];
			$subprodid  = $r1['subprodid'];
			$membid     = $r1['membid'];
			$jtangung   = "MENURUN";
			$resiko     = "MENINGGAL DUNIA";
			$validdt    = "Jakarta , " . substr($r1['validdt'],0,10);
			?>
			<div class="juduls">
				<p align="center">No Claim. <?= $policyno; ?> </p> <br>
			</div>
	
			<table class="table_new">
				<tr>
					<td style="width: 40%">Produk/NO Register </td><td  style="width: 55%"><?= $r1['prodname'] . ' / ' .$r1['regid']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Nama/Nomor Peserta </td><td  style="width: 55%"><?= $r1['nama'] . ' / ' .$r1['nopeserta']; ?></td>
				</tr>

				<tr>
					<td style="width: 40%">Jns. Kelamin/Tanggal Lahir </td><td  style="width: 55%"><?= $r1['jkeldesc'] .'/' .tglindo_balik($r1['tgllahir']); ?></td>
				</tr>

				<tr>
					<td style="width: 40%">No KTP/Pekerjaan </td><td  style="width: 55%"><?= $r1['noktp'] . ' / ' . $r1['kerja']; ?></td>
				</tr>

				<tr>
					<td style="width: 40%">Masa Asuransi</td><td  style="width: 55%"><?= $r1['masa']. ' Bulan / ' . tglindo_balik($r1['mulai']) . ' S/D ' . tglindo_balik($r1['akhir']); ?></td>
				</tr>
				
				<tr>
					<td style="width: 40%">Jenis Pertanggungan </td><td  style="width: 55%"><?= $jtangung; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Resiko Yang Dijamin</td><td  style="width: 55%"><?= $resiko; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Uang Pertanggungan</td><td  style="width: 55%"><?= number_format($r1['up'],0); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Premi</td><td  style="width: 55%"><?= number_format($r1['premi'],0); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Asuransi  </td><td  style="width: 55%"><?= $r1['asuransi']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Cabang/Mitra/AO</td><td  style="width: 55%"><?= $r1['scab'] .' / '.  $r1['smitra']. '/ ' .$r1['aoname'] ; ?></td>
				</tr>

				
				<tr>
					<td style="width: 40%">Nilai OS </td><td  style="width: 55%"><?= number_format($r1['nilaios']); ?></td>
				</tr>

				<tr>
					<td style="width: 40%">Tgl. Laporan/Tgl. Input </td><td  style="width: 50%"><?= $r1['tgllapor'].'/'.$r1['createdt']; ?></td>
				</tr>
				
				<tr>
					<td style="width: 40%">No PK </td><td  style="width: 55%"><?= $r1['nopk']; ?></td>
				</tr>
				
				<tr>
					<td style="width: 40%">Penyebab  </td><td  style="width: 55%"><?= $r1['sebabclm']; ?></td>
				</tr>

				
			</table>
			<div class="juduls">
				<p align="center"> </p> <br>
			</div>
			<div class="table_body">
			
			<table class="table_new" style="width: 90%">
				<tr>
					<th align="center">No. </th>
					<th align="center" style="width: 35%;">Dokumen  </th>
					<th align="center" style="width: 10%;">Status </th>
					<th align="center" style="width: 10%;">Tgl Terima </th>
					<th align="center" style="width: 10%;">File</th>
					<th align="center" style="width: 20%;">Keterangan </th>
				</tr>
				<?php
				$sqld=" SELECT CONCAT(b.msdesc,IF(b.editby IS NULL,' (Pendukung)',' (Wajib)')) msdesc,
				               CASE
			                       WHEN c.jnsdoc IS NULL THEN 'Tidak Ada'
			                       ELSE 'Ada'
			                   END statdoc,
                               c.*
                        FROM   tr_claim a
                               INNER JOIN ms_master b
                                       ON b.mstype = a.doctype
                               LEFT JOIN tr_document c
                                      ON c.regid = a.regid
                                         AND c.jnsdoc = b.msid
                        WHERE  a.regid = '$sregid'
                               AND b.createby IS NULL
                               AND ( ( b.editby = 'wajib' AND c.jnsdoc IS NULL ) OR 
                                     ( b.editby = 'wajib' AND c.jnsdoc IS NOT NULL ) OR
                                     ( b.editby IS NULL   AND c.file IS NOT NULL )
                                   )";
				$sno=1;

				foreach($db->query($sqld) as $row) {
			
				?>
				<tr>
				
					<td align="center"><?= $sno; ?>  </td>
					<td style="width: 35%;"><?= $row['msdesc']; ?> </td>
					<td align="center" style="width: 10%;"><?= $row['statdoc']; ?> </td>
					<td align="center" style="width: 10%;"><?= $row['tglupload']; ?> </td>
					<td align="center" style="width: 20%;"><?= "<a href='https://docs.google.com/gview?url=https://siap-laku.com/bank/".$row['file']."&embedded=true'>".$row['nama_file'].".".$row['tipe_file']."</a>"; ?>  </td>
					<td style="width: 20%;"><?= $sremark; ?> </td>
				</tr>
				<?php
					$sno++;
				}
				 
				?>
				
				
				
			</table>
			
			</div>
			<?php
			    $res = $db->query(" SELECT IF (b.editby = 'wajib'
                                               AND c.jnsdoc IS NULL, 'Dokumen Belum Lengkap', NULL)
                                    FROM   tr_claim a
                                           INNER JOIN ms_master b
                                                   ON b.mstype = a.doctype
                                                      AND b.editby = 'wajib'
                                           LEFT JOIN tr_document c
                                                  ON c.regid = a.regid
                                                     AND c.jnsdoc = b.msid
                                    WHERE  a.regid = '$sregid'
                                           AND b.createby IS NULL
                                           AND c.jnsdoc IS NULL   ");
                if ($res->num_rows > 0) {
                    $ket = "Dokumen Belum Lengkap";
                } else {
                    $ket = "Dokumen Lengkap";
                }
			?>
			<div class="info">
				<p class="space"></p>
				<p align="justify">
				    <table border=1 class="ket">
				        <tr>
				            <td>
				                Ket: <br>
				                <h4><?= $ket ;?></h4>
				            </td>
				        </tr>
				    </table>
				</p>
				<p class="space"></p>
				<p class="space"></p>
			</div>
		

			<br><br><br><br>
			
		</div>
		<page_footer>
			<div class="" style="font-size:10px">
				Dicetak secara otomatis oleh <a href="https://siap-laku.com/bank/media.php?module=claim">SIAP</a> pada <?= date("d-m-Y H:i:s"); ?>
			</div>
		</page_footer>
	</body>
</html>