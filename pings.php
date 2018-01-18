<?php
require_once('global_functions.php');
$stat="putus";
if(pings("192.168.0.200")){
	$stat="sambung";
}
echo $stat;
?>
