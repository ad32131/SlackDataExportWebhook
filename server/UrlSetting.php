<html>
<head><title>UrlSetting</title></head>
<body>
<?php
if(strlen($_POST['Email']) > 0 ){
	$fp = fopen("UrlSetting.txt", "w");
	fwrite($fp, $_POST['Email']);
	fclose($fp);
	header("Refresh:0");
}else{
	echo "<form method='post'>";
	echo "Email:<input type='text' id='Email' name='Email'/><br/>";
	echo "<input type='submit' value='OK' />";
	echo "</form>";
}
?>
</body>
</html>
