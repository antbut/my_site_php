<?php

include 'interf/meny_table.php';
$idstr=1;
if(isset($_GET['idst'])){
	$idstr=$_GET['idst'];
}

//print_r($_GET);
include 'interf/work_table.tmp.php';
?>