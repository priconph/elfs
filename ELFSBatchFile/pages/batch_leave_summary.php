
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

<div class="panel panel-primary" style="margin:auto; width:95%;">
	<div class="panel-heading">EMPLOYEE BATCH LEAVE</div>
	<div class="panel-body">

	<form action="#"> 
		<center><div id="alert_msg" style="display:none;color:white;font-size: 14px;text-align:center;width:100%" class="row alert alert-danger"></div></center>
			
			<div class="row">
				<div class="col-sm-6">	
					
					<br>
					<label class="FormBatchLabel">Date Created:</label>
					<input type="date" style="width:220px; height:5%;" class="FormBatchText" id="txt-DateCreated" name="txt-DateCreated" value="<?php echo date("Y-m-d") ; ?>" readonly>	
					<br>
					<label class="FormBatchLabel">Employee Name:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="txt-FullName" name="txt-FullName" readonly>
					<br>
					<label class="FormBatchLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="txt-EmpNo" name="txt-EmpNo" readonly>
					<br>
					<label class="FormBatchLabel">Division:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="txt-Division" name="txt-Division" readonly>	
					<br>
					<label class="FormBatchLabel" for="txt-Approver">Dept. Head:</label>
						<?php
						echo "<select id='txt-Approver' name='txt-Approver' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Department Head...' required>"; 
							$result = ELFS::getInstance()->getApproverList($username);
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
				
				<div class="col-sm-5">
					<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="rbtn_wd" name="txt-dayType" value="0"><b>&nbsp;&nbsp;WHOLE DAY</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="rbtn_hd" name="txt-dayType" value="1"><b>&nbsp;&nbsp;HALF DAY</b>
					<br>
					<br>
					
					<label class="FormBatchLabel">Date Absent:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText">
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="txt-DateFrom" name="txt-DateFrom" autocomplete="off" readonly="true" required>
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="txt-DateTo" name="txt-DateTo" autocomplete="off" readonly="true" required> 
					<br>
					<label class="FormBatchLabel">No. of days:</label>
					<input type="text" style="width:50px; height:5%;" class="FormBatchText" id="txt-NoOfDays" name="txt-NoOfDays" readonly>
					<br>
					<label class="FormBatchLabel">Reason/s:</label>
					<select id="txt-reason" name="txt-reason" style="width:220px; height:5%;" class="FormBatchText" required>	
						<option value="">--Select--</option>
						<option value="Special Holiday">Special Holiday</option>
						<option value="Shut-Down">Shut-Down</option>
					</select> 
					<br>
					<label class="FormBatchLabel"></label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText" id="txt-LeaveApplied" name="txt-LeaveApplied" value="0" Placeholder="Vacation Leave" readonly>	
					<br>
			</div>
				<button type="button" class="btn btn-primary" id="btn-add_subordinate_modal"> Add Employee</button>
				<button type="button" class="btn btn-danger" id="btn-remove_subordinate_modal"> Remove Employee</button>
				<br>
				<br>
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
				<button type="submit" id="btn_send_batch_leave" data-confirm="Are you sure you want to file this batch leave?" class="btn btn-success">SAVE&SEND </button>
				<button type="button" id="btn_cancel_batch_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 35px;" data-dismiss="modal">CANCEL</button> &nbsp;
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
//btn_cancel_batch_leave

$('#btn_cancel_batch_leave').click(function(e){
	window.location.href = "batch_leave_summary.php";
});

//Save and Send Leave
/* $('#btn_send_batch_leave').click(function(e){
		if($('#txt-Approver').val() == '') {
			$('#alert_msg').show();
            $('#alert_msg').append('Please select your Department Head.<br>');
        } else if($('#txt-DateFrom').val() == '') { 
			$('#alert_msg').show();
            $('#alert_msg').append('Please select your Date absent from.<br>');
		} else if($('#txt-DateTo').val() == '') { 
			$('#alert_msg').show();
            $('#alert_msg').append('Please select your Date absent to.<br>');
		} else if($('#txt-reason').val() == '') { 
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
			"action"			 : 'save_leave_batch',
			"fkEmployee"		 : $('#fkEmployee').val(),
			"status"			 : '0',
			"date_created"		 : $('#txt-DateCreated').val(),
			"empName"			 : $('#txt_username').val(),
			"EmpNo"				 : $('#EmpNo').val(),
			"Division"		 	 : $('#txt-Division').val(),
			"leave_applied"		 : $('#txt-LeaveApplied').val(),
			"reason"			 : $('#txt-reason').val(),
			"approver"			 : $('#txt-Approver').val(),
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
		window.location.href = "emp_leave_summary.php";
		
		},error(data){
			alert('ERROR MAIN');
		}
	});
	}
	});	 */

/* New leave datepicker */
 $("input[name='txt-dayType']").click(function() {
	dayType = this.value;
	var dateFrom = $('#txt-DateFrom');
	var dateTo = $('#txt-DateTo');
	
if ($("input[name='txt-dayType']:checked").val() == 0 ){ //WHOLE DAY
	$("input[id='txt-DateFrom']").prop("disabled", false);
	$("input[id='txt-DateTo']").prop("disabled", false);
	$('#txt-DateFrom').val('');
	$('#txt-DateTo').val('');
	$('#txt-NoOfDays').val('');

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
	var start = $("#txt-DateFrom").datepicker("getDate");
	var end = $("#txt-DateTo").datepicker("getDate");
	var diff = calcBusinessDays(start,end);
	$("#txt-NoOfDays").val(diff);
	}
});
	
} else if ($("input[name='txt-dayType']:checked").val() == 1 ){ //HALF DAY
	$("input[id='txt-DateFrom']").prop("disabled", false);
	$("input[id='txt-DateTo']").prop("disabled", false);
	$('#txt-DateFrom').val('');
	$('#txt-DateTo').val('');
	$('#txt-NoOfDays').val('');

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
	var start = $("#txt-DateFrom").datepicker("getDate");
	var end = $("#txt-DateTo").datepicker("getDate");
	var diff = calcBusinessDays(start,end);
	
	var half = diff / 2;
	$("#txt-NoOfDays").val(half);
	
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
alert(username);
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