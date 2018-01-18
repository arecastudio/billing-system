<!DOCTYPE html PUBLIC "-//W2C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BackupData</title>
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
$mysqldump=exec('which mysqldump');
//$command = "mysqldump -u root billing >D:\bekap_%date:~-7,2%_%date:~-10,2%_%date:~-4,4%.sql";
$command = "mysqldump -u rail -h 192.168.0.100 billing >/mnt/bekap1/backup_".$tgl.".sql";
exec($command);#sleep(10);
#$command = "cp /home/pdam/Data/Backup_Server/backup_".$tgl.".sql /mnt/bekap1/";
$command = "cd /mnt/bekap1/";
exec($command);
$command = "gzip /mnt/bekap1/backup_".$tgl.".sql";
exec($command);
echo"<script type=\"text/javascript\">alert('Proses Backup Data berhasil');</script>";

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
