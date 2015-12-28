<?php
//include 'interf/viewusers.php'

if(isset($_GET['usid']) && isset($_GET['edit'])){
	
	if($_GET['edit']==1){//если редактируем пользователя
			
			echo 'запрос на измененние';
			$id=$_GET['usid'];;
			$name=$_POST['new_user'];
			$pass=$_POST['passwd'];
			$viewnam=$_POST['viewnam'];
			$email=$_POST['email'];
			$org=$_POST['organiz'];
			$privil=$_POST['privilege'];
			$viewgroup=$_POST['viewgroup'];
					
			$curent_user->changeUserData($id, $name, $viewnam, $pass,$email,$privil,$org,$viewgroup);
	}
	
	
}elseif(isset($_GET['usid']) && !isset($_GET['act'])){
	include_once 'interf/infuser.php';
}elseif(isset($_GET['act'])){
	if($_GET['act']=="delete"){
		$curent_user->Delete_user($_GET['usid']);
	}
}else{
	$use=$curent_user->GetAllUser($curent_user->GetPrivilegeLevel());
}

?>