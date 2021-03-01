<?php
    session_start();
    include("../../config/koneksi.php");
    include("../../config/cek_akses.php");
    include("../../config/fungsi_all.php");
    
    $vlevel = $_SESSION['idLevel'];
    $userid = $_SESSION['idLog'];
    
	//data kolom yang akan di tampilkan
	$aColumns = array( 'asuransi','cabang','produk','createby','regid','policyno','nama','tgllahir','mulai','up','premi','status','aksi','reg_encode' );
	
	//primary key
	$sIndexColumn = "regid";
	
	//nama table database
	$sTable = "(SELECT 
                    b.msdesc 'asuransi',
                    c.msdesc 'cabang',
                    d.msdesc 'produk',
                    a.createby,
                    regid,
                    policyno,
                    nama,
                    tgllahir,
                    mulai,
                    up,
                    premi,
                    e.msdesc 'status',
                    Concat(regid, '-', status, '-', (IF(policyno IS NOT NULL, policyno, 'null'))) aksi,
                    regid reg_encode
                FROM `tr_sppa` a
                INNER JOIN ms_master b
                	ON a.asuransi = b.msid
                    AND b.mstype = 'asuransi'
                INNER JOIN ms_master c
                	ON a.cabang = c.msid
                    AND c.mstype = 'cab'
                INNER JOIN ms_master d
                	ON a.produk = d.msid
                    AND d.mstype = 'produk'
                INNER JOIN ms_master e
                	ON a.status = e.msid
                    AND e.mstype = 'streq'
                WHERE up != ''
                	AND premi != 0  ";
		
	if ($vlevel == 'mkt' or $vlevel == 'smkt') {
	    $sTable .= "AND a.createby IN ( SELECT CASE 
                                                    WHEN a.parent=a.username THEN a.parent 
                                                    ELSE a.username 
                                                END 
                                         FROM   ms_admin a 
                                         WHERE  ( a.username='$userid' OR a.parent='$userid'))";
	    
	} elseif ($vlevel=="schecker" or $vlevel=="checker") {
		$sTable .= "AND a.cabang like (SELECT CASE WHEN cabang='ALL' THEN '%%'
                                                      ELSE cabang END cabang
		                                  FROM ms_admin
		                                  WHERE username='$userid')";
		                                  
    } else if ($vlevel=="broker") {
	    $sTable .= "";
	    
		                                
	} else if ($vlevel=="insurance") {
        $sTable .= "AND a.asuransi LIKE (SELECT cabang
                                        FROM ms_admin
                                        WHERE level='insurance' AND username='$userid' )";
                                        
	}
	
	$mitra = ($_SESSION['idMitra'] == NULL)?('NOM'):($_SESSION['idMitra']);
	if ($mitra !== 'NOM') {
	    $sTable .= " AND a.mitra = '$mitra' ";
	}
	
// 	if ($_POST['sSearch'] == '') {
// 	    $sTable .= " ORDER BY a.createdt DESC LIMIT 100 ";
// 	}
	$sTable .= ") t_baru";
	
// 	echo $sTable;die;
 
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
		"aaData" => array(),
		"console" => $sLimit
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
			else if ( $aColumns[$i] != ' ' && $aColumns[$i] != '' && $aColumns[$i] != null )
			{
				// if ( $aColumns[$i] == 'reg_encode' ) {
    // 				$row[] = encrypt_decrypt("encrypt",$aRow[ $aColumns[$i] ]);
			 //   } else {
    // 				$row[] = $aRow[ $aColumns[$i] ];
			 //   }
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
// echo $sTable;
?>