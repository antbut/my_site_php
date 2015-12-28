<?php 
$db = mysql_connect('localhost','admin','Athlantida');
mysql_select_db('site_base',$db);

mysql_query("set_client='utf8'");
mysql_query("set character_set_results='utf8'");
mysql_query("set collation_connection='utf8_general_ci'");
mysql_query("SET NAMES'utf8'");
?>