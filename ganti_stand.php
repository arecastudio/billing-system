<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
//ini_set('max_execution_time', 2500); //300 seconds = 5 minutes

require_once("head.php");//mysql_num_rows();
//---HISTORY DSMP
$nloket="JPR[".php_uname('n')."]";//"JPR";
$operator=$_SESSION['nama_user'];
?>

	<tr>
		<td><br />
		<p></p>
		
		<table width="500px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form name="fcari" method="post" action="">
            <tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
              <td colspan="2"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>.:: Koreksi Status & Angka Meter Lalu ::.</b></font></center></td>
              </tr>
            <tr>
				<td width="120">Nomor Pelanggan</td>
				<td>
                	<input type="text" name="txnomor" id="txnomor" size="10" maxlength="13" onkeypress="return isNumb(event);" />
                    <input type="submit" name="cari" value="Tampilkan!" class="kelas_tombol"/>                </td>
			</tr>
            </form>
            
            <?php
            if(isset($_POST["cari"])){
				//$dapat=false;
				$plalu=getPeriodeLalu();
				$nmr=$_POST['txnomor'];
				$sql="
				SELECT m.nomor,m.nolama,m.nama,m.alamat,m.gol,(SELECT DISTINCT keterangan FROM tarif AS f WHERE f.gol=m.gol LIMIT 0,1)as ngol,m.cabang,c.nama as cnama,m.kode_wilayah,w.nama_wilayah,m.dkd,d.jalan,m.kondisi_meter,IFNULL(ds.angka,0)
				FROM master AS m
				LEFT OUTER JOIN cabang AS c ON c.cabang=m.cabang
				LEFT OUTER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah AND w.kode_cabang=m.cabang
				LEFT OUTER JOIN dkd AS d ON d.dkd=m.dkd
				LEFT OUTER JOIN dsmp_new AS ds ON ds.nomor=m.nomor AND ds.periode=$plalu
				WHERE (m.nomor='$nmr' OR m.nolama='$nmr')
				LIMIT 0,1
				;";
				$qry=mysql_query($sql)or die(mysql_error());
				if($row=mysql_fetch_row($qry)){
					$dapat=true;
					$nomor=$row[0];
					$nolama=$row[1];
					$nama=$row[2];
					$alamat=$row[3];
					$gol=$row[4]." - ".$row[5];
					$cabang=$row[6]." - ".$row[7];
					$wilayah=$row[8]." - ".$row[9];
					$dkd=$row[10]." - ".$row[11];
					$kondisiwm=$row[12];
					$angka=$row[13];
					
					echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").value=\"$nmr\";</script>";
				}else{
					$dapat=false;
					echo"<script type=\"text/javascript\">alert('Data tidak ditemukan\nAtau Kondisi Meter bukan Aktif!');</script>";
				}
			}
			?>
                        
			<tr>
				<td>Pelanggan</td>
				<td>:&nbsp;<?php if(isset($_POST['cari']) && $dapat==true) echo"$nomor / $nolama - $nama"; ?></td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:&nbsp;<?php if(isset($_POST['cari']) && $dapat==true) echo"$alamat"; ?></td>
			</tr>
			<tr>
				<td>Golongan</td>
				<td>:&nbsp;<?php if(isset($_POST['cari']) && $dapat==true) echo"$gol"; ?></td>
			</tr>
			<tr>
				<td>Cabang</td>
				<td>:&nbsp;<?php if(isset($_POST['cari']) && $dapat==true) echo"$cabang"; ?></td>
			</tr>
			<tr>
				<td>Wilayah</td>
				<td>:&nbsp;<?php if(isset($_POST['cari']) && $dapat==true) echo"$wilayah"; ?></td>
			</tr>
			<tr>
				<td>DKD</td>
				<td>:&nbsp;<?php if(isset($_POST['cari']) && $dapat==true) echo"$dkd"; ?><hr /></td>
			</tr>
            <!--tr>
				<td>Status Aktif</td>
                <td>
                	<input type="radio" name="r1" value="1" checked="checked" />Aktif &nbsp;&nbsp;
                    <input type="radio" name="r1" value="3"/>Non Aktif
                </td>
            </tr-->
            <form name="fkoreksi" method="post" action="">
            <tr>
				<td>Periode</td>
				<td>
					<select name="optperiode" id="optperiode">
						<option value="<?php echo getPeriodeLalu() ;?>"><?php echo getPeriodeLalu() ;?></option>
						<?php
							/*$prd0=gperiode();//$row[0];
							while($prd0>=200001){
								echo"<option value=\"$prd0\">$prd0</option>";
								$prd0--;//201405 201404 201001 201000 200912
								if(substr($prd0,4,2)==00)$prd0-=88;
							}*/							
						?>
					</select>
                    
                    <input type="hidden" name="txh_nomor" id="txh_nomor" value="<?php if(isset($_POST['cari']) && $dapat==true) echo"$nomor"; ?>" />				</td>
			</tr>
            <tr>
				<td>Kondisi Meter</td>
				<td>
				<input type="hidden" id="kwm_lama" name="kwm_lama" />
					<select name="optkwm" id="optkwm" >
						<!--option value="" selected="selected">--Pilih--</option>
                        <option value="1">1 - Meter Baik</option>
                        <option value="2">2 - Meter Segel</option>
                        <option value="3">3 - Meter Rusak</option>
                        <option value="4">4 - Tanpa Meter</option-->
					
                    <?php
                    if(isset($_POST['cari']) && $dapat==true) {
						
						
									/*if ($kondisiwm=='2'){
										echo"<option value=\"2\">2 - METER SEGEL</option>";
									}else{
										echo"<option value=\"\" selected=\"selected\">--Pilih--</option>
                                        <option value=\"1\">1 - METER BAIK</option>                                        
                                        <option value=\"3\">3 - METER RUSAK</option>
                                        <option value=\"4\">4 - TANPA METER</option>";
									}*/
									switch ($kondisiwm) {
										case '4':
											# code...
											echo"<option value=\"4\">4 - TANPA METER</option>";
											break;
										case '3':
											echo "<option value=\"3\">3 - METER RUSAK</option>";
											break;
										case '2':
											# code...
											echo"<option value=\"2\">2 - METER SEGEL</option>";
											break;
										default:
											# code...
											echo "<option value=\"1\">1 - METER BAIK</option>";
											break;
									}
						
						echo"<script type=\"text/javascript\">document.getElementById(\"optkwm\").value=\"$kondisiwm\";</script>";
						echo"<script type=\"text/javascript\">document.getElementById(\"kwm_lama\").value=\"$kondisiwm\";</script>";
					}
					?> 
					</select>
					

                    <hr/>				</td>
			</tr>
			<tr>
				<td>Alasan Koreksi</td>
				<td>
					<select name="optsebab" id="optsebab" >
						<!--option value="">--Pilih--</option-->
						<?php
						$sql=mysql_query("select kabnorm,keterangan from abnormal where kabnorm<>0 order by kabnorm");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td>Angka Koreksi</td>
				<td><input type="text" name="txkorek" id="txkorek" size="6" style="text-align:right;"  onKeyPress="return isNumb(event);" /></td>
                <?php if(isset($_POST['cari']) && $dapat==true){
				echo"<script type=\"text/javascript\">document.getElementById(\"txkorek\").value=\"$angka\";</script>";
				// ---HISTORY DSMP
				echo"<input type=\"hidden\" name=\"hangka\" value=\"$angka\" />";
				}
				?>
			</tr>
			<tr>				
				<td colspan="2" align="center"><br /><br /><br />
					<input type="submit" name="simpan" value="Simpan" class="kelas_tombol" />
					<input type="submit" name="batal" value="Batal" class="kelas_tombol" />				</td>
			</tr>
            </form>
		</table>
		<br />
        <fieldset style="background-color:#f0f0f0;font:'Courier New', Courier, monospace;font-size:11px;color:#609;">
        	<p>
            	Keterangan:<br/>
                Perubahan <i>Angka Koreksi</i> <u>hanya</u> berlaku untuk Data Pelanggan dengan status kondisi <i>1 - METER BAIK</i><br/>
                Sedangkan, perubahan <i>Kondisi Meter</i> ke kondisi Non-Meter atau <b>selain</b> kondisi <i>1 - METER BAIK</i> akan mengabaikan nilai <i>Angka Koreksi</i>.
            </p>
        </fieldset><br />
        <a href="averageusage.php" style="color:#00f;">Pemakanan Air [Non-Meter]</a>
		<?php
		date_default_timezone_set('Asia/Jayapura');
        if(isset($_POST['batal'])){
			//echo"<!--script type=\"text/javascript\">document.getElementById(\"optsebab\").value=\"--\";</script-->";
			header("location: ganti_stand.php");
		}else if(isset($_POST['simpan'])){			
			$nomor=$_POST['txh_nomor'];
			$periode=$_POST['optperiode'];
			$kwm=$_POST['optkwm'];			
			$kwm_lama=$_POST['kwm_lama'];			
			$arg=$_POST['optsebab'];
			$angka=$_POST['txkorek'];
			$hangka=$_POST['hangka'];
			if($operator=="")$operator="test";
			$tgl=date('Y-m-d',time());
			$jam=date('H:i:s',time());
			//$jam=$_SERVER['REQUEST_TIME'];
			
			//echo $jam."<br/>$nomor<br/>$periode<br/>$angka<br/>$arg<br/>$kwm<br/>$operator<br/>$tgl<br/>";
			if(!(empty($nomor) && empty($periode) && empty($kwm) && empty($arg) && empty($angka) && empty($operator) && empty($tgl) && empty($jam))){
				//echo"$nomor";
				if($kwm!="1")$angka=0;
				$sql="
				UPDATE dsmp_new AS d, master AS m
				SET d.angka=$angka,m.kondisi_meter=$kwm
				WHERE d.nomor='$nomor' AND d.periode=$periode AND m.nomor='$nomor'
				;";
				$qry=mysql_query($sql)or die(mysql_error());
				if($qry) echo"<script type=\"text/javascript\">alert('Data tersimpan!');</script>";
			}
			
			if($angka!=$hangka){
				$sql="INSERT INTO his_dsmp0(nomor,nolama,periode,angka_awal,angka_akhir,operator,loket,tgl,jam)VALUES('$nomor',(SELECT DISTINCT nolama FROM master WHERE nomor='$nomor'),$periode,$hangka,$angka,'$operator','$nloket',curdate(),curtime()) ON DUPLICATE KEY UPDATE angka_akhir=$angka,jam=curtime();";
				mysql_query($sql) or die(mysql_error());
				//hapus data perubahan yang kembali ke angka awal karena tidak dibutuhkan lagi historinya
				mysql_query("DELETE FROM his_dsmp0 WHERE angka_awal=angka_akhir;") or die(mysql_error());
			}

			$sql99="
	        INSERT INTO ubah_kwm(nomor,tgl,jam,lama,baru,operator,loket)
	        VALUES('$nomor','$tgl','$jam','$kwm_lama','$kwm','$operator','$nloket')
	        ON DUPLICATE KEY UPDATE baru='$kwm',jam='$jam',operator='$operator',loket='$nloket'
	        ;";        
	        if($kwm_lama!=$kwm)$query99=mysql_query($sql99)or die(mysql_error());

		}
		?>
		</td>
	</tr>
	
<?php
putus();
require_once("foot.php");
?>
