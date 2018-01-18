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
	<div style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;text-align:center;"><h3 style="margin:2px;">Pembayaran Berulang (Duplicate Payment)</h3>
	</div>
	<form id="f-double" action="" method="POST">
	<div style="width:1024px;text-align:center;margin:0 auto;padding:5px;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
<input type="radio" name="rjenis" id="rjenis1" value="r1" checked="checked"/>Per
		Tgl. Trans. &nbsp;
			<input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
			&nbsp;<i>s/d</i>&nbsp;
			<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
			:::::::::::::::
<input type="radio" name="rjenis" id="rjenis2" value="r2"/>Per Periode
<select name="optperiode1" id="optperiode1">
<?php
$sql=mysql_query("SELECT DISTINCT periode FROM rekening1 ORDER BY periode DESC;");
while($row=mysql_fetch_row($sql)){
	echo"<option value=\"$row[0]\">$row[0]</option>";
}
?>
</select>
s/d
<select name="optperiode2" id="optperiode2">
<?php
$sql=mysql_query("SELECT DISTINCT periode FROM rekening1 ORDER BY periode DESC;");
while($row=mysql_fetch_row($sql)){
	echo"<option value=\"$row[0]\">$row[0]</option>";
}
?>
</select>
			&nbsp;
			<input type="submit" name="submit" value="Proses" />
&rarr;&rarr;		
<input type="button" name="export" value="Export to Excel" onClick ="$('#table-duplicate').tableExport({type:'excel',escape:'false',htmlContent:'true'});" style="color:#00f;font-size:12px;font-weight:bold;padding:0px;"/>
	</div></form>

	<div style="height:430px;overflow:auto;width:1024px;box-shadow: 0 0 15px #999;margin:5 auto;" background="img/grids.gif"">
		<table id="table-duplicate" width="100%" border="1" cellpadding="5" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
			<thead style="color:#fff;background:linear-gradient(#900,#300);font-size:16px;font-weight:bolder;">
				<tr>
					<th>#</th>
					<th>Tanggal</th>
					<th>Loket</th>
					<th>Nomor/NoLama - Gol</th>
					<th>Nama</th>
					<th>Periode</th>
					<th>Jml. Bayar</th>
					<th>Kasir/Op.</th>
				</tr>
			</thead>
			<tbody>
<?php
if (isset($_POST['submit'])) {
	$i=1;
	$radio=$_POST['rjenis'];
	$tgl1=$_POST['txtawal'];
	$tgl2=$_POST['txtakhir'];
	$prd1=$_POST['optperiode1'];
	$prd2=$_POST['optperiode2'];
	if($radio=='r1') $sql=mysql_query("SELECT r.nomor,r.nolama,r.nama,t.periode,r.gol,t.loket,t.tbayar,t.jbayar,t.total,t.operator FROM rekening1 AS r INNER JOIN (SELECT nomor,periode FROM transaksi WHERE batal=0 GROUP BY nomor,periode HAVING COUNT(periode)>1) AS dup ON dup.nomor=r.nomor INNER JOIN transaksi AS t ON t.nomor=r.nomor WHERE dup.periode=r.periode AND r.status_bayar=1 AND t.periode=r.periode AND t.batal=0 AND (t.tbayar BETWEEN '$tgl1' AND '$tgl2') ORDER BY r.nomor ASC,r.periode ASC,t.tbayar ASC,t.jbayar ASC;");
	if($radio=='r2') $sql=mysql_query("SELECT r.nomor,r.nolama,r.nama,t.periode,r.gol,t.loket,t.tbayar,t.jbayar,t.total,t.operator FROM rekening1 AS r INNER JOIN (SELECT nomor,periode FROM transaksi WHERE batal=0 GROUP BY nomor,periode HAVING COUNT(periode)>1) AS dup ON dup.nomor=r.nomor INNER JOIN transaksi AS t ON t.nomor=r.nomor WHERE dup.periode=r.periode AND r.status_bayar=1 AND t.periode=r.periode AND t.batal=0 AND (r.periode BETWEEN '$prd1' AND '$prd2') ORDER BY r.nomor ASC,r.periode ASC,t.tbayar ASC,t.jbayar ASC;");
	while($row=mysql_fetch_row($sql)){
		echo"
<tr>
	<td align=\"center\">$i</td>
	<td align=\"center\">$row[6] $row[7]</td>
	<td align=\"center\">$row[5]</td>
	<td align=\"center\">$row[0] / $row[1] - $row[4]</td>
	<td>$row[2]</td>
	<td align=\"center\">$row[3]</td>
	<td align=\"right\">".formatMoney($row[8])."</td>
	<td align=\"center\">$row[9]</td>
</tr>
		";
		$i++;
	}
	echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$tgl1\";</script>";
	echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$tgl2\";</script>";
	
	echo"<script type=\"text/javascript\">document.getElementById(\"optperiode1\").value=\"$prd1\";</script>";
	echo"<script type=\"text/javascript\">document.getElementById(\"optperiode2\").value=\"$prd2\";</script>";
		
	if($radio=='r2')echo"<script type=\"text/javascript\">document.getElementById(\"rjenis2\").checked=\"checked\";</script>";
}
?>
			</tbody>
		</table>
	</div>
	<div style="color:#f00;margin:0 auto;width:1024px;background-color:#f0f0f0;padding:5px;">
		<b>Hint</b>: <i>Jika terdapat transaksi yang muncul hanya sekali, pilih tanggal transaksi beberapa bulan ke belakang (minimal 1 bulan ketika terbitnya periode rekening yang dimaksud.) kemudian Proses kembali</i>
	</div>

	</td>
</tr>





<?php
putus();
require_once("foot.php");
?>
