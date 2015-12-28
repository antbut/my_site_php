<?php

if(!empty($_POST)){
//	include_once'../system/funktions.php';
	if($_POST['type_send']=='Создать Спецификацию'){
		//echo 'вошло ';
		extract($_POST, EXTR_OVERWRITE);
		
		$idsp=createSpicsfication( $predm_zakup, $vid_diyaln, $postach,  $pokypets, $id_user, $strok_postv, $yamov_postav, $predoplata, $povn_opl_pis_pos, $prots, $tranzit);
		unset($_POST);
		//echo __DIR__;
		include 'interf/add_specif_tabl.php';
		//echo ' вышло';
	}elseif($_POST['type_send']=='Добавить пункт'){
		include 'interf/add_specif_tabl.php';
	}elseif($_POST['type_send']=='Отправить в базу'){
		addPunktSpecifikation($_POST);
		echo 'Отправлено в базу';
		unset($_POST);
	}
	
}else{
	$id_user=$curent_user->id_user;
	//echo 'id_user='.$id_user;
	//include 'interf/add_specif_tabl.php';
	include 'interf/add_table_material.php';
}
?>