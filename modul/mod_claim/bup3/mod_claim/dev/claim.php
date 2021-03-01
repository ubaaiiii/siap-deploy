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
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Back</button>
                    <?php if ($vlevel !== 'insurance') { ?>
                    <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Add" onclick="window.location='media.php?module=claimpro'"><i class="fa fa-plus-circle"></i> Add</button>
                    <?php } ?>
                </div>

                <div style="width:100%;overflow-x:auto;">
                    <table class="table table-bordered" id="table-claim" style="width:100%;">
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    <script>
                        $(document).ready(function(){
                            var tableClaim = $('#table-claim').DataTable({
                                "colReorder": true,
                                "scrollX": true,
                    		    "autoWidth": true,
                    			"bProcessing": true,
                    			"bServerSide": true,
                    			"sAjaxSource": "modul/mod_claim/data_claim.php",
                    			"sServerMethod": 'POST',
                    			"aoColumns": [
                    			  {"sName": "regclaim"},
                    			  {"sName": "regid"},
                    			  {"sName": "produk"},
                    			  {"sName": "nama"},
                    			  {"sName": "cabang"},
                    			  {"sName": "tgllapor"},
                    			  {"sName": "tglkejadian"},
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
                    				    var regclaim= data[0];
                    				    var regid   = data[1];
                    				    var status  = data[2];
                    				    var nama    = data[3];
                    				    
                    				    if (('<?=$vlevel;?>' == 'broker' && (status == '90' || status == '91')) || ('<?=$vlevel;?>' == 'checker' && status == '90')) {
                    				        var button = `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="media.php?module=claim&&act=update&&id=`+regid+`"><i class="fa fa-edit"></i> Edit</a>`;
                    				    } else {
                    				        var button = `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Lihat Data" href="media.php?module=claim&&act=view&&id=`+regid+`"><i class="fa fa-search"></i> View</a>`;
                    				    }
                    				    
                    				    if ('<?=$vlevel;?>' != 'checker') {
                    				        button += `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Download Checklist Document" target="_blank" href="laporan/claim/f_claim.php?id=`+regid+`"><i class="fa fa-download"></i> List Document</a>`;
                    				        button += `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View Documents" href="media.php?module=docclaim&&id=`+regid+`"><i class="fa fa-files-o"></i> Documents</a>`;
                    				    } else {
                    				        button += `<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View Documents" href="media.php?module=docclaim&&id=`+regid+`"><i class="fa fa-upload"></i> Documents</a>`;
                    				    }
                    				    
                    				    
                    				    if ('<?=$vlevel;?>' == 'broker' && status == '91') {
                    				        button += `<a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" href="modul/mod_claim/aksi_claim.php?module=approve&&regid=`+regid+`&&id=`+regclaim+`"><i class="fa fa-check"></i> Approve</a>`;
                    				        button += `<button type="button" class="btn-rollback btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Rollback" data-id="`+regid+`" data-nama="`+nama+`"><i class="fa fa-undo"></i> Rollback</button>`;  
                    				    }
                    				    
                    				    if ('<?=$vlevel;?>' == 'schecker' && status == '90') {
                    				        button += `<a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" href="modul/mod_claim/aksi_claim.php?module=approve&&regid=`+regid+`&&id=`+regclaim+`"><i class="fa fa-check"></i> Approve</a>`;
                    				    }
                    				    
                    				    if ('<?=$vlevel;?>' == 'insurance') {
                    				        if (status == '92') {
                    				            button += `<a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Approve" href="modul/mod_claim/aksi_claim.php?module=approve&&regid=`+regid+`&&id=`+regclaim+`"><i class="fa fa-check"></i> Approve</a>`;
                        				        button += `<a class="btn-reject btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Reject" data-id="`+regid+`" data-nama="`+nama+`"><i class="fa fa-times"></i> Reject</a>`;
												button += `<a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="email" href="modul/mod_claim/aksi_claim.php?module=email&&id=`+regclaim+`"><i class="fa fa-check"></i> Email</a>`;
											} else if (status == '93') {
                    				            button += `<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Pembayaran Claim" href="media.php?module=bayar&&act=claim&&regid=`+regid+`&&before=claim"><i class="fa fa-calendar"></i> Pay Claim</button>`;
												button += `<a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="email" href="modul/mod_claim/aksi_claim.php?module=email&&id=`+regclaim+`"><i class="fa fa-check"></i> Email</a>`;
                    				        }
                    				    }
                    				    
                    				    return button;
                    				}
                    			  }
                    			],
                    			"columnDefs": [ 
                    			    {
                                        "targets": 10,
                                        "orderable": false
                                    },
                                    {
                                        targets: [7,8],
                                        className: 'text-right'
                                    }
                                ],
                                order: [[5, 'desc']],
                            });
                            
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
                                        var alasan = result.value
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
                                                }
                                            }
                                        })
                                    }
                                })
                            });
                            
                            $('#table-claim tbody').on('click', '.btn-reject', function() {
                                var id = $(this).attr('data-id');
                                var nama = $(this).attr('data-nama');
                                swal.fire({
                                    title: 'Mohon Mengisi Alasan Reject Untuk Debitur:<br>' + nama,
                                    input: 'textarea',
                                    icon: 'info',
                                    showCancelButton: true,
                                }).then(function(result) {
                                    if (result.value) {
                                        var alasan = result.value
                                        $.ajax({
                                            url: "<?=$aksi;?>?module=reject&&regid="+id+"&&comment="+alasan,
                                            success: function(data){
                                                if (data == 'berhasil') {
                                                    Swal.fire(
                                                        'Reject Berhasil!',
                                                        'Debitur a/n: ' + nama + ' telah ditolak claimnya',
                                                        'success'
                                                    );
                                                    tableClaim.ajax.reload();
                                                } else {
                                                    console.log(data);
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
</div>
<?php
} else {

$sid=$_GET['id'];

switch ($_GET['act']) {
case "add":
    $query = mysql_query("SELECT *
                          FROM   tr_sppa
                          WHERE  regid = '$sid' ");
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
                                 ab.nilaios 
                          FROM   tr_sppa aa 
                                 INNER JOIN tr_claim ab 
                                         ON aa.regid = ab.regid 
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
                                 ab.nilaios 
                          FROM   tr_sppa aa 
                                 INNER JOIN tr_claim ab 
                                         ON aa.regid = ab.regid 
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
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Claim
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="regclaim" name="regclaim" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= $regclaim; ?>">

                                </div>
                            </div>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia /Tgl Lahir
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="susia" name="susia" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?=$r['usia'] . ' Tahun / ' . tglindo_balik($r['tgllahir']);?>">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="masaas" name="masaas" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?= $r['masa'] . ' Bulan / ' . tglindo_balik($r['mulai'])  .' s/d '. tglindo_balik($r['akhir']); ?>">

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
                                    <input type="text" id="nilaios" name="nilaios" placeholder="dalam rupiah" required="required" class="form-control col-md-7 col-xs-12" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?=number_format($r['nilaios'],0,',','.');?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl lapor
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <input type="date" value="<?= $r['tgllapor']; ?>" id="tgllapor" name="tgllapor" value="dd-mm-yyyy" required="required" class="form-control col-md-7 col-xs-12">

                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Kejadian
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <input type="date" value="<?= $r['tglkejadian']; ?>" id="tglkejadian" name="tglkejadian" value="dd-mm-yyyy" required="required" class="form-control col-md-7 col-xs-12">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tempat Kejadian
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_single form-control" tabindex="-2" name="tmpkejadian" id="tmpkejadian">
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
                                    <select class="select2_single form-control" tabindex="-2" name="sebab" id="sebab">
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



                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Back</button>
                                    
                                    <?php if($judul !== 'View') { ?>
                                    <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-paper-plane"></i> &nbsp;Submit</button>
                                    <?php } ?>
                                    
                                    <?php if($vlevel !== 'checker' && $judul !== 'Add') { ?>
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Approve</button>
                                    <?php } ?>
                                </div>
                            </div>



                    </div>

                    </form>
                    <script>
                        $(document).ready(function(){
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
<?php
}
?>

