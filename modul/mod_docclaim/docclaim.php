<script>
	$(document).ready(function(){
		$("#form_add").css("display","none");
		$("#add").click(function(){
			$("#form_add").fadeToggle(1000);

		});
	});
</script>

<?php	
$aksi   = "modul/mod_docclaim/aksi_docclaim.php";
$vlevel = $_SESSION['idLevel'];
$judul  = "Document Claim";
$sid    = $_GET['id'];
date_default_timezone_set('Asia/Jakarta');

$query  = mysql_query("SELECT a.*  FROM tr_sppa a WHERE regid='$sid'");
$r      = mysql_fetch_array($query);
$snama  = $r['nama'];

$judul2=$sid." - ".$snama;
switch(isset($_GET['act'])){
	default:
	
?>
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
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a onclick="window.history.back();" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                </div>
                <div id="hasil"></div>
                <div style="width:100%;overflow-x:auto;">
                    <table class="table table-bordered" id="table-docclaim" style="width:100%;">
                        <thead>
                            <tr>
    							<th>Dokumen </th>
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
                            var tableDocclaim = $('#table-docclaim').DataTable({
                                "pageLength": -1,
                                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                                "colReorder": true,
                                "scrollX": true,
                    		    "autoWidth": true,
                    			"bProcessing": true,
                    			"bServerSide": true,
                    			"sAjaxSource": "modul/mod_docclaim/data_docclaim.php?regid=<?=$sid;?>",
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
                    				    var sedit   = data[0];
                    				    var jdoc    = data[1];
                    				    var ukuran  = data[2];
                    				    var dokumen = data[3];
                    				    var link    = data[4];
                    				    
                    				    if (ukuran == 'kosong') {
                    				        if ('<?=$vlevel;?>' != 'insurance') {
                    				            var button = `<button type="button" class="btn-upload btn btn-sm btn-secondary" dokumen="`+dokumen+`" jdoc="`+jdoc+`" data-toggle="tooltip" data-placement="top" title="Upload"><i class="fa fa-upload"></i> Upload</button>`;
                    				        } else {
                    				            var button =`<i class="fa fa-exclamation-triangle"> No Data</i>`;
                    				        }
                    				    } else {
                    				        var button = `<a href="`+link+`" target="pdf-frame" class="btn btn-sm btn-default"><i class="fa fa-file-pdf-o"></i> View</a>`;
                    				        if ('<?=$vlevel;?>' != 'insurance') {
                    				            button += `<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="window.location='<?=$aksi;?>?module=delete&&sedit=`+sedit+`'"><i class="fa fa-trash"></i> Delete</button>`;
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
                            });
                            
                            $('#table-docclaim tbody').on('click', '.btn-upload', function() {
                                var dokumen = $(this).attr('dokumen');
                                var jdoc    = $(this).attr('jdoc');
                                Swal.fire({
                                    title: dokumen,
                                    text: 'Pilih Dokumen:',
                                    icon: 'info',
                                    showCancelButton: true,
                                    confirmButtonText: 'Upload',
                                    input: 'file',
                                    onBeforeOpen: () => {
                                        $(".swal2-file").change(function () {
                                            var reader = new FileReader();
                                            reader.readAsDataURL(this.files[0]);
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
                                            $.ajax({
                                                method: 'post',
                                                url: 'modul/mod_docclaim/aksi_docclaim.php?module=upload',
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function (resp) {
                                                    $('.btn-upload').html('<i class="fa fa-upload"></i> Upload');
                                                    $('.btn-upload').attr('disabled',false);
                                                    if (resp == 'berhasil') {
                                                        Swal.fire('Berhasil Diupload', 'Dokumen:<br>'+dokumen, 'success');
                                                        tableDocclaim.ajax.reload();
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
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
break;

case "update":
$sid=$_GET['id'];
$query=mysql_query("SELECT a.*  FROM tr_sppa a WHERE a.regid='$sid'");
$r=mysql_fetch_array($query);
$regid=$r['regid'];
$nama=$r['nama'];

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
                                    <h2>Update <small><?php echo $r['regid']; ?></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
									<input type="hidden" name="id" value="<?php echo $r['iddiag']; ?>">
                                       
										
										
									
                                        
                                        
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                               <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=client'"><i class="fa fa-arrow-left"></i> Back</button>

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