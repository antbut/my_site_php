	<?php
		if($curent_user->GetPrivilegeLevel()!=1 && $curent_user->GetPrivilegeLevel()!=2 && $curent_user->GetPrivilegeLevel()!=4 ){	
			echo '<ul id="menu">';
			if($curent_user->QwestPriwilege('VEIW_OLL_TABLE_WORK') && $curent_user->GetPrivilegeLevel()!=5){
				echo'<li><a href="?action=work_table">Таблица</a></li>';
			}
			if($curent_user->QwestPriwilege('VEIW_OLL_TABLE_MATERIAL') && $curent_user->GetPrivilegeLevel()!=5){
				echo'<li><a href="?action=material_table">Таблица Материалы</a></li>';
			}
			if($curent_user->QwestPriwilege('VIEW_TABLE_MANAGER_MATERIAL')){
				echo'<li><a href="?action=material_table">Таблица Материалы</a></li>';
			}
						
			if($curent_user->QwestPriwilege('ADD_MATERIAL_SPECIF')){
				echo'<li><a href="?action=new_specif">Добавить спецификацию</a></li>';
			}
			if($curent_user->QwestPriwilege('VEIW_USERS')){
				echo'<li class="user"><a href="?action=all_users">Пользователи</a></li>';
			}
			if($curent_user->QwestPriwilege('CREATE_USERS')){
				echo '<li class="useradd"><a href="?action=add_user">создать пользователя</a></li>';
			}
			if($curent_user->QwestPriwilege('VIEW_ROLES')){
				echo '<li><a href="?action=view_roles">Просмотреть Роли</a></li>';
			}
			if($curent_user->QwestPriwilege('EDIT_VIEW_GRUP')){
				echo '<li><a href="?action=view_group">Просмотреть групы просмотра</a></li>';
			}
			if($curent_user->QwestPriwilege('VIEW_LOG_ENTE_USERS')){
				echo '<li class="log"><a href="?action=log_ente">Лог входа</a></li>';
			}
			if($curent_user->QwestPriwilege('LOAD_FILES_IN_WORK')){
				echo'<li><a href="?action=upload">Загрузить данные</a></li>';
			}
			if($curent_user->QwestPriwilege('LOAD_FILES_IN_MATERIAL')){
				echo'<li class="download"><a href="?action=upload1">Загрузить данные материалов</a></li>';
			}
			echo '<li class="exitt"><a href="?action=exit">Выход</a></li>';
			echo'</ul>';
		}
	?>