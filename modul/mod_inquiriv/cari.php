<?php
	session_start();
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$q=$_POST['q'];
	$userid=$_SESSION['idLog'];
	$aksi="modul/mod_inquiriv/aksi_inquiriv.php";
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
												<th>No Pinjaman</th>
												<th>Status</th>
												<th></th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=3)
											{
												
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up, ";
											$sqlr= $sqlr . " aa.premi,aa.cabang,aa.produk,ab.msdesc cab,aa.premi tpremi , ";
											$sqlr= $sqlr . " ac.msdesc proddesc,aa.mulai,ad.msdesc sts,aa.createby  from tr_sppa aa  ";
											$sqlr= $sqlr . " inner join ms_master ab on aa.cabang=ab.msid and ab.mstype='cab'";
											$sqlr= $sqlr . " inner join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' ";
											$sqlr= $sqlr . " inner join ms_master ad on aa.status=ad.msid and ad.mstype='STREQ' ";
											$sqlr= $sqlr . " where ( aa.nama LIKE '%".$q."%' or aa.regid LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' ";
											$sqlr= $sqlr . " or  aa.createby LIKE '%".$q."%'  )   ";
											$sqlr= $sqlr . "  and aa.asuransi in (select cabang from ms_admin  where level='insurance' and username='$userid' ) ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 100 ";
											
											}
											else 
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
											$sqlr= $sqlr . " from tr_sppa aa where aa.status='1' ";
											$sqlr= $sqlr . " and aa.nama='XXX'  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 100 ";
											}
											 /* echo $sqlr;  */
											
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
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
												<td><?php echo number_format($r['tpremi'],0); ?></td>
												<td><?php echo $r['nopeserta']; ?></td>
												<td><?php echo $r['sts']; ?></td>
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=inquiriv&&act=view&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> view</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=polhist&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Log</button>
												
												</th>

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>