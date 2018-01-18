<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');
//file koreksi
$loket=$_SESSION['nama_komputer'];
$operator=$_SESSION['nama_user'];
$tanggal=date('Y-m-d');

?>
<script type="text/javascript">
	function upInput(inputID,inputValue){
    	document.getElementById(inputID).value = inputValue;
	}
	
	function setTotal(uair,adm,meter,denda,meterai){
		return parseInt(uair)+parseInt(adm)+parseInt(meter)+parseInt(denda)+parseInt(meterai);
	}
	
	function setMeterai(uair,bts1,bts2,mri1,mri2){
		if(parseInt(uair)>=parseInt(bts2)){
			return mri2;
		}else if(parseInt(uair)>=parseInt(bts1) && parseInt(uair)<parseInt(bts2)){
			return mri1;
		}else{
			return 0;
		}
	}
	
	function setAwal(kwm,ori){
		var hasil=0;
		switch(kwm){
			case 1:hasil=parseInt(ori);break;
			case 2:hasil=0;break;
			case 3:hasil=0;break;
			case 4:hasil=0;break;
		}
		return hasil;
	}
	
	function setAkhir(kwm,ori){
		var hasil=0;
		switch(kwm){
			case 1:hasil=parseInt(ori);break;
			case 2:hasil=0;break;
			case 3:hasil=parseInt(ori);break;
			case 4:hasil=parseInt(ori);break;
		}
		return hasil;
	}
	
	function setMeter(kwm,biaya){
		var hasil=0;
		switch(kwm){
			case '1':hasil=parseInt(biaya);break;
			case '2':hasil=parseInt(biaya);break;
			case '3':hasil=0;break;
			case '4':hasil=0;break;
		}
		return hasil;
	}
	
</script>
  <!--focus kursor -->
<script type="text/javascript" language="javascript">
	 $(function() {
    
	   $("#txnomor").focus();
       
    });
