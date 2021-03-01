<style>
.bundar{
	-webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	border-radius: 50px;
}
</style>
<?php

$eid=$_SESSION['idLog'];
$userid=$_SESSION['idLog'];
$slevel=$_SESSION['idLevel'];
date_default_timezone_set("Asia/Jakarta");

			$ssql="SELECT distinct date_format(now(),'%Y')  sdate ,a.username,level FROM ms_admin a ";
			$ssql=$ssql . " where a.username='$userid'   ";
			/* echo $ssql;  */
			$query=$db->query($ssql);
			$num=$query->num_rows;
			$scond = array('mkt', 'smkt');
			$scond4 = array('smon', 'smon');
			$scond1 = array('checker', 'schecker');
			$scond2 = array('broker', 'broker');
			$scond3 = array('insurance', 'insurance');

			while($r=$query->fetch_array()){
				$username=$r['username'];
				$level=$r['level'];
				$syear=$r['sdate'];
				$sfield = $r['level'];

			}

			if ($slevel=="broker" or $slevel=="smon" )
			{
			$lsp2="Sertifikat";
			$lsp3="Realisasi";
			$ssql=" select sum(sp1) s1,sum(sp2) s2,sum(sp3) s3,sum(sp4) s4,sum(sp5) s5,sum(sp6) s6";
			$ssql=$ssql . " from  ";
			$ssql=$ssql . " ( ";
			$ssql=$ssql . " SELECT count(1) sp1,0 sp2, 0 sp3,0 sp4,0 sp5, 0 sp6 FROM tr_sppa where status in (1)  and cabang<>''  ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,count(1) sp2, 0 sp3,0 sp4,0 sp5, 0 sp6  FROM tr_sppa where status in (5)  and cabang<>'' ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, count(1)  sp3,0 sp4,0 sp5, 0 sp6   FROM tr_sppa where status in (3) and cabang<>'' ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,count(1) sp4,0 sp5,0 sp6  FROM tr_sppa where status in (10)  and cabang<>'' ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,0 sp4 ,count(1) sp5,0 sp6  FROM tr_sppa where status in (11)  and cabang<>''  ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,0 sp4 ,0 sp5,count(1) sp6  FROM tr_sppa  inner join tr_sppa_paid  on tr_sppa.regid=tr_sppa_paid.regid  where  cabang<>'' ";
			$ssql=$ssql . " ) aa ";
			}

			if ($slevel=="checker" or $level=="schecker" )
			{
			$lsp2="Active";
			$lsp3="Realisasi";
			$ssql=" select sum(sp1) s1,sum(sp2) s2,sum(sp3) s3,sum(sp4) s4,sum(sp5) s5 ,sum(sp6) s6";
			$ssql=$ssql . " from  ";
			$ssql=$ssql . " ( ";
			$ssql=$ssql . " SELECT count(1) sp1,0 sp2, 0 sp3,0 sp4,0 sp5, 0 sp6 FROM tr_sppa where status in (1)  and cabang like (select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  from ms_admin  where username='$userid' )  ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,count(1) sp2, 0 sp3,0 sp4,0 sp5, 0 sp6  FROM tr_sppa where status in (2)  and cabang like (select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  from ms_admin  where username='$userid' )  ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, count(1)  sp3,0 sp4,0 sp5, 0 sp6   FROM tr_sppa where status in (3)  and cabang like (select case when cabang='ALL' THEN '%%' ELSE cabang END cabang from ms_admin  where username='$userid' )  ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,count(1) sp4,0 sp5,0 sp6  FROM tr_sppa where status in (10,4)  and cabang like (select case when cabang='ALL' THEN '%%' ELSE cabang END cabang from ms_admin  where username='$userid' )  ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,0 sp4 ,count(1) sp5,0 sp6  FROM tr_sppa where status in (11,5)  and cabang like (select case when cabang='ALL' THEN '%%' ELSE cabang END cabang from ms_admin  where username='$userid' )  ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,0 sp4 ,0 sp5,count(1) sp6  FROM tr_sppa  inner join tr_sppa_paid  on tr_sppa.regid=tr_sppa_paid.regid   ";
			$ssql=$ssql . " where tr_sppa.cabang like (select case when cabang='ALL' THEN '%%' ELSE cabang END cabang from ms_admin  where username='$userid' )  ";
			$ssql=$ssql . " ) aa ";
			}

			if ($slevel=="insurance" )
			{
			$lsp2="Sertifikat";
			$lsp3="Realisasi";
			$ssql=" select sum(sp1) s1,sum(sp2) s2,sum(sp3) s3,sum(sp4) s4,sum(sp5) s5 ,sum(sp6) s6";
			$ssql=$ssql . " from  ";
			$ssql=$ssql . " ( ";
			$ssql=$ssql . " SELECT count(1) sp1,0 sp2, 0 sp3,0 sp4,0 sp5, 0 sp6 FROM tr_sppa where status in (1)  and asuransi in (select cabang  from ms_admin  where username='$userid' )  ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,count(1) sp2, 0 sp3,0 sp4,0 sp5, 0 sp6  FROM tr_sppa where status in (5)  and asuransi in (select cabang  from ms_admin  where username='$userid' ) ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, count(1)  sp3,0 sp4,0 sp5, 0 sp6   FROM tr_sppa where status in (3)  and asuransi in (select cabang  from ms_admin  where username='$userid' ) ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,count(1) sp4,0 sp5,0 sp6  FROM tr_sppa where status in (10)  and asuransi in (select cabang  from ms_admin  where username='$userid' ) ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,0 sp4 ,count(1) sp5,0 sp6  FROM tr_sppa where status in (11)  and asuransi in (select cabang  from ms_admin  where username='$userid' ) ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,0 sp4 ,0 sp5,count(1) sp6  FROM tr_sppa  inner join tr_sppa_paid  on tr_sppa.regid=tr_sppa_paid.regid   ";
			$ssql=$ssql . " where tr_sppa.asuransi in (select cabang  from ms_admin  where username='$userid' ) ";
			$ssql=$ssql . " ) aa ";
			}

			if ($slevel=="mkt" or $level=="smkt" )
			{
			$lsp2="Active";
			$lsp3="Realisasi";
			$ssql=" select sum(sp1) s1,sum(sp2) s2,sum(sp3) s3,sum(sp4) s4,sum(sp5) s5 ,sum(sp6) s6";
			$ssql=$ssql . " from  ";
			$ssql=$ssql . " ( ";
			$ssql=$ssql . " SELECT count(1) sp1,0 sp2, 0 sp3,0 sp4,0 sp5, 0 sp6 FROM tr_sppa where status in (1)    ";
			$ssql=$ssql . " and createby in (select  a.uname from vw_msadmin_mkt a ";
			$ssql=$ssql . " where a.username='$userid' or a.parent='$userid') ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,count(1) sp2, 0 sp3,0 sp4,0 sp5, 0 sp6  FROM tr_sppa where status in (2)   ";
			$ssql=$ssql . " and createby in (select  a.uname from vw_msadmin_mkt a ";
			$ssql=$ssql . " where a.username='$userid' or a.parent='$userid') ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, count(1)  sp3,0 sp4,0 sp5, 0 sp6   FROM tr_sppa where status in (3) ";
			$ssql=$ssql . " and createby in (select  a.uname from vw_msadmin_mkt a ";
			$ssql=$ssql . " where a.username='$userid' or a.parent='$userid') ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,count(1) sp4,0 sp5,0 sp6  FROM tr_sppa where status in (10,4)  ";
			$ssql=$ssql . " and createby in (select  a.uname from vw_msadmin_mkt a ";
			$ssql=$ssql . " where a.username='$userid' or a.parent='$userid') ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,0 sp4 ,count(1) sp5,0 sp6  FROM tr_sppa where status in (11,5)   ";
			$ssql=$ssql . " and createby in (select  a.uname from vw_msadmin_mkt a ";
			$ssql=$ssql . " where a.username='$userid' or a.parent='$userid') ";
			$ssql=$ssql . " union  ";
			$ssql=$ssql . " SELECT  0 sp1,0 sp2, 0 sp3,0 sp4 ,0 sp5,count(1) sp6  FROM tr_sppa a inner join tr_sppa_paid  b on a.regid=b.regid   ";
			$ssql=$ssql . " and a.createby in (select  a.uname from vw_msadmin_mkt a ";
			$ssql=$ssql . " where a.username='$userid' or a.parent='$userid') ";
			$ssql=$ssql . " ) aa ";
			}
			/* echo $ssql;    */
			$query=$db->query($ssql);

			while($r=$query->fetch_array()){

				$sp1=$r['s1'];
				$sp2=$r['s2'];
				$sp3=$r['s3'];
				$sp4=$r['s4'];
				$sp5=$r['s5'];
				$sp6=$r['s6'];               

			}
			
