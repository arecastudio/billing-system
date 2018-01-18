<?php
require_once("mydb.php");

$rayon = $_GET['cabang1'];
$dkd = mysql_query("select dkd,jalan from dkd where rayon='$rayon'");
echo "<option>-- Pilih DKD --</option>";
while($k = mysql_fetch_array($dkd)){
    echo "<option value=\"".$k['dkd']."\">".$k['jalan']."</option>\n";
}
?>