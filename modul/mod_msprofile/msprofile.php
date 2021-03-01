<script>
	$(document).ready(function(){
		$("#form_add").css("display","none");
		$("#add").click(function(){
			$("#form_add").fadeToggle(1000);

		});
	});
</script>
<script type="text/javascript">
		 $(document).ready(function() {
		  $("#txtcari").keyup(function() {
		   var strcari = $("#txtcari").val();
		   if (strcari != ""  )
		   {
		   $("#tabel_awal").css("display", "none");

			$("#hasil").html("<img src='images/loader.gif'/>")
			$.ajax({
			 type:"post",
			 url:"modul/mod_msmitra/cari.php",
			 data:"q="+ strcari,
			 success: function(data){
			 $("#hasil").css("display", "block");
			  $("#hasil").html(data);
			  
			 }
			});
		   }
		   else{
		   $("#hasil").css("display", "none");
		   $("#tabel_awal").css("display", "block");
		   }
		  });
			});
	</script>
<?php	

$aksi="modul/mod_msprofile/aksi_msprofile.php";
$judul="Master Profile";
$userid=$_SESSION['idLog'];
switch(isset($_GET['act'])){
	default:
	$p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

?>
<div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $judul; ?></h3>
                        </div>
					</div>
                    <div class="clearfix"></div>


                    <div class="row">
                                <div class="x_content">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<button type="button" class="btn btn-default btn-sm" id="add"><i class="fa fa-plus-circle"></i> Add Data</button>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" required="required" class="form-control" placeholder="Search" id="txtcari">
                                    </div>
					<div class="row" id="form_add">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Input Data</h2>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form action="<?php echo $aksi."?module=add" ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
										<input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ID
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="code" type="text" id="code" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
                                       
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="desk" type="text" id="profilename" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										
										 <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alamat#1
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="alamat1" type="text" id="alamat1" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										
										 <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alamat#2
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="alamat2" type="text" id="alamat2" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										
										
										 <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kota
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="kota" type="text" id="kota" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telpon#1
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="phone1" type="text" id="phone1" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
                                        
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telpon#2
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="phone2" type="text" id="phone2" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fax#1
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="fax1" type="text" id="fax1" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fax#2
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="fax2" type="text" id="fax2" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="email" type="text" id="email" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
									<div id="hasil"></div>
									<div id="tabel_awal">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                                <th>ID</th>
												<th>Nama </th>
                                                <th>Alamat</th>
												<th>Kota</th>
												<th>Telpon</th>
												<th>Fax</th>
												<th>Email</th>
												
												
												
												<th></th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											$sqlq ="SELECT profileid,profilename,concat(address1,address2) alamat, ";
											$sqlq = $sqlq . " citycd, phone1 phone, fax1 fax, email ";
											$sqlq = $sqlq . " from tr_profile  order by profileid ASC LIMIT $posisi,$batas";
											/* echo $sqlq; */
											$query=mysql_query($sqlq);
											$num=mysql_num_rows($query);
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                               
                                                <td><?php echo $r['profileid']; ?></td>
												<td><?php echo $r['profilename']; ?></td>
                                                <td><?php echo $r['alamat']; ?></td>
												<td><?php echo $r['kota']; ?></td>
												<td><?php echo $r['phone']; ?></td>
												<td><?php echo $r['fax']; ?></td>
												<td><?php echo $r['email']; ?></td>
												
																					
												
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=msprofile&&act=update&&id=<?php echo $r['profileid']; ?>'"><i class="fa fa-search"></i> Edit</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="window.location='<?php echo $aksi."?module=delete&&id=".$r['profileid']; ?>'"><i class="fa fa-trash"></i> Delete</button>

												</th>
												
												
											
                                            </tr>
										<?php
										$no++;
										}
										?>
                                        </tbody>
                                    </table>
									</div>
									<?php
							$jmldata=mysql_num_rows(mysql_query("SELECT * from ms_master where mstype='MITRA'  "));
							$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
							$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman); 
							echo "$linkHalaman";
							
							?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
break;

case "update":
$id=$_GET['id'];
$sqlq ="SELECT profileid,profilename,concat(address1,address2) alamat, ";
$sqlq = $sqlq . " citycd, phone1 phone, fax1 fax, email ";
$sqlq = $sqlq . " from tr_profile where profileid='$id'";
$query=mysql_query($sqlq);
$r=mysql_fetch_array($query);
$msdesc=$r['msdesc'];
?>
<div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $judul; ?></h3>
                        </div>

                     
                    </div>
                    <div class="clearfix"></div>


                   <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Update <small><?php echo $msdesc; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
										<input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> ID
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="code" name="code" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['profileid']; ?>">
												
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="desk" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['profilename']; ?>">
                                            </div>
                                        </div>
										
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alamat#1 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="desk" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['alamat1']; ?>">
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alamat#2 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="desk" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['alamat2']; ?>">
                                            </div>
                                        </div>

										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kota 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="desk" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['alamat2']; ?>">
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telpon#1
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="desk" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['phone1']; ?>">
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telpon#2 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="desk" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['phone2']; ?>">
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fax#1 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="desk" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['fax1']; ?>">
                                            </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fax2 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="desk" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['fax2']; ?>">
                                            </div>
                                        </div>
										
										
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                               <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=msprofile'"><i class="fa fa-arrow-left"></i> Back</button>
											   <button type="submit" class="btn btn-sm btn-default">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
break;
}
?>