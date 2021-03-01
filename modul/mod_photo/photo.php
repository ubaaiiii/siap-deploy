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
			 url:"modul/mod_doc/cari.php",
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
$aksi="modul/mod_photo/aksi_photo.php";
$iddata=$_GET['eid'];
$judul="Photo";
$sid=$_GET['id'];

$query=mysql_query("SELECT a.*  FROM tr_sppa a WHERE regid='$sid'");
$r=mysql_fetch_array($query);
$snama=$r['nama'];
$snopeserta=$r['nopeserta'];

$judul2=$sid." - ".$snama;
switch($_GET['act']){
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
							<h3><?php echo $judul2; ?></h3>
                        </div>
					</div>
                    <div class="clearfix"></div>


                    <div class="row">
                                <div class="x_content">
									<div class="col-md-6 col-sm-6 col-xs-12">

									<a href="media.php?module=ajuan&&act=update&&id=<?php echo $sid; ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
									<button type="button" class="btn btn-default btn-sm" id="add"><i class="fa fa-plus-circle"></i> Add Data</button>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">

                                    </div>
									<div class="row" id="form_add">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Tambah Data</h2>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
									<form action="<?php echo $aksi."?module=add"; ?>" method="post" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">


										<input type="hidden" name="regid" value="<?php echo $sid; ?>">
										<input type="hidden" name="snama" value="<?php echo $snama; ?>">
										<input name="MAX_FILE_SIZE" type="hidden" value="3000000" />  
										<input type="hidden" name="userfile" type="file" accept="Camera" capture /> <hr>

										<div class="form-group">

                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No Peserta 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input name="nopeserta" type="text" id="nopeserta" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $snopeserta; ?>">
                                            </div>
                                        </div>
										

                                        <div class="form-group">

                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input name="nama" type="text" id="nama" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $snama; ?>">
                                            </div>
                                        </div>
                                 
									
										
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" name="upload" value="upload" class="btn btn-success">Photo</button>
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
												<th>Nama file </th>
                                                <th>Type</th>
												<th>File</th>
                                                <th>Ukuran</th>
												<th></th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
											$sqld="SELECT a.* from  ";
											$sqld= $sqld . " tr_document a  where regid='$sid' ";  
											$sqld= $sqld . "  LIMIT $posisi,$batas" ;
											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
										?>
                                            <tr>
                                               
                                                <td><?php echo $no; ?></td>
												<td><a href="<?php echo $r['file'] ?>" target="pdf-frame"><?php echo $r['nama_file']; ?> </a>
                                                <td><?php echo $r['tipe_file']; ?></td>
												<td><?php echo $r['file']; ?></td>
												<td><?php echo $r['ukuran_file']; ?></td>
												
                                                <th>
												
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Document" onclick="window.location='<?php echo $r['file'] ?>'"><i class="fa fa-file-pdf-o"></i> Document</button>

												<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="window.location='<?php echo $aksi."?module=delete&&sedit=".$r['sedit']; ?>'"><i class="fa fa-trash"></i> Hapus</button>
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
							$jmldata=mysql_num_rows(mysql_query("SELECT * from tr_document where  regid='$sid' "));
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
$sid=$_GET['id'];
$query=mysql_query("SELECT a.*  FROM tr_sppa a WHERE a.regid='$sid'");
$r=mysql_fetch_array($query);
$sregid=$r['regid'];
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
                                    <h2>Update <small><?php echo $r['regid']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                   
								<form action="<?php echo $aksi."?module=update"; ?>" enctype="multipart/form-data" method="post">  
									<div class='controls'>
									<div id="File button">
									<div style="position:absolute;">
									<label for="fileButton"><img src="images/camera.png" align="center" high="200" width="300"></label></div>
									<br /><br />
									<br /><br />

									<input id="fileButton" type="file" name="userfile" accept="Camera" capture />
									
									<?php //echo form_error('file');   ?> <br /><br />
									<br /><br /><br /><br /> <br /><br /><br /><br /><br /><br /></div>
									</div></div>
									
									<input type="hidden" name="regid" value="<?php echo $sregid; ?>">
									<input name="MAX_FILE_SIZE" type="hidden" value="1000000" />  

								<hr>
									<input type="submit" value="Upload Now" />
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

case "view":
$sid=$_GET['id'];
$query=mysql_query("SELECT a.*  FROM tr_sppa a WHERE a.regid='$sid'");
$r=mysql_fetch_array($query);
$sregid=$r['regid'];
$target='/uploads/' . $sregid . '.jpg';
$sphoto="photo/" . $sregid . ".jpg";

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
                                    <h2>View <small><?php echo $r['regid']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
								<a href="media.php?module=ajuan&&act=update&&id=<?php echo $sid; ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                                    <br />
                                   
								<form action="<?php echo $aksi."?module=balik"; ?>" enctype="multipart/form-data" method="post">  

						
								<div id="tabel_photo">
									<table class="table table-bordered">
									 <tbody>
										<?php
										
											$sqld="SELECT a.* from  ";
											$sqld= $sqld . " tr_document a  where regid='$sid' and pages='1212' ";  
											/* echo $sqld; */
											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											$sphoto	= $r['file'];
										?>
                                            <tr>
                                                <td>
												<img src="<?php echo $sphoto; ?>" alt="Avatar" style="high:30;width:30%;float:left;margin-right:10px;"> 
												</td>

											
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