<script type="text/javascript" src="/path/to/jquery.js"></script>
<script type="text/javascript" src="/path/to/moment.js"></script>
<script type="text/javascript" src="/path/to/bootstrap/js/transition.js"></script>
<script type="text/javascript" src="/path/to/bootstrap/js/collapse.js"></script>
<script type="text/javascript" src="/path/to/bootstrap/dist/bootstrap.min.js"></script>
<script type="text/javascript" src="/path/to/bootstrap-datetimepicker.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
$judul="Claim Register";

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
										<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=home'"><i class="fa fa-arrow-left"></i> Back</button>
										<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Add" onclick="window.location='media.php?module=inqclm'"><i class="fa fa-plus-circle"></i> Add</button>
										
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="pelapor" name="pelapor"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">
												
                                            </div>	
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Penyebab Kematian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="penyebab" name="penyebab"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['penyebab']; ?>">
												
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
                                                <th>No Register</th>
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
										
											$sqlr="select aa.regid,ab.nama,ab.noktp,ab.tgllahir,ab.up,ab.nopeserta,ab.up,ab.premi, ";
											$sqlr= $sqlr . " aa.tglkejadian,aa.tgllapor,aa.regclaim ";
											$sqlr= $sqlr . " ,aa.statclaim,ac.msdesc stsclm from tr_claim aa ";
											$sqlr= $sqlr . " inner join tr_sppa ab on aa.regid=ab.regid  ";
											$sqlr= $sqlr . " inner join ms_master ac on ac.msid=ab.status ";
											$sqlr= $sqlr . " and ac.mstype='STREQ' ";
											if ($vlevel=="schecker" or $vlevel=="checker" )
											{
												$sqlr= $sqlr . " where ab.status='90' ";
												$sqlr= $sqlr . " and  ab.cabang in (select case when cabang='ALL' THEN '%%' ELSE cabang END cabang from ms_admin where username='$userid' ) ";
											}
											
											if ($vlevel=="broker"   )
											{
												$sqlr= $sqlr . " where aa.status='91' ";
											}
											
											if ($vlevel=="insurance"   )
											{
												$sqlr= $sqlr . " where ab.status='92'  ";
												$sqlr= $sqlr . " and  ab.asuransi in (select cabang from ms_admin  where level='insurance' and username='$userid' ) ";
												
											}
											/* echo $sqlr; */
											$query=mysql_query($sqlr);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											$scond = array('schecker', 'schecker');
											$sfield = $vlevel;
											
										?>
                                            <tr>

												<td><?php echo $r['regclaim']; ?></td>
                                                <td><?php echo $r['regid']; ?></td>
												<td><?php echo $r['nama']; ?></td>
												<td><?php echo $r['tgllapor']; ?></td>
												<td><?php echo $r['tglkejadian']; ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo $r['stsclm']; ?></td>
												
                                                <th>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=claim&&act=update&&id=<?php echo $r['regclaim']; ?>'"><i class="fa fa-search"></i> Edit</button>
												<?php if (in_array($sfield, $scond, TRUE)): ?>
												<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" onclick="window.location='<?php echo $aksi."?module=approve&&id=".$r['regclaim']; ?>'"><i class="fa fa-trash"></i> Approve</button>
												<?php endif; ?>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="cek list " onclick="window.location = 'laporan/claim/f_claim.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> List</button>
												<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="document" onclick="window.location='media.php?module=docclaim&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Doc</button>
												</th>

                                            </tr>
										<?php
			
										}
										?>
                                        </tbody>
                                    </table>
									</div>
									<?php
								$sqlr="select aa.regid from tr_sppa aa inner join tr_sppa_cancel ab on aa.regid=ab.regid ";
								if ($vlevel=="schecker" or $vlevel=="checker" )
								{
								$sqlr= $sqlr . " where aa.status='7' or aa.status='8' ";
								$sqlr= $sqlr . " and  aa.cabang like   ";
								$sqlr= $sqlr . " (select case when cabang='ALL' THEN '%%' ELSE cabang END cabang from ms_admin where username='$userid') ";
								}
								if ($vlevel=="broker"   )
								{
								$sqlr= $sqlr . " where ab.status='91'  ";
								}
								if ($vlevel=="insurance"   )
								{
								$sqlr= $sqlr . " where aa.status='92' ";
								$sqlr= $sqlr . " and  aa.asuransi in (select cabang from ms_admin  where level='insurance' and username='$userid' ) ";
								}
								/* echo $sqlr; */
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

