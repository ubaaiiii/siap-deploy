<?php
    include("data_user.php");
?>
<script>
    function cariUser() {
        var tipe = $('#tipe-user').children('option:selected').val();
        var cabang = $('#select-cabang').children('option:selected').val();
        if (tipe == "ALL" && cabang == "ALL") {
            var ketemu = user;
        } else if (tipe == "ALL" && cabang != "ALL") {
            var ketemu = user.filter(function(e) {
                return e.cabang == cabang;
            });
        } else if (tipe != "ALL" && cabang == "ALL") {
            var ketemu = user.filter(function(e) {
                return e.level == tipe;
            });
        } else {
            var ketemu = user.filter(function(e) {
                return e.level == tipe;
            }).filter(function(e) {
                return e.cabang == cabang;
            });
        }

        $('#select-user').empty();
        $('#select-user').append('<option value="ALL">ALL (' + Object.keys(ketemu).length + ')</option>');
        $.each(ketemu, function(i, value) {
            $opt = '<option value="' + ketemu[i].username + '">' + ketemu[i].nama + "</option>";
            $("#select-user").append($opt);
        });
        if (Object.keys(ketemu).length > 0) {
            $("#select-user").removeAttr('disabled');
            $('#btn-simpan').removeAttr('disabled');
        } else {
            $("#select-user").prop('disabled', true);
            $("#btn-simpan").prop('disabled', true);
        }
        $('#select-user').select2('val', 'ALL');
    }
</script>