function potongAngka($n, $precision = 2) {
    if ($n > 100000000) {
        $n_format = number_format($n / 1000000000, $precision);
    } else {
        $n_format = 0;
    }
    return $n_format;
}
?>

<script>
    function potongAngka (labelValue) {
        return Math.abs(Number(labelValue)) >= 1.0e+9
        ? (Math.abs(Number(labelValue)) / 1.0e+9).toFixed(2)
        : 0
    }
    function updateChart(chart, data) {
        chart.data.datasets[0].data = data;
        chart.update();
    }
    $(document).ready(function(){
        <?php
    	    // Cek Notifikasi Pribadi
    	    $sqlNotif1 = "SELECT * FROM `tbl_push_notif` WHERE level='$idLevel' AND cabang='$idCabang' AND username='$idLog' AND '".date('Y-m-d')."' BETWEEN `tgl_mulai` and `tgl_selesai`";
    	    $resNotif = $db->query($sqlNotif1);
    	    while ($rowNotif = $resNotif->fetch_assoc()) {
    	        $pesan = explode("-",$rowNotif['pesan']);
    	        echo "new PNotify({
                        title: '$pesan[1]',
                        text: '$pesan[2]',
                        type: '$pesan[0]',
                        hide: false,
                        styling: 'bootstrap3'
                    });";
    	    }
    	    
    	    //Cek Notifikasi ALL
    	    $sqlNotif2 = "SELECT * FROM `tbl_push_notif` WHERE level='ALL' AND cabang='ALL' AND username='ALL' AND '".date('Y-m-d')."' BETWEEN `tgl_mulai` and `tgl_selesai`";
    	    $resNotif = $db->query($sqlNotif2);
    	    while ($rowNotif = $resNotif->fetch_assoc()) {
    	        $pesan = explode("-",$rowNotif['pesan']);
    	        echo "new PNotify({
                        title: '$pesan[1]',
                        text: '$pesan[2]',
                        type: '$pesan[0]',
                        hide: false,
                        styling: 'bootstrap3'
                    });";
    	    }
    	   // echo $sqlNotif1."<br>".$sqlNotif2;
    	?>
    })
