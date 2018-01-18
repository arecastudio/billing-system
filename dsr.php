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
		<br />
		
		<table width="900px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="">
			<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
			  <td colspan="4"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;"><b>Daftar Sisa Rekening [DSR]</b></font></center></td>
			  </tr>
			<tr>
            	<td width="130">Stat Sambungan</td>
				<td width="370">
                	<select name="opt_sambung" id="opt_sambung" style="background:linear-gradient(#fff,#ccc);color:#060;font-weight:bold;" >
		            	<option value="0" selected="selected">[0] Sambung</option>
                        <option value="3">[3] Putus</option>
                        <option value="5">[5] Hapus</option>
                    </select>
                </td>
				<td><input type="radio" name="r1" id="r1_kolek" value="perkolek" checked="checked">
				Kolektif</td>
				<td>
				<select name="optkolek" id="optkolek" >
				  <!--option value="" selected="selected">--Pilih--</option-->
				  <?php
						$sql=mysql_query("select kode_kolektif, substr(ket_kolektif,1,22) from pel_kolektif order by kode_kolektif ASC");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."-".trim($row[1])."</option>";
						}
					?>
                  </select>
				</td>
            </tr>
            <tr>
				<td width="130">Periode Rekening</td>
				<td width="370"><select name="optperiode1" id="optperiode1" >
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
                  </select>s/d
                  <select name="optperiode2" id="optperiode2" >
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
                  </select>              	</td>
			  	<td><input type="checkbox" name="chpergol"  id="chgol" value="pergol"/>
		  	    Per Gol.</td>
				<td><select name="optgoltarif" id="optgoltarif" >
				  <option value="" selected="selected">--Pilih--</option>
				  <?php
						$sql=mysql_query("select distinct gol,keterangan from tarif order by gol");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
			    </select></td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" value="perupp" id="perupp" checked="checked">Cabang [UPP]</td>
				<td>
					<select name="optcabang" id="optcabang" >
						<option value="" selected="selected">Semua UPP</option>
						<?php
						$sql=mysql_query("select cabang,nama from cabang where cabang<>'00' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
			  <td><input type="checkbox" name="chjpel" id="chjpel" />
Jns Pel.</td>
				<td><select name="optjpel" id="optjpel">
				  <option value="">-Pilih-</option>
				  <?php
						$sql=mysql_query("select kode_jenis_pel,ket_jenis_pel from pel_jenis order by kode_jenis_pel");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
			    </select></td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" id="rwilayah" value="perwil" />Wilayah</td>
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
			  <td><input type="checkbox" id="chkwm" name="chkwm" />
Kondisi WM</td>
				<td><select name="optkwm" id="optkwm">
				  <option value="">-Pilih-</option>
				  <?php
						$sql=mysql_query("select kode_kondisi,ket_kondisi from meter_kondisi order by kode_kondisi");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
			    </select></td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" id="rblok" value="perblok" />Blok</td>
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
			  	<td align="right">Jns Report</td>
				<td><input type="radio" name="rjrep" id="rjrep2" value="rjperpel" checked="checked" />Detail &nbsp;&nbsp;
                	<input type="radio" name="rjrep" id="rjrep" value="rjrekap" />Rekap                </td>
			</tr>
			<tr>
				<td><input type="radio" name="r1" id="rdkd"  value="perdkd"/>DKD</td>
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
			  	<td align="right">&nbsp;</td>
				<td>
				  <input type="radio" name="rjrep" id="rjrep3" value="rjdaftar" />Daftar
                  --><input type="checkbox" id="ch3bulan" name="ch3bulan" value="3bulan" />Tunggak > 3(tiga) bulan			  	</td>
			</tr>
			<tr>
				<td><input type="radio" name="r1"  value="pernomor"/>Dari No. Pel</td>
				<td>
					<input type="text" name="txno1" size="7" maxlength="6" onkeypress="return isNumb(event);" />&nbsp;s/d&nbsp;
					<input type="text" name="txno2" size="7" maxlength="6" onkeypress="return isNumb(event);" />				</td>
				<td></td>
			  <td align="left"><input type="checkbox" id="ch2bulan" name="ch2bulan" value="2bulan" />Tunggak <= 3(tiga)bln
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="proses" value="Proses" class="kelas_tombol" />
					<input type="button" name="batal" value="Batal" class="kelas_tombol" onclick="location.header('drd.php');" />				</td>
</tr>
<!--tr>
	<td><input type="checkbox" id="chacuan" name="chacuan"/>Tanggal Cut Off</td>
	<td colspan="3"><input type="text" id="txacuan" name="txacuan" size="10" class="datepicker" readonly/></td>
</tr-->
			</form>
		</table>
		<br />
		<table  width="850px" align="center" border="0" cellpadding="2" cellspacing="2" style="box-shadow: 0 0 15px #999;" background="img/grids.gif" class="rounded">
			<tr>
				<td width="100%" align="center">
					<div style="height:280px;overflow:auto">
						<table id="table-hasil" width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">
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
									$periode=$_POST["optperiode1"];$periode2=$_POST["optperiode2"];
									echo"<script type=\"text/javascript\">document.getElementById(\"optperiode1\").value=\"$periode\";</script>";
									echo"<script type=\"text/javascript\">document.getElementById(\"optperiode2\").value=\"$periode2\";</script>";
									
									$judul="Report Daftar Sisa Rekening - Periode [$periode]s/d[$periode2]";
									
									$sambung=$_POST["opt_sambung"];
									echo"<script type=\"text/javascript\">document.getElementById(\"opt_sambung\").value=\"$sambung\";</script>";
									switch($sambung){
										case 0:
											$judul.="<br>Status Sambungan: Aktif [0]";
											break;
										case 3:
											$judul.="<br>Status Sambungan: Putus [3]";
											break;
										case 5:
											$judul.="<br>Status Sambungan: Hapus [5]";
											break;
									}
									
									if(isset($_POST["rjenis"])){
										switch($_POST["rjenis"]){
											case"rjnow":												
												$judul.="<br>Jenis Rekening: Statis [Awal]";
												break;
											case"rjtill":
												$judul.="<br>Jenis Rekening: Dinamis [Berjalan]";
												break;
											case"rjall":
												break;
										}										
									}
									
									if(isset($_POST["r1"]))$radio1=$_POST["r1"];
									switch($radio1){
										case"perupp":
											if(($key=$_POST["optcabang"])!=""){
												//$slipit=cek_slip($slipit)."m.cabang='$key'";
												//$judul.="<br>Cabang UPP : $key";
												$slipit=cek_slip($slipit)."m.cabang='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"perupp\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$key\";</script>";
												$nama_key=getNama("nama",$key,"cabang","cabang");//field_to_get,val_inject,index,table_name
												$judul.="<br>Cabang : $key - $nama_key";
											}
											break;
											
										case"perwil":
											if(($key=$_POST["optwilayah"])!=""){
												//$slipit=cek_slip($slipit)."m.kode_wilayah='$key'";
												//$judul.="<br>Wilayah : $key";
												$slipit=cek_slip($slipit)."m.kode_wilayah='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"rwilayah\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optwilayah\").value=\"$key\";</script>";
												$nama_key=getNama("nama_wilayah",$key,"kode_wilayah","master_wilayah");//field_to_get,val_inject,index,table_name
												$judul.="<br>Wilayah : $key - $nama_key";
											}
											break;
											
										case"perblok":
											if(($key=$_POST["optblok"])!=""){
												//$slipit=cek_slip($slipit)."m.kode_blok='$key'";
												//$judul.="<br>Blok : $key";
												$slipit=cek_slip($slipit)."m.kode_blok='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"rblok\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optblok\").value=\"$key\";</script>";
												$nama_key=getNama("ket_blok",$key,"kode_blok","master_blok");//field_to_get,val_inject,index,table_name
												$judul.="<br>Blok : $key - $nama_key";
											}
											break;
											
										case"perdkd":
											if(($key=$_POST["optdkd"])!=""){
												//$slipit=cek_slip($slipit)."m.dkd='$key'";
												//$judul.="<br>DKD [WPT] : $key";
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
											}
											break;
											
										case"perkolek":
											if(($key=$_POST["optkolek"])!=""){
												$slipit=cek_slip($slipit)."m.nomor in (SELECT DISTINCT p.nomor FROM pel_kolektif_d AS p WHERE p.kode_kolektif='$key')";
												$nama_key=getNama("ket_kolektif",$key,"kode_kolektif","pel_kolektif");
												$judul.="<br>Dari Kode Kolektif : [$key] - $nama_key";
												echo"<script type=\"text/javascript\">document.getElementById(\"r1_kolek\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optkolek\").value=\"$key\";</script>";
											}
											break;
									}
									$gol_tarif="";
									if(isset($_POST["chpergol"])&&($key=$_POST['optgoltarif'])!=''){
										$slipit=cek_slip($slipit)."m.gol='$key'";
										echo"<script type=\"text/javascript\">document.getElementById(\"chgol\").checked=\"checked\";</script>";
										echo"<script type=\"text/javascript\">document.getElementById(\"optgoltarif\").value=\"$key\";</script>";
										#$nama_key=getNama("gol",$key,"tarif");
										$judul.="<br>Golongan Tarif : $key";
									}

									$tgl_acuan="";
                                                                        if(isset($_POST["chacuan"])&&($key=$_POST['txacuan'])!=''){
                                                                                $slipit=cek_slip($slipit)."( r.status_bayar=0 OR ( r.status_bayar=1 AND r.nomor IN ( SELECT t.nomor FROM transaksi AS t WHERE t.periode=r.periode AND  t.tbayar<'$key' AND t.batal=0)))";
                                                                                echo"<script type=\"text/javascript\">document.getElementById(\"chacuan\").checked=\"checked\";</script>";
                                                                                echo"<script type=\"text/javascript\">document.getElementById(\"txacuan\").value=\"$key\";</script>";
                                                                                #$nama_key=getNama("gol",$key,"tarif");
                                                                                $judul.="<br>Tgl Cut Off : $key";
                                                                        }
									
									$jpl="";
									if(isset($_POST["chjpel"])&&($key=$_POST['optjpel'])!=''){
										
										if ($key>'1') {
											$slipit=cek_slip($slipit)."(m.nomor in (select distinct d.nomor from pel_kolektif_d as d inner join pel_kolektif as p on p.kode_kolektif=d.kode_kolektif where p.kode_jenis_pel='$key'))";
										}else{
											$slipit=cek_slip($slipit)."(m.nomor in (select distinct nomor from master where nomor not in(select distinct d.nomor from pel_kolektif_d as d inner join pel_kolektif as p on p.kode_kolektif=d.kode_kolektif where p.kode_jenis_pel>'1')))";
										}

										$jpl=getNama("ket_jenis_pel",$key,"kode_jenis_pel","pel_jenis");
										echo"<script type=\"text/javascript\">document.getElementById(\"chjpel\").checked=\"checked\";</script>";
										echo"<script type=\"text/javascript\">document.getElementById(\"optjpel\").value=\"$key\";</script>";										
										$judul.="<br>Jenis Pelanggan : $key - $jpl";
									}
									
									$kwm="";
									if(isset($_POST["chkwm"])&&($key=$_POST['optkwm'])!=''){
										$slipit=cek_slip($slipit)."m.kondisi_meter='$key'";
										echo"<script type=\"text/javascript\">document.getElementById(\"chkwm\").checked=\"checked\";</script>";
										echo"<script type=\"text/javascript\">document.getElementById(\"optkwm\").value=\"$key\";</script>";
										$kwm=kondisi_wm($key);
										
										$judul.="<br>Kondisi Water Meter : $key - $kwm";
									}
									
									//=====================================BOF=DETAIL==============================================
									if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjperpel"){
										$judul.="<br>Jenis Report: Detail";
										$i=0;$j=0;
										$theader="
										<tr height=\"30px\" align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\">
											<td width=30>NO</td>
											<td width=50>NOMOR</td>
											<td width=65>NO.LAMA</td>
											<td width=200>NAMA</td>
											<td width=300>ALAMAT</td>
											<td width=25>KWM</td>							
										</tr>
										";
										
										echo"<script type=\"text/javascript\">document.getElementById(\"jrep2\").checked=\"checked\";</script>";	
										
										$alg=array("center","center","left","left","right","right","right","right","right","right","right","right","right","right");
										if($slipit!="")$slipit.=" AND ";
										$nopel="";
										$sql0="
										SELECT m.nomor,m.nolama,m.nama,m.alamat,m.kondisi_meter,r.periode,r.pakai,r.uangair,r.adm,r.meter,r.denda,r.meterai,(r.uangair + r.adm + r.meter + r.meterai + r.denda)
										FROM master AS m
										INNER JOIN rekening1 AS r ON r.nomor=m.nomor
										WHERE $slipit (r.periode BETWEEN $periode AND $periode2) AND r.status_bayar=0 AND m.putus=".$sambung."
										ORDER BY m.nolama,r.periode
										;";
										$qry=mysql_query($sql0)or die("err: ".mysql_error());
										echo $theader;
										while($row=mysql_fetch_row($qry)){											
											if($nopel<>trim($row[0]))$i++;
											//$nopel=trim($row[0]);
											//echo $i;
											//$j++;
											if($nopel<>trim($row[0])&&$nopel<>"")echo"
													</table>
												</td>
											</tr>
											";
																						
											if($nopel<>trim($row[0]))echo"
											<tr style=\"font-family:courier;\">
												<td align=center rowspan=\"2\">$i</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[1]</td>
												<td>$row[2]</td>
												<td>$row[3]</td>
												<td align=center>$row[4]</td>
											</tr>";
											//<td>&nbsp;</td>
											if($nopel<>trim($row[0]))echo"
											<tr bgcolor=\"#fff\">
												
												<td colspan=\"5\">
													<table border=\"1\" style=\"border-collapse:collapse;background:#ffc;font-family:calibri;font-size:11px;\">
											";
											if($nopel<>trim($row[0]))echo"
														<tr style=\"background-color:#f0f0f0;color:#000;\">
															<th width=\"60\">Periode</th>
															<th width=\"90\">Pakai</th>
															<th width=\"120\">Uang Air</th>
															<th width=\"90\">Adm.</th>
															<th width=\"90\">Meter</th>
															<th width=\"90\">Denda</th>
															<th width=\"90\">Meterai</th>
															<th width=\"120\">Total</th>
														</tr>";
											//$qry1=mysql_query($sql1)or die("err: ".mysql_error());
											//while($row1=mysql_fetch_row($qry1)){											
											//if($nopel<>trim($row[0]))
											//echo $i;
											$j++;
											$arr0[]=$row[0];
											$arr1[]=$row[1];
											$arr2[]=$row[2];
											$arr3[]=$row[3];
											$arr4[]=$row[4];
											$arr5[]=$row[5];
											$arr6[]=$row[6];
											$arr7[]=$row[7];
											$arr8[]=$row[8];
											$arr9[]=$row[9];
											$arr10[]=$row[10];
											$arr11[]=$row[11];
											$arr12[]=$row[12];
											
											echo"
														<tr style=\"background-color:#fff;color:#000;font-size:11px;\">
															<td align=\"center\">$row[5]</td>
															<td align=\"right\">$row[6]</td>
															<td align=\"right\">$row[7]</td>
															<td align=\"right\">$row[8]</td>
															<td align=\"right\">$row[9]</td>
															<td align=\"right\">$row[10]</td>
															<td align=\"right\">$row[11]</td>
															<td align=\"right\">$row[12]</td>
														</tr>
											";
											
											//}
											
											
											
											$nopel=trim($row[0]);
										}
										if($nopel<>trim($row[0])&&$nopel<>"")echo"
													</table>
												</td>
											</tr>
											";										
									
									
									//$arr_jml=$i;
									$_SESSION['arr_jml']=$j;
									$_SESSION['arr0']=$arr0;
									$_SESSION['arr1']=$arr1;
									$_SESSION['arr2']=$arr2;
									$_SESSION['arr3']=$arr3;
									$_SESSION['arr4']=$arr4;
									$_SESSION['arr5']=$arr5;
									$_SESSION['arr6']=$arr6;
									$_SESSION['arr7']=$arr7;
									$_SESSION['arr8']=$arr8;
									$_SESSION['arr9']=$arr9;
									$_SESSION['arr10']=$arr10;
									$_SESSION['arr11']=$arr11;
									$_SESSION['arr12']=$arr12;
									
									$_SESSION["judul"]=$judul;
									$_SESSION["jumfield"]=$i;
									//$_SESSION["eskiel"]=$sql;
									//$_SESSION["alinea"]=$alg;
									$_SESSION["theader"]=$theader;
									//$_SESSION["jumdata"]=$jml_data;
									//$_SESSION["tfooter"]=$tfooter;
									$_SESSION['batas']=20;
									//echo $j;
																				
									}
									
											
									//=====================================BOF=DETAIL==============================================
									if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjperpel666"){
										$judul.="<br>Jenis Report: Per-Pelanggan";
										$i=0;
										$theader="
										<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\">
											<td>No</td>
											<td>Nomor</td>
											<td>NoLama</td>
											<td width=150>Nama</td>											
											<td>Periode<br>Rek.</td>
											<td width=70>Harga<br>Air</td>
											<td width=40>Adm</td>
											<td width=40>Meter</td>
											<td width=40>Meterai</td>
											<td width=40>Denda</td>
											<td width=70>Total</td>
										</tr>
										";																	
										
										echo"<script type=\"text/javascript\">document.getElementById(\"jrep2\").checked=\"checked\";</script>";	
										
										$alg=array("center","center","left","center","right","right","right","right","right","right","right","right","right","right");
										if($slipit!="")$slipit.=" AND ";
										//$sql="SELECT r.nomor,m.nolama,m.nama,r.periode,format(r.uangair,0),format(r.adm,0),format(r.meter,0),format(r.meterai,0),format(r.denda,0),format((r.uangair + r.adm + r.meter + r.meterai + r.denda),0) FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and (r.periode BETWEEN $periode AND $periode2) and r.status_bayar=0 ORDER BY m.nolama;";
										$sql="SELECT r.nomor,m.nolama,SUBSTR(m.nama,1,25),r.periode,format(r.uangair,0),format(r.adm,0),format(r.meter,0),format(r.meterai,0),format(r.denda,0),format((r.uangair + r.adm + r.meter + r.meterai + r.denda),0)
										FROM rekening1 AS r
										INNER JOIN master AS m ON m.nomor=r.nomor
										WHERE $slipit (r.periode BETWEEN $periode AND $periode2) and r.status_bayar=0 AND m.putus=".$sambung."
										ORDER BY m.nolama;";																				
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
												<td align=right>$row[4]</td>
												<td align=right>$row[5]</td>
												<td align=right>$row[6]</td>
												<td align=right>$row[7]</td>
												<td align=right>$row[8]</td>
												<td align=right>$row[9]</td>
											</tr>
											";
										}
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										$sql_jml="SELECT format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.denda),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0) FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and (r.periode between $periode and $periode2) and r.status_bayar=0 and m.putus=".$sambung." ORDER BY m.nolama;";
										
										$qry0=mysql_query($sql_jml)or die("err: ".mysql_error());
										if($row0=mysql_fetch_row($qry0)){
											$juangair=$row0[0];
											$jadm=$row0[1];
											$jmeter=$row0[2];
											$jmeterai=$row0[3];
											$jdenda=$row0[4];
											$jtotal=$row0[5];
										}
										$tfooter="
										<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\">											
											<td colspan=\"5\" height=\"20\">GRAND TOTAL</td>											
											<td>$juangair</td>
											<td>$jadm</td>
											<td>$jmeter</td>
											<td>$jmeterai</td>
											<td>$jdenda</td>
											<td>$jtotal</td>
										</tr>
										";
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										echo $tfooter;
										$_SESSION["judul"]=$judul;
										$_SESSION["jumfield"]=10;
										$_SESSION["eskiel"]=$sql;
										$_SESSION["alinea"]=$alg;
										$_SESSION["theader"]=$theader;
										//$_SESSION["jumdata"]=$jml_data;
										$_SESSION["tfooter"]=$tfooter;
									
									}
									//=====================================BOF=DAFTAR==============================================
									if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjdaftar"){
										$judul.="<br>Jenis Report: Daftar";
										if(isset($_POST['ch3bulan'])){
											$slipit=cek_slip($slipit)."(SELECT COUNT(r.nomor) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001)>3";
											echo"<script type=\"text/javascript\">document.getElementById(\"ch3bulan\").checked=\"checked\";</script>";	
										}
										if(isset($_POST['ch2bulan'])){
											$slipit=cek_slip($slipit)."(SELECT COUNT(r.nomor) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001)<=3";
											echo"<script type=\"text/javascript\">document.getElementById(\"ch2bulan\").checked=\"checked\";</script>";	
										}
										$i=0;
										$theader="
										<tr align=\"center\" style=\"color:#000;font-weight:bold;\">
											<td>No</td>
											<td width=45>Nomor</td>
											<td width=55>NoLama</td>
											<td width=200>Nama</td>	
											<td width=200>Alamat</td>
											<td>Jml<br>Rek</td>
											<td width=45>Pakai<br>[M<sup>3</sup>]</td>
											<td width=75>Total<br>[Rp.]</td>
											<td>KWM</td>
										</tr>
										";																	
										
										echo"<script type=\"text/javascript\">document.getElementById(\"rjrep3\").checked=\"checked\";</script>";	
										#Tambahan
										echo"<script type=\"text/javascript\">document.getElementById(\"ch5bulan\").checked=\"checked\";</script>";	
										
										
										$alg=array("center","center","left","left","right","right","right","right","right","right","right","right","right");
										if($slipit!="")$slipit.=" AND ";
										$sql="SELECT r.nomor,m.nolama,SUBSTR(m.nama,1,25),SUBSTR(lcase(m.alamat),1,25),format(COUNT(r.periode),0),format(SUM(r.pakai),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0),m.kondisi_meter
										FROM rekening1 r, master m
										WHERE $slipit r.nomor=m.nomor and (r.periode BETWEEN $periode AND $periode2) and r.status_bayar=0 AND m.putus=".$sambung."
										GROUP BY r.nomor ORDER BY m.nolama;";																				
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\">
											<td>No</td>
											<td>Nomor</td>
											<td>NoLama</td>
											<td width=250>Nama</td>	
											<td>Alamat</td>
											<td>Jml Rek.<br>[lembar]</td>
											<td>Pakai<br>[M<sup>3</sup>]</td>
											<td>Total<br>[Rp.]</td>
											<td>KWM</td>
										</tr>
										";
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[1]</td>
												<td>$row[2]</td>
												<td>".ucwords(trim($row[3]))."</td>
												<td align=right>$row[4]</td>
												<td align=right>$row[5]</td>
												<td align=right>$row[6]</td>
												<td align=center>$row[7]</td>
											</tr>
											";
										}
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										$sql_jml="SELECT format(COUNT(r.periode),0),format(SUM(r.pakai),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0) FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and (r.periode between $periode and $periode2) and r.status_bayar=0 AND m.putus=".$sambung.";";
										
										$qry0=mysql_query($sql_jml)or die("err: ".mysql_error());
										if($row0=mysql_fetch_row($qry0)){
											$jjml=$row0[0];
											$jkubik=$row0[1];
											$jtotal=$row0[2];
										}
										$tfooter="
										<tr align=\"center\" style=\"color:#000;font-weight:bold;\">											
											<td colspan=\"5\" height=\"20\">GRAND TOTAL</td>
											<td>$jjml</td>
											<td>$jkubik</td>
											<td colspan=\"2\">$jtotal</td>
										</tr>
										";
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										
										$_SESSION["judul"]=$judul;
										$_SESSION["jumfield"]=8;
										$_SESSION["eskiel"]=$sql;
										$_SESSION["alinea"]=$alg;
										$_SESSION["theader"]=$theader;
										//$_SESSION["jumdata"]=$jml_data;
										$_SESSION["tfooter"]=$tfooter;	
										$_SESSION['orientasi']='P';
										$_SESSION['batas']=40;
									}
									
									//=====================================BOF=REKAP==============================================
									if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
										$i=0;$judul.="<br>Jenis Report: Rekap";
										$theader="
										<tr align=\"center\" style=\"color:#000;font-weight:bold;\">
											<td>No.</td>
											
											<td>KODE</td>
											<td width=170>GOLONGAN TARIF</td>
											<td width=40>JML<br>REK</td>
											<td width=50>PAKAI<br>AIR M<sup>3</sup></td>
											<td width=65>HARGA AIR<br>Rp.</td>
											<td width=50>ADM</td>
											<td width=50>METER</td>											
											<td>METERAI</td>
											<td width=75>TOTAL</td>
											<td>RATA<sup>2</sup><br>HARGA</td>
											<td>RATA<sup>2</sup><br>KONS.</td>
										</tr>
										";
										$alg=array("center","left","right","right","right","right","right","right","right","right","right");
										
										echo"<script type=\"text/javascript\">document.getElementById(\"rjrep\").checked=\"checked\";</script>";	
										
										if($slipit!="")$slipit.=" AND ";
										//$sql="SELECT distinct m.gol, FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 ORDER BY m.nolama;";
										$sql="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0) as jtotal,FORMAT(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0)as avg_harga, FORMAT(IFNULL((SUM(r.pakai)/COUNT(*)),0),0)as avg_plg FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and (r.periode between $periode and $periode2) and r.status_bayar=0 AND m.putus=".$sambung." GROUP BY m.gol;";
										
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
										$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0) FROM rekening1 r,master m WHERE $slipit r.nomor=m.nomor and (r.periode between $periode and $periode2) and r.status_bayar=0 AND m.putus=".$sambung." ORDER BY m.gol;";
										
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
										<tr align=\"center\" style=\"color:#000;font-weight:bold;\">											
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
										$_SESSION['orientasi']='L';
									}
									
									echo"<tr bgcolor=#fff><td colspan=15 align=center>$tfooter</td></tr>";
								}
							?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
			<td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
            	<?php
                if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjperpel"){
					$tujuan="reports/print_report_dsr_detail.php";
				}elseif(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjdaftar"){
					$tujuan="reports/print_report_dsr_daftar.php";
					}elseif(isset($_POST["rjrep"])&& $_POST["rjrep"]=="3bulan"){
					$tujuan="reports/print_report_dsr_rekap.php";
				
				}else{
					$tujuan="reports/print_report.php";
				}
				
				
				
				?>
				<a href="<?php echo $tujuan; ?>" target="_blank" style="font-size:16px;color:#FF0000;font-weight:bold">-= Cetak Report =-</a>

<input type="button" name="export" value="Export to Excel" onClick ="$('#table-hasil').tableExport({type:'excel',escape:'false',htmlContent:'true'});" style="color:#00f;font-size:12px;font-weight:bold;padding:0px;"/>


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
//var_dump($arr11);
putus();
require_once("foot.php");
?>
