<html>
<head>
  <title>Результат загрузки файла</title>
</head>
<body>
<?php
	include '../system/file.php';
	include '../system/user.php';
	//include '../interf/left.php';
	//print_r($_POST);
	$idload=$_POST['loadid'];
	//echo $idload;
   if($_FILES["filename"]["size"] > 1024*5*1024)
   {
     echo ("Размер файла превышает пять мегабайт");
     exit;
   }
   	if($idload==1){
		$linkaddr='/usr/share/nginx/html/price/xls/tor.xls';
	}
	if($idload==2){
		$linkaddr='/usr/share/nginx/html/price/xls/mater.xls';
	}
   // Проверяем загружен ли файл
   
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную]
	 

     move_uploaded_file($_FILES["filename"]["tmp_name"], $linkaddr);
	
	if($idload==2){
		$data= new FileData();
		$data->ExportArrayXLSInDB($data->getXLS('../xls/mater.xls',0),$data->GetArrayOrganizationIDfinsek());
	 }
	 
	 echo 'Файл загружен Успешно <br>';
	 echo '<a href="../work.php"> Перейти на начальную страницу</a>';
	 
   } else {
      echo("Ошибка загрузки файла");
   }
?>
</body>
</html>