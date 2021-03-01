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
		   if (strcari != "")
		   {
		   $("#tabel_awal").css("display", "none");

			$("#hasil").html("<img src='images/loader.gif'/>")
			$.ajax({
			 type:"post",
			 url:"modul/mod_profile/cari.php",
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
	<style>
	#selec{
		width:500px;
	}
	</style>
<?php	
$aksi="modul/mod_profile/aksi_profile.php";
switch(isset($_GET['act'])){
	default:
	$p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
	$iduser=$_SESSION['idLog'];
			$ssql="select a.* from ms_admin a where a.username='$iduser'   ";
			/* echo $ssql; */
			$query=$db->query($ssql);
			$num=$query->num_rows;
			
			while($r=$query->fetch_array()){
				$username=$r['username'];
				$level=$r['level'];
				$eid=$r['eid'];
				$nama=$r['nama'];
				$email=$r['email'];
				$mitra=$r['mitra'];
				$joindate=$r['joindate'];
				$level=$r['level'];
				$parent=$r['parent'];
				$cabang=$r['cabang'];
				
				$email=$r['email'];
				$nohp=$r['nohp'];
		
				
			}
?>
<div class="right_col" role="main">
                <div class="">
                    <div class="clearfix"></div>


                    <div class="row">
                    <div class="x_content">

										
										
									
					<div id="tabel_awal">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Profile </h2>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                      <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">

										<div class="form-group">

                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Username
                                            </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="username" name="username" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $username; ?>">
                                            </div>
										</div>
									
									
										<div class="form-group">

                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name
                                            </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="nama" name="nama" class="form-control col-md-7 col-xs-12" value="<?php echo $nama; ?>">
                                            </div>
										</div>
										
									
									
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mitra 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="mitra" id="mitra" onChange="display(this.value)">
												<option value="" selected="selected">-- Pilih Area --</option>
												<?php
												$sqlcmb="select ms.msid comtabid,msdesc comtab_nm from ms_master ms  where mstype='mitra' order by ms.msdesc ";
												$query=$db->query($sqlcmb);
												while($bariscb=$query->fetch_array()){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$mitra){ ?> selected="selected" <? }?>> 
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
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="cabang" id="cabang" onChange="display(this.value)">
												<option value="" selected="selected">-- Pilih Area --</option>
												<?php
												$sqlcmb="select ms.msid comtabid,msdesc comtab_nm from ms_master ms  where mstype='cab' order by ms.msdesc ";
												$query=$db->query($sqlcmb);
												while($bariscb=$query->fetch_array()){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$cabang){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>	
										
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email
                                            </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="email" name="email" required="required"  class="form-control col-md-7 col-xs-12" value="<?php echo $email; ?>">
                                            </div>
										</div>
										                                    
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No Hp
                                            </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="nohp" name="nohp" required="required"  class="form-control col-md-7 col-xs-12" value="<?php echo $nohp; ?>">
                                            </div>
										</div>		
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hak Akses 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="level" id="level" onChange="display(this.value)">
												<option value="" selected="selected">-- choose akses --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='utype'  order by ms.mstype ";
												$query=$db->query($sqlcmb);
												while($bariscb=$query->fetch_array()){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$level){ ?> selected="selected" <? }?>> 
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
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="parent" id="parent" onChange="display(this.value)">
												<option value="" selected="selected">-- choose supervisor --</option>
												<?php
												$sqlcmb="select   ms.username comtabid,nama comtab_nm from ms_admin ms order by ms.username ";
												$query=$db->query($sqlcmb);
												while($bariscb=$query->fetch_array()){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$parent){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>			

									<div id="tabel_doc">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
												<th>Nama  </th>
												<th>Level  </th>
												<th>Cabang  </th>
											</tr>
                                        </thead>
                                        <tbody>
										<?php
										
											$sqld="select nama,mm.msdesc cabang,ml.msdesc lvl from ";
											$sqld= $sqld . "(select username,nama,cabang,level from ms_admin ";
											$sqld= $sqld . "where username in (select parent from ms_admin where username='$iduser') ";
											$sqld= $sqld . "union  ";
											$sqld= $sqld . "select username,nama,cabang,level from ms_admin  ";
											$sqld= $sqld . "where cabang in (select cabang from ms_admin where username='$iduser') ";
											$sqld= $sqld . "and level in ('checker','schecker')) aa ";
											$sqld= $sqld . "left join ms_master mm on mm.msid=aa.cabang ";
											$sqld= $sqld . "left join ms_master ml on ml.msid=aa.level ";
											$sqld= $sqld . "group by nama,mm.msdesc ,ml.msdesc ";
											
											$query=$db->query($sqld);
											$num=$query->num_rows;
											$no=1;
											while($r=$query->fetch_array()){
										?>
                                            <tr>
                                               

											<td><?php echo $r['nama']; ?></td>
											<td><?php echo $r['lvl']; ?></td>
											<td><?php echo $r['cabang']; ?></td>
 
												
                                              
												
											
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
                                                <a href="media.php?module=home"" class="btn btn-primary btn-large"><i class="fa fa-arrow-left"></i> Back</a>
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
												
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
                    </div>
                </div>
            </div>
<?php
break;

case "update":
$idpeg=$_GET['eid'];
$query=$db->query("SELECT username,id_peg,'' password FROM tbl_admin where username='$idpeg'");

$r=$query->fetch_array();
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
                                    <h2>Change Password <small><?php echo $r['username']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=updatepass"; ?>">
									<input type="hidden" name="id" value="<?php echo $r['username']; ?>">
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Username 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="username" name="username" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['username']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</span> </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="pass" class="form-control col-md-7 col-xs-12" type="text" name="pass"  value="<?php echo $r['password']; ?>">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Retry Password <span class="required">*</span> </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="rpass" class="form-control col-md-7 col-xs-12" type="text" name="rpass"  value="<?php echo $r['password']; ?>">
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
                        </div>
                    </div>
                </div>
            </div>
<?php
break;
}
?>