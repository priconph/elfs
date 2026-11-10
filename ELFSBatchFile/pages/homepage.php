<?php
	require_once("elfs_oop.php");
	
	$result = ELFS::getInstance()->getEmpInfo($EmpNo);
		while($rowEmpInfo = mysqli_fetch_array($result)){
		 $pkid	 			= $rowEmpInfo['pkid'];
		 $fkEmployee	 	= $rowEmpInfo['pkid'];
		 $empName 			= $rowEmpInfo['FirstName'] . " " .$rowEmpInfo['LastName'];
		 $department 		=  $rowEmpInfo['Department'];
		 $Division 			=  $rowEmpInfo['Division'];
		 $SalaryType 		=  $rowEmpInfo['SalaryType'];
	}
?>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-6">
					<span class="fa fa-users"></span> Batch Leave Application
				</div>
			</div>
		</div>
			<div class="panel-body">
				<div class="row" id="system_message">
				</div>
				<div class="row">
					<div class="col-sm-12">
						<legend><h3><span class="fa fa-user"> Employee Information</h3></legend>
					</div>
					<div class="col-sm-6">
					<input type="hidden" id="txt_username" name="txt_username" value="<?php echo $username; ?>"> 
					<input type="hidden" id="fkEmployee" name="fkEmployee" value="<?php echo $fkEmployee; ?>"> 
					<input type="hidden" id="txt_EmpNo" name="txt_EmpNo" value="<?php echo $EmpNo; ?>"> 

						<div class="row">
							<div class="col-sm-4">Date Created</div>
							<div class="col-sm-8"><input type="text" class="form-control" id="txt-date_created" value="<?php echo date("Y-m-d") ; ?>"  readonly></div>
						</div>
						<div class="row">
							<div class="col-sm-4">FullName</div>
							<div class="col-sm-8"><input type="text" class="form-control" id="txt-FullName" readonly></div>
						</div>
						<div class="row">
							<div class="col-sm-4">EmpNo</div>
							<div class="col-sm-8"><input type="text" class="form-control" id="txt-EmpNo" readonly></div>
						</div>
						<div class="row">
							<div class="col-sm-4">Division</div>
							<div class="col-sm-8"><input type="text" class="form-control" id="txt-Division" readonly></div>
						</div>
						<div class="row">
							<div class="col-sm-4">Department Head</div>
							<?php
								echo "<div class='col-sm-8'>"; 
								echo "<select id='bth_approver' name='bth_approver' style='width:349px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Department Head...' required>"; 
									$result = ELFS::getInstance()->getApproverList($username);
									while($row = mysqli_fetch_array($result)){
										$get_emp_info = ELFS::getInstance()->getEmpName($row['approver_username']);
										if($row_emp_info = mysqli_fetch_array($get_emp_info)) {
											echo "<option value='".$row['approver_username']."'>".$row_emp_info['FirstName']." ".$row_emp_info['LastName']."</option>";
										}
									}
								echo "</select>";						
								echo "</div>";						
							?>
						<!--	<div class="col-sm-8"><input type="text" class="form-control" id="txt-Department" readonly></div> -->
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-4"></div>
							<div class="col-sm-8"><input type="radio" id="rbtn_wd" name="day_type" value="0"><b>&nbsp;&nbsp;&nbsp;&nbsp;WHOLE DAY</b></div>
						</div>
						<div class="row">
							<div class="col-sm-4"></div>
							<div class="col-sm-8"><input type="radio" id="rbtn_hd" name="day_type" value="1"><b>&nbsp;&nbsp;&nbsp;&nbsp;HALF DAY</b></div>
						</div>
						<div class="row">
							<div class="col-sm-4">Date Absent</div>
							<div class="col-sm-8"><input type="hidden" class="form-control"readonly></div>
						</div>
						<div class="row">
							<div class="col-sm-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From</div>
							<div class="col-sm-8"><input type="text" class="form-control" id="txt-date_from" readonly></div>
						</div>
						<div class="row">
							<div class="col-sm-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To</div>
							<div class="col-sm-8"><input type="text" class="form-control" id="txt-date_to" readonly></div>
						</div>
						<div class="row">
							<div class="col-sm-4">No of Days</div>
							<div class="col-sm-4"><input type="text" class="form-control" id="txt-no_of_days" readonly></div>
						</div>
					
						<div class="row">
							<div class="col-sm-4">Reason</div>
							<div class="col-sm-8">
								<select id="bth_reason" name="bth_reason" class="form-control" required>	
									<option value="">--Select--</option>
									<option value="Special Holiday">Special Holiday</option>
									<option value="Shut-Down">Shut-Down</option>
								</select> 							
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4"></div>
							<div class="col-sm-8">
							<input type="hidden" class="form-control" id="bth_leave_applied" name="bth_leave_applied" value="0" readonly>
						</div>
						</div>
						
					</div>
				</div><br />
				<div class="row">
					<div class="col-sm-12">
						<legend><h3><span class="fa fa-users"> Employee Information</h3></legend>
					</div>
					<div class="col-sm-12">
						<p style="text-align:right;">
							<button type="button" class="btn btn-primary fa fa-user-plus" id="btn-add_subordinate_modal"> Add Employee</button>
							<button type="button" class="btn btn-danger fa fa-user-times" id="btn-remove_subordinate_modal"> Remove Employee</button>
						</p>
					</div>
				</div><br>
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered" id="tbl_subordinate">
							<thead>
								<th></th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_subordinate">
  <div class="modal-dialog" role="document" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-user-plus"></span> Add Employee</h4>
      </div>
      <div class="modal-body">
		<div class="error_message">
		</div>
		<div class="row" id="system_message">
			<!--<div class="alert alert-danger">
			</div>-->
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-bordered" id="tbl_employee_list">
					<thead>
						<th></th>
						<th>Employee #</th>
						<th>Employee Name</th>
						<th>Division</th>
						<th>Department</th>
						<th>Section</th>	
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save_subordinate">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_remove_subordinate">
  <div class="modal-dialog" role="document" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-user-times"></span> Remove Employee</h4>
      </div>
      <div class="modal-body">
		<div class="row" id="system_message">
			<div class="alert alert-danger"><h4>Warning: The following employees will be removed from batch filling.</h4></div>
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
		"sAjaxSource": "server_side_scripts/subordinate_list.php?SectionHead=" + empno
	} );
	load_employee_information(empno);
});

