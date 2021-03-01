<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$q=$_POST['q'];
	$aksi="modul/mod_policy/aksi_policy.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
												<th>Cabang </th>
											    <th>Produk </th>
												<th>AO </th>
												<th>No Register </th>
                                                <th>Nama</th>
												<th>Tgl Lahir</th>
												<th>Mulai</th>
												<th>UP</th>
												<th>Premi</th>
												<th></th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=5)
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai, ";
											$sqlr= $sqlr . " ab.msdesc cab ,ac.msdesc proddesc,aa.createby from tr_sppa aa ";
											$sqlr= $sqlr . " left join ms_master ab on aa.cabang=ab.msid and ab.mstype='cab'";
											$sqlr= $sqlr . " left join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' ";
											$sqlr= $sqlr . " where aa.status='3' ";
											$sqlr= $sqlr . " and ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' or aa.regid LIKE '%".$q."%' or aa.createby LIKE '%".$q."%' )  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											
											}
											else 
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi ";
											$sqlr= $sqlr . " from tr_sppa aa where aa.status='3' ";
											$sqlr= $sqlr . " and aa.nama='XXX'  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											}
											/* echo $sqlr; */
											
											$query=$db->query($sqlr);
											$num=$query->num_rows;
											$no=1;
											while($r=$query->fetch_array()){
											
										?>
                                            <tr>
												<td><?php echo $r['cab']; ?></td>
												<td><?php echo $r['proddesc']; ?></td>
												<td><?php echo $r['createby']; ?></td>
												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo tglindo_balik($r['tgllahir']); ?></td>
												<td><?php echo tglindo_balik($r['mulai']); ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo number_format($r['premi'],0); ?></td>
												
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="window.location='media.php?module=verif&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-check-square"></i> Verif</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Reject" onclick="window.location='media.php?module=verif&&act=reject&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-trash"></i> Reject</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="rollback" onclick="window.location='media.php?module=verif&&act=rollback&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Rollback</button>
												</th>


                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>