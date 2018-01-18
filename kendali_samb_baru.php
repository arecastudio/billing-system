<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

$nloket="JPR";
$operator=$_SESSION['nama_user'];
#kunci_halaman("ubah_kwm",$secret,$operator);

#simpan BOF
#simpan EOF


?>
<tr>
<td>
<br/>

<table cellpadding="0" cellspacing="0" style="margin:0 auto;">
	<tr>
		<td colspan="2"><h3>Lembar Kendali Sambungan Baru</h3></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
</table>


</td>
</tr>
<?php
putus();
require_once('foot.php');
?>
