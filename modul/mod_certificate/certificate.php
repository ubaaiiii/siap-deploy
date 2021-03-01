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
</script>


<?php
$veid = $_SESSION['id_peg'];
$vempname = $_SESSION['empname'];
$vlevel = $_SESSION['idLevel'];
$userid = $_SESSION['idLog'];
$aksi = "modul/mod_certificate/aksi_certificate.php";
$judul = "Certificate";

switch ($_GET['act']) {
   default:
      $p      = new Paging;
      $batas  = 10;
      $posisi = $p->cariPosisi($batas);

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
                     <table class="table table-bordered" id="table-certificate" style="white-space: nowrap;">
                        <thead>
                           <tr>
                              <th>Asuransi </th>
                              <th>No Register </th>
                              <th>Nama</th>
                              <th>Tgl Lahir</th>
                              <th>Mulai</th>
                              <th>UP</th>
                              <th>Premi</th>
                              <th>Produk</th>
                              <th>Tenor</th>
                              <th>No Pinjaman</th>
                              <th>Status</th>
                              <th></th>

                           </tr>
                        </thead>
                     </table>
                     <script>
                         $(document).ready(function(){
                            var tableCertificate = $('#table-certificate').DataTable({
                                "colReorder": true,
                    			"processing": true,
                    			"autoWidth": true,
                    			"serverSide": true,
                    			"ajax": {
                                    "url": "modul/mod_certificate/data_certificate.php",
                                    "type": "POST",
                        //             error: function(resp) {
                        // 			    console.log(resp.responseText);
                        // 			},
                        // 			success: function(d) {
                        //                 console.log(d);
                        //             },
                                },
                    			"aoColumns": [
                    			  /* 0*/ {"sName": "asuransi"},
                    			  /* 1*/ {"sName": "regid"},
                    			  /* 2*/ {"sName": "nama"},
                    			  /* 3*/ {"sName": "tgllahir"},
                    			  /* 4*/ {"sName": "mulai"},
                    			  /* 5*/ {
                            			      "sName"  : "up",
                            			      "mRender": function ( data, type, full, meta ) {
                            					return $.fn.dataTable.render.number( ',', '.', 0 ).display(data);
                            				  }
                            			  },
                    			  /* 6*/ {
                            			      "sName"  : "premi",
                            			      "mRender": function ( data, type, full, meta ) {
                            					return $.fn.dataTable.render.number( ',', '.', 0 ).display(data);
                            				  }
                            			  },
                    			  /* 7*/ {"sName": "produk"},
                    			  /* 8*/ {
                    			            "sName": "masa",
                    			            "mRender": function( data, type, full, meta) {
                    			                var tahun = (Number.isInteger(data/12))?(data/12):(data/12).toFixed(2);
                    			                return data + " bulan / " + tahun + " tahun";
                    			            }
                            			            
                            			  },
                    			  /* 9*/ {"sName": "nopeserta"},
                    			  /*10*/ {"sName": "status"},
                    			  /*11*/ {
                            				"mRender": function ( data, type, full, meta ) {
                            				    var button = `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="View" href="media.php?module=certificate&&act=update&&id=`+full[1]+`"><i class="fa fa-search"></i> View</a>`;
                            				    
                            				    button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Sertifikat" href="laporan/cert/f_cert.php?id=`+full[1]+`"><i class="fa fa-print"></i> Cert</a>`;
                            				    button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Invoice" href="laporan/bill/f_bill.php?id=`+data+`"><i class="fa fa-print"></i> Invoice</a>`;
                            				    
                            				    <?php if($vlevel == 'broker'){ ?>
                                				    button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="paid" href="media.php?module=certificate&&act=paid&&id=`+full[1]+`"><i class="fa fa-money"></i> Paid</a>`;
                            				    <?php } ?>
                            				    <?php if($vlevel == 'mkt' || $vlevel == 'smkt'){ ?>
                                				    if (full[12] == 20) {
                                				        button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Top Up" href="media.php?module=certificate&&act=topup&&id=`+full[1]+`"><i class="fa fa-external-link-square"></i> Top up</a>`;
                                				    }
                            				    <?php } ?>
                            				    
                            				    if ([73, 83].includes(full[12])) {
                            				        button += `<a class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Invoice" href="laporan/refund/f_refund.php?id=`+data+`"><i class="fa fa-print"></i> Refund</a>`;
                            				    }
                            				    
                            				    return button;
                            				}
                            			  },
                    			  /*12*/ {"sName": "status_code", "visible": false},
                    			],
                    			"columnDefs": [
                    			    {
                                        "targets": 11,
                                        "orderable": false,
                                    },
                                    {
                                        targets: [5,6],
                                        className: 'text-right'
                                    },
                                    {
                                        targets: [1,3,4,7,10],
                                        className: 'text-center'
                                    }
                                ],
                                initComplete: function() {
                                    $('#table-certificate_filter input').unbind();
                                    
                                    $("#table-certificate_filter input").keyup(function(e) {
                                        if (this.value == "") {
                                            tableCertificate.search(this.value).draw();
                                        } else {
                                            if (e.keyCode == 13) {
                                                tableCertificate.search(this.value).draw();
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
                                // createdRow: function( row, data, dataIndex ) {
                                // },
                            }); 
                         });
                     </script>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
      </div>
   <?php
      break;

   case "update":
      $sid  = $_GET['id'];
      $sqle = " SELECT aa.regid,
                       aa.nama,
                       aa.noktp,
                       aa.jkel,
                       aa.pekerjaan,
                       aa.cabang,
                       aa.tgllahir,
                       aa.mulai,
                       aa.akhir,
                       aa.masa,
                       aa.up,
                       aa.status,
                       aa.createdt,
                       aa.createby,
                       aa.editdt,
                       aa.editby,
                       aa.validby,
                       aa.validdt,
                       aa.nopeserta,
                       aa.usia,
                       aa.premi,
                       aa.epremi,
                       aa.tpremi,
                       aa.bunga,
                       aa.tunggakan,
                       aa.produk,
                       aa.mitra,
                       aa.comment,
                       aa.asuransi,
                       aa.policyno,
                       ab.msdesc tstatus,
                       ac.paiddt
                FROM   tr_sppa aa
                       LEFT JOIN ms_master ab
                              ON aa.status = ab.msid
                                 AND ab.mstype = 'STREQ'
                       LEFT JOIN tr_sppa_paid ac
                              ON ac.regid = aa.regid
                WHERE  aa.regid = '$sid'  ";

      /* echo $sqle; */
      $query = $db->query($sqle);
      $r     = $query->fetch_array();

      $sjkel        = $r['jkel'];
      $spekerjaan   = $r['pekerjaan'];
      $scabang      = $r['cabang'];
      $ssubject     = $r['subject'];
      $sproduk      = $r['produk'];
      $susia        = $r['tgllahir'] . ' / ' .  $r['usia'] . ' tahun ';
      $smasaass     = $r['masa'] . ' Bulan / ' . $r['mulai'] . ' s/d ' . $r['akhir'];
      $sregid       = $r['regid'];
      $sphoto       = "photo/" . $sregid . ".jpg";

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
                        <h2>View <small><?php echo $r['reqid']; ?></small></h2>

                        <div class="clearfix"></div>
                     </div>
                     <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi . "?module=update"; ?>">
                           <input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
                           <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                           <input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select disabled class="select2_single form-control" tabindex="-2" name="produk" id="produk" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sproduk){ ?> selected="selected"
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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir /Usia
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="tgllahir" name="tgllahir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $susia; ?>">

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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sjkel){ ?> selected="selected"
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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$scabang){ ?> selected="selected"
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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$spekerjaan){ ?> selected="selected"
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
                                 <input type="text" id="mulai" name="mulai" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $smasaass; ?>">

                              </div>
                           </div>




                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="up" name="up" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'], 0); ?>">

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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal bayar
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="tglbayar" name="tglbayar" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['paiddt']; ?>">

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
                                 <textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($ssubject)); ?></textarea>
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

                                    $sqld = "SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from  ";
                                    $sqld = $sqld . " tr_document a  where regid='$sid'  ";
                                    $query = $db->query($sqld);
                                    $num = $query->num_rows;
                                    $no = 1;
                                    while ($r = $query->fetch_array()) {
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
                                 <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=certificate'"><i class="fa fa-arrow-left"></i> Back</button>



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

   case "cancel":
      $sid = $_GET['id'];

      $sqle = "select aa.*,ab.tglbatal ";
      $sqle = $sqle . " from tr_sppa aa left join tr_sppa_cancel ab on ab.regid=aa.regid ";
      $sqle = $sqle . " where aa.regid='$sid'";

      /* echo $sqle; */
      $query = $db->query($sqle);
      $r = $query->fetch_array();
      $sjkel = $r['jkel'];
      $spekerjaan = $r['pekerjaan'];
      $scabang = $r['cabang'];
      $ssubject = $r['subject'];
      $sproduk = $r['produk'];
      $susia = $r['tgllahir'] . ' / ' .  $r['usia'] . ' tahun ';
      $smasaass = $r['masa'] . ' Bulan / ' . $r['mulai'] . ' s/d ' . $r['akhir'];
      $canceldt = $r['tglbatal'];
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
                        <h2>Cancelation <small><?php echo $r['reqid']; ?></small></h2>

                        <div class="clearfix"></div>
                     </div>
                     <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi . "?module=cancel"; ?>">
                           <input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
                           <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                           <input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Peserta
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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir /Usia
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="tgllahir" name="tgllahir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $susia; ?>">

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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sjkel){ ?> selected="selected"
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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$scabang){ ?> selected="selected"
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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$spekerjaan){ ?> selected="selected"
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
                                 <input type="text" id="mulai" name="mulai" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $smasaass; ?>">

                              </div>
                           </div>




                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="up" name="up" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'], 0); ?>">

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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alasan Pembatalan
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select class="select2_single form-control" tabindex="-2" name="catreason" id="catreason" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='batal'  order by ms.msdesc ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sbatal){ ?> selected="selected"
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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Pembatalan
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="date" id="canceldt" name="canceldt" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['canceldt']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <textarea name="reason" rows="5" class="textbox" id="reason" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($ssubject)); ?></textarea>
                              </div>
                           </div>


                           <div class="ln_solid"></div>
                           <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                 <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=certificate'"><i class="fa fa-arrow-left"></i> Back</button>
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
   case "refund":
      $sid = $_GET['id'];

      $sqle = "select aa.*,ab.tglbatal ";
      $sqle = $sqle . " from tr_sppa aa left join tr_sppa_cancel ab on ab.regid=aa.regid ";
      $sqle = $sqle . " where aa.regid='$sid'";

      /* echo $sqle; */
      $query = $db->query($sqle);
      $r = $query->fetch_array();
      $sjkel = $r['jkel'];
      $spekerjaan = $r['pekerjaan'];
      $scabang = $r['cabang'];
      $ssubject = $r['subject'];
      $sproduk = $r['produk'];
      $susia = $r['tgllahir'] . ' / ' .  $r['usia'] . ' tahun ';
      $smasaass = $r['masa'] . ' Bulan / ' . $r['mulai'] . ' s/d ' . $r['akhir'];
      $canceldt = $r['tglbatal'];
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
                        <h2>Cancelation <small><?php echo $r['reqid']; ?></small></h2>

                        <div class="clearfix"></div>
                     </div>
                     <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi . "?module=refund"; ?>">
                           <input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
                           <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                           <input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Peserta
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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir /Usia
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="tgllahir" name="tgllahir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $susia; ?>">

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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sjkel){ ?> selected="selected"
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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$scabang){ ?> selected="selected"
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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$spekerjaan){ ?> selected="selected"
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
                                 <input type="text" id="mulai" name="mulai" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $smasaass; ?>">

                              </div>
                           </div>




                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="up" name="up" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'], 0); ?>">

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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alasan Pembatalan
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select class="select2_single form-control" tabindex="-2" name="catreason" id="catreason" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='refund'  order by ms.msdesc ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sbatal){ ?> selected="selected"
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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Pembatalan
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="date" id="canceldt" name="canceldt" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['canceldt']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <textarea name="reason" rows="5" class="textbox" id="reason" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($ssubject)); ?></textarea>
                              </div>
                           </div>


                           <div class="ln_solid"></div>
                           <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                 <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=certificate'"><i class="fa fa-arrow-left"></i> Back</button>
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

   case "paid":
      $sid = $_GET['id'];

      $sqle = "select   aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai,aa.akhir,aa.masa,	";
      $sqle = $sqle . " aa.up,	aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby,aa.validdt,aa.nopeserta,aa.usia,	";
      $sqle = $sqle . " aa.premi,aa.epremi,aa.tpremi,aa.bunga,aa.tunggakan,aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno ,ab.paiddt ";
      $sqle = $sqle . " from tr_sppa aa left join tr_sppa_paid ab on aa.regid=ab.regid ";
      $sqle = $sqle . " where aa.regid='$sid'";

      /* echo $sqle; */
      $query = $db->query($sqle);
      $r = $query->fetch_array();
      $sjkel = $r['jkel'];
      $spekerjaan = $r['pekerjaan'];
      $scabang = $r['cabang'];
      $ssubject = $r['subject'];
      $sproduk = $r['produk'];

      $susia = $r['tgllahir'] . ' / ' .  $r['usia'] . ' tahun ';
      $smasaass = $r['masa'] . ' Bulan / ' . $r['mulai'] . ' s/d ' . $r['akhir'];

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
                        <h2>Paid <small><?php echo $r['reqid']; ?></small></h2>

                        <div class="clearfix"></div>
                     </div>
                     <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi . "?module=paid"; ?>">
                           <input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
                           <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                           <input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Peserta
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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir /Usia
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="tgllahir" name="tgllahir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $susia; ?>">

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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sjkel){ ?> selected="selected"
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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$scabang){ ?> selected="selected"
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
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$spekerjaan){ ?> selected="selected"
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
                                 <input type="text" id="mulai" name="mulai" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $smasaass; ?>">

                              </div>
                           </div>




                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="up" name="up" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'], 0); ?>">

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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tanggal Pembayaran
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="date" id="paiddt" name="paiddt" class="form-control col-md-7 col-xs-12" value="<?php echo $r['paiddt']; ?>">

                              </div>
                           </div>




                           <div class="ln_solid"></div>
                           <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                 <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=certificate'"><i class="fa fa-arrow-left"></i> Back</button>
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

   case "topup":
      $sid = $_GET['id'];

      $sqle = "select   aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai,aa.akhir,aa.masa,	";
      $sqle = $sqle . " aa.up,	aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby,aa.validdt,aa.nopeserta,aa.usia,	";
      $sqle = $sqle . " aa.premi,aa.epremi,aa.tpremi,aa.bunga,aa.tunggakan,aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno ,ab.paiddt ";
      $sqle = $sqle . " from tr_sppa aa left join tr_sppa_paid ab on aa.regid=ab.regid ";
      $sqle = $sqle . " where aa.regid='$sid'";

      /* echo $sqle; */
      $query = $db->query($sqle);
      $r = $query->fetch_array();
      $sjkel = $r['jkel'];
      $spekerjaan = $r['pekerjaan'];
      $scabang = $r['cabang'];
      $ssubject = $r['subject'];
      $sproduk = $r['produk'];
      $stgllahir = $r['tgllahir'];

      $susia = $r['tgllahir'] . ' / ' .  $r['usia'] . ' tahun ';
      $smasaass = $r['masa'] . ' Bulan / ' . $r['mulai'] . ' s/d ' . $r['akhir'];

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
                        <h2>Top Up <small><?php echo $r['reqid']; ?></small></h2>

                        <div class="clearfix"></div>
                     </div>
                     <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi . "?module=topup"; ?>">
                           <input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
                           <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                           <input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select disabled class="select2_single form-control" tabindex="-2" name="produk" id="produk" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sproduk){ ?> selected="selected"
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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Peserta
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
                                 <input type="text" id="tgllahir" name="tgllahir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $stgllahir; ?>">

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
                                 <select class="select2_single form-control" tabindex="-2" disabled name="jkel" id="jkel" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='jkel'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sjkel){ ?> selected="selected"
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
                                 <select class="select2_single form-control" tabindex="-2" disabled name="cabang" id="cabang" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$scabang){ ?> selected="selected"
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
                                 <select class="select2_single form-control" tabindex="-2" disabled name="pekerjaan" id="pekerjaan" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$spekerjaan){ ?> selected="selected"
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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="date" id="mulai" name="mulai" required="required" value="<?=date('Y-m-d');?>" class="form-control col-md-7 col-xs-12">

                              </div>
                           </div>


                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="number" id="masa" name="masa" placeholder="dalam bulan" required="required" class="form-control col-md-7 col-xs-12">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Uang Pertanggungan
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="up" name="up" placeholder="dalam rupiah" required="required" class="form-control col-md-7 col-xs-12" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Grace Period (khusus MPP)
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="number" id="tunggakan" name="tunggakan" min="0" max="1000" placeholder="dalam bulan" required="required" class="form-control col-md-7 col-xs-12">

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

   case "topuphsl":
      $sid = $_GET['id'];

      $sqle = "select   aa.regid,	aa.nama,	aa.noktp,	aa.jkel,	aa.pekerjaan,	aa.cabang,	aa.tgllahir,	aa.mulai,	aa.akhir,	aa.masa,	";
      $sqle = $sqle . " aa.up,	aa.status,	aa.createdt,	aa.createby,	aa.editdt,	aa.editby,	aa.validby,	aa.validdt,	aa.nopeserta,	aa.usia,	";
      $sqle = $sqle . " aa.premi,	aa.epremi,	aa.tpremi,	aa.bunga,	aa.tunggakan,	aa.produk,	aa.mitra,	aa.comment,	aa.asuransi,	aa.policyno ";
      $sqle = $sqle . " from tr_sppa aa ";
      $sqle = $sqle . " where aa.regid='$sid'";
      /* echo $sqle; */

      $query = $db->query($sqle);
      $r = $query->fetch_array();
      $sjkel = $r['jkel'];
      $spekerjaan = $r['pekerjaan'];
      $scabang = $r['cabang'];
      $ssubject = $r['comment'];
      $sregid = $r['regid'];
      $sproduk = $r['produk'];
      $smitra = $r['mitra'];
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
                        <h2>Top Up <small><?php echo $r['reqid']; ?></small></h2>

                        <div class="clearfix"></div>
                     </div>
                     <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi . "?module=update"; ?>">
                           <input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
                           <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                           <input type="hidden" name="sjkel" value="<?php echo $sjkel; ?>">
                           <input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select disabled class="select2_single form-control" tabindex="-2" name="produk" id="produk" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sproduk){ ?> selected="selected"
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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="nama" name="nama" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">

                              </div>
                           </div>





                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="date" id="tgllahir" name="tgllahir" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tgllahir']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="int" id="usia" name="usia" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>">

                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="noktp" name="noktp" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Kelamin
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <select class="select2_single form-control" tabindex="-2" name="jkel" id="jkel" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select distinct  ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='jkel'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$sjkel){ ?> selected="selected"
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
                                 <select class="select2_single form-control" tabindex="-2" name="pekerjaan" id="pekerjaan" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select distinct  ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$spekerjaan){ ?> selected="selected"
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
                                 <select class="select2_single form-control" tabindex="-2" name="cabang" id="cabang" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select distinct  ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$scabang){ ?> selected="selected"
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
                                 <select class="select2_single form-control" tabindex="-2" name="mitra" id="mitra" onChange="display(this.value)">
                                    <option value="" selected="selected">-- choose category --</option>
                                    <?php
                                    $sqlcmb = "select distinct  ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra'  order by ms.mstype ";
                                    $query = $db->query($sqlcmb);
                                    while ($bariscb = $query->fetch_array()) {
                                    ?>
                                       <option value="<?= $bariscb['comtabid'] ?>" <? if($bariscb['comtabid']==$smitra){ ?> selected="selected"
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
                                 <input type="text" id="masa" name="masa" min="6" max="100" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>">

                              </div>
                           </div>


                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="date" id="mulai" name="mulai" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['mulai']; ?>">

                              </div>
                           </div>


                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="date" id="akhir" name="akhir" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['akhir']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="up" name="up" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'], 0); ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Premi
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="premi" name="premi" readonly class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['premi'], 0); ?>">

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
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Grace Period (khusus MPP)
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" id="tunggakan" name="tunggakan" min="0" max="100" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['tunggakan']; ?>">

                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                 <textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'><?php echo htmlspecialchars(stripslashes($ssubject)); ?></textarea>
                              </div>
                           </div>



                           <div id="tabel_doc">
                              <table class="table table-bordered">
                                 <thead>
                                    <tr>

                                       <th>Nama file </th>

                                       <th></th>


                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                    $sqld = "select  a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file, ";
                                    $sqld = $sqld . " a.file,a.pages,a.createby,a.createdt,a.seqno,a.jnsdoc,a.catdoc ";
                                    $sqld = $sqld . " from tr_document a  where a.regid='$sid' ";
                                    $query = $db->query($sqld);
                                    $num = $query->num_rows;
                                    $no = 1;
                                    while ($r = $query->fetch_array()) {
                                    ?>
                                       <tr>


                                          <td><a href="<?php echo $r['file'] ?>" target="pdf-frame"><?php echo $r['nama_file']; ?> </a>

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
                           <div id="tabel_photo">
                              <table class="table table-bordered">
                                 <tbody>
                                    <?php

                                    $sqld = "select  a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file, ";
                                    $sqld = $sqld . " a.file,a.pages,a.createby,a.createdt,a.seqno,a.jnsdoc,a.catdoc ";
                                    $sqld = $sqld . " from tr_document a  where a.regid='$sid' ";

                                    $query = $db->query($sqld);
                                    $num = $query->num_rows;
                                    $no = 1;
                                    while ($r = $query->fetch_array()) {
                                       $sphoto   = $r['file'];
                                    ?>
                                       <tr>
                                          <td>
                                             <img src="<?php echo $sphoto; ?>" alt="Avatar" style="high:30;width:30%;float:left;margin-right:10px;">
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
                                 <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=ajuan'"><i class="fa fa-arrow-left"></i> Back</button>
                                 <button type="submit" class="btn btn-sm btn-default">Submit</button>
                                 <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="document" onclick="window.location='media.php?module=doc&&id=<?php echo $sregid; ?>'"><i class="fa fa-search"></i> Doc</button>
                                 <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="photo" onclick="window.location='media.php?module=photo&&act=update&&id=<?php echo $sregid; ?>'"><i class="fa fa-search"></i> Photo</button>
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