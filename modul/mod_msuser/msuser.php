
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
			 url:"modul/mod_msuser/cari.php",
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

$aksi="modul/mod_msuser/aksi_msuser.php";
$judul="Master User";
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
										<button type="button" class="btn btn-default btn-sm" id="add"><i class="fa fa-plus-circle"></i> Add </button>
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">NIP
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="nip" type="text" id="nip" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										
										
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="nama" type="text" id="nama" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										
										 <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="email" type="text" id="email"  required="required"  class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No Hp
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="nohp" type="number" id="nohp" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Hak Akses
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                               <select class="select2_single form-control" tabindex="-2" name="level" id="selec">
													
													<?php
													$qtahun=$db->query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='utype'  order by ms.msdesc  asc ");
													while($rpro = $qtahun->fetch_array()){
													?>
													<option value="<?php echo $rpro['comtabid']; ?>"><?php echo $rpro['comtab_nm']; ?></option>
													<?php
													}
													?>
												
												</select>
                                            </div>
										</div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Cabang 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                               <select class="select2_single form-control" tabindex="-2" name="cabang" id="selec">
													
													<?php
													$qtahun=$db->query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='cab'  order by ms.msdesc  asc ");
													while($rpro=$qtahun->fetch_array()){
													?>
													<option value="<?php echo $rpro['comtabid']; ?>"><?php echo $rpro['comtab_nm']; ?></option>
													<?php
													}
													?>
												
												</select>
                                            </div>
										</div>										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mitra 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                               <select class="select2_single form-control" tabindex="-2" name="mitra" id="selec">
													
													<?php
													$qtahun=$db->query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc ");
													while($rpro=$qtahun->fetch_array()){
													?>
													<option value="<?php echo $rpro['comtabid']; ?>"><?php echo $rpro['comtab_nm']; ?></option>
													<?php
													}
													?>
												
												</select>
                                            </div>
										</div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Supervisor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                               <select class="select2_single form-control" tabindex="-2" name="parent" id="selec">
													
													<?php
													$qtahun=$db->query("select ms.username comtabid,ms.nama comtab_nm from ms_admin ms   order by ms.nama  asc ");
													while($rpro=$qtahun->fetch_array()){
													?>
													<option value="<?php echo $rpro['comtabid']; ?>"><?php echo $rpro['comtab_nm']; ?></option>
													<?php
													}
													?>
												
												</select>
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
											$sqlq="SELECT a.*,b.msdesc cab, c.msdesc utype from ms_admin a ";
											$sqlq= $sqlq . "  left join ms_master b on a.cabang=b.msid and b.mstype='cab' ";
											$sqlq= $sqlq . "  left join ms_master c on c.msid=a.level and c.mstype='utype'";
											$sqlq= $sqlq . " order by a.id_admin desc LIMIT $posisi,$batas";
											$query=$db->query($sqlq);
											$num=$query->num_rows;
											$no=1;
											while($r=$query->fetch_array()){
											
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
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=msuser&&act=update&&id=<?php echo $r['username']; ?>'"><i class="fa fa-search"></i> Edit</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="window.location='<?php echo $aksi."?module=delete&&id=".$r['username']; ?>'"><i class="fa fa-trash"></i> Delete</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Reset" onclick="window.location='<?php echo $aksi."?module=reset&&id=".$r['username']; ?>'"><i class="fa fa-search"></i> Reset</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Email" onclick="window.location='<?php echo $aksi."?module=email&&id=".$r['username']; ?>'"><i class="fa fa-search"></i> Email</button>
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
							$jmldata=$db->query("SELECT * from ms_admin    ")->num_rows;
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
$query=$db->query("SELECT * FROM ms_admin where username='$id'");
$r=$query->fetch_array();
$slevel=$r['level'];
$smitra=$r['mitra'];
$scabang=$r['cabang'];
$spar=substr($r['parent'],0,20);
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Username
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="uname" name="uname" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['username']; ?>">
												
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="nama" name="nama" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
                                            </div>
                                        </div>
										
										
												
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['email']; ?>">
                                            </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No Hp 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="nohp" name="nohp" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nohp']; ?>">
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mitra 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select class="select2_single form-control" tabindex="-2" name="mitra" id="mitra" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra'  order by ms.mstype ";
												$query=$db->query($sqlcmb);
												while($bariscb=$query->fetch_array()){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$smitra){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>					

										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cabang 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select class="select2_single form-control" tabindex="-2" name="cabang" id="cabang" onChange="display(this.value)">
												<option value="" selected="selected">-- choose cabang --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype ";
												$query=$db->query($sqlcmb);
												while($bariscb=$query->fetch_array()){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$scabang){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>															

										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hak Akses 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select class="select2_single form-control" tabindex="-2" name="level" id="level" onChange="display(this.value)">
												<option value="" selected="selected">-- choose akses --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='utype'  order by ms.mstype ";
												$query=$db->query($sqlcmb);
												while($bariscb=$query->fetch_array()){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$slevel){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>														
										
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Supervisor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select class="select2_single form-control" tabindex="-2" name="parent" id="parent" onChange="display(this.value)">
												<option value="" selected="selected">-- choose supervisor --</option>
												<?php
												$sqlcmb="select   ms.username comtabid,nama comtab_nm from ms_admin ms where level in ('smkt','schecker') order by ms.username ";
												$query=$db->query($sqlcmb);
												while($bariscb=$query->fetch_array()){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$spar){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>								
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                               <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=msuser'"><i class="fa fa-arrow-left"></i> Back</button>
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