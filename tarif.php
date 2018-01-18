<?php 
ob_start();
session_start();
require_once("mydb.php");
require_once("global_functions.php");
//==================================================================================================


//==================================================================================================
require_once("head.php");
//echo substr("rail",2,2);
?>

	<tr>
		<td>
			<div align="center" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;"><b>TARIF GOLONGAN PELANGGAN - UMUM</b></div>
			
			<div class="wrapper">
			<form id="frcust" method="post" action="" class="cmxform1">
			<table border="0" align="center" cellpadding="0" cellspacing="2" class="wrapper1" bgcolor="#ffffff" width="420px">
				<tr>
					<td width="100">Tgl SK</td>
					<td colspan="5"><input type="text" id="txtglsk" name="txtglsk" value="" size="10" maxlength="10" class="datepicker" required />&nbsp;<b style="color:red;">YYYY-MM-DD</b></td>					
				</tr>
				<tr>
					<td>No. SK</td>
					<td colspan="5"><input type="text" id="txnosk" name="txnosk" value="" size="41"  /></td>					
				</tr>
				<tr>
					<td>Berlaku dari bulan</td>
					<td colspan="5"><input type="text" id="txperiode" name="txperiode" value="" size="7" maxlength="6" required onKeyPress="return isNumb(event);" />&nbsp;<b style="color:red;">YYYYMM</b></td>					
				</tr>
				<tr>
					<td>Golongan</td>
					<td colspan="2"><input type="text" id="txgol" name="txgol" value="" size="3" maxlength="2" required /></td>
					<td>Gol. yg ada</td>
					<td colspan="2">
						<select name="opgol" onChange="tampilkan(this.value);">
							<option value="">-Pilih-</option>
							<?php
							$sql=mysql_query("select gol,periode,tgl_sk,no_sk,keterangan as ket_1,tarip1,tarip2,tarip3,tarip4 from tarif order by gol asc,periode desc");
							$jsArray = "var Tarif = new Array();\n"; 
							while($row=mysql_fetch_array($sql)){
								echo"<option value=\"$row[0]$row[1]\">$row[0] - $row[1]</option>";
								$jsArray .= "Tarif['".$row[0]."','".$row[1]."'] = {tglsk:'" . addslashes($row['tgl_sk']) . "',nosk:'".addslashes($row['no_sk'])."',ket1:'".addslashes($row['ket_1'])."',rp1:'".addslashes($row['tarip1'])."',rp2:'".addslashes($row['tarip2'])."',rp3:'".addslashes($row['tarip3'])."'};\n";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td colspan="5"><input type="text" id="txket" name="txtgl" value="" size="41"  /></td>					
				</tr>
				<tr>
					<td>Tarif 1</td>					
					<td><input type="text" name="txtarif1" value="0" style="text-align:right;" size="5" onKeyPress="return isNumb(event);" required /></td>
					<td width="30px">s/d</td>
					<td><input type="text" name="txkubik1" value="0" style="text-align:right;" size="5" onKeyPress="return isNumb(event);" required />M<sup>3</sup></td>
					<td align="right">Rp.</td>
					<td><input type="text" id="txrp1" name="txrp1" value="0" style="text-align:right;" size="5" onKeyPress="return isNumb(event);" required /></td>
				</tr>
				<tr>
					<td>Tarif 2</td>					
					<td><input type="text" name="txtarif2" value="0" style="text-align:right;" size="5" onKeyPress="return isNumb(event);" required /></td>
					<td>s/d</td>
					<td><input type="text" name="txkubik2" value="0" style="text-align:right;" size="5" onKeyPress="return isNumb(event);" required />M<sup>3</sup></td>
					<td align="right">Rp.</td>
					<td><input type="text" id="txrp2" name="txrp2" value="0" style="text-align:right;" size="5" onKeyPress="return isNumb(event);" required /></td>
				</tr>
				<tr>
					<td>Tarif 3</td>					
					<td><input type="text" name="txtarif3" value="0" style="text-align:right;" size="5" onKeyPress="return isNumb(event);" required /></td>
					<td>s/d</td>
					<td><input type="text" name="txkubik3" value="0"  style="text-align:right;"size="5" onKeyPress="return isNumb(event);" required />M<sup>3</sup></td>
					<td align="right">Rp.</td>
					<td><input type="text" id="txrp3" name="txrp3" value="0" style="text-align:right;" size="5" onKeyPress="return isNumb(event);" required /></td>
				</tr>
				<tr>
					<td>Tarif 4></td>					
					<td><input type="text" name="txkubik4" value="0" size="5" style="text-align:right;" onKeyPress="return isNumb(event);" required />M<sup>3</sup></td>
					<!--td colspan="2">&nbsp;</td-->
					<td align="right" colspan="3">Rp.</td>
					<td><input type="text" id="txrp4" name="txrp4" value="0" size="5" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
				</tr>
				<tr>					
					<td colspan="6">
						<table bgcolor="" cellpadding="0" cellspacing="2" width="100%" border="0" style="font-family:'Trebuchet MS', sans-serif;font-size:11px;">
							<tr>
								<td align="center" width="50%" colspan="2"><u><b>Biaya</b></u></td>
								<td align="center" width="50%" colspan="2"><u><b>Denda</b></u></td>
							</tr>
							<tr>
								<td width="120">Administrasi</td>
								<td><input type="text" name="txadmin" value="0" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
								<td align="right" width="70"><input type="radio" name="r1"></td>
								<td>Denda Flat</td>
							</tr>
							<tr>
								<td>Pemeliharaan Meter</td>
								<td><input type="text" name="txmainten" value="0" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
								<td align="right"><input type="radio" name="r1" value="1"></td>
								<td>Denda Akumulasi</td>
							</tr>
							<tr>
								<td>Pasang Baru</td>
								<td><input type="text" name="txpbaru" value="0" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
								<td align="right"><input type="radio" name="r1" value="2"></td>
								<td>Denda Berlipat</td>
							</tr>
							<tr>
								<td>Jaminan</td>
								<td><input type="text" name="txjamin" value="0" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
								<td align="right"><input type="radio" name="r1" value="3"></td>
								<td>Non Denda</td>
							</tr>
							<tr>
								<td>Pendaftaran</td>
								<td><input type="text" name="txreg" value="0" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
								<td align="right">Denda I</td>
								<td><input type="text" name="txdenda1" value="0" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
							</tr>
							<tr>
								<td>Balik Nama</td>
								<td><input type="text" name="txrename" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
								<td align="right">Denda II</td>
								<td><input type="text" name="txdenda2" value="0" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
							</tr>
							<tr>
								<td>Ganti Water Meter</td>
								<td><input type="text" name="txgantiwm" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
								<td align="right">Denda III</td>
								<td><input type="text" name="txdenda3" value="0" size="10" style="text-align:right;" onKeyPress="return isNumb(event);" required /></td>
							</tr>
						</table>
					</td>					
				</tr>
				<tr>					
					<td colspan="6">
						<table cellpadding="0" cellspacing="2" width="100%" border="0" style="font-family:'Trebuchet MS', sans-serif;font-size:11px;">
							<tr>
								<td colspan="2" align="center" width="100%"><u><b>Simulasi</b></u></td>
							</tr>
							<tr>								
								<td align="center" width="50%">Perkiraan Pemakaian Terendah</td>
								<td><input type="text" size="5" style="text-align:right;" name="txsim1" value="0" onKeyPress="return isNumb(event);" />&nbsp;M<sup>3</sup></td>
							</tr>
							<tr>								
								<td align="center" width="50%">Perkiraan Pemakaian Tertinggi</td>
								<td><input type="text" size="5" style="text-align:right;" name="txsim2" value="0" onKeyPress="return isNumb(event);" />&nbsp;M<sup>3</sup></td>
							</tr>
							<tr>								
								<td align="center" width="50%">Pemakaian Minimum</td>
								<td><input type="text" size="5" style="text-align:right;" name="txsim3" value="0" onKeyPress="return isNumb(event);" />&nbsp;M<sup>3</sup></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>					
					<td colspan="6" align="center" width="100%">
						<input type="submit" value="Simpan">
						<input type="reset" value="Batal">
						<input type="button" value="Lihat">
					</td>
				</tr>
			</table>
			</form>
			</div>
		</td>
	</tr>

<script type="text/javascript">
	<?php echo $jsArray; ?>
	function tampilkan(id){	
		//var gol="'"+ id.substring(0,2) +"'",
		//	prd="'"+ id.substring(2,8) +"'";
		//var vtglsk= Tarif[id.substring(0,2),id.substring(2,8)].tglsk,
		//	vnosk= Tarif[id.substring(0,2),id.substring(2,8)].nosk;
			
		document.getElementById('txtglsk').value = Tarif[id.substring(0,2),id.substring(2,8)].tglsk;
		document.getElementById('txnosk').value = Tarif[id.substring(0,2),id.substring(2,8)].nosk;
		document.getElementById('txgol').value = id.substring(0,2);
		document.getElementById('txperiode').value = id.substring(2,8);
		document.getElementById('txket').value = Tarif[id.substring(0,2),id.substring(2,8)].ket1;
		document.getElementById('txrp1').value = Tarif[id.substring(0,2),id.substring(2,8)].rp1;
		document.getElementById('txrp2').value = Tarif[id.substring(0,2),id.substring(2,8)].rp2;
		document.getElementById('txrp3').value = Tarif[id.substring(0,2),id.substring(2,8)].rp3;
		//alert(id.substring(0,2));
	}
</script>
	
<?php
require_once("foot.php");
?>