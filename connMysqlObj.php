<?php
    $dbhost = '127.0.0.1';
    $dbuser = 'root';
    $dbpass = '';
	$db_link = @mysqli_connect( $dbhost, $dbuser, $dbpass);
	if (!$db_link) die("資料連結失敗！");

	mysqli_query($db_link, "SET NAMES utf8");
?>