<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");
//file ubah_blok.php
$nloket="JPR";
$operator=$_SESSION['nama_user'];
kunci_halaman("ubah_blok",$secret,$operator);
?>

<tr>
	<td>
	<br/>
		
		<div class="wrapper">
			
		<table background="img/grids.gif" width="500px" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="return suvalid(this);">
				<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
				  <td colspan="3"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>Perubahan Kode Blok Pelanggan</b></font></center></td>
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
							SELECT m.nomor, m.nolama, m.nama, m.alamat, m.kode_blok, b.ket_blok, m.kode_wilayah, w.nama_wilayah, m.cabang, c.nama, m.gol, g.keterangan, m.jenis_pel, m.online, m.putus, m.kondisi_meter, m.tglstart, m.tgl_input
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
							echo"<script type=\"text/javascript\">document.getElementById(\"txhlama\").value=\"$row[4]\";</script>";
							
							echo"
							<fieldset style=\"font-family:courier;font-size:12px;background:#000;color:#0f0;\">
								<b style=\"color:#ff0;font-size:16px;\">Nomor: $row[0]<br/>
								NoLama: $row[1] (No ID Pel)</b><br/>
								Nama: $row[2]<br/>
								Alamat: $row[3]<br/>
								<b style=\"color:#ff0;font-size:15px;\">Blok: $row[4] - $row[5]</b><br/>
								Wilayah: $row[6] - $row[7]<br/>
								Cabang: $row[8] - $row[9]<br/>
								Golongan: $row[10] - $row[11]<br/>
							</fieldset>
							";
							
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Kode Blok Baru</td>
					<td colspan="2"><!--input type="text" name="txnama" id="txnama" size="45" /-->
<select id="txnama" name="txnama">
<?php
if($focus==1){
$qry=mysql_query("SELECT * FROM master_blok WHERE kode_cabang='$row[8]' ORDER BY kode_blok ASC;")or die(mysql_error());
while($b=mysql_fetch_array($qry)){
echo"<option value=\"$b[kode_blok]\">$b[kode_blok] - $b[ket_blok]</option>\n";
}
}
?>
</select>
</td>
					<?php
					if($focus==1){
						echo"<script type=\"text/javascript\">document.getElementById(\"txnama\").focus();</script>";
					}else{
						echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").focus();</script>";
					}
					?>
				</tr>
<tr>
	<td>Sumber Perubahan</td>
	<td><?php sumber_ubah();?></td>
</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2">
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
				$snama=trim($_POST['txnama']);
				$slama=trim($_POST['txhlama']);
				$sumber=trim($_POST['txsumber']);
				
#echo $snomor."<br/>";
#echo $snama."<br/>";
#echo $slama;
				if($snomor!='' && $snama!=''){
				
				$q1="
				UPDATE master
				SET kode_blok='$snama', nu='$tgl'
				WHERE nomor='$snomor'
				;";
				mysql_query($q1)or die(mysql_error());
				
				$q2="
				INSERT INTO ubah_blok(nomor,tgl,jam,lama,baru,operator,loket,sumber)
				VALUES('$snomor','$tgl','$jam','$slama','$snama','$operator','$nloket','$sumber')
				ON DUPLICATE KEY UPDATE baru='$snama',jam='$jam',operator='$operator',loket='$nloket',sumber='$sumber'
				;";
				mysql_query($q2)or die(mysql_error());
#echo $q2;
				
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
