	
	<tr valign="bottom">
		<td align="center" valign="bottom" bgcolor="#000000"><!--font color="#FFFFFF" face="Courier New, Courier, monospace" size="1px">&hearts; &reg;PDAM Jayapura&copy;2014 &hearts;</font--></td>
	</tr>
</table>

<?php
sambung();
$isi_info="";
$sql_info="SELECT tgl,isi FROM informasi ORDER BY id DESC LIMIT 1;";
$qry_info=mysql_query($sql_info)or die(mysql_error());
if($row_info=mysql_fetch_row($qry_info)){
	$isi_info="[".$row_info[0]."] ".$row_info[1];
}
putus();
?>

<table border="0px" width="90%">
	<tr style="text-align:left; display:scroll;position:fixed; bottom:10px;left:0px;color:#f00;font-size:15px;font-weight:80px;">
		<td>Billing Info :</td>
		<td><marquee width="800px" behavior="scroll" scrolldelay="200" style="color:#ff0;"><?php echo $isi_info;?></marquee></td>
	</tr>
</table>

</body>
</html>
