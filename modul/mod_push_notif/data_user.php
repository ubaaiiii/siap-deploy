<?php
include("../../config/koneksi.php");

$result=mysql_query("SELECT id_admin,nama,level,username,cabang FROM ms_admin");
if (mysql_num_rows($result)>0) {
  while($row = mysql_fetch_assoc($result)) {
    $tableUser[] = $row;
  }
} else {
  $tableUser = array(
    "data"=>[],
    "draw"=>1,
    "recordsFiltered"=>0,
    "recordsTotal"=>0
  );
}
// echo json_encode($tableUser);
?>

<script>
var user = <?=json_encode($tableUser);?>;
</script>
