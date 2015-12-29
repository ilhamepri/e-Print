<?php
$host	= "localhost";
$user	= "root";		
$pass	= "luver";		
$db		= "pbw_uas";

mysql_connect($host, $user, $pass) or die( "server database tidak ditemukan!");
mysql_select_db($db) or die( "database tidak ditemukan di server!" );
?>