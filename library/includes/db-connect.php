<?php
$link = mysql_connect("localhost", "admin", "")
        or die("Could not connect");

$db = mysql_select_db("test", $link)
		or die("Could not select database");

mysql_query('SET NAMES utf8') or die(mysql_error());
mysql_query('SET CHARACTER SET utf8') or die(mysql_error());
mysql_query('SET COLLATION_CONNECTION="utf8_general_ci"') or die(mysql_error());
mysql_set_charset('utf8');	
?>