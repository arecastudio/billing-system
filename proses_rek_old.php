<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();

//$bulan="";//file proses_rek.php
$bulan=getNamaBulan(date("m"));$period=gperiode();$lastperiod=getPeriodeLalu();

$sql1="INSERT INTO rekening1(nomor,periode, standlalu, standkini, pakai, loket, tbayar, uangair, adm, meter, denda, meterai, total, status_bayar, periode_tarif, periode_meterai);";

$sql2="INSERT IGNORE INTO rekening1(nomor,periode, standlalu, standkini, pakai) select a.nomor,b.periode,a.angka,b.angka,(b.angka-a.angka) FROM dsmp0 AS a, dsmp0 AS b WHERE a.nomor=b.nomor AND b.periode=$period AND a.periode=$lastperiod;";

$sql="INSERT IGNORE INTO rekening1(nomor,periode, standlalu, standkini, pakai,meter) SELECT a.nomor,b.periode,a.angka,b.angka,(b.angka-a.angka),mt.biaya FROM dsmp0 AS a, dsmp0 AS b,master AS ms,meter AS mt WHERE a.nomor=b.nomor AND b.periode=$period AND a.periode=$lastperiod AND b.nomor=ms.nomor AND ms.ukuran=mt.kode AND ms.putus=0;";

