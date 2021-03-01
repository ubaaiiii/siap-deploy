<?

include "../include/globalx.php";
$exp = $_GET['exp'];
switch ($exp) {
case "clmhdr" :
	$file_name="clmhdr";
	$sql ="select concat('`',cr.batchno) batchno,concat('`',cr.claimno) claimno,concat('`',cr.altclaimno) nojaminan,concat('`',cr.membid) membid,fullname nama,ms.subprodnm2 layanan,cr.admissiondt as tglrawat,DATEDIFF(cr.dischargedt,cr.admissiondt)+1 LOS,cr.icdcode1,cr.icdcode2, ";
	$sql = $sql. " mp.polinm,cr.billedamt diajukan,cr.acceptamt disetujui ,cr.paidamt dibayar ,cr.unpaidamt as selisih,cr.altclaimno noskp,cr.remark,cr.createdt inputdate,cr.createby inputby from clm_claim_hdr cr  ";
	$sql = $sql. " left join pol_policy_member pm on pm.policyno=cr.policyno and pm.membid=cr.membid left join memb_member_master mm on mm.membercif=pm.membercif left join mst_subproduct ms  on cr.subprodid=ms.subprodid ";
	$sql = $sql. " left join mst_poli mp on cr.poliid=mp.poliid ";
	$sql = $sql. " where cr.batchno  = ". $_GET['batchno'];
	$sql = $sql. " order by claimno asc";
	
break;	
case "clmdtl" :
	$file_name="clmdtl";
	$sql ="select  concat('`',cr.batchno) batchno,concat('`',cr.claimno) claimno,concat('`',cr.altclaimno) nojaminan,concat('`',cr.membid) membid,fullname nama,ms.subprodnm2 layanan,cr.admissiondt as tglrawat,DATEDIFF(cr.dischargedt,cr.admissiondt)+1 LOS,cr.icdcode1,cr.icdcode2, ";
	$sql = $sql. " mp.polinm,cd.benefitid kodebenefit,mb.benefitnm2 benefit,cd.billedamt diajukan,cd.acceptamt disetujui ,cd.paidamt dibayar ,cd.unpaidamt as selisih,cr.altclaimno noskp,cr.remark,cr.createdt inputdate,cr.createby inputby  from clm_claim_hdr cr inner join clm_claim_dtl cd on cr.claimno=cd.claimno  ";
	$sql = $sql. " left join  mst_benefit mb on mb.benefitid=cd.benefitid left join pol_policy_member pm on pm.policyno=cr.policyno and pm.membid=cr.membid left join memb_member_master mm on mm.membercif=pm.membercif left join mst_subproduct ms  on cr.subprodid=ms.subprodid ";
	$sql = $sql. " left join mst_poli mp on cr.poliid=mp.poliid ";
	$sql = $sql. " where  cr.batchno  = ". $_GET['batchno'];
	$sql = $sql. " order by claimno asc";
break;	

case "clmdrg" :
	$file_name="clmdrg";
	$sql ="SELECT concat('`',md.claimno) claimno, md.itemid,mb.itemnm,md.amount harga,md.qtya jmldiajukan, ";
	$sql = $sql. " md.amounta hargadiajukan,md.qtyb jmldisetujui,md.amountb hargadisetujui,md.qtyc jumlahselisih,md.amountc hargaselisih ";
	$sql = $sql. " FROM clm_claim_item md inner join mst_benefit_item mb on mb.itemid=md.itemid  ";
	$sql = $sql. " inner join clm_claim_hdr cr on md.claimno=cr.claimno ";
 	$sql = $sql. " where  cr.batchno  = ". $_GET['batchno'];
	$sql = $sql. " order by cr.claimno asc";
break;	

case "clmbat" :
	$file_name="clmbat";
	$sql = "select pa.batchno,pa.dor tglterima ,pa.refno noreffrensi,pa.policyno,pa.status,pa.remark keterangan ,mc.providername namaprovider,ms.statusnm status,pa.nrofdoc,pa.batchamt,nc.nrclm jmlklaim,nc.ba diajukan,nc.pa dibayar from clm_claim_batch pa inner join prv_provider_master mc on pa.providerid=mc.providerid ";
	$sql = $sql." inner join mst_status ms on ms.status=pa.status left join (select batchno, count(1)nrclm ,sum(billedamt) ba,sum(paidamt) pa from clm_claim_hdr group by batchno) nc on  nc.batchno=pa.batchno where pa.source>=0 " ;
	$sql = $sql." order by pa.batchno";
break;	

case "clmall" :
	$file_name="clmall";
	$sql = "select concat('`',cr.batchno) batchno,concat('`',cr.claimno) claimno,concat('`',cr.altclaimno) nojaminan,concat('`',cr.membid) membid,pn.policyno,pm.clientname,mm.fullname nama,ms.subprodnm2 layanan,cr.admissiondt as tglrawat,concat(cr.icdcode1,', ',cr.icdcode2) icdcode ";
	$sql = $sql." ,cd.benefitid kodebenefit,mb.benefitnm2 benefit,cd.billedamt diajukan,cd.acceptamt disetujui , ";
	$sql = $sql." cd.paidamt dibayar ,cd.unpaidamt as selisih,cr.altclaimno noskp, ";
	$sql = $sql." cr.remark,cr.createdt inputdate,cr.createby inputby ,cr.status,cr.providerid,pr.providername,mp.polinm ";
	$sql = $sql." from clm_claim_hdr cr inner join clm_claim_dtl cd on cr.claimno=cd.claimno  ";
	$sql = $sql." left join mst_poli mp on mp.poliid=cr.poliid ";
 	$sql = $sql." left join mst_benefit mb on mb.benefitid=cd.benefitid ";
	$sql = $sql." left join pol_policy_member py on py.policyno=cr.policyno and py.membid=cr.membid ";
	$sql = $sql." left join memb_member_master mm on mm.membercif=py.membercif left join mst_subproduct ms  on cr.subprodid=ms.subprodid ";
	$sql = $sql." left join pol_policy_no pn on cr.policyno=pn.policyno ";
	$sql = $sql." left join pol_holder_master pm on pm.clientcode=pn.clientcode left join prv_provider_master pr on pr.providerid=cr.providerid order by claimno asc ";
	
break;	
}
//create query to select as data from your table


//run mysql query and then count number of fields
$export = mysql_query ( $sql ) 
       or die ( "Sql error : " . mysql_error( ) );
$fields = mysql_num_fields ( $export );

//create csv header row, to contain table headers 
//with database field names
for ( $i = 0; $i < $fields; $i++ ) {
	$header .= mysql_field_name( $export , $i ) . ",";
}

//this is where most of the work is done. 
//Loop through the query results, and create 
//a row for each
while( $row = mysql_fetch_row( $export ) ) {
	$line = '';
	//for each field in the row
	foreach( $row as $value ) {
		//if null, create blank field
		if ( ( !isset( $value ) ) || ( $value == "" ) ){
			$value = ",";
		}
		//else, assign field value to our data
		else {
			$value = str_replace( '"' , '""' , $value );
			$value = '"' . $value . '"' . ",";
		}
		//add this field value to our row
		$line .= $value;
	}
	//trim whitespace from each row
	$data .= trim( $line ) . "\n";
}
//remove all carriage returns from the data
$data = str_replace( "\r" , "" , $data );


//create a file and send to browser for user to download
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$file_name.".csv");
print "$header\n$data";
exit;
?>
</select>
