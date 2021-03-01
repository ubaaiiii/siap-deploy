<?php
include "/qrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA

$tempdir = "../../temp/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
    mkdir($tempdir);
	
	//lanjutan yang tadi

#parameter inputan
$isi_teks = "Belajar QR Code itu asik";
$namafile = "cobacoba.png";
$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 3; //batasan 1 paling kecil, 10 paling besar
$padding = 0;

QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);



?>