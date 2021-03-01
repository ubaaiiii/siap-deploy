<!--<script type="text/javascript" src="/path/to/jquery.js"></script>-->
<!--<script type="text/javascript" src="/path/to/moment.js"></script>-->
<!--<script type="text/javascript" src="/path/to/bootstrap/js/transition.js"></script>-->
<!--<script type="text/javascript" src="/path/to/bootstrap/js/collapse.js"></script>-->
<!--<script type="text/javascript" src="/path/to/bootstrap/dist/bootstrap.min.js"></script>-->
<!--<script type="text/javascript" src="/path/to/bootstrap-datetimepicker.min.js"></script>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->

<script>
function tandaPemisahTitik(b){
	var _minus = false;
	if (b<0) _minus = true;
	b = b.toString();
	b=b.replace(".","");
	b=b.replace("-","");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--){
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)){
			c = b.substr(i-1,1) + "." + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	if (_minus) c = "-" + c ;
	return c;
}

function numbersonly(ini, e){
	if (e.keyCode>=49){
		if(e.keyCode<=57){
			a = ini.value.toString().replace(".","");
			b = a.replace(/[^\d]/g,"");
			b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
			ini.value = tandaPemisahTitik(b);
			return false;
		}
		else if(e.keyCode<=105){
			if(e.keyCode>=96){
				//e.keycode = e.keycode - 47;
				a = ini.value.toString().replace(".","");
				b = a.replace(/[^\d]/g,"");
				b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
				ini.value = tandaPemisahTitik(b);
				//alert(e.keycode);
				return false;
			}
			else {return false;}
		}
		else {
			return false; }
		}else if (e.keyCode==48){
			a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
			b = a.replace(/[^\d]/g,"");
			if (parseFloat(b)!=0){
				ini.value = tandaPemisahTitik(b);
				return false;
			} else {
				return false;
			}
		}else if (e.keyCode==95){
			a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
			b = a.replace(/[^\d]/g,"");
			if (parseFloat(b)!=0){
				ini.value = tandaPemisahTitik(b);
				return false;
			} else {
				return false;
			}
		}else if (e.keyCode==8 || e.keycode==46){
			a = ini.value.replace(".","");
			b = a.replace(/[^\d]/g,"");
			b = b.substr(0,b.length -1);
			if (tandaPemisahTitik(b)!=""){
				ini.value = tandaPemisahTitik(b);
			} else {
				ini.value = "";
			}

			return false;
		} else if (e.keyCode==9){
			return true;
		} else if (e.keyCode==17){
			return true;
		} else {
			//alert (e.keyCode);
			return false;
		}

	}
</script>


<script type="text/javascript">
	$(document).ready(function(){
		var d = new Date();

		function twoDigitDate(d){
			return ((d.getDate()).toString().length == 1) ? "0"+(d.getDate()).toString() : (d.getDate()).toString();
		};

		function twoDigitMonth(d){
			return ((d.getMonth()+1).toString().length == 1) ? "0"+(d.getMonth()+1).toString() : (d.getMonth()+1).toString();
		};

		var today_ISO_date = d.getFullYear()+"-"+twoDigitMonth(d)+"-"+twoDigitDate(d); // in yyyy-mm-dd format

		// document.getElementById('datepicker').setAttribute("value", today_ISO_date);
		//
		// var dd_mm_yyyy;
		// $("#datepicker").change( function(){
		// 	changedDate = $(this).val(); //in yyyy-mm-dd format obtained from datepicker
		// 	var date = new Date(changedDate);
		// 	dd_mm_yyyy = twoDigitDate(date)+"/"+twoDigitMonth(date)+"/"+date.getFullYear(); // in dd-mm-yyyy format
		// 	$('#textbox').val(dd_mm_yyyy);
		// 	//console.log($(this).val());
		// 	//console.log("Date picker clicked");
		// });

	});

