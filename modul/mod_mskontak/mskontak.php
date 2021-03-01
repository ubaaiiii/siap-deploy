
<script>
	$(document).ready(function(){
		$("#form_add").css("display","none");
		$("#add").click(function(){
			$('#modal-mskontak').modal('show'); 

		});
	});
	
	
</script>
<?php	

$aksi="modul/mod_mskontak/aksi_mskontak.php";
$judul="Data Broker";
$userid=$_SESSION['idLog'];
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
				<div id="tabel_awal">
                    <table class="table table-bordered" id="tabel-kontak">
                        <thead>
                            <tr>
								<th>ID Admin </th>
								<th>Nama </th>
                                <th>Nomor Telepon </th>
                                <th>Dashboard </th>
                                <th>Kontak </th>
								<th></th>
                            </tr>
                        </thead>
                        <tbody>
							
                        </tbody>
                    </table>
                    <div class="modal fade" tabindex="-1" id="modal-mskontak" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modal-title">Tambah Kontak</h4>
                                </div>
                                <br>
                                <fieldset id="field-kontak">
                                    <form class="form-horizontal form-label-left mt-5" id="form-kontak">
                                        <input type="text" class="form-control" name="userid" value="<?=$userid;?>" style="display:none;">
                                        <input type="text" class="form-control" name="id-contact" id="id-contact" style="display:none;">
                                        <input type="text" class="form-control" name="tipe" id="tipe" value="simpan" style="display:none;">
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 ">Nama</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <input type="text" class="form-control" placeholder="Nama Lengkap" id="nama" name="nama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 ">No. Telepon</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <input type="tel" name="no_telp" class="form-control" placeholder="Nomor Telepon" id="no_telp">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" id="btn-reset" class="btn btn-secondary" style="display:none;">Reset</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-tutup">Tutup</button>
                                            <button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
                                        </div>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <script>
                        var tabelKontak = $('#tabel-kontak').DataTable({
                            "colReorder": true,
                		    "autoWidth": false,
                		    "responsive": true,
                			"bProcessing": true,
                			"bServerSide": true,
                			"sAjaxSource": "modul/mod_mskontak/data_mskontak.php",
                			"aoColumns": [
                			  {"sName": "id_contact","visible":false},
                			  {"sName": "nama"},
                			  {"mRender": function ( data, type, full ) {
                				  return "<a href='https://api.whatsapp.com/send?phone="+data+"'>"+data+"</a>";
                			    }
                			  },
                			  {"mRender": function ( data, type, full ) {
                				  return `<input type="checkbox" data-id="`+full[0]+`" class="ck-dash check-`+data+`">`;
                			    }
                			  },
                			  {"mRender": function ( data, type, full ) {
                				  return `<input type="checkbox" data-id="`+full[0]+`" class="ck-cont check-`+data+`">`;
                			    }
                			  },
                			  {"mRender": function ( data, type, full ) {
                			      var kata = data.split("-");
                			      var did = kata[0];
                			      var dnama = kata[1];
                			      var button = `<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" id="edit" data-id="`+did+`"><i class="fa fa-pencil"></i> Edit</button>`;
                			      button += `<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" id="hapus" data-nama="`+dnama+`" data-id="`+did+`"><i class="fa fa-trash"></i> Hapus</button>`;
                				  return button;
                			    }
                			  }
                			],
                			"columnDefs": [ 
                			    {
                                    "targets": 0,
                                    "orderable": false
                                },
                                {
                                    "targets": 5,
                                    "orderable": false
                                }
                            ],
                            "order": [[ 1, 'asc' ]],
                            "createdRow": function( row, data, dataIndex ) {
                                $('.check-1',row).attr('checked',true);
                            }
                        });
                        
                        $('#tabel-kontak tbody').on( 'change', '.ck-dash', function () {
                            var id = $(this).attr('data-id'),
                                dash = 0;
                            if ($(this).is(':checked')) {
                                dash = 1;
                            }
                            $('.ck-dash').attr('disabled',true);
                            $.ajax({
                                url: "<?=$aksi;?>?module=edit",
                                data: {"tipe":"check","id-contact":id,"val":dash,"field":"dashboard"},
                                type: "POST",
                                success: function(resp){
                                $('.ck-dash').attr('disabled',false);
                                    console.log(resp);
                                }
                            })
                        });
                        
                        $('#tabel-kontak tbody').on( 'change', '.ck-cont', function () {
                            var id = $(this).attr('data-id'),
                                cont = 0;
                            if ($(this).is(':checked')) {
                                cont = 1;
                            }
                            $('.ck-cont').attr('disabled',true);
                            $.ajax({
                                url: "<?=$aksi;?>?module=edit",
                                data: {"tipe":"check","id-contact":id,"val":cont,"field":"kontak"},
                                type: "POST",
                                success: function(resp){
                                $('.ck-cont').attr('disabled',false);
                                    console.log(resp);
                                }
                            })
                        });
                        
                        $('#tabel-kontak tbody').on( 'click', '#edit', function () {
                            var idnya = $(this).attr('data-id');
                            $.ajax({
                                url :'<?=$aksi."?module=cari";?>',
                                type:'POST',
                                data:'id-contact='+idnya,
                                success: function(data){
                                    data = JSON.parse(data);
                                    $('#id-contact').val(idnya);
                                    $('#nama').val(data.nama);
                                    $('#no_telp').val(data.nohp);
                                    $('#modal-title').html('Ubah Data Kontak');
                                    $('#btn-submit').html('Simpan Perubahan');
                                    $('#tipe').val('edit');
                                    $('#modal-mskontak').modal('show');
                                }
                            })
                        });
                        
                        $('#tabel-kontak tbody').on('click', '#hapus', function(){
                            var idnya = $(this).attr('data-id');
                            var namanya = $(this).attr('data-nama');
                            Swal.fire({
                                title: 'Apakah Anda Yakin?',
                                text: "Kontak "+namanya+" akan dihapus..",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#1479b8',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Tidak jadi!'
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        url: '<?=$aksi."?module=hapus";?>',
                                        data: 'id-contact='+idnya,
                                        type: 'POST',
                                        success: function(data){
                                            data = JSON.parse(data);
                                            if (data=="true") {
                                                Swal.fire(
                                                    'Sukses!',
                                                    "Kontak "+namanya+" telah terhapus..",
                                                    'success'
                                                );
                                                tabelKontak.ajax.reload();
                                            } else {
                                                console.log('gagal');
                                            }
                                        }
                                    })
                                }
                            })
                        })
                        
                        $('#modal-mskontak').on('hidden.bs.modal',function(){
                            $('#btn-reset').click();
                            $('#btn-submit').html('Simpan');
                            $('#tipe').val('simpan');
                            $('#modal-title').html('Tambah Kontak');
                        })
                        
                        $(document).ready(function(){
                            $('#form-kontak').submit(function(e){
                                e.preventDefault();
                                var datanya = $(this).serialize();
                                $('#field-kontak').attr('disabled',true);
                                $('#btn-submit').html('<i class="fa fa-spinner fa-pulse"></i>Menyimpan...');
                                console.log(datanya);
                                $.ajax({
                                    url: '<?=$aksi."?module=edit";?>',
                                    data: datanya,
                                    type: 'POST',
                                    success: function(resp){
                                        console.log(resp);
                                        if (resp == "berhasil") {
                                            Swal.fire(
                                                'Sukses!',
                                                "Kontak "+$('#nama').val()+" berhasil diubah..",
                                                'success'
                                            );
                                            tabelKontak.ajax.reload();
                                            $('#field-kontak').attr('disabled',false);
                                            $('#btn-tutup').click();
                                        } else {
                                            Swal.fire(
                                                'Gagal!',
                                                "Kontak "+$('#nama').val()+" gagal diubah..",
                                                'error'
                                            );
                                        }
                                    }
                                })
                            });
                        })
                    </script>
				</div>
            </div>
        </div>
    </div>
</div>
