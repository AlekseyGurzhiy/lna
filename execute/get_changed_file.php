<?php
	header("Content-Type: text/html; charset=utf-8");
	$db = mysqli_connect("beta.mtw.ru","pianogd1","Zsdcawedq23","db?pianogd1");
	mysqli_query($db,'SET names "utf8"');

	$query_search = mysqli_query($db,"SELECT * FROM `file_lna` WHERE `date_document`='".date("Y-m-d",strtotime($_POST['date_document']))."' AND `number_document`='".$_POST['number_document']."'");
	$number_row = mysqli_num_rows($query_search);
	$row = mysqli_fetch_assoc($query_search);

	echo json_encode(array($number_row,$row['filename'],$row['date_document'],$row['number_document'],$row['id'],$row['filetype']));
	
?>