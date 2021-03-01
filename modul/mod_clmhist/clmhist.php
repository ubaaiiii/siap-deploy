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
			 url:"modul/mod_clmhist/cari.php",
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

$aksi="modul/mod_clmhist/aksi_clmhist.php";
$judul="Claim History";
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Code
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="code" type="text" id="code" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
                                       
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Deskripsi
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="desk" type="text" id="desk" required="required" class="form-control col-md-7 col-xs-12">
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
                                               
                                                <th>No</th>
												<th>Code </th>
                                                <th>Description</th>
												
												
												<th></th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											$query=mysql_query("SELECT * from ms_master where mstype='CAB' order by msid ASC LIMIT $posisi,$batas");
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
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
									</div>
									<?php
							$jmldata=mysql_num_rows(mysql_query("SELECT * from ms_master where mstype='CAB'  "));
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
$query=mysql_query("SELECT a.regclaim,b.nama,a.regid,a.tgllapor,a.tglkejadian,a.detail FROM tr_claim a inner join tr_sppa b on a.regid=b.regid  where a.regclaim='$id'");
$r=mysql_fetch_array($query);
$detail=$r['detail'];
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
                                    <h2>View <small><?php echo $r['regclaim']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
										<input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Claim No
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="code" name="code" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regclaim']; ?>">
												
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No Peserta  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="nama" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
                                            </div>
                                        </div>
										
										 <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama   
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="nama" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lapor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tgllapor" name="tgllapor"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tgllapor']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Kejadian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tglkejadian" name="tglkejadian" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tglkejadian']; ?>">
												
                                            </div>
                                        </div>
										
								
									   <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Detail Kejadian  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<textarea disabled name="subject" rows="5" class="textbox" id="detail" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($detail)); ?></textarea>                                            
											</div>
                                        </div>
									<div id="tabel_awal">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                                <th>No</th>
												<th>Status </th>
                                                <th>User</th>
												<th>Tanggal</th>
												<th>Comment</th>
												
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											$sqll="SELECT a.*,b.msdesc statusclm from tr_claim_log a inner join ms_master b on a.statclaim=b.msid and b.mstype='STCLM' ";
											$sqll=$sqll . " where a.regclaim='$id'  ";
											/* echo $sqll; */
											$query=mysql_query($sqll);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                               
                                                <td><?php echo $r['statclaim']; ?></td>
												<td><?php echo $r['statusclm']; ?></td>
                                                <td><?php echo $r['createby']; ?></td>
												<td><?php echo $r['createdt']; ?></td>
												<td><?php echo $r['comment']; ?></td>
												
																					
												
                                               
												
												
											
                                            </tr>
										<?php
										$no++;
										}
										?>
                                        </tbody>
                                    </table>
									</div>										
										
										
										
										
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                               <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=claim'"><i class="fa fa-arrow-left"></i> Back</button>
											
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