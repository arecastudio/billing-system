<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');
?>

	<tr>
		<td>
		<!--############################################################################################################-->
        <div align="center"><font face="Arial,sans-serif" size="4px"><b>Rekap Pendapatan & Penerimaan [LPP]</b></font></div><hr width="660px"/>		
		<table width="660px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#ffc;" background="img/grids.gif">
        	<form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr>
            	<td colspan="4">Pilihan Rekap:</td>
            </tr>
            <tr>
            	<td width="180"><input type="radio" name="r1" value="rall" checked/>Total [Keseluruhan]</td>
                <td></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td><input type="radio" name="r1" value="rcabang"/>Per-Cabang</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td><input type="radio" name="r1" value="rwilayah"/>Per-Wilayah</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td><input type="radio" name="r1" value="rblok"/>Per-Blok</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td><input type="radio" name="r1" value="rkasir"/>Per-Operator [Kasir]</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </form>
            
            
            
        </table>
        <br/>
		<!--############################################################################################################-->
  	  </td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
