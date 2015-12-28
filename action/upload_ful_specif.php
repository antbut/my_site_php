<?php
	//include 'system/file.php';
	//include '../system/user.php';
//	mysql_close($db);
	include 'system/db_material.php';
	//$idload=$_POST['loadid'];
	//$idsp=$_GET['idsp'];
   if($_FILES["filename"]["size"] > 1024*5*1024)
   {
     echo ("Размер файла превышает пять мегабайт");
     exit;
   }
   
	$linkaddr='/usr/share/nginx/html/price/xls/temp/'.$_FILES["filename"]["name"] ;
	//$linkaddr='Z:/home/localhost/www/new_int/xls/temp/sss.xls';
	// echo $linkaddr;
   // Проверяем загружен ли файл
   
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную]
	 

		move_uploaded_file($_FILES["filename"]["tmp_name"], $linkaddr);
	 
		$data= new FileData();
		//$data->ExportXLSArraySpecif($data->getXLS('xls/temp/'.$_FILES['filename']['name'],0),$idsp);
		$data->ExportXLSFullSpecif($data->getXLS('xls/temp/'.$_FILES['filename']['name'],0), $data->GetArrayOrganizationIDfinsek(), $curent_user->id_user);
		//include 'interf/add_specif_tabl.php';
	 echo 'Файл загружен Успешно <br>';
		unlink ( 'xls/temp/'.$_FILES['filename']['name']);
	 
   } else {
      echo("Ошибка загрузки файла на сервер");
   }
?>