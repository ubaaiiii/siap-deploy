<?php
	session_start();
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$veid=$_SESSION['id_peg'];
	$vempname=$_SESSION['empname'];
	$vlevel=$_SESSION['idLevel'];
	$userid=$_SESSION['idLog'];
	
	$q=$_POST['q'];
	$aksi="modul/mod_cancel/aksi_cancel.php";
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
												
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,";
											$sqlr= $sqlr . " aa.mulai,ac.msdesc stscan,aa.status sts ";
											$sqlr= $sqlr . " from tr_sppa aa inner join tr_sppa_cancel ab on aa.regid=ab.regid ";
											$sqlr= $sqlr . " left join ms_master ac on ac.msid=aa.status and ac.mstype='STREQ' ";
											$sqlr= $sqlr . " where  ";
											$sqlr= $sqlr . " ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' or aa.regid  LIKE '%".$q."%'  )  ";
											
											
											}
											else 
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,";
											$sqlr= $sqlr . " aa.mulai,ac.msdesc stscan,aa.status sts ";
											$sqlr= $sqlr . " from tr_sppa aa inner join tr_sppa_cancel ab on aa.regid=ab.regid ";
											$sqlr= $sqlr . " left join ms_master ac on ac.msid=aa.status and ac.mstype='STREQ' ";
											$sqlr= $sqlr . " where aa.nama='XXX'  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											}
											
											if ($vlevel=="schecker" or $vlevel=="checker" )
											{
												$sqlr= $sqlr . " and aa.status='7' or aa.status='8' ";
												$sqlr= $sqlr . " and  aa.cabang in (select cabang from ms_admin  where username='$userid' ) ";
											}
											
											if ($vlevel=="broker"   )
											{
												$sqlr= $sqlr . " and aa.status='71'  or aa.status='81'";
											}
											
											if ($vlevel=="insurance"   )
											{
												$sqlr= $sqlr . " and aa.status='72'  or aa.status='82'";
												$sqlr= $sqlr . " and  aa.asuransi in (select cabang from ms_admin  where level='insurance' and username='$userid' ) ";
											}
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											/* echo $sqlr; */
											
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											$scond = array( 'schecker');
											$sfield = $vlevel;
											$scond1 = array( 'broker');
											$sfield1 = $vlevel;
											$scond2 = array( 'insurance');
											$sfield2 = $vlevel;
											
											$scond3 = array( '7','71','8','81');
											$sfield3 = $r['sts'];
										?>
                                            <tr>

												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo tglindo_balik($r['tgllahir']); ?></td>
												<td><?php echo tglindo_balik($r['mulai']); ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo number_format($r['premi'],0); ?></td>
												<td><?php echo $r['stscan']; ?></td>
                                                <th>
												<?php if (in_array($sfield3, $scond3, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=cancel&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Edit</button>
												<?php endif; ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=cancel&&act=view&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> View</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="document" onclick="window.location='media.php?module=doc&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Doc</button>
												<?php if (in_array($sfield, $scond, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=approve&&id=".$r['regid']; ?>'"><i class="fa fa-trash"></i> Approve</button>
												<?php endif; ?>
												<?php if (in_array($sfield1, $scond1, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=appbro&&id=".$r['regid']; ?>'"><i class="fa fa-trash"></i> Approve</button>
												<?php endif; ?>
												<?php if (in_array($sfield2, $scond2, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=appins&&id=".$r['regid']; ?>'"><i class="fa fa-trash"></i> Approve</button>
												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=rollback&&id=".$r['regid']; ?>'"><i class="fa fa-trash"></i> Rollback</button>
												<?php endif; ?>
												
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="sppa" onclick="window.location = 'laporan/batal/f_batal.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> Form</button>
												</th>


                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>