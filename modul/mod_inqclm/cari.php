<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$q=$_POST['q'];
	$aksi="modul/mod_inquiry/aksi_inquiry.php";
?>
	<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
												<th>No Register </th>
                                                <th>Nama</th>
												<th>Tgl Lahir</th>
												<th>Mulai</th>
												<th>UP</th>
												<th>Premi</th>
												<th>Status</th>
												<th></th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=3)
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai,ab.msdesc ";
											$sqlr= $sqlr . " from tr_sppa aa  inner join ms_master ab ";
											$sqlr= $sqlr . " on aa.status=ab.msid and ab.mstype='STREQ' ";
											$sqlr= $sqlr . " where ( aa.nama LIKE '%".$q."%' or aa.regid LIKE '%".$q."%' ";
											$sqlr= $sqlr . " or aa.noktp LIKE '%".$q."%' ) and aa.status in ('5','6','7','20') ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 20 ";
											
											}
											else 
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
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

												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo tglindo_balik($r['tgllahir']); ?></td>
												<td><?php echo tglindo_balik($r['mulai']); ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo number_format($r['tpremi'],0); ?></td>
												<td><?php echo $r['msdesc']; ?></td>
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=inqclm&&act=view&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> view</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=claim&&act=addclm&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Claim</button>
												</th>

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>