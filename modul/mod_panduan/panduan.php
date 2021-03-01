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
		   if (strcari != ""  )
		   {
		   $("#tabel_awal").css("display", "none");

			$("#hasil").html("<img src='images/loader.gif'/>")
			$.ajax({
			 type:"post",
			 url:"modul/mod_doc/cari.php",
			 data:"q="+ strcari,
			 success: function(data){
			 $("#hasil").css("display", "block");
			  $("#hasil").html(data);
			  
			 }
			});
		   }
		   else{
		   $("#hasil").css("display", "none");
		   $("#tabel_awal").css("display", "block");
		   }
		  });
			});
	</script>
<?php	
$aksi="modul/mod_panduan/aksi_panduan.php";
$iddata=$_GET['eid'];
$judul="Panduan";
$sid=$_GET['id'];
$vlevel=$_SESSION['idLevel'];
date_default_timezone_set('Asia/Jakarta');


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
									<a href="media.php?module=home" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a>

									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">

                                    </div>
									<div class="row" id="form_add">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                   
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
									<form action="" method="post" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">


										
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
                                               

												<th>Modul </th>
												<th>Level</th>
												<th></th>
                                               
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
											$sqld="SELECT a.modul,a.level,a.file from  ";
											$sqld= $sqld . " tr_manual a left join ms_master b on b.msid=a.level and b.mstype='LEVEL' ";
											$sqld= $sqld . " where level ='$vlevel' "; 
											$sqld= $sqld . "  LIMIT $posisi,$batas" ;
											/* echo $sqld; */
											$query=mysql_query($sqld);
											$num=mysql_num_rows($query);
											$no=1;
											while($r=mysql_fetch_array($query)){
											
										?>
                                            <tr>
                                               

												<td><a href="<?php echo $r['modul'] ?>" target="pdf-frame"><?php echo $r['modul']; ?> </a>
												<td><?php echo $r['level']; ?></td>
												
												
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
									<?php
							$jmldata=mysql_num_rows(mysql_query("SELECT * from tr_manual "));
							$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
							$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman); 
							echo "$linkHalaman";
							
							?>
                                </div>
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