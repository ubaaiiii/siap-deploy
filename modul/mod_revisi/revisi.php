<?php	
$veid=$_SESSION['id_peg'];
$vlevel=$_SESSION['idLevel'];
$userid=$_SESSION['idLog'];
$aksi="modul/mod_revisi/aksi_revisi.php";
$judul="Log Revisi";

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
                <table class="table table-bordered" id="table-revisi" width="100%">
                    <thead>
                        <tr>
							<th>No. Revisi </th>
							<th>No. Register </th>
							<th>Tgl. Revisi </th>
                            <th>Jenis Revisi </th>
							<th>Direvisi Oleh </th>
							<th>Data Awal </th>
							<th>Data Akhir </th>
							<th>Catatan </th>
							<th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <script>
                    $(document).ready(function() {
                		$('#table-revisi').dataTable( {
                		    "colReorder": true,
                		    "autoWidth": false,
                		    "responsive": true,
                			"bProcessing": true,
                			"bServerSide": true,
                			"sAjaxSource": "modul/mod_revisi/data_revisi.php",
                			"aoColumns": [
                			  {"sName": "regrev"},
                			  {"sName": "regid"},
                			  {"sName": "tglrevisi"},
                			  {"sName": "jnsrev"},
                			  {"sName": "createby"},
                			  {"sName": "dataawal"},
                			  {"sName": "dataakhir"},
                			  {"sName": "comment"},
                			  {
                				"mRender": function ( data, type, full ) {
                					return `<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Revisi Lagi" onclick="window.location='media.php?module=revisi&&act=add&&id=`+data+`'"><i class="fa fa-refresh"></i> Revisi</button>`;
                				  }
                			  }
                			],
                			"columnDefs": [ 
                			    {
                                    "targets": 8,
                                    "orderable": false
                                }
                            ]
                		} );
                	} );
                </script>
			</div>
        </div>
    </div>
</div>
<?php
break;

case "add":
$sid=$_GET['id'];

$sqle=" SELECT 
            aa.regid,aa.noktp,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai,aa.akhir,aa.masa,aa.up,
            aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby,aa.validdt,aa.nopeserta,aa.usia,
            aa.premi,aa.epremi,aa.tpremi,aa.bunga,aa.tunggakan,aa.produk,aa.mitra,aa.asuransi,aa.policyno, 
            ab.tglrevisi,ab.comment,ab.jnsrev,ab.regrev,ab.dataawal,ab.dataakhir 
        FROM   tr_sppa aa 
               LEFT JOIN tr_sppa_revisi ab 
                       ON aa.regid = ab.regid 
        WHERE  aa.regid = '$sid' ";

 /* echo $sqle;   */
$query=$db->query($sqle);
$r=$query->fetch_array();
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$scabang=$r['cabang'];
$ssubject=$r['comment'];
$sregid=$r['regid'];
$sproduk=$r['produk'];
$smitra=$r['mitra'];


