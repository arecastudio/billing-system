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
		
		<center><font face="Arial,sans-serif" size="4px"><b>Pencetakan Rekening Kolektif [Faktur]</b></font></center><hr width="900px"/>
		<table width="800px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
			<form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr>
            	<td colspan="2"><b>Data Pelanggan</b></td>
                <td colspan="2">Keterangan</td>              
            </tr>
            <tr>
           	  <td width="130px">Tgl. Pembayaran</td>
               <td><input type="text" size="11" maxlength="10" name="txtbyr" class="datepicker" value="<?php echo date('Y-m-d');?>"  /></td>
              <td rowspan="3" valign="top"><textarea name="taket" wrap="soft" cols="50" rows="3" readonly></textarea></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
            	<td>Kode Kolektif</td>
                <td><input type="text" name="txkode" size="3" maxlength="3" onkeypress="return isNumb(event);" /><input type="button" onKeyPress="" /></td>
                <td>&nbsp;</td>
                
            </tr>
            <tr>
            	<td>Jenis Cetakan</td>
                <td><input type="radio" name="chjc" value="jrek"/>Rek.&nbsp;<input type="radio" name="chjc" value="jjft" checked/>Daftar</td>
                <td>&nbsp;</td>
                
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td><input type="radio" name="chjc" value="jkwit"/>Kwitansi</td>
                <td>&nbsp;</td>
                
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="proses" value="Proses" />&nbsp;<input type="reset" name="reset" value="Batal" /></td>
                
            </tr>
            </form>
      	</table>
        <br />
		<table width="900px" align="center" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 0 0 15px #999;" background="img/grids.gif">
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">                        	
                            <tr align="center" style="background-color:#505050;color:#FFFFFF;font-weight:bold;">
								<td>No.</td>
								<td>Nomor</td>
								<td>NoLama</td>
                                <td>Nama</td>
								<td>Ctk</td>                                
								<td>Periode</td>
								<td>Pakai<br/>M<sup>3</sup></td>
                                <td>Harga<br/>Air</td>
                                <td>Adm.</td>
                                <td>Meter</td>
                                <td>Meterai</td>
                                <td>Denda</td>
                                <td>Jumlah</td>
							</tr>
                            <?php
							if(isset($_POST['proses'])&& $_POST['proses']=='Proses'){
								$sql="";$i=0;
								$kode=$_POST['txkode'];
								$tbyr=$_POST['txtbyr'];
								if($kode!=""&&$tbyr!=""){
									//echo"pro";
									$sql="SELECT r.nomor,(SELECT m.nolama FROM master as m WHERE m.nomor=r.nomor LIMIT 0,1)AS nola,(SELECT m.nama FROM master AS m WHERE m.nomor=r.nomor LIMIT 0,1) AS nm,r.periode,FORMAT(r.pakai,0),FORMAT(r.uangair,0),FORMAT(r.adm,0),FORMAT(r.meter,0),FORMAT(r.meterai,0),FORMAT(r.denda,0),FORMAT(r.uangair + r.adm + r.meter + r.meterai + r.denda,0) FROM rekening1 as r,pel_kolektif_d as pkd WHERE pkd.nomor=r.nomor AND r.status_bayar=0 AND pkd.kode_kolektif='$kode' ORDER BY nola";
									$qry=mysql_query($sql)or die(mysql_error());
									while($row=mysql_fetch_row($qry)){
										$i++;
										echo"
										<tr>
											<td align=\"center\">$i</td>
											<td align=\"center\">$row[0]</td>
											<td align=\"center\">$row[1]</td>
											<td>$row[2]</td>
											<td align=\"center\"><input type=\"checkbox\" name=\"ck$i\" value=\"\" checked /></td>
											<td align=\"center\">$row[3]</td>
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
								}
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
        <br />
		</td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>