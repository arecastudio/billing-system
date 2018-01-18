<?php
ob_start();
session_start();
require_once("mydb.php");
//sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');
$plalu=getPeriodeLalu();

?>

	<tr>
		<td>
		<!--############################################################################################################-->
        <p align="center">&nbsp;</p>		
		<table width="700px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
        	<form name="f1" method="post" action="">
            <tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">>
              <td colspan="4"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:2px 2px 2px red;color:#fff;font-size:19px;"><b>.::  Ambil Dsmp dan LPP dari Cabang ::.</b></font></center></td>
              </tr>
            <tr>
            	<td>Cabang</td>
                <td>
                <select name="optcabang" id="optcabang" >
                  <!--option value="11" selected="selected">Semua UPP</option-->
                  <?php
						$sql=mysql_query("select cabang,nama from cabang WHERE cabang<>'00' AND cabang<>'01' AND cabang<>'06' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>                </td>
                <td><!--input type="submit" name="master" value="Ambil Data Pelanggan" /--></td>
                <td></td>
            </tr>
            <tr>
            	<td>Periode</td>
                <td>
                <select name="optperiode" >
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from dsmp_new order by periode desc limit 2;");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;
							/*$prd0=gperiode();//$row[0];
							while($prd0>=200001){
								echo"<option value=\"$prd0\">$prd0</option>";
								$prd0--;//201405 201404 201001 201000 200912
								if(substr($prd0,4,2)==00)$prd0-=88;
							}*/
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>&nbsp;&nbsp;<i style="color:red;font-size:11px;">Catatan: Ambil Periode lalu ( <?php echo $plalu;?> ) terlebih dahulu!</i></td>
                <td><input type="submit" name="dsmp" value="Ambil DSMP" class="kelas_tombol"/></td>
                <td></td>
            </tr>
            <tr>
            	<td>Tanggal Pelunasan LPP</td>
                <td>
                <input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]                </td>
                <td><input type="submit" name="lpp" value="Ambil LPP" class="kelas_tombol"/></td>
                <td></td>
            </tr>
            </form>
        </table>
        <?php
		
		if(isset($_POST['dsmp'])){
			$cabang=$_POST['optcabang'];
			echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
			$peri=$_POST['optperiode'];
			$ip="";$cbg="00";
			switch($cabang){
				case"01";
					$ip="192.168.0.200";
					$cbg="01";
					break;
				case"02";
					//$ip="192.168.1.5";
					$ip="192.168.1.50";
					$cbg="02";
					break;
				case"03";
					$ip="192.168.2.60";
					$cbg="03";
					break;
				case"04";
					$ip="192.168.5.80";
					$cbg="04";
					break;
				case"05";
					$ip="192.168.4.70";
					$cbg="05";
					break;
			}
			$i=0;
			//konek("192.168.0.200","root","","billing");
			konek($ip,"pdam","","billing");
			$qry=mysql_query("SELECT DISTINCT d.nomor,d.periode,d.angka,m.kondisi_meter,d.petugas,d.tgl_baca,d.keterangan,d.kondisi_meter,d.status FROM dsmp_new AS d INNER JOIN master AS m on m.nomor=d.nomor WHERE d.PERIODE=$peri AND m.cabang='$cabang';")or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;
					//$data[$i]=array($row[0],$row[1],$row[2]);
					$nomor[$i]=$row[0];
					$periode[$i]=$row[1];
					$angka[$i]=$row[2];
					$kwm[$i]=$row[3];					
					$petugas[$i]=$row[4];					
					$tgl_baca[$i]=$row[5];					
					$keterangan[$i]=$row[6];					
					$kondisi_meter[$i]=$row[7];
					$status[$i]=$row[8];
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//putus();
				
				konek("192.168.0.100","pdam","pdamjpr123","billing");
				//$qry=mysql_query("INSERT INTO dsmpo") or die(mysql_error());
				//for($i=0;$i<$jml;$i++){
				$i=0;
				while($i<$jml){
					$i++;
					
					$qry=mysql_query("INSERT IGNORE INTO dsmp_new(nomor,periode,angka,petugas,tgl_baca,keterangan,kondisi_meter,status)VALUES('$nomor[$i]',$periode[$i],$angka[$i],'$petugas[$i]','$tgl_baca[$i]','$keterangan[$i]','$kondisi_meter[$i]',$status[$i]) ON DUPLICATE KEY UPDATE angka=$angka[$i],petugas='$petugas[$i]',tgl_baca='$tgl_baca[$i]',keterangan='$keterangan[$i]',kondisi_meter='$kondisi_meter[$i]',status=$status[$i];") or die(mysql_error());
					//$qry=mysql_query("UPDATE master SET pakai_air_bln=$angka[$i] WHERE nomor='$nomor[$i]' AND (kondisi_meter='3' OR kondisi_meter='4');")or die(mysql_error());
					$qry=mysql_query("UPDATE master SET kondisi_meter=$kwm[$i] WHERE nomor='$nomor[$i]' AND kondisi_meter<>'2';")or die(mysql_error());
					if($kwm[$i]=='3'||$kwm[$i]=='4'){
						$qry=mysql_query("UPDATE master SET kondisi_meter=$kwm[$i],pakai_air_bln=$angka[$i] WHERE nomor='$nomor[$i]' AND (kondisi_meter<>'2');")or die(mysql_error());//update selain segel
						$qry=mysql_query("UPDATE dsmp_new SET angka=$angka[$i],petugas='$petugas[$i]',tgl_baca='$tgl_baca[$i]',keterangan='$keterangan[$i]',kondisi_meter='$kondisi_meter[$i]' WHERE nomor='$nomor[$i]' AND periode=$periode[$i] AND periode<>$plalu;")or die(mysql_error());
					}
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//if($qry)echo"<script language='javascript'>alert('Berhasil Ambil Data!');</script-->";
				//putus();
			}
		}
				
		//===================================================================================================================
		if(isset($_POST['master'])){
			$cabang=$_POST['optcabang'];
			echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
			$ip="";
			switch($cabang){
				case"01";
					$ip="192.168.0.200";
					break;
				case"02";
					$ip="192.168.1.50";
					break;
				case"03";
					$ip="192.168.2.60";
					break;
				case"04";
					$ip="192.168.5.80";
					break;
				case"05";
					$ip="192.168.4.70";
					break;
			}
			
			$i=0;
			konek($ip,"pdam","","billing");
			$qry=mysql_query("SELECT DISTINCT nomor,nolama,nama,alamat,kondisi_meter,putus,pakai_air_bln FROM master WHERE cabang=$cabang AND putus=0;")or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";			
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;
					//$data[$i]=array($row[0],$row[1],$row[2]);
					$nomor[$i]=$row[0];
					$nolama[$i]=$row[1];
					$nama[$i]=$row[2];
					$alamat[$i]=$row[3];
					$kondisi_meter[$i]=$row[4];
					$putus[$i]=$row[5];
					$pakai[$i]=$row[6];
				}
				konek("localhost","root","","billing");
				$i=0;
				while($i<$jml){
					$i++;					
					//$qry=mysql_query("INSERT IGNORE INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					$qry=mysql_query("UPDATE master SET nama='$nama[$i]',alamat='$alamat[$i]',kondisi_meter='$kondisi_meter[$i]',pakai_air_bln=$pakai[$i] WHERE cabang='$cabang' AND nomor='$nomor[$i]' AND nolama='$nolama[$i]';") or die(mysql_error());
				}
				
			}
			
		}
		//===================================================================================================================
		if(isset($_POST['lpp'])){
			$cabang=$_POST['optcabang'];
			echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
			$ip="";
			$cab="";
			switch($cabang){
				case"01";
					$ip="192.168.0.200";
					
					break;
				case"02";
					//$ip="192.168.1.16";
					//$ip="192.168.0.12";
					$ip="192.168.1.50";
					$cab="UJU";
					break;
				case"03";
					$ip="192.168.2.60";
					$cab="ABE";
					break;
				case"04";
					$ip="192.168.5.80";
					$cab="WNA";
					break;
				case"05";
					$ip="192.168.4.70";
					$cab="STN";
					break;
			}
			
			$tawal='2000-01-01';
			$takhir=date('Y-m-d');
			if(($key1=$_POST['txtawal'])!=''){
			$tawal=$key1;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$tawal\";</script>";
			}
			if(($key2=$_POST['txtakhir'])!=''){
				$takhir=$key2;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$takhir\";</script>";
			}
			
			//=============================REKENING1
			$i=0;
			//konek("192.168.0.200","root","","billing");
			konek($ip,"pdam","","billing");
			//$qry=mysql_query("SELECT DISTINCT nomor,periode,angka FROM dsmp0 WHERE PERIODE=201409")or die(mysql_error());
			//$qry=mysql_query("SELECT DISTINCT nomor,periode,standlalu,standkini,pakai,loket,tbayar,uangair,adm,meter,denda,meterai,total,status_bayar FROM rekening1 WHERE status_bayar=1 AND loket='$cab' AND (tbayar BETWEEN '$tawal' AND '$takhir');")or die(mysql_error());
			$qry=mysql_query("SELECT DISTINCT r.nomor,r.periode,r.standlalu,r.standkini,r.pakai,r.loket,r.tbayar,r.uangair,r.adm,r.meter,r.denda,r.meterai,r.total,r.status_bayar FROM rekening1 AS r INNER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode WHERE r.status_bayar=1 AND t.loket='$cab' AND (t.tbayar BETWEEN '$tawal' AND '$takhir');")or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;
					//$data[$i]=array($row[0],$row[1],$row[2]);
					$nomor[$i]=$row[0];
					$periode[$i]=$row[1];					
					$standlalu[$i]=$row[2];
					$standkini[$i]=$row[3];
					$loket[$i]=$row[4];
					$tbayar[$i]=$row[5];
					$uangair[$i]=$row[6];
					$adm[$i]=$row[7];
					$meter[$i]=$row[8];
					$denda[$i]=$row[9];
					$meterai[$i]=$row[10];
					$total[$i]=$row[11];
					$statbayar[$i]=$row[12];
					
					
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//putus();
				
				konek("192.168.0.100","pdam","pdamjpr123","billing");
				//$qry=mysql_query("INSERT INTO dsmpo") or die(mysql_error());
				//for($i=0;$i<$jml;$i++){
				$i=0;
				while($i<$jml){
					$i++;
					
					//$qry=mysql_query("INSERT IGNORE INTO dsmp_copy(nomor,periode,angka)VALUES('$nomor[$i]',$periode[$i],$angka[$i])") or die(mysql_error());
					//$qry=mysql_query("INSERT IGNORE INTO transaksi_copy(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					//$qry=mysql_query("INSERT IGNORE INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					$sql_rek="
					UPDATE rekening1 SET
					status_bayar=1, tbayar='$tbayar[$i]', loket='$loket[$i]'
					WHERE nomor='$nomor[$i]' AND periode=$periode[$i] AND status_bayar=0
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}			
			//=================TRANSAKSI======================================
			$i=0;
			//konek("192.168.0.200","root","","billing");
			konek($ip,"pdam","","billing");
			//$qry=mysql_query("SELECT DISTINCT nomor,periode,angka FROM dsmp0 WHERE PERIODE=201409")or die(mysql_error());
			$qry=mysql_query("SELECT DISTINCT nomor,periode,total,tbayar,jbayar,loket,operator,batal FROM transaksi WHERE (tbayar BETWEEN '$tawal' AND '$takhir');")or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;
					//$data[$i]=array($row[0],$row[1],$row[2]);
					$nomor[$i]=$row[0];
					$periode[$i]=$row[1];
					$total[$i]=$row[2];
					$tbayar[$i]=$row[3];
					$jbayar[$i]=$row[4];
					$loket[$i]=$row[5];
					$operator[$i]=$row[6];
					$batal[$i]=$row[7];
					
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//putus();
				
				konek("192.168.0.100","pdam","pdamjpr123","billing");
				//$qry=mysql_query("INSERT INTO dsmpo") or die(mysql_error());
				//for($i=0;$i<$jml;$i++){
				$i=0;
				while($i<$jml){
					$i++;
					
					//$qry=mysql_query("INSERT IGNORE INTO dsmp_copy(nomor,periode,angka)VALUES('$nomor[$i]',$periode[$i],$angka[$i])") or die(mysql_error());
					//$qry=mysql_query("INSERT IGNORE INTO transaksi_copy(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					$qry=mysql_query("INSERT IGNORE INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//if($qry)echo"<script language='javascript'>alert('Berhasil Ambil Data!');</script-->";
				//putus();
			}			
			//======================================
		}
		
		?>
        <br/>
        <table width="820" align="center" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 0 0 15px #999;" background="img/grids.gif">
