<?php

require_once("mydb.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");
?>

	<tr>
		<td>
		
		<table width="800px" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr align="center" bgcolor="white">
				<td width="50%"><a href="custcredit.php">TUNGGAKAN PELANGGAN</a></td>
				<td width="50%"><a href="custinfo.php">CETAK DATA MASTER PELANGGAN</a></td>
			</tr>			
		</table>
		<div align="center" style="padding:5px 0;text-shadow:4px -4px 6px red;color:yellow;font-size:25px;"><b>CETAK DATA MASTER PELANGGAN</b></div>
		<form id="fcustinf" action="" method="post">
		<table width="900px" border="1" cellpadding="0" cellspacing="0" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:11px;">
			<tr>
				<td width="150px"><input type="radio" name="r1" value="all" checked="checked">&nbsp;Semua Pelanggan</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			
			<tr>
				<td><input type="checkbox" name="chtgl">Tanggal Pasang</td>
				<td>
					<input type="text" size="11" maxlength="10" name="txtawal" class="datepicker"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" class="datepicker"  />
					&nbsp;&nbsp;<i>Format(YYYY-MM-DD)</i>
				</td>
				<td></td>
				<td></td>
			</tr>
			
			<tr>
				<td><input type="checkbox" name="chbranch">Cabang [UPP]</td>
				<td>
					<select name="optcabang" id="optcabang" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select cabang,nama from cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
				<td>
					<input type="checkbox" name="chjpel" />Jns Pelanggan					
				</td>
				<td>
					<select name="optjpel">
						<option value="">-Pilih-</option>
						<?php
						$sql=mysql_query("select kode_jenis_pel,ket_jenis_pel from pel_jenis");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>
				</td>
			</tr>
			
			<tr>
			  <td><input type="checkbox" name="charea" />
		      Wilayah</td>
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
				<td>
					<input type="checkbox" name="chkwm" />Kondisi WM					
				</td>
				<td>
					<select name="optkwm">
						<option value="">-Pilih-</option>
						<?php
						$sql=mysql_query("select kode_kondisi,ket_kondisi from meter_kondisi");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><input type="checkbox" name="chblok">Blok</td>
				<td>
					<select name="optblok" id="optblok">
						<option value="" selected="selected">--Pilih Blok--</option>
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("select * from master_blok order by kode_blok");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_blok]\">$p[ket_blok]</option>\n";
						}
						?>
					</select>				</td>
				<td colspan="2" align="center"><i><b>Rekap Berdasarkan</b></i></td>
			</tr>
			
			<tr>
				<td><input type="checkbox" name="chdkd">DKD</td>
				<td>
					<select id="optdkd" name="optdkd" onchange="setalamat();" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select dkd,jalan from dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>	
					</select>				</td>
				<td><input name="pilrekap" type="radio" value="c" checked="checked"/>Cabang</td>
				<td></td>
			</tr>
			
			<tr>
				<td><input type="checkbox" name="chgol">Golongan</td>
				<td>
					<select name="optgoltarif" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select distinct gol,keterangan from tarif");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
				<td><input name="pilrekap" type="radio" value="w"/>Wilayah</td>
				<td><input type="submit" name="proses" id="proses" value="Proses" /></td>
			</tr>
		</table>
		</form>
		
		<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:11px;">
			<tr bgcolor="#00FFFF" align="center">
				<td>No.</td>
				<td>Nomor</td>
				<td>No. Lama</td>
				<td>Nama</td>
				<td>Alamat</td>
				<td>No. Rumah </td>
				<td>RT</td>
				<td>RW</td>
				<td>Cabang</td>
				<td>Wil</td>
				<td>Blok</td>
				<td>DKD</td>
				<td>Jns Pel </td>
				<td>Kondisi<br/>WM </td>
				<td>Gol</td>
			</tr>
			<?php
			//db bof*********************************************************************************************************************************************
	
	function cek_slip($str_slip){
		if($str_slip !=''){
			$str_slip=$str_slip ." AND ";
		}
		return $str_slip;
	}
	
	if(isset($_POST['proses'])){
		$slipit='';
		
		//$is_tgl=$_POST['chtgl'];
		$tgl_awal=$_POST['txtawal'];
		$tgl_akhir=$_POST['txtakhir'];
		//$is_cabang=$_POST['chbranch'];
		$cabang=$_POST['optcabang'];
		//$is_wilayah=$_POST['charea'];
		$wilayah=$_POST['optwilayah'];
		//$is_blok=$_POST['chblok'];
		$blok=$_POST['optblok'];
		//$is_dkd=$_POST['chdkd'];
		$dkd=$_POST['optdkd'];
		//$is_gol=$_POST['chgol'];
		$goltarif=$_POST['optgoltarif'];
		//$is_jpl=$_POST['chjpel'];
		$jpl=$_POST['optjpel'];
		$is_kwm=$_POST['chkwm'];
		$kwm=$_POST['optkwm'];
		$is_pilrekap=$_POST['pilrekap'];
		//validasi
		if(isset($_POST["chtgl"])){
			if($tgl_awal !="" && $tgl_akhir !="")$slipit=cek_slip($slipit)."(tglstart BETWEEN '$tgl_awal' AND '$tgl_akhir')";			
		}
		if(isset($_POST["chbranch"])){
			if($cabang !="")$slipit=cek_slip($slipit)."cabang='$cabang'";			
		}
		if(isset($_POST["charea"])){
			if($wilayah !="")$slipit=cek_slip($slipit)."kode_wilayah='$wilayah'";			
		}
		if(isset($_POST["chblok"])){
			if($blok !="")$slipit=cek_slip($slipit)."kode_blok='$blok'";			
		}
		if(isset($_POST["chdkd"])){
			if($dkd !="")$slipit=cek_slip($slipit)."dkd='$dkd'";			
		}
		if(isset($_POST["chgol"])){
			if($goltarif !="")$slipit=cek_slip($slipit)."gol='$goltarif'";			
		}
		if(isset($_POST["chjpel"])){
			if($jpl !="")$slipit=cek_slip($slipit)."jenis_pel='$jpl'";			
		}
		if(isset($_POST["chkwm"])){
			if($kwm !="")$slipit=cek_slip($slipit)."kondisi_meter='$kwm'";			
		}
		
		if ($slipit!="")$slipit=" where ".$slipit;
		
		$sql="SELECT NOMOR,NOLAMA,NAMA,ALAMAT,NORUMAH,rt,rw,cabang,kode_wilayah,kode_blok,DKD,jenis_pel,kondisi_meter,GOL FROM master $slipit order by NOLAMA;";
		$qry=mysql_query($sql);
		while($row=mysql_fetch_row($qry)){
			$j++;
			echo"<tr><td>$j</td>";
			for($i=0;$i<14;$i++){
				echo"<td>".trim($row[$i])."</td>";
			}
			echo"</tr>";		
		}		
	}
			
			//db eof*********************************************************************************************************************************************
			?>
		</table>
		</td>
	</tr>
	
<?php
mysql_close();
require_once("foot.php");
?>