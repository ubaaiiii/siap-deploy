<?php
    // mysql - ga kepake - nambahin error doang di error_log
    // @mysql_connect("localhost","siapdev_user","spm@1jkt80") or  die ("Tidak Terkoneksi");
    // @mysql_select_db('siapdev_live') or die('Database Tidak Ditemukan');

    $db = new mysqli("localhost","siapdev_user","spm@1jkt80","siapdev_live");
    if (mysqli_connect_errno()) {
        echo mysqli_connect_error();
    }

    //informasi koneksi ke database
	$gaSql['user']       = "siapdev_user";
	$gaSql['password']   = "spm@1jkt80";
	$gaSql['db']         = "siapdev_live";
	$gaSql['server']     = "localhost";
	
	// SQL server connection information
    $sql_details = array(
        'user' => 'siapdev_user',
        'pass' => 'spm@1jkt80',
        'db'   => 'siapdev_live',
        'host' => 'localhost'
    );
    
    
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from remote address
    else {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    }

?>