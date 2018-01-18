<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();

//$bulan="";
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
	$sql="
	INSERT IGNORE INTO rekening1(nomor,periode,standlalu,standkini,pakai)
	SELECT m.nomor,b.periode,a.angka AS stlalu,b.angka AS stkini,(b.angka-a.angka)as pakai1	
	FROM master AS m
	INNER JOIN dsmp0 AS a ON a.nomor=m.nomor AND a.periode=$lastperiod
	INNER JOIN dsmp0 AS b ON b.nomor=m.nomor AND b.periode=$period
	WHERE m.putus='0'
	;	
	";
	//WHERE m.putus='0' AND m.kondisi_meter<>'2'
	$qry1=mysql_query($sql)or die(mysql_error());//simpan rekening kosong
	
	//mulai proses update uangair cs
	//,(SELECT adm FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS tadm
	$sql="
	SELECT m.nomor,m.gol,r.periode,r.pakai
	,(SELECT tarip1 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS t1
	,(SELECT tarip2 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS t2
	,(SELECT tarip3 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS t3
	,(SELECT tarip4 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS t4	
	,(SELECT n.nadm FROM adm AS n WHERE n.periode<=r.periode ORDER BY n.periode DESC LIMIT 0,1)AS adm1
	,(SELECT meter FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS tmeter
	,(SELECT denda1 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 0,1)AS tdenda
	,(SELECT b1.batas1 FROM adm AS b1 WHERE b1.periode<=r.periode ORDER BY b1.periode DESC LIMIT 0,1)AS bts1
	,(SELECT b2.batas2 FROM adm AS b2 WHERE b2.periode<=r.periode ORDER BY b2.periode DESC LIMIT 0,1)AS bts2
	,(SELECT m1.met1 FROM adm AS m1 WHERE m1.periode<=r.periode ORDER BY m1.periode DESC LIMIT 0,1)AS mtr1
	,(SELECT m2.met2 FROM adm AS m2 WHERE m2.periode<=r.periode ORDER BY m2.periode DESC LIMIT 0,1)AS mtr2
	,m.kondisi_meter
	FROM rekening1 AS r
	INNER JOIN master AS m ON m.nomor=r.nomor
	WHERE r.periode=$period
	ORDER BY m.nomor
	";
	//ambil nomor,golongan,pemakaian
	$sql0="update rekening1 set ";//uangair=".setUangAir($use,$t1,$t2,$t3,$t4)." where nomor=$nmr1 and periode=201409";
	$where="";$update="";
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
			$kwm=$row[15];
		//}
		$uangair=setUangAir($use,$t1,$t2,$t3,$t4);
		$tuangair=$uangair;
		if($uangair<=0)$tuangair=0;
		
		if($uangair>=$bts2){
			$meterai=$mtr2;
		}else if($uangair>=$bts1 && $uangair<$bts2){
			$meterai=$mtr1;
		}else{
			$meterai=0;
		}
		
		if($kwm=='2'){
			$uangair=0;
			$tuangair=0;
		}else if($kwm=='4'){
			$mtr=0;
		}
		//if($update!="")$update.=" AND ";
		//$update.=" uangair=$uangair ";//." where nomor=$nmr1 and periode=201409";
		
		$sql0="UPDATE rekening1 SET uangair=$uangair,adm=$adm,meter=$mtr,denda=$denda,meterai=$meterai,total=($tuangair+$adm+$mtr+$denda+$meterai) WHERE nomor='$nmr1' AND periode=$period;";
		$qry30=mysql_query($sql0)or die(mysql_error());		
		
		//if($where!="")$where.=" AND ";
		//$where.=" nomor=$nmr1";
	}
	$sql_copy="INSERT IGNORE INTO rekening1_awal SELECT DISTINCT * FROM rekening1 WHERE periode=$period;";
	$qry_copy=mysql_query($sql_copy)or die(mysql_error());
	
	//$sql0.=$update." WHERE ".$where." AND periode=201409;";
	if($qry)echo"<script language='javascript'>alert('Berhasil Proses Rekening!');</script>";
	//echo $sql0;
}

?>

	<tr>
		<td>
		<p><h2 align="center">Transfer Data Rekening</h2></p>
		<p align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif">Pentransferan harus dilakukan setiap bulan<br/>setelah pengisian Stand Meter selesai</p>
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