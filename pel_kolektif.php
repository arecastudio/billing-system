<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');
?>


<?php

$dapat=false;
if(isset($_POST['tampilkan']) && trim($_POST['txkokol']!='')){
	//echo"menampilkan";	
	$kokol=trim($_POST['txkokol']);
	$sql="
	SELECT DISTINCT ket_kolektif,alamat_kolektif,kode_cabang,kode_wilayah,kode_blok,dkd,penanggung_jawab,telp,kode_jenis_pel
	FROM pel_kolektif
	WHERE kode_kolektif='$kokol'
	LIMIT 1
	;";
	$qry=mysql_query($sql)or die(mysql_error());
	if($brs=mysql_fetch_row($qry)){
		$dapat=true;
		$ket=trim($brs[0]);
		$alm=trim($brs[1]);
		
		$cbg=trim($brs[2]);
		$wil=trim($brs[3]);
		$blk=trim($brs[4]);
		$dkd=trim($brs[5]);
		
		$pjw=trim($brs[6]);
		$tlp=trim($brs[7]);
		$pel_jenis=trim($brs[8]);
	}
}elseif(isset($_POST['simpan']) && trim($_POST['txkokol'])!=''){	
	$kokol=$_POST['txkokol'];
	$ket=$_POST['txket'];
	$cbg=$_POST['optcabang'];
	$wil=$_POST['optwilayah'];
	$blok=$_POST['optblok'];
	$dkd=$_POST['optdkd'];
	$alamat=$_POST['txalamat'];
	$acc=$_POST['txacc'];
	$tlp=$_POST['txtelp'];
	$pel_jenis=$_POST['pel_jenis'];
	
	$sql="
	INSERT INTO pel_kolektif(kode_kolektif,ket_kolektif,alamat_kolektif,kode_cabang,kode_wilayah,kode_blok,dkd,penanggung_jawab,telp,kode_jenis_pel)
	values('$kokol','$ket','$cbg','$wil','$blok','$dkd','$alamat','$acc','$tlp','$pel_jenis')
	ON DUPLICATE KEY UPDATE ket_kolektif='$ket', alamat_kolektif='$alamat',kode_cabang='$cbg',kode_wilayah='$wil',kode_blok='$blok',dkd='$dkd',penanggung_jawab='$acc',telp='$tlp',kode_jenis_pel='$pel_jenis'
	";
	mysql_query($sql)or die(mysql_error());
}
?>

	<tr>
		<td>
			<!--############################################################################################################-->
            <br/>
            
			<table width="720px" border="0" cellpadding="0" cellspacing="1" bgcolor="#fff" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
            	<form name="f1" method="post" action="">
                <tr>
                	<th colspan="4" align="center" style="font-family:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">Pelanggan Kolektif</th>
                </tr>
				<tr>
                	<th colspan="4" bgcolor="#d0d0d0" align="left">Identitas Kolektif</th>
                </tr>
                <tr>
                	<td width="80px">&nbsp;Kode Kolektif</td>
                    <td colspan="3">
						<input type="text" name="txkokol" id="txkokol" size="2" maxlength="3" onkeypress="return isNumb(event);" value="<?php if($dapat==true){echo $kokol;}?>" />
						&nbsp;<input type="submit" id="tampilkan" name="tampilkan" value="Tampilkan!" class="kelas_tombol" />
					</td>                    
                </tr>
                <tr>
                	<td>&nbsp;Keterangan</td>
                    <td colspan="3"><input type="text" name="txket" id="txket" size="50" maxlength="50" value="<?php //if($dapat==true){echo $ket;}?>" />
&nbsp;&nbsp;&nbsp;&nbsp;&rarr;

<select name="pel_jenis" id="pel_jenis">
<?php
$sql=mysql_query("SELECT kode_jenis_pel,ket_jenis_pel FROM pel_jenis WHERE 1;")or die(mysql_error());
while($row=mysql_fetch_row($sql)){
	echo"
	<option value=\"$row[0]\">$row[0] - $row[1]</option>
";
}
?>
</select>

