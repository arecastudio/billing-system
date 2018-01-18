<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');


if(isset($_GET['kode'])){
	$kd1=$_GET['kode'];
	$qry=mysql_query("delete from responsibility where nik=".$kd1);
	header("location:responsibility.php");	
}

if(isset($_POST['simpan'])){
	$nik=strip_tags($_POST['txnik']);
	$nama=strip_tags($_POST['txnama']);
	$jabatan=strip_tags($_POST['txjabatan']);
	if($nik!=""&&$nama!=""&&$jabatan!=""){
		$sql="INSERT INTO responsibility(nik,nama,jabatan)values('$nik','$nama','$jabatan') ON DUPLICATE KEY UPDATE nama='$nama',jabatan='$jabatan';";
		$qry=mysql_query($sql)or die(mysql_error());		
	}
}

?>
<script type="text/javascript">
	function ubah(cb,kd,nm){
		document.getElementById("txnik").value=cb;
		document.getElementById("txnama").value=kd;
		document.getElementById("txjabatan").value=nm;
	}
	
	function hapus(kd){
		if (confirm("Yakin untuk hapus?\n Kode Data:"+kd)) {
		document.location = "responsibility.php?kode="+kd;
		}
	}
</script>

	<tr>
		<td>
		<!--############################################################################################################-->
        <br/>
		<div align="center"><font face="Arial,sans-serif" size="4px"><b>Pejabat & Staf Penanggung-jawab Laporan</b></font></div>
        <table width="500px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
        	<form name="f1" method="post" action="">
            <tr>
            	<td width="60px">NIK</td>
                <td><input type="text" name="txnik" id="txnik" size="10" maxlength="10" /></td>                
            </tr>
            <tr>
            	<td>Nama</td>
                <td><input type="text" name="txnama" id="txnama" size="35" maxlength="35" /></td>                
            </tr>
            <tr>
            	<td>Jabatan</td>
                <td><input type="text" name="txjabatan" id="txjabatan" size="50" maxlength="100" /></td>                
            </tr>
            <tr>
            	<td colspan="2" align="right"><input type="submit" name="simpan" value="Simpan"/>&nbsp;<input type="reset" value="Batal"/></td>
            </tr>
            </form>
        </table>
        <br/>
        <table width="700px" align="center" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 0 0 15px #999;" background="img/grids.gif">
			<tr>
            	<td width="100%" align="center">
                	<div style="height:300px;overflow:auto">
                    <table width="700px" border="1" cellpadding="2" cellspacing="2" align="center" class="wrapper" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">
                        <tr bgcolor="#000" style="font-size:14px;color:#FFFFFF">
                            <th>NIK</th><th>Nama</th><th>Jabatan</th><th>Kontrol</th>
                        </tr>
                        <?php
                        $i=0;
						$sql="SELECT DISTINCT nik,nama,jabatan FROM responsibility order by nama ASC;";
						$qry=mysql_query($sql)or die(mysql_error());
						while($row=mysql_fetch_row($qry)){
							$i++;
							echo"<tr>";
							echo"<td align=center>".trim($row[0])."&nbsp;</td>";
							echo"<td>".trim($row[1])."&nbsp;</td>";
							echo"<td>".trim($row[2])."&nbsp;</td>";
							echo"<form name=\"f2\" method=\"get\" action=\"\">";
							echo"<td align=center><input type=\"button\" name=\"btedit".$i."\" value=\"Edit\" onClick=\"ubah('".trim($row[0])."','".trim($row[1])."','".trim($row[2])."');\">&nbsp;<input type=\"button\" value=\"Hapus\" name=\"bthapus".$i."\" onClick=\"hapus('".trim($row[0])."');\"><input type=\"hidden\" name=$row[0] value=$row[0]></td>";
							echo"</form>";
							echo"</tr>";
						}
						?>
                    </table>
        			</div>
                </td>
            </tr>
        </table>
		<br />		  
		<!--############################################################################################################-->
	  	</td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
