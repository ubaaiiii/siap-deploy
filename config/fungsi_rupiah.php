<?php
function format_rupiah($angka){
	if($angka!='-' AND $angka!=''){
		$rupiah=number_format($angka,0,',','.');
		return $rupiah;
	}else{
	
	}
}
?> 
