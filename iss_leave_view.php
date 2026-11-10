<?php
    include("includes.php");
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
		 $Department 		=  $rowEmpInfo['Department'];
		 $Section 			=  $rowEmpInfo['Section'];
		 $Division 			=  $rowEmpInfo['Division'];
		 $SalaryType 		=  $rowEmpInfo['SalaryType'];
	}
	
?>
<html lang="en">
<head>

 <style>
		
	#leaveEmpForApproval tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#leaveEmpForApproval tr.selected {
		background-color: #36747a;
		color: #FFF;
	}
	
	#leaveHistory tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#leaveHistory tr.selected {
		background-color: #36747a;
		color: #FFF;
	}
	
	#cont .FormLabel{
		width:35%;
		margin-right:2%;
		font-size: 14px;
	}
	
	#cont .FormText{
		margin-bottom:4px;
		width:10%;
		font-size: 14px;
	}
	
	#cont .FormLeaveLabel{
		width:35%;
		margin-right:10%;
		font-size: 14px;
	}
	

	#cont .FormLeaveText{
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
	
	.glyphicon.glyphicon-remove {
		font-size: 25px;
	}
	
	.glyphicon.glyphicon-ok {
		font-size: 25px;
	}
		
</style>
</head>
<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>


<div class="panel panel-primary" style="margin:auto; width:95%;">
	<div class="panel-heading">ISS EMPLOYEE LEAVE HISTORY</div>
		<div class="panel-body">	
		<br>
	
		<form id="" method="get">
			<table id="Empleave_history_tbl" name="Empleave_history_tbl" class="display nowrap" cellspacing="0" width="100%">
				 <thead>
					<tr>
						<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Remarks" data-original-title="">REMARKS</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee No." data-original-title="">EMPLOYEE NO.</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Adress during leave" data-original-title="">ADDRESS DURING LEAVE</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Other address during leave" data-original-title="">OTHER ADDRESS DURING LEAVE</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Reason/s" data-original-title="">REASON</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Other Reason/s" data-original-title="">OTHER REASON</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total # of leaves" data-original-title="">TOTAL # OF LEAVE(S)</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by IM" data-original-title="">IMMEDIATE SUPERIOR</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Sec/Head Approver" data-original-title="">SEC/HEAD APPROVER</th>
					</tr>
				  </thead>
				  <tbody id="leaveHistory">
					<?php
					$result = ELFS::getInstance()->select_leave_history_for_iss();
						while($row = mysqli_fetch_array($result)){
						
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
						}	else if($row['leave_applied'] == 7) {
							$leave_applied = '<center>Special Leave Benefit for Women</center>';
						}	
											
						if($row['status'] == 0) {
							$status_label = '<div class="ui blue ribbon label">For Approval</div>'; 
						}   else if($row['status'] == 1) {
							$status_label = '<div class="ui green ribbon label">Approved by IM</div>'; 
						}	else if($row['status'] == 2) {
							$status_label = '<div class="ui green ribbon label">Approved by Dept. Head</div>'; 
						} 	else if($row['status'] == 3) {
							$status_label = '<div class="ui blue ribbon label">Conformed</div>'; 
						}   else if($row['status'] == 5) {
							$status_label = '<div class="ui red ribbon label">Disapproved by IM</div>'; 
						}	else if($row['status'] == 6) {
							$status_label = '<div class="ui red ribbon label">Disapproved by Dept. Head</div>'; 
						}
						
						
						
						if($row['other_reason'] == 0) {										
							$reason_label = '<center>N/A</center>';
						} 	else if($row['other_reason'] == 1) {
							$reason_label = '<center>Shut-down</center>';
						}	else if($row['other_reason'] == 2) {
							$reason_label = '<center>Special Non-working Holiday</center>';
						}	else if($row['other_reason'] == 3) {
							$reason_label = '<center>Others</center>';
						}	
						
						if($row['IS_disapproved_remarks'] != "" || $row['DH_disapproved_remarks'] != "" || $row['HR_revised_remarks'] !="" || $row['Cancelled_remarks'] !="" || $row['HR_cancel_remarks'] !="") {
								$hbtn_view_remarks = '<button class="btn btn-danger" id="hbtn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
						} else {
								$hbtn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found." disabled><span class="glyphicon glyphicon-comment"></span></button>';
						}
						
						if($row['status'] == 3 || $row['status'] == 8) {
								$btn_cancel = '<button class="btn btn-default" style="border-radius: 0px;" ><span class="glyphicon glyphicon-remove"></span></button>';
						} 
						
						$pkid = $row['pkid'];	
						echo "
							<tr title='Double click to view leave dates.'>	
								<td style='display:none'>".$row['pkid']."</td>
								<td style='font-size: 16px;'>".$status_label."</td>
								<td style='text-align: center; font-size: 16px;'>".$hbtn_view_remarks."</td>
								<td style='text-align: center; font-family: Euphemia; font-size: 13px;'>".date('F d, Y',strtotime($row['date_created']))."</td>
								<td style='text-align: center; font-size: 14px;'>".$row['EmpNo']."</td>
								<td style='text-align: center; font-size: 14px;'>".$row['FirstName']." ".$row['LastName']."  </td>
								<td style='text-align: center; font-size: 14px;'>".$leave_applied."</td>
								<td style='text-align: center; font-size: 14px;'>".$row['emp_address']."</td>
								<td style='text-align: center; font-size: 14px;'>".$row['address']."</td>
								<td style='text-align: center; font-size: 14px;'>".$reason_label."</td>
								<td style='text-align: center; font-size: 14px;'>".$row['reason']."</td>
								<td style='text-align: center; font-size: 14px;'>".$row['total_absent_days']."</td>
								<td style='text-align: center; font-size: 14px;'>".$row['approvername1']."</td>
								<td style='text-align: center; font-size: 14px;'>".$row['approvername2']."</td>
							</tr>
							";
							}
					?>
				</tbody>
			</table>  
		</form>  
	</div>
