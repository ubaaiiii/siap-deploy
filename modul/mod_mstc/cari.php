<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_indotgl.php");
	$q=$_POST['q'];
	$aksi="modul/mod_msrate/aksi_msrate.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                                <th>Product </th>
                                                <th>Sex</th>
												<th>Umur#1 </th>
                                                <th>Umur#2</th>
                                                <th>Year</th>
												<th>Month</th>
												<th>GPB</th>
												<th>GPA</th>
												<th>Rates </th>
												

                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=3)
											{
											$sqlq="SELECT a.*,b.msdesc sproduk,concat(produk,jkel,umurb,umura,insperiodyy,insperiodmm) ";
											$sqlq=$sqlq . " from tr_rates a left join ms_master b on a.produk=b.msid and b.mstype='produk' ";
											$sqlq=$sqlq . " where a.produk LIKE '%".$q."%'  ";
											$sqlq=$sqlq . " or b.msdesc  LIKE '%".$q."%'  ";
											$sqlq=$sqlq . " order by produk,jkel,umurb,insperiodmm ASC LIMIT 200 ";
											
											
											
											}
											else 
											{
											$sqlq="SELECT a.*,b.msdesc sproduk,concat(produk,jkel,umurb,umura,insperiodyy,insperiodmm) ";
											$sqlq=$sqlq . " from tr_rates a left join ms_master b on a.produk=b.msid and b.mstype='produk' ";
											$sqlq=$sqlq . " where a.produk LIKE '%".$q."%'  ";
											$sqlq=$sqlq . " or b.msdesc  LIKE '%".$q."%'  ";
											$sqlq=$sqlq . " order by produk,jkel,umurb,insperiodmm,gpb ASC LIMIT 200 ";
											
											}
											$query=mysql_query($sqlq);	
											$num=mysql_num_rows($query);
											$no=1;

											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                               
                                                <td><?php echo $r['sproduk']; ?></td>
												<td><?php echo $r['jkel']; ?></td>
                                                <td><?php echo $r['umurb']; ?></td>
												<td><?php echo $r['umura']; ?></td>
												<td><?php echo $r['insperiodyy']; ?></td>
												<td><?php echo $r['insperiodmm']; ?></td>
												<td><?php echo $r['gpb']; ?></td>
												<td><?php echo $r['gpa']; ?></td>
												<td><?php echo $r['rates']; ?></td>

												
                                               												
												
                                            </tr>
										<?php
										$no++;
										}
										?>
                                        </tbody>
                                    </table>