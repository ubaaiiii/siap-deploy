<?php
	session_start();
	include("config/koneksi.php");

	$user   = $_POST['user'];
	$pass   = md5($_POST['pass']);

	$sql    = " SELECT a.username,a.level,a.cabang FROM ms_admin a ";
	$sql    = $sql . " where a.username='$user' AND a.password='$pass'  ";
	// 
	file_put_contents('eror.txt',$sql, FILE_APPEND | LOCK_EX);    
	$query  = $db->query($sql);
	
	$r      = $query->fetch_array();
	$num    = $query->num_rows;

	if($num >= 1){
		$_SESSION['idLog']=$r['username'];
		$_SESSION['idLevel']=$r['level'];
		$_SESSION['id_peg']=$r['id_peg'];

		$_SESSION['ucab']=$r['cabang'];
		$id=$r['username'];
		$tgl= Date("Y-m-d H:i:s");
		$id=$_SESSION['idLog'];
		
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   
			  {
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			  }
			//whether ip is from proxy
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
			  {
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			  }
			//whether ip is from remote address
			else
			  {
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			  }
			

			$queryLogtemp=$db->query("INSERT INTO log_temp (username, tgl_temp,ipaddress) VALUES ('$user',now(),'$ipaddress')");
		header("location:media.php?module=home");
	}
	else{
		echo "
			<script>
				alert('Username dan Password anda salah!');
				window.location='index.php';
			</script>
		";
	}
?>