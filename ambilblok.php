<?php
require_once("mydb.php");
//sambung();

$wil = $_GET['wil2'];
$blok = mysql_query("select kode_wilayah,kode_blok,ket_blok from master_blok where kode_wilayah='$wil'");
echo "<option>-- Pilih Blok --</option>";
while($k = mysql_fetch_array($blok)){
    echo "<option value=\"".$k['kode_blok']."\">".$k['ket_blok']."</option>\n";
}
?>