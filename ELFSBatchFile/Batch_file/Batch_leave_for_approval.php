<?php
    include("includes.php");
	require_once("elfs_oop.php");
	session_start();

	$username = $_SESSION['username'];
	// $username = 'esmolina';

?>
<html lang="en">
<head>

 <style>
		
	#BatchEmpForApproval tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#BatchEmpForApproval tr.selected {
		background-color: #36747a;
		color: #FFF;
	}
		
	#cont .FormBatchLabel{
		width:35%;
		margin-right:2%;
		font-size: 14px;
	}
	
	#cont .FormBatchText{
		margin-bottom:4px;
		width:10%;
		font-size: 14px;
	}
		
	.fa:hover {
		font-size: 20px;
		color: #FFF;
	}
	
	#cont .FormLeaveApplied{
		width:10%;
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
	
	.fa-thumbs-o-down {
	  color: red;
	}

	.fa-thumbs-down {
	  color: red;
	}	

		
</style>
</head>
<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>

<div class="panel panel-primary" style="margin:auto; width:95%;">
<div class="panel-heading">BATCH LEAVE FOR APPROVAL</div>
	<div class="panel-body">	
	<br>
	<form id="" method="get">
		<table id="EmpBatchLeave_tbl" name="EmpBatchLeave_tbl" class="table table-bordered" width="100%">
		<thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">REMARKS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" data-original-title="">EDIT/VIEW</th>
		 </tr>
		</thead>
		<tbody id="BatchEmpForApproval">
			<?php
			$result = ELFS::getInstance()->select_batch_leave_summary_for_approval_DH($username);
				while($row = mysqli_fetch_array($result)){
				
				// 0-for approval, 1-approved by approver1, 2-approved by approver2, 3-conformed by hrd, 4-revise leave as per hrd, 5-Disapproved by approver1, 6-Disapproved by approver2				
				if($row['status'] == 0) {
					$status_label = '<div class="ui gray ribbon label">Pending for Approval</div>'; 
				} else if($row['status'] == 1) {
					$status_label = '<div class="ui green ribbon label">Approved by Immediate Supr.</div>'; 
				}	else if($row['status'] == 2) {
					$status_label = '<div class="ui green ribbon label">Approved</div>'; 
				}	else if($row['status'] == 3) {
					$status_label = '<div class="ui blue ribbon label">Conformed</div>'; 
				}   else if($row['status'] == 4) {
					$status_label = '<div class="ui yellow ribbon label">For Revision</div>'; 
				}	else if($row['status'] == 5) {
					$status_label = '<div class="ui red ribbon label">Disapproved by Immediate Supr.</div>'; 
				}	else if($row['status'] == 6) {
					$status_label = '<div class="ui red ribbon label">Disapproved</div>'; 
				}	else if($row['status'] == 8) {
					$status_label = '<div class="ui red ribbon label">Cancelled</div>'; 
				}	

				if($row['leave_applied'] == 0) {										
				$leave_applied = '<center>Sick Leave</center>';
				} 	else if($row['leave_applied'] == 1) {
				$leave_applied = '<center>Vacation Leave</center>';
				}	else if($row['leave_applied'] == 2) {
				$leave_applied = '<center>Birthday Leave</center>';
				}	else if($row['leave_applied'] == 3) {
				$leave_applied = '<center>Maternity Leave</center>';
				}	else if($row['leave_applied'] == 4) {
				$leave_applied = '<center>Paternity Leave</center>';
				}	else if($row['leave_applied'] == 5) {
				$leave_applied = '<center>Bereavement Leave</center>';
				}	else if($row['leave_applied'] == 6) {
				$leave_applied = '<center>Solo Parent Leave</center>';
				}	
				
				if($row['IS_disapproved_remarks'] != "") {
						$btn_view_remarks = '<button class="btn btn-danger" id="btn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
				} else {
						$btn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found."><span class="glyphicon glyphicon-comment"></span></button>';
				}
						
				if($row['status'] == 0) {
						$btn_edit_view = '<button class="btn btn-warning" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to edit leave status."><span class="glyphicon glyphicon-pencil"></span></button>';
						$btn_edit_date_batch_leave = '<button class="btn btn-success" id="btn_view_leave_dates" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view leave date/s."><span class="glyphicon glyphicon-calendar"></span></button>';
				} else {
						$btn_edit_view = '<button class="btn btn-default" style="border-radius: 0px;" ><span class="glyphicon glyphicon-eye-close"></span></button>';
				}
															
				echo "
					<tr>	
						<td style='display:none'>".$row['pkid']."</td>
						<td style='font-family: Euphemia;' title='Double click to view leave dates'>".$status_label."</td>
						<td style='font-family: Euphemia; text-align: center;' title='Double click to view leave dates'>".$btn_view_remarks."</td>
						<td style='text-align: center; font-size: 14px;' title='Double click to view leave dates'>".$row['Emp_Name']."</td>
						<td style='text-align: center; font-size: 13px;' title='Double click to view leave dates'>".date('F d, Y',strtotime($row['date_created']))."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$btn_edit_view." ".$btn_edit_date_batch_leave."</td>
					</tr>
					";
		}
		?>
		</tbody>
		</table>
	</form>
	</div>
