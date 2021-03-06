<?php
	$number_record = 1;
	$summa = 0;
	mysqli_data_seek($query_pulpit, 0);
	//mysql_data_seek($query_file_info, 0);
		while ( $row_file_info = mysqli_fetch_assoc($query_file_info) ) {
			$arr_section_kaf[ $row_file_info['pulpit'] ][ $row_file_info['section'] ]++;
			$summa+=1;
		}

	//mysql_data_seek($query_file_info, 0);
	while($row_file_info = mysqli_fetch_assoc($query_file_info)){
		$arr_kaf_number[ $row_file_info['pulpit'] ]++; 					//Считаем общее количество файлов по каждой кафедре
		$arr_section_number[ $row_file_info['section'] ]++;				//Считаем общее количество файлов по разделам
	}

	$colspan_number = mysqli_num_rows($query_pulpit);					//Общее количество кафедр, содержащееся в базе
?>
<section class="section_stat">
	<div class="w_1000">
		<h1 class="UMK_h1">Локальные нормативные акты : Статистика</h1>
		<div class="stat_load">
			<h2 class="UMK_h2"> Загружено на сервер: </h2>

			<table class="stat_load-kaf_table center">
				<th colspan="3">По разделам и кафедрам:</th>
				<tr class="stat_load-kaf_tr">
					<td class="stat_load-kaf_head" rowspan="2"> № </td>
					<td class="stat_load-kaf_head" rowspan="2"> Раздел </td>
					<td class="stat_load-kaf_head" colspan="<?php echo $colspan_number+1;?>"> Количество </td>
				</tr>
				<tr>
					<?php mysqli_data_seek($query_pulpit2, 0); ?>
					<?php while($row_pulpit = mysqli_fetch_assoc($query_pulpit2)){ ?>
						<td class="stat_load-kaf_head" title="<?php echo $row_pulpit['name']?>"><?php echo $row_pulpit['name_mini']?></td>
					<?php } ?>
					<td class="stat_load-kaf_head">Всего</td>
				</tr>
			<?php
				$number_record = 1; 
				mysqli_data_seek($query_section, 0);
				while($row_section = mysqli_fetch_assoc($query_section)){ 
			?>
				<tr class="stat_load-kaf_tr">
					<td class="stat_load-kaf_id"> <?php echo $number_record++;?> </td>
					<td class="stat_load-kaf_name"><?php echo $row_section['name']?></td>
					<?php mysqli_data_seek($query_pulpit2, 0); ?>
					<?php while($row_pulpit = mysqli_fetch_assoc($query_pulpit2)){ ?>
					<td class="stat_load-kaf_number <?php echo ( $row_pulpit['id']==$_SESSION['skaf'] )?("green_bg"):""?>"><?php echo ($arr_section_kaf[ $row_pulpit['id'] ][ $row_section['id'] ]!=0)?($arr_section_kaf[ $row_pulpit['id'] ][ $row_section['id'] ]):(0)?></td>
					<?php } ?>
					<td class="stat_load-kaf_number-itogo"> <?php echo ($arr_section_number[ $row_section["id"] ]>=1)?($arr_section_number[ $row_section["id"] ]):"0" ?> </td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2" class="stat_load-kaf_number-itogo bold"> Всего: </td>
					<?php mysqli_data_seek($query_pulpit2, 0); ?>
					<?php while($row_kaf_filter = mysqli_fetch_assoc($query_pulpit2)){ ?>
					<td class="stat_load-kaf_number-itogo bold"> <?php echo ($arr_kaf_number[ $row_kaf_filter["id"] ]>=1)?($arr_kaf_number[ $row_kaf_filter["id"] ]):"0" ?> </td>
					<?php } ?>
					<td class="stat_load-kaf_number-itogo bold"> <?php echo $summa;?> </td>
				</tr>
			</table>
			<div class="clear"></div>
		</div>
	</div>
</section>