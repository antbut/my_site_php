
<?php if($curent_user->GetPrivilegeLevel()==1 || $curent_user->GetPrivilegeLevel()==2 || $curent_user->GetPrivilegeLevel()==4 || $curent_user->GetPrivilegeLevel()==5){ ?>
<p align="center"><a href="?action=work_table" class="button12" tabindex="0">Работы</a>&nbsp &nbsp
<a href="?action=material_table" class="button12" tabindex="0">Товары и услуги</a></p>
<?php }else{ ?>
<p align="center">Выберите действие</p>
<?php $curent_user->QwestPriwilege('VEIW_USERS');	?>
<?php } ?>