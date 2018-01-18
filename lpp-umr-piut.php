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
        <div align="center"><font face="Arial,sans-serif" size="4px"><b style="color:#eee;">Rekap Laporan Penerimaan & Penagihan [LPP] per Cabang [ UPP ]</b></font></div><hr width="1024px"/>		
		<table width="660px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#ffc;" background="img/grids.gif">
        	<form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr>
            	<td width="220px">Tgl Bayar</td>
                <td>
                	<input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]
                </td>
            </tr>
        	<tr>
            	<td>Periode Rek. Dihapus Mulai <b>200001</b> s/d </td>
                <td>
					<!--input type="text" size="11" maxlength="10" name="tt" id="tt" class="datepicker" value="<?php //echo date('Y-m-d');?>" /-->
                    
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

								if($prd1==201212){
									echo"<option value=\"$prd1\" selected=\"selected\">$prd1</option>";
								}else{
									echo"<option value=\"$prd1\">$prd1</option>";
								}
								$prd1++;//201405 201404 201001 201000 200912
								if(substr($prd1,4,2)==13)$prd1+=88;
							}
							//echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						//}
					?>
                </select>
                </td>
            </tr>
            <tr>
            	<td>Cabang</td>
                <td>
					<select name="optcabang" id="optcabang" >
					<option value="11" selected="selected">Semua UPP</option>
					<?php
                            $sql=mysql_query("select cabang,nama from cabang WHERE cabang<>'00' order by cabang");
                            while($row=mysql_fetch_row($sql)){
                                echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
                            }
					?>
                    </select> 
                </td>
            </tr>
            <tr>
            	<td>Loket</td>
                <td>
                	<select name="optloket" id="optloket">
                      <option value="666">Semua Loket</option>
                      <?php
                            $sql=mysql_query("select kode_loket,ket_loket from m_loket order by kode_loket");
                            while($row=mysql_fetch_row($sql)){
                                echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
                            }
                      ?>
                    </select>
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
                        	<tr align="center" style="background:linear-gradient(#ccc,#000);color:#fff;font-weight:bold;">
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
							
							//MENGGUNAKAN BETWEEN START INTERVAL HARUS LEBIH KECIL DARI END INSTERVAL......!!!!!!!!!!!
                            if(isset($_POST['proses'])&&$_POST['proses']=='Proses'){							
								if(($key1=$_POST['txtawal'])!=''){
									$tawal=$key1;
										echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$key1\";</script>";
								}
								
								if(($key2=$_POST['txtakhir'])!=''){
									$takhir=$key2;
									echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$key2\";</script>";
								}
								
								$judul="Rekap LPP - Tanggal Pembayaran [$tawal s/d $takhir]";
								
								$b1="";$b2="";$slipit="";
								
								//cetak
								$prd_batas=$_POST['optperiode'];
								//$prd_batas=strtotime($batas.' +1 month');
								
								//echo $prd_batas;
								
								$selip="";
								$cabang=$_POST['optcabang'];
								$loket=$_POST['optloket'];
								
								echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
								echo"<script type=\"text/javascript\">document.getElementById(\"optloket\").value=\"$loket\";</script>";
								
								$selip="";									
								if($cabang=='11'){
									$selip.=" m.cabang<>'$cabang' AND ";
									$judul.="<br>Cabang: Semua UPP";
								}else{
									$selip.=" m.cabang='$cabang' AND ";
									$nama_cbg=getNama("nama",$cabang,"cabang","cabang");
									$judul.="<br>Cabang: $cabang - $nama_cbg";
								}
								
								if($loket=='666'){
									$selip.=" t.loket<>'$loket' AND ";
									$judul.="<br>Loket: Semua Loket";
								}else{
									$selip.=" t.loket='$loket' AND ";
									$judul.="<br>Loket: $loket";
								}																
								
								
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
								
								$prd1=$takhir;
								if(date('d',strtotime($takhir))>'28'){
									$prd1=date('Y-m-d',strtotime($takhir.' -3 day'));
									//kurangi 3 hari sebab bulan lalu belum tentu ada tgl 31, antisipasi juga untuk tahun khabisat
								}
								
								//echo $prd1;
								
								$bln1=date('Ym',strtotime($prd1.' -1 month'));
								
								$bln2=date('Ym',strtotime($prd1.' -2 month'));
								$bln3=date('Ym',strtotime($prd1.' -3 month'));
								$bln4=date('Ym',strtotime($prd1.' -4 month'));
								$bln6=date('Ym',strtotime($prd1.' -6 month'));
								$bln7=date('Ym',strtotime($prd1.' -7 month'));
								$bln12=date('Ym',strtotime($prd1.' -12 month'));								
								$bln13=date('Ym',strtotime($prd1.' -13 month'));
								
								$bln24=date('Ym',strtotime($prd1.' -24 month'));
								$bln25=date('Ym',strtotime($prd1.' -25 month'));
								$bln36=date('Ym',strtotime($prd1.' -36 month'));
								$bln37=date('Ym',strtotime($prd1.' -37 month'));
								
								
								$sql_i[1]="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter) as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal,ROUND(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0) as avg_harga, ROUND(IFNULL((SUM(r.pakai)/COUNT(*)),0),0) as avg_plg FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode WHERE $selip r.periode=$bln1 AND (t.tbayar BETWEEN '$tawal' AND '$takhir') AND r.status_bayar=1 AND t.batal=0 GROUP BY m.gol;";
								$sql_i[2]="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter) as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal,ROUND(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0) as avg_harga, ROUND(IFNULL((SUM(r.pakai)/COUNT(*)),0),0) as avg_plg FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode WHERE $selip (r.periode BETWEEN $bln3 AND $bln2) AND (t.tbayar BETWEEN '$tawal' AND '$takhir') AND r.status_bayar=1 AND t.batal=0 GROUP BY m.gol;";
								$sql_i[3]="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter) as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal,ROUND(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0) as avg_harga, ROUND(IFNULL((SUM(r.pakai)/COUNT(*)),0),0) as avg_plg FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode WHERE $selip (r.periode BETWEEN $bln6 AND $bln4) AND (t.tbayar BETWEEN '$tawal' AND '$takhir') AND r.status_bayar=1 AND t.batal=0 GROUP BY m.gol;";
								$sql_i[4]="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter) as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal,ROUND(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0) as avg_harga, ROUND(IFNULL((SUM(r.pakai)/COUNT(*)),0),0) as avg_plg FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode WHERE $selip (r.periode BETWEEN $bln12 AND $bln7) AND (t.tbayar BETWEEN '$tawal' AND '$takhir') AND r.status_bayar=1 AND t.batal=0 GROUP BY m.gol;";
								
								$sql_i[5]="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter) as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal,ROUND(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0) as avg_harga, ROUND(IFNULL((SUM(r.pakai)/COUNT(*)),0),0) as avg_plg FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode WHERE $selip (r.periode BETWEEN $bln24 AND $bln13) AND (t.tbayar BETWEEN '$tawal' AND '$takhir') AND r.status_bayar=1 AND t.batal=0 GROUP BY m.gol;";
								$sql_i[6]="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter) as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal,ROUND(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0) as avg_harga, ROUND(IFNULL((SUM(r.pakai)/COUNT(*)),0),0) as avg_plg FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode WHERE $selip (r.periode BETWEEN $bln36 AND $bln25) AND (t.tbayar BETWEEN '$tawal' AND '$takhir') AND r.status_bayar=1 AND t.batal=0 GROUP BY m.gol;";
								$sql_i[7]="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter) as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal,ROUND(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0) as avg_harga, ROUND(IFNULL((SUM(r.pakai)/COUNT(*)),0),0) as avg_plg FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode WHERE $selip (r.periode >$prd_batas AND r.periode<=$bln37) AND (t.tbayar BETWEEN '$tawal' AND '$takhir') AND r.status_bayar=1 AND t.batal=0 GROUP BY m.gol;";
								$sql_i[8]="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter) as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal,ROUND(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0) as avg_harga, ROUND(IFNULL((SUM(r.pakai)/COUNT(*)),0),0) as avg_plg FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode WHERE $selip r.periode<=$prd_batas AND (t.tbayar BETWEEN '$tawal' AND '$takhir') AND r.status_bayar=1 AND t.batal=0 GROUP BY m.gol;";
								//$sql_i[7]="SELECT DISTINCT m.gol,(select distinct t.keterangan from tarif t where t.gol=m.gol LIMIT 0,1)as ket,COUNT(*) as jml_rek,SUM(r.pakai) as jpakai,SUM(r.uangair) as juangair,SUM(r.adm) as jadm,SUM(r.meter) as jmeter,SUM(r.meterai) as jmeterai,SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)) as jtotal,ROUND(IFNULL((SUM(r.uangair)/SUM(r.pakai)),0),0) as avg_harga, ROUND(IFNULL((SUM(r.pakai)/COUNT(*)),0),0) as avg_plg FROM rekening1 r, master m WHERE $selip r.periode<=$bln37 AND (r.tbayar LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode BETWEEN '$tawal' AND '$takhir') AND m.nomor=r.nomor and r.status_bayar=1 GROUP BY m.gol;";
								
								
								$j=1;$bts="";
								$c1=0;$c2=0;$c=0;$counter=0;
								$cnt1[]="";$cnt2[]="";$baris="";
								while($j<=8){
									if ($j==1) {$bts=$bln1;$peri="1 bulan";}
									if ($j==2) {$bts=$bln2." - ".$bln3;$peri="2 s/d 3 bulan";}
									if ($j==3) {$bts=$bln4." - ".$bln6;$peri="4 s/d 6 bulan";}
									if ($j==4) {$bts=$bln7." - ".$bln12;$peri="7 s/d 12 bulan";}
									if ($j==5) {$bts=$bln13." - ".$bln24;$peri="13 s/d 24 bulan";}
									if ($j==6) {$bts=$bln25." - ".$bln36;$peri="13 s/d 24 bulan";}
									if ($j==7) {$bts=$bln37." dst. ";$peri="37 bulan s/d batas Rek. dihapuskan";}
									//if ($j==8) {$bts="Dibawah Periode Rek. ".$prd_batas;$peri="Rek. Lain-lain [Dihapuskan]";}
									if ($j==8) {$bts="Periode 200001 s/d ".$prd_batas;$peri="Rek. Lain-lain [Dihapuskan]";}
									$qry1=mysql_query($sql_i[$j])or die(mysql_error());
									$i=0;
									
									$jrek=0;$pakai=0;$harga=0;$adm=0;$meter=0;$meterai=0;$total=0;$rata1=0;$rata2=0;								
									
									$c1++;
									
									echo"<tr style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\"><td colspan=12>Periode $peri >> $bts</td></tr>";
									$baris.="<tr style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\"><td colspan=12>Periode $peri >> $bts</td></tr>";
									$rows[]="<tr style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\"><td colspan=12>Periode $peri >> $bts</td></tr>";
									$counter++;
									while($row=mysql_fetch_row($qry1)){
										$i++;
										$c2++;
										
										$jrek+=$row[2];
										$pakai+=$row[3];
										$harga+=$row[4];
										$adm+=$row[5];
										$meter+=$row[6];
										$meterai+=$row[7];
										$total+=$row[8];
										$rata1+=$row[9];
										$rata2+=$row[10];
										
										echo"
										<tr>
											<td align=\"center\">$i</td>
											<td>$row[0]-$row[1]</td>
											
											<td align=\"right\">".formatMoney($row[2])."</td>
											<td align=\"right\">".formatMoney($row[3])."</td>
											<td align=\"right\">".formatMoney($row[4])."</td>
											<td align=\"right\">".formatMoney($row[5])."</td>
											<td align=\"right\">".formatMoney($row[6])."</td>
											<td align=\"right\">".formatMoney($row[7])."</td>
											<td align=\"right\">".formatMoney($row[8])."</td>
											<td align=\"right\">".formatMoney($row[9])."</td>
											<td align=\"right\">".formatMoney($row[10])."</td>
											
										</tr>
										";
										$baris.="
										<tr>
											<td align=\"center\">$i</td>
											<td align=\"center\">$row[0]</td>
											<td>$row[1]</td>
											<td align=\"right\">".formatMoney($row[2])."</td>
											<td align=\"right\">".formatMoney($row[3])."</td>
											<td align=\"right\">".formatMoney($row[4])."</td>
											<td align=\"right\">".formatMoney($row[5])."</td>
											<td align=\"right\">".formatMoney($row[6])."</td>
											<td align=\"right\">".formatMoney($row[7])."</td>
											<td align=\"right\">".formatMoney($row[8])."</td>
											<td align=\"right\">".formatMoney($row[9])."</td>
											<td align=\"right\">".formatMoney($row[10])."</td>
											
										</tr>
										";
										
										$rows[]="
										<tr>
											<td align=\"center\">$i</td>
											<td align=\"center\">$row[0]</td>
											<td>$row[1]</td>
											<td align=\"right\">".formatMoney($row[2])."</td>
											<td align=\"right\">".formatMoney($row[3])."</td>
											<td align=\"right\">".formatMoney($row[4])."</td>
											<td align=\"right\">".formatMoney($row[5])."</td>
											<td align=\"right\">".formatMoney($row[6])."</td>
											<td align=\"right\">".formatMoney($row[7])."</td>
											<td align=\"right\">".formatMoney($row[8])."</td>
											<td align=\"right\">".formatMoney($row[9])."</td>
											<td align=\"right\">".formatMoney($row[10])."</td>
											
										</tr>
										";
																				
										$counter++;
									}
									
										$rows[]="
										<tr>											
											<th colspan=\"3\">Sub Total</th>
											<th align=\"right\">".formatMoney($jrek)."</th>
											<th align=\"right\">".formatMoney($pakai)."</th>
											<th align=\"right\">".formatMoney($harga)."</th>
											<th align=\"right\">".formatMoney($adm)."</th>
											<th align=\"right\">".formatMoney($meter)."</th>
											<th align=\"right\">".formatMoney($meterai)."</th>
											<th align=\"right\">".formatMoney($total)."</th>
											<th align=\"right\">".formatMoney($rata1)."</th>
											<th align=\"right\">".formatMoney($rata2)."</th>
											
										</tr>
										";
									$counter++;
									
										echo"
										<tr>											
											<th colspan=\"2\">Sub Total</th>
											<th align=\"right\">".formatMoney($jrek)."</th>
											<th align=\"right\">".formatMoney($pakai)."</th>
											<th align=\"right\">".formatMoney($harga)."</th>
											<th align=\"right\">".formatMoney($adm)."</th>
											<th align=\"right\">".formatMoney($meter)."</th>
											<th align=\"right\">".formatMoney($meterai)."</th>
											<th align=\"right\">".formatMoney($total)."</th>
											<th align=\"right\">".formatMoney($rata1)."</th>
											<th align=\"right\">".formatMoney($rata2)."</th>
											
										</tr>
										";
									
									$j++;									
								}
								
							
							$sql_jml="
							SELECT format(count(*),0),format(SUM(r.pakai),0),format(SUM(r.uangair),0),format(SUM(r.adm),0),format(SUM(r.meter),0),format(SUM(r.meterai),0),format(SUM((r.uangair + r.adm + r.meter + r.meterai + r.denda)),0)
							FROM rekening1 AS r
							INNER JOIN master AS m ON m.nomor=r.nomor
							LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode
							WHERE $selip r.status_bayar=1 AND t.batal=0 AND (t.tbayar BETWEEN '$tawal' AND '$takhir')
							;";
							
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
							
							echo"
							<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;font-weight:bold;\">											
							<td colspan=\"2\" height=\"11\">GRAND TOTAL</td>
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
							$_SESSION["jumbaris"]=$counter-1;
							$_SESSION["tfooter"]=$tfooter;
							$_SESSION['rows']=$rows;
							$_SESSION['orientasi']='L';
							$_SESSION['batas']=30;
							$_SESSION['baris']=$baris;
							$_SESSION['ttd']="<br><br>
										<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
										<tr width=\"100%\">
											<td width=\"300\" align=\"center\">
												Diketuahui oleh,<br>
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
												Dibuat oleh,<br>
												<br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr>
										</table>
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
