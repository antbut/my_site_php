<?php
if(isset($_GET['add'])){
	
	$name=$_POST['new_user'];
	$pass=$_POST['passwd'];
	$email=$_POST['email'];
	$viewnam=$_POST['viewnam'];
	$org=$_POST['organiz'];
	$privil=$_POST['privilege'];
	$curent_user->Create_user($name,$viewnam, $pass,$email,$privil,$org);
}else{
include 'interf/infuser.php';
}
?>