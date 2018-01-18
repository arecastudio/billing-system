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
        <div align="center"><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 2px red;color:#ff0;font-size:19px;"><b>Rekap Pendapatan & Penerimaan [LPP] per Umur Piutang</b></font></div><hr width="1024px"/>		
		<table width="660px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background:linear-gradient(#ff0, #ccf);" background="img/grids.gif">
        	<form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr>
            	<td width="170px">Rekening [DRD] Acuan</td>
                <td>
                	<!--select name="optperiode" -->
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						echo "Periode <strong>".date('Ym')."</strong>";
						//$sql=mysql_query("select distinct periode from rekening1 order by periode desc");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						//if($row=mysql_fetch_row($sql)){
							//$i=0;
							/*$prd0=gperiode();//$row[0];
							while($prd0>=200001){
								echo"<option value=\"$prd0\">$prd0</option>";
								$prd0--;//201405 201404 201001 201000 200912
								if(substr($prd0,4,2)==00)$prd0-=88;
							}*/
							//echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						//}
					?>
                <!--/select-->
                </td>
            </tr>
            <tr>
            	<td><br/>Umur Piutang</td>
                <td><br/><input type="radio" name="rd1" id="rd1" value="bl1" checked />Satu Bulan</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="radio" name="rd1" id="rd1" value="bl23" />2 - 3 Bulan</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="radio" name="rd1" id="rd1" value="bl46" />4 - 6 Bulan</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="radio" name="rd1" id="rd1" value="bl712" />7 - 12 Bulan</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="radio" name="rd1" id="rd1" value="bl1324" />13 - 24 Bulan</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="radio" name="rd1" id="rd1" value="bl2536" />25 - 36 Bulan</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="radio" name="rd1" id="rd1" value="bl37sd" />37 Bulan s/d <input type="text" name="txblsd" maxlength="6" size="6" onKeyPress="return isNumb(event);" /> 
                Disi Periode cth: 200807</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="radio" name="rd1" id="rd1" value="blsd" />Lain-lain:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="txblsd1" maxlength="6" size="6" onKeyPress="return isNumb(event);" /> s/d <input type="text" name="txblsd2" maxlength="6" size="6" onKeyPress="return isNumb(event);" />
                Disi Periode cth: 200807</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td align="right"><!--input type="submit" name="tgl" value="Test"-->
                	<input type="submit" name="proses" value="Proses" />
                    <input type="reset" name="reset" value="Batal" />
                </td>
            </tr>
            </form>
        </table>
        <br/>        
        <table width="1024px" align="center" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 0 0 15px #999;" background="img/grids.gif">
			<tr>
				<td width="100%" align="center">
					<div style="height:350px;overflow:auto">
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">
                        	<tr align="center" style="background:linear-gradient(#ff0, #ccf);font-weight:bold;">
								<td>No.</td>
                                <td>PERIODE</td>
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
                            <?php
							
							/*
							if(isset($_POST['tgl']) && $_POST['tgl']=='Test'){
								
								$period=date('Ym');
								$tgl=date('Ym',strtotime('-36 month'));
								//$tgl=date('Ym',strtotime($tgl));
								echo $tgl;
							}*/
							
							//MENGGUNAKAN BETWEEN START INTERVAL HARUS LEBIH KECIL DARI END INSTERVAL......!!!!!!!!!!!
                            if(isset($_POST['proses'])&&$_POST['proses']=='Proses'){							
								$umur=$_POST['rd1'];$b1="";$b2="";$slipit="";$prd=gperiode();
								$judul="Rekap LPP";
								//cetak
								$theader="
								<tr align=\"center\" style=\"background-color:#909090;color:#FFFFFF;font-weight:bold;\">
									<td>No.</td>
									<td>PERIODE</td>
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
								$alg=array("center","center","left","right","right","right","right","right","right","right","right","right");
								//cetak
								
								switch($umur){
									case"bl1":
										$b1=date('Ym',strtotime('-1 month'));
										$slipit="r.periode=$b1";
										$judul.=" 1(Satu) Bulan [$prd]";
										break;
									case"bl23":
										$b1=date('Ym',strtotime('-2 month'));
										$b2=date('Ym',strtotime('-3 month'));
										$slipit="(r.periode BETWEEN $b2 AND $b1)";
										$judul.=" Bulan ke-2 s/d ke-3 Terhadap periode [$prd]";
										break;
									case"bl46":
										$b1=date('Ym',strtotime('-4 month'));
										$b2=date('Ym',strtotime('-6 month'));
										$slipit="(r.periode BETWEEN $b2 AND $b1)";
										$judul.=" Bulan ke-4 s/d ke-6 Terhadap periode [$prd]";
										break;
									case"bl712":
										$b1=date('Ym',strtotime('-7 month'));
										$b2=date('Ym',strtotime('-12 month'));
										$slipit="(r.periode BETWEEN $b2 AND $b1)";
										$judul.=" Bulan ke-7 s/d ke-12 Terhadap periode [$prd]";
										break;
									case"bl1324":
										$b1=date('Ym',strtotime('-13 month'));
										$b2=date('Ym',strtotime('-24 month'));
										$slipit="(r.periode BETWEEN $b2 AND $b1)";
										$judul.=" Bulan ke-13 s/d ke-24 Terhadap periode [$prd]";
										break;
									case"bl2536":
										$b1=date('Ym',strtotime('-25 month'));
										$b2=date('Ym',strtotime('-36 month'));
										$slipit="(r.periode BETWEEN $b2 AND $b1)";
										$judul.=" Bulan ke-25 s/d ke-36 Terhadap periode [$prd]";
										break;
									case"bl37sd":
										$b1=date('Ym',strtotime('-37 month'));
										$b2=$_POST['txblsd'];
										$slipit="(r.periode BETWEEN $b2 AND $b1)";
										$judul.=" Bulan ke-37 dst. Terhadap periode [$prd]";
										break;
									case"blsd":
										$b1=$_POST['txblsd1'];
										$b2=$_POST['txblsd2'];
										$slipit="(r.periode BETWEEN $b1 AND $b2)";
										$judul.=" Rek. Periode[$b1]s/d[$b2]";
										break;
								}
								//echo $slipit;
								
								$sql="SELECT DISTINCT r.periode, m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM(r.total),0) as jtotal,FORMAT(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0)as avg_harga, FORMAT(IFNULL((SUM(r.pakai)/COUNT(*)),0),0)as avg_plg FROM rekening1 r, master m WHERE $slipit AND m.nomor=r.nomor and r.status_bayar=1 GROUP BY r.periode,m.gol;";
								
								$qry=mysql_query($sql)or die(mysql_error());
								
								$i=0;
								while($row=mysql_fetch_row($qry)){
									$i++;
									echo"
									<tr>
										<td align=\"center\">$i</td>
										<td align=\"center\">$row[0]</td>
										<td>$row[1] - $row[2]</td>
										<td align=\"right\">$row[3]</td>
										<td align=\"right\">$row[4]</td>
										<td align=\"right\">$row[5]</td>
										<td align=\"right\">$row[6]</td>
										<td align=\"right\">$row[7]</td>
										<td align=\"right\">$row[8]</td>
										<td align=\"right\">$row[9]</td>
										<td align=\"right\">$row[10]</td>
										<td align=\"right\">$row[11]</td>
									</tr>
									";
								}
							
							$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.total),0) FROM rekening1 r,master m WHERE $slipit AND r.nomor=m.nomor AND r.status_bayar=1";
							
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
							<td colspan=\"4\" height=\"20\">GRAND TOTAL</td>
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
							
							$_SESSION["judul"]=$judul;
							$_SESSION["jumfield"]=12;
							$_SESSION["eskiel"]=$sql;
							$_SESSION["alinea"]=$alg;
							$_SESSION["theader"]=$theader;
							//$_SESSION["jumdata"]=$jml_data;
							$_SESSION["tfooter"]=$tfooter;
							$_SESSION['orientasi']='L';
							$_SESSION['batas']=25;
							$_SESSION['ttd']="<br><br><br>
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
							
							}
							?>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
                    <a href="reports/print_report.php" target="_blank" style="font-size:16px;">-= Cetak Report =-</a>
                </td>
            </tr> 
        </table>
        <br/>
		<!--############################################################################################################-->
	  	</td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
