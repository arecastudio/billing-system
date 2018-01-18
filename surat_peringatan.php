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
		<br style="font-size:8px;" />
		<table width="1024px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
          <form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr style="font:calibri;font-size:13px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
            	<td colspan="4" align="center"><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:16px;">SURAT PERINGATAN PELANGGAN - PER UMUR PIUTANG</td>
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
              <td>Tgl. Surat</td>
              <td>
					<input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
				</td>
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
              <td>
                No. Surat</td>
              <td>
              <input type="text" size="30" maxlength="40" name="txnosurat" id="txnosurat" readonly placeholder="Non Aktif" />
              </td>
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
                </select>
              </td>
              <td>
              	Pejabat
              </td>
              <td>
			  	<!--select name="optkaupp" id="optkaupp"-->
                  	<!--option value="" selected="selected">--Pilih Wilayah--</option-->
                  	<?php
						//mengambil nama-nama wilayah yang ada di database
						/*$cbg = mysql_query("SELECT DISTINCT cabang,kacab FROM cabang WHERE cabang='01' ORDER BY cabang;");
						while($p=mysql_fetch_row($cbg)){
						echo "<option value=\"$p[1]\">$p[0] - $p[1]</option>\n";
						}
						echo"<option value=\"YOHAN WANGGAI, SE\">07 - Man. Humas</option>";
					*/?>
                <!--/select-->
