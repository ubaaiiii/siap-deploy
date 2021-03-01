<?php
include("../../config/koneksi.php");

$result=$db->query("SELECT ms.regid id,
                            concat(ms.nama,' - ',ms.regid) text,
                            status dStatus
                     FROM tr_sppa ms 
                     WHERE ms.status IN (5, 83, 84, 93)");
if ($result->num_rows>0) {
  while($row = $result->fetch_assoc()) {
    $Debitur[] = $row;
  }
} else {
  $Debitur = array("");
}

// echo json_encode($Debitur);
?>

<script>
var debitur = <?=json_encode($Debitur);?>;
</script>
