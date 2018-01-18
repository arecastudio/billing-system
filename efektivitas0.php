<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
?>

	<tr>
		<td>
		
		<center><font face="Arial,sans-serif" size="4px"><b>Efektivitas Penagihan Rekening Air</b></font></center><hr width="900px"/>
		<table width="800px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr>
            	<td>
					<?php
                    	//$peri=getPeriodeLalu();
						//echo date('Ym',strtotime('2014-12-05'));
					?>
                    Tanggal
                </td>
               	<td colspan="3">
                    <input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]
                </td>
            </tr>
            <tr>
            	<td width="170px"><input type="radio" name="r1" id="rall" value="rall" checked />Semua Cabang [UPP]</td>
                <td>&nbsp;</td>
                <td width="200">Sisa Rekening sampai 2(Dua) bulan lalu, mulai dari Periode:</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td><input type="radio" name="r1" id="rupp" value="rupp"/>Per-Cabang[UPP]</td>
                <td>
                	<select name="optcabang" id="optcabang" >
                  	<!--option value="" selected="selected">-Pilih-</option-->
                  	<?php
						$sql=mysql_query("select cabang,nama from cabang where cabang<>'00' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
					?>
              		</select>
                </td>
                <td align="center"><select name="optperiode" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <?php
						//$sql=mysql_query("select distinct periode from rekening1 order by periode desc");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						//if($row=mysql_fetch_row($sql)){
							//$i=0;
							$prd0=date('Ym',strtotime('-3 month'));//$row[0];
							while($prd0>=200001){
								if($prd0==201101){
								echo"<option value=\"$prd0\" selected=\"selected\">$prd0</option>";
								}else{
								echo"<option value=\"$prd0\">$prd0</option>";
								}
								$prd0--;//201405 201404 201001 201000 200912
								if(substr($prd0,4,2)==00)$prd0-=88;
							}
							//echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						//}
					?>
              </select></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>
                	<input type="submit" name="proses" value="Proses" />
                    <input type="reset" name="batal" value="Batal" />
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        	</form>    
		</table>
        
        <br />
		<table width="900px" align="center" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 0 0 15px #999;" background="img/grids.gif">
			<tr>
				<td width="100%" align="center">
					<div style="height:420px;overflow:auto">
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">
                        	<tr align="center" style="background:linear-gradient(#fff,#a0a0a0);color:#000;font-weight:bold;">
                            	<td colspan="4">Penerimaan Penagihan</td>
                                <td align=center rowspan="2">Pelayanan</td>
                                <td colspan="4">Rekening Yang Masih Harus Ditagih</td>
                            </tr>
                            <tr align="center" style="background:linear-gradient(#fff,#a0a0a0);color:#000;font-weight:bold;">
								<td>Sisa Rek. s/d<br>2 Bln Y.L</td>
								<td>Sisa Rek.<br>Bln Y.L</td>
								<td>Rek. Bl.<br>Ini</td>
								<td>Jumlah</td>
                                
								<td>Jumlah</td>
								<td>Rek. Bl.<br>Ini</td>
                                <td>Sisa Rek.<br>Bln Y.L</td>
                                <td>Sisa Rek. s/d<br>2 Bln Y.L</td>
							</tr>
                            <?php
                            if(isset($_POST['proses'])){
								
								
								if(($key2=$_POST['txtakhir'])!=''){
									$takhir=$key2;
									echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$key2\";</script>";
								}
								$peri=date('Ym',strtotime($takhir));
								$judul="EVEKTIVITAS PENAGIHAN REKENING AIR<br>PEMBAYARAN REKENING PER TANGGAL $takhir";
								
								if((isset($_POST['r1']) && $key=$_POST["optcabang"])!=""){
									if($key=='11'){
										//$slipit=cek_slip($slipit)."m.cabang<>'$key'";
										//$judul.="<br>Cabang : Semua UPP";
									}else{
										//$slipit=cek_slip($slipit)."r.cabang='$key'";
										$nama_key=getNama("nama",$key,"cabang","cabang");//field_to_get,val_inject,index,table_name
										$judul.="<br>Cabang : $key - $nama_key";
									}
									echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$key\";</script>";
									echo"<script type=\"text/javascript\">document.getElementById(\"rupp\").checked=\"checked\";</script>";
								}
								
								$sql="";//periode $peri
								$cbg=$_POST['optcabang'];
								//$bkini=date('Ym');//echo $bkini;
								$bkini=date('Ym',strtotime($takhir));
								$blalu1=date('Ym',strtotime($takhir.'-1 month'));
								$blalu2=date('Ym',strtotime($takhir.'-2 month'));								
								$bsampai=$_POST['optperiode'];
								
								$theader="
							<tr align=\"center\" style=\"color:#000;font-weight:bold;\">
                            	<td rowspan=\"2\">No.</td>
								<td colspan=\"3\">Penerimaan Penagihan</td>
                                <td width=25 align=center rowspan=\"2\">GOL</td>
								<td width=280 align=center rowspan=\"2\">Pelayanan</td>
                                <td colspan=\"4\">Rekening Yang Masih Harus Ditagih</td>
                            </tr>
                            <tr align=\"center\" style=\"color:#000;font-weight:bold;\">
								<td width=100>Sisa Rek. s/d<br>2 Bln Y.L<br>[$blalu2]</td>
								<td width=100>Sisa Rek.<br>Bln Y.L<br>[$blalu1]</td>
								<td width=100>Rek. Bl.<br>Ini<br>[$bkini]</td>
								
                                
								
								<td width=100>Rek. Bl.<br>Ini<br>[$bkini]</td>
                                <td width=100>Sisa Rek.<br>Bln Y.L<br>[$blalu1]</td>
                                <td width=100>Sisa Rek. [$bsampai] s/d<br>2 Bln Y.L<br>[$blalu2]</td>
							</tr>
								";
								
								
								if(isset($_POST['r1'])){
									//echo"semua";
									if($_POST['r1']=='rall'){
									$judul.="<br>Cabang : Semua UPP";
									$sql="select DISTINCT m.gol,(select distinct t.keterangan from tarif as t where t.gol=m.gol)as ket,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE r.periode=$bkini AND r.status_bayar=1 AND r.tbayar<=$takhir AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_kini,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE r.periode=$blalu1 AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_1lalu,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_2lalu,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE r.periode=$bkini AND (r.status_bayar=0 OR r.tbayar<=$takhir) AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_kini,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE r.periode=$blalu1 AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_1lalu,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_2lalu
from tarif as m;";

									$sql_r="select DISTINCT 
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_2lalu,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE r.periode=$blalu1 AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_1lalu,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE r.periode=$bkini AND r.status_bayar=1 AND r.tbayar<=$takhir AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_kini,

(select distinct t.gol from tarif as t where t.gol=m.gol)as ket,
(select distinct t.keterangan from tarif as t where t.gol=m.gol)as ket,


(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE r.periode=$bkini AND (r.status_bayar=0 OR r.tbayar>$takhir) AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_kini,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE r.periode=$blalu1 AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_1lalu,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_2lalu
from tarif as m;";

									}if($_POST['r1']=='rupp'){
									/*$sql="select DISTINCT m.gol,(select distinct t.keterangan from tarif as t where t.gol=m.gol)as ket,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master m1 WHERE m1.cabang='$cbg' AND r.periode=$bkini AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_kini,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master m1 WHERE m1.cabang='$cbg' AND r.periode=$blalu1 AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_1lalu,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master m1 WHERE m1.cabang='$cbg' AND (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_2lalu,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master m1 WHERE m1.cabang='$cbg' AND r.periode=$bkini AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_kini,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master m1 WHERE m1.cabang='$cbg' AND r.periode=$blalu1 AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_1lalu,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master m1 WHERE m1.cabang='$cbg' AND (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_2lalu
from tarif as m;";*/
							
									$sql="select DISTINCT m.gol,(select distinct t.keterangan from tarif as t where t.gol=m.gol)as ket,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND r.periode=$bkini AND r.status_bayar=1 AND r.tbayar<=$takhir AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_kini,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND r.periode=$blalu1 AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_1lalu,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_2lalu,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND r.periode=$bkini AND (r.status_bayar=0 OR r.tbayar>$takhir) AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_kini,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND r.periode=$blalu1 AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_1lalu,
(SELECT IFNULL(sum(r.total),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_2lalu
from tarif as m;";

									$sql_r="select DISTINCT
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_2lalu,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND r.periode=$blalu1 AND r.status_bayar=1 AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_1lalu,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND r.periode=$bkini AND r.status_bayar=1 AND r.tbayar<=$takhir AND m1.nomor=r.nomor AND m1.gol=m.gol )as lpp_kini,

(select distinct t.gol from tarif as t where t.gol=m.gol)as ket,
(select distinct t.keterangan from tarif as t where t.gol=m.gol)as ket,
 

(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND r.periode=$bkini AND (r.status_bayar=0 or r.tbayar>$takhir) AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_kini,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND r.periode=$blalu1 AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_1lalu,
(SELECT FORMAT(IFNULL(sum(r.total),0),0) FROM rekening1 as r,master as m1 WHERE m1.cabang='$cbg' AND (r.periode BETWEEN $bsampai AND $blalu2) AND r.status_bayar=0 AND m1.nomor=r.nomor AND m1.gol=m.gol )as dsr_2lalu
from tarif as m;";
									
									}
									$lpp3=0;$lpp2=0;$lpp1=0;
									$dsr3=0;$dsr2=0;$dsr1=0;
									$qry=mysql_query($sql)or die(mysql_error());
									while($row=mysql_fetch_row($qry)){
										echo"
										<tr>
											<td align=\"right\">".formatMoney($row[4])."</td>
											<td align=\"right\">".formatMoney($row[3])."</td>
											<td align=\"right\">".formatMoney($row[2])."</td>
											
											<td align=\"right\">&nbsp;</td>
											
											<td align=\"center\">$row[0] - $row[1]</td>
											
											<td align=\"right\">&nbsp;</td>
											
											<td align=\"right\">".formatMoney($row[5])."</td>
											<td align=\"right\">".formatMoney($row[6])."</td>
											<td align=\"right\">".formatMoney($row[7])."</td>
											
										</tr>
										";
										$lpp3+=$row[4];
										$lpp2+=$row[3];
										$lpp1+=$row[2];
										
										$dsr1+=$row[5];
										$dsr2+=$row[6];
										$dsr3+=$row[7];
									}
										
										echo"
										<tr height=\"25\" style=\"background:linear-gradient(#fff,#a0a0a0);color:#000;font-weight:bold;\">
											<td align=\"right\">".formatMoney($lpp3)."</td>
											<td align=\"right\">".formatMoney($lpp2)."</td>
											<td align=\"right\">".formatMoney($lpp1)."</td>
											
											<td align=\"right\">&nbsp;</td>
											
											<td align=\"center\">&nbsp;</td>
											
											<td align=\"right\">&nbsp;</td>
											
											<td align=\"right\">".formatMoney($dsr1)."</td>
											<td align=\"right\">".formatMoney($dsr2)."</td>
											<td align=\"right\">".formatMoney($dsr3)."</td>
											
										</tr>
										";
										
										$tfooter="
										<tr height=\"25\" style=\"background:linear-gradient(#fff,#a0a0a0);color:#000;font-weight:bold;\">
											<td align=\"center\">&nbsp;</td>
											<td align=\"right\">".formatMoney($lpp3)."</td>
											<td align=\"right\">".formatMoney($lpp2)."</td>
											<td align=\"right\">".formatMoney($lpp1)."</td>
											
											<td align=\"center\">&nbsp;</td>
											<td align=\"center\">&nbsp;</td>
											
											<td align=\"right\">".formatMoney($dsr1)."</td>
											<td align=\"right\">".formatMoney($dsr2)."</td>
											<td align=\"right\">".formatMoney($dsr3)."</td>
											
										</tr>
										";
										
								//}else if(isset($_POST['r1'])&&$_POST['r1']=='rupp'){
									//echo"upp";
								//	$sql="SELECT  FROM WHERE GROUP BY ORDER BY";
								//echo $sql;
								$alg=array("right","right","right","center","center","right","right","right","right","right","right","right","right");
								$_SESSION["alinea"]=$alg;
								$_SESSION["judul"]=$judul;
								$_SESSION["jumfield"]=8;
								$_SESSION["eskiel"]=$sql_r;
								//$_SESSION["alinea"]=$alg;
								$_SESSION["theader"]=$theader;
								//$_SESSION["jumdata"]=$jml_data;
								$_SESSION["tfooter"]=$tfooter;
								$_SESSION['orientasi']='L';
								//$_SESSION['batas']=30;
								$_SESSION['ttd']="<br>
										<table align=\"center\" border=\"0\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;border-spacing:1px;padding:1px;width:600px;\">
										<tr width=\"100%\">
											<td width=\"200\" align=\"center\">
												Diketahui oleh,<br>
												<br><br>
												...............................<br>Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td width=\"200\" align=\"center\">
												Disetujui oleh,<br>
												<br><br>
												...............................<br>
												Jab.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
							}
							?>                            
                        </table>
                   	</div>
				</td>
			</tr>
            <tr>
				<td><a href="reports/print_report.php" target="_blank" style="font-size:16px;">-= Cetak Report =-</a></td>
			</tr>
        </table>
		<br />
		
		</td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>