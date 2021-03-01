<script>
	$(document).ready(function(){
		$("#form_add").css("display","none");
		$("#add").click(function(){
			$("#form_add").fadeToggle(1000);

		});
	
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
    include("../../config/fungsi_all.php");
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
            <div class="col-md-12 col-sm-12 col-xs-12">
				<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=home'"><i class="fa fa-arrow-left"></i> Back</button>
				<?php
				    if ($vlevel !== 'insurance') {
				?>
				<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Add" onclick="window.location='media.php?module=inqcancel'"><i class="fa fa-plus-circle"></i> Add</button>
				<?php
				    }
			    ?>
			</div>
            <div class="x_content">
				<style>
                    .large-table-container-3 {
                      max-width: 100%;
                      overflow-x: scroll;
                      overflow-y: auto;
                    }
                    .large-table-container-3 table {
                    
                    }
                    .large-table-fake-top-scroll-container-3 {
                      max-width: 100%;
                      overflow-x: scroll;
                      overflow-y: auto;
                    }
                    .large-table-fake-top-scroll-container-3 div {
                      background: #F7F7F7;
                      font-size:1px;
                      line-height:1px;
                    }
				</style>
				<div class="large-table-fake-top-scroll-container-3">
                    <div>&nbsp;</div>
                </div>
                <div class="large-table-container-3">
                    <br>
                    <table class="table table-bordered" id="table-cancel" style="width:100%;white-space: nowrap;">
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
    							<!--<th>reg_encode</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <script>
                    $(document).ready(function(){
                        var tableCancel = $('#table-cancel').DataTable({
                            "colReorder": true,
                		    "autoWidth": true,
                			"bProcessing": true,
                			"bServerSide": true,
                			"sAjaxSource": "modul/mod_cancel/data_cancel.php",
                			"sServerMethod": 'POST',
                			"aoColumns": [
                			  {"sName": "regid"},       // full[0]
                			  {"sName": "nama"},        // full[1]
                			  {"sName": "cabang"},      // full[2]
                			  {"sName": "tgllahir"},    // full[3]
                			  {"sName": "tglbatal"},    // full[4]
                			  {"sName": "mulai"},       // full[5]
                			  {                         // full[6]
                			      "mRender": function ( data, type, full, meta ) {
                					return $.fn.dataTable.render.number( ',', '.', 0 ).display(data);
                				  }
                			  },
                			  {                         // full[7]
                			      "mRender": function ( data, type, full, meta ) {
                					return $.fn.dataTable.render.number( ',', '.', 0 ).display(data);
                				  }
                			  },
                			  {"sName": "status"},      // full[8]
                			  {                         // full[9]
                				"mRender": function ( data, type, full, meta ) {
                				    data = data.split('-');
                				    var regid   = data[0],
                				        status  = data[1],
                				        sertif  = data[2],
                				        bordero = data[3],
                				        jdoc    = "",
                				        button  = "";
                				    
            				        if( ["72", "73", "82", "83"].includes(status) ){
                				        button += ``;
                				    } else {
                				        if ( '<?=$vlevel;?>' !== 'insurance') {
                    				        button += `<a style="display: inline-block;" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit" href="media.php?module=cancel&&act=update&&id=`+regid+`"><i class="fa fa-edit"></i> Edit</button>`;
                				        }
                				    }
                				    
                				    if( ["7","71","72","73"].includes(status) ) {
                				        jdoc = "DTBTL";
                				    } else {
                				        jdoc = "DTRFN";
                				    }
                				    
                				    button += `<a style="display: inline-block;" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit" href="media.php?module=cancel&&act=view&&id=`+regid+`"><i class="fa fa-search"></i> View</a>`;
                				    button += `<a style="display: inline-block;" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="View Documents" href="media.php?module=doc&&id=`+regid+`&&jenis=`+jdoc+`"><i class="fa fa-files-o"></i> Doc</a>`;
                				    
                				    if( ["7", "71", "72", "73", "8", "81", "82"].indexOf(status) == -1 ){
                				        button += `<a style="display: inline-block;" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Cetak Credit Note" href="laporan/refund/f_refund.php?id=`+sertif+`"><i class="fa fa-download"></i> CN</a>`;
                				    }
                				    
                				    if ( '<?=$vlevel;?>' == 'schecker' && ["7", "8"].includes(status) ) {
                				        button += `<a style="display: inline-block;" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Approve" href="<?=$aksi."?module=approve&&regid=";?>`+regid+`"><i class="fa fa-check-circle"></i> Approve</a>`;
                				        
                				    } else if ('<?=$vlevel;?>' == 'broker') {
            				            if( ["7", "8", "71", "81"].includes(status) ){
                				            button += `<a style="display: inline-block;" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Approve" href="<?=$aksi."?module=approve&&regid=";?>`+regid+`"><i class="fa fa-check-circle"></i> Approve</a>`;
            				                if( ["7", "71"].includes(status) ){
                				                button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Form Pembatalan" href="https://docs.google.com/gview?url=https://siap-laku.com/bank/laporan/batal/f_batal.php?id=`+regid+`&&jenis=batal" target="_blank"><i class="fa fa-download"></i> Batal</button>`;
                				            } else if( ["8", "81"].includes(status) ){
                				                button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Form Pembatalan" href="https://docs.google.com/gview?url=https://siap-laku.com/bank/laporan/batal/f_batal.php?id=`+regid+`&&jenis=refund" target="_blank"><i class="fa fa-download"></i> Batal</button>`;
                				            }
                				        } else if (status == 83) {
                				            button += `<a style="display: inline-block;" data-id="`+regid+`" class="btn-paid-broker btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Pembayaran Refund"><i class="fa fa-calendar"></i> Paid</a>`;
                				            button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Form Pembatalan" href="https://docs.google.com/gview?url=https://siap-laku.com/bank/laporan/batal/f_batal.php?id=`+regid+`&&jenis=refund" target="_blank"><i class="fa fa-download"></i> Batal</button>`;
                				        }
                				        
                				    } else if ('<?=$vlevel;?>' == 'insurance') {
                				        if (status == 84) {
                				            if (bordero == 'YES') {
                				                button += `<a style="display: inline-block;" class="btn-paid btn btn-xs btn-success" data-id="`+regid+`" data-toggle="tooltip" data-placement="top" title="Pembayaran Refund"><i class="fa fa-calendar"></i> Paid</a>`;
                				            }
                				        } else if( ["72", "82"].includes(status) ){
                				            button += `<a style="display: inline-block;" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Approve" href="<?=$aksi."?module=approve&&regid=";?>`+regid+`"><i class="fa fa-check-circle"></i> Approve</a>`;
                    				        // button += `<a style="display: inline-block;" class="btn-rollback btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Rollback" d-id="`+regid+`"><i class="fa fa-undo"></i> Rollback</a>`;
                				        }
                				        
                				    }
                				    
                				    if (status.indexOf('7') > -1) {
                				        var typeLog = "LTBTL";
                				    } else if (status.indexOf('8') > -1) {
                				        var typeLog = "LTRFN";
                				    }
                				    button += `<a style="display: inline-block;" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Pembayaran Claim" href="media.php?module=polhist&&act=log&&type=`+typeLog+`&&id=`+regid+`"><i class="fa fa-history"></i> Log</a>`;
                				    
                					return button;
                				}
                			  },
                			 // {"sName":"reg_encode","visible":false}, // full[10]
                			],
                			"columnDefs": [ 
                			    {
                                    "targets": 9,
                                    "orderable": false
                                },
                            ],
                            order: [[4, 'asc']],
                            initComplete: function() {
                                $('#table-cancel_filter input').unbind();
                                
                                $("#table-cancel_filter input").keyup(function(e) {
                                    if (e.keyCode == 13) {
                                        tableCancel.search(this.value).draw();
                                    }
                                });
                                $(function() {
                                    var tableContainer = $(".large-table-container-3");
                                    var table = $(".large-table-container-3 table");
                                    var fakeContainer = $(".large-table-fake-top-scroll-container-3");
                                    var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");
                                
                                    var tableWidth = table.width();
                                    fakeDiv.width(tableWidth+20);
                                
                                    fakeContainer.scroll(function() {
                                        tableContainer.scrollLeft(fakeContainer.scrollLeft());
                                    });
                                    tableContainer.scroll(function() {
                                        fakeContainer.scrollLeft(tableContainer.scrollLeft());
                                    });
                                })
                            }
                        });
                        
                        <?php
                            $custHTML = "<h4 style='width:100%;text-align: center;'>Tanggal Paid<i class='red'>*</i>:</h4>
                                         <input type='date' class='form-control' required style='width:100%;text-align: center;' id='tglbayar' name='tglbayar'>
                                         <h4 style='width:100%;text-align: center;'>Catatan:</h4>
                                         <textarea name='subject' id='subject' class='form-control'></textarea>";
                            if ($vlevel == 'insurance') {
                                $custHTML .= "<h4 style='width:100%;text-align: center;'>Bukti Pembayaran Refund<i class='red'>*</i>:</h4>";
                            }
                            $custHTML = trim(preg_replace('/\s\s+/', '', $custHTML));
                        ?>
                        
                        $('#table-cancel tbody').on('click', 'a.btn-paid', function() {
                            var id       = $(this).attr('data-id'),
                                htmlLama = $(this).html(); 
                            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
                            $(this).attr('disabled',true);
                            swal.fire({
                                html: "<?=$custHTML;?>",
                                input: 'file',
                                showCancelButton: true,
                                cancelButtonText: "Batal",
                                confirmButtonText: "Bayar",
                                onBeforeOpen : () => {
                                    $('#fupload').change(function(){
                                        var reader = new FileReader();
                                        reader.readAsDataURL(this.files[0]);
                                    })
                                }
                            }).then((file) => {
                                if (file.dismiss == 'backdrop' || file.dismiss == 'cancel') {
                                    
                                } else {
                                    if (file.value) {
                                        if ($('#tglbayar').val()) {
                                            var formData = new FormData(),
                                            file         = $('.swal2-file')[0].files[0],
                                            tglbayar     = $('#tglbayar').val(),
                                            subject      = $('#subject').val();
                                            if (file.size/1024/1024 > 2) {
                                                Swal.fire({
                                                    icon    : 'error',
                                                    title   : 'Ukuran Melebihi Kapasitas!',
                                                    text    : 'Mohon maaf, untuk saat ini file yang dapat diupload hanya yang berukuran dibawah 2 MB.',
                                                    footer  : 'Ukuran file anda: '+(file.size/1024/1024).toFixed(2) + ' MB'
                                                });
                                            } else {
                                                formData.append("fupload", file);
                                                formData.append("jdoc", "BTF");
                                                formData.append("catdoc", "RFN");
                                                
                                                formData.append("regid", id);
                                                formData.append("userid", "<?=$userid;?>");
                                                formData.append("subject", subject);
                                                formData.append("jenis-kas", "masuk");  //asuransi = kas masuk
                                                formData.append("tglbayar", tglbayar);
                                                formData.append("jenis-transaksi", "refund");
                                                formData.append("dajax", "true");
                                                
                                                $.ajax({
                                                    method: 'post',
                                                    url: 'modul/mod_bayar/aksi_bayar.php?module=add',
                                                    data: formData,
                                                    processData: false,
                                                    contentType: false,
                                                    success: function (resp) {
                                                        if (resp == 'berhasil') {
                                                            $.ajax({
                                                                method: "post",
                                                                url: "modul/mod_doc/aksi_doc.php?module=upload",
                                                                data: formData,
                                                                processData: false,
                                                                contentType: false,
                                                                success: function (resp2) {
                                                                    console.log(resp2);
                                                                    if (resp2 == 'berhasil') {
                                                                        swal.fire('Pembayaran Refund Berhasil..','','success');
                                                                        tableCancel.ajax.reload();
                                                                    } else {
                                                                        swal.fire('Ada yang salah:',resp2,'error');
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            swal.fire('Ada yang salah:',resp,'error');
                                                        }
                                                    }
                                                })
                                            }
                                        } else {
                                            swal.fire('Harap memilih tanggal bayar refund','','warning');
                                        }
                                    } else {
                                        swal.fire('Harap mengupload bukti pembayaran refund','','warning');
                                    }
                                }
                                $(this).attr('disabled',false);
                                $(this).html(htmlLama);
                            });
                        });
                        
                        $('#table-cancel tbody').on('click', 'a.btn-paid-broker', function() {
                            var id       = $(this).attr('data-id'),
                                htmlLama = $(this).html(); 
                            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
                            $(this).attr('disabled',true);
                            swal.fire({
                                html: "<?=$custHTML;?>",
                                // input: 'file',
                                showCancelButton: true,
                                cancelButtonText: "Batal",
                                confirmButtonText: "Bayar",
                                onBeforeOpen : () => {
                                    $('#fupload').change(function(){
                                        var reader = new FileReader();
                                        reader.readAsDataURL(this.files[0]);
                                    })
                                }
                            }).then((dismiss) => {
                                if (dismiss.dismiss == 'backdrop' || dismiss.dismiss == 'cancel') {
                                    
                                } else {
                                    if ($('#tglbayar').val()) {
                                        var formData = new FormData(),
                                            tglbayar = $('#tglbayar').val(),
                                            subject  = $('#subject').val();
                                            
                                        formData.append("regid", id);
                                        formData.append("userid", "<?=$userid;?>");
                                        formData.append("subject", subject);
                                        formData.append("jenis-kas", "keluar");  // kas keluar = broker
                                        formData.append("tglbayar", tglbayar);
                                        formData.append("jenis-transaksi", "refund");
                                        formData.append("dajax", "true");
                                        
                                        $.ajax({
                                            method: 'post',
                                            url: 'modul/mod_bayar/aksi_bayar.php?module=add',
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            success: function (resp) {
                                                if (resp == 'berhasil') {
                                                    swal.fire('Pembayaran Refund Berhasil..','','success');
                                                    tableCancel.ajax.reload();
                                                } else {
                                                    swal.fire('Ada yang salah:',resp,'error');
                                                }
                                            }
                                        })
                                    } else {
                                        swal.fire('Harap memilih tanggal bayar refund','','warning');
                                    }
                                }
                                $(this).attr('disabled',false);
                                $(this).html(htmlLama);
                            });
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
        // $sid    = encrypt_decrypt("decrypt",$_GET['id']);
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
                                <input type="text" id="regid" name="regid" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
								
                            </div>	
                        </div>
					    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="nama" name="nama"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
								
                            </div>	
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="nama" name="nama"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
								
                            </div>
                        </div>
						
						

						
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="tgllahir" name="tgllahir" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tgllahir']); ?>">
								
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="int" id="usia" name="usia"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>">
								
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="noktp" name="noktp"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">
								
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
                                <input type="text" id="masa" name="masa" min="0" max="600" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >
								
                            </div>
                        </div>
						
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="mulai" name="mulai"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['mulai']); ?>" >
								
                            </div>
                        </div>
						
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="akhir" name="akhir"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['akhir']); ?>">
								
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
                                <input type="text" id="epremi" name="epremi"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['epremi'],0); ?>">
								
                            </div>
                        </div>
							<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Batal 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="tglbatal" name="tglbatal" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tglbatal']); ?>">
								
                            </div>
                        </div>										
						
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Refund Premi 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="refund" name="refund"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['refund'],0); ?>">
								
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
    									<a href="<?php echo $r['file'] ?>" target="pdf-frame" class="btn btn-xs btn-default"><i class="fa fa-file-pdf-o"></i> Document</a>
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
                       	<button type="button" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="history.back(-1)"><i class="fa fa-arrow-left"></i> Back</button>

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
        // $sid    = encrypt_decrypt("decrypt",$_GET['id']);
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
                                    <input type="text" id="regid" name="regid" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
    								
                                </div>	
                            </div>
    					    <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <input type="text" id="nama" name="nama"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
    								
                                </div>	
                            </div>
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="nama" name="nama"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
    								
                                </div>
                            </div>
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="tgllahir" name="tgllahir" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tgllahir']); ?>">
    								
                                </div>
                            </div>
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="int" id="usia" name="usia"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>">
    								
                                </div>
                            </div>
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="noktp" name="noktp"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">
    								
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
                                    <input type="text" id="masa" name="masa" min="0" max="600" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >
    								
                                </div>
                            </div>
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="mulai" name="mulai"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['mulai']); ?>" >
    								
                                </div>
                            </div>
    						<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="akhir" name="akhir"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['akhir']); ?>">
    								
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
                                    <input type="text" id="epremi" name="epremi"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['epremi'],0); ?>">
    								
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
                                    <input type="date" id="tglbatal" name="tglbatal" required class="form-control col-md-7 col-xs-12" value="<?php echo $r['tglbatal']; ?>">
    								
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
            								<a href="<?php echo $r['file'] ?>" target="pdf-frame" class="btn btn-xs btn-default"><i class="fa fa-file-pdf-o"></i> Document</a>
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
                               	<button type="button" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=cancel'"><i class="fa fa-arrow-left"></i> Back</button>
        						<button type="submit" class="btn btn-xs btn-success">Submit</button>
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
// $sid    = encrypt_decrypt("decrypt",$_GET['id']);
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
                                                <input type="text" id="regid" name="regid" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
												
                                            </div>	
                                        </div>
									    <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                 <input type="text" id="nama" name="nama"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
												
                                            </div>	
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nama" name="nama"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
												
                                            </div>
                                        </div>
										
										

										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="tgllahir" name="tgllahir" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tgllahir']); ?>">
												
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="int" id="usia" name="usia"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>">
												
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="noktp" name="noktp"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">
												
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
                                                <input type="text" id="masa" name="masa" min="0" max="600" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"  >
												
                                            </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="mulai" name="mulai"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['mulai']); ?>" >
												
                                            </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="akhir" name="akhir"  readonly required class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['akhir']); ?>">
												
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
                                                <input type="date" id="tglbatal" name="tglbatal"   required class="form-control col-md-7 col-xs-12" value="">
												
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
												

											
												
												<a href="<?php echo $r['file'] ?>" target="pdf-frame" class="btn btn-xs btn-default"><i class="fa fa-file-pdf-o"></i> Document</a>
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
										
                                           	<button type="button" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="history.back(-1)"><i class="fa fa-arrow-left"></i> Back</button>
											<button type="submit" class="btn btn-xs btn-success">Submit</button>
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
			
<?php
break;			
case "refund":
// $sid=encrypt_decrypt("decrypt",$_GET['id']);
$sid=$_GET['id'];
// echo "<script>alert('".$sid."');</script>";
// die;
$sqle=" SELECT aa.*,
               ab.tglbatal,
               ab.reason,
               ab.catreason,
               ac.paiddt 'tglbayar'
        FROM   tr_sppa aa
               LEFT JOIN tr_sppa_cancel ab
                    ON ab.regid = aa.regid
               LEFT JOIN (SELECT * FROM tr_sppa_paid WHERE paidtype='PREMI') ac
                    ON ac.regid = aa.regid
        WHERE  aa.regid = '$sid' ";

/* echo $sqle; */
$query      = mysql_query($sqle);
$r          = mysql_fetch_array($query);
$sjkel      = $r['jkel'];
$spekerjaan = $r['pekerjaan'];
$scabang    = $r['cabang'];
$ssubject   = $r['subject'];
$sproduk    = $r['produk'];
$susia      = $r['tgllahir'] . ' / ' .  $r['usia'] . ' tahun ';
$smasaass   = $r['masa'] . ' Bulan / '. $r['mulai'] . ' s/d ' . $r['mulai'] ; 
$stglbatal  = $r['tglbatal'];
$sregid     = $r['regid'];
$sphoto     = "photo/" . $sregid . ".jpg";
$scatreason = $r['catreason'];
$sreason    = $r['reason'];
$sstatus    = $r['status'];
$scond      = array( 'cancel');
$sfield     = $sstatus;

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
                                    <input type="text" id="regid" name="regid" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="nopeserta" name="nopeserta" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="nama" name="nama" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir /Usia
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="tgllahir" name="tgllahir" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $susia; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="noktp" name="noktp" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">
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
                                        <option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sjkel){ ?> selected="selected"
                                            <? }?>>
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
                                        <option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$scabang){ ?> selected="selected"
                                            <? }?>>
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
                                        <option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$spekerjaan){ ?> selected="selected"
                                            <? }?>>
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
                                    <input type="text" id="mulai" name="mulai" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo $smasaass; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="up" name="up" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'],0); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Premi
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="premi" name="premi" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['premi'],0); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Extra Premi
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="epremi" name="epremi" readonly required class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['epremi'],0); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alasan Pembatalan
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select required class="select2_single form-control" tabindex="-2" name="catreason" id="catreason">
                                        <option value="" selected="selected">-- choose category --</option>
                                        <?php
											$sqlcmb="select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='refund'  order by ms.msdesc ";
											$query=mysql_query($sqlcmb);
											while($bariscb=mysql_fetch_array($query)){
										?>
                                        <option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$sbatal){ ?> selected="selected"
                                            <? }?>>
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
                                    <input type="date" id="tglbatal" name="tglbatal" required class="form-control col-md-7 col-xs-12" value="<?php echo $r['tglbatal']; ?>">
                                    <span id="ket-tgl" class="red"></span>
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
                                    <button type="button" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="history.back(-1)"><i class="fa fa-arrow-left"></i> Back</button>
                                    <button type="submit" class="btn btn-xs btn-default">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <script>
                        $(document).ready(function(){
                            $('#tglbatal').change(function(){
                                var start = new Date('<?=$r['tglbayar'];?>'),
                                end   = new Date($('#tglbatal').val()),
                                diff  = new Date(end - start),
                                days  = diff/1000/60/60/24;
                                
                                if (days < 0) {
                                    $('button[type="submit"]').attr('disabled',true);
                                    $('#ket-tgl').text('Tanggal pembatalan tidak boleh kurang dari tanggal pembayaran premi');
                                } else {
                                    $('button[type="submit"]').attr('disabled',false);
                                    $('#ket-tgl').text('');
                                }
                            });
                        })
                    </script>
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

