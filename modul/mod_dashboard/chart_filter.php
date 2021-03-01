<script src="././js/chart.min.js"></script>
<script src="././js/progressbar/bootstrap-progressbar.min.js"></script>
<?php
include ("../../config/koneksi.php");
if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
    $tgl_awal = $_GET['tgl1'];
    $tgl_akhir = $_GET['tgl2'];
} else if (isset($_POST['tgl1']) && isset($_POST['tgl2'])) {
    $tgl_awal = $_POST['tgl1'];
    $tgl_akhir = $_POST['tgl2'];
}
?>
<div class="row">
	<?php
		$resAsuransi = mysql_query("SELECT `asuransi`,`produk`,sum(premi) pendapatan FROM `tr_sppa` WHERE `status`>=5 and `status`not in (10,11,12,13,73,83,93) and LEFT(`validdt`,10) BETWEEN '".$tgl_awal."' and '".$tgl_akhir."' group by `produk`,`asuransi`");

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
							<canvas class="canvasTKP" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
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

			$('.canvasTKP').each(function () {
				var chart_element = $(this);
				var chart_doughnut = new Chart(chart_element, chart_doughnut_settings);
			});
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
							<canvas class="canvasETI" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
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

			$('.canvasETI').each(function () {
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
							<canvas class="canvasMPM" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
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

			$('.canvasMPM').each(function () {
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
				this.value = 'All Periode';
			});

			$('.date-range-input').daterangepicker({
		      autoUpdateInput: false,
		      locale: {
		          format: 'MMMM D, YYYY',
		          cancelLabel: 'All Periode',
		          applyLabel: 'Terapkan'
		      }
		    }, function(start, end, label) {
		        $.ajax({
					type:"post",
					url:"modul/mod_dashboard/chart_filter.php",
					data:"tgl1="+start.format('YYYY-MM-DD')+"&tgl2="+end.format('YYYY-MM-DD'),
					success: function(data){
					    $('#chart-all').css('display','none');
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
	where m.mstype='cab' and t.status>=5 and `status`not in (10,11,12,13,73,83,93) AND
    LEFT(`validdt`,10) BETWEEN '".$tgl_awal."' and '".$tgl_akhir."'
	GROUP BY cabang) a
	order by a.cabang");
	$resRangkingCabang = mysql_query("select a.* from (SELECT sum(t.premi) as pendapatan,m.msdesc as cabang FROM `tr_sppa` t
	join `ms_master` m on t.cabang = m.msid
	where m.mstype='cab' and t.status>=5 and `status`not in (10,11,12,13,73,83,93) AND
    LEFT(`validdt`,10) BETWEEN '".$tgl_awal."' and '".$tgl_akhir."'
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
					<h3>Pendapatan Cabang</h3>
				</div>
			</div>

			<div class="col-md-9 col-sm-9 ">
				<canvas width="200" class="bar-cabang" height="60"></canvas>
			</div>
			<div class="col-md-3 col-sm-3  bg-white">
				<div class="x_title">
					<table>
						<tr>
							<td><h2>TOTAL PENDAPATAN</h2></td>
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
	    $('.progress .progress-bar').progressbar();
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

		$('.bar-cabang').each(function () {
			var chart_element = $(this);
			var chart_doughnut = new Chart(chart_element, chart_doughnut_settings);
		});

	</script>

</div>