?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $judul; ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <script>
            function disField(dataID) {
                if (dataID !== undefined) {
                    var msid = dataID.value;
                    $('.R-all').attr('disabled',true);
                    $('.l-all').css('display','none');
                    $('.'+msid).removeAttr('disabled');
                    $('.l-'+msid).removeAttr('style');
                    
                    // console.log(msid);    
                }
            }
        </script>
        
       <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update <small><?php echo $r['reqid']; ?></small></h2>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=add"; ?>">
						<input type="hidden" name="userid" value="<?php echo $userid; ?>">
						<input type="hidden" name="regid" value="<?php echo $sregid; ?>">
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Revisi 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<select class="select2_single form-control" tabindex="-2" name="jenrev" required onchange="disField(this);" style="width:100%">
									<option value="" selected="selected">-- choose category --</option>
									<?php
									$sqlcmb="select  ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='revisi'  order by ms.mstype ";
									$query=$db->query($sqlcmb);
									while($bariscb=$query->fetch_array()){
									?>
									<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sjenrev){ ?> selected="selected" <? }?>> 
										<?=$bariscb['comtab_nm']?>
									</option>
									<?php
									}
									?>
									</select>
                                </div>
                            </div>	
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<select disabled class="select2_single form-control" tabindex="-2" name="produk" style="width:100%">
										<option value="" selected="selected">-- choose category --</option>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="regid" name="regid"  disabled required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
                                </div>	
                            </div>
						
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="nopeserta" name="nopeserta"  disabled class="R7 R-all form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
									<label class="l-R7 l-all control-label" for="first-name" style="display:none;">Sebelumnya: <?= $r['nopeserta'] ;?></label>
                                    <input type="hidden" name="nopeserta-sebelumnya" required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['nopeserta']; ?>">
                                </div>	
                            </div>
							
							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="nama" name="nama" disabled required="required" class="R1 R-all form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
									<label class="l-R1 l-all control-label" for="first-name" style="display:none;">Sebelumnya: <?= $r['nama'] ;?></label>
                                    <input type="hidden" name="nama-sebelumnya" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="date" id="tgllahir" name="tgllahir" disabled  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tgllahir']; ?>">
									
                                </div>
                            </div>
							
						    <div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" id="noktp" name="noktp" disabled required="required" class="R6 R-all form-control col-md-7 col-xs-12" value="<?=$r['noktp'];?>" data-parsley-id="8719"><ul class="parsley-errors-list" id="parsley-id-8719"></ul>
									<label class="l-R6 l-all control-label" for="first-name" style="display:none;">Sebelumnya: <?= $r['noktp'] ;?></label>
                                    <input type="hidden" name="noktp-sebelumnya" required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['noktp'] ;?>">
								</div>
							</div>
							
							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Kelamin 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<select disabled class="select2_single form-control R5 R-all" tabindex="-2" name="jkel" style="width:100%">
									<option value=""  selected="selected">-- choose category --</option>
									<?php
									$sqlcmb="select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='jkel'  order by ms.mstype ";
									$query=$db->query($sqlcmb);
									while($bariscb=$query->fetch_array()){
									    if ($bariscb['comtabid']==$r['jkel']) {
									        $jkel = $bariscb['comtab_nm'];
									    }
									?>
									<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sjkel){ ?> selected="selected" <? }?>> 
										<?=$bariscb['comtab_nm']?>
									</option>
									<?php
									}
									?>
									</select>
									<label class="l-R5 l-all" for="first-name" style="display:none;">Sebelumnya: <?= $jkel ;?></label>
                                    <input type="hidden" name="jkel-sebelumnya" required="required" class="R1 R-all" value="<?= $r['jkel'] ;?>">
                                </div>
                            </div>							

							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mitra 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<select disabled class="select2_single form-control R2 R-all" tabindex="-2" name="mitra" style="width:100%">
									<option value="" selected="selected">-- choose category --</option>
									<?php
									$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra'  order by ms.mstype ";
									$query=$db->query($sqlcmb);
									while($bariscb=$query->fetch_array()){
									    if ($bariscb['comtabid']==$r['mitra']) {
									        $mitra = $bariscb['comtab_nm'];
									    }
									?>
									<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$smitra){ ?> selected="selected" <? }?>> 
										<?=$bariscb['comtab_nm']?>
									</option>
									<?php
									}
									?>
									</select>
									<label class="l-R2 l-all" for="first-name" style="display:none;">Sebelumnya: <?= $mitra ;?></label>
                                    <input type="hidden" name="mitra-sebelumnya" required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['mitra'] ;?>">
                                </div>
                            </div>						
							
							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cabang 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<select disabled class="select2_single form-control R3 R-all" tabindex="-2" name="cabang" style="width:100%">
									<option value="" selected="selected">-- choose category --</option>
									<?php
									$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype ";
									$query=$db->query($sqlcmb);
									while($bariscb=$query->fetch_array()){
									    if ($bariscb['comtabid']==$r['cabang']) {
									        $cabang = $bariscb['comtab_nm'];
									    }
									?>
									<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$scabang){ ?> selected="selected" <? }?>> 
										<?=$bariscb['comtab_nm']?>
									</option>
									<?php
									}
									?>
									</select>
									<label class="l-R3 l-all" for="first-name" style="display:none;">Sebelumnya: <?= $cabang ;?></label>
                                    <input type="hidden" name="cabang-sebelumnya" required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['cabang'] ;?>">
                                </div>
                            </div>							


							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Pekerjaan
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<select disabled class="select2_single form-control R4 R-all" tabindex="-2" name="pekerjaan" style="width:100%">
									<option value="" selected="selected">-- choose category --</option>
									<?php
									$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype ";
									$query=$db->query($sqlcmb);
									while($bariscb=$query->fetch_array()){
									    if ($bariscb['comtabid']==$r['pekerjaan']) {
									        $pekerjaan = $bariscb['comtab_nm'];
									    }
									?>
									<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$spekerjaan){ ?> selected="selected" <? }?>> 
										<?=$bariscb['comtab_nm']?>
									</option>
									<?php
									}
									?>
									</select>
									<label class="l-R4 l-all" for="first-name" style="display:none;">Sebelumnya: <?= $pekerjaan ;?></label>
                                    <input type="hidden" name="pekerjaan-sebelumnya" required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['pekerjaan'] ;?>">
                                </div>
                            </div>							

							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="masa" name="masa" min="0" max="300" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >
									
                                </div>
                            </div>
							
							
							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="date" id="mulai" name="mulai"  disabled required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['mulai']; ?>" >
									
                                </div>
                            </div>

							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP  
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <input type="text" id="up" name="up"  readonly class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'],0); ?>">
									
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan  
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
									<textarea name="subject" rows="3" class="textbox" id="subject" style='width: 98%;'></textarea>
								</div>
                            </div>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                               	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=revisi'"><i class="fa fa-arrow-left"></i> Back</button>
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

<?php
break;
}
?>