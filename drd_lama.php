<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//edit 07 Sep 2016
ini_set('max_execution_time', 600);
?>

	<tr>
		<td>
		<br/>	
		<table width="1024px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background:linear-gradient(#c0c0c0,#fff);" background="img/grids.gif">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="">
			<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);text-align:justify;">
            	<td colspan="4" align="center"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>Daftar Rekening Ditagihkan [DRD]</b></font></center></td>
            </tr>
            <tr>
				<td width="130px">Jenis Rek.</td>
				<td width="300px">					
					<input type="radio" name="rjenis" id="rjenis" value="rjtill" disabled />DRD Awal &nbsp;&nbsp;
					<input type="radio" name="rjenis" id="rjenis" value="rjall" checked="checked" />DRD Berjalan				</td>
			  	<td>Periode Rek.</td>
				<td>
				<select name="optperiode" id="optperiode" >
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from rekening1 order by periode DESC");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>
                &nbsp;s/d&nbsp;
                <select name="optperiode2" id="optperiode2" >
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from rekening1 order by periode DESC");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" id="perupp" value="perupp">Cabang [UPP]</td>
				<td>
					<select name="optcabang" id="optcabang" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select cabang,nama from cabang where cabang<>'00' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
			  <td><input type="checkbox" name="chpergol" id="pergol"  value="pergol"/>		      
		      Per Gol.</td>
			  <td>
				<select name="optgoltarif" id="optgoltarif" >
                  <option value="" selected="selected">--Pilih--</option>
                  <?php
						$sql=mysql_query("select distinct gol,keterangan from tarif order by gol");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" id="perwil"  value="perwil" />Wilayah</td>
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
					</select>				</td>
			  <td><input type="checkbox" id="chjpel" name="chjpel" />
		      Jns Pel.</td>
				<td>
				<select name="optjpel" id="optjpel">
                  <option value="">-Pilih-</option>
                  <?php
						$sql=mysql_query("select kode_jenis_pel,ket_jenis_pel from pel_jenis order by kode_jenis_pel");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" value="perblok" id="perblok" checked="checked" />Blok</td>
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
					</select>				</td>
				<td><input type="checkbox" id="chkwm" name="chkwm" />
			    Kondisi WM</td>
				<td>
				<select name="optkwm" id="optkwm">
                  <option value="">-Pilih-</option>
                  <?php
						$sql=mysql_query("select kode_kondisi,ket_kondisi from meter_kondisi order by kode_kondisi");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1"  id="perdkd" value="perdkd"/>DKD</td>
				<td>
					<select id="optdkd" name="optdkd" onchange="setalamat();" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select dkd,jalan from dkd order by dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>	
					</select>				</td>
				<td align="right">Jns Report</td>
				<td>
					<input type="radio" name="rjrep" id="rjrep" value="rjdetail" />Detail &nbsp;&nbsp;
					<input type="radio" name="rjrep" id="rjrep" value="rjrekap" checked="checked" />Rekap				</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1"  value="pernomor"/>Dari No. Pel</td>
				<td>
					<input type="text" name="txno1" size="7" maxlength="6" onkeypress="return isNumb(event);" />&nbsp;s/d&nbsp;
					<input type="text" name="txno2" size="7" maxlength="6" onkeypress="return isNumb(event);" />				</td>
				<td align="right">Pemakaian</td>
				<td>
<select name="optpakai88" id="optpakai88">
	<option value=">=0">Semua</option>
	<option value="<=10">0 sampai 10</option>
	<option value=">100">lebih dari 100</option>
	<option value=">1000">lebih dari 1000</option>
</select>
				</td>
			</tr>
			<tr height="50px">
				<td colspan="4" align="center" style="padding:0px;">
				<input type="submit" name="proses" value="Proses" class="kelas_tombol" /> &nbsp;&nbsp;&nbsp;
				<input type="button" name="batal" value="Batal" class="kelas_tombol" onclick="location.header('drd.php');" />				</td>
			</tr>
			</form>
		</table>
		<br />
		<table width="1024px" align="center" border="0" cellpadding="2" cellspacing="2" style="box-shadow: 0 0 15px #999;" background="img/grids.gif" class="rounded">
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffe;color:#000;font-family:calibri;font-size:12px;">
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
									$periode=$_POST["optperiode"];$periode2=$_POST["optperiode2"];
									echo"<script type=\"text/javascript\">document.getElementById(\"optperiode\").value=\"$periode\";</script>";
									echo"<script type=\"text/javascript\">document.getElementById(\"optperiode2\").value=\"$periode2\";</script>";

									$pakai=$_POST["optpakai88"];
									$var_pakai="Semua pemakaian";
									$judul="- Periode [$periode s/d $periode2]";