<tr>
				<td width="100%" align="center">
                <div style="height:300px;overflow:auto">
                    <table width="800px" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
        <?php
        if(isset($_POST['dsmp'])){			
			echo"<tr style=\"background-color:#909090;color:#FFFFFF;\">";
			echo"<th width=\"2px\">No.</th><th>Nomor</th><th>Periode</th><th>Angka Meter</th>";
			echo"</tr>";
			$i=0;
			while($i<$jml){
				$i++;
				echo"<tr><td align=left>$i</td><td align=center>$nomor[$i]</td><td align=center>$periode[$i]</td><td align=right>$angka[$i]</td></tr>";
			}
		}else if(isset($_POST['lpp'])){
			echo"<tr style=\"background-color:#909090;color:#FFFFFF;\">";
			echo"<th width=\"2px\">No.</th><th>Nomor</th><th>Periode</th><th>Total</th><th>Tgl Bayar</th><th>Jam</th><th>Loket</th><th>Kasir</th><th>Stat<br>Trans</th>";
			echo"</tr>";
			$i=0;
			while($i<$jml){
				$i++;
				//echo"<tr><td align=left>$i</td><td align=center>$nomor[$i]</td><td align=center>$periode[$i]</td><td align=right>$angka[$i]</td></tr>";
				if($batal[$i]==0){$btl='LUNAS';}else{$btl='DIBATALKAN';}
				echo"<tr>
				<td align=left>$i</td>
				<td align=center>$nomor[$i]</td>
				<td align=center>$periode[$i]</td>
				<td align=right>$total[$i]</td>
				<td align=center>$tbayar[$i]</td>
				<td align=center>$jbayar[$i]</td>
				<td align=center>$loket[$i]</td>
				<td align=center>$operator[$i]</td>				
				<td align=center>$btl</td>
				</tr>";
			}
		}else if(isset($_POST['master'])){
			echo"<tr style=\"background-color:#909090;color:#FFFFFF;\">";
			echo"<th width=\"2px\">No.</th><th>Nomor</th><th>NoLama</th><th>Nama</th><th>Alamat</th><th>Kondisi<br>Meter</th>";
			echo"</tr>";
			$i=0;
			while($i<$jml){
				$i++;
				echo"<tr>
				<td align=center>$i</td>
				<td align=center>$nomor[$i]</td>
				<td align=center>$nolama[$i]</td>
				<td align=left>$nama[$i]</td>
				<td align=left>$alamat[$i]</td>
				<td align=center>$kondisi_meter[$i]</td>
				</tr>";
			}
		}
		?>
                    </table>
                </div>
                </td>
           </tr>
     	</table>
							
        	  
		<!--############################################################################################################-->
	  </td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
