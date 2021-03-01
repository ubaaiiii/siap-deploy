<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_all.php");
	$q=$_POST['q'];
	$aksi="modul/mod_msuser/aksi_msuser.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                                 <th>Username</th>
												<th>Password </th>
                                                <th>Nama</th>
												<th>Parent</th>
												<th>Cabang</th>
												<th>Mitra</th>
												<th>Level</th>
												<th></th>

                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=3)
											{
												
											
											$sqlu="SELECT a.*,b.msdesc cab,c.msdesc utype from ms_admin a ";
											$sqlu= $sqlu . "  left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";
											$sqlu= $sqlu . "  left join ms_master c on c.msid=a.level and c.mstype='utype'";
											$sqlu=$sqlu . " WHERE (username LIKE '%".$q."%' or nama LIKE '%".$q."%'  ";
											$sqlu=$sqlu . " or  nama LIKE '%".$q."%' or parent  LIKE '%".$q."%'  ";
											$sqlu=$sqlu . " or  b.msdesc LIKE '%".$q."%' or a.mitra  LIKE '%".$q."%' ) ";
											$sqlu=$sqlu . " order by username limit 200 ";
											}
											else 
											{
											$sqlu="SELECT * FROM ms_admin ";
											$sqlu=$sqlu . " WHERE (username LIKE '%".$q."%' ";
											$sqlu=$sqlu . " or email LIKE '%".$q."%' or  nama LIKE '%".$q."%' ) ";
											$sqlu=$sqlu . "   order by username limit 200 ";
											}
											/* echo $sqlu; */
											$query=mysql_query($sqlu);
											$num=mysql_num_rows($query);
											$no=1;

											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                               
                                                
												<td><?php echo $r['username']; ?></td>
												<td><?php echo $r['supervisor']; ?></td>
												<td><?php echo $r['nama']; ?></td>
												<td><?php echo $r['parent']; ?></td>
												<td><?php echo $r['cab']; ?></td>
												<td><?php echo $r['mitra']; ?></td>
												<td><?php echo $r['utype']; ?></td>
		
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=msuser&&act=update&&id=<?php echo $r['username']; ?>'"><i class="fa fa-search"></i> Edit</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="window.location='<?php echo $aksi."?module=delete&&id=".$r['username']; ?>'"><i class="fa fa-trash"></i> Delete</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Reset" onclick="window.location='<?php echo $aksi."?module=reset&&id=".$r['username']; ?>'"><i class="fa fa-search"></i> Reset</button>
												</th>
												
                                            </tr>
										<?php
										$no++;
										}
										?>
                                        </tbody>
                                    </table>