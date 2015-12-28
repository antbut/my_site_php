<?php
include_once 'file.php';
include'db.php';
class user{
	
	public $id_user;
	public $name;
	public $viewname;
	private $viewgroup;
	private $hashpasswd;
	public $organization;
	private $organizationid;
	private $organizationlastname;
	private $privilege;
	private $email;
	public function GetViewGroup(){
		return $this->viewgroup;
	}
	public function GetPrivilegeLevel(){
		return $this->privilege;
	}
//-------------------------- получить название организации
	public function GetOrganization(){
		return $this->organization;
	}
//--------------------------получить условное обозначение в таблице
	public function GetOrganizationLastname(){
		return $this->organizationlastname;
	}
//--------------------------Получить ИД пользователя
	public function GetOrganizationID(){
		return $this->organizationid;
	}
	public function GetUserRoleFoID($id){
		
		$resull = mysql_query("SELECT * FROM roles WHERE id='$id'");
								
				if($myrole=mysql_fetch_array($resull)){
					return  $myrole['name'];
				}else{
					$ret='Роль не назначена';
					return $ret;
				}
		
	}
	public function GetUsersIdViewname(){
		$result = mysql_query("SELECT * FROM users ");
			$i=0;
			while($myuser=mysql_fetch_array($result)){
				$res[$i++]=array('id'=>$myuser['id'],'name'=>$myuser['viewname']);
			}
		return $res;
	}
	public function  editrole($idrole, $priveleges=array()){
		
		//print_r($priveleges);
		$n=count($priveleges);
		
		//echo 'n='.$n;
		for($i=0;$i<$n;$i++){
			//echo '<br>запрос  ';
			$resultrol = mysql_query("SELECT * FROM role_and_privilege WHERE id_role='$idrole' AND id_privilege='$priveleges[$i]' ");
				if($myrol=mysql_fetch_array($resultrol)){
			//		echo 'есть такая привилегия';
					
				}else{
				//	echo 'нужно добавить привилегию';
					$pr=$priveleges[$i];
					$resultaddrol = mysql_query("INSERT INTO `role_and_privilege`(`id_role`, `id_privilege`) VALUES('$idrole', '$pr')");
					
					if($resultaddrol){
						//echo 'привилегия добавлена успешно';
					}
				}
		}
		
		$a = mysql_query("SELECT COUNT(1) FROM role_and_privilege WHERE id_role='$idrole'");
		$b = mysql_fetch_array( $a );
		//echo 'количество привилегий у роли'.$b[0];
		
		if($b[0]>$n){
		//	echo'<br>чтото лишнее<br>';
			$resultrol = mysql_query("SELECT * FROM role_and_privilege WHERE id_role='$idrole'");
			while($rols=mysql_fetch_array($resultrol)){
				$okrol=false;
				for($i=0;$i<$n;$i++){
					if($priveleges[$i]==$rols['id_privilege']){
						$okrol=true;
						break;
					}
				}
				if(!$okrol){
					$dellpriv=mysql_query("DELETE FROM `role_and_privilege` WHERE id_role='$idrole' AND id_privilege='$rols[id_privilege]'" );
					if($dellpriv){
					//	echo  'привилегии удалены';
					}
				}
			}
		}
		unset($_POST);
	}
	
