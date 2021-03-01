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
$aksi="modul/mod_notif/aksi_notif.php";
$iddata=$_GET['eid'];
$judul="Notifikasi";
$sid=$_GET['id'];
$sdid=$_GET['did'];

$vlevel=$_SESSION['idLevel'];
$userid=$_SESSION['idLog'];
$ucab=$_SESSION['ucab'];

date_default_timezone_set('Asia/Jakarta');

$query=mysql_query("SELECT a.nama FROM tr_sppa a WHERE regid='$sid'");
$r=mysql_fetch_array($query);
$snama=$r['nama'];
$scond = array('0','1');
$sfield = $r['status'] ;	
$scond0 = array('01','01');
$sfield0= $sdid ;	
$scond1 = array('23','7','8');
$sfield1= $sdid ;	


$judul2=$sid." - ".$snama;
switch($_GET['act']){
	default:
	$p      = new Paging;
    $batas  = 100;
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
									<a href="media.php?module=home" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a>

									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">

                                    </div>
									<div class="row" id="form_add">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                  
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
									<form action="" method="post" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">


										
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
                                               


												<th>Kode</th>
												<th>Deskripsi </th>
												<th>Jumlah </th>
												<th></th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
											$sqld="select  aa.status,ms.msdesc, sts from  ";
											$sqld= $sqld . "  (select status,count(1) sts from tr_sppa  ";
											if ($vlevel=="checker" or $vlevel=="schecker")
											{
											$sqld= $sqld . "where cabang ='$ucab'";
											}
											
											if ($vlevel=="mkt" )
											{
											$sqld= $sqld . "where createby ='$userid'";
											}
											
											$sqld= $sqld . " group by status) aa ";
											$sqld= $sqld . " inner join ms_master ms on aa.status=ms.msid and ms.mstype='STREQ' ";
											
											$sqld= $sqld . " order by aa.status asc  LIMIT $posisi,$batas" ;
											/* echo $sqld; */
											
											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                               

                                                <td><?php echo $r['status']; ?></td>
												<td><?php echo $r['msdesc']; ?></td>
												<td><?php echo number_format($r['sts'],0); ?></td>

                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="detail" onclick="window.location='media.php?module=notif&&act=stat&&id=<?php echo $r['status']; ?>'"><i class="fa fa-search"></i> Detail</button>
												
																								
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
							$sqlt="select left(mulai,7) smonth , ";
							$sqlt= $sqlt . " sum(up) sup,count(regid) smem ,sum(tpremi) stpremi from tr_sppa  ";  
							$sqlt= $sqlt . "  group by left(mulai,7) ";
							$jmldata=mysql_num_rows(mysql_query($sqlt));
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

case "stat":
$sid=$_GET['id'];

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
                                    <h2>status <small><?php echo $sid; ?></small></h2>
                                    
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
                                               
                                                <th>Produk</th>
												<th>Cabang</th>
												<th>No Register</th>
												<th>Nama </th>
                                                <th>Up</th>
												<th>Premi</th>
												<th>Status</th>
												<th></th>
												
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											$sqld="select ad.msdesc sproduk,ac.msdesc scabang,ab.regid,ab.nama,ab.sup,ab.premi,ab.status,ae.msdesc streq ";
											$sqld= $sqld . " from (select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.nopeserta,aa.up,aa.premi,aa.mulai, ";
											$sqld= $sqld . " aa.produk,aa.status,aa.cabang,case when aa.up='' then 0 else aa.up end sup from tr_sppa aa  ";
											$sqld= $sqld . " where aa.status='$sid') ab  ";
											$sqld= $sqld . " left join ms_master ac on ac.msid=ab.cabang and ac.mstype='cab' ";
											$sqld= $sqld . " left join ms_master ad on ad.msid=ab.produk and ad.mstype='PRODUK' ";
											$sqld= $sqld . " left join ms_master ae on ae.msid=ab.status and ae.mstype='streq' order by ab.regid desc limit 100 ";
											 /* echo $sqld;   */
											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
												<td><?php echo $r['sproduk']; ?></td>
												<td><?php echo $r['scabang']; ?></td>
                                                <td><?php echo $r['regid']; ?></td>
												<td><?php echo $r['nama']; ?></td>
												<td><?php echo number_format($r['sup'],0); ?></td>
												<td><?php echo number_format($r['premi'],0); ?></td>
												<td><?php echo $r['streq']; ?></td>
												 <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Detail" onclick="window.location='media.php?module=notif&&act=detreg&&id=<?php echo  $r['regid']; ?>'"><i class="fa fa-search"></i> Detail</button>
												
																								
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
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=notif'"><i class="fa fa-arrow-left"></i> Back</button>

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

case "detreg":
$regid=$_GET['id'];

$sqle="select aa.*,ab.msdesc tstatus ";
$sqle= $sqle . " from tr_sppa aa  left join ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' ";
$sqle= $sqle . " where aa.regid='$regid'";

/* echo $sqle;  */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$scabang=$r['cabang'];
$smitra=$r['mitra'];
$produk=$r['produk'];
$ssubject=$r['comment'];
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
												<option value="" selected="selected">-- choose produk --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$produk){ ?> selected="selected" <? }?>> 
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
												<textarea disabled name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($ssubject)); ?></textarea>                                            
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
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=notif'"><i class="fa fa-arrow-left"></i> Back</button>
										
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