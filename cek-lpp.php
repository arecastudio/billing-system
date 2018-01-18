<?php
ob_start();
session_start();
//require_once("mydb.php");
//sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');
?>

	<tr>
		<td>
		<!--############################################################################################################-->        
		<br />
        <table>
        	<tr>
            	<td>
                	<h3 align="center">Cek LPP Per Cabang</h3>
                </td>
            </tr>
            <tr>
            	<td>
                	Cabang [UPP]
                </td>
                <td>
                	<select id="optupp" name="optupp">
                    	<option value="192.168.2.155">UPP JAYAPURA</option>
                        <option value="192.168.0.200">UPP JAYAPURA UTARA</option>
                        <option value="192.168.2.100">UPP ABEPURA</option>
                        <option value="192.168.2.100">UPP WAENA</option>
                        <option value="192.168.2.100">UPP SENTANI</option>
                    </select>
                </td>
                <td></td>
            </tr>
        </table><br/>
        <table>
        	<tr>
            	<td></td>
            </tr>
        </table>
		<!--############################################################################################################-->
		</td>
	</tr>
	
<?php
//mysql_close();
//putus();
require_once("foot.php");
?>