<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	
	$suid=$_POST['uid'];
	$userid=$_POST['uid'];
	$slvl=$_POST['lvl'];
	$q=$_POST['q'];
	$aksi="modul/mod_certificate/aksi_certificate.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
												<th>Asuransi </th>
												<th>No Register </th>
                                                <th>Nama</th>
												<th>Tgl Lahir</th>
												<th>Mulai</th>
												<th>UP</th>
												<th>Premi</th>
												<th>Produk</th>
												<th>Tenor</th>
												<th>No Pinjaman</th>
												<th>Status</th>
												<th></th>
												                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=3)
											{
											$sqlr="select '$suid','$slvl',aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi, ";
											$sqlr= $sqlr . "  aa.status,ab.msdesc,aa.mulai ,aa.policyno,ma.msdesc asuransi,pd.msdesc produk,aa.masa  ";
											$sqlr= $sqlr . " from tr_sppa aa  left join ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' ";
											$sqlr= $sqlr . " inner join ms_master  ma on aa.asuransi=ma.msid and ma.mstype='asuransi' ";
											$sqlr= $sqlr . "  left join ms_master pd on pd.msid=aa.produk and pd.mstype='produk' ";
											$sqlr= $sqlr . " where aa.status in ('5','6','20','73','83') ";
											$sqlr= $sqlr . " and ( aa.nama LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%'  or  aa.regid LIKE '%".$q."%'   ";
											$sqlr= $sqlr . " or aa.nopeserta LIKE '%".$q."%' or aa.policyno LIKE '%".$q."%'   )  ";
											

											/* echo $sqlr; */
											}
											else 
											{
											$sqlr="select  '$q','$suid','$slvl',aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,ab.msdesc ";
											$sqlr= $sqlr . " from tr_sppa aa  left join ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' where aa.status in ('5','6','20','73','83') ";
											$sqlr= $sqlr . " and aa.nama='XXX'  ";

											}
											/* echo $sqlr;  */
											
											if ($vlevel=="smkt"  )
											{
											$sqlr= $sqlr . " and aa.createby in ";
											$sqlr= $sqlr . " (select  case when a.parent=a.username ";
											$sqlr= $sqlr . " then a.parent else a.username end from ms_admin a ";
											$sqlr= $sqlr . " where (a.username='$userid' or a.parent='$userid')) ";
											}
											
											if ($vlevel=="mkt"  )
											{
											$sqlr= $sqlr . " and aa.createby in ";
											$sqlr= $sqlr . "  ('$userid') ";
											}
											
											if ($vlevel=="checker"  or $vlevel=="schecker"    )
											{
											$sqlr= $sqlr . "and cabang in (  ";
											$sqlr= $sqlr . "select  msid from  ";
											$sqlr= $sqlr . "(select 'chkstf01' uname ,msid from ms_master where mstype='cab' ";
											$sqlr= $sqlr . " union  ";
											$sqlr= $sqlr . "select 'chkstf01' uname ,msid from ms_master where mstype='cab' ";
											$sqlr= $sqlr . "union ";
											$sqlr= $sqlr . "select username uname ,a1.cabang msid from ms_admin a1 ";
											$sqlr= $sqlr . "where a1.username in ('$userid' ) ) aa where uname='$userid' )  ";
											}
											
											if ($vlevel=="insurance"    )
											{
											$sqlr= $sqlr . "  and aa.asuransi in (select cabang from ms_admin  where level='insurance' and username='$userid' ) "; 
											}
											
											if ($vlevel=="broker"  )
											{
											$sqlr= $sqlr . " ";
											
											}
											
											
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 100 ";
											
										
											/* echo $sqlr; */
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											$scond = array('5', '6');
											$sfield = $r['status'];	
											$scond1 = array('20');
											$sfield1 = $r['status'];	
											$scond2 = array('broker','broker');
											$sfield2 = $slvl;	
											$scond3 = array('73', '83');
											$sfield3 = $r['status'];	
											
										?>
                                            <tr>
												<td><?php echo $r['asuransi']; ?></td>
												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo tglindo_balik($r['tgllahir']); ?></td>
												<td><?php echo tglindo_balik($r['mulai']); ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo number_format($r['premi'],0); ?></td>
												<td><?php echo $r['produk']; ?></td>
												<td><?php echo $r['masa']; ?></td>
												<td><?php echo $r['nopeserta']; ?></td>
												<td><?php echo $r['msdesc']; ?></td>
												
                                            <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=certificate&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> View</button>
					
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Sertifikat" onclick="window.location = 'laporan/cert/f_cert.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> Cert</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Invoice" onclick="window.location = 'laporan/bill/f_bill.php?id=<?php echo $r['policyno']; ?>'"><i class="fa fa-print"></i> Invoice</button>
												
												<?php if (in_array($sfield2, $scond2, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Paid" onclick="window.location='media.php?module=certificate&&act=paid&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-money"></i> Paid</button>
												<?php endif; ?>
												<?php if (in_array($sfield3, $scond3, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Tanggal Tarik Refund" onclick="window.location = 'laporan/refund/f_refund.php?id=<?php echo $r['policyno']; ?>'"><i class="fa fa-calendar"></i> Refund <i class="fa fa-check-circle" style="color:blue"></i></button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Credit Note" onclick="window.location = 'laporan/refund/f_refund.php?id=<?php echo $r['policyno']; ?>'"><i class="fa fa-print"></i> Credit Note</button>
												<?php endif; ?>
											</th>

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>