<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");

$nloket="JPR";
$operator=$_SESSION['nama_user'];
kunci_halaman("ubah_meter",$secret,$operator);
?>

<tr>
	<td>
	<br/>
		
		<div class="wrapper">
			
		<table background="img/grids.gif" width="550px" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="return suvalid(this);">
				<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
				  <td colspan="3"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>Proses Meterisasi</b></font></center></td>
				</tr>
				<tr>
					<td width="110px">Nomor / NoLama</td>
						<input type="hidden" name="txhnomor" id="txhnomor" />
						<input type="hidden" name="txhstat" id="txhstat" />
						<input type="hidden" name="txhdapat" id="txhdapat" value="0" />
						<input type="hidden" name="txhtawal" id="txhtawal"/>
					<td width="100px"><input type="text" name="txnomor" id="txnomor" size="10" value="" onKeyPress="return isNumb(event);" /></td>
					<td>
						<input type="submit" name="cari" value="Tampilkan" class="kelas_tombol" />
						&nbsp;&nbsp;<input type="button" name="cr" value="Cari" class="kelas_tombol"  onclick="window.open('cari.php','popUpWindow','height=400,width=800,left=10,top=10,scrollbars=yes,menubar=no'); return false;" />
					</td>					
				</tr>
				<tr>
					<td valign="top">Keterangan</td>
					<td colspan="2">
						<?php
						$focus=0;$dapat=0;$nola="";
						$merk=1;$merk_nama="";$noseri=0;$diameter=1;$diameter_nama="";
						if(isset($_POST['cari']) && $_POST['txnomor']!=''){
							$nmr=$_POST['txnomor'];$htawal=$_POST['txhtawal'];
							echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").value=\"$nmr\";</script>";

							echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$htawal\";</script>";
							
							$sql="
							SELECT m.nomor, m.nolama, m.nama, m.alamat, m.kode_blok, b.ket_blok, m.kode_wilayah, w.nama_wilayah, m.cabang, c.nama, m.gol, g.keterangan, m.jenis_pel, m.online, m.putus,(IF(m.putus='0','AKTIF',IF(m.putus='2','SEGEL',IF(m.putus='3','PUTUS','HAPUS'))))as st_putus, (IF(m.kondisi_meter='1','[1] Aktif',IF(m.kondisi_meter='2','[2] Segel',IF(m.kondisi_meter='3','[3] Rusak','[4] Non-Meter')))) AS kwm, m.tglstart, m.tgl_input
							,(SELECT FORMAT(COUNT(r.nomor),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001) as lembar
							,(SELECT IFNULL(FORMAT(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001) as total
							,m.kondisi_meter, m.merk,(SELECT k.nama FROM merk AS k WHERE k.merk=m.merk LIMIT 1), m.nometer, m.ukuran,(SELECT k.ukuran FROM meter AS k WHERE k.kode=m.ukuran LIMIT 1)
							FROM master AS m
							LEFT OUTER JOIN cabang AS c ON c.cabang=m.cabang
							LEFT OUTER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah AND w.kode_cabang=m.cabang
							LEFT OUTER JOIN master_blok AS b ON b.kode_blok=m.kode_blok
							LEFT OUTER JOIN tarif AS g ON g.gol=m.gol
							WHERE (m.nomor='$nmr' OR m.nolama='$nmr') AND m.putus='0'
							LIMIT 1
							;";
							//22,23,24,25,26
							$qry=mysql_query($sql)or die(mysql_error());
							if($row=mysql_fetch_row($qry)){
							$htanggal=$_POST['txhtawal'];
							$focus=1;$dapat=1;
							echo"<script type=\"text/javascript\">document.getElementById(\"txhnomor\").value=\"$row[0]\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"txhstat\").value=\"$row[21]\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"txhdapat\").value=\"1\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById('txtawal').value=\"$htanggal\"</script>";
							
							$merk=$row[22];$merk_nama=$row[23];$noseri=$row[24];$diameter=$row[25];$diameter_nama=$row[26];

							echo"
							<fieldset style=\"font-family:courier;font-size:12px;background:#000;color:#0f0;\">
								Nomor: <b style=\"color:#ff0;font-size:12;\">$row[0]</b><br/>
								NoLama: <b style=\"color:#ff0;font-size:12;\">$row[1]</b><br/>
								Nama: <b style=\"color:#ff0;font-size:12;\">$row[2]</b><br/>
								Alamat: $row[3]<br/>
								Blok: $row[4] - $row[5]<br/>
								Wilayah: $row[6] - $row[7]<br/>
								Cabang: $row[8] - $row[9]<br/>
								Golongan: $row[10] - $row[11]<br/>
								Stat: $row[14] - $row[15]<br/>
								<b style=\"color:#ff0;font-size:16;\">Kond. Meter: $row[16]</b><br/>
								Tunggakan: <b style=\"color:#0ff;font-size:15;font-family:calibri;\">$row[19] Lembar - RP. $row[20]</b>
							</fieldset>
							";													
							}else{
								echo"<script type='text/javascript'>alert('Nomor tidak ditemukan pada data pelanggan Aktif!');</script>";
							}
						}
						?>
					</td>
				</tr>
<!--##########################################-->
				<tr><td colspan="3"><center style="font-size:13px;color:blue;font-style:italic;background:#ccccff;">Keterangan Meter Lama</center>
					<div style="border:2px solid #ccccff;">
					<table width="100%" border="0" style="font-face:arial;font-size:11px;">
					<tr>
						<td width="150px">Merk</td>
						<td>
							<select name="optmerk1" id="optmerk1" >                                       								
									<?php
									if($dapat && $merk>0){echo"<option value=\"$merk\" selected=\"selected\">$merk - $merk_nama</option>";}
									$sql=mysql_query("SELECT DISTINCT merk,nama FROM merk ORDER BY merk");
echo"<option value=\"-\">Tanpa Keterangan (NULL)</option>";									
while($row=mysql_fetch_row($sql)){
										echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
									}
#echo"<option value=\"-\">Tanpa Keteterangan</option>";								
									?>
							</select>
						</td>
					</tr>
					<tr><td>No. Seri</td><td><input type="textbox" name="txseri1" id="txseri1" size="15px" maxlength="12px" value="<?php if ($dapat && strlen($noseri)){echo"$noseri";}else{echo "0";} {
						# code...
					}?>" /></td></tr>
					<tr>
						<td>Diameter [inch]</td>
						<td>
							<select name="optmeter1" id="optmeter1" >                                       
								<!--option value="" selected="selected">--Pilih--</option-->
								<?php
								if($dapat && $diameter>0){echo"<option value=\"$diameter\" selected=\"selected\">$diameter_nama</option>";}
								$sql=mysql_query("SELECT DISTINCT kode,ukuran FROM meter ORDER BY kode");
echo"<option value=\"-\">NULL</option>";
								while($row=mysql_fetch_row($sql)){
									echo"<option value=". trim($row[0]).">".trim($row[1])."</option>";
								}
								?>
                            </select>
						</td>
					</tr>
					<tr><td>Angka Meter</td><td><input type="textbox" name="txangka1" id="txangka1" size="8px" maxlength="10px" onKeyPress="return isNumb(event);" style="text-align:right;" value="0" /></td></tr>
					</table>
					</div><!--br/-->
				</td></tr>
<!--##########################################-->				
				<tr><td colspan="3"><center style="font-size:13px;color:blue;font-style:italic;background:#ccccff;">Keterangan Meter Baru</center>
					<div style="border:2px solid #ccccff;">
					<table width="100%" border="0" style="font-face:arial;font-size:11px;">
					<tr>
						<td width="150px">Merk</td>
						<td>
							<select name="optmerk2" id="optmerk2" >                                       
								<!--option value="" selected="selected">--Pilih--</option-->
									<?php
									$sql=mysql_query("SELECT DISTINCT merk,nama FROM merk ORDER BY merk");
									while($row=mysql_fetch_row($sql)){
										echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
									}
									?>
							</select>
						</td>
					</tr>
					<tr><td>No. Seri</td><td><input type="textbox" name="txseri2" id="txseri2" size="15px" maxlength="12px" /></td></tr>
					<tr>
						<td>Diameter [inch]</td>
						<td>
							<select name="optmeter2" id="optmeter2" >                                       
								<!--option value="" selected="selected">--Pilih--</option-->
								<?php
								$sql=mysql_query("SELECT DISTINCT kode,ukuran FROM meter ORDER BY kode");
								while($row=mysql_fetch_row($sql)){
									echo"<option value=". trim($row[0]).">".trim($row[1])."</option>";
								}
								?>
                            </select>
						</td>
					</tr>
					<tr><td>Angka Meter</td><td><input type="textbox" name="txangka2" id="txangka2" size="8px" maxlength="10px" onKeyPress="return isNumb(event);" value="0" style="text-align:right;" /></td></tr>
<tr>
<td>Tgl. Pasang</td>
<td><input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="BUKANdatepicker"  /><i>format: YYYY-MM-DD</i></td>
</tr>
					</table>
					</div>
					<center style="text-align:left;font-size:9px;color:#aaaaaa;">Catatan&nbsp;:<br/>- Peng<i>input</i>an Keterangan Meter Lama dan Baru hanya bersifat <i>data history</i>, tidak akan mempengaruhi <i>input data</i> DSMP pembacaan meter saat ini;<br/>- Proses Meterisasi secara otomatis akan mengubah Data Kondisi Meter pelanggan menjadi Aktif [1].<center>
				</td>
                <?php
					if($focus==1){
						echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").focus();</script>";//sebelumnya optkwm
					}else{
						echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").focus();</script>";
					}
					?>
                
                
                
                
                
                </tr>				
<!--##########################################-->

<tr>
	<td>Sumber Ubah</td>
	<td colspan="2"><?php sumber_ubah();?></td>
</tr>	
				<tr height="50px">
					<td>&nbsp;</td>
					<td colspan="2" align="right">
						<input type="submit" value="Simpan" name="save" id="save" class="kelas_tombol"/>&nbsp;
						<input type="reset" value="Batal" class="kelas_tombol" />&nbsp;
					</td>
				</tr>
			</form>		
		</table>
		</div>		

		<!--######################################################################-->
		<?php			
			$tgl=date('Y-m-d');
			$jam=date('H:m:i');
			
			$snomor="";
			$kwm="";			
			$sumber="";			
			if(isset($_POST['save'])){
				if($_POST['txhdapat']=="1"){
					$snomor=trim($_POST['txhnomor']);
					$kwm=$_POST['txhstat'];
					$sumber=$_POST['txsumber'];
					
					$merk1=$_POST['optmerk1'];
					$merk2=$_POST['optmerk2'];
					$no1=$_POST['txseri1'];
					$no2=$_POST['txseri2'];
					$dia1=$_POST['optmeter1'];
					$dia2=$_POST['optmeter2'];
					$angka1=$_POST['txangka1'];
					$angka2=$_POST['txangka2'];
					$tgl_pasang=$_POST['txtawal'];
					echo"<script type=\"text/javascript\">document.getElementById('txhtawal').value=\"$tgl_pasang\";</script>";
					
					$sql="UPDATE master SET kondisi_meter='1',merk='$merk2',nometer='$no2',ukuran='$dia2' WHERE nomor='$snomor' ;";
					mysql_query($sql)or die(mysql_error());
					
					$sql="
					INSERT INTO ubah_meter(nomor, tgl, jam, nometer1, nometer2, merk1, merk2, ukuran1, ukuran2, angka1, angka2, operator, loket,tgl_pasang,sumber)
					VALUES('$snomor','$tgl','$jam','$no1','$no2','$merk1','$merk2','$dia1','$dia2',$angka1,$angka2,'$operator','$nloket','$tgl_pasang','$sumber')
					ON DUPLICATE KEY UPDATE nometer1='$no1',nometer2='$no2',merk1='$merk1',merk2='$merk2',ukuran1='$dia1',ukuran2='$dia2',angka1=$angka1,angka2=$angka2,jam='$jam',operator='$operator',loket='$nloket',tgl_pasang='$tgl_pasang'
					;";
					mysql_query($sql)or die(mysql_error());
					
					if($kwm<>'1'){
						$sql99="
						INSERT INTO ubah_kwm(nomor,tgl,jam,lama,baru,operator,loket,sumber)
						VALUES('$snomor','$tgl','$jam','$kwm','1','$operator','$nloket','$sumber')
						ON DUPLICATE KEY UPDATE baru='1',jam='$jam',operator='$operator',loket='$nloket',sumber='$sumber'
						;";
						mysql_query($sql99)or die(mysql_error());
					}
				}
				echo"<script type=\"text/javascript\">alert('Proses Meterisasi berhasil!');</script>";				
			}
		?>
		<!--######################################################################-->
			</td>
	</tr>

<?php
putus();
require_once("foot.php");
?>
