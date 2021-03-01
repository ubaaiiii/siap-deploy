<?php
	include ("../../config/koneksi.php");
	$q=$_POST['q'];
	$aksi="modul/mod_diagnosa/aksi_diagnosa.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                                <th>No</th>
                                                <th>Kode ICD</th>
												<th>Diagnosa</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=3)
											{
											$query=$db->query("SELECT * FROM tbl_diagnosa WHERE nmdiagnosa<>'' and  (kdicd LIKE '%".$q."%' or nmdiagnosa LIKE '%".$q."%') limit 200 ");
											}
											else 
											{
											$query=$db->query("SELECT * FROM tbl_diagnosa WHERE nmdiagnosa<>'' order by kdicd asc limit 200 ");
											}
											$num=$query->num_rows;
											$no=1;

											while($r=$query->fetch_array()){
										?>
                                            <tr>
                                               
                                                <td><?php echo $no; ?></td>
												<td><?php echo $r['kdicd']; ?></td>
                                                <td><?php echo $r['nmdiagnosa']; ?></td>
                                               
												
												
                                            </tr>
										<?php
										$no++;
										}
										?>
                                        </tbody>
                                    </table>