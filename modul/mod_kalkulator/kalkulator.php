
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
        
    document.getElementById('datepicker').setAttribute("value", today_ISO_date);
       
     var dd_mm_yyyy;
     $("#datepicker").change( function(){
       	changedDate = $(this).val(); //in yyyy-mm-dd format obtained from datepicker
        var date = new Date(changedDate);
        dd_mm_yyyy = twoDigitDate(date)+"/"+twoDigitMonth(date)+"/"+date.getFullYear(); // in dd-mm-yyyy format
        $('#textbox').val(dd_mm_yyyy);
        //console.log($(this).val());
        //console.log("Date picker clicked");
        });
        
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
			 url:"modul/mod_ajuan/cari.php",
			 data:"q="+ strcari ,
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

$vlevel=$_SESSION['idLevel'];
$userid=$_SESSION['idLog'];
$aksi="modul/mod_kalkulator/aksi_kalkulator.php";
$judul="Kalkulator";

			$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
			$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
			$sqll = $sqll = $sqll . " where a.trxid= 'calreg'";
			$hasill = $db->query($sqll);
			$barisl = $hasill->fetch_array();
			$nourut = $barisl[0];

			$sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'calreg'";
			$hasiln = $db->query($sqln);
			$calreg=$nourut;

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
                                       
                                    </div>
									
									<div id="hasil"></div>
									<div id="tabel_awal">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Input Data</h2>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form action="<?php echo $aksi."?module=add" ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
									<input type="hidden" name="userid" value="<?php echo $userid; ?>">
									<input type="hidden" name="calreg" value="<?php echo $calreg; ?>">
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Produk 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                               <select class="select2_single form-control" tabindex="-2" name="produk" id="selec">
													
													<?php
													$qtahun=$db->query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk'  and msid<>'all' order by ms.msdesc  asc ");
													while($rpro=$qtahun->fetch_array()){
													?>
													<option value="<?php echo $rpro['comtabid']; ?>"><?php echo $rpro['comtab_nm']; ?></option>
													<?php
													}
													?>
												
												</select>
                                            </div>
										</div>
									
			
	

										

										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Jenis Kelamin 
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                               <select class="select2_single form-control" tabindex="-2" name="jkel" id="selec">
													
													<?php
													$qtahun=$db->query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc ");
													while($rpro=$qtahun->fetch_array()){
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Jumlah Pinjaman  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="up" name="up"  placeholder="dalam rupiah" required="required" class="form-control col-md-7 col-xs-12" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

                                            </div>	
                                        </div>
	
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Grace Period (khusus produk MPP)
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="number" id="gp" name="gp" min="0" max="100" placeholder="dalam bulan" required="required" class="form-control col-md-7 col-xs-12" value="0"> 
												
                                            </div>	
                                        </div>
										
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Hitung</button>
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
<?php
break;

case "update":
$sid=$_GET['id'];

$sqle="select aa.* ";
$sqle= $sqle . " from tr_calc aa ";
$sqle= $sqle . " where aa.calreg='$sid'";

 /* echo $sqle; */
$query=$db->query($sqle);
$r=$query->fetch_array();
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$scabang=$r['cabang'];
$ssubject=$r['subject'];
$sregid=$r['regid'];
$sproduk=$r['produk'];
$sterima=$r['up']-$r['premi'];
$ssubject=$r['comment'];


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
                                    <h2>Hasil <small><?php echo $r['calreg']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
									<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
									<input type="hidden" name="userid" value="<?php echo $userid; ?>">
					
									<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
									
											<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel" onChange="display(this.value)">
												<option value="" selected="selected">-- choose produk --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk'  order by ms.mstype ";
												$query=$db->query($sqlcmb);
												while($bariscb=$query->fetch_array()){
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
                                                <input type="int" id="usia" name="usia"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>">
												
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
												$query=$db->query($sqlcmb);
												while( $bariscb = $query->fetch_array() ){
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
                                                <input type="date" id="akhir" name="akhir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['akhir']; ?>">
												
                                            </div>
                                        </div>

										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Pinjaman  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="up" name="up"   readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'],0); ?>">
												
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Jumlah Diterima 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="epremi" name="epremi"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($sterima,0); ?>">
												
                                            </div>
                                        </div>
											
										
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Grace Period (khusus produk MPP) 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="gp" name="gp" min="0" max="100" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tunggakan']; ?>"  >
												
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
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=kalkulator'"><i class="fa fa-arrow-left"></i> Hitung Lagi</button>
											
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