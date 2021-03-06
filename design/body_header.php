<header>
	<div class="header_name_user"><?php echo ($_SESSION['sname'] !='')?($_SESSION['ssurname']." ".$_SESSION['sname']." ".$_SESSION['sfathername']):( ($login)?("Пароль введен неверно"):( ($number == 0)?"Такого пользователя не существует":"" ) )?> <?php echo $aqds;?></div>
	<ul>
		<li class="autorization_button" <?php echo ($_SESSION['sname'] !='')?($hide):""?>>Авторизация</li>
		<li class="header_element out" <?php echo ($_SESSION['sname'] =='')?($hide):""?>>
			<form action="" method="post">
				<input type="submit" name="out" class="out" value="Выход">
			</form>
		</li>
		<li class="header_element logs_button" <?php ($_SESSION['srools'] !='admin')?($hide):""?>>Лог</li>
		<li class="header_element statistics_button">Статистика</li>
		<li class="header_element load_button" <?php echo ($_SESSION['sname'] =='')?($hide):""?>>Загрузить файл</li>
		<li class="header_element search_button">Поиск файлов</li>
	</ul>
</header>