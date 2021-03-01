<?php
	session_start();
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$q = $_POST['q'];
	$sdate = $_POST['dateall'];
	/* $sdate = '03/01/2011 - 03/30/2019'; */
	$searchproduct=$_POST['searchproduk'];
	$aksi="modul/mod_checkpro/aksi_checkpro.php";
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
												<th></th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											
											$sqlm="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi ";
											$sqlm= $sqlm . " ,aa.mulai,aa.akhir from tr_sppa aa where aa.status in ('2','3') ";
											$sqlm= $sqlm . " and ( aa.nama LIKE '%".$q."%' ";
											$sqlm= $sqlm . "  or aa.noktp LIKE '%".$q."%' or aa.regid  LIKE '%".$q."%'  )  ";
										
										    if($sdate!=""){
													$sqlm=$sqlm ." and date_format(aa.mulai, '%Y-%m-%d') between  date_format(str_to_date(substring('$sdate',1,10),'%m/%d/%Y'),'%Y-%m-%d') and date_format(str_to_date(substring('$sdate' from 13),'%m/%d/%Y'),'%Y-%m-%d') ";
											} 
											/*if($searchproduct != 'null'){
													$sqlm=$sqlm ." and aa.providerid='$searchproduct' ";
											} */
/* 											if (strlen($q)>=3)
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi ";
											$sqlr= $sqlr . " ,aa.mulai,aa.akhir from tr_sppa aa where aa.status in ('2','3') ";
											$sqlr= $sqlr . " and ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' or aa.regid  LIKE '%".$q."%'  )  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											
											}
											else 
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi ";
											$sqlr= $sqlr . " ,aa.mulai,aa.akhir from tr_sppa aa where aa.status='21' ";
											$sqlr= $sqlr . " and aa.nama='XXX'  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											} */
											echo $sdate; 
											
											$query=mysql_query($sqlm);
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
												<td><?php echo number_format($r['premi'],0); ?></td>
												
												<th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=checkpro&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Edit</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="document" onclick="window.location='media.php?module=doc&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Doc</button>
												
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="sppa" onclick="window.location = 'laporan/sppa/f_sppa.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPPA</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=polhist&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Log</button>
											


												</th>
                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>