</div> 

<!-- Modal update leave-->	
<div class="modal fade" id="Batch_Leave_application_modal_update" role="dialog">
	<div class="modal-dialog" style="width:75%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4>EMPLOYEE BATCH LEAVE APPLICATION</h4>
			</div>
		<div class="modal-body" id="cont">	
			<form action="#"> 
				<center><div id="alert_msg" style="display:none;color:white;font-size: 14px;text-align:center;width:100%" class="row alert alert-danger"></div></center>
				<input type="hidden" id="update_txt_pkid"> 
				<input type="hidden" id="update_txt_username" name="update_txt_username" value="<?php echo $username; ?>"> 
				<input type="hidden" id="update_txt_EmpNo" name="update_txt_EmpNo" value="<?php echo $EmpNo; ?>"> 

			<div class="row">
				<div class="col-sm-6">	
					
					<br>
					<label class="FormBatchLabel">Date Created:</label>
					<input type="date" style="width:220px; height:5%;" class="FormBatchText" id="update_date_created" name="update_date_created" readonly>	
					<br>
					<label class="FormBatchLabel">Requested by:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_empName" name="update_empName" readonly>
					<br>
					<label class="FormBatchLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_EmpNo" name="update_EmpNo" readonly>
					<br>
					<label class="FormBatchLabel">Division:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_division" name="update_division" readonly>	
					<br>
					<label class="FormBatchLabel" for="approver2">Dept. Head:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_cmb_approver2" name="update_cmb_approver2" readonly>	
					<br>
					<label class="FormBatchLabel">Leave Applied:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_leave_applied" name="update_leave_applied" readonly>
					<br>
					<label class="FormBatchLabel">Reason/s:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_reason" name="update_reason" readonly>
					<br>
					
				</div>	
				
				<div class="col-sm-6">
					<div class="panel panel-warning" id="update_leave_status" style="width:80%;">
						<div class="panel-heading">
							<div class="row">
								<div class="col-sm-12"><b>LEAVE STATUS</b></div>
							</div>
						</div>
						<div class="panel-body">
						<div class="row">
						&nbsp;&nbsp;
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_approved" name="status" value="2">
								<label style="font-size: 14px;" id="lbl_approved">Approved Leave</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_disapproved" name="status" value="6">
								<label style="font-size: 14px;" id="lbl_disapproved">Disapproved Leave</label>
						</div>			
						</div>			
					</div>	
					<div class="row">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_wd" name="day_type" value="0" disabled>
								<label style="font-size: 14px;" id="lbl_approved">Whole Day</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_hd" name="day_type" value="1" disabled>
								<label style="font-size: 14px;" id="lbl_disapproved">Half Day</label>
					</div>
					<label class="FormBatchLabel">Date Absent:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText">
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_date_absent_from" name="update_date_absent_from" autocomplete="off" readonly>
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_date_absent_to" name="update_date_absent_to" autocomplete="off" readonly> 
					<br>
					<label class="FormBatchLabel">No. of days:</label>
					<input type="text" style="width:50px; height:5%;" class="FormBatchText" id="update_no_of_days" name="update_no_of_days" readonly>
					<br>
					<br>
					<br>
				</div>				
			</div>
			
			<div class="panel panel-primary" id="update_leave_status" style="width:100%;">
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-12"><b>EMPLOYEE LIST</b></div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-bordered" id="tbl_batch_employee">
						<thead>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;">EMP. NO.</th>
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
			
			<div class="modal-footer">
				<button type="button" id="btn_send_batch_leave" data-confirm="Are you sure you want to approved / disapproved this leave?" class="btn btn-success">SEND</button>
				<button type="button" id="btn_close_batch_leave"class="btn btn-danger" data-dismiss="modal">CANCEL</button></a>
			</div>
			</form>	
		</div>
		</div>
	</div>
</div>

