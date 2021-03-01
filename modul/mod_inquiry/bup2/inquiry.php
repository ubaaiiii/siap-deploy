<style>
   tfoot input {
      width: 100%;
      padding: 3px;
      box-sizing: border-box;
   }
</style>
<script>
   $(document).ready(function() {
      $("#form_add").css("display", "none");
      $("#add").click(function() {
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
               url: "modul/mod_inquiry/cari.php",
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
$veid = $_SESSION['id_peg'];
$vempname = $_SESSION['empname'];
$vlevel = $_SESSION['idLevel'];
$userid = $_SESSION['idLog'];
$aksi = "modul/mod_inquiriv/aksi_inquiriv.php";
$judul = "Inquiry";

switch ($_GET['act']) {
   default:
      $p      = new Paging;
      $batas  = 10;
      $posisi = $p->cariPosisi($batas);
      $sregid = encrypt_decrypt("decrypt",$_GET['id']);

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
               <style>
                  .large-table-container-3 {
                     max-width: 100%;
                     overflow-x: scroll;
                     overflow-y: auto;
                  }

                  .large-table-container-3 table {}

                  .large-table-fake-top-scroll-container-3 {
                     max-width: 100%;
                     overflow-x: scroll;
                     overflow-y: auto;
                  }

                  .large-table-fake-top-scroll-container-3 div {
                     background: #F7F7F7;
                     font-size: 1px;
                     line-height: 1px;
                  }
               </style>
               <div class="x_content">
                  <div class="large-table-fake-top-scroll-container-3">
                     <div>&nbsp;</div>
                  </div>
                  <div class="large-table-container-3">
                     <br>
                     <table id="table-inquiry" class="table table-bordered" cellspacing="0" width="100%" style="white-space: nowrap;">
                        <thead>
                           <tr class="headings">
                              <th class="column-title">Asuransi </th>
                              <th class="column-title">Cabang </th>
                              <th class="column-title">Produk </th>
                              <th class="column-title">AO </th>
                              <th class="column-title">No. Register </th>
                              <th class="column-title">No. Sertifikat </th>
                              <th class="column-title">Nama </th>
                              <th class="column-title">Tgl Lahir </th>
                              <th class="column-title">Mulai </th>
                              <th class="column-title">UP </th>
                              <th class="column-title">Premi </th>
                              <th class="column-title">Status </th>
                              <th class="column-title no-link last"><span class="nobr">Action</span></th>
                              <th>reg_encode</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th class="column-title">Asuransi </th>
                              <th class="column-title">Cabang </th>
                              <th class="column-title">Produk </th>
                              <th class="column-title">AO </th>
                              <th class="column-title">No. Register </th>
                              <th class="column-title">No. Sertifikat </th>
                              <th class="column-title">Nama </th>
                              <th class="column-title">Tgl Lahir </th>
                              <th class="column-title">Mulai </th>
                              <th class="column-title">UP </th>
                              <th class="column-title">Premi </th>
                              <th class="column-title">Status </th>
                              <th class="column-title no-link last"><span class="nobr">Action</span></th>
                              <th>reg_encode</th>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
                  <script>
                     $(document).ready(function() {
                        $('#table-inquiry tfoot th').each(function() {
                           var title = $(this).text();
                           if ($(this).is(':contains("Action")')) {
                              $(this).html('');
                           } else {
                              $(this).html('<input type="text" placeholder="' + title + '" />');
                           }
                        });
                        var tableInq = $('#table-inquiry').DataTable({
                           "colReorder": true,
                           "bProcessing": true,
                           "bServerSide": true,
                           "sAjaxSource": "modul/mod_inquiry/data_inquiry.php",
                        //   "fnServerParams": function ( consoleData ) {
                        //         console.log(consoleData);
                        //     },
                           "sServerMethod": 'POST',
                           "aoColumns": [{
                                 sName: "asuransi"
                              }, // full[0]
                              {
                                 sName: "cabang"
                              }, // full[1]
                              {
                                 sName: "produk"
                              }, // full[2]
                              {
                                 sName: "createby"
                              }, // full[3]
                              {
                                 sName: "regid"
                              }, // full[4]
                              {
                                 sName: "policyno"
                              }, // full[5]
                              {
                                 sName: "nama"
                              }, // full[6]
                              {
                                 sName: "tgllahir"
                              }, // full[7]
                              {
                                 sName: "mulai"
                              }, // full[8]
                              {
                                 "mRender": function(data, type, full, meta) { // full[9]
                                    return $.fn.dataTable.render.number(',', '.', 0).display(data);
                                 }
                              },
                              {
                                 "mRender": function(data, type, full, meta) { // full[10]
                                    return $.fn.dataTable.render.number(',', '.', 0).display(data);
                                 }
                              },
                              null,
                              {
                                 "mRender": function(data, type, full, meta) { // full[11]
                                    data = data.split('-');
                                    var regid = data[0];
                                    var status = data[1];
                                    var sertif = data[2];

                                    var button = `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="View" href="media.php?module=inquiry&&act=view&&id=` + full[13] + `"><i class="fa fa-search"></i> View</a>`;
                                    button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="View Documents" href="media.php?module=doc&&id=` + full[13] + `&&jenis=DTPGJ"><i class="fa fa-files-o"></i> Doc</a>`;

                                    if ('<?= $vlevel; ?>' == 'mkt' || '<?= $vlevel; ?>' == 'smkt') {
                                       if (status == 0) {
                                          var button = `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" href="media.php?module=ajuan&&act=update&&id=` + full[13] + `" title="Edit"><i class="fa fa-edit"></i> Edit</a>`;
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" href="media.php?module=doc&&id=` + full[13] + `&&jenis=DTPGJ" title="Upload Dokumen"><i class="fa fa-upload"></i> Doc</a>`;
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" href="media.php?module=photo&&act=update&&id=` + full[13] + `'" title="Upload Foto"><i class="fa fa-upload"></i> Photo</a>`;
                                          button += `<a class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" href="modul/mod_ajuan/aksi_ajuan.php?module=approve&&id=` + full[13] + `&&uid=<?= $userid; ?>'" title="Approve"><i class="fa fa-check-square"></i> Approve</a>`;
                                       } else if (status == 11) {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Cetak SPPA" onclick="window.location = 'laporan/sppa/f_sppa.php?id=` + full[13] + `'"><i class="fa fa-download"></i> SPPA</a>`;
                                       } else if (['5'].includes(status)) {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Form Pembatalan" href="laporan/batal/f_batal.php?id=` + full[13] + `&&jenis=batal"><i class="fa fa-download"></i> Batal</button>`;
                                       } else if (['20'].includes(status)) {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Form Pembatalan" href="laporan/batal/f_batal.php?id=` + full[13] + `&&jenis=refund"><i class="fa fa-download"></i> Batal</button>`;
                                       }

                                       if (sertif !== 'null') {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" onclick="window.location = 'laporan/cert/f_cert.php?id=` + full[13] + `'" title="Cetak Sertifikat"><i class="fa fa-download"></i> Cert</a>`;
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" onclick="window.location = 'laporan/bill/f_bill.php?id=` + sertif + `'" title="Cetak Invoice"><i class="fa fa-download"></i> Invoice</a>`;

                                       }

                                       if ('<?= $vlevel; ?>' == 'mkt') {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" href="media.php?module=ajuan&&act=salin&&id=` + full[13] + `" title="Hubungkan Induk/Talangan/Pasangan"><i class="fa fa-link"></i> Link</a>`;
                                       }

                                    } else if ('<?= $vlevel; ?>' == 'checker') {
                                       if (status == 11) {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Cetak SPPA" onclick="window.location = 'laporan/sppa/f_sppa.php?id=` + full[13] + `'"><i class="fa fa-download"></i> SPPA</a>`;
                                       }

                                       if (sertif !== 'null') {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" onclick="window.location = 'laporan/cert/f_cert.php?id=` + full[13] + `'" title="Cetak Sertifikat"><i class="fa fa-download"></i> Cert</a>`;
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" onclick="window.location = 'laporan/bill/f_bill.php?id=` + sertif + `'" title="Cetak Invoice"><i class="fa fa-download"></i> Invoice</a>`;
                                       }

                                    } else if ('<?= $vlevel; ?>' == 'schecker') {
                                       if (status == 11) {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Cetak SPPA" onclick="window.location = 'laporan/sppa/f_sppa.php?id=` + full[13] + `"><i class="fa fa-download"></i> SPPA</a>`;
                                       }

                                       if (sertif !== 'null') {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" onclick="window.location = 'laporan/cert/f_cert.php?id=` + full[13] + `'" title="Cetak Sertifikat"><i class="fa fa-download"></i> Cert</a>`;
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" onclick="window.location = 'laporan/bill/f_bill.php?id=` + sertif + `'" title="Cetak Invoice"><i class="fa fa-download"></i> Invoice</a>`;
                                       }

                                    } else if ('<?= $vlevel; ?>' == 'broker') {
                                       if (status !== '12' && status !== '0') {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Revisi" href="media.php?module=revisi&&act=add&&id=` + full[13] + `"><i class="fa fa-edit"></i> Revisi</a>`;
                                          if (status == '5') {
                                             button += `<a class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Input Tanggal Paid" href="media.php?module=bayar&&act=premi&&before=inquiry&&regid=` + full[13] + `"><i class="fa fa-money"></i> Paid</a>`;
                                             button += `<a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Pembatalan" href="media.php?module=cancel&&act=addcan&&id=` + full[13] + `"><i class="fa fa-undo"></i> Cancel</a>`;
                                          }

                                          if (status == '20') {
                                             button += `<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Refund" href="media.php?module=cancel&&act=refund&&id=` + full[13] + `"><i class="fa fa-undo"></i> Refund</a>`;
                                             button += `<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Claim" href="media.php?module=claim&&act=add&&id=` + full[13] + `"><i class="fa fa-check"></i> Claim</a>`;
                                          }
                                       }

                                       if (sertif !== 'null') {
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" onclick="window.location = 'laporan/cert/f_cert.php?id=` + full[13] + `'" title="Cetak Sertifikat"><i class="fa fa-download"></i> Cert</a>`;
                                          button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" onclick="window.location = 'laporan/bill/f_bill.php?id=` + sertif + `'" title="Cetak Invoice"><i class="fa fa-download"></i> Invoice</a>`;
                                       }
                                    } else if ('<?= $vlevel; ?>' == 'insurance') {

                                    } else if ('<?= $vlevel; ?>' == 'smon') {

                                    }

                                    button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Log" href="media.php?module=polhist&&act=log&&id=` + full[13] + `"><i class="fa fa-search"></i> Log</a>`;
                                    return button;
                                 }
                              },
                              {
                                 sName: "reg_encode",
                                 visible: false
                              }, // full[12]
                           ],
                           "columnDefs": [{
                              "targets": 12,
                              "orderable": false
                           }],
                           initComplete: function() {
                              // Apply the search
                              this.api().columns().every(function() {
                                 var that = this;

                                 $('input', this.footer()).on('keyup change clear', function(e) {
                                    if (that.search() !== this.value) {
                                       if (this.value == "") {
                                          that
                                             .search(this.value)
                                             .draw();
                                       } else {
                                          if (e.keyCode == 13) {
                                             that
                                                .search(this.value)
                                                .draw();
                                          }
                                       }
                                    }
                                 });
                              });

                              $('#table-inquiry_filter input').unbind();

                              $("#table-inquiry_filter input").keyup(function(e) {
                                 if ($(this).val() == "") {
                                    tableInq.search(this.value).draw();
                                 } else {
                                    if (e.keyCode == 13) {
                                       tableInq.search(this.value).draw();
                                    }
                                 }
                              });

                              $(function() {
                                 var tableContainer = $(".large-table-container-3");
                                 var table = $(".large-table-container-3 table");
                                 var fakeContainer = $(".large-table-fake-top-scroll-container-3");
                                 var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");

                                 var tableWidth = table.width();
                                 fakeDiv.width(tableWidth + 20);

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
                        if (isset($sregid)) {
                           echo "
                                        $('#table-inquiry_filter input').val('$sregid');
                                        tableInq.search('$sregid').draw();
                                    ";
                        }
                        ?>
                     });
                  </script>
               </div>
            </div>
         </div>
      </div>
      </div>
      </div>
   <?php
      break;

   case "view":
      $sid = encrypt_decrypt("decrypt",$_GET['id']);

      $sqle = "select aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai, ";
      $sqle = $sqle . " aa.akhir,aa.masa,aa.up,aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby, ";
      $sqle = $sqle . " aa.validdt,aa.nopeserta,aa.usia,aa.premi,aa.epremi,aa.tpremi, ";
      $sqle = $sqle . " aa.bunga,aa.tunggakan, aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno,aa.asuransi,ab.msdesc tstatus  ";
      $sqle = $sqle . " from tr_sppa aa  left join ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' ";
      $sqle = $sqle . " where aa.regid='$sid'";

      /* echo $sqle;  */
      $query = mysql_query($sqle);
      $r = mysql_fetch_array($query);
      $sjkel = $r['jkel'];
      $spekerjaan = $r['pekerjaan'];
      $scabang = $r['cabang'];
      $smitra = $r['mitra'];
      $produk = $r['produk'];
      $sasuransi = $r['asuransi'];
      $ssubject = $r['subject'];
      $sregid = $r['regid'];
      $sphoto = "photo/" . $sregid . ".jpg";
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
                        <h2>View <small><?php echo $sid; ?></small></h2>

                        <div class="clearfix"></div>
                     </div>
                     <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi . " ?module=update "; ?>">
                           <input type="hidden" name="id" value="<?php echo $sregid; ?>">
                           <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                           <input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select disabled class="select2_single form-control" tabindex="-2" name="produk" id="produk" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose produk --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk'  order by ms.mstype ";
                                    $query = mysql_query($sqlcmb);
                                    while ($bariscb = mysql_fetch_array($query)) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb[ 'comtabid' ]==$produk){ ?> selected="selected"
                                          <? }?>>
                                          <?= $bariscb['comtab_nm'] ?>
                                       </option>
                                    <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                           </div>

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
                                 <input type="text" id="nopeserta" name="nopeserta" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="nama" name="nama" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="tgllahir" name="tgllahir" min="6" max="100" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tgllahir']); ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="int" id="usia" name="usia" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>">

                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="noktp" name="noktp" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Kelamin
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='jkel'  order by ms.mstype ";
                                    $query = mysql_query($sqlcmb);
                                    while ($bariscb = mysql_fetch_array($query)) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb[ 'comtabid' ]==$sjkel){ ?> selected="selected"
                                          <? }?>>
                                          <?= $bariscb['comtab_nm'] ?>
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
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra'  order by ms.mstype ";
                                    $query = mysql_query($sqlcmb);
                                    while ($bariscb = mysql_fetch_array($query)) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb[ 'comtabid' ]==$smitra){ ?> selected="selected"
                                          <? }?>>
                                          <?= $bariscb['comtab_nm'] ?>
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
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype ";
                                    $query = mysql_query($sqlcmb);
                                    while ($bariscb = mysql_fetch_array($query)) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb[ 'comtabid' ]==$scabang){ ?> selected="selected"
                                          <? }?>>
                                          <?= $bariscb['comtab_nm'] ?>
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
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype ";
                                    $query = mysql_query($sqlcmb);
                                    while ($bariscb = mysql_fetch_array($query)) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb[ 'comtabid' ]==$spekerjaan){ ?> selected="selected"
                                          <? }?>>
                                          <?= $bariscb['comtab_nm'] ?>
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
                                 <input type="text" id="masa" name="masa" min="6" max="100" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="mulai" name="mulai" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['mulai']); ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="akhir" name="akhir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['akhir']); ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="up" name="up" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up']); ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Premi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="premi" name="premi" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['premi'], 0); ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Extra Premi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="epremi" name="epremi" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['epremi'], 0); ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asuransi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select disabled class="select2_single form-control" tabindex="-2" name="asuransi" id="asuransi" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='asuransi'  order by ms.mstype ";
                                    $query = mysql_query($sqlcmb);
                                    while ($bariscb = mysql_fetch_array($query)) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb[ 'comtabid' ]==$sasuransi){ ?> selected="selected"
                                          <? }?>>
                                          <?= $bariscb['comtab_nm'] ?>
                                       </option>
                                    <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Status
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="tstatus" name="tstatus" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tstatus']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal bayar
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="mulai" name="mulai" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_yyyymmdd($r['paiddt']); ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Grace Preiod (Khusus MPP)
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="gp" name="gp" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tunggakan']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <textarea name="subject" readonly rows="5" class="textbox" id="subject" style='width: 98%;'>
                                                <?php echo htmlspecialchars(stripslashes($ssubject)); ?>
                                            </textarea>
                              </div>
                           </div>

                           <h2>Dokumen <small><?php echo $sid; ?></small></h2>
                           <div style="width:100%;overflow-x:auto;">
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

                                    $sqld = "SELECT regid,tglupload,nama_file,tipe_file,ukuran_file,file,pages,createby,createdt  ";
                                    $sqld = $sqld . " seqno,jnsdoc,catdoc from tr_document   where regid='$sid' ";
                                    $query = mysql_query($sqld);
                                    $num = mysql_num_rows($query);
                                    $no = 1;
                                    while ($r = mysql_fetch_array($query)) {
                                    ?>
                                       <tr>

                                          <td>
                                             <?php echo $no; ?>
                                          </td>
                                          <td>
                                             <a href="<?php echo $r['file'] ?>" target="pdf-frame">
                                                <?php echo $r['nama_file']; ?>
                                             </a>
                                          <td>
                                             <?php echo $r['tipe_file']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['ukuran_file']; ?>
                                          </td>

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

                           <h2>Log Status <small><?php echo $sid; ?></small></h2>
                           <div style="width:100%;overflow-x:auto;">
                              <table class="table table-bordered">
                                 <thead>
                                    <tr>

                                       <th>Code</th>
                                       <th>Status </th>
                                       <th>User</th>
                                       <th>Tanggal</th>
                                       <th>Keterangan</th>

                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                    $sqld = "SELECT a.regid,a.status,a.comment,a.createdt,a.createby ,b.msdesc stdesc ";
                                    $sqld = $sqld . " from tr_sppa_log a inner join ms_master b on a.status=b.msid and b.mstype='streq'";
                                    $sqld = $sqld . " where regid='$sid' order by a.createdt desc ";
                                    $query = mysql_query($sqld);
                                    $num = mysql_num_rows($query);
                                    $no = 1;
                                    while ($r = mysql_fetch_array($query)) {
                                    ?>
                                       <tr>

                                          <td>
                                             <?php echo $r['status']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['stdesc']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['createby']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['createdt']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['comment']; ?>
                                          </td>

                                       </tr>
                                    <?php
                                       $no++;
                                    }
                                    ?>
                                 </tbody>
                              </table>
                           </div>
                           <h2>Data Yang Terhubung <small><?php echo $sid; ?></small></h2>
                           <div style="width:100%;overflow-x:auto;">
                              <table class="table table-bordered">
                                 <thead>
                                    <tr>

                                       <th>No Register</th>
                                       <th>Produk</th>
                                       <th>Mulai</th>
                                       <th>Akhir</th>
                                       <th>UP</th>
                                       <th>Premi</th>
                                       <th>Status</th>
                                       <th></th>

                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                    $sqld = "SELECT a.regid,a.produk , m.msdesc proddesc ,a.up,a.tpremi,a.mulai,a.akhir,s.msdesc stdesc ";
                                    $sqld = $sqld . " from tr_sppa a inner join tr_sppa_reff b on a.regid=b.regid ";
                                    $sqld = $sqld . " left join ms_master m on m.msid=a.produk and  m.mstype='produk' ";
                                    $sqld = $sqld . " left join ms_master s on s.msid=a.status and  s.mstype='streq' ";
                                    $sqld = $sqld . " where b.reffregid='$sid' ";

                                    $query = mysql_query($sqld);
                                    $num = mysql_num_rows($query);
                                    $no = 1;
                                    while ($r = mysql_fetch_array($query)) {
                                    ?>
                                       <tr>

                                          <td>
                                             <?php echo $r['regid']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['proddesc']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['mulai']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['akhir']; ?>
                                          </td>
                                          <td>
                                             <?php echo number_format($r['up'], 0); ?>
                                          </td>
                                          <td>
                                             <?php echo number_format($r['tpremi'], 0); ?>
                                          </td>
                                          <td>
                                             <?php echo $r['stdesc']; ?>
                                          </td>
                                          <th>
                                             <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=inquiry&&act=view&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> view</button>
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
                                 <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Back</button>

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
      $sid = encrypt_decrypt("decrypt",$_GET['id']);

      $sqle = "select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta, ";
      $sqle = $sqle . " aa.premi,aa.cabang,aa.produk ";
      $sqle = $sqle . " from tr_sppa aa ";
      $sqle = $sqle . " where aa.regid='$sid'";

      /* echo $sqle;  */
      $query = mysql_query($sqle);
      $r = mysql_fetch_array($query);
      $sjkel = $r['jkel'];
      $spekerjaan = $r['pekerjaan'];
      $scabang = $r['cabang'];
      $smitra = $r['mitra'];
      $sproduk = $r['produk'];
      $ssubject = $r['subject'];
      $sregid = $r['regid'];
      $sphoto = "photo/" . $sregid . ".jpg";
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
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi . " ?module=reject "; ?>">
                           <input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
                           <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                           <input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

                           <div style="width:100%;overflow-x:auto;">
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
                                    $sqll = "SELECT a.*,b.msdesc statpol from tr_sppa_log a ";
                                    $sqll = $sqll . " inner join ms_master b on a.status=b.msid and b.mstype='STREQ' ";
                                    $sqll = $sqll . " where a.regid='$sid'  ";
                                    /* echo $sqll; */
                                    $query = mysql_query($sqll);
                                    $num = mysql_num_rows($query);
                                    $no = 1;
                                    while ($r = mysql_fetch_array($query)) {

                                    ?>
                                       <tr>

                                          <td>
                                             <?php echo $r['status']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['statpol']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['createby']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['createdt']; ?>
                                          </td>
                                          <td>
                                             <?php echo $r['comment']; ?>
                                          </td>

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

<?php
      break;
}
?>