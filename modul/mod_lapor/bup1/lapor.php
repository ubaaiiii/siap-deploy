<script>
	$(document).ready(function(){
		$("#form_add").css("display","none");
		$("#add").click(function(){
			$("#form_add").fadeToggle(1000);
		});
	});
</script>

	<style>
	#selec{
		width:500px;
	}
	</style>
<?php	
$mitra=$_SESSION['mitra']; 
$vlevel=$_SESSION['idLevel'];
$userid=$_SESSION['idLog'];


$sqle="select cabang from ms_admin where id_peg='$userid' ";
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$ucab=$r['cabang'];

$aksi="modul/mod_lapor/aksi_lapor.php";
switch(isset($_GET['act'])){
	default:
	$p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
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
                                    <h2>Laporan</h2>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form action="<?php echo $aksi."?module=print" ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
									<input type="hidden" name="level" value="<?php echo $vlevel; ?>">
									<input type="hidden" name="uid" value="<?php echo $userid; ?>">
									<input type="hidden" name="cab" value="<?php echo $ucab; ?>">

										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tanggal
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <fieldset>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                                            <input type="text" class="form-control has-feedback-left" name="tgl1" id="single_cal2" placeholder="Masukkan Tanggal" aria-describedby="inputSuccess2Status2">
                                                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                            <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                                                        </div>
                                                    </div>
                                                </div>
												</fieldset>
												
											 <fieldset>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                                            <input type="text" class="form-control has-feedback-left" name="tgl2" id="single_cal3" placeholder="Masukkan Tanggal" aria-describedby="inputSuccess2Status3">
                                                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                            <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            </div>
                                        </div>
										
										<div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-5">
                                                        <select class="select2_single form-control" tabindex="-1" name="sfilter1">
														 <option disabled selected name="t2">Pilih</option>
															<?php
																$query=mysql_query("SELECT msid scode ,msdesc sdesc FROM ms_master where mstype='produk' order by msdesc  ");
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
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cabang
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-5">
                                                        <select class="select2_single form-control" tabindex="-1" name="sfilter2">
														 <option disabled selected name="t2">Pilih</option>
															<?php
															
															
																$sqlc="SELECT msid scode ,msdesc sdesc FROM ms_master where mstype='cab' ";
																if ($vlevel=="mkt" or $vlevel=="smkt" )
																{
																$sqlc=$sqlc . " and msid='$ucab'  ";
																}
																$sqlc=$sqlc . "  order by msdesc  ";
																
																$query=mysql_query($sqlc);
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
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asuransi
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-5">
                                                        <select class="select2_single form-control" tabindex="-1" name="sfilter3">
														 <option disabled selected name="t2">Pilih</option>
															<?php
															
															
																$sqlc="SELECT msid scode ,msdesc sdesc FROM ms_master where mstype='asuransi' ";
																if ($vlevel=="insurance" )
																{
																$sqlc=$sqlc . " and msid='$ucab'  ";
																}
																$sqlc=$sqlc . "  order by msdesc  ";
																
																$query=mysql_query($sqlc);
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
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Laporan
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-5">
                                                        <select class="select2_single form-control" tabindex="-1" name="treport">
														 <option disabled selected name="t2">Pilih</option>
															<?php
															
																$sqlp="SELECT repid scode ,repname sdesc FROM ms_report where repid<>''  ";
																if ($vlevel=="mkt" or $vlevel=="smkt" )
																{
																$sqlp=$sqlp . " and cat='siap'  ";
																}
																
																//if ($vlevel=="checker" or $vlevel=="checker" )
																if ($vlevel=="checker" or $vlevel=="schecker" )
																{
																$sqlp=$sqlp . " and cat='siap'  ";
																}
																
																if ($vlevel=="insurance"  )
																{
																$sqlp=$sqlp . " and cat='siapin'  ";
																}
																
																if ($vlevel=="broker" )
																{
																$sqlp=$sqlp . " and cat='siap'  ";
																}
																$sqlp=$sqlp . "  order by repid  ";
																
																
																$query=mysql_query($sqlp);
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
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipe-ekstensi">Tipe Ekstensi File
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-5">
                                            <select class="select2_single form-control" tabindex="-1" name="tipe-ekstensi">
											 <option disabled selected name="t2">Pilih</option>
												<option value="xls">Laporan<b>.xls</b></option>
												<option value="csv">Laporan<b>.csv</b></option>
												<!--<option value="doc">Laporan<b>.doc</b></option>-->
												
											</select>
                                        </div>
									</div>
									
								
                                        
                                      
										<input type="hidden" value="<?php echo $idLog; ?>" name="onlog">
                                       
												
                                        
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
                    </div>
                </div>
            </div>

<?php
break;
}
?>