	public function  editviewgroup($idvievgr, $priveleges=array()){
		
		//print_r($priveleges);
		$n=count($priveleges);
		
		//echo 'n='.$n;
		for($i=0;$i<$n;$i++){
			//echo '<br>запрос  ';
			$resultrol = mysql_query("SELECT * FROM viewgroup_and_organiz WHERE id_viewgrup='$idvievgr' AND id_organization='$priveleges[$i]' ");
				if($myrol=mysql_fetch_array($resultrol)){
			//		echo 'есть такая привилегия';
					
				}else{
				//	echo 'нужно добавить привилегию';
					$pr=$priveleges[$i];
					$resultaddrol = mysql_query("INSERT INTO `viewgroup_and_organiz`(`id_viewgrup`, `id_organization`) VALUES('$idvievgr', '$pr')");
					
					if($resultaddrol){
						//echo 'привилегия добавлена успешно';
					}
				}
		}
		
		$a = mysql_query("SELECT COUNT(1) FROM viewgroup_and_organiz WHERE id_viewgrup='$idvievgr'");
		$b = mysql_fetch_array( $a );
		//echo 'количество привилегий у роли'.$b[0];
		
		if($b[0]>$n){
		//	echo'<br>чтото лишнее<br>';
			$resultrol = mysql_query("SELECT * FROM viewgroup_and_organiz WHERE id_viewgrup='$idvievgr'");
			while($rols=mysql_fetch_array($resultrol)){
				$okrol=false;
				for($i=0;$i<$n;$i++){
					if($priveleges[$i]==$rols['id_organization']){
						$okrol=true;
						break;
					}
				}
				if(!$okrol){
					$dellpriv=mysql_query("DELETE FROM `viewgroup_and_organiz` WHERE id_viewgrup='$idvievgr' AND id_organization='$rols[id_privilege]'" );
					if($dellpriv){
					//	echo  'привилегии удалены';
					}
				}
			}
		}
		unset($_POST);
	}
//---------------------------Создать Пользователя---------------------------------	
	public function Create_user($name, $viewnam, $passwd,$email,$privilege,$organizationid){
		
		$data_org=new FileData();
		$this->name=$name;
		$this->organizationid=$organizationid;
		$this->hashpasswd=md5($passwd);
		//$orn=$data_org->LoadOrganizationFoID($organizationid);
		$this->organization=$this->GetOrganizationFoID($organizationid);
		$this->email=$email;
		$this->privilege=$privilege;
		$tim=date("Y-m-d");
		
		$result = mysql_query("INSERT INTO users (login, viewname, passwd, passwdhash, privilege, orgnizid, orgniz, email, lastchpasswd) VALUES('$name', '$viewnam', '$passwd', '$this->hashpasswd', '$privilege', '$organizationid', '$this->organization', '$email', '$tim')");
					
		if ($result == true){
			echo '  Пользователь создан';
		}else{
			echo '  Произошла ошибка присоздании пользователя';
		}
	}
	public function Delete_user($id){
		$result = mysql_query("DELETE FROM `users` WHERE id='$id'");
		if($result){
			echo "пользователь успешно удален id=".$id;
			return true;
		}else{
			echo "пользователь не мог быть удален";
			return false;
		}
	}
//---------------------------изменить настройки пользователя---------------------------------	
	public function changeUserData($id, $name,$viwnam,$passwd,$email,$privilege,$organizationid,$viewgroup){
		
		$data_org=new FileData();
		$this->name=$name;
		$this->organizationid=$organizationid;
		
		//$orn=$data_org->LoadOrganizationFoID($organizationid);
		$this->organization=$this->GetOrganizationFoID($organizationid);
		$this->email=$email;
		$this->privilege=$privilege;
		$this->viewgroup=$viewgroup;
		$tim=date("Y-m-d");
		if($passwd!=""){
			$this->hashpasswd=md5($passwd);
			$result = mysql_query("UPDATE users SET login='$name', viewname='$viwnam', passwd='$passwd', passwdhash='$this->hashpasswd', privilege='$privilege', orgnizid='$organizationid', orgniz='$this->organization', email='$this->email', lastchpasswd='$tim', viewgroup='$this->viewgroup' WHERE id='$id'");
		}else{
			$result = mysql_query("UPDATE users SET login='$name',viewname='$viwnam', privilege='$privilege', orgnizid='$organizationid', orgniz='$this->organization', email='$this->email', 	viewgroup='$this->viewgroup' WHERE id='$id' ");
			
		}
		
	//	$result = mysql_query("UPDATE users SET login='$name',");
		
			
		if ($result == true){
			echo 'Данные обновлены';
		}else{
			echo 'Произошла ошибка при обновлении';
		}
	}
//----------------------- получить имена всех пользовтелей-----------------------------------
	public function Load_username(){
		$f=fopen('system/userdata.dat',r);
		$i=0;
		$names=array();
		while (!feof($f)){
			$data=fgets($f);
			$array_dat=explode(',',$data);
			$names[$i++]=$array_dat[0];
		}
		
		fclose($f);
		return $names;
		
	}
	public function DefUser(){
		$access=true;
		$this->name='DefUser';
		$this->organizationid=2;
		$this->hashpasswd=md5($passwd);
		$this->email='em@ua.fm';
		$this->privilege=1;
		$orgname='сумы';
		$this->organization=2;
		$this->organizationlastname='II';
	}
//------------------------Авторизация пользователя на странице-----------------------
	public function Login($name,$passwd){
		$access=false;
		$data_org=new FileData();
		
		$l=fopen('system/log.dat','a+');
		 
		$result = mysql_query("SELECT * FROM users WHERE login='$name'");
		if($myuser=mysql_fetch_array($result)){
						
			if(md5($passwd)==$myuser['passwdhash']){
				$access=true;
				$this->name=$name;
				$this->organizationid=$myuser['orgnizid'];
				//echo'id='.$myuser['orgnizid'];
				$this->hashpasswd=md5($passwd);
				$this->id_user=$myuser['id'];
				$this->viewgroup=$myuser['viewgroup'];
				
				
				$this->viewname=$myuser['viewname'];
				$this->privilege=$myuser['privilege'];
				$orgname=$data_org->LoadOrganizationFoID($myuser['orgnizid']);
				//print_r($orgname);
				$this->organization=$orgname[0];
				$this->organizationlastname=$orgname[1];
				unset($_SESSION["login"]);
				unset($_SESSION["pwd"]);
				$_SESSION['login']=$this->name;
				$_SESSION['pwd']=$this->hashpasswd;
				//fwrite($l,"user:$name login Sucses \n"); //запись в лог файл
				$this->sendlog("user:$name login Sucses");
				
			}
		}elseif(!isset($_SESSION['login']) && !isset($_SESSION['pwd'])){
			echo 'нет такого пользователя!!!';
			$this->sendlog("user:$name bad login");
		}
			
		if(isset($_SESSION['login']) && isset($_SESSION['pwd']) && !$access ){
			$result = mysql_query("SELECT * FROM users WHERE login='$_SESSION[login]'");
				
				
				$myuser=mysql_fetch_array($result);
				
				if($myuser && $_SESSION['pwd']==$myuser['passwdhash']){
					$access=true;
					$this->name=$myuser['login'];
					$this->organizationid=$myuser['orgnizid'];
					$this->hashpasswd=$_SESSION['pwd'];
					$this->id_user=$myuser['id'];
					$this->viewgroup=$myuser['viewgroup'];
					
					$this->viewname=$myuser['viewname'];
					$this->email=$myuser['email'];
					$this->privilege=$myuser['privilege'];
					$orgname=$data_org->LoadOrganizationFoID($myuser['orgnizid']);
					$this->organization=$orgname[0];
					$this->organizationlastname=$orgname[1];
					
				}
		}
		
		if(!$access){
			$this->sendlog("user: $name login failed");
		//	$t=date("Y-m-d H:i:s");
		//	fwrite($l,"$t user:$name login failed \n");
		}
		
		
		fclose($l);
		
		return $access;
	}
	public function GetUsrInfo(){
		echo 'инфрмация по пользователю:<br>';
		echo '<br>Имя:'.$this->name;
		echo '<br>Имя: '.lastname;
		echo '<br>хеш пароля '.$this->hashpasswd;
		echo '<br>Организация '.$this->organization;
		echo '<br>ИД Организации '.$this->organizationid;

		echo '<br>Второе название организации '.$this->organizationlastname;
		echo '<br>Уровень привилегий '.$this->privilege;
		echo '<br>Емейл '.$this->email;
	}
	
	
	public function SheckPasswd(){
		
	}
	public function ExitSesion(){
		unset($_SESSION["login"]);
		unset($_SESSION["pwd"]);
	}
	public function GetEmailUser(){
		return $this->email;
	}
	public function GetEmailAll(){
		
	}
	
