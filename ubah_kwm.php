<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");

$nloket="JPR";
$operator=$_SESSION['nama_user'];
kunci_halaman("ubah_kwm",$secret,$operator);
?>

<tr>
	<td>
	<br/>
		
		<div class="wrapper">
			
		<table background="img/grids.gif" width="500px" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="return suvalid(this);">
				<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
				  <td colspan="3"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;"><b>Perubahan Kondisi Water Meter (<i>status meter</i>)</b></font></center></td>
				</tr>
				<tr>
					<td width="110px">Nomor / NoLama</td>
						<input type="hidden" name="txhnomor" id="txhnomor" />
						<input type="hidden" name="txhlama" id="txhlama" />
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
						$focus=0;
						if(isset($_POST['cari']) && $_POST['txnomor']!=''){
							$nmr=$_POST['txnomor'];
							echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").value=\"$nmr\";</script>";
							
							$sql="
							SELECT m.nomor, m.nolama, m.nama, m.alamat, m.kode_blok, b.ket_blok, m.kode_wilayah, w.nama_wilayah, m.cabang, c.nama, m.gol, g.keterangan, m.jenis_pel, m.online, m.putus, m.kondisi_meter, m.tglstart, m.tgl_input,
							(SELECT FORMAT(COUNT(r.nomor),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001)
					,(SELECT IFNULL(FORMAT(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001)
					,(SELECT FORMAT(COUNT(r.nomor),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=1 AND r.periode>=200001)
					,(SELECT IFNULL(FORMAT(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=1 AND r.periode>=200001),IFNULL((select ub.tgl from ubah_kwm as ub where ub.nomor=m.nomor order by ub.tgl DESC limit 1 ),'Belum Ada'),IFNULL((select ub.sumber from ubah_kwm as ub where ub.nomor=m.nomor order by ub.tgl DESC limit 1 ),'Belum Ada')
							FROM master AS m
							LEFT OUTER JOIN cabang AS c ON c.cabang=m.cabang
							LEFT OUTER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah AND w.kode_cabang=m.cabang
							LEFT OUTER JOIN master_blok AS b ON b.kode_blok=m.kode_blok
							LEFT OUTER JOIN tarif AS g ON g.gol=m.gol
							WHERE (m.nomor='$nmr' OR m.nolama='$nmr') AND m.putus='0'
							LIMIT 1
							;";
							
							$qry=mysql_query($sql)or die(mysql_error());
							if($row=mysql_fetch_row($qry)){
							
							$focus=1;
							echo"<script type=\"text/javascript\">document.getElementById(\"txhnomor\").value=\"$row[0]\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"txhlama\").value=\"$row[15]\";</script>";
							
							echo"
							<fieldset style=\"font-family:courier;font-size:12px;background:#000;color:#0f0;\">
								Nomor	: $row[0]<br/>
								NoLama	: $row[1]<br/>
								<b style=\"color:#f00;font-size:16;\">Nama	: $row[2]</b><br/>
								Alamat	: $row[3]<br/>
								Blok	: $row[4] - $row[5]<br/>
								Wilayah	: $row[6] - $row[7]<br/>
								Cabang	: $row[8] - $row[9]<br/>
								Golongan: $row[10] - $row[11]<br/>
								<b style=\"color:#ff0;font-size:14;\">Tanggal Perubahan : $row[22]</b> <br>
								<b style=\"color:#ff0;font-size:14;\">Sumber Perubahan : $row[23]</b> <br>
								<b style=\"color:#ff0;font-size:16;\">Kond. Meter:</b><b style=\"color:#f00;font-size:20px;\"> $row[15]</b><br/>
								<span style=\"color:#ff0;font-size:14;\">Jml Tunggak:&nbsp;&nbsp;$row[18] lembar.&nbsp;&nbsp;Rp. $row[19]</span>
								
								
							</fieldset>
							";
							
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td>KWM Baru</td>
					<td colspan="2"><!--input type="text" name="txnama" id="txnama" size="45" /-->
<select name="optkwm" id="optkwm">
	<option value="1">[1] Aktif</option>
	<option value="2">[2] Segel</option>
	<option value="3">[3] Rusak</option>
	<option value="4">[4] Non-Meter</option>
</select>
</td>
					<?php
					if($focus==1){
						echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").focus();</script>";//sebelumnya optkwm
					}else{
						echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").focus();</script>";
					}
					?>
				</tr>
				<tr>
					<td>Sumber Ubah</td>
					<td colspan="2"><?php sumber_ubah();?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input style="margin-top:5px;" type="text" name="txno_kwitansi" id="txno_kwitansi" size="10" maxlength="10" placeholder="No. Kwitansi"/>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2" align="right">
						<input type="submit" value="Simpan" name="save" id="save" class="kelas_tombol"/>
						<input type="reset" value="Batal" class="kelas_tombol" />
					</td>
				</tr>
			</form>		
		</table>
		</div>		

		<!--######################################################################-->
		<?php			
			$tgl=date('Y-m-d');
			$jam=date('H:m:i');
			if(isset($_POST['save'])){
				
				$snomor=trim($_POST['txhnomor']);
				$skwm=$_POST['optkwm'];
				$slama=trim($_POST['txhlama']);
				$sumber=trim($_POST['txsumber']);
				$nokwi=trim($_POST['txno_kwitansi']);
				
				if($snomor!='' && $skwm!=''){
				
					$q188="
					UPDATE master
					SET kondisi_meter='$skwm', nu='$tgl'
					WHERE nomor='$snomor'
					;";
					mysql_query($q188)or die(mysql_error());
					
					$sql99="
					INSERT INTO ubah_kwm(nomor,tgl,jam,lama,baru,operator,loket,sumber,no_kwitansi)
					VALUES('$snomor','$tgl','$jam','$slama','$skwm','$operator','$nloket','$sumber','$nokwi')
					ON DUPLICATE KEY UPDATE baru='$skwm',jam='$jam',operator='$operator',loket='$nloket',sumber='$sumber',no_kwitansi='$nokwi'
					;";
					mysql_query($sql99)or die(mysql_error());
				
				}
			}
		?>
		<!--######################################################################-->
		
		
	
	
	</td>
</tr>

<?php
putus();
require_once("foot.php");
?>
