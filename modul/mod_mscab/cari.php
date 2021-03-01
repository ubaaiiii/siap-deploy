<?php
	include ("../../config/koneksi.php");
	include ("../../config/fungsi_indotgl.php");
	$q=$_POST['q'];
	$aksi="modul/mod_item/aksi_item.php";
?>
<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                                 <th>No</th>
												<th>Code </th>
                                                <th>Description</th>
												
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											if (strlen($q)>=3)
											{
												
											
											$query=$db->query("SELECT * FROM ms_master WHERE (msdesc LIKE '%".$q."%' or msid LIKE '%".$q."%' ) and mstype='CAB' order by msdesc limit 200 ");
											}
											else 
											{
											$query=$db->query("SELECT * FROM ms_master WHERE (msdesc LIKE '%".$q."%' or msid LIKE '%".$q."%' ) and mstype='CAB' order by msdesc  limit 200");
											}
											$num=$query->num_rows;
											$no=1;

											while($r=$query->fetch_array()){
											
										?>
                                            <tr>
                                               
                                                 <td><?php echo $no; ?></td>
												<td><?php echo $r['msid']; ?></td>
                                                <td><?php echo $r['msdesc']; ?></td>
												
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=mscab&&act=update&&id=<?php echo $r['msid']; ?>'"><i class="fa fa-search"></i> Edit</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="window.location='<?php echo $aksi."?module=delete&&id=".$r['msid']; ?>'"><i class="fa fa-trash"></i> Delete</button>		
												</th>
												
												
                                            </tr>
										<?php
										$no++;
										}
										?>
                                        </tbody>
                                    </table>