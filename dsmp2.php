<?php 
require_once("mydb.php");
sambung();
//ob_flush();
//set_time_limit(24000);
require_once("global_functions.php");


//begin proses bikin data periode lalu
$plalu=getPeriodeLalu();
$pkini=gperiode();
$peri="0101";

//$qry="insert into dsmp0(nomor,periode) select nomor,kode_blok from master where kode_blok='$peri' and putus='0' and not exists(select * from dsmp0 where periode='$plalu');";
$qry="insert ignore into dsmp0(nomor,periode) select nomor,periode_tipu from master where putus='0';";
$sql=mysql_query($qry) or die(mysql_error());
//if($ok=mysql_fetch_row($sql)){echo"sip";}

//$qry="update dsmp0 set angka=0 where periode is null";
//$sql=mysql_query($qry) or die(mysql_error());
//mysql_fetch_row($sql);

$qry="update dsmp0 set angka=0,periode=0 where (periode=0 OR periode IS NULL)";
$sql=mysql_query($qry) or die(mysql_error());
//mysql_fetch_row($sql);

$qry="update ignore dsmp0 set periode='$plalu' where periode=0";
$sql=mysql_query($qry) or die(mysql_error());
//mysql_fetch_row($sql);

$qry="delete from dsmp0 where periode=0";
$sql=mysql_query($qry) or die(mysql_error());

//mysql_fetch_row($sql);
//end prosses
//=========================================================================
//begin proses periode kini


//$qry="insert into dsmp0(nomor,periode) select nomor,kode_blok from master where kode_blok='$peri' and putus='0' and not exists(select * from dsmp0 where periode='$pkini');";
$qry="insert into dsmp0(nomor,periode) select nomor,periode_tipu from master where putus='0';";
$sql=mysql_query($qry) or die(mysql_error());
//if($ok=mysql_fetch_row($sql)){echo"sip";}

//$qry="update dsmp0 set angka=0 where periode is null";
//$sql=mysql_query($qry) or die(mysql_error());
//mysql_fetch_row($sql);

//$qry="update dsmp0 set angka=0 where periode=0";
$qry="update dsmp0 set angka=0,periode=0 where (periode=0 OR periode IS NULL)";
$sql=mysql_query($qry) or die(mysql_error());
//mysql_fetch_row($sql);

$qry="update ignore dsmp0 set periode='$pkini' where periode=0";
$sql=mysql_query($qry) or die(mysql_error());
//mysql_fetch_row($sql);

$qry="delete from dsmp0 where periode=0";
$sql=mysql_query($qry) or die(mysql_error());
/*
$qry="SELECT DISTINCT nomor,kondisi_meter,pakai_air_bln,periode_tipu FROM master WHERE putus='0'";
$sql=mysql_query($qry) or die(mysql_error());
$jl=mysql_num_rows($sql);
//echo $jl;
while($row=mysql_fetch_row($sql)){
//for($i=0;$i<=$jl;$i++){
	$nr1=$row[0];
	$kn1=$row[1];
	$pk1=$row[2];
	$pr1=$row[3];
	if($kn1=='1'){
		$q1="INSERT IGNORE INTO dsmp0(nomor,periode,angka)VALUES($nr1,$plalu,0);";
		$q2="INSERT IGNORE INTO dsmp0(nomor,periode,angka)VALUES($nr1,$pkini,0);";
	}else if($kn1=='2'){
		$q1="INSERT INTO dsmp0(nomor,periode,angka)VALUES($nr1,$plalu,0) ON DUPLICATE KEY UPDATE angka=0;";
		$q2="INSERT INTO dsmp0(nomor,periode,angka)VALUES($nr1,$pkini,0) ON DUPLICATE KEY UPDATE angka=0;";
	}else{
		$q1="INSERT INTO dsmp0(nomor,periode,angka)VALUES($nr1,$plalu,0) ON DUPLICATE KEY UPDATE angka=0;";
		$q2="INSERT INTO dsmp0(nomor,periode,angka)VALUES($nr1,$plalu,$pk1) ON DUPLICATE KEY UPDATE angka=$pk1;";
	}
	$sql1=mysql_query($q1) or die(mysql_error());
	$sql2=mysql_query($q2) or die(mysql_error());
}
//}
*/


