<?php
    session_start();
    include("../../config/koneksi.php");
    include("../../config/fungsi_all.php");
    
    $vlevel = $_SESSION['idLevel'];
    $userid = $_SESSION['idLog'];
    
    if ($vlevel == "insurance") {
        $custCol = ",'-',(IF(ae.borderono IS NOT NULL, 'YES', 'NO'))";
        $custJoin= " LEFT JOIN tr_bordero_dtl ae
                              ON ae.regid = aa.regid ";
    } else {
        $custCol = "";
        $custJoin= "";
    }

	//data kolom yang akan di tampilkan
	$aColumns = array( 'regid','nama','cabang','tgllahir','tglbatal','mulai','up','premi','status','aksi','reg_encode' );
	
	//primary key
	$sIndexColumn = "regid";
	
	//nama table database
	$sTable = "(SELECT aa.regid, 
                       aa.nama, 
                       ad.msdesc 'cabang', 
                       aa.tgllahir, 
                       ab.tglbatal,
                       aa.mulai, 
                       aa.up, 
                       aa.premi, 
                       ac.msdesc 'status', 
                       Concat(aa.regid, '-', aa.status, '-', aa.policyno $custCol) 'aksi',
                       aa.regid reg_encode
                FROM   tr_sppa aa 
                       INNER JOIN tr_sppa_cancel ab 
                               ON aa.regid = ab.regid 
                       LEFT JOIN ms_master ac 
                              ON ac.msid = aa.status 
                                 AND ac.mstype = 'STREQ' 
                       LEFT JOIN ms_master ad 
                              ON ad.msid = aa.cabang 
                                 AND ad.mstype = 'CAB' 
                       $custJoin  ";
	
	if ($vlevel=="checker" or $vlevel=="schecker") {
		$sTable .= "WHERE aa.status IN ('7','73','8','83','84','85')
		                AND aa.cabang like (SELECT CASE WHEN cabang='ALL' THEN '%%'
                                                      ELSE cabang END cabang
		                                  FROM ms_admin
		                                  WHERE username = '$userid') ) t_baru";
		                                  
    } else if ($vlevel=="broker") {
	    $sTable .= "WHERE aa.status IN ('7','8','71','81','83') ) t_baru";
	    
		                                
	} else if ($vlevel=="insurance") {
        $sTable .= "WHERE (aa.status IN ('72','82')
                        OR (aa.status = '84' AND ae.borderono IS NOT NULL))
                        AND aa.asuransi IN (SELECT cabang
                                        FROM ms_admin
                                        WHERE level='insurance' AND username='$userid' ) ) t_baru";
                                        
	}
 
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
	$rResult = $db->query( $sQuery, $gaSql['link'] ) or die($db->error());
	
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = $db->query( $sQuery, $gaSql['link'] ) or die($db->error());
	$aResultFilterTotal = $rResultFilterTotal->fetch_array();
	$iFilteredTotal = $aResultFilterTotal[0];
	
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
	";
	$rResultTotal = $db->query( $sQuery, $gaSql['link'] ) or die($db->error());
	$aResultTotal = $rResultTotal->fetch_array();
	$iTotal = $aResultTotal[0];
	
	$output = array(
		"sEcho" => intval($_POST['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = $rResult->fetch_assoc() )
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
				if ( $aColumns[$i] == 'reg_encode' ) {
    				$row[] = encrypt_decrypt("encrypt",$aRow[ $aColumns[$i] ]);
			    } else {
    				$row[] = $aRow[ $aColumns[$i] ];
			    }
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>