<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_indotgl.php");
	date_default_timezone_set('Asia/Jakarta');
	$sboxid=$_GET['id'];
	
	$sqle="select aa.* ";
	$sqle= $sqle . " from tr_bordero aa ";
	$sqle= $sqle . " where aa.borderono='$sboxid'";
	$query=mysql_query($sqle);
	$r=mysql_fetch_array($query);


	$spolicyno="";
	$speriod=$r['period1'] . ' s/d ' .  $r['period2'] ;
	$spolholder="Bank Bukopin";
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
			padding: 10px 10px 10px 10px;
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
			padding: 20px 10px 10px 0px;
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
			 font-size: 10px;
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

			<p class="space"></p>
			<div class="juduls">
				<p align="center">DAFTAR PESERTA ASURANSI KREDIT MULTIGUNA (ASKRED)  </p> <br>
				<p align="left">Bordero No : <?php echo $sboxid; ?></p><br>
				<p align="left">No Polis : <?php echo $spolicyno; ?></p><br>
				<p align="left">Pemegang Polis : <?php echo $spolholder; ?></p><br>
				<p align="left">Periode : <?php echo $speriod; ?></p><br>

			</div>
			<table class="table_new">
				<tr>
					<td style="width: 9%">No. reg</td>
					<td style="width: 20%">Nama</td>
					<td style="width: 5%">JK</td>
					<td style="width: 8%">Tgl.Lahir</td>
					<td style="width: 8%">No PK</td>
					<td style="width: 12%">No KTP</td>
					<td style="width: 8%">Mulai</td>
					<td style="width: 8%">Akhir</td>
					<td style="width: 5%">Masa</td>
					<td style="width: 8%">UP</td>
					<td style="width: 8%">Premi</td>
				</tr>
			</table>
			<?php

			// header transaction
			$sqlm="SELECT a.*,b.nama,b.cabang,b.up,b.tpremi,concat(a.borderono,a.regid) sbordero,b.noktp, ";
			$sqlm= $sqlm . " b.mulai,b.akhir,b.nopeserta,b.jkel,b.tgllahir,b.mulai,b.akhir,b.masa ";
			$sqlm= $sqlm . " from tr_bordero_dtl a left join tr_sppa b on a.regid=b.regid ";
			//echo $sqlm;
			$query=mysql_query($sqlm);
			$num=mysql_num_rows($query);
			$no=1;
			while($r=mysql_fetch_array($query)){
			?>

			<table class="table_new">
				<tr>
					<td style="width: 9%"><?php echo $r['regid']; ?></td>
					<td style="width: 20%"><?php echo $r['nama']; ?></td>
					<td style="width: 5%"><?php echo $r['jkel']; ?></td>
					<td style="width: 8%"><?php echo $r['tgllahir']; ?></td>
					<td style="width: 8%"><?php echo $r['nopeserta']; ?></td>
					<td style="width: 12%"><?php echo $r['noktp']; ?></td>
					<td style="width: 8%"><?php echo $r['mulai']; ?></td>
					<td style="width: 8%"><?php echo $r['akhir']; ?></td>
					<td style="width: 5%"><?php echo $r['masa']; ?></td>
					<td style="width: 8%"><?php echo number_format($r['up'],0); ?></td>
					<td style="width: 8%"><?php echo number_format($r['tpremi'],0); ?></td>
				</tr>
			</table>
			<?php
				}
			?>
			
			<div class="juduls">
				<p align="Left"></p><br> 
				<p align="Left">Jakarta <?php echo date("d-m-Y"); ?></p><br> 
				<p align="left">PT. Bina Dana Sejahtera</p><br>
				<p align="left"></p><br>
				<p align="left"></p><br>
				<p align="left"></p><br>
				<p align="left">____________________</p> <br>

			</div>
		</div>
		<page_footer>
			
			<div class="" style="font-size:10px">
				Dicetak secara otomatis pada system pada <?php echo date("d-m-Y H:i:s"); ?>
			</div>
		</page_footer>
	</body>
</html>
