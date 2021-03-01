<script>
    var linkGoogle1 = "",
        linkGoogle2 = "";
    if ('<?=$_SESSION['idLevel'];?>' !== 'broker') {
        linkGoogle1 = "https://docs.google.com/gview?url=";
        linkGoogle2 = "&hl=id&embedded=true";
    }
</script>
<?php	
$host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/"; // pembeda siap-laku sama siapdev
$uri = explode("/",$_SERVER[REQUEST_URI])[1]."/";  // pembeda bank sama beta
$linkSIAP = $host.$uri;

include("../../config/fungsi_all.php");
$aksi   = "modul/mod_doc/aksi_doc.php";
$vlevel = $_SESSION['idLevel'];
$judul  = "Document";
$jenis  = $_GET['jenis'];
$sid    = $_GET['id'];
// $sid    = encrypt_decrypt("decrypt",$_GET['id']);
date_default_timezone_set('Asia/Jakarta');

$query  = $db->query("SELECT a.*  FROM tr_sppa a WHERE regid='$sid'");
$r      = $query->fetch_array();
$snama  = $r['nama'];

$judul2=$sid." - ".$snama;
switch(isset($_GET['act'])){
	default:
?>
<div class="modal fade bs-example-modal-lg" id="modal-help-doc" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <b><h4 class="modal-title">Cara Download File</h4></b>
                <button type="button" class="close" data-dismiss="modal" style="position:relative;top:-20px"><span aria-hidden="true" class="fa fa-times"></span></button>
            </div>
            <div class="load-content">
                <div class="modal-body">
                    <div class="card text-center">
                        <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Gambar (.jpg,.png,.jpeg)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Dokumen (.docx,.doc,.pdf)</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <img src="https://i.ibb.co/grfsYDL/tut-doc-img.png" class="img-fluid" width="100%" height="100%" alt="Download Gambar">
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <img src="https://i.ibb.co/ccJmjMx/tut-doc-doc.png" width="100%" alt="Download Dokumen">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $judul; ?></h3>
                <h3><?php echo $judul2; ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                    <a onclick="window.history.back();" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                    <a onclick="$('#modal-help-doc').modal('show');" class="btn btn-default btn-sm"><i class="fa fa-info-circle"></i> Cara Download File</a>
                    <br>
                    <select id="jdoc" class="select2_single input-sm">
                        <?php
                            $dataJDOC = $db->query("SELECT msid, msdesc FROM ms_master WHERE mstype = 'DOCTYPE' ORDER BY msid ASC");
                            while ($row = $dataJDOC->fetch_array()) {
                        ?>
                            <option value="<?=$row['msid'];?>"><?=$row['msdesc'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                </div>
            <!--<div class="x_panel">-->
            <div class="x_content">
                <div style="width:100%;overflow-x:auto;">
                    <table class="table table-bordered" id="table-doc" style="width:100%;white-space: nowrap;">
                        <thead>
                            <tr>
    							<th>Dokumen (<i class="fa fa-asterisk red"></i> Wajib Diunggah)</th>
                                <th>Tipe File </th>
                                <th>Ukuran </th>
                                <th>Tgl. Upload </th>
    							<th> </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <script>
                        $(document).ready(function(){
                            var tableDoc = $('#table-doc').DataTable({
                                // "pageLength": -1,
                                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                                "dom": 'rtlip',
                                "colReorder": true,
                                "scrollX": true,
                    		    "autoWidth": true,
                    			"bProcessing": true,
                    			"bServerSide": true,
                    			"sAjaxSource": "modul/mod_doc/data_doc.php?regid=<?=$sid;?>&&jenis=<?=$jenis;?>",
                    			"sServerMethod": 'POST',
                    			"aoColumns": [
                    			  {"sName": "dokumen"},
                    			  {"sName": "tipe",
                    			      "defaultContent": "<i>Belum ada data</i>",
                    			  },
                    			  {"sName": "ukuran",
                    			      "defaultContent": "<i>Belum ada data</i>",
                    			  },
                    			  {"sName": "tglupload",
                    			      "defaultContent": "<i>Belum ada data</i>"
                    			  },
                    			  {
                    				"mRender": function ( data, type, full ) {
                    				    data = data.split('-');
                    				    var sedit   = data[0],
                    				        jdoc    = data[1],
                    				        ukuran  = data[2],
                    				        tipe    = data[3],
                    				        dokumen = data[4],
                    				        link    = data[5],
                    				        level   = data[6],
                    				        button  = "";
                    				    
                    				    if (ukuran == 'null') {
                    				        if ('<?=$vlevel;?>' != 'insurance') {
                    				            if (level == 'null') {
                    				                button += `<button type="button" class="btn-upload btn btn-sm btn-secondary" dokumen="`+dokumen+`" jdoc="`+jdoc+`" data-toggle="tooltip" data-placement="top" title="Upload"><i class="fa fa-upload"></i> Upload`+level+`</button>`;    
                    				            } else {
                    				                button += `<i class="fa fa-exclamation-triangle red"></i> <i class="red"> No Data</i>`;
                    				            }
                    				        } else {
                    				            button += `<i class="fa fa-exclamation-triangle red"></i> <i class="red"> No Data</i>`;
                    				        }
                    				    } else {
                    				        if (['jpg','png','jpeg'].includes(tipe)) {
                    				            button += `<a target="_blank" href="`+link+`" class="btn btn-sm btn-default"><i class="fa fa-file-pdf-o"></i> View</a>`;
                    				        } else {
                        				        button += `<a href="` + linkGoogle1 + `<?= $linkSIAP ;?>` + link + linkGoogle2 + `" target="pdf-frame" class="btn btn-sm btn-default"><i class="fa fa-file-pdf-o"></i> View</a>`;
                    				        }
                    				        if ('<?=$vlevel;?>' != 'insurance') {
                    				            button += `<button type="button" class="btn-hapus btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" dokumen="`+dokumen+`" sedit="`+sedit+`"><i class="fa fa-trash"></i> Delete</button>`;
                    				        }
                    				    }
                    					return button;
                    				}
                    			  }
                    			],
                    			"columnDefs": [ 
                    			    {"targets": 4,
                                     "orderable": false},
                                ],
                                order: [[0, 'asc']],
                                initComplete: function(){
                                    $('#table-doc_filter input').unbind();
                                
                                    $("#table-doc_filter input").keyup(function(e) {
                                        if (this.value == "") {
                                            tableDoc.search(this.value).draw();
                                        } else {
                                            if (e.keyCode == 13) {
                                                tableDoc.search(this.value).draw();
                                            }
                                        }
                                    });
                                }
                            });
                            
                            $('#jdoc').change(function(){
                                var val = $(this).val();
                                tableDoc.clear().destroy();
                                tableDoc = $('#table-doc').DataTable({
                                    // "pageLength": -1,
                                    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                                    "dom": 'rtlip',
                                    "colReorder": true,
                                    "scrollX": true,
                        		    "autoWidth": true,
                        			"bProcessing": true,
                        			"bServerSide": true,
                        			"sAjaxSource": "modul/mod_doc/data_doc.php?regid=<?=$sid;?>&&jenis="+val,
                        			"sServerMethod": 'POST',
                        			"aoColumns": [
                        			  {
                        			      "sName": "dokumen",
                        			      "mRender": function ( data, type, full ) {
                        			          var mandat = full[4].split('-');
                        			          if (mandat[7] == 'wajib') {
                        			              return data+" <i class='fa fa-asterisk red' style='top: 1px;'></i>";
                        			          } else {
                        			              return data;
                        			          }
                        			      }
                        			  },
                        			  {"sName": "tipe",
                        			      "defaultContent": "<i>Belum ada data</i>",
                        			  },
                        			  {"sName": "ukuran",
                        			      "defaultContent": "<i>Belum ada data</i>",
                        			  },
                        			  {"sName": "tglupload",
                        			      "defaultContent": "<i>Belum ada data</i>"
                        			  },
                        			  {
                        				"mRender": function ( data, type, full ) {
                        				    data = data.split('-');
                        				    var sedit   = data[0],
                        				        jdoc    = data[1],
                        				        ukuran  = data[2],
                        				        tipe    = data[3],
                        				        dokumen = data[4],
                        				        link    = data[5],
                        				        level   = data[6],
                        				        button  = "";
                        				    
                        				    if (ukuran == 'null') {
                        				        if ('<?=$vlevel;?>' != 'insurance') {
                        				            if (level == 'null') {
                        				                button += `<button type="button" class="btn-upload btn btn-sm btn-primary" dokumen="`+dokumen+`" jdoc="`+jdoc+`" data-toggle="tooltip" data-placement="top" title="Upload"><i class="fa fa-upload"></i> Upload</button>`;    
                        				            } else {
                        				                button += `<i class="fa fa-exclamation-triangle red"></i> <i class="red"> No Data</i>`;
                        				            }
                        				        } else {
                        				            if (level == 'null') {
                        				                button += `<i class="fa fa-exclamation-triangle red"></i> <i class="red"> No Data</i>`;
                        				            } else {
                        				                button += `<button type="button" class="btn-upload btn btn-sm btn-primary" dokumen="`+dokumen+`" jdoc="`+jdoc+`" data-toggle="tooltip" data-placement="top" title="Upload"><i class="fa fa-upload"></i> Upload</button>`;    
                        				            }
                        				        }
                        				    } else {
                        				        if (['jpg','png','jpeg'].includes(tipe)) {
                        				            button += `<a target="_blank" href="`+link+`" class="btn btn-sm btn-default"><i class="fa fa-file-pdf-o"></i> View</a>`;
                        				        } else {
                            				        button += `<a href="` + linkGoogle1 + `<?= $linkSIAP ;?>` + link + linkGoogle2 + `" target="pdf-frame" class="btn btn-sm btn-default"><i class="fa fa-file-pdf-o"></i> View</a>`;
                        				        }
                        				        if ('<?=$vlevel;?>' != 'insurance') {
                        				            if (level == 'null') {
                        				                button += `<button type="button" class="btn-hapus btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" dokumen="`+dokumen+`" sedit="`+sedit+`"><i class="fa fa-trash"></i> Delete</button>`;
                        				            }
                        				        } else {
                        				            if (level != 'null') {
                        				                button += `<button type="button" class="btn-hapus btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" dokumen="`+dokumen+`" sedit="`+sedit+`"><i class="fa fa-trash"></i> Delete</button>`;
                        				            }
                        				        }
                        				    }
                        					return button;
                        				}
                        			  }
                        			],
                        			"columnDefs": [ 
                        			    {"targets": 4,
                                         "orderable": false},
                                    ],
                                    order: [[0, 'asc']],
                                    initComplete: function(){
                                        $('#table-doc_filter input').unbind();
                                    
                                        $("#table-doc_filter input").keyup(function(e) {
                                            if (this.value == "") {
                                                tableDoc.search(this.value).draw();
                                            } else {
                                                if (e.keyCode == 13) {
                                                    tableDoc.search(this.value).draw();
                                                }
                                            }
                                        });
                                    }
                                });
                            });
                            
                            <?php
                                if (isset($jenis)) {
                            ?>
                                $('#jdoc').val('<?=$jenis;?>').change();
                            <?php
                                } else {
                            ?>
                                $('#jdoc').val('DTALL').change();
                            <?php
                                }
                            ?>
                            $('#table-doc tbody').on('click', '.btn-upload', function() {
                                <?php
                                    // echo "console.log(`SELECT * FROM ms_master WHERE mstype = 'DOCTYPE' WHERE msid = '$jenis'`);";
                                    $data = $db->query("SELECT * FROM ms_master WHERE mstype = 'DOCTYPE' AND msid = '$jenis'");
                                    $r    = $data->fetch_array();
                                ?>
                                var dokumen = $(this).attr('dokumen'),
                                    jdoc    = $(this).attr('jdoc'),
                                    catdoc  = '<?=$r['createby'];?>';       //pemanggilan catdoc yang tersimpan sebagai createby
                                Swal.fire({
                                    title: dokumen,
                                    text: 'Pilih Dokumen:',
                                    icon: 'info',
                                    footer: 'Harap memilih dokumen dengan ukuran di bawah 2 MB.',
                                    showCancelButton: true,
                                    confirmButtonText: 'Upload',
                                    input: 'file',
                                    onBeforeOpen: () => {
                                        $('.swal2-file').attr('accept','.doc, .docx, .pdf, .jpg, .jpeg, .tif, .png');
                                        $(".swal2-file").change(function () {
                                            var files = $(this)[0].files[0];
                                            if (files.size/1024/1024 > 2) {
                                                Swal.fire({
                                                    icon    : 'error',
                                                    title   : 'Ukuran Melebihi Kapasitas!',
                                                    text    : 'Mohon maaf, untuk saat ini file yang dapat diupload hanya yang berukuran dibawah 2 MB.',
                                                    footer  : 'Ukuran file anda: '+(files.size/1024/1024).toFixed(2) + ' MB'
                                                });
                                                $(this).val("");
                                            } else {
                                                $('#ukuran-file').remove();
                                                $('div.swal2-content').append('<span id="ukuran-file">Ukuran File: '+(files.size/1024/1024).toFixed(2)+' MB</span>');
                                                var reader = new FileReader();
                                                reader.readAsDataURL(this.files[0]);
                                            }
                                        });
                                    }
                                }).then((file) => {
                                    if (file.value) {
                                        $('.btn-upload').html('<i class="fa fa-spin fa-spinner"></i> Loading');
                                        $('.btn-upload').attr('disabled',true);
                                        var formData = new FormData();
                                        var file = $('.swal2-file')[0].files[0];
                                        if (file.size/1024/1024 > 2) {
                                            $('.btn-upload').html('<i class="fa fa-upload"></i> Upload');
                                            $('.btn-upload').attr('disabled',false);
                                            Swal.fire({
                                                icon    : 'error',
                                                title   : 'Ukuran Melebihi Kapasitas!',
                                                text    : 'Mohon maaf, untuk saat ini file yang dapat diupload hanya yang berukuran dibawah 2 MB.',
                                                footer  : 'Ukuran file anda: '+(file.size/1024/1024).toFixed(2) + ' MB'
                                            });
                                        } else {
                                            formData.append("fupload", file);
                                            formData.append("regid", "<?=$sid;?>");
                                            formData.append("jdoc", jdoc);
                                            formData.append("catdoc", catdoc);
                                            $.ajax({
                                                method: 'post',
                                                url: 'modul/mod_doc/aksi_doc.php?module=upload',
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function (resp) {
                                                    $('.btn-upload').html('<i class="fa fa-upload"></i> Upload');
                                                    $('.btn-upload').attr('disabled',false);
                                                    // console.log(resp);
                                                    if (resp == 'berhasil') {
                                                        Swal.fire('Berhasil Diupload', 'Dokumen:<br>'+dokumen, 'success');
                                                        tableDoc.ajax.reload();
                                                    } else if (resp == 'wrong'){
                                                        Swal.fire({title:'Dokumen Salah', html:'Harap mengupload file dokumen hasil scan (pdf), word document (doc) atau foto', icon:'error'});
                                                    } else {
                                                        Swal.fire({title:'Gagal Diupload', html:'Dokumen:<br>'+dokumen, icon:'error', footer:'Harap menghubungi Team BDS.'});
                                                    }
                                                },
                                                error: function() {
                                                    Swal({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                                                }
                                            })
                                        }
                                    }
                                })
                            });
                            $('#table-doc tbody').on('click', '.btn-hapus', function() {
                                var sedit   = $(this).attr('sedit'),
                                    dokumen = $(this).attr('dokumen');
                                
                                dokumen = dokumen.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                    return letter.toUpperCase();
                                });
                                
                                Swal.fire({
                                    title: 'Apakah Anda Yakin?',
                                    text: "Dokumen yang dihapus tidak akan dapat dikembalikan!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.value) {
                                        $('.btn-hapus').html('<i class="fa fa-spin fa-spinner"></i> Loading');
                                        $('.btn-hapus').attr('disabled',true);
                                        $.ajax({
                                            url: "modul/mod_doc/aksi_doc.php?module=delete",
                                            data: {"sedit":sedit},
                                            type: "POST",
                                            success: function(resp) {
                                                $('.btn-hapus').html('<i class="fa fa-trash"></i> Delete');
                                                $('.btn-hapus').attr('disabled',false);
                                                if (resp == "berhasil") {
                                                    tableDoc.ajax.reload();
                                                    Swal.fire('Terhapus!','Berhasil Menghapus Dokumen: <br>'+dokumen,'success');
                                                } else {
                                                    Swal.fire('Error!',sedit,'error');
                                                }
                                                // console.log(resp);
                                            }
                                        });
                                    }
                                })
                            });
                        });
                    </script>
                </div>
            </div>
            <!--</div>-->
        </div>
    </div>
</div>
<?php
break;
}
?>