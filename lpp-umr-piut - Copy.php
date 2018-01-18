<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

$periode1=201404;
$prd1=substr($periode1,0,4).'-'.substr($periode1,4,2);
$tgl1=date('Ym',strtotime($prd1.' -12 month'));
//echo $tgl1;

?>

	<tr>
		<td>
		<!--############################################################################################################-->
        <div align="center"><font face="Arial,sans-serif" size="4px"><b>Rekap Pendapatan & Penerimaan [LPP] per Umur Piutang</b></font></div><hr width="1024px"/>		
		<table width="660px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#ffc;" background="img/grids.gif">
        	<form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr>
            	<td>Tgl Bayar</td>
                <td>
                	<input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]
                </td>
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
                        	<tr align="center" style="background-color:#909090;color:#FFFFFF;font-weight:bold;">
								<td>No.</td>
                                
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
								$b1="";$b2="";$slipit="";
								//$prd=gperiode();
								//$prd=$_POST['optperiode2'];
								//$judul="Rekap LPP";
								//cetak
								
								if(($key1=$_POST['txtawal'])!=''){
									$tawal=$key1;
										echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$key1\";</script>";
								}
								if(($key2=$_POST['txtakhir'])!=''){
									$takhir=$key2;
									echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$key2\";</script>";
								}
								
								$judul="Rekap LPP - Tanggal Pembayaran [$tawal s/d $takhir]";
								
								$theader="
								<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\">
									<td>No.</td>
									<td>KODE TARIF</td>
									<td>GOLONGAN<br>TARIF</td>
									<td>JML REK AIR</td>
									<td>PAKAI AIR [M<sup>3</sup>]</td>
									<td>HARGA AIR [Rp.]</td>
									<td>ADMINISTRASI</td>
									<td>BIAYA METER</td>											
									<td>BIAYA METERAI</td>
									<td>TOTAL<br>NILAI REKENING</td>
									<td>RATA<sup>2</sup><br>HARGA</td>
									<td>RATA<sup>2</sup><br>KONS.</td>
								</tr>
								";
								
								$alg=array("center","center","left","right","right","right","right","right","right","right","right","right");
								//cetak
								
								/*switch($umur){
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
								}*/
								//echo $slipit;
								//$periode1=$prd;
								//$prd1=substr($periode1,0,4).'-'.substr($periode1,4,2);
								$prd1=$takhir;
								$bln1=date('Ym',strtotime($prd1.' -1 month'));
								//echo $bln1;
								$bln2=date('Ym',strtotime($prd1.' -2 month'));
								$bln3=date('Ym',strtotime($prd1.' -3 month'));
								$bln4=date('Ym',strtotime($prd1.' -4 month'));
								$bln6=date('Ym',strtotime($prd1.' -6 month'));
								$bln7=date('Ym',strtotime($prd1.' -7 month'));
								$bln12=date('Ym',strtotime($prd1.' -12 month'));
								
								$bln13=date('Ym',strtotime($prd1.' -13 month'));//akhir
								
								$sql_i[1]="SELECT DISTINCT  m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM(r.total),0) as jtotal,FORMAT(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0)as avg_harga, FORMAT(IFNULL((SUM(r.pakai)/COUNT(*)),0),0)as avg_plg FROM rekening1 r, master m WHERE r.periode=$bln1 AND (r.tbayar BETWEEN '$tawal' AND '$takhir') AND m.nomor=r.nomor and r.status_bayar=1 GROUP BY m.gol;";
								$sql_i[2]="SELECT DISTINCT  m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM(r.total),0) as jtotal,FORMAT(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0)as avg_harga, FORMAT(IFNULL((SUM(r.pakai)/COUNT(*)),0),0)as avg_plg FROM rekening1 r, master m WHERE (r.periode BETWEEN $bln3 AND $bln2) AND (r.tbayar BETWEEN '$tawal' AND '$takhir') AND m.nomor=r.nomor and r.status_bayar=1 GROUP BY m.gol;";
								$sql_i[3]="SELECT DISTINCT  m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM(r.total),0) as jtotal,FORMAT(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0)as avg_harga, FORMAT(IFNULL((SUM(r.pakai)/COUNT(*)),0),0)as avg_plg FROM rekening1 r, master m WHERE (r.periode BETWEEN $bln6 AND $bln4) AND (r.tbayar BETWEEN '$tawal' AND '$takhir') AND m.nomor=r.nomor and r.status_bayar=1 GROUP BY m.gol;";
								$sql_i[4]="SELECT DISTINCT  m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM(r.total),0) as jtotal,FORMAT(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0)as avg_harga, FORMAT(IFNULL((SUM(r.pakai)/COUNT(*)),0),0)as avg_plg FROM rekening1 r, master m WHERE (r.periode BETWEEN $bln12 AND $bln7) AND (r.tbayar BETWEEN '$tawal' AND '$takhir') AND m.nomor=r.nomor and r.status_bayar=1 GROUP BY m.gol;";
								$sql_i[5]="SELECT DISTINCT  m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM(r.total),0) as jtotal,FORMAT(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0)as avg_harga, FORMAT(IFNULL((SUM(r.pakai)/COUNT(*)),0),0)as avg_plg FROM rekening1 r, master m WHERE r.periode<=$bln13 AND (r.tbayar BETWEEN '$tawal' AND '$takhir') AND m.nomor=r.nomor and r.status_bayar=1 GROUP BY m.gol;";
								
								//for($j=0;$j<=5;$j++){
								$j=1;$bts="";
								$c1=0;$c2=0;$c=0;
								$cnt1[]="";$cnt2[]="";$baris="";
								while($j<=5){
									if ($j==1) {$bts=$bln1;$peri="1 bulan";}
									if ($j==2) {$bts=$bln2." & ".$bln3;$peri="2 s/d 3 bulan";}
									if ($j==3) {$bts=$bln4." & ".$bln6;$peri="4 s/d 6 bulan";}
									if ($j==4) {$bts=$bln7." & ".$bln12;$peri="7 s/d 12 bulan";}
									if ($j==5) {$bts=$bln13;$peri="lebih dari 12 bulan";}
									$qry1=mysql_query($sql_i[$j])or die(mysql_error());
									$i=0;
									$c1++;
									echo"<tr style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\"><td colspan=12>Periode $j # $bts</td></tr>";
									$baris.="<tr style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\"><td colspan=12>Periode $peri rekening</td></tr>";
									while($row=mysql_fetch_row($qry1)){
										$i++;
										$c2++;
										echo"
										<tr>
											<td align=\"center\">$i</td>
											<td>$row[0]-$row[1]</td>
											
											<td align=\"right\">$row[2]</td>
											<td align=\"right\">$row[3]</td>
											<td align=\"right\">$row[4]</td>
											<td align=\"right\">$row[5]</td>
											<td align=\"right\">$row[6]</td>
											<td align=\"right\">$row[7]</td>
											<td align=\"right\">$row[8]</td>
											<td align=\"right\">$row[9]</td>
											<td align=\"right\">$row[10]</td>
											
										</tr>
										";
										$baris.="
										<tr>
											<td align=\"center\">$i</td>
											<td align=\"center\">$row[0]</td>
											<td>$row[1]</td>
											<td align=\"right\">$row[2]</td>
											<td align=\"right\">$row[3]</td>
											<td align=\"right\">$row[4]</td>
											<td align=\"right\">$row[5]</td>
											<td align=\"right\">$row[6]</td>
											<td align=\"right\">$row[7]</td>
											<td align=\"right\">$row[8]</td>
											<td align=\"right\">$row[9]</td>
											<td align=\"right\">$row[10]</td>
											
										</tr>
										";
									}
									$j++;
									//$cnt1[$c1].=$cnt2[$c2];
								}
								
								//$sql="SELECT DISTINCT r.periode, m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,FORMAT(COUNT(*),0) as jml_rek,FORMAT(SUM(r.pakai),0) as jpakai,FORMAT(SUM(r.uangair),0) as juangair,FORMAT(SUM(r.adm),0) as jadm,FORMAT(SUM(r.meter),0)as jmeter,FORMAT(SUM(r.meterai),0) as jmeterai,FORMAT(SUM(r.total),0) as jtotal,FORMAT(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0)as avg_harga, FORMAT(IFNULL((SUM(r.pakai)/COUNT(*)),0),0)as avg_plg FROM rekening1 r, master m WHERE $slipit AND m.nomor=r.nomor and r.status_bayar=1 GROUP BY r.periode,m.gol;";
								
								//$qry=mysql_query($sql)or die(mysql_error());
								
								
							
							$sql_jml="SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM(r.total),0) FROM rekening1 r,master m WHERE r.nomor=m.nomor AND r.status_bayar=1 AND (r.tbayar BETWEEN '$tawal' AND '$takhir');";
							
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
							<td colspan=\"3\" height=\"11\">GRAND TOTAL</td>
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
							$_SESSION['baris']=$baris;//$_SESSION['jumbaris']=$c2;
							$_SESSION['ttd']="<br><br>
										<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
										<tr width=\"100%\">
											<td width=\"200\" align=\"center\">
												Diketuahui oleh,<br>
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
												Dibuat oleh,<br>
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
                    <a href="reports/print_report_rekap.php" target="_blank" style="font-size:16px;">-= Cetak Report =-</a>
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