//end proses
//=========================================================================
//begin simpan data
$tmp[]=0;
function simpan($idata){	
	$plalu=getPeriodeLalu();
	for ($j=1;$j<=$idata;$j++){ //untuk nomor pake input type hiden untuk tampung,,sip..!!!!!!!
		//$query="update dsmp0 set angka='".now."$i' where nomor='$tmp[$j]' and periode='$pkini'";
		$query="UPDATE dsmp0 AS a,dsmp0 AS b SET b.angka='".now."$i',a.angka='".lst."$i' where b.nomor='$tmp[$j]' AND a.nomor=b.nomor AND b.periode=$pkini AND a.periode=$plalu";
		$sql=mysql_query($query) or die(mysql_error());
		if ($sip=mysql_fetch_row($sql)){
			echo"<script language=\"javascript\">alert(\"Simpan data berhasil!\");</script>";
		}else{
			echo"<script language=\"javascript\">alert(\"Simpan data gagal!\");</script>";
		}
	}	
}

//end simpan data

//begin submit===================================
$tombol = "simpan";
$j=0;
if (isset($_POST['simpan'])){
	//echo"<script language=\"javascript\">alert('Simpan data berhasil!');<!--/script-->";
	$jum=strip_tags($_POST['jml']);	
	while($j<$jum){
		$j++;
		$ang[$j]=strip_tags($_POST['now'.$j]);
		//$angl[$j]=strip_tags($_POST['lst'.$j]);
		$nmr[$j]=strip_tags($_POST['num'.$j]);
		//$sql="update dsmp0 set angka=$ang[$j] where nomor='$nmr[$j]' and periode='$pkini';";
		//mysql_query($sql) or die(mysql_error());		
	}
	$j=0;
	while($j<$jum){
		$j++;
		//$ang[$j]=strip_tags($_POST['now'.$j]);
		//$nmr[$j]=strip_tags($_POST['num'.$j]);
		$sql="update dsmp0 set angka=$ang[$j] where nomor='$nmr[$j]' and periode=$pkini;";
		mysql_query($sql) or die(mysql_error());
		//$sql2="update dsmp0 set angka=$angl[$j] where nomor='$nmr[$j]' and periode=$plalu;";
		//mysql_query($sql2) or die(mysql_error());		
	}
	//echo "seles &nbsp; $j &nbsp;".$nmr[1]."-".$pkini."-".$ang[1];
	$j=0;
	
	//for($k=1;k<=$jum;$k++){
	//	$sql="update dsmp0 set angka=$ang[$k] where nomor='$nmr[$k]' and periode='$pkini';";
	//	mysql_query($sql) or die(mysql_error());
	//}
	
	//mysql_query("update billing.dsmp0 set angka=2233 where nomor='000001' and periode='201406';") or die(mysql_error());
	//if($lari=mysql_fetch_row($run)){
	//	echo "sip";
	//}else echo "payah";
}
//end submit=====================================

require_once("head.php");

?>

<script	type="text/javascript">
	function isNumb(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode				
		if (charCode > 31 && (charCode < 48 || charCode > 57)){
			return false;
		}
		return true;
	}
	
	function gpakai(lalu,kini,pakai){
		var l,k,p;
		l=parseInt(document.getElementById(lalu));
		k=parseInt(document.getElementById(kini));
		//p=document.getElementById(pakai);
		p=k.value-l.value;
		//p=document.getElementById(kini) - document.getElementById(lalu);
		document.getElementById(pakai).value=parseInt(p);
		
	}
	
	function submit_me(){
		//alert("submit me");
		fentry.submit();
		//document.getElementById('fentry').submit();
	}
	
	function validasi(frm0){
		if(window.confirm('Yakin untuk simpan data?')==true){
			return true;			
		}else {
			return false;
		}
	}
	
