<div class="logo"></div>
<div class="darken"></div>
<div class="instruction"><a href="doc/ChromeStandaloneSetup.exe">1. Скачать Google Chrome</a></div>

<!-- Поле для редактирования информации о файле -->

	<div class="edit_area">
		<div class="edit_area_close"></div>
		<h3 class="edit_area_title"> Редактирование </h3>
		<form id="lnaReloadInfo" action="index.php" method="post" enctype="multipart/form-data">
		<table class="edit_table">
			<tr class="edit_record">
				<td class="edit_cell_title">Имя файла:</td>
				<td class="edit_cell_value"><input type="text" class="edit_area_input_name" name="edit_lna_input_name" value=""></td>
			</tr>
			<tr class="edit_record">
				<td class="edit_cell_title">№ документа:</td>
				<td class="edit_cell_value">
						<input type="text" class="input-number_document edit_number" name="edit_lna_number_name" placeholder="Номер" autocomplete="off"> 
						<span><input type="checkbox" name="edit_lna_L_S" class="edit_L_S" checked=""> Л/С </span>
						<!--<span><input type="radio" name="edit_radio_group_DSP_S" value="1"> ДСП </span>
						<span><input type="radio" name="edit_radio_group_DSP_S" value="2"> С </span>
						<span><input type="radio" name="edit_radio_group_DSP_S" value="0"> убрать ДСП и С </span>-->
				</td>
			</tr>
			<tr class="edit_record">
				<td class="edit_cell_title">Дата:</td>
				<td class="edit_cell_value">
					<input id="edit_date_document" name="edit_lna_date_document" type="text" placeholder="Дата" autocomplete="off">
				</td>
			</tr>

			<tr class="edit_record">
				<td class="edit_cell_title">Раздел:</td>
				<td class="edit_cell_value">
				<select class="edit_area_select_section" name="edit_lna_select_section">
					<option value="0">Не выбрано</option>
					<? mysqli_data_seek($query_glossary, 0); ?>
					<? while($row_glossagy = mysqli_fetch_assoc($query_glossary)){ ?>
						<? if($row_glossagy['for_id']==0){ ?>
					<option value="<?=$row_glossagy['id']?>"> <?= $row_glossagy['name']?> </option>
						<? } ?>
					<? } ?>
				</select>
				</td>
			</tr>

			<tr class="edit_record edit_record_subsection">
				<td class="edit_cell_title">Подраздел:</td>
				<td class="edit_cell_value">
				<select class="edit_area_select_subsection" name="edit_lna_select_subsection">
					<option class="edit_razdel-option edit_podraz-0" value="0">Не выбрано</option>
					<? mysqli_data_seek($query_glossary, 0); ?>
					<? while($row_glossagy = mysqli_fetch_assoc($query_glossary)){ ?>
						<? if($row_glossagy['for_id']!=0){ ?>
					<option class="edit_razdel-option edit_podraz-<?=$row_glossagy['for_id']?>" value="<?=$row_glossagy['id']?>"> <?= $row_glossagy['name']?> </option>
						<? } ?>
					<? } ?>
				</select>
				</td>
			</tr>

			<tr class="edit_record">
				<td class="edit_cell_title">Ключ. слова:</td>
				<td class="edit_cell_value"><input type="text" class="edit_area_input_key" name="edit_lna_input_key" value=""></td>
			</tr>

			<tr class="edit_record">
				<td class="edit_cell_title">Исполнитель:</td>
				<td class="edit_cell_value"><input type="text" class="edit_area_input_executor" name="edit_lna_input_executor" value=""></td>
			</tr>

			<tr class="edit_record">
				<td colspan="2" class="edit_cell_value">
					<input type="hidden" id="lna_id_record" name="lna_id_record" value="">
					<input type="submit" class="send_file" name="lna_reload_file" value="Обновить">
				</td>
			</tr>
		</table>
	</form>
	</div>
	

<!-- Поле авторизации -->
<div class="autorization_area" >
	<div class="area_head">Введите логин и пароль</div>
	<form id="autorizForm" action="" method="post">
	<table>
		<tr>
			<td> Логин: </td>
			<td> <input type="text" name="autoriz_login" class="autoriz_login" value="alex"> </td>
		</tr>
		<tr>
			<td> Пароль: </td>
			<td> <input type="password" name="autoriz_password" value="123"> </td>
		</tr>
	</table>
	<input type="submit" name="autoriz_submit" class="autoriz_submit" value="Авторизация">
	</form>
</div>

<!-- Поле "Изменил действие документов" -->
<div class="change_file_area">
	<div class="edit_area_close"></div>
	<h3 class="change_file_area-title">Выберите изменённые документы</h3>
	<div class="change_file_area-input_area">
		<input type="text" id="change_file_area-input_area-number" placeholder="Номер документа">
		<input type="text" id="change_file_area-input_area-date" placeholder="Дата документа">
	</div>
	<input type="button" class="change_file_area-search" value="Поиск">

	<table id="change_file_area-table">
		<tr> 
			<td> Номер, дата </td>
			<td> Наименование </td>
			<td> Действие </td>
		</tr>
	</table>
	<input type="button" class="change_file_area-submit" value="Сохранить">
</div>

<!-- Поле "Отменил действие документов" -->
<div class="cancel_file_area">
	<div class="edit_area_close"></div>
	<h3 class="cancel_file_area-title">Выберите отменённые документы</h3>
	<div class="cancel_file_area-input_area">
		<input type="text" id="cancel_file_area-input_area-number" placeholder="Номер документа">
		<input type="text" id="cancel_file_area-input_area-date" placeholder="Дата документа">
	</div>
	<input type="button" class="cancel_file_area-search" value="Поиск">

	<table id="cancel_file_area-table">
		<tr> 
			<td> Номер, дата </td>
			<td> Наименование </td>
			<td> Действие </td>
		</tr>
	</table>
	<input type="button" class="cancel_file_area-submit" value="Сохранить">
</div>