</script>
	<tr>
		<td>
		<!--############################################################################################################-->				
        <br/>
		<table width="1024px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:verdana;font-size:14px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
        	<form name="fcari" method="post" action="">
            <tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);text-align:justify;">
            	<td colspan="4" align="center">Koreksi Rekening</td>
            </tr>                        
            <tr>
            	<td width="120px">Nomor/NoLama</td>
                <td colspan="2">
                	<input type="text" name="txnomor" id="txnomor" size="10" maxlength="13" onkeypress="return isNumb(event);" />                    
                    &nbsp;<input type="submit" name="cari" value="Tampilkan!" class="kelas_tombol" />
                    &nbsp;&nbsp;<input type="button" name="cr" value="Cari" class="kelas_tombol"  onclick="window.open('cari.php','popUpWindow','height=400,width=800,left=10,top=10,scrollbars=yes,menubar=no'); return false;" />
                    &nbsp;&nbsp;&nbsp;<input type="checkbox" name="chkall" id="chkall" value="all" />Centangi Semua
					&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chpaid" id="chpaid" style="background:#ffc;" />
					Rek. Terbayar
                &nbsp;&nbsp;Periode : 
                <select name="optperiode" id="optperiode">
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from rekening1 order by periode DESC;");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>
                &nbsp;s/d&nbsp;
                <select name="optperiode2" id="optperiode2">
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from rekening1 order by periode DESC;");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select></td>
            </tr>
            <tr>
            	<td colspan="4">
            		<table>
            			<tbody>
            				<tr style="color:#555;background:linear-gradient(#ccc,#fff,#ccc);font-size:13px;height:30px;">
		                    	<td><!--input type="button" value="Samakan" /-->
		                    		<input type="checkbox" id="refsama" name="refsama" value="" /> Samakan
		                    	</td>
		                        <td>
		                        	<select id="refkwm" name="refkwm" style="text-align:center;color:#f00;font-weight:bold;" onChange="">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
									</select>
		                        </td>
		                        <td><input style="text-align:right;" type="text" name="refawal" id="refawal" size="5pe" placeholder="Awal" /></td>
		                        <td><input style="text-align:right;" type="text" name="refakhir" id="refakhir" size="5pe" placeholder="Akhir" /></td>
		                        
		                        
		                        <td><input style="text-align:right;" type="text" name="refadm" id="refadm" size="10pe" placeholder="Adm" /></td>
		                        <td><input style="text-align:right;" type="text" name="refmeter" id="refmeter" size="10pe" placeholder="Meter" /></td>
		                        <td><input style="text-align:right;" type="text" name="refdenda" id="refdenda" size="10pe" placeholder="Denda" /></td>
		                        <td>Ket.: </td>
		                    </tr>
            			</tbody>
            		</table>
            	</td>
            </tr>
            </form>
            <?php
			$dapat=false;
            if(isset($_POST["cari"])){
				//$dapat=false;
				$plalu=getPeriodeLalu();
				$nmr=$_POST['txnomor'];	
				$prd1=$_POST['optperiode'];
				$prd2=$_POST['optperiode2'];			
				/*$sql="
				SELECT m.nomor,m.nolama,m.nama,m.alamat,m.gol,(SELECT DISTINCT f.keterangan FROM tarif AS f WHERE f.gol=m.gol LIMIT 1)as ngol,m.cabang,c.nama as cnama,m.kode_wilayah,w.nama_wilayah,m.dkd,d.jalan,m.kondisi_meter
				,m.ukuran AS uk_meter,m.loket
				,r.standlalu,r.standkini,(r.standkini-r.standlalu)AS pake,r.uangair,r.adm,r.meter,r.denda,r.meterai
				,(SELECT tarip1 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1)AS t1
				,(SELECT tarip2 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1)AS t2
				,(SELECT tarip3 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1)AS t3
				,(SELECT tarip4 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1)AS t4	
				,(r.uangair + r.adm + r.meter + r.meterai + r.denda)
				FROM master AS m
				INNER JOIN cabang AS c ON c.cabang=m.cabang
				INNER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah AND w.kode_cabang=m.cabang
				INNER JOIN dkd AS d ON d.dkd=m.dkd
				INNER JOIN rekening1 AS r ON r.nomor=m.nomor
				WHERE (m.nomor='$nmr' OR m.nolama='$nmr') AND r.periode=$prd
				LIMIT 1
				;";*/
				echo"<script type=\"text/javascript\">document.getElementById(\"optperiode\").value=\"$prd1\";</script>";
				echo"<script type=\"text/javascript\">document.getElementById(\"optperiode2\").value=\"$prd2\";</script>";

				$sql="
				SELECT m.nomor,m.nolama,m.nama,m.alamat,m.gol,(SELECT DISTINCT f.keterangan FROM tarif AS f WHERE f.gol=m.gol LIMIT 1)as ngol,m.cabang,c.nama as cnama,m.kode_wilayah,w.nama_wilayah,m.dkd,d.jalan,m.kondisi_meter,IF(m.putus=3,'PUTUS [3]','SAMBUNG [0]')
				FROM master AS m
				LEFT OUTER JOIN cabang AS c ON c.cabang=m.cabang
				LEFT OUTER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah AND w.kode_cabang=m.cabang
				LEFT OUTER JOIN dkd AS d ON d.dkd=m.dkd
				WHERE (nomor='$nmr' OR nolama='$nmr') AND putus='0' 
				LIMIT 1
				;";
				
				$qry=mysql_query($sql)or die(mysql_error());
				if($row=mysql_fetch_row($qry)){
					$dapat=true;
					$nomor=$row[0];
					$nolama=$row[1];
					$nama=$row[2];
					$alamat=$row[3];
					$gol=$row[4]." - ".$row[5];
					$cabang=$row[6]." - ".$row[7];
					$wilayah=$row[8]." - ".$row[9];
					$dkd=$row[10]." - ".$row[11];
					$kondisiwm=$row[12];
					$putus=$row[13];
					
					/*$rlalu=$row[15];
					$rkini=$row[16];
					$rpakai=$row[17];
					$ruair=$row[18];
					$radm=$row[19];
					$rmeter=$row[20];
					$rdenda=$row[21];
					$rmeterai=$row[22];
					$rtotal=$row[27];*/
					
					echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").value=\"$nmr\";</script>";
					
				}else{
					$dapat=false;					
					echo"<script language=\"javascript\">alert(\"Data tidak ditemukan atau Kondisi Meter bukan Aktif!\");</script>";
					//echo"4444444444444444";
				}
			}
			?>
            <tr style="font-weight:bold;font-size:13px;">
				<td>Pelanggan</td>
				<td colspan="2"><?php if(isset($_POST['cari']) && $dapat==true) echo"$nomor / $nolama - $nama"; ?></td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td colspan="2"><?php if(isset($_POST['cari']) && $dapat==true) echo"$alamat"; ?></td>
			</tr>
			<tr>
				<td>Golongan</td>
				<td colspan="2"><?php if(isset($_POST['cari']) && $dapat==true) echo"$gol"; ?></td>
			</tr>
			<tr>
				<td>Cabang</td>
				<td colspan="2"><?php if(isset($_POST['cari']) && $dapat==true) echo"$cabang"; ?></td>
			</tr>
			<tr>
				<td>Wilayah</td>
				<td colspan="2"><?php if(isset($_POST['cari']) && $dapat==true) echo"$wilayah"; ?></td>
			</tr>
            <tr>
				<td>DKD</td>
				<td colspan="3"><?php if(isset($_POST['cari']) && $dapat==true) echo"$dkd"; ?></td>
			</tr>
            <tr>
				<td>Kondisi WM</td>
				<td><?php if(isset($_POST['cari']) && $dapat==true) echo"$kondisiwm - ".kondisi_wm($kondisiwm); ?></td>                
			</tr>
            <tr>
				<td>Stat.</td>
				<td><?php if(isset($_POST['cari']) && $dapat==true) echo $putus; ?></td>                
			</tr>
            <form name="fr2" id="fr2" action="" method="post">
            <tr>
            	<td colspan="4">
                <div style="height:550px;overflow:auto">
                <table border="0" style="border-collapse:collapse;padding:0;border-spacing:0;font-family:arial;font-size:11px;width:100%;">
                	
                    <!--tr><td colspan="13">&nbsp;</td></tr-->
                	<tr style="color:#fff;background:linear-gradient(#666,#004);font-size:13px;">
                    	<th>No.</th>
                        <th>Save</th>
                        <th>KWM</th>
                        <th>Periode</th>
                        <th>Stand<br/>Awal</th>
                        <th>Stand<br/>Akhir</th>
                        <th>Pakai</th>
                        <th>UangAir</th>
                        <th>Adm.</th>
                        <th>Meter</th>
                        <th>Denda</th>
                        <th>Meterai</th>
                        <th>Total</th>
                    </tr>
                    <?php					
                    if($dapat==true){
						$i=0;
						$cek="";
						if(isset($_POST["chkall"])){
							$cek="checked";
							echo"<script type=\"text/javascript\">document.getElementById(\"chkall\").checked=\"checked\";</script>";
						}
						$slipit="";
						if(isset($_POST["chpaid"])&&($key=$_POST['chpaid'])!=''){
							//$slipit=cek_slip($slipit)."t.loket='$key'";
							$slipit=" AND r.status_bayar=1 ";
							//$judul.="<br>Loket : $key";
							echo"<script type=\"text/javascript\">document.getElementById(\"chpaid\").checked=\"checked\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"chpaid\").value=\"$key\";</script>";
						}else{
							$slipit=" AND r.status_bayar=0 ";
						}
						
						//,IFNULL((SELECT biaya FROM meter WHERE kode=m.ukuran LIMIT 1),0)AS tmeter
						//,IFNULL((SELECT meter FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1),IFNULL((SELECT meter FROM tarif WHERE periode>=r.periode AND gol=m.gol ORDER BY periode ASC LIMIT 1),0))AS tmeter
						$esqiel="
						SELECT DISTINCT r.periode,r.standlalu,r.standkini,r.pakai,r.uangair,r.adm,r.meter,r.denda,r.meterai,(r.uangair + r.adm + r.meter + r.meterai + r.denda),m.ukuran,m.kondisi_meter
						,IFNULL((SELECT tarip1 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1),IFNULL((SELECT tarip1 FROM tarif WHERE periode>=r.periode AND gol=m.gol ORDER BY periode ASC LIMIT 1),0))AS t1
						,IFNULL((SELECT tarip2 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1),IFNULL((SELECT tarip2 FROM tarif WHERE periode>=r.periode AND gol=m.gol ORDER BY periode ASC LIMIT 1),0))AS t2
						,IFNULL((SELECT tarip3 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1),IFNULL((SELECT tarip3 FROM tarif WHERE periode>=r.periode AND gol=m.gol ORDER BY periode ASC LIMIT 1),0))AS t3
						,IFNULL((SELECT tarip4 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1),IFNULL((SELECT tarip4 FROM tarif WHERE periode>=r.periode AND gol=m.gol ORDER BY periode ASC LIMIT 1),0))AS t4	
						,IFNULL((SELECT n.nadm FROM adm AS n WHERE n.periode<=r.periode ORDER BY n.periode DESC LIMIT 1),IFNULL((SELECT n.nadm FROM adm AS n WHERE n.periode>=r.periode ORDER BY n.periode ASC LIMIT 1),0))AS adm1
						,IFNULL((SELECT biaya FROM meter WHERE kode=m.ukuran LIMIT 1),0)AS tmeter
						,IFNULL((SELECT denda1 FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1),IFNULL((SELECT denda1 FROM tarif WHERE periode>=r.periode AND gol=m.gol ORDER BY periode ASC LIMIT 1),0))AS tdenda
						,IFNULL((SELECT b1.batas1 FROM adm AS b1 WHERE b1.periode<=r.periode ORDER BY b1.periode DESC LIMIT 1),IFNULL((SELECT b1.batas1 FROM adm AS b1 WHERE b1.periode>=r.periode ORDER BY b1.periode ASC LIMIT 1),0))AS bts1
						,IFNULL((SELECT b2.batas2 FROM adm AS b2 WHERE b2.periode<=r.periode ORDER BY b2.periode DESC LIMIT 1),IFNULL((SELECT b2.batas2 FROM adm AS b2 WHERE b2.periode>=r.periode ORDER BY b2.periode ASC LIMIT 1),0))AS bts2
						,IFNULL((SELECT m1.met1 FROM adm AS m1 WHERE m1.periode<=r.periode ORDER BY m1.periode DESC LIMIT 1),IFNULL((SELECT m1.met1 FROM adm AS m1 WHERE m1.periode>=r.periode ORDER BY m1.periode ASC LIMIT 1),0))AS mtr1
						,IFNULL((SELECT m2.met2 FROM adm AS m2 WHERE m2.periode<=r.periode ORDER BY m2.periode DESC LIMIT 1),IFNULL((SELECT m2.met2 FROM adm AS m2 WHERE m2.periode>=r.periode ORDER BY m2.periode ASC LIMIT 1),0))AS mtr2
						,IFNULL((SELECT minimum FROM tarif WHERE periode<=r.periode AND gol=m.gol ORDER BY periode DESC LIMIT 1),IFNULL((SELECT minimum FROM tarif WHERE periode>=r.periode AND gol=m.gol ORDER BY periode ASC LIMIT 1),0))AS mini
						FROM rekening1 AS r
						LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
						WHERE r.nomor='$nomor' $slipit AND (r.periode BETWEEN '$prd1' AND '$prd2')
						ORDER BY r.periode ASC
						;";
						//ttl"."$i.value=uair"."$i.value+adm"."$i.value+mtr"."$i.value+dnd"."$i.value+mri"."$i.value;
						$query=mysql_query($esqiel)or die(mysql_error());
						while($rows=mysql_fetch_row($query)){
							$i++;
							if ($i%2==0){$wrn="#ffe";}else{$wrn="#eef";}

							if(isset($_POST["refsama"])){
								#$cek="checked";
								$kwm_ref=$_POST['refkwm'];
								$awal_ref=$_POST['refawal'];
								$akhir_ref=$_POST['refakhir'];
								$adm_ref=$_POST['refadm'];
								$meter_ref=$_POST['refmeter'];
								$denda_ref=$_POST['refdenda'];

								echo"<script type=\"text/javascript\">document.getElementById(\"refsama\").checked=\"checked\";</script>";
								echo"<script type=\"text/javascript\">document.getElementById(\"refkwm\").value=\"$kwm_ref\";</script>";
								echo"<script type=\"text/javascript\">document.getElementById(\"refawal\").value=\"$awal_ref\";</script>";
								echo"<script type=\"text/javascript\">document.getElementById(\"refakhir\").value=\"$akhir_ref\";</script>";
								
								echo"<script type=\"text/javascript\">document.getElementById(\"refadm\").value=\"$adm_ref\";</script>";
								echo"<script type=\"text/javascript\">document.getElementById(\"refmeter\").value=\"$meter_ref\";</script>";
								echo"<script type=\"text/javascript\">document.getElementById(\"refdenda\").value=\"$denda_ref\";</script>";

								echo"
								<tr style=\"color:#000;background:".$wrn.";font-size:13px;\">
									<td style=\"text-align:center;\">$i</td>
									<td style=\"text-align:center;\"><input type=\"checkbox\" id=\"chk$i\" name=\"chk$i\" $cek value=\"$rows[0]\" /></td>
									<td align=\"center\">
										<select id=\"okwm$i\" name=\"okwm$i\" style=\"text-align:center;color:#f00;font-weight:bold;\" onChange=\"lst"."$i.value=setAwal(this.value,lst"."$i.value); now"."$i.value=setAkhir(this.value,now"."$i.value); mtr"."$i.value=setMeter(this.value,$rows[17]);\">
											<option value=\"$kwm_ref\">$kwm_ref</option>
											<!--option value=\"1\">1</option>
											<option value=\"2\">2</option>
											<option value=\"3\">3</option>
											<option value=\"4\">4</option-->
										</select>
									</td>
									<td style=\"text-align:center;color:#00f;font-weight:bold;\">$rows[0]</td>
									<td width=\"10\"><input type=\"text\" name=\"lst$i\" id=\"lst$i\" value=\"$awal_ref\" size=\"5pe\" maxlength=\"9\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value); return isNumb(event);pk"."$i.value=now"."$i.value - lst"."$i.value; return uair"."$i.value=setHargaAir(pk"."$i.value,$rows[12],$rows[13],$rows[14],$rows[14],$rows[23],okwm"."$i.value);\" onMouseMove=\"pk"."$i.value=now"."$i.value - lst"."$i.value; ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value); mri"."$i.value=setMeterai(uair"."$i.value,$rows[19],$rows[20],$rows[21],$rows[22]) ; return uair"."$i.value=setHargaAir(pk"."$i.value,$rows[12],$rows[13],$rows[14],$rows[14],$rows[23],okwm"."$i.value);\" onKeyDown=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
									<td width=\"10\"><input type=\"text\" name=\"now$i\" id=\"now$i\" value=\"$akhir_ref\" size=\"5pe\" maxlength=\"9\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value); return isNumb(event);pk"."$i.value=now"."$i.value - lst"."$i.value; return uair"."$i.value=setHargaAir(pk"."$i.value,$rows[12],$rows[13],$rows[14],$rows[14],$rows[23],okwm"."$i.value);\" onMouseMove=\"pk"."$i.value=now"."$i.value - lst"."$i.value; ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value); mri"."$i.value=setMeterai(uair"."$i.value,$rows[19],$rows[20],$rows[21],$rows[22]) ; return uair"."$i.value=setHargaAir(pk"."$i.value,$rows[12],$rows[13],$rows[14],$rows[14],$rows[23],okwm"."$i.value);\" onKeyDown=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
									<td width=\"10\"><input type=\"text\" name=\"pk$i\" id=\"pk$i\" readonly value=\"$rows[3]\" size=\"5pe\" maxlength=\"9\"  style=\"background:#ddd;text-align:right;font-weight:bold;color:#00f;\" onkeypress=\"return isNumb(event);\" /></td>
									<td width=\"10\"><input type=\"text\" name=\"uair$i\" id=\"uair$i\" readonly value=\"$rows[4]\" size=\"12pe\" style=\"background:#ddd;text-align:right;font-weight:bold;color:#00f;\" onkeypress=\"return isNumb(event);\" /></td>
									<td width=\"10\"><input type=\"text\" name=\"adm$i\" id=\"adm$i\" value=\"$adm_ref\" size=\"10pe\" maxlength=\"10\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);return isNumb(event);\" onKeyUp=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
									<td width=\"10\"><input type=\"text\" name=\"mtr$i\" id=\"mtr$i\" value=\"$meter_ref\" size=\"5pe\" maxlength=\"9\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);return isNumb(event);\" onKeyUp=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
									<td width=\"10\"><input type=\"text\" name=\"dnd$i\" id=\"dnd$i\" value=\"$denda_ref\" size=\"5pe\" maxlength=\"9\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);return isNumb(event);\" onKeyUp=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
									<td width=\"10\"><input type=\"text\" name=\"mri$i\" id=\"mri$i\" readonly value=\"$rows[8]\" size=\"10pe\" maxlength=\"10\"  style=\"background:#ddd;text-align:right;color:#00f;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);return isNumb(event);\" onKeyUp=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
									<td width=\"10\"><input type=\"text\" name=\"ttl$i\" id=\"ttl$i\" readonly value=\"$rows[9]\" size=\"15pe\" style=\"background:#ddd;text-align:right;font-weight:bold;color:#00f;\" />
										<input type=\"hidden\" id=\"h1t$i\" name=\"h1t$i\" value=\"$rows[12]\" />
										<input type=\"hidden\" id=\"h2t$i\" name=\"h2t$i\" value=\"$rows[13]\" />
										<input type=\"hidden\" id=\"h3t$i\" name=\"h3t$i\" value=\"$rows[14]\" />
										<input type=\"hidden\" id=\"h4t$i\" name=\"h4t$i\" value=\"$rows[15]\" />
										<input type=\"hidden\" id=\"hadm$i\" name=\"hadm$i\" value=\"$rows[16]\" />
										<input type=\"hidden\" id=\"hmtr$i\" name=\"hmtr$i\" value=\"$rows[17]\" />
										<input type=\"hidden\" id=\"hdnd$i\" name=\"hdnd$i\" value=\"$rows[18]\" />
										<input type=\"hidden\" id=\"h1bts$i\" name=\"h1bts$i\" value=\"$rows[19]\" />
										<input type=\"hidden\" id=\"h2bts$i\" name=\"h2bts$i\" value=\"$rows[20]\" />
										<input type=\"hidden\" id=\"h1mtri$i\" name=\"h1mtri$i\" value=\"$rows[21]\" />
										<input type=\"hidden\" id=\"h2mtri$i\" name=\"h2mtri$i\" value=\"$rows[22]\" />
										<input type=\"hidden\" id=\"hmini$i\" name=\"hmini$i\" value=\"$rows[23]\" />
									</td>
								</tr>
								";

							}else{
							echo"
							<tr style=\"color:#000;background:".$wrn.";font-size:13px;\">
								<td style=\"text-align:center;\">$i</td>
								<td style=\"text-align:center;\"><input type=\"checkbox\" id=\"chk$i\" name=\"chk$i\" $cek value=\"$rows[0]\" /></td>
								<td align=\"center\">
									<select id=\"okwm$i\" name=\"okwm$i\" style=\"text-align:center;color:#f00;font-weight:bold;\" onChange=\"lst"."$i.value=setAwal(this.value,lst"."$i.value); now"."$i.value=setAkhir(this.value,now"."$i.value); mtr"."$i.value=setMeter(this.value,$rows[17]);\">
										<option value=\"1\">1</option>
										<option value=\"2\">2</option>
										<option value=\"3\">3</option>
										<option value=\"4\">4</option>
									</select>
								</td>
								<td style=\"text-align:center;color:#00f;font-weight:bold;\">$rows[0]</td>
								<td width=\"10\"><input type=\"text\" name=\"lst$i\" id=\"lst$i\" value=\"$rows[1]\" size=\"5pe\" maxlength=\"9\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value); return isNumb(event);pk"."$i.value=now"."$i.value - lst"."$i.value; return uair"."$i.value=setHargaAir(pk"."$i.value,$rows[12],$rows[13],$rows[14],$rows[14],$rows[23],okwm"."$i.value);\" onKeyUp=\"pk"."$i.value=now"."$i.value - lst"."$i.value; ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value); mri"."$i.value=setMeterai(uair"."$i.value,$rows[19],$rows[20],$rows[21],$rows[22]) ; return uair"."$i.value=setHargaAir(pk"."$i.value,$rows[12],$rows[13],$rows[14],$rows[14],$rows[23],okwm"."$i.value);\" onKeyDown=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
								<td width=\"10\"><input type=\"text\" name=\"now$i\" id=\"now$i\" value=\"$rows[2]\" size=\"5pe\" maxlength=\"9\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value); return isNumb(event);pk"."$i.value=now"."$i.value - lst"."$i.value; return uair"."$i.value=setHargaAir(pk"."$i.value,$rows[12],$rows[13],$rows[14],$rows[14],$rows[23],okwm"."$i.value);\" onKeyUp=\"pk"."$i.value=now"."$i.value - lst"."$i.value; ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value); mri"."$i.value=setMeterai(uair"."$i.value,$rows[19],$rows[20],$rows[21],$rows[22]) ; return uair"."$i.value=setHargaAir(pk"."$i.value,$rows[12],$rows[13],$rows[14],$rows[14],$rows[23],okwm"."$i.value);\" onKeyDown=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
								<td width=\"10\"><input type=\"text\" name=\"pk$i\" id=\"pk$i\" readonly value=\"$rows[3]\" size=\"5pe\" maxlength=\"9\"  style=\"background:#ddd;text-align:right;font-weight:bold;color:#00f;\" onkeypress=\"return isNumb(event);\" /></td>
								<td width=\"10\"><input type=\"text\" name=\"uair$i\" id=\"uair$i\" readonly value=\"$rows[4]\" size=\"12pe\" style=\"background:#ddd;text-align:right;font-weight:bold;color:#00f;\" onkeypress=\"return isNumb(event);\" /></td>
								<td width=\"10\"><input type=\"text\" name=\"adm$i\" id=\"adm$i\" value=\"$rows[5]\" size=\"10pe\" maxlength=\"10\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);return isNumb(event);\" onKeyUp=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
								<td width=\"10\"><input type=\"text\" name=\"mtr$i\" id=\"mtr$i\" value=\"$rows[6]\" size=\"5pe\" maxlength=\"9\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);return isNumb(event);\" onKeyUp=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
								<td width=\"10\"><input type=\"text\" name=\"dnd$i\" id=\"dnd$i\" value=\"$rows[7]\" size=\"5pe\" maxlength=\"9\"  style=\"text-align:right;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);return isNumb(event);\" onKeyUp=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
								<td width=\"10\"><input type=\"text\" name=\"mri$i\" id=\"mri$i\" readonly value=\"$rows[8]\" size=\"10pe\" maxlength=\"10\"  style=\"background:#ddd;text-align:right;color:#00f;\" onkeypress=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);return isNumb(event);\" onKeyUp=\"ttl"."$i.value=setTotal(uair"."$i.value,adm"."$i.value,mtr"."$i.value,dnd"."$i.value,mri"."$i.value);\" /></td>
								<td width=\"10\"><input type=\"text\" name=\"ttl$i\" id=\"ttl$i\" readonly value=\"$rows[9]\" size=\"15pe\" style=\"background:#ddd;text-align:right;font-weight:bold;color:#00f;\" />
									<input type=\"hidden\" id=\"h1t$i\" name=\"h1t$i\" value=\"$rows[12]\" />
									<input type=\"hidden\" id=\"h2t$i\" name=\"h2t$i\" value=\"$rows[13]\" />
									<input type=\"hidden\" id=\"h3t$i\" name=\"h3t$i\" value=\"$rows[14]\" />
									<input type=\"hidden\" id=\"h4t$i\" name=\"h4t$i\" value=\"$rows[15]\" />
									<input type=\"hidden\" id=\"hadm$i\" name=\"hadm$i\" value=\"$rows[16]\" />
									<input type=\"hidden\" id=\"hmtr$i\" name=\"hmtr$i\" value=\"$rows[17]\" />
									<input type=\"hidden\" id=\"hdnd$i\" name=\"hdnd$i\" value=\"$rows[18]\" />
									<input type=\"hidden\" id=\"h1bts$i\" name=\"h1bts$i\" value=\"$rows[19]\" />
									<input type=\"hidden\" id=\"h2bts$i\" name=\"h2bts$i\" value=\"$rows[20]\" />
									<input type=\"hidden\" id=\"h1mtri$i\" name=\"h1mtri$i\" value=\"$rows[21]\" />
									<input type=\"hidden\" id=\"h2mtri$i\" name=\"h2mtri$i\" value=\"$rows[22]\" />
									<input type=\"hidden\" id=\"hmini$i\" name=\"hmini$i\" value=\"$rows[23]\" />
								</td>
							</tr>
							";
							}
						}
						echo"<input type=\"hidden\" id=\"hjumdata\" name=\"hjumdata\" value=\"$i\" />";
						echo"<input type=\"hidden\" id=\"hnomor\" name=\"hnomor\" value=\"$nomor\" />";
					}
					?>
                </table>
                </div>
            	</td>
            </tr>
            <tr style="background:linear-gradient(#ccc,#222);height:35px;">
                <td colspan="12">
                &nbsp;<input type="submit" name="simpan" value="Simpan" class="kelas_tombol" />
                &nbsp;<input type="reset" name="batal" value="Reset" class="kelas_tombol" />
                </td>
            </tr>
            </form>
        </table>
		<br />		  
		<!--############################################################################################################-->
	  	</td>
	</tr>
