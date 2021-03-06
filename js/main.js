function get_info_file(el,id_user,otdel,section,subsection,change_doc,cancel_doc,changed,canceled){
	$.ajax({
		type: "POST",
		url: "/lna/execute/get_info_file.php",
		dataType: "json",
		data: "id_user="+id_user+"&otdel="+otdel+"&section="+section+"&subsection="+subsection+"&change_doc="+change_doc+"&cancel_doc="+cancel_doc+"&changed="+changed+"&canceled="+canceled,
		success: function(response){
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_login_class").html(response[0]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_kafedra_class").html(response[1]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_section_class").html(response[2]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_subsection_class").html(response[3]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_change_doc_class").html(response[4]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_cancel_doc_class").html(response[5]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_changed_class").html(response[6]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_canceled_class").html(response[7]);

			$(".link_file").click(function(){
				_str = $(this).attr("id")
				_id = _str.replace("q","");
				_link_str = "#rec-"+_id;
				_scroll_to_element = $(_link_str).offset().top;
				$(_link_str).click();
				$('html, body').animate({scrollTop:_scroll_to_element}, 'slow');
			});

			if(response[2]==null){
				$(".user_section_class").parent(".info_file_result").parent(".info_one_record").css({"display":"none"});
			} else {
				$(".user_section_class").parent(".info_file_result").parent(".info_one_record").css({"display":"table-row"});
			}
			if(response[3]==null){
				$(".user_subsection_class").parent(".info_file_result").parent(".info_one_record").css({"display":"none"});
			} else {
				$(".user_subsection_class").parent(".info_file_result").parent(".info_one_record").css({"display":"table-row"});
			}
		}
	});
}

function get_changed_file(number_document,date_document){
	$.ajax({
		type: "POST",
		url: "/lna/execute/get_changed_file.php",
		dataType: "json",
		data: "number_document="+number_document+"&date_document="+date_document,
		success: function(response){
			if(response[0]==0){
				$(".change_file_area-title").html("Документ в базе не найден!");
				$(".change_file_area-search").hide();
			} else {
				$("#change_file_area-table").css({"display":"table"});
				$(".change_file_area-submit").css({"display":"block"});
				$(".change_file_area-title").html("Документ найден и добавлен. Можно добавить ещё...");
				$(".change_file_area-search").hide();

				var _date = new Date(response[2]);
				var d_date = _date.getDate();
				var m_date = _date.getMonth() + 1;
				var y_date = _date.getFullYear();

				var tbody = document.getElementById('change_file_area-table').getElementsByTagName("TBODY")[0];
		    var row = document.createElement("TR");
		    row.className = 'row_record row_'+response[4];
		    row.setAttribute("title", response[4]);
		    var td1 = document.createElement("TD");
		    td1.appendChild(document.createTextNode("№"+response[3]+" от "+d_date+"."+m_date+"."+y_date));
		    var td2 = document.createElement("TD");
		    td2.appendChild (document.createTextNode(response[1]));
		    var td3 = document.createElement("TD");
				td3.innerHTML = "<a href='files/"+response[4]+"."+response[5]+"'><input type='button' value='Просмотр'></a> <input type='button' class='del_file' id='"+response[4]+"' value='Удалить'>";
		    row.appendChild(td1);
		    row.appendChild(td2);
		    row.appendChild(td3);
		    tbody.appendChild(row);
		    
		    $(".del_file").click(function(){
					_change_ids = "";
					row_id = ".row_"+$(this).attr("id");
					$(row_id).remove();
				});
			}
		}
	});
}

