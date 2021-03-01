<?php
    session_start();
    include("../../config/koneksi.php");
    include("../../config/cek_akses.php");
    include("../../config/fungsi_all.php");
    
    $vlevel=$_SESSION['idLevel'];
    $userid=$_SESSION['idLog'];

	//data kolom yang akan di tampilkan
	$aColumns = array( 'regclaim','regid','produk','nama','cabang','tgllapor','tglkejadian','up','nilaios','status' );
	
	if (in_array($vlevel,['checker'])) {
	    array_push($aColumns,'sisawaktu','aksi');
	    $custField = "IF (tr.status IN ('93','94','95','96'),'<i class=\"green\">SELESAI</i>',
	                    IF((wkc.msdesc + wkc.createby) - Datediff(tc.tgllapor,tc.tglkejadian) < 0, NULL,
                            If((wkc.msdesc + wkc.createby) - Datediff(tc.tgllapor,tc.tglkejadian) < 15 AND tr.status='90',
                                Concat((wkc.msdesc + wkc.createby) - Datediff(tgllapor,tglkejadian),' hari <i class=\"merahin\"></i>'),
                                    Concat((wkc.msdesc + wkc.createby) - Datediff(tgllapor,tglkejadian),' hari')))) 'sisawaktu', ";
	} elseif (in_array($vlevel,['insurance','broker','schecker'])) {
	    array_push($aColumns,'jatuhtempo','aksi');
	    $custField = "concat(DATE_ADD(tc.tglkejadian, INTERVAL (wkc.msdesc + wkc.createby) DAY),
	                    IF (DATE_ADD(tc.tglkejadian, INTERVAL (wkc.msdesc + wkc.createby) DAY) < NOW(),
	                        '<span style=\"display:none;\">EXPIRED</span>',
	                        '')) as 'jatuhtempo', ";
	} else {
	    array_push($aColumns,'aksi');
	}
	
    array_push($aColumns,'reg_encode');
	
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
                        tr.regid 'reg_encode', 
                        $custField
                        concat(tc.regclaim,'-',
                               tr.regid,'-',
                               tr.status,'-',
                               tr.nama,'-',
                               IF(dok.hasil IS NULL,'Lengkap','Approve')) 'aksi'
                 FROM   tr_sppa tr
                        INNER JOIN tr_claim tc 
                                ON tc.regid = tr.regid 
                        INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='STREQ') ts 
                                ON ts.msid = tr.status 
                        INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='PRODUK') tp
                                ON tp.msid = tr.produk
                        INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='CAB') tb
                                ON tb.msid = tr.cabang
                        LEFT JOIN  (SELECT * FROM tr_document WHERE catdoc = 'clmreject') td
                                ON td.regid = tr.regid
                        LEFT JOIN  (SELECT a.regid,
                                           GROUP_CONCAT(DISTINCT IF (b.editby = 'wajib' AND c.jnsdoc IS NULL,
                                           'Dokumen Belum Lengkap',
                                           NULL) SEPARATOR ', ')hasil
                                    FROM   tr_claim a
                                           INNER JOIN ms_master b
                                                   ON b.mstype = a.doctype
                                                      AND b.editby = 'wajib'
                                           LEFT JOIN tr_document c
                                                  ON c.regid = a.regid
                                                     AND c.jnsdoc = b.msid
                                    WHERE  b.createby IS NULL
                                           AND c.jnsdoc IS NULL
                                    GROUP BY regid) dok ON dok.regid = tr.regid
                        LEFT JOIN  (SELECT msid, msdesc, createby FROM ms_master WHERE mstype='WKTCLM') wkc
                                ON wkc.msid = concat(tr.asuransi,tr.produk)  ";
	
	if ($vlevel=="schecker" or $vlevel=="checker" )
    {
    	$sTable .= "WHERE tr.cabang LIKE (SELECT 
                                                if(cabang='ALL','%%',cabang)
                                            FROM   ms_admin 
                                            WHERE  username='$userid' ) ";
        if ($vlevel == 'schecker') {
            // $sTable .= "AND tcd.uploaded >= tcm.jmldokumen ";
            $sTable .= "AND ((tr.status = '90' AND dok.hasil IS NULL) OR (tr.status != '90')) ";
        }
    }
    
    if ($vlevel=="broker" )
    {
    	$sTable .= "WHERE tr.status='91'";
    }
    
    if ($vlevel=="insurance" )
    {
    	$sTable .= "WHERE (tr.status IN ('92','93','96')
    	                OR (tr.status = '90' AND NOW() > DATE_ADD(tc.tglkejadian,INTERVAL (wkc.msdesc + wkc.createby) DAY)))
                        AND tr.asuransi IN (SELECT cabang 
                                            FROM   ms_admin 
                                            WHERE  level='insurance' 
                                                AND username='$userid' )";
    	
    }
    
    $sTable .= ') t_baru';
 
    // echo $sTable; die;
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