<?php
if(isset($_POST["simpan"])){
	$nomor=$_POST["hnomor"];
	$jml=$_POST["hjumdata"];
	$i=0;
	for($i=0;$i<=$jml;$i++){
		if(isset($_POST["chk".$i])){
			$prd=$_POST["chk".$i];
			//auto total pengganti $_POST["ttl".$i]
			$auto_total= strval($_POST["uair".$i])+strval($_POST["adm".$i])+strval($_POST["mtr".$i])+strval($_POST["dnd".$i])+strval($_POST["mri".$i]);
			//echo "<div style=\"color:#ff0;font-size:15px;\">".$nomor."-".$prd."-".$_POST["lst".$i]."-".$_POST["now".$i]."-".$_POST["pk".$i]."-".$_POST["uair".$i]."-".$_POST["adm".$i]."-".$_POST["mtr".$i]."-".$_POST["dnd".$i]."-".$_POST["mri".$i]."-".$_POST["ttl".$i]."<br></div>";
			
			$q_simpan="
			INSERT INTO his_koreksi_rek(nomor,periode,standlalu,standkini,pakai,uangair,adm,meter,denda,meterai,total,tkorek,loket,operator,standlalu_awal,standkini_awal,pakai_awal,uangair_awal,adm_awal,meter_awal,denda_awal,meterai_awal,total_awal)
			VALUES('$nomor',$prd,".$_POST["lst".$i].",".$_POST["now".$i].",".$_POST["pk".$i].",".$_POST["uair".$i].",".$_POST["adm".$i].",".$_POST["mtr".$i].",".$_POST["dnd".$i].",".$_POST["mri".$i].",".$auto_total.",'".$tanggal."','".$loket."','".$operator."'
			,(SELECT standlalu FROM rekening1 AS r2 WHERE r2.nomor='$nomor' AND r2.periode=$prd)
			,(SELECT standkini FROM rekening1 AS r2 WHERE r2.nomor='$nomor' AND r2.periode=$prd)
			,(SELECT pakai FROM rekening1 AS r2 WHERE r2.nomor='$nomor' AND r2.periode=$prd)
			,(SELECT uangair FROM rekening1 AS r2 WHERE r2.nomor='$nomor' AND r2.periode=$prd)
			,(SELECT adm FROM rekening1 AS r2 WHERE r2.nomor='$nomor' AND r2.periode=$prd)
			,(SELECT meter FROM rekening1 AS r2 WHERE r2.nomor='$nomor' AND r2.periode=$prd)
			,(SELECT denda FROM rekening1 AS r2 WHERE r2.nomor='$nomor' AND r2.periode=$prd)
			,(SELECT meterai FROM rekening1 AS r2 WHERE r2.nomor='$nomor' AND r2.periode=$prd)
			,(SELECT total FROM rekening1 AS r2 WHERE r2.nomor='$nomor' AND r2.periode=$prd)
			)
			ON DUPLICATE KEY UPDATE
			standlalu=".$_POST["lst".$i].",
			standkini=".$_POST["now".$i].",
			pakai=".$_POST["pk".$i].",
			uangair=".$_POST["uair".$i].",
			adm=".$_POST["adm".$i].",
			meter=".$_POST["mtr".$i].",
			denda=".$_POST["dnd".$i].",
			meterai=".$_POST["mri".$i].",
			total=".$auto_total.",
			tkorek='".$tanggal."',
			loket='".$loket."',
			operator='".$operator."'
			;";			
			mysql_query($q_simpan) or die(mysql_error());
			
			$q_ubah="
			UPDATE rekening1
			SET
				standlalu=".$_POST["lst".$i].",
				standkini=".$_POST["now".$i].",
				pakai=".$_POST["pk".$i].",
				uangair=".$_POST["uair".$i].",
				adm=".$_POST["adm".$i].",
				meter=".$_POST["mtr".$i].",
				denda=".$_POST["dnd".$i].",
				meterai=".$_POST["mri".$i].",
				total=".$auto_total."
			WHERE nomor='$nomor' AND periode=$prd AND status_bayar<>9
			";
			mysql_query($q_ubah)or die(mysql_error());
		}
	}
	echo"<script language=\"javascript\">alert(\"Data Tersimpan!\");</script>";
}
?>

<!--############################################################################################################-->

<?php
//mysql_close();
putus();
require_once("foot.php");
?>
