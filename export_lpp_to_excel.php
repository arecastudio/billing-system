<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");
?>
	<tr>
		<td>	
        <br />	
		
		<table align="center" width="750px" bgcolor="#ffc">
        	<form name="f1" method="post" action="">
        	<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);text-align:justify;">
        	  <td colspan="3"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>Export LPP dan DRD ke format Excel</b></font></center></b></font></center></td>
        	  </tr>
        	<tr>
            	<td width="190">
                	Export DRD Periode</td>
                <td>
                <select name="optperiode" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <?php
						$sql=mysql_query("select distinct periode from rekening1 order by periode desc;");
						while($row=mysql_fetch_row($sql)){				
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>                </td>
                <td><input type="submit" name="drd" value="Export DRD" /></td>
            </tr>
			
			<tr>
            	<td width="190">
                	Export Pel Lunas Briva                </td>
                <td>
                <select name="optperiode2" >
                  <!--option value="" selected="selected">--Pilih--</option-->
                  <?php
						$sql=mysql_query("select distinct periode from rekening1 order by periode desc;");
						while($row=mysql_fetch_row($sql)){				
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>                </td>
                <td><input type="submit" name="briva" value="Export Pel Lunas Briva" /></td>
            </tr>
			
            <tr>
            	<td width="190">
                	Export LPP per Tgl                </td>
                <td><input type="text" size="11" maxlength="10" name="txtgl" value="<?php echo date('Y-m-d',time());?>" class="datepicker"  /></td>
                <td><input type="submit" name="lpp" value="Export LPP per Loket" />&nbsp;&nbsp;<input type="submit" name="lpp2" value="Export LPP per Kasir" /></td>
            </tr>
            </form>
        </table>
        <?php
        if(isset($_POST['drd'])){
			//echo"drd";
			$periode1=$_POST['optperiode'];			
			header("Location: rekap_drd_perbulan.php?periode=$periode1");
			exit;
		}else if(isset($_POST['lpp'])){
			//echo"lpp";
			$tgl1=$_POST['txtgl'];
			header("Location: rekap_lpp_perhari.php?tanggal=$tgl1");
			exit;
		}else if(isset($_POST['lpp2'])){
			//echo"lpp";
			$tgl1=$_POST['txtgl'];
			header("Location: rekap_lpp_perhari2.php?tanggal=$tgl1");
			exit;
		}else if(isset($_POST['briva'])){
			$periode2=$_POST['optperiode2'];
			header("Location: pel_non_tunggak.php?periode=$periode2");
			exit;
		}
		?>

		</td>
	</tr>
	
<?php
putus();
require_once("foot.php");
?>