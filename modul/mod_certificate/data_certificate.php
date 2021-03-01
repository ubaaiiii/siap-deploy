<?php
    session_start();
    include("../../config/koneksi.php");
    include("../../config/cek_akses.php");
    include("../../config/fungsi_all.php");
    
    $vlevel=$_SESSION['idLevel'];
    $userid=$_SESSION['idLog'];

	//data kolom yang akan di tampilkan
	$aColumns = array( 'asuransi','regid','nama','tgllahir','mulai','up','premi','produk','masa','nopeserta','status','policyno','status_code' );
	$aSelect  = array( 'ma.msdesc asuransi','regid','nama','tgllahir','mulai','up','premi','pd.msdesc produk','masa','nopeserta','ab.msdesc status','aa.policyno','aa.status status_code' );
	
	/*Column:
	[0] Asuransi
	[1] Regid
	[2] Nama
	[3] Tanggal Lahir
	[4] Mulai
	[5] UP
	[6] Premi
	[7] Produk
	[8] Masa
	[9] No Pinjaman
	[10] Status
	[11] Regid
	*/
	
	//primary key
	$sIndexColumn = "regid";
                
    $sTable = "tr_sppa aa";
    
    $sJoin = " INNER JOIN ms_master ab
                       ON aa.status = ab.msid
                          AND ab.mstype = 'STREQ'
               INNER JOIN ms_master ma
                       ON aa.asuransi = ma.msid
                          AND ma.mstype = 'ASURANSI'
               INNER JOIN ms_master pd
                      ON pd.msid = aa.produk
                         AND pd.mstype = 'produk'";
    
    $sWhere_ori = "WHERE  aa.status IN ( '5', '6', '20', '73', '83' ) ";
	
	if ($vlevel=="smkt" )
    {
    	$sWhere_ori .= " AND aa.createby IN (SELECT
                                            CASE
                                                WHEN a.parent=a.username THEN a.parent
                                                ELSE a.username
                                            END
                                         FROM   ms_admin a
                                         WHERE  (a.username = '$userid' OR a.parent = '$userid')) ";
    }
    
    if ($vlevel=="mkt" )
    {
    	$sWhere_ori .= " AND aa.createby = '$userid' ";
    }
    
    if ($vlevel=="checker" || $vlevel=="schecker" )
    {
    	$sWhere_ori .= " AND cabang LIKE (SELECT
                                        CASE
                                            WHEN cabang = 'ALL' THEN '%%'
                                            ELSE cabang
                                        END cabang
                                      FROM   ms_admin
                                      WHERE  username = '$userid' ) ";
    }
    
    if ($vlevel=="broker" )
    {
    
    }
    
    if ($vlevel=="insurance" )
    {
    	$sWhere_ori .= " AND aa.asuransi IN (SELECT cabang
                                           FROM   ms_admin
                                           WHERE  level = 'insurance'
                                           AND    username = '$userid' ) ";
    }
 
	$sLimit = "";
	if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
	{
		$sLimit = "LIMIT ".$db->real_escape_string( $_POST['start'] ).", ".
			$db->real_escape_string( $_POST['length'] );
	}
	
	if ( isset( $_POST['order'][0]['column'] ) )
	{
		$sOrder = "ORDER BY ";
		for ( $i=0 ; $i<count( $_POST['order'] ) ; $i++ )
		{
			$sOrder .= " " . $aColumns[$_POST['order'][$i]['column']] . " " . $_POST['order'][$i]['dir'];
			if ($i + 1 !== count( $_POST['order'] )) {
			    $sOrder .= ",";
			}
		}
		
	}
	
	$sWhere_filter= $sWhere_ori;
	if ( $_POST['search']['value'] != "" )
	{
		$sWhere_filter.= " AND (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere_filter.= explode(" ",$aSelect[$i])[0]." LIKE '%".$db->real_escape_string( $_POST['search']['value'] )."%' OR ";
		}
		$sWhere_filter= substr_replace( $sWhere_filter, "", -3 );
		$sWhere_filter.= ')';
	}
	
	
	$sQuery = "
	    SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aSelect))."
		FROM   $sTable
		$sJoin
		$sWhere_filter
		$sOrder
		$sLimit
	";
	
// 	foreach ($_POST as $key => $value) {
//         echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."\n";
//     }
    // echo json_encode($_POST['order'][0]['column']);die;
//     echo json_encode($_POST);die;
// 	echo $sQuery;die;
	$rResult = $db->query( $sQuery ) or die($db->error);
	
	$sQuery = "
		SELECT FOUND_ROWS()
	";

	$rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
	$aResultFilterTotal = $rResultFilterTotal->fetch_array();
	$iFilteredTotal = $aResultFilterTotal[0];

	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
		$sJoin
		$sWhere_ori
	";
	
	$rResultTotal = $db->query( $sQuery ) or die($db->error);
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
			else if ( $aColumns[$i] != ' ' && $aColumns[$i] != '' && $aColumns[$i] != null )
			{
			    if ( $aColumns[$i] == 'reg_encode' ) {
                      $row[] = encrypt_decrypt("encrypt",$aRow[ $aColumns[$i] ]);
			    } else {
                      $row[] = $aRow[ $aColumns[$i] ];
			    }
				// $row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
    // var_dump($output);
?>