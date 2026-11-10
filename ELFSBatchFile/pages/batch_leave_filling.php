<?php
	require_once("elfs_oop.php");
	session_start();

	$username = $_SESSION['username'];
	// $username = 'jcfeliciano';
	
	$result = ELFS::getInstance()->getEmpNo($username);
		while($row = mysqli_fetch_array($result)){
		$EmpNo = $row['EmpNo'];
	} 

	$result = ELFS::getInstance()->getEmpInfo($EmpNo);
		while($rowEmpInfo = mysqli_fetch_array($result)){
		 $pkid	 			= $rowEmpInfo['pkid'];
		 $fkEmployee	 	= $rowEmpInfo['pkid'];
		 $empName 			= $rowEmpInfo['FirstName'] . " " .$rowEmpInfo['LastName'];
		 $department 		=  $rowEmpInfo['Department'];
		 $Division 			=  $rowEmpInfo['Division'];
		 $CityAddress1 		=  $rowEmpInfo['CityAddress1'];
		 $CityAddress2 		=  $rowEmpInfo['CityAddress2'];
		 $CityAddress3 		=  $rowEmpInfo['CityAddress3'];
		 $SalaryType 		=  $rowEmpInfo['SalaryType'];
	}
?>
<html>
<head>
	<script src="dist/js/bootstrap-select.js"></script>
	<link rel="stylesheet" href="dist/css/bootstrap-select.css">
<style>
	h4 { 
		display: block;
		font-size: 1.3em;
		font-family: Euphemia;
		color: #36747a;
		margin-top: 0;
		margin-bottom: 0;
		margin-left: 0;
		margin-right: 0;
		font-weight: bold;
	}

	.modal-body {
		max-height: calc(110vh - 210px);
		overflow-y: auto;
	}

	.FormBatchLabel{
		width:30%;
		margin-left:2%;
		font-size: 14px;
	}
	
	.FormBatchText{
		margin-bottom:4px;
		width:5%;
		font-size: 14px;
	}			
</style>
</head>

<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>

<div class="panel panel-primary" style="margin:auto; width:80%;">
	<div class="panel-heading">EMPLOYEE BATCH LEAVE</div>
	<div class="panel-body">

	<form action="#"> 
		<center><div id="alert_msg" style="display:none;color:white;font-size: 14px;text-align:center;width:100%" class="row alert alert-danger"></div></center>
					<input type="hidden" id="txt_username" name="txt_username" value="<?php echo $username; ?>"> 
					<input type="hidden" id="txt_EmpNo" name="txt_EmpNo" value="<?php echo $EmpNo; ?>"> 
					<input type="hidden" id="fkEmployee" name="fkEmployee" value="<?php echo $fkEmployee; ?>"> 
					<input type="hidden" id="SalaryType" name="SalaryType" value="<?php echo $SalaryType; ?>"> 

			<div class="row">
				<div class="col-sm-6">	
					
					<br>
					<label class="FormBatchLabel">Date Created:</label>
					<input type="date" style="width:220px; height:5%;" class="FormBatchText" id="date_created" name="date_created" value="<?php echo date("Y-m-d") ; ?>" readonly>	
					<br>
					<label class="FormBatchLabel">Requested by:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="txt-FullName" name="txt-FullName" readonly>
					<br>
					<label class="FormBatchLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="EmpNo" name="EmpNo" readonly>
					<br>
					<label class="FormBatchLabel">Division:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="Division" name="Division" readonly>	
					<br>
					<label class="FormBatchLabel" for="approver2">Dept. Head:</label>
						<?php
						echo "<select id='approver2' name='approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true'>"; 
							$result = ELFS::getInstance()->getApproverList($username);
									echo "<option value=''></option>";
							while($row = mysqli_fetch_array($result)){
								$get_emp_info = ELFS::getInstance()->getEmpName($row['approver_username']);
								if($row_emp_info = mysqli_fetch_array($get_emp_info)) {
									echo "<option value='".$row['approver_username']."'>".$row_emp_info['FirstName']." ".$row_emp_info['LastName']."</option>";
								}
							}
						echo "</select>";						
						?>
					<br>		
				</div>	
				
				<div class="col-sm-6">
					<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="rbtn_wd" name="day_type" value="0"><b>&nbsp;&nbsp;WHOLE DAY</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="rbtn_hd" name="day_type" value="1"><b>&nbsp;&nbsp;HALF DAY</b>
					<br>
					<br>
					
					<label class="FormBatchLabel">Date Absent:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText">
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="date_absent_from" name="date_absent_from" autocomplete="off" readonly>
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="date_absent_to" name="date_absent_to" autocomplete="off" readonly> 
					<br>
					<label class="FormBatchLabel">No. of days:</label>
					<input type="text" style="width:50px; height:5%;" class="FormBatchText" id="no_of_days" name="no_of_days" readonly>
					<br>
					<label class="FormBatchLabel">Reason/s:</label>
					<select id="reason" name="reason" style="width:220px; height:5%;" class="FormBatchText" required>	
						<option value="">--Select--</option>
						<option value="Special Holiday">Special Holiday</option>
						<option value="Shut-Down">Shut-Down</option>
					</select> 
					<br>
					<label class="FormBatchLabel"></label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText" id="leave_applied" name="leave_applied" value="1" Placeholder="Vacation Leave" readonly>	
					<br>
				</div>
				
				<table style="text-align:right; width: 100%;">
					<tr>
						<td>
							<form class="form-inline" role="form" method="POST" action="">
								<button type="button" class="btn btn-primary" id="btn-add_subordinate_modal"> Add Employee</button>
								<button type="button" class="btn btn-danger" id="btn-remove_subordinate_modal"> Remove Employee</button>
								<br>
								<br>
							</form>
						</td>
					</tr>
				</table>
			
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
				
			</div><!-- end row -->
			<div class="modal-footer">
				<button type="submit" id="btn_save_batch_leave" data-confirm="Are you sure you want to save this leave?" class="btn btn-success">SAVE</button>
				<!--<button type="submit" id="btn_send_batch_leave" data-confirm="Are you sure you want to file this batch leave?" class="btn btn-success">SAVE&SEND </button> -->
				<a href="batch_leave_summary.php"> <button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button></a>
			</div>
			</form>	
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
			<div class="alert alert-danger"><h4>Warning: The following employees will be removed from batch leave.</h4></div>
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
</body>

