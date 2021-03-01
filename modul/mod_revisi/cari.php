<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_indotgl.php");
	$q=$_POST['q'];
	$aksi="modul/mod_revisi/aksi_revisi.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
												<th>No Revisi </th>
												<th>No Register </th>
                                                <th>Nama</th>
												<th>No. KTP</th>
												<th>Tgl Lahir</th>
												<th>UP</th>
												<th>Status</th>
												<th></th>

                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=5)
											{
												
											$sqlr="select ac.regrev,aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,ab.msdesc stat ";
											$sqlr= $sqlr . " from tr_sppa aa inner join ms_master ab on aa.status=ab.msid and ab.mstype='streq' ";
											$sqlr= $sqlr . " inner join tr_sppa_revisi ac on aa.regid=ac.regid ";
											$sqlr= $sqlr . "  ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' or aa.regid  LIKE '%".$q."%'  )  ";
																						
											}
											else 
											{
											$sqlr="select ac.regrev,aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,ab.msdesc stat ";
											$sqlr= $sqlr . " from tr_sppa aa inner join ms_master ab on aa.status=ab.msid and ab.mstype='streq' ";
											$sqlr= $sqlr . " inner join tr_sppa_revisi ac on aa.regid=ac.regid ";
											$sqlr= $sqlr . "  ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' or aa.regid  LIKE '%".$q."%'  )  ";
											}
											/* echo $sqlr; */
											
											$query=$db->query($sqlr);
											$num=$query->num_rows;
											$no=1;
											while($r=$query->fetch_array()){
											
										?>
                                            <tr>
												<td><?php echo $r['regid']; ?></td>
												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo $r['noktp']; ?></td>
												<td><?php echo $r['tgllahir']; ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo $r['stat']; ?></td>
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=revisi&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-edit"></i> Edit</button>
								
												</th>

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>