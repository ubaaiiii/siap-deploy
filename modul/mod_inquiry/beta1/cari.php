<?php

	session_start();
	$veid=$_SESSION['id_peg'];
	$vempname=$_SESSION['empname'];
	$vlevel=$_SESSION['idLevel'];
	$userid=$_SESSION['idLog'];
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$suid=$_POST['uid'];
	$slvl=$_POST['lvl'];
	$vlevel=$_POST['lvl'];
	$userid=$_POST['uid'];
	$q=$_POST['q'];
	$aksi="modul/mod_inquiry/aksi_inquiry.php";
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
											if (strlen($q)>=4)
											{
												
											$sqlr="select '$vlevel','$userid', aa.status,aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up, ";
											$sqlr= $sqlr . " aa.premi,aa.cabang,aa.produk,ac.msdesc proddesc,aa.policyno,aa.masa,aa.asuransi, ";
											$sqlr= $sqlr . " ac.msdesc cab,aa.mulai,ad.msdesc sts from tr_sppa aa  left join ms_master ab ";
											$sqlr= $sqlr . " on aa.cabang=ab.msid and ab.mstype='cab'";
											$sqlr= $sqlr . " left join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' ";
											$sqlr= $sqlr . " left join ms_master ad on aa.status=ad.msid and ad.mstype='STREQ' ";
											$sqlr= $sqlr . " where ( aa.nama LIKE '%".$q."%' or ";
											$sqlr= $sqlr . " aa.regid LIKE '%".$q."%' or aa.noktp LIKE '%".$q."%' )  ";
										
											
											
											}
											if (strlen($q)<=4)
											{
											$sqlr="select '$vlevel','$userid', aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
											$sqlr= $sqlr . " ,aa.status from tr_sppa aa where aa.status='1' ";
											$sqlr= $sqlr . " and aa.nama='XXX'  ";

											}
											
											
											if ($vlevel=="mkt" or  $vlevel=="smkt")
											{
											$sqlr= $sqlr . " and aa.createby in ";
											$sqlr= $sqlr . " (select  case when a.parent=a.username ";
											$sqlr= $sqlr . " then a.parent else a.username end from ms_admin a ";
											$sqlr= $sqlr . " where (a.username='$userid' or a.parent='$userid')) ";
											}
											
											if ($vlevel=="schecker" )
											{
	/* 										$sqlr= $sqlr . " and aa.cabang in (  ";
											$sqlr= $sqlr . "select  msid from  ";
											$sqlr= $sqlr . "(select 'chkspm01' uname ,msid from ms_master where mstype='cab' ";
											$sqlr= $sqlr . " union  ";
											$sqlr= $sqlr . "select 'chkspm01' uname ,msid from ms_master where mstype='cab' ";
											$sqlr= $sqlr . "union ";
											$sqlr= $sqlr . "select username uname ,a1.cabang msid from ms_admin a1 ";
											$sqlr= $sqlr . "where a1.username in ('$userid' ) ) aa where uname='$userid' )  "; */
											
											
											$sqlr= $sqlr . " and  aa.cabang like ( 	";				
											$sqlr= $sqlr . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
											$sqlr= $sqlr . "from ms_admin where username='$userid' )";
											}
											
											if ($vlevel=="checker")
											{
											/* $sqlr= $sqlr . " and aa.cabang in (  ";
											$sqlr= $sqlr . "select  msid from  ";
											$sqlr= $sqlr . "(select 'chkstf01' uname ,msid from ms_master where mstype='cab' ";
											$sqlr= $sqlr . " union  ";
											$sqlr= $sqlr . "select 'chkstf01' uname ,msid from ms_master where mstype='cab' ";
											$sqlr= $sqlr . "union ";
											$sqlr= $sqlr . "select username uname ,a1.cabang msid from ms_admin a1 ";
											$sqlr= $sqlr . "where a1.username in ('$userid' ) ) aa where uname='$userid' )  "; */
											
											$sqlr= $sqlr . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
											$sqlr= $sqlr . "from ms_admin where username='$userid' )";
											}
											
											
											if ($vlevel=="insurance")
											{
											$sqlr= $sqlr . "  and aa.asuransi in (select cabang from ms_admin  where level='insurance' and username='$userid' ) "; 
											}
											if ($vlevel=="broker")
											{
											$sqlr= $sqlr . "   and aa.status<>'' "; 
											}
											
											
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											/* echo $sqlr;   */
											
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											$sfield = $r['status'];	
											$scond = array('5', '6','20','90','91','92','93','70','71','72','73','80','81','82','83');
											
											$rsppa=array("2","3","4","5","6","11","20");
											$rrefund=array('83','83');
											$rinv=array('5','6');
										?>
                                            <tr>
												<td><?php echo $r['asuransi']; ?></td>
												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo tglindo_balik($r['tgllahir']); ?></td>
												<td><?php echo tglindo_balik($r['mulai']); ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo number_format($r['premi'],0); ?></td>
												<td><?php echo $r['proddesc']; ?></td>
												<td><?php echo $r['masa']; ?></td>
												<td><?php echo $r['nopeserta']; ?></td>
												<td><?php echo $r['sts']; ?></td>
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=inquiry&&act=view&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> view</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=polhist&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Log</button>
												<?php if (in_array($sfield, $rsppa, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="sppa" onclick="window.location = 'laporan/sppa/f_sppa.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPPA</button>
												<?php endif; ?>
												<?php if (in_array($sfield, $rrefund, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Invoice" onclick="window.location = 'laporan/refund/f_refund.php?id=<?php echo $r['policyno']; ?>'"><i class="fa fa-print"></i> Refund</button>
												<?php endif; ?>
												<?php if (in_array($sfield, $rinv, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Invoice" onclick="window.location = 'laporan/bill/f_bill.php?id=<?php echo $r['policyno']; ?>'"><i class="fa fa-print"></i> Invoice</button>
												<?php endif; ?>
												<?php if (in_array($sfield, $scond, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Sertifikat" onclick="window.location = 'laporan/cert/f_cert.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> Cert</button>
												<?php endif; ?>
												</th>

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>