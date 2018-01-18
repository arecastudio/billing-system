<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");

$nloket="JPR";
$operator=$_SESSION['nama_user'];
kunci_halaman("ubah_gol",$secret,$operator);
?>

<tr>
	<td>
	<br/>
		
		<div class="wrapper">
			
		<table background="img/grids.gif" width="550px" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="return suvalid(this);">
				<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
				  <td colspan="3"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>Perubahan Golongan Tarif</b></font></center></td>
				</tr>
				<tr>
					<td width="110px">Nomor / NoLama</td>
						<input type="hidden" name="txhnomor" id="txhnomor" />
						<input type="hidden" name="txhlama" id="txhlama" />
						<input type="hidden" name="txhgolawal" id="txhgolawal" />
						<input type="hidden" name="txhnolaawal" id="txhnolaawal" />
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
							SELECT m.nomor, m.nolama, m.nama, m.alamat, m.kode_blok, b.ket_blok, m.kode_wilayah, w.nama_wilayah, m.cabang, c.nama, m.gol, g.keterangan, m.jenis_pel, m.online, m.putus, m.kondisi_meter, m.tglstart, m.tgl_input
							FROM master AS m
							LEFT OUTER JOIN cabang AS c ON c.cabang=m.cabang
							LEFT OUTER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah AND w.kode_cabang=m.cabang
							LEFT OUTER JOIN master_blok AS b ON b.kode_blok=m.kode_blok
							LEFT OUTER JOIN tarif AS g ON g.gol=m.gol
							WHERE m.nomor='$nmr' OR m.nolama='$nmr' AND m.putus='0'
							LIMIT 1
							;";
							
							$qry=mysql_query($sql)or die(mysql_error());
							if($row=mysql_fetch_row($qry)){
							
							$focus=1;$dapat=1;
							echo"<script type=\"text/javascript\">document.getElementById(\"txhnomor\").value=\"$row[0]\";</script>";
							//echo"<script type=\"text/javascript\">document.getElementById(\"txhlama\").value=\"$row[2]\";</script>";
							
							echo"
							<fieldset style=\"font-family:courier;font-size:12px;background:#000;color:#0f0;\">
								Nomor: $row[0]<br/>
								NoLama: <b style=\"color:#f00;font-size:16;\">$row[1]</b><br/>
								Nama: $row[2]<br/>
								Alamat: $row[3]<br/>
								Blok: $row[4] - $row[5]<br/>
								Wilayah: $row[6] - $row[7]<br/>
								Cabang: $row[8] - $row[9]<br/>
								<b style=\"color:#f00;font-size:16;\">Golongan: $row[10] - $row[11]</b>
							</fieldset>
							";
							
							$nolama=trim($row[1]);
							$nola=substr($nolama,0,strlen($nola)-2);
							//echo "<b style=\"color:#f00;\">$nola</b>";
							echo"<script type=\"text/javascript\">document.getElementById(\"txhlama\").value=\"$nola\";</script>";
							
							echo"<script type=\"text/javascript\">document.getElementById(\"txhgolawal\").value=\"$row[10]\";</script>";							
							echo"<script type=\"text/javascript\">document.getElementById(\"txhnolaawal\").value=\"$row[1]\";</script>";							
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Ubah Golongan</td>
					<td colspan="2"><input type="hidden" id="txhnola" name="txhnola">
						<?php
						echo"<input type=\"radio\" name=\"r1\" id=\"r1\" value=\"auto\"> Automatic<br/>";
						if($dapat==1){
							echo"<b style=\"color:#00f;\">$nola</b>-";
							echo"<script language=\"javascript\"></script>";
						}
						?>
						<br/><br/>
						<select name="optgol1" id="optgol1" style=\"font-weight:bold;color:#00f;background-color:#fff;\">
							<!--option value="" selected="selected">--Pilih--</option-->
							<?php
								$sql=mysql_query("SELECT DISTINCT kode,gol,keterangan FROM golongan WHERE kode<>'00' ORDER BY kode ASC;");
								while($row=mysql_fetch_row($sql)){
									echo"<option value=".trim($row[0])."-".trim($row[1]).">".trim($row[0])."&nbsp;&nbsp;&nbsp;&nbsp;[ ".trim($row[1])." - ".trim($row[2])." ]</option>";
								}
							?>
						</select>
						<br/><br/><br/><br/>
						<?php
						echo"<input type=\"radio\" name=\"r1\" id=\"r2\" value=\"manu\" checked> Manual <!--i style=\"color:#f00;\">[khusus pel. UPP Genyem atau Gol A5 - Rmh Tgg TNI dll]</i--><br/>";
						?>
						<br/><br/>
						<select name="optgol2" id="optgol2" style=\"font-weight:bold;color:#00f;background-color:#fff;\">
							<!--option value="" selected="selected">--Pilih--</option-->
							<?php
								$sql=mysql_query("SELECT DISTINCT gol,keterangan,kode FROM golongan WHERE kode<>'00' ORDER BY kode ASC;");
								while($row=mysql_fetch_row($sql)){
									echo"<option value=". trim($row[0]).">"."[".trim($row[2])."] ".trim($row[0])." - ".trim($row[1])."</option>";
								}
							?>
						</select>
						<br/><br/>
						<input type="text" name="txnolama" id="txnolama" size="45" value="<?php if($dapat==1)echo "";?>" />
					</td>
					<?php
					if($focus==1){
						echo"<script type=\"text/javascript\">document.getElementById(\"txnolama\").focus();</script>";
					}else{
						echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").focus();</script>";
					}
					
					if($dapat==1){
						echo"<script type=\"text/javascript\">document.getElementById(\"nola\").value=".$nola.";</script>";
					}
					
					?>
				</tr>
<tr>
	<td>Sumber Ubah</td>
	<td><?php sumber_ubah();?></td>
</tr>
				<tr height="100px">
					<td colspan="3" style="padding:10px;text-align:center;">
						<input type="submit" value="Simpan" name="save" id="save" class="kelas_tombol"/>
						&nbsp;
						&nbsp;
						&nbsp;
						&nbsp;
						&nbsp;
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
			
			$snomor="";
			$kode="";
			$gol="";
			$golawal="";
			$slama="";
			$nolaawal="";
			$sumber="";
			
			if(isset($_POST['save'])){
				if($_POST['r1']=='auto'){
					$snomor=trim($_POST['txhnomor']);
					$kode=substr(trim($_POST['optgol1']),0,2);
					$gol=substr(trim($_POST['optgol1']),3,2);
					$slama=trim($_POST['txhlama']);
					$golawal=trim($_POST['txhgolawal']);
					$nolaawal=trim($_POST['txhnolaawal']);
					$sumber=trim($_POST['txsumber']);
					$sql="UPDATE master SET gol='$gol', nolama='".$slama.$kode."' WHERE nomor='$snomor' ;";
					mysql_query($sql)or die(mysql_error());
					//echo"nomor: $snomor \n nolama: $slama - $kode \n gol: $gol";
					$sql="INSERT INTO ubah_gol(nomor,tgl,jam,nola1,nola2,gol1,gol2,operator,loket,sumber)
					VALUES('$snomor','$tgl','$jam','$nolaawal','".$slama.$kode."','$golawal','$gol','$operator','$nloket','$sumber')
					ON DUPLICATE KEY UPDATE jam='$jam',tgl='$tgl',nola1='$nolaawal',nola2='".$slama.$kode."',gol1='$golawal',gol2='$gol',operator='$operator',loket='$nloket',sumber='$sumber'
					;";
					mysql_query($sql)or die(mysql_error());
				}elseif($_POST['r1']=='manu'){
					$snomor=trim($_POST['txhnomor']);
					$gol=trim($_POST['optgol2']);
					$slama=trim($_POST['txnolama']);
					$golawal=trim($_POST['txhgolawal']);
					$nolaawal=trim($_POST['txhnolaawal']);
					$sumber=trim($_POST['txsumber']);
					$sql="UPDATE master SET gol='$gol', nolama='$slama' WHERE nomor='$snomor' ;";
					mysql_query($sql)or die(mysql_error());
					//echo"nomor: $snomor \n nolama: $slama \n gol: $gol";
					$sql="INSERT INTO ubah_gol(nomor,tgl,jam,nola1,nola2,gol1,gol2,operator,loket,sumber)
					VALUES('$snomor','$tgl','$jam','$nolaawal','$slama','$golawal','$gol','$operator','$nloket','$sumber')
					ON DUPLICATE KEY UPDATE jam='$jam',tgl='$tgl',nola2='$slama',gol1='$golawal',gol2='$gol',operator='$operator',loket='$nloket',sumber='$sumber'
					;";
					mysql_query($sql)or die(mysql_error());
				}
				echo"<script type=\"text/javascript\">alert('Perubahan Golongan Tarif berhasil!');</script>";				
			}
		?>
		<!--######################################################################-->
		
		
	
	
	</td>
</tr>

<?php
putus();
require_once("foot.php");
?>
