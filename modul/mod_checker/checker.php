
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
    var struid = $("#uid").val();
    var strlvl = $("#lvl").val();
    if (strcari != "") {
      $("#tabel_awal").css("display", "none");
      $("#hasil").html("<img src='images/loader.gif'/>");
      $.ajax({
        type: "post",
        url: "modul/mod_checker/cari.php",
        data: "q=" + strcari + "&uid=" + struid + "&lvl=" + strlvl,
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
include("../../config/koneksi.php");
$veid = $_SESSION['id_peg'];
$vlevel = $_SESSION['idLevel'];
$userid = $_SESSION['idLog'];
$ucab = $_SESSION['ucab'];
$aksi = "modul/mod_checker/aksi_checker.php";
$judul = "Checker";
$slevel = $_GET['vlevel'];
switch (isset($_GET['act']))
{
  default:
  $p = new Paging;
  $batas = 10;
  $posisi = $p->cariPosisi($batas);
  ?>
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $judul; ?></h3> </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="x_content">
            <div class="col-md-6 col-sm-6 col-xs-12"> </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="hidden" id="uid" name="uid" value="<?php echo $userid; ?>">
              <input type="hidden" id="lvl" name="lvl" value="<?php echo $vlevel; ?>">
              <input type="text" required="required" class="form-control" placeholder="Search" id="txtcari"> </div>
              <div class="row" id="form_add">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Input Data</h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="<?php echo $aksi."?module=add " ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div id="hasil"></div>
              <div id="tabel_awal">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No Register </th>
                      <th>Nama</th>
                      <th>Tgl Lahir</th>
                      <th>Mulai</th>
                      <th>UP</th>
                      <th>Premi</th>
                      <th>Produk</th>
                      <th>Tenor</th>
                      <th>No Pinjaman</th>
                      <th>Cabang </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($vlevel == "checker")
                    {
                      $sqlr = "select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
                      $sqlr = $sqlr . " ,cb.msdesc cabang,pd.msdesc produk,aa.masa from tr_sppa aa  ";
                      $sqlr = $sqlr . "  left join ms_master cb on cb.msid=aa.cabang and cb.mstype='cab' ";
                      $sqlr = $sqlr . "  left join ms_master pd on pd.msid=aa.produk and pd.mstype='produk' ";
                      $sqlr = $sqlr . " where aa.status='11'  ";
                      $sqlr = $sqlr . " and aa.cabang like  ( ";
                      $sqlr = $sqlr . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
                      $sqlr = $sqlr . "from ms_admin where username='$userid' )";
                    }
                    if ($vlevel == "schecker")
                    {
                      $sqlr = "select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
                      $sqlr = $sqlr . " ,cb.msdesc cabang,pd.msdesc produk,aa.masa from tr_sppa aa  ";
                      $sqlr = $sqlr . "  left join ms_master cb on cb.msid=aa.cabang and cb.mstype='cab' ";
                      $sqlr = $sqlr . "  left join ms_master pd on pd.msid=aa.produk and pd.mstype='produk' ";
                      $sqlr = $sqlr . " where aa.status='2'  ";
                      $sqlr = $sqlr . " and aa.cabang like  ( ";
                      $sqlr = $sqlr . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
                      $sqlr = $sqlr . "from ms_admin where username='$userid' )";
                    }
                    if ($userid == "chkspm01")
                    {
                      $sqlr = $sqlr . " and aa.regid in (select regid from vw_tr_sppa_chkstf01 ) ";
                    }
                    $sqlr = $sqlr . " order by aa.regid desc LIMIT $posisi,$batas ";
                    $query = $db->query($sqlr);
                    $num = $query->num_rows;
                    $no = 1;
                    while ($r = $query->fetch_array())
                    {
                      $scond = array(
                        'schecker',
                        'schecker'
                      );
                      $sfield = $vlevel;
                      $sdoc = $r['jnsdoc'];
                      $skkt = array(
                        "SKKT",
                        "SKKT"
                      );
                      $spd = array(
                        "SPD",
                        "SPD"
                      );
                      $spm = array(
                        "SPM",
                        "SPM"
                      );
                      $spm = array(
                      "MEDA",
                      "MEDA"
                      ); ?>


                      <tr>
                        <td>
                          <?php echo $r['regid']; ?>
                        </td>
                        <td>
                          <?php echo $r['nama']; ?>
                        </td>
                        <td>
                          <?php echo tglindo_balik($r['tgllahir']); ?>
                        </td>
                        <td>
                          <?php echo tglindo_balik($r['mulai']); ?>
                        </td>
                        <td>
                          <?php echo number_format($r['up'], 0); ?>
                        </td>
                        <td>
                          <?php echo number_format($r['premi'], 0); ?>
                        </td>
                        <td>
                          <?php echo $r['produk']; ?>
                        </td>
                        <td>
                          <?php echo $r['masa']; ?>
                        </td>
                        <td>
                          <?php echo $r['nopeserta']; ?>
                        </td>
                        <td>
                          <?php echo $r['cabang']; ?>
                        </td>
                        <th>
                          <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="window.location='media.php?module=checker&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Edit</button>
                          <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="document" onclick="window.location='media.php?module=doc&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Doc</button>
                          <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="sppa" onclick="window.location = 'laporan/sppa/f_sppa.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPPA</button>
                          <button type="button" class="btn btn-sm btn-info btn-approve" data-toggle="tooltip" data-placement="top" title="Approve" d-id="<?=$r['regid']; ?>" d-nopinjam="<?php echo $r['nopeserta']; ?>"><i class="fa fa-check-square"></i> Approve</button>
                          <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Log" onclick="window.location='media.php?module=polhist&&act=update&&id=<?php echo $r['regid']; ?>'"><i class="fa fa-search"></i> Log</button>
                          <button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="rollback" onclick="if (confirm('Yakin ingin Rollback data <?=$r['nama']; ?>?')) { window.location='<?php echo $aksi."?module=rollback&&id=".$r['regid'] ."&&lvl=" .$vlevel."&&uid=" .$userid; ?>' ;}"><i class="fa fa-trash"></i> Rollback</button>
                          <?php if (in_array($sdoc, $spd, true)): ?>
                            <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="SPD" onclick="window.location = 'laporan/spd/f_spd.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPD</button>
                          <?php endif; ?>
                          <?php if (in_array($sdoc, $skkt, true)): ?>
                            <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="SKKT" onclick="window.location = 'laporan/skkt/f_skkt.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SKKT</button>
                          <?php endif; ?>
                          <?php if (in_array($sdoc, $spm, true)): ?>
                            <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="SPM" onclick="window.location = 'laporan/spm/f_spm.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> SPM</button>
                          <?php endif; ?>
                          <?php if (in_array($sdoc, $med, true)): ?>
                            <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="medical" onclick="window.location = 'laporan/meda/f_meda.php?id=<?php echo $r['regid']; ?>'"><i class="fa fa-print"></i> Med</button>
                          <?php endif; ?>
                        </th>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <script>
                  $(document).ready(function() {
                    $('.btn-approve').click(function() {
                      var id = $(this).attr('d-id');
                      var peserta = $(this).attr('d-nopinjam');
                      if (peserta == "" || peserta == "TBA") {
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Harap mengisi Nomor Pinjaman!',
                          footer: 'Akan dialihkan ke menu edit..'
                        }).then((result) => {
                          if (result.value) {
                            window.location = 'media.php?module=checker&&act=update&&id=' + id;
                          }
                        })
                      } else {
                        window.location = '<?=$aksi;?>?module=approve&&id=' + id + '&&lvl=<?=$vlevel;?>&&uid=<?=$userid;?>';
                      }
                    })
                  })
                </script>
              </div>
              <?php if ($vlevel == "checker")
              {
                $sqlp = "select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
                $sqlp = $sqlp . " ,cb.msdesc cabang,aa.produk from tr_sppa aa  ";
                $sqlp = $sqlp . "  left join ms_master cb on cb.msid=aa.cabang and cb.mstype='cab' ";
                $sqlp = $sqlp . " where aa.status='11'  ";
                $sqlp = $sqlp . " and cabang like (  ";
                $sqlp = $sqlp . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
                $sqlp = $sqlp . "from ms_admin where username='$userid' )";
              }
              if ($vlevel == "schecker")
              {
                $sqlp = "select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
                $sqlp = $sqlp . " ,cb.msdesc cabang,aa.produk from tr_sppa aa ";
                $sqlp = $sqlp . " left join ms_master cb on cb.msid=aa.cabang and cb.mstype='cab' ";
                $sqlp = $sqlp . " where aa.status='2'  ";
                $sqlp = $sqlp . " and cabang like (  ";
                $sqlp = $sqlp . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
                $sqlp = $sqlp . " from ms_admin where username='$userid' )";
              }
              if ($userid == "chkspm01")
              {
                $sqlp = $sqlp . " and aa.regid in (select regid from vw_tr_sppa_chkstf01 ) ";
              }
              $jmldata = $db->query($sqlp)->num_rows;
              $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
              $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
              echo "$linkHalaman"; ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  break;
  case "update":
  $sid = $_GET['id'];
  $sqle = "select aa.* ";
  $sqle = $sqle . " from tr_sppa aa ";
  $sqle = $sqle . " where aa.regid='$sid'"; /* echo $sqle; */
  $query = $db->query($sqle);
  $r = $query->fetch_array();
  $sjkel = $r['jkel'];
  $spekerjaan = $r['pekerjaan'];
  $scabang = $r['cabang'];
  $ssubject = $r['subject'];
  $sregid = $r['regid'];
  $sproduk = $r['produk'];
  $smitra = $r['mitra'];
  $sphoto = "photo/" . $sregid . ".jpg";
  ?>

  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $judul; ?></h3> </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Update <small><?php echo $r['reqid']; ?></small></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <br />
                <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update "; ?>">
                  <input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
                  <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                  <input type="hidden" name="regid" value="<?php echo $sregid; ?>">
                  <input type="hidden" name="produk" value="<?php echo $sproduk; ?>">
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produk </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select disabled class="select2_single form-control" tabindex="-2" name="produk" id="produk" onChange="display(this.value)">
                        <option value="" selected="selected">-- choose category --</option>
                        <?php
                          $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk'  order by ms.mstype ";
                          $query = $db->query($sqlcmb);
                          while ($bariscb = $query->fetch_array())
                          {
                        ?>
                          <option value="<?=$bariscb['comtabid']?>" <?php if ($bariscb[ 'comtabid']==$sproduk) { ?> selected="selected"
                          <?php } ?>>
                          <?=$bariscb['comtab_nm'];?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Register </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="regid" name="regid" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>"> </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No Pinjaman </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="nopeserta" name="nopeserta" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nopeserta']; ?>"> </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Nama </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="nama" name="nama" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>"> </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Lahir </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="tgllahir" name="tgllahir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo tglindo_balik($r['tgllahir']); ?>"> </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Usia Masuk </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="int" id="usia" name="usia" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['usia']; ?>"> </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> No KTP </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="noktp" name="noktp" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['noktp']; ?>"> </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Kelamin </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select disabled class="select2_single form-control" tabindex="-2" name="jkel" id="jkel" onChange="display(this.value)">
                                  <option value="" selected="selected">-- choose category --</option>
                                  <?php $sqlcmb = "select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='jkel' order by ms.mstype ";
                                  $query = $db->query($sqlcmb);
                                  while ($bariscb = $query->fetch_array())
                                  { ?>
                                    <option value="<?=$bariscb['comtabid'] ?>" <?php if ($bariscb['comtabid'] == $sjkel)
                                    { ?> selected="selected"
                                    <?php
                                  } ?>>
                                  <?=$bariscb['comtab_nm']; ?>
                                </option>
                                <?php
                              } ?>

                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mitra </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select disabled class="select2_single form-control" tabindex="-2" name="mitra" id="mitra" onChange="display(this.value)">
                                <option value="" selected="selected">-- choose category --</option>
                                <?php $sqlcmb = "select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra' order by ms.mstype ";
                                $query = $db->query($sqlcmb);
                                while ($bariscb = $query->fetch_array())
                                { ?>
                                  <option value="<?=$bariscb['comtabid'] ?>" <?php if ($bariscb['comtabid'] == $smitra)
                                  { ?> selected="selected"
                                  <?php
                                } ?>>
                                <?=$bariscb['comtab_nm']; ?>
                              </option>
                              <?php
                            } ?>

                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cabang </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select disabled class="select2_single form-control" tabindex="-2" name="cabang" id="cabang" onChange="display(this.value)">
                              <option value="" selected="selected">-- choose category --</option>
                              <?php $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype ";
                              $query = $db->query($sqlcmb);
                              while ($bariscb = $query->fetch_array())
                              { ?>
                                <option value="<?=$bariscb['comtabid'] ?>" <?php if ($bariscb['comtabid'] == $scabang)
                                { ?> selected="selected"
                                <?php
                              } ?>>
                              <?=$bariscb['comtab_nm']; ?>
                            </option>
                            <?php
                          } ?>

                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Pekerjaan </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select disabled class="select2_single form-control" tabindex="-2" name="pekerjaan" id="pekerjaan" onChange="display(this.value)">
                            <option value="" selected="selected">-- choose category --</option>
                            <?php $sqlcmb = "select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype ";
                            $query = $db->query($sqlcmb);
                            while ($bariscb = $query->fetch_array())
                            { ?>
                              <option value="<?=$bariscb['comtabid'] ?>" <?php if ($bariscb['comtabid'] == $spekerjaan)
                              { ?> selected="selected"
                              <?php
                            } ?>>
                            <?=$bariscb['comtab_nm']; ?>
                          </option>
                          <?php
                        } ?>

                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Masa Asuransi </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="masa" name="masa" min="0" max="500" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['masa']; ?>"> </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Mulai Asuransi </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="date" id="mulai" name="mulai" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['mulai']; ?>"> </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Akhir Asuransi </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" id="akhir" name="akhir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['akhir']; ?>"> </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> UP </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="up" name="up" readonly class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['up'], 0); ?>"> </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Premi </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="premi" name="premi" readonly class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['premi'], 0); ?>"> </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Extra Premi </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" id="epremi" name="epremi" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo number_format($r['epremi'], 0); ?>"> </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Catatan </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="subject" rows="5" class="textbox" id="subject" style='width: 98%;'>
                                      <?php echo htmlspecialchars(stripslashes($ssubject)); ?>
                                    </textarea>
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
                                      <?php $sqld = "SELECT a.* from  ";
                                      $sqld = $sqld . " tr_document a  where regid='$sid' ";
                                      $query = $db->query($sqld);
                                      $num = $query->num_rows;
                                      $no = 1;
                                      while ($r = $query->fetch_array())
                                      { ?>
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
                                            <th> <a href="<?php echo $r['file'] ?>" target="pdf-frame" class="btn btn-sm btn-default"><i class="fa fa-file-pdf-o"></i> Document</a> </th>
                                          </tr>
                                          <?php $no++;
                                        } ?>

                                        </tbody>
                                      </table>
                                    </div>
                                    <div id="tabel_photo">
                                      <table class="table table-bordered">
                                        <tbody>
                                          <?php $sqld = "SELECT a.* from  ";
                                          $sqld = $sqld . " tr_document a  where regid='$sid'  ";
                                          $query = $db->query($sqld);
                                          $num = $query->num_rows;
                                          $no = 1;
                                          while ($r = $query->fetch_array())
                                          {
                                            $sphoto = $r['file']; ?>
                                            <tr>
                                              <td> <img src="<?php echo $sphoto; ?>" alt="Avatar" style="high:30;width:30%;float:left;margin-right:10px;"> </td>
                                            </tr>
                                            <?php $no++;
                                          } ?>

                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <div class="ln_solid"></div>
                                  <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                      <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=checker'"><i class="fa fa-arrow-left"></i> Back</button>
                                      <button type="submit" class="btn btn-sm btn-default">Submit</button>
                                    </div>
                                  </div>
                                </div>
                              </form>
                              <script>
                                $(document).ready(function() {
                                  $('#demo-form2').submit(function() {
                                    if ($.trim($("#nopeserta").val()) === "" || $.trim($("#nopeserta").val()) === "TBA") {
                                      window.scrollTo(0, 0);
                                      $('#nopeserta').select();
                                      Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: 'Harap mengisi Nomor Pinjaman!'
                                      }) return false;
                                    }
                                  })
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
              <?php	break;}	?>
