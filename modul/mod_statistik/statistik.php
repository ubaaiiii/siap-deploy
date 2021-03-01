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

			while($r=$query->fetch_array()){
				$scond = array('mkt', 'smkt');
				$scond4 = array('smon', 'smon');
				$scond1 = array('checker', 'schecker');
				$scond2 = array('broker', 'broker');
				$scond3 = array('insurance', 'insurance');
				$username=$r['username'];
				$level=$r['level'];
				$syear=$r['sdate'];
				$sfield = $r['level'];

			}
?>

    <div class="right_col" role="main">
        
        <?php if (in_array($sfield, $scond2, TRUE)): ?>
        <div class="clearfix"></div>
        <div class="row">                   
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-line-chart"></i> Grafik Premi dan UP</h2>
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
                            label: "UP",
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
                                        return "Rp. " + currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
                        $.ajax({
                            url: "modul/mod_statistik/grafik_premi.php",
                            data: datanya,
                            type: 'GET',
                            success: function(data){
                                data = JSON.parse(data);
                                if (data !== null) {
                                    if (data.label == null || data.premi == null || data.up == null) {
                                        Swal.fire("Data Kosong","Maaf belum ada data di periode tersebut","warning").then(
                                        (result) => {
                                            $('#range-grafik').val('');
                                            $('#range-grafik').click();   
                                        });
                                    } else {
                                        updateGrafik(chartGrafik,data.label,data.premi,data.up);
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
        <div class="clearfix"></div>
        <div class="row">                   
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-line-chart"></i> Grafik Pengajuan</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <input id="range-grafik-pengajuan" style="position:absolute;top:15px;right:80px;z-index:1;text-indent:10px;width:200px;" type="text" placeholder="Pilih Periode.." class="bundar date-range-input-pengajuan">
                    <select id="tipe-grafik-pengajuan" style="position:absolute;top:15px;right:300px;z-index:1;width:150px;;text-indent:4px;height:25px;" class="bundar">
                        <option selected value="bulan">Bulanan</option>
                        <option value="minggu">Mingguan</option>
                        <option value="hari">Harian</option>
                    </select>
                    <input id="tgl-mulai-pengajuan" name="tgl-mulai-pengajuan" type="date" hidden>
                    <input id="tgl-selesai-pengajuan" name="tgl-selesai-pengajuan" type="date" hidden>
                    <div class="x_content">
                        <canvas id="chart-pengajuan" height="400" style="width:100%;height:auto;"></canvas>
                    </div>
                </div>
            </div>
            <script>
                var ctxPengajuan = document.getElementById('chart-pengajuan').getContext('2d');
                var chartPengajuan = new Chart(ctxPengajuan, {
                    type: 'line',
                    data: {
                        datasets: [{
                            data: [''],
                            borderColor: '#3498DB',
                            pointBackgroundColor: '#3498DB',
                            pointBorderColor: '#3498DB',
                            label: "Pengajuan",
                            pointStyle: 'rectRounded'
                        },
                        
                        {
                            data: [''],
                            borderColor: '#10ea29',
                            pointBackgroundColor: '#10ea29',
                            pointBorderColor: '#10ea29',
                            label: "Sertifikat",
                            pointStyle: 'rectRounded'
                        },
                        
                        {
                            data: [''],
                            backgroundColor: 'rgba(46,204,112,0)',
                            borderColor: '#ff0000',
                            pointBackgroundColor: '#ff0000',
                            pointBorderColor: '#ff0000',
                            label: "Reject",
                            pointStyle: 'rectRounded'
                        },]
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
								    return currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " nasabah";
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
                    $('#range-grafik-pengajuan').val('Periode 3 Bulan Terakhir..');
                    function updateGrafikPengajuan(chart, label, data1, data2, data3) {
                        chart.data.labels.pop();
                        chart.data.labels = label
                        chart.data.datasets[0].data = data1;
                        chart.data.datasets[1].data = data2;
                        chart.data.datasets[2].data = data3;
                        chart.update();
                    }
                    
                    function removeChartDataPengajuan(chart) {
                        chart.data.labels.pop();
                        chart.data.datasets.forEach((dataset) => {
                            dataset.data.pop();
                        });
                        chart.update();
                    }
					$('.date-range-input-pengajuan').keydown(function() {
						return false;
					});

					var start = moment().subtract(3, 'month').startOf('month');
                    var end = moment();
                
                    function cbPengajuan(start, end) {
                        $('#tgl-mulai-pengajuan').val(start.format('YYYY-MM-DD'));
                        $('#tgl-selesai-pengajuan').val(end.format('YYYY-MM-DD'));
                        var tipeGrafikPengajuan = $('#tipe-grafik-pengajuan option:selected').val();
                        var dataPengajuannya = "aRange="+start.format('YYYY-MM-DD')+"&&bRange="+end.format('YYYY-MM-DD')+"&&tipe="+tipeGrafikPengajuan;
                        $.ajax({
                            url: "modul/mod_statistik/grafik_pengajuan.php",
                            data: dataPengajuannya,
                            type: 'POST',
                            success: function(data){
                                data = JSON.parse(data);
                                if (data !== null) {
                                    if (data.label == null || data.pengajuan == null || data.sertifikat == null || data.reject == null) {
                                        Swal.fire("Data Kosong","Maaf belum ada data di periode tersebut","warning").then(
                                        (result) => {
                                            $('#range-grafik-pengajuan').val('');
                                            $('#range-grafik-pengajuan').click();   
                                        });
                                    } else {
                                        updateGrafikPengajuan(chartPengajuan,data.label,data.pengajuan,data.sertifikat,data.reject);
                                    }
                                }
                            }
                        })
                    }
                
                    $('.date-range-input-pengajuan').daterangepicker({
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
                    }, cbPengajuan);
                
                    $('#tipe-grafik-pengajuan').on('change', function() {
                        var dateAwal = new Date($('#tgl-mulai-pengajuan').val());
                        var dateAkhir = new Date($('#tgl-selesai-pengajuan').val());
                        var momentAwal = moment(dateAwal);
                        var momentAkhir = moment(dateAkhir);
                        cbPengajuan(momentAwal,momentAkhir);
                    });
                    
                    cbPengajuan(start, end);
                    
                    $('.date-range-input-pengajuan').on('cancel.daterangepicker', function(ev, picker) {
                        $('#tgl-mulai-pengajuan').val('');
                        $('#tgl-selesai-pengajuan').val('');
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