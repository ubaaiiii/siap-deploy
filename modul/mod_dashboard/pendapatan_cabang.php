<?php


	$resCabang = mysql_query("select a.* from (SELECT sum(t.premi) as pendapatan,m.msdesc as cabang FROM `tr_sppa` t
														join `ms_master` m on t.cabang = m.msid
														where m.mstype='cab' and t.status='5'
														GROUP BY cabang) a
														order by a.cabang");
	$resRangkingCabang = mysql_query("select a.* from (SELECT sum(t.premi) as pendapatan,m.msdesc as cabang FROM `tr_sppa` t
																		join `ms_master` m on t.cabang = m.msid
																		where m.mstype='cab' and t.status='5'
																		GROUP BY cabang) a
																		order by a.pendapatan desc");

	while ($rowCabang = mysql_fetch_assoc($resCabang)) {
		$dataCabang[] = $rowCabang['cabang'];
		$dataPendapatanCabang[] = $rowCabang['pendapatan'];
	}

	$i = 1;
	while ($rowRangkingCabang = mysql_fetch_assoc($resRangkingCabang)) {
		$dataRangkingCabang[] = $rowRangkingCabang;
		if ($i == 5) {
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
       <div class="col-md-6">
         <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
           <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
           <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
         </div>
       </div>
     </div>

     <div class="col-md-9 col-sm-9 ">
       <canvas width="200" class="bar-cabang" height="60"></canvas>
     </div>
     <div class="col-md-3 col-sm-3  bg-white">
       <div class="x_title">
         <h2>Peringkat Performa Cabang</h2>
         <div class="clearfix"></div>
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
     scales: {
       yAxes: [{
         ticks: {
           beginAtZero: true,
           callback: function(value, index, values) {
             if(parseInt(value) >= 1000){
               return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
