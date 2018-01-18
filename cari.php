<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
?>

<html>
<head>
<title>Cari@Loket</title>
</head>
<body>
<table style="font-family:calibri;" width="650px">
	<form id="f1" name="f1" action="" method="post">
    <tr style="background:#eee;font-size:18px;font-weight:bold;">
    	<td colspan="2">Cari Data Berdasarkan</td>
    </tr>
    <tr>
    	<td width="150px"><input type="radio" id="r1" name="acuan" value="nomor" checked />Nomor</td>
        <td><input type="text" id="tx1" name="txnomor" size="7pe" /></td>
    </tr>
    <tr>
    	<td><input type="radio" id="r2" name="acuan" value="nolama" />Nomor Lama</td>
        <td><input type="text" id="tx2" name="txnolama" size="15pe" /></td>
    </tr>
    <tr>
    	<td><input type="radio" id="r3" name="acuan" value="nama" />Nama</td>
        <td><input type="text" id="tx3" name="txnama" size="35pe" /></td>
    </tr>
    <tr>
    	<td><input type="radio" id="r4" name="acuan" value="alamat" />Alamat</td>
        <td><input type="text" id="tx4" name="txalamat" size="45pe" /></td>
    </tr>
    <tr>
    	<td colspan="2">
        <input type="submit" name="cari" value="Cari" />&nbsp;
        <input type="reset" name="batal" value="Batal" />
        </td>
    </tr>
    </form>
    <tr>
    	<td colspan="2">
        	<table width="100%" border="1" style="border-collapse:collapse;">
            	<tr style="background:#eee;">
                	<th width="3px">No.</th>
                    <th>Nomor</th>
                    <th>NoLama</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                </tr>
                <form name="f2" id="f2" method="post" action="loket.php">
				<?php
                if(isset($_POST["cari"])){
					$nomor=trim($_POST["txnomor"]);
					$nolama=trim($_POST["txnolama"]);
					$nama=trim($_POST["txnama"]);
					$alamat=trim($_POST["txalamat"]);
					
					echo"<script type=\"text/javascript\">opener.location=window.opener.document.URL;</script>";
					
					switch($_POST["acuan"]){
						case"nomor":
							$slip="nomor='".trim($_POST["txnomor"])."'";
							echo"<script type=\"text/javascript\">document.getElementById(\"tx1\").value=\"$nomor\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"r1\").checked=\"checked\";</script>";
							break;
						case"nolama":
							$slip="nolama='".trim($_POST["txnolama"])."'";
							echo"<script type=\"text/javascript\">document.getElementById(\"tx2\").value=\"$nolama\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"r2\").checked=\"checked\";</script>";
							break;
						case"nama":
							$slip="nama like '%".trim($_POST["txnama"])."%'";
							echo"<script type=\"text/javascript\">document.getElementById(\"tx3\").value=\"$nama\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"r3\").checked=\"checked\";</script>";
							break;
						case"alamat":
							$slip="alamat like '%".trim($_POST["txalamat"])."%'";
							echo"<script type=\"text/javascript\">document.getElementById(\"tx4\").value=\"$alamat\";</script>";
							echo"<script type=\"text/javascript\">document.getElementById(\"r4\").checked=\"checked\";</script>";
							break;
					}
					$sql="SELECT nomor,nolama,nama,alamat FROM master WHERE ".$slip.";";
					$qry=mysql_query($sql)or die(mysql_error());
					$i=0;
					echo"<input type=\"hidden\" id=\"hnomor\" name=\"hnomor\" value=\"\" />";
					while($row=mysql_fetch_row($qry)){
						$i++;
						if($i%2==0){
							$wrn="#ccf";
						}else{
							$wrn="#ffc";
						}
						echo"
						<tr style=\"background:$wrn;\">
							<td>$i
								
							</td>
							<td style=\"color:#f00;cursor:pointer;\" onClick=\"hnomor.value='$row[0]';opener.document.getElementById('txnomor').value='$row[0]';window.close();\"><u>$row[0]</u></td>							
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td>$row[3]</td>
						</tr>
						";
					}
				}
				?>
                </form>
            </table>        
        </td>
    </tr>
</table>
</body>
</html>
<?php
putus();
?>