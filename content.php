<?php
	if($_GET['module']=='home'){
		include("modul/home.php");
	}
	elseif($_GET['module']=='ajuan'){
		include("modul/mod_ajuan/ajuan.php");
	}
	elseif($_GET['module']=='verif'){
		include("modul/mod_verif/verif.php");
	}
	elseif($_GET['module']=='valid'){
		include("modul/mod_valid/valid.php");
	}
	elseif($_GET['module']=='certificate'){
		include("modul/mod_certificate/certificate.php");
	}
	elseif($_GET['module']=='doc'){
		include("modul/mod_doc/doc.php");
	}
	elseif($_GET['module']=='photo'){
		include("modul/mod_photo/photo.php");
	}
	elseif($_GET['module']=='cekfoto'){
		include("modul/mod_cekfoto/cekfoto.php");
	}
	elseif($_GET['module']=='certificate'){
		include("modul/mod_certificate/certificate.php");
	}
	elseif($_GET['module']=='dashboard'){
		include("modul/mod_dashboard/dashboard.php");
	}
	elseif($_GET['module']=='lapor'){
		include("modul/mod_lapor/lapor.php");
	}
	elseif($_GET['module']=='profile'){
		include("modul/mod_profile/profile.php");
	}
	elseif($_GET['module']=='bulan'){
		include("modul/mod_bulan/bulan.php");
	}
	elseif($_GET['module']=='cabang'){
		include("modul/mod_cabang/cabang.php");
	}
	elseif($_GET['module']=='mkt'){
		include("modul/mod_mkt/mkt.php");
	}
	elseif($_GET['module']=='mscab'){
		include("modul/mod_mscab/mscab.php");
	}
	elseif($_GET['module']=='msprofile'){
		include("modul/mod_msprofile/msprofile.php");
	}
	elseif($_GET['module']=='mkt'){
		include("modul/mod_mkt/mkt.php");
	}
	elseif($_GET['module']=='msuser'){
		include("modul/mod_msuser/msuser.php");
	}
	elseif($_GET['module']=='bordero'){
		include("modul/mod_bordero/bordero.php");
	}
	elseif($_GET['module']=='docclaim'){
		include("modul/mod_docclaim/docclaim.php");
	}
	elseif($_GET['module']=='clmverif'){
		include("modul/mod_clmverif/clmverif.php");
	}
	elseif($_GET['module']=='clmvalid'){
		include("modul/mod_clmvalid/clmvalid.php");
	}
	elseif($_GET['module']=='clmpaid'){
		include("modul/mod_clmpaid/clmpaid.php");
	}
	elseif($_GET['module']=='checker'){
		include("modul/mod_checker/checker.php");
	}
	elseif($_GET['module']=='clmhist'){
		include("modul/mod_clmhist/clmhist.php");
	}
	elseif($_GET['module']=='polhist'){
		include("modul/mod_polhist/polhist.php");
	}
	elseif($_GET['module']=='revisi'){
		include("modul/mod_revisi/revisi.php");
	}
	elseif($_GET['module']=='cancel'){
		include("modul/mod_cancel/cancel.php");
	}
	elseif($_GET['module']=='inqcancel'){
		include("modul/mod_inqcancel/inqcancel.php");
	}
	elseif($_GET['module']=='minquiry'){
		include("modul/mod_minquiry/minquiry.php");
	}
	elseif($_GET['module']=='claim'){
		include("modul/mod_claim/claim.php");
	}
	elseif($_GET['module']=='inqclm'){
		include("modul/mod_inqclm/inqclm.php");
	}
	elseif($_GET['module']=='inquiry'){
		include("modul/mod_inquiry/inquiry.php");
	}
	elseif($_GET['module']=='inquirib'){
		include("modul/mod_inquirib/inquirib.php");
	}
	elseif($_GET['module']=='inquiric'){
		include("modul/mod_inquiric/inquiric.php");
	}

	elseif($_GET['module']=='inquiriv'){
		include("modul/mod_inquiriv/inquiriv.php");
	}
	elseif($_GET['module']=='inqcancel'){
		include("modul/mod_inqcancel/inqcancel.php");
	}
	elseif($_GET['module']=='claimpro'){
		include("modul/mod_claimpro/claimpro.php");
	}
	elseif($_GET['module']=='checkpro'){
		include("modul/mod_checkpro/checkpro.php");
	}
	elseif($_GET['module']=='cancelpro'){
		include("modul/mod_cancelpro/cancelpro.php");
	}
	elseif($_GET['module']=='msrate'){
		include("modul/mod_msrate/msrate.php");
	}
	elseif($_GET['module']=='kalkulator'){
		include("modul/mod_kalkulator/kalkulator.php");
	}
	elseif($_GET['module']=='panduan'){
		include("modul/mod_panduan/panduan.php");
	}
	elseif($_GET['module']=='dashboard'){
		include("modul/mod_dashboard/dashboard.php");
	}
	elseif($_GET['module']=='rollback'){
		include("modul/mod_rollback/rollback.php");
	}
	elseif($_GET['module']=='borderodtl'){
		include("modul/mod_borderodtl/borderodtl.php");
	}
	elseif($_GET['module']=='push_notif'){
		include("modul/mod_push_notif/push.php");
	}
	elseif($_GET['module']=='statistik'){
		include("modul/mod_statistik/statistik.php");
	}
	elseif($_GET['module']=='bayar'){
		include("modul/mod_bayar/bayar.php");
	}
	elseif($_GET['module']=='mskontak'){
		include("modul/mod_mskontak/mskontak.php");
	}
	elseif($_GET['module']=='mspolis'){
		include("modul/mod_mspolis/mspolis.php");
	}
	elseif($_GET['module']=='msprofile'){
		include("modul/mod_msprofile/msprofile.php");
	}
	elseif($_GET['module']=='mstc'){
		include("modul/mod_mstc/mstc.php");
	}
	elseif($_GET['module']=='keluar'){
		session_destroy();
		header("location:index.php");
	}
	else{
		include("modul/404.php");
	}
?>
