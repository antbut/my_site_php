<html>
<?php
session_start();
//ini_set('display_errors','On');
?>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/table.css" type="text/css" />
<link rel="stylesheet" href="css/button.css" type="text/css" />
<link rel="stylesheet" href="css/links.css" type="text/css" />

<link rel="stylesheet" href="css/scrollup.css" type="text/css" media="screen">
<script src="js/scrollup.js" type="text/javascript"></script>

<title>Данные по ценам</title>
<body bgcolor="#EEE9E9">

<?php
	
	
	include_once 'system/user.php';
	include_once 'system/file.php';
	include_once 'system/funktions.php';
	$curent_user= new user();
	//$curent_user->Create_user('xoe01','kwR145vvh','mail@mai.ua',1,7);

	if($curent_user->Login($_POST['username'],$_POST['password'])){
		
		include 'interf/top.php';
		include 'interf/left.php';
		
		$action=clean_str($_GET['action']);	
		//$actionmode=clean_str($_GET['actionmode']);	
	
		if(!$action){
			$action="action/main_use.php";
		}
		if(file_exists('action/'.$action.'.php')){
			include 'action/'.$action.'.php';
		//	include 'action/upload.php?id=1';
		}else{
			include 'action/main_use.php';
		}
		//echo "action= $action";
		
		
		
		?>
		
		<?php
	}
	else {
		echo '<h1>Access denied</h1>';
	}
	
?>
<div id="scrollup">
	<img src="images/up.png" class="up" alt="Прокрутить вверх" />
</div>

</body>
</html>
