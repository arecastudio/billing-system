<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

$lembar=0;
$pakai=0;
$uangair=0;
$adm=0;
$meter=0;
$meterai=0;
$total=0;
$rata1=0;
$rata2=0;

?>



	<tr>
		<td><br />
		<!--############################################################################################################-->
		
				
		<table width="920px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
          <form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
              <td colspan="4"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>.::  Laporan Penerimaan & Penagihan [LPP] ::.</b></font></center></td>
            </tr>
            <tr>
              <td>Periode Rek. </td>
              <td><!--input type="radio" name="rjenis" id="rjenis" value="rjnow" />
                Rek. bln ini&nbsp;&nbsp;
                <input type="radio" name="rjenis" id="rjenis" value="rjtill" />
                Rek. sblm bln lalu &nbsp;&nbsp;
				<input type="radio" name="rjenis" id="rjenis" value="rjall" checked="checked" />
				Semua Rek.</td-->
                <!--########################################################################################-->
                <select name="optperiode" id="optperiode">
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from rekening1 order by periode ASC");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>
                &nbsp;s/d&nbsp;
                <select name="optperiode2" id="optperiode2">
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from rekening1 order by periode desc");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select></td>
                <!--########################################################################################-->                
              <td><input type="checkbox" name="chtgl" checked="checked">Tgl. Trans.</td>
              <td>
					<input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]			  </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rupp" value="perupp" checked="checked">
                Cabang [UPP]</td>
              <td><select name="optcabang" id="optcabang" >
                  <option value="11" selected="selected">Semua UPP</option>
                  <?php
						$sql=mysql_query("select cabang,nama from cabang WHERE cabang<>'00' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>             	</td>
              <td><input type="checkbox" name="chpergol"  value="pergol"/>
                Per Gol.</td>
              <td><select name="optgoltarif" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <?php
						$sql=mysql_query("select distinct gol,keterangan from tarif order by gol");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>              </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rwilayah" value="perwil" />
                Wilayah</td>
              <td><select name="optwilayah" id="optwilayah">
                  <!--option value="" selected="selected">--Pilih Wilayah--</option-->
                  <?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("SELECT kode_cabang,kode_wilayah,nama_wilayah FROM master_wilayah WHERE kode_wilayah<>'' ORDER BY kode_wilayah");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_wilayah]\">$p[nama_wilayah]</option>\n";
						}
						?>
                </select>              </td>
              <td><input type="checkbox" name="chjlok" id="chjlok" />
                Per Loket </td>
              <td><select name="optjlok" id="optjlok">
                  <!--option value="">-Pilih-</option-->
                  <?php
						$sql=mysql_query("select kode_loket,ket_loket from m_loket order by kode_loket");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>              </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rblok" value="perblok" />
                Blok</td>
              <td><select name="optblok" id="optblok">
                  <!--option value="" selected="selected">--Pilih Blok--</option-->
                  <?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("select * from master_blok order by kode_blok");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_blok]\">$p[kode_blok] - $p[ket_blok]</option>\n";
						}
						?>
                </select>              </td>
              <td align="right"><div align="left">
                <input type="checkbox" name="chopr" />
              Per Operator </div></td>
              <td>
			  	<select name="optopr">
                  <!--option value="">-Pilih-</option-->
                  <?php
						$sql=mysql_query("SELECT DISTINCT operator FROM transaksi WHERE operator<>'' ORDER BY operator;") or die(mysql_error());
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
						?>
                </select>			  </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1"  id="rdkd" value="perdkd"/>
                DKD [WPT] </td>
              <td><select id="optdkd" name="optdkd" onchange="setalamat();" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <?php
						$sql=mysql_query("select dkd,jalan from dkd order by dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>              </td>
              <td align="right">Jenis Trans.</td>
           	  <td><input type="radio" name="rjtrans" id="rjtrans0" value="0" checked="checked" />
Lunas &nbsp;&nbsp;
<input type="radio" name="rjtrans" id="rjtrans1" value="1" />
Batal </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rnomor"  value="pernomor"/>
                Dari No. Pel</td>
              <td><input type="text" name="txno1" id="txno1" size="7" maxlength="6" onkeypress="return isNumb(event);" />
                &nbsp;s/d&nbsp;
                <input type="text" name="txno2" id="txno2" size="7" maxlength="6" onkeypress="return isNumb(event);" />              </td>
              <td><div align="right">Jns Report</div></td>
              <td><input type="radio" name="rjrep" id="rjdetail" value="rjdetail" checked="checked" />
Daftar &nbsp;&nbsp;
<input type="radio" name="rjrep" id="rjrekap" value="rjrekap" />
Rekap </td>
            </tr>
			<tr>
				<td><!--input type="radio" name="r1" id="rallupp"  value="all"/-->
				&nbsp;
                <input type="hidden" id="dik" name="dik" />                </td>
				<td colspan="2"></td>
				<td align="right">
					<input type="submit" name="proses" value="Proses" />
                  	<input type="button" name="batal" value="Batal" onclick="" />				</td>
			</tr>
          </form>
		  </table>
		  <br />
		  
		  <table width="1024px" align="center" border="0" cellpadding="2" cellspacing="2" style="box-shadow: 0 0 15px #999;" background="img/grids.gif" class="rounded">
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
							
							<?php
								if (isset($_POST["proses"])&& $_POST["proses"]=="Proses"){
									$tawal='2000-01-01';
									$takhir=date('Y-m-d');
									$slipit="";
									$stbayar=0;
									//$periode=getPeriodeLalu();
									$periode=$_POST["optperiode"];
									$periode2=$_POST["optperiode2"];
									echo"<script type=\"text/javascript\">document.getElementById(\"optperiode\").value=\"$periode\";</script>";
									echo"<script type=\"text/javascript\">document.getElementById(\"optperiode2\").value=\"$periode2\";</script>";		
									
									//$diketahui=$_POST['respon1'];
									//$diperiksa=$_POST['respon2'];
									//$dibuat=$_POST['respon3'];
									
									//echo"<script type=\"text/javascript\"></script-->";
									
									/*$sql_res="SELECT DISTINCT a.nik,a.nama,a.jabatan,
									b.nik,b.nama,b.jabatan,
									c.nik,c.nama,c.jabatan
									FROM responsibility AS a
									INNER JOIN responsibility AS b ON b.nik='$diperiksa'
									INNER JOIN responsibility AS c ON c.nik='$dibuat'
									WHERE a.nik='$diketahui'
									;";
									$qry_res=mysql_query($qry_res)or die(mysql_error());
									if($row_res=mysql_fetch_row($qry_res)){
										$dik[0]=$row_res[0];
										$dik[1]=$row_res[1];
										$dik[2]=$row_res[2];
										
										$dip[0]=$row_res[3];
										$dip[1]=$row_res[4];
										$dip[2]=$row_res[5];
										
										$dib[0]=$row_res[6];
										$dib[1]=$row_res[7];
										$dib[2]=$row_res[8];
									}*/
									
									$stbatal=$_POST['rjtrans'];
									$jdl_lunas="";
									if ($stbatal=='1'){
										$jdl_lunas="Pembatalan ";
										$stbayar=0;
										$slipit=cek_slip($slipit)."z.batal=1 AND r.status_bayar=0";
										echo"<script type=\"text/javascript\">document.getElementById(\"rjtrans1\").checked=\"checked\";</script>";																												
									}else{
										$stbayar=1;
										$slipit=cek_slip($slipit)."z.batal=0 AND r.status_bayar=1";
										echo"<script type=\"text/javascript\">document.getElementById(\"rjtrans0\").checked=\"checked\";</script>";
									}
									
									if(isset($_POST['chtgl'])){
										if(($key1=$_POST['txtawal'])!=''){
											$tawal=$key1;
											echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$key1\";</script>";
										}
										if(($key2=$_POST['txtakhir'])!=''){
											$takhir=$key2;
											echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$key2\";</script>";
										}
									}
									
									$judul=$jdl_lunas."Laporan Penerimaan dan Penagihan [LPP] - Tanggal [$tawal] s/d [$takhir]";
									//$judul.="<br> $jdl_lunas";
									
									/*if(isset($_POST["rjenis"])){
										switch($_POST["rjenis"]){
											case"rjnow":												
												$slipit=cek_slip($slipit)."z.periode=$periode";
												$judul.="<br>Jenis LPP: Terhadap Rekening Bulan/Periode [$periode]";
												break;
											case"rjtill":
												$slipit=cek_slip($slipit)."z.periode < $periode";
												$judul.="<br>Jenis LPP: Terhadap Rek. <u>Sebelum</u> Bulan/Periode [$periode]";
												break;
											case"rjall":
												//$slipit=cek_slip($slipit)."z.periode < $periode";
												$judul.="<br>Jenis LPP: Terhadap Rekening/Periode [$periode] <u>dan Sebelumnya</u>";
												break;
										}										
									}*/
									//$slipit=cek_slip($slipit)."(z.periode BETWEEN $periode AND $periode2)";
									$judul.="<br>Terhadap Rekening Periode: [$periode s/d $periode2]";
									
									if(isset($_POST["r1"]))$radio1=$_POST["r1"];
									switch($radio1){
										case"perupp":
											if(($key=$_POST["optcabang"])!=""){
												if($key=='11'){
													$slipit=cek_slip($slipit)."m.cabang<>'$key'";
													$judul.="<br>Pel. Cabang : Semua UPP";
												}else{
													$slipit=cek_slip($slipit)."m.cabang='$key'";
													$nama_key=getNama("nama",$key,"cabang","cabang");//field_to_get,val_inject,index,table_name
													$judul.="<br>Pel. Cabang : $key - $nama_key";
												}
												
												echo"<script type=\"text/javascript\">document.getElementById(\"rupp\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$key\";</script>";
											}
											break;
											
										case"perwil":
											if(($key=$_POST["optwilayah"])!=""){
												$slipit=cek_slip($slipit)."m.kode_wilayah='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"rwilayah\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optwilayah\").value=\"$key\";</script>";
												$nama_key=getNama("nama_wilayah",$key,"kode_wilayah","master_wilayah");//field_to_get,val_inject,index,table_name
												$judul.="<br>Wilayah : $key - $nama_key";
											}
											break;
											
										case"perblok":
											if(($key=$_POST["optblok"])!=""){
												$slipit=cek_slip($slipit)."m.kode_blok='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"rblok\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optblok\").value=\"$key\";</script>";
												$nama_key=getNama("ket_blok",$key,"kode_blok","master_blok");//field_to_get,val_inject,index,table_name
												$judul.="<br>Blok : $key - $nama_key";
											}
											break;
											
										case"perdkd":
											if(($key=$_POST["optdkd"])!=""){
												$slipit=cek_slip($slipit)."m.dkd='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"rdkd\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optdkd\").value=\"$key\";</script>";
												$nama_key=getNama("jalan",$key,"dkd","dkd");//field_to_get,val_inject,index,table_name
												$judul.="<br>DKD [WPT] : $key - $nama_key";
											}
											break;
											
										case"pernomor":
											if(($key1=$_POST["txno1"])!="" && ($key2=$_POST["txno2"])!=""){
												$slipit=cek_slip($slipit)."m.nomor BETWEEN '$key1' AND '$key2'";
												$judul.="<br>Dari Nomor Pelanggan : [$key1] s/d [$key2]";
												echo"<script type=\"text/javascript\">document.getElementById(\"rnomor\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"txno1\").value=\"$key1\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"txno2\").value=\"$key2\";</script>";
											}
											break;
											
										case"all":											
											$judul.="<br>Semua Cabang [UPP]";
											echo"<script type=\"text/javascript\">document.getElementById(\"rallupp\").checked=\"checked\";</script>";											
											break;
									}
									
									if(isset($_POST["chpergol"])&&($key=$_POST['optgoltarif'])!=''){
										$slipit=cek_slip($slipit)."m.gol='$key'";
										$judul.="<br>Golongan Tarif : $key";
									}
									
									if(isset($_POST["chjlok"])&&($key=$_POST['optjlok'])!=''){
										$slipit=cek_slip($slipit)."z.loket='$key'";
										$judul.="<br>Loket : $key";
										echo"<script type=\"text/javascript\">document.getElementById(\"chjlok\").checked=\"checked\";</script>";
										echo"<script type=\"text/javascript\">document.getElementById(\"optjlok\").value=\"$key\";</script>";
									}
									
									if(isset($_POST["chopr"])&&($key=$_POST['optopr'])!=''){
										$slipit=cek_slip($slipit)."z.operator='$key'";
										$judul.="<br>Operator : $key";
									}
																		
									//=====================================BOF=DETAIL==============================================
									if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjdetail"){
										echo"<script type=\"text/javascript\">document.getElementById(\"rjdetail\").checked=\"checked\";</script>";
										$i=0;
										$theader="
										<tr align=\"center\" style=\"color:#000;font-weight:bold;\">
											<td style=\"border:1px solid;\">No.</td>
											<td style=\"border:1px solid;width:55\">Tgl</td>
											<td style=\"border:1px solid;width:55\">Jam</td>
											<td style=\"border:1px solid;width:55\">Nomor</td>
											<td style=\"border:1px solid;width:65\">NoLama</td>
											<td style=\"border:1px solid;width:200;\">Nama</td>
											<!-- td style=\"border:1px solid;width:160; \">Alamat</td-->
											
											<td style=\"border:1px solid;width:55;\">Periode</td>
											
											<td style=\"border:1px solid;width:55;\">Pakai</td>
											<td style=\"border:1px solid;width:70; \">Uang<br>Air</td>
											<td style=\"border:1px solid;width:55; \">Adm</td>
											<td style=\"border:1px solid;width:55; \">Meter</td>
											<td style=\"border:1px solid;\">Denda</td>
											<td style=\"border:1px solid;width:55; \">Meterai</td>
											<td style=\"border:1px solid;width:70; \">Total</td>
										</tr>
										";
										
										if($slipit!="")$slipit.=" AND ";
										$alg=array("center","center","center","center","left","center","right","right","right","right","right","right","right","right","right","right","right","right","right","right");
										
										$sql="
										SELECT DISTINCT z.tbayar,z.jbayar,r.nomor,m.nolama,SUBSTR(m.nama,1,25),SUBSTR(m.alamat,1,25),r.periode,(r.pakai),FORMAT(r.uangair,0),FORMAT(r.adm,0),FORMAT(r.meter,0),format(r.denda,0),format(r.meterai,0),format((r.uangair + r.adm + r.meter + r.meterai + r.denda),0)
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
										LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.periode=r.periode AND (r.periode BETWEEN $periode AND $periode2)
										ORDER BY m.nomor ASC, r.periode ASC
										;"; //ORDER BY z.jbayar ASC, r.periode ASC
										
										//z.tbayar ASC,z.jbayar ASC
										
										
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										<tr align=\"center\" style=\"color:#000;font-weight:bold;background:linear-gradient(#fff,#ccc);\">
											<td>No.</td>
											<td>Tgl</td>
											<td>Jam</td>
											<td>Nomor</td>
											<td>NoLama</td>
											<td>Nama</td>
											<td>Alamat</td>
											
											<td>Periode</td>
											
											<td>Pakai</td>
											<td>Uang<br>Air</td>
											<td>Adm</td>
											<td>Meter</td>
											<td>Denda</td>
											<td>Meterai</td>
											<td>Total</td>
										</tr>
										
										";
										
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[1]</td>
												<td align=left>$row[2]</td>
												<td align=left>$row[3]</td>
												<td align=left>$row[4]</td>
												<td align=left>$row[5]</td>
												<td align=center style=\"color:#00f\">$row[6]</td>												
												<td align=right>$row[7]</td>
												<td align=right>$row[8]</td>
												<td align=right>$row[9]</td>
												<td align=right>$row[10]</td>
												<td align=right>$row[11]</td>
												<td align=right>$row[12]</td>
												<td align=right>$row[13]</td>
												
											</tr>
											";
										}
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										$sql_jml1="SELECT format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),FORMAT(SUM(r.denda),0),format(SUM(r.meterai),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0)
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
										LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.periode=r.periode AND (r.periode BETWEEN $periode AND $periode2)
										;";
										
										$qry0=mysql_query($sql_jml1)or die("err: ".mysql_error());
										if($row0=mysql_fetch_row($qry0)){
											$jpakai=$row0[0];
											$juangair=$row0[1];
											$jadm=$row0[2];
											$jmeter=$row0[3];
											$jdenda=$row0[4];
											$jmeterai=$row0[5];
											$jtotal=$row0[6];
										}
										$tfooter="
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#ccc);color:#000;font-weight:bold;\">											
											<td style=\"border:1px solid;\" colspan=\"8\" height=\"20\">GRAND TOTAL</td>
											<td style=\"border:1px solid;\">$jpakai</td>
											<td style=\"border:1px solid;\">$juangair</td>
											<td style=\"border:1px solid;\">$jadm</td>
											<td style=\"border:1px solid;\">$jmeter</td>
											<td style=\"border:1px solid;\">$jdenda</td>
											<td style=\"border:1px solid;\">$jmeterai</td>
											<td style=\"border:1px solid;\"> $jtotal</td>
										</tr>
										
										";
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										
										$_SESSION["judul"]=$judul;
										$_SESSION["jumfield"]=13;
										$_SESSION["eskiel"]="
										SELECT DISTINCT z.tbayar,z.jbayar,r.nomor,m.nolama,SUBSTR(m.nama,1,25),r.periode,(r.pakai),FORMAT(r.uangair,0),FORMAT(r.adm,0),FORMAT(r.meter,0),format(r.denda,0),format(r.meterai,0),format((r.uangair + r.adm + r.meter + r.meterai + r.denda),0)
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
										LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.periode=r.periode AND (r.periode BETWEEN $periode AND $periode2)
										ORDER BY m.nolama ASC, r.periode ASC
										;";//ORDER BY m.nolama ASC, r.periode ASC
										$_SESSION["alinea"]=$alg;
										$_SESSION["theader"]=$theader;
										//$_SESSION["jumdata"]=$jml_data;
										$_SESSION["tfooter"]="
										<tr align=\"center\" style=\"background-color:#ddd;color:#000;font-weight:bold;\">											
											<td style=\"border:1px solid;\" colspan=\"7\" height=\"20\">GRAND TOTAL</td>
											<td style=\"border:1px solid;\">$jpakai</td>
											<td style=\"border:1px solid;\">$juangair</td>
											<td style=\"border:1px solid;\">$jadm</td>
											<td style=\"border:1px solid;\">$jmeter</td>
											<td style=\"border:1px solid;\">$jdenda</td>
											<td style=\"border:1px solid;\">$jmeterai</td>
											<td style=\"border:1px solid;\"> $jtotal</td>
										</tr>										
										";
										$_SESSION['orientasi']='L';
										$_SESSION['batas']=40;
										$_SESSION['ttd']="<br><br>
										<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
										<tr width=\"100%\">
											<td width=\"300\" align=\"center\">
												Diketahui oleh,<br>
												<br><br><br>
												...............................<br>Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"300\" align=\"center\">
												Diperiksa oleh,<br>
												<br><br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"300\" align=\"center\">
												Dibuat oleh,<br>
												<br><br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr></table>
										";
										
									//=====================================BOF=REKAP==============================================
									}if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
										echo"<script type=\"text/javascript\">document.getElementById(\"rjrekap\").checked=\"checked\";</script>";
										$i=0;
										//$kode="";$gol="";$jrek=0;$pakai=0;$uair=0;$adm=0;$meter=0;$meterai=0;$total=0;$avg1=0;$avg2=0;
										$theader="
										<tr align=\"center\" style=\"color:#000;font-weight:bold;\">
											<td >No.</td>
											<td >KODE</td>
											<td width=200>GOLONGAN TARIF</td>
											<td width=40>JML<br>REK.</td>
											<td width=70>PAKAI<br>AIR M<sup>3</sup></td>
											<td width=110>HARGA AIR<br>Rp.</td>
											<td width=70>ADM</td>
											<td width=70>METER</td>											
											<td width=70>METERAI</td>
											<td width=90>TOTAL</td>
											<td width=70>RATA<sup>2</sup><br>HARGA</td>
											<td width=70>RATA<sup>2</sup><br>KONS.</td>
										</tr>
										";
										$alg=array("center","left","right","right","right","right","right","right","right","right","right","right");
										
										if($slipit!="")$slipit.=" AND ";
										$ada_hapus=0;$barisan="";
										$prawal=$periode;
										
										if($periode<=200912){
											$ada_hapus=1;
											$periode=201001;
											$sql_hapus="SELECT distinct m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter)as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal, ifnull(round(sum(r.uangair)/sum(r.pakai),2),0)as avg_harga, ifnull(round(sum(r.pakai)/count(*),2),0)as avg_plg
											FROM rekening1 AS r
											LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
											LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
											WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.periode=r.periode AND (r.periode BETWEEN $prawal AND 200912)
											GROUP BY m.gol
											ORDER BY m.gol
											;";
										}
										
										//$sql="SELECT distinct m.gol, FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 ORDER BY m.nolama;";
										$sql="SELECT distinct m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter)as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal, ifnull(round(sum(r.uangair)/sum(r.pakai),2),0)as avg_harga, ifnull(round(sum(r.pakai)/count(*),2),0)as avg_plg
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
										LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.periode=r.periode AND (r.periode BETWEEN $periode AND $periode2)
										GROUP BY m.gol
										ORDER BY m.gol
										;";
										
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#ccc);color:#000;font-weight:bold;\">
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
											$lembar+=$row[2];
												$pakai+=$row[3];
												$uangair+=$row[4];
												$adm+=$row[5];
												$meter+=$row[6];
												$meterai+=$row[7];
												$total+=$row[8];
												$rata1+=$row[9];
												$rata2+=$row[10];
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=left>$row[1]</td>
												<td align=right>".formatMoney($row[2])."</td>
												<td align=right>".formatMoney($row[3])."</td>
												<td align=right>".formatMoney($row[4])."</td>
												<td align=right>".formatMoney($row[5])."</td>
												<td align=right>".formatMoney($row[6])."</td>
												<td align=right>".formatMoney($row[7])."</td>
												<td align=right>".formatMoney($row[8])."</td>
												<td align=right>".formatMoney($row[9])."</td>
												<td align=right>".formatMoney($row[10])."</td>
											</tr>
											";
											$barisan.="
											<tr >
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=left>$row[1]</td>
												<td align=right>".formatMoney($row[2])."</td>
												<td align=right>".formatMoney($row[3])."</td>
												<td align=right>".formatMoney($row[4])."</td>
												<td align=right>".formatMoney($row[5])."</td>
												<td align=right>".formatMoney($row[6])."</td>
												<td align=right>".formatMoney($row[7])."</td>
												<td align=right>".formatMoney($row[8])."</td>
												<td align=right>".formatMoney($row[9])."</td>
												<td align=right>".formatMoney($row[10])."</td>
											</tr>
											";
											
										}
										$barisan.="
												<tr style=\"font-weight:bold;vertical-align:middle; \" height=\"16\" >
												<td align=\"center\" colspan=\"3\" >Sub Total</td>
												<td align=\"right\" >".formatMoney($lembar)."</td>
												<td align=\"right\" >".formatMoney($pakai)."</td>
												<td align=\"right\" >".formatMoney($uangair)."</td>
												<td align=\"right\" >".formatMoney($adm)."</td>
												<td align=\"right\" >".formatMoney($meter)."</td>
												<td align=\"right\" >".formatMoney($meterai)."</td>
												<td align=\"right\" >".formatMoney($total)."</td>
												<td align=\"right\" >".formatMoney($rata1)."</td>
												<td align=\"right\" >".formatMoney($rata2)."</td>
												
												</tr>
												
												
												";
										echo"
												<tr style=\"font-weight:bold;vertical-align:middle; \" height=\"16\" >
												<td align=\"center\" colspan=\"3\" >Sub Total</td>
												<td align=\"right\" >".formatMoney($lembar)."</td>
												<td align=\"right\" >".formatMoney($pakai)."</td>
												<td align=\"right\" >".formatMoney($uangair)."</td>
												<td align=\"right\" >".formatMoney($adm)."</td>
												<td align=\"right\" >".formatMoney($meter)."</td>
												<td align=\"right\" >".formatMoney($meterai)."</td>
												<td align=\"right\" >".formatMoney($total)."</td>
												<td align=\"right\" >".formatMoney($rata1)."</td>
												<td align=\"right\" >".formatMoney($rata2)."</td>
												
												</tr>
												
												
												";
										if($ada_hapus==1){											
											$qry_hapus=mysql_query($sql_hapus)or die("err: ".mysql_error());
											//echo $theader;//Cetak TR pertama sebagai header table
											echo"
												<tr style=\"background-color:#ffc;color:#000;font-weight:bold;\">
													<td colspan=\"12\">Periode Rek. di bawah Tahun 2010</td>
												</tr>
												";
											$barisan.="<tr style=\"color:#000;font-weight:bold;\">
													<td colspan=\"12\">Periode Rek. di bawah Tahun 2010</td>
												</tr>
												";
												$lembar=0;
												$pakai=0;
												$uangair=0;
												$adm=0;
												$meter=0;
												$meterai=0;
												$total=0;
												$rata1=0;
												$rata2=0;
											while($row1=mysql_fetch_row($qry_hapus)){
												$i++;	
												$lembar+=$row1[2];
												$pakai+=$row1[3];
												$uangair+=$row1[4];
												$adm+=$row1[5];
												$meter+=$row1[6];
												$meterai+=$row1[7];
												$total+=$row1[8];
												$rata1+=$row1[9];
												$rata2+=$row1[10];
												
																												
												echo"
												<tr>
													<td align=center>$i</td>
													<td align=center>$row1[0]</td>
													<td align=left>$row1[1]</td>
													<td align=right>".formatMoney($row1[2])."</td>
													<td align=right>".formatMoney($row1[3])."</td>
													<td align=right>".formatMoney($row1[4])."</td>
													<td align=right>".formatMoney($row1[5])."</td>
													<td align=right>".formatMoney($row1[6])."</td>
													<td align=right>".formatMoney($row1[7])."</td>
													<td align=right>".formatMoney($row1[8])."</td>
													<td align=right>".formatMoney($row1[9])."</td>
													<td align=right>".formatMoney($row1[10])."</td>
												</tr>
												";
												$barisan.="
												<tr >
													<td align=center>$i</td>
													<td align=center>$row1[0]</td>
													<td align=left>$row1[1]</td>
													<td align=right>".formatMoney($row1[2])."</td>
													<td align=right>".formatMoney($row1[3])."</td>
													<td align=right>".formatMoney($row1[4])."</td>
													<td align=right>".formatMoney($row1[5])."</td>
													<td align=right>".formatMoney($row1[6])."</td>
													<td align=right>".formatMoney($row1[7])."</td>
													<td align=right>".formatMoney($row1[8])."</td>
													<td align=right>".formatMoney($row1[9])."</td>
													<td align=right>".formatMoney($row1[10])."</td>
												</tr>
												";
											}
											$barisan.="
												<tr style=\"font-weight:bold;vertical-align:middle; \" height=\"16\" >
												<td align=\"center\" colspan=\"3\" >Sub Total</td>
												<td align=\"right\" >".formatMoney($lembar)."</td>
												<td align=\"right\" >".formatMoney($pakai)."</td>
												<td align=\"right\" >".formatMoney($uangair)."</td>
												<td align=\"right\" >".formatMoney($adm)."</td>
												<td align=\"right\" >".formatMoney($meter)."</td>
												<td align=\"right\" >".formatMoney($meterai)."</td>
												<td align=\"right\" >".formatMoney($total)."</td>
												<td align=\"right\" >".formatMoney($rata1)."</td>
												<td align=\"right\" >".formatMoney($rata2)."</td>
												
												</tr>
												
												
												";
											
											echo"
												<tr style=\"font-weight:bold;vertical-align:middle; \" height=\"16\" >
												<td align=\"center\" colspan=\"3\" >Sub Total</td>
												<td align=\"right\" >".formatMoney($lembar)."</td>
												<td align=\"right\" >".formatMoney($pakai)."</td>
												<td align=\"right\" >".formatMoney($uangair)."</td>
												<td align=\"right\" >".formatMoney($adm)."</td>
												<td align=\"right\" >".formatMoney($meter)."</td>
												<td align=\"right\" >".formatMoney($meterai)."</td>
												<td align=\"right\" >".formatMoney($total)."</td>
												<td align=\"right\" >".formatMoney($rata1)."</td>
												<td align=\"right\" >".formatMoney($rata2)."</td>
												
												</tr>
												
												
												";
										}
										
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										//$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0) FROM rekening1 r,transaksi z,master m WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.nomor=r.nomor AND r.nomor=m.nomor AND m.nomor=z.nomor AND z.batal=$stbatal AND z.periode=r.periode AND m.putus=0 ";
										$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0)
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON  m.nomor=r.nomor
										LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit z.periode=r.periode AND (z.tbayar BETWEEN '$tawal' AND '$takhir') AND (r.periode BETWEEN $prawal AND $periode2)
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
										<tr align=\"center\" style=\"color:#000;background:linear-gradient(#fff,#ccc);font-weight:bold;\">											
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
										//echo $sql_jml;
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										
										$_SESSION["judul"]=$judul;
										$_SESSION["jumfield"]=11;
										$_SESSION['orientasi']='L';
										$_SESSION["eskiel"]=$sql;
										$_SESSION["alinea"]=$alg;
										$_SESSION["theader"]=$theader;
										$_SESSION['barisan']=$barisan;
										//$_SESSION["jumdata"]=$jml_data;
										$_SESSION["tfooter"]=$tfooter;
										$_SESSION['ttd']="<br><br>
										<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
										<tr width=\"100%\">
											<td width=\"200\" align=\"center\">
												Diketahui oleh,<br>
												<br><br><br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"200\" align=\"center\">
												Diperiksa oleh,<br>
												<br><br><br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"200\" align=\"center\">
												Dibuat oleh,<br>
												<br><br><br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr></table>
										";
									}
									
									echo"<tr bgcolor=#fff><td colspan=19 align=center>$tfooter</td></tr>";									
								}
							?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
			<td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
				<?php
                if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
					$tujuan="reports/print_report_lpp_rekap.php";
				}else{
					$tujuan="reports/print_report_lpp.php";
				}
				?>
                <a href="<?php echo $tujuan; ?>" target="_blank" style="font-size:16px;color:#FF0000;font-weight:bold;">-= Cetak Report =-</a>
				<!--<input type="checkbox" name="chcustprint" value="customprint" />Custom -=>-->
				Mengetahui:
				<select name="optrespon1" id="optrespon1" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<!--option value="" selected="selected">--Pilih--</option-->
					<?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nik,nama,jabatan from responsibility order by nama");
					while($p=mysql_fetch_row($usr)){
					//echo "<option value=\"$p[0]\">$p[1]</option>";
					echo "<option value=\"<u>$p[1]</u>\n$p[2]\">$p[1]</option>";
					}					
					?>
				</select>
				Pemeriksa:
				<select name="optrespon2" id="optrespon2" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<!--option value="" selected="selected">--Pilih--</option-->
					<?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nik,nama,jabatan from responsibility where jabatan<>'DIREKTUR UTAMA' order by nama");
					while($p=mysql_fetch_row($usr)){
					echo "<option value=\"$p[0]\">$p[1]</option>";
					}
					?>
				</select>
				Pembuat:
				<select name="optrespon3" id="optrespon3" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<!--option value="" selected="selected">--Pilih--</option-->
					<?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nik,nama,jabatan from responsibility where jabatan<>'DIREKTUR UTAMA' order by nik DESC");
					while($p=mysql_fetch_row($usr)){
					echo "<option value=\"$p[0]\">$p[1]</option>";
					}
					?>
				</select>
			</td>
		</tr>
		</table>

		  <br />
		  
		  <!--############################################################################################################-->
	  </td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