if(isset($_POST["proses"])){
	//echo "<p>".$sql."</p>";
	//echo "<p>".setUangAir(337,2330,2880,3580,3580)."</p>";
	$qry=mysql_query($sql);
	
	$nmr1="";$gol1="";$use=0;$t1=0;$t2=0;$t3=0;$t4=0;$uangair=0;
	//$sql="select r.nomor,m.gol,r.pakai from rekening1 as r,master as m where r.periode=$period and r.nomor=m.nomor and m.kode_blok='0101'";
	/*$sql="
	SELECT r.nomor,m.gol,r.pakai
	FROM rekening1 AS r
	INNER JOIN master AS m ON m.nomor=r.nomor
	WHERE r.periode=$period AND m.kode_blok='0101'; 
	";*/
	//AND m.kode_blok='0101'"
//perubahan pada kwm,putus,ukuran

	$sql="
	INSERT IGNORE INTO rekening1(nomor,periode,standlalu,standkini,pakai,kondisi_meter,putus,ukuran,gol)
	SELECT m.nomor,b.periode,a.angka AS stlalu,b.angka AS stkini,(b.angka-a.angka)as pakai1,m.kondisi_meter,m.putus,m.ukuran,m.gol	
	FROM master AS m
	LEFT OUTER JOIN dsmp0 AS a ON a.nomor=m.nomor AND a.periode=$lastperiod
	LEFT OUTER JOIN dsmp0 AS b ON b.nomor=m.nomor AND b.periode=$period
	WHERE m.putus='0'
	;	
	";	
	$qry1=mysql_query($sql)or die(mysql_error());//simpan rekening kosong
	
	//mulai proses update uangair cs
	//,(SELECT adm FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS tadm
	//,(SELECT meter FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS tmeter
	$sql="
	SELECT m.nomor,m.gol,r.periode,r.pakai
	,(SELECT tarip1 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS t1
	,(SELECT tarip2 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS t2
	,(SELECT tarip3 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS t3
	,(SELECT tarip4 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS t4	
	,(SELECT n.nadm FROM adm AS n WHERE n.periode<=r.periode ORDER BY n.periode DESC LIMIT 0,1)AS adm1
	,(SELECT biaya FROM meter WHERE kode=m.ukuran LIMIT 1) AS tmeter
	,(SELECT denda1 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS tdenda
	,(SELECT b1.batas1 FROM adm AS b1 WHERE b1.periode<=r.periode ORDER BY b1.periode DESC LIMIT 0,1)AS bts1
	,(SELECT b2.batas2 FROM adm AS b2 WHERE b2.periode<=r.periode ORDER BY b2.periode DESC LIMIT 0,1)AS bts2
	,(SELECT m1.met1 FROM adm AS m1 WHERE m1.periode<=r.periode ORDER BY m1.periode DESC LIMIT 0,1)AS mtr1
	,(SELECT m2.met2 FROM adm AS m2 WHERE m2.periode<=r.periode ORDER BY m2.periode DESC LIMIT 0,1)AS mtr2
	,m.ukuran,m.kondisi_meter
	,(SELECT minimum FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS mini
	,m.nolama,m.nama,m.cabang,m.kode_wilayah,m.kode_blok,m.dkd
	,m.putus,m.ukuran
	FROM rekening1 AS r
	INNER JOIN master AS m ON m.nomor=r.nomor
	WHERE r.periode=$period
	ORDER BY m.nomor
	";
	//ambil nomor,golongan,pemakaian
	//$sql0="update rekening1 set ";//uangair=".setUangAir($use,$t1,$t2,$t3,$t4)." where nomor=$nmr1 and periode=201409";
	//$where="";$update="";
	$qry1=mysql_query($sql)or die(mysql_error());
	while($row=mysql_fetch_row($qry1)){
		$nmr1=$row[0];
		$gol1=$row[1];
		$use=$row[3];
				
		//ambil tarif untuk tentukan jml uangair
		//$sql="SELECT tarip1,tarip2,tarip3,tarip4,periode FROM tarif WHERE periode<=$period AND gol='$gol1' ORDER BY periode DESC LIMIT 0,1;";
		//$qry2=mysql_query($sql)or die("err: ".mysql_error());
		
		//if($row=mysql_fetch_row($qry2)){
			$t1=$row[4];
			$t2=$row[5];
			$t3=$row[6];
			$t4=$row[7];
			$adm=$row[8];
			$mtr=$row[9];
			//$denda=$row[10];
			$denda=0;
			$bts1=$row[11];
			$bts2=$row[12];
			$mtr1=$row[13];
			$mtr2=$row[14];
			
			$kond=$row[16];
			$mini=$row[17];
			
			$nolama=$row[18];
			$nama=$row[19];
			$cbg=$row[20];
			$wil=$row[21];
			$blok=$row[22];
			$dkd=$row[23];

			$putus=$row[24];
			$ukuran=$row[25];
		//}
		$uangair=setUangAir($use,$t1,$t2,$t3,$t4,$mini);
		$tuangair=$uangair;
		if($uangair<=0)$tuangair=0;
		
		if($uangair>=$bts2){
			$meterai=$mtr2;
		}else if($uangair>=$bts1 && $uangair<$bts2){
			$meterai=$mtr1;
		}else{
			$meterai=0;
		}
		//if($update!="")$update.=" AND ";
		//$update.=" uangair=$uangair ";//." where nomor=$nmr1 and periode=201409";
		if($kond=='4'||$kond=='3'){$mtr=0;}
		if($kond=='2'){$uangair=0;$tuangair=0;$meterai=0;}
//baru update 12 april 2015 penambahan round untuk pembulatan uangair pada nilai ratusan
		$sql0="UPDATE rekening1 SET nolama='$nolama',nama='$nama',cabang='$cbg',kode_wilayah='wil',kode_blok='$blok',dkd='$dkd',uangair=ROUND($uangair,-2),adm=$adm,meter=$mtr,denda=$denda,meterai=$meterai,total=(ROUND($tuangair,-2)+$adm+$mtr+$denda+$meterai),kondisi_meter='$kond',gol='$gol1',putus='$putus',ukuran='$ukuran' WHERE nomor='$nmr1' AND periode=$period;";
		$qry30=mysql_query($sql0)or die(mysql_error());
				
		//if($where!="")$where.=" AND ";
		//$where.=" nomor=$nmr1";		
	}
	
	mysql_query("DELETE FROM rekening1_awal WHERE periode=(SELECT DISTINCT d1.periode FROM dsmp0 AS d1 ORDER BY d1.periode DESC LIMIT 1);")or die(mysql_error());
	//hapus rekening_bekap jika proses lebih dari sekali
	
	$sql_copy="INSERT IGNORE INTO rekening1_awal SELECT DISTINCT * FROM rekening1 where periode>=201504;";//antisipasi untuk tidak mengganggu proses rekening setelah tanggal 30/31 akhir bulan
	$qry_copy=mysql_query($sql_copy)or die(mysql_error());
	
	mysql_query("DELETE FROM lap_bulan_ti WHERE periode=(SELECT DISTINCT d1.periode FROM dsmp0 AS d1 ORDER BY d1.periode DESC LIMIT 1);")or die(mysql_error());
	
	$sql_lap="
	INSERT IGNORE INTO lap_bulan_ti select distinct d1.periode
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='1' and m1.cabang='01')as jpr_aktif
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='2' and m1.cabang='01')as jpr_segel
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='3' and m1.cabang='01')as jpr_rusak
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='4' and m1.cabang='01')as jpr_nonmeter
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='1' and m1.cabang='02')as uju_aktif
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='2' and m1.cabang='02')as uju_segel
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='3' and m1.cabang='02')as uju_rusak
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='4' and m1.cabang='02')as uju_nonmeter
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='1' and m1.cabang='03')as abe_aktif
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='2' and m1.cabang='03')as abe_segel
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='3' and m1.cabang='03')as abe_rusak
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='4' and m1.cabang='03')as abe_nonmeter
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='1' and m1.cabang='04')as wna_aktif
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='2' and m1.cabang='04')as wna_segel
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='3' and m1.cabang='04')as wna_rusak
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='4' and m1.cabang='04')as wna_nonmeter
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='1' and m1.cabang='05')as stn_aktif
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='2' and m1.cabang='05')as stn_segel
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='3' and m1.cabang='05')as stn_rusak
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='4' and m1.cabang='05')as stn_nonmeter
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='1' and m1.cabang='06')as gym_aktif
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='2' and m1.cabang='06')as gym_segel
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='3' and m1.cabang='06')as gym_rusak
	,(select count(m1.nomor) from master as m1 where m1.putus='0' and m1.kondisi_meter='4' and m1.cabang='06')as gym_nonmeter
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)<=10 and m2.putus='0' and m2.cabang='01')as jpr_10
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)>100 and m2.putus='0' and m2.cabang='01')as jpr_100
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)<=10 and m2.putus='0' and m2.cabang='02')as uju_10
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)>100 and m2.putus='0' and m2.cabang='02')as uju_100
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)<=10 and m2.putus='0' and m2.cabang='03')as abe_10
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)>100 and m2.putus='0' and m2.cabang='03')as abe_100
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)<=10 and m2.putus='0' and m2.cabang='04')as wna_10
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)>100 and m2.putus='0' and m2.cabang='04')as wna_100
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)<=10 and m2.putus='0' and m2.cabang='05')as stn_10
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)>100 and m2.putus='0' and m2.cabang='05')as stn_100	
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)<=10 and m2.putus='0' and m2.cabang='06')as gym_10
	,(select distinct count(m2.nomor) from master as m2 inner join dsmp0 as d2 on d2.nomor=m2.nomor inner join dsmp0 as d3 on d3.nomor=m2.nomor where d3.periode=$lastperiod AND d2.periode=d1.periode and (d2.angka-d3.angka)>100 and m2.putus='0' and m2.cabang='06')as gym_100
	,(select count(u.nomor)from ubah_nama as u where year(u.tgl)=left(d1.periode,4) and month(u.tgl)=right(d1.periode,2))as ubah_nama
	,(select count(u.nomor)from ubah_kwm as u where year(u.tgl)=left(d1.periode,4) and month(u.tgl)=right(d1.periode,2))as ubah_kwm
	,(select count(u.nomor)from ubah_gol as u where year(u.tgl)=left(d1.periode,4) and month(u.tgl)=right(d1.periode,2))as ubah_gol
	,(select count(u.nomor)from ubah_meter as u where year(u.tgl)=left(d1.periode,4) and month(u.tgl)=right(d1.periode,2))as meterisasi
	,(select count(u.nomor)from ubah_stat as u where year(u.tgl)=left(d1.periode,4) and month(u.tgl)=right(d1.periode,2) and lama<>'5' and baru='5')as pel_hapus
	,(select count(u.nomor)from master as u where year(u.tgl_input)=left(d1.periode,4) and month(u.tgl_input)=right(d1.periode,2))as pel_baru
	,(select count(u.nomor)from his_koreksi_rek as u where year(u.tkorek)=left(d1.periode,4) and month(u.tkorek)=right(d1.periode,2))as jml_koreksi_rek
	,(select sum(u.pakai_awal)from his_koreksi_rek as u where year(u.tkorek)=left(d1.periode,4) and month(u.tkorek)=right(d1.periode,2))as koreksi_pakai_awal
	,(select sum(u.pakai)from his_koreksi_rek as u where year(u.tkorek)=left(d1.periode,4) and month(u.tkorek)=right(d1.periode,2))as koreksi_pakai_akhir
	,(select sum(u.adm_awal+u.uangair_awal+u.meter_awal+u.meterai_awal+u.denda_awal)from his_koreksi_rek as u where year(u.tkorek)=left(d1.periode,4) and month(u.tkorek)=right(d1.periode,2))as koreksi_total_awal
	,(select sum(u.adm+u.uangair+u.meter+u.meterai+u.denda)from his_koreksi_rek as u where year(u.tkorek)=left(d1.periode,4) and month(u.tkorek)=right(d1.periode,2))as koreksi_total_akhir	
	,(select count(u.nomor)from ubah_stat as u where year(u.tgl)=left(d1.periode,4) and month(u.tgl)=right(d1.periode,2) and lama<>'0' and baru='0')as pel_reaktif
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='01' AND kondisi_meter='1')) AS jpr_1_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='01' AND kondisi_meter='3')) AS jpr_3_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='01' AND kondisi_meter='4')) AS jpr_4_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='02' AND kondisi_meter='1')) AS uju_1_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='02' AND kondisi_meter='3')) AS uju_3_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='02' AND kondisi_meter='4')) AS uju_4_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='03' AND kondisi_meter='1')) AS abe_1_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='03' AND kondisi_meter='3')) AS abe_3_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='03' AND kondisi_meter='4')) AS abe_4_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='04' AND kondisi_meter='1')) AS wna_1_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='04' AND kondisi_meter='3')) AS wna_3_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='04' AND kondisi_meter='4')) AS wna_4_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='05' AND kondisi_meter='1')) AS stn_1_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='05' AND kondisi_meter='3')) AS stn_3_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='05' AND kondisi_meter='4')) AS stn_4_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='06' AND kondisi_meter='1')) AS gym_1_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='06' AND kondisi_meter='3')) AS gym_3_m3
	,(SELECT SUM(m3.pakai) FROM rekening1 AS m3 WHERE m3.periode=d1.periode AND m3.nomor in(SELECT nomor FROM master WHERE cabang='06' AND kondisi_meter='4')) AS gym_4_m3
	from dsmp0 as d1 order by d1.periode desc limit 1
	;";
	$qry_copy=mysql_query($sql_lap)or die(mysql_error());
	
	//$sql0.=$update." WHERE ".$where." AND periode=201409;";
	if($qry)echo"<script language='javascript'>alert('Berhasil Proses Rekening!');</script>";
	//echo $sql0;
}

