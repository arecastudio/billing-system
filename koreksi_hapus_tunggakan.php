<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
//ob_flush();
//set_time_limit(24000);
require_once("global_functions.php");
require_once("head.php");

$ope=$_SESSION['nama_user'];
$lok="KOR";
$tgl=date('Y-m-d');
$jam=date('H:i:s');

kunci_halaman("util_hapus_tung",$secret,$ope);

//echo"<script language='javascript'>alert('Data berhasil disimpan!');</script>";
if(isset($_POST['hapus'])){	
	$sql="
	insert ignore into rekening1_hapus(nomor,nolama,nama,cabang,kode_wilayah,kode_blok,dkd,gol,periode,standlalu,standkini,pakai,loket,tbayar,uangair,adm,meter,denda,meterai,total,status_bayar,periode_tarif,periode_meterai)
	select r.nomor,r.nolama,r.nama,r.cabang,r.kode_wilayah,r.kode_blok,r.dkd,r.gol,r.periode,r.standlalu,r.standkini,r.pakai,r.loket,r.tbayar,r.uangair,r.adm,r.meter,r.denda,r.meterai,r.total,r.status_bayar,r.periode_tarif,r.periode_meterai from rekening1 as r where r.nomor='".$_POST['txnomor']."' and r.status_bayar=0 and (r.periode between ".$_POST['p1']." and ".$_POST['p2'].")
	;";
	$qry=mysql_query($sql)or die(mysql_error());
	
	$sql="
	update rekening1_hapus set tgl_hapus='$tgl',op_hapus='$ope',jam_hapus='$jam'
	where nomor='".$_POST['txnomor']."' and status_bayar=0 and (periode between ".$_POST['p1']." and ".$_POST['p2'].")
	;";
	$qry=mysql_query($sql)or die(mysql_error());
	
	$sql="
	delete from rekening1 where nomor='".$_POST['txnomor']."' and status_bayar=0 and (periode between ".$_POST['p1']." and ".$_POST['p2'].")
	;";
	$qry=mysql_query($sql)or die(mysql_error());
	
	echo"<script language='javascript'>alert('Data berhasil dihapus!');</script>";
}

require_once("head.php");
?>

	<tr>
		<td>
		<script type="text/javascript">					
			function checkKey(){
				if (window.event.keyCode == 13){
					alert("you hit return!");
				}
			}
			
			function isNumb(evt){
				var charCode = (evt.which) ? evt.which : event.keyCode				
				if (charCode > 31 && (charCode < 48 || charCode > 57)){
					return false;
				}
				return true;
			}
		</script>
		<br />
			<center><font face="Arial,sans-serif" size="3px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:15px;"><b>Penghapusan Tunggakan Rek. Pelanggan [Koreksi]</b></font></center>
			<div class="wrapper5">
			
			<table width="400px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper1" style="font-size:15px;font-family:courier;">
			<form id="frmerkwm" name="frmerkwm" method="post" action="" onSubmit="return suvalid(this);">
				<tr>
					<td>Periode Rek.</td>
					<td>
						<input type="text" size="8px" id="p1" name="p1" maxlength="6" onKeyPress="return isNumb(event);" style="font-size:13px;font-family:courier;color:#0f0;background:#000;" />s/d
						<input type="text" size="8px" id="p2" name="p2" maxlength="6" onKeyPress="return isNumb(event);" style="font-size:13px;font-family:courier;color:#0f0;background:#000;" />
					</td>
				</tr>
				<tr>
					<td>Nomor</td>
					<td>
						<input type="text" size="15px" id="txnomor" name="txnomor" maxlength="6" onKeyPress="return isNumb(event);" style="font-size:15px;font-family:courier;color:#0f0;background:#000;" />
					</td>
				</tr>
				<tr align="right">				
					<td colspan="2">
						<input type="submit" name="hapus" value="Hapus" class="kelas_tombol" />
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left">
						<!--a href="custcredit.php" style="font-size:11px;color:#00f;font-family:verdana;">Klik disini untuk Cek Tunggakan Pelanggan</a-->
					</td>
				</tr>
			</form>
			</table>
			
			</div>
			
							
		</td>
	</tr>
    
     <!--focus kursor -->
<script type="text/javascript" language="javascript">
	 $(function() {
    
	   $("#txnomor").focus();
       
    });
