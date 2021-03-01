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
			$sqlm   = "select aa.*,ab.msdesc jkeldesc,ac.msdesc kerja,aa.cabang,aa.mitra,aa.createby,  ";
			$sqlm  .= " ah.nopk,ah.nilaios, ah.penyebab,ah.tglkejadian, aj.msdesc sebabclm,ai.msdesc tmpjadi, ";
			$sqlm  .= " aa.createdt,aa.produk,ad.msdesc prodname,ae.msdesc scab,af.msdesc smitra ,ag.nama aoname,ah.regclaim,ak.msdesc asuransi,ah.tgllapor ";
			$sqlm  .= " from tr_sppa aa inner join ms_master ab on aa.jkel=ab.msid and ab.mstype='JKEL' ";
			$sqlm  .= " left join  ms_master ac on aa.pekerjaan=ac.msid and ac.mstype='kerja'  ";
			$sqlm  .= " left join  ms_master ad on aa.produk=ad.msid and ad.mstype='PRODUK'";
			$sqlm  .= " left join  ms_master ae on aa.cabang=ae.msid and ae.mstype='cab'";
			$sqlm  .= " left join  ms_master af on aa.mitra=af.msid and af.mstype='mitra'";
			$sqlm  .= " left join  ms_admin ag on ag.username=aa.createby ";
			$sqlm  .= " left join  tr_claim ah on ah.regid=aa.regid ";
			$sqlm  .= " left join  ms_master ai on ai.msid=ah.tmpkejadian and ai.mstype='tmpclm' ";
			$sqlm  .= " left join  ms_master aj on aj.msid=ah.penyebab and aj.mstype='sbbclm' ";
			$sqlm  .= " left join  ms_master ak on ak.msid=aa.asuransi and ak.mstype='asuransi' ";
			$sqlm  .= " where aa.regid='$sregid' ";
			//echo $sqlm;
			
			$r1         = $db->query($sqlm)->fetch_assoc();
			$policyno   = $r1['regclaim'];
			$subprodid  = $r1['subprodid'];
			$membid     = $r1['membid'];
			$jtangung   = "MENURUN";
			$resiko     = "MENINGGAL DUNIA";
			$validdt    = "Jakarta , " . substr($r1['validdt'],0,10);
			?>
			<div class="juduls">
				<p align="center">No Claim. <?php echo $policyno; ?> </p> <br>
			</div>
	
			<table class="table_new">
				<tr>
					<td style="width: 40%">Produk/NO Register </td><td  style="width: 55%"><?php echo $r1['prodname'] . ' / ' .$r1['regid']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Nama/Nomor Peserta </td><td  style="width: 55%"><?php echo $r1['nama'] . ' / ' .$r1['nopeserta']; ?></td>
				</tr>

				<tr>
					<td style="width: 40%">Jns. Kelamin/Tanggal Lahir </td><td  style="width: 55%"><?php echo $r1['jkeldesc'] .'/' .tglindo_balik($r1['tgllahir']); ?></td>
				</tr>

				<tr>
					<td style="width: 40%">No KTP/Pekerjaan </td><td  style="width: 55%"><?php echo $r1['noktp'] . ' / ' . $r1['kerja']; ?></td>
				</tr>

				<tr>
					<td style="width: 40%">Masa Asuransi</td><td  style="width: 55%"><?php echo $r1['masa']. ' Bulan / ' . tglindo_balik($r1['mulai']) . ' S/D ' . tglindo_balik($r1['akhir']); ?></td>
				</tr>
				
				<tr>
					<td style="width: 40%">Jenis Pertanggungan </td><td  style="width: 55%"><?php echo $jtangung; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Resiko Yang Dijamin</td><td  style="width: 55%"><?php echo $resiko; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Uang Pertanggungan</td><td  style="width: 55%"><?php echo number_format($r1['up'],0); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Premi</td><td  style="width: 55%"><?php echo number_format($r1['premi'],0); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Asuransi  </td><td  style="width: 55%"><?php echo $r1['asuransi']; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Cabang/Mitra/AO</td><td  style="width: 55%"><?php echo $r1['scab'] .' / '.  $r1['smitra']. '/ ' .$r1['aoname'] ; ?></td>
				</tr>

				
				<tr>
					<td style="width: 40%">Nilai OS </td><td  style="width: 55%"><?php echo number_format($r1['nilaios']); ?></td>
				</tr>

				<tr>
					<td style="width: 40%">Tgl. Laporan/Tgl. Input </td><td  style="width: 50%"><?php echo $r1['tgllapor'].'/'.$r1['createdt']; ?></td>
				</tr>
				
				<tr>
					<td style="width: 40%">No PK </td><td  style="width: 55%"><?php echo $r1['nopk']; ?></td>
				</tr>
				
				<tr>
					<td style="width: 40%">Penyebab  </td><td  style="width: 55%"><?php echo $r1['sebabclm']; ?></td>
				</tr>

				
			</table>
			<div class="juduls">
				<p align="center"> </p> <br>
			</div>
			<div class="table_body">
			
			<table class="table_new" style="width: 90%">
				<tr>
					<td style="width: 5%;">No  </td>
					<td align="center" style="width: 35%;">Dokumen  </td>
					<td align="center" style="width: 10%;">Status </td>
					<td align="center" style="width: 10%;">Tgl Terima </td>
					<td align="center" style="width: 10%;">File</td>
					<td style="width: 20%;">Keterangan </td>
				</tr>
				<?php
				$sqld=" SELECT a.msdesc,
                               b.*,
                               CASE
                                 WHEN b.jnsdoc IS NULL THEN 'tidak ada'
                                 ELSE 'ada'
                               end statdoc
                        FROM   (SELECT msdesc,
                                       msid
                                FROM   ms_master
                                WHERE  mstype IN (SELECT doctype
                                                  FROM   tr_claim
                                                  WHERE  regid = '$sregid')
                                       AND createby IS NULL) a
                               LEFT JOIN tr_document b
                                      ON b.jnsdoc = a.msid
                                         AND b.regid = '$sregid'  ";
				$sno=1;

				
				
				foreach($db->query($sqld) as $row) {
			
				?>
				<tr>
				
					<td style="width: 3%;"><?php echo $sno; ?>  </td>
					<td style="width: 35%;"><?php echo $row['msdesc']; ?> </td>
					<td align="right" style="width: 12%;"><?php echo $row['statdoc']; ?> </td>
					<td align="right" style="width: 12%;"><?php echo $row['tglupload']; ?> </td>
					<td align="right" style="width: 20%;"><?php echo "<a href='https://docs.google.com/gview?url=https://siap-laku.com/bank/".$row['file']."&embedded=true'>".$row['nama_file']."</a>"; ?>  </td>
					<td style="width: 20%;"><?php echo $sremark; ?> </td>
				</tr>
				<?php
					$sno++;
				}
				 
				?>
				
				
				
			</table>
			
			</div>
			<?php
			    $res = $db->query(" SELECT    a.regid,
                                              IF (d.uploaded >= c.jmldokumen,
                                                    'Dokumen Lengkap',
                                                    'Dokumen Belum Lengkap') ket
                                    FROM      `tr_claim` a
                                    
                                    LEFT JOIN tr_sppa b
                                    ON        a.regid = b.regid
                                    
                                    LEFT JOIN ( SELECT   mstype,
                                                         Count(msid) 'jmldokumen'
                                                FROM     ms_master
                                                WHERE    mstype LIKE 'CL%'
                                                AND      createby IS NULL
                                                GROUP BY mstype) c
                                    ON        c.mstype = a.doctype
                                    
                                    LEFT JOIN ( SELECT   regid,
                                                         count(regid) 'uploaded'
                                                FROM     tr_document
                                                WHERE    catdoc='CLM'
                                                GROUP BY regid) d
                                    ON        d.regid = b.regid
                                    WHERE     b.regid = '$sregid' ");
                $res = $res->fetch_assoc();
			?>
			<div class="info">
				<p class="space"></p>
				<p align="justify">
				    <table border=1 class="ket">
				        <tr>
				            <td>
				                Ket: <br>
				                <h4><?= $res['ket'] ;?></h4>
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
				Dicetak secara otomatis pada system pada <?php echo date("d-m-Y H:i:s"); ?>
			</div>
		</page_footer>
	</body>
</html>