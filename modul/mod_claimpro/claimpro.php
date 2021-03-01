<?php	
$veid=$_SESSION['id_peg'];
$vempname=$_SESSION['empname'];
$vlevel=$_SESSION['idLevel'];
$userid=$_SESSION['idLog'];
$aksi="modul/mod_inqclm/aksi_inqclm.php";
$judul="Inquiry";

switch($_GET['act']){
	default:

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
                    <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Back</button>
                </div>
                <div>
                    <table class="table table-bordered" id="table-inqclm" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No. Register </th>
                                <th>Produk </th>
                                <th>Nama </th>
                                <th>Cabang </th>
                                <th>No. Pinjam </th>
                                <th>No. Sertifikat </th>
                                <th>UP </th>
                                <th>Premi </th>
                                <th>Status </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <script>
                        $(document).ready(function(){
                            var tableClaim = $('#table-inqclm').DataTable({
                                "colReorder": true,
                                "scrollX": true,
                    		    "autoWidth": true,
                    			"bProcessing": true,
                    			"bServerSide": true,
                    			"sAjaxSource": "modul/mod_claimpro/data_claimpro.php",
                    			"sServerMethod": 'POST',
                    			"aoColumns": [
                    			  {"sName": "regid"},
                    			  {"sName": "produk"},
                    			  {"sName": "nama"},
                    			  {"sName": "cabang"},
                    			  {"sName": "nopeserta"},
                    			  {"sName": "policyno"},
                    			  {
                    			      "mRender": function ( data, type, full ) {
                    					return $.fn.dataTable.render.number( ',', '.', 0 ).display(data);
                    				  }
                    			  },
                    			  {
                    			      "mRender": function ( data, type, full ) {
                    					return $.fn.dataTable.render.number( ',', '.', 0 ).display(data);
                    				  }
                    			  },
                    			  {"sName": "status"},
                    			  {
                    				"mRender": function ( data, type, full ) {
                    				    data = data.split('-');
                    				    var regid   = data[0];
                    				    var status  = data[1];
                    				    
                    				    var button = `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" href="media.php?module=inquirib&&act=view&&id=`+regid+`"><i class="fa fa-search"></i> View</a>`;
                    				    button += `<button type="button" class="btn-claim btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Claim" data-id="`+regid+`"><i class="fa fa-check-circle"></i> Claim</button>`;
                    				    
                    				    return button;
                    				}
                    			  }
                    			],
                    			"columnDefs": [ 
                    			    {
                                        "targets": 9,
                                        "orderable": false
                                    },
                                    {
                                        targets: [7,6],
                                        className: 'text-right'
                                    }
                                ],
                                order: [[0, 'asc']],
                            });
                            
                            $('#table-inqclm tbody').on('click', '.btn-claim', function() {
                                var datanya = $(this).attr('data-id');
                                $.ajax({
                                    url: 'modul/mod_claim/aksi_claim.php?module=cekdata&&id='+datanya,
                                    success: function(data) {
                                        if (data != 0) {
                                            Swal.fire(
                                                'Data sudah pernah claim!',
                                                'Harap menghubungi Team BDS untuk pengecekan lebih lanjut',
                                                'error'
                                            );
                                        } else {
                                            window.location.href="media.php?module=claim&&act=add&&id="+datanya;
                                        }
                                    }
                                })
                            });
                        });
                    </script>
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
$sqle= $sqle . " from tr_sppa aa  inner join ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' ";
$sqle= $sqle . " where aa.regid='$sid'";

/* echo $sqle; */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$scabang=$r['cabang'];
$smitra=$r['mitra'];
$produk=$r['produk'];
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
												$sqlcmb="select distinct  ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='jkel'  order by ms.mstype ";
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
												$sqlcmb="select distinct  ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra'  order by ms.mstype ";
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
												$sqlcmb="select distinct  ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype ";
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
												$sqlcmb="select distinct  ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype ";
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
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=inquiry'"><i class="fa fa-arrow-left"></i> Back</button>
										
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

/* echo $sqle; */
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
											$sqll=$sqll . " where a.regid='$id'  ";
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
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=inquiry'"><i class="fa fa-arrow-left"></i> Back</button>

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
