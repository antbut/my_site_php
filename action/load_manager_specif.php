<?php
//print_r($_GET);
if(isset($_GET['idsp'])){
$idsp=$_GET['idsp'];
//echo 'id'.$idsp;

}
if(isset($_GET['loadful'])){
	$loadful=$_GET['loadful'];
	
}
$id_user=$curent_user->id_user;
	unset($_POST);
	include 'interf/add_specif_tabl.php';
?>