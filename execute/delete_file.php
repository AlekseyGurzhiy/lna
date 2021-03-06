<?php
	$db = mysqli_connect("beta.mtw.ru","pianogd1","Zsdcawedq23","db?pianogd1");
	mysqli_query($db,'SET names "utf8"');

	array_map("unlink", glob("../files/".$_POST['ajax_id'].".*"));
	mysql_query($db,"DELETE FROM file_lna WHERE id='".$_POST['ajax_id']."'");
	
	mysql_query($db,"INSERT INTO logs_lna (type_event, name_file, date_event, person_event, ip_event) VALUES ('del','".$_POST['ajax_filename']."','".date("Y-m-d H:i:s")."','".$_POST['ajax_people_name']."','".$_SERVER['REMOTE_ADDR']."')");
?>