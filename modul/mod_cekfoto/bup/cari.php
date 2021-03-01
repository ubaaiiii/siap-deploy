<?php
include ("../../config/koneksi.php");
include ("../../config/fungsi_all.php");
$q=$_POST['q'];
$aksi="modul/mod_cekfoto/aksi_cekfoto.php";
?>
<table class="table table-bordered">
	<thead>
		<tr>

			<th>Cabang </th>
			<th>Produk </th>
			<th>No Register </th>
			<th>Nama</th>
			<th>UP</th>
			<th></th>

		</tr>
	</thead>
	<tbody>
		<?php
		if (strlen($q)>=5)
		{
			$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai, ";
			$sqlr= $sqlr . " ab.msdesc cab ,ac.msdesc proddesc,aa.createby from tr_sppa aa ";
			$sqlr= $sqlr . " left join ms_master ab on aa.cabang=ab.msid and ab.mstype='cab' ";
			$sqlr= $sqlr . " left join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' ";
			$sqlr= $sqlr . " left join (select regid from tr_sppa_log where  status=13) ad on aa.regid = ad.regid ";
			$sqlr= $sqlr . " where aa.status='1' ";
			$sqlr= $sqlr . " and ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' or aa.regid  LIKE '%".$q."%'  ) ";
			$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";

		}
		else
		{
			$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi ";
			$sqlr= $sqlr . " from tr_sppa aa where aa.status='1' ";
			$sqlr= $sqlr . " and aa.nama='XXX'  ";
			$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
		}
		/* echo $sqlr; */

		$query=mysql_query($sqlr);
		$num=mysql_num_rows($query);
		$no=1;
		while($r=mysql_fetch_array($query)){

			?>
			<tr>
				<td><?php echo $r['cab']; ?></td>
				<td><?php echo $r['proddesc']; ?></td>
				<td><?php echo $r['regid']; ?></td>
				<td><?php echo $r['nama']; ?></td>
				<td><?php echo number_format($r['up'],0); ?></td>


				<th>
					<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=cekfoto&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Edit</button>

					<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Revisi" onclick="window.location='media.php?module=cekfoto&&act=revisi&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Revisi</button>

					<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="sppa" onclick="window.location = 'laporan/sppa/f_sppa.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPPA</button>
					<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=polhist&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Log</button>


					<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=approve&&id=".$r['regid']; ?>'"><i class="fa fa-check-square"></i> Approve</button>
					<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Reject" onclick="window.location='<?php echo $aksi."?module=reject&&id=".$r['regid']; ?>'"><i class="fa fa-trash"></i> Reject</button>
				</th>

			</tr>
			<?php

		}
		?>
	</tbody>
</table>