<script type="text/javascript">
/////////////////////////// BATCH LEAVE ///////////////////////////////
// btn_save_batch_leave
$('#btn_save_batch_leave').click(function(e){ //  Leave Application (SAVE AS DRAFT) 	
	if($('#approver2').val() == '') {
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your Department Head!<br>');
	} else {
		$('#alert_msg').hide();
		
	if(confirm($(this).data('confirm'))){
		e.preventDefault();
	} else {
		return false;
	}	
	
	var data = {
		"action"			 : 'Save_batch_leave_as_draft',
		"fkEmployee"		 : $('#fkEmployee').val(),
		"status"			 : '7',
		"date_created"		 : $('#date_created').val(),
		"empName"			 : "<?php echo $username; ?>",
		"EmpNo"				 : $('#EmpNo').val(),
		"Division"		 	 : $('#Division').val(),
		"leave_applied"		 : '1',
		"day_type"			 : $('input[name="day_type"]:checked').val(),
		"approver2"			 : $('#approver2').val(),
		"reason"			 : $('#reason').val(),
		"username"			 : "<?php echo $username; ?>"
	}
	
	data = $.param(data);
	alert(data);
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		data	: data,
		url		: 'save_batch_leave_as_draft.php',
		success	: function(data){	
		
			var data1 = {
			"action"			 : 'Select_batch_leave_as_draft',
			"fkEmployee"		 : $('#fkEmployee').val(),
			"status"			 : '7',
			"date_created"		 : $('#date_created').val(),
			"empName"			 : "<?php echo $username; ?>",
			"EmpNo"				 : $('#EmpNo').val(),
			"Division"		 	 : $('#Division').val(),
			"leave_applied"		 : '0',
			"day_type"			 : $('input[name="day_type"]:checked').val(),
			"approver2"			 : $('#approver2').val(),
			"reason"			 : $('#reason').val(),
			"username"			 : "<?php echo $username; ?>"
			}
			
			data1 = $.param(data1);
			$.ajax({
				type	: "POST",
				dataType: "json",
				data	: data1,
				url		:"elfs_handler.php",
				success	: function (result) {
				
					var pkid = result['pkid'];
					var leave_applied = result['leave_applied'];
				
					var data2 = {
						"pkid"					: result['pkid'],
						"leave_applied"			: result['leave_applied'],
						"date_absent_from"		: $('#date_absent_from').val(),
						"date_absent_to"		: $('#date_absent_to').val(),
						"no_of_days"			: $('#no_of_days').val()
					}	
				
					data2 = $.param(data2);
					alert(data2);
					$.ajax({
						type	: "post",
						dataType: "json",
						data	: data2,
						url		: "save_leave_dates_as_drafts.php",
						success	: function(result){			
						},error	: function(result){
						}
					});
						
				}, error: function (result) {
				}
			});
			
			alert("Batch Leave Application Saved!");
			window.location.href = "batch_leave_summary.php";
			
		}
		// ,error(data){
			// alert('ERROR MAIN');
		// }
	});
	} // end else
});	