#echo "44444444".$judul;
switch($pakai){
	case"<=10":echo"<script type=\"text/javascript\">document.getElementById(\"optpakai88\").value=\"$pakai\"</script>";$var_pakai="0 - 10 m3";break;
	case">100":echo"<script type=\"text/javascript\">document.getElementById(\"optpakai88\").value=\"$pakai\"</script>";$var_pakai="Lebih dari 100 m3";break;
	case">1000":echo"<script type=\"text/javascript\">document.getElementById(\"optpakai88\").value=\"$pakai\"</script>";$var_pakai="Lebih dari 1000 m3";break;
	default:echo"<script type=\"text/javascript\">document.getElementById(\"optpakai88\").value=\"$pakai\"</script>";break;
}
									
									if(isset($_POST["rjenis"])){
										switch($_POST["rjenis"]){
											case"rjnow":												
												//$judul.="<br>Jenis Rekening: Bulan ini";
												break;
											case"rjtill":
												$judul.="<br>Jenis Rekening: DRD Awal";
												break;
											case"rjall":
												$judul.="<br>Jenis Rekening: DRD Berjalan";
												break;
										}										
									}
									
									if(isset($_POST["r1"]))$radio1=$_POST["r1"];
									switch($radio1){
										case"perupp":
											if(($key=$_POST["optcabang"])!=""){
												$slipit=cek_slip($slipit)."m.cabang='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"perupp\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$key\";</script>";
												//$judul.="<br>Cabang UPP : $key";
												$nama_key=getNama("nama",$key,"cabang","cabang");//field_to_get,val_inject,index,table_name
												$judul.="<br>Cabang : $key - $nama_key";
											}
											break;
											
										case"perwil":
											if(($key=$_POST["optwilayah"])!=""){
												$slipit=cek_slip($slipit)."m.kode_wilayah='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"perwil\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optwilayah\").value=\"$key\";</script>";
												$judul.="<br>Wilayah : $key";
											}
											break;
											
										case"perblok":
											if(($key=$_POST["optblok"])!=""){
												$slipit=cek_slip($slipit)."m.kode_blok='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"perblok\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optblok\").value=\"$key\";</script>";
												$nama_key=getNama("ket_blok",$key,"kode_blok","master_blok");//field_to_get,val_inject,index,table_name
												$judul.="<br>Blok : $key - $nama_key";
											}
											break;
											
										case"perdkd":
											if(($key=$_POST["optdkd"])!=""){
												$slipit=cek_slip($slipit)."m.dkd='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"perdkd\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optdkd\").value=\"$key\";</script>";
												$judul.="<br>DKD [WPT] : $key";
											}
											break;
											
										case"pernomor":
											if(($key1=$_POST["txno1"])!="" && ($key2=$_POST["txno2"])!=""){
												$slipit=cek_slip($slipit)."r.nomor BETWEEN '$key1' AND '$key2'";
												$judul.="<br>Dari Nomor Pelanggan : [$key1] s/d [$key2]";
											}
											break;
									}
									
									if(isset($_POST["chpergol"])&&($key=$_POST['optgoltarif'])!=''){
										$slipit=cek_slip($slipit)."m.gol='$key'";
										echo"<script type=\"text/javascript\">document.getElementById(\"pergol\").checked=\"checked\";</script>";
										echo"<script type=\"text/javascript\">document.getElementById(\"optgoltarif\").value=\"$key\";</script>";
										$judul.="<br>Golongan Tarif : $key";
									}
									
									if(isset($_POST["chjpel"])&&($key=$_POST['optjpel'])!=''){
										#$slipit=cek_slip($slipit)."m.jenis_pel='$key'";

										if ($key>'1') {
											$slipit=cek_slip($slipit)."(m.nomor in (select distinct d.nomor from pel_kolektif_d as d inner join pel_kolektif as p on p.kode_kolektif=d.kode_kolektif where p.kode_jenis_pel='$key'))";
										}else{
											$slipit=cek_slip($slipit)."(m.nomor in (select distinct nomor from master where nomor not in(select distinct d.nomor from pel_kolektif_d as d inner join pel_kolektif as p on p.kode_kolektif=d.kode_kolektif where p.kode_jenis_pel>'1')))";
										}

										$nama_key=getNama("ket_jenis_pel",$key,"kode_jenis_pel","pel_jenis");
										echo"<script type=\"text/javascript\">document.getElementById(\"chjpel\").checked=\"checked\";</script>";
										echo"<script type=\"text/javascript\">document.getElementById(\"optjpel\").value=\"$key\";</script>";
										$judul.="<br>Jenis Pelanggan : $key - $nama_key";
									}
									
									if(isset($_POST["chkwm"])&&($key=$_POST['optkwm'])!=''){
										$slipit=cek_slip($slipit)."r.kondisi_meter='$key'";
										echo"<script type=\"text/javascript\">document.getElementById(\"chkwm\").checked=\"checked\";</script>";
										echo"<script type=\"text/javascript\">document.getElementById(\"optkwm\").value=\"$key\";</script>";
										$judul.="<br>Kondisi Water Meter : $key";
									}
									//=====================================BOF=DETAIL==============================================
									//<td>Cab</td>
									//<td>Wil</td>
									if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjdetail"){
										$judul="Daftar Rekening Ditagihkan ".$judul.", Pemakaian: $var_pakai";
										$i=0;
										$theader="
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#c0c0c0);color:#000;font-weight:bold;\">
											<td>No</td>
											<td>Nomor</td>
											<td>NoLama</td>
											<td width=140>Nama</td>
											
											<td>DKD</td>
											<td>St<br>Lalu</td>
											<td>St<br>Kini</td>
											<td>Pakai</td>
											<td width=60>Uang<br>Air</td>
											<td width=40>Adm</td>
											<td width=40>Meter</td>
											<td width=40>Meterai</td>
											<td width=60>Total</td>
											<td>KWM</td>
											<td>Stat</td>
										</tr>
										";		
										echo"<script type=\"text/javascript\">document.getElementById(\"rjrep\").checked=\"checked\";</script>";															
										
										$alg=array("center","center","left","center","center","center","right","right","right","right","right","right","center","center");
										if($slipit!="")$slipit.=" AND ";
										//$sql="SELECT r.nomor,m.nolama,m.nama,m.cabang,m.kode_wilayah,m.dkd,r.standlalu,r.standkini,r.pakai,format(r.uangair,0),format(r.adm,0),format(r.meter,0),format(r.meterai,0),format((r.uangair + r.adm + r.meter + r.meterai + r.denda),0) FROM rekening1 AS r, master AS m WHERE $slipit r.nomor=m.nomor and r.periode=$periode ORDER BY m.nolama;";
										/*$sql="
										SELECT r.nomor, m.nolama, SUBSTR(m.nama,1,25), m.dkd, r.standlalu, r.standkini, r.pakai, format(r.uangair,0), format(r.adm,0), format(r.meter,0), format(r.meterai,0), format((r.uangair + r.adm + r.meter + r.meterai + r.denda),0) FROM rekening1 AS r
										INNER JOIN master AS m on m.nomor=r.nomor
										WHERE $slipit r.periode=$periode ORDER BY m.nolama
										;";*/
										//CONCAT(UCASE(MID(name,1,1)),MID(name,2)) AS name
										$sql="
										SELECT DISTINCT r.nomor, m.nolama, SUBSTR(lcase(m.nama),1,20), m.dkd, r.standlalu, r.standkini, r.pakai, format(r.uangair,0), format(r.adm,0), format(r.meter,0), format(r.meterai,0), format((r.uangair + r.adm + r.meter + r.meterai ),0),r.kondisi_meter,IF(r.status_bayar=1,'LNS','TGK')
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m on m.nomor=r.nomor
										WHERE $slipit (r.periode BETWEEN $periode AND $periode2) AND r.pakai".$pakai."
										ORDER BY m.nolama,r.periode
										;";	
										
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo $theader;//Cetak TR pertama sebagai header table
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[1]</td>
												<td>".ucwords($row[2])."</td>
												<td align=center>$row[3]</td>
												<td align=right>$row[4]</td>
												<td align=right>$row[5]</td>
												<td align=right>$row[6]</td>
												<td align=right>$row[7]</td>
												<td align=right>$row[8]</td>
												<td align=right>$row[9]</td>
												<td align=right>$row[10]</td>
												<td align=right>$row[11]</td>
												<td align=center>$row[12]</td>
												<td align=center>$row[13]</td>
											</tr>
											";
										}
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										//$sql_jml="SELECT format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0) FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 ORDER BY m.nolama;";
										$sql_jml="
										SELECT format(SUM(r.pakai),0), format(SUM(r.uangair),0), format(SUM(r.adm),0), format(SUM(r.meter),0), format(SUM(r.meterai),0), format(SUM((r.uangair + r.adm + r.meter + r.meterai )),0) FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
										WHERE  $slipit (r.periode BETWEEN $periode AND $periode2) AND m.putus=0 AND r.pakai".$pakai." ORDER BY m.nolama;
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
										<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-size:11px;font-weight:bold;\">											
											<td colspan=\"7\" height=\"20\">GRAND TOTAL</td>
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
										$_SESSION['orientasi']='P';
										$_SESSION["tfooter"]=$tfooter;
										$_SESSION['ttd']="<br>
										<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
										<tr width=\"100%\">
											<td width=\"200\" align=\"center\">
												Diketahui oleh,<br>
												<br><br>
												...............................<br>Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"200\" align=\"center\">
												<!--Diperiksa oleh,<br>
												<br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
											</td>
											<td width=\"200\" align=\"center\">
												Dibuat oleh,<br>
												<br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr></table>
										";
									//=====================================BOF=REKAP==============================================
									}if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
										$judul="Ikhtisar Rekening Air ".$judul.", Pemakaian: $var_pakai";
										$i=0;
										$theader="
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#c0c0c0);color:#000;font-weight:bold;\">
											<td>No.</td>
											<td width=50>KODE</td>
											<td width=200>GOLONGAN TARIF</td>
											<td width=70>JML<br>REK.</td>
											<td width=70>PAKAI<br>AIR M<sup>3</sup></td>
											<td width=90>HARGA AIR<br>Rp.</td>
											<td width=80>ADM</td>
											<td width=80>METER</td>
											<td width=80>METERAI</td>
											<td width=90>TOTAL</td>
											<td>RATA<sup>2</sup><br>HARGA</td>
											<td>RATA<sup>2</sup><br>KONS.</td>
										</tr>
										";
										$alg=array("center","left","right","right","right","right","right","right","right","right","right","right");
										
										if($slipit!="")$slipit.=" AND ";
										//$sql="SELECT distinct m.gol, FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 ORDER BY m.nolama;";
										$sql="
										SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM((r.uangair + r.adm + r.meter + r.meterai)),0) as jtotal, format(ifnull((sum(r.uangair)/sum(r.pakai)),0),0)as avg_harga, format(ifnull((sum(r.pakai)/count(*)),0),0)as avg_plg
										FROM rekening1 as r
										INNER JOIN master AS m ON m.nomor=r.nomor
										WHERE $slipit (r.periode BETWEEN $periode AND $periode2) AND m.putus=0 AND r.pakai".$pakai." GROUP BY m.gol ORDER BY m.gol
										;";
										
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#c0c0c0);color:#000;font-weight:bold;\">
											<td>No.</td>
											<td>KODE</td>
											<td>GOLONGAN TARIF</td>
											<td>JML<br>REK.</td>
											<td>PAKAI<br>AIR M<sup>3</sup></td>
											<td>HARGA AIR<br>Rp.</td>
											<td>ADM</td>
											<td>METER</td>
											<td>METERAI</td>
											<td>TOTAL</td>
											<td>RATA<sup>2</sup><br>HARGA</td>
											<td>RATA<sup>2</sup><br>KONS.</td>
										</tr>
										";
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
										//$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0) FROM rekening1 r,master m WHERE $slipit m.nomor=r.nomor AND (r.periode BETWEEN $periode AND $periode2);";
										$sql_jml="
										SELECT FORMAT(COUNT(*),0),FORMAT(SUM(r.pakai),0),FORMAT(SUM(r.uangair),0),FORMAT(SUM(r.adm),0),FORMAT(SUM(r.meter),0),FORMAT(SUM(r.meterai),0),FORMAT(SUM((r.uangair + r.adm + r.meter + r.meterai )),0)
										FROM rekening1 as r
										INNER JOIN master AS m ON m.nomor=r.nomor
										WHERE $slipit (r.periode BETWEEN $periode AND $periode2) AND m.putus=0 AND r.pakai".$pakai."
										;";
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
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#c0c0c0);color:#000;font-weight:bold;\">											
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
										$_SESSION['orientasi']='L';
										$_SESSION["tfooter"]=$tfooter;
										$_SESSION['ttd']="<br><br><br>
										<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
										<tr width=\"100%\">
											<td width=\"300\" align=\"center\">
												Diketahui oleh,<br>
												Manager Keuangan<br>
												<br><br><br><br><br>
											        ABDULLAH MANSUR, SE<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"300\" align=\"center\">
											<!--	Diperiksa oleh,<br>
												Asmen Pengelola Data Rekening<br><br><br><br><br><br>
												RENALDO TUMEWU, ST<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
											</td>
											<td width=\"300\" align=\"center\">
												Dibuat oleh,<br>
												Staf Pengelola Data Rekening<br><br><br><br><br><br>
												P A R M I N, S.Kom<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr></table>
										";
									}
									
									//echo"<tr bgcolor=#fff><td colspan=15 align=center>$sql_jml</td></tr>";
									echo $tfooter;
								}
							?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
			<td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;background:linear-gradient(#fff,#c0c0c0);">
            	<?php
                if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
					$tujuan="reports/print_report_rekap_drd.php";
				}else{
					$tujuan="reports/print_report_drd.php";
				}
				
				
				
				?>
            
            
				<a href="<?php echo $tujuan; ?>" target="_blank" style="font-size:16px;color:#FF0000;font-weight:bold;">-= Cetak Report =-</a>******************
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
