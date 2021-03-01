<?php
include("../../config/koneksi.php");
require('../../fpdf/fpdf.php');
include ("../../config/fungsi_all.php");
date_default_timezone_set('Asia/Jakarta');
/* $sbillno=$_GET['billno']; */
$sbillno='211810000049';

            class PDF extends FPDF {
                //Page header
                function Header(){
                    //Logo
					
					$stitle1="PT. TUGU KRESNA PRATAMA";
					$stitle2="GENERAL INSURANCE";
					
					$this->Image('../../images/logo.png',17,3,20);
				
					//header report 
					$this->SetFont('Arial','B',22);
					$this->SetY(5);
					$this->Cell(0,10,$stitle1,0,0,'C');
					$this->Line(50,15,120,15);
							
					$this->SetY(10);
					$this->SetFont('Arial','B',10);
					$this->SetX(120);
					$this->Cell(0,10,'GENERAL INSURANCE',0,0,'L');
			

                }
                //Page footer
                function Footer(){
                    $this->SetY(-22);
                    //$this->SetX(-35);
                    //Arial italic 8
                    $this->SetFont('Arial','I',8);
                    //Page number
					$sdate =  date("d-m-Y H:i:s");
                    $this->Cell(0,10,'Print date : ' . $sdate  ,0,0,'L');
					
					$this->SetY(-15);
					$this->SetFont('Arial','B',12);
					$this->Cell(0,10,'PT. TUGU KRESNA PRATAMA' ,0,0,'C');
					
					$this->SetFont('Arial','',7);
					$this->SetY(-10);
					$this->Cell(0,10,'Kantor Pusat : Jl. Raya Pasar Minggu No. 5 Jakarta Selatan 12780 Telp. (021) 799 5888 Fax (021) 7918 4342, 791 83422, 791 84958 '  ,0,0,'C');
                }
            }

			$sauthor="Nurman Sasono";
			$stitle="Premium-Invoice";
			
            $pdf = new PDF();
            //$pdf->open();
            $pdf->AddPage("P","A4"); // P =portrait L = Landscape
            $pdf->AliasNbPages();   // necessary for x of y page numbers to appear in document
            $pdf->SetAutoPageBreak(true, 20);

            // document properties
            $pdf->SetAuthor($sauthor);
            $pdf->SetTitle($stitle);

          


			$sno==0;
            //start -----detail data ------------------
            $sql = "SELECT a.* from tr_sppa a  where  a.regid='$sbillno' "; 
			/* echo $sql; */
            $res1 = mysql_query($sql) or die(mysql_error());
            $row1 = mysql_num_rows($res1);
            while($row1 = mysql_fetch_array($res1)){           
			$sbillno = $row1['regid'];
			$y = 5;
            $x = 10;  
			

			$pdf->SetFont('Arial','B',10);
			$pdf->SetY(15);
			$pdf->Cell(0,10,'',0,0,'C');
			
			
			$pdf->Line(10,25,200,25);
						
            $pdf->SetDrawColor(0, 0, 0); //black
			
			//body report 
             
				$ssql="select a.*,'Bank Bukopin' clientname  ";
				$ssql= $ssql . " from ";
				$ssql= $ssql . " tr_sppa a  where a.regid='$sbillno' ";
				/* echo $ssql; */
				$query=mysql_query($ssql);
				$r=mysql_fetch_array($query);
				$snopol3 = " : " . $r['policyno'];
				$sto3 = " : " . $r['clientname'] ;
				$scob3 = " : " . $r['instype'] ;
				$sobject3 = " : " . $r['object'] ;
				$sname2 = " : " . $r['clientname'] ;
				$snopeserta2 = " : " . $r['nopeserta'] ;
				$speriod2 = " : " . $r['speriod3'] ;
				$snopeserta =  $r['nopeserta'] ;
				$billamt2 =  $r['grossamt'] ;
				$billamt3 =  $r['admamt'] ;
				$billamt4 =  $r['dutycostamt'] ;
				$billamt5 =  $r['discamt'] ;
				$billamt6 =  $r['totalamt'] ;
				$sproductcd =$r['productcd'] ;
				$srek='TKPPLN3';
			
				
				$billremark =  $r['remark'] . " : ".$r['reffno'] ;

				
				$sdate="Jakarta , ". $sdate ; 
				$sinvoceno= "No  : " . $r['regid'] ;
				$billtype= "SERTIFIKAT";
				$billdt=  " POLIS ASURANSI KREDIT MULTIGUNA" ;
				$headnote1="Bahwa tertanggung / pemegang polis telah mengajukan suatu permohonan tertulis dan melakukan pembayaran premi yang";
				$headnote2="menjadi dasar dan merupakan bagian yang tidak terpisahkan dari Polis Induk Asuransi Kredit Multiguna No.12345678  ";
				$headnote3="Penanggung akan memberikan manfaat asuransi berupa pembayaran sesuai jenis pertanggungan bilamana peserta";
				$headnote4="tersebutmengalami kerugian yang diderita yang diakibatkan atas resiko yang dijamin dalam polis ini ";
				$headnote5="sesuai nama yang tercantum dalam lampiran sertifikat ini. " ;
				
				$sto1="Kepada "  ;
				$sto2="To   " ;
				$snopol1="No Polis   " ;
				$snopol2="Policy No    " ;
				$sname1="Nama Tertanggung";
				
				$scob1="Jenis Asuransi";
				$scob2="Class of business";
				$speriod1="Jangka waktu";
				$speriod2="Period";
				$sobject1="Objeck Asuransi";
				$sobject2="Interest Insured ";
				
				$sqls="select companyname,address1,phone1,fax1,web,bank,branch,acctname,acctno from ms_systab where companycd='$srek' ";
				$query=mysql_query($sqls);
				$r=mysql_fetch_array($query);
				
				$bank = $r['bank'] . " " .  $r['branch'];;
				$branch = $r['branch'];
				$acctname = $r['acctname'];
				$acctno = $r['acctno'];
				
				$lbank="Bank";
				$lacctno="No Rekening";
				$lacctname="Nama ";
				$lbranch="Nama ";
				
				$lclaimno="No Klaim ";
				$lprovider="Provider ";
				$sauthor="Nurman Sasono";
				$stitle="invoice-excess";      

			$yh=45;
			
			$pdf->SetFont('Arial',"B","15");
			$pdf->setXY(10, $yh-14); 
            $pdf->Cell(180,10,$billtype,0, 0, "C", 0);
			
						
			$pdf->SetFont('Arial',"","12");
			$pdf->setXY(10, $yh-9); 
            $pdf->Cell(180,10,$billdt,0, 0, "C", 0);
			
			$pdf->SetFont('Arial',"","9");
			$pdf->setXY(10, $yh-5); 
            $pdf->Cell(180,10,$sinvoceno,0, 0, "C", 0);
			
			$pdf->setXY(10, $yh+5); 
            $pdf->SetFont('Arial',"","9");
            $pdf->Cell(30,10,$headnote1);

			$pdf->setXY(10, $yh+10); 
            $pdf->Cell(30,10,$headnote2);
			
			$pdf->setXY(10, $yh+15); 
            $pdf->Cell(30,10,$headnote3);			
			
			$pdf->setXY(10, $yh+20); 
			$pdf->Cell(30,10,$headnote4);
			
			$pdf->setXY(10, $yh+25); 
            $pdf->Cell(30,10,$headnote4);
			
			$pdf->setXY(10, $yh+35); 
            $pdf->Cell(30,10,$sname1);
			
			$pdf->setXY(50, $yh+35); 
			$pdf->Cell(30,10,$sname2;
			
			$pdf->setXY(50, $yh+40); 
			$pdf->Cell(30,10,$snopeserta1);
			
			$pdf->setXY(50, $yh+40); 
            $pdf->Cell(30,10,$snopeserta2);
			
			$pdf->setXY(10, $yh+45); 
			$pdf->Cell(30,10,$snama1);

			$pdf->setXY(50, $yh+45); 
			$pdf->Cell(30,10,$snam2);
						
			$pdf->setXY(50, $yh+50); 
			$pdf->Cell(30,10,$scob3);
			
			$pdf->setXY(10, $yh+50); 
			$pdf->Cell(30,10,$speriod1);
			
			$pdf->setXY(10, $yh+45); 
			$pdf->Cell(30,10,$speriod2);
			
			$pdf->setXY(50, $yh+55); 
			$pdf->Cell(30,10,$speriod3);
			
			$pdf->setXY(10, $yh+55); 
			$pdf->Cell(30,10,$sobject1);
			
			$pdf->setXY(10, $yh+55); 
			$pdf->Cell(30,10,$sobject2);			
			
			$pdf->setXY(50, $yh+68); 
			$pdf->Cell(30,10,$sobject3);			
			

			$pdf->SetDrawColor(0, 0, 0); //black
            //table header
            $pdf->SetFillColor(170, 170, 170); //gray
            $pdf->setFont("Arial","B","8");
            $pdf->setXY(10, $yh+85); 
            $pdf->Cell(120, 8, " Catatan/Notes ", 1, 0, "C", 0);
            $pdf->Cell(70, 8, "Perincian/Detail", 1, 0, "C", 0);
		
			$sbody1="\n"."Jumlah tersebut dalam Nota Debet ini hendaknya segera dibayar untuk penyelesaian transaksi. ";
			$sbody1= $sbody1 . " Harap pembayaran dilakukan dengan cheque silang (crossed cheque) atas nama ";
			$sbody1= $sbody1 . "PT. ASURANSI TUGU KRESNA PRATAMA atau dipindahbukukan pada rekening giro ";
			$sbody1= $sbody1 . "di salah satu Bank berikut ini : " ."\n\n";
			$sbody1= $sbody1 . "Please pay the amount shown in this Debit Note immediately to finalize the transaction. ";
			$sbody1= $sbody1 . "Payment should be made with a crossed cheque in the name ";
			$sbody1= $sbody1 . "PT. ASURANSI TUGU KRESNA PRATAMA or transferred to our current account ";
			$sbody1= $sbody1 . "with one of the following bank :  " ."\n\n";
			$sbody1= $sbody1 . "      " .  $bank . " - " . $acctno . "\n\n";
			$sbody1= $sbody1 . "Keterangan " ."\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";

			
			$pdf->setFont("Arial","","7");
			$pdf->setXY(10, $yh+94); 
			$pdf->MultiCell(120,4,$sbody1,1,'LRT');		

			
			$sbody2="\n" ."Premi". "\n";
			$sbody2= $sbody2 . "\n" ."Premium". "\n";

			$sbody2a="\n" ."Premi Netto". "\n";
			$sbody2a= $sbody2a . "\n" ."Nett Premium". "\n";
			
			$sbody2b="\n" ."Biaya polis". "\n";
			$sbody2b= $sbody2b . "\n" ."Policy Cost". "\n";
			
			$sbody2c="\n" ."Biaya Meterai". "\n";
			$sbody2c= $sbody2c . "\n" ."Dutycost". "\n";

			$sbody2d="\n" ."Diskon". "\n";
			$sbody2d= $sbody2d . "\n" ."Discount". "\n";			
			

			
			$sbody3="\n" ."Jumlah". "\n";
			$sbody3= $sbody3 .="\n" ."Total". "\n";
			
			$sbody4="\n\n\n\n";
			$sbody5a="\n\n\n\n";
			$sbody5b="\n\n\n\n";
			$sbody5c="\n\n\n\n";
			$sbody5d="\n\n\n\n";
			
			
			$sbody6="\n" ."PT. TUGU KRESNA PRATAMA" . "\n\n";
			

			$pdf->setFont("Arial","","10");
			$pdf->setXY(165, $yh+94); 
			$pdf->Cell(35, 8, ": " . number_format($billamt1,0) , 0, 0, "L", 0);
			
			$pdf->setXY(165, $yh+111); 
			$pdf->Cell(35, 8, ": " . number_format($billamt2,0) , 0, 0, "L", 0);
			
			$pdf->setXY(165, $yh+128); 
			$pdf->Cell(35, 8, ": " . number_format($billamt3,0) , 0, 0, "L", 0);
			
			$pdf->setXY(165, $yh+145); 
			$pdf->Cell(35, 8, ": " . number_format($billamt4,0) , 0, 0, "L", 0);
			
			$pdf->setXY(165, $yh+160); 
			$pdf->Cell(35, 8, ": " . number_format($billamt5,0) , 0, 0, "L", 0);
			
			$pdf->setXY(165, $yh+177); 
			$pdf->Cell(35, 8, ": " . number_format($billamt6,0) , 0, 0, "L", 0);
			

			

			//box for detail 
			
			$pdf->setFont("Arial","","8");
			$pdf->setXY(130, $yh+94); 
			$pdf->MultiCell(35,4,$sbody2,1,'LRT');		
			
			$pdf->setFont("Arial","","8");
			$pdf->setXY(130, $yh+110); 
			$pdf->MultiCell(35,4,$sbody2a,1,'LRT');		
			
			$pdf->setFont("Arial","","8");
			$pdf->setXY(130, $yh+126); 
			$pdf->MultiCell(35,4,$sbody2b,1,'LRT');		
			
			$pdf->setFont("Arial","","8");
			$pdf->setXY(130, $yh+142); 
			$pdf->MultiCell(35,4,$sbody2c,1,'LRT');	

			$pdf->setFont("Arial","","8");
			$pdf->setXY(130, $yh+158); 
			$pdf->MultiCell(35,4,$sbody2d,1,'LRT');				

			$pdf->setFont("Arial","","8");
			$pdf->setXY(130, $yh+174); 
			$pdf->MultiCell(35,4,$sbody3,1,'LRT');		
			
			$pdf->setFont("Arial","","8");
			$pdf->setXY(130, $yh+190); 
			$pdf->MultiCell(70,4,$sbody6,1,'C');

			$pdf->setFont("Arial","","8");
			$pdf->setXY(10, $yh+157); 
			$pdf->MultiCell(130,4,$billremark,0,'LRT');		
			
			//box for amount invoice 
			$pdf->setFont("Arial","","8");
			$pdf->setXY(165, $yh+94); 
			$pdf->MultiCell(35,4,$sbody4,1,'LRT');	
			
			$pdf->setFont("Arial","","8");
			$pdf->setXY(165, $yh+110); 
			$pdf->MultiCell(35,4,$sbody5a,1,'LRT');	
			
			$pdf->setXY(165, $yh+126); 
			$pdf->MultiCell(35,4,$sbody5b,1,'LRT');	

			$pdf->setXY(165, $yh+142); 
			$pdf->MultiCell(35,4,$sbody5c,1,'LRT');	

			$pdf->setXY(165, $yh+158); 
			$pdf->MultiCell(35,4,$sbody5d,1,'LRT');				

			$pdf->setXY(165, $yh+174); 
			$pdf->MultiCell(35,4,$sbody5d,1,'LRT');			

			
			$pdf->setXY(10, $yh+200); 
			$pdf->Cell(35, 8, "Nota Debet ini bukan merupakan tanda bukti pembayaran. "  , 0, 0, "L", 0);
			
			
			$pdf->setXY(10, $yh+205); 
			$pdf->Cell(35, 8, "This Debit Note is not a receipt." , 0, 0, "L", 0);
			

			


			}
				//end of -----detail data ------------------
            $pdf->Output();

			?>