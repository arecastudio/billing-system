<?php
ob_start();
session_start();
require_once("mydb.php");
//sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');
?>

	<tr>
		<td>
		<!--############################################################################################################-->
        	<br />
		<table width="700px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
        	<form name="f1" method="post" action="">
            <tr>
              <td colspan="4" align="center" style="padding:2px 0;text-shadow:2px 2px 2px red;color:#000;font-size:18px;background: linear-gradient(#ff0, #fff);font-weight:bold;font-family:'Times New Roman', Times, serif'" ><b>Update LPP Semua ke Cabang [UPP]</b></font></td>
              </tr>
            <tr>
            	<td>Cabang</td>
                <td>
                <select name="optcabang" id="optcabang" >
                  <!--option value="11" selected="selected">Semua UPP</option-->
                  <?php
						$sql=mysql_query("select cabang,nama from cabang WHERE cabang<>'00' AND cabang<>'01' AND cabang<>'06' order by cabang");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>                </td>
                <td><!--input type="submit" name="master" value="Ambil Data Pelanggan" /--></td>
                <td></td>
            </tr>
            <tr>
            	<td>Tanggal Pelunasan LPP</td>
                <td>
                <input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]                </td>
                <td><input type="submit" name="lpp" id="lpp" value="Kirim LPP Semua" class="kelas_tombol" /></td>
                <td></td>
            </tr>
            </form>
        </table>
		<!--###############-->
		<?php
		if(isset($_POST['lpp'])){
			$cabang=$_POST['optcabang'];
			echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>";
			$ip="";
			switch($cabang){
				case"01";
					$ip="192.168.0.200";
					break;
				case"02";
					//$ip="192.168.1.16";
					//$ip="192.168.0.12";
					$ip="192.168.1.50";
					break;
				case"03";
					$ip="192.168.2.60";
					break;
				case"04";
					$ip="192.168.5.80";
					break;
				case"05";
					$ip="192.168.4.70";
					break;
			}
			
			$tawal='2000-01-01';
			$takhir=date('Y-m-d');
			if(($key1=$_POST['txtawal'])!=''){
			$tawal=$key1;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$tawal\";</script>";
			}
			if(($key2=$_POST['txtakhir'])!=''){
				$takhir=$key2;
				echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$takhir\";</script>";
			}
			
			//=============================REKENING1
			$i=0;
			//konek("192.168.0.200","root","","billing");
			//konek($ip,"pdam","","billing");
			konek("localhost","root","pdamjpr123","billing");
			//$qry=mysql_query("SELECT DISTINCT nomor,periode,angka FROM dsmp0 WHERE PERIODE=201409")or die(mysql_error());
			//$qry=mysql_query("SELECT DISTINCT nomor,periode,standlalu,standkini,pakai,loket,tbayar,uangair,adm,meter,denda,meterai,total,status_bayar FROM rekening1 WHERE status_bayar=1 AND (tbayar BETWEEN '$tawal' AND '$takhir');")or die(mysql_error());
			$qry=mysql_query("SELECT DISTINCT r.nomor,r.periode,r.standlalu,r.standkini,r.pakai,r.loket,r.tbayar,r.uangair,r.adm,r.meter,r.denda,r.meterai,r.total,r.status_bayar FROM rekening1 AS r INNER JOIN transaksi AS t on t.nomor=r.nomor AND t.periode=r.periode WHERE r.status_bayar=1 AND t.batal=0 AND (t.tbayar BETWEEN '$tawal' AND '$takhir');")or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;
					//$data[$i]=array($row[0],$row[1],$row[2]);
					$nomor[$i]=$row[0];
					$periode[$i]=$row[1];					
					$standlalu[$i]=$row[2];
					$standkini[$i]=$row[3];
					$loket[$i]=$row[4];
					$tbayar[$i]=$row[5];
					$uangair[$i]=$row[6];
					$adm[$i]=$row[7];
					$meter[$i]=$row[8];
					$denda[$i]=$row[9];
					$meterai[$i]=$row[10];
					$total[$i]=$row[11];
					$statbayar[$i]=$row[12];
					
					
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//putus();
				
				//konek("192.168.0.100","root","","billing");
				konek($ip,"pdam","","billing");
				//konek("192.168.0.13","pdam","","billing");
				//$qry=mysql_query("INSERT INTO dsmpo") or die(mysql_error());
				//for($i=0;$i<$jml;$i++){
				$i=0;
				while($i<$jml){
					$i++;
					
					//$qry=mysql_query("INSERT IGNORE INTO dsmp_copy(nomor,periode,angka)VALUES('$nomor[$i]',$periode[$i],$angka[$i])") or die(mysql_error());
					//$qry=mysql_query("INSERT IGNORE INTO transaksi_copy(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					//$qry=mysql_query("INSERT IGNORE INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					$sql_rek="
					UPDATE rekening1 SET
					status_bayar=1, tbayar='$tbayar[$i]', loket='$loket[$i]'
					WHERE nomor='$nomor[$i]' AND periode=$periode[$i]
					;";
					$qry=mysql_query($sql_rek) or die(mysql_error());
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}				
			}			
			//=================TRANSAKSI======================================
			$i=0;
			konek("localhost","root","pdamjpr123","billing");
			//konek($ip,"pdam","","billing");
			//$qry=mysql_query("SELECT DISTINCT nomor,periode,angka FROM dsmp0 WHERE PERIODE=201409")or die(mysql_error());
			$qry=mysql_query("SELECT DISTINCT nomor,periode,total,tbayar,jbayar,loket,operator,batal FROM transaksi WHERE (tbayar BETWEEN '$tawal' AND '$takhir');")or die(mysql_error());
			$jml=mysql_num_rows($qry);
			$data[$jml]="";
			if($jml>0){
				while($row=mysql_fetch_row($qry)){
					$i++;
					//$data[$i]=array($row[0],$row[1],$row[2]);
					$nomor[$i]=$row[0];
					$periode[$i]=$row[1];
					$total[$i]=$row[2];
					$tbayar[$i]=$row[3];
					$jbayar[$i]=$row[4];
					$loket[$i]=$row[5];
					$operator[$i]=$row[6];
					$batal[$i]=$row[7];
					
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//putus();
				
				konek($ip,"pdam","","billing");
				//konek("192.168.0.13","pdam","","billing");
				//$qry=mysql_query("INSERT INTO dsmpo") or die(mysql_error());
				//for($i=0;$i<$jml;$i++){
				$i=0;
				while($i<$jml){
					$i++;
					
					//$qry=mysql_query("INSERT IGNORE INTO dsmp_copy(nomor,periode,angka)VALUES('$nomor[$i]',$periode[$i],$angka[$i])") or die(mysql_error());
					//$qry=mysql_query("INSERT IGNORE INTO transaksi_copy(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					$qry=mysql_query("INSERT IGNORE INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor[$i]',$periode[$i],$total[$i],'$tbayar[$i]','$jbayar[$i]','$loket[$i]','$operator[$i]',$batal[$i]);") or die(mysql_error());
					
					//echo"Hasil: $nomor[$i] - $periode[$i] -  $angka[$i]<br/>";
				}
				//if($qry)echo"<script language='javascript'>alert('Berhasil Ambil Data!');</script-->";
				//putus();
			}			
			//======================================
		}
		?>
		<!--###############-->
		<br/>
        <table width="1024px" align="center" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 0 0 15px #999;" background="img/grids.gif">
			<tr>
				<td width="100%" align="center">
                <div style="height:300px;overflow:auto">
                    <table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
        <?php
        if(isset($_POST['dsmp'])){			
			echo"<tr style=\"background-color:#909090;color:#FFFFFF;\">";
			echo"<th width=\"2px\">No.</th><th>Nomor</th><th>Periode</th><th>Angka Meter</th>";
			echo"</tr>";
			$i=0;
			while($i<$jml){
				$i++;
				echo"<tr><td align=left>$i</td><td align=center>$nomor[$i]</td><td align=center>$periode[$i]</td><td align=right>$angka[$i]</td></tr>";
			}
		}else if(isset($_POST['lpp'])){
			echo"<tr style=\"background-color:#909090;color:#FFFFFF;\">";
			echo"<th width=\"2px\">No.</th><th>Nomor</th><th>Periode</th><th>Total</th><th>Tgl Bayar</th><th>Jam</th><th>Loket</th><th>Kasir</th><th>Stat<br>Trans</th>";
			echo"</tr>";
			$i=0;
			while($i<$jml){
				$i++;
				//echo"<tr><td align=left>$i</td><td align=center>$nomor[$i]</td><td align=center>$periode[$i]</td><td align=right>$angka[$i]</td></tr>";
				if($batal[$i]==0){$btl='LUNAS';}else{$btl='DIBATALKAN';}
				echo"<tr>
				<td align=left>$i</td>
				<td align=center>$nomor[$i]</td>
				<td align=center>$periode[$i]</td>
				<td align=right>$total[$i]</td>
				<td align=center>$tbayar[$i]</td>
				<td align=center>$jbayar[$i]</td>
				<td align=center>$loket[$i]</td>
				<td align=center>$operator[$i]</td>				
				<td align=center>$btl</td>
				</tr>";
			}
		}else if(isset($_POST['master'])){
			echo"<tr style=\"background-color:#909090;color:#FFFFFF;\">";
			echo"<th width=\"2px\">No.</th><th>Nomor</th><th>NoLama</th><th>Nama</th><th>Alamat</th><th>Kondisi<br>Meter</th>";
			echo"</tr>";
			$i=0;
			while($i<$jml){
				$i++;
				echo"<tr>
				<td align=center>$i</td>
				<td align=center>$nomor[$i]</td>
				<td align=center>$nolama[$i]</td>
				<td align=left>$nama[$i]</td>
				<td align=left>$alamat[$i]</td>
				<td align=center>$kondisi_meter[$i]</td>
				</tr>";
			}
		}
		?>
                    </table>
                </div>
                </td>
           </tr>
     	</table>
							
        	  
		<!--############################################################################################################-->
	  </td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
