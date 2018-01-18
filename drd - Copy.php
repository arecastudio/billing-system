<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
?>

	<tr>
		<td>
		
		<center><font face="Arial,sans-serif" size="4px"><b>Daftar Rekening Ditagih [DRD]</b></font></center>
		<table width="800px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="">
			<tr>
				<td width="130px">Jenis Iktisar</td>
				<td width="300px">
					<input type="radio" name="rjenis" id="rjenis" value="rjnow" />Bulan ini &nbsp;&nbsp;
					<input type="radio" name="rjenis" id="rjenis" value="rjtill" />Sebelum Bulan ini &nbsp;&nbsp;
					<input type="radio" name="rjenis" id="rjenis" value="rjall" checked="checked" />Semua
				</td>
			  	<td>Periode Rek.</td>
				<td>
				<select name="optperiode" >
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						//$sql=mysql_query("select distinct periode from rekening1 order by periode desc");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						//if($row=mysql_fetch_row($sql)){
							//$i=0;
							$prd0=gperiode();//$row[0];
							while($prd0>=200001){
								echo"<option value=\"$prd0\">$prd0</option>";
								$prd0--;//201405 201404 201001 201000 200912
								if(substr($prd0,4,2)==00)$prd0-=88;
							}
							//echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						//}
					?>
                </select>
				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" value="perupp">Cabang [UPP]</td>
				<td>
					<select name="optcabang" id="optcabang" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select cabang,nama from cabang order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>
				</td>
			  <td><input type="checkbox" name="chpergol"  value="pergol"/>
		      Per Gol.</td>
				<td>
				<select name="optgoltarif" >
                  <option value="" selected="selected">--Pilih--</option>
                  <?php
						$sql=mysql_query("select distinct gol,keterangan from tarif order by gol");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>
				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" value="perwil" />Wilayah</td>
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
			  <td><input type="checkbox" name="chjpel" />
		      Jns Pel.</td>
				<td>
				<select name="optjpel">
                  <option value="">-Pilih-</option>
                  <?php
						$sql=mysql_query("select kode_jenis_pel,ket_jenis_pel from pel_jenis order by kode_jenis_pel");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>
				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" value="perblok" checked="checked" />Blok</td>
				<td>
					<select name="optblok" id="optblok">
						<option value="" selected="selected">--Pilih Blok--</option>
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("select * from master_blok order by kode_blok");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_blok]\">$p[kode_blok] - $p[ket_blok]</option>\n";
						}
						?>
					</select>
				</td>
				<td><input type="checkbox" id="chkwm" name="chkwm" />
			    Kondisi WM</td>
				<td>
				<select name="optkwm">
                  <option value="">-Pilih-</option>
                  <?php
						$sql=mysql_query("select kode_kondisi,ket_kondisi from meter_kondisi order by kode_kondisi");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>
				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1"  value="perdkd"/>DKD</td>
				<td>
					<select id="optdkd" name="optdkd" onchange="setalamat();" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select dkd,jalan from dkd order by dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>	
					</select>
				</td>
				<td align="right">Jns Report</td>
				<td>
					<input type="radio" name="rjrep" id="rjrep" value="rjdetail" />Detail &nbsp;&nbsp;
					<input type="radio" name="rjrep" id="rjrep" value="rjrekap" checked="checked" />Rekap
				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1"  value="pernomor"/>Dari No. Pel</td>
				<td>
					<input type="text" name="txno1" size="7" maxlength="6" onkeypress="return isNumb(event);" />&nbsp;s/d&nbsp;
					<input type="text" name="txno2" size="7" maxlength="6" onkeypress="return isNumb(event);" />
				</td>
				<td></td>
				<td align="right">
					<input type="submit" name="proses" value="Proses" />
					<input type="button" name="batal" value="Batal" onclick="location.header('drd.php');" />
				</td>
			</tr>
			</form>
		</table>
		<br />
		<table width="1024px" align="center" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 0 0 15px #999;" background="img/grids.gif">
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">
							<!--tr align="center" style="background-color:#909090;color:#FFFFFF;font-weight:bold;">
								<td>No</td>
								<td>Nomor</td>
								<td>NoLama</td>
								<td>Nama</td>
								<td>Cab</td>
								<td>Wil</td>
								<td>DKD</td>
								<td>St<br>Lalu</td>
								<td>St<br>Kini</td>
								<td>Pakai</td>
								<td>Uang<br>Air</td>
								<td>Adm</td>
								<td>Meter</td>
								<td>Meterai</td>
								<td>Total</td>
							</tr-->
							<?php
								if (isset($_POST["proses"])&& $_POST["proses"]=="Proses"){
									$slipit="";									
									$periode=$_POST["optperiode"];
									$judul="Laporan Daftar Rekening Ditagih [DRD] - Periode [$periode]";
									
									if(isset($_POST["rjenis"])){
										switch($_POST["rjenis"]){
											case"rjnow":												
												//$judul.="<br>Jenis Rekening: Bulan ini";
												break;
											case"rjtill":
												//$judul.="<br>Jenis Rekening: Sebelum bulan ini";
												break;
											case"rjall":
												break;
										}										
									}
									
									if(isset($_POST["r1"]))$radio1=$_POST["r1"];
									switch($radio1){
										case"perupp":
											if(($key=$_POST["optcabang"])!=""){
												$slipit=cek_slip($slipit)."m.cabang='$key'";
												$judul.="<br>Cabang UPP : $key";
											}
											break;
											
										case"perwil":
											if(($key=$_POST["optwilayah"])!=""){
												$slipit=cek_slip($slipit)."m.kode_wilayah='$key'";
												$judul.="<br>Wilayah : $key";
											}
											break;
											
										case"perblok":
											if(($key=$_POST["optblok"])!=""){
												$slipit=cek_slip($slipit)."m.kode_blok='$key'";
												$judul.="<br>Blok : $key";
											}
											break;
											
										case"perdkd":
											if(($key=$_POST["optdkd"])!=""){
												$slipit=cek_slip($slipit)."m.dkd='$key'";
												$judul.="<br>DKD [WPT] : $key";
											}
											break;
											
										case"pernomor":
											if(($key1=$_POST["txno1"])!="" && ($key2=$_POST["txno2"])!=""){
												$slipit=cek_slip($slipit)."m.nomor BETWEEN '$key1' AND '$key2'";
												$judul.="<br>Dari Nomor Pelanggan : [$key1] s/d [$key2]";
											}
											break;
									}
									
									if(isset($_POST["chpergol"])&&($key=$_POST['optgoltarif'])!=''){
										$slipit=cek_slip($slipit)."m.gol='$key'";
										$judul.="<br>Golongan Tarif : $key";
									}
									
									if(isset($_POST["chjpel"])&&($key=$_POST['optjpel'])!=''){
										$slipit=cek_slip($slipit)."m.jenis_pel='$key'";
										$judul.="<br>Jenis Pelanggan : $key";
									}
									
									if(isset($_POST["chkwm"])&&($key=$_POST['optkwm'])!=''){
										$slipit=cek_slip($slipit)."m.kondisi_meter='$key'";
										$judul.="<br>Kondiwi Water Meter : $key";
									}
									//=====================================BOF=DETAIL==============================================
									if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjdetail"){
										$i=0;
										$theader="
										<tr align=\"center\" style=\"background-color:#909090;color:#FFFFFF;font-weight:bold;\">
											<td>No</td>
											<td>Nomor</td>
											<td>NoLama</td>
											<td width=250>Nama</td>
											<td>Cab</td>
											<td>Wil</td>
											<td>DKD</td>
											<td>St<br>Lalu</td>
											<td>St<br>Kini</td>
											<td>Pakai</td>
											<td>Uang<br>Air</td>
											<td>Adm</td>
											<td>Meter</td>
											<td>Meterai</td>
											<td>Total</td>
										</tr>
										";																	
										
										$alg=array("center","center","left","center","center","center","right","right","right","right","right","right","right","right");
										if($slipit!="")$slipit.=" AND ";
										//$sql="SELECT r.nomor,m.nolama,m.nama,m.cabang,m.kode_wilayah,m.dkd,r.standlalu,r.standkini,r.pakai,format(r.uangair,0),format(r.adm,0),format(r.meter,0),format(r.meterai,0),format(r.total,0) FROM rekening1 AS r, master AS m WHERE $slipit r.nomor=m.nomor and r.periode=$periode ORDER BY m.nolama;";
										$sql="
										SELECT r.nomor, m.nolama, m.nama, m.cabang, m.kode_wilayah, m.dkd, r.standlalu, r.standkini, r.pakai, format(r.uangair,0), format(r.adm,0), format(r.meter,0), format(r.meterai,0), format(r.total,0) FROM rekening1 AS r
INNER JOIN master AS m on m.nomor=r.nomor
WHERE $slipit r.periode=$periode ORDER BY m.nolama;
										";																			
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo $theader;//Cetak TR pertama sebagai header table
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[1]</td>
												<td>$row[2]</td>
												<td align=center>$row[3]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=right>$row[6]</td>
												<td align=right>$row[7]</td>
												<td align=right>$row[8]</td>
												<td align=right>$row[9]</td>
												<td align=right>$row[10]</td>
												<td align=right>$row[11]</td>
												<td align=center>$row[12]</td>
												<td align=right>$row[13]</td>
											</tr>
											";
										}
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										//$sql_jml="SELECT format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.total),0) FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 ORDER BY m.nolama;";
										$sql_jml="
										SELECT format(SUM(r.pakai),0), format(SUM(r.uangair),0), format(SUM(r.adm),0), format(SUM(r.meter),0), format(SUM(r.meterai),0), format(SUM(r.total),0) FROM rekening1 AS r
