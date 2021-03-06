<?php
	//Указываем всем браузерам, что кодировка должна быть UTF-8
	header("Content-Type: text/html; charset=utf-8");  
	//Подключаемся к базе
	$db = mysqli_connect("beta.mtw.ru","pianogd1","Zsdcawedq23","db?pianogd1");
	mysqli_query($db,'SET names "utf8"');

	//Переменные, используемые в процессе работы программы
	$page_lna = 'active_page';
	$number = -1;
	$hide = "style='display:none;'";
	$show = "style='display:block;'";
	$show_cell = "style='display:table-cell;'";
	$number_result = 0;
	$filter = false;
	$sort_load = "";
	$sort_date = "button_active";
	$sort_section = ""; 
	
	//Запускаем глобальную переменную "Сессия". 
	session_start();
	
	//Если нажата кнопка "Выход", то уничтожаем сессию
	if(isset($_POST['out'])){
		$_SESSION['sid'] = '';
		$_SESSION['slogin'] = '';
		$_SESSION['sname'] = '';
		$_SESSION['ssurname'] = '';
		$_SESSION['sfathername'] = '';
		$_SESSION['skaf'] = '';
		$_SESSION['srools'] = '';
		session_destroy();
		$result_query = mysqli_query($db,"SELECT * FROM file_table WHERE `date_document`>'2015-01-01' ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для неавторизованного
	}

	// Если нажата клавиша "Скачать файл", то сохраняем его
	if( isset($_POST["download_file"]) ){
		$full_path_file = $_POST["download_filename"];
		$path_file = explode("/",$full_path_file);
		$id_file = explode(".",$path_file[1]);

		mysqli_query($db,"UPDATE file_lna SET download_number=download_number+1 WHERE id='".$id_file[0]."'");
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($_POST["download_newname"]).'"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($_POST["download_filename"]));
		ob_clean();
		flush();
		readfile($_POST["download_filename"]);
		exit;
	}
	
	//Если нажата кнопка авторизации
	if(isset($_POST["autoriz_submit"])){
		$autorization_login = $_POST["autoriz_login"];
		$autorization_password = $_POST["autoriz_password"];
		
		$query = mysqli_query($db,"SELECT * FROM users WHERE `login`='".$autorization_login."'");
		$number = mysqli_num_rows($query);
		
		if($number!=0) $rows = mysqli_fetch_assoc($query);
		
		if($number == 1){
			$login = true;
			if($autorization_password == $rows["password"]){
				$autorization = true;
				$_SESSION['sid'] = $rows["id"];
				$_SESSION['slogin'] = $autorization_login;
				$_SESSION['sname'] = $rows["name"];
				$_SESSION['ssurname'] = $rows["surname"];
				$_SESSION['sfathername'] = $rows["fathername"];
				$_SESSION['skaf'] = $rows["otdel"];
				$_SESSION['srools'] = $rows["rools"];
			} else {
				$autorization = false;
			}
		}
	}

	/* Если нажата кнопка "Удалить" */
	if( isset($_POST['delete_yes']) ){
		array_map("unlink", glob($_POST['download_filename']));
		mysqli_query($db,"DELETE FROM file_lna WHERE id='".$_POST['download_fileid']."'");
		mysqli_query($db,"INSERT INTO logs (type_event, name_file, date_event, person_event, ip_event,for_proga) VALUES ('del','".$_POST['download_newname']."','".date("Y-m-d H:i:s")."','".$_SESSION['ssurname']." ".$_SESSION['sname']." ".$_SESSION['sfathername']."','".$_SERVER['REMOTE_ADDR']."','1')");
	}

	if( isset( $_POST['lna_reload_file'] ) ){
		mysqli_query($db,"UPDATE `file_lna` SET `filename`='".$_POST['edit_lna_input_name']."',`number_document`='".$_POST['edit_lna_number_name']."',`L_S`='".$_POST['edit_lna_L_S']."',`date_document`='".date("Y-m-d",strtotime($_POST['edit_lna_date_document']))."',`section`='".$_POST['edit_lna_select_section']."',`subsection`='".$_POST['edit_lna_select_subsection']."',`keywords`='".$_POST['edit_lna_input_key']."',`executor`='".$_POST['edit_lna_input_executor']."' WHERE id=".$_POST['lna_id_record']);
	}

	// Если файл загружен, то...
	$tmp_filename = $_FILES["add_file_real"]["tmp_name"];
	if(is_uploaded_file($tmp_filename)){
		$filename = $_POST["add_file_name"];
		$filetype = substr($_FILES["add_file_real"]["name"], strrpos($_FILES["add_file_real"]["name"], '.')+1);
		
		//Добавляем запрос в базу на добавление записи о новом файле
		mysqli_query($db,"INSERT INTO `file_lna` (`filename`,`filetype`,`filesize`,`date_load`,`date_document`,`user`,`section`,`subsection`,`number_document`,`L_S`,`DSP_OR_S`,`keywords`,`pulpit`,`change_doc`,`cancel_doc`,`executor`) VALUES ('".$filename."', '".$filetype."','".$_FILES["add_file_real"]["size"]."','".date("Y-m-d G:i:s")."','".date("Y-m-d",strtotime($_POST['add_date_document']))."','".$_SESSION['sid']."','".$_POST['add_file_section']."','".$_POST['add_file_subsection']."','".$_POST['input_number_document_name']."','".$_POST['L_S']."','".$_POST['radio_group_DSP_S']."','".$_POST['add_area_keywords']."','".$_SESSION['skaf']."','".$_POST['change_file_ids']."','".$_POST['cancel_file_ids']."','".$_POST['file_executor']."' )");
		
		//Получаем идентификатор нового файла
		$query_id = mysqli_query($db,"SELECT `id` FROM `file_lna` WHERE `number_document`='".$_POST['input_number_document_name']."' AND `date_document`='".date("Y-m-d",strtotime($_POST['add_date_document']))."'");
		$row_file = mysqli_fetch_assoc($query_id);
		$id_file = $row_file["id"];

		//Формируем полное имя файла
		$full_filename = $_SERVER['DOCUMENT_ROOT']."/lna/files/".$id_file.".".$filetype;

		//Загружаем сам файл на сервер
		move_uploaded_file($tmp_filename, $full_filename);

		//Добавляем информацию об изменении тем файлам, которые изменил новый, только что загруженный
		$str_change = str_replace("(","",$_POST['change_file_ids']);
		$ids_change = explode(")",$str_change);
		array_pop($ids_change);

		foreach($ids_change as $ids){
			mysqli_query($db,"UPDATE `file_lna` SET `changed`='(".$id_file.")' WHERE `id`='".$ids."'");
		}
		unset($ids);

		//Добавляем в базу инфу об отмене тем файлам, которые отменил загруженный
		$str_cancel = str_replace("(","",$_POST['cancel_file_ids']);
		$ids_cancel = explode(")",$str_cancel);
		array_pop($ids_cancel);

		foreach($ids_cancel as $ids){
			mysqli_query($db,"UPDATE `file_lna` SET `canceled`='(".$id_file.")' WHERE `id`='".$ids."'");
		}
		unset($ids);
		
		header('Location: http://gurzhiy.info/lna/');
	}
	if($_SESSION['srools'] == 'admin'){
		$result_query = mysqli_query($db,"SELECT * FROM file_lna ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для админа
	} else if($_SESSION['srools'] == 'user'){
		$result_query = mysqli_query($db,"SELECT * FROM file_lna WHERE `date_document`>'2015-01-01' AND pulpit=".$_SESSION['skaf']." ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для юзера
	} else if($_SESSION['srools'] == ''){
		$result_query = mysqli_query($db,"SELECT * FROM file_lna WHERE `date_document`>'2015-01-01' ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для неавторизованного
	}
	
	if(isset($_POST['top_10_load']) ){
		if($_SESSION['srools'] == 'admin'){
			$result_query = mysqli_query($db,"SELECT * FROM file_lna ORDER BY download_number desc LIMIT 50"); // Список загруженных файлов для админа
		} else if($_SESSION['srools'] == 'user'){
			$result_query = mysqli_query($db,"SELECT * FROM file_lna WHERE `date_document`>'2015-01-01' AND pulpit=".$_SESSION['skaf']." ORDER BY download_number desc LIMIT 50"); // Список загруженных файлов для юзера
		} else if($_SESSION['srools'] == ''){
			$result_query = mysqli_query($db,"SELECT * FROM file_lna WHERE `date_document`>'2015-01-01' ORDER BY download_number desc LIMIT 50"); // Список загруженных файлов для неавторизованного
		}
		$sort_load = "button_active";
		$sort_date = "";
		$sort_section = "";
	}
	if(isset($_POST['top_10_date']) ){
		if($_SESSION['srools'] == 'admin'){
			$result_query = mysqli_query($db,"SELECT * FROM file_lna ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для админа
		} else if($_SESSION['srools'] == 'user'){
			$result_query = mysqli_query($db,"SELECT * FROM file_lna WHERE `date_document`>'2015-01-01' AND pulpit=".$_SESSION['skaf']." ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для юзера
		} else if($_SESSION['srools'] == ''){
			$result_query = mysqli_query($db,"SELECT * FROM file_lna WHERE `date_document`>'2015-01-01' ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для неавторизованного
		}
		$sort_load = "";
		$sort_date = "button_active";
		$sort_section = "";
	}
	if(isset($_POST['top_10_section']) ){
		if($_SESSION['srools'] == 'admin'){
			$result_query = mysqli_query($db,"SELECT * FROM file_lna ORDER BY section desc LIMIT 50"); // Список загруженных файлов для админа
		} else if($_SESSION['srools'] == 'user'){
			$result_query = mysqli_query($db,"SELECT * FROM file_lna WHERE `date_document`>'2015-01-01' AND pulpit=".$_SESSION['skaf']." ORDER BY section desc LIMIT 50"); // Список загруженных файлов для юзера
		} else if($_SESSION['srools'] == ''){
			$result_query = mysqli_query($db,"SELECT * FROM file_lna WHERE `date_document`>'2015-01-01' ORDER BY section desc LIMIT 50"); // Список загруженных файлов для неавторизованного
		}
		$sort_load = "";
		$sort_date = "";
		$sort_section = "button_active";
	}
	
	//Если нажата клавиша поиска
	if(isset($_POST["search_submit"])){
		$where_flag = false;
		$filter = true;
		/* Если текстовое поле не пустое */
		if($_POST["search_text"] != ""){
			$flag_search = 0;
			$where_flag = true;
			$query_text = "SELECT * FROM file_lna WHERE (LOCATE('".$_POST['search_text']."',filename) != 0)";
				//По дате
				if($_POST['lna_datepicker_start'] != "" || $_POST['lna_datepicker_end'] != ""){
					$start_date = $_POST['lna_datepicker_start'];
					$end_date = $_POST['lna_datepicker_end'];
					
					if($end_date==""){
						$end_date = date("Y-m-d");
						$_POST['lna_datepicker_end'] = date("d-m-Y");
					}

					if($start_date==""){
						$start_date = date("Y-m-d",strtotime('1970-01-01'));
						$_POST['lna_datepicker_start'] = date("d-m-Y",strtotime('01-01-1970'));
					}

					if($_POST["exact_date_name"] == "on"){
						$query_text.=" AND `date_document`='".date("Y-m-d",strtotime($start_date))."'";
					} else {
						$query_text.=" AND `date_document`>='".date("Y-m-d",strtotime($start_date))."' AND `date_document`<='".date("Y-m-d",strtotime($end_date))."'";
					}
				}

				//По разделу
				if($_POST['filter_area_razdel'] != 0){
					$query_text.=" AND `section`=".$_POST['filter_area_razdel'];
				}

				//По подразделу
				if($_POST['filter_area_podrazdel'] != 0){
					$query_text.=" AND `subsection`=".$_POST['filter_area_podrazdel'];
				}
				
				//По номеру
				if($_POST['input_number_document_name'] != 0){
					$query_text.=" AND `number_document`=".$_POST['input_number_document_name'];
				}

				//По чекбоксу Л/С
				if($_POST['L_S'] != ""){
					$query_text.=" AND `L_S`='on'";
				}

				//По радиобоксу "ДСП/С"
				if($_POST['radio_group_DSP_S'] != 0){
					$query_text.=" AND `DSP_OR_S`=".$_POST['radio_group_DSP_S'];
				}

				//По ключевым словам
				if($_POST['input-key_text_name'] != ""){
					$query_text.=" AND (LOCATE('".$_POST['input-key_text_name']."',keywords) != 0)";
				}

				//По исполнителю
				if($_POST['input-executor_file'] != ""){
					$query_text.=" AND (LOCATE('".$_POST['input-executor_file']."',executor) != 0)";
				}
		} else {
			$flag_search = 1;
			$result_title = "Результаты поиска";
			$query_text = "SELECT * FROM file_lna";
			//Добавляем к запросу поиск по дате
			if($_POST['lna_datepicker_start'] != "" || $_POST['lna_datepicker_end'] != ""){
				$start_date = $_POST['lna_datepicker_start'];
				$end_date = $_POST['lna_datepicker_end'];
					
				if($end_date==""){
					$end_date = date("Y-m-d");
					$_POST['lna_datepicker_end'] = date("d-m-Y");
				}

				if($start_date==""){
					$start_date = date("Y-m-d",strtotime('1970-01-01'));
					$_POST['lna_datepicker_start'] = date("d-m-Y",strtotime('1970-01-01'));
				}


				if($_POST["exact_date_name"] == "on"){
					$query_text.=" WHERE `date_document`='".date("Y-m-d",strtotime($start_date))."'";
				} else {
					$query_text.=" WHERE `date_document`>='".date("Y-m-d",strtotime($start_date))."' AND `date_document`<='".date("Y-m-d",strtotime($end_date))."'";
				}
				$where_flag = true;
			}
			//Добавляем к запросу поиск по разделу
			if($_POST['filter_area_razdel'] != 0){
				if($where_flag){ //т.е. если в запросе уже используется слово "WHERE"
					$query_text.=" AND `section`=".$_POST['filter_area_razdel'];
				} else {
					$query_text.=" WHERE `section`=".$_POST['filter_area_razdel'];
					$where_flag = true;
				}
			}

			//Добавляем к запросу поиск по подразделу
			if($_POST['filter_area_podrazdel'] != 0){
				if($where_flag){
					$query_text.=" AND `subsection`=".$_POST['filter_area_podrazdel'];
				} else {
					$query_text.=" WHERE `subsection`=".$_POST['filter_area_podrazdel'];
					$where_flag = true;
				}
			}

			//Добавляем к запросу поиск по номеру документа
			if($_POST['input_number_document_name'] != 0){
				if($where_flag){
					$query_text.=" AND `number_document`=".$_POST['input_number_document_name'];
				} else {
					$query_text.=" WHERE `number_document`=".$_POST['input_number_document_name'];
					$where_flag = true;
				}
			}

			//Добавляем к запросу поиск по чекбоксу "Л/С"
			if($_POST['L_S'] != ""){
				if($where_flag){
					$query_text.=" AND `L_S`='on'";
				} else {
					$query_text.=" WHERE `L_S`='on'";
					$where_flag = true;
				}
			}

			//Добавляем к запросу поиск по радиобоксу "ДСП/С"
			if($_POST['radio_group_DSP_S'] != 0){
				if($where_flag){
					$query_text.=" AND `DSP_OR_S`=".$_POST['radio_group_DSP_S'];
				} else {
					$query_text.=" WHERE `DSP_OR_S`=".$_POST['radio_group_DSP_S'];
					$where_flag = true;
				}
			}

			//Добавляем поиск по ключевым словам
			if($_POST['input-key_text_name'] != ""){
				if($where_flag){
					$query_text.=" AND (LOCATE('".$_POST['input-key_text_name']."',keywords) != 0)";
				} else {
					$query_text.=" WHERE (LOCATE('".$_POST['input-key_text_name']."',keywords) != 0)";
					$where_flag = true;
				}
			}

			//Добавляем поиск по исполнителю
			if($_POST['input-executor_file'] != ""){
				if($where_flag){
					$query_text.=" AND (LOCATE('".$_POST['input-executor_file']."',executor) != 0)";
				} else {
					$query_text.=" WHERE (LOCATE('".$_POST['input-executor_file']."',executor) != 0)";
					$where_flag = true;
				}
			}
		}
		$query_text.=" ORDER BY id desc";
		//echo $query_text;
		$result_query = mysqli_query($db,$query_text);
	}
	
	//Если нажата кнопка авторизации "Выход" 
	if(isset($_POST["out"])){
		$autorization = false;
	}
	
	$this_year = date("Y");
	//Список запросов к базе:
	$query_pulpit = mysqli_query($db,"SELECT * FROM pulpit");   					// Список кафедр
	$query_pulpit2 = mysqli_query($db,"SELECT * FROM pulpit WHERE type=2");   		// Список только кафедр
	$query_file_info = mysqli_query($db,"SELECT * FROM file_lna");				// Информация о загруженных файлах
	$query_glossary = mysqli_query($db,"SELECT * FROM glossary");				// Получаем список из словаря
	$query_log = mysqli_query($db,"SELECT * FROM logs WHERE for_proga=1 ORDER BY date_event desc");// Логи
?>
<!-- Далее внешний вид страницы, с подключенными модулями -->
<!DOCTYPE html>
<html>
	<head>
	<?php
		include_once("design/head.php"); 									// Подключаем содержимое тега head
	?>
	</head>
	
	<body lang="ru">
	<?php //Подключаем модули:
		include_once("design/body_absolute_element.php"); 					// ..абсолютные элементы страницы
		include_once("design/body_header.php");           					// ..тег header и его содержимое (черная строка вверху экрана) 
		include_once("design/body_section_search.php");   					// ..тег section - поиск файлов
		include_once("design/body_section_add_file.php"); 					// ..тег section - загрузка файлов
		include_once("design/body_section_stat.php");     					// ..тег section - статистика
		include_once("design/body_section_log.php");	     					// ..тег section - логгирование
		include_once("design/body_footer.php");           					// ..тег footer - подвал сайта
	?>
	</body>
</html>