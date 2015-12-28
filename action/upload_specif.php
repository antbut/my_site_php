<?php
ini_set('display_errors','On');
	//include 'system/file.php';
	//include '../system/user.php';
//	mysql_close($db);
	include 'system/db_material.php';
	$idload=$_POST['loadid'];
	$idsp=$_GET['idsp'];
	$loadful=$_GET['loadful'];
	$idfile=$_GET['idfile'];
	
	//echo 'loadful='.$loadful;
	
   if($_FILES["filename"]["size"] > 1024*5*1024)
   {
     echo ("Размер файла превышает пять мегабайт");
     exit;
   }
   
	$linkaddr='/usr/share/nginx/html/price/xls/temp/'.$_FILES['filename']['name'] ;;
	
	 
   // Проверяем загружен ли файл
   
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную]
	 

     move_uploaded_file($_FILES["filename"]["tmp_name"], $linkaddr);
	 
		$data= new FileData();
		if($loadful==1){
			echo 'загрузка етого вида пока не доступна<br><br>';
		//	echo 'id file='.$idfile;
			$err=$data->ExportXLSFullSpecifAddPosition($data->getXLS('xls/temp/'.$_FILES['filename']['name'],0), $data->GetArrayOrganizationIDfinsek(), $curent_user->id_user, $idsp, $idfile);
			if($err){
				$headerlink='Location:work.php?action=material_table&idsp='.$idsp;
				header($headerlink);
			}
		}else{
			$data->ExportXLSArraySpecif($data->getXLS('xls/temp/'.$_FILES['filename']['name'],0),$idsp);
			include 'interf/add_specif_tabl.php';
		}

		
	// echo 'Файл загружен Успешно <br>';
		unlink ( 'xls/temp/'.$_FILES['filename']['name']);
	 
   } else {
      echo("Ошибка загрузки файла");
   }
?>