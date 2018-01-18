<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

$nloket="JPR";
$operator=$_SESSION['nama_user'];
//kunci_halaman("ganti_data_pelanggan",$secret,$operator);
$lembar=0;
$pakai=0;
$uangair=0;
$adm=0;
$meter=0;
$meterai=0;
$total=0;
$rata1=0;
$rata2=0;
$denda=0;

?>



	<tr>
		<td><br />
		<!--############################################################################################################-->
		<table width="920px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="file:///C|/Users/Asus/AppData/Local/Temp/scp46941/var/www/html/billing/img/grids.gif">
          <form id="fr1" name="fr1" method="post" action="" onsubmit="">
            <tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
              <td colspan="4"><center>
                <font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>.::  Efektivitas Penagihan Air perBLOK  ::.</b></font>
              </center></td>
            </tr>
            <tr>
             
              <td><input type="checkbox" name="chtgl" checked="checked" />
                Tgl. Transaksi</td>
              <td><input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
                &nbsp;<i>s/d</i>&nbsp;
                <input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
                [YYYY-MM-DD] </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>Periode Rek.</td>
              <td><select name="optperiode" id="optperiode" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <?php
						$sql=mysql_query("select distinct periode from rekening1_awal order by periode DESC");
						//$sql=mysql_query("select distinct max(periode) from rekening1_awal;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>	&nbsp;s/d&nbsp;
          <select name="optperiode2" id="optperiode2">
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from rekening1_awal order by periode DESC");
						//$sql=mysql_query("select distinct max(periode) from rekening1_awal;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>				</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
        <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="right"></td>
              <td><input type="checkbox" name="chlpp" value="perlpp" checked="checked" />
                
                Efektifitas LPP</td>
              <td><!--select name="optnama" id="optgol" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <!--?php
						$sql=mysql_query("select distinct nomor,tgl,jam,lama,baru,operator,loket from ubah_nama order by nomor");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select-->
                  <input type="radio" name="rnama"  value="perblok" id="rblok"/> 
              Efektifitas DRD</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="radio" name="rjtrans" id="rjtrans0" value="0"  />                
                Lunas
              <input type="hidden" name="rjtrans" id="rjtrans1" value="1" />              </td>
              <td><!--<select name="optjlok" id="optjlok">
                  <!--option value="">-Pilih-</option>
                  <!--?php
						$sql=mysql_query("select kode_loket,ket_loket from m_loket order by kode_loket");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select-->              </td>
            </tr>
                        <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><!--input type="radio" name="r1" id="rallupp"  value="all"/-->
                &nbsp;
                <input type="hidden" id="dik" name="dik" />              </td>
              <td colspan="2"></td>
              <td align="right"><input type="submit" name="proses" value="Proses" class="kelas_tombol" />
                  <input type="button" name="batal" value="Batal"  class="kelas_tombol" onclick="" />              </td>
            </tr>
          </form>
		  </table>
		<br />
		  
		  <table width="1024px" align="center" border="0" cellpadding="2" cellspacing="2" style="box-shadow: 0 0 15px #999;" background="img/grids.gif" class="rounded">
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
						<table width="100%" border="1" id="table-hasil" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
							 <form name="f2" id="f2" method="post" action="lap_nomor_nama.php">
							
              
							<?php
								if (isset($_POST["proses"])&& $_POST["proses"]=="Proses"){
									$tawal='2000-01-01';
									$takhir=date('Y-m-d');
									$slipit="";
									$stbayar=0;
									$i=0;
									$judul="";
									$key="";
									$optcabang="";
									
									$stbatal=$_POST['rjtrans'];
									$jdl_lunas="";
									if ($stbatal=='1'){
										$jdl_lunas="Pembatalan ";
										$stbayar=0;
										//$slipit=cek_slip($slipit)."z.batal=1 AND r.status_bayar=0";
										$slipit=cek_slip($slipit)."z.batal=1";
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
									}
									
									
											//break;
																		
									if (isset($_POST["proses"])&& $_POST["proses"]=="Proses"){
									$slipit="";	
									$periode=$_POST["optperiode"];$periode2=$_POST["optperiode2"];
									echo"<script type=\"text/javascript\">document.getElementById(\"optperiode\").value=\"$periode\";</script>";
									echo"<script type=\"text/javascript\">document.getElementById(\"optperiode2\").value=\"$periode2\";</script>";
									}
									//MENAMPILKAN EFEKTIVITAS LPP PER BLOK
								if(isset($_POST["chlpp"])&& $_POST["chlpp"]=="perlpp"){
								
										$sql="
										SELECT distinct 
										m.gol
										,(select format(SUM(r.status_bayar),0) from rekening1 as r where r.status_bayar=1) as lunas
										,COUNT(*) as jml_rek
										,SUM(r.pakai) as jpakai
										,SUM(r.uangair) as juangair
										,SUM(r.adm) as jadm,SUM(r.meter)as jmeter
										,SUM(r.meterai) as jmeterai
										,SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda) as jtotal
										, ifnull(round(sum(r.uangair)/sum(r.pakai),2),0)as avg_harga
										, ifnull(round(sum(r.pakai)/count(*),2),0)as avg_plg
										, SUM(r.denda) AS jdenda
										,m.kode_blok
										,SUM(r.status_bayar)
										,format(SUM(r.pakai),0)
										,format(SUM(r.uangair),0)
										,format(SUM(r.adm),0)
										,format(SUM(r.meter),0)
										,format(SUM(r.meterai),0)
										,format(SUM(r.denda),0)
										,format(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0)
										
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
										LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.periode=r.periode AND (r.periode BETWEEN $periode AND $periode2) AND z.batal=0 AND r.status_bayar=1
										GROUP BY m.kode_blok
										ORDER BY m.kode_blok 
										
										;"; //ORDER BY z.tbayar ASC, r.periode ASC
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										
																	
									
										
										echo "
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#ccc);color:#000;font-weight:bold;\">
											<td>No.</td>
											<td>KODE BLOK</td>
											<td>JML REK.</td>
											
											<td>PAKAI<br>AIR M<sup>3</sup></td>
											<td>HARGA AIR<br>Rp.</td>
											<td>ADM</td>
											<td>METER</td>											
											<td>METERAI</td>
											<td>DENDA</td>
											<td>TOTAL</td>
											
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
												$denda+=$row[11];
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[12]</td>
												<td align=center>$row[13]</td>
												<td align=right>".formatMoney($row[14])."</td>
												<td align=right>".formatMoney($row[15])."</td>
												<td align=right>".formatMoney($row[16])."</td>
												<td align=right>".formatMoney($row[17])."</td>
												<td align=right>".formatMoney($row[18])."</td>
												<td align=right>".formatMoney($row[19])."</td>
												<td align=right>".formatMoney($row[20])."</td>
												
											</tr>
											";
											}
											//query jumlah total lpp
												$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),format(SUM(r.denda),0)
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON  m.nomor=r.nomor
										LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') 
										AND z.periode=r.periode AND (r.periode BETWEEN $periode AND $periode2)  AND z.batal=0 AND r.status_bayar=1
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
											$jdenda=$row0[7];
										}
										echo"
										  	<tr align=\"center\" style=\"background-color:#ddd;color:#000;font-weight:bold;\">											
											<td style=\"border:1px solid;\" colspan=\"2\" height=\"20\">TOTAL</td>
												<td align=right>$jrek</td>
												<td align=right>$jpakai</td>
												<td align=right>$juangair</td>
												<td align=right>$jadm</td>
												<td align=right>$jmeter</td>
												<td align=right>$jmeterai</td>
												<td align=right>$jdenda</td>
												<td align=right>$jtotal</td>
