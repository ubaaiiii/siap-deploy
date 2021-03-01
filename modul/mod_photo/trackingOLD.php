<script language=\"JavaScript\">
 function konfirmasi()
 {
 tanya = confirm('Anda Yakin Akan Menghapus Data ?');
 if (tanya == true) return true;
 else return false;
 }
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<?php
$apps="ASGUNA | CLIENT";
$judul="Profile ";
$topjudul="Profile ";
$sfooter="@2017-www.tugukresna.com";
$userid=$_SESSION['userid'];
$sclientcd=$_SESSION['clientcd'];
$smemberno=$_SESSION['memberno'];
$aksi="modul/mod_validasi/aksi_validasi.php";
switch ($_GET[act]){
 //Menampilkan data admin
 default:
?>
<!DOCTYPE html>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> <?php echo $apps . $judul ; ?>  </title>


  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">


            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                     <h2><?php echo $topjudul ; ?> </h2>
                 
                    <div class="clearfix"></div>
                  </div>
				  
		<!----begin page content----->
		<div class="x_content">

		<!DOCTYPE html>
		<html>
		<body>

		<form action="modul/mod_tracking/upload.php" method="post" enctype="multipart/form-data">
			Select image to upload:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload Image" name="submit">
		</form>

		</body>
		</html>
		
		
		
        </div>
		<!----end page content----->

        <!-- footer content -->
        <footer>
          <div class="pull-right"> <a href="https://tugukresna.co.id"> Asuransi Tugu Kresna Pratama</a>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

 
  </body>


<?php
break;
}
?>
   
