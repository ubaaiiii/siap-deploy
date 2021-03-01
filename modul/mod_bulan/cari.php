<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_indotgl.php");
	$q=$_POST['q'];
	$aksi="modul/mod_policy/aksi_policy.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
												<th>No Peserta </th>
                                                <th>Nama</th>
												<th>No. KTP</th>
												<th>Tgl Lahir</th>
												<th>UP</th>
												<th></th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=5)
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi ";
											$sqlr= $sqlr . " from tr_sppa aa where aa.status='1' ";
											$sqlr= $sqlr . " and ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' )  ";
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

												<td><?php echo $r['nopeserta']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo $r['noktp']; ?></td>
												<td><?php echo $r['tgllahir']; ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=ajuan&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Edit</button>
												</th>

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>