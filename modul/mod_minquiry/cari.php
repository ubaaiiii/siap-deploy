<?php
	session_start();
	$veid=$_SESSION['id_peg'];
	$vempname=$_SESSION['empname'];
	$vlevel=$_SESSION['idLevel'];
	$userid=$_SESSION['idLog'];

	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$q=$_POST['q'];
	$aksi="modul/mod_minquiry/aksi_minquiry.php";
?>
	<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               

											    <th>Nasabah </th>
												<th>Pertanggunan </th>
												
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=1)
											{
												
											$sqlr="select aa.status,aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.usia ";
											$sqlr= $sqlr . " ,aa.premi,aa.cabang,aa.produk,ab.msdesc proddesc,aa.policyno,aa.jkel, ";
											$sqlr= $sqlr . " ac.msdesc cab,aa.mulai,ad.msdesc sts,aa.createby from tr_sppa aa  ";
											$sqlr= $sqlr . " left join ms_master ab on aa.cabang=ab.msid and ab.mstype='cab'";
											$sqlr= $sqlr . " left join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' ";
											$sqlr= $sqlr . " left join ms_master ad on aa.status=ad.msid and ad.mstype='STREQ' ";
											$sqlr= $sqlr . " where ( aa.nama LIKE '%".$q."%' or aa.regid LIKE '%".$q."%' ";
											$sqlr= $sqlr . " or aa.noktp LIKE '%".$q."%' )  ";
											$sqlr= $sqlr . " and aa.createby in ";
											$sqlr= $sqlr . " (select distinct case when a.parent=a.username ";
											$sqlr= $sqlr . " then a.parent else a.username end from ms_admin a ";
											$sqlr= $sqlr . " where (a.username='$userid' or a.parent='$userid')) ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											
											}
											else 
											{
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
											$sqlr= $sqlr . " ,aa.status from tr_sppa aa where aa.status='1' ";
											$sqlr= $sqlr . " and aa.nama='XXX'  ";
											$sqlr= $sqlr . " order by aa.nama ASC LIMIT 10 ";
											}
											/* echo $sqlr; */
											
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											$scond = array('5', '6');
											$sfield = $r['status'];	
										?>
                                                                               <tr>
                                    <td>
									<div class="dashboard-widget-content">

                                    <ul class="list-unstyled timeline widget">
                                        <li>
                                            <div class="block">
                                                <div class="block_content">
												<h2 class="title">
												<a>No Register : <a href="media.php?module=minquiry&&act=view&&id=<?php echo $r['regid']; ?>"> <?php echo $r['regid']; ?></a>
												</h2>
                                                <div class="byline">
													<span><i class="fa fa-user"></i> Nama : <a><?php echo $r['nama']; ?></a></span><br>
													<span><i class="fa fa-user"></i> Jns Kelamin : <a><?php echo $r['jkel']; ?></a></span><br>
													<span><i class="fa fa-user"></i> No Ktp : <a><?php echo $r['noktp']; ?></a></span><br>
													<span><i class="fa fa-calendar"></i> Tgl Lahir : <a><?php echo tglindo_balik($r['tgllahir']); ?></a></span><br>
													<span><i class="fa fa-user"></i> Usia : <a><?php echo $r['usia']; ?></a></span><br>
																											
                                                </div>
													<p class="excerpt"><h4>Keterangan : </h4>
													<?php echo $r['comment']; ?></a>
                                                    </p>
                                                  
                                                </div>
                                            </div>
                                        </li>
                                        
                                    </ul>
                                </div>
								</td>
								 <td>
								<div class="dashboard-widget-content">

                                    <ul class="list-unstyled timeline widget">
                                        <li>
                                            <div class="block">
                                                <div class="block_content">
												<h2 class="title">
												<a>No Pinjaman : <?php echo $r['nopeserta']; ?></a>
												</h2>
                                                <div class="byline">
													
													<span><i class="fa fa-user"></i> AO : <a><?php echo $r['createby']; ?></a></span><br>
													<span><i class="fa fa-calendar"></i> Mulai : <a><?php echo tglindo_balik($r['mulai']); ?></a></span><br>
													<span><i class="fa fa-calendar"></i> Akhir : <a><?php echo tglindo_balik($r['akhir']); ?></a></span><br>
													<span><i class="fa fa-search"></i>Masa : <a><?php echo $r['masa']; ?></a></span><br>
													<span><i class="fa fa-money"></i>Up : <a><?php echo $r['up']; ?></a></span><br>
													<span><i class="fa fa-money"></i>Premi : <a><?php echo $r['tpremi']; ?></a></span><br>
													<span><i class="fa fa-check"></i>Status : <a><?php echo $r['sts']; ?></a></span><br>
													<span><i class="fa fa-file-text"></i> No sertificate : <a><?php echo $r['policyno']; ?>
														
                                                </div>

                                                 
                                                </div>
                                            </div>
                                        </li>
                                        
                                    </ul>
                                </div>
								</td>
												
												

                                               

                                            </tr>
										<?php

										}
										?>
                                        </tbody>
                                    </table>