</td>
                </tr>
                <tr>
                	<td>&nbsp;Cabang</td>
                    <td>
                    	<select name="optcabang" id="optcabang" >
                          <!--option value="" selected="selected">--Pilih--</option-->
                          <?php
                          $sql=mysql_query("SELECT cabang,nama FROM cabang WHERE cabang<>'001' ORDER BY cabang");
                          while($row=mysql_fetch_row($sql)){
                            echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
                          }
                          ?>
                        </select>
                    </td>
                    <td>&nbsp;Wilayah</td>
                    <td>
                    	<select name="optwilayah" id="optwilayah">
                     	<!--option value="" selected="selected">--Pilih Wilayah--</option-->
        			   	<?php
                        //mengambil nama-nama wilayah yang ada di database
                        $wilayah = mysql_query("SELECT kode_cabang,kode_wilayah,nama_wilayah FROM master_wilayah WHERE kode_wilayah<>'' ORDER BY kode_wilayah;");
                        while($p=mysql_fetch_array($wilayah)){
                        	echo "<option value=\"$p[kode_wilayah]\">$p[nama_wilayah]</option>\n";
                        }
		                ?>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td>&nbsp;Blok</td>
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
                        </select>
                    </td>
                    <td>&nbsp;[DKD]</td>
                    <td>
                    	<select id="optdkd" name="optdkd" onchange="setalamat();" >
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select dkd,jalan from dkd order by dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                        </select> 
                    </td>
                </tr>
                <tr>
                	<td>&nbsp;Alamat</td>
                    <td colspan="3"><input type="text" name="txalamat" id="txalamat" size="50" maxlength="70" value="<?php //if($dapat==true){echo $alm;}?>" /></td>
                    <!--td>&nbsp;</td>
                    <td>&nbsp;</td-->
                </tr>
                <tr>
                	<td>&nbsp;Penanggung-jawab</td>
                    <td><input type="text" name="txacc" id="txacc" size="25" maxlength="30" value="<?php //if($dapat==true){echo $pjw;}?>" /></td>
                    <td>&nbsp;Telp.</td>
                    <td><input type="text" name="txtelp" id="txtelp" size="12" maxlength="12" onkeypress="return isNumb(event);" value="<?php //if($dapat==true){echo $tlp;}?>" /></td>
                </tr>
                <tr align="right">
                	<td align="left"><input type="<?php if($dapat==true){echo'button';}else{echo'hidden';}?>" name="input_member" value="Input Member" class="kelas_tombol" onClick="window.open('pel_kolektif_d.php?nomor=<?php echo $kokol;?>','popUpWindow','height=400,width=800,left=10,top=10,scrollbars=yes,menubar=no');" /></td>
					<td colspan="3"><input type="submit" name="simpan" value="Simpan" class="kelas_tombol" />&nbsp;<input type="reset" name="batal" value="Batal" class="kelas_tombol" />&nbsp;&nbsp;<input type="submit" name="hapus" value="Hapus" class="kelas_tombol" /></td>
                    <!--td>&nbsp;</td>                    
                    <td>&nbsp;</td-->
                </tr>
                </form>
            </table>
			
			<?php
			if($dapat==true){
			echo"
			<script type=\"text/javascript\">document.getElementById(\"txkokol\").value=\"$kokol\";</script>
			<script type=\"text/javascript\">document.getElementById(\"txket\").value=\"$ket\";</script>
			<script type=\"text/javascript\">document.getElementById(\"txalamat\").value=\"$alm\";</script>
			
			<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cbg\";</script>
			<script type=\"text/javascript\">document.getElementById(\"optwilayah\").value=\"$wil\";</script>
			<script type=\"text/javascript\">document.getElementById(\"optblok\").value=\"$blk\";</script>
			<script type=\"text/javascript\">document.getElementById(\"optdkd\").value=\"$dkd\";</script>
			
			<script type=\"text/javascript\">document.getElementById(\"txacc\").value=\"$pjw\";</script>
			<script type=\"text/javascript\">document.getElementById(\"txtelp\").value=\"$tlp\";</script>
			<script type=\"text/javascript\">document.getElementById(\"pel_jenis\").value=\"$pel_jenis\";</script>
			";
			}
			?>
			
			<!--############################################################################################################-->
			<i style="color:#c00;font-family:calibri;font-size:12px;">Tips:&nbsp;&nbsp;Klik pada <b>kode_kolektif</b> untuk menampilkan form pengisian <b>member_kolektif</b> !</i>
			<table width="1050px" align="center" border="0" cellpadding="2" cellspacing="1" class="rounded" bgcolor="#ccc">			
            <tr>
				<td width="100%" align="center" colspan="3">
					<div style="height:400px;overflow:auto">						
                        <table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffd;font-family:calibri;font-size:12px;" >
							<tr style=\"color:#000;background:linear-gradient(#fff,#888);\">
								<!--th>No.</th-->
								<th rowspan="2">Kode</th>
								<th rowspan="2">Keterangan</th>
								<th rowspan="2">Alamat</th>
								<th rowspan="2">Cbg</th>
								<th rowspan="2">Wil</th>
								<th rowspan="2">Blok</th>
								<th rowspan="2">DKD</th>
								<th rowspan="2">Operator</th>
								<th rowspan="2">No. Tlp</th>
								<th colspan="4">Collective Member(s)</th>
							</tr>
                            <tr style=\"color:#000;background:linear-gradient(#fff,#888);\">
								<th>No.</th>
								<th>Nomor</th>
								<th width="70px">NoLama</th>
								<th>Nama ~ Alamat</th>
							</tr>
							<?php
							$sql="
							SELECT kode_kolektif,trim(SUBSTR(ket_kolektif,1,25)),trim(SUBSTR(alamat_kolektif,1,20)),kode_cabang,kode_wilayah,kode_blok,dkd,penanggung_jawab,telp
							FROM pel_kolektif
							ORDER BY kode_kolektif ASC
							;";
							$i=0;$kd_kol="";$j=0;
							$qry=mysql_query($sql);
							while($row=mysql_fetch_row($qry)){
								$i++;
								if($i%2==0){
									$wrn="#ccf";
								}else{
									$wrn="#ffc";
								}
								$kd_kol=trim($row[0]);
								echo"<tr bgcolor=\"$wrn\" valign=\"top\">";
								echo"								
									<form name=\"f2\" method=\"post\" action=\"\" >
									<input type=\"hidden\" name=\"txkode\" id=\"txkode\" value=\"$kd_kol\">
									<td align=\"center\" style=\"color:#f00;font-size:14px;font-weight:bold;font-family:times;cursor:pointer;\" onClick=\"window.open('cari.php','Google Inc.','menubar=no,width=700,height=500,toolbar=no,location=no,status=no,scrollbar=yes');\" >".trim($row[0])."</td>
									</form>
									<td>".trim($row[1])."</td>
									<td>".trim($row[2])."</td>
									<td align=\"center\">".trim($row[3])."</td>
									<td align=\"center\">".trim($row[4])."</td>
									<td align=\"center\">".trim($row[5])."</td>
									<td align=\"center\">".trim($row[6])."</td>
									<td>".trim($row[7])."</td>
									<td align=\"center\">".trim($row[8])."</td>
								
								";
								
								$sql_member="
								SELECT DISTINCT p.nomor,IFNULL(m.nolama,'<i style=\"color:#f00;\">###NULL###</i>'),IFNULL(m.nama,'<i style=\"color:#f00;\">###NULL###</i>'),IFNULL(SUBSTR(m.alamat,1,10),'<i style=\"color:#f00;\">###NULL###</i>')
								FROM pel_kolektif_d AS p
								LEFT OUTER JOIN master AS m ON m.nomor=p.nomor
								WHERE p.kode_kolektif='$kd_kol'
								ORDER BY m.nolama ASC
								;";
								$j=0;$new=true;
								echo"<td colspan=5>";
								$qry_member=mysql_query($sql_member)or die("err_member: ".mysql_error());
								while($rows=mysql_fetch_row($qry_member)){
									$j++;
									if($j>99){
										echo $j."&nbsp;&nbsp;";
									}elseif($j>9){
										echo "0".$j."&nbsp;&nbsp;";
									}else{
										echo "00".$j."&nbsp;&nbsp;";
									}
									/*if($new=true && $j==1){
										echo"</td><td>";
									}*/
									echo trim($rows[0])."&nbsp;&nbsp;";
									
									echo trim($rows[1])."&nbsp;&nbsp;";
									
									echo trim($rows[2])." <b style=\"color:#070;\">#</b> ".trim($rows[3])."<br>";
									
									$new=false;
								}
								echo"</td>";
								echo"</tr>";
							}
							
							?>
						</table>
					</div>
				</td>
			</tr>
			</table>
			
			
		</td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