</script>
    <div class="right_col" role="main">
        <!-- top tiles -->
        <div class="row tile_count">
            <div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                <div class="left"></div>
                <div class="right">
                    <span class="count_top"><i class="fa fa-clock-o"></i>Approve </span>
                    <div class="count">
                        <?php

							echo $sp1;
							?>

                    </div>

                </div>
            </div>

            <div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                <div class="left"></div>
                <div class="right">
                    <span class="count_top"><i class="fa fa-book"></i> Verifikasi							
							</span>
                    <div class="count blue">
                        <?php
							echo $sp4;
							?>
                    </div>

                </div>
            </div>

            <div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                <div class="left"></div>
                <div class="right">
                    <span class="count_top"><i class="fa fa-check-square"></i> Validasi							
							</span>
                    <div class="count red">
                        <?php
							echo $sp5;
							?>
                    </div>

                </div>
            </div>

            <div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                <div class="left"></div>
                <div class="right">
                    <span class="count_top"><i class="fa fa-search"></i> 							
							<?php
							echo $lsp2;
							?> </span>
                    <div class="count green">
                        <?php

							echo $sp2;
							?>
                    </div>

                </div>
            </div>

            <div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                <div class="left"></div>
                <div class="right">
                    <span class="count_top"><i class="fa fa-briefcase"></i> 
							<?php
							echo $lsp3;
							?>				
							</span>
                    <div class="count">
                        <?php
							echo $sp3;
							?>
                    </div>

                </div>
            </div>

            <div class="animated flipInY col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                <div class="left"></div>
                <div class="right">
                    <span class="count_top"><i class="fa fa-money"></i> Paid							
							</span>
                    <div class="count red">
                        <?php
							echo $sp6;
							?>
                    </div>

                </div>
            </div>
        </div>
        <!-- /top tiles -->
        
        <?php if (in_array($sfield, $scond2, TRUE)): ?>                         <!-- Target Premi dan Status Asuransi -->
        <div class="clearfix"></div>
        <div class="row">
            <?php
                    if (!isset($_GET['bulannya'])) {
                        $bulannya = date('Y-m');   // bulan sekarang, kalo di demo hasilnya etiqa doang 1
                        // $bulannya = '2020-03';    
                    } else {
                        $bulannya = $_GET['bulannya'];
                    }
                    $target = 15000000000;
                
				?>
				<div class="col-md-4 col-sm-4">                                 <!-- Target Sertifikat Perbulan -->
					<div class="x_panel">
                        <div class="x_title">
                            <h2>Target Premi</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="" style="width:100%">
                                <tr>
                                    <th style="width:37%;">
                                        <p>Premi</p>
                                    </th>
                                    <th>
                                        <div class="col-lg-5 col-md5 col-sm-5 ">
                                            <p class="">Nominal</p>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 " style="text-align:right" >
                                            <p class="pull-right">Mil</p>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <canvas id="canvasPremi" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                                    </td>
                                    <td>
                                        <table class="tile_info">
                                            <tr>
                                                <td>
                                                    <p id="text-target"><i class="fa fa-bullseye" style="color:#ff0000"></i>Target<span class="loader__dot"> .</span><span class="loader__dot"> .</span><span class="loader__dot"> .</span></p>
                                                </td>
                                                <td style="text-align:right" id="val-target">
                                                    <?=potongAngka($target);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square" style="color:#3498DB"></i>Saat Ini </p>
                                                </td>
                                                <i id="hidden-premi" style="display:none;"></i>
                                                <td style="text-align:right" id="val-today">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p id="text-sisa-target"><i class="fa fa-square" style="color:#BDC3C7"></i>Sisa Target </p>
                                                </td>
                                                <td style="text-align:right" id="val-sisa">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
					<script>
						var settingsChartTarget = {
							type: 'doughnut',
							tooltipFillColor: "rgba(51, 51, 51, 0.55)",
							data: {
								labels: [
    								"Melebihi Target",
    								"Saat Ini",
    								"Sisa Target"
								],
								datasets: [{
									data: [''],
									backgroundColor: [
    									"#27e566",
    									"#3498DB",
    									"#BDC3C7"
									],
									hoverBackgroundColor: [
    									"#29f469",
    									"#4fb4f7",
    									"#CFD4D8"
									]
								}]
							},
							options: {
								legend: false,
								responsive: false,
								tooltips: {
									callbacks: {
										label: function(tooltipItem, data) {
											var dataset = data.datasets[tooltipItem.datasetIndex];
											var currentValue = dataset.data[tooltipItem.index];
											return "Rp. "+currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
										}
									}
								}
							}
						}

						var chartPremi = new Chart($('#canvasPremi'), settingsChartTarget);
						
						$(document).ready(function(){
						    function refreshPremi() {
						        var prevPremi = parseInt($('#hidden-premi').text());
						        $.ajax({
						            url: "modul/mod_home/premi_bulanan.php",
						            data: "bulannya=<?=$bulannya;?>",
						            type: "post",
						            success: function(data){
						                data = parseInt(JSON.parse(data));
						                if (data !== null) {
						                    if (prevPremi !== data) {
						                        $('#hidden-premi').text(data);
						                        
						                        if (data > <?=$target;?>) {
						                            $('#text-sisa-target').html('<i class="fa fa-flag-checkered" style="color:#27e566"></i>Melebihi Target');
                            					    $('#text-target').html('<i class="fa fa-check-circle" style="color:#27e566"></i>Target');
                            					    
                            					    var lebihPremi = data - <?=$target;?>;
                            					    var sisaPremi = 0;
                            					    var currPremi = <?=$target;?>;
						                        } else {
						                            $('#text-sisa-target').html('<i class="fa fa-square" style="color:#BDC3C7"></i>Sisa Target');
                            					    $('#text-target').html('<i class="fa fa-spinner fa-pulse" style="color:#ff0000"></i>Target');
                            					    
                            					    var lebihPremi = 0;
                            					    var sisaPremi = <?=$target;?> - data;
                            					    var currPremi = data;
						                        }
						                        
						                        $('#val-sisa').text((data > <?=$target;?>)?(potongAngka(lebihPremi)):(potongAngka(sisaPremi)));
						                        $('#val-today').text(potongAngka(currPremi+lebihPremi));
						                        
						                        var dataChartPremi = [lebihPremi,currPremi,sisaPremi];
						                        
						                        updateChart(chartPremi,dataChartPremi);
						                    }
						                }
						            }
						        })
						    }
						    refreshPremi();
						    
						})
						
					</script>
				</div>
            
				<div class="col-md-4 col-sm-4">                                 <!-- Target Sertifikat Perbulan -->
					<div class="x_panel">
                        <div class="x_title">
                            <h2>Jumlah Sertifikat</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="" style="width:100%">
								<tr>
									<th style="width:37%;">
										<p>Sertifikat</p>
									</th>
									<th>
										<div class="col-lg-9 col-md-9 col-sm-9 ">
											<p class="">Asuransi</p>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 " style="text-align:right" >
											<p class="fa fa-percent"></p>
										</div>
									</th>
								</tr>
								<tr>
									<td>
										<canvas id="canvasSertifikat" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
									</td>
									<td>
										<table class="tile_info">
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#FFC20E"></i>Etiqa </p>
												</td>
												<td style="text-align:right" id="perc-eti">
                                                </td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#FF6C0C"></i>MPM </p>
												</td>
												<td style="text-align:right" id="perc-mpm">
                                                </td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#BDC3C7"></i>TKP </p>
												</td>
												<td style="text-align:right" id="perc-tkp">
                                                </td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
                        </div>
                    </div>
					<script>
						var settingChartSertifikat = {
							type: 'doughnut',
							tooltipFillColor: "rgba(51, 51, 51, 0.55)",
							data: {
								labels: [
								"Etiqa",
								"Mitra Pelindung Mustika",
								"Tugu Kresna Pratama"
								],
								datasets: [{
									data: [''],
									backgroundColor: [
									"#FFC20E",
									"#FF6C0C",
									"#BDC3C7"
									],
									hoverBackgroundColor: [
									"#ffcc42",
									"#ff904c",
									"#CFD4D8"
									]
								}]
							},
							options: {
								legend: false,
								responsive: false,
								tooltips: {
									callbacks: {
										label: function(tooltipItem, data) {
											var dataset = data.datasets[tooltipItem.datasetIndex];
											var currentValue = dataset.data[tooltipItem.index];
											return currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " Sertifikat";
										}
									}
								}
							}
						}
						var chartSertifikat = new Chart($('#canvasSertifikat'), settingChartSertifikat);
						
						$(document).ready(function(){
						    function refreshSertifikat() {
						        var percETI = $('#perc-eti').text(),
						            percMPM = $('#perc-mpm').text(),
						            percTKP = $('#perc-tkp').text();
						        $.ajax({
						            url: "modul/mod_home/sertifikat_bulanan.php",
						            data: "bulannya=<?=$bulannya;?>",
						            type: "post",
						            success: function(data) {
						                data = JSON.parse(data);
						                if (data !== null) {
						                    if (data.persen[0] !== percETI && data.persen[0] !== undefined && data.persen[0] !== null) {
						                        $('#perc-eti').text(data.persen[0]);
						                        updateChart(chartSertifikat,data.sertifikat);
						                    }
						                    if (data.persen[1] !== percMPM && data.persen[1] !== undefined && data.persen[1] !== null) {
						                        $('#perc-mpm').text(data.persen[1]);
						                        updateChart(chartSertifikat,data.sertifikat);
						                    }
						                    if (data.persen[2] !== percTKP && data.persen[2] !== undefined && data.persen[2] !== null) {
						                        $('#perc-tkp').text(data.persen[2]);
						                        updateChart(chartSertifikat,data.sertifikat);
						                    }
						                }
						            }
						        })
						    }
						    refreshSertifikat();
						})
					</script>
				</div>
				
				<div class="col-md-4 col-sm-4">                                 <!-- Data Broker -->
					<div class="x_panel">
                        <div class="x_title">
                            <h2>Data Broker</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="" style="width:100%">
								<tr>
									<th style="width:37%;">
										<p>Yang Dikerjakan</p>
									</th>
									<th>
										<div class="col-lg-9 col-md-9 col-sm-9 ">
											<p class="">Broker</p>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 " style="text-align:right" >
											<p class="fa fa-percent"></p>
										</div>
									</th>
								</tr>
								<tr>
									<td>
										<canvas id="canvasBroker" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
									</td>
									<td>
										<table class="tile_info">
											<tr>
												<td>
													<p><i class="fa fa-user" style="color:#badc58"></i>Bayu </p>
												</td>
												<td style="text-align:right" id="perc-bayu">
                                                </td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-user" style="color:#7ed6df"></i>Dinda </p>
												</td>
												<td style="text-align:right" id="perc-dinda">
                                                </td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-user" style="color:#ff7979"></i>Tony </p>
												</td>
												<td style="text-align:right" id="perc-tony">
                                                </td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-user" style="color:#ffbe76"></i>Fanur </p>
												</td>
												<td style="text-align:right" id="perc-fanur">
                                                </td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-user" style="color:#686de0"></i>Nindy </p>
												</td>
												<td style="text-align:right" id="perc-nindy">
                                                </td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-user" style="color:#8e44ad"></i>Zyah </p>
												</td>
												<td style="text-align:right" id="perc-zyah">
                                                </td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
                        </div>
                    </div>
					<script>
						var settingChartBroker = {
							type: 'doughnut',
							tooltipFillColor: "rgba(51, 51, 51, 0.55)",
							data: {
								labels: [
								"Bayu",
								"Dinda",
								"Tony",
								"Fanur",
								"Nindy",
								"Zyah"
								],
								datasets: [{
									data: [''],
									backgroundColor: [
									"#badc58",
									"#7ed6df",
									"#ff7979",
									"#ffbe76",
									"#686de0",
									"#8e44ad",
									],
									hoverBackgroundColor: [
									"#b0e01f",
									"#87e9f2",
									"#ff9191",
									"#ffc384",
									"#757cf9",
									"#ab58ce",
									]
								}]
							},
							options: {
								legend: false,
								responsive: false,
								tooltips: {
									callbacks: {
										label: function(tooltipItem, data) {
											var dataset = data.datasets[tooltipItem.datasetIndex];
											var currentValue = dataset.data[tooltipItem.index];
											return data.labels[tooltipItem.index] + ": " + currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " Nasabah";
										}
									}
								}
							}
						}
						var chartBroker = new Chart($('#canvasBroker'), settingChartBroker);
						
						$(document).ready(function(){
						    function refreshBroker() {
						        var percBayu = $('#perc-bayu').text(),
						            percDinda = $('#perc-dinda').text(),
						            percTony = $('#perc-tony').text(),
						            percFanur = $('#perc-fanur').text(),
						            percNindy = $('#perc-nindy').text(),
						            percZyah = $('#perc-zyah').text();
						        $.ajax({
						            url: "modul/mod_home/broker_bulanan.php",
						            data: "bulannya=<?=$bulannya;?>",
						            type: "post",
						            success: function(data) {
						                data = JSON.parse(data);
						                if (data !== null) {
						                    if (data.persen[0] !== percBayu && data.persen[0] !== undefined && data.persen[0] !== null) {
						                        $('#perc-bayu').text(data.persen[0]);
						                        updateChart(chartBroker,data.jumlah);
						                      //  console.log(data.persen[0] + " = " + percBayu);
						                    }
						                    if (data.persen[1] !== percDinda && data.persen[1] !== undefined && data.persen[1] !== null) {
						                        $('#perc-dinda').text(data.persen[1]);
						                        updateChart(chartBroker,data.jumlah);
						                      //  console.log(data.persen[1] + " = " + percDinda);
						                    }
						                    if (data.persen[2] !== percTony && data.persen[2] !== undefined && data.persen[2] !== null) {
						                        $('#perc-tony').text(data.persen[2]);
						                        updateChart(chartBroker,data.jumlah);
						                      //  console.log(data.persen[2] + " = " + percTony);
						                    }
						                    if (data.persen[3] !== percFanur && data.persen[3] !== undefined && data.persen[3] !== null) {
						                        $('#perc-fanur').text(data.persen[3]);
						                        updateChart(chartBroker,data.jumlah);
						                      //  console.log(data.persen[3] + " = " + percFanur);
						                    }
						                    if (data.persen[4] !== percNindy && data.persen[4] !== undefined && data.persen[4] !== null) {
						                        $('#perc-nindy').text(data.persen[4]);
						                        updateChart(chartBroker,data.jumlah);
						                      //  console.log(data.persen[4] + " = " + percNindy);
						                    }
						                    if (data.persen[5] !== percZyah && data.persen[5] !== undefined && data.persen[5] !== null) {
						                        $('#perc-zyah').text(data.persen[5]);
						                        updateChart(chartBroker,data.jumlah);
						                      //  console.log(data.persen[5] + " = " + percZyah);
						                    }
						                    
						                }
						            }
						        })
						    }
						    refreshBroker();
						})
					</script>
				</div>
            
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-line-chart"></i> Grafik Premi dan Sertifikat</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <input id="range-grafik" style="position:absolute;top:15px;right:80px;z-index:1;text-indent:10px;width:200px;" type="text" placeholder="Pilih Periode.." class="bundar date-range-input">
                    <select id="tipe-grafik" style="position:absolute;top:15px;right:300px;z-index:1;width:150px;;text-indent:4px;height:25px;" class="bundar">
                        <option selected value="bulan">Bulanan</option>
                        <option value="minggu">Mingguan</option>
                        <option value="hari">Harian</option>
                    </select>
                    <input id="tgl-mulai" name="tgl-mulai" type="date" hidden>
                    <input id="tgl-selesai" name="tgl-selesai" type="date" hidden>
                    <div class="x_content">
                        <canvas id="myChart" height="400" style="width:100%;height:auto;"></canvas>
                    </div>
                </div>
            </div>
            <script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var chartGrafik = new Chart(ctx, {
                    type: 'line',
                    data: {
                        datasets: [{
                            data: [''],
                            backgroundColor: 'rgba(56,111,148,0)',
                            borderColor: '#3498DB',
                            pointBackgroundColor: '#3498DB',
                            pointBorderColor: '#3498DB',
                            label: "Premi",
                            pointStyle: 'rectRounded'
                        },
                        
                        {
                            data: [''],
                            backgroundColor: 'rgba(46,204,112,0)',
                            borderColor: '#FFC20E',
                            pointBackgroundColor: '#FFC20E',
                            pointBorderColor: '#FFC20E',
                            label: "Sertifikat",
                            pointStyle: 'rectRounded'
                        }]
                    },
                    options: {
                        responsive: false,
                        layout: {
                            padding: {
                                top: 12,
                                left: 12,
                                bottom: 12,
                            },
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    borderDash: [],
                                },
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                    
                            yAxes: [{
                                gridLines: {
                                    borderDash: [],
                                },
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    }
                                }
                            }],
                        },
                        legend: {
                            labels: {
                                usePointStyle: true
                             }
                        },
                        elements: {
                            arc: {},
                            point: {
                                radius: 5,
                                borderWidth: 1,
                            },
                            line: {
                                tension:0.4,fill:false,borderDash:[4,4],borderWidth:3,
                            },
                            rectangle: {},
                        },
                        tooltips: {
                            callbacks: {
								label: function(tooltipItem, data) {
								    var dataset = data.datasets[tooltipItem.datasetIndex];
									var currentValue = dataset.data[tooltipItem.index];
								    if (tooltipItem.datasetIndex === 0) {
                                        return "Rp. "+currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    } else if (tooltipItem.datasetIndex === 1) {
                                        return currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " Sertifikat";
                                    }
								}
							}
                        },
                        hover: {
                            mode: 'nearest',
                            animationDuration: 400,
                        },
                    }
                });
                $(document).ready(function(){
                    $('#range-grafik').val('Periode 3 Bulan Terakhir..');
                    function updateGrafik(chart, label, data1, data2) {
                        chart.data.labels.pop();
                        chart.data.labels = label
                        chart.data.datasets[0].data = data1;
                        chart.data.datasets[1].data = data2;
                        chart.update();
                    }
                    
                    function removeChartData(chart) {
                        chart.data.labels.pop();
                        chart.data.datasets.forEach((dataset) => {
                            dataset.data.pop();
                        });
                        chart.update();
                    }
					$('.date-range-input').keydown(function() {
						return false;
					});

					var start = moment().subtract(3, 'month').startOf('month');
                    var end = moment();
                
                    function cb(start, end) {
                        $('#tgl-mulai').val(start.format('YYYY-MM-DD'));
                        $('#tgl-selesai').val(end.format('YYYY-MM-DD'));
                        var tipeGrafik = $('#tipe-grafik option:selected').val();
                        var datanya = "aRange="+start.format('YYYY-MM-DD')+"&&bRange="+end.format('YYYY-MM-DD')+"&&tipe="+tipeGrafik;
                        console.log('Datanya', datanya);
                        $.ajax({
                            url: "modul/mod_home/grafik_premi.php",
                            data: datanya,
                            type: 'GET',
                            success: function(data){
                                data = JSON.parse(data);
                                if (data !== null) {
                                    if (data.label == null || data.premi == null || data.sertifikat == null) {
                                        Swal.fire("Data Kosong","Maaf belum ada data di periode tersebut","warning").then(
                                        (result) => {
                                            $('#range-grafik').val('');
                                            $('#range-grafik').click();   
                                        });
                                    } else {
                                        updateGrafik(chartGrafik,data.label,data.premi,data.sertifikat);
                                    }
                                }
                            }
                        })
                    }
                
                    $('.date-range-input').daterangepicker({
                        opens: 'left',
                        startDate: start,
                        endDate: end,
                        maxDate: moment(),
                        locale: {
                            "separator": " s/d ",
                            "applyLabel": "Terapkan",
                            "cancelLabel": "Batal",
                            "fromLabel": "Dari",
                            "toLabel": "Sampai",
                            "customRangeLabel": "Pilih Periode",
                            "daysOfWeek": [
                                "Min",
                                "Sen",
                                "Sel",
                                "Rab",
                                "Kam",
                                "Jum",
                                "Sab"
                            ],
                            "monthNames": [
                                "Januari",
                                "Februari",
                                "Maret",
                                "April",
                                "Mei",
                                "Juni",
                                "Juli",
                                "Agustus",
                                "September",
                                "Oktober",
                                "November",
                                "Desember"
                            ],
                            "firstDay": 1
                        },
                        ranges: {
                           'Hari Ini': [moment(), moment()],
                           'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                           'Seminggu Yang Lalu': [moment().subtract(6, 'days'), moment()],
                           'Sebulan Yang Lalu': [moment().subtract(29, 'days'), moment()],
                           'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                           'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        }
                    }, cb);
                
                    $('#tipe-grafik').on('change', function() {
                        var dateAwal = new Date($('#tgl-mulai').val());
                        var dateAkhir = new Date($('#tgl-selesai').val());
                        var momentAwal = moment(dateAwal);
                        var momentAkhir = moment(dateAkhir);
                        cb(momentAwal,momentAkhir);
                    });
                    
                    cb(start, end);
                    
                    $('.date-range-input').on('cancel.daterangepicker', function(ev, picker) {
                        $('#tgl-mulai').val('');
                        $('#tgl-selesai').val('');
                        $(this).val('');
                    });
				});
            </script>
        </div>
        <?php endif; ?>

        <div class="clearfix"></div>
        <?php if ($slevel !== "broker"): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-dashboard"></i> SIAP <small><?=$r['level'];?></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="col-md-6 col-lg-6 col-sm-5">
                            <div class="x_content">
                                <ul class="list-unstyled timeline">
                                    <?php if (in_array($sfield, $scond, TRUE)): ?>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=ajuan" class="tag">
                                                        <span>Pengajuan</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a>Pengajuan </a>
                                                    </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=inquiry" class="tag">
                                                        <span>Inquiry</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a>Inquiry </a>
                                                    </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array($sfield, $scond1, TRUE)): ?>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=checker" class="tag">
                                                        <span>Checker</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                                <a>Checker </a>
                                                            </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=inquiry" class="tag">
                                                        <span>Inquiry</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                                <a>Inquiry </a>
                                                            </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (in_array($sfield, $scond2, TRUE)): ?>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=verif" class="tag">
                                                        <span>Verifikasi</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a>Verifikasi </a>
                                                    </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_array($sfield, $scond3, TRUE)): ?>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=valid" class="tag">
                                                        <span>Validasi</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                                    <a>Validasi </a>
                                                                </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=inquiriv" class="tag">
                                                        <span>Inquiry</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                                    <a>Inquiry </a>
                                                                </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (in_array($sfield, $scond4, TRUE)): ?>

                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=inquiric" class="tag">
                                                        <span>Inquiry</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                            <a>Inquiry </a>
                                                        </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=dashboard" class="tag">
                                                        <span>Dashboard</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                            <a>Dashboard </a>
                                                        </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>

                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=certificate" class="tag">
                                                        <span>Sertifikat</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a>Sertifikat </a>
                                                    </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="block">
                                                <div class="tags">
                                                    <a href="media.php?module=panduan" class="tag">
                                                        <span>Bantuan</span>
                                                    </a>
                                                </div>
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a>Bantuan</a>
                                                    </h2>
                                                    <div class="byline">
                                                        <span>&nbsp;</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-7">
                            <!-- blockquote -->
                            <blockquote>
                                <p> Sistem Informasi Asuransi Perbankan (SIAP)</p>
                                <p><b><?php echo $sempname; ?></b></p>
                                <img src="images/logo.png" alt="Avatar" style="width:30%;float:left;margin-right:10px;">
                                <br>
                                <p>Aplikasi ini berfungsi untuk Pengelolaan Asuransi Perbankan </p>
                                <p>Untuk pertanyaan dan komplain dengan menyebutkan userid tampilan layar yang dimaksud. silahkan kirim ke whatsapp no :
                                    <p> <a href="https://api.whatsapp.com/send?phone=6281224208914" target="_blank">klik untuk chat dengan 081224208914 - Dinda</a> </p>
                                    <p> <a href="https://api.whatsapp.com/send?phone=6281224208861" target="_blank">klik untuk chat dengan 081224208861 - Fanur</a> </p>
                                    <p> <a href="https://api.whatsapp.com/send?phone=628111200279" target="_blank">klik untuk chat dengan 08111200279	- Bayu</a> </p>
                                    <p> atau email ke : <a href="mailto:personal.bdspt@gmail.com">personal.bdspt@gmail.com</a> </p>

                            </blockquote>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
    </div>