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
			 url:"modul/mod_claim/cari.php",
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
$aksi="modul/mod_claim/aksi_claim.php";
$judul="Claim";

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
									
									   <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl lapor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tgllapor" name="tgllapor"  required="required" class="form-control col-md-7 col-xs-12" >
												
                                            </div>	
                                        </div>
										
										

										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Kejadian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tglkejadian" name="tglkejadian"  required="required" class="form-control col-md-7 col-xs-12" >
												
                                            </div>	
                                        </div>
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Pelapor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="pelapor" name="pelapor"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">
												
                                            </div>	
                                        </div>
										
								
									   <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Detail Kejadian  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($ssubject)); ?></textarea>                                            
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
                                               
												<th>No Claim </th>
                                                <th>No Peserta</th>
												<th>Nama</th>
												<th>Tgl Lapor</th>
												<th>Tgl Kejadian</th>
												<th>UP</th>
												<th>Status</th>
												<th></th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
											$sqlr="select aa.regid,ab.nama,ab.noktp,ab.tgllahir,ab.up,ab.nopeserta,ab.up,ab.premi,aa.tglkejadian,aa.tgllapor,aa.regclaim ";
											$sqlr= $sqlr . " ,aa.statclaim from tr_claim aa inner join tr_sppa ab on aa.regid=ab.regid  ";
											$sqlr= $sqlr . " order by aa.regid desc LIMIT $posisi,$batas";
											/* echo $sqlr; */
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>

												<td><?php echo $r['regclaim']; ?></td>
                                                <td><?php echo $r['nopeserta']; ?></td>
												<td><?php echo $r['nama']; ?></td>
												<td><?php echo $r['tgllapor']; ?></td>
												<td><?php echo $r['tglkejadian']; ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo $r['statclaim']; ?></td>
												
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=claim&&act=update&&id=<?php echo $r['regclaim']; ?>'"><i class="fa fa-search"></i> Edit</button>
												
												</th>

                                            </tr>
										<?php
			
										}
										?>
                                        </tbody>
                                    </table>
									</div>
									<?php
							$sqlp="select * from tr_sppa where status='2' ";
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

case "update":
$sid=$_GET['id'];

$sqle="select aa.regclaim,aa.regid,ab.nopeserta,aa.tgllapor,aa.tglkejadian,ab.nama,ab.up,ab.masa,ab.mulai,ab.akhir ";
$sqle= $sqle . " ,ab.tgllahir,ab.usia,aa.pelapor,aa.detail from tr_claim  aa inner join tr_sppa ab on aa.regid=ab.regid";
$sqle= $sqle . " where aa.regclaim='$sid'";

/* echo $sqle; */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$susia= $r['usia'] . ' Tahun' . ' / ' . $r['tgllahir']  ;
$smasaas=$r['masa'] . ' Bulan / ' . $r['mulai']  .' s/d '. $r['akhir'] ;
$sdetail=$r['detail'];

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
                                    <h2>Update <small><?php echo $r['reqid']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
									<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
									<input type="hidden" name="userid" value="<?php echo $userid; ?>">
									<input type="hidden" name="regid" value="<?php echo $sregid; ?>">
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Claim 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="regclaim" name="regclaim"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regclaim']; ?>">
												
                                            </div>	
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Peserta 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nopeserta" name="nopeserta"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
												
                                            </div>	
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nama" name="nama"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia /Tgl Lahir
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="susia" name="susia" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $susia; ?>">
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="masaas" name="masaas" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $smasaas; ?>">
												
                                            </div>
                                        </div>

										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="up" name="up"   readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'],0); ?>" >
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lapor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tgllapor" name="tgllapor"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tgllapor']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Kejadian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tglkejadian" name="tglkejadian"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tglkejadian']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Pelapor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="pelapor" name="pelapor"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['pelapor']; ?>">
												
                                            </div>
                                        </div>
											
										
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Detail  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($sdetail)); ?></textarea>                                            
											</div>
                                        </div>
		
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=verif'"><i class="fa fa-arrow-left"></i> Back</button>
											<button type="submit" class="btn btn-sm btn-default">Submit</button>
											<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="document Claim" onclick="window.location='media.php?module=docclaim&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Doc</button>
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

case "reject":
$sid=$_GET['id'];

$sqle="select aa.regclaim,aa.regid,ab.nopeserta,aa.tgllapor,aa.tglkejadian,ab.nama,ab.up,ab.masa,ab.mulai,ab.akhir ";
$sqle= $sqle . " ,ab.tgllahir,ab.usia,aa.pelapor,aa.detail from tr_claim  aa inner join tr_sppa ab on aa.regid=ab.regid";
$sqle= $sqle . " where aa.regclaim='$sid'";

/* echo $sqle; */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$susia= $r['usia'] . ' Tahun' . ' / ' . $r['tgllahir']  ;
$smasaas=$r['masa'] . ' Bulan / ' . $r['mulai']  .' s/d '. $r['akhir'] ;
$sdetail=$r['detail'];

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
                                    <h2>Rejection <small><?php echo $r['reqid']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
									<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
									<input type="hidden" name="userid" value="<?php echo $userid; ?>">
									<input type="hidden" name="regid" value="<?php echo $sregid; ?>">
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Claim 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="regclaim" name="regclaim"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regclaim']; ?>">
												
                                            </div>	
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Peserta 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nopeserta" name="nopeserta"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
												
                                            </div>	
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nama" name="nama"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia /Tgl Lahir
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="susia" name="susia" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $susia; ?>">
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="masaas" name="masaas" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $smasaas; ?>">
												
                                            </div>
                                        </div>

										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="up" name="up"   readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'],0); ?>" >
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lapor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tgllapor" name="tgllapor"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tgllapor']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Kejadian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tglkejadian" name="tglkejadian"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tglkejadian']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Pelapor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="pelapor" name="pelapor"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['pelapor']; ?>">
												
                                            </div>
                                        </div>
											
										
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Detail  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($sdetail)); ?></textarea>                                            
											</div>
                                        </div>
		
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=verif'"><i class="fa fa-arrow-left"></i> Back</button>
											<button type="submit" class="btn btn-sm btn-default">Reject</button>
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