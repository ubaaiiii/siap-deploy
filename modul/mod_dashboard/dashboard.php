<style>
.bundar{
	-webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	border-radius: 50px;
}
</style>
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
$aksi="modul/mod_dashboard/aksi_dashboard.php";
$iddata=$_GET['eid'];
$judul="Dashboard";
$sid=$_GET['id'];
$sdid=$_GET['did'];
date_default_timezone_set('Asia/Jakarta');

$query=mysql_query("SELECT a.*  FROM tr_sppa a WHERE regid='$sid'");
$r=mysql_fetch_array($query);
$snama=$r['nama'];
$scond = array('0','1');
$sfield = $r['status'] ;
$scond0 = array('01','01');
$sfield0= $sdid ;
$scond1 = array('23','7','8');
$sfield1= $sdid ;


$judul2=$sid." - ".$snama;
switch($_GET['act']){
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
					<div>
						<input id="range-TKP" style="position:relative;top:-5px" type="text" placeholder="Pilih Periode.." class="bundar date-range-input form-control">
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row" id="chart-filter" style="display:none;">
			    
			</div>
			<div id="chart-all">
			    <div class="row">
				<?php
					$resAsuransi = mysql_query("SELECT `asuransi`,`produk`,sum(premi) pendapatan,LEFT(`validdt`,10) tglvalid FROM `tr_sppa` WHERE `status`>=5 and `status`not in (10,11,12,13,73,83,93) group by `tglvalid`,`produk`,`asuransi`");

					while ($rowAsuransi = mysql_fetch_assoc($resAsuransi)) {
						$arrayAsuransi[] = $rowAsuransi;
					}
					//TKP
					$TKP_total = 0;
					$TKP_pens = 0;
					$TKP_mpp = 0;
					$TKP_pas = 0;
					$TKP_plat = 0;
					$TKP_pns = 0;
					//Etiqa
					$ETI_total = 0;
					$ETI_pens = 0;
					$ETI_mpp = 0;
					$ETI_pas = 0;
					$ETI_plat = 0;
					$ETI_pns = 0;
					//MPM
					$MPM_total = 0;
					$MPM_pens = 0;
					$MPM_mpp = 0;
					$MPM_pas = 0;
					$MPM_plat = 0;
					$MPM_pns = 0;

					foreach ($arrayAsuransi as $ra) {
						switch ($ra['asuransi']) {
							case 'TKP':
								$TKP_total += $ra['pendapatan'];
								switch ($ra['produk']) {
									case 'PR01':
										$TKP_pens += $ra['pendapatan'];
										break;
									case 'PL01':
										$TKP_plat += $ra['pendapatan'];
										break;
									case 'MP01':
										$TKP_mpp += $ra['pendapatan'];
										break;
									case 'PS01':
										$TKP_pas += $ra['pendapatan'];
										break;
									default:
										$TKP_pns += $ra['pendapatan'];
										break;
								}
								break;

							case 'ETI':
								$ETI_total += $ra['pendapatan'];
								switch ($ra['produk']) {
									case 'PR01':
										$ETI_pens += $ra['pendapatan'];
										break;
									case 'PL01':
										$ETI_plat += $ra['pendapatan'];
										break;
									case 'MP01':
										$ETI_mpp += $ra['pendapatan'];
										break;
									case 'PS01':
										$ETI_pas += $ra['pendapatan'];
										break;
									default:
										$ETI_pns += $ra['pendapatan'];
										break;
								}
								break;

							default:
								$MPM_total += $ra['pendapatan'];
								switch ($ra['produk']) {
									case 'PR01':
										$MPM_pens += $ra['pendapatan'];
										break;
									case 'PL01':
										$MPM_plat += $ra['pendapatan'];
										break;
									case 'MP01':
										$MPM_mpp += $ra['pendapatan'];
										break;
									case 'PS01':
										$MPM_pas += $ra['pendapatan'];
										break;
									default:
										$MPM_pns += $ra['pendapatan'];
										break;
								}
								break;
						}
					}

					$dataProdukTKP = array($TKP_mpp,$TKP_pas,$TKP_pens,$TKP_plat,$TKP_pns);
					$dataProdukETI = array($ETI_mpp,$ETI_pas,$ETI_pens,$ETI_plat,$ETI_pns);
					$dataProdukMPM = array($MPM_mpp,$MPM_pas,$MPM_pens,$MPM_plat,$MPM_pns);

					$jsProdukTKP = json_encode($dataProdukTKP);
					$jsProdukETI = json_encode($dataProdukETI);
					$jsProdukMPM = json_encode($dataProdukMPM);

				?>
				<div class="col-md-4 col-sm-4 mt-3">
					<div class="x_panel tile fixed_height_320 overflow_hidden">
						<div class="x_title">
							<h2>Tugu Kresna Pratama</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<table class="" style="width:100%">
								<tr>
									<th style="width:37%;">
										<p>Rp. <?=number_format($TKP_total, 0, ',', '.');?></p>
									</th>
									<th>
										<div class="col-lg-9 col-md-9 col-sm-9 ">
											<p class="">Produk</p>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 ">
											<p class="fa fa-percent"></p>
										</div>
									</th>
								</tr>
								<tr>
									<td>
										<canvas id="canvasTKP" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
									</td>
									<td>
										<table class="tile_info">
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#BDC3C7"></i>MPP </p>
												</td>
												<td><?=number_format($TKP_mpp/$TKP_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#9B59B6"></i>Pasangan </p>
												</td>
												<td><?=number_format($TKP_pas/$TKP_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#E74C3C"></i>Pensiun Reguler </p>
												</td>
												<td><?=number_format($TKP_pens/$TKP_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#26B99A"></i>Platinum </p>
												</td>
												<td><?=number_format($TKP_plat/$TKP_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#3498DB"></i>PNS </p>
												</td>
												<td><?=number_format($TKP_pns/$TKP_total*100, 1, ',', '');?></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<script>
					var dataTKP = <?=$jsProdukTKP;?>;
				// 	console.log(dataTKP);
						var chart_doughnut_settings = {
							type: 'doughnut',
							tooltipFillColor: "rgba(51, 51, 51, 0.55)",
							data: {
								labels: [
								"MPP",
								"Pasangan",
								"Pensiun Reguler",
								"Platinum",
								"PNS"
								],
								datasets: [{
									data: dataTKP,
									backgroundColor: [
									"#BDC3C7",
									"#9B59B6",
									"#E74C3C",
									"#26B99A",
									"#3498DB"
									],
									hoverBackgroundColor: [
									"#CFD4D8",
									"#B370CF",
									"#E95E4F",
									"#36CAAB",
									"#49A9EA"
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

						var chart_doughnut = new Chart($('#canvasTKP'), chart_doughnut_settings);
						
					</script>
				</div>

				<div class="col-md-4 col-sm-4 mt-3">
					<div class="x_panel tile fixed_height_320 overflow_hidden">
						<div class="x_title">
							<h2>Etiqa</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<table class="" style="width:100%">
								<tr>
									<th style="width:37%;">
										<p>Rp. <?=number_format($ETI_total, 0, ',', '.');?></p>
									</th>
									<th>
										<div class="col-lg-9 col-md-9 col-sm-9 ">
											<p class="">Produk</p>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 ">
											<p class="fa fa-percent"></p>
										</div>
									</th>
								</tr>
								<tr>
									<td>
										<canvas id="canvasETI" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
									</td>
									<td>
										<table class="tile_info">
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#BDC3C7"></i>MPP </p>
												</td>
												<td><?=number_format($ETI_mpp/$ETI_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#9B59B6"></i>Pasangan </p>
												</td>
												<td><?=number_format($ETI_pas/$ETI_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#E74C3C"></i>Pensiun Reguler </p>
												</td>
												<td><?=number_format($ETI_pens/$ETI_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#26B99A"></i>Platinum </p>
												</td>
												<td><?=number_format($ETI_plat/$ETI_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#3498DB"></i>PNS </p>
												</td>
												<td><?=number_format($ETI_pns/$ETI_total*100, 1, ',', '');?></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<script>
					var dataETI = <?=$jsProdukETI;?>;
						var chart_doughnut_ETI = {
							type: 'doughnut',
							tooltipFillColor: "rgba(51, 51, 51, 0.55)",
							data: {
								labels: [
								"MPP",
								"Pasangan",
								"Pensiun Reguler",
								"Platinum",
								"PNS"
								],
								datasets: [{
									data: dataETI,
									backgroundColor: [
									"#BDC3C7",
									"#9B59B6",
									"#E74C3C",
									"#26B99A",
									"#3498DB"
									],
									hoverBackgroundColor: [
									"#CFD4D8",
									"#B370CF",
									"#E95E4F",
									"#36CAAB",
									"#49A9EA"
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

						$('#canvasETI').each(function () {
							var chart_element = $(this);
							var chart_doughnut = new Chart(chart_element, chart_doughnut_ETI);
						});
					</script>
				</div>
				<div class="col-md-4 col-sm-4 mt-3">
					<div class="x_panel tile fixed_height_320 overflow_hidden">
						<div class="x_title">
							<h2>Mitra Pelindung Mustika</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<table class="" style="width:100%">
								<tr>
									<th style="width:37%;">
										<p>Rp. <?=number_format($MPM_total, 0, ',', '.');?></p>
									</th>
									<th>
										<div class="col-lg-9 col-md-9 col-sm-9 ">
											<p class="">Produk</p>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 ">
											<p class="fa fa-percent"></p>
										</div>
									</th>
								</tr>
								<tr>
									<td>
										<canvas id="canvasMPM" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
									</td>
									<td>
										<table class="tile_info">
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#BDC3C7"></i>MPP </p>
												</td>
												<td><?=number_format($MPM_mpp/$MPM_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#9B59B6"></i>Pasangan </p>
												</td>
												<td><?=number_format($MPM_pas/$MPM_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#E74C3C"></i>Pensiun Reguler </p>
												</td>
												<td><?=number_format($MPM_pens/$MPM_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#26B99A"></i>Platinum </p>
												</td>
												<td><?=number_format($MPM_plat/$MPM_total*100, 1, ',', '');?></td>
											</tr>
											<tr>
												<td>
													<p><i class="fa fa-square" style="color:#3498DB"></i>PNS </p>
												</td>
												<td><?=number_format($MPM_pns/$MPM_total*100, 1, ',', '');?></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<script>
					var dataMPM = <?=$jsProdukMPM;?>;
						var chart_doughnut_MPM = {
							type: 'doughnut',
							tooltipFillColor: "rgba(51, 51, 51, 0.55)",
							data: {
								labels: [
								"MPP",
								"Pasangan",
								"Pensiun Reguler",
								"Platinum",
								"PNS"
								],
								datasets: [{
									data: dataMPM,
									backgroundColor: [
									"#BDC3C7",
									"#9B59B6",
									"#E74C3C",
									"#26B99A",
									"#3498DB"
									],
									hoverBackgroundColor: [
									"#CFD4D8",
									"#B370CF",
									"#E95E4F",
									"#36CAAB",
									"#49A9EA"
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

						$('#canvasMPM').each(function () {
							var chart_element = $(this);
							var chart_doughnut = new Chart(chart_element, chart_doughnut_MPM);
						});
					</script>
				</div>
				<script>
					$(document).ready(function(){
						$('.date-range-input').keydown(function() {
							return false;
						});
						$('.date-range-input').focus(function() {
							this.value = '';
						});
						$('.date-range-input').focusout(function() {
							this.value = 'Pilih Periode';
						});

						$('.date-range-input').daterangepicker({
    				      autoUpdateInput: false,
    				      locale: {
    				          format: 'MMMM D, YYYY',
    				          cancelLabel: 'All Periode',
    				          applyLabel: 'Terapkan'
    				      }
    				    }, function(start, end, label) {
    				        $('#chart-all').css('display','none');
    				        $.ajax({
            					type:"post",
            					url:"modul/mod_dashboard/chart_filter.php",
            					data:"tgl1="+start.format('YYYY-MM-DD')+"&tgl2="+end.format('YYYY-MM-DD'),
            					success: function(data){
            						$("#chart-filter").removeAttr('style');
            						$("#chart-filter").html(data);
            
            					}
            				});
                        });
                        
                        $('.date-range-input').on('cancel.daterangepicker', function(ev, picker) {
                            $('#chart-all').removeAttr('style');
                            $('#chart-filter').css('display','none');
                        });
					});
				</script>
			</div>
			<div class="row">
				<?php
				$resCabang = mysql_query("select a.* from (SELECT sum(t.premi) as pendapatan,m.msdesc as cabang FROM `tr_sppa` t
				join `ms_master` m on t.cabang = m.msid
				where m.mstype='cab' and t.status>=5 and `status`not in (10,11,12,13,73,83,93)
				GROUP BY cabang) a
				order by a.cabang");
				$resRangkingCabang = mysql_query("select a.* from (SELECT sum(t.premi) as pendapatan,m.msdesc as cabang FROM `tr_sppa` t
				join `ms_master` m on t.cabang = m.msid
				where m.mstype='cab' and t.status>=5 and `status`not in (10,11,12,13,73,83,93)
				GROUP BY cabang) a
				order by a.pendapatan desc");

				while ($rowCabang = mysql_fetch_assoc($resCabang)) {
					$dataCabang[] = $rowCabang['cabang'];
					$dataPendapatanCabang[] = $rowCabang['pendapatan'];
				}

				$i = 1;
				while ($rowRangkingCabang = mysql_fetch_assoc($resRangkingCabang)) {
					$dataRangkingCabang[] = $rowRangkingCabang;
					if ($i == 4) {
						break;
					}
					$i++;
				}

				$jsCabang = json_encode($dataCabang);
				$jsRangkingCabang = json_encode($dataRangkingCabang);
				$jsPendapatanCabang = json_encode($dataPendapatanCabang);

				?>
				<div class="col-md-12 col-sm-12 ">
					<div class="dashboard_graph">
						<div class="row x_title">
							<div class="col-md-6">
								<h3>Premi Cabang</h3>
							</div>
						</div>

						<div class="col-md-9 col-sm-9 ">
							<canvas width="200" id="bar-cabang" height="60"></canvas>
						</div>
						<div class="col-md-3 col-sm-3  bg-white">
							<div class="x_title">
								<table>
									<tr>
										<td><h2>TOTAL PREMI</h2></td>
									</tr>
									<tr>
										<td><b>Rp. <?=number_format(array_sum($dataPendapatanCabang), 0, ',', '.');?></b></td>
									</tr>
								</table>
							</div>

							<div class="col-md-12 col-sm-12 ">
								<?php
								$PendapatanCabangTertinggi = max($dataPendapatanCabang);

								foreach ($dataRangkingCabang as $key => $data) {
									?>
									<div>
										<p><?=$data['cabang'];?></p>
										<div class="">
											<div class="progress progress_sm" style="width: 90%;">
												<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?=$data['pendapatan']/$PendapatanCabangTertinggi*100;?>"></div>
											</div>
										</div>
									</div>
									<?php
								}
								?>
							</div>

						</div>

						<div class="clearfix"></div>
					</div>
				</div>
				<script>
					var dataCabang = <?=$jsCabang;?>;
					var dataPendapatanCabang = <?=$jsPendapatanCabang;?>;
					var chart_doughnut_settings = {
						type: 'bar',
						tooltipFillColor: "rgba(51, 51, 51, 0.55)",
						data: {
							labels: dataCabang,
							datasets: [{
								data: dataPendapatanCabang,
								backgroundColor: "#36CAAB",
								hoverBackgroundColor: "#36CAAB"
							}]
						},
						options: {
							legend: false,
							tooltips: {
								callbacks: {
									label: function(tooltipItem, data) {
										return "Rp. "+tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
									}
								}
							},
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										callback: function(value, index, values) {
											if(parseInt(value) >= 1000){
												return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
											} else {
												return 'Rp. ' + value;
											}
										}
									}
								}]
							}
						}
					}

					$('#bar-cabang').each(function () {
						var chart_element = $(this);
						var chart_doughnut = new Chart(chart_element, chart_doughnut_settings);
					});

				</script>

			</div>
			</div>
			
            <div class="row">      <!-- -------------------------------Tabel Yang Baru---------------------------------------- -->
                <table id="table-dashboard" class="table table-striped jambo_table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                      <tr class="headings">
                        <th class="column-title">Bulan </th>
                        <th class="column-title">Pinjaman </th>
                        <th class="column-title">Premi </th>
                        <th class="column-title">Debitur </th>
                        <th class="column-title no-link last"><span class="nobr">Action</span></th>
                      </tr>
                    </thead>

                    <tbody>
                      
                    </tbody>
                  </table>
                  <script>
                	$(document).ready(function() {
                		$('#table-dashboard').dataTable( {
                		    "colReorder": true,
                		    "autoWidth": false,
                		    "responsive": true,
                			"bProcessing": true,
                			"bServerSide": true,
                			"sAjaxSource": "modul/mod_dashboard/data_dashboard.php",
                			"aoColumns": [
                			  {"sName": "smonth"},
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
                			  {"sName": "smem"},
                			  {
                				"mRender": function ( data, type, full ) {
                			          var btnReturn = `<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Cabang" onclick="window.location='media.php?module=dashboard&&act=cab&&id=`+data+`'"><i class="fa fa-search"></i> Cabang</button>`;
    					              btnReturn += `<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Status" onclick="window.location='media.php?module=dashboard&&act=stat&&id=`+data+`'"><i class="fa fa-search"></i> Status</button>`;
    					              btnReturn += `<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="produk" onclick="window.location='media.php?module=dashboard&&act=prod&&id=`+data+`'"><i class="fa fa-search"></i> Produk</button>`;
    					              btnReturn += `<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="tanggal" onclick="window.location='media.php?module=dashboard&&act=tgl&&id=`+data+`'"><i class="fa fa-search"></i> Tanggal</button>`;
    					              return btnReturn;
                				  }
                			  }
                			],
                			"columnDefs": [ 
                			    {
                                    "targets": 4,
                                    "orderable": false
                                }
                            ]
                		} );
                	} );
            	</script>
            </div>          <!-- -------------------------------Tabel Yang Baru---------------------------------------- -->
            <br>
			<div class="row" style="display:none;">  <!-- -------------------------------Tabel Sebelumnya---------------------------------------- -->

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
									<th>Bulan</th>
									<th>Pinjaman </th>
									<th>Premi </th>
									<th>Nasabah</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php

								$sqld="select aa.* from  (select left(mulai,7) smonth , ";
								$sqld= $sqld . " sum(up) sup,count(regid) smem ,sum(tpremi) stpremi from tr_sppa where status not in ('0','12') ";
								$sqld= $sqld . "  group by left(mulai,7) ) aa  order by aa.smonth desc LIMIT $posisi,$batas" ;
								$query=mysql_query($sqld);
								$num=mysql_num_rows($query);
								$no=1;
								while($r=mysql_fetch_array($query)){

									?>
									<tr>


										<td><?php echo $r['smonth']; ?></td>
										<td><?php echo number_format($r['sup'],0); ?></td>
										<td><?php echo number_format($r['stpremi'],0); ?></td>
										<td><?php echo number_format($r['smem'],0); ?></td>
										<th>
											<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Cabang" onclick="window.location='media.php?module=dashboard&&act=cab&&id=<?php echo $r['smonth']; ?>'"><i class="fa fa-search"></i> Cabang</button>
											<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Status" onclick="window.location='media.php?module=dashboard&&act=stat&&id=<?php echo $r['smonth']; ?>'"><i class="fa fa-search"></i> Status</button>
											<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="produk" onclick="window.location='media.php?module=dashboard&&act=prod&&id=<?php echo $r['smonth']; ?>'"><i class="fa fa-search"></i> Produk</button>
											<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="tanggal" onclick="window.location='media.php?module=dashboard&&act=tgl&&id=<?php echo $r['smonth']; ?>'"><i class="fa fa-search"></i> Tanggal</button>

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
					$sqlt="select left(mulai,7) smonth , ";
					$sqlt= $sqlt . " sum(up) sup,count(regid) smem ,sum(tpremi) stpremi from tr_sppa  ";
					$sqlt= $sqlt . "  group by left(mulai,7) ";
					$jmldata=mysql_num_rows(mysql_query($sqlt));
					$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
					$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
					echo "$linkHalaman";

					?>
				</div>
			</div>               <!-- -------------------------------Tabel Sebelumnya---------------------------------------- -->
			
		</div>
	</div>
</div>
</div>
<?php
break;

case "cab":
$sid=$_GET['id'];

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
						<h2>Cabang <small><?php echo $r['reqid']; ?></small></h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

							<div id="tabel_awal">
								<table class="table table-bordered">
									<thead>
										<tr>

											<th>Cabang</th>
											<th>Pinjaman </th>
											<th>Premi</th>
											<th>Nasabah</th>
											<th></th>



										</tr>
									</thead>
									<tbody>
										<?php
										$sqld="select aa.cabang,left(mulai,7) smonth , ab.msdesc cab ,";
										$sqld= $sqld . " sum(aa.up) sup,count(aa.regid) smem ,sum(aa.tpremi) stpremi from tr_sppa aa ";
										$sqld= $sqld . " inner join ms_master ab on ab.msid=aa.cabang and ab.mstype='cab'";
										$sqld= $sqld . " where left(aa.mulai,7)='$sid' and aa.status<>'0' group by  aa.cabang,left(aa.mulai,7),ab.msdesc ";

										/* echo $sqld;  */
										$query=mysql_query($sqld);
										$num=mysql_num_rows($query);
										$no=1;
										while($r=mysql_fetch_array($query)){

											?>
											<tr>

												<td><?php echo $r['cab']; ?></td>
												<td><?php echo number_format($r['sup'],0); ?></td>
												<td><?php echo number_format($r['stpremi'],0); ?></td>
												<td><?php echo number_format($r['smem'],0); ?></td>
												<th>
													<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Status" onclick="window.location='media.php?module=dashboard&&act=cabstat&&id=<?php echo  $r['cabang'].$r['smonth']; ?>'"><i class="fa fa-search"></i> Status</button>
													<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="produk" onclick="window.location='media.php?module=dashboard&&act=cabprod&&id=<?php echo  $r['cabang'].$r['smonth']; ?>'"><i class="fa fa-search"></i> Produk</button>
													<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="tanggal" onclick="window.location='media.php?module=dashboard&&act=cabtgl&&id=<?php echo  $r['cabang'].$r['smonth']; ?>'"><i class="fa fa-search"></i> Tanggal</button>

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
									<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=dashboard'"><i class="fa fa-arrow-left"></i> Back</button>

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

case "stat":
$sid=$_GET['id'];

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
						<h2>Status</small></h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

							<div id="tabel_awal">
								<table class="table table-bordered">
									<thead>
										<tr>

											<th>Cabang</th>
											<th>Pinjaman </th>
											<th>Premi</th>
											<th>Nasabah</th>




										</tr>
									</thead>
									<tbody>
										<?php
										$sqld="select left(aa.mulai,7) smonth , ab.msdesc msd ,";
										$sqld= $sqld . " sum(aa.up) sup,count(aa.regid) smem ,sum(aa.tpremi) stpremi from tr_sppa aa ";
										$sqld= $sqld . " inner join ms_master ab on ab.msid=aa.status and ab.mstype='streq' ";
										$sqld= $sqld . " where left(aa.mulai,7)='$sid'  group by ab.msdesc ,left(aa.mulai,7)  ";
										$query=mysql_query($sqld);
										$num=mysql_num_rows($query);
										$no=1;
										while($r=mysql_fetch_array($query)){

											?>
											<tr>

												<td><?php echo $r['msd']; ?></td>
												<td><?php echo number_format($r['sup'],0); ?></td>
												<td><?php echo number_format($r['stpremi'],0); ?></td>
												<td><?php echo number_format($r['smem'],0); ?></td>



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
									<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=dashboard'"><i class="fa fa-arrow-left"></i> Back</button>

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

case "prod":
$sid=$_GET['id'];

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
						<h2>Produk</h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

							<div id="tabel_awal">
								<table class="table table-bordered">
									<thead>
										<tr>

											<th>Produk</th>
											<th>Pinjaman </th>
											<th>Premi</th>
											<th>Nasabah</th>




										</tr>
									</thead>
									<tbody>
										<?php
										$sqld="select left(aa.mulai,7) smonth , ab.msdesc msd ,";
										$sqld= $sqld . " sum(aa.up) sup,count(aa.regid) smem ,sum(aa.tpremi) stpremi from tr_sppa aa ";
										$sqld= $sqld . " inner join ms_master ab on ab.msid=aa.produk ";
										$sqld= $sqld . " where left(aa.mulai,7)='$sid' and aa.status<>'0' group by ab.msdesc,left(aa.mulai,7)  ";
										/* echo $sqld;  */
										$query=mysql_query($sqld);
										$num=mysql_num_rows($query);
										$no=1;
										while($r=mysql_fetch_array($query)){

											?>
											<tr>

												<td><?php echo $r['msd']; ?></td>
												<td><?php echo number_format($r['sup'],0); ?></td>
												<td><?php echo number_format($r['stpremi'],0); ?></td>
												<td><?php echo number_format($r['smem'],0); ?></td>







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
									<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=dashboard'"><i class="fa fa-arrow-left"></i> Back</button>

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
case "tgl":
$sid=$_GET['id'];

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
						<h2>Tanggal </small></h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

							<div id="tabel_awal">
								<table class="table table-bordered">
									<thead>
										<tr>

											<th>Tanggal</th>
											<th>Pinjaman </th>
											<th>Premi</th>
											<th>Nasabah</th>




										</tr>
									</thead>
									<tbody>
										<?php
										$sqld="select * from (select left(aa.mulai,10) smonth ,";
										$sqld= $sqld . " sum(aa.up) sup,count(aa.regid) smem ,sum(aa.tpremi) stpremi from tr_sppa aa ";
										$sqld= $sqld . " where left(aa.mulai,7)='$sid'  group by left(aa.mulai,10)) ax order by smonth ";
										/* echo $sqld;  */
										$query=mysql_query($sqld);
										$num=mysql_num_rows($query);
										$no=1;
										while($r=mysql_fetch_array($query)){

											?>
											<tr>

												<td><?php echo $r['smonth']; ?></td>
												<td><?php echo number_format($r['sup'],0); ?></td>
												<td><?php echo number_format($r['stpremi'],0); ?></td>
												<td><?php echo number_format($r['smem'],0); ?></td>







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
									<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=dashboard'"><i class="fa fa-arrow-left"></i> Back</button>

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
case "cabstat":
$sid=$_GET['id'];

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
						<h2>Cabang-Status </h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

							<div id="tabel_awal">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Cabang</th>
											<th>Status</th>
											<th>Pinjaman </th>
											<th>Premi</th>
											<th>Nasabah</th>
											<th></th>



										</tr>
									</thead>
									<tbody>
										<?php
										$sqld="select aa.status,left(aa.mulai,7) smonth , ab.msdesc msd, ac.msdesc cab,aa.cabang, ";
										$sqld= $sqld . " sum(aa.up) sup,count(aa.regid) smem ,sum(aa.tpremi) stpremi from tr_sppa aa ";
										$sqld= $sqld . " inner join ms_master ab on ab.msid=aa.status  and ab.mstype='streq' ";
										$sqld= $sqld . " inner join ms_master ac on ac.msid=aa.cabang  and ac.mstype='cab' ";
										$sqld= $sqld . " where concat(aa.cabang,left(aa.mulai,7))='$sid' group by aa.status,aa.cabang,ab.msdesc,left(aa.mulai,7),ac.msdesc ";
										/* echo $sqld;   */
										$query=mysql_query($sqld);
										$num=mysql_num_rows($query);
										$no=1;
										while($r=mysql_fetch_array($query)){

											?>
											<tr>
												<td><?php echo $r['cab']; ?></td>
												<td><?php echo $r['msd']; ?></td>
												<td><?php echo number_format($r['sup'],0); ?></td>
												<td><?php echo number_format($r['stpremi'],0); ?></td>
												<td><?php echo number_format($r['smem'],0); ?></td>
												<th>
													<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="detail" onclick="window.location='media.php?module=dashboard&&act=statdtl&&id=<?php echo $r['status'].$r['cabang'].$r['smonth']; ?>'"><i class="fa fa-search"></i> Detail</button>
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
									<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=dashboard'"><i class="fa fa-arrow-left"></i> Back</button>

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
case "cabprod":
$sid=$_GET['id'];

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
						<h2>Cabang-Produk </h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

							<div id="tabel_awal">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Cabang</th>
											<th>Produk</th>
											<th>Pinjaman </th>
											<th>Premi</th>
											<th>Nasabah</th>




										</tr>
									</thead>
									<tbody>
										<?php
										$sqld="select left(aa.mulai,7) smonth , ab.msdesc msd, ac.msdesc cabang,";
										$sqld= $sqld . " sum(aa.up) sup,count(aa.regid) smem ,sum(aa.tpremi) stpremi from tr_sppa aa ";
										$sqld= $sqld . " inner join ms_master ab on ab.msid=aa.produk  and ab.mstype='produk' ";
										$sqld= $sqld . " inner join ms_master ac on ac.msid=aa.cabang  and ac.mstype='cab' ";
										$sqld= $sqld . " where concat(aa.cabang,left(aa.mulai,7))='$sid'  group by ab.msdesc,left(aa.mulai,7),ac.msdesc  ";
										/* echo $sqld;   */
										$query=mysql_query($sqld);
										$num=mysql_num_rows($query);
										$no=1;
										while($r=mysql_fetch_array($query)){

											?>
											<tr>
												<td><?php echo $r['cabang']; ?></td>
												<td><?php echo $r['msd']; ?></td>
												<td><?php echo number_format($r['sup'],0); ?></td>
												<td><?php echo number_format($r['stpremi'],0); ?></td>
												<td><?php echo number_format($r['smem'],0); ?></td>







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
									<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=dashboard'"><i class="fa fa-arrow-left"></i> Back</button>

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
case "cabtgl":
$sid=$_GET['id'];

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
						<h2>Cabang-Tanggal </h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

							<div id="tabel_awal">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Cabang</th>
											<th>Tanggal</th>
											<th>Pinjaman </th>
											<th>Premi</th>
											<th>Nasabah</th>




										</tr>
									</thead>
									<tbody>
										<?php
										$sqld="select left(aa.mulai,7) smonth , aa.mulai msd, ac.msdesc cabang,";
										$sqld= $sqld . " sum(aa.up) sup,count(aa.regid) smem ,sum(aa.tpremi) stpremi from tr_sppa aa ";
										$sqld= $sqld . " inner join ms_master ac on ac.msid=aa.cabang  and ac.mstype='cab' ";
										$sqld= $sqld . " where concat(aa.cabang,left(aa.mulai,7))='$sid'  group by aa.mulai ,left(aa.mulai,7),ac.msdesc  ";
										/* echo $sqld;   */
										$query=mysql_query($sqld);
										$num=mysql_num_rows($query);
										$no=1;
										while($r=mysql_fetch_array($query)){

											?>
											<tr>
												<td><?php echo $r['cabang']; ?></td>
												<td><?php echo $r['msd']; ?></td>
												<td><?php echo number_format($r['sup'],0); ?></td>
												<td><?php echo number_format($r['stpremi'],0); ?></td>
												<td><?php echo number_format($r['smem'],0); ?></td>







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
									<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=dashboard'"><i class="fa fa-arrow-left"></i> Back</button>

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
case "statdtl":
$sid=$_GET['id'];

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
						<h2>Cabang-Tanggal </h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $aksi."?module=reject"; ?>">
							<input type="hidden" name="id" value="<?php echo $r['regid']; ?>">
							<input type="hidden" name="userid" value="<?php echo $userid; ?>">
							<input type="hidden" name="produk" value="<?php echo $sproduk; ?>">

							<div id="tabel_awal">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Cabang</th>
											<th>Status</th>
											<th>Regid</th>
											<th>Nama</th>
											<th>Pinjaman </th>
											<th>Premi</th>
											<th>AO</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sqld="select ac.msdesc cab,ab.msdesc stat ,aa.regid,aa.nama,aa.tgllahir,aa.premi,aa.up,aa.createby ";
										$sqld= $sqld . "  from tr_sppa aa ";
										$sqld= $sqld . " inner join ms_master ac on ac.msid=aa.cabang  and ac.mstype='cab' ";
										$sqld= $sqld . " inner join ms_master ab on ab.msid=aa.status  and ab.mstype='streq' ";
										$sqld= $sqld . " where concat(aa.status,aa.cabang,left(aa.mulai,7))='$sid'  order by aa.nama asc  ";
										/* echo $sqld;   */
										$query=mysql_query($sqld);
										$num=mysql_num_rows($query);
										$no=1;
										while($r=mysql_fetch_array($query)){
											?>
											<tr>
												<td><?php echo $r['cab']; ?></td>
												<td><?php echo $r['stat']; ?></td>
												<td><?php echo $r['regid']; ?></td>
												<td><?php echo $r['nama']; ?></td>
												<td><?php echo number_format($r['up'],0); ?></td>
												<td><?php echo number_format($r['premi'],0); ?></td>
												<td><?php echo $r['createby']; ?></td>

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
									<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Back" onclick="window.location='media.php?module=dashboard'"><i class="fa fa-arrow-left"></i> Back</button>
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
}
?>
