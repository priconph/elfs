<?php
    include("includes.php");
	require_once("elfs_oop.php");
	session_start();

	echo '<input type="hidden" id="hd_fkid" value="'.$_GET['pkid'].'">';
	echo '<input type="hidden" id="hd_status" value="'.$_GET['status'].'">';
	
	
	$username = $_SESSION['username'];
	$username = 'jcfeliciano';
	
	$result = ELFS::getInstance()->getEmpNo($username);
		while($row = mysqli_fetch_array($result)){
		$EmpNo = $row['EmpNo'];
	}

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
<html lang="en">
<head>
<style>
	#batchEmpList tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#batchEmpList tr.selected {
		background-color: #36747a;
		color: #FFF;
	}
	
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
	
	.modal-body {
		max-height: calc(110vh - 210px);
		overflow-y: auto;
	}
	
	.fixed-panel {
		max-height: 300;
		overflow-y: scroll;
	}
</style>

</head>
<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>

<div class="panel panel-primary" style="margin:auto; width:95%;">
<div class="panel-heading">LIST OF BATCH EMPLOYEE</div>
	<div class="panel-body">	
		<input type="hidden" id="hd_fkid" name="hd_fkid" value="<?php echo $_GET['pkid'] ?>"> <br>
		<input type="hidden" id="hd_status" name="hd_status" value="<?php echo $_GET['status'] ?>"> <br>
		<input type="hidden" id="txt_EmpNo" name="txt_EmpNo" value="<?php echo $EmpNo; ?>"> <br>
		<input type="hidden" id="txt_username_id" name="txt_username_id" value="<?php echo $username; ?>"> <br>

		<table style="text-align:right; width: 100%;">
			<tr>
				<td>
					<form class="form-inline" role="form" method="POST" action="">
						<?php
							if( $_GET['status'] != '3' && $_GET['status'] != '8' ){
								echo '<button type="button" class="btn btn-danger" id="btn_remove_employee_list"> Remove Employee</button>';						
							}
						?>
					</form>
				</td>
			</tr>
		</table>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-bordered" id="tbl_batch_employee">
					<thead>
						<th></th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;">EMPLOYEE NO.</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;">EMPLOYEE NAME</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;">DIVISION</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;">DEPARTMENT</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;">SECTION</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;">POSITION</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-success" id="btn_close_batch_leave" name="btn_close_batch_leave" title="Click this to close batch leave">CLOSE</button></a>
	</div>
</div> 

<div class="modal fade" tabindex="-1" role="dialog" id="modal_remove_employee_list">
  <div class="modal-dialog" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">REMOVE EMPLOYEE</h4>
      </div>
      <div class="modal-body">
		<div class="row" id="system_message">
			<div class="alert alert-danger"><h4>Warning: The following employees will be removed from batch list.</h4></div>
		</div>
		<div class="content">
		</div>		
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_remove_employee">REMOVE</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>
<!--end modals-->

</body>

<script type="text/javascript">
	$("#EmpBatchLeave_tbl").dataTable({"order": [],
		"columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false,
	}]});
	
	$("#btn_close_batch_leave").on('click', function(){
		window.location.href = "Batch_leave_for_conformance2.php";
	});

	$('#btn_remove_employee').click(function(){ 
		remove_employee();
	});

	$('#btn_remove_employee_list').click(function(){ 
		if( array_subordinate.length == 0 ){
			var message  = '<div class="alert alert-danger">';
				message += ' <center><h3>There are no record selected!</h3></center>';
				message += '</div>';
			system_message_modal(message);
		}
		employee_for_removal();
		$('#modal_remove_employee_list').modal('show');
		return false;
	});

	$('#tbl_batch_employee tbody').on('click','tr .checkbox', function(){
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

	$('#tbl_employee_batch_list tbody').on('click','tr .checkbox', function(){
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

/////////////////////////////////////////////////////////////////////////////////////////////
var handler = 'handler/handler.php';
var array_empno = [];
var array_subordinate = [];
var username = $('#txt_username_id').val();
var empno = '';
var fkid = $('#hd_fkid').val();

/* Datatables serverside configuration */
var tbl_batch_employee = '';

/* Get Empno */
get_empno(username,function(result){
	tbl_batch_employee = $('#tbl_batch_employee').DataTable( {
		"sAjaxSource": "server_side_scripts/batch_employee_list.php?fkid=" + fkid
	});
});

function load_employee_information(fkid){
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: "action=load_employee_information&fkid="+fkid,
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

function employee_for_removal(){
	var data = {
		"action"		: "employee_for_removal",
		"SectionHead"	: empno,
		"array_empno"	: array_subordinate,
		"fkid"			:fkid
	}
	data = $.param(data);
	$.ajax({
		type	: "POST",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(result){
			$('#modal_remove_employee_list .modal-body .content').empty();
			$('#modal_remove_employee_list .modal-body .content').append(result['html']);
		},error	: function(){
			alert('error handler');
		}
	});
}

function remove_employee(){
	var data = {
		"action"		: "remove_employee", 
		"SectionHead"	: empno,
		"array_empno"	: array_subordinate,
		"fkid"			: fkid

	}
	data = $.param(data);
	// alert(fkid);
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(result){
			var message  = '<div class="alert alert-success">';
				message += ' <center><h3>The following employee has been removed from your batch list!</h3></center>';
				message += '</div>';
			system_message_modal(message);
			tbl_batch_employee.ajax.reload();
			tbl_emp_selection.ajax.reload();
			array_subordinate = [];
			array_empno = [];
			$('#modal_remove_employee_list .modal-body .content').empty();
			console.log(array_subordinate);
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