</div> 


<div class="modal fade" tabindex="-1" id="show_remarks_modal" role="dialog">
<div class="modal-dialog" style="width:40%">
  <div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Leave Status Remarks</h4>
	</div>
	<div class="modal-body" id="cont">

		  <label style="font-size: 14px;">Disapproved by Immediate Superior:</label>
		 <center><textarea rows="3" id="IS_disapproved_remarks_show" style="width:420px;" placeholder="N/A" readonly></textarea></center>
		  <br>
		  <br>
		  
		  <label style="font-size: 14px;" >Disapproved by Dept. Head:</label>
		<center><textarea rows="3" id="DH_disapproved_remarks_show"  style="width:420px;" placeholder="N/A" readonly></textarea></center>
		  <br>
		  <br>
		 
		  <label style="font-size: 14px;" >Revise Leave by HRD:</label>
		  <center><textarea rows="3" id="HR_revise_remarks_show" style="width:420px;" placeholder="N/A" readonly></textarea></center>
	
	</div>
	<div class="modal-footer">
		<center><button type="button" id="btn_close_leave_remarks" class="btn btn-danger" style="width:420px; height: 40px;" data-dismiss="modal">CLOSE</button></center>
	</div>

  </div>
</div>
</div> 

<!-- Modal View Leave -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_view_emp_leave">
	<div class="modal-dialog" style="width:85%">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">EMPLOYEE LEAVE DATES</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txt_pkid_view_leave" name="txt_pkid_view_leave" value="<?php echo $pkid; ?>"> <br>
			<div id="ViewLeave_summary" style="padding: 13px;" ></div> 
			</div>
			
			<div class="modal-footer">
			<!--	<button type="submit" id="btn_save_view_leave" class="btn btn-primary" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;">SAVE</button>
			-->
			<button type="button" id="btn_close_view_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

</body>

