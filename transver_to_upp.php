<?php
ob_start();
session_start();
require_once("mydb.php");
//sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');
//ini_set('mysql.connect_timeout',3000);
//ini_set('default_socket_timeout',3000);

$rekening_baru=0;
$qry=mysql_query("SELECT MAX(periode) AS prd FROM billing.rekening1 LIMIT 1;")or die(mysql_error());
while($rek_bar=mysql_fetch_row($qry)){	
	$rekening_baru=$rek_bar[0];
}
?>

	<tr>
		<td>
		<!--############################################################################################################-->
        	<br />
		<table width="1124px" border="0" cellpadding="10" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="border:5px dashed #707;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
        	<form name="f1" method="post" action="">
            <tr>
              <td colspan="6" align="center" style="padding:2px 0;text-shadow:2px 2px 2px red;color:#000;font-size:18px;background: linear-gradient(#909,#fff);font-weight:bold;font-family:'Times New Roman', Times, serif'" ><b>Kirim Data Server ke Cabang [UPP]</b></font></td>
              </tr>
            <tr>
            	<td>Ke Cabang</td>
                <td colspan="5">
                <select name="optcabang" id="optcabang" >
                  <!--option value="11" selected="selected">Semua UPP</option-->
                  <?php
						$sql=mysql_query("select cabang,nama from cabang WHERE cabang<>'00' AND cabang<>'01' AND cabang<>'06' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span  style="background:#ffc;">LPP : u/ trans. <input type="checkbox" name="chjlok" id="chjlok" style="background:#ffc;" />&nbsp;Per-loket&nbsp;
				<select name="optjlok" id="optjlok" style="background:#ffc;">
                  <!--option value="">-Pilih-</option-->
					<?php
						$sql=mysql_query("select kode_loket,ket_loket from m_loket order by kode_loket");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
					?>
                </select>
				<i style="color:#006;font-size:90%;">Hilangkan centang untuk kirim transaksi semua loket !</i>
				</span>
				</td>				
            </tr>
            <tr>
            	<td>Tgl Acuan</td>
                <td>
					<input type="text" size="7" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="7" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]
				</td>
               
                <td><input type="submit" name="koreksi" id="koreksi" value="(1)Koreksi Rek." class="kelas_tombol" /></td>
<td><input type="submit" name="lpp" id="lpp" value="LPP Semua" class="kelas_tombol" /></td>
				<td><input type="submit" name="pel" id="pel" value="(3)Pelanggan" class="kelas_tombol" /></td>
				<td><input style="font-size:120%;color:#000;" type="submit" name="newrek" id="newrek" value="(4)Kirim Rek. <?php echo $rekening_baru;?>" class="kelas_tombol5" /></td>
            </tr>
            </form>
        </table>
		<!--###############-->
		<?php
		