//btn_send_batch_leave
$('#btn_send_batch_leave').click(function(e){ // Leave Application (SAVE/SEND)
	if($('#approver2').val() == '') {
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your Department Head.<br>');
	} else if($('#date_absent_from').val() == '') { 
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your Date absent from.<br>');
	} else if($('#date_absent_to').val() == '') { 
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your Date absent to.<br>');
	} else if($('#reason').val() == '') { 
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your Reason.<br>');
	} else {
		$('#alert_msg').hide();
		
	if(confirm($(this).data('confirm'))){
		e.preventDefault();
	} else {
		return false;
	}	
			
	var data = {
		"action"			 : 'test',
		"fkEmployee"		 : $('#fkEmployee').val(),
		"status"			 : '0',
		"date_created"		 : $('#date_created').val(),
		"empName"			 : $('#txt_username').val(),
		"EmpNo"				 : $('#EmpNo').val(),
		"Division"		 	 : $('#Division').val(),
		"leave_applied"		 : $('#leave_applied').val(),
		"reason"			 : $('#reason').val(),
		"approver2"			 : $('#approver2').val(),
		"day_type"			 : $('input[name="day_type"]:checked').val(),
		"username"			 : "<?php echo $username; ?>"
	}
	
	data = $.param(data);
	alert(data);
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		data	: data,
		url		: 'save_batch_leave.php',
		// url		: 'elfs_handler.php',
		success	: function(data){	
		
			var data1 = {
			"action"			 : 'Select_batch_leave',
			"fkEmployee"		 : $('#fkEmployee').val(),
			"status"			 : '0',
			"date_created"		 : $('#date_created').val(),
			"empName"			 : $('#txt_username').val(),
			"EmpNo"				 : $('#EmpNo').val(),
			"Division"		 	 : $('#Division').val(),
			"leave_applied"		 : $('#leave_applied').val(),
			"reason"			 : $('#reason').val(),
			"approver2"			 : $('#approver2').val(),
			"day_type"			 : $('input[name="day_type"]:checked').val(),
			"username"			 : "<?php echo $username; ?>"
			}
			
			data1 = $.param(data1);
			alert(data1);
			$.ajax({
				type	: "POST",
				dataType: "json",
				data	: data1,
				url		:"elfs_handler.php",
				success	: function (result) {
				
				var pkid 			= result['pkid'];
				var leave_applied	= result['leave_applied'];
				
				var data2 = {
					"pkid"					: result['pkid'],
					"leave_applied"			: result['leave_applied'],
					"date_absent_from"		: $('#date_absent_from').val(),
					"date_absent_to"		: $('#date_absent_to').val(),
					"no_of_days"			: $('#no_of_days').val()
				}	
				
				data2 = $.param(data2);
				alert(data2);
				$.ajax({
					type	: "post",
					dataType: "json",
					data	: data2,
					url		: "save_batch_leave_dates.php",
					success	: function(result){			
					},error	: function(result){
					}
				});
				
					// var data3 = {
						// "action"			: "send_email_batch_leave_for_approval",
						// "pkid"				: result['pkid']
					// }
				
					// data3 = $.param(data3);
					// alert(data3);
					// $.ajax({
						// type		: "POST",
						// dataType	: "json",
						// data		: data3,
						// url			: "elfs_handler.php",
						// success		: function (result) {
						// }, error	: function (result) {
						// }
					// });

				}, error: function (result) {
				}
			});
			
			// alert("Leave Application has been added!");
			// window.location.href = "batch_leave_summary.php";
		}
	});
	} // end else
});	 

/* New leave datepicker */
 $("input[name='day_type']").click(function() {
	dayType = this.value;
	var dateFrom = $('#date_absent_from');
	var dateTo = $('#date_absent_to');
	
if ($("input[name='day_type']:checked").val() == 0 ){ //WHOLE DAY
	$("input[id='date_absent_from']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", false);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');

dateFrom.datepicker('destroy');
dateFrom.datepicker({ 
	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
});
 
dateTo.datepicker('destroy');
dateTo.datepicker( { 
	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
	
onSelect: function (dateStr){
	var start = $("#date_absent_from").datepicker("getDate");
	var end = $("#date_absent_to").datepicker("getDate");
	var diff = calcBusinessDays(start,end);
	$("#no_of_days").val(diff);
	}
});
	
} else if ($("input[name='day_type']:checked").val() == 1 ){ // BIRTHDAY LEAVE
	$("input[id='date_absent_from']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", true);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');
		
dateTo.datepicker('destroy');
dateTo.datepicker({ 
	changeMonth: false,
	changeYear: false,
	stepMonths: false,
	beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
	},
});
	
dateFrom.datepicker('destroy');
dateFrom.datepicker({ 
	changeMonth: false,
	changeYear: false,
	stepMonths: false,
	beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
	},
	
onSelect: function (dateText, inst) {
		var date = $.datepicker.parseDate($.datepicker._defaults.dateFormat, dateText);
		$("#date_absent_to").datepicker("option", "minDate", date)
		$("#date_absent_to").datepicker("setDate", date);
		var start = $("#date_absent_from").datepicker("getDate");
		var end = $("#date_absent_to").datepicker("getDate");
		var diff = 1; 
		var days = diff + (end - start) / 86400000;
		var half = days / 2;

		$("#no_of_days").val(half);
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

});  
//End function

var handler = 'handler/handler.php';
var array_empno = [];
var array_subordinate = [];
var username = $('#txt_hd_id').val();
// alert(username);
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
			$('#EmpNo').val(result['EmpNo']);
			$('#txt-FullName').val(result['FullName']);
			$('#Division').val(result['Division']);
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
				message += ' <center><h3>New list of employee has been added to your batch leave!</h3></center>';
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
				message += ' <center><h3>The following employee has been removed from your batch leave!</h3></center>';
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
</script>

</html>