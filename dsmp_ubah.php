<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
$tgl= date('Y-m-d');
$plalu=getPeriodeLalu();
$pkini=gperiode();
?>

	<tr>
		<td>
		<!--############################################################################################################-->
		
		<p align="center"><font face="Arial,sans-serif" size="4px"><b>Ubah Masukkan DSMP Bulan ini</b></font></p>	
        
        
		
		  
		  <!--############################################################################################################-->
	  </td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