</script>

	<style>
		//html{background:#84eeee;}
		/* This only works with JavaScript, 
		   if it's not present, don't show loader */
		.no-js #loader { display: none;  }
		.js #loader {  display: block; position: fixed; left: 50%; top: 50%; right:50%; bottom:50%; }		
	</style>	
	
	<script src="js/jquery.min.js"></script>
	<script src="js/modernizr.js"></script>
	<script>
		// Wait for window load
		$(window).load(function() {
			$('#loader').fadeOut(2000);
		});
		
	</script>

	<tr>
		<td class="no-js">	
		<img src="icon_loading.gif" id="loader"></img>
		<!---->
		<div align="center" style="padding:2px 0;text-shadow:4px -4px 2px red;color:#ff0;font-size:19px;"><b>Isi / Koreksi Stand Meter <?php echo gperiode();?></b></div>
		<table width="1000px" border="0" cellpadding="2" cellspacing="5" bgcolor="#FFFFFF" align="center" class="wrapper1">
			<form id="fkrit" action="" method="post">
			<tr>
				<td bgcolor="#eee">
					<input type="radio" name="r2" value="0">Semua Kondisi<br />
					<input type="radio" name="r2" value="1" checked="checked">Kondisi Meter&nbsp;
					<select name="optkondisiwm" id="optkondisiwm" onClick="fkrit.r2.checked='checked'">
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select kode_kondisi,ket_kondisi from meter_kondisi");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
				<td bgcolor="#eee">
					<input type="radio" name="r3" value="dkd">DKD/ Jalan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<select id="optdkd" name="optdkd" >
						<option value="" selected="selected">--Pilih--</option>
						<?php
						$sql=mysql_query("select dkd,jalan from dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>	
					</select>
					<br />
					<input type="radio" name="r3" value="blok" checked="checked">BLOK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<select name="optblok" id="optblok">
                      <option>--Pilih--</option>
                      <?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("select * from master_blok order by kode_blok");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_blok]\">$p[kode_blok]</option>\n";
						}
						?>
                    </select>
					<br />
					<input type="radio" name="r3" value="nomor">Nomor/NoLama
					<input type="text" name="txnomor" size="13" maxlength="13" onKeyPress="return isNumb(event);">				</td>
				<td bgcolor="#eee">
					Auto-sort by:<br />
					<input type="radio" name="r4" value="nomor">Nomor<br />
					<input type="radio" name="r4" value="nolama" checked="checked">No. Lama<br />
					<input type="radio" name="r4" value="rute">Rute Baca				</td>
				<td bgcolor="#eee">
					Tampilkan:<br />
					<input type="radio" name="r5" value="semua" checked="checked">Semua<br />
					<input type="radio" name="r5" value="terisi">Terisi<br />
					<input type="radio" name="r5" value="kosong">Kosong/ Minus				</td>
			</tr>
			<tr>
				<td colspan="4" align="right" bgcolor="#eee"><input type="submit" name="proses" value="Proses" />&nbsp;<input type="reset" value="Reset" /></td>
			</tr>
			</form>
			
			<form id="fentry" name="fentry" method="post" action="" onSubmit="return validasi(this);">
			<tr>
				<td colspan="4" align="center" bgcolor="#0f0">
					<div style="height:500px;overflow:auto">
					<table width="100%" border="1" bordercolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:11px;">
						<tr align="center" style="color:#fff;background:#99ccff;font-size:11px;font-family:calibri;text-transform:uppercase">
							<td colspan="4">Data Pelanggan</td>
							<td colspan="3">Stand Meter</td>
							<td colspan="2">Kondisi Water Meter</td>							
						</tr>
						<tr align="center" style="color:#fff;background:#99ccff;font-size:11px;font-family:calibri">
							<td width="20px">No.</td>
							<td width="40px">Nomor</td>
							<td width="60px">No.Lama</td>
							<td width="150px">Nama</td>
							<td width="60px"><?php echo getBulan(date("m")-1);?></td>
							<td width="60px"><?php echo getBulan(date("m"));?></td>
							<td width="60px">Pakai</td>
							<td>Kode</td>
							<td>Keterangan</td>
						</tr>						
						<?php
							//$query=mysql_query("select nomor,nolama,nama from master where putus='0' and kondisi_meter='1' and kode_blok='0101' order by nolama;") or die(mysql_error());
							//$query=mysql_query("select master.nomor,master.nolama,master.nama,dsmp0.angka from master,dsmp0 where master.putus='0' and master.kondisi_meter='1' and master.kode_blok='0101' and dsmp0.nomor=master.nomor and dsmp0.periode='$plalu' order by master.nolama;") or die(mysql_error());
						
						$slipit=" WHERE a.nomor=b.nomor AND b.nomor=m.nomor AND a.periode=$plalu AND b.periode=$pkini AND m.putus='0' ";						
						$key="";//fungsi refresh tiap kali posting/getting
						$autosort="";$kondisiwm="";
						if(isset($_POST['optkondisiwm']))$kondisiwm=$_POST['optkondisiwm'];
						if(isset($_POST["proses"])){
							$kondisi=$_POST["r2"];
							switch($kondisi){
								case "0":
									//$slipit="";
									break;
								case "1":
									if(($key=$_POST['optkondisiwm']) !="")$slipit=cek_slip($slipit)."m.kondisi_meter='$key'";
									echo"<script type='text/javascript'>document.getElementById('optkondisiwm').value='$key';</script>";
									break;
							}
							
							switch($nmr=$_POST['r3']){
								case"dkd":
									if(($key=$_POST['optdkd']) !="")$slipit=cek_slip($slipit)."m.dkd='$key'";
									echo"<script type='text/javascript'>document.getElementById('optdkd').value='$key';</script>";
									break;
								case"blok":
									if(($key=$_POST['optblok']) !="")$slipit=cek_slip($slipit)."m.kode_blok='$key'";
									echo"<script type='text/javascript'>document.getElementById('optblok').value='$key';</script>";
									break;
								case"nomor":
									if(($key=$_POST['txnomor']) !="")$slipit=cek_slip($slipit)."(m.nomor='$key' OR m.nolama='$key')";
									echo"<script type='text/javascript'>document.getElementById('txnomor').value='$key';</script>";
									break;
							}
							
							switch($_POST['r5']){
								case"semua":
									//$slipit.=cek_slip($slipit)."";
									break;
								case"terisi":
									$slipit.=" AND b.angka>0";
									//echo"<!--script type='text/javascript'>document.getElementById('r5').value='$key';</script-->";
									break;
								case"kosong":
									$slipit.=" AND (a.angka>b.angka) AND (b.angka-a.angka<1)";
									break;
							}
							
							//$obay=""; =============slip terakhir
							//switch($nmr=$_POST['r4']){
							$sordby=$_POST['r4'];
							switch($sordby){
								case"nomor":
									$slipit .=" ORDER BY m.nomor";
									break;
								case"nolama":
									$slipit .=" ORDER BY m.nolama";
									break;
								case"rute":
									$slipit .=" ORDER BY m.dkd";
									break;								
							}				
														
							$sql="SELECT m.nomor,m.nolama,m.nama,a.angka,b.angka,m.dkd FROM master AS m,dsmp0 AS a,dsmp0 AS b $slipit ;";
							//echo $sql;
							$query=mysql_query($sql) or die(mysql_error());
							$tmp[]=0;
							$i=0;
							//$perd=gperiode();
							while($row=mysql_fetch_row($query)){
								$i++;
								if ($i%2==0){echo"<tr bgcolor=\"#eee\">";}else{echo"<tr>";}
								echo"<td align=\"right\">$i</td>";
								echo"<td align=\"center\">".$row[0]."<input name=\"num"."$i\" value=\"".$row[0]."\" type=\"hidden\"></td>";							
								$tmp[$i]=$row[0];
								$a1=trim($row[3]);
								$a2=trim($row[4]);
								$a3=$a2-$a1;
								//$qry=mysql_query("select angka from dsmp where periode=201405 and nomor='$row[0]'");
								//if ($hsl=mysql_fetch_row($qry)){$lalu=$hsl[0];}else{$lalu=0;}
								echo"<td align=\"center\">".$row[1]."</td>";
								echo"<td>".$row[2]."</td>";
								if($kondisiwm=='1'){
                                	echo"<td><input type=\"text\" style=\"text-align:right;\" text-align=\"right\" name=\"lst"."$i\" value=\"$a1\" size=\"6\" readonly disabled=\"disabled\" /></td>";
                                    echo"<td><input type=\"text\" style=\"text-align:right;\" name=\"now"."$i\" value=\"$a2\" size=\"6\" onChange=\"pk"."$i.value=\"now"."$i.value - lst"."$i.value\"  onKeyPress=\"pk"."$i.value=now"."$i.value - lst"."$i.value\"   onKeyDown=\"pk"."$i.value=now"."$i.value - lst"."$i.value\" onMouseMove=\"pk"."$i.value=now"."$i.value - lst"."$i.value\" onFocus=\"pk"."$i.value=now"."$i.value - lst"."$i.value\" readonly/></td>";
                                    echo"<td><input type=\"text\" style=\"text-align:right;\" name=\"pk"."$i\" value=\"$a3\" size=\"6\" readonly disabled=\"disabled\" /></td>";
                                }else if($kondisiwm=='2'){
                                	echo"<td><input type=\"text\" style=\"text-align:right;\" text-align=\"right\" name=\"lst"."$i\" value=\"$a1\" size=\"6\" readonly disabled=\"disabled\" /></td>";
                                    echo"<td><input type=\"text\" style=\"text-align:right;\" name=\"now"."$i\" value=\"$a1\" size=\"6\" onChange=\"pk"."$i.value=\"now"."$i.value - lst"."$i.value\"  onKeyPress=\"pk"."$i.value=now"."$i.value - lst"."$i.value\"   onKeyDown=\"pk"."$i.value=now"."$i.value - lst"."$i.value\" onMouseMove=\"pk"."$i.value=now"."$i.value - lst"."$i.value\" onFocus=\"pk"."$i.value=now"."$i.value - lst"."$i.value\" /></td>";
                                    echo"<td><input type=\"text\" style=\"text-align:right;\" name=\"pk"."$i\" value=\"0\" size=\"6\" readonly disabled=\"disabled\" /></td>";
                                }else{
                                	echo"<td><input type=\"text\" style=\"text-align:right;\" text-align=\"right\" name=\"lst"."$i\" value=\"0\" size=\"6\" readonly disabled=\"disabled\" /></td>";
                                    echo"<td><input type=\"text\" style=\"text-align:right;\" name=\"now"."$i\" value=\"$a1\" size=\"6\" onChange=\"pk"."$i.value=\"now"."$i.value - lst"."$i.value\"  onKeyPress=\"pk"."$i.value=now"."$i.value - lst"."$i.value\"   onKeyDown=\"pk"."$i.value=now"."$i.value - lst"."$i.value\" onMouseMove=\"pk"."$i.value=now"."$i.value - lst"."$i.value\" onFocus=\"pk"."$i.value=now"."$i.value - lst"."$i.value\" /></td>";
                                    echo"<td><input type=\"text\" style=\"text-align:right;\" name=\"pk"."$i\" value=\"$a1\" size=\"6\" readonly disabled=\"disabled\" /></td>";
                                }
								//echo"<td><div style=\"text-align:right;\" text-align=\"right\" name=\"".lst."$i\"/>0</div></td>";
								//$qry=mysql_query("select angka from dsmp where periode='$perd' and nomor='$tmp[$i]'");
								//if ($hsl=mysql_fetch_row($qry)){$mtr=$hsl[0];}else{$mtr=0;}
								
								//echo"<td><input type=\"text\" style=\"text-align:right;\" name=\"pk"."$i\" value=\"$a3\" size=\"6\" readonly disabled=\"disabled\" /></td>";                                
                                
								echo"<td></td>";
								echo"<td></td>";
								echo"</tr>";
							}
							echo"<input name=\"jml\" type=\"hidden\" value=\"$i\">";
						
						}
						
						?>						
					</table>
					</div>				</td>
			</tr>
			<tr>
				<td colspan="4" align="left" bgcolor="#99ccff">
					<!--a href="dsmp.php?aksi=save">Save</a-->
					&nbsp;
					<input name="<?php echo $tombol; ?>" id="Simpan" type="submit" value="Simpan" class="button2" onClick="document.fentry.submit();" />&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" value="Batal" class="button2" onClick="this.form.reset()" />&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;<!--a style="font-family:arial;font-size:12px" href="#">Cetak&nbsp;<?php echo $i?></a-->				</td>	
			</tr>
			</form>
		</table>
		<!---->		
		</td>
	</tr>
	
<?php
putus();
require_once("foot.php");
?>