<input type="text" name="txpejabat1" id="txpejabat1" placeholder="Nama" size="15px" required/>
<input type="text" name="txpejabat2" id="txpejabat2" placeholder="Jabatan" size="15px" required/>
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
              <td>
              	Tunggak
              </td>
              <td>
			  	<input type="text" name="txtunggak" id="txtunggak" size="3pe" onkeypress="return isNumb(event);" style="text-align:right;" value="3" />&nbsp;bulan/ lebih
			  </td>
            </tr>
            <tr>
              <td><input type="radio" name="r1" id="rnomor"  value="pernomor"/>
                Nomor Pel.</td>
              <td><input type="text" name="txno1" id="txno1" size="7" maxlength="6" onkeypress="return isNumb(event);" />
                
                <!--input type="text" name="txno2" id="txno2" size="7" maxlength="6" onkeypress="return isNumb(event);" /-->              </td>
              <td></td>
              <td></td>
            </tr>
			<tr>
				<td><!--input type="radio" name="r1" id="rallupp"  value="all"/-->
				&nbsp;
                <input type="hidden" id="dik" name="dik" />
                </td>
				<td colspan="2"></td>
				<td align="right">
					<input type="submit" name="proses" value="Proses" />
                  	<input type="button" name="batal" value="Batal" onclick="" />				</td>
			</tr>
          </form>
		  </table>
		  <br style="font-size:5px;" />		  
		  <table width="1024px" align="center" border="0" cellpadding="2" cellspacing="1" background="img/grids.gif" class="rounded">
			<tr>
				<td width="100%" align="center">
					<div style="height:370px;overflow:auto">
						<table width="100%" border="1" id="table-hasil" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffe;font-family:calibri;font-size:12px;" >
							
							<?php
								if (isset($_POST["proses"])){
									$tawal=date('Y-m-d');									
									$slipit="";									
									//$periode=getPeriodeLalu();
									
									$tunggak=trim($_POST["txtunggak"]);
									echo"<script type=\"text/javascript\">document.getElementById(\"txtunggak\").value=\"$tunggak\";</script>";
									$ttd_nama=$_POST[txpejabat1];
									$ttd_jab=$_POST[txpejabat2];
									echo"<script type=\"text/javascript\">document.getElementById(\"txpejabat1\").value=\"".$ttd_nama."\";</script>";
									echo"<script type=\"text/javascript\">document.getElementById(\"txpejabat2\").value=\"".$ttd_jab."\";</script>";
																						
									if(($key1=$_POST['txtawal'])!=''){
										$tawal=$key1;
										echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$key1\";</script>";
									}
									
									
									//$slipit=cek_slip($slipit)."(z.periode BETWEEN $periode AND $periode2)";
									$slipit=cek_slip($slipit)."(SELECT COUNT(r.nomor) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001)>0";
									$judul="SURAT PERINGATAN PELANGGAN";
									
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
											//if(($key1=$_POST["txno1"])!="" && ($key2=$_POST["txno2"])!=""){
												if(($key1=$_POST["txno1"])!=""){
												$slipit=cek_slip($slipit)."m.nomor='$key1'";
												$judul.="<br>Nomor Pelanggan : $key1";
												echo"<script type=\"text/javascript\">document.getElementById(\"rnomor\").checked=\"checked\";</script>";
												echo"<script type=\"text/javascript\">document.getElementById(\"txno1\").value=\"$key1\";</script>";
												//echo"<script type=\"text/javascript\">document.getElementById(\"txno2\").value=\"$key2\";</script-->";
											}
											break;
											
										case"all":											
											$judul.="<br>Semua Cabang [UPP]";
											echo"<script type=\"text/javascript\">document.getElementById(\"rallupp\").checked=\"checked\";</script>";											
											break;
									}
																		
																		
									//=====================================BOF=DETAIL==============================================
									//if(isset($_POST["rjrep"])){										
										$theader="
										<tr align=\"center\" style=\"background:linear-gradient(#999,#004);color:#fff;font-weight:bold;\">
											<td>No.</td>
											<td>Nomor</td>
											<td>NoLama</td>
											<td>Nama</td>
											<td>Alamat</td>
											<td>Gol</td>	
											<td>KWM</td>										
											<td>Piutang<br>[bulan]</td>											
											<td>Pakai<br>[M<sup>3</sup>]</td>
											<td>Biaya<br>Air</td>
											<td>Adm</td>
											<td>Meter</td>
											<td>Denda</td>
											<td>Meterai</td>
											<td>Total</td>
										</tr>
										";
										
										//if($slipit!="")$slipit.=" AND ";
										//$alg=array("center","center","center","center","left","left","center","right","right","right","right","right","right","right","right","right","right","right","right","right","right");
										
										//$sql="SELECT r.nomor,m.nolama,SUBSTR(m.nama,1,25),SUBSTR(m.alamat,1,25),format(COUNT(r.periode),0),format(SUM(r.standkini-r.standlalu),0),format(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0) FROM rekening1 r, master m WHERE $slipit r.nomor=m.nomor and (r.periode BETWEEN $periode AND $periode2) and r.status_bayar=0 GROUP BY r.nomor ORDER BY m.nolama;";
										$sql="
										SELECT r.nomor,m.nolama,SUBSTR(m.nama,1,25),SUBSTR(m.alamat,1,30),m.gol,format(COUNT(r.periode),0),format(SUM(r.pakai),0),FORMAT(SUM(r.uangair),0),FORMAT(SUM(r.adm),0),FORMAT(SUM(r.meter),0),format(SUM(r.denda),0),format(SUM(r.meterai),0),format(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),COUNT(r.periode) AS piutang,m.kondisi_meter
										FROM rekening1 AS r
										INNER JOIN master AS m ON  m.nomor=r.nomor
										WHERE $slipit AND r.status_bayar=0 AND m.kondisi_meter<>'2'
										GROUP BY r.nomor
										HAVING piutang>$tunggak
										ORDER BY m.nolama
										;";
										$qry=mysql_query($sql)or die("err: ".mysql_error());
										echo $theader;//Cetak TR pertama sebagai header table
										$i=0;//$$j=0;
										
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=\"center\">$row[0]</td>
												<td align=\"center\">$row[1]</td>
												<td align=left>$row[2]</td>
												<td align=left>$row[3]</td>
												<td align=center>$row[4]</td>
												<td align=right>$row[14]</td>
												<td align=right>$row[5]</td>
												
												<td align=right>$row[6]</td>												
												<td align=right>$row[7]</td>
												<td align=right>$row[8]</td>
												<td align=right>$row[9]</td>
												<td align=right>$row[10]</td>
												<td align=right>$row[11]</td>
												<td align=right>$row[12]</td>												
											</tr>
											";
											$nomor[]=trim($row[0])."/".trim($row[1]);
											$nama[]=trim($row[2]);
											$alamat[]=trim($row[3]);
											$total[]=trim($row[12]);
										}
										//```````````````````````````BOF OPTIONAL FOR FOOTER`````````````````````````````````
										/*$sql_jml1="SELECT format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),FORMAT(SUM(r.denda),0),format(SUM(r.meterai),0),format(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0)
										FROM rekening1 AS r
										INNER JOIN master AS m ON  m.nomor=r.nomor
										INNER JOIN transaksi AS z ON z.nomor=r.nomor
										WHERE $slipit
										;";
										
										$qry0=mysql_query($sql_jml1)or die("err: ".mysql_error());
										if($row0=mysql_fetch_row($qry0)){
											$jpakai=$row0[0];
											$juangair=$row0[1];
											$jadm=$row0[2];
											$jmeter=$row0[3];
											$jdenda=$row0[4];
											$jmeterai=$row0[5];
											$jtotal=$row0[6];
										}*/
										/*$tfooter="
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
										";*/
										//```````````````````````````EOF OPTIONAL FOR FOOTER`````````````````````````````````
										
										//$_SESSION["judul"]=$judul;
										//$_SESSION["jumfield"]=14;
										//$_SESSION["eskiel"]=$sql;
										//$_SESSION["alinea"]=$alg;
										///$_SESSION["theader"]=$theader;
										$_SESSION["jumdata"]=$i;
										//$_SESSION["tfooter"]=$tfooter;
										//$_SESSION['orientasi']='L';
										//$_SESSION['batas']=23;
										if($i>0){
										$_SESSION["nomor"]=$nomor;
										$_SESSION["nama"]=$nama;
										$_SESSION["alamat"]=$alamat;
										$_SESSION["total"]=$total;
										}
										
										#$_SESSION['ttd']=$_POST['optkaupp'];
										$_SESSION['ttd_nama']=$_POST['txpejabat1'];
										$_SESSION['ttd_jabatan']=$_POST['txpejabat2'];
										
									//=====================================BOF=REKAP==============================================
									//}
									
									//echo"<tr bgcolor=#fff><td colspan=19 align=center>$sql</td></tr>";									
								}
							?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
			<td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
				<a href="reports/print_super.php" target="_blank" style="font-size:16px;color:#FF0000;font-weight:bold">-= Cetak Report =-</a>
                <input type="button" name="export" value="Export to Excel" onClick ="$('#table-hasil').tableExport({type:'excel',escape:'false',htmlContent:'true'});" style="color:#00f;font-size:16px;font-weight:bold;padding:0px;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Catatan: Pelanggan Status Kondisi Meter Segel Tidak akan Tampil</b>
		
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
