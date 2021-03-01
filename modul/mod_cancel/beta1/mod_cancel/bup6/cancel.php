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
            if (strcari != "") {
                $("#tabel_awal").css("display", "none");
    
                $("#hasil").html("<img src='images/loader.gif'/>")
                $.ajax({
                    type: "post",
                    url: "modul/mod_cancel/cari.php",
                    data: "q=" + strcari,
                    success: function(data) {
                        $("#hasil").css("display", "block");
                        $("#hasil").html(data);
    
                    }
                });
            } else {
                $("#hasil").css("display", "none");
                $("#tabel_awal").css("display", "block");
            }
        });
    });
</script>
<?php	
    $veid       = $_SESSION['id_peg'];
    $vempname   = $_SESSION['empname'];
    $vlevel     = $_SESSION['idLevel'];
    $userid     = $_SESSION['idLog'];
    $aksi       = "modul/mod_cancel/aksi_cancel.php";
    $judul      = "Pembatalan & Refund";
    
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
					<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=home'"><i class="fa fa-arrow-left"></i> Back</button>
					<?php
					    if ($vlevel !== 'insurance') {
					?>
					<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Add" onclick="window.location='media.php?module=inqcancel'"><i class="fa fa-plus-circle"></i> Add</button>
					<?php
					    }
				    ?>
				</div>
                <table class="table table-bordered" id="table-cancel" style="width:100%;">
                    <thead>
                        <tr>
							<th>No Register </th>
                            <th>Nama</th>
                            <th>Cabang</th>
							<th>Tgl Lahir</th>
							<th>Tgl Batal</th>
							<th>Mulai</th>
							<th>UP</th>
							<th>Premi</th>
							<th>Status</th>
							<th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <script>
                    $(document).ready(function(){
                        var tableCancel = $('#table-cancel').DataTable({
                            "colReorder": true,
                            "scrollX": true,
                		    "autoWidth": true,
                			"bProcessing": true,
                			"bServerSide": true,
                			"sAjaxSource": "modul/mod_cancel/data_cancel.php",
                			"sServerMethod": 'POST',
                			"aoColumns": [
                			  {"sName": "regid"},
                			  {"sName": "nama"},
                			  {"sName": "cabang"},
                			  {"sName": "tgllahir"},
                			  {"sName": "tglbatal"},
                			  {"sName": "mulai"},
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
                				    var bordero = data[2];
                				    
                				    if (status == 72 || status == 73 || status == 82 || status == 83 || status == 84 || status == 85) {
                				        var button = ``;
                				    } else {
                				        var button = `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" href="media.php?module=cancel&&act=update&&id=`+regid+`"><i class="fa fa-edit"></i> Edit</button>`;
                				    }
                				    
                				    button += `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" href="media.php?module=cancel&&act=view&&id=`+regid+`"><i class="fa fa-search"></i> View</button>`;
                				    button += `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Dokumen" href="media.php?module=doc&&id=`+regid+`"><i class="fa fa-files-o"></i> Doc</button>`;
                				    if (status == 7 || status == 71 || status == 72 || status == 73) {
                				        button += `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Form Pembatalan" href="laporan/batal/f_batal.php?id=`+regid+`&&jenis=batal"><i class="fa fa-print"></i> Form Batal</button>`;
                				    } else {
                				        button += `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Form Pembatalan" href="laporan/batal/f_batal.php?id=`+regid+`&&jenis=refund"><i class="fa fa-print"></i> Form Batal</button>`;
                				    }
                				    
                				    if ('<?=$vlevel;?>' == 'schecker' && (status == 7 || status == 8)) {
                				        button += `<a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" href="<?=$aksi."?module=approve&&regid=";?>`+regid+`"><i class="fa fa-check-circle"></i> Approve</button>`;
                				        
                				    } else if ('<?=$vlevel;?>' == 'broker') {
                				        if (status == 7 || status == 8 || status == 71 || status == 81) {
                				            button += `<a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" href="<?=$aksi."?module=approve&&regid=";?>`+regid+`"><i class="fa fa-check-circle"></i> Approve</button>`;
                				            if (status == 71 || status == 81) {
                				                button += `<a class="btn-rollback btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Rollback" d-id="`+regid+`"><i class="fa fa-undo"></i> Rollback</button>`;
                				            }
                				        } else if (status == 83) {
                				            button += `<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Pembayaran Refund" href="media.php?module=bayar&&act=refund&&kas=keluar&&regid=`+regid+`&&before=cancel"><i class="fa fa-calendar"></i> Pay Refund</button>`;
                				        }
                				        
                				    } else if ('<?=$vlevel;?>' == 'insurance') {
                				        if (status == 84) {
                				            if (bordero == 'YES') {
                				                button += `<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Pembayaran Refund" href="media.php?module=bayar&&act=refund&&kas=masuk&&regid=`+regid+`&&before=cancel"><i class="fa fa-calendar"></i> Pay Refund</button>`;
                				            }
                				        } else  if (status == 72 || status == 82) {
                				            button += `<a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" href="<?=$aksi."?module=approve&&regid=";?>`+regid+`"><i class="fa fa-check-circle"></i> Approve</button>`;
                    				        button += `<a class="btn-rollback btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Rollback" d-id="`+regid+`"><i class="fa fa-undo"></i> Rollback</button>`;
                				        }
                				        
                				    }
                				    
                					return button;
                				}
                			  }
                			],
                			"columnDefs": [ 
                			    {
                                    "targets": 9,
                                    "orderable": false
                                },
                            ],
                            order: [[4, 'asc']],
                        });
                        
                        $('#table-cancel tbody').on('click', 'a.btn-rollback', function() {
                            var regid = $(this).attr('d-id');
                            Swal.fire({
                                title: 'Masukkan Alasan Anda Rollback Data '+regid+":",
                                input: 'textarea'
                            }).then(function(result) {
                                if (result.value) {
                                    var subject = result.value;
                                    $.ajax({
                                        url: 'modul/mod_cancel/aksi_cancel.php?module=rollback',
                                        data: {id:regid, comment:subject},
                                        type: 'post',
                                        success: function(data) {
                                            data = JSON.parse(data);
                                            if (data === 'berhasil') {
                                                tableCancel.ajax.reload();
                                            }
                                        }
                                    })
                                }
                            })
                        });
                    });
                </script>
    		</div>
        </div>
    </div>
