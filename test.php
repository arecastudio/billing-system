<?php
session_start();
$arr[]="satu <br/>";
$arr[]="dua <br/>";
$arr[]="tiga <br/>";
$arr[]="empat <br/>";
$arr[]="lima <br/>";

$_SESSION['rr']=$arr;

$yy=$_SESSION['rr'];


echo $yy[2];

?>