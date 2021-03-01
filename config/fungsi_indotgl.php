<?php
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
			
	function hitung_umur($tanggal_lahir) {
		list($year,$month,$day) = explode("-",$tanggal_lahir);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($month_diff < 0) $year_diff--;
			elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
		return $year_diff;
	}
	function tgl_akhir($tglmulai,$masa) {
		$stgla = date('Y-m-d', strtotime('+' . $masa. 'months', strtotime($tglmulai))); //operasi penjumlahan tanggal sebanyak x bulan
	return $stgla;
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
?>
