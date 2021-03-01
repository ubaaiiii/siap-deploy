<?php
if($mulai=="" AND $tglcon1=="//" AND $tglcon2=="//" AND $bagian==""){
    $query=mysql_query("SELECT * FROM tbl_spt, tbl_kegiatan, tbl_pegawai WHERE tbl_spt.id_kegiatan=tbl_kegiatan.id_kegiatan AND tbl_spt.id_pegawai=tbl_pegawai.id_pegawai AND tbl_spt.status='N' ORDER BY nama ASC");
    }
    elseif($mulai!="" AND $tglcon1!="//" AND $tglcon2!="//" AND $bagian!=""){
        $query=mysql_query("SELECT * FROM tbl_spt, tbl_kegiatan, tbl_pegawai WHERE tbl_spt.id_kegiatan=tbl_kegiatan.id_kegiatan AND tbl_spt.id_pegawai=tbl_pegawai.id_pegawai AND tbl_spt.status='N' AND tbl_kegiatan.tglberangkat LIKE '%".$mulai."%' AND tbl_kegiatan.tglberangkat >= '$tglcon1' AND tbl_kegiatan.tglselesai <= '$tglcon2' AND tbl_pegawai.bagian LIKE '%".$bagian."%' ORDER BY nama ASC");
        
    }
    elseif($tglcon1!="//" AND $tglcon2!="//"){
        $query=mysql_query("SELECT * FROM tbl_spt, tbl_kegiatan, tbl_pegawai WHERE tbl_spt.id_kegiatan=tbl_kegiatan.id_kegiatan AND tbl_spt.id_pegawai=tbl_pegawai.id_pegawai AND tbl_spt.status='N' AND tbl_kegiatan.tglberangkat LIKE '%".$mulai."%' AND tbl_kegiatan.tglberangkat >= '$tglcon1' AND tbl_kegiatan.tglselesai <= '$tglcon2' ORDER BY nama ASC");
        
    }
    elseif($mulai!=""){
        $query=mysql_query("SELECT * FROM tbl_spt, tbl_kegiatan, tbl_pegawai WHERE tbl_spt.id_kegiatan=tbl_kegiatan.id_kegiatan AND tbl_spt.id_pegawai=tbl_pegawai.id_pegawai AND tbl_spt.status='N' AND tbl_kegiatan.tglberangkat LIKE '%".$mulai."%' ORDER BY nama ASC");
        
    }
    elseif($bagian!=""){
            
        $query=mysql_query("SELECT * FROM tbl_spt, tbl_kegiatan, tbl_pegawai WHERE tbl_spt.id_kegiatan=tbl_kegiatan.id_kegiatan AND tbl_spt.id_pegawai=tbl_pegawai.id_pegawai AND tbl_spt.status='N' AND tbl_pegawai.bagian LIKE '%".$bagian."%' ORDER BY nama ASC");
    
    }
?>