</script>

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
					url:"modul/mod_cekfoto/cari.php",
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
        
        var tablenya = "";
		var intervalnya = setInterval(function(){
			var sebelumnya = parseInt($('#jumlah-sebelumnya').text());
			if (!$("#txtcari").val()){
				$('#tabel_awal').css('display','none');
				$("#hasil").removeAttr('style');
				$("#hasil").html(tablenya);
				$.ajax({
					type:"post",
					url:"modul/mod_cekfoto/table_cekfoto.php",
					success: function(data){
					    var datajson = JSON.parse(data);
						var setelahnya = datajson.num;
						if (sebelumnya !== setelahnya) {
						    console.log(datajson.num);
							tablenya = datajson.table;
							$("#jumlah-sebelumnya").text(setelahnya);
						}
					}
				});
			}
		},1000);
	
	});
</script>
<?php

date_default_timezone_set('Asia/Jakarta');

$veid=$_SESSION['id_peg'];
$vempname=$_SESSION['empname'];
$vlevel=$_SESSION['idLevel'];
$userid=$_SESSION['idLog'];
$aksi="modul/mod_cekfoto/aksi_cekfoto.php";
$judul="Cek Foto";

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
										<input type="hidden" name="userid" value="<?php echo $userid; ?>">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Produk
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select class="select2_single form-control" tabindex="-2" name="produk" id="selec">

													<?php
													$qtahun=mysql_query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk'  order by ms.msdesc  asc ");
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
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="nama" name="nama"  required="required" class="form-control col-md-7 col-xs-12" >

											</div>
										</div>


										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="noktp" name="noktp"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">

											</div>
										</div>




										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Jenis Kelamin
											</label>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<select class="select2_single form-control" tabindex="-2" name="jkel" id="selec">

													<?php
													$qtahun=mysql_query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc ");
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
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Pekerjaan
											</label>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<select class="select2_single form-control" tabindex="-2" name="pekerjaan" id="selec">

													<?php
													$qtahun=mysql_query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA'  order by ms.msdesc  asc ");
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
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Cabang
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select class="select2_single form-control" tabindex="-2" name="cabang" id="selec">

													<?php
													$qtahun=mysql_query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB'  order by ms.msdesc  asc ");
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
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mitra
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<select class="select2_single form-control" tabindex="-2" name="mitra" id="selec">

													<?php
													$qtahun=mysql_query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc ");
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
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Lahir
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">


												<input type="date" id="tgllahir" name="tgllahir"  value="dd-mm-yyyy" required="required" class="form-control col-md-7 col-xs-12" >

											</div>
										</div>


										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="date" id="mulai" name="mulai"  required="required" class="form-control col-md-7 col-xs-12" >

											</div>
										</div>


										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="number" id="masa" name="masa" min="1" max="216" placeholder="dalam bulan" required="required" class="form-control col-md-7 col-xs-12" >

											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Uang Pertanggungan
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="up" name="up"  placeholder="dalam rupiah" required="required" class="form-control col-md-7 col-xs-12" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan
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
					<p>Cek Foto Tersisa: </p><span id="jumlah-sebelumnya"></span></p>
					<div id="tabel_awal">
						<span style="display:none" id="data-sebelumnya"></span>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Cabang </th>
									<th>Produk </th>
									<th>No Register </th>
									<th>Nama</th>
									<th>UP</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php

								$sqlr = "select a.regid,a.nama,a.noktp,tgllahir,up,nopeserta,up,premi,mulai,ab.msdesc cab, ac.msdesc proddesc, a.createby ";
								$sqlr.= "from tr_sppa a ";
								$sqlr.= "left join (select regid from tr_sppa_log where  status=13) b on a.regid = b.regid ";
								$sqlr.= "left join ms_master ab on a.cabang=ab.msid and ab.mstype='cab' ";
								$sqlr.= "left join ms_master ac on ac.msid=a.produk and ac.mstype='produk' ";
								$sqlr.= "where b.regid is null and a.status='1' ";
								$sqlr.= "order by b.regid asc LIMIT $posisi,$batas ";

								/* echo $sqlr; */
								$query=mysql_query($sqlr);
								$num=mysql_num_rows($query);
								$no=1;
								while($r=mysql_fetch_array($query)){
									$scond = array('SMKT', 'smkt');
									$sfield = $vlevel;
									?>
									<tr>
										<td><?php echo $r['cab']; ?></td>
										<td><?php echo $r['proddesc']; ?></td>
										<td><?php echo $r['regid']; ?></td>
										<td><?php echo $r['nama']; ?></td>
										<td><?php echo number_format($r['up'],0); ?></td>


										<th>
											<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=cekfoto&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Edit</button>

											<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Revisi" onclick="window.location='media.php?module=cekfoto&&act=revisi&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Revisi</button>

											<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="sppa" onclick="window.location = 'laporan/sppa/f_sppa.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPPA</button>
											<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=polhist&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Log</button>
											<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=approve&&id=".$r['regid'] . "&&uid=".$userid; ?>'"><i class="fa fa-check-square"></i> Approve</button>
											<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Reject" onclick="window.location='<?php echo $aksi."?module=reject&&id=".$r['regid']  . "&&uid=".$userid; ; ?>'"><i class="fa fa-trash"></i> Reject</button>

										</th>

									</tr>
									<?php

								}
								?>
							</tbody>
						</table>
					</div>
					<?php
				// 	$sqlp="select * from tr_sppa where status='1' ";
				// 	$jmldata=mysql_num_rows(mysql_query($sqlp));
				// 	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
				// 	$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
				// 	echo "$linkHalaman";

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
$sdate = date('Y-m-d H:i:s');

$sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
$sqll=$sqll . " values ('$sid','13','$userid','$sdate') ";
$query=mysql_query($sqll);

$sqle="select aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai, ";
$sqle= $sqle . " aa.akhir,aa.masa,aa.up,aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby, ";
$sqle= $sqle . " aa.validdt,aa.nopeserta,aa.usia,aa.premi,aa.epremi,aa.tpremi, ";
$sqle= $sqle . " aa.bunga,aa.tunggakan, aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno ";
$sqle= $sqle . " from tr_sppa aa ";
$sqle= $sqle . " where aa.regid='$sid'";

/* echo $sqle; */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$scabang=$r['cabang'];
$ssubject=$r['comment'];
$sregid=$r['regid'];
$sproduk=$r['produk'];
$smitra=$r['mitra'];
$sasuransi=$r['asuransi'];
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
						<h2>Update <small><?php echo $r['reqid']; ?></small></h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="uid" id="uid" value="<?php echo $userid; ?>">

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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="regid" name="regid" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">

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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="date" id="tgllahir" name="tgllahir"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tgllahir']; ?>">

								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="int" id="usia" name="usia" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>">

								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="noktp" name="noktp" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">

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
									<select  disabled class="select2_single form-control" tabindex="-2" name="pekerjaan" id="pekerjaan" onChange="display(this.value)">
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
									<input type="text" id="masa" name="masa" min="1" max="216" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >

								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="date" id="mulai" name="mulai"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['mulai']; ?>" >

								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="date" id="akhir" name="akhir" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['akhir']; ?>">

								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="up" name="up" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'],0); ?>">

								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Premi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="premi" name="premi"  readonly class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['premi'],0); ?>">

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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Grace Period (khusus MPP)
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="tunggakan" name="tunggakan" min="0" max="100" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tunggakan']; ?>"  >

								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asuransi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="select2_single form-control" tabindex="-2" name="asuransi" id="asuransi" onChange="display(this.value)" required>
										<option value="" selected="selected">-- choose category --</option>
										<?php
										/* $sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='asuransi' and msid<>'ALL' order by ms.mstype "; */
										$sqlcmb="select ms.msid comtabid,msdesc comtab_nm from ms_master ms ";
										$sqlcmb = $sqlcmb . " left join tr_limit tl on ms.msid=tl.asuransi ";
										$sqlcmb = $sqlcmb . "where ms.mstype='ASURANSI' and tl.produk='$sproduk' ";
										$sqlcmb = $sqlcmb . "and '$sup' BETWEEN tl.minup and tl.maxup ";
										$sqlcmb = $sqlcmb . "group by ms.msid,ms.msdesc ";
										$query=mysql_query($sqlcmb);
										while($bariscb=mysql_fetch_array($query)){
											?>
											<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sasuransi){ ?> selected="selected" <? }?>>
												<?=$bariscb['comtab_nm']?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($ssubject)); ?></textarea>
								</div>
							</div>


							<h2>Dokumen <small><?php echo $sid; ?></small></h2>
							<div id="tabel_doc">
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

										$sqld="SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from  ";
										$sqld= $sqld . " tr_document a  where regid='$sid'  ";
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
								<h2>Log Status <small><?php echo $sid; ?></small></h2>
								<div id="tabel_log">
									<table class="table table-bordered">
										<thead>
											<tr>

												<th>Code</th>
												<th>Status  </th>
												<th>User</th>
												<th>Tanggal</th>
												<th>Keterangan</th>


											</tr>
										</thead>
										<tbody>
											<?php

											$sqld="SELECT a.regid,a.status,a.comment,a.createdt,a.createby ,b.msdesc stdesc ";
											$sqld= $sqld . " from tr_sppa_log a inner join ms_master b on a.status=b.msid and b.mstype='streq'";
											$sqld= $sqld . " where regid='$sid' order by a.createdt desc ";
											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
												?>
												<tr>

													<td><?php echo $r['status']; ?></td>
													<td><?php echo $r['stdesc']; ?></td>
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


								<h2>Aplikasi Terkait <small><?php echo $sid; ?></small></h2>
								<div id="tabel_awal">
									<table class="table table-bordered">
										<thead>
											<tr>

												<th>No Register</th>
												<th>Produk</th>
												<th>Mulai</th>
												<th>Akhir</th>
												<th>UP</th>
												<th>Premi</th>
												<th>Status</th>
												<th></th>

											</tr>
										</thead>
										<tbody>
											<?php

											$sqld="SELECT a.regid regid,a.produk , m.msdesc proddesc ,a.up,a.tpremi,a.mulai,a.akhir,s.msdesc stdesc ";
											$sqld= $sqld . " from tr_sppa a inner join tr_sppa_reff b on a.regid=b.regid ";
											$sqld= $sqld . " left join ms_master m on m.msid=a.produk and  m.mstype='produk' ";
											$sqld= $sqld . " left join ms_master s on s.msid=a.status and  s.mstype='streq' ";
											$sqld= $sqld . " where b.reffregid='$sid' ";
											$sqld= $sqld . " union all ";
											$sqld= $sqld . " SELECT a.regid regid,a.produk , m.msdesc proddesc ,a.up,a.tpremi,a.mulai,a.akhir,s.msdesc stdesc ";
											$sqld= $sqld . " from tr_sppa a inner join tr_sppa_reff b on a.regid=b.reffregid ";
											$sqld= $sqld . " left join ms_master m on m.msid=a.produk and  m.mstype='produk' ";
											$sqld= $sqld . " left join ms_master s on s.msid=a.status and  s.mstype='streq' ";
											$sqld= $sqld . " where b.regid='$sid' ";

											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
												?>
												<tr>

													<td><?php echo $r['regid']; ?></td>
													<td><?php echo $r['proddesc']; ?></td>
													<td><?php echo $r['mulai']; ?></td>
													<td><?php echo $r['akhir']; ?></td>
													<td><?php echo number_format($r['up'],0); ?></td>
													<td><?php echo number_format($r['tpremi'],0); ?></td>
													<td><?php echo $r['stdesc']; ?></td>
													<th>
														<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=inquirib&&act=view&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> view</button>
													</th>


												</tr>
												<?php
												$no++;
											}
											?>
										</tbody>
									</table>
								</div>

								<div id="tabel_photo">
									<table class="table table-bordered">
										<tbody>
											<?php

											$sqld="SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from  ";
											$sqld= $sqld . " tr_document a  where regid='$sid'  and pages='1212' ";
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
										<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=cekfoto'"><i class="fa fa-arrow-left"></i> Back</button>
										<button type="submit" class="btn btn-sm btn-default">Submit</button>
										<button type="button" class="btn btn-sm btn-default" onclick="window.location='media.php?module=cekfoto&&act=revisi&&id=<?=$sid;?>'"><i class="fa fa-search"></i> Revisi</button>
										<button type="button" class="btn btn-sm btn-info" onclick="window.location='<?=$aksi."?module=reject&&id=".$sid."&&uid=".$userid; ?>'"><i class="fa fa-trash"></i> Reject</button>

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

