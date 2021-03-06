<section class="section_add_file">
	<h1 class="UMK_h1">Локальные нормативные акты : Загрузка файлов</h1>
	<h3> Загрузка файлов только в формате PDF </h3>
	<div class="add_file">
		<form id="formAddFile" action="index.php" method="post" enctype="multipart/form-data">
			<table class="more_option_table">
				<tr> 
					<td colspan="2"> 
						<input type="text" name="add_file_beauty" class="add_file_beauty" placeholder="Выберите файл..." autocomplete="off">
						<input type="file" name="add_file_real" class="add_file_real">
					</td>
				</tr>
				<tr> 
					<td colspan="2"> <input type="text" name="add_file_name" class="add_file_name" placeholder="Введите имя файла:" autocomplete="off"> </td>
				</tr>
				
				<tr>
					<td class="w200"> 
						<div class="title">Подразделение:</div>
					</td>
					<td class="bottom"> 
						<select class="add_file_kafedra_s add_file_select" disabled>
							<option value="0"> Не известно </option>
							<?php mysqli_data_seek($query_pulpit, 0); ?>
							<?php while($row = mysqli_fetch_assoc($query_pulpit)){ ?>
							<option value="<?php echo $row['id']?>" <?php echo ($row["id"] == $_SESSION['skaf'])?'selected':''?>> <?php echo $row['name']?> </option>
							<?php } ?>
						</select>
					</td>
				</tr>

				<tr>
					<td class="w200"> 
						<div class="title">Дата документа:</div>
					</td>
					<td class="bottom"> 
						<input id="add_date_document" name="add_date_document" type="text" placeholder="Дата" autocomplete="off">
					</td>
				</tr>

				<tr>
					<td class="w200 title">Номер документа:</td>
					<td class="bottom"> 
						№ <input type="text" class="input-number_document" name="input_number_document_name" placeholder="Номер" autocomplete="off"> 
						<span><input type="checkbox" name="L_S"> Л/С </span>
						<span><input type="radio" name="radio_group_DSP_S" value="1"> ДСП </span>
						<span><input type="radio" name="radio_group_DSP_S" value="2"> С </span>
					</td>
				</tr>
				
				<tr>
					<td class="w200"> 
						<div class="title">Раздел:</div>
					</td>
					<td class="bottom"> 
						<select name="add_file_section" class="add_file_select add_file_facultet_s">
							<option value="0"> Не выбрано </option>
							<?php mysqli_data_seek($query_glossary, 0); ?>
							<?php while($row_glossagy = mysqli_fetch_assoc($query_glossary)){ ?>
								<?php if($row_glossagy['for_id']==0){ ?>
							<option value="<?php echo $row_glossagy['id']?>"> <?php echo $row_glossagy['name']?> </option>
								<?php } ?>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr class="hide_show_table_add">
					<td class="w200 title">Подраздел:</td>
					<td class="bottom"> 
						<select name="add_file_subsection" class="add_file_select add_file_job_s">
							<option class="razdel-option podraz-0" value="0"> Не выбрано </option>
							<?php mysqli_data_seek($query_glossary, 0); ?>
							<?php while($row_glossagy = mysqli_fetch_assoc($query_glossary)){ ?>
								<?php if($row_glossagy['for_id']!=0){ ?>
							<option class="razdel-option podraz-<?php echo $row_glossagy['for_id']?>" value="<?php echo $row_glossagy['id']?>"> <?php echo $row_glossagy['name']?> </option>
								<?php } ?>
							<?php } ?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td class="w200">
						<div class="title">Ключевые слова:</div>
					</td>
					<td class="bottom"> 
						<input type="text" name="add_area_keywords" class="input-key_text" placeholder="Введите ключевые слова" autocomplete="off">
					</td>
				</tr>

				<tr>
					<td class="w200">
						<div class="title">Исполнитель:</div>
					</td>
					<td class="bottom"> 
						<input type="text" name="file_executor" class="input-key_text" placeholder="Введите фамилию и инициалы исполнителя" autocomplete="off">
					</td>
				</tr>

				<tr>
					<td colspan="2" class="title text_center">Изменил/отменил действие документов:</td>
				</tr>
				<tr>
					<td class="w200">
						<div class="title">Изменил:</div>
						<input type="hidden" class="change_file_ids" name="change_file_ids" value="">
					</td>
					<td class="bottom change_file" title="Редактировать поле"> 
						-
					</td>
				</tr>
				<tr>
					<td class="w200">
						<div class="title">Отменил:</div>
						<input type="hidden" class="cancel_file_ids" name="cancel_file_ids" value="">
					</td>
					<td class="bottom close_file"> 
						-
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="send_file" class="send_file" value="Загрузить"></td>
				</tr>
			</table>
			
		</form>
	</div>
</section>