/* Check Session */
check_session(function(result){
	if(result == 1){
		alert('SESSION HAS BEEN EXPIRED! PLEASE RELOGIN!');
	}
	return false;
});

/* Events */
$('#btn-save_subordinate').click(function(){ save_subordinate(); });
$('#btn-remove_subordinate').click(function(){ remove_subordinate(); });
$('#btn-add_subordinate_modal').click(function(){ $('#modal_add_subordinate').modal('show'); });

$('#btn-users_manual').click(function(){  
	window.location.href = "pages/download_user_manual.php";
});

$('#btn-remove_subordinate_modal').click(function(){ 
	if( array_subordinate.length == 0 ){
		var message  = '<div class="alert alert-danger">';
			message += ' <center><h3>There are no record selected!</h3></center>';
			message += '</div>';
		system_message_modal(message);
	}
	subordinate_for_removal();
	$('#modal_remove_subordinate').modal('show');
	return false;
});

/* Subordinate List */
$('#tbl_subordinate tbody').on('click','tr .checkbox', function(){
	var prop_state = get_checkbox_state( $(this) );
	var empno = $(this).closest('tr').find('td:eq(1)').text();
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

/* Employee List */
$('#tbl_employee_list tbody').on('click','tr .checkbox', function(){
	var prop_state = get_checkbox_state( $(this) );
	var empno = $(this).closest('tr').find('td:eq(1)').text();
	if(prop_state){
		var exist = check_exist_array(empno,array_empno);
		if(exist){
			array_empno.push(empno);
		}		
		console.log(array_empno);
	}else{
		array_empno = remove_to_array(empno,array_empno);
		console.log(array_empno);
	}
});

/* Functions */
function load_employee_information(empno){
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: "action=load_employee_information&empno="+empno,
		url		: handler,
		success	: function(result){
			$('#txt-EmpNo').val(result['EmpNo']);
			$('#txt-FullName').val(result['FullName']);
			$('#txt-Division').val(result['Division']);
			$('#txt-Section').val(result['Section']);
			$('#txt-Department').val(result['Department']);
			$('#txt-Position').val(result['Position']);
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

function save_subordinate(){
	/* Check Session */
	check_session(function(result){
		if(result == 1){
			alert('SESSION HAS BEEN EXPIRED! PLEASE RELOGIN!');
		}
		return false;
	});
	if( array_empno.length == 0 ){
		var message  = '<div class="alert alert-danger">';
			message += ' <center><h3>There are no record selected!</h3></center>';
			message += '</div>';
		system_message_modal(message);
		return false;
	}
	var data = {
		"action"		: "save_subordinate", 
		"user_empno"	: empno,
		"array_empno"	: array_empno
	}
	data = $.param(data);
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(result){
			if(result['exist'] == '1'){
				system_message_modal(result['message']);
			}else{
				var message  = '<div class="alert alert-success">';
				message += ' <center><h3>New list of employee has been added to your subordinate!</h3></center>';
				message += '</div>';
				system_message_modal(message);
				tbl_subordinate.ajax.reload();
				tbl_emp_selection.ajax.reload();
				array_empno = [];
				array_subordinate = [];
				console.log(array_subordinate);
			}
		},error	: function(){
			alert('error handler');
		}
	});
}

function subordinate_for_removal(){
	var data = {
		"action"		: "subordinate_for_removal",
		"SectionHead"	: empno,
		"array_empno"	: array_subordinate
	}
	data = $.param(data);
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(result){
			$('#modal_remove_subordinate .modal-body .content').empty();
			$('#modal_remove_subordinate .modal-body .content').append(result['html']);
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
			$('#modal_remove_subordinate .modal-body .content').empty();
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

	
/* New leave datepicker */
	$("input[name='day_type']").click(function() {
		day_type = this.value;
		var dateFrom = $('#txt-date_from');
		var dateTo = $('#txt-date_to');
		
	if ($("input[name='day_type']:checked").val() == 0 ){ //WHOLE DAY
		$("input[id='txt-date_from']").prop("disabled", false);
		$("input[id='txt-date_to']").prop("disabled", false);
		$('#txt-date_from').val('');
		$('#txt-date_to').val('');
		$('#txt-no_of_days').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({ 
		// minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
	});
	 
	dateTo.datepicker('destroy');
	dateTo.datepicker( { 
		// minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
		
	onSelect: function (dateStr){
		var start = $("#txt-date_from").datepicker("getDate");
		var end = $("#txt-date_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		$("#txt-no_of_days").val(diff);
		}
	});
		
	} else if ($("input[name='day_type']:checked").val() == 1 ){ //HALF DAY
		$("input[id='txt-date_from']").prop("disabled", false);
		$("input[id='txt-date_to']").prop("disabled", false);
		$('#txt-date_from').val('');
		$('#txt-date_to').val('');
		$('#txt-no_of_days').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({ 
		// minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
	});
	 
	dateTo.datepicker('destroy');
	dateTo.datepicker( { 
		// minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
		
	onSelect: function (dateStr){
		var start = $("#txt-date_from").datepicker("getDate");
		var end = $("#txt-date_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		
		var half = diff / 2;
		$("#txt-no_of_days").val(half);
		
		}
	});
		
	}
		
	//Function for Calculate days
	function calcBusinessDays(start, end) {
			var start = new Date(start);
			var end = new Date(end);
			
			var totalBusinessDays = 0;
				
			start.setHours(0,0,0,0);
			end.setHours(0,0,0,0);
			
			var current = new Date(start);
			current.setDate(current.getDate() + 0);
			var day;
			while (current <= end) {
				day = current.getDay();
				if (day >= 1 && day <= 6) {
					++totalBusinessDays;
				}
				current.setDate(current.getDate() + 1);
			}
			return totalBusinessDays;
	}
	
	}); //End function
	
	//Save and Send Leave
	$('#btn_send_batch_leave').click(function(e){
		if($('#bth_approver').val() == '') {
			$('#alert_msg').show();
            $('#alert_msg').append('*** Please select your Department Head. ***<br>');
        } else if($('#txt-date_from').val() == '') { 
			$('#alert_msg').show();
            $('#alert_msg').append('*** Please select your Date absent from. ***<br>');
		} else if($('#txt_date_to').val() == '') { 
			$('#alert_msg').show();
            $('#alert_msg').append('*** Please select your Date absent to. ***<br>');
		} else if($('#bth_reason').val() == '') { 
			$('#alert_msg').show();
            $('#alert_msg').append('*** Please select your Reason. ***<br>');
		} else {
			$('#alert_msg').hide();
			
		if(confirm($(this).data('confirm'))){
			e.preventDefault();
		} else {
			return false;
		}	
			
		var data = {
			"action"			 : 'save_leave_batch',
			"fkEmployee"		 : $('#fkEmployee').val(),
			"status"			 : '0',
			"date_created"		 : $('#txt_date_created').val(),
			"empName"			 : $('#txt_username').val(),
			"EmpNo"				 : $('#txt-EmpNo').val(),
			"Division"		 	 : $('#txt-Division').val(),
			"leave_applied"		 : $('#bth_leave_applied').val(),
			"reason"			 : $('#bth_reason').val(),
			"approver"			 : $('#bth_approver').val(),
			"username"			 : "<?php echo $username; ?>"
		}
		
	data = $.param(data);
	alert(data);
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		data	: data,
		url		: 'elfs_handler.php',
		success	: function(data){	
			
			alert("Batch Leave Application has been added!");
			window.location.href = "home_page.php";
			
		},error(data){
			alert('ERROR MAIN');
		}
	});
	}
	});	
	
</script>