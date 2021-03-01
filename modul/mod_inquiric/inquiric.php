<script type="text/javascript" src="/path/to/jquery.js"></script>
<script type="text/javascript" src="/path/to/moment.js"></script>
<script type="text/javascript" src="/path/to/bootstrap/js/transition.js"></script>
<script type="text/javascript" src="/path/to/bootstrap/js/collapse.js"></script>
<script type="text/javascript" src="/path/to/bootstrap/dist/bootstrap.min.js"></script>
<script type="text/javascript" src="/path/to/bootstrap-datetimepicker.min.js"></script>

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
			 url:"modul/mod_inquiric/cari.php",
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
$veid=$_SESSION['id_peg'];
$vempname=$_SESSION['empname'];
$vlevel=$_SESSION['idLevel'];
$userid=$_SESSION['idLog'];
$aksi="modul/mod_inquiric/aksi_inquiric.php";
$judul="Inquiry";

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
												<th>Cabang </th>
											    <th>Produk </th>
												<th>AO </th>
												<th>No Register </th>
                                                <th>Nama</th>
												<th>Tgl Lahir</th>
												<th>Mulai</th>
												<th>UP</th>
												<th>Premi</th>
												<th>Status</th>
												<th></th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
											$sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up, ";
											$sqlr= $sqlr . " aa.premi,aa.cabang,aa.produk,ab.msdesc cab,aa.tpremi , ";
											$sqlr= $sqlr . " ac.msdesc proddesc,aa.mulai,ad.msdesc sts,aa.createby  from tr_sppa aa  ";
											$sqlr= $sqlr . " left join ms_master ab on aa.cabang=ab.msid and ab.mstype='cab'";
											$sqlr= $sqlr . " left join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' ";
											$sqlr= $sqlr . " left join ms_master ad on aa.status=ad.msid and ad.mstype='STREQ' ";
											$sqlr= $sqlr . " where  LEFT(aa.createdt,10)>=LEFT(date_add(now(), INTERVAL -5 DAY),10) order by aa.regid desc LIMIT $posisi,$batas";
											/* echo $sqlr; */
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>

												<td><?php echo $r['cab']; ?></td>
												<td><?php echo $r['proddesc']; ?></td>
												<td><?php echo $r['createby']; ?></td>
												<td><?php echo $r['regid']; ?></td>
                                                <td><?php echo $r['nama']; ?></td>
												<td><?php echo tglindo_balik($r['tgllahir']); ?></td>
												<td><?php echo tglindo_balik($r['mulai']); ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo number_format($r['tpremi'],0); ?></td>
												<td><?php echo $r['sts']; ?></td>
												
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=inquiric&&act=view&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> view</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=inquiric&&act=log&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Log</button>
												</th>

                                            </tr>
										<?php
			
										}
										?>
                                        </tbody>
                                    </table>
									</div>
									<?php
							$sqlp="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up, ";
							$sqlp= $sqlp . " aa.premi,aa.cabang,aa.produk,ab.msdesc proddesc,aa.tpremi , ";
							$sqlp= $sqlp . " ac.msdesc cab,aa.mulai,ad.msdesc sts  from tr_sppa aa  ";
							$sqlp= $sqlp . " left join ms_master ab on aa.cabang=ab.msid and ab.mstype='cab'";
							$sqlp= $sqlp . " left join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' ";
							$sqlp= $sqlp . " left join ms_master ad on aa.status=ad.msid and ad.mstype='STREQ'  where LEFT(aa.createdt,10)>=LEFT(date_add(now(), INTERVAL -5 DAY),10) ";
							$jmldata=mysql_num_rows(mysql_query($sqlp));
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

case "view":
$sid=$_GET['id'];

$sqle="select aa.*,ab.msdesc tstatus ";
$sqle= $sqle . " from tr_sppa aa  left join ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' ";
$sqle= $sqle . " where aa.regid='$sid'";

