<?php

//breadcrumbs

function breadcrumbs1() {
$delimiter = '&rsaquo;';
$home = 'Home';

echo '<div xmlns:v="http://rdf.data-vocabulary.org/#">';
global $post;
echo ' <span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title" href="'.home_url( '/' ).'">'.$home.'</a>
</span> ';
$cats = get_the_category();
if ($cats) {
foreach($cats as $cat) {
echo $delimiter . "<span typeof=\"v:Breadcrumb\">
<a rel=\"v:url\" property=\"v:title\" href=\"".get_category_link($cat->term_id)."\" >$cat->name</a>
</span>"; }
}
echo $delimiter . the_title(' <span>', '</span>', false);
echo '</div>';
}
function baliktgl($tgl) {
	//21/12/2010
	$hari = substr($tgl,0,2);
	$bln = substr($tgl,3,2);
	$thn = substr($tgl,6,4);
	$tgle = $thn."-".$bln."-".$hari;
	return $tgle;
	}

function simpantglentodb($tgl) {
	//21/12/2010
	$bln = substr($tgl,0,2);
	$hari = substr($tgl,3,2);
	$thn = substr($tgl,6,4);
	$tglb = $thn."-".$bln."-".$hari;
	return $tglb;
	}
function simpantglidtodb($tgl) {
	//21/12/2010
	$bln = substr($tgl,3,2);
	$hari = substr($tgl,0,2);
	$thn = substr($tgl,6,4);
	$tglb = $thn."-".$bln."-".$hari;
	return $tglb;
	}
	
	function tgl_indo($tgl){
			$tanggal = substr($tgl,0,2);
			$bulan = getBulan(substr($tgl,3,4));
			$tahun = substr($tgl,6,9);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}
	
	function tgl_indo2($tgl){
			$tanggal = substr($tgl,3,2);
			$bulan = getBulan(substr($tgl,0,2));
			$tahun = substr($tgl,6,9);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}

	function tglindo_yyyymmdd($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan = getBulan(substr($tgl,6,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
			#2018-01-08
			#1234567890
	}
	function tglindo_balik($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan =  substr($tgl,5,2);
			$tahun = substr($tgl,0,4);
			return $tanggal.'-'.$bulan.'-'.$tahun;		 
	}
	
	function getBln($tgl){
			$tanggal = substr($tgl,0,2);
			$bulan = getBulan(substr($tgl,3,4));
			$tahun = substr($tgl,6,9);
			return $bulan;		 
	}


	
	function getBulan($bln){
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			} 
			
function format_rupiah($angka){
	if($angka!='-' AND $angka!=''){
		$rupiah="Rp. ".number_format($angka,0,',','.');
		return $rupiah;
	}else{
	
	}
}

function Terbilang($satuan){
$huruf = array ("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", 
"Tujuh", "Delapan", "Sembilan", "Sepuluh","Sebelas");
if ($satuan < 12)
 return " ".$huruf[$satuan];
elseif ($satuan < 20)
 return Terbilang($satuan - 10)." Belas";
elseif ($satuan < 100)
 return Terbilang($satuan / 10)." Puluh".
 Terbilang($satuan % 10);
elseif ($satuan < 200)
 return "seratus".Terbilang($satuan - 100);
elseif ($satuan < 1000)
 return Terbilang($satuan / 100)." Ratus".
 Terbilang($satuan % 100);
elseif ($satuan < 2000)
 return "seribu".Terbilang($satuan - 1000); 
elseif ($satuan < 1000000)
 return Terbilang($satuan / 1000)." Ribu".
 Terbilang($satuan % 1000); 
elseif ($satuan < 1000000000)
 return Terbilang($satuan / 1000000)." Juta".
 Terbilang($satuan % 1000000); 
elseif ($satuan >= 1000000000)
 echo "Angka terlalu Besar";
}

function encrypt_decrypt($action, $string, $encryption_key = null) 
{
    if ($encryption_key == null) {
        $encryption_key = $_SESSION['token'];
    }
    $iv = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
    
    if (!$encryption_key) {
        return "TOKEN = NULL<br>Harap Re-Login SIAP.";
    } else {
        if($action == 'encrypt') {
            $encrypted = openssl_encrypt($string, 'aes-128-ctr', $encryption_key, 0, $iv);
            return base64_encode($encrypted . '::' . $iv);
        } elseif ($action == 'decrypt') {
            list($encrypted_data, $iv) = explode('::', base64_decode($string), 2);
            return openssl_decrypt($encrypted_data, 'aes-128-ctr', $encryption_key, 0, $iv);
        } else {
            return null;
        }
    }
}

?>