<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");
?>

<tr>
	<td>
	<br/>
		
		<div class="wrapper">
			
		<table background="img/grids.gif" width="853" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="return suvalid(this);">
			<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
			  <td colspan="4"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>CETAK Konfirmasi DSMP</b></font></center></td>
			  </tr>
			<tr>
				<td><input type="radio" name="rd1" id="rdallcust" value="all" />&nbsp;Semua Pelanggan</td>
				<td width="441"><input type="checkbox" name="chtgl" id="chtgl" >Tgl.Ambil
                <input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" /></td>
				<td colspan="2" align="center">
					<input type="submit" name="proses" value="Proses" class="kelas_tombol"/>&nbsp;
					<input type="reset" name="reset" value="Batal" class="kelas_tombol">				</td>
			</tr>
			<tr>
				<td width="130"><!--input type="radio" name="rd1" id="rd1" value="tgl" />&nbsp;Tanggal pasang</td-->
				<td colspan="3">
					<!--input type="text" size="11" maxlength="10" name="txtawal" class="datepicker"  />
					s/d <input type="text" size="11" maxlength="10" name="txtakhir" class="datepicker"  /-->				</td>
			</tr>
			<tr>
				<td><input type="radio" name="rd1" id="rdcabang" value="cabang" />&nbsp;Cabang</td>
				<td>
					<select name="optcabang" id="optcabang" >
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select cabang,nama from cabang where cabang<>'00' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
				<td colspan="2"><input type="radio" name="rd2" id="rdsemua" value="all" checked="checked" />&nbsp;Semua pemakaian</td>
			</tr>
			<tr>
				<td><input type="radio" name="rd1" id="rdwil" value="wil" />&nbsp;Wilayah</td>
				<td>
					<select name="optwilayah" id="optwilayah">
						<!--option value="" selected="selected">--Pilih Wilayah--</option-->
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("SELECT kode_cabang,kode_wilayah,nama_wilayah FROM master_wilayah ORDER BY kode_wilayah");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_wilayah]\">$p[nama_wilayah]</option>\n";
						}
						?>
					</select>				</td>
				<td width="108"><input type="radio" name="rd2" id="rdbelum" value="belum" />&nbsp;Belum di-data</td>
			    <td width="134"><input type="radio" name="rd2" id="rdsudah" value="sudah">Sudah diData</td>
			</tr>
			<tr>
				<td><input type="radio" name="rd1" id="rdblok" value="blok" checked="checked" />&nbsp;Blok</td>
				<td>
					<select name="optblok" id="optblok">
						<!--option value="" selected="selected">--Pilih Blok--</option-->
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("select * from master_blok order by kode_blok");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_blok]\">$p[kode_blok] - $p[ket_blok]</option>\n";
						}
						?>
					</select>				</td>
				<td colspan="2"><input type="radio" name="rd2" id="rdbedakwm" value="bedakwm" />&nbsp;Beda KWM</td>
			</tr>
			<tr>
				<td><input type="radio" name="rd1" id="rddkd" value="dkd" />&nbsp;DKD/Jalan</td>
				<td>
					<select id="optdkd" name="optdkd" onchange="setalamat();" >
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select dkd,jalan from dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>	
					</select>				</td>
				<td colspan="2"><input type="radio" name="rd2" id="rdkurang" value="kurang" />&nbsp;Pemakaian <=&nbsp;&nbsp;
					<input type="text" name="txkecil" id="txkecil" value="" size="2px" />				</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="chjpel" id="chjpel" />Golongan</td>
				<td>
					<select name="optjpel" id="optjpel">
						<!--option value="">-Pilih-</option-->
						<?php
						$sql=mysql_query("select distinct gol,keterangan from tarif order by gol asc;");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
				<td colspan="2"><input type="radio" name="rd2" id="rdlebih" value="lebih" />
				Pemakaian &gt;&nbsp;&nbsp;
				<input type="text" name="txbesar" id="txbesar" value="" size="2px" />				</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="chkwm" name="chkwm" />Kondisi WM</td>
				<td>
					<select name="optkwm" id="optkwm">
						<!--option value="">-Pilih-</option-->
						<?php
						$sql=mysql_query("select kode_kondisi,ket_kondisi from meter_kondisi");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>
					&rarr;&rarr;&rarr;
					<input type="checkbox" id="chkdia" name="chkdia"/>Diameter Pipa&nbsp;&nbsp;
					<select name="optdia" id="optdia">
						<?php
						$sql=mysql_query("SELECT kode,ukuran FROM meter ORDER BY kode ASC;");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=".$row[0].">".$row[1]."</option>";
							//echo"<option value=1>1</option>";
						}
						?>
					</select>&nbsp;Inch				</td>
				<td colspan="2">
					<input type="radio" name="rd2" id="rdpetugas" value="petugas" />&nbsp;Petugas
					<select name="optpetugas" id="optpetugas">
						<!--option value="">-Pilih-</option-->
						<?php
                                                $sql=mysql_query("SELECT DISTINCT petugas FROM dsmp_new WHERE status=1 ORDER BY petugas;");
                                                while($row=mysql_fetch_row($sql)){
                                                        echo"<option value=\"$row[0]\">$row[0]</option>";
                                                }
                                                ?>
					</select>				</td>
			</tr>
			</form>
		</table>
		<br/>
		<!--######################################################################-->
		<table background="img/grids.gif" width="1480px" align="center" border="0" cellpadding="2" cellspacing="2" style="box-shadow: 0 0 15px #999;" class="rounded">
		<tr>
		<td width="100%" align="center">
		<div style="height:300px;overflow:auto">
		<table id="table-hasil" width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">
			<tr align="center" style="background-color:#FFC;color:#000;font-weight:bold;">
				<td>No.</td>
				<td>Nomor</td>
				<td>No. Lama</td>
				<td>Nama</td>
				<td>Alamat</td>
				<td>DKD</td>
				<td>St. Lalu</td>
				<td>St. Kini</td>
				<td>Pakai</td>
                <td>St<br>Mtr</td>
                <td>KWM<br>Lap.</td>
                <td>Ket.</td>
                <td>Tgl<br/>Ambil</td>
                <!--td>Tgl<br/>Kirim</td-->
                <td>Petugas</td>
			</tr>
			<?php
			$plalu=getPeriodeLalu();$pkini=gperiode();$i=0;
			$sql="";
			$slipit="";
			$judul="Daftar Pemakaian Air [Konfirmasi] - Rek. Periode [$pkini]";
			$kwm="";$jpel="";
			
			//variable2 dari get/post harus berada dalam blok event(tombol,ect) jika tidak,php akan membaca sebagai var tak berindex(tanpa arah/pemicu)
			if(isset($_POST["proses"])){
				$r1=$_POST['rd1'];
				$r2=$_POST['rd2'];
				//$tgl_awal=$_POST['txtawal'];
				//$tgl_akhir=$_POST['txtakhir'];
				$pkecil=$_POST['txkecil'];$nkecil=10;
				$pbesar=$_POST['txbesar'];$nbesar=100;
				$slipit=" a.nomor=b.nomor and b.nomor=m.nomor and a.periode=$plalu and b.periode=$pkini and m.putus='0' ";
				$jdl="";
			
				switch($r1){
					case"all":
						//$slipit="";
						echo"<script type=\"text/javascript\">document.getElementById(\"rdallcust\").checked=\"checked\";</script>";
						break;
					//case"tgl":
					//	//$slipit="";
					//	if($tgl_awal !="" && $tgl_akhir !="")$slipit=cek_slip($slipit)."(m.tglstart BETWEEN '$tgl_awal' AND '$tgl_akhir')";
					//	$judul.="<br>per-tanggal $tgl_awal s/d $tgl_akhir";
					//	break;
					case"cabang":
						if(($cabang=$_POST['optcabang']) !="")$slipit=cek_slip($slipit)."m.cabang='$cabang'";
						$judul.="<br>Cabang:".getNama("nama","cabang",$cabang,"cabang");
						echo"<script type=\"text/javascript\">document.getElementById(\"rdcabang\").checked=\"checked\";</script>";
						echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
						break;
					case"wil":
						if(($wil=$_POST['optwilayah']) !="")$slipit=cek_slip($slipit)."m.kode_wilayah='$wil'";
						$judul.="<br>Wilayah: $wil";
						echo"<script type=\"text/javascript\">document.getElementById(\"rdwil\").checked=\"checked\";</script>";
						echo"<script type=\"text/javascript\">document.getElementById(\"optwilayah\").value=\"$wil\";</script>";
						break;
					case"blok":
						if(($blok=$_POST['optblok']) !="")$slipit=cek_slip($slipit)."m.kode_blok='$blok'";
						$judul.="<br>Blok: $blok";
						echo"<script type=\"text/javascript\">document.getElementById(\"rdblok\").checked=\"checked\";</script>";
						echo"<script type=\"text/javascript\">document.getElementById(\"optblok\").value=\"$blok\";</script>";
						break;
					case"dkd":
						if(($dkd=$_POST['optdkd']) !="")$slipit=cek_slip($slipit)."m.dkd='$dkd'";
						$jalan=getNama("jalan",$dkd,"dkd","dkd");
						$judul.="<br>DKD: $dkd - $jalan";
						echo"<script type=\"text/javascript\">document.getElementById(\"rddkd\").checked=\"checked\";</script>";
						echo"<script type=\"text/javascript\">document.getElementById(\"optdkd\").value=\"$dkd\";</script>";
						break;
				}
				
				switch($r2){
					case"all":
						//$slipit=cek_slip($slipit)."(b.angka=0 AND a.angka<>b.angka)";
						//$judul.="<br>Stand Meter Belum Terisi";
						echo"<script type=\"text/javascript\">document.getElementById(\"rdsemua\").checked=\"checked\";</script>";
						break;
					//case"nol":
					//	$slipit=cek_slip($slipit)."(b.angka-a.angka)=0";
					//	$judul.="<br>Stand Mtr: Pemakaian Nol (0)";
					//	break;
					case"belum":
						//$slipit=cek_slip($slipit)."(a.angka<>b.angka)";
						//$slipit=cek_slip($slipit)."(b.angka=0 AND a.angka<>b.angka)";
						$slipit=cek_slip($slipit)."(b.status=0)";
						$judul.="<br>Stand Meter Belum diData";
						echo"<script type=\"text/javascript\">document.getElementById(\"rdbelum\").checked=\"checked\";</script>";
						break;
						case"sudah":
						//$slipit=cek_slip($slipit)."(a.angka<>b.angka)";
						//$slipit=cek_slip($slipit)."(b.angka=0 AND a.angka<>b.angka)";
						$slipit=cek_slip($slipit)."(b.status=1)";
						$judul.="<br>Stand Meter Sudah diData";
						echo"<script type=\"text/javascript\">document.getElementById(\"rdsudah\").checked=\"checked\";</script>";
						break;
					case"kurang":
						if($pkecil!="")$nkecil=$pkecil;
						$slipit=cek_slip($slipit)."(b.angka-a.angka)<=$nkecil";
						$judul.="<br>Pemakaian Lebih Kecil atau Setara [$nkecil]";
						echo"<script type=\"text/javascript\">document.getElementById(\"rdkurang\").checked=\"checked\";</script>";
						echo"<script type=\"text/javascript\">document.getElementById(\"txkecil\").value=\"$nkecil\";</script>";
						break;
					case"lebih":
						if($pbesar!="")$nbesar=$pbesar;
						$slipit=cek_slip($slipit)."(b.angka-a.angka)>$nbesar";
						$judul.="<br>Pemakaian Lebih Besar dari [$nbesar]";
						echo"<script type=\"text/javascript\">document.getElementById(\"rdlebih\").checked=\"checked\";</script>";
						echo"<script type=\"text/javascript\">document.getElementById(\"txbesar\").value=\"$nbesar\";</script>";
						break;
					case "petugas":
						$petugas=$_POST['optpetugas'];
						$slipit=cek_slip($slipit)."(b.petugas='$petugas')";
                                                $judul.="<br>Petugas [$petugas]";
                                                echo"<script type=\"text/javascript\">document.getElementById(\"rdpetugas\").checked=\"checked\";</script>";
                                                echo"<script type=\"text/javascript\">document.getElementById(\"optpetugas\").value=\"$petugas\";</script>";
						#echo $petugas;
						break;
						case"terisi":
									//$slipit.=" AND (a.angka=b.angka AND b.angka>0)";
									$slipit.=" AND (b.angka>0 AND b.angka-a.angka>=0)";
									echo"<script type=\"text/javascript\">document.getElementById(\"terisi\").checked=\"checked\";</script>";
									//checked="checked"
									break;
					case"bedakwm":
                                                if($pbesar!="")$nbesar=$pbesar;
                                                $slipit=cek_slip($slipit)."(LEFT(b.kondisi_meter,1)<>m.kondisi_meter)";
                                                $judul.="<br>Kondisi Meter Tidak Sama (Billing dan Lapangan)";
                                                echo"<script type=\"text/javascript\">document.getElementById(\"rdbedakwm\").checked=\"checked\";</script>";
                                                #echo"<script type=\"text/javascript\">document.getElementById(\"txbesar\").value=\"$nbesar\";</script>";
                                                break;
				}
              
				 
				if(isset($_POST["chkwm"])){
					if(($kwm=$_POST['optkwm']) !="")$slipit=cek_slip($slipit)."m.kondisi_meter='$kwm'";
					$judul.="<br>Kondisi WM: $kwm";
					echo"<script type=\"text/javascript\">document.getElementById(\"chkwm\").checked=\"checked\";</script>";
					echo"<script type=\"text/javascript\">document.getElementById(\"optkwm\").value=\"$kwm\";</script>";
				}
				if(isset($_POST["chjpel"])){
					if(($jpel=$_POST['optjpel']) !="")$slipit=cek_slip($slipit)."m.gol='$jpel'";
					$judul.="<br>Golongan : $jpel";
					echo"<script type=\"text/javascript\">document.getElementById(\"chjpel\").checked=\"checked\";</script>";
					echo"<script type=\"text/javascript\">document.getElementById(\"optjpel\").value=\"$jpel\";</script>";
				}

				if(isset($_POST["chkdia"])){
					if(($jpel=$_POST['optdia']) !="")$slipit=cek_slip($slipit)."m.ukuran='$jpel'";
					$judul.="<br>Diameter Pipa : ".getNama("ukuran",$jpel,"kode","meter")." Inch";
					echo"<script type=\"text/javascript\">document.getElementById(\"chkdia\").checked=\"checked\";</script>";
					echo"<script type=\"text/javascript\">document.getElementById(\"optdia\").value=\"$jpel\";</script>";
				}
				  if(isset($_POST['chtgl'])){
					if(($key1=$_POST['txtawal'])!=''){
					$tawal=$key1;
					echo"<script type=\"text/javascript\">document.getElementById(\"chtgl\").checked=\"checked\";</script>";
					echo"<script type=\"text/javascript\">document.getElementById(\"chtgl\").value=\"$key1\";</script>";
					echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$key1\";</script>";
					}
					
					if(($key2=$_POST['txtakhir'])!=''){
					$takhir=$key2;
					echo"<script type=\"text/javascript\">document.getElementById(\"chtgl\").checked=\"checked\";</script>";
					echo"<script type=\"text/javascript\">document.getElementById(\"chtgl\").value=\"$key2\";</script>";
					echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$key2\";</script>";
					}

					$slipit=cek_slip($slipit)."(DATE(b.tgl_baca) BETWEEN '$tawal' AND '$takhir')";
				}
				
				
				
				if ($slipit!="")$slipit=" where ".$slipit;
				
				$alg=array("center","center","left","left","right","right","right","right","center");
				#$sql="select m.nomor,m.nolama,SUBSTR(m.nama,1,35),SUBSTR(lcase(m.alamat),1,42),m.dkd,a.angka,b.angka,(b.angka-a.angka),m.kondisi_meter,LEFT(b.kondisi_meter,1),b.keterangan,b.tgl_baca,b.tgl,b.petugas from master as m,dsmp_new as a,dsmp_new as b $slipit  and(b.tgl_baca BETWEEN '$tawal' AND '$takhir') order by CAST(m.nolama as UNSIGNED) ";
				$sql="select m.nomor,m.nolama,SUBSTR(m.nama,1,35),SUBSTR(lcase(m.alamat),1,42),m.dkd,a.angka,b.angka,(b.angka-a.angka),m.kondisi_meter,LEFT(b.kondisi_meter,1),b.keterangan,b.tgl_baca,b.tgl,b.petugas from master as m,dsmp_new as a,dsmp_new as b $slipit ORDER BY CAST(m.nolama as UNSIGNED) ";
				$query=mysql_query($sql) or die(mysql_error());
				while($row=mysql_fetch_row($query)){
					$i++;
					$nl=trim($row[1]);
					echo"<tr>";
					echo"<td align=center>$i</td>";
					echo"<td align=center>".trim($row[0])."</td>";
					echo"<td align=center>".trim($row[1])."</td>";
					echo"<td>".trim($row[2])."</td>";
					echo"<td>".ucwords(trim($row[3]))."</td>";
					echo"<td align=center>".trim($row[4])."</td>";
					//echo"<td align=right>".trim($row[5])."</td>";
					//echo"<td align=right>".trim($row[6])."</td>";
					
					if(file_exists("foto_meter/".$nl."_".$plalu.".jpg")){
						echo"<td align=right><a style=\"color:#00f;\" href=\"foto_meter/$nl"."_"."$plalu".".jpg\" target=\"_blank\">".trim($row[5])."</a></td>";
					}else{
						echo"<td align=right>".trim($row[5])."</td>";
					}
					
					if(file_exists("foto_meter/".$nl."_".$pkini.".jpg")){
						echo"<td align=right><a style=\"color:#00f;\" href=\"foto_meter/$nl"."_"."$pkini".".jpg\" target=\"_blank\">".trim($row[6])."</a></td>";
					}else{					
						echo"<td align=right>".trim($row[6])."</td>";
					}
					
					echo"<td align=right>".trim($row[7])."</td>";
					echo"<td align=right>".trim($row[8])."</td>";
					echo"<td align=center>".trim($row[9])."</td>";
					echo"<td align=center>".trim($row[10])."</td>";
					echo"<td align=center>".trim($row[11])."</td>";
					#echo"<td align=center> - </td>";
					echo"<td align=center>".trim($row[13])."</td>";
					//echo"<td align=right>".((trim($row[6]))-(trim($row[5])))."</td>";
					echo"</tr>";					
				}
				#echo"<tr><td colspan=9>$sql</td></tr>";
				
				$sql1="
				SELECT IFNULL(FORMAT(sum(b.angka-a.angka),0),0) AS hsl
				FROM master AS m
				INNER JOIN dsmp_new AS a ON a.nomor=m.nomor
				INNER JOIN dsmp_new AS b ON b.nomor=m.nomor 
				$slipit AND b.angka-a.angka>0
				;";
				$query=mysql_query($sql1) or die(mysql_error());
				if($row=mysql_fetch_row($query)){
					$total_pakai=$row[0];
				}
				//echo $total_pakai;
				$tfoot="
				<tr>
					<th colspan=\"5\">TOTAL PEMAKAIAN [M<sup>3</sup>]</th>
					<th colspan=\"5\" align=\"right\">$total_pakai</th>
				</tr>
				";
				echo $tfoot;
				//inject session bof
				$_SESSION['tfooter']=$tfoot;
				$_SESSION["judul"]=$judul;
				$_SESSION["jumfield"]=8;
				$_SESSION["eskiel"]="select m.nomor,m.nolama,SUBSTR(lcase(m.nama),1,30),SUBSTR(lcase(m.alamat),1,30),a.angka,b.angka,(b.angka-a.angka),m.kondisi_meter from master as m,dsmp_new as a,dsmp_new as b $slipit order by CAST(m.nolama as UNSIGNED)";
				$_SESSION["alinea"]=$alg;
				$_SESSION["theader"]="
				<tr align=\"center\" style=\"background-color:#fff;color:#000;font-weight:bold;\">
					<th>No.</th>
					<th >Nomor</th>
					<th >No. Lama</th>
					<th width=180>Nama</th>
					<th width=220>Alamat</th>
					<!--th >DKD</th-->
					<th>Stand Lalu</th>
					<th>Stand Kini</th>
					<th width=60>Pakai</th>
					<th width=30>St<br>Mtr</th>
				</tr>
				";
				$_SESSION['orientasi']="P";
				$_SESSION['ttd']="<br>
				<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
				<tr width=\"100%\">
					<td width=\"300\" align=\"center\">
						Diketahui oleh,<br>
						<br><br><br>
						...............................<br>Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td width=\"300\" align=\"center\">
						Dibuat oleh,<br>
						<br><br><br>
						...............................<br>
						Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
				</tr></table>
				";
				//inject session eof
			}
														
			?>
		</table>
		</div>
		</td>
		</tr>
<tr>
</tr>
		<tr>
			<td align="center">
				<a href="reports/print_report_confirm.php" target="_blank" style="color:#FF0000;font-weight:bold"<br />-= Cetak Report =-</a>

 <input type="button" name="export" value="Export to Excel" onClick ="$('#table-hasil').tableExport({type:'excel',escape:'false',htmlContent:'true'});" style="color:#00f;font-size:12px;font-weight:bold;padding:0px;"/>
			</td>
		</tr>
		</table>
		
		<br/>
		<!--######################################################################-->
		
		</div>
	
	
	</td>
</tr>

<?php
putus();
require_once("foot.php");
?>