	public function GetAllUser($priv=5){
		
		$i=0;
		$names=array();
		$res=array();
		
		$result = mysql_query("SELECT * FROM users ORDER BY login");
		
		echo '<h3><p align="center">Информация по учетным записям пользователей в системе</p></h3>';
		echo '<table align="center" border="1">';
		echo '<tr><th>ID</th><th>Логин</th><th>ИД организации</th><th>Название организации</th><th>Емейл</th><th>Уровень привилегий</th><th></th></th><th></th>';	
		
		while ($myuser=mysql_fetch_array($result)){
			
			echo '<tr><td>'.$myuser['id'].'</td><td>'.$myuser['login'].
				'</td><td>'.$myuser['orgnizid'].'</td><td>'.$myuser['orgniz'].'</td><td>'.$myuser['email'].
				'</td><td>'.$this->GetUserRoleFoID($myuser['privilege']).'</td>';
			if($this->QwestPriwilege('EDIT_USERS')){	
				echo '<td><a href="?action=all_users&usid='.$myuser['id'].'">edit</a></td>';
				echo '<td><a href="?action=all_users&usid='.$myuser['id'].'&act=delete"><img src="images/delete.png" width="20px" height="20px"></a></td></tr>';
			}else{
				echo '<td></td></tr>';
			}
			
		}
		echo '</table>';	
		
		return $res;
		
	}
	public function GetOrganizationFoID($organizationid){
		$result = mysql_query("SELECT * FROM organization WHERE id='$organizationid'");
								
				if($myuser=mysql_fetch_array($result)){
					return  $myuser['name'];
				}else{
					return false;
				}
				
	}
	