function get_cancel_file(number_document,date_document){
	$.ajax({
		type: "POST",
		url: "/lna/execute/get_changed_file.php",
		dataType: "json",
		data: "number_document="+number_document+"&date_document="+date_document,
		success: function(response){
			if(response[0]==0){
				$(".cancel_file_area-title").html("Документ в базе не найден!");
				$(".cancel_file_area-search").hide();
			} else {
				$("#cancel_file_area-table").css({"display":"table"});
				$(".cancel_file_area-submit").css({"display":"block"});
				$(".cancel_file_area-title").html("Документ найден и добавлен. Можно добавить ещё...");
				$(".cancel_file_area-search").hide();

				var _date = new Date(response[2]);
				var d_date = _date.getDate();
				var m_date = _date.getMonth() + 1;
				var y_date = _date.getFullYear();

				var tbody = document.getElementById('cancel_file_area-table').getElementsByTagName("TBODY")[0];
		    var row = document.createElement("TR");
		    row.className = 'cancel_record cancel_'+response[4];
		    row.setAttribute("title", response[4]);
		    var td1 = document.createElement("TD");
		    td1.appendChild(document.createTextNode("№"+response[3]+" от "+d_date+"."+m_date+"."+y_date));
		    var td2 = document.createElement("TD");
		    td2.appendChild (document.createTextNode(response[1]));
		    var td3 = document.createElement("TD");
				td3.innerHTML = "<a href='files/"+response[4]+"."+response[5]+"'><input type='button' value='Просмотр'></a> <input type='button' class='del_file' id='"+response[4]+"' value='Удалить'>";
		    row.appendChild(td1);
		    row.appendChild(td2);
		    row.appendChild(td3);
		    tbody.appendChild(row);
		    
		    $(".del_file").click(function(){
					_add_string = "";
					row_id = ".cancel_"+$(this).attr("id");
					$(row_id).remove();
				});
			}
		}
	});
}



