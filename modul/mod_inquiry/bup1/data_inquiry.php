<?php
    session_start();
    include("../../config/koneksi.php");
    
    $vlevel = $_SESSION['idLevel'];
    $userid = $_SESSION['idLog'];
    
	//data kolom yang akan di tampilkan
	$aColumns = array( 'asuransi','cabang','produk','createby','regid','policyno','nama','tgllahir','mulai','up','premi','status','aksi' );
	
	//primary key
	$sIndexColumn = "regid";
	
	//nama table database
	$sTable = "( SELECT mc.msdesc                  cabang, 
                        ma.msdesc                  asuransi, 
                        mp.msdesc                  produk, 
                        aa.createby, 
                        regid, 
                        policyno, 
                        nama, 
                        tgllahir, 
                        mulai, 
                        up, 
                        premi, 
                        ms.msdesc                  status, 
                        Concat(aa.regid, '-', aa.status, '-', (IF(aa.policyno IS NOT NULL, aa.policyno, 'null'))) aksi 
                 FROM   (select * from tr_sppa where nama LIKE '%".mysql_real_escape_string( $_POST['sSearch'] )."%'
						or regid LIKE '%".mysql_real_escape_string( $_POST['sSearch'] )."%' 
						or nopeserta LIKE '%".mysql_real_escape_string( $_POST['sSearch'] )."%' 
						or noktp LIKE '%".mysql_real_escape_string( $_POST['sSearch'] )."%' 
						) aa 
                        LEFT JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'ASURANSI') ma 
                                ON ma.msid = aa.asuransi 
                        INNER JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'CAB') mc 
                                ON mc.msid = aa.cabang 
                        INNER JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'STREQ') ms 
                                ON ms.msid = aa.status 
                        INNER JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'PRODUK') mp 
                                ON mp.msid = aa.produk 
                        
                 WHERE  aa.up != '' 
                        AND aa.premi != 0  ";
		
	if ($vlevel == 'mkt' or $vlevel == 'smkt') {
	    $sTable .= "AND aa.createby IN ( SELECT CASE 
                                                    WHEN a.parent=a.username THEN a.parent 
                                                    ELSE a.username 
                                                END 
                                         FROM   ms_admin a 
                                         WHERE  ( a.username='$userid' OR a.parent='$userid'))";
	    
	} elseif ($vlevel=="schecker" or $vlevel=="checker") {
		$sTable .= "AND aa.cabang like (SELECT CASE WHEN cabang='ALL' THEN '%%'
                                                      ELSE cabang END cabang
		                                  FROM ms_admin
		                                  WHERE username='$userid')";
		                                  
    } else if ($vlevel=="broker") {
	    $sTable .= "";
	    
		                                
	} else if ($vlevel=="insurance") {
        $sTable .= "AND aa.asuransi LIKE (SELECT cabang
                                        FROM ms_admin
                                        WHERE level='insurance' AND username='$userid' )";
                                        
	}
	
	if ($_POST['sSearch'] == '') {
	    $sTable .= " and datediff(now(),createdt)<100 ORDER BY aa.createdt DESC LIMIT 100";
	}
	$sTable .= ") t_baru";
 
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
// echo $sTable;
?>