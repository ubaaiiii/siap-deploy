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
			 url:"modul/mod_bordero/cari.php",
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
$id=$_GET['id'];
$aksi="modul/mod_borderodtl/aksi_borderodtl.php";
$judul="Bordero Detail";
$judul1="No : " . $id ;
$userid=$_SESSION['idLog'];

$query=mysql_query("SELECT borderono,concat(left(period1,10), ' s/d ', left(period2,10)) period,branch FROM tr_bordero where borderono='$id'");
$r=mysql_fetch_array($query);
$borderono=$r['borderono'];

switch($_GET['act']){
	default:
	$p      = new Paging;
    $batas  = 1000;
    $posisi = $p->cariPosisi($batas);

?>
<div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $judul; ?></h3>
							<h3><?php echo $judul1; ?></h3>
                        </div>
                        </div>
						
					</div>
                    <div class="clearfix"></div>


                    <div class="row">
                                <div class="x_content">
									<div class="col-md-6 col-sm-6 col-xs-12">
										 <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=bordero'"><i class="fa fa-arrow-left"></i> Back</button>
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
                                                <th>Poduk</th>
											    <th>Cabang</th>
                                                <th>No Register</th>
												<th>Nama </th>
                                                <th>Mulai</th>
												<th>Akhir</th>
												<th>No PK</th>
												<th>UP</th>
												<th>Premi</th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											$sqlb="SELECT a.*,b.nama,b.cabang,b.up,b.tpremi,concat(a.borderono,a.regid) sbordero, ";
											$sqlb= $sqlb . " b.mulai,b.akhir,b.nopeserta,c.msdesc cab,d.msdesc prod ";
											$sqlb= $sqlb . " from tr_bordero_dtl a left join tr_sppa b on a.regid=b.regid ";
											$sqlb= $sqlb . " left join ms_master c on b.cabang=c.msid and c.mstype='cab'";
											$sqlb= $sqlb . " left join ms_master d on d.msid=b.produk and d.mstype='produk' ";
											$sqlb= $sqlb . " where a.borderono='$id'  order by a.regid desc LIMIT $posisi,$batas ";
											/* echo $sqlb;  */
											$query=mysql_query($sqlb);
											$num=mysql_num_rows($sqlb);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                                <td><?php echo $r['prod']; ?></td>
                                                <td><?php echo $r['cab']; ?></td>
												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo $r['mulai']; ?></td>
												<td><?php echo $r['akhir']; ?></td>
												<td><?php echo $r['nopeserta']; ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo number_format($r['tpremi'],0); ?></td>
												
												
											
                                            </tr>
										<?php
										$no++;
										}
										?>
                                        </tbody>
                                    </table>
									</div>
									<?php
							$sqlr="select regid from tr_borderodtl  ";
							$jmldata=mysql_num_rows(mysql_query($sqlr));
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
}
?>