$(document).ready(function(){
	$('input[placeholder], textarea[placeholder]').placeholder();
	$("#change_file_area-input_area-date,#cancel_file_area-input_area-date").datepicker({changeMonth:true,changeYear:true,dateFormat:'dd-mm-yy',showAnim:'clip'});
	$("#add_date_document").datepicker({changeMonth:true,changeYear:true,dateFormat:'yy-mm-dd',showAnim:'clip'});
	$("#lna_datepicker_start,#lna_datepicker_end,#edit_date_document").datepicker({changeMonth:true,changeYear:true,dateFormat:'dd.mm.yy',showAnim:'clip',minDate:"01.01.2015"});

	$(".autorization_button").click(function(){
		$(".darken").show();
		$(".autorization_area").fadeIn(200);
		$(".autoriz_login").focus();
	});
	
	$(".option_button").click(function(){
		$(".darken").show();
		$(".option_area").animate({'top':'20%'},200);
	});
	
	$(".darken, .edit_area_close, .delete_question-no").click(function(){
		$(".darken").fadeOut(200);
		$(".edit_area").animate({"left":"10%","opacity":"0"},300,function(){
			$(".edit_area").hide();
		});
		$(".delete_question").hide();
		$(".autorization_area").fadeOut(200);
		$(".change_file_area").fadeOut(200);
		$(".cancel_file_area").fadeOut(200);
	});
	
	/* Нажали на кнопку меню "Загрузить файл" */
	$(".load_button").click(function(){
		$(".section_add_file").show();
		$(".section_search").hide();
		$(".section_stat").hide();
		$(".section_logs").hide();
	});
	/* Нажали на кнопку меню "Поиск файлов" */
	$(".search_button").click(function(){
		$(".section_search").show();
		$(".section_add_file").hide();
		$(".section_stat").hide();
		$(".section_logs").hide();
	});
	/* Нажали на кнопку меню "Статистика" */
	$(".statistics_button").click(function(){
		$(".section_stat").show();
		$(".section_add_file").hide();
		$(".section_search").hide();
		$(".section_logs").hide();
	});
	/* Нажали на кнопку меню "Логи" */
	$(".logs_button").click(function(){
		$(".section_stat").hide();
		$(".section_add_file").hide();
		$(".section_search").hide();
		$(".section_logs").show();
	});
	
	/* Нажали на любую кнопку меню */
	$(".header_element").click(function(){
		$(".header_element").css({"color":"#565656"});
		$(this).css({"color":"#FEFEFD"});
	});
		
	$(".add_file_real").change(function(){
		if($(this).val()!='') {
			filename_string = new String( $(this).val() );

			if(filename_string[0]!="C"){
				// для FireFox
				name_file = filename_string.substr(0,filename_string.lastIndexOf("."));
				$(".add_file_name").val( name_file );
			} else {
				// для Google Chrome
				$(".add_file_beauty").val( filename_string );
				arr_file = filename_string.split("\\");
				name_file = arr_file[2].substr(0,arr_file[2].lastIndexOf("."));
				$(".add_file_name").val( name_file );
			}
			$(".add_file_beauty").val("Файл успешно выбран!");
		}
	});
	
	$(".add_file_facultet_s").change(function(){
		_class_name = ".podraz-"+$(this).val();
		if( $(this).val() == 0 || $(this).val()==1){
			$(".hide_show_table_add").hide(200);
		} else {
			$(".hide_show_table_add").show(200);
			$(".hide_show_table_add option").hide();
			$(_class_name).show();
			$('.hide_show_table_add select').each(function(){
				$(this).val("0");
			});
			$(".hide_show_table_add option[value='0']").show();
		}
	});

	$("#formAddFile").validate({
       rules:{
            input_number_document_name:{
                required: true,
                digits: true,
            },
            add_file_beauty:{
                required: true,
            },
            add_file_real:{
                required: true,
                accept: "pdf",
            },
            add_file_name:{
                required: true,
            },
            add_date_document:{
                required: true,
            },
       },

       messages:{
            input_number_document_name:{
                required: "",
								digits: "< Вводите только цифры",
            },
						add_file_beauty:{
                required: "",
            },
            add_file_real:{
                required: "",
                accept: ""
            },
            add_file_name:{
                required: "",
            },
            add_date_document:{
                required: "",
            },
       }
  });

$("#lnaReloadInfo").validate({
       rules:{
            edit_lna_number_name:{
                required: true,
                digits: true,
            },
            edit_lna_input_name:{
                required: true,
            },
            edit_lna_date_document:{
                required: true,
            },
       },

       messages:{
            edit_lna_number_name:{
                required: "",
								digits: "< Вводите только цифры",
            },
            edit_lna_input_name:{
                required: "",
            },
            edit_lna_date_document:{
                required: "",
            },
       }
  });

	$("#formAddFile").click(function(){
		if( $(".add_file_real").hasClass("error") ){
			$(".add_file_beauty").css({
				"border":"1px solid #FEFEFD",
				"background":"#fdd",
				"color":"#f00",
			});
			$(".add_file_beauty").val("Ошибка! Выберите PDF файл!");
		} else {
			$(".add_file_beauty").css({
				"border":"2px inset white",
				"background":"#fff",
				"color":"#0f0",
			});
		}
	});

	$(".send_file").click(function(){
		if( $(".add_file_real").hasClass("error") ){
			$(".add_file_beauty").val("Ошибка! Выберите PDF файл!");
		} else {
			$(".add_file_beauty").val("Файл успешно выбран!");
		}

	});

	$.validator.messages.required = "";
	
	$(".add_file_real").change(function (){
		filename_string = new String( $(this).val() );
		if(filename_string[0]!="C"){
			// для FireFox
			ras_file = filename_string.substr(filename_string.lastIndexOf(".")+1);
		} else {
			// для Google Chrome
			$(".add_file_beauty").val( filename_string );
			arr_file = filename_string.split("\\");
			ras_file = arr_file[2].substr(arr_file[2].lastIndexOf(".")+1);
		}

		if( ras_file == "pdf" ){
			$(".add_file_real").removeClass("error");
			$(".add_file_beauty").css({
				"border":"2px inset white",
				"background":"#fff",
				"color":"#0f0",
			});
			$(".add_file_beauty").val("Файл успешно выбран!");
		} else {
			$(".add_file_real").addClass("error");
			$(".add_file_beauty").css({
				"border":"1px solid #FEFEFD",
				"background":"#fdd",
				"color":"red",
			});
			$(".add_file_beauty").val("Ошибка! Выберите PDF файл!");
		}
	});
	
	//Скрипты для блока search
	$(".click-info").click(function(){
		rec_id = $(this).attr("id");
		var string_id = new String(rec_id);
		id = string_id.substr(4);
		info_id = "#info-"+id;

		if( $(info_id).is(":hidden") ){
			$(".info").hide();
			$(info_id).show();
		} else {
			$(info_id).hide();
		}
		
		id_user = $(info_id).children("td").children(".info_one_table").children("tbody").children("tr").children(".info_file_result").children(".user_login_class").attr("title");
		otdel = $(info_id).children("td").children(".info_one_table").children("tbody").children("tr").children(".info_file_result").children(".user_kafedra_class").attr("title");
		section = $(info_id).children("td").children(".info_one_table").children("tbody").children("tr").children(".info_file_result").children(".user_section_class").attr("title");
		change_doc = $(info_id).children("td").children(".info_one_table").children("tbody").children("tr").children(".info_file_result").children(".user_change_doc_class").attr("title");
		cancel_doc = $(info_id).children("td").children(".info_one_table").children("tbody").children("tr").children(".info_file_result").children(".user_cancel_doc_class").attr("title");
		changed = $(info_id).children("td").children(".info_one_table").children("tbody").children("tr").children(".info_file_result").children(".user_changed_class").attr("title");
		canceled = $(info_id).children("td").children(".info_one_table").children("tbody").children("tr").children(".info_file_result").children(".user_canceled_class").attr("title");
		if(!change_doc!=''){change_doc=0}
		if(!cancel_doc!=''){cancel_doc=0}
		if(!changed!=''){changed=0}
		if(!canceled!=''){canceled=0}


		if(section>1){
			subsection = $(info_id).children("td").children(".info_one_table").children("tbody").children("tr").children(".info_file_result").children(".user_subsection_class").attr("title");
		} else {
			subsection = -1;
		}
		get_info_file(info_id,id_user,otdel,section,subsection,change_doc,cancel_doc,changed,canceled);
	});
	
	$(".jpg_class").fancybox({
		openEffect  : 'fade',
		closeEffect : 'elastic'
	});
	$('.pdf_class').fancybox({
		openEffect  : 'none',
		closeEffect : 'none',
		type: "iframe",
		width: '90%',
		height: '100%',
		iframe : {
			preload: false
		}
	});
	
	$(".search_filter").click(function(){
		if( $(".filter_area").is(":hidden") ){
			$(".filter_area").show(400);
			$(".search_filter").css({"color":"#FEFEFD"});
		} else {
			$(".filter_area").hide(400);
			$(".search_filter").css({"color":"#565656"});
		}
	});
	
	$(".search_text").click(function(){
		$(".filter_area").show(400);
		$(".search_filter").css({"color":"#FEFEFD"});
	});
	
	$(".download_class").click(function(){
		id_file = $(this).attr("title");
		string_class_id = ".download_number_"+id_file;
		number_download = $(string_class_id).html()*1 + 1;
		$(string_class_id).html( number_download );
	});
		
	// При фильтрации показываем/скрываем 
	$(".filter_area_razdel").change(function(){
		if ( ($(this).val() != 0) && ($(this).val() != 1)){
			$(".search_podrazdel").show(200);
			_class_view = ".raz-"+$(this).val();
			$(".razdel-option").hide();
			$(".filter_area_podrazdel").val(0);
			$(_class_view).show();
		} else {
			$(".search_podrazdel").hide(200);
		}
	});

	$(".edit_class").click(function(){
		$(".darken").fadeIn(200);
		$(".edit_area").show();
		$(".edit_area").animate({"left":"25%","opacity":"1"},300);
		id_record = $(this).attr("title");
		id_name_file = "#rec-"+id_record;
		name_file = $(id_name_file).html();
		number_doc = parseInt( $(".number-"+id_record).html() ,10);
		l_s = $(".number-"+id_record).attr("ls");
		date_string = $(".date_doc_"+id_record).html();
		day = date_string[1]+date_string[2];
		month = date_string[4]+date_string[5];
		year = date_string[7]+date_string[8]+date_string[9]+date_string[10];
		final_date = day+"."+month+"."+year;
		section = $("#user_section_id_"+id_record).attr("title");
		if( section>0 ){
			$(".edit_record_subsection").css({"display":"table-row"});
		} else {
			$(".edit_record_subsection").css({"display":"none"});
		}
		subsection = $("#user_subsection_id_"+id_record).attr("title");
		keywords = $("#user_key_id_"+id_record).html();
		executor = $("#user_executor_id_"+id_record).html();

		$(".edit_area_input_name").val( name_file );
		$(".edit_number").val( number_doc );
		if(l_s=='on'){
			$(".edit_L_S").attr("checked","checked");
		} else {
			$(".edit_L_S").attr("checked","");
		}
		$("#edit_date_document").val( final_date );
		$(".edit_area_select_section").val( section );
		$(".edit_razdel-option").hide();
		$(".edit_podraz-"+section).show();
		$(".edit_area_select_subsection").val( subsection );
		$(".edit_area_input_key").val( keywords );
		$(".edit_area_input_executor").val( executor );
		$("#lna_id_record").val( id_record );
	});

	$(".edit_area_select_section").change(function(){
		if( $(this).val()>1 ){
			$(".edit_record_subsection").css({"display":"table-row"});
		} else {
			$(".edit_record_subsection").css({"display":"none"});
		}
		$(".edit_area_select_subsection").val( 0 );
		$(".edit_razdel-option").hide();
		$(".edit_podraz-"+$(this).val()).show();
	});

	$(".delete_class").click(function(){
		$(".darken").show();
		$(".delete_question").show();
	});

	if( $(".exact_date").attr("checked") == true){
		$("#lna_datepicker_end").hide();
		$("#lna_datepicker_start").attr({"placeholder":"Точная дата"});
	}

	$(".exact_date").click(function(){
		if( $(this).attr("checked") == true){
			$("#lna_datepicker_end").hide(200);
			$("#lna_datepicker_start").attr({"placeholder":"Точная дата"});
		} else {
			$("#lna_datepicker_end").show(200);
			$("#lna_datepicker_start").attr({"placeholder":"Начальная дата"});
		}
	});

	$(".change_file").click(function(){
		$(".darken").fadeIn(200);
		$(".change_file_area").fadeIn(200);
		$("#change_file_area-input_area-number").focus();
	});

	$(".close_file").click(function(){
		$(".darken").fadeIn(200);
		$(".cancel_file_area").fadeIn(200);
		$("#cancel_file_area-input_area-number").focus();
	});

	$("#change_file_area-input_area-number").keyup(function(){
		if( $("#change_file_area-input_area-number").val() != '' && $("#change_file_area-input_area-date").val() != '' ){
			$(".change_file_area-search").css({"display":"block"});
		} else {
			$(".change_file_area-search").css({"display":"none"});
		}
	});
	$("#cancel_file_area-input_area-number").keyup(function(){
		if( $("#cancel_file_area-input_area-number").val() != '' && $("#cancel_file_area-input_area-date").val() != '' ){
			$(".cancel_file_area-search").css({"display":"block"});
		} else {
			$(".cancel_file_area-search").css({"display":"none"});
		}
	});


	$("#change_file_area-input_area-date").change(function(){
		if( $("#change_file_area-input_area-number").val() != '' && $("#change_file_area-input_area-date").val() != '' ){
			$(".change_file_area-search").css({"display":"block"});
		} else {
			$(".change_file_area-search").css({"display":"none"});
		}
	});
	$("#cancel_file_area-input_area-date").change(function(){
		if( $("#cancel_file_area-input_area-number").val() != '' && $("#cancel_file_area-input_area-date").val() != '' ){
			$(".cancel_file_area-search").css({"display":"block"});
		} else {
			$(".cancel_file_area-search").css({"display":"none"});
		}
	});

	$(".change_file_area-search").click(function(){
		$(".change_file_area-title").html("Ищу документ в базе. Подождите...");
		number_document = $("#change_file_area-input_area-number").val();
		date_document = $("#change_file_area-input_area-date").val();
		get_changed_file(number_document,date_document);
		$("#change_file_area-input_area-number").val("");
		$("#change_file_area-input_area-date").val("");
	});

	$(".cancel_file_area-search").click(function(){
		$(".cancel_file_area-title").html("Ищу документ в базе. Подождите...");
		number_cancel = $("#cancel_file_area-input_area-number").val();
		date_cancel = $("#cancel_file_area-input_area-date").val();
		get_cancel_file(number_cancel,date_cancel);
		$("#cancel_file_area-input_area-number").val("");
		$("#cancel_file_area-input_area-date").val("");
	});
	
	$(".change_file_area-submit").click(function(){
		_add_string = "";
		_change_ids = "";
		
		$(".change_file").html("");
		$(".darken").hide();
		$(".change_file_area").hide();
			
		$(".row_record").each(function(){
			_w = $(this).find('td').html();
			_add_string+= _w+" <br>";
		});
		$(".change_file").html(_add_string);

		$(".row_record").each(function(){
			_id_change = $(this).attr("title");
			_change_ids+= "("+_id_change+")";
		});
		$(".change_file_ids").val(_change_ids);
	});

	$(".cancel_file_area-submit").click(function(){
		_add_string = "";
		_cancel_string = "";
		$(".close_file").html("");
		$(".darken").hide();
		$(".cancel_file_area").hide();
			
		$(".cancel_record").each(function(){
			_w = $(this).find('td').html();
			_add_string+= _w+" <br>";
		});
		$(".close_file").html(_add_string);

		$(".cancel_record").each(function(){
			_id_cancel = $(this).attr("title");
			_cancel_string+= "("+_id_cancel+")";
		});
		$(".cancel_file_ids").val(_cancel_string);
	});

});