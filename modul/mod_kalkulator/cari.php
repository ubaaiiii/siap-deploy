<?php
	session_start();
	$veid=$_SESSION['id_peg'];
	$vempname=$_SESSION['empname'];
	$vlevel=$_SESSION['idLevel'];
	$userid=$_SESSION['idLog'];
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$q=$_POST['q'];
	$aksi="modul/mod_ajuan/aksi_ajuan.php";
	if ($vlevel=="smkt"  )
		{
		$slevel="0" . "," . "1";
		}
	else 
		{
		$slevel="0";
		}	

?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
												<th>No Register </th>
                                                <th>Nama</th>
												<th>UP</th>
												<th>AO</th>
												<th></th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=3)
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi ";
											$sqlr= $sqlr . " ,aa.createby from tr_sppa aa where aa.status in ( $slevel ) ";
											$sqlr= $sqlr . " and ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' ";
											$sqlr= $sqlr . "  or aa.regid  LIKE '%".$q."%'  )  ";
											$sqlr= $sqlr . " and ";
											$sqlr= $sqlr . " aa.createby in ";
											$sqlr= $sqlr . " (select distinct case when a.parent=a.username ";
											$sqlr= $sqlr . " then a.parent else a.username end from ms_admin a ";
											$sqlr= $sqlr . " where (a.username='$userid' or a.parent='$userid')) ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											
											}
											else 
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi ";
											$sqlr= $sqlr . " ,aa.createby from tr_sppa aa where aa.status='1' ";
											$sqlr= $sqlr . " and aa.nama='XXX'  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											}
											/* echo  	$sqlr;  */
											
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											$scond = array('SMKT', 'smkt');
											$sfield = $vlevel;
											$scond1 = array('0','1');
											$sfield1 = $r['status'];
											
											$scond2 = array('11');
											$sfield2 = $r['status'];
										?>
                                            <tr>

												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo $r['createby']; ?></td>
												
                                                <th>
												<?php if (in_array($sfield1, $scond1, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=ajuan&&act=update&&id=".$r['regid']; ?>'"><i class="fa fa-trash"></i> Edit</button>
												<?php endif; ?>

												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="sppa" onclick="window.location = 'laporan/sppa/f_sppa.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPPA</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=polhist&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Log</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="document" onclick="window.location='media.php?module=doc&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Doc</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="photo" onclick="window.location='media.php?module=photo&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Photo</button>
												<?php if (in_array($sfield, $scond, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=approve&&id=".$r['regid']; ?>'"><i class="fa fa-trash"></i> Approve</button>
												<?php endif; ?>
												</th>

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>