<!-- Modal disapproved leave-->	
  <div class="modal fade" id="disapproved_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-default">
          <h4 style="font-family:Euphemia">DISAPPROVED LEAVE</h4>
        </div>
		<div class="modal-body">
			<center><div id="alert_msg2" style="display:none;color:white;font-size: 14px;text-align:center;width:100%" class="row alert alert-danger"></div></center>
			<div class="form-group">
			  <label style="font-size: 14px;" for="disapp_remarks">Remarks</label>
			  <textarea class="form-control" rows="3" id="DH_batch_disapproved_remarks"></textarea>
			</div>
		</div>
		<div class="modal-footer">
			<div style="float:right">
				<button class="btn btn-primary" id="btn_save_disapproved" data-save="modal">SAVE</button>
				<button class="btn btn-danger" id="btn_close_disapproved">CLOSE</button>
			</div>
		</div>
      </div>
    </div>
  </div> 

<!-- Modal Show remarks -->
<div class="modal fade" tabindex="-1" id="show_remarks_modal" role="dialog">
	<div class="modal-dialog" style="width:35%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Leave Status Remarks</h4>
			</div>
		<div class="modal-body" id="cont">

		<label style="font-size: 14px;" >Disapproved by Immediate Superior:</label>
		<center><textarea rows="3" id="IS_disapproved_remarks_show" style="width:420px;" placeholder="N/A" readonly></textarea></center>
		<br>
		<br>
		
		<label style="font-size: 14px;" >Disapproved by Dept. Head:</label>
		<center><textarea rows="3" id="DH_batch_disapproved_remarks_show"  style="width:420px;" placeholder="N/A" readonly></textarea></center>
		<br>
		<br>
		
		<label style="font-size: 14px;" >Revise Leave by HRD:</label>
		<center><textarea rows="3" id="HR_revise_remarks_show" style="width:420px;" placeholder="N/A" readonly></textarea></center>
		<br>
		<br>
		
		<label style="font-size: 14px;" >Cancelled Leave:</label>
		<center><textarea rows="3" id="Cancelled_remarks_show" style="width:420px;" placeholder="N/A" readonly></textarea></center>
	
		</div>
		<div class="modal-footer">
			<center><button type="button" id="btn_close_leave_remarks" class="btn btn-danger" style="width:420px; height: 40px;" data-dismiss="modal">CLOSE</button></center>
		</div>

		</div>
	</div>
</div> 

<!-- Modal Remove Date -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_view_dates">
	<div class="modal-dialog" style="width:85%">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">BATCH EMPLOYEE LEAVE DATES</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txt_pkid_remove_leave" name="txt_pkid_remove_leave" value="<?php echo $pkid; ?>"> <br>
			<div id="remove_date_summary" style="padding: 13px;" ></div> 
			</div>
			
			<div class="modal-footer">
			<button type="button" id="btn_close_view_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


</body>

<script type="text/javascript">
	var oTable_batch = '';
	
	$("#EmpBatchLeave_tbl").DataTable({"order": [],
		"columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false,
	}]});
		
	oTable_batch = $("#tbl_batch_employee").DataTable({
	});
	
/* 	$("#EmpBatchLeave_tbl tbody").on('dblclick','tr', function(){
		$("#modal-body input").val("");	
		select_batch_leave_info_by_pkid($(this).find("td:eq(0)").text());
	}); */
	
	$("#EmpBatchLeave_tbl tbody").on('click','tr #btn_view_leave', function(e){
		e.preventDefault();
		select_batch_leave_info_by_pkid($(this).val());
	});	
	
	$("#EmpBatchLeave_tbl tbody").on('click','tr #btn_view_leave_dates', function(e){
		e.preventDefault();
		select_batch_dates($(this).val());
	});

	$('#btn_save_disapproved').click(function(){
		if($('#DH_batch_disapproved_remarks').val() != '') {
			$('#disapproved_modal').modal('hide');
		} else {
			$('#alert_msg2').show();
			$('#alert_msg2').append('Please add remarks!<br>');
		}
	});	
		
	$('#btn_close_disapproved').click(function(){
		$('#disapproved_modal').modal('hide');
		$('#update_rbtn_disapproved').attr("checked", false);
		$('#DH_batch_disapproved_remarks').val('');

	});	
		
	$("#btn_send_batch_leave").click(function(e){
		var checker = false;
		if($('#update_rbtn_approved').is(':checked') || $('#update_rbtn_disapproved').is(':checked')) {
			 if($('#update_rbtn_approved').is(':checked')) {
				var status = 2;
				checker = true;
			} else if($('#update_rbtn_disapproved').is(':checked')) {
					var status = 6;	
					if($('#IS_disapproved_remarks').val() == '') {
						$('#alert_msg2').show();
						$('#alert_msg2').append('Please add remarks!<br>');
						$('#disapproved_modal').modal('show');
					} else {
						checker = true;
					} 
				} 
				
				if(confirm($(this).data('confirm'))){
					e.preventDefault();
				} else {
					return false;
				}
				
			if(checker) {			
				update_batch_approver2_status($('#update_txt_pkid').val(),status);
				}
		} else {
			$('#alert_msg').show();
			$('#alert_msg').append('Please select leave status!<br>');
		} 	
					
	});
	
	$("#EmpBatchLeave_tbl tbody").on('click','tr #btn_show_remarks', function(e){
		e.preventDefault();
		batch_show_remarks($(this).val());
	});

	$("tbody tr").click(function() {
		console.log('clicked');
		$(this).addClass('selected').siblings().removeClass("selected");
	});

	$('#btn_cancel_update_leave').click(function(){
		window.location.href = "Batch_leave_for_approval.php";
	});	

	$("#update_rbtn_disapproved").click(function(){
		$('#disapproved_modal').modal('show');
    });
		
	$('#btn_close_disapproved').click(function(){
		$('#disapproved_modal').modal('hide');
		$('#update_rbtn_disapproved').attr("checked", false);
	});	
	
	$('#btn_close_batch_leave').click(function() {
		window.location.href = "Batch_leave_for_approval.php";
	});

