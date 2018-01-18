<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");
?>

<tr>
	<td>
	<br/>
		<center><font face="Arial,sans-serif" size="4px"><b>Cetak Konfirmasi DSMP</b></font></center>
		<div class="wrapper">
			
		<table background="img/grids.gif" width="700px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="return suvalid(this);">
			<tr>
				<td colspan="2"><input type="radio" name="rd1" id="rd1" value="all" />&nbsp;Semua Pelanggan</td>
				<td align="center">
					<input type="submit" name="proses" value="Proses"/>&nbsp;
					<input type="reset" name="reset" value="Batal">
				</td>
			</tr>
			<tr>
				<td width="130px"><!--input type="radio" name="rd1" id="rd1" value="tgl" />&nbsp;Tanggal pasang</td-->
				<td colspan="2">
					<!--input type="text" size="11" maxlength="10" name="txtawal" class="datepicker"  />
					s/d <input type="text" size="11" maxlength="10" name="txtakhir" class="datepicker"  /-->
				</td>
				
			</tr>
			<tr>
				<td><input type="radio" name="rd1" id="rd1" value="cabang" />&nbsp;Cabang</td>
				<td>
					<select name="optcabang" id="optcabang" >
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select cabang,nama from cabang order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>
				</td>
				<td><input type="radio" name="rd2" id="rd2" value="all" checked="checked" />&nbsp;Semua pemakaian</td>
			</tr>
			<tr>
				<td><input type="radio" name="rd1" id="rd1" value="wil" />&nbsp;Wilayah</td>
				<td>
					<select name="optwilayah" id="optwilayah">
						<!--option value="" selected="selected">--Pilih Wilayah--</option-->
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("SELECT kode_cabang,kode_wilayah,nama_wilayah FROM master_wilayah ORDER BY kode_wilayah");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_wilayah]\">$p[nama_wilayah]</option>\n";
						}
						?>
					</select>
				</td>
				<td><input type="radio" name="rd2" id="rd2" value="belum" />&nbsp;Belum di-isi</td>
			</tr>
			<tr>
				<td><input type="radio" name="rd1" id="rd1" value="blok" checked="checked" />&nbsp;Blok</td>
				<td>
					<select name="optblok" id="optblok">
						<!--option value="" selected="selected">--Pilih Blok--</option-->
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("select * from master_blok order by kode_blok");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_blok]\">$p[kode_blok] - $p[ket_blok]</option>\n";
						}
						?>
					</select>
				</td>
				<td><!--<input type="radio" name="rd2" id="rd2" value="nol" />&nbsp;Pemakaian nol--></td>
			</tr>
			<tr>
				<td><input type="radio" name="rd1" id="rd1" value="dkd" />&nbsp;DKD/Jalan</td>
				<td>
					<select id="optdkd" name="optdkd" onchange="setalamat();" >
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select dkd,jalan from dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>	
					</select>
				</td>
				<td><input type="radio" name="rd2" id="rd2" value="kurang" />&nbsp;Pemakaian <=&nbsp;&nbsp;
					<input type="text" name="txkecil" id="txkecil" value="" size="2px" />
				</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="chjpel" />Jns Pelanggan</td>
				<td>
					<select name="optjpel">
						<!--option value="">-Pilih-</option-->
						<?php
						$sql=mysql_query("select kode_jenis_pel,ket_jenis_pel from pel_jenis");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>
				</td>
				<td><input type="radio" name="rd2" id="rd2" value="lebih" />
				Pemakaian &gt;=&nbsp;&nbsp;
				<input type="text" name="txbesar" id="txbesar" value="" size="2px" />
				</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="chkwm" name="chkwm" />Kondisi WM</td>
				<td>
					<select name="optkwm">
						<!--option value="">-Pilih-</option-->
						<?php
						$sql=mysql_query("select kode_kondisi,ket_kondisi from meter_kondisi");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>
				</td>
				<td>
					<input type="radio" name="rd2" id="rd2" value="tahun" />&nbsp;Satu tahun
					<select name="optthn">
						<!--option value="">-Pilih-</option-->
						<?php
							$thn=date('Y');
							while($thn>=2000){								
								echo"<option value=\"$thn\">$thn</option>";
								$thn--;
							}						
						?>
					</select>
				</td>
			</tr>
			</form>
		</table>
		<br/>
		<!--######################################################################-->
		<table background="img/grids.gif" width="900px" align="center" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 0 0 15px #999;">
		<tr>
		<td width="100%" align="center">
		<div style="height:300px;overflow:auto">
		<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">
			<tr align="center" style="background-color:#909090;color:#FFFFFF;font-weight:bold;">
				<td>No.</td>
				<td>Nomor</td>
				<td>No. Lama</td>
				<td>Nama</td>
				<td>Alamat</td>
				<td>DKD</td>
				<td>St. Lalu</td>
				<td>St. Kini</td>
				<td>Pakai</td>
                <td>St<br>Mtr</td>
			</tr>
			<?php
			$plalu=getPeriodeLalu();$pkini=gperiode();$i=0;
			$sql="";
			$slipit="";
			$judul="Daftar Pemakaian Air [Konfirmasi] - Rek. Periode [$pkini]";
			$kwm="";$jpel="";
			
			//variable2 dari get/post harus berada dalam blok event(tombol,ect) jika tidak,php akan membaca sebagai var tak berindex(tanpa arah/pemicu)
			if(isset($_POST["proses"])){
				$r1=$_POST['rd1'];
				$r2=$_POST['rd2'];
				//$tgl_awal=$_POST['txtawal'];
				//$tgl_akhir=$_POST['txtakhir'];
				$pkecil=$_POST['txkecil'];$nkecil=10;
				$pbesar=$_POST['txbesar'];$nbesar=100;
				$slipit=" a.nomor=b.nomor and b.nomor=m.nomor and a.periode=$plalu and b.periode=$pkini and m.putus='0' ";
				$jdl="";
			
				switch($r1){
					case"all":
						//$slipit="";
						break;
					//case"tgl":
					//	//$slipit="";
					//	if($tgl_awal !="" && $tgl_akhir !="")$slipit=cek_slip($slipit)."(m.tglstart BETWEEN '$tgl_awal' AND '$tgl_akhir')";
					//	$judul.="<br>per-tanggal $tgl_awal s/d $tgl_akhir";
					//	break;
					case"cabang":
						if(($cabang=$_POST['optcabang']) !="")$slipit=cek_slip($slipit)."m.cabang='$cabang'";
						$judul.="<br>Cabang:".getNama("nama","cabang",$cabang,"cabang");
						break;
					case"wil":
						if(($wil=$_POST['optwilayah']) !="")$slipit=cek_slip($slipit)."m.kode_wilayah='$wil'";
						$judul.="<br>Wilayah: $wil";
						break;
					case"blok":
						if(($blok=$_POST['optblok']) !="")$slipit=cek_slip($slipit)."m.kode_blok='$blok'";
						$judul.="<br>Blok: $blok";
						break;
					case"dkd":
						if(($dkd=$_POST['optdkd']) !="")$slipit=cek_slip($slipit)."m.dkd='$dkd'";
						$jalan=getNama("jalan",$dkd,"dkd","dkd");
						$judul.="<br>DKD: $dkd - $jalan";
						break;
				}
				
				switch($r2){
					case"belum":
						$slipit=cek_slip($slipit)."(b.angka=0 AND a.angka<>b.angka)";
						$judul.="<br>Stand Meter Belum Terisi";
						break;
					//case"nol":
					//	$slipit=cek_slip($slipit)."(b.angka-a.angka)=0";
					//	$judul.="<br>Stand Mtr: Pemakaian Nol (0)";
					//	break;
					case"kurang":
						if($pkecil!="")$nkecil=$pkecil;
						$slipit=cek_slip($slipit)."(b.angka-a.angka)<=$nkecil";
						$judul.="<br>Pemakaian Lebih Kecil atau Setara [$nkecil]";
						break;
					case"lebih":
						if($pbesar!="")$nbesar=$pbesar;
						$slipit=cek_slip($slipit)."(b.angka-a.angka)>$nbesar";
						$judul.="<br>Pemakaian Lebih Besar atau Setara [$nbesar]";
						break;
				}
				 
				if(isset($_POST["chkwm"])){
					if(($kwm=$_POST['optkwm']) !="")$slipit=cek_slip($slipit)."m.kondisi_meter='$kwm'";
					$judul.="<br>Kondisi WM: $kwm";
				}
				if(isset($_POST["chjpel"])){
					if(($jpel=$_POST['optjpel']) !="")$slipit=cek_slip($slipit)."m.jenis_pel='$jpel'";
					$judul.="<br>Jenis Pel. : $jpel";
				}
				
				if ($slipit!="")$slipit=" where ".$slipit;
				
				$alg=array("center","center","left","left","center","right","right","right","center");
				$sql="select m.nomor,m.nolama,SUBSTR(m.nama,1,30),SUBSTR(m.alamat,1,30),m.dkd,a.angka,b.angka,(b.angka-a.angka),m.kondisi_meter from master as m,dsmp0 as a,dsmp0 as b $slipit order by m.nolama";
				$query=mysql_query($sql) or die(mysql_error());
				while($row=mysql_fetch_row($query)){
					$i++;
					echo"<tr>";
					echo"<td align=center>$i</td>";
					echo"<td align=center>".trim($row[0])."</td>";
					echo"<td align=center>".trim($row[1])."</td>";
					echo"<td>".trim($row[2])."</td>";
					echo"<td>".trim($row[3])."</td>";
					echo"<td align=center>".trim($row[4])."</td>";
					echo"<td align=right>".trim($row[5])."</td>";
					echo"<td align=right>".trim($row[6])."</td>";
					echo"<td align=right>".trim($row[7])."</td>";
					echo"<td align=right>".trim($row[8])."</td>";
					//echo"<td align=right>".((trim($row[6]))-(trim($row[5])))."</td>";
					echo"</tr>";					
				}
				//cho"<tr><td colspan=9>$sql</td></tr>";
				
				$sql1="
				SELECT IFNULL(FORMAT(sum(b.angka-a.angka),0),0) AS hsl
				FROM master AS m
				INNER JOIN dsmp0 AS a ON a.nomor=m.nomor
				INNER JOIN dsmp0 AS b ON b.nomor=m.nomor 
				$slipit AND b.angka-a.angka>0
				;";
				$query=mysql_query($sql1) or die(mysql_error());
				if($row=mysql_fetch_row($query)){
					$total_pakai=$row[0];
				}
				//echo $total_pakai;
				$tfoot="
				<tr>
					<th colspan=\"5\">TOTAL PEMAKAIAN [M<sup>3</sup>]</th>
					<th colspan=\"5\" align=\"right\">$total_pakai</th>
				</tr>
				";
				echo $tfoot;
				//inject session bof
				$_SESSION['tfooter']=$tfoot;
				$_SESSION["judul"]=$judul;
				$_SESSION["jumfield"]=9;
				$_SESSION["eskiel"]=$sql;
				$_SESSION["alinea"]=$alg;
				$_SESSION["theader"]="
				<tr align=\"center\" style=\"background-color:#fff;color:#000;font-weight:bold;\">
					<th>No.</th>
					<th>Nomor</th>
					<th>No. Lama</th>
					<th width=200>Nama</th>
					<th width=200>Alamat</th>
					<th>DKD</th>
					<th>Stand<br>Lalu</th>
					<th>Stand Kini</th>
					<th>Pakai</th>
					<th>St<br>Mtr</th>
				</tr>
				";
				$_SESSION['orientasi']="P";
				$_SESSION['ttd']="<br>
				<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
				<tr width=\"100%\">
					<td width=\"300\" align=\"center\">
						Diketahui oleh,<br>
						<br><br>
						...............................<br>Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td width=\"300\" align=\"center\">
						Dibuat oleh,<br>
						<br><br>
						...............................<br>
						Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
				</tr></table>
				";
				//inject session eof
			}
														
			?>
		</table>
		</div>
		</td>
		</tr>
		<tr>
			<td align="center">
				<a href="reports/print_report.php" target="_blank">-= Cetak Report =-</a>
			</td>
		</tr>
		</table>
		
		<br/>
		<!--######################################################################-->
		
		</div>
	
	
	</td>
</tr>

<?php
putus();
require_once("foot.php");
?>