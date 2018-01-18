<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>restart_server</title>
</head>
<?php
ob_start();
session_start();
require_once("head.php");
date_default_timezone_set('Asia/Jayapura');	
ini_set('max_execution_time', 0);//unlimited
ini_set('memory_limit', '-1');
	
	ini_set('query_cache_type', '1');
	ini_set('query_cache_size', '26214400');

$tgl=getHari(date('w'))."-".date('d_M_Y-h_i_s');//date('D-d_M_Y-h_i_s');	
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'billing';
//$mysqldump=exec('which mysqldump');
//$command = "mysqldump -u rail -h 192.168.0.100 billing >/home/pdam/Data/Backup_Server/backup_".$tgl.".sql";
//$command = "sudo service mysql restart";
//exec($command);
$command2 = "service apache2 stop ";
exec($command2);

echo"<script type=\"text/javascript\">alert('Proses Restart Data berhasil');</script>";

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
<body>
</body>
</html>
