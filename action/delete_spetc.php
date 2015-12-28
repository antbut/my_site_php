<?php
if(isset($_GET['idsp'])){
	mysql_close($db);
	include_once 'system/db_material.php';
	$idsp=$_GET['idsp'];
	if(DeleteSpetcif($idsp)){
		$headerlink='Location:work.php?action=material_table';
		header($headerlink);
	}
}
?>