################################################################################################################
		##BOF newrek		
		if(isset($_POST['newrek'])){			
			$cabang=$_POST['optcabang'];
			echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
			$ip="";
			switch($cabang){
				case"01";
					$ip="192.168.0.200";
					break;
				case"02";
					//$ip="192.168.1.16";
					//$ip="192.168.0.200";
					$ip="192.168.1.50";
					break;
				case"03";
					$ip="192.168.2.60";
					break;
				case"04";
					$ip="192.168.5.80";
					break;
				case"05";
					$ip="192.168.4.70";
					break;
			}
			$tawal='2000-01-01';
			$takhir=date('Y-m-d');
			if(($key1=$_POST['txtawal'])!=''){
			$tawal=$key1;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$tawal\";</script>";
			}
			if(($key2=$_POST['txtakhir'])!=''){
				$takhir=$key2;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$takhir\";</script>";
			}
			#BOF rek_baru#			
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				nomor, nolama, nama, cabang, kode_wilayah, kode_blok, dkd, gol, periode, standlalu, standkini, pakai, loket, tbayar, uangair, adm, meter, denda, meterai, total, status_bayar, periode_tarif, periode_meterai
			FROM rekening1
			WHERE periode=$rekening_baru
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$nolama[$i]=$row[1];
					$nama[$i]=$row[2];
					$cabang[$i]=$row[3];
					$kode_wilayah[$i]=$row[4];
					$kode_blok[$i]=$row[5];
					$dkd[$i]=$row[6];
					$gol[$i]=$row[7];
					$periode[$i]=$row[8];
					$standlalu[$i]=$row[9];
					$standkini[$i]=$row[10];
					$pakai[$i]=$row[11];
					$loket[$i]=$row[12];
					$tbayar[$i]=$row[13];
					$uangair[$i]=$row[14];
					$adm[$i]=$row[15];
					$meter[$i]=$row[16];
					$denda[$i]=$row[17];
					$meterai[$i]=$row[18];
					$total[$i]=$row[19];
					$status_bayar[$i]=$row[20];
					$periode_tarif[$i]=$row[21];
					$periode_meterai[$i]=$row[22];
				}
				//putus();
				konek($ip,"pdam","","billing");
				//konek($ip,"root","","billing");	
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					INSERT IGNORE INTO rekening1(
					nomor, nolama, nama, cabang, kode_wilayah, kode_blok, dkd, gol, periode, standlalu, standkini, pakai, loket, tbayar, uangair, adm, meter, denda, meterai, total, status_bayar, periode_tarif, periode_meterai
					)VALUES(
					'$nomor[$i]', '$nolama[$i]', '$nama[$i]', '$cabang[$i]', '$kode_wilayah[$i]', '$kode_blok[$i]', '$dkd[$i]', '$gol[$i]', $periode[$i], $standlalu[$i], $standkini[$i], $pakai[$i], '$loket[$i]', '$tbayar[$i]', $uangair[$i], $adm[$i], $meter[$i], $denda[$i], $meterai[$i], $total[$i], $status_bayar[$i], $periode_tarif[$i], $periode_meterai[$i]
					)
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF rek_baru#
						
			//echo"<h1 style=\"text-align:center;color:red;font-size:150%;\">Update Data Pelanggan Berhasil</h1>";
			echo"<script language=\"javascript\">alert('Update Data Rek. $rekening_baru ke Host $ip berhasil');</script>";
		}
		##EOF newrek
				
		
		
		################################################################################################################
		##BOF pelanggan		
		if(isset($_POST['pel'])){			
			$cabang=$_POST['optcabang'];
			echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
			$ip="";
			switch($cabang){
				case"01";
					$ip="192.168.0.200";
					break;
				case"02";
					//$ip="192.168.1.16";
					//$ip="192.168.0.200";
					$ip="192.168.1.50";
					break;
				case"03";
					$ip="192.168.2.60";
					break;
				case"04";
					$ip="192.168.5.80";
					break;
				case"05";
					$ip="192.168.4.70";
					break;
			}
			$tawal='2000-01-01';
			$takhir=date('Y-m-d');
			if(($key1=$_POST['txtawal'])!=''){
			$tawal=$key1;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$tawal\";</script>";
			}
			if(($key2=$_POST['txtakhir'])!=''){
				$takhir=$key2;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$takhir\";</script>";
			}
			#BOF balik_nama#			
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				nomor,
				baru
			FROM ubah_nama
			WHERE tgl between '$tawal' AND '$takhir'
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$baru[$i]=$row[1];
				}
				//putus();
				konek($ip,"pdam","","billing");
				//konek($ip,"root","","billing");	
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					UPDATE master
					SET nama='$baru[$i]'
					WHERE nomor='$nomor[$i]'
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF balik_nama#
			
			#BOF ubah_stat_pel#			
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				nomor,
				baru
			FROM ubah_stat
			WHERE tgl between '$tawal' AND '$takhir'
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$baru[$i]=$row[1];
				}
				//putus();
				konek($ip,"pdam","","billing");
				//konek($ip,"root","","billing");	
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					UPDATE master
					SET putus='$baru[$i]'
					WHERE nomor='$nomor[$i]'
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF ubah_stat_pel#
			
			#BOF ubah_kwm#			
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				nomor,
				baru
			FROM ubah_kwm
			WHERE tgl between '$tawal' AND '$takhir'
			;";
			$sql555="
			SELECT
				nomor,
				kondisi_meter
			FROM master
			WHERE putus=0
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$baru[$i]=$row[1];
				}
				//putus();
				konek($ip,"pdam","","billing");
				//konek($ip,"root","","billing");	
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					UPDATE master
					SET kondisi_meter='$baru[$i]'
					WHERE nomor='$nomor[$i]'
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF ubah_kwm#
						
			#BOF ubah_gol#
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				nomor,
				nola2,
				gol2
			FROM ubah_gol
			WHERE tgl between '$tawal' AND '$takhir'
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$nola2[$i]=$row[1];
					$gol2[$i]=$row[2];
				}
				//putus();
				konek($ip,"pdam","","billing");
				//konek($ip,"root","","billing");
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					UPDATE master
					SET nolama='$nola2[$i]', gol='$gol2[$i]'
					WHERE nomor='$nomor[$i]'
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF ubah_gol#

			#BOF ubah_nomor [ID PEL]#
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				nomor,
				lama
			FROM ubah_nomor
			WHERE tgl between '$tawal' AND '$takhir'
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$lama[$i]=$row[1];
				}
				//putus();
				konek($ip,"pdam","","billing");
				//konek($ip,"root","","billing");
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					UPDATE master
					SET nolama='$lama[$i]'
					WHERE nomor='$nomor[$i]'
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF ubah_nomor [ID PEL]#

			#BOF hapus_pelanggan
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="SELECT nomor FROM hapus_master WHERE nu BETWEEN '$tawal' AND '$takhir';";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;
					$nomor[$i]=$row[0];
				}
				konek($ip,"pdam","","billing");
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="DELETE FROM master WHERE nomor='$nomor[$i]';";
					$qry=mysql_query($sql_rek) or die(mysql_error());
				}
			}
			#EOF hapus_pelanggan

			#BOF ubah_meter [METERISASI]#
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				nomor,
				nometer2,
				merk2
				ukuran2				
			FROM ubah_meter
			WHERE tgl between '$tawal' AND '$takhir'
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$nometer2[$i]=$row[1];
					$merk2[$i]=$row[2];
					$ukuran2[$i]=$row[3];
				}
				konek($ip,"pdam","","billing");				
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					UPDATE master
					SET NOMETER='$nometer2[$i]', MERK='$merk2[$i]',UKURAN='$ukuran2',kondisi_meter='1'
					WHERE nomor='$nomor[$i]'
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF ubah_meter [METERISASI]#
			
			#BOF ubah_stat#
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				nomor,
				nolama,
				alamat,
				kondisi_meter,
				cabang,
				kode_wilayah,
				kode_blok,
				DKD,
				kode_cabang
			FROM master
			WHERE nu between '$tawal' AND '$takhir'
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$nolama[$i]=$row[1];
					$alamat[$i]=$row[2];
					$kwm[$i]=$row[3];
					#$merk[$i]=$row[3];
					#$nometer[$i]=$row[3];
					#$ukuran[$i]=$row[3];
					$cabang[$i]=$row[4];
					$kode_wilayah[$i]=$row[5];
					$kode_blok[$i]=$row[6];
					$DKD[$i]=$row[7];
					$kode_cabang[$i]=$row[8];
				}
				//putus();
				konek($ip,"pdam","","billing");				
				//konek($ip,"root","","billing");
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					UPDATE master
					SET nolama='$nolama[$i]',alamat='$alamat[$i]',kondisi_meter='$kwm[$i]',cabang='$cabang[$i]',kode_wilayah='$kode_wilayah[$i]',kode_blok='$kode_blok[$i]',DKD='$DKD[$i]',kode_cabang='$kode_cabang[$i]'
					WHERE nomor='$nomor[$i]'
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF ubah_stat#
			
			#BOF sambungan_baru#
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				NOMOR,
				NOLAMA,
				NAMA,
				ALAMAT,
				NORUMAH,
				kode_pos,
				cabang,
				kode_cabang,
				kode_wilayah,
				kode_blok,
				DKD,
				wpt,
				rt,
				rw,
				no_telp,
				no_hp,
				no_ktp,
				no_sim,
				npwp,
				GOL,
				PUTUS,
				tglstart,
				UKURAN,
				qr_stat,
				qr_tahap,
				UANG,
				CR_ANGS,
				ANG_KE,
				MUKA,
				TUNGGAK,
				PIUTANG,
				KABNORM,
				MERK,
				NOMETER,
				kondisi_meter,
				pakai_air_bln,
				jenis_pel,
				TUNGANGS,
				ONLINE,
				nu,
				nomor_lama,
				status_aktif,
				periode_aktif,
				status_sambung,
				kode_kolektif,
				alamat_pendek,
				tgl_input,
				periode_t
			FROM master
			WHERE tgl_input between '$tawal' AND '$takhir'
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$nolama[$i]=$row[1];
					$nama[$i]=$row[2];
					$alamat[$i]=$row[3];
					$norumah[$i]=$row[4];
					$kode_pos[$i]=$row[5];
					$cabang[$i]=$row[6];
					$kode_cabang[$i]=$row[7];
					$kode_wilayah[$i]=$row[8];
					$kode_blok[$i]=$row[9];
					$dkd[$i]=$row[10];
					$wpt[$i]=$row[11];
					$rt[$i]=$row[12];
					$rw[$i]=$row[13];
					$no_telp[$i]=$row[14];
					$no_hp[$i]=$row[15];
					$no_ktp[$i]=$row[16];
					$no_sim[$i]=$row[17];
					$npwp[$i]=$row[18];
					$gol[$i]=$row[19];
					$putus[$i]=$row[20];
					$tglstart[$i]=$row[21];
					$ukuran[$i]=$row[22];
					$qr_stat[$i]=$row[23];
					$qr_tahap[$i]=$row[24];
					$uang[$i]=$row[25];
					$cr_angs[$i]=$row[26];
					$ang_ke[$i]=$row[27];
					$muka[$i]=$row[28];
					$tunggak[$i]=$row[29];
					$piutang[$i]=$row[30];
					$kabnorm[$i]=$row[31];
					$mark[$i]=$row[32];
					$nometer[$i]=$row[33];
					$kondisi_meter[$i]=$row[34];
					$pakai_air_bln[$i]=$row[35];
					$jenis_pel[$i]=$row[36];
					$tungangs[$i]=$row[37];
					$online[$i]=$row[38];
					$nu[$i]=$row[39];
					$nomor_lama[$i]=$row[40];
					$status_aktif[$i]=$row[41];
					$periode_aktif[$i]=$row[42];
					$status_sambung[$i]=$row[43];
					$kode_kolektif[$i]=$row[44];
					$alamat_pendek[$i]=$row[45];
					$tgl_input[$i]=$row[46];
					$periode_t[$i]=$row[47];
				}
				//putus();
				konek($ip,"pdam","","billing");				
				//konek($ip,"root","","billing");
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					INSERT INTO master(
						NOMOR,
						NOLAMA,
						NAMA,
						ALAMAT,
						NORUMAH,
						kode_pos,
						cabang,
						kode_cabang,
						kode_wilayah,
						kode_blok,
						DKD,
						wpt,
						rt,
						rw,
						no_telp,
						no_hp,
						no_ktp,
						no_sim,
						npwp,
						GOL,
						PUTUS,
						tglstart,
						UKURAN,
						qr_stat,
						qr_tahap,
						UANG,
						CR_ANGS,
						ANG_KE,
						MUKA,
						TUNGGAK,
						PIUTANG,
						KABNORM,
						MERK,
						NOMETER,
						kondisi_meter,
						pakai_air_bln,
						jenis_pel,
						TUNGANGS,
						ONLINE,
						nu,
						nomor_lama,
						status_aktif,
						periode_aktif,
						status_sambung,
						kode_kolektif,
						alamat_pendek,
						tgl_input,
						periode_t
					)VALUES(
						'$nomor[$i]',
						'$nolama[$i]',
						'$nama[$i]',
						'$alamat[$i]',
						'$norumah[$i]',
						'$kode_pos[$i]',
						'$cabang[$i]',
						'$kode_cabang[$i]',
						'$kode_wilayah[$i]',
						'$kode_blok[$i]',
						'$dkd[$i]',
						'$wpt[$i]',
						'$rt[$i]',
						'$rw[$i]',
						'$no_telp[$i]',
						'$no_hp[$i]',
						'$no_ktp[$i]',
						'$no_sim[$i]',
						'$npwp[$i]',
						'$gol[$i]',
						'$putus[$i]',
						'$tglstart[$i]',
						'$ukuran[$i]',
						'$qr_stat[$i]',
						'$qr_tahap[$i]',
						'$uang[$i]',
						'$cr_angs[$i]',
						'$ang_ke[$i]',
						'$muka[$i]',
						'$tunggak[$i]',
						'$piutang[$i]',
						'$kabnorm[$i]',
						'$mark[$i]',
						'$nometer[$i]',
						'$kondisi_meter[$i]',
						'$pakai_air_bln[$i]',
						'$jenis_pel[$i]',
						'$tungangs[$i]',
						'$online[$i]',
						'$nu[$i]',
						'$nomor_lama[$i]',
						'$status_aktif[$i]',
						'$periode_aktif[$i]',
						'$status_sambung[$i]',
						'$kode_kolektif[$i]',
						'$alamat_pendek[$i]',
						'$tgl_input[$i]',
						'$periode_t[$i]'
					)					
					ON DUPLICATE KEY UPDATE kode_wilayah='$kode_wilayah[$i]',kondisi_meter='$kondisi_meter[$i]',dkd='$dkd[$i]',putus='$putus[$i]'
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF sambungan_baru#
			
			//echo"<h1 style=\"text-align:center;color:red;font-size:150%;\">Update Data Pelanggan Berhasil</h1>";
			echo"<script language=\"javascript\">alert('Update Data Pelanggan Berhasil');</script>";
		}
		##EOF pelanggan
		
		
		################################################################################################################
		if(isset($_POST['koreksi'])){			
			$cabang=$_POST['optcabang'];
			echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
			$ip="";
			switch($cabang){
				case"01";
					$ip="192.168.0.200";
					break;
				case"02";
					//$ip="192.168.1.16";
					//$ip="192.168.0.200";
					$ip="192.168.1.50";
					break;
				case"03";
					$ip="192.168.2.60";
					break;
				case"04";
					$ip="192.168.5.80";
					break;
				case"05";
					$ip="192.168.4.70";
					break;
			}
			$tawal='2000-01-01';
			$takhir=date('Y-m-d');
			if(($key1=$_POST['txtawal'])!=''){
			$tawal=$key1;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$tawal\";</script>";
			}
			if(($key2=$_POST['txtakhir'])!=''){
				$takhir=$key2;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$takhir\";</script>";
			}
			
			#BOF REKENING#
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			//$qry=mysql_query("SELECT DISTINCT r.nomor,r.periode,r.standlalu,r.standkini,r.pakai,r.loket,r.tbayar,r.uangair,r.adm,r.meter,r.denda,r.meterai,r.total,r.status_bayar FROM rekening1 AS r INNER JOIN transaksi AS t on t.nomor=r.nomor AND t.periode=r.periode WHERE r.status_bayar=1 AND t.batal=0 AND (t.tbayar BETWEEN '$tawal' AND '$takhir');")or die(mysql_error());
			$sql="
			SELECT
				nomor,
				periode,
				standlalu,
				standkini,
				pakai,
				uangair,
				adm,
				meter,
				denda,
				meterai,
				total,
				tkorek,
				loket,
				operator,
				standlalu_awal,
				standkini_awal,
				pakai_awal,
				uangair_awal,
				adm_awal,
				meter_awal,
				denda_awal,
				meterai_awal,
				total_awal
			FROM his_koreksi_rek
			WHERE tkorek between '$tawal' AND '$takhir'
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$periode[$i]=$row[1];
					$standlalu[$i]=$row[2];
					$standkini[$i]=$row[3];
					$pakai[$i]=$row[4];
					$uangair[$i]=$row[5];
					$adm[$i]=$row[6];
					$meter[$i]=$row[7];
					$denda[$i]=$row[8];
					$meterai[$i]=$row[9];
					$total[$i]=$row[10];
					$tkorek[$i]=$row[11];
					$loket[$i]=$row[12];
					$operator[$i]=$row[13];
					$standlalu_awal[$i]=$row[14];
					$standkini_awal[$i]=$row[15];
					$pakai_awal[$i]=$row[16];
					$uangair_awal[$i]=$row[17];
					$adm_awal[$i]=$row[18];
					$meter_awal[$i]=$row[19];
					$denda_awal[$i]=$row[20];
					$meterai_awal[$i]=$row[21];
					$total_awa[$i]=$row[22];
				}
				//putus();
				//echo"Hasil: $nomor[$i] - $periode[$i] -  $total[$i]<br/>";
				konek($ip,"pdam","","billing");				
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					UPDATE rekening1 SET
						standlalu=$standlalu[$i],
						standkini=$standkini[$i],
						pakai=$pakai[$i],
						uangair=$uangair[$i],
						adm=$adm[$i],
						meter=$meter[$i],
						denda=$denda[$i],
						meterai=$meterai[$i],
						total=$total[$i]
					WHERE nomor='$nomor[$i]' AND periode=$periode[$i] AND status_bayar=0
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					
				}				
			}
			#EOF REKENING#
			/*
			%%%%%%%%%%%%
			%%%%%%%%%%%%
			%%%%%%%%%%%%
			%%%%%%%%%%%%
			*/
			#BOF HAPUS#
			$i=0;
			konek("localhost","root","pdamjpr123","billing");			
			$sql="
			SELECT
				nomor,
				periode
			FROM rekening1_hapus
			WHERE tgl_hapus between '$tawal' AND '$takhir'
			;";
			$qry=mysql_query($sql)or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;					
					$nomor[$i]=$row[0];
					$periode[$i]=$row[1];
				}
				//putus();
				konek($ip,"pdam","","billing");				
				$i=0;
				while($i<$jml){
					$i++;
					$sql_rek="
					DELETE FROM rekening1
					WHERE nomor='$nomor[$i]' AND periode=$periode[$i] AND status_bayar=0
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}
			#EOF HAPUS#
			//echo"<h1 style=\"text-align:center;color:red;font-size:150%;\">Update Koreksi Rekening Berhasil</h1>";
			echo"<script language=\"javascript\">alert('Update Koreksi Rekening Berhasil');</script>";
		}
		################################################################################################################
		if(isset($_POST['lpp'])){
		
		$slipit="";
		//$$$$ PER LOKET
			if(isset($_POST["chjlok"])){
				$key=$_POST['optjlok'];
				$slipit=" AND (t.loket='$key') ";
				//$judul.="<br>Loket : $key";
				echo"<script type=\"text/javascript\">document.getElementById(\"chjlok\").checked=\"checked\";</script>";
				echo"<script type=\"text/javascript\">document.getElementById(\"optjlok\").value=\"$key\";</script>";
			}
		//$$$$ PER LOKET
		
			$cabang=$_POST['optcabang'];
			echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
			$ip="";
			switch($cabang){
				case"01";
					$ip="192.168.0.200";
					break;
				case"02";
					//$ip="192.168.1.16";
					//$ip="192.168.0.12";
					$ip="192.168.1.50";
					break;
				case"03";
					$ip="192.168.2.60";
					break;
				case"04";
					$ip="192.168.5.80";
					break;
				case"05";
					$ip="192.168.4.70";
					break;
			}
			
			$tawal='2000-01-01';
			$takhir=date('Y-m-d');
			if(($key1=$_POST['txtawal'])!=''){
			$tawal=$key1;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$tawal\";</script>";
			}
			if(($key2=$_POST['txtakhir'])!=''){
				$takhir=$key2;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$takhir\";</script>";
			}
			
			//=============================REKENING1
			$i=0;
			//konek("192.168.0.200","root","","billing");
			//konek($ip,"pdam","","billing");
			konek("localhost","root","pdamjpr123","billing");
			//$qry=mysql_query("SELECT DISTINCT nomor,periode,angka FROM dsmp0 WHERE PERIODE=201409")or die(mysql_error());
			//$qry=mysql_query("SELECT DISTINCT nomor,periode,standlalu,standkini,pakai,loket,tbayar,uangair,adm,meter,denda,meterai,total,status_bayar FROM rekening1 WHERE status_bayar=1 AND (tbayar BETWEEN '$tawal' AND '$takhir');")or die(mysql_error());
			$qry=mysql_query("SELECT DISTINCT r.nomor,r.periode,r.standlalu,r.standkini,r.pakai,r.loket,r.tbayar,r.uangair,r.adm,r.meter,r.denda,r.meterai,r.total,r.status_bayar FROM rekening1 AS r INNER JOIN transaksi AS t on t.nomor=r.nomor AND t.periode=r.periode WHERE r.status_bayar=1 AND t.batal=0 $slipit AND (t.tbayar BETWEEN '$tawal' AND '$takhir');")or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;
					//$data[$i]=array($row[0],$row[1],$row[2]);
					$nomor[$i]=$row[0];
					$periode[$i]=$row[1];					
					$standlalu[$i]=$row[2];
					$standkini[$i]=$row[3];
					$pakai[$i]=$row[4];
					$loket[$i]=$row[5];
					$tbayar[$i]=$row[6];
					$uangair[$i]=$row[7];
					$adm[$i]=$row[8];
					$meter[$i]=$row[9];
					$denda[$i]=$row[10];
					$meterai[$i]=$row[11];
					$total[$i]=$row[12];
					$statbayar[$i]=$row[13];
					
					
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//putus();
				
				//konek("192.168.0.100","root","","billing");
				konek($ip,"pdam","","billing");
				//konek("192.168.0.13","pdam","","billing");
				//$qry=mysql_query("INSERT INTO dsmpo") or die(mysql_error());
				//for($i=0;$i<$jml;$i++){
				$i=0;
				while($i<$jml){
					$i++;
					
					//$qry=mysql_query("INSERT IGNORE INTO dsmp_copy(nomor,periode,angka)VALUES('$nomor[$i]',$periode[$i],$angka[$i])") or die(mysql_error());
					//$qry=mysql_query("INSERT IGNORE INTO transaksi_copy(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					//$qry=mysql_query("INSERT IGNORE INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					$sql_rek="
					UPDATE rekening1 SET
					status_bayar=$statbayar[$i], tbayar='$tbayar[$i]', loket='$loket[$i]',denda=$denda[$i],total=$total[$i] 
					WHERE nomor='$nomor[$i]' AND periode=$periode[$i]
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}			
			//=================TRANSAKSI======================================
			$i=0;
			konek("localhost","root","pdamjpr123","billing");
			//konek($ip,"pdam","","billing");
			//$qry=mysql_query("SELECT DISTINCT nomor,periode,angka FROM dsmp0 WHERE PERIODE=201409")or die(mysql_error());
			$qry=mysql_query("SELECT DISTINCT t.nomor,t.periode,t.total,t.tbayar,t.jbayar,t.loket,t.operator,t.batal FROM transaksi AS t WHERE (t.tbayar BETWEEN '$tawal' AND '$takhir') $slipit;")or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;
					//$data[$i]=array($row[0],$row[1],$row[2]);
					$nomor[$i]=$row[0];
					$periode[$i]=$row[1];
					$total[$i]=$row[2];
					$tbayar[$i]=$row[3];
					$jbayar[$i]=$row[4];
					$loket[$i]=$row[5];
					$operator[$i]=$row[6];
					$batal[$i]=$row[7];
					
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//putus();
				
				konek($ip,"pdam","","billing");
				//konek("192.168.0.13","pdam","","billing");
				//$qry=mysql_query("INSERT INTO dsmpo") or die(mysql_error());
				//for($i=0;$i<$jml;$i++){
				$i=0;
				while($i<$jml){
					$i++;
					
					//$qry=mysql_query("INSERT IGNORE INTO dsmp_copy(nomor,periode,angka)VALUES('$nomor[$i]',$periode[$i],$angka[$i])") or die(mysql_error());
					//$qry=mysql_query("INSERT IGNORE INTO transaksi_copy(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					$qry=mysql_query("INSERT IGNORE INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//if($qry)echo"<script language='javascript'>alert('Berhasil Ambil Data!');</script-->";
				//putus();
			}			
			//======================================		
			
			
		}
		?>
		<!--###############-->
		<br/>
        <table width="1024px" align="center" border="0" cellpadding="0" cellspacing="0" style="border:5px dashed #707;box-shadow: 0 0 15px #999;" background="img/grids.gif">
			<tr>
				<td width="100%" align="center">
                <div style="height:300px;overflow:auto">
                    <table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
        <?php
        if(isset($_POST['dsmp'])){			
			echo"<tr style=\"background-color:#909090;color:#FFFFFF;\">";
			echo"<th width=\"2px\">No.</th><th>Nomor</th><th>Periode</th><th>Angka Meter</th>";
			echo"</tr>";
			$i=0;
			while($i<$jml){
				$i++;
				echo"<tr><td align=left>$i</td><td align=center>$nomor[$i]</td><td align=center>$periode[$i]</td><td align=right>$angka[$i]</td></tr>";
			}
		}else if(isset($_POST['lpp'])){
			echo"<tr style=\"background-color:#909090;color:#FFFFFF;\">";
			echo"<th width=\"2px\">No.</th><th>Nomor</th><th>Periode</th><th>Total</th><th>Tgl Bayar</th><th>Jam</th><th>Loket</th><th>Kasir</th><th>Stat<br>Trans</th>";
			echo"</tr>";
			$i=0;
			while($i<$jml){
				$i++;
				//echo"<tr><td align=left>$i</td><td align=center>$nomor[$i]</td><td align=center>$periode[$i]</td><td align=right>$angka[$i]</td></tr>";
				if($batal[$i]==0){$btl='LUNAS';}else{$btl='DIBATALKAN';}
				echo"<tr>
				<td align=left>$i</td>
				<td align=center>$nomor[$i]</td>
				<td align=center>$periode[$i]</td>
				<td align=right>$total[$i]</td>
				<td align=center>$tbayar[$i]</td>
				<td align=center>$jbayar[$i]</td>
				<td align=center>$loket[$i]</td>
				<td align=center>$operator[$i]</td>				
				<td align=center>$btl</td>
				</tr>";
			}
		}else if(isset($_POST['master'])){
			echo"<tr style=\"background-color:#909090;color:#FFFFFF;\">";
			echo"<th width=\"2px\">No.</th><th>Nomor</th><th>NoLama</th><th>Nama</th><th>Alamat</th><th>Kondisi<br>Meter</th>";
			echo"</tr>";
			$i=0;
			while($i<$jml){
				$i++;
				echo"<tr>
				<td align=center>$i</td>
				<td align=center>$nomor[$i]</td>
				<td align=center>$nolama[$i]</td>
				<td align=left>$nama[$i]</td>
				<td align=left>$alamat[$i]</td>
				<td align=center>$kondisi_meter[$i]</td>
				</tr>";
			}
		}
		?>
                    </table>
                </div>
                </td>
           </tr>
     	</table>
							
        	  
		<!--############################################################################################################-->
	  </td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
