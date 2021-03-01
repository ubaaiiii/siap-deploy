<style>
    .select2-dropdown {
      z-index: 1061;
    }
</style>
<script>
	function tandaPemisahTitik(b) {
        var _minus = false;
        if (b < 0) _minus = true;
        b = b.toString();
        b = b.replace(".", "");
        b = b.replace("-", "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "." + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        if (_minus) c = "-" + c;
        return c;
    }
    
    function numbersonly(ini, e) {
        if (e.keyCode >= 49) {
            if (e.keyCode <= 57) {
                a = ini.value.toString().replace(".", "");
                b = a.replace(/[^\d]/g, "");
                b = (b == "0") ? String.fromCharCode(e.keyCode) : b + String.fromCharCode(e.keyCode);
                ini.value = tandaPemisahTitik(b);
                return false;
            } else if (e.keyCode <= 105) {
                if (e.keyCode >= 96) {
                    //e.keycode = e.keycode - 47;
                    a = ini.value.toString().replace(".", "");
                    b = a.replace(/[^\d]/g, "");
                    b = (b == "0") ? String.fromCharCode(e.keyCode - 48) : b + String.fromCharCode(e.keyCode - 48);
                    ini.value = tandaPemisahTitik(b);
                    //alert(e.keycode);
                    return false;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else if (e.keyCode == 48) {
            a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode);
            b = a.replace(/[^\d]/g, "");
            if (parseFloat(b) != 0) {
                ini.value = tandaPemisahTitik(b);
                return false;
            } else {
                return false;
            }
        } else if (e.keyCode == 95) {
            a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode - 48);
            b = a.replace(/[^\d]/g, "");
            if (parseFloat(b) != 0) {
                ini.value = tandaPemisahTitik(b);
                return false;
            } else {
                return false;
            }
        } else if (e.keyCode == 8 || e.keycode == 46) {
            a = ini.value.replace(".", "");
            b = a.replace(/[^\d]/g, "");
            b = b.substr(0, b.length - 1);
            if (tandaPemisahTitik(b) != "") {
                ini.value = tandaPemisahTitik(b);
            } else {
                ini.value = "";
            }
    
            return false;
        } else if (e.keyCode == 9) {
            return true;
        } else if (e.keyCode == 17) {
            return true;
        } else {
            //alert (e.keyCode);
            return false;
        }
    
    }

	$(document).ready(function(){
		$("#form_add").css("display","none");
		$("#add").click(function(){
			$("#form_add").fadeToggle(1000);

		});

    });
</script>
<?php	
    $veid=$_SESSION['id_peg'];
    $vempname=$_SESSION['empname'];
    $vlevel=$_SESSION['idLevel'];
    $userid=$_SESSION['idLog'];
    $aksi="modul/mod_claim/aksi_claim.php";
    
    if (!isset($_GET['act'])) {
?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Claim Register</h3>
            </div>
        </div>
        <div class="clearfix"></div>


        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Back</button>
                <?php if ($vlevel !== 'insurance') { ?>
                <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Add" onclick="window.location='media.php?module=claimpro'"><i class="fa fa-plus-circle"></i> Add</button>
                <?php } ?>
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
                    <table class="table table-bordered" id="table-claim" style="white-space: nowrap">
                        <thead>
                            <tr>
                                <th>No. Claim </th>
                                <th>No. Register </th>
                                <th>Produk </th>
                                <th>Nama </th>
                                <th>Cabang </th>
                                <th>Tgl Lapor </th>
                                <th>Tgl Kejadian </th>
                                <th>UP </th>
                                <th>Outstanding </th>
                                <th>Status </th>
                                <?php if(in_array($vlevel,['checker'])){ ?>
                                    <th>Sisa Waktu </th>
                                <?php } else { ?>
                                    <th>Jatuh Tempo </th>
                                <?php } ?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <script>
                    $(document).ready(function(){
                        var tableClaim = $('#table-claim').DataTable({
                            "colReorder": true,
                			"bProcessing": true,
                			"autoWidth": true,
                			"bServerSide": true,
                			"sAjaxSource": "modul/mod_claim/data_claim.php",
                			"sServerMethod": 'POST',
                			"aoColumns": [
                			  {"sName": "regclaim"},    // full[0] => No Reg Claim
                			  {"sName": "regid"},       // full[1] => No Reg ID
                			  {"sName": "produk"},      // full[2] => Produk
                			  {"sName": "nama"},        // full[3] => Nama
                			  {"sName": "cabang"},      // full[4] => Cabang
                			  {"sName": "tgllapor"},    // full[5] => Tgl Lapor
                			  {"sName": "tglkejadian"}, // full[6] => Tgl Kejadian
                			  {                         // full[7] => Premi
                			      "mRender": function ( data, type, full ) {
                					return $.fn.dataTable.render.number( ',', '.', 0 ).display(data);
                				  }
                			  },
                			  {                         // full[8] => Nilai OS
                			      "mRender": function ( data, type, full ) {
                					return $.fn.dataTable.render.number( ',', '.', 0 ).display(data);
                				  }
                			  },
                			  {"sName": "status"},      // full[9] => Status
                			  <?php if (in_array($vlevel,['schecker','checker'])){ ?>
                    			  {"sName": "sisawaktu","defaultContent": "<b><i>EXPIRED</i></b>"}, // full[10] => Sisa Waktu
                    		  <?php } else { ?>  
                    			  {"sName": "jatuhtempo","defaultContent": "<b><i>EXPIRED</i></b>"},// full[10] => Tgl Jatuh Tempo
                			  <?php } ?>
                			  {                         // full[11] => Aksi
                				"mRender": function ( data, type, full ) {
                				    data = data.split('-');
                				    var regclaim= data[0],
                				        regid   = data[1],
                				        status  = data[2],
                				        nama    = data[3];
                				    
                				    if (('<?=$vlevel;?>' == 'broker' && (status == '90' || status == '91')) || ('<?=$vlevel;?>' == 'checker' && status == '90')) {
                				        var button = `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="media.php?module=claim&&act=update&&id=`+full[1]+`"><i class="fa fa-edit"></i> Edit</a>`;
                				        button += `<a class="btn-batal btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Batal Claim" data-id="`+full[1]+`"><i class="fa fa-times"></i> Batal</a>`;
                				    } else {
                				        var button = `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Lihat Data" href="media.php?module=claim&&act=view&&id=`+full[1]+`"><i class="fa fa-search"></i> View</a>`;
                				    }
                				    
                				    button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="View Documents" href="media.php?module=doc&&id=`+full[1]+`&&jenis=DTCLM"><i class="fa fa-files-o"></i> Doc</a>`;
                				    button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Download Checklist Document" href="laporan/claim/f_claim.php?id=`+full[1]+`"><i class="fa fa-download"></i> List</a>`;
                				    
                				    
                				    if ('<?=$vlevel;?>' == 'broker' && status == '91') {
                				        button += `<a class="btn-approve btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Approve" data-regid="`+full[1]+`" data-id="`+full[0]+`"><i class="fa fa-check"></i> Approve</a>`;
                				        button += `<button type="button" class="btn-rollback btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Rollback" data-id="`+full[1]+`" data-nama="`+nama+`"><i class="fa fa-undo"></i> Rollback</button>`;  
                				    }
                				    
                				    if ('<?=$vlevel;?>' == 'schecker' && status == '90') {
                				        button += `<a class="btn-approve btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Approve" data-regid="`+full[1]+`" data-id="`+full[0]+`"><i class="fa fa-check"></i> Approve</a>`;
                				    }
                				    
                				    if ('<?=$vlevel;?>' == 'insurance') {
                				        if (status == '90') {
                				            button += `<a class="btn-reject btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Reject" data-id="`+full[1]+`" data-nama="`+nama+`"><i class="fa fa-warning"></i> Expired</a>`;
                				        } else if (status == '92') {
                				            button += `<a class="btn-approve-ins btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Approve" data-regid="`+full[1]+`" data-id="`+full[0]+`"><i class="fa fa-check"></i> Approve</a>`;
                    				        button += `<a class="btn-reject btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Reject" data-id="`+full[1]+`" data-nama="`+nama+`"><i class="fa fa-times"></i> Reject</a>`;
                    				        button += `<button type="button" class="btn-rollback btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Rollback" data-id="`+full[1]+`" data-nama="`+nama+`"><i class="fa fa-undo"></i> Rollback</button>`;  
                				        } else if (status == '93') {
                				            button += `<a class="btn-receive btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Dokumen Telah Diterima" data-id="`+full[1]+`"><i class="fa fa-check-circle"></i> Received</a>`;
                				        } else if (status == '96') {
                				            button += `<a class="btn-paid btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" data-nil="`+full[8]+`" data-id="`+full[1]+`" title="Pembayaran Claim"><i class="fa fa-calendar"></i> Paid</a>`;
                				        }
                				    }
                				    
                				    button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="History Log" href="media.php?module=polhist&&act=log&&type=LTCLM&&id=`+full[1]+`"><i class="fa fa-history"></i> Log</button>`;
                				    
                				    return button;
                				}
                			  }
                			],
                			"columnDefs": [ 
                			    {
                                    "targets": <?=(in_array($vlevel,['schecker','checker','insurance','broker']))?('11'):('10');?>,
                                    "orderable": false,
                                },
                                {
                                    targets: [7,8],
                                    className: 'text-right'
                                }
                            ],
                            order: [[5, 'desc']],
                            initComplete: function() {
                                $('#table-claim_filter input').unbind();
                                
                                $("#table-claim_filter input").keyup(function(e) {
                                    if (this.value == "") {
                                        tableClaim.search(this.value).draw();
                                    } else {
                                        if (e.keyCode == 13) {
                                            tableClaim.search(this.value).draw();
                                        }
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
                            },
                            createdRow: function( row, data, dataIndex ) {
                                if ($(row).is(":contains('EXPIRED')")) {
                                    $(row).addClass('red');
                                }
                                <?php
                                    if ($vlevel == 'insurance') {
                                        echo "
                                        if ($(row).is(\":contains('CLAIM PENDING')\")) {
                                            $(row).addClass('red');
                                        }";
                                    }
                                ?>
                                if (data[10] !== null) {
                                    var sisa = data[10].match(/\d+/);
                                    if (sisa <= 15) {
                                        $(row).addClass('red');
                                        $(row).css('font-style','italic');    
                                    }
                                } else {
                                    $(row).addClass('red');
                                    $(row).css('font-style','italic');
                                }
                            },
                        });
                        
                        <?php
                            $custHTML = "<h4 style='width:100%;text-align: center;'>Tanggal Paid<i class='red'>*</i>:</h4>
                                         <input type='date' class='form-control' required style='width:100%;text-align: center;' id='tglbayar' name='tglbayar'><br>
                                         <input type='text' onkeydown='return numbersonly(this, event);' class='form-control' required style='width:100%;text-align: center;' id='jmlbyr' name='jmlbyr' placeholder='Jumlah Claim Dibayar*..'><br>
                                         <textarea name='subject' id='subject' class='form-control' placeholder='Catatan...'></textarea>
                                         <h4 style='width:100%;text-align: center;'>Bukti Pembayaran Claim<i class='red'>*</i>:</h4>";
                            $custHTML = trim(preg_replace('/\s\s+/', '', $custHTML));
                        ?>
                        
                        $('#table-claim tbody').on('click', 'a.btn-paid', function() {
                            var regid       = $(this).attr('data-id'),
                                htmlLama    = $(this).html(),
                                nilaios     = $(this).attr('data-nil');
                                
                            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
                            $(this).prop('disabled',true);
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
                                    $(this).html(htmlLama);
                                    $(this).prop('disabled',false);
                                } else {
                                    if (file.value) {
                                        if ($('#tglbayar').val()) {
                                            if ($('#jmlbyr').val()) {
                                                var formData = new FormData(),
                                                file         = $('.swal2-file')[0].files[0],
                                                tglbayar     = $('#tglbayar').val(),
                                                subject      = $('#subject').val(),
                                                jmlbyr       = $('#jmlbyr').val();
                                                
                                                if (file.size/1024/1024 > 2) {
                                                    Swal.fire({
                                                        icon    : 'error',
                                                        title   : 'Ukuran Melebihi Kapasitas!',
                                                        text    : 'Mohon maaf, untuk saat ini file yang dapat diupload hanya yang berukuran dibawah 2 MB.',
                                                        footer  : 'Ukuran file anda: '+(file.size/1024/1024).toFixed(2) + ' MB'
                                                    });
                                                } else {
                                                    formData.append("fupload", file);
                                                    formData.append("jdoc", "BPC");   // Bukti Pembayaran Claim
                                                    formData.append("catdoc", "CLM"); // Claim
                                                    
                                                    formData.append("regid", regid);
                                                    formData.append("jmlbyr", jmlbyr);
                                                    formData.append("jenis-transaksi", "claim");
                                                    formData.append("userid", "<?=$userid;?>");
                                                    formData.append("subject", subject);
                                                    formData.append("tglbayar", tglbayar);
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
                                                                        // console.log(resp2);
                                                                        if (resp2 == 'berhasil') {
                                                                            swal.fire('Pembayaran Claim Berhasil..','','success');
                                                                            tableClaim.ajax.reload();
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
                                                swal.fire('Harap mengisi jumlah bayar claim','','warning');
                                            }
                                        } else {
                                            swal.fire('Harap memilih tanggal bayar claim','','warning');
                                        }
                                    } else {
                                        swal.fire('Harap mengupload bukti pembayaran claim','','warning');
                                    }
                                    $(this).html(htmlLama);
                                    $(this).prop('disabled',false);
                                }
                            });
                        });
                            
                        $('#table-claim tbody').on('click', 'a.btn-approve', function() {
                            var id    = $(this).attr('data-id');
                            var regid = $(this).attr('data-regid');
                            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
                            $(this).prop('disabled',true);
                            $.ajax({
                                url: "<?=$aksi;?>?module=approve",
                                data: {"id":id,"regid":regid},
                                type: "POST",
                                success: function(resp) {
                                    // console.log(resp);
                                    $(this).html('<i class="fa fa-check"></i> Approve');
                                    $(this).prop('disabled',false);
                                    if (resp == "berhasil") {
                                        Swal.fire(
                                            'Berhasil Approve!',
                                            '',
                                            'success'
                                        );
                                        tableClaim.ajax.reload();
                                    } else {
                                        Swal.fire(
                                            'Gagal Approve!',
                                            'errcode: '+resp,
                                            'error'
                                        );
                                    }
                                }
                            })
                        });
                        
                        $('#table-claim tbody').on('click', 'a.btn-approve-ins', function() {
                            var id    = $(this).attr('data-id')
                                regid = $(this).attr('data-regid'),
                                htmlLama = $(this).html();
                            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
                            $(this).prop('disabled',true);
                            swal.fire({
                                title: "Harap Mengupload Surat Keterangan Claim Valid: ",
                                input: 'file',
                                icon: 'info',
                                showCancelButton: true,
                                cancelButtonText: "Batal",
                                confirmButtonText: "Approve",
                                onBeforeOpen : () => {
                                    $('#fupload').change(function(){
                                        var reader = new FileReader();
                                        reader.readAsDataURL(this.files[0]);
                                    })
                                }
                            }).then((file) => {
                                if (file.dismiss == 'backdrop' || file.dismiss == 'cancel') {
                                    $(this).html(htmlLama);
                                    $(this).prop('disabled',false);
                                } else {
                                    if (file.value) {
                                        var formData = new FormData(),
                                            file     = $('.swal2-file')[0].files[0];
                                        if (file.size/1024/1024 > 2) {
                                            Swal.fire({
                                                icon    : 'error',
                                                title   : 'Ukuran Melebihi Kapasitas!',
                                                text    : 'Mohon maaf, untuk saat ini file yang dapat diupload hanya yang berukuran dibawah 2 MB.',
                                                footer  : 'Ukuran file anda: '+(file.size/1024/1024).toFixed(2) + ' MB'
                                            });
                                        } else {
                                            formData.append("fupload", file);
                                            formData.append("regid", regid);
                                            formData.append("jdoc", "SKC");   // Surat Keterangan Claim
                                            formData.append("catdoc", "CLM"); // Claim
                                            $.ajax({
                                                url: "<?=$aksi;?>?module=approve",
                                                data: {"id":id,"regid":regid},
                                                type: "POST",
                                                success: function(resp) {
                                                    // console.log(resp);
                                                    $(this).html('<i class="fa fa-check"></i> Approve');
                                                    $(this).prop('disabled',false);
                                                    if (resp == "berhasil") {
                                                        $.ajax({
                                                            method: "post",
                                                            url: "modul/mod_doc/aksi_doc.php?module=upload",
                                                            data: formData,
                                                            processData: false,
                                                            contentType: false,
                                                            success: function (resp2) {
                                                                // console.log(resp2);
                                                                if (resp2 == 'berhasil') {
                                                                    Swal.fire('Berhasil Approve!','','success');
                                                                    tableClaim.ajax.reload();
                                                                } else {
                                                                    swal.fire('Gagal Upload:','errcode: '+resp2,'error');
                                                                }
                                                            }
                                                        });
                                                    } else {
                                                        Swal.fire(
                                                            'Gagal Approve!',
                                                            'errcode: '+resp,
                                                            'error'
                                                        );
                                                    }
                                                }
                                            })
                                        }
                                    } else {
                                        swal.fire('Harap mengupload bukti pembayaran refund','','warning');
                                    }
                                    $(this).html(htmlLama);
                                    $(this).prop('disabled',false);
                                }
                            });
                        });
                        
                        $('#table-claim tbody').on('click', 'a.btn-batal', function() {
                            var id = $(this).attr('data-id');
                            swal.fire({
                                title: 'Mohon Mengisi Alasan Batal Claim',
                                input: 'textarea',
                                icon: 'info',
                                showCancelButton: true,
                            }).then(function(result) {
                                if (result.value) {
                                    $("a.btn-batal").html('<i class="fa fa-spin fa-spinner"></i> Loading');
                                    var alasan = result.value;
                                    $.ajax({
                                        url: "<?=$aksi;?>?module=delete",
                                        data: {"regid":id,"comment":alasan},
                                        type: "POST",
                                        success: function(resp) {
                                            $("a.btn-batal").html('<i class="fa fa-times"></i> Batal');
                                            if (resp == "berhasil") {
                                                Swal.fire(
                                                    'Batal Claim Berhasil!',
                                                    'Debitur telah dibatalkan claimnya',
                                                    'success'
                                                );
                                                tableClaim.ajax.reload();
                                            } else {
                                                Swal.fire(
                                                    'Batal Gagal!',
                                                    'Debitur gagal dibatalkan claimnya',
                                                    'error'
                                                );
                                            }
                                        }
                                    })
                                }
                            });
                            
                        })
                        
                        $('#table-claim tbody').on('click', 'button.btn-rollback', function() {
                            var id = $(this).attr('data-id');
                            var nama = $(this).attr('data-nama');
                            swal.fire({
                                title: 'Mohon Mengisi Alasan Rollback Untuk Debitur:<br>' + nama,
                                input: 'textarea',
                                icon: 'info',
                                showCancelButton: true,
                            }).then(function(result) {
                                if (result.value) {
                                    var alasan = result.value;
                                    $.ajax({
                                        url: "<?=$aksi;?>?module=rollback&&regid="+id+"&&comment="+alasan,
                                        success: function(data){
                                            if (data == 'berhasil') {
                                                Swal.fire(
                                                    'Rollback Berhasil!',
                                                    'Debitur a/n: ' + nama + ' telah berhasil dirollback status claimnya',
                                                    'success'
                                                );
                                                tableClaim.ajax.reload();
                                            } else {
                                                // console.log(data);
                                                Swal.fire(
                                                    'Rollback Gagal!',
                                                    'Debitur a/n: ' + nama + ' gagal dirollback',
                                                    'error'
                                                );
                                            }
                                        }
                                    })
                                }
                            })
                        });
                        
                        $('#table-claim tbody').on('click', 'a.btn-receive', function() {
                            var id = $(this).attr('data-id'),
                                htmlLama = $(this).html();
                            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
                            $(this).attr('disabled','true');
                            $.ajax({
                                url: "<?=$aksi;?>?module=receive&&regid="+id,
                                success: function(data) {
                                    if (data == 'berhasil') {
                                        swal.fire('Berhasil..','','success');
                                        tableClaim.ajax.reload();
                                    } else {
                                        swal.fire('Ada yang salah:',data,'error');
                                    }
                                    $(this).attr('disabled','true');
                                    $(this).html(htmlLama);
                                }
                            })
                        });
                        
                        <?php
                            $query = mysql_query("SELECT msid,msdesc FROM ms_master WHERE mstype='REJECTTYPE'");
                            $selectHTML = '<select required id="select-alasan" class="swal2-select" width="100%">';
                            while ($row = mysql_fetch_array($query)) {
                                $selectHTML .= "<option value=\"".$row['msid']."\">".$row['msdesc']."</option>";
                            }
                            $selectHTML .= '</select><br>
                                            <textarea class="swal2-textarea" id="keterangan" placeholder="Keterangan lebih detail"></textarea><br>
                                            <span>Upload Surat Pernyataan Reject Claim<br>';
                            $selectHTML = trim(preg_replace('/\s\s+/', '', $selectHTML));
                        ?>
                        
                        var formData   = new FormData();
                        $('#table-claim tbody').on('click', '.btn-reject', function() {
                            var id   = $(this).attr('data-id'),
                                nama = $(this).attr('data-nama'),
                                expired = false;
                            if ($(this).is(':contains("Expired")')) {
                                expired = true;
                            }
                            $(this).attr('disabled',true);
                            var htmlLama = $(this).html();
                            $(this).html('<i class="fa fa-spin fa-spinner"></i> Loading');
                            swal.fire({
                                title: 'Mohon Mengisi Alasan Reject Untuk Debitur:<br>' + nama,
                                html: '<?=$selectHTML;?>',
                                input: 'file',
                                showCancelButton: true,
                                cancelButtonText: "Batal",
                                confirmButtonText: "Reject",
                                onOpen : () => {
                                    $('#select-alasan').select2({
                                        placeholder: "Pilih Alasan Reject..",
                                        allowClear: true
                                    });
                                    if (expired == true) {
                                        $('#select-alasan').val("EXPIRED").change();
                                    } else {
                                        $('#select-alasan').val(null).change();
                                    }
                                },
                                onBeforeOpen : () => {
                                    $('#fupload').change(function(){
                                        var reader = new FileReader();
                                        reader.readAsDataURL(this.files[0]);
                                    })
                                }
                            }).then((file) => {
                                if (file.dismiss == 'backdrop' || file.dismiss == 'cancel') {
                                    $(this).attr('disabled',false);
                                    $(this).html(htmlLama);
                                } else {
                                    if (file.value) {
                                        if ($('#select-alasan').val()) {
                                            var formData    = new FormData(),
                                                file        = $('.swal2-file')[0].files[0],
                                                alasan      = $('#select-alasan').val(),
                                                keterangan  = $('#keterangan').val();
                                            if (file.size/1024/1024 > 2) {
                                                Swal.fire({
                                                    icon    : 'error',
                                                    title   : 'Ukuran Melebihi Kapasitas!',
                                                    text    : 'Mohon maaf, untuk saat ini file yang dapat diupload hanya yang berukuran dibawah 2 MB.',
                                                    footer  : 'Ukuran file anda: '+(file.size/1024/1024).toFixed(2) + ' MB'
                                                });
                                            } else {
                                                formData.append("fupload", file);
                                                formData.append("regid", id);
                                                formData.append("jdoc", "SKC");   // Surat Keterangan Claim
                                                formData.append("catdoc", "CLM"); // Claim
                                                
                                                formData.append("alasan", alasan);
                                                formData.append("keterangan", keterangan);
                                                
                                                $.ajax({
                                                    method: 'post',
                                                    url: '<?=$aksi;?>?module=reject',
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
                                                                    // console.log(resp2);
                                                                    if (resp2 == 'berhasil') {
                                                                        swal.fire('Reject Berhasil..','','success');
                                                                        tableClaim.ajax.reload();
                                                                    } else {
                                                                        swal.fire('Gagal Upload','errcode: '+resp2,'error');
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            swal.fire('Gagal Reject','err code: '+resp,'error');
                                                        }
                                                    }
                                                })
                                            }
                                        } else {
                                            swal.fire('Harap memilih alasan reject','','warning');
                                        }
                                    } else {
                                        swal.fire('Harap mengupload surat pernyataan reject claim','','warning');
                                        $(this).attr('disabled',false);
                                        $(this).html(htmlLama);
                                    }
                                }
                            });
                        });
                        
                        
                    });
                    </script>
            </div>
        </div>
    </div>
</div>
<?php
} else {

$sid = $_GET['id'];
$act = $_GET['act'];
switch ($act) {
case "add":
    $query = mysql_query("SELECT a.*,
                                 b.msdesc 'wktclm',
                                 b.createby 'wktdoc'
                          FROM   tr_sppa a
                          LEFT JOIN (SELECT msid, msdesc, createby FROM ms_master WHERE mstype ='WKTCLM') b
                                 ON b.msid = concat(a.asuransi,a.produk) 
                          WHERE  a.regid = '$sid' ");
    $r = mysql_fetch_array($query);
    
    $queryReg = mysql_query("SELECT Concat(Concat(prevno, Date_format(Now(), '%y%m')), RIGHT( 
                                           Concat(formseqno, b.lastno), formseqlen)) AS seqno 
                             FROM   tbl_lastno_form a 
                                    LEFT JOIN tbl_lastno_trans b 
                                           ON a.trxid = b.trxid 
                             WHERE  a.trxid = 'regclm' ");
    $d        = mysql_fetch_array($queryReg);
    $regclaim = $d['seqno'];
    
    $updReg = mysql_query("UPDATE tbl_lastno_trans 
                           SET    lastno = lastno + 1 
                           WHERE  trxid = 'regclm' ");
                           
    $judul = "Add";
    $action = "add";
    break;
    
case "update":
    $query = mysql_query("SELECT aa.*, 
                                 ab.regclaim, 
                                 ab.tgllapor, 
                                 ab.tmpkejadian, 
                                 ab.tglkejadian, 
                                 ab.`comment`, 
                                 ab.penyebab, 
                                 ab.detail, 
                                 ab.nopk, 
                                 ab.nilaios,
                                 ac.msdesc 'wktclm',
                                 ac.createby 'wktdoc'
                          FROM   tr_sppa aa 
                                 INNER JOIN tr_claim ab 
                                         ON aa.regid = ab.regid
                                 LEFT JOIN (SELECT msid, msdesc, createby FROM ms_master WHERE mstype = 'WKTCLM') ac
                                         ON ac.msid = concat(aa.asuransi,aa.produk) 
                          WHERE  ab.regid = '$sid' ");
    $r = mysql_fetch_array($query);
    
    $regclaim = $r['regclaim'];
    $judul = "Edit";
    $action = "update";
    break;
    
case "view":
    $query = mysql_query("SELECT aa.*, 
                                 ab.regclaim, 
                                 ab.tgllapor, 
                                 ab.tmpkejadian, 
                                 ab.tglkejadian, 
                                 ab.`comment`, 
                                 ab.penyebab, 
                                 ab.detail, 
                                 ab.nopk, 
                                 ab.nilaios, 
                                 ac.msdesc 'wktclm',
                                 ac.createby 'wktdoc' 
                          FROM   tr_sppa aa 
                                 INNER JOIN tr_claim ab 
                                         ON aa.regid = ab.regid 
                                 LEFT JOIN (SELECT msid, msdesc, createby FROM ms_master WHERE mstype = 'WKTCLM') ac
                                         ON ac.msid = concat(aa.asuransi,aa.produk) 
                          WHERE  ab.regid = '$sid' ");
    $r = mysql_fetch_array($query);
    
    $regclaim = $r['regclaim'];
    $judul = "View";
    $action = "";
    break;
    
default:
    header("location:media.php?module=claim");
    break;
    
}

?>
<?php
    if ($vlevel == 'checker') {
        if ($r['status'] !== '90' && $act == 'update') {
            return header("location:media.php?module=claim");
        }
    } elseif ($vlevel == 'schecker') {
        if ($r['status'] !== '91' && $act == 'update') {
            return header("location:media.php?module=claim");
        }
    }
?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Claim</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?=$judul;?> Data<small><?= $r['regid']; ?></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?= $aksi."?module=".$action; ?>">
                            <input type="hidden" name="id" value="<?= $r['regid']; ?>">
                            <input type="hidden" name="userid" value="<?= $userid; ?>">
                            <input type="hidden" name="regid" value="<?= $sregid; ?>">
                            <input type="hidden" name="produk" value="<?= $r['produk']; ?>">
                            <input type="hidden" name="insurance" value="<?= $r['asuransi']; ?>">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Claim
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="regclaim" name="regclaim" readonly required class="form-control col-md-7 col-xs-12" value="<?= $regclaim; ?>">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="regid" name="regid" readonly required class="form-control col-md-7 col-xs-12" value="<?= $r['regid']; ?>">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="nama" name="nama" readonly required class="form-control col-md-7 col-xs-12" value="<?= $r['nama']; ?>">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia /Tgl Lahir
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="susia" name="susia" readonly required class="form-control col-md-7 col-xs-12" value="<?=$r['usia'] . ' Tahun / ' . tglindo_balik($r['tgllahir']);?>">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="masaas" name="masaas" readonly required class="form-control col-md-7 col-xs-12" value="<?= $r['masa'] . ' Bulan / ' . tglindo_balik($r['mulai'])  .' s/d '. tglindo_balik($r['akhir']); ?>">

                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="up" name="up" readonly class="form-control col-md-7 col-xs-12" value="<?= number_format($r['up'],0); ?>">

                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="nopeserta" name="nopeserta" readonly class="form-control col-md-7 col-xs-12" value="<?= $r['nopeserta']; ?>">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nilai OS
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="textA" id="nilaios" name="nilaios" placeholder="dalam rupiah" required class="form-control col-md-7 col-xs-12" onkeydown="return numbersonly(this, event);" value="<?=number_format($r['nilaios'],0,',','.');?>">
                                </div>
                            </div>
                            <script>
                                $(document).ready(function(){
                                    var nilaiup  = parseInt("<?=$r['up'];?>");
                                    var nilaios2 = 0;
                                    $('#nilaios').keyup(function(){
                                        var nilaios = parseInt($(this).val().split('.').join(""));
                                        // console.log(nilaios+" "+nilaiup);
                                        // console.log(nilaios > nilaiup);
                                        if (nilaios > nilaiup === true){
                                            swal.fire('Kesalahan!','Nilai OS tidak boleh lebih dari nilai UP','error');
                                            $('button[type="submit"]').attr('disabled',true);
                                            $(this).val(nilaios2);
                                        } else {
                                            nilaios2 = $(this).val();
                                            tandaPemisahTitik(nilaios);
                                            $('button[type="submit"]').attr('disabled',false);
                                        }
                                    })
                                })
                            </script>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl lapor
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <input type="date" value="<?= $r['tgllapor']; ?>" id="tgllapor" name="tgllapor" value="dd-mm-yyyy" required class="range-tgl form-control col-md-7 col-xs-12">

                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Kejadian
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="date" value="<?= $r['tglkejadian']; ?>" id="tglkejadian" name="tglkejadian" value="dd-mm-yyyy" required class="range-tgl form-control col-md-7 col-xs-12">
                                    <span id="sisa-waktu"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tempat Kejadian
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_single form-control" tabindex="-2" required name="tmpkejadian" id="tmpkejadian">
                                        <option value="" selected="selected">-- choose category --</option>
                                        <?php
												$sqlcmb="select   ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='TMPCLM'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
                                        <option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$smitra){ ?> selected="selected"
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Penyebab Kematian
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_single form-control" tabindex="-2" required name="sebab" id="sebab">
                                        <option value="" selected="selected">-- choose category --</option>
                                        <?php
												$sqlcmb="select   ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='SBBCLM'  order by ms.mstype ";
												$query=mysql_query($sqlcmb);
												while($bariscb=mysql_fetch_array($query)){
												?>
                                        <option value="<?=$bariscb['comtabid']?>" <? if($bariscb['comtabid']==$smitra){ ?> selected="selected"
                                            <? }?>>
                                            <?=$bariscb['comtab_nm']?>
                                        </option>
                                        <?php
												}
												?>
                                    </select>
                                </div>
                            </div>
                            <?php
                                if ($action == 'update') {
                            ?>
                            
                            <div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea name="subject" rows="5" class="textbox" id="subject" style="width: 98%;" data-parsley-id="8971"></textarea><ul class="parsley-errors-list" id="parsley-id-8971"></ul>
								</div>
							</div>
                            
                            <?php
                                }
                            ?>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Back</button>
                                    
                                    <?php if($judul !== 'View') { ?>
                                    <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-paper-plane"></i> &nbsp;Submit</button>
                                    <?php } ?>
                                </div>
                            </div>



                    </div>

                    </form>
                    <script>
                        $(document).ready(function(){
                            // if ('<?=$_GET['act'];?>' == 'add') {
                            //     $('#sisa-waktu').removeAttr('hidden');
                            //     $('.range-tgl').removeAttr('value');
                            // }
                            
                            $('.range-tgl').change(function(){
                                var tgllapor    = $('#tgllapor').val(),
                                    tglkejadian = $('#tglkejadian').val(),
                                    waktupengajuan = <?=$r['wktclm'];?>,
                                    waktudokumen   = <?=$r['wktdoc'];?>;
                                
                                
                                if (tgllapor !== '' && tglkejadian !== '') {
                                    var start = new Date(tglkejadian),
                                    end   = new Date(tgllapor),
                                    diff  = new Date(end - start),
                                    today = new Date(),
                                    diff2 = new Date(today - end),
                                    sisa  = diff2/1000/60/60/24,
                                    days  = waktupengajuan - diff/1000/60/60/24;
                                    // console.log(diff2);
                                    if (days > waktupengajuan) {
                                        $('#sisa-waktu').text("Pengisian Tanggal Lapor dan Tanggal Kejadian Salah!");
                                        $('#sisa-waktu').addClass("red");
                                        $('button[type="submit"]').attr('disabled',true);
                                    } else {
                                        $('#sisa-waktu').removeClass("red");
                                        if (days < 0) {
                                            days = "Expired, akan langsung diteruskan ke Asuransi untuk proses reject klaim";
                                            $('#sisa-waktu').addClass('red');
                                        } else {
                                            days += " hari";
                                            $('#sisa-waktu').removeClass('red');
                                        }
                                        $('#sisa-waktu').text("Sisa waktu pengumpulan dokumen: "+days);
                                        if (waktudokumen !== 0) {
                                            if (waktudokumen - sisa < 0) {
                                                $('#sisa-waktu').text("Expired, akan langsung diteruskan ke Asuransi untuk proses reject klaim");
                                                $('#sisa-waktu').addClass('red');
                                            } else {
                                                $('#sisa-waktu').text("Sisa waktu pengajuan claim: "+days+" + pengumpulan dokumen: "+waktudokumen+" hari");
                                                $('#sisa-waktu').removeClass('red');
                                            }
                                        }
                                        $('button[type="submit"]').attr('disabled',false);
                                    }
                                }
                            });
                            
                            $('.range-tgl').change();
                            
                            $('#tmpkejadian').val('<?=$r['tmpkejadian'];?>').trigger('change');
                            $('#sebab').val('<?=$r['penyebab'];?>').trigger('change');
                            
                            if ('<?=$judul;?>' == 'View') {
                                $('#nilaios').attr('disabled',true);
                                $('#tgllapor').attr('disabled',true);
                                $('#tglkejadian').attr('disabled',true);
                                $('#tmpkejadian').attr('disabled',true);
                                $('#sebab').attr('disabled',true);
                            }
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
}
?>

