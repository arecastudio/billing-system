<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");

$nloket="JPR";
$operator=$_SESSION['nama_user'];
kunci_halaman("ubah_stat",$secret,$operator);
?>

<tr>
	<td>
	<br/>
		
		<div class="wrapper">
			
		<table background="img/grids.gif" width="550px" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="return suvalid(this);">
				<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
				  <td colspan="3"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>Hapus Pelanggan</b></font></center></td>
				</tr>
				<tr>
					<td width="110px">Nomor / NoLama</td>
						<input type="hidden" name="txhnomor" id="txhnomor" />
						<input type="hidden" name="txhstat" id="txhstat" />
						<input type="hidden" name="txhdapat" id="txhdapat" value="0" />
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
						if(isset($_POST['cari']) && $_POST['txnomor']!=''){
							$nmr=$_POST['txnomor'];
							echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").value=\"$nmr\";</script>";
							
							$sql="
							SELECT m.nomor, m.nolama, m.nama, m.alamat, m.kode_blok, b.ket_blok, m.kode_wilayah, w.nama_wilayah, m.cabang, c.nama, m.gol, g.keterangan, m.jenis_pel, m.online, m.putus,(IF(m.putus='0','AKTIF',IF(m.putus='2','SEGEL',IF(m.putus='3','PUTUS','HAPUS'))))as st_putus, m.kondisi_meter, m.tglstart, m.tgl_input
							,(SELECT FORMAT(COUNT(r.nomor),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001) as lembar
							,(SELECT IFNULL(FORMAT(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001) as total							
							FROM master AS m
							LEFT OUTER JOIN cabang AS c ON c.cabang=m.cabang
							LEFT OUTER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah AND w.kode_cabang=m.cabang
							LEFT OUTER JOIN master_blok AS b ON b.kode_blok=m.kode_blok
							LEFT OUTER JOIN tarif AS g ON g.gol=m.gol
							WHERE m.nomor='$nmr' OR m.nolama='$nmr'
							LIMIT 1
							;";
							
							$qry=mysql_query($sql)or die(mysql_error());
							if($row=mysql_fetch_row($qry)){
							
							$focus=1;$dapat=1;
							echo"<script type=\"text/javascript\">document.getElementById(\"txhnomor\").value=\"$row[0]\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"txhstat\").value=\"$row[14]\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"txhdapat\").value=\"1\";</script>";
							
							echo"
							<fieldset style=\"font-family:courier;font-size:12px;background:#000;color:#0f0;\">
								Nomor: $row[0]<br/>
								NoLama: <b style=\"color:#ff0;font-size:16;\">$row[1]</b><br/>
								Nama: $row[2]<br/>
								Alamat: $row[3]<br/>
								Blok: $row[4] - $row[5]<br/>
								Wilayah: $row[6] - $row[7]<br/>
								Cabang: $row[8] - $row[9]<br/>
								Golongan: $row[10] - $row[11]<br/>
								<b style=\"color:#ff0;font-size:16;\">Stat: $row[14] - $row[15]</b><br/>
								Tunggakan: <b style=\"color:#0ff;font-size:15;font-family:calibri;\">$row[19] Lembar - RP. $row[20]</b>
							</fieldset>
							";													
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Aksi >></td>
					<td colspan="2">
						<select name="opt_stat" ide="opt_stat" style="color:#f00;background:linear-gradient(#fff,#888);font-weight:bold;">
							<!--option value="0">[0] AKTIF</option>
							<option value="2"></option>
							<option value="3">[3] PUTUS</option-->
							<option value="5">HAPUS</option>
						</select>
					</td>
					<?php
					if($focus==1){
						echo"<script type=\"text/javascript\">document.getElementById(\"txnolama\").focus();</script>";
					}else{
						echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").focus();</script>";
					}					
					?>
				</tr>
<tr>
	<td>Sumber Ubah</td>
	<td><?php sumber_ubah();?></td>
</tr>
				<tr height="50px">
					<td>&nbsp;</td>
					<td colspan="2" align="right">
						<input type="submit" value="Hapus" name="save" id="save" class="kelas_tombol"/>&nbsp;
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
			$stat_lama="";
			$stat_baru="";
			$sumber="";
			
			if(isset($_POST['save'])){
				if($_POST['txhdapat']=="1"){
					$snomor=trim($_POST['txhnomor']);
					$stat_lama=$_POST['txhstat'];
					$stat_baru=$_POST['opt_stat'];
					$sumber=$_POST['txsumber'];
					$sql="UPDATE master SET putus='$stat_baru' WHERE nomor='$snomor' ;";
					mysql_query($sql)or die(mysql_error());
					//echo"nomor: $snomor \n nolama: $slama - $kode \n gol: $gol";
					$sql="
					INSERT INTO ubah_stat(nomor,tgl,jam,lama,baru,operator,loket,sumber)
					VALUES('$snomor','$tgl','$jam','$stat_lama','$stat_baru','$operator','$nloket','$sumber')
					ON DUPLICATE KEY UPDATE baru='$stat_baru',jam='$jam',operator='$operator',loket='$nloket',sumber='$sumber'
					;";
					mysql_query($sql)or die(mysql_error());

					$sql="UPDATE master SET nu=CURRENT_DATE(),nomor_lama=CURRENT_TIMESTAMP() WHERE nomor='$snomor';;";
					mysql_query($sql)or die(mysql_error());

					$sql="INSERT IGNORE INTO hapus_master SELECT * FROM master WHERE nomor='$snomor';";
					mysql_query($sql)or die(mysql_error());

					$sql="DELETE FROM master WHERE nomor='$snomor';";
					mysql_query($sql)or die(mysql_error());

					$sql="INSERT IGNORE INTO hapus_rekening1 SELECT * FROM rekening1 WHERE nomor='$snomor';";
					mysql_query($sql)or die(mysql_error());

					$sql="DELETE FROM rekening1 WHERE nomor='$snomor';";
					mysql_query($sql)or die(mysql_error());

					$sql="INSERT IGNORE INTO hapus_transaksi SELECT * FROM transaksi WHERE nomor='$snomor';";
					mysql_query($sql)or die(mysql_error());


				}
				echo"<script type=\"text/javascript\">alert(\"Hapus Data Pelanggan berhasil\");</script>";				
			}
		?>
		<!--######################################################################-->
	</td>
</tr>

<?php
putus();
require_once("foot.php");
?>
