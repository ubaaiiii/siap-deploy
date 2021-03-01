<?php
    session_start();
    include("../../config/koneksi.php");
    
    $vlevel=$_SESSION['idLevel'];
    $userid=$_SESSION['idLog'];

	//data kolom yang akan di tampilkan
	$aColumns = array( 'regclaim','regid','produk','nama','cabang','tgllapor','tglkejadian','up','nilaios','status','aksi' );
	
	//primary key
	$sIndexColumn = "regclaim";
	
	//nama table database
	$sTable = "(SELECT  tc.regclaim, 
	                    tr.regid, 
	                    tp.msdesc 'produk',
                        tr.nama, 
                        tb.msdesc 'cabang', 
                        tr.up, 
                        tc.nilaios, 
                        tr.premi, 
                        tc.tglkejadian, 
                        tc.tgllapor, 
                        ts.msdesc 'status',
                        concat(tc.regclaim,'-',tr.regid,'-',tr.status,'-',tr.nama) 'aksi'
                 FROM   tr_sppa tr
                        INNER JOIN tr_claim tc 
                                ON tc.regid = tr.regid 
                        INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='STREQ') ts 
                                ON ts.msid = tr.status 
                        INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='PRODUK') tp
                                ON tp.msid = tr.produk
                        INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='CAB') tb
                                ON tb.msid = tr.cabang ";
	
	if ($vlevel=="schecker" or $vlevel=="checker" )
    {
    	$sTable .= "WHERE tr.status='90' 
                        AND tr.cabang LIKE (SELECT 
                                                CASE 
                                                    WHEN cabang='ALL' THEN '%%' 
                                                    ELSE cabang 
                                                END cabang 
                                            FROM   ms_admin 
                                            WHERE  username='$userid' ) )t_baru";
    }
    
    if ($vlevel=="broker"   )
    {
    	$sTable .= "WHERE tr.status='91' ) t_baru";
    }
    
    if ($vlevel=="insurance"   )
    {
    	$sTable .= "WHERE tr.status IN ('92','93') 
                        AND tr.asuransi IN (SELECT cabang 
                                            FROM   ms_admin 
                                            WHERE  level='insurance' 
                                                AND username='$userid' ) ) t_baru";
    	
    }
 
	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
	
 
	$sLimit = "";
	if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_POST['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_POST['iDisplayLength'] );
	}
	
	if ( isset( $_POST['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
		{
			if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
				 	".mysql_real_escape_string( $_POST['sSortDir_'.$i] ) .", ";
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
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_POST['sSearch'] )."%' OR ";
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
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_POST['sSearch_'.$i])."%' ";
		}
	}
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	$output = array(
		"sEcho" => intval($_POST['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
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