INNER JOIN master AS m ON m.nomor=r.nomor
WHERE  $slipit r.periode=$periode ORDER BY m.nolama;
										";
										
										$qry0=mysql_query($sql_jml)or die("err: ".mysql_error());
										if($row0=mysql_fetch_row($qry0)){
											$jpakai=$row0[0];
											$juangair=$row0[1];
											$jadm=$row0[2];
											$jmeter=$row0[3];
											$jmeterai=$row0[4];
											$jtotal=$row0[5];
										}
										$tfooter="
										<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\">											
											<td colspan=\"9\" height=\"20\">GRAND TOTAL</td>
											<td>$jpakai</td>
											<td>$juangair</td>
											<td>$jadm</td>
											<td>$jmeter</td>
											<td>$jmeterai</td>
											<td>$jtotal</td>
										</tr>
										";
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										
										$_SESSION["judul"]=$judul;
										$_SESSION["jumfield"]=14;
										$_SESSION["eskiel"]=$sql;
										$_SESSION["alinea"]=$alg;
										$_SESSION["theader"]=$theader;
										//$_SESSION["jumdata"]=$jml_data;
										$_SESSION["tfooter"]=$tfooter;
									//=====================================BOF=REKAP==============================================
									}if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
										$i=0;
										$theader="
										<tr align=\"center\" style=\"background-color:#909090;color:#FFFFFF;font-weight:bold;\">
											<td>No.</td>
											<td>KODE</td>
											<td>GOLONGAN TARIF</td>
											<td>JML REK.<br>AIR</td>
											<td>PAKAI<br>AIR M<sup>3</sup></td>
											<td>HARGA AIR<br>Rp.</td>
											<td>ADM</td>
											<td>DANA METER</td>											
											<td>METERAI</td>
											<td>TOTAL</td>
											<td>RATA<sup>2</sup><br>HARGA</td>
											<td>RATA<sup>2</sup><br>KONS.</td>
										</tr>
										";
										$alg=array("center","left","right","right","right","right","right","right","right","right","right","right");
										
										if($slipit!="")$slipit.=" AND ";
										//$sql="SELECT distinct m.gol, FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 ORDER BY m.nolama;";
										$sql="SELECT distinct m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM(r.total),0) as jtotal, format(ifnull((sum(r.uangair)/sum(r.pakai)),0),0)as avg_harga, format(ifnull((sum(r.pakai)/count(*)),0),0)as avg_plg FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 GROUP BY m.gol ORDER BY m.gol;";
										
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo $theader;//Cetak TR pertama sebagai header table
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=left>$row[1]</td>
												<td align=right>$row[2]</td>
												<td align=right>$row[3]</td>
												<td align=right>$row[4]</td>
												<td align=right>$row[5]</td>
												<td align=right>$row[6]</td>
												<td align=right>$row[7]</td>
												<td align=right>$row[8]</td>
												<td align=right>$row[9]</td>
												<td align=right>$row[10]</td>
											</tr>
											";
										}
										
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.total),0) FROM rekening1 r,master m WHERE $slipit m.nomor=r.nomor AND r.periode=$periode;";
										
										$qry0=mysql_query($sql_jml)or die("err: ".mysql_error());
										if($row0=mysql_fetch_row($qry0)){
											$jrek=$row0[0];
											$jpakai=$row0[1];
											$juangair=$row0[2];
											$jadm=$row0[3];
											$jmeter=$row0[4];
											$jmeterai=$row0[5];
											$jtotal=$row0[6];
										}
										$tfooter="
										<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\">											
											<td colspan=\"3\" height=\"20\">GRAND TOTAL</td>
											<td align=right>$jrek</td>
											<td align=right>$jpakai</td>
											<td align=right>$juangair</td>
											<td align=right>$jadm</td>
											<td align=right>$jmeter</td>
											<td align=right>$jmeterai</td>
											<td align=right>$jtotal</td>
											<td colspan=2>&nbsp;</td>
										</tr>
										";
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										
										$_SESSION["judul"]=$judul;
										$_SESSION["jumfield"]=11;
										$_SESSION["eskiel"]=$sql;
										$_SESSION["alinea"]=$alg;
										$_SESSION["theader"]=$theader;
										//$_SESSION["jumdata"]=$jml_data;
										$_SESSION["tfooter"]=$tfooter;
									}
									
									//echo"<tr bgcolor=#fff><td colspan=15 align=center>$sql</td></tr>";
								}
							?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
			<td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
				<a href="reports/print_report.php" target="_blank" style="font-size:16px;">-= Cetak Report =-</a>******************
				<input type="checkbox" name="chcustprint" value="customprint" />Custom -=>
				Mengetahui:
				<select name="optrespon1" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<option value="" selected="selected">--Pilih--</option>
					<?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nama from users order by nama");
					while($p=mysql_fetch_row($usr)){
					echo "<option value=\"$p[0]\">$p[0]</option>";
					}
					?>
				</select>
				Pemeriksa:
				<select name="optrespon2" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<option value="" selected="selected">--Pilih--</option>
					<?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nama from users order by nama");
					while($p=mysql_fetch_row($usr)){
					echo "<option value=\"$p[0]\">$p[0]</option>";
					}
					?>
				</select>
				Pembuat:
				<select name="optrespon3" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<option value="" selected="selected">--Pilih--</option>
					<?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nama from users order by nama");
					while($p=mysql_fetch_row($usr)){
					echo "<option value=\"$p[0]\">$p[0]</option>";
					}
					?>
				</select>
			</td>
		</tr>
		</table>
		<br />
		
		</td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>