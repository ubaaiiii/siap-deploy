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
		   if (strcari != "")
		   {
		   $("#tabel_awal").css("display", "none");

			$("#hasil").html("<img src='images/loader.gif'/>")
			$.ajax({
			 type:"post",
			 url:"modul/mod_util/cari.php",
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
	<style>
	#selec{
		width:500px;
	}
	</style>
<?php	
$aksi="modul/mod_util/aksi_util.php";
switch(isset($_GET['act'])){
	default:
	$p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
	$idfaskes=$_SESSION['kdfaskes'];
	$iduser=$_SESSION['idLog'];
			
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
                                    <h2>Process </h2>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                      <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=print"; ?>">

										
										
										 <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Process Type 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select class="select2_single form-control" tabindex="-2" name="reptype" id="reptype" onChange="display(this.value)">
												<option value="" selected="selected">-- Pilih Jenis Laporan --</option>
												<?php
												$sqlcmb="select ms.repid comtabid,repname comtab_nm from ms_report ms  where cat='don' order by ms.repid ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sex){ ?> selected="selected" <? }?>> 
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
                                                <a href="media.php?module=home"" class="btn btn-primary btn-large"><i class="fa fa-arrow-left"></i> Back</a>
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Download</button>
												
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