</tr>


											";	
											
											
													
										  
										/*echo"<script type=\"text/javascript\">document.getElementById(\"rlpp\").checked=\"checked\";</script>";
										echo"<script type=\"text/javascript\">document.getElementById(\"rjtrans0\").checked=\"checked\";</script>";*/
										/*$judul.="<br>Golongan Tarif : $key";*/
									}
									
								
									
									//MENAMPILKAN DRD AWAL PER BLOK
//									
									if(isset($_POST["rnama"])&& $_POST["rnama"]=="perblok"){
				
										$sql="
										SELECT DISTINCT 
										r.gol
										,(select distinct t.keterangan from tarif t where t.gol=m.gol)as ket
										,FORMAT(COUNT(*),0) as jml_rek
										,FORMAT(SUM(r.pakai),0) as jpakai
										,FORMAT(SUM(r.uangair),0) as juangair
										,FORMAT(SUM(r.adm),0) as jadm
										,FORMAT(SUM(r.meter),0)as jmeter
										,FORMAT(SUM(r.meterai),0) as jmeterai
										,FORMAT(SUM((r.uangair + r.adm + r.meter + r.meterai)),0) as jtotal
										,format(ifnull((sum(r.uangair)/sum(r.pakai)),0),0)as avg_harga
										,format(ifnull((sum(r.pakai)/count(*)),0),0)as avg_plg
										,m.kode_blok
										,FORMAT(COUNT(m.kode_blok),0) as jml_rek
										FROM rekening1_awal as r
										INNER JOIN master AS m ON m.nomor=r.nomor
										WHERE $slipit(r.periode BETWEEN $periode AND $periode2) GROUP BY m.kode_blok ASC
										;";
										
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										
										$total="select IFNULL(FORMAT(count(r.nomor),0),0) AS hsl
										,FORMAT(SUM(r.pakai),0) as jpakai
										,FORMAT(SUM(r.uangair),0) as juangair
										,FORMAT(SUM(r.adm),0) as jadm
										,FORMAT(SUM(r.meter),0)as jmeter
										,FORMAT(SUM(r.meterai),0) as jmeterai
										,FORMAT(SUM((r.uangair + r.adm + r.meter + r.meterai)),0) as jtotal
										FROM rekening1_awal as r
										INNER JOIN master AS m ON m.nomor=r.nomor
										WHERE $slipit(r.periode BETWEEN $periode AND $periode2) 
										"; 
										$tot=mysql_query($total)or die("err: ".mysql_error());
										
										echo "
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#c0c0c0);color:#000;font-weight:bold;\">
											<td>No.</td>
											<td>KODE BLOK</td>
											
											<td>JML<br>REK.</td>
											<td>PAKAI<BR>AIR M3</td>
											<td>HARGA AIR<BR>Rp.</td>
											<td>ADM<BR>Rp.</td>
											<td>METER<BR>Rp.</td>
											<td>METERAI<BR>Rp.</td>
											<td>TOTAL<BR>Rp.</td></td>
											
										</tr>
										";
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[11]</td>
												<td align=right>$row[12]</td>
												<td align=\"right\" style=\"color:#000\">$row[3]</td>
												<td align=\"right\" style=\"color:#000\">$row[4]</td>
												<td align=\"right\" style=\"color:#000\">$row[5]</td>
												<td align=\"right\" style=\"color:#000\">$row[6]</td>
												<td align=\"right\" style=\"color:#000\">$row[7]</td>
												<td align=\"right\" style=\"color:#000;font-weight:bold;\">$row[8]</td>
												
											</tr>
																																

											
											";
										}
										
												while($row=mysql_fetch_row($tot)){
											$i++;
										  	echo"
										  	<tr align=\"center\" style=\"background-color:#ddd;color:#000;font-weight:bold;\">											
											<td style=\"border:1px solid;\" colspan=\"2\" height=\"20\">TOTAL</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[1]</td>
												<td align=center>$row[2]</td>
												<td align=center>$row[3]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[6]</td>
</tr>


											";	}							

										
										
										/*echo"<script type=\"text/javascript\">document.getElementById(\"rblok\").checked=\"checked\";</script>";*/
									
									
										
																		
									
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										//$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0) FROM rekening1 r,transaksi z,master m WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.nomor=r.nomor AND r.nomor=m.nomor AND m.nomor=z.nomor AND z.batal=$stbatal AND z.periode=r.periode AND m.putus=0 ";
										$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),format(SUM(r.denda),0)
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON  m.nomor=r.nomor
										LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit z.periode=r.periode AND (z.tbayar BETWEEN '$tawal' AND '$takhir')
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
											$jdenda=$row0[7];
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
											<td align=right>$jdenda</td>
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
										//$_SESSION["alinea"]=$alg;
										//$_SESSION["theader"]=$theader;
										//$_SESSION['barisan']=$barisan;
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
									
									//echo"<tr bgcolor=#fff><td colspan=19 align=center>$tfooter</td></tr>";									
								
								
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
                <a href="<!--?php echo $tujuan; ?>" target="_blank" style="font-size:16px;color:#FF0000;font-weight:bold;"></a>
                 <input type="button" name="export" value="Export to Excel" onClick ="$('#table-hasil').tableExport({type:'excel',escape:'false',htmlContent:'true'});" style="color:#00f;font-size:12px;font-weight:bold;padding:0px;"/>
                 
				<!--input type="checkbox" name="chcustprint" value="customprint" />Custom -=> 
				Mengetahui:
				<select name="optrespon1" id="optrespon1" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<option value="" selected="selected">--Pilih--</option>
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
					<option value="" selected="selected">--Pilih--</option>
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
					<!--?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nik,nama,jabatan from responsibility where jabatan<>'DIREKTUR UTAMA' order by nik DESC");
					while($p=mysql_fetch_row($usr)){
					echo "<option value=\"$p[0]\">$p[1]</option>";
					}
					?>
				</select-->
               
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
