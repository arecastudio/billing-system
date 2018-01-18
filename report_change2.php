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
kunci_halaman("ganti_data_pelanggan",$secret,$operator);
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
                <font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>.::  Laporan Perubahan Data Pelanggan  ::.</b></font>
              </center></td>
            </tr>
            <tr>
             
              <td><input type="checkbox" name="chtgl" checked="checked" />
                Tgl. Perubahan</td>
              <td><input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
                &nbsp;<i>s/d</i>&nbsp;
                <input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
                [YYYY-MM-DD] </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rupp"   value="perupp" checked="checked" />
                Cabang [UPP]</td>
              <td><select name="optcabang" id="optcabang" >
                  <option value="11" selected="selected">Semua UPP</option>
                  <?php
						$sql=mysql_query("select cabang,nama from cabang WHERE cabang<>'00' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>              </td>
              <td><input type="radio" name="rnama"  value="perkor" id="rkor"/>
Perubahan Koreksi Rekening</td>
              <td><input type="radio" name="rnama"  value="perdsmp" id="rdsmp"/>
Perubahan DSMP</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="radio" name="rnama"  value="perkwm" id="rkwm"/>
                Perubahan Status Kondisi Meter</td>
              <td><input type="radio" name="rnama"  value="pernama" id="rnama"/>
                Perubahan Nama Pelanggan</td>
              <td><!--select name="optnama" id="optgol" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <!--?php
						$sql=mysql_query("select distinct nomor,tgl,jam,lama,baru,operator,loket from ubah_nama order by nomor");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select-->
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="radio" name="rnama" value="meter" id="rmtr" />
                Perubahan Meterisasi</td>
              <td><input type="radio" name="rnama" value="pernomor" id="rnomor" />
                Perubahan Nomor Sambungan</td>
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
              <td><input type="radio" name="rnama"  value="perstatus" id="rstatus"/>
                Perubahan Status Pelanggan</td>
              <td align="right"><div align="left">
                  <input type="radio" name="rnama" value="pergol" id="rgol" />
                Perubahan Golongan Tarif</div></td>
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
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
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
									
										//case"all":											
										//	$judul.="<br>Semua Cabang [UPP]";
											echo"<script type=\"text/javascript\">document.getElementById(\"rallupp\").checked=\"checked\";</script>";											
									//		break;
									}
									//if(isset($_POST["r1"]))$radio1=$_POST["r1"];
									//switch($radio1){
										//case"perupp":
											if(isset($_POST['optcabang']) && ($key=$_POST["optcabang"])!=""){
											//if(isset($_POST["rnama"])&& $_POST["rnama"]=="perupp"){
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
											//break;
									
									//MENAMPILKAN PERUBAHAN NAMA PELANGGAN
//									if(($key=$_POST["rnama"])!=""){
//									if(isset($_POST["rnama"])!="pernama"){
									if(isset($_POST["rnama"])&& $_POST["rnama"]=="pernama"){
								
										$sql="
										SELECT DISTINCT u.nomor,u.tgl,u.lama,u.baru,u.operator,u.loket,m.nolama,u.sumber
										FROM ubah_nama AS u
										LEFT OUTER JOIN master as m on u.nomor=m.nomor
										WHERE (u.tgl BETWEEN '$tawal' AND '$takhir') and $slipit
										ORDER BY u.tgl ASC
										;"; 
										$hasil=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										
										<tr align=\"center\" style=\"color:#000;font-weight:bold;background:linear-gradient(#fff,#ccc);\">
											<td>No.</td>
											<td>Tanggal</td>
											<td>Nomor</td>
											<td>Nomor Lama</td>
											<td>Nama Lama</td>
											<td>Nama Baru</td>
											<td>Operator</td>
											<td>Loket</td>
											<td>Sumber/Ket</td>
											
										</tr>
										
										";
										
										while($row=mysql_fetch_row($hasil)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[1]</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[6]</td>
												<td align=left>$row[2]</td>
												<td align=left>$row[3]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[7]</td>
												
												
											</tr>
											";}
										  
										echo"<script type=\"text/javascript\">document.getElementById(\"rnama\").checked=\"checked\";</script>";
										/*$judul.="<br>Golongan Tarif : $key";*/
									}
									
									//MENAMPILKAN PERUBAHAN NOMOR SAMBUNGAN
//									if(isset($_POST["rnama"])!="pernomor"){
									if(isset($_POST["rnama"])&& $_POST["rnama"]=="pernomor"){
				
										$sql="
										SELECT DISTINCT n.nomor,n.tgl,n.lama,n.baru,n.operator,n.loket,m.nama,m.alamat
										FROM ubah_nomor AS n
										LEFT OUTER JOIN master as m on n.nomor=m.nomor
										WHERE (n.tgl BETWEEN '$tawal' AND '$takhir') and $slipit
										ORDER BY n.tgl ASC
										;"; 
										$hasil=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										
										<tr align=\"center\" style=\"color:#000;font-weight:bold;background:linear-gradient(#fff,#ccc);\">
											<td>No.</td>
											<td>Tanggal</td>
											<td>Nomor</td>
											<td>Nomor Lama</td>
											<td>Nomor Baru</td>
											<td>Nama Pelanggan</td>
											<td>Alamat</td>
											<td>Operator</td>
											<td>Loket</td>
											
											
										</tr>
										
										";
										
										while($row=mysql_fetch_row($hasil)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[1]</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[2]</td>
												<td align=center>$row[3]</td>
												<td align=left>$row[6]</td>
												<td align=left>$row[7]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												
												
												
											</tr>
											";}
										  
										  
										
										echo"<script type=\"text/javascript\">document.getElementById(\"rnomor\").checked=\"checked\";</script>";
										/*$judul.="<br>Golongan Tarif : $key";*/
									}
									
									//MENAMPILKAN PERUBAHAN GOLONGAN TARIF
//									if(isset($_POST["rnama"])!="pergol"){
									if(isset($_POST["rnama"])&& $_POST["rnama"]=="pergol"){
				
										$sql="
										SELECT DISTINCT u.nomor,u.tgl,u.jam,u.nola1,u.nola2,u.gol1,u.gol2,u.operator,u.loket,m.nama,u.sumber
										FROM ubah_gol AS u
										LEFT OUTER JOIN master as m on u.nomor=m.nomor
										WHERE (u.tgl BETWEEN '$tawal' AND '$takhir') and $slipit
										ORDER BY u.tgl ASC
										;"; 
										$hasil=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										
										<tr align=\"center\" style=\"color:#000;font-weight:bold;background:linear-gradient(#fff,#ccc);\">
											<td>No.</td>
											<td>Tgl</td>
											<td>Jam</td>
											<td>Nomor</td>
											<td>Nomor Lama</td>
											<td>NomorBaru</td>
											<td>Gol Lama</td>
											<td>Gol baru</td>
											<td>Nama Pelanggan</td>
											<td>Operator</td>
											<td>Loket</td>
											<td>Sumber/Ket</td>
											
										</tr>
										
										";
										
										while($row=mysql_fetch_row($hasil)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[1]</td>
												<td align=center>$row[2]</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[3]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[6]</td>
												<td align=left>$row[9]</td>
												<td align=center>$row[7]</td>
												<td align=center>$row[8]</td>
												<td align=center>$row[10]</td>
												
												
											</tr>
											";}
										  									
										echo"<script type=\"text/javascript\">document.getElementById(\"rgol\").checked=\"checked\";</script>";
									
									}
									//MENAMPILKAN PERUBAHAN STATUS KONDISI METER
//									if(isset($_POST["rnama"])!="pergol"){
									if(isset($_POST["rnama"])&& $_POST["rnama"]=="perkwm"){
				
										$sql="
										SELECT DISTINCT k.nomor,k.tgl,k.jam,k.lama,k.baru,k.operator,k.loket,m.nolama,m.nama,k.sumber
										FROM ubah_kwm AS k
										LEFT OUTER JOIN master as m on k.nomor=m.nomor
										WHERE (k.tgl BETWEEN '$tawal' AND '$takhir') and $slipit
										ORDER BY k.tgl ASC
										;"; 
										$hasil=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										
										<tr align=\"center\" style=\"color:#000;font-weight:bold;background:linear-gradient(#fff,#ccc);\">
											<td>No.</td>
											<td>Tgl</td>
											<td>Jam</td>
											<td>Nomor</td>
											<td>Nomor Lama</td>
											<td>Nama Pelanggan</td>
											<td>Status KWM Lama</td>
											<td>Status KWM Baru</td>
											<td>Operator</td>
											<td>Sumber/Ket</td>
											
											
										</tr>
										
										";
										
										while($row=mysql_fetch_row($hasil)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[1]</td>
												<td align=center>$row[2]</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[7]</td>
												<td align=left>$row[8]</td>
												<td align=center>$row[3]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[9]</td>
												
												
											</tr>
											";}
										  									
										echo"<script type=\"text/javascript\">document.getElementById(\"rkwm\").checked=\"checked\";</script>";
									
									}
									//MENAMPILKAN PERUBAHAN METERISASI
//									if(isset($_POST["rnama"])!="pergol"){
									
									if(isset($_POST["rnama"])&& $_POST["rnama"]=="meter"){
				
										$sql="
										SELECT DISTINCT m1.nomor,m1.tgl,m1.jam,m1.nometer1,m1.nometer2,m1.merk1,m1.merk2,m1.ukuran1,m1.ukuran2,m1.angka1,m1.angka2,m1.operator,m1.tgl_pasang,m.nolama,m.nama,m1.sumber
										FROM ubah_meter AS m1
										LEFT OUTER JOIN master as m on m1.nomor=m.nomor
										WHERE (m1.tgl BETWEEN '$tawal' AND '$takhir') AND $slipit
										ORDER BY m1.tgl ASC, m.nolama ASC 
																				;"; 
										$hasil=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										
										<tr align=\"center\" style=\"color:#000;font-weight:bold;background:linear-gradient(#fff,#ccc);\">
											<td>No.</td>
											<td>Tgl</td>
											<td>Jam</td>
											<td>Nomor</td>
											<td>No.Lama</td>
											<td>Nama Pelanggan</td>
											<td>No.Mtr.Lama </td>
											<td>No.Mtr.Baru</td>
											<td>Merk Lama</td>
											<td>Merk Baru</td>
											<td>U.Lama</td>
											<td>U.Baru</td>
											<td>Angka Lama</td>
											<td>Angka Baru</td>
											<td>Operator</td>
											<td>Tgl Pasang</td>
											<td>Sumber/Ket</td>
											
											
										</tr>
										
										";
										
										while($row=mysql_fetch_row($hasil)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[1]</td>
												<td align=center>$row[2]</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[13]</td>
												<td align=left>$row[14]</td>
												<td align=center>$row[3]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[6]</td>
												<td align=center>$row[7]</td>
												<td align=center>$row[8]</td>
												<td align=center>$row[9]</td>
												<td align=center>$row[10]</td>
												<td align=center>$row[11]</td>
												<td align=center>$row[12]</td>
												<td align=center>$row[15]</td>
												
												
											</tr>
											";}
																			
										echo"<script type=\"text/javascript\">document.getElementById(\"rmtr\").checked=\"checked\";</script>";
										echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$key\";</script>";

									
									}
									//MENAMPILKAN PERUBAHAN STATUS PELANGGAN
//									if(isset($_POST["rnama"])!="pergol"){
									if(isset($_POST["rnama"])&& $_POST["rnama"]=="perstatus"){
				
										$sql="
										SELECT DISTINCT s.nomor,s.tgl,s.jam,s.lama,s.baru,s.operator,s.loket,m.nolama,m.nama
										FROM ubah_stat AS s
										LEFT OUTER JOIN master as m on s.nomor=m.nomor
										WHERE (s.tgl BETWEEN '$tawal' AND '$takhir') and $slipit
										ORDER BY s.tgl ASC
										;"; 
										$hasil=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										
										<tr align=\"center\" style=\"color:#000;font-weight:bold;background:linear-gradient(#fff,#ccc);\">
											<td>No.</td>
											<td>Tgl</td>
											<td>Jam</td>
											<td>Nomor</td>
											<td>Nomor Lama</td>
											<td>Nama Pelanggan</td>
											<td>Status P. Lama </td>
											<td>Status P. Baru</td>
											<td>Operator</td>
											<td>Loket</td>
											
											
										</tr>
										
										";
										
										while($row=mysql_fetch_row($hasil)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[1]</td>
												<td align=center>$row[2]</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[7]</td>
												<td align=left>$row[8]</td>
												<td align=center>$row[3]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[6]</td>
												</tr>
											";}
										  									
										echo"<script type=\"text/javascript\">document.getElementById(\"rstatus\").checked=\"checked\";</script>";
									
									}
									
									//MENAMPILKAN PERUBAHAN KOREKSI REKENING
//									if(isset($_POST["rnama"])!="pergol"){
									if(isset($_POST["rnama"])&& $_POST["rnama"]=="perkor"){
				
										$sql="
										SELECT DISTINCT k.nomor,m.nolama,k.periode,k.standlalu,k.standkini,k.pakai,format((k.uangair + k.adm + k.meter + k.denda + k.meterai),0) as total,k.tkorek,k.loket,k.operator,k.standlalu_awal,k.standkini_awal,k.pakai_awal,format((k.uangair_awal + k.adm_awal + k.meter_awal + k.denda_awal + k.meterai_awal),0) as total_awal,m.nama,k.tdisposisi
										FROM his_koreksi_rek AS k
										LEFT OUTER JOIN master as m on k.nomor=m.nomor
										WHERE (k.tkorek BETWEEN '$tawal' AND '$takhir') and $slipit
										ORDER BY k.operator, k.tkorek ASC
										;"; 
										$hasil=mysql_query($sql)or die("err: ".mysql_error());

										$total="select format(SUM(k.standlalu_awal),0),
										format(SUM(k.standlalu),0),
										format(SUM(k.standkini_awal),0),
										format(SUM(k.standkini),0),
										format(SUM(k.pakai_awal),0),
										format(SUM(pakai),0),
										format(SUM(total_awal),0),
										format(SUM(total),0) 
										FROM his_koreksi_rek AS k
										LEFT OUTER JOIN master as m on k.nomor=m.nomor
										WHERE (k.tkorek BETWEEN '$tawal' AND '$takhir') and $slipit
										ORDER BY k.operator, k.tkorek ASC
										"; 
										$tot=mysql_query($total)or die("err: ".mysql_error());
										echo "
										
										<tr align=\"center\" style=\"color:#000;font-weight:bold;background:linear-gradient(#fff,#ccc);\">
											<td>No.</td>
											<td>Tgl Koreksi</td>
											<td>Tgl Disposisi</td>
											<td>Nomor</td>
											<td>Nomor Lama</td>
											<td>Nama Pelanggan</td>
											<td>periode</td>
											<td>S. Awal</td>
											<td>S. Akhir</td>
											<td>Standkini<br/> Awal</td>
											<td>Standkini<br/> Akhir</td>
											<td>Pakai<br/> Awal</td>
											<td>Pakai<br/> Akhir</td>
											<td>Total<br/> Awal</td>
											<td>Total<br/> Akhir</td>
											
											<td>Loket</td>
											<td>Operator</td>
											</tr>
										
										";
										
										while($row=mysql_fetch_row($hasil)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[7]</td>
												<td align=center>$row[15]</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[1]</td>
												<td align=left>$row[14]</td>
												<td align=center>$row[2]</td>
												<td align=center>$row[10]</td>
												<td align=center>$row[3]</td>
												<td align=center>$row[11]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[12]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[13]</td>
												<td align=center>$row[6]</td>
												
												<td align=center>$row[8]</td>
												<td align=center>$row[9]</td>
																					
												</tr>

											";}
										  	while($row=mysql_fetch_row($tot)){
											$i++;
										  	echo"
										  	<tr align=\"center\" style=\"background-color:#ddd;color:#000;font-weight:bold;\">											
											<td style=\"border:1px solid;\" colspan=\"11\" height=\"20\">TOTAL KOREKSI REKENING</td>
												
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[6]</td>
												<td align=center>$row[7]</td>
												

</tr>


											";	}							
										echo"<script type=\"text/javascript\">document.getElementById(\"rkor\").checked=\"checked\";</script>";
									
									}
									//MENAMPILKAN HISTORY PERUBAHAN DSMP
//									if(isset($_POST["rnama"])!="pergol"){
									if(isset($_POST["rnama"])&& $_POST["rnama"]=="perdsmp"){
				
										$sql="
										SELECT DISTINCT s.nomor,s.tgl,s.jam,s.periode,s.angka_awal,s.angka_akhir,s.operator,s.loket,m.nolama,m.nama,m.kode_blok
										FROM his_dsmp0 AS s
										LEFT OUTER JOIN master as m on s.nomor=m.nomor
										WHERE (s.tgl BETWEEN '$tawal' AND '$takhir') and $slipit
										ORDER BY s.tgl ASC
										;"; 
										$hasil=mysql_query($sql)or die("err: ".mysql_error());
										echo "
										
										<tr align=\"center\" style=\"color:#000;font-weight:bold;background:linear-gradient(#fff,#ccc);\">
											<td>No.</td>
											<td>Tgl</td>
											<td>Jam</td>
											<td>Nomor</td>
											<td>Nomor Lama</td>
											<td>Kode Blok</td>
											<td>Nama Pelanggan</td>
											<td>Periode</td>
											<td>Angka<br>DSMP</td>
											<td>Angka<br>Perubahan</td>
											<td>Operator</td>
											<td>Loket</td>
											
											
										</tr>
										
										";
										
										while($row=mysql_fetch_row($hasil)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[1]</td>
												<td align=center>$row[2]</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[8]</td>
												<td align=center>$row[10]</td>
												<td align=left>$row[9]</td>												
												<td align=center>$row[3]</td>
												<td align=center>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[6]</td>
												<td align=center>$row[7]</td>
												</tr>
											";}
										  									
										echo"<script type=\"text/javascript\">document.getElementById(\"rdsmp\").checked=\"checked\";</script>";
									
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
										
									
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										
										//$_SESSION["judul"]=$judul;
										$_SESSION["jumfield"]=13;
										/*$_SESSION["eskiel"]="
										SELECT DISTINCT z.tbayar,z.jbayar,r.nomor,m.nolama,SUBSTR(m.nama,1,25),r.periode,(r.pakai),FORMAT(r.uangair,0),FORMAT(r.adm,0),FORMAT(r.meter,0),format(r.denda,0),format(r.meterai,0),format(r.uangair + r.adm + r.meter + r.meterai + r.denda,0)
										FROM rekening1 AS r
										LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
										LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.periode=r.periode AND (r.periode BETWEEN $periode AND $periode2)
										ORDER BY z.tbayar ASC, z.jbayar ASC, r.periode ASC
										;";//ORDER BY m.nolama ASC, r.periode ASC
										$_SESSION["alinea"]=$alg;
										$_SESSION["theader"]=$theader;
										//$_SESSION["jumdata"]=$jml_data;
										/*$_SESSION["tfooter"]="
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
										";*/	
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
											<td width=70>DENDA</td>
											<td width=90>TOTAL</td>
											<td width=70>RATA<sup>2</sup><br>HARGA</td>
											<td width=70>RATA<sup>2</sup><br>KONS.</td>
										</tr>
										";
										$alg=array("center","left","right","right","right","right","right","right","right","right","right","right");
										
										if($slipit!="")$slipit.=" AND ";
										$ada_hapus=0;$barisan="";
										$prawal=$periode;
										
										if($periode<=201112){
											$ada_hapus=1;
											$periode=201201;
											$sql_hapus="SELECT distinct m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter)as jmeter,SUM(r.meterai) as jmeterai,SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda) as jtotal, ifnull(round(sum(r.uangair)/sum(r.pakai),2),0)as avg_harga, ifnull(round(sum(r.pakai)/count(*),2),0)as avg_plg, SUM(r.denda) AS jdenda
											FROM rekening1 AS r
											LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
											LEFT OUTER JOIN transaksi AS z ON z.nomor=r.nomor
											WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.periode=r.periode AND (r.periode BETWEEN $prawal AND 201112)
											GROUP BY m.gol
											ORDER BY m.gol
											;";
										}
										
										//$sql="SELECT distinct m.gol, FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 ORDER BY m.nolama;";
										$sql="SELECT distinct m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter)as jmeter,SUM(r.meterai) as jmeterai,SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda) as jtotal, ifnull(round(sum(r.uangair)/sum(r.pakai),2),0)as avg_harga, ifnull(round(sum(r.pakai)/count(*),2),0)as avg_plg, SUM(r.denda) AS jdenda
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
											<td>DENDA</td>
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
												$denda+=$row[11];
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
												<td align=right>".formatMoney($row[11])."</td>
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
												<td align=right>".formatMoney($row[11])."</td>
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
												<td align=\"right\" >".formatMoney($denda)."</td>
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
												<td align=\"right\" >".formatMoney($denda)."</td>
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
													<td colspan=\"12\">Periode Rek. di bawah Tahun 2012 [200001 - 201112]</td>
												</tr>
												";
											$barisan.="<tr style=\"color:#000;font-weight:bold;\">
													<td colspan=\"12\">Periode Rek. di bawah Tahun 2012 [200001 - 201112]</td>
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
												$denda=0;
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
												$denda+=$row1[11];
																												
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
													<td align=right>".formatMoney($row1[11])."</td>
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
													<td align=right>".formatMoney($row1[11])."</td>
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
												<td align=\"right\" >".formatMoney($denda)."</td>
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
												<td align=\"right\" >".formatMoney($denda)."</td>
												<td align=\"right\" >".formatMoney($total)."</td>
												<td align=\"right\" >".formatMoney($rata1)."</td>
												<td align=\"right\" >".formatMoney($rata2)."</td>
												
												</tr>
												
												
												";
										}
										
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										//$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0) FROM rekening1 r,transaksi z,master m WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.nomor=r.nomor AND r.nomor=m.nomor AND m.nomor=z.nomor AND z.batal=$stbatal AND z.periode=r.periode AND m.putus=0 ";
										$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),format(SUM(r.denda),0)
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
                <a href="<?php echo $tujuan; ?>" target="_blank" style="font-size:16px;color:#FF0000;font-weight:bold;">-= Cetak Report =-</a>
				<input type="checkbox" name="chcustprint" value="customprint" />Custom -=>
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