</script>

	<tr>
		<td><!--br-->
        	<!--table class="wrapper1" width="600px" border="0" cellpadding="0" cellspacing="0" align="center" background="img/grids.gif">
                <tr align="center" bgcolor="white">
                    <th width="50%"><a href="custcredit.php">TUNGGAKAN PER PELANGGAN</a></th>
                    <th width="50%"><a href="custinfo.php">CETAK DATA MASTER PELANGGAN</a></th>
                </tr>			
			</table-->
            
            <h3 align="center" style="text-shadow:4px -4px 2px black;color:#fff;">Rekening Pelanggan</h3><hr width="600px" align="center" />            
            <table width="880px" border="0" cellpadding="1" cellspacing="2" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;box-shadow: 0 0 15px #999;" background="img/grids.gif">
				<form name="f1" method="post" action="" onSubmit="">
				<tr>
					<td width="100px">Nomor/No Lama</td>					
					<td colspan="2"><input type="text" name="txnomor" id="txnomor" size="10" maxlength="13" value="" onKeyPress="return isNumb(event);" />
						&nbsp;&nbsp;<input type="submit" name="cari" value="Tampilkan" class="kelas_tombol" />
                        &nbsp;&nbsp;<input type="button" name="cr" value="Cari" class="kelas_tombol"  onclick="window.open('cari.php','popUpWindow','height=400,width=800,left=10,top=10,scrollbars=yes,menubar=no'); return false;" />
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="all" id="all" value="all" />Tampilkan Rek. Terbayar juga
					</td>
				</tr>
                </form>				
                <?php
				#$plalu=getPeriodeLalu();$pkini=gperiode();$i=0;
                if(isset($_POST['cari']) && $_POST['txnomor']!=''){
					$nmr=$_POST['txnomor'];
					echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").value=\"$nmr\";</script>";
					
					$all=0;
					if(isset($_POST["all"])){
						echo"<script type=\"text/javascript\">document.getElementById(\"all\").checked=\"checked\";</script>";
						$selip="";//" AND (r.status_bayar=0 OR r.status_bayar=1)";
					}else{
						$selip=" AND r.status_bayar=0";
					}
					
					$jdl="<b>INFORMASI REKENING PELANGGAN</b>";
					$sql="SELECT DISTINCT m.NOMOR, m.NOLAMA, m.NAMA, m.ALAMAT, m.cabang,c.nama, m.kode_wilayah,w.nama_wilayah, m.kode_blok,b.ket_blok, m.DKD,d.jalan, m.GOL,g.keterangan, IF(m.PUTUS='0','AKTIF [0]',if(m.putus='3','PUTUS [3] . Hubungi bag. Hubungan Langganan untuk Penyambungan Kembali','HAPUS [5] . Hubungi bag. Hubungan Langganan untuk pelunasan')), m.tglstart, m.kondisi_meter
					,(SELECT FORMAT(COUNT(r.nomor),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001)
					,(SELECT IFNULL(FORMAT(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=0 AND r.periode>=200001)
					,(SELECT FORMAT(COUNT(r.nomor),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=1 AND r.periode>=200001)
					,(SELECT IFNULL(FORMAT(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0),0) FROM rekening1 AS r WHERE r.nomor=m.nomor AND r.status_bayar=1 AND r.periode>=200001)
					FROM master AS m
					LEFT OUTER JOIN cabang AS c ON c.cabang=m.cabang
					LEFT OUTER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah AND w.kode_cabang=m.cabang
					LEFT OUTER JOIN master_blok AS b ON b.kode_blok=m.kode_blok
					LEFT OUTER JOIN dkd AS d ON d.dkd=m.dkd
					LEFT OUTER JOIN tarif AS g ON g.gol=m.gol					
					WHERE (m.nomor='$nmr' OR m.nolama='$nmr');";
					$qry=mysql_query($sql)or die(mysql_error());
					if($row=mysql_fetch_row($qry)){
						$nmr=$row[0];
						$nolama=$row[1];
						$jdl.="<table>
						<tr><td>Nomor</td><td>:&nbsp;&nbsp;$row[0] / $row[1]</td></tr>
						<tr><td>Nama</td><td>:&nbsp;&nbsp;$row[2]</td></tr>
						<tr><td>Alamat</td><td>:&nbsp;&nbsp;$row[3]</td></tr>
						<tr><td>DKD</td><td>:&nbsp;&nbsp;$row[10] - $row[11]</td></tr>
						<tr><td>Golongan</td><td>:&nbsp;&nbsp;$row[12] - $row[13]</td></tr>
						<tr><td>Stat Sambung</td><td>:&nbsp;&nbsp;$row[14]</td></tr>
						<tr><td>Jml Tunggak</td><td>:&nbsp;&nbsp;$row[17] lembar.&nbsp;&nbsp;Rp. $row[18]</td></tr>	
						</table>
						";
						$kwm=kondisi_wm($row[16]);
						echo"						
						<tr>
							<td>&nbsp;</td>
							<td width=\"90px\">Nomor</td>
							<td>:&nbsp;&nbsp;$row[0] / $row[1]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Nama</td>
							<td>:&nbsp;&nbsp;$row[2]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Alamat</td>
							<td>:&nbsp;&nbsp;$row[3]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Cabang</td>
							<td>:&nbsp;&nbsp;$row[4] - $row[5]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Wilayah</td>
							<td>:&nbsp;&nbsp;$row[6] - $row[7]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>BLOK</td>
							<td>:&nbsp;&nbsp;$row[8] - $row[9]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>DKD</td>
							<td>:&nbsp;&nbsp;$row[10] - $row[11]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Golongan</td>
							<td>:&nbsp;&nbsp;$row[12] - $row[13]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td style=\"color:#f00;font-weight:bold;\">Status Pel.</td>
							<td style=\"color:#f00;font-weight:bold;\">:&nbsp;&nbsp;$row[14]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Tgl. Pasang</td>
							<td>:&nbsp;&nbsp;$row[15]</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Kondisi WM</td>
							<td>:&nbsp;&nbsp;$row[16] - $kwm</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Jml. Tunggak</td>
							<td style=\"font-weight:bold;font-style:italic;\">:&nbsp;&nbsp;$row[17] Lembar.&nbsp;&nbsp;&nbsp;Rp.&nbsp;$row[18]</td>
						</tr>
						<tr>
							<td align=\"left\"><a href=\"reports/print_report_pel.php\" target=\"_blank\" style=\"color:#f00;font-weight:bold;\">-=Cetak=-</a></td>
							<td>Jml. Lunas</td>
							<td style=\"font-weight:bold;font-style:italic;\">:&nbsp;&nbsp;$row[19] Lembar.&nbsp;&nbsp;&nbsp;Rp.&nbsp;$row[20]</td>
						</tr>
						";						
						$sql000="SELECT DISTINCT r.periode, FORMAT(r.standlalu,0), FORMAT(r.standkini,0), FORMAT (r.pakai,0), FORMAT(r.uangair,0), FORMAT(r.adm,0), FORMAT(r.meter,0), FORMAT(r.denda,0), IFNULL(FORMAT(r.meterai,0),0), IFNULL(FORMAT(r.uangair + r.adm + r.meter + r.meterai + r.denda,0),0),IF(r.status_bayar=0,'TUNGGAK','LUNAS'),IF(r.status_bayar=1,IF(t.tbayar<>'0000-00-00',t.tbayar,r.tbayar),'-'),IF(r.status_bayar=1,IF(t.loket<>'',t.loket,r.loket),'-'),IF(r.status_bayar=1,UCASE(t.operator),'-')
						FROM rekening1 AS r
						LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode
						WHERE r.nomor='$nmr' AND r.periode>=200001 $selip
						ORDER BY r.periode ASC
						;";
						
						$sql="SELECT DISTINCT r.periode, FORMAT(r.standlalu,0), FORMAT(r.standkini,0), FORMAT (r.pakai,0), FORMAT(r.uangair,0), FORMAT(r.adm,0), FORMAT(r.meter,0), FORMAT(r.denda,0), IFNULL(FORMAT(r.meterai,0),0), IFNULL(FORMAT(r.uangair + r.adm + r.meter + r.meterai + r.denda,0),0),IF(r.status_bayar=0,'TUNGGAK','LUNAS'),IF(r.status_bayar=1,(SELECT t.tbayar FROM transaksi AS t WHERE t.nomor=r.nomor AND t.periode=r.periode ORDER BY t.batal ASC,t.tbayar ASC, t.jbayar ASC LIMIT 1),'-'),IF(r.status_bayar=1,(SELECT t.loket FROM transaksi AS t WHERE t.nomor=r.nomor AND t.periode=r.periode ORDER BY t.batal ASC,t.tbayar ASC, t.jbayar ASC LIMIT 1),'-'),IF(r.status_bayar=1,(SELECT t.operator FROM transaksi AS t WHERE t.nomor=r.nomor AND t.periode=r.periode ORDER BY t.batal ASC,t.tbayar ASC, t.jbayar ASC LIMIT 1),'-')
						FROM rekening1 AS r
						
						WHERE r.nomor='$nmr' AND r.periode>=200001 $selip
						ORDER BY r.periode ASC
						;";
						#$slipit=" a.nomor=b.nomor and b.nomor=m.nomor and a.periode=$plalu and b.periode=$pkini and m.putus='0' ";
						$qry=mysql_query($sql)or die(mysql_error());
						echo"<tr><td colspan=\"3\">";
						echo"<div style=\"height:330px;overflow:auto\">";
						echo"<table bgcolor=\"#000\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;\">";
						echo"<tr align=\"center\" style=\"background:linear-gradient(#999,#000);color:#fff;\"><th>Rek.</th><th>St.Awal</th><th>St.Akhir</th><th>Pakai</th><th>Hrg Air</th><th>Adm.</th><th>Meter</th><th>Denda</th><th>Meterai</th><th>Jumlah</th><th>Stat</th><th>Ket</th><th>Lkt</th><th>Opr</th></tr>";
						$tmp_periode='8';
						$plalu='';
						while($row=mysql_fetch_row($qry)){
						$pakhir=$row[0];
						
							echo"<tr style=\"background-color:#ffe;color:#000;\">";
							echo"<td align=\"center\">$row[0]</td>";
							
							if($tmp_periode!='8')$plalu=$tmp_periode;
							
							#munculkan foto
							if(file_exists("foto_meter/".$nolama."_".$plalu.".jpg")){
								echo"<td align=right><a style=\"color:#00f;\" href=\"foto_meter/$nolama"."_"."$plalu".".jpg\" target=\"_blank\">".trim($row[1])."</a></td>";
							}else{
								echo"<td align=right>".trim($row[1])."</td>";
							}
					
							if(file_exists("foto_meter/".$nolama."_".$pakhir.".jpg")){
								echo"<td align=right><a style=\"color:#00f;\" href=\"foto_meter/$nolama"."_"."$pakhir".".jpg\" target=\"_blank\">".trim($row[2])."</a></td>";
							}else{					
								echo"<td align=right>".trim($row[2])."</td>";
							}
									for($i=3;$i<=9;$i++){
								echo"<td align=\"right\">$row[$i]</td>";
							}
							echo"<td align=\"center\">$row[10]</td>";
							echo"<td align=\"center\">$row[11]</td>";
							echo"<td align=\"center\">$row[12]</td>";
							echo"<td align=\"center\">".ucwords(trim($row[13]))."</td>";
							echo"</tr>";
							
							$tmp_periode=$row[0];
						}
						echo"</table>";
						echo"</div>";
						echo"</td></tr>";							
						
						$_SESSION["judul"]=$jdl;
						$_SESSION["jumfield"]=12;
						$_SESSION["eskiel"]=$sql;
						$_SESSION["alinea"]=array("center","right","right","right","right","right","right","right","right","right","center","center");
						$_SESSION['theader']="<tr style=\"height:150px;text-align:center;\"><th>No.</th><th width=50>Rek</th><th>Stand<br>Awal</th><th>Stand<br>Akhir</th><th>Pakai</th><th width=80>Harga<br>Air</th><th width=50>Adm</th><th width=50>Meter</th><th>Denda</th><th>Meterai</th><th width=80>Total</th><th width=80>Stat</th><th width=80>Ket</th></tr>";
						$_SESSION['orientasi']='P';
						$_SESSION['batas']=35;					
					}						
				}
				?>     		
     		</table>
            				
		</td>
	</tr>
	
	
<?php
putus();
require_once("foot.php");
?>
