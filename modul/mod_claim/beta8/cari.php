<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_indotgl.php");
	$q=$_POST['q'];
	$aksi="modul/mod_policy/aksi_policy.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
												<th>No Claim </th>
                                                <th>No Register</th>
												<th>Nama</th>
												<th>Tgl Lapor</th>
												<th>Tgl Kejadian</th>
												<th>UP</th>
												<th>Status</th>
												<th></th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=3)
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,";
											$sqlr= $sqlr . " ab.tgllapor,ab.tglkejadian,ac.msdesc stsclm, ";
											$sqlr= $sqlr . " ab.regclaim from tr_sppa aa inner join tr_claim ab on ab.regid=aa.regid ";
											$sqlr= $sqlr . " inner join ms_master ac on ac.msid=aa.status ";
											$sqlr= $sqlr . " and ac.mstype='STREQ' ";
											$sqlr= $sqlr . " where  ";
											$sqlr= $sqlr . "  ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' )  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											
											}
											else 
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi, ";
											$sqlr= $sqlr . " ab.regclaim,ab.tgllapor,ab.tglkejadian  from tr_sppa aa where aa.status='1' ";
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

												<td><?php echo $r['regclaim']; ?></td>
                                                <td><?php echo $r['regid']; ?></td>
												<td><?php echo $r['nama']; ?></td>
												<td><?php echo $r['tgllapor']; ?></td>
												<td><?php echo $r['tglkejadian']; ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo $r['stsclm']; ?></td>
												
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=claim&&act=update&&id=<?php echo $r['regclaim']; ?>'"><i class="fa fa-search"></i> Edit</button>
												<?php if (in_array($sfield, $scond, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=approve&&id=".$r['regclaim']; ?>'"><i class="fa fa-trash"></i> Approve</button>
												<?php endif; ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="cek list " onclick="window.location = 'laporan/claim/f_claim.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> List</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="document" onclick="window.location='media.php?module=docclaim&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Doc</button>
												</th>

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>