/* echo $sqle;  */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$scabang=$r['cabang'];
$smitra=$r['mitra'];
$produk=$r['produk'];
$ssubject=$r['subject'];
$sregid=$r['regid'];
$sproduk=$r['produk'];
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
                                    <h2>view <small><?php echo $r['reqid']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
									<input type="hidden" name="id" value="<?php echo $sregid; ?>">
									<input type="hidden" name="userid" value="<?php echo $userid; ?>">
									<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
									<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="produk" id="produk" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sproduk){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
										</div>	
									<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Peserta 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="regid" name="regid"  readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
												
                                            </div>	
                                        </div>									
									
									
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nopeserta" name="nopeserta"  readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
												
                                            </div>	
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nama" name="nama" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
												
                                            </div>
                                        </div>
										
										

										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                   <input type="text" id="tgllahir" name="tgllahir" min="6" max="100" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tgllahir']); ?>"  >
												
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="int" id="usia" name="usia"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="noktp" name="noktp"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Kelamin 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='jkel'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sjkel){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>	


										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mitra 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="mitra" id="mitra" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
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
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="cabang" id="cabang" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Pekerjaan
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$spekerjaan){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>							

										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="masa" name="masa" min="6" max="100" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >
												
                                            </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="mulai" name="mulai" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['mulai']); ?>" >
												
                                            </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="akhir" name="akhir"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['akhir']); ?>">
												
                                            </div>
                                        </div>

										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="up" name="up"  readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up']); ?>" >
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Premi  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="premi" name="premi"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['premi'],0); ?>">
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Extra Premi 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="epremi" name="epremi"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['epremi'],0); ?>">
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Status 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                   <input type="text" id="tstatus" name="tstatus"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tstatus']; ?>">
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal bayar 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="mulai" name="mulai" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_yyyymmdd($r['paiddt']); ?>" >
												
                                            </div>
                                        </div>					
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Grace Preiod (Khusus MPP) 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="gp" name="gp" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tunggakan']; ?>" >
												
                                            </div>
                                        </div>																		
										
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($ssubject)); ?></textarea>                                            
											</div>
                                        </div>
										<div id="tabel_awal">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                               
                                                <th>No</th>
												<th>Nama file </th>
                                                <th>Type</th>
                                                <th>Ukuran</th>
												<th></th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
											$sqld="SELECT a.* from  ";
											$sqld= $sqld . " tr_document a  where regid='$sid' ";  
											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
										?>
                                            <tr>
                                               
                                                <td><?php echo $no; ?></td>
												<td><a href="<?php echo $r['file'] ?>" target="pdf-frame"><?php echo $r['nama_file']; ?> </a>
                                                <td><?php echo $r['tipe_file']; ?></td>
												<td><?php echo $r['ukuran_file']; ?></td>
												
                                                <th>
												

											
												
												<a href="<?php echo $r['file'] ?>" target="pdf-frame" class="btn btn-sm btn-default"><i class="fa fa-file-pdf-o"></i> Document</a>
												</th>
												
											
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
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=inquiric'"><i class="fa fa-arrow-left"></i> Back</button>
										
                                            </div>
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

case "log":
$sid=$_GET['id'];

$sqle="select aa.* ";
$sqle= $sqle . " from tr_sppa aa ";
$sqle= $sqle . " where aa.regid='$sid'";

/* echo $sqle;  */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$scabang=$r['cabang'];
$smitra=$r['mitra'];
$sproduk=$r['produk'];
$ssubject=$r['subject'];
$sregid=$r['regid'];
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
                                    <h2>Log Status <small><?php echo $r['reqid']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
									<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
									<input type="hidden" name="userid" value="<?php echo $userid; ?>">
									<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
 								
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
											$sqll="SELECT a.*,b.msdesc statpol from tr_sppa_log a inner join ms_master b on a.status=b.msid and b.mstype='STREQ' ";
											$sqll=$sqll . " where a.regid='$sid'  ";
											/* echo $sqll; */
											$query=mysql_query($sqll);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                               
                                                <td><?php echo $r['status']; ?></td>
												<td><?php echo $r['statpol']; ?></td>
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
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=inquiric'"><i class="fa fa-arrow-left"></i> Back</button>

                                            </div>
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