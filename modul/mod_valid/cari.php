<?php
	session_start();
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$ucab=$_SESSION['ucab'];
	$userid=$_SESSION['idLog'];
	$q=$_POST['q'];
	$aksi="modul/mod_valid/aksi_valid.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
												<th>Produk </th>
											    <th>Cabang </th>
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
											if (strlen($q)>=3)
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai, ";
											$sqlr= $sqlr . " ac.msdesc proddesc, ab.msdesc cab from tr_sppa aa ";
											$sqlr= $sqlr . " left join ms_master ab on aa.cabang=ab.msid and ab.mstype='cab'";
											$sqlr= $sqlr . " left join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' "; 
											$sqlr= $sqlr . "  where aa.status IN ('4','10') ";
											$sqlr= $sqlr . " and ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%'  ";
											$sqlr= $sqlr . " or aa.regid LIKE '%".$q."%' or aa.nopeserta LIKE '%".$q."%'   ";
											$sqlr= $sqlr . " or  aa.createby LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' )  ";
											$sqlr= $sqlr . "  and aa.asuransi in (select cabang from ms_admin  where level='insurance' and username='$userid' ) ";  
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											
											}
											else 
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi ";
											$sqlr= $sqlr . " from tr_sppa aa where aa.status='1' ";
											$sqlr= $sqlr . " and aa.nama='XXX'  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											}
											/* echo $sqlr;  */
											
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>

												<td><?php echo $r['proddesc']; ?></td>
												<td><?php echo $r['cab']; ?></td>				
												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo tglindo_balik($r['tgllahir']); ?></td>
												<td><?php echo tglindo_balik($r['mulai']); ?></td>
												<td><?php echo number_format($r['up']); ?></td>
												<td><?php echo number_format($r['premi']); ?></td>
												
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Validasi" onclick="window.location='media.php?module=valid&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-check-square"></i> Validasi</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Validasi" onclick="window.location='media.php?module=valid&&act=reject&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-times-circle"></i> Reject</button>
												
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="rollback" onclick="window.location='media.php?module=valid&&act=rollback&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-recycle"></i> Rollback</button>
												</th>

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>