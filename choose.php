<?php
require_once("mydb.php");

$nomor = $_GET['nomor'];
$query = mysql_query("select * from master_wilayah where kode_cabang='$nomor'");
echo "<option>-- Pilih --</option>";
if($row = mysql_fetch_row($query)){
    //echo $row[3];
	echo "<option value=\"".$row[1]."\">".$row[2]."</option>\n";
}
?>