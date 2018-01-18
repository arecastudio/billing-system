<?php
//halaman mydb.php ptponline

//$con=mysql_connect("localhost","root","") or die(mysql_error());
function sambung(){
	$con=mysql_connect("localhost","rail","") or die(mysql_error());
	mysql_select_db("billing",$con) or die(mysql_error());
}

//konek("192.168.2.155","root","","billing");
function konek($host,$user,$password,$database){
	$con1=mysql_connect($host,$user,$password) or die(mysql_error());
	mysql_select_db($database,$con1) or die(mysql_error());
}


function putus(){
	mysql_close();
}


function rupiah($data){
	$rupiah = "";
	$jml = strlen($data);

 	while($jml > 3){
		$rupiah = "." . substr($data,-3) . $rupiah;
		$l = strlen($data) - 3;
		$data = substr($data,0,$l);
		$jml = strlen($data);
 	}
 //$rupiah = "Rp " . $data . $rupiah . ",-";
 	$rupiah = $data . $rupiah.",-";
 	return $rupiah;
}
//kita lakukan pemanggilan fungsi dengan memasukan data integer
// echo rupiah (1000) ."<br>";
// echo rupiah (10000) ."<br>";
// echo rupiah (1000000);


function getvaluebyid($fieldid,$fieldname,$thetable,$theid){
	$result="tradapat";
	if($fieldid !=="" && $fieldname !=="" && $thetable !=="" && $theid !==""){
		$qryget="select distinct ".$fieldname." from ".$thetable." where ".$fieldid."='".$theid."';";
		//$qryget="select nama from kota where id='".$theid."';";
		$runitget=mysql_query($qryget);
		$barisget=mysql_fetch_row($runitget);
		if ($barisget){
			list($r1)=$barisget;
			$result=$r1;			
			//$result="adakota";
		}
	}
	return $result;
}


function upgbr($infile,$gbrbaru){
	$lokasi=$_FILES['$infile']['tmp_name'];
	//$g1=$_FILES['$infile']['name'];
	$g1=$gbrbaru;
	if($infile!=="none"){
		//$g1="gambar/".$HTTP_POST_FILES['gbr1']['name'];
		move_uploaded_file($loc1,"gambar/".$g1);
	}
}

function isDenda(){
	$ret=0;
	if(date('d')>=21){
		$ret=1;
	}
	return $ret;
}


function setDenda($nomor,$periode){
	$plalu=getPeriodeLalu();
	$ret=0;
	if($periode<$plalu){
		$ret=getDenda($nomor);
	}else{
		if(date('d')>=21) $ret=getDenda($nomor);
	}
	return $ret;
}

function getDenda($nomor){
	$ret=10000;
	//$sql_denda="SELECT COUNT(*) FROM denda_wpt WHERE nomor='$nomor';";
	$sql_denda="SELECT COUNT(*) FROM master WHERE nomor='$nomor' AND dkd 
IN('9000','9001','9002','9003','9004','9100','9110','9120','9130','9200','9210','9220','9230','9300','9310','9320','9400','9410','9420','9430');";
	$qry=mysql_query($sql_denda)or die(mysql_error());
	if($row=mysql_fetch_row($qry)){
		if($row[0]>0) $ret=15000;
	}
	return $ret;
}

/////

?>