<script type="text/javascript">
	$("#Empleave_tbl").dataTable({
		"order": [],
		"columnDefs": [ {
		"targets"  : 'no-sort',
		"orderable": false,
		}]
	});
	
	$("#Empleave_tbl tbody").on('dblclick', 'tr', function(){
		$("#modal-body input").val("");	
		select_view_emp_leave($(this).find("td:eq(0)").text());
	});	
	
	$("#Empleave_tbl tbody").on('click','tr #btn_view_leave', function(e){
		e.preventDefault();
		select_leave_info_by_pkid($(this).val());	
	});
	
	$("#Empleave_history_tbl tbody").on('click','tr #hbtn_show_remarks', function(e){
		e.preventDefault();
		show_remarks($(this).val());
	});

	$("#Empleave_tbl tbody").on('click','tr #appbtn_show_remarks', function(e){
		e.preventDefault();
		show_remarks($(this).val());
	});
	
	$("#Empleave_history_tbl tbody").on('dblclick', 'tr', function(){
		$("#modal-body input").val("");	
		select_view_emp_leave($(this).find("td:eq(0)").text());
	});	

	$("#Empleave_history_tbl").dataTable({
		"order": [],
		"columnDefs": [ {
		"targets"  : 'no-sort',
		"orderable": false,
		}]
	});
	
	$("#EmpleaveBalance_tbl").dataTable({
		"scrollX": true
	});
	
	$("tbody tr").click(function() {
		console.log('clicked');
		$(this).addClass('selected').siblings().removeClass("selected");
	});

	$('#btn_vw_leave_history').click(function(){
		$('#Emp_Leave_History').modal('show'); 
	});

	
