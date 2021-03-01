<?php
    session_start();
    include("../../config/koneksi.php");

	//data kolom yang akan di tampilkan
	$aColumns = array( 'dokumen','tipe','ukuran','tglupload','aksi' );
	
	//primary key
	$sIndexColumn = "dokumen";
	
	$regid = $_GET['regid'];
	$jenis = $_GET['jenis'];
	
	if ($jenis == 'DTCLM') {
	    $custWhere = " WHERE  mstype = (SELECT doctype
                                 FROM   tr_claim
                                 WHERE  regid = '$regid') ";
	}
	elseif ($jenis == 'DTBTL') {
	    $custWhere = " WHERE  mstype = 'FRMBATAL' ";
	}
	elseif ($jenis == 'DTRFN') {
	    $custWhere = " WHERE  mstype = 'FRMREFUND' ";
	}
	elseif ($jenis == 'DTPGJ') {
	    $custWhere = " WHERE mstype = concat('PGJ',(SELECT produk
                                 FROM   tr_sppa
                                 WHERE  regid = '$regid')) ";
	}
	else {
	    $custWhere = " WHERE mstype IN (
                        ( SELECT doctype
                          FROM   tr_claim
                          WHERE  regid = '$regid'),
                        'FRMBATAL',
                        concat('PGJ',( SELECT produk
                                       FROM   tr_sppa
                                       WHERE  regid = '$regid'))) ";
	}
	
	//nama table database
	$sTable = "(SELECT a.msdesc 'dokumen',
                       b.tipe_file 'tipe',
                       b.ukuran_file 'ukuran',
                       b.tglupload,
                       concat(
                            IF (concat(b.regid,b.seqno) IS NOT NULL, concat(b.regid,b.seqno), 'null'),
                            '-', 
                            a.msid,
                            '-',
                            IF (b.ukuran_file IS NOT NULL, b.ukuran_file, 'null'), 
                            '-', 
                            IF (b.tipe_file IS NOT NULL, b.tipe_file, 'null'), 
                            '-', 
                            a.msdesc,
                            '-',
                            IF (b.file IS NOT NULL, b.file, 'null'),
                            '-',
                            IF (a.createby IS NOT NULL, a.createby, 'null'),
                            '-',
                            IF (a.editby IS NOT NULL, a.editby, 'null')) 'aksi'
                FROM   ms_master a
                LEFT JOIN (SELECT regid, seqno, file, jnsdoc, tipe_file, ukuran_file, tglupload FROM tr_document where regid = '$regid') b
                	ON a.msid = b.jnsdoc
                $custWhere ) t_baru";
    // echo $sTable;
    // die;
 
// 	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
// 		die( 'Could not open connection to server' );
	
// 	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
// 		die( 'Could not select database '. $gaSql['db'] );
	
 
	$sLimit = "";
	if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".$db->real_escape_string( $_POST['iDisplayStart'] ).", ".
			$db->real_escape_string( $_POST['iDisplayLength'] );
	}
	
	if ( isset( $_POST['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
		{
			if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
				 	".$db->real_escape_string( $_POST['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$sWhere = "";
	if ( $_POST['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".$db->real_escape_string( $_POST['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_POST['bSearchable_'.$i] == "true" && $_POST['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".$db->real_escape_string($_POST['sSearch_'.$i])."%' ";
		}
	}
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
	$rResult = $db->query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = $db->query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = $rResultFilterTotal->fetch_array();
	$iFilteredTotal = $aResultFilterTotal[0];
	
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
	";
	$rResultTotal = $db->query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = $rResultTotal->fetch_array();
	$iTotal = $aResultTotal[0];
	
	$output = array(
		"sEcho" => intval($_POST['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = $rResult->fetch_assoc()  )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "version" )
			{
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>