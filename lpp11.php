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

	<tr>
		<td>
		<!--############################################################################################################-->
		
		<p align="center"><font face="Arial,sans-serif" size="4px"><b>Laporan Penerimaan & Penagihan [LPP]</b></font></p>		
		<table width="920px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
          <form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr>
              <td>Periode Rek. </td>
              <td><!--input type="radio" name="rjenis" id="rjenis" value="rjnow" />
                Rek. bln ini&nbsp;&nbsp;
                <input type="radio" name="rjenis" id="rjenis" value="rjtill" />
                Rek. sblm bln lalu &nbsp;&nbsp;
				<input type="radio" name="rjenis" id="rjenis" value="rjall" checked="checked" />
				Semua Rek.</td-->
                <!--########################################################################################-->
                <select name="optperiode" >
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						//$sql=mysql_query("select distinct periode from rekening1 order by periode desc");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						//if($row=mysql_fetch_row($sql)){
							//$i=0;
							$prd0=gperiode();//$row[0];
							$prd1=200001;
							while($prd1<=$prd0){
								echo"<option value=\"$prd1\">$prd1</option>";
								$prd1++;//201405 201404 201001 201000 200912
								if(substr($prd1,4,2)==13)$prd1+=88;
							}
							//echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						//}
					?>
                </select>
                &nbsp;s/d&nbsp;
                <select name="optperiode2" >
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						//$sql=mysql_query("select distinct periode from rekening1 order by periode desc");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						//if($row=mysql_fetch_row($sql)){
							//$i=0;
							$prd0=gperiode();//$row[0];
							while($prd0>=200001){
								echo"<option value=\"$prd0\">$prd0</option>";
								$prd0--;//201405 201404 201001 201000 200912
								if(substr($prd0,4,2)==00)$prd0-=88;
							}
							//echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						//}
					?>
                </select>
                <!--########################################################################################-->                
              <td><input type="checkbox" name="chtgl" checked="checked">Tgl. Trans.</td>
              <td>
					<input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]			  </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rupp" value="perupp" checked="checked">
                Cabang [UPP]</td>
              <td><select name="optcabang" id="optcabang" >
                  <option value="11" selected="selected">Semua UPP</option>
                  <?php
						$sql=mysql_query("select cabang,nama from cabang WHERE cabang<>'00' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>
             	</td>
              <td><input type="checkbox" name="chpergol"  value="pergol"/>
                Per Gol.</td>
              <td><select name="optgoltarif" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <?php
						$sql=mysql_query("select distinct gol,keterangan from tarif order by gol");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>              </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rwilayah" value="perwil" />
                Wilayah</td>
              <td><select name="optwilayah" id="optwilayah">
                  <!--option value="" selected="selected">--Pilih Wilayah--</option-->
                  <?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("SELECT kode_cabang,kode_wilayah,nama_wilayah FROM master_wilayah WHERE kode_wilayah<>'' ORDER BY kode_wilayah");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_wilayah]\">$p[nama_wilayah]</option>\n";
						}
						?>
                </select>              </td>
              <td><input type="checkbox" name="chjlok" />
                Per Loket </td>
              <td><select name="optjlok">
                  <!--option value="">-Pilih-</option-->
                  <?php
						$sql=mysql_query("select kode_loket,ket_loket from m_loket order by kode_loket");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>              </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rblok" value="perblok" />
                Blok</td>
              <td><select name="optblok" id="optblok">
                  <!--option value="" selected="selected">--Pilih Blok--</option-->
                  <?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("select * from master_blok order by kode_blok");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_blok]\">$p[kode_blok] - $p[ket_blok]</option>\n";
						}
						?>
                </select>              </td>
              <td align="right"><div align="left">
                <input type="checkbox" name="chopr" />
              Per Operator </div></td>
              <td>
			  	<select name="optopr">
                  <!--option value="">-Pilih-</option-->
                  <?php
						$sql=mysql_query("SELECT DISTINCT operator FROM transaksi WHERE operator<>'' ORDER BY operator;") or die(mysql_error());
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
						?>
                </select>
			  </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1"  id="rdkd" value="perdkd"/>
                DKD [WPT] </td>
              <td><select id="optdkd" name="optdkd" onchange="setalamat();" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <?php
						$sql=mysql_query("select dkd,jalan from dkd order by dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>              </td>
              <td align="right">Jenis Trans.</td>
           	  <td><input type="radio" name="rjtrans" id="rjtrans" value="0" checked="checked" />
Lunas &nbsp;&nbsp;
<input type="radio" name="rjtrans" id="rjtrans" value="1" />
Batal </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rnomor"  value="pernomor"/>
                Dari No. Pel</td>
              <td><input type="text" name="txno1" id="txno1" size="7" maxlength="6" onkeypress="return isNumb(event);" />
                &nbsp;s/d&nbsp;
                <input type="text" name="txno2" id="txno2" size="7" maxlength="6" onkeypress="return isNumb(event);" />              </td>
              <td><div align="right">Jns Report</div></td>
              <td><input type="radio" name="rjrep" id="rjrep" value="rjdetail" checked="checked" />
Daftar &nbsp;&nbsp;
<input type="radio" name="rjrep" id="rjrep" value="rjrekap" />
Rekap </td>
            </tr>
			<tr>
				<td><!--input type="radio" name="r1" id="rallupp"  value="all"/-->
				&nbsp;</td>
				<td colspan="2"></td>
				<td align="right">
					<input type="submit" name="proses" value="Proses" />
                  	<input type="button" name="batal" value="Batal" onclick="" />				</td>
			</tr>
          </form>
		  </table>
		  <br />
		  
		  <table width="1024px" align="center" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 0 0 15px #999;" background="img/grids.gif">
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
							
							<?php
								if (isset($_POST["proses"])&& $_POST["proses"]=="Proses"){
									$tawal='2000-01-01';
									$takhir=date('Y-m-d');
									$slipit="";
									//$periode=getPeriodeLalu();
									$periode=$_POST["optperiode"];
									$periode2=$_POST["optperiode2"];
									
									$stbatal=$_POST['rjtrans'];
									$jdl_lunas="";
									if ($stbatal=='1')$jdl_lunas="Pembatalan ";
									
									if(isset($_POST['chtgl'])){
										if(($key1=$_POST['txtawal'])!=''){
											$tawal=$key1;
											echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$key1\";</script>";
										}
										if(($key2=$_POST['txtakhir'])!=''){
											$takhir=$key2;
											echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$key2\";</script>";
										}
									}
									
									$judul=$jdl_lunas."Laporan Penerimaan dan Penagihan [LPP] - Tanggal [$tawal] s/d [$takhir]";
									//$judul.="<br> $jdl_lunas";
									
									/*if(isset($_POST["rjenis"])){
										switch($_POST["rjenis"]){
											case"rjnow":												
												$slipit=cek_slip($slipit)."z.periode=$periode";
												$judul.="<br>Jenis LPP: Terhadap Rekening Bulan/Periode [$periode]";
												break;
											case"rjtill":
												$slipit=cek_slip($slipit)."z.periode < $periode";
												$judul.="<br>Jenis LPP: Terhadap Rek. <u>Sebelum</u> Bulan/Periode [$periode]";
												break;
											case"rjall":
												//$slipit=cek_slip($slipit)."z.periode < $periode";
												$judul.="<br>Jenis LPP: Terhadap Rekening/Periode [$periode] <u>dan Sebelumnya</u>";
												break;
										}										
									}*/
									$slipit=cek_slip($slipit)."(z.periode BETWEEN $periode AND $periode2)";
									$judul.="<br>Terhadap Rekening Periode: [$periode s/d $periode2]";
									
									if(isset($_POST["r1"]))$radio1=$_POST["r1"];
									switch($radio1){
										case"perupp":
											if(($key=$_POST["optcabang"])!=""){
												if($key=='11'){
													$slipit=cek_slip($slipit)."m.cabang<>'$key'";
													$judul.="<br>Cabang : Semua UPP";
												}else{
													$slipit=cek_slip($slipit)."m.cabang='$key'";
													$nama_key=getNama("nama",$key,"cabang","cabang");//field_to_get,val_inject,index,table_name
													$judul.="<br>Cabang : $key - $nama_key";
												}
												
												echo"<script type=\"text/javascript\">document.getElementById(\"rupp\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$key\";</script>";
											}
											break;
											
										case"perwil":
											if(($key=$_POST["optwilayah"])!=""){
												$slipit=cek_slip($slipit)."m.kode_wilayah='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"rwilayah\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optwilayah\").value=\"$key\";</script>";
												$nama_key=getNama("nama_wilayah",$key,"kode_wilayah","master_wilayah");//field_to_get,val_inject,index,table_name
												$judul.="<br>Wilayah : $key - $nama_key";
											}
											break;
											
										case"perblok":
											if(($key=$_POST["optblok"])!=""){
												$slipit=cek_slip($slipit)."m.kode_blok='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"rblok\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optblok\").value=\"$key\";</script>";
												$nama_key=getNama("ket_blok",$key,"kode_blok","master_blok");//field_to_get,val_inject,index,table_name
												$judul.="<br>Blok : $key - $nama_key";
											}
											break;
											
										case"perdkd":
											if(($key=$_POST["optdkd"])!=""){
												$slipit=cek_slip($slipit)."m.dkd='$key'";
												echo"<script type=\"text/javascript\">document.getElementById(\"rdkd\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"optdkd\").value=\"$key\";</script>";
												$nama_key=getNama("jalan",$key,"dkd","dkd");//field_to_get,val_inject,index,table_name
												$judul.="<br>DKD [WPT] : $key - $nama_key";
											}
											break;
											
										case"pernomor":
											if(($key1=$_POST["txno1"])!="" && ($key2=$_POST["txno2"])!=""){
												$slipit=cek_slip($slipit)."m.nomor BETWEEN '$key1' AND '$key2'";
												$judul.="<br>Dari Nomor Pelanggan : [$key1] s/d [$key2]";
												echo"<script type=\"text/javascript\">document.getElementById(\"rnomor\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"txno1\").value=\"$key1\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"txno2\").value=\"$key2\";</script>";
											}
											break;
											
										case"all":											
											$judul.="<br>Semua Cabang [UPP]";
											echo"<script type=\"text/javascript\">document.getElementById(\"rallupp\").checked=\"checked\";</script>";											
											break;
									}
									
									if(isset($_POST["chpergol"])&&($key=$_POST['optgoltarif'])!=''){
										$slipit=cek_slip($slipit)."m.gol='$key'";
										$judul.="<br>Golongan Tarif : $key";
									}
									
									if(isset($_POST["chjlok"])&&($key=$_POST['optjlok'])!=''){
										$slipit=cek_slip($slipit)."z.loket='$key'";
										$judul.="<br>Loket : $key";
									}
									
									if(isset($_POST["chopr"])&&($key=$_POST['optopr'])!=''){
										$slipit=cek_slip($slipit)."z.operator='$key'";
										$judul.="<br>Operator : $key";
									}
																		
									//=====================================BOF=DETAIL==============================================
									if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjdetail"){
										$i=0;
										$theader="
										<tr align=\"center\" style=\"background-color:#909090;color:#FFFFFF;font-weight:bold;\">
											<td>No.</td>
											<td>Tgl</td>
											<td>Jam</td>
											<td>Nomor</td>
											<td>NoLama</td>
											<td>Nama</td>
											<td>Alamat</td>
											
											<td>Periode</td>
											
											<td>Pakai</td>
											<td>Uang<br>Air</td>
											<td>Adm</td>
											<td>Meter</td>
											<td>Denda</td>
											<td>Meterai</td>
											<td>Total</td>
										</tr>
										";																	
										//if($slipit!="")$slipit.=" AND ";
										$alg=array("center","center","center","center","left","left","center","right","right","right","right","right","right","right","right","right","right","right","right","right","right");
										//if($slipit!="")$slipit.=" AND ";
										//$sql="SELECT r.nomor,m.nolama,m.nama,m.cabang,m.kode_wilayah,m.dkd,z.periode,r.standlalu,r.standkini,r.pakai,format(r.uangair,0),format(r.adm,0),format(r.meter,0),format(r.meterai,0),format(r.total,0) FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 ORDER BY m.nolama;";
										//$sql="SELECT z.nomor,m.nolama,SUBSTR(m.nama,1,20),SUBSTR(m.alamat,1,30),m.dkd,z.periode,r.standlalu,r.standkini,r.pakai,format(r.uangair,0),format(r.adm,0),format(r.meter,0),format(r.denda,0),format(r.meterai,0),format(r.total,0) FROM master m, transaksi z, rekening1 r WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.nomor=r.nomor AND r.nomor=m.nomor AND z.batal=$stbatal AND z.periode=r.periode ORDER BY m.nolama,m.cabang,m.gol;";													
										/*$sql="
										SELECT z.nomor,m.nolama,SUBSTR(m.nama,1,20),SUBSTR(m.alamat,1,30),m.dkd,z.periode,r.standlalu,r.standkini,r.pakai,FORMAT(r.uangair,0),FORMAT(r.adm,0),FORMAT(r.meter,0),format(r.denda,0),format(r.meterai,0),format(r.total,0)
										FROM rekening1 AS r
										INNER JOIN master AS m ON m.nomor=r.nomor
										INNER JOIN transaksi AS z ON z.nomor=r.nomor AND z.periode=r.periode AND z.batal=$stbatal AND (z.tbayar BETWEEN '$tawal' AND '$takhir')
										WHERE $slipit  ORDER BY m.nolama,m.cabang,m.gol;
										";*/
										$sql="
										SELECT z.tbayar,z.jbayar,r.nomor,m.nolama,SUBSTR(m.nama,1,25),SUBSTR(m.alamat,1,30),r.periode,(r.standkini-r.standlalu),FORMAT(r.uangair,0),FORMAT(r.adm,0),FORMAT(r.meter,0),format(r.denda,0),format(r.meterai,0),format(r.total,0)
										FROM rekening1 AS r
										INNER JOIN master AS m ON m.nomor=r.nomor
										INNER JOIN transaksi AS z ON z.nomor=r.nomor AND z.periode=r.periode
										WHERE z.batal=$stbatal AND $slipit AND (z.tbayar BETWEEN '$tawal' AND '$takhir');
										";
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo $theader;//Cetak TR pertama sebagai header table
										if($slipit!="")$slipit.=" AND ";
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[1]</td>
												<td align=left>$row[2]</td>
												<td align=left>$row[3]</td>
												<td align=left>$row[4]</td>
												<td align=left>$row[5]</td>
												<td align=center style=\"color:#00f\">$row[6]</td>												
												<td align=right>$row[7]</td>
												<td align=right>$row[8]</td>
												<td align=right>$row[9]</td>
												<td align=right>$row[10]</td>
												<td align=right>$row[11]</td>
												<td align=right>$row[12]</td>
												<td align=right>$row[13]</td>
												
											</tr>
											";
										}
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										$sql_jml="SELECT format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),FORMAT(SUM(r.denda),0),format(SUM(r.meterai),0),format(SUM(r.total),0) FROM rekening1 AS r INNER JOIN master AS m ON  r.nomor=m.nomor INNER JOIN transaksi AS z ON z.nomor=r.nomor AND z.periode=r.periode WHERE $slipit r.status_bayar=1 AND (r.tbayar BETWEEN '$tawal' AND '$takhir');";
										
										$qry0=mysql_query($sql_jml)or die("err: ".mysql_error());
										if($row0=mysql_fetch_row($qry0)){
											$jpakai=$row0[0];
											$juangair=$row0[1];
											$jadm=$row0[2];
											$jmeter=$row0[3];
											$jdenda=$row0[4];
											$jmeterai=$row0[5];
											$jtotal=$row0[6];
										}
										$tfooter="
										<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-size:10px;font-weight:bold;\">											
											<td colspan=\"8\" height=\"20\">GRAND TOTAL</td>
											<td>$jpakai</td>
											<td>$juangair</td>
											<td>$jadm</td>
											<td>$jmeter</td>
											<td>$jdenda</td>
											<td>$jmeterai</td>
											<td>$jtotal</td>
										</tr>
										";
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										
										$_SESSION["judul"]=$judul;
										$_SESSION["jumfield"]=14;
										$_SESSION["eskiel"]=$sql;
										$_SESSION["alinea"]=$alg;
										$_SESSION["theader"]=$theader;
										//$_SESSION["jumdata"]=$jml_data;
										$_SESSION["tfooter"]=$tfooter;
										$_SESSION['orientasi']='L';
										$_SESSION['batas']=23;
										$_SESSION['ttd']="<br>
										<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
										<tr width=\"100%\">
											<td width=\"300\" align=\"center\">
												Dibuat oleh,<br>
												<br><br>
												...............................<br>Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"300\" align=\"center\">
												Diperiksa oleh,<br>
												<br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"300\" align=\"center\">
												Diketahui oleh,<br>
												<br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr></table>
										";
										
									//=====================================BOF=REKAP==============================================
									}if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
										$i=0;
										$theader="
										<tr align=\"center\" style=\"background-color:#909090;color:#FFFFFF;font-weight:bold;\">
											<td>No.</td>
											<td>KODE</td>
											<td>GOLONGAN TARIF</td>
											<td>JML REK.<br>AIR</td>
											<td>PAKAI<br>AIR M<sup>3</sup></td>
											<td>HARGA AIR<br>Rp.</td>
											<td>ADM</td>
											<td>METER</td>											
											<td>METERAI</td>
											<td>TOTAL</td>
											<td>RATA<sup>2</sup><br>HARGA</td>
											<td>RATA<sup>2</sup><br>KONS.</td>
										</tr>
										";
										$alg=array("center","left","right","right","right","right","right","right","right","right","right","right");
										
										if($slipit!="")$slipit.=" AND ";
										//$sql="SELECT distinct m.gol, FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and r.periode=$periode and m.putus=0 ORDER BY m.nolama;";
										$sql="SELECT distinct m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM(r.total),0) as jtotal, format(ifnull((sum(r.uangair)/sum(r.pakai)),0),0)as avg_harga, format(ifnull((sum(r.pakai)/count(*)),0),0)as avg_plg FROM rekening1 r, master m,transaksi z WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.nomor=r.nomor AND r.nomor=m.nomor AND z.batal=$stbatal AND z.periode=r.periode AND m.putus=0 GROUP BY m.gol ORDER BY m.gol;";
										
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo $theader;//Cetak TR pertama sebagai header table
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=left>$row[1]</td>
												<td align=right>$row[2]</td>
												<td align=right>$row[3]</td>
												<td align=right>$row[4]</td>
												<td align=right>$row[5]</td>
												<td align=right>$row[6]</td>
												<td align=right>$row[7]</td>
												<td align=right>$row[8]</td>
												<td align=right>$row[9]</td>
												<td align=right>$row[10]</td>
											</tr>
											";
										}
										
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.total),0) FROM rekening1 r,transaksi z,master m WHERE $slipit (z.tbayar BETWEEN '$tawal' AND '$takhir') AND z.nomor=r.nomor AND r.nomor=m.nomor AND m.nomor=z.nomor AND z.batal=$stbatal AND z.periode=r.periode AND m.putus=0 ";
										
										$qry0=mysql_query($sql_jml)or die("err: ".mysql_error());
										if($row0=mysql_fetch_row($qry0)){
											$jrek=$row0[0];
											$jpakai=$row0[1];
											$juangair=$row0[2];
											$jadm=$row0[3];
											$jmeter=$row0[4];
											$jmeterai=$row0[5];
											$jtotal=$row0[6];
										}
										$tfooter="
										<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\">											
											<td colspan=\"3\" height=\"20\">GRAND TOTAL</td>
											<td align=right>$jrek</td>
											<td align=right>$jpakai</td>
											<td align=right>$juangair</td>
											<td align=right>$jadm</td>
											<td align=right>$jmeter</td>
											<td align=right>$jmeterai</td>
											<td align=right>$jtotal</td>
											<td colspan=2>&nbsp;</td>
										</tr>
										";
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										
										$_SESSION["judul"]=$judul;
										$_SESSION["jumfield"]=11;
										$_SESSION["eskiel"]=$sql;
										$_SESSION["alinea"]=$alg;
										$_SESSION["theader"]=$theader;
										//$_SESSION["jumdata"]=$jml_data;
										$_SESSION["tfooter"]=$tfooter;
										$_SESSION['ttd']="<br><br><br><br><br><br><br><br>
										<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
										<tr width=\"100%\">
											<td width=\"200\" align=\"center\">
												Dibuat oleh,<br>
												<br><br>
												...............................<br>Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"200\" align=\"center\">
												Diperiksa oleh,<br>
												<br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"200\" align=\"center\">
												Diketahui oleh,<br>
												<br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr></table>
										";
									}
									
									echo"<tr bgcolor=#fff><td colspan=19 align=center>$tfooter</td></tr>";
								}
							?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
			<td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
				<a href="reports/print_report.php" target="_blank" style="font-size:16px;">-= Cetak Report =-</a>******************
				<input type="checkbox" name="chcustprint" value="customprint" />Custom -=>
				Mengetahui:
				<select name="optrespon1" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<option value="" selected="selected">--Pilih--</option>
					<?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nama from users order by nama");
					while($p=mysql_fetch_row($usr)){
					echo "<option value=\"$p[0]\">$p[0]</option>";
					}
					?>
				</select>
				Pemeriksa:
				<select name="optrespon2" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<option value="" selected="selected">--Pilih--</option>
					<?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nama from users order by nama");
					while($p=mysql_fetch_row($usr)){
					echo "<option value=\"$p[0]\">$p[0]</option>";
					}
					?>
				</select>
				Pembuat:
				<select name="optrespon3" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
					<option value="" selected="selected">--Pilih--</option>
					<?php
					//mengambil nama-nama wilayah yang ada di database
					$usr = mysql_query("select nama from users order by nama");
					while($p=mysql_fetch_row($usr)){
					echo "<option value=\"$p[0]\">$p[0]</option>";
					}
					?>
				</select>
			</td>
		</tr>
		</table>
		  
		  <br />
		  
		  <!--############################################################################################################-->
	  </td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
