<?php
require_once("mydb.php");

$cabang = $_GET['cabang1'];
$wilayah = mysql_query("select * from master_wilayah where kode_cabang='$cabang'");
echo "<option>-- Pilih Wilayah --</option>";
while($k = mysql_fetch_array($wilayah)){
    echo "<option value=\"".$k[1]."\">".$k[2]."</option>\n";
}
?>