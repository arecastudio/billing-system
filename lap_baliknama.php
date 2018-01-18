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
		<td><br />
		<!--############################################################################################################-->
		
				
		<table width="920px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
          <form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
              <td colspan="4"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>.::  Laporan Perubahan Nama Pelanggan ::.</b></font></center></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
                <!--########################################################################################-->                
              <td><input type="checkbox" name="chtgl" checked="checked">Tgl. Trans.</td>
              <td>
					<input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]			  </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right">.</td>
           	  <td>&nbsp;</td>
            </tr>
            
			<tr>
				<td><!--input type="radio" name="r1" id="rallupp"  value="all"/-->
				&nbsp;
                <input type="hidden" id="dik" name="dik" />                </td>
				<td colspan="2"></td>
				<td align="right">
					<input type="submit" name="proses" value="Proses" class="kelas_tombol" />
                  	<input type="button" name="batal" value="Batal"  class="kelas_tombol" onclick="" />				</td>
			</tr>
          </form>
		  </table>
		  <br />
		  
		  <table width="1024px" align="center" border="0" cellpadding="2" cellspacing="2" style="box-shadow: 0 0 15px #999;" background="img/grids.gif" class="rounded">
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
							
							<?php
								if (isset($_POST["proses"])&& $_POST["proses"]=="Proses"){
									$tawal=$_POST["txtawal"];
									$takhir=$_POST["txtakhir"];
									$slipit="";
									$stbayar=0;
									//$periode=getPeriodeLalu();
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
										
										$sql3="
										SELECT distinct u.nomor,u.tgl,u.jam,u.lama,u.baru,u.operator,u.loket from ubah_nama as u where (u.tgl between '$tawal' and '$takhir')	order by u.jam								
										";																				
										$qry=mysql_query($sql3)or die("err: ".mysql_error());
										echo "
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#ccc);color:#000;font-weight:bold;\">
											<td height=30>No.</td>
											<td>Nomor Pelanggan</td>
											<td>Tgl</td>
											<td>Jam Perubahan</td>
											<td>Nama Pelanggan Lama</td>
											<td>Nama Perubahan Baru</td>
											<td>Operator</td>
											<td>Loket</td>
											</tr>
										";
										$i=0;
										while($row=mysql_fetch_row($qry)){
											$i++;
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=center>$row[1]</td>
												<td align=center>$row[2]</td>
												<td align=left>$row[3]</td>
												<td align=left>$row[4]</td>
												<td align=center>$row[5]</td>
												<td align=center>$row[6]</td>
												
												</tr>
												";
																								}
																								}
												?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
			<td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
				<?php
               if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
					$tujuan="reports/print_report_lpp_rekap.php";
				}else{
					$tujuan="reports/print_report_lpp.php";
				}
				?>
                <!--a href="<!?php echo $tujuan; ?>" target="_blank" style="font-size:16px;color:#FF0000;font-weight:bold;">-= Cetak Report =-</a-->
				<!--<input type="checkbox" name="chcustprint" value="customprint" />Custom -=>-->
		
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