?>

	<tr>
		<td>
		<p><h2 align="center" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;">Transfer Data Rekening</h2></p>
		<p><h4 align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif;color:#FFFF66">Pentransferan harus dilakukan setiap bulan<br/>setelah pengisian Stand Meter selesai</h4></p>
		<table align="center" border="0" width="500px" cellpadding="2" cellspacing="2" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
			<?php
            $minus=0;$p1=gperiode();$p2=getPeriodeLalu();
			$sql_minus="
			SELECT FORMAT(COUNT(*),0)
			FROM master AS m
			INNER JOIN dsmp0 AS a ON a.nomor=m.nomor AND a.periode=$p2
			INNER JOIN dsmp0 AS b ON b.nomor=m.nomor AND b.periode=$p1
			WHERE (b.angka-a.angka)<0 AND m.putus='0' AND m.kondisi_meter<>'2'
			;";
			$qry_minus=mysql_query($sql_minus)or die(mysql_error());
			if($row_minus=mysql_fetch_row($qry_minus)){
				$minus=$row_minus[0];
			}
			?>
            <form name="f1" method="post" action="">
			<tr>				
				<td colspan="2" style="font-family:verdana;font-size:18;color:blue;">Rekening bulan: <?php echo"$bulan ".date("Y");?></td>				
			</tr>
            <tr>				
				<td colspan="2" style="font-family:verdana;font-size:12;color:red;">Jumlah Pemakaian Minus: <?php echo $minus." rekening";?></td>				
			</tr>
			<tr>
				<td width="150px"><b>Jenis Rekening</b></td>
				<td>
					<input type="radio" name="r1" value="online" checked="checked"/>Online&nbsp;&nbsp;&nbsp;
					<input type="radio" name="r1" value="offline"/>Non Online (Offline)<br /><br />
					<input type="radio" name="r1" value="onoff"/>Semua (Online & Offline)
				</td>				
			</tr>
			<tr>
				<td colspan="2"><b>Pilihan proses</b></td>				
			</tr>
			<tr>
				<td><input type="radio" name="r2" value="all" checked="checked" />Semua Pelanggan</td>
				<td align="right"><input type="checkbox" name="c1" value="mastung"/>Master Tunggakan</td>				
			</tr>
			<tr>
				<td><input type="radio" name="r2" value="percabang" />Per Cabang</td>
				<td>
					<select name="optcabang" id="optcabang" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select cabang,nama from cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>
				</td>				
			</tr>
			<tr>
				<td><input type="radio" name="r2" value="perwil" />Per Wilayah</td>
				<td>
					<select name="optwilayah" id="optwilayah">
						<option value="" selected="selected">--Pilih Wilayah--</option>
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("SELECT kode_cabang,kode_wilayah,nama_wilayah FROM master_wilayah ORDER BY kode_wilayah");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_wilayah]\">$p[nama_wilayah]</option>\n";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r2" value="perblok" />Per Blok</td>
				<td>
					<select name="optblok" id="optblok">
						<option value="" selected="selected">--Pilih Blok--</option>
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("select * from master_blok order by kode_blok");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_blok]\">$p[ket_blok]</option>\n";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r2"  value="perdkd"/>Per DKD</td>
				<td>
					<select id="optdkd" name="optdkd" onchange="setalamat();" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select dkd,jalan from dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>	
					</select>
				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r2"  value="perpelanggan"/>Dari Nomor Pel.</td>
				<td>
					<input type="text" name="txnopel1" id="txnopel1" size="7" maxlength="6" onkeypress="return isNumb(event);" />&nbsp;s/d&nbsp;
					<input type="text" name="txnopel2" id="txnopel2" size="7" maxlength="6" onkeypress="return isNumb(event);" />
				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r2"  value="pergol"/>Per Golongan</td>
				<td>
					<select name="optgoltarif" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select distinct gol,keterangan from tarif");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><br />
					<input type="submit" name="proses" value="Proses" />&nbsp;
					<input type="reset" name="batal" value="Batal" />
				</td>
			</tr>
			</form>
		</table><br/>

		</td>
	</tr>
	
<?php
putus();
require_once("foot.php");
?>