/* Functions */
function select_leave_info_by_pkid(pkid) {
	var data1 = {
		"action"			 : "select_leave_info_by_pkid",
		"pkid"				 : pkid
	}
	data1 = $.param(data1);
	// alert(data1);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data1,
		url			: "elfs_handler.php",
		success		: function (result) {	
			for(var i=0;i<result['ctr'];i++) {
		
			$('#update_rbtn_approved').val(result['status'][i]);
			$('#update_date_created').val(result['date_created'][i]);
			$('#update_empName').val(result['Emp_Name'][i]);
			$('#update_EmpNo').val(result['EmpNo'][i]);
			$('#update_division').val(result['Division'][i]);
			
				if(result['leave_applied'] == 0) {
					$('#update_rbtn_sl').prop('checked', true);
				} else if(result['leave_applied'] == 1) {
					$('#update_rbtn_vl').prop('checked', true);
				} else if(result['leave_applied'] == 2) {
					$('#update_rbtn_bdl').prop('checked', true);
				} else if(result['leave_applied'] == 3) {
					$('#update_rbtn_ml').prop('checked', true);
				} else if(result['leave_applied'] == 4) {
					$('#update_rbtn_pl').prop('checked', true);
				} else if(result['leave_applied'] == 5) {
					$('#update_rbtn_bl').prop('checked', true);
				} else if(result['leave_applied'] == 6) {
					$('#update_rbtn_sp').prop('checked', true);
				} else if(result['leave_applied'] == 7) {
					$('#update_rbtn_slbw').prop('checked', true);
				} 
				
			$('#update_date_absent_from').val(result['date_from'][i]);
			$('#update_date_absent_to').val(result['date_to'][i]);
			$('#update_no_of_days').val(result['total_absent_days'][i]);
			// $('#update_reason').val(result['reason'][i]);
			$('#emp_address').val(result['emp_address'][i]);
			
				if(result['radio_OthersAdd'] == 1) {
					$('#lbl_radio_update_otherAdd').prop('checked', true);
				} else {
					$('#lbl_radio_update_otherAdd').prop('checked', false);
				}
				
				if(result['other_reason'] == 0 || result['other_reason'] == 1 || result['other_reason'] == 2 || result['other_reason'] == 3) {	
					$('#update_reason').val(result['reason']);
					$('#update_other_reason').val(result['other_reason']);
				} else {
					$('#update_reason').val(result['reason']);
				}

				
			$('#update_address').val(result['address'][i]);
			$('#update_cmb_approver1').val(result['approver1_name'][i]);
			$('#update_cmb_approver2').val(result['approver2_name'][i]);
			
			$('#update_txt_pkid').val(pkid);	
			$("#Leave_application_modal_update").modal();
		}	
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}	
 	
function select_view_emp_leave(pkid) { 
	var data1 = {
		"action"			 : "select_view_emp_leave",
		"pkid"				 : pkid
	}
	data1 = $.param(data1);
	// alert(data1);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data1,
		url			: "elfs_handler.php",
		success		: function (result) {

			if(result['leave_applied'] == 3) {
				$('#modal_view_emp_leave').modal('disabled', true);
			}
		
			$('#txt_pkid_view_leave').val(pkid);
			$("#modal_view_emp_leave").modal();
				get_view_leave_dates_summary(pkid);
			
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}

function get_view_leave_dates_summary(){
	var pkid = $("#txt_pkid_view_leave").val();
	var data = {
		"action"	: "get_view_leave_dates_summary",
		"pkid"		: pkid
	}
	
	data = $.param(data);
	// alert(data);
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: "elfs_handler.php",
		success	: function(data){
			
			var status = data['status'];
			// alert(status);
			if(status == 2) {	
					$('#btn_edit_leave_date').attr('disabled','disabled');
					$('#btn_remove_leave_date').attr('disabled','disabled');
				}
			
			var ctr = data['ctr'];
				$('#ViewLeave_summary').empty();	
					var html  = '<table id="tbl_leave_records" class="table table-bordered">';
						html += '	<thead>';
						html += '		<tr>';
						// html += '			<th><center><font size="2">LEAVE APPLIED</font></center></th>';
						// html += '			<th><center><font size="2">REASON</font></center></th>';
						html += '			<th><center><font size="2">DATE ABSENT</font></center></th>';
						html += '			<th><center><font size="2">NO. OF DAYS</font></center></th>';
						html += '		</tr>';
						html += '	</thead>';
						html += '	<tbody>';
						html += '	</tbody>';
						html += '</table>';
					
				$('#ViewLeave_summary').append(html);	
			
			for(i=0;i<ctr;i++){
				var html  = '<tr id="'+data['pkid'][i]+'">';
					// html += '	<td style="text-align: center;font-size: 14px;">'+data['leave_applied'][i]+'</td>';	
					// html += '	<td style="text-align: center;font-size: 14px;">'+data['reason'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['date_absent_from'][i]+ ' - ' +data['date_absent_to'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_days'][i]+'</td>';	
					html += '</tr>';
				 $('#tbl_leave_records tbody').append(html);			
			}
			
			var oTable = $('#tbl_leave_records').DataTable({ 
				"paginate":true, 
				"aaSorting": [],
			});
			table_events();
			
			
			$("#tbl_leave_records tbody").on('click','#btn_edit_leave_date', function(e){ // edit leave date button
				e.preventDefault();
				
				if(confirm($(this).data('confirm'))){
					update_halfday($(this).val());
				} else {
					return false;
				}
				
			});
						
			$("#tbl_leave_records tbody").on('click','#btn_remove_leave_date', function(e){ // edit leave date button
				e.preventDefault();
				
				if(confirm($(this).data('confirm'))){
					remove_date($(this).val());
				} else {
					return false;
				}
				
			});
			
		},error	: function(data){
			alert(data);
		}
	});
}

function show_remarks(pkid) {
	var data = {
		"action"			: "show_remarks",
		"pkid"				: pkid
	}
	data = $.param(data);
	// alert(data);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data,
		url			: "elfs_handler.php",
		success		: function (result) {
		
			$('#IS_disapproved_remarks_show').val(result['IS_disapproved_remarks']);
			$('#DH_disapproved_remarks_show').val(result['DH_disapproved_remarks']);
			$('#HR_revise_remarks_show').val(result['HR_revised_remarks']);
			$('#show_remarks_modal').modal('show');
			
		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}
	
</script>
	
</html>