	public function QwestPriwilege($namePrivilege='aa'){
		
		//this->privilege
		$resultpr = mysql_query("SELECT privileges.name FROM privileges, role_and_privilege WHERE role_and_privilege.id_privilege=privileges.id AND role_and_privilege.id_role='$this->privilege' AND privileges.name='$namePrivilege'");
		while ($myprivileges=mysql_fetch_array($resultpr)){
			//echo 'true';
			return true;
			
		}
		//echo 'false';
		return false;
		
	}
	
	public function viewlog(){
		$l=fopen('system/log.dat','r');
		echo '<table align="center">';
		while(!feof($l)){
			$logdata=fgets($l);
			$view=explode(';',$logdata);
			echo "<tr><td>$view[0]</td><td>$view[1]</td><td>$view[2]</td>";
			$stringteg = strpos($view[3], "failed");
			$stringteg += strpos($view[3], "bad");
			if($stringteg>0){
				echo"<td>$view[3] !!!</td></tr>";
			}else{
				echo"<td>$view[3]</td></tr>";
			}
		}
		echo '<table>';
		
	}
	public function sendlog($mess){
		$l=fopen('system/log.dat','a+');
		$t=date("Y-m-d H:i:s");
		$user_agent = $_SERVER["HTTP_USER_AGENT"];
		if (strpos($user_agent, "Firefox") !== false) $browser = "Firefox";
		elseif (strpos($user_agent, "Opera") !== false) $browser = "Opera";
		elseif (strpos($user_agent, "Chrome") !== false) $browser = "Chrome";
		elseif (strpos($user_agent, "MSIE") !== false) $browser = "Internet Explorer";
		elseif (strpos($user_agent, "Safari") !== false) $browser = "Safari";
		else $browser = "Неизвестный";
				
		$ip=$_SERVER['REMOTE_ADDR'];
		fwrite($l,"$t ; $browser; $ip; $mess \n"); //запись в лог файл
	}
	
};




?>