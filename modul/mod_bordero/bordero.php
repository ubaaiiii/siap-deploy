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

$aksi="modul/mod_bordero/aksi_bordero.php";
$judul="Bordero";
$userid=$_SESSION['idLog'];
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Period#1
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="period1" type="date" id="period1" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
                                       
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Period#2
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input name="period2" type="date" id="period2" required="required" class="form-control col-md-7 col-xs-12">
											</div>
											
                                        </div>
										
										
										<div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-5">
                                                        <select class="select2_single form-control" tabindex="-1" name="sfilter3" id="selec">
														 <option disabled selected name="t2">Pilih</option>
															<?php
																$query=mysql_query("SELECT msid scode ,msdesc sdesc FROM ms_master where mstype='produk' and msid<>'ALL' order by msdesc  ");
																while($r=mysql_fetch_array($query)){
															?>
															
															<option value="<?php echo $r['scode'] ?>"><?php echo $r['sdesc']; ?></option>
															<?php
															}
															?>
														</select>
                                                    </div>
													
										</div>
										
										<div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-5">
                                                        <select class="select2_single form-control" tabindex="-1" name="sfilter4" id="selec">
														 <option disabled selected name="t2">Pilih</option>
															<?php
																$sqlst="select msid scode ,msdesc sdesc FROM ms_master where mstype='BLIST'   order by msdesc";
																$query=mysql_query($sqlst);
																while($r=mysql_fetch_array($query)){
															?>
															
															<option value="<?php echo $r['scode'] ?>"><?php echo $r['sdesc']; ?></option>
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
                                               
                                                <th>No</th>
												<th>Tanggal</th>
                                                <th>period#1</th>
												<th>period#2</th>
												<th>Asuransi</th>
												<th>Produk</th>
												<th>Premi</th>
												<th></th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
											$sqlb=" SELECT a.borderono,a.reffdt,b.reffamt,a.status,a.period1,a.period2,a.branch asuransi,a.produk from tr_bordero a ";
											$sqlb = $sqlb . " inner join ( ";
											$sqlb = $sqlb . " SELECT c.borderono,SUM(c.premi) reffamt FROM tr_bordero_dtl  c  ";
											$sqlb = $sqlb . " group by c.borderono ) b   ";
											$sqlb = $sqlb . " on a.borderono=b.borderono  order by a.borderono desc LIMIT $posisi,$batas ";
											/* echo $sqlb; */
											$query=mysql_query($sqlb);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                               
                                               
												<td><?php echo $r['borderono']; ?></td>
                                                <td><?php echo $r['reffdt']; ?></td>
												<td><?php echo $r['period1']; ?></td>
												<td><?php echo $r['period2']; ?></td>
												<td><?php echo $r['asuransi']; ?></td>
												<td><?php echo $r['produk']; ?></td>
												<td><?php echo number_format($r['reffamt'],0); ?></td>
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Detail" onclick="window.location='media.php?module=borderodtl&&id=<?php echo $r['borderono']; ?>'"><i class="fa fa-search"></i> Detail</button>
												
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Sertifikat" onclick="window.location = 'laporan/bordero/f_bordero.php?id=<?php echo $r['borderono']; ?>'"><i class="fa fa-print"></i> Print</button>
												
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Export" onclick="window.location='<?php echo $aksi."?module=export&&id=" . $r['borderono']; ?>'"><i class="fa fa-check-square"></i> Export</button>
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
							$jmldata=mysql_num_rows(mysql_query("SELECT borderono from tr_bordero   "));
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

case "detail":
$id=$_GET['id'];

$p      = new Paging;
$batas  = 100;
$posisi = $p->cariPosisi($batas);

$query=mysql_query("SELECT borderono,concat(left(period1,10), ' s/d ', left(period2,10)) period,branch FROM tr_bordero where borderono='$id'");
$r=mysql_fetch_array($query);
$borderono=$r['borderono'];
?>
<div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $judul; ?></h3>
                        </div>

                     
                    </div>



                   <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
									<div class="col-md-6 col-sm-6 col-xs-12">
                                    <h2>View <small><?php echo $borderono; ?></small></h2>
									</div>
								
                                    
                                </div>
                               
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
										<input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Period
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="period" name="period" readonly  class="form-control col-md-7 col-xs-12" value="<?php echo $r['period']; ?>">
												
                                            </div>
                                        </div>
                                  
										
										
									<div id="hasil"></div>
									<div id="tabel_awal">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                                <th>No Peserta</th>
												<th>Nama </th>
                                                <th>Cabang</th>
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
											$sqlb= $sqlb . " b.mulai,b.akhir,b.nopeserta ";
											$sqlb= $sqlb . " from tr_bordero_dtl a left join tr_sppa b on a.regid=b.regid ";
											$sqlb= $sqlb . " where a.borderono='$id'  order by a.borderono asc LIMIT $posisi,$batas ";
											echo $sqlb;
											$query=mysql_query($sqlb);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                               
                                               
												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo $r['cabang']; ?></td>
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
							$jmldata=mysql_num_rows(mysql_query("SELECT borderono from tr_bordero_dtl where borderono='$id'   "));
							$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
							$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman); 
							echo "$linkHalaman";
							
							?>
                                </div>
										
										
										
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                           
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

case "adddetail":
$id=$_GET['id'];

$p      = new Paging;
$batas  = 10;
$posisi = $p->cariPosisi($batas);

$query=mysql_query("SELECT borderono,concat(left(period1,10), ' s/d ', left(period2,10)) period,branch FROM tr_bordero where borderono='$id'");
$r=mysql_fetch_array($query);
$borderono=$r['borderono'];
?>
<div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $judul; ?></h3>
                        </div>

                     
                    </div>



                   <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
									<div class="col-md-6 col-sm-6 col-xs-12">
                                    <h2>Add Detail Bordero <small><?php echo $borderono; ?></small></h2>
									</div>
								
                                    
                                </div>
                          
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=adddetail"; ?>">
										<input type="hidden" name="userid" value="<?php echo $userid; ?>">
										<input type="hidden" name="borderono" value="<?php echo $borderono; ?>">
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Peserta 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                               <select class="select2_single form-control" tabindex="-2" name="regid" id="selec">
													
													<?php
													$qtahun=mysql_query("select ms.regid comtabid,concat(ms.nama,' - ',ms.nopeserta)  comtab_nm from tr_sppa ms   where status in (4,5,6,7)  order by ms.nama  asc ");
													while($rpro=mysql_fetch_array($qtahun)){
													?>
													<option value="<?php echo $rpro['comtabid']; ?>"><?php echo $rpro['comtab_nm']; ?></option>
													<?php
													}
													?>
												
												</select>
                                            </div>
										</div>

										
										

                                </div>
										
										
										
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                               <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=bordero&&act=detail&&id=<?php echo $borderono; ?>'"><i class="fa fa-arrow-left"></i> Back</button>
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