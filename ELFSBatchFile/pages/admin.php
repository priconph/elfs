<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-6">
					<span class="fa fa-users"></span> Subordinate Management System - (ADMIN)
				</div>
				<div class="col-sm-6">
					<p style="text-align:right;">
						<!--<button type="button" class="btn btn-success fa fa-book" id="btn-users_manual"> Users Manual</button>-->
					</p>
				</div>
			</div>
		</div>
			<div class="panel-body">
				<div class="row" id="system_message">
				</div>
				<div class="row">
					<div class="col-sm-12">
						<legend><h3><span class="fa fa-users"> Subordinate Information</h3></legend>
					</div>
					<div class="col-sm-12">
						<p style="text-align:right;">
							<button type="button" class="btn btn-primary fa fa-edit" id="btn-edit_superior_modal"> Edit Superior</button>
						</p>
					</div>
				</div><br>
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered" id="tbl_subordinate">
							<thead>
								<th></th>
								<th>Superior</th>
								<th>Employee #</th>
								<th>Employee Name</th>
								<th>Division</th>
								<th>Department</th>
								<th>Section</th>							
								<th>Position</th>							
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--modals-->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_superior">
  <div class="modal-dialog" role="document" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-edit"></span> Edit Superior</h4>
      </div>
      <div class="modal-body">
		<div class="error_message">
		</div>
		<div class="row" id="system_message">

		</div>
		<div class="row">
			<div class="col-sm-3" style="padding-top:30px;">
				<b>Select New Superior:</b>
			</div>
			<div class="col-sm-4">
				<label>Employee #</label>
				<p style="text-align:right;">
					<select id="txt-chosen_empno" class="chosen-select"></select>
				</p>
			</div>
			<div class="col-sm-4">
				<label>Employee Name</label>
				<p style="text-align:right;">
					<select id="txt-chosen_empname" class="chosen-select"></select>
				</p>
			</div>
			<div class="col-sm-1" style="padding-top:25px;">
				<button class="btn btn-danger fa fa-eraser" id="btn-clear_chosen"></button>
			</div>
		</div><br />
		<div class="row">
			<div class="col-sm-12 content">
				<table class="table table-bordered" id="tbl_employee_for_edit">
					<thead>
						<th>Superior</th>
						<th>Employee #</th>
						<th>Employee Name</th>
						<th>Division</th>
						<th>Department</th>
						<th>Section</th>	
						<th>Position</th>	
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-update_superior">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_remove_subordinate">
  <div class="modal-dialog" role="document" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-user-times"></span> Remove Subordinate</h4>
      </div>
      <div class="modal-body">
		<div class="row" id="system_message">
			<div class="alert alert-danger"><h4>Warning: The following employees will be removed as your subordinate.</h4></div>
		</div>
		<div class="content">
		</div>		
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-remove_subordinate">Proceed</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--end modals-->
<script>
var handler = 'handler/handler.php';
var array_empno = [];
var array_subordinate = [];
var username = $('#txt_hd_id').val();
var empno = '';

/* Datatables serverside configuration */
var tbl_emp_selection = $('#tbl_employee_list').DataTable( {
	"sAjaxSource": "server_side_scripts/employee_list.php"
} );

var tbl_subordinate = '';

/* Get Empno */
get_empno(username,function(result){
	tbl_subordinate = $('#tbl_subordinate').DataTable( {
		"sAjaxSource": "server_side_scripts/subordinate_list_admin.php"
	} );
	// load_employee_information(empno);
});

/* Check Session */
check_session(function(result){
	if(result == 1){
		alert('SESSION HAS BEEN EXPIRED! PLEASE RELOGIN!');
	}
	return false;
});

/* Events */
$('#btn-edit_superior_modal').click(function(){ 
	subordinate_for_edit();
	$('#modal_edit_superior').modal('show'); 
});

$('#btn-update_superior').click(function(){
	update_superior();
});

$('#txt-chosen_empno').change(function(){
	get_fullname_chosen($(this).val(), function(FullName){
		$('#txt-chosen_empname').val(FullName).trigger('chosen:updated');
	});
});

$('#txt-chosen_empname').change(function(){
	get_empno_chosen($(this).val(), function(EmpNo){
		$('#txt-chosen_empno').val(EmpNo).trigger('chosen:updated');
	});
});

$('#btn-clear_chosen').click(function(){
	$('.chosen-select').val('').trigger('chosen:updated');
});

// ''$('#btn-users_manual').click(function(){  
	// window.location.href = "pages/download_user_manual.php";
// });

/* Subordinate List */
$('#tbl_subordinate tbody').on('click','tr .checkbox', function(){
	var prop_state = get_checkbox_state( $(this) );
	var empno = $(this).closest('tr').find('td:eq(2)').text();
	if(prop_state){
		var exist = check_exist_array(empno,array_subordinate);
		if(exist){
			array_subordinate.push(empno);
		}		
		console.log(array_subordinate);
	}else{
		array_subordinate = remove_to_array(empno,array_subordinate);
		console.log(array_subordinate);
	}
});

