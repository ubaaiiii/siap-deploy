<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$q=$_POST['q'];
	
	$suid=$_POST['uid'];
	$slvl=$_POST['lvl'];
	$vlevel=$_POST['lvl'];
	$userid=$_POST['uid'];
	$aksi="modul/mod_checker/aksi_checker.php";
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
												<th>Produk</th>
												<th>Tenor</th>
												<th>No Pinjaman</th>
												<th>Cabang </th>
												<th></th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											
											
											
											if (strlen($q)>=3 and $vlevel=="checker" )
											{

											
											$sqlr="select '$q','$suid','$slvl',aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
											$sqlr= $sqlr . " ,cb.msdesc cabang,pd.msdesc produk,aa.masa from tr_sppa aa  ";
											$sqlr= $sqlr . "  left join ms_master cb on cb.msid=aa.cabang and cb.mstype='cab' ";
											$sqlr= $sqlr . "  left join ms_master pd on pd.msid=aa.produk and pd.mstype='produk' ";
											$sqlr= $sqlr . " where aa.status='11'  ";
											$sqlr= $sqlr . " and aa.cabang like  ( ";							
											$sqlr= $sqlr . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
											$sqlr= $sqlr . "from ms_admin where username='$userid' )";
											$sqlr= $sqlr . " and ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%'  ";
											$sqlr= $sqlr . " or aa.regid LIKE '%".$q."%' or aa.nopeserta LIKE '%".$q."%'   ";
											$sqlr= $sqlr . " or aa.produk LIKE '%".$q."%' or cb.msdesc LIKE '%".$q."%'   ";
											$sqlr= $sqlr . " or  aa.createby LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' )  ";

											}

											if (strlen($q)>=3 and $vlevel=="schecker" )
											{
											
											$sqlr="select '$q','$suid','$slvl',aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
											$sqlr= $sqlr . " ,cb.msdesc cabang,pd.msdesc produk,aa.masa from tr_sppa aa ";
											$sqlr= $sqlr . " left join ms_master cb on cb.msid=aa.cabang and cb.mstype='cab' ";
											$sqlr= $sqlr . "  left join ms_master pd on pd.msid=aa.produk and pd.mstype='produk' ";
											$sqlr= $sqlr . " where aa.status='2'  ";
											$sqlr= $sqlr . " and aa.cabang like  ( ";							
											$sqlr= $sqlr . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
											$sqlr= $sqlr . " from ms_admin where username='$userid' )";
											$sqlr= $sqlr . " and ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%'  ";
											$sqlr= $sqlr . " or aa.regid LIKE '%".$q."%' or aa.nopeserta LIKE '%".$q."%'   ";
											$sqlr= $sqlr . " or aa.produk LIKE '%".$q."%' or cb.msdesc LIKE '%".$q."%'   ";
											$sqlr= $sqlr . " or  aa.createby LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' )  ";

											}	
											
											if ($userid=="chkspm01")
											{
											$sqlr=$sqlr . " and aa.regid in (select regid from vw_tr_sppa_chkstf01 ) "; 
											}
											
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 100 ";
											
											/* echo $sqlr;  */
											
											$query=$db->query($sqlr);
											$num=$query->num_rows;
											$no=1;
											while($r=$query->fetch_array()){
											
										?>
                                            <tr>

											<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo tglindo_balik($r['tgllahir']); ?></td>
												<td><?php echo tglindo_balik($r['mulai']); ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo number_format($r['premi'],0); ?></td>
												<td><?php echo $r['produk']; ?></td>
												<td><?php echo $r['masa']; ?></td>
												<td><?php echo $r['nopeserta']; ?></td>
												<td><?php echo $r['cabang']; ?></td>
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=checker&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Edit</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="document" onclick="window.location='media.php?module=doc&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Doc</button>
												
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="sppa" onclick="window.location = 'laporan/sppa/f_sppa.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPPA</button>

												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=approve&&id=".$r['regid'] ."&&lvl=" . $vlevel ."&&uid=" . $userid  ; ?>'"><i class="fa fa-check-square"></i> Approve</button>
												
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=polhist&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Log</button>
												
												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="rollback" onclick="if (confirm('Yakin ingin Rollback data <?=$r['nama'];?>?')) { window.location='<?php echo $aksi."?module=rollback&&id=".$r['regid'] ."&&lvl=" .$vlevel."&&uid=" .$userid; ?>' ;}"><i class="fa fa-trash"></i> Rollback</button>
												
												<?php if (in_array($sdoc, $spd, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="SPD" onclick="window.location = 'laporan/spd/f_spd.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPD</button>
												<?php endif; ?>
												<?php if (in_array($sdoc, $skkt, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="SKKT" onclick="window.location = 'laporan/skkt/f_skkt.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SKKT</button>
												<?php endif; ?>
												<?php if (in_array($sdoc, $spm, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="SPM" onclick="window.location = 'laporan/spm/f_spm.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPM</button>
												<?php endif; ?>
												<?php if (in_array($sdoc, $med, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="medical" onclick="window.location = 'laporan/meda/f_meda.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> Med</button>
												<?php endif; ?>
												</th>
                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>