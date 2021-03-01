<script>
	$(document).ready(function(){
		$("#form_add").css("display","none");
		$("#add").click(function(){
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
                    url: "modul/mod_clmhist/cari.php",
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

$aksi="modul/mod_polhist/aksi_polhist.php";
$judul="Log";
$userid=$_SESSION['idLog'];
switch(isset($_GET['act'])){
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
                <div class="col-md-6 col-sm-6 col-xs-12">

                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" required="required" class="form-control" placeholder="Search" id="txtcari">
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
                                <form action="<?php echo $aksi."?module=add" ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Code
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input name="code" type="text" id="code" required="required" class="form-control col-md-7 col-xs-12">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Deskripsi
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input name="desk" type="text" id="desk" required="required" class="form-control col-md-7 col-xs-12">
                                        </div>

                                    </div>

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
                <div style="width:100%;overflow-x:auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code </th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
								$query=mysql_query("SELECT * from ms_master where mstype='CAB' order by msid ASC LIMIT $posisi,$batas");
								$num=mysql_num_rows($query);
								$no=1;
								while($r=mysql_fetch_array($query)){
								
							?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $r['msid']; ?></td>
                                <td><?php echo $r['msdesc']; ?></td>
                                <th>
                                    <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="View" onclick="window.location='media.php?module=mscab&&act=update&&id=<?php echo $r['msid']; ?>'"><i class="fa fa-search"></i> Edit</button>
                                    <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="window.location='<?php echo $aksi."?module=delete&&id=".$r['msid']; ?>'"><i class="fa fa-trash"></i> Delete</button>
                                </th>
                            </tr>
                            <?php
								$no++;
								}
							?>
                        </tbody>
                    </table>
                </div>
                <?php
					$jmldata=mysql_num_rows(mysql_query("SELECT * from ms_master where mstype='CAB'  "));
					$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
					$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman); 
					echo "$linkHalaman";
				?>
            </div>
        </div>
    </div>
</div>
<?php
break;

case "update":
$id     = $_GET['id'];
$type   = $_GET['type'];

$query=mysql_query("SELECT a.*  FROM tr_sppa a where a.regid='$id'");
$r=mysql_fetch_array($query);
$detail=$r['detail'];
$regid = $r['regid'];
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
                        <h2>View <small><?php echo $r['regclaim']; ?></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=update"; ?>">
                            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No Peserta
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="desk" name="nama" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['regid']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="desk" name="nama" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['nama']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Mulai
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="mulai" name="mulai" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['mulai']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Tgl Akhir
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="akhir" name="akhir" readonly required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $r['akhir']; ?>">
                                </div>
                            </div>
                            <select class="select2_single col-md-3 col-sm-3 col-xs-12" id="select-jenis" name="select-jenis">
                                <?php
                                    $sql = "SELECT msid,msdesc FROM ms_master WHERE mstype='LOGTYPE' ORDER BY msdesc ASC";
                                    $query = mysql_query($sql);
                                    while ($row = mysql_fetch_array($query)) {
                                ?>
                                    <option value="<?=$row['msid'];?>"><?=$row['msdesc'];?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <div style="width:100%;overflow-x:auto;">
                                <table class="table table-bordered" id="table-log">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Status </th>
                                            <th>User</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($type == 'LTPGJ') {
                                                $status = "NOT IN ( '7','71','72','73',
                                                                    '8','81','82','83','84','85',
                                                                    '90','91','92','93','94','95','96' )";
                                            } elseif ($type == 'LTBTL') {
                                                $status = "IN ( '7','71','72','73' )";
                                            } elseif ($type == 'LTRFN') {
                                                $status = "IN ( '8','81','82','83','84','85' )";
                                            } elseif ($type == 'LTCLM') {
                                                $status = "IN ( '90','91','92','93','94','95','96' )";
                                            } else {
                                                $status = "LIKE '%%'";
                                            }
                                            
											$sqll=" SELECT     a.regid,
                                                               a.status,
                                                               a.comment,
                                                               a.createdt,
                                                               a.createby,
                                                               b.msdesc statpol
                                                    FROM       tr_sppa_log a
                                                    INNER JOIN ms_master b
                                                    ON         a.status=b.msid
                                                    AND        b.mstype='STREQ'
                                                    WHERE      a.regid='$id'
                                                    AND        status $status
                                                    ORDER BY   a.createdt DESC ";
											/* echo $sqll; */
											$query=mysql_query($sqll);
											$num=mysql_num_rows($query);
											while($r=mysql_fetch_array($query)){
										?>
                                        <tr>
                                            <td><?php echo $r['status']; ?></td>
                                            <td><?php echo $r['statpol']; ?></td>
                                            <td><?php echo $r['createby']; ?></td>
                                            <td><?php echo $r['createdt']; ?></td>
                                            <td><?php echo $r['comment']; ?></td>
                                        </tr>
                                        <?php
    										}
										?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="history.back(-1)"><i class="fa fa-arrow-left"></i> Back</button>
                                </div>
                            </div>
                        </form>
                        <script>
                            $(document).ready(function(){
                                if ('<?=$type;?>' == '') {
                                    $('#select-jenis').val('LTALL').change();
                                } else {
                                    $('#select-jenis').val('<?=$type;?>').change();
                                }
                                $('#select-jenis').change(function(){
                                    var val = $(this).val();
                                    $.ajax({
                                        url: "<?=$aksi;?>?module=ganti-log&&jenis="+val+"&&id=<?=$regid;?>",
                                        success: function(data){
                                            $('#table-log tbody').empty();
                                            $('#table-log tbody').append(data);
                                        }
                                    })
                                })
                            })
                        </script>
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