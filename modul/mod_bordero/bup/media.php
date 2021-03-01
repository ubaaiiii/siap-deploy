<?php
	session_start();
	ob_start();
	
	if(!isset($_SESSION['idLog'])){
		echo "
		<script>
			alert('Login Terlebih Dahulu');
			window.location.href='index.php';
		</script>
		";
	}
	else{
	$idLog=$_SESSION['idLog'];
	$idLevel=$_SESSION['idLevel'];
	$id_peg=$_SESSION['id_peg'];
	include("config/koneksi.php");
	include("config/pagging.php");
	include("config/fungsi_all.php");

	?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAP  </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">
    <!-- editor -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link href="css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="css/editor/index.css" rel="stylesheet">
    <!-- select2 -->
    <link href="css/select/select2.min.css" rel="stylesheet">
    <!-- switchery -->
    <link rel="stylesheet" href="css/switchery/switchery.min.css" />

    <script src="js/jquery.min.js"></script>
	
    <script src="js/jquery.min.js"></script>
    <script src="js/nprogress.js"></script>
	
    <script>
        NProgress.start();
    </script>
	<script type="text/javascript">
	 $(document).ready(function () {
		$('#form_add').css("border", "3px solid #333");
		
		$('#add').click(function(){
			$('#form_add').show(1000);
		)};
	});
</script>

</head>


<body class="nav-md">
<?php
	$queryOn=mysql_query("SELECT a.* FROM ms_admin a  where a.username='$idLog'");
	$rOn=mysql_fetch_array($queryOn);
?>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.php" class="site_title"><i class="fa fa-desktop"></i> <span>SIAP 1.0 </span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="images/users.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Selamat Datang,</span>
                            <h2><?php echo $rOn['username']; ?></h2>
							<h2><?php echo $rOn['level']; ?></h2>
							
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>Generals</h3>
                            <ul class="nav side-menu">
                                <li><a href="media.php?module=home"><i class="fa fa-home"></i> Home </a></li>
								
									
									<li><a href='media.php?module=profile'><i class='fa fa-user'></i> Profile</a></li>
									
									
									
									
									
									
									
								
								<?php
                                        if (isset($_SESSION['idLevel'])) {
											if ($_SESSION['idLevel'] == "super_user") {

												
												echo "<li><a href='media.php?module=ajuan'><i class='fa fa fa-file-text-o'></i> Pengajuan</a></li>";
												echo "<li><a href='media.php?module=checker'><i class='fa fa-check'></i> Checker</a></li>";
												echo "<li><a href='media.php?module=verif'><i class='fa fa-check-square-o'></i> Verifikasi</a></li>";
												echo "<li><a href='media.php?module=valid'><i class='fa fa-check-square'></i> Validasi</a></li>";
												echo "<li><a href='media.php?module=certificate'><i class='fa fa-briefcase'></i> Sertifikat</a></li>";
												echo "<li><a href='media.php?module=lapor'><i class='fa fa-book'></i> Laporan</a></li>";
												echo "<li><a href='media.php?module=inquiry'><i class='fa fa fa-search'></i> Inquiry</a></li>";
												echo "<li><a href='media.php?module=inquiric'><i class='fa fa fa-search'></i> Inquiry</a></li>";
												echo "<li><a href='media.php?module=cancel'><i class='fa fa fa-search'></i> Pembatalan</a></li>";
												echo "<li><a><i class='fa fa-pencil-square-o'></i> Klaim<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=claim'><i class='fa fa-search'></i> Register</a></li>";
												echo "<li><a href='media.php?module=clmverif'><i class='fa fa-search'></i> Klaim Verif </a></li>";
												echo "<li><a href='media.php?module=clmvalid'><i class='fa fa-search'></i> Klaim Valid</a></li>";
												echo "<li><a href='media.php?module=clmpaid'><i class='fa fa-search'></i> Klaim Paid</a></li>";
												echo "</ul>";
												echo "<li><a><i class='fa fa-pencil-square-o'></i> Dashboard<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=cabang'><i class='fa fa-search'></i> cabang</a></li>";
												echo "<li><a href='media.php?module=mkt'><i class='fa fa-search'></i> Marketing </a></li>";
												echo "<li><a href='media.php?module=bulan'><i class='fa fa-search'></i> Bulan</a></li>";
												echo "</ul>";
												
												echo "<li><a><i class='fa fa-wrench'></i> Master<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=mscab'><i class='fa fa-search'></i> Cabang</a></li>";
												echo "<li><a href='media.php?module=msmitra'><i class='fa fa-search'></i> Mitra </a></li>";
												echo "<li><a href='media.php?module=msuser'><i class='fa fa-search'></i> User</a></li>";
												echo "<li><a href='media.php?module=msrate'><i class='fa fa-search'></i> Rate</a></li>";
												echo "</ul>";
												echo "<li><a><i class='fa fa-pencil-square-o'></i> Maintenance<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=bordero'><i class='fa fa-book'></i> Bordero</a></li>";
												echo "<li><a href='media.php?module=revisi'><i class='fa fa-book'></i> Revisi</a></li>";
												echo "<li><a href='media.php?module=cancel'><i class='fa fa fa-search'></i> Cancel</a></li>";
												echo "</ul>";
												
                                          	}			
											elseif ($_SESSION['idLevel'] == "checker" or $_SESSION['idLevel']=='schecker') {

												echo "<li><a><i class='fa fa-pencil-square-o'></i> Pengajuan<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=checker'><i class='fa fa-book'></i> Checker</a></li>";
												echo "<li><a href='media.php?module=checkpro'><i class='fa fa-book'></i> Proses</a></li>";
												echo "<li><a href='media.php?module=certificate'><i class='fa fa-briefcase'></i> Sertifikat</a></li>";
												echo "</ul>";
												
												echo "<li><a><i class='fa fa-pencil-square-o'></i> Klaim<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=claim'><i class='fa fa-search'></i> Klaim</a></li>";
												echo "<li><a href='media.php?module=claimpro'><i class='fa fa-book'></i> Klaim Proses</a></li>";
												echo "<li><a href='media.php?module=cancel'><i class='fa fa-briefcase'></i> Batal</a></li>";
												echo "<li><a href='media.php?module=cancelpro'><i class='fa fa-briefcase'></i> Batal Proses</a></li>";
												echo "</ul>";
												
												echo "<li><a href='media.php?module=lapor'><i class='fa fa-book'></i> Laporan</a></li>";
												echo "<li><a href='media.php?module=inquiry'><i class='fa fa fa-search'></i> Inquiry</a></li>";
												
			
												
                                          	}	

											elseif ($_SESSION['idLevel'] == "mkt" or $_SESSION['idLevel'] == "smkt" ) {

												
												echo "<li><a href='media.php?module=ajuan'><i class='fa fa fa-file-text-o'></i> Pengajuan</a></li>";
												echo "<li><a href='media.php?module=certificate'><i class='fa fa-briefcase'></i> Sertifikat</a></li>";
												echo "<li><a href='media.php?module=lapor'><i class='fa fa-book'></i> Laporan</a></li>";
												echo "<li><a href='media.php?module=inquiry'><i class='fa fa fa-search'></i> Inquiry</a></li>";
												echo "<li><a href='media.php?module=minquiry'><i class='fa fa fa-search'></i> Inquiry</a></li>";
												echo "<li><a href='media.php?module=kalkulator'><i class='fa fa fa-calculator'></i> kalkulator</a></li>";
												echo "<li><a href='media.php?module=panduan'><i class='fa fa fa-book'></i> Panduan</a></li>";

												
                                          	}				
											elseif ($_SESSION['idLevel'] == "broker") {

												echo "<li><a href='media.php?module=cekfoto'><i class='fa fa-check-square-o'></i> Check Foto</a></li>";
												echo "<li><a href='media.php?module=verif'><i class='fa fa-check-square-o'></i> Verifikasi</a></li>";
												echo "<li><a href='media.php?module=certificate'><i class='fa fa-briefcase'></i> Sertifikat</a></li>";
												echo "<li><a href='media.php?module=lapor'><i class='fa fa-book'></i> Laporan</a></li>";
												echo "<li><a href='media.php?module=inquiry'><i class='fa fa fa-search'></i> Inquiry</a></li>";
												echo "<li><a href='media.php?module=rollback'><i class='fa fa-recycle'></i> Rollback</a></li>";
												echo "<li><a href='media.php?module=cancel'><i class='fa fa fa-search'></i> Pembatalan</a></li>";
												echo "<li><a href='media.php?module=clmverif'><i class='fa fa-search'></i> Klaim Verif </a></li>";
												echo "<li><a><i class='fa fa-wrench'></i> Master<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=mscab'><i class='fa fa-search'></i> Cabang</a></li>";
												echo "<li><a href='media.php?module=msmitra'><i class='fa fa-search'></i> Mitra </a></li>";
												echo "<li><a href='media.php?module=msuser'><i class='fa fa-search'></i> User</a></li>";
												echo "<li><a href='media.php?module=msrate'><i class='fa fa-search'></i> Rate</a></li>";
												echo "</ul>";
												echo "<li><a><i class='fa fa-pencil-square-o'></i> Maintenance<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=bordero'><i class='fa fa-book'></i> Bordero</a></li>";
												echo "<li><a href='media.php?module=revisi'><i class='fa fa-book'></i> Revisi</a></li>";
												
												echo "</ul>";
												
                                          	}	

											elseif ($_SESSION['idLevel'] == "insurance") {

												echo "<li><a href='media.php?module=valid'><i class='fa fa-check-square'></i> Validasi</a></li>";
												echo "<li><a href='media.php?module=certificate'><i class='fa fa-briefcase'></i> Sertifikat</a></li>";
												echo "<li><a href='media.php?module=lapor'><i class='fa fa-book'></i> Laporan</a></li>";
												echo "<li><a href='media.php?module=inquiriv'><i class='fa fa fa-search'></i> Inquiry</a></li>";
												echo "<li><a href='media.php?module=cancel'><i class='fa fa fa-search'></i> Pembatalan</a></li>";
												echo "<li><a href='media.php?module=clmvalid'><i class='fa fa-search'></i> Klaim Valid</a></li>";
												

												echo "<li><a><i class='fa fa-wrench'></i> Master<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=mscab'><i class='fa fa-search'></i> Cabang</a></li>";
												echo "<li><a href='media.php?module=msmitra'><i class='fa fa-search'></i> Mitra </a></li>";
												echo "<li><a href='media.php?module=msuser'><i class='fa fa-search'></i> User</a></li>";
												echo "<li><a href='media.php?module=msrate'><i class='fa fa-search'></i> Rate</a></li>";
												echo "</ul>";
												echo "<li><a><i class='fa fa-pencil-square-o'></i> Maintenance<span class='fa fa-chevron-down'></span></a>";
												echo "<ul class='nav child_menu'>";
												echo "<li><a href='media.php?module=bordero'><i class='fa fa-book'></i> Bordero</a></li>";
												echo "<li><a href='media.php?module=revisi'><i class='fa fa-book'></i> Revisi</a></li>";
												
												echo "</ul>";
												
                                          	}					
											elseif ($_SESSION['idLevel'] == "smon") {

												echo "<li><a href='media.php?module=inquiric'><i class='fa fa fa-search'></i> Inquiry</a></li>";
												echo "<li><a href='media.php?module=certificate'><i class='fa fa-briefcase'></i> Sertifikat</a></li>";
												echo "<li><a href='media.php?module=dashboard'><i class='fa fa-dashboard'></i> Dashboard</a></li>";
												echo "<li><a href='media.php?module=lapor'><i class='fa fa-book'></i> Laporan</a></li>";

												
												

												
												
												echo "</ul>";
												
                                          	}																
											else {
                                                echo "";
                                            }
                                        }
                                        ?>
								                            
                                   
								
								<!--<li><a href="media.php?module=laporan"><i class="fa fa-table"></i> Laporan </a></li>-->
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->

                  
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="images/users.png" alt=""><?php echo $rOn['nama']; ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    
                                    <li><a href="media.php?module=keluar"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>
						</ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->


            <!-- page content -->
                <?php include("content.php"); ?>
            <!-- end content -->
            
                </div>

                <!-- footer content -->

           
            </div>
            <!-- /page content -->

        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>
    <script src="js/custom.js"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="js/moment.min2.js"></script>
    <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
    <!-- input mask -->
    <script src="js/input_mask/jquery.inputmask.js"></script>
    <!-- knob -->
    <script src="js/knob/jquery.knob.min.js"></script>
    <!-- range slider -->
    <script src="js/ion_range/ion.rangeSlider.min.js"></script>
    <!-- color picker -->
    <script src="js/colorpicker/bootstrap-colorpicker.js"></script>
    <script src="js/colorpicker/docs.js"></script>
	<!-- select2 -->
        <script src="js/select/select2.full.js"></script>
        <!-- form validation -->
        <script type="text/javascript" src="js/parsley/parsley.min.js"></script>
    <!-- image cropping -->
    <script src="js/cropping/cropper.min.js"></script>
    <script src="js/cropping/main2.js"></script>

	<script src="js/textarea/autosize.min.js"></script>
        <script>
            autosize($('.resizable_textarea'));
        </script>
        <!-- Autocomplete -->
        <script type="text/javascript" src="js/autocomplete/countries.js"></script>
        <script src="js/autocomplete/jquery.autocomplete.js"></script>
        <script type="text/javascript">
            $(function () {
                'use strict';
                var countriesArray = $.map(countries, function (value, key) {
                    return {
                        value: value,
                        data: key
                    };
                });
                // Initialize autocomplete with custom appendTo:
                $('#autocomplete-custom-append').autocomplete({
                    lookup: countriesArray,
                    appendTo: '#autocomplete-container'
                });
            });
        </script>
    <!-- datepicker -->
    <script type="text/javascript">
        $(document).ready(function () {

            var cb = function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
            }

            var optionSet1 = {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2015',
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            };

            $('#reportrange_right span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            $('#reportrange_right').daterangepicker(optionSet1, cb);

            $('#reportrange_right').on('show.daterangepicker', function () {
                console.log("show event fired");
            });
            $('#reportrange_right').on('hide.daterangepicker', function () {
                console.log("hide event fired");
            });
            $('#reportrange_right').on('apply.daterangepicker', function (ev, picker) {
                console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
            });
            $('#reportrange_right').on('cancel.daterangepicker', function (ev, picker) {
                console.log("cancel event fired");
            });

            $('#options1').click(function () {
                $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb);
            });

            $('#options2').click(function () {
                $('#reportrange_right').data('daterangepicker').setOptions(optionSet2, cb);
            });

            $('#destroy').click(function () {
                $('#reportrange_right').data('daterangepicker').remove();
            });

        });
    </script>
    <!-- datepicker -->
    <script type="text/javascript">
        $(document).ready(function () {

            var cb = function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
            }

            var optionSet1 = {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2015',
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            };
            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange').daterangepicker(optionSet1, cb);
            $('#reportrange').on('show.daterangepicker', function () {
                console.log("show event fired");
            });
            $('#reportrange').on('hide.daterangepicker', function () {
                console.log("hide event fired");
            });
            $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
            });
            $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
                console.log("cancel event fired");
            });
            $('#options1').click(function () {
                $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
            });
            $('#options2').click(function () {
                $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
            });
            $('#destroy').click(function () {
                $('#reportrange').data('daterangepicker').remove();
            });
        });
    </script>
    <!-- /datepicker -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#single_cal1').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_1"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#single_cal2').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_2"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#single_cal3').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_3"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#single_cal4').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#reservation').daterangepicker(null, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    </script>
    <!-- /datepicker -->
    <!-- input_mask -->
    <script>
        $(document).ready(function () {
            $(":input").inputmask();
        });
    </script>
    <!-- /input mask -->
    <!-- ion_range -->
    <script>
        $(function () {
            $("#range_27").ionRangeSlider({
                type: "double",
                min: 1000000,
                max: 2000000,
                grid: true,
                force_edges: true
            });
            $("#range").ionRangeSlider({
                hide_min_max: true,
                keyboard: true,
                min: 0,
                max: 5000,
                from: 1000,
                to: 4000,
                type: 'double',
                step: 1,
                prefix: "$",
                grid: true
            });
            $("#range_25").ionRangeSlider({
                type: "double",
                min: 1000000,
                max: 2000000,
                grid: true
            });
            $("#range_26").ionRangeSlider({
                type: "double",
                min: 0,
                max: 10000,
                step: 500,
                grid: true,
                grid_snap: true
            });
            $("#range_31").ionRangeSlider({
                type: "double",
                min: 0,
                max: 100,
                from: 30,
                to: 70,
                from_fixed: true
            });
            $(".range_min_max").ionRangeSlider({
                type: "double",
                min: 0,
                max: 100,
                from: 30,
                to: 70,
                max_interval: 50
            });
            $(".range_time24").ionRangeSlider({
                min: +moment().subtract(12, "hours").format("X"),
                max: +moment().format("X"),
                from: +moment().subtract(6, "hours").format("X"),
                grid: true,
                force_edges: true,
                prettify: function (num) {
                    var m = moment(num, "X");
                    return m.format("Do MMMM, HH:mm");
                }
            });
        });
    </script>
    <!-- /ion_range -->
    <!-- knob -->
    <script>
        $(function ($) {

            $(".knob").knob({
                change: function (value) {
                    //console.log("change : " + value);
                },
                release: function (value) {
                    //console.log(this.$.attr('value'));
                    console.log("release : " + value);
                },
                cancel: function () {
                    console.log("cancel : ", this);
                },
                /*format : function (value) {
                 return value + '%';
                 },*/
                draw: function () {

                    // "tron" case
                    if (this.$.data('skin') == 'tron') {

                        this.cursorExt = 0.3;

                        var a = this.arc(this.cv) // Arc
                            ,
                            pa // Previous arc
                            , r = 1;

                        this.g.lineWidth = this.lineWidth;

                        if (this.o.displayPrevious) {
                            pa = this.arc(this.v);
                            this.g.beginPath();
                            this.g.strokeStyle = this.pColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                            this.g.stroke();
                        }

                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                        this.g.stroke();

                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();

                        return false;
                    }
                }
            });

            // Example of infinite knob, iPod click wheel
            var v, up = 0,
                down = 0,
                i = 0,
                $idir = $("div.idir"),
                $ival = $("div.ival"),
                incr = function () {
                    i++;
                    $idir.show().html("+").fadeOut();
                    $ival.html(i);
                },
                decr = function () {
                    i--;
                    $idir.show().html("-").fadeOut();
                    $ival.html(i);
                };
            $("input.infinite").knob({
                min: 0,
                max: 20,
                stopper: false,
                change: function () {
                    if (v > this.cv) {
                        if (up) {
                            decr();
                            up = 0;
                        } else {
                            up = 1;
                            down = 0;
                        }
                    } else {
                        if (v < this.cv) {
                            if (down) {
                                incr();
                                down = 0;
                            } else {
                                down = 1;
                                up = 0;
                            }
                        }
                    }
                    v = this.cv;
                }
            });
        });
    </script>
	
	<script type="text/javascript" src="js/wizard/jquery.smartWizard.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // Smart Wizard 	
            $('#wizard').smartWizard();

            function onFinishCallback() {
                $('#wizard').smartWizard('showMessage', 'Finish Clicked');
                alert('Finish Clicked');
            }
        });

        $(document).ready(function () {
            // Smart Wizard	
            $('#wizard_verticle').smartWizard({
                transitionEffect: 'slide'
            });

        });
    </script>
	<script>
            $(document).ready(function () {
                $(".select2_single").select2({
                    placeholder: "Select a state",
                    allowClear: true
                });
                $(".select2_group").select2({});
                $(".select2_multiple").select2({
                    maximumSelectionLength: 4,
                    placeholder: "With Max Selection limit 4",
                    allowClear: true
                });
            });
        </script>
        <!-- /select2 -->
        <!-- input tags -->
        <script>
            function onAddTag(tag) {
                alert("Added a tag: " + tag);
            }

            function onRemoveTag(tag) {
                alert("Removed a tag: " + tag);
            }

            function onChangeTag(input, tag) {
                alert("Changed a tag: " + tag);
            }

            $(function () {
                $('#tags_1').tagsInput({
                    width: 'auto'
                });
            });
        </script>
        <!-- /input tags -->
        <!-- form validation -->
        <script type="text/javascript">
            $(document).ready(function () {
                $.listen('parsley:field:validate', function () {
                    validateFront();
                });
                $('#demo-form .btn').on('click', function () {
                    $('#demo-form').parsley().validate();
                    validateFront();
                });
                var validateFront = function () {
                    if (true === $('#demo-form').parsley().isValid()) {
                        $('.bs-callout-info').removeClass('hidden');
                        $('.bs-callout-warning').addClass('hidden');
                    } else {
                        $('.bs-callout-info').addClass('hidden');
                        $('.bs-callout-warning').removeClass('hidden');
                    }
                };
            });

            $(document).ready(function () {
                $.listen('parsley:field:validate', function () {
                    validateFront();
                });
                $('#demo-form2 .btn').on('click', function () {
                    $('#demo-form2').parsley().validate();
                    validateFront();
                });
                var validateFront = function () {
                    if (true === $('#demo-form2').parsley().isValid()) {
                        $('.bs-callout-info').removeClass('hidden');
                        $('.bs-callout-warning').addClass('hidden');
                    } else {
                        $('.bs-callout-info').addClass('hidden');
                        $('.bs-callout-warning').removeClass('hidden');
                    }
                };
            });
            try {
                hljs.initHighlightingOnLoad();
            } catch (err) {}
        </script>
        <!-- /form validation -->
        <!-- editor -->
        <script>
            $(document).ready(function () {
                $('.xcxc').click(function () {
                    $('#descr').val($('#editor').html());
                });
            });

            $(function () {
                function initToolbarBootstrapBindings() {
                    var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                'Times New Roman', 'Verdana'],
                        fontTarget = $('[title=Font]').siblings('.dropdown-menu');
                    $.each(fonts, function (idx, fontName) {
                        fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
                    });
                    $('a[title]').tooltip({
                        container: 'body'
                    });
                    $('.dropdown-menu input').click(function () {
                            return false;
                        })
                        .change(function () {
                            $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                        })
                        .keydown('esc', function () {
                            this.value = '';
                            $(this).change();
                        });

                    $('[data-role=magic-overlay]').each(function () {
                        var overlay = $(this),
                            target = $(overlay.data('target'));
                        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
                    });
                    if ("onwebkitspeechchange" in document.createElement("input")) {
                        var editorOffset = $('#editor').offset();
                        $('#voiceBtn').css('position', 'absolute').offset({
                            top: editorOffset.top,
                            left: editorOffset.left + $('#editor').innerWidth() - 35
                        });
                    } else {
                        $('#voiceBtn').hide();
                    }
                };

                function showErrorAlert(reason, detail) {
                    var msg = '';
                    if (reason === 'unsupported-file-type') {
                        msg = "Unsupported format " + detail;
                    } else {
                        console.log("error uploading file", reason, detail);
                    }
                    $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
                };
                initToolbarBootstrapBindings();
                $('#editor').wysiwyg({
                    fileUploadError: showErrorAlert
                });
                window.prettyPrint && prettyPrint();
            });
        </script>
    <!-- /datepicker -->
    <!-- /footer content -->


		

</body>

</html>
<?php
}
?>