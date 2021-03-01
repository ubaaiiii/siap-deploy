<?php

    include('data_debitur.php');

?>
<script>

function cariDebitur() {
    var dataTransaksi = $('#select-transaksi').children('option:selected').val();
    var dataKas = $('#select-kas').children('option:selected').val();
    
    if (dataTransaksi == "premi") {
        var ketemu = debitur.filter(function(e) {
            return e.dStatus == "5";
        });
    } else if (dataTransaksi == "klaim") {
        var ketemu = debitur.filter(function(e) {
            return e.dStatus == "93";
        });
    } else if (dataTransaksi == "refund") {
        if (dataKas == "masuk") {
            var ketemu = debitur.filter(function(e) {
                return e.dStatus == "84";
            });
        } else if (dataKas == "keluar") {
            var ketemu = debitur.filter(function(e) {
                return e.dStatus == "83";
            });
        }
    }
    
    function format(item) { return item.text; };
    
    $('#select-nama').empty();
    $("#select-nama").select2({
        minimumInputLength: 3,
        allowClear: true,
        placeholder: "Masukkan Nama / Regid",
        data:ketemu,
        formatSelection: format,
        formatResult: format
    });
    $('#select-nama').val(null).trigger('change');
}

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

$(document).ready(function() {
    
    var d = new Date();

    function twoDigitDate(d) {
        return ((d.getDate()).toString().length == 1) ? "0" + (d.getDate()).toString() : (d.getDate()).toString();
    };

    function twoDigitMonth(d) {
        return ((d.getMonth() + 1).toString().length == 1) ? "0" + (d.getMonth() + 1).toString() : (d.getMonth() + 1).toString();
    };

    var dd_mm_yyyy;
    $("#datepicker").change(function() {
        changedDate = $(this).val(); //in yyyy-mm-dd format obtained from datepicker
        var date = new Date(changedDate);
        dd_mm_yyyy = twoDigitDate(date) + "/" + twoDigitMonth(date) + "/" + date.getFullYear(); // in dd-mm-yyyy format
        $('#textbox').val(dd_mm_yyyy);
        //console.log($(this).val());
        //console.log("Date picker clicked");
    });


    $("#form_add").css("display", "none");
    $("#add").click(function() {
        $("#form_add").fadeToggle(1000);

    });

});
</script>
<?php	
    $veid=$_SESSION['id_peg'];
    $vempname=$_SESSION['empname'];
    $vlevel=$_SESSION['idLevel'];
    $userid=$_SESSION['idLog'];
    $aksi="modul/mod_bayar/aksi_bayar.php";
    $judul="Pembayaran";
    
    if (!isset($_GET['act'])) {
    	    $jenisTrans = $_GET['jenis-trans'];
    	    $jenisKas   = $_GET['jenis-kas'];
    	    $dregid     = $_GET['id'];
?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?= $judul; ?></h3>

            </div>
        </div>
        <div class="clearfix"></div>


        <div class="row">
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <button type="button" class="btn btn-default btn-sm" id="add"><i class="fa fa-plus-circle"></i> Add Data</button>
                </div>
                <div class="row" id="form_add">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Input Data</h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <br />
                                <form action="<?= $aksi."?module=add" ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" name="userid" value="<?= $userid; ?>">
                                    <input type="hidden" name="url" value="bayar">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="select-transaksi"> Jenis Transaksi
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control select2_single" required tabindex="-2" onchange="cariDebitur()" name="jenis-transaksi" id="select-transaksi" style="width: 100%">
                                                <option value="premi">Pembayaran Premium</option>
                                                <option value="refund">Pembayaran Refund</option>
                                                <option value="klaim">Pembayaran Klaim</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="group-kas" style="display:none;">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="select-kas"> Jenis Kas
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control select2_single" tabindex="-2" name="jenis-kas" onchange="cariDebitur()" id="select-kas" style="width: 100%">
                                                <option value="masuk">Masuk</option>
                                                <option value="keluar">Keluar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="select-nama"> Nama
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" tabindex="-2" name="regid" id="select-nama" style="width: 100%">
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tglbayar"> Tanggal Bayar
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">


                                            <input type="date" id="tglbayar" name="tglbayar" required="required" class="form-control col-md-7 col-xs-12">

                                        </div>
                                    </div>
                                    
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        function format(item) { return item.text; };
                                        
                                        $("#select-nama").select2({
                                            minimumInputLength: 3,
                                            allowClear: true,
                                            placeholder: "Masukkan Nama / Regid",
                                            data: debitur,
                                            formatSelection: format,
                                            formatResult: format
                                        });
                                        
                                        $('#select-transaksi').on("select2:select", function() {
                                            if ($(this).val() == 'refund') {
                                                $('#group-kas').removeAttr('style');
                                            } else {
                                                $('#group-kas').css('display', 'none');
                                            }
                                        });
                                        
                                        $('#select-transaksi').val('<?=$jenisTrans;?>').trigger('select2:select');
                                        $('#select-jenis').val('<?=$jenisKas;?>').trigger('select2:select');
                                        $('#select-nama').val('<?=$dregid;?>').trigger('change');
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="dataTables">
                    <table id="table-bayar" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Paid ID</th>
                                <th>No Register</th>
                                <th>Nama</th>
                                <th>UP</th>
                                <th>Premi</th>
                                <th>Tgl Bayar</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                    
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Ubah Tanggal Paid</h4>
                                    </button>
                                </div>
                                <br>
                                <form class="form-horizontal form-label-left mt-5" method="post" action="<?= $aksi."?module=update"; ?>">
                                    <input type="text" class="form-control" name="userid" value="<?=$userid;?>" style="display:none;">
                                    <input type="text" class="form-control" name="paid-id" id="no-paid"  style="display:none;">
                                    <input type="text" class="form-control" name="reg-id" id="no-reg"  style="display:none;">
                                    <input type="text" class="form-control" name="data-status" id="data-status"  style="display:none;">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Paid ID</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" placeholder="Paid ID" id="no-paid2" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">No. Register</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" placeholder="Nomor Register" id="no-register" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Nama</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" placeholder="Nama Lengkap" id="nama" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Sebelumnya</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="date" class="form-control" id="paid-before" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Paid</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="date" class="form-control" id="paid-dt" name="paid-dt" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" id="btn-reset" class="btn btn-secondary" style="display:none;">Reset</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#btn-reset').click();">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                    
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#table-bayar').dataTable({
                                "colReorder": true,
                                "autoWidth": false,
                                "responsive": true,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": "modul/mod_bayar/data_bayar.php",
                                "aoColumns": [{
                                        "sName": "paidid"
                                    },
                                    {
                                        "sName": "regid"
                                    },
                                    {
                                        "sName": "nama"
                                    },
                                    {
                                        "mRender": function(data, type, full) {
                                            return $.fn.dataTable.render.number(',', '.', 0).display(data);
                                        }
                                    },
                                    {
                                        "mRender": function(data, type, full) {
                                            return $.fn.dataTable.render.number(',', '.', 0).display(data);
                                        }
                                    },
                                    {
                                        "sName": "paiddt"
                                    },
                                    {
                                        "sName": "comment"
                                    },
                                    {
                                        "mRender": function(data, type, full) {
                                            var kata = data.split("-");
                                            var regisID = kata[0];
                                            var paidID = kata[1];
                                            var dataStatus = kata[2];
                        
                                            var tombol = `<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" data-status="`+dataStatus+`" data-id="` + paidID + `" id="edit"><i class="fa fa-search"></i> Edit</button>`;
                                            tombol += `<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=polhist&&act=update&&id=` + regisID + `'"><i class="fa fa-search"></i> Log</button>`;
                                            tombol += `<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="window.location='<?= $aksi ;?>?module=delete&&id=` + paidID + `&&regid=` + regisID + `&&uid=<?= $userid ;?>'"><i class="fa fa-trash"></i> Delete</button>`;
                        
                                            return tombol;
                                        }
                                    },
                                ],
                                "columnDefs": [{
                                    "targets": 7,
                                    "orderable": false
                                }],
                                order: [[5, 'desc']],
                            });
                        
                            $('#table-bayar tbody').on( 'click', '#edit', function () {
                                var statusnya = $(this).attr('data-status');
                                $.ajax({
                                    url :'modul/mod_bayar/aksi_bayar.php?module=cari',
                                    type:'POST',
                                    data:'id='+$(this).attr('data-id')+'&&user=<?=$userid;?>',
                                    success: function(data){
                                        data = JSON.parse(data);
                                        $('#data-status').val(statusnya);
                                        $('#no-paid').val(data.paidid);
                                        $('#no-paid2').val(data.paidid);
                                        $('#no-reg').val(data.regid);
                                        $('#no-register').val(data.regid);
                                        $('#nama').val(data.nama);
                                        $('#paid-before').val(data.paiddt);
                                        $('.bs-example-modal-lg').modal('show');
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
} else {
    switch ($_GET['act']) {
        case "refund":
            $kas   = $_GET['kas'];
            $jenis = "refund";
            break;
        
        case "claim":
            $kas   = "";
            $jenis = "claim";
            break;
            
        case "premi":
            $kas   = "";
            $jenis = "premi";
            break;
    }
    
	$sid = $_GET['regid'];
    $url = $_GET['before'];
    
    $query = mysql_query("SELECT regid, 
                                 nama, 
                                 tgllahir,
                                 usia,
                                 noktp, 
                                 jkel, 
                                 pekerjaan, 
                                 cabang, 
                                 mitra, 
                                 masa,  
                                 mulai, 
                                 akhir, 
                                 up, 
                                 premi, 
                                 epremi, 
                                 tunggakan
                          FROM   tr_sppa 
                          WHERE  regid = '$sid' ");
    
    $r = mysql_fetch_array($query);
?>
<div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Pembayaran</h3>
                </div>

             
            </div>
            <div class="clearfix"></div>


           <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?=ucwords($jenis);?> <small><?= $r['reqid']; ?></small></h2>
                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?= $aksi; ?>?module=add">
							<input type="hidden" name="regid" value="<?= $r['regid']; ?>">
							<input type="hidden" name="userid" value="<?= $userid; ?>">
							<input type="hidden" name="jenis-transaksi" value="<?= $jenis ;?>">
							<input type="hidden" name="jenis-kas" value="<?= $kas; ?>">
							<input type="hidden" name="url" value="<?= $url; ?>">
							
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="regid" name="regid" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['regid']; ?>">
										
                                    </div>	
                                </div>
                            
								
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="nama" name="nama" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['nama']; ?>">
										
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="date" id="tgllahir" name="tgllahir"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['tgllahir']; ?>">
										
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="int" id="usia" name="usia" readonly  required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['usia']; ?>">
										
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="noktp" name="noktp"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['noktp']; ?>">
										
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="masa" name="masa" min="0" max="500" disabled required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['masa']; ?>"  >
										
                                    </div>
                                </div>
								
								
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="date" id="mulai" name="mulai" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['mulai']; ?>" >
										
                                    </div>
                                </div>
								
								
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="date" id="akhir" name="akhir"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['akhir']; ?>">
										
                                    </div>
                                </div>

								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP  
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="up" name="up"   readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= number_format($r['up'],0); ?>">
										
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Premi  
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="premi" name="premi"  readonly class="form-control col-md-7 col-xs-12" value="<?= number_format($r['premi'],0); ?>">
										
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Extra Premi 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="epremi" name="epremi"  readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= number_format($r['epremi'],0); ?>">
										
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Grace Period (khusus MPP) 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="tunggakan" name="tunggakan" readonly min="0" max="500" required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['tunggakan']; ?>"  >
										
                                    </div>
                                </div>	


								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Bayar 
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">


									<input type="date" id="tglbayar" name="tglbayar" required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['paiddt']; ?>" >
										
                                    </div>	
                                </div>
								
								
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan  
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
										<textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?= htmlspecialchars(stripslashes($ssubject)); ?></textarea>                                            
									</div>
                                </div>

								
					
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   	<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> &nbsp;Back</button>
									<button type="submit" class="btn btn-sm btn-info"><i class="fa fa-save"></i> Submit</button>
								
                                    </div>
                                </div>
								
									
								
                                </div>

                            </form>
                            <script>
                                $(document).ready(function(){
                                    $('#jkel').val('<?=$r['jkel'];?>').trigger('change');
                                    $('#pekerjaan').val('<?=$r['pekerjaan'];?>').trigger('change');
                                    $('#cabang').val('<?=$r['cabang'];?>').trigger('change');
                                    $('#mitra').val('<?=$r['mitra'];?>').trigger('change');
                                })
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
}
?>