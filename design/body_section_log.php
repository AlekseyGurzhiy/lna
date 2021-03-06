<section class="section_logs">
	<div class="w_1000">
	<h1 class="UMK_h1">Электронный УМК : Логгирование</h1>
		<div class="log_filter">
			Фильтр по дате: <br>
			<input id="log_datepicker_start" type="text" name="log_date_start" value="" placeholder="Начальная дата">
			<input id="log_datepicker_end" type="text" name="log_date_end" value="" placeholder="Конечная дата">
		</div>
		<table class="log_table">
			<tr class="log_record">
				<td class="log_cell_head">
					№
				</td>
				<td class="log_cell_head">
					Информация
				</td>
			</tr>
			<?php $log_number = 1; ?>
			<?php while ( $row_log = mysqli_fetch_assoc($query_log) ){?>
			<tr>
				<td class="log_cell text_center">
					<?php echo $log_number++; ?>
				</td>
				<td class="log_cell text_left" title="<?php echo date('d.m.Y h:m:s',strtotime($row_log['date_event']))?>">
					<?php echo date('d.m.Yг. в h:m:s',strtotime($row_log['date_event']))?> <?php echo $row_log['person_event']?> удалил файл "<?php echo $row_log['name_file']?>" c IP-адреса "<?php echo $row_log['ip_event'];?>" 
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</section>