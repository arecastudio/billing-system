<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
ob_start();
session_start();
require_once("head.php");
$nuser=$_SESSION['nama_user'];
//echo $nuser;
//$_SESSION['login']="tutup";
?>

	<tr>
		<td>&nbsp;
        	<div style="height:800px;overflow:auto;">
        	<table height="100%">
            	<tr>
                	<td>
                    </td>
                </tr>
            </table>
            </div>
        </td>
	</tr>
	
<?php
require_once("foot.php");
?>