case "revisi":
$sid=$_GET['id'];

$sqle="select aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai, ";
$sqle= $sqle . " aa.akhir,aa.masa,aa.up,aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby, ";
$sqle= $sqle . " aa.validdt,aa.nopeserta,aa.usia,aa.premi,aa.epremi,aa.tpremi, ";
$sqle= $sqle . " aa.bunga,aa.tunggakan, aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno,aa.asuransi  ";
$sqle= $sqle . " from tr_sppa aa ";
$sqle= $sqle . " where aa.regid='$sid'";

/* echo $sqle; */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$scabang=$r['cabang'];
$ssubject=$r['comment'];
$sregid=$r['regid'];
$sproduk=$r['produk'];
$smitra=$r['mitra'];
$sasuransi=$r['asuransi'];
$sup=$r['up'];
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
						<h2>Revisi <small><?php echo $r['reqid']; ?></small></h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=revisi"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="uid" id="uid" value="<?php echo $userid; ?>">

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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="regid" name="regid" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">

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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="date" id="tgllahir" name="tgllahir"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tgllahir']; ?>">

								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="int" id="usia" name="usia" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>">

								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="noktp" name="noktp" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">

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
									<select  disabled class="select2_single form-control" tabindex="-2" name="pekerjaan" id="pekerjaan" onChange="display(this.value)">
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
									<input type="text" id="masa" name="masa" min="1" max="216" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >

								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="date" id="mulai" name="mulai"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['mulai']; ?>" >

								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="date" id="akhir" name="akhir" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['akhir']; ?>">

								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="up" name="up" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'],0); ?>">

								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Premi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="premi" name="premi"  readonly class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['premi'],0); ?>">

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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Grace Period (khusus MPP)
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="tunggakan" name="tunggakan" min="0" max="100" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tunggakan']; ?>"  >

								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asuransi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="select2_single form-control" tabindex="-2" name="asuransi" id="asuransi" onChange="display(this.value)" required>
										<option value="" selected="selected">-- choose category --</option>
										<?php

										$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms ";
										$sqlcmb = $sqlcmb . " left join tr_limit tl on ms.msid=tl.asuransi ";
										$sqlcmb = $sqlcmb . "where ms.mstype='ASURANSI' and tl.produk='$sproduk' ";
										$sqlcmb = $sqlcmb . "and '$sup' BETWEEN tl.minup and tl.maxup ";
										$sqlcmb = $sqlcmb . "group by ms.msid,ms.msdesc ";

										$query=mysql_query($sqlcmb);
										while($bariscb=mysql_fetch_array($query)){
											?>
											<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sasuransi){ ?> selected="selected" <? }?>>
												<?=$bariscb['comtab_nm']?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($ssubject)); ?></textarea>
								</div>
							</div>



							<div id="tabel_doc">
								<table class="table table-bordered">
									<thead>
										<tr>

											<th>Nama file </th>

											<th></th>


										</tr>
									</thead>
									<tbody>
										<?php

										$sqld="SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages ";
										$sqld= $sqld . " from tr_document a  where regid='$sid'  ";
										$query=mysql_query($sqld);
										$num=mysql_num_rows($query);
										$no=1;
										while($r=mysql_fetch_array($query)){
											?>
											<tr>

												<td><a href="<?php echo $r['file'] ?>" target="pdf-frame"><?php echo $r['nama_file']; ?> </a>

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

								<h2>Log Status <small><?php echo $sid; ?></small></h2>
								<div id="tabel_awal">
									<table class="table table-bordered">
										<thead>
											<tr>

												<th>Code</th>
												<th>Status  </th>
												<th>User</th>
												<th>Tanggal</th>
												<th>Keterangan</th>


											</tr>
										</thead>
										<tbody>
											<?php

											$sqld="SELECT a.regid,a.status,a.comment,a.createdt,a.createby ,b.msdesc stdesc ";
											$sqld= $sqld . " from tr_sppa_log a inner join ms_master b on a.status=b.msid and b.mstype='streq'";
											$sqld= $sqld . " where regid='$sid' order by a.createdt desc ";
											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
												?>
												<tr>

													<td><?php echo $r['status']; ?></td>
													<td><?php echo $r['stdesc']; ?></td>
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

								<h2>Aplikasi Terkait <small><?php echo $sid; ?></small></h2>
								<div id="tabel_awal">
									<table class="table table-bordered">
										<thead>
											<tr>

												<th>No Register</th>
												<th>Produk</th>
												<th>Mulai</th>
												<th>Akhir</th>
												<th>UP</th>
												<th>Premi</th>
												<th>Status</th>
												<th></th>

											</tr>
										</thead>
										<tbody>
											<?php

											$sqld="SELECT a.regid regid,a.produk , m.msdesc proddesc ,a.up,a.tpremi,a.mulai,a.akhir,s.msdesc stdesc ";
											$sqld= $sqld . " from tr_sppa a inner join tr_sppa_reff b on a.regid=b.regid ";
											$sqld= $sqld . " left join ms_master m on m.msid=a.produk and  m.mstype='produk' ";
											$sqld= $sqld . " left join ms_master s on s.msid=a.status and  s.mstype='streq' ";
											$sqld= $sqld . " where b.reffregid='$sid' ";
											$sqld= $sqld . " union all ";
											$sqld= $sqld . " SELECT a.regid regid,a.produk , m.msdesc proddesc ,a.up,a.tpremi,a.mulai,a.akhir,s.msdesc stdesc ";
											$sqld= $sqld . " from tr_sppa a inner join tr_sppa_reff b on a.regid=b.reffregid ";
											$sqld= $sqld . " left join ms_master m on m.msid=a.produk and  m.mstype='produk' ";
											$sqld= $sqld . " left join ms_master s on s.msid=a.status and  s.mstype='streq' ";
											$sqld= $sqld . " where b.regid='$sid' ";

											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
												?>
												<tr>

													<td><?php echo $r['regid']; ?></td>
													<td><?php echo $r['proddesc']; ?></td>
													<td><?php echo $r['mulai']; ?></td>
													<td><?php echo $r['akhir']; ?></td>
													<td><?php echo number_format($r['up'],0); ?></td>
													<td><?php echo number_format($r['tpremi'],0); ?></td>
													<td><?php echo $r['stdesc']; ?></td>
													<th>
														<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=inquirib&&act=view&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> view</button>
													</th>


												</tr>
												<?php
												$no++;
											}
											?>
										</tbody>
									</table>
								</div>

								<div id="tabel_photo">
									<table class="table table-bordered">
										<tbody>
											<?php

											$sqld="SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from  ";
											$sqld= $sqld . " tr_document a  where regid='$sid'  and pages='1212' ";
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
										<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=cekfoto'"><i class="fa fa-arrow-left"></i> Back</button>
										<button type="submit" class="btn btn-sm btn-default">Submit</button>

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