case "addclm":
$sid=$_GET['id'];

$sqle="select aa.*,DATE_FORMAT(now(),'%Y/%m/%d') tgllapor ";
$sqle= $sqle . "  from tr_sppa aa ";
$sqle= $sqle . " where aa.regid='$sid'";

/* echo $sqle; */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$susia= $r['usia'] . ' Tahun' . ' / ' . $r['tgllahir']  ;
$smasaas=$r['masa'] . ' Bulan / ' . $r['mulai']  .' s/d '. $r['akhir'] ;
$sdetail=$r['detail'];



			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'regclm'";
			$hasill = mysql_query($sqll);
			$barisl = mysql_fetch_array($hasill);
			$nourut = $barisl[0];

			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'regclm'";
			$hasiln = mysql_query($sqln);
			$regclaim=$nourut;

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
                                    <h2>Add <small><?php echo $r['reqid']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=add"; ?>">
									<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
									<input type="hidden" name="userid" value="<?php echo $userid; ?>">
									<input type="hidden" name="regid" value="<?php echo $sregid; ?>">
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Claim 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="regclaim" name="regclaim"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $regclaim; ?>">
												
                                            </div>	
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="regid" name="regid"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
												
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
                                                <input type="text" id="up" name="up"   readonly  class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'],0); ?>" >
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nopeserta" name="nopeserta"   readonly class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>" >
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nilai OS 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nilaios" name="nilaios"  placeholder="dalam rupiah" required="required" class="form-control col-md-7 col-xs-12" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

                                            </div>	
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl laporan 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">

                                                <input type="date" id="tgllapor" name="tgllapor"  value="dd-mm-yyyy"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tgllapor']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Kejadian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">

                                                <input type="date" id="tglkejadian" name="tglkejadian"  value="dd-mm-yyyy"  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tglkejadian']; ?>">
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tempat Kejadian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select class="select2_single form-control" tabindex="-2" name="tmpkejadian" id="tmpkejadian" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='TMPCLM'  order by ms.mstype ";
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Penyebab Kematian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select class="select2_single form-control" tabindex="-2" name="sebab" id="sebab" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='SBBCLM'  order by ms.mstype ";
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
											

                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=claim'"><i class="fa fa-arrow-left"></i> Back</button>
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

case "update":
$sid=$_GET['id'];

$sqle="select aa.*,";
$sqle= $sqle . "  ab.regclaim,ab.tgllapor,ab.tmpkejadian,ab.tglkejadian,ab.`comment`,ab.penyebab,ab.detail,ab.nopk,ab.nilaios ";
$sqle= $sqle . "  from tr_sppa aa inner join tr_claim ab on aa.regid=ab.regid ";
$sqle= $sqle . "  where ab.regclaim='$sid'";

/* echo $sqle; */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$susia= $r['usia'] . ' Tahun' . ' / ' . tglindo_balik($r['tgllahir'])  ;
$smasaas=$r['masa'] . ' Bulan / ' . tglindo_balik($r['mulai'])  .' s/d '. tglindo_balik($r['akhir']) ;
$sdetail=$r['detail'];
$stmpkejadian=$r['tmpkejadian'];
$stgllapor=$r['tgllapor'];
$regclaim=$r['regclaim'];
$spenyebab=$r['penyebab'];		

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
                                                <input type="text" id="regclaim" name="regclaim"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $regclaim; ?>">
												
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No PK  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nopk" name="nopk"    required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopk']; ?>" >
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nilai OS  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                
												   <input type="text" id="nilaios" name="nilaios"  placeholder="dalam rupiah" required="required" class="form-control col-md-7 col-xs-12" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo number_format($r['nilaios'],0); ?>">
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lapor 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tgllapor" name="tgllapor"   required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $stgllapor; ?>">
												
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tempat Kejadian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select class="select2_single form-control" tabindex="-2" name="tmpkejadian" id="tmpkejadian" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='tmpclm'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$stmpkejadian){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>				
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Penyebab Kematian 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select class="select2_single form-control" tabindex="-2" name="sebab" id="sebab" onChange="display(this.value)">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='sbbclm'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$spenyebab){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>			
											

                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=claim'"><i class="fa fa-arrow-left"></i> Back</button>
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
}
?>