</div>
<?php
    break;
    
    case "view":
        $sid    = $_GET['id'];
        
        $sqle   = " SELECT aa.*, 
                           ab.tglbatal, 
                           ab.masa, 
                           ab.sisa, 
                           ab.refund, 
                           ab.reason, 
                           ab.catreason, 
                           ac.msdesc resdesc 
                    FROM   tr_sppa aa 
                           INNER JOIN tr_sppa_cancel ab 
                                   ON ab.regid = aa.regid 
                           LEFT JOIN ms_master ac 
                                  ON ac.msid = ab.catreason 
                                     AND ac.mstype = 'batal' 
                    WHERE  aa.regid = '$sid' ";
        $query  = mysql_query($sqle);
        $r      = mysql_fetch_array($query);
        
        $sjkel      = $r['jkel'];
        $spekerjaan = $r['pekerjaan'];
        $scabang    = $r['cabang'];
        $ssubject   = $r['subject'];
        $sregid     = $r['regid'];
        $sproduk    = $r['produk'];
        $smitra     = $r['mitra'];
        $sphoto     = "photo/" . $sregid . ".jpg";
        $sreason    = $r['reason'];
        $sbatal     = $r['catreason'];
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
                        <h2>view <small><?php echo $sid; ?></small></h2>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
						<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
						<input type="hidden" name="userid" value="<?php echo $userid; ?>">
						<input type="hidden" name="regid" value="<?php echo $sregid; ?>">
						<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="regid" name="regid" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
								
                            </div>	
                        </div>
					    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="nama" name="nama"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
								
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
                                <input type="text" id="tgllahir" name="tgllahir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tgllahir']); ?>">
								
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
                            	<select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel">
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
                            	<select disabled class="select2_single form-control" tabindex="-2" name="mitra" id="mitra">
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
                            	<select disabled class="select2_single form-control" tabindex="-2" name="cabang" id="cabang">
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
                            	<select disabled class="select2_single form-control" tabindex="-2" name="pekerjaan" id="pekerjaan">
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
                                <input type="text" id="masa" name="masa" min="0" max="600" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >
								
                            </div>
                        </div>
						
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="mulai" name="mulai"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['mulai']); ?>" >
								
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Extra Premi 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="epremi" name="epremi"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['epremi'],0); ?>">
								
                            </div>
                        </div>
							<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Batal 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="tglbatal" name="tglbatal" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tglbatal']); ?>">
								
                            </div>
                        </div>										
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Refund Premi 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="refund" name="refund"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['refund'],0); ?>">
								
                            </div>
                        </div>	
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alasan
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            	<select disabled class="select2_single form-control" tabindex="-2" name="catreason" id="catreason">
								<option value="" selected="selected">-- Pilih Alasan --</option>
								<?php
								$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype in ('batal','refund')  order by ms.mstype ";
								$query=mysql_query($sqlcmb);
								while($bariscb=mysql_fetch_array($query)){
								?>
								<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sbatal){ ?> selected="selected" <? }?>> 
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
								<textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($sreason)); ?></textarea>                                            
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
    								$sqld   = " SELECT a.regid, 
                                                       a.tglupload, 
                                                       a.nama_file, 
                                                       a.tipe_file, 
                                                       a.ukuran_file, 
                                                       a.FILE, 
                                                       a.pages, 
                                                       a.seqno, 
                                                       a.jnsdoc 
                                                FROM   tr_document a 
                                                WHERE  regid = '$sid' ";  
    								$query  = mysql_query($sqld);
    								$num    = mysql_num_rows($query);
    								$no     = 1;
    								while ($r=mysql_fetch_array($query)) {
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
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                       	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="history.back(-1)"><i class="fa fa-arrow-left"></i> Back</button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<?php
    break;

    case "update":
        $sid    = $_GET['id'];
        $sqle   = " SELECT aa.*,
                           ab.catreason sbatal, 
                           ab.tglbatal  tglbatal, 
                           ab.reason 
                    FROM   tr_sppa aa 
                           INNER JOIN tr_sppa_cancel ab 
                                   ON ab.regid = aa.regid 
                    WHERE  aa.regid = '$sid' ";
        $query  = mysql_query($sqle);
        $r      = mysql_fetch_array($query);
        
        $sjkel      = $r['jkel'];
        $spekerjaan = $r['pekerjaan'];
        $scabang    = $r['cabang'];
        $ssubject   = $r['subject'];
        $sregid     = $r['regid'];
        $sproduk    = $r['produk'];
        $smitra     = $r['mitra'];
        $sphoto     = "photo/" . $sregid . ".jpg";
        $sreason    = $r['reason'];
        $sbatal     = $r['sbatal'];
        $sstatus    = $r['status'];
        $scond      = array( '7','71','72');
        $sfield     = $sstatus;
        
        $scond1 = array( '8','81','82');
        $sfield1 = $sstatus;
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
                        <h2>Edit Pembatalan <small><?php echo $sid; ?></small></h2>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
        					<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
        					<input type="hidden" name="userid" value="<?php echo $userid; ?>">
        					<input type="hidden" name="regid" value="<?php echo $sregid; ?>">
        					<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="regid" name="regid" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
    								
                                </div>	
                            </div>
    					    <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <input type="text" id="nama" name="nama"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
    								
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
                                    <input type="text" id="tgllahir" name="tgllahir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tgllahir']); ?>">
    								
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
                                	<select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel">
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
                                	<select disabled class="select2_single form-control" tabindex="-2" name="mitra" id="mitra">
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
                                	<select disabled class="select2_single form-control" tabindex="-2" name="cabang" id="cabang">
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
                                	<select disabled class="select2_single form-control" tabindex="-2" name="pekerjaan" id="pekerjaan">
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
                                    <input type="text" id="masa" name="masa" min="0" max="600" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >
    								
                                </div>
                            </div>
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="mulai" name="mulai"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['mulai']); ?>" >
    								
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Extra Premi 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="epremi" name="epremi"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['epremi'],0); ?>">
    								
                                </div>
                            </div>
    						<?php if (in_array($sfield, $scond, TRUE)): ?>
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alasan Pembatalan <?=$r['sbatal'];?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<select class="select-reason select2_single form-control" tabindex="-2" name="catreason" id="catreason">
    								<option value="" selected="selected">-- choose category --</option>
    								<?php
    								$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='batal'  order by ms.msdesc ";
    								$query=mysql_query($sqlcmb);
    								while($bariscb=mysql_fetch_array($query)){
    								?>
    								<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sbatal){ ?> selected="selected" <? }?>> 
    									<?=$bariscb['comtab_nm']?>
    								</option>
    								<?php
    								}
    								?>
    								</select>
                                </div>
                            </div>						
    						<?php endif; ?>
    						
    						<?php if (in_array($sfield1, $scond1, TRUE)): ?>
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alasan Pembatalan 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<select  class="select-reason select2_single form-control" tabindex="-2" name="catreason" id="catreason">
    								<option value="" selected="selected">-- choose category --</option>
    								<?php
    								$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='refund'  order by ms.msdesc ";
    								$query=mysql_query($sqlcmb);
    								while($bariscb=mysql_fetch_array($query)){
    								?>
    								<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sbatal){ ?> selected="selected" <? }?>> 
    									<?=$bariscb['comtab_nm']?>
    								</option>
    								<?php
    								}
    								?>
    								</select>
                                </div>
                            </div>						
    						<?php endif; ?>
    						
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Pembatalan 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="date" id="tglbatal" name="tglbatal" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tglbatal']; ?>">
    								
                                </div>
                            </div>
    						
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan  
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
    								<textarea name="reason" rows="5" class="textbox" id="reason" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($sreason)); ?></textarea>                                            
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
            							$sqld   = " SELECT a.regid, 
                                                           a.tglupload, 
                                                           a.nama_file, 
                                                           a.tipe_file, 
                                                           a.ukuran_file, 
                                                           a.FILE, 
                                                           a.pages, 
                                                           a.createby, 
                                                           a.createdt, 
                                                           a.seqno, 
                                                           a.jnsdoc, 
                                                           a.catdoc 
                                                    FROM   tr_document a 
                                                    WHERE  a.regid = '$sid'  ";  
            							$query  = mysql_query($sqld);
            							$num    = mysql_num_rows($query);
            							$no     = 1;
            							while ($r=mysql_fetch_array($query)) {
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
                               	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=cancel'"><i class="fa fa-arrow-left"></i> Back</button>
        						<button type="submit" class="btn btn-sm btn-success">Submit</button>
                            </div>
                        </div>		
                    </div>
                </form>
                <script>
                    $(document).ready(function(){
                        $('.select-reason').val('<?=$r['reason'];?>').trigger('change');
                    })
                </script>
            </div>
        </div>
    </div>
</div>
</div>
<?php
break;

case "addcan":
$sid    = $_GET['id'];
$sqle   = "SELECT *
           FROM   tr_sppa aa 
           WHERE  aa.regid = '$sid' ";
/* echo $sqle;   */
$query  = mysql_query($sqle);
$r      = mysql_fetch_array($query);
$sjkel  = $r['jkel'];
$spekerjaan = $r['pekerjaan'];
$scabang    = $r['cabang'];
$ssubject   = $r['subject'];
$sregid     = $r['regid'];
$sproduk    = $r['produk'];
$smitra     = $r['mitra'];
$sphoto     = "photo/" . $sregid . ".jpg";

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
                                    <h2>Pembatalan <small><?php echo $sid; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=add"; ?>">
									<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
									<input type="hidden" name="userid" value="<?php echo $userid; ?>">
									<input type="hidden" name="regid" value="<?php echo $sregid; ?>">
									<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="regid" name="regid" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
												
                                            </div>	
                                        </div>
									    <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                 <input type="text" id="nama" name="nama"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
												
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
                                                <input type="text" id="tgllahir" name="tgllahir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tgllahir']); ?>">
												
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
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel">
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
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="mitra" id="mitra">
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
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="cabang" id="cabang">
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
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="pekerjaan" id="pekerjaan">
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
                                                <input type="text" id="masa" name="masa" min="0" max="600" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >
												
                                            </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="mulai" name="mulai"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['mulai']); ?>" >
												
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Batal 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tglbatal" name="tglbatal"   required="required" class="form-control col-md-7 col-xs-12" value="">
												
                                            </div>
                                        </div>										
										
									
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alasan
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select  class="select2_single form-control" tabindex="-2" name="catreason" id="catreason">
												<option value="" selected="selected">-- Pilih Alasan --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='batal'  order by ms.mstype ";
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<textarea name="reason" rows="5" class="textbox" id="subject" style='width: 100%;'></textarea>                                            
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
                                        

											
										
                                        </div>

                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="history.back(-1)"><i class="fa fa-arrow-left"></i> Back</button>
											<button type="submit" class="btn btn-sm btn-success">Submit</button>
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
case "refund":
$sid=$_GET['id'];

