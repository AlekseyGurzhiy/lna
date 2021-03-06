<?php
	header("Content-Type: text/html; charset=utf-8");
	$db = mysqli_connect("beta.mtw.ru","pianogd1","Zsdcawedq23","db?pianogd1");
	mysqli_query($db,'SET names "utf8"');
	
	//Запрос для поиска фамилии, имени и отчества пользователя
	$query_name = mysqli_query($db,"SELECT * FROM users WHERE id='".$_POST['id_user']."'");
	$row_name = mysqli_fetch_assoc($query_name);
	$full_name = $row_name["surname"]." ".$row_name["name"]." ".$row_name["fathername"]; //Сформировали фамилию, имя и отчество

	$query_otdel = mysqli_query($db,"SELECT * FROM pulpit WHERE id=".$_POST['otdel']);
	$row_otdel = mysqli_fetch_assoc($query_otdel);

	$query_section = mysqli_query($db,"SELECT * FROM glossary WHERE id=".$_POST['section']);
	$row_section = mysqli_fetch_assoc($query_section);

	//Получаем информацию о изменённых документах
	$str_change_doc = str_replace("(","",$_POST['change_doc']);
	$ids_change_doc = explode(")",$str_change_doc);
	array_pop($ids_change_doc);
	$i=0;
	foreach($ids_change_doc as $ids){
		$query_change_doc = mysqli_query($db,"SELECT * FROM `file_lna` WHERE `id`='".$ids."'");
		$row_change = mysqli_fetch_assoc($query_change_doc);
		$name_change = mb_substr($row_change['filename'],0,30,"UTF-8");
		$file_info_change[$i] = "<div class='link_file' id='q".$row_change['id']."'>№".$row_change['number_document']." от ".date("d.m.Y",strtotime($row_change['date_document']))." - \"".$name_change."\"</div>";
		$i++;
	}
	unset($ids);

	for($i=0;$i<count($file_info_change);$i++){
		$out_change.=$file_info_change[$i];
	}

//Получаем информацию об отменённых документах
	$str_cancel_doc = str_replace("(","",$_POST['cancel_doc']);
	$ids_cancel_doc = explode(")",$str_cancel_doc);
	array_pop($ids_cancel_doc);
	$i=0;
	foreach($ids_cancel_doc as $ids){
		$query_cancel_doc = mysqli_query($db,"SELECT * FROM `file_lna` WHERE `id`='".$ids."'");
		$row_cancel = mysqli_fetch_assoc($query_cancel_doc);
		$name_cancel = mb_substr($row_cancel['filename'],0,30,"UTF-8");
		$file_info_cancel[$i] = '<div class="link_file" id="q'.$row_cancel['id'].'">№'.$row_cancel['number_document'].' от '.date("d.m.Y",strtotime($row_cancel['date_document']))." - \"".$name_cancel."\"</div>";
		$i++;
	}
	unset($ids);

	for($i=0;$i<count($file_info_cancel);$i++){
		$out_cancel.=$file_info_cancel[$i];
	}

//Получаем информацию о файлах, которые изменили документ
	$str_changed = str_replace("(","",$_POST['changed']);
	$ids_changed = explode(")",$str_changed);
	array_pop($ids_changed);
	$i=0;
	foreach($ids_changed as $ids){
		$query_changed = mysqli_query($db,"SELECT * FROM `file_lna` WHERE `id`='".$ids."'");
		$row_changed = mysqli_fetch_assoc($query_changed);
		$name_changed = mb_substr($row_changed['filename'],0,30,"UTF-8");
		$file_info_changed[$i] = '<div class="link_file" id="q'.$row_changed['id'].'">№'.$row_changed['number_document'].' от '.date("d.m.Y",strtotime($row_changed['date_document']))." - \"".$name_changed."\"</div>";
		$i++;
	}
	unset($ids);

	for($i=0;$i<count($file_info_changed);$i++){
		$out_changed.=$file_info_changed[$i];
	}

//Получаем информацию о файлах, которые отменили документ
	$str_canceled = str_replace("(","",$_POST['canceled']);
	$ids_canceled = explode(")",$str_canceled);
	array_pop($ids_canceled);
	$i=0;
	foreach($ids_canceled as $ids){
		$query_canceled = mysqli_query($db,"SELECT * FROM `file_lna` WHERE `id`='".$ids."'");
		$row_canceled = mysqli_fetch_assoc($query_canceled);
		$name_canceled = mb_substr($row_canceled['filename'],0,30,"UTF-8");
		$file_info_canceled[$i] = '<div class="link_file" id="q'.$row_canceled['id'].'">№'.$row_canceled['number_document'].' от '.date("d.m.Y",strtotime($row_canceled['date_document']))." - \"".$name_canceled."\" </div>";
		$i++;
	}
	unset($ids);

	for($i=0;$i<count($file_info_canceled);$i++){
		$out_canceled.=$file_info_canceled[$i];
	}
//Возвращаем результат в javascript
	if($_POST['subsection']!=null){
		$query_subsection = mysqli_query($db,"SELECT * FROM glossary WHERE id=".$_POST['subsection']);
		$row_subsection = mysqli_fetch_assoc($query_subsection);
		echo json_encode(array(/*0*/$full_name,/*1*/$row_otdel['name'],/*2*/$row_section['name'],/*3*/$row_subsection['name'],/*4*/$out_change,/*5*/$out_cancel,/*6*/$out_changed,/*7*/$out_canceled));
	} else {
		echo json_encode(array(/*0*/$full_name,/*1*/$row_otdel['name'],/*2*/$row_section['name'],/*3*/$row_subsection['name'],/*4*/$out_change,/*5*/$out_cancel,/*6*/$out_changed,/*7*/$out_canceled));
	}
	
?>