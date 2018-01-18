<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

$nloket="JPR";
$operator=$_SESSION['nama_user'];
kunci_halaman("login_user",$secret,$operator);

?>
<script type="text/javascript">
function ubah(nm,pw,hk){
	document.getElementById("txnama").value=nm;
	document.getElementById("txpassword").value=pw;
	document.getElementById("opthak").value=hk;
}
</script>

<?php
if(isset($_POST["simpan"])){
	$unama=$_POST["txnama"];
	$upass=$_POST["txpassword"];
	$uhak=$_POST["opthak"];
	if(strlen(trim($unama))>0 && strlen(trim($upass))>0 && strlen(trim($uhak))>0){
		$sql="INSERT INTO login_user(nama,kunci,id) VALUES(AES_ENCRYPT('$unama',$secret),AES_ENCRYPT('$upass',$secret),AES_ENCRYPT('$uhak',$secret)) ON DUPLICATE KEY UPDATE kunci=AES_ENCRYPT('$upass',$secret),id=AES_ENCRYPT('$uhak',$secret);";
		$qry=mysql_query($sql)or die(mysql_error());
	}else{
		echo"<script type=\"text/javascript\">alert('Data belum lengkap!');</script>";
	}
}

if(isset($_GET['d'])){
	if($_GET['d']!=''){
		$hapus_user=$_GET['d'];
		echo"hapus $hapus_user";
		$sql_hapus="DELETE FROM login_user WHERE nama=AES_ENCRYPT('$hapus_user',$secret)";
		$qry=mysql_query($sql_hapus)or die(mysql_error());
		header("location: login_user.php");
	}
}

?>
	<tr>
		<td>
		<!--############################################################################################################-->
        <br />
        
        <table align="center" width="450px" border="0" cellpadding="2" cellspacing="1" class="rounded" style="border-collapse:collapse;background:linear-gradient(#fff,#ffc);font-family:calibri;font-size:14px;">
        	<form name="f1" action="" method="post">
            <tr>
            	<td colspan="2" align="center"><div style="font-family:Arial, Helvetica, sans-serif;font-size:19px;font-weight:bold;color:#fff;;text-shadow:4px -4px 2px #000;background:linear-gradient(#aaa,#606060);">Login User</div></td>
            </tr>
            <tr>
            	<td align="right">Nama&nbsp;</td>
                <td><input type="text" name="txnama" id="txnama" size="15px" /></td>                
            </tr>
            <tr>
            	<td align="right">Password&nbsp;</td>
                <td><input type="text" name="txpassword" id="txpassword" size="15px" /></td>                
            </tr>
            <tr>
            	<td align="right">Hak Akses&nbsp;</td>
                <td>
                <select name="opthak" id="opthak" >
                  <option value="" selected="selected">--Pilih--</option>
                  <?php
						$sql=mysql_query("SELECT id,nama FROM login_hak ORDER BY id;");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
                </select>
                </td>                
            </tr>
            <tr>
            	<td align="right">&nbsp;</td>
                <td align="right">
                	<input type="submit" name="simpan" value="Simpan" class="kelas_tombol" />
                    <input type="reset" name="batal" value="Batal" class="kelas_tombol" />
                    &nbsp;
                </td>
            </tr>
            <tr>
            	<td colspan="2">
                <div style="height:500px;overflow:auto">
                	<table width="100%" border="1" cellpadding="2" cellspacing="1" style="border-collapse:collapse;border-style:dashed;background:#fff;font-family:calibri;font-size:11px;">
                    	<tr height="25px" style="background:linear-gradient(#aaa,#606060);color:#000;">
                        	<th width="30px">No.</th>
                            <th>Nama</th>
                            <th>Password</th>
                            <th width="80px">Hak Akses</th>
                            <th colspan="2">Kendali</th>
                        </tr>
                    <?php
                    	$i=0;$pw="";
						$sql="SELECT AES_DECRYPT(u.nama,$secret),AES_DECRYPT(u.kunci,$secret),h.nama,h.id,AES_DECRYPT(u.id,$secret) FROM login_user AS u INNER JOIN login_hak AS h ON h.id=AES_DECRYPT(u.id,$secret) ORDER BY AES_DECRYPT(u.nama,$secret);";
						$qry=mysql_query($sql)or die(mysql_error());
						while($row=mysql_fetch_row($qry)){
							$i++;
							$pw=trim($row[1]);
							if($row[4]==1)$pw="";
							echo"
							<tr>
								<td align=\"center\">$i</td>
								<td>".strtoupper($row[0])."</td>
								<td>$pw</td>
								<td>$row[2]</td>
								<td  width=\"20px\" align=\"center\" style=\"font-size:11px;color:#800;\">
									<a style=\"cursor:pointer;\" onClick=\"ubah('".trim($row[0])."','".$pw."','".trim($row[3])."');\">Ubah</a>
								</td>
								<!-- /form>
								<form method=\"get\" -->
								<td  width=\"20px\" align=\"center\" style=\"font-size:11px;color:#800;\">
									<a href=\"login_user.php?d=".trim($row[0])."\" style=\"cursor:pointer;\">Hapus</a>
								</td>
								<!--/form-->
							</tr>
							";
						}
					?>
                    </table>
                </div>
                </td>                
            </tr>
            </form>
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
