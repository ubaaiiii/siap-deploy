<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	date_default_timezone_set('Asia/Jakarta');
	$spolicyno=$_GET['id'];
	?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../img/laporan.png">
<link rel="stylesheet" type="text/css" href="../../css/laporan.css">
<style>
		.logo{	
			width:300px;
			hight:80px;
			margin: 10px 50px 10px 10px;
		}
		.kop{
			border-collpase:collapse;
		}
		.kop .header{
			width:130px;
		}
		.kop .judul{
			text-align:right;
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
			margin : 20px 0px;
			padding-right: 220px;
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
		.tbl_lap3 .cel1{			width:300px;		}
		.tbl_lap3 .cel2{			width:100px;		}		
		.tbl_lap3 .cel3{
			width:300px;		}
		.table_new{			border-collapse: collapse;		}		.table_new td{			padding: 5px 10px 5px 10px;			font-size:9;		 }		.table_new, .table_new th, .table_new td {    		border: 1px solid black;		}
		</style>
	</head>
	<body>
		<div class="page">
			<td class="l">
						<img src="../../images/logoinv.png" class="logo" >
			</td>
			<div class="kop">
			<table class="kop">
			<tr>
				<td  class="judul" >
				<?php

						$ssql="select a.billno,date_format(a.billdt,'%d-%m-%Y') billdt from tr_billing a where a.policyno='$spolicyno' ";

						$query=mysql_query($ssql);
						$r=mysql_fetch_array($query);
						$sbillno=$r['billno'];
						$sbilldt=$r['billdt'];
				?>
							<H3></H3>
							<H3 align="right">Credit NOTES</H3>
							
				</td>
			</tr>
				
				<tr>
					<td class="cel1"><b><?php echo ' No Nota  :  ' . $sbillno;?></b> </td>
				</tr>
				<tr>
					<td class="cel1"><b><?php echo ' Tgl/Date : ' . $sbilldt;?> </b></td>
				</tr>
			</table>
		</div>
		<div class="garis">
			<hr class="line1"/>
			<hr class="line2"/>
		</div>
		<?php
				$sbillno=$_GET['billno'];
				$ssql="select a.policyno,'Bank Bukopin' sclientname,nama clientname, 'Asuranis Kredit' object, ";
				$ssql= $ssql . "  a.mulai effdt,a.akhir expdt , 'Asuransi Kredit ' instype, grossamt ,totalamt ";
				$ssql= $ssql . " ,c.msdesc  object,a.up,a.masa,a.regid ,b.remark  from tr_sppa a inner join tr_billing b on a.policyno=b.policyno ";
				$ssql= $ssql . " inner join ms_master c on c.msid=a.produk and c.mstype='produk' ";
				$ssql= $ssql . " where a.policyno='$spolicyno' and b.grossamt<0 ";
				//echo $sqlm;
			$query1=mysql_query($ssql);
			$c=mysql_fetch_array($query1);
			?>
						<table>
							<tr><br><br>
								<td class="cel1">Kepada
								<br>								To								<br>
								<br> 								No Register 
								<br>								Register No 
								<br>
								<br> 								No Sertifikat 
								<br>								Certificate No 
								<br>
								<br>								Nama Tertanggung 
								<br>								Name of Insured 
								<br>
								<br>								Jenis Asuransi 
								<br>								Class of business  
								<br>
								<br>								Jangka waktu 
								<br>								Period 
								<br>
								<br>								Objeck Asuransi 
								<br>								Interest Insured 
								<br>
								<br>								Uang Pertanggungan 
								<br>								Sum Insured 
								<br>
								<br>								
								</td>
								<td class="cel3"> <?php echo ' : ' . $c['sclientname'];?>
								<br><?php echo ' : ' . $c['address1'] . ' ' . $c['address2'] . ' ' .  $c['address3'];?>
								<br>
								<br><?php echo ' : ' .  $c['regid']  ;?>
								<br>
								<br>
								<br><?php echo ' : ' .  $c['policyno'] .  $c['sreffno'] ;?>
								<br>
								<br>
								<br><?php echo ' : ' . $c['clientname'] ;?>
								<br>
								<br>
								<br><?php echo ' : ' . $c['instype'] ;?>
								<br>
								<br>
								<br><?php echo ' : ' . $c['masa'] . ' bulan / ' . $c['effdt'] .' sd ' . $c['expdt'] ;?>
								<br>
								<br>
								<br><?php echo ' : ' . $c['object'] ;?>
								<br>
								<br>
								<br><?php echo ' : ' . number_format($c['up'],0) ;?><br><br><br>
								<br>
								</td>
							</tr>
						</table>
			<table class="table_new" style="width:95%">
				<tr>					
				<td style="width:35%">    <b>          Catatan/Notes</b></td>					
				<td style="width:30%" colspan="2"><b>Perincian/Detail</b></td>									
				</tr>				
				<tr>					
				<td rowspan="14"> 
				<i>Jumlah tersebut dalam Nota Debet ini hendaknya segera 					dibayar untuk penyelesaian transaksi. <br>
				Harap pembayaran dilakukan dengan cheque silang (crossed cheque) atas nama  <br>
				PT. BINA DANA SEJAHTERA atau dipindahbukukan pada rekening giro  <br> 					
				di salah satu Bank berikut ini :<br> 					
				Please pay the amount shown in this Debit Note immediately to finalize the transaction. <br> 					
				Payment should be made with a crossed cheque in the name <br> 					
				PT. BINA DANA SEJAHTERA or transferred to our current account  <br> 					
				with one of  the following bank : 
				<br> <br> <br>					- Bank Bukopin Cabang S. Parman Acc. No. 100.1409.430 - IDR<br> <br> <br> <br>					
				<?php echo  $c['remark'];?><br><br><br>					</i>
				</td>					
				<td >Premi : </td>					<td  rowspan="2"><?php echo number_format($c['grossamt'],0); ?></td>				</tr>				<tr><td >Premium</td></tr>
				<tr><td >Premi Tambahan : </td>
				<td rowspan="2"><?php echo number_format($c['discamt'],0); ?></td>
				</tr>
				<tr><td >Extra Premium</td></tr>
				<tr><td >Biaya Polis : </td><td rowspan="2"><?php echo number_format($c['discamt'],0); ?></td>				</tr>				<tr>									
				<td >Policy Cost</td></tr>								
				<tr>	<td >Biaya Meterai : </td>					
				<td rowspan="2"><?php echo number_format($c['discamt'],0); ?></td>				</tr>				<tr>										<td >Duty Cost</td>									</tr>				<tr>										<td >+/- : </td>					<td rowspan="2"><?php echo number_format($c['discamt'],0); ?></td>				</tr>				<tr>					<td>+/- : </td>				</tr>				<tr>					<td >Jumlah : </td>					<td rowspan="2"><?php echo number_format($c['totalamt'],0); ?></td>				</tr>				<tr>					<td >Total</td>				</tr>						<tr>					<td  colspan="2" >PT. BINA DANA SEJAHTERA </td>									</tr>
			</table>
			<p class="space"></p>
			<table >				<tr>					<td >Nota Debet ini bukan merupakan tanda bukti pembayaran.</td>				</tr>								<tr>					<td >This Debit Note is not a receipt.</td>				</tr>			</table>
		</div>
		<page_footer>
			Printed <?php echo date("d-m-Y H:i:s"); ?>
		</page_footer>
	</body>
</html>