/* Functions */
function select_batch_leave_info_by_pkid(pkid) {
	var data1 = {
		"action"			 : "select_batch_leave_info_by_pkid",
		"pkid"				 : pkid
	}
	data1 = $.param(data1);
	alert(data1);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data1,
		url			: "elfs_handler.php",
		success		: function (result) {	
			
			
			if(result['status'] == 2) {	
				$('#update_rbtn_approved').prop('checked', true);
				$('#update_rbtn_approved').prop('disabled', true);
				$('#update_rbtn_disapproved').prop('disabled', true);
				$('#btn_send_batch_leave').prop('disabled', true);
			} else if (result['status'] == 6) {
				$('#update_rbtn_disapproved').prop('checked', true);
				$('#update_rbtn_approved').prop('disabled', true);
				$('#update_rbtn_disapproved').prop('disabled', true);
				$('#btn_send_batch_leave').prop('disabled', true);
			}
			
			$('#update_date_created').val(result['date_created']);
			$('#update_empName').val(result['Emp_Name']);
			$('#update_EmpNo').val(result['EmpNo']);
			$('#update_division').val(result['Division']);
			$('#update_cmb_approver2').val(result['approver2_name']);
			$('#update_reason').val(result['reason']);
			
			if(result['leave_applied'] == 1) {
				$('#update_leave_applied').val('Vacation Leave');
			} 
					
			if(result['day_type'] == 0) {
				$('#update_rbtn_wd').prop('checked', true);
			} else if(result['day_type'] == 1) {
				$('#update_rbtn_hd').prop('checked', true);
			} 
				
			$('#update_date_absent_from').val(result['date_from']);
			$('#update_date_absent_to').val(result['date_to']);
			$('#update_no_of_days').val(result['total_absent_days']);
			
			$('#update_txt_pkid').val(pkid);	
				get_batch_employee_list_by_requestor(pkid);
			$("#Batch_Leave_application_modal_update").modal();

		// }	
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}

function get_batch_employee_list_by_requestor(fkid){
// alert(fkid);
	var data = {
		"action"		: "get_batch_employee_list_by_requestor",
		"pkid"			: fkid 
	}	
	call_ajax(data, 'elfs_handler.php', function(result){

		var html  = '';
			for(x=0;x<result['ctr'];x++){
								
				// html += '<tr id="'+result['fkid'][x]+'">';
				// html += '	<td style="font-size: 13px; font-family:Consolas; display:none; "><center>'+result['pkid'][x]+'</center></td>';
				// html += '	<td style="font-size: 13px;"><center>'+result['Subordinate'][x]+'</center></td>';
				// html += '	<td style="font-size: 13px;"><center>'+result['FullName'][x]+'</center></td>';
				// html += '	<td style="font-size: 13px;"><center>'+result['Division'][x]+'</center></td>';
				// html += '	<td style="font-size: 13px;"><center>'+result['Department'][x]+'</center></td>';
				// html += '	<td style="font-size: 13px;"><center>'+result['Section'][x]+'</center></td>';
				// html += '	<td style="font-size: 13px;"><center>'+result['Position'][x]+'</center></td>';
				// html += '</tr>';
				
				oTable_batch.row.add([
					result['Subordinate'][x],
					result['FullName'][x],
					result['Division'][x],
					result['Department'][x],
					result['Section'][x],
					result['Position'][x]
				]).draw(false);
			}
			
 		$('#tbl_batch_employee tbody').append(html);
	
	});
	
}

function call_ajax(data, handler, fn){
	data = $.param(data);
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: handler,
		success	: function(result){
			fn(result);
		}
	});
}

