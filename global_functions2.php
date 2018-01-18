<script language="javascript">
	function setHargaAir(pakai,tarif1,tarif2,tarif3,tarif4,mini){
		var sisa=0,hasil=0;
		pakai=parseInt(pakai);
		tarif1=parseInt(tarif1);
		tarif2=parseInt(tarif2);
		tarif3=parseInt(tarif3);
		tarif4=parseInt(tarif4);
		mini=parseInt(mini);
		sisa=parseInt(sisa);
		hasil=parseInt(hasil);
		
		if(parseInt(mini) > parseInt(pakai)){pakai=mini;}
		if(parseInt(pakai) > 0){		
			if(parseInt(pakai) > 30){
				sisa=parseInt(pakai) - 30;
				sisa=parseInt(sisa) * parseInt(tarif4);
				hasil=(parseInt(tarif1) + parseInt(tarif2) + parseInt(tarif3)) * 10;
			}else if(parseInt(pakai) > 20){
				sisa=parseInt(pakai) - 20;
				sisa=parseInt(sisa) * parseInt(tarif3);
				hasil=(parseInt(tarif1) + parseInt(tarif2)) * 10;
			}else if(parseInt(pakai) > 10){
				sisa=parseInt(pakai) - 10;
				sisa=parseInt(sisa) * parseInt(tarif2);
				hasil=parseInt(tarif1) * 10;
			}else{
				hasil=10 * parseInt(tarif1);
			}
		}else{
			hasil=10 * parseInt(tarif1);
		}
		return parseInt(hasil)+parseInt(sisa);
	}

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
	
	function terbilang(bilangan) {	 
		 bilangan    = String(bilangan);
		 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
		 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
		 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');
		 
		 var panjang_bilangan = bilangan.length;
		 
		 /* pengujian panjang bilangan */
		 if (panjang_bilangan > 15) {
		   kaLimat = "Diluar Batas";
		   return kaLimat;
		 }
		 
		 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
		 for (i = 1; i <= panjang_bilangan; i++) {
		   angka[i] = bilangan.substr(-(i),1);
		 }
		 
		 i = 1;
		 j = 0;
		 kaLimat = "";
		 
		 
		 /* mulai proses iterasi terhadap array angka */
		 while (i <= panjang_bilangan) {
		 
		   subkaLimat = "";
		   kata1 = "";
		   kata2 = "";
		   kata3 = "";
		 
		   /* untuk Ratusan */
		   if (angka[i+2] != "0") {
			 if (angka[i+2] == "1") {
			   kata1 = "Seratus";
			 } else {
			   kata1 = kata[angka[i+2]] + " Ratus";
			 }
		   }
		 
		   /* untuk Puluhan atau Belasan */
		   if (angka[i+1] != "0") {
			 if (angka[i+1] == "1") {
			   if (angka[i] == "0") {
				 kata2 = "Sepuluh";
			   } else if (angka[i] == "1") {
				 kata2 = "Sebelas";
			   } else {
				 kata2 = kata[angka[i]] + " Belas";
			   }
			 } else {
			   kata2 = kata[angka[i+1]] + " Puluh";
			 }
		   }
		 
		   /* untuk Satuan */
		   if (angka[i] != "0") {
			 if (angka[i+1] != "1") {
			   kata3 = kata[angka[i]];
			 }
		   }
		 
		   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
		   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
			 subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
		   }
		 
		   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
		   kaLimat = subkaLimat + kaLimat;
		   i = i + 3;
		   j = j + 1;
		 
		 }
		 
		 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
		 if ((angka[5] == "0") && (angka[6] == "0")) {
		   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
		 }
		 
		 return kaLimat + "Rupiah";
	}
	
</script>

<?php
$secret="038444442580";
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

function setUangAir($pakai,$tarif1,$tarif2,$tarif3,$tarif4,$mini){
	$sisa=0;$hasil=0;
	if($mini>$pakai){$pakai=$mini;}
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
			$hasil=10*$tarif1;
		}
	}else{
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

function formatMoney($number, $fractional=false) {
	if ($fractional) {
		$number = sprintf('%.2f', $number);
	}
	while (true) {
		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
		if ($replaced != $number) {
			$number = $replaced;
		} else {
			break;
		}
	}
	return $number;
}

function konversi($x){  
	$x = abs($x);
	$angka = array ("","Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	$temp = "";  
	if($x < 12){
		$temp = " ".$angka[$x];
	}else if($x<20){
		$temp = konversi($x - 10)." Belas";
	}else if ($x<100){
		$temp = konversi($x/10)." Puluh". konversi($x%10);
	}else if($x<200){
		$temp = " Seratus".konversi($x-100);
	}else if($x<1000){
		$temp = konversi($x/100)." Ratus".konversi($x%100);   
	}else if($x<2000){
		$temp = " Seribu".konversi($x-1000);
	}else if($x<1000000){
		$temp = konversi($x/1000)." Ribu".konversi($x%1000);   
	}else if($x<1000000000){
		$temp = konversi($x/1000000)." Juta".konversi($x%1000000);
	}else if($x<1000000000000){
		$temp = konversi($x/1000000000)." Milyar".konversi($x%1000000000);
	}  
	return $temp;
}

?>