<script language="javascript">

	function isNumb(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode				
		if (charCode > 31 && (charCode < 48 || charCode > 57)){
			return false;
		}
		return true;
	}

	function cekinput(obid){
		if(document.getElementById(obid).value.trim().length==0){
			alert('Data belum lengkap');
			document.getElementById(obid).focus();
		}
	}
</script>

<?php

function getPeriodeLalu(){
	//$th=date("Y");
	$bl=date("Ym")-1;
	$tmp=date("m");
	if ($tmp==01){
		$bl=(date("Y")-1)."12";
	}	
	return $bl;
}

function gperiode(){
	$periode=date("Y").date("m");
	return $periode;
}

function cek_slip($str_slip){//fungsi untuk inject query
	if($str_slip !=""){
		$str_slip=$str_slip ." AND ";
	}
	return $str_slip;
}

function getBulan($numBul){
	switch ($numBul){
		case 0:$bln="Des";break;
		case 1:$bln="Jan";break;
		case 2:$bln="Feb";break;
		case 3:$bln="Mar";break;
		case 4:$bln="Apr";break;
		case 5:$bln="Mei";break;
		case 6:$bln="Jun";break;
		case 7:$bln="Jul";break;
		case 8:$bln="Agust";break;
		case 9:$bln="Sept";break;
		case 10:$bln="Okt";break;
		case 11:$bln="Nov";break;
		case 12:$bln="Des";
	}
	return $bln;
}

function getNamaBulan($numBul){
	switch ($numBul){
		case 0:$bln="Desember";break;
		case 1:$bln="Januari";break;
		case 2:$bln="Februari";break;
		case 3:$bln="Maret";break;
		case 4:$bln="April";break;
		case 5:$bln="Mei";break;
		case 6:$bln="Juni";break;
		case 7:$bln="Juli";break;
		case 8:$bln="Agustus";break;
		case 9:$bln="September";break;
		case 10:$bln="Oktober";break;
		case 11:$bln="November";break;
		case 12:$bln="Desember";
	}
	return $bln;
}

function setUangAir($pakai,$tarif1,$tarif2,$tarif3,$tarif4){
	$sisa=0;$hasil=0;
	if($pakai>0){
		if($pakai>30){
			$sisa=$pakai-30;
			$sisa=$sisa*$tarif4;
			$hasil=($tarif1+$tarif2+$tarif3)*10;
		}elseif($pakai>20){
			$sisa=$pakai-20;
			$sisa=$sisa*$tarif3;
			$hasil=($tarif1+$tarif2)*10;
		}elseif($pakai>10){
			$sisa=$pakai-10;
			$sisa=$sisa*$tarif2;
			$hasil=$tarif1*10;
		}else{
			//$hasil=$pakai*$tarif1;
			$hasil=10*$tarif1;
		}
	}else{
		//$hasil=$tarif1;
		$hasil=10*$tarif1;
	}
	return $hasil+$sisa;
}

function getNama($nama,$byid,$onid,$ontable){
	$query=mysql_query("select distinct $nama from $ontable where $onid=$byid;")or die("Err :".mysql_error());
	if($baris=mysql_fetch_row($query)) return trim($baris[0]);
}

function kondisi_wm($kode){
	switch($kode){
		case"2":
			return "METER SEGEL";
			break;
		case"3":
			return "METER RUSAK";
			break;
		case"4":
			return "TANPA METER";
			break;
		default:
			return "METER BAIK";
			break;
	}
}

function login_sukses($uname,$upass){
	
	$sql_login="SELECT nama,kunci,id FROM user_login where nama='$uname' AND kunci='$upass' LIMIT 0,1;";
	$qlogin=mysql_query($sql_login)or die(mysql_error());
	if($rlogin=mysql_fetch_row($qlogin)){
	return 0;	
	}
}

?>