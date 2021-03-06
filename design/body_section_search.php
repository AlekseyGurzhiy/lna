<section class="section_search">
	<!-- Клавиша "Новый поиск" -->	
	<?php if($filter){ ?>
	<div class="load_file"><a href="http://gurzhiy.info/lna/">Новый поиск</a></div>
	<?php } ?>

	<h1 class="UMK_h1">Локальные нормативные акты : Поиск файлов</h1>
	<div class="search">
		<form id="searchFile" action="" method="post">
			<input type="text" name="search_text" class="search_text" placeholder="Введите наименование искомого файла..." autocomplete="off" value="<?php echo $_POST['search_text']?>">
			<input type="hidden" name="search_flag" class="search_flag" value="<?php echo $flag_search;?>">
			<input type="submit" name="search_submit" class="search_submit <?php echo $filter?'search_button':'' ?>" value="Найти">
			<div class="search_filter">Фильтр</div>
		</div>
		<div class="filter_area">
			<table class="filter_area_table">
				<tr class="filter_area_record">
					<td class="filter_area_title"> Дата издания </td>
					<td class="filter_area_result">
						<input id="lna_datepicker_start" name="lna_datepicker_start" type="text" placeholder="Начальная дата" value="<?php echo $_POST['lna_datepicker_start'];?>" autocomplete="off">
						<input id="lna_datepicker_end" name="lna_datepicker_end" type="text" placeholder="Конечная дата" value="<?php echo $_POST['lna_datepicker_end'];?>" autocomplete="off">
						<span><input type="checkbox" class="exact_date" name="exact_date_name" <?php echo ($_POST['exact_date_name']=='on')?'checked':''?>> Точная дата </span>
					</td>
				</tr>
				<tr class="filter_area_record">
					<td class="filter_area_title"> Раздел </td>
					<td class="filter_area_result">
						<select class="filter_area_razdel" name="filter_area_razdel">
							<option value="0"> Не выбрано </option>
							<?php mysqli_data_seek($query_glossary, 0); ?>
							<?php while($row_glossagy = mysqli_fetch_assoc($query_glossary)){ ?>
								<?php if($row_glossagy['for_id']==0){ ?>
							<option value="<?php echo $row_glossagy['id']?>" 
								<?php if($_POST['filter_area_razdel'] == $row_glossagy['id']){
								 echo 'selected';
								} else {
									echo '';
								}
								?>> 
								<?php echo $row_glossagy['name']?> 
							</option>
								<?php } ?>
							<?php } ?>
						</select>
					</td>
				</tr>

				<tr class="filter_area_record search_podrazdel">
					<td class="filter_area_title"> Подраздел </td>
					<td class="filter_area_result">
						<select class="filter_area_podrazdel" name="filter_area_podrazdel">
							<option class="razdel-option raz-0" value="0"> Не выбрано </option>
							<?php mysqli_data_seek($query_glossary, 0); ?>
							<?php while($row_glossagy = mysqli_fetch_assoc($query_glossary)){ ?>
								<?php if($row_glossagy['for_id']!=0){ ?>
							<option class="razdel-option raz-<?=$row_glossagy['for_id']?>" value="<?php echo $row_glossagy['id']?>" <?php echo ( $_POST['filter_area_podrazdel'] == $row_glossagy['id'] )?'selected':''?>> <?php echo $row_glossagy['name']?> </option>
								<?php } ?>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr class="filter_area_record">
					<td class="filter_area_title"> Номер документа </td>
					<td class="filter_area_result">
						№ <input type="text" class="input-number_document" name="input_number_document_name" value="<?php echo $_POST['input_number_document_name']?>" placeholder="Номер" autocomplete="off"> 
						<span><input type="checkbox" name="L_S" <?php echo ($_POST['L_S']=="on"?"checked":"")?>> Л/С </span>
						<span><input type="radio" name="radio_group_DSP_S" value="1" <?php echo ($_POST['radio_group_DSP_S']=="1"?"checked":"")?>> ДСП </span>
						<span><input type="radio" name="radio_group_DSP_S" value="2" <?php echo ($_POST['radio_group_DSP_S']=="2"?"checked":"")?>> С </span>
					</td>
				</tr>
				<tr class="filter_area_record">
					<td class="filter_area_title"> Ключевое слово </td>
					<td class="filter_area_result">
						<input type="text" class="input-key_text" name="input-key_text_name" value="<?=$_POST['input-key_text_name']?>" placeholder="Поиск по ключу" autocomplete="off">
					</td>
				</tr>
				<tr class="filter_area_record">
					<td class="filter_area_title"> Исполнитель </td>
					<td class="filter_area_result">
						<input type="text" class="input-key_text" name="input-executor_file" value="<?=$_POST['input-executor_file']?>" placeholder="Поиск по исполнителю" autocomplete="off">
					</td>
				</tr>
			</form>
		</table>
	</div>
	<div class="search_result">
		<form action="" method="post">
			Сортировка: 
			<input type="submit" name="top_10_section" class="search_result-button <?=$sort_section?>" value="По разделам">
			<input type="submit" name="top_10_load" class="search_result-button <?=$sort_load?>" value="По популярности">
			<input type="submit" name="top_10_date" class="search_result-button <?=$sort_date?>" value="По дате">
		</form>
	</div>
	<div class="content">
		<table class="table_result">
<?php		while($row_result = mysqli_fetch_assoc($result_query)){ 
				$number_result++;
				if($row_result["filesize"] < 1024){
					$filesize = floor($row_result["filesize"]) ;
					$str = "б";
				} else if($row_result["filesize"]>1024 && $row_result["filesize"]<1024000){
					$filesize = round($row_result["filesize"]/1024,2);
					$str = "Кб";
				} else if($row_result["filesize"]>1024000){
					$filesize = round($row_result["filesize"]/1024/1024,2);
					$str = "Мб";
				}
				$url = "files/".$row_result["id"].".".$row_result["filetype"];
				switch($row_result["filetype"]){
					case "docx" : $class_type="word"; break;
					case "doc"  : $class_type="word"; break;
					case "DOC"  : $class_type="word"; break;
					case "mp4"  : $class_type="video"; break;
					case "avi"  : $class_type="video"; break;
					case "AVI"  : $class_type="video"; break;
					case "MP4"  : $class_type="video"; break;
					case "wmv"  : $class_type="video"; break;
					case "WMV"  : $class_type="video"; break;
					case "mpg"  : $class_type="video"; break;
					case "flv"  : $class_type="video"; break;
					case "FLV"  : $class_type="video"; break;
					case "pps"  : $class_type="pp"; break;
					case "PPS"  : $class_type="pp"; break;
					case "rtf"  : $class_type="word"; break;
					case "xls"  : $class_type="excel"; break;
					case "jpeg" : $class_type="jpg"; break;
					case "jpg"  : $class_type="jpg"; break;
					case "JPG"  : $class_type="jpg"; break;
					case "png"  : $class_type="png"; break;
					case "PNG"  : $class_type="png"; break;
					case "pdf"  : $class_type="pdf"; break;
					case "PDF"  : $class_type="pdf"; break;
					case "rar"  : $class_type="rar"; break;
					case "RAR"  : $class_type="rar"; break;
					default: $class_type="default";
				}
				?>
				<tr>
					<td width="5%"> <?php echo $number_result;?> </td>
					<td class="<?php echo $class_type;?> click-info" id="rec-<?php echo $row_result["id"];?>"><?php echo $row_result["filename"];?></td>
					<td width="19%" class="download_number"> Количество <br> скачиваний: <span class="download_number_<?php echo $row_result["id"];?>"><?php echo $row_result["download_number"];?></span></td> 
				</tr>
				<tr class="info" id="info-<?=$row_result["id"]?>">
					<td colspan="2" class="info_colspan2"> 
						<table class="info_one_table">
							<tr class="info_one_record">
								<td class="info_file_title"> Полное имя файла: </td>
								<td class="info_file_result"> <?php echo $row_result["filename"].".".$row_result["filetype"]?> </td>
							</tr>
							<tr class="info_one_record">
								<td class="info_file_title"> Номер документа: </td>
								<td class="info_file_result"> <span class="user_doc_number number-<?php echo $row_result["id"]?>" DSP_OR_S="<?php echo $row_result['DSP_OR_S'];?>" ls="<?php echo $row_result['L_S'];?>" ><?php echo $row_result["number_document"]?><?php echo ($row_result['L_S']=='on')?(" л/с"):("")?><?php echo ($row_result['DSP_OR_S']=='1')?(" ДСП"):("")?><?php echo ($row_result['DSP_OR_S']=='2')?(" С"):("")?> </span> </td>
							</tr>

							<tr class="info_one_record">
								<td class="info_file_title"> Размер файла: </td>
								<td class="info_file_result"> <?php echo $filesize." ".$str;?> </td>
							</tr>
							<tr class="info_one_record">
								<td class="info_file_title"> Дата загрузки на сервер: </td>
								<td class="info_file_result"> <?php echo date("d.m.Y H:i:s",strtotime($row_result["date_load"]));?> </td>
							</tr>
							<tr class="info_one_record">
								<td class="info_file_title"> Дата издания документа: </td>
								<td class="info_file_result date_doc_<?php echo $row_result["id"]?>"> <?php echo date("d.m.Y",strtotime($row_result["date_document"]));?> </td>
							</tr>
							<tr class="info_one_record">
								<td class="info_file_title"> Раздел: </td>
								<td class="info_file_result"> <span class="user_section_class" id="user_section_id_<?php echo $row_result["id"]?>" title="<?php echo $row_result["section"]?>">Загрузка...</span> </td>
							</tr>
							<?php if($row_result['section']>1){ ?>
							<tr class="info_one_record">
								<td class="info_file_title"> Подраздел: </td>
								<td class="info_file_result"> <span class="user_subsection_class" id="user_subsection_id_<?php echo $row_result["id"]?>" title="<?php echo $row_result["subsection"]?>">Загрузка...</span> </td>
							</tr>
							<?php } ?>
							<tr class="info_one_record">
								<td class="info_file_title"> Ключевые слова: </td>
								<td class="info_file_result"> <span class="user_keywords_class" id="user_key_id_<?php echo $row_result["id"]?>"><?php echo $row_result["keywords"]?></span> </td>
							</tr>
							<tr class="info_one_record">
								<td class="info_file_title"> Исполнитель: </td>
								<td class="info_file_result"> <span class="user_executor_class" id="user_executor_id_<?php echo $row_result["id"]?>"><?php echo ($row_result["executor"]==null)?"Не извесен":$row_result["executor"]?></span> </td>
							</tr>
							<tr class="info_one_record">
								<td class="info_file_title"> Кто загрузил файл: </td>
								<td class="info_file_result"><span class="user_login_class" title="<?php echo $row_result["user"]?>">Загрузка...</span></td>
							</tr>
							<tr class="info_one_record">
								<td class="info_file_title"> Подразделение: </td>
								<td class="info_file_result"> <span class="user_kafedra_class" title="<?php echo $row_result["pulpit"]?>">Загрузка...</span> </td>
							</tr>
							<tr class="info_one_record">
								<td class="info_file_title"> Актуальность: </td>
								<td class="info_file_result"><span class="user_status_class <?php echo (($row_result["changed"]==null) && ($row_result["canceled"]==null))?"green":""?><?php echo ($row_result["canceled"]!='')?"red":"";?><?php echo (($row_result["canceled"]==null) && ($row_result["changed"] != ''))?"yellow":"";?>"><?php echo (($row_result["canceled"]==null) && ($row_result["changed"]==null))?"Документ актуален":"";?><?php echo (($row_result["changed"]!='') && ($row_result["canceled"]==null))?"Документ изменён":"";?><?php echo ($row_result["canceled"]!='')?"Не действующая редакция":"";?></span></td>
							</tr>
							<tr class="info_one_record <?php echo ($row_result["change_doc"]!='')?'show_table':'hide';?>">
								<td class="info_file_title"> Изменяет документы: </td>
								<td class="info_file_result"><span class="user_change_doc_class" title="<?php echo $row_result["change_doc"];?>"></span></td>
							</tr>
							<tr class="info_one_record <?php echo ($row_result["cancel_doc"]!='')?'show_table':'hide';?>">
								<td class="info_file_title"> Отменяет документы: </td>
								<td class="info_file_result"><span class="user_cancel_doc_class" title="<?php echo $row_result["cancel_doc"];?>"></span></td>
							</tr>
							<tr class="info_one_record <?php echo ($row_result["changed"]!='')?'show_table':'hide';?>">
								<td class="info_file_title"> Изменён документами: </td>
								<td class="info_file_result"><span class="user_changed_class" title="<?php echo $row_result["changed"];?>"></span></td>
							</tr>
							<tr class="info_one_record <?php echo ($row_result["canceled"]!='')?'show_table':'hide';?>">
								<td class="info_file_title"> Отменён документом: </td>
								<td class="info_file_result"><span class="user_canceled_class" title="<?php echo $row_result["canceled"];?>"></span></td>
							</tr>
						</table>
					</td>
					<form method="post" action="" id="form_delete_file" name="form_delete_file">
						<td>
							<?php if( $class_type == "jpg" || $class_type == "png"){ ?>
							<a href="<?php echo $url;?>" class="view_class jpg_class"> Просмотр </a>
							<?php } ?>
							<?php if( $class_type == "pdf" ){ ?>
							<a href="<?php echo $url;?>" data-fancybox-type="iframe" class="view_class pdf_class"> Просмотр </a>
							<?php } ?>
							<input type="submit" class="download_class" title="<?php echo $row_result["id"];?>" name="download_file" value="Скачать">
							<?php if( $_SESSION['slogin'] != '' ){ ?>
							<input type="button" class="edit_class" title="<?php echo $row_result["id"];?>" name="edit_class" value="Редактор">
							<div class="delete_class"> Удалить </div>
							
							<?php } ?>
							
							<div class="delete_question">
								<div class="delete_question-text">Вы действительно хотите удалить этот файл?</div>
								<div class="delete_question-button delete_question-no"> Нет </div>
								<input type="submit" class="delete_question-button delete_question-yes" name="delete_yes" value="Да">
							</div>

							<input type="hidden" name="download_fileid" value="<?php echo $row_result["id"];?>">
							<input type="hidden" class="download_filename_<?php echo $row_result["id"];?>" name="download_filename" value="<?php echo $url;?>">
							<input type="hidden" class="download_newname_<?php echo $row_result["id"];?>" name="download_newname" value="<?php echo $row_result["filename"].".".$row_result["filetype"]?>">
						</td>
					</form>
				</tr>
				<?php		}	?>
			</table>

			<?php $number_file = mysqli_num_rows($result_query);?>
			<?php if(($number_file==0) && ($filter)){ ?>
			<h1> Файлов по Вашему запросу не найдено </h1>
			<?php } ?>

			<?php if(($number_file==0) && (!$filter)){ ?>
			<h1> Ни одного файла в базу не загружено </h1>
			<?php } ?>
		</div>
	</section>