$sqle="select aa.*,ab.tglbatal,ab.reason,ab.catreason ";
$sqle= $sqle . " from tr_sppa aa left join tr_sppa_cancel ab on ab.regid=aa.regid ";
$sqle= $sqle . " where aa.regid='$sid'";

/* echo $sqle; */
$query=mysql_query($sqle);
$r=mysql_fetch_array($query);
$sjkel=$r['jkel'];
$spekerjaan=$r['pekerjaan'];
$scabang=$r['cabang'];
$ssubject=$r['subject'];
$sproduk=$r['produk'];
$susia=$r['tgllahir'] . ' / ' .  $r['usia'] . ' tahun ';
$smasaass=$r['masa'] . ' Bulan / '. $r['mulai'] . ' s/d ' . $r['mulai'] ; 
$stglbatal=$r['tglbatal'];
$sregid=$r['regid'];
$sphoto="photo/" . $sregid . ".jpg";
$scatreason=$r['catreason'];
$sreason=$r['reason'];
$sstatus=$r['status'];
$scond = array( 'cancel');
$sfield = $sstatus;

$scond1 = array( 'refund');
$sfield1 = $sstatus;
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
                                    <h2>Refund <small><?php echo $r['regid']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=refund"; ?>">
									<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
									<input type="hidden" name="userid" value="<?php echo $userid; ?>">
									<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="regid" name="regid"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
												
                                            </div>	
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman 
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir /Usia
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="tgllahir" name="tgllahir"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $susia; ?>">
												
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
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel">
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cabang 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="cabang" id="cabang">
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
                                            	<select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel">
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
                                                <input type="text" id="mulai" name="mulai"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $smasaass; ?>" >
												
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alasan Pembatalan 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            	<select  class="select2_single form-control" tabindex="-2" name="catreason" id="catreason">
												<option value="" selected="selected">-- choose category --</option>
												<?php
												$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='refund'  order by ms.msdesc ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
												<option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sbatal){ ?> selected="selected" <? }?>> 
													<?=$bariscb['comtab_nm']?>
												</option>
												<?php
												}
												?>
												</select>
                                            </div>
                                        </div>						
		
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Pembatalan 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="date" id="tglbatal" name="tglbatal"    required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tglbatal']; ?>">
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan  
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<textarea name="reason" rows="5" class="textbox" id="reason" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($sreason)); ?></textarea>                                            
											</div>
                                        </div>


                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                           	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="history.back(-1)"><i class="fa fa-arrow-left"></i> Back</button>
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