<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-envelope"></i> Buat Notifikasi</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="form-notif" method="POST" action="modul/mod_push_notif/aksi_push.php?module=simpan">
                            <input type="text" id="id" name="id" hidden>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tipe-user">Tipe User</label>
                                    <select required class="select2 form-control" style="width:100%" name="level" id="tipe-user">
                                        <option disabled hidden></option>
                                        <option value="ALL">ALL</option>
                                        <?php
                                            $qtahun=mysql_query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms where ms.mstype='level'  order by ms.msdesc  asc ");
                                            while($rpro=mysql_fetch_array($qtahun)){
                                        ?>
                                        <option value="<?php echo $rpro['comtabid']; ?>"><?php echo $rpro['comtab_nm']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="selec">Cabang</label>
                                    <select required class="select2 form-control" style="width:100%" name="cabang" id="select-cabang">
                                        <option disabled hidden></option>
                                        <?php
                                            $qtahun=mysql_query("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='cab'  order by ms.msdesc  asc ");
                                            while($rpro=mysql_fetch_array($qtahun)){
                                        ?>
                                        <option value="<?php echo $rpro['comtabid']; ?>"><?php echo $rpro['comtab_nm']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="select-user">Nama</label>
                                    <select required disabled class="select2 form-control" style="width:100%" tabindex="-2" name="user" id="select-user">
                                        <option disabled hidden></option>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tipe-pesan">Tipe Pesan</label>
                                    <select required class="select2 form-control" style="width:100%" tabindex="-2" name="tipe" id="tipe-pesan">
                                        <option selected disabled hidden></option>
                                        <option value="info" data-judul="Informasi..">Information</option>
                                        <option value="success" data-judul="Berhasil!">Success</option>
                                        <option value="error" data-judul="Gagal!">Error</option>
                                        <option value="warning" data-judul="Perhatian!">Warning</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="judul-pesan">Judul Pesan</label>
                                    <input name="judul" type="text" required class="form-control" style="text-transform:capitalize;" id="judul-pesan">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="range-durasi">Durasi Pesan <small>(Pesan akan muncul di menu [<b class="fa fa-home"></b> Home] selama durasi yang ditentukan)</small></label>
                                    <input required id="range-durasi" type="text" placeholder="Pilih Tanggal Durasi.." class="date-range-input form-control">
                                    <input id="tgl-mulai" name="tgl-mulai" type="date" hidden>
                                    <input id="tgl-selesai" name="tgl-selesai" type="date" hidden>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="pesan">Pesan</label>
                                <textarea name="pesan" required class="form-control" id="pesan"></textarea>
                            </div>
                            <div class="form-group col-md-12 mt-5">
                                <button id="btn-batal" class="btn btn-danger" type="reset">Batal</button>
                                <button id="coba" type="button" class="btn btn-dark">Coba</button>
                                <button id="btn-simpan" disabled type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-envelope"></i> Data Notifikasi</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="table-notifikasi" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <th>ID Push</th>
                                <th>Level</th>
                                <th>Cabang</th>
                                <th>Username</th>
                                <th>Pesan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th></th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function formatTanggal(tanggal) {
        var t = new Date(tanggal);
        return (t.getMonth()+1)+"/"+t.getDate()+"/"+t.getFullYear();
    }
    function editNotif(id) {
        $.ajax({
            url: 'modul/mod_push_notif/aksi_push.php?module=edit&&id=' + id,
            success: function(data) {
                data = JSON.parse(data);
                $('#tipe-user').val(data.level).trigger('change');
                $('#select-cabang').val(data.cabang).trigger('change');
                $('#select-user').val(data.username).trigger('change');
                var pesan = data.pesan.split('-');
                $('#tipe-pesan').val(pesan[0]).trigger('change');
                $('#judul-pesan').val(pesan[1]);
                $('#pesan').val(pesan[2]);
                $('#id').val(data.id);
                $('#range-durasi').data('daterangepicker').setStartDate(formatTanggal(data.tgl_mulai));
                $('#range-durasi').data('daterangepicker').setEndDate(formatTanggal(data.tgl_selesai));
            }
        })
    };
    function deleteNotif(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'modul/mod_push_notif/aksi_push.php?module=hapus&&id=' + id,
                    success: function(data) {
                        console.log(data);
                        if (data=="true") {
                            $('#table-notifikasi').dataTable().api().ajax.reload();
                            Swal.fire(
                                'Terhapus!',
                                'Notif telah dihapus.',
                                'success'
                            )
                        }
                    }
                })
            }
        })
    }
    $(document).ready(function() {

        $(".select2").select2({
            placeholder: "Pilih Salah Satu..",
            allowClear: true
        });

        cariUser();

        $('.date-range-input').keydown(function() {
            return false;
        });

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#tgl-mulai').val(start.format('YYYY-MM-DD'));
            $('#tgl-selesai').val(end.format('YYYY-MM-DD'));
        }

        $('.date-range-input').daterangepicker({
            startDate: start,
            endDate: end,
            minDate: moment(),
            locale: {
                format: 'MMMM D, YYYY',
                cancelLabel: 'Batal',
                applyLabel: 'Terapkan'
            },
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Besok': [moment().add('d', 1).toDate(), moment().add('d', 1).toDate()],
                'Seminggu': [moment(), moment().add('d', 7).toDate()],
                'Sebulan': [moment(), moment().add('M', 1).toDate()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')]
            }
        }, cb);

        cb(start, end);

        $('.date-range-input').on('cancel.daterangepicker', function(ev, picker) {
            $('#tgl-mulai').val('');
            $('#tgl-selesai').val('');
            $(this).val('');
        });

        // console.log(user);
        $('#tipe-user').change(function() {
            // console.log($(this).children('option:selected').val());
            cariUser();
        })
        $('#select-cabang').change(function() {
            // console.log($(this).children('option:selected').val());
            cariUser();
        })

        $(document).on('change', ':text,textarea', function() {
            this.value = this.value.replace('-', ' ');
            this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        });

        $('#tipe-pesan').change(function() {
            var judul = $(this).children('option:selected').attr('data-judul');
            $('#judul-pesan').attr('placeholder','misalnya: ( '+judul+' )');
            $('#judul-pesan').select();
        })

        $('#form-push').submit(function(e) {
            e.preventDefault();
            var datanya = $(this).serialize();
            if ($('#tipe-pesan').val() == "") {
                $('#tipe-pesan').focus();
            } else {
                Swal.fire({
                    title: 'Apakah Data Sudah Benar?',
                    text: "Validasi Sebelum Menyimpan Ke Database.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Iya'
                }).then((result) => {
                    if (result.value) {
                        console.log(datanya);
                    }
                })
            }
        })
        
        $('#btn-batal').click(function(){
            $('.select2').val('0').trigger('change');
        })

        $('#coba').click(function() {
            var tipe = $('#tipe-pesan').children('option:selected').val();
            var judul = $('#judul-pesan').val();
            var pesan = $('#pesan').val();
            if (tipe == "") {
                swal.fire(
                    'Kesalahan!',
                    'Harap Mengisi Tipe Pesan',
                    'warning'
                )
            } else if (judul == "") {
                swal.fire(
                    'Kesalahan!',
                    'Harap Mengisi Judul Pesan',
                    'warning'
                )
            } else if (pesan == "") {
                swal.fire(
                    'Kesalahan!',
                    'Harap Mengisi Pesan',
                    'warning'
                )
            } else {
                new PNotify({
                    title: judul,
                    text: pesan,
                    type: tipe,
                    hide: false,
                    styling: 'bootstrap3'
                });
            }
        })

        var table_notifikasi = $('#table-notifikasi').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "modul/mod_push_notif/table_push.php",
            "aoColumns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                {
                    "mRender": function(data, type, full) {
                        return `<button type="button" onclick="editNotif(` + data + `)" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-edit"></i> Ubah</button><button type="button" onclick="deleteNotif(` + data + `)" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i> Hapus</button>`;
                    }
                }
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": 7
            }]
        });

    })
</script>
