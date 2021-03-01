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
			 url:"modul/mod_msrate/cari.php",
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

$aksi="modul/mod_msrate/aksi_msrate.php";
$judul="Master Rates";
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
											$sqlq="SELECT a.*,b.msdesc sproduk,concat(produk,jkel,umurb,umura,insperiodyy,insperiodmm) ";
											$sqlq=$sqlq . " from tr_rates a left join ms_master b on a.produk=b.msid and b.mstype='produk' ";
											$sqlq=$sqlq . " order by produk,jkel,umurb,insperiodmm,gpb ASC LIMIT $posisi,$batas";
											$query=$db->query($sqlq);
											$num=$query->num_rows();
											$no=1;
											while( $r = $query->fetch_array() ){
											
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
									</div>
									<?php
        							$jmldata=$db->query("SELECT * from tr_rates   ")->num_rows;
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
$query=$db->query("SELECT * FROM tr_rates where concat(produk,jkel,umurb,umura,insperiodyy,insperiodmm)='$id'");
$r=$query->fetch_array();
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Code
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="code" name="code" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['msid']; ?>">
												
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="desk" name="desk" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['msdesc']; ?>">
                                            </div>
                                        </div>
										
										
										
										
										
										
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                               <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=item'"><i class="fa fa-arrow-left"></i> Back</button>
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