/* Functions */
populate_chosen_dropdown('txt-chosen_empno','empno');
populate_chosen_dropdown('txt-chosen_empname','name');

function populate_chosen_dropdown(chosen_id,list){
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: "action=populate_chosen_dropdown&list="+list,
		url		: "handler/handler.php",
		success	: function(result){
			$('#'+chosen_id).empty();
			$('#'+chosen_id).append( '<option> - SELECT - </option>' );
			$('#'+chosen_id).append( result['html'] );
			$('.chosen-select#'+chosen_id).chosen({width:"100%", height: "100%"});
			$('#'+chosen_id).val('').trigger('chosen:updated');
		},error	: function(){
			alert('error handler');
		}
	});
}

function get_empno(username,callback){
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: "action=get_empno&username="+username,
		url		: handler,
		success	: function(result){
			empno = result['EmpNo'];
			callback();
		},error	: function(){
			alert('error handler');
		}
	});
}

function get_empno_chosen(fullname,callback){
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: "action=get_empno_chosen&fullname="+fullname,
		url		: handler,
		success	: function(result){
			callback(result['EmpNo']);
		},error	: function(){
			alert('error handler');
		}
	});
}

function get_fullname_chosen(empno,callback){
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: "action=get_fullname_chosen&empno="+empno,
		url		: handler,
		success	: function(result){
			callback(result['FullName']);
		},error	: function(){
			alert('error handler');
		}
	});
}

function change_page(page){
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: "action=encode&page="+page,
		url		: handler,
		success	: function(result){
			window.location.href = "index.php?param="+result;
		},error	: function(){
			alert('error handler');
		}
	});
}

function get_checkbox_state(checkbox){
	if( checkbox.prop('checked') == true ){
		return true;
	}else{
		return false;
	}
}

function check_exist_array(str,array){
	if( jQuery.inArray(str,array)){
		return true;
	}
	return false;
}

function remove_to_array(str,array){
	array = jQuery.grep(array, function(value) {
	  return value != str;
	});
	return array;
}

function update_superior(){
	/* Check Session */
	check_session(function(result){
		if(result == 1){
			alert('SESSION HAS BEEN EXPIRED! PLEASE RELOGIN!');
		}
		return false;
	});
	if( array_subordinate.length == 0 ){
		var message  = '<div class="alert alert-danger">';
			message += ' <center><h3>There are no record selected!</h3></center>';
			message += '</div>';
		system_message_modal(message);
		return false;
	}
	var data = {
		"action"			: "update_superior", 
		"superior"			: $('#txt-chosen_empno').val(),
		"array_subordinate"	: array_subordinate
	}
	data = $.param(data);
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(result){
			var message  = '<div class="alert alert-success">';
				message += ' <center><h3>Superior has been updated!</h3></center>';
				message += '</div>';
			system_message_modal(message);
			tbl_subordinate.ajax.reload();
			array_subordinate = [];
			$('#modal_edit_superior .modal-body .content').empty();
		},error	: function(){
			alert('error handler');
		}
	});
}

function subordinate_for_edit(){
	var data = {
		"action"		: "subordinate_for_edit",
		"array_empno"	: array_subordinate
	}
	data = $.param(data);
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(result){
			$('#modal_edit_superior .modal-body .content').empty();
			$('#modal_edit_superior .modal-body .content').append(result['html']);
		},error	: function(){
			alert('error handler');
		}
	});
}

function remove_subordinate(){
	/* Check Session */
	check_session(function(result){
		if(result == 1){
			alert('SESSION HAS BEEN EXPIRED! PLEASE RELOGIN!');
		}
		return false;
	});
	var data = {
		"action"		: "remove_subordinate", 
		"SectionHead"	: empno,
		"array_empno"	: array_subordinate
	}
	data = $.param(data);
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(result){
			var message  = '<div class="alert alert-success">';
				message += ' <center><h3>The following employee has been removed from your subordinate!</h3></center>';
				message += '</div>';
			system_message_modal(message);
			tbl_subordinate.ajax.reload();
			tbl_emp_selection.ajax.reload();
			array_subordinate = [];
			array_empno = [];
			console.log(array_subordinate);
		},error	: function(){
			alert('error handler');
		}
	});
}

function check_session(callback){
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: "action=check_session",
		url		: handler,
		success	: function(result){
			callback(result['session_expired']);
		},error	: function(){
			alert('error handler');
		}
	});
}

function system_message_modal(message){
	$('.modal #system_message').empty();
	$('.modal #system_message').append(message);
	/* display message for 1 sec */
	setTimeout(function(){
	  $('.modal #system_message .alert').toggle(1000);
	}, 1500);
}

function encode_base64(str,callback){
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: "action=encode&param="+str,
		url		: handler,
		success	: function(result){
			callback(result['param']);
		},error	: function(){
			alert('error handler');
		}
	});
}
</script>