function update_batch_approver2_status(pkid,status) {
	var data1 = {
		"action"						 : "update_batch_approver2_status",
		"pkid"							 : pkid,
		"status"						 : status,
		"DH_disapproved_remarks" 		 : $('#DH_batch_disapproved_remarks').val(),
		"username"						 : "<?php echo $username; ?>"
	}
	data1 = $.param(data1);
	alert(data1);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data1,
		url			: "update_batch_approver2_status.php",
		success		: function (result) {
		
			var data2 = {
				"action": "send_email_from_approver2",
				"pkid"	: pkid
			}
			data2 = $.param(data2);
			$.ajax({
				type	: "POST",
				dataType: "json",
				data	: data2,
				url		:"elfs_handler.php",
				success	: function (result) {					
				}, error: function (result) {
				}
			});
			alert("Successfully updated!");
			window.location.href = "Batch_leave_for_approval.php";
		
		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}
	
function batch_show_remarks(pkid) { 
	var data = {
		"action"			: "batch_show_remarks",
		"pkid"				: pkid
	}
	data = $.param(data);
	alert(data);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data,
		url			: "elfs_handler.php",
		success		: function (result) {
		
			$('#IS_disapproved_remarks_show').val(result['IS_disapproved_remarks']);
			$('#DH_batch_disapproved_remarks_show').val(result['DH_batch_disapproved_remarks']);
			$('#HR_revise_remarks_show').val(result['HR_revised_remarks']);
			$('#Cancelled_remarks_show').val(result['Cancelled_remarks']);
			$('#show_remarks_modal').modal('show');
			
		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}	

function select_batch_dates(pkid) { 
		var data1 = {
			"action"			 : "select_batch_dates",
			"pkid"				 : pkid
		}
		data1 = $.param(data1);
		alert(data1);
		$.ajax({
			type		: "POST",
			dataType	: "json",
			data		: data1,
			url			: "elfs_handler.php",
			success		: function (result) {
			
			if(result['status'] == 0) {
				$('#txt_pkid_remove_leave').val(pkid);
				$('#modal_view_dates').modal();
				get_remove_leave_dates_summary(pkid);
			}	
								
			}, error	: function (result) {
			alert('ERROR: '+result);
			}
		});
	}

function get_remove_leave_dates_summary(){
	var pkid = $("#txt_pkid_remove_leave").val();
	var data = {
		"action"	: "get_remove_leave_dates_summary",
		"pkid"		: pkid
	}
	
	data = $.param(data);
	alert(data);
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: "elfs_handler.php",
		success	: function(data){
				
			var ctr = data['ctr'];
				$('#remove_date_summary').empty();	
					var html  = '<table id="tbl_batch_date" class="table table-bordered">';
						html += '	<thead>';
						html += '		<tr>';
						html += '			<th><center><font size="2">DATE ABSENT</font></center></th>';
						html += '			<th><center><font size="2">NO. OF DAYS</font></center></th>';
						html += '		</tr>';
						html += '	</thead>';
						html += '	<tbody>';
						html += '	</tbody>';
						html += '</table>';
					
				$('#remove_date_summary').append(html);	
			
			for(i=0;i<ctr;i++) {
			
					if(data['day_type'][i] == 0) {	
						var disable = '';
					} else if (data['day_type'][i] == 1){
						var disable = 'disabled';
					} 
					
				var html  = '<tr id="'+data['pkid'][i]+'">';
					html += '	<td style="text-align: center;font-size: 14px;">'+data['date_absent_from'][i]+ ' - ' +data['date_absent_to'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_days'][i]+'</td>';	
				 $('#tbl_batch_date tbody').append(html);			
			}
			
			var oTable = $('#tbl_batch_date').DataTable({ 
				"paginate":true, 
				"aaSorting": [],
			});
			vw_table_events();
						
		
		},error	: function(data){
			alert(data);
		}
	});
}

function vw_table_events(){
$('#tbl_batch_date tbody tr').click(function(){
	vw_selected_pkid = "";
		$('#tbl_batch_date tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
	vw_selected_pkid = this.id;
});
}


</script>
	
</html>