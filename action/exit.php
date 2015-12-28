<?php
$curent_user->ExitSesion();
					echo '<h1>Выход выполнен <a href="index.php">Перейти на страницу авторизации</a></h1>';
					//header(location: index.php);
					$headerlink='Location:index.php';
					header($headerlink);
?>