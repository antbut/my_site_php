<?php

if($curent_user->QwestPriwilege('LOAD_FILES_IN_WORK') ){
	$idval=1;
}
$idval=1;

?>							
							<div class="posituload"><h2><p><b> Форма для загрузки файлов </b></p></h2>
							
							<form action="system/upload.php" method="post" enctype="multipart/form-data">
							<table class="tr_inviz" align="center">
							<tr ><td class="tr_table">
							<input type="file" name="filename"><br>
							
							<input type="hidden" name="loadid" value="1"></td></tr>
							<tr><td class="tr_table">
							<input type="submit" value="Загрузить"></td></tr>
							</table>
							</form></div>'