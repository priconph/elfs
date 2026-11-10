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
		
	#batchLeaveForApproval tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#batchLeaveForApproval tr.selected {
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
<div class="panel-heading">EMPLOYEE BATCH LEAVE SUMMARY</div>
	
	<div class="panel-body">	
		<div align='left'>
			<button type='submit' class="btn btn-primary" onClick="window.location = 'download_leave_filling.php?filename=MassFilling'">USER MANUAL &nbsp;<img src='images/pdf_download.png' height='30' width='35'> </button>
		</div>
		<table style="text-align:right; width: 100%;">
			<tr>
				<td>
				<form class="form-inline" role="form" method="POST" action="">
					<button type="button" class="btn btn-warning" id="btn_manage_batch_emp" name="btn_manage_batch_emp" title="Click this to add new batch leave">Manage Batch Employee</button></a>
					<button type="button" class="btn btn-primary" id="btn_new_leave" name="btn_new_leave" title="Click this to add new batch leave">Add New Batch Leave</button></a>
				</form>
				</td>
			</tr>
		</table>
	<form id="" method="get">
		<table id="EmpBatchLeave_tbl" name="EmpBatchLeave_tbl" class="table table-bordered" width="100%">
		<thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle;" class="hide">status</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">REMARKS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">REQUESTOR NAME</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" data-original-title="">EDIT/VIEW/CANCEL</th>
		 </tr>
		</thead>
		<tbody id="batchLeaveForApproval">
			<?php
			$result = ELFS::getInstance()->select_batch_leave_summary_for_approval($username);
				while($row = mysqli_fetch_array($result)){
				
				// 0-for approval, 1-approved by approver1, 2-approved by cmb_approver2, 3-conformed by hrd, 4-revise leave as per hrd, 5-Disapproved by approver1, 6-Disapproved by cmb_approver2				
				if($row['status'] == 0) {
					$status_label = '<div class="ui gray ribbon label">Pending for Approval</div>'; 
				} else if($row['status'] == 1) {
					$status_label = '<div class="ui green ribbon label">Approved by Immediate Supr.</div>'; 
				}	else if($row['status'] == 2) {
					$status_label = '<div class="ui green ribbon label">Approved by Dept. Head</div>'; 
				}	else if($row['status'] == 3) {
					$status_label = '<div class="ui blue ribbon label">Conformed</div>'; 
				}   else if($row['status'] == 4) {
					$status_label = '<div class="ui yellow ribbon label">For Revision</div>'; 
				}	else if($row['status'] == 5) {
					$status_label = '<div class="ui red ribbon label">Disapproved by Immediate Supr.</div>'; 
				}	else if($row['status'] == 6) {
					$status_label = '<div class="ui red ribbon label">Disapproved by Dept. Head</div>'; 
				}	else if($row['status'] == 7) {
					$status_label = '<div class="ui orange ribbon label">For Edit</div>'; 
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
				
				if($row['DH_disapproved_remarks'] != "" || $row['HR_revised_remarks'] != "") {
						$btn_view_remarks = '<button class="btn btn-danger" id="btn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
				} else {
						$btn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found."><span class="glyphicon glyphicon-comment"></span></button>';
				}
						
				if( $row['status'] == 0) {
						$btn_edit_batch_leave = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view batch leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
						$btn_edit_date_batch_leave = '<button class="btn btn-primary" id="btn_remove_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to remove date for batch leave application"><span class="glyphicon glyphicon-calendar"></span></button>';
						$btn_cancel_batch_leave = '<button class="btn btn-danger" id="btn_cancel_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to cancel batch leave application"><span class="glyphicon glyphicon-remove"></span></button>';
				} else	if($row['status'] == 2 || $row['status'] == 6) {
						$btn_edit_batch_leave = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view batch leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
						$btn_edit_date_batch_leave = '<button class="btn btn-primary" id="btn_remove_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view/remove date for batch leave application"><span class="glyphicon glyphicon-calendar"></span></button>';
						$btn_cancel_batch_leave = '<button class="btn btn-danger" style="border-radius: 0px;" disabled><span class="glyphicon glyphicon-remove"></span></button>';
				} else	if($row['status'] == 3) {
						$btn_edit_batch_leave = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view batch leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
						$btn_edit_date_batch_leave = '<button class="btn btn-primary" id="btn_remove_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view/remove date for batch leave application"><span class="glyphicon glyphicon-calendar"></span></button>';
						$btn_cancel_batch_leave = '<button class="btn btn-danger" style="border-radius: 0px;" disabled><span class="glyphicon glyphicon-remove"></span></button>';
				} else if($row['status'] == 7) {
						$btn_edit_batch_leave = '<button class="btn btn-warning" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to edit batch leave application"><span class="glyphicon glyphicon-pencil"></span></button>';
						$btn_edit_date_batch_leave = '<button class="btn btn-primary" id="btn_remove_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view/remove date for batch leave application"><span class="glyphicon glyphicon-calendar"></span></button>';
						$btn_cancel_batch_leave = '<button class="btn btn-danger" id="btn_cancel_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to cancel batch leave application"><span class="glyphicon glyphicon-remove"></span></button>';
				} else {
						$btn_edit_batch_leave = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view batch leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
						$btn_edit_date_batch_leave = '<button class="btn btn-primary" id="btn_remove_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view/remove date for batch leave application"><span class="glyphicon glyphicon-calendar"></span></button>';
						$btn_cancel_batch_leave = '<button class="btn btn-danger" style="border-radius: 0px;" disabled><span class="glyphicon glyphicon-remove"></span></button>';
				}
				
				echo "
					<tr>	
						<td style='display:none'>".$row['pkid']."</td>
						<td style='display:none'>".$row['status']."</td>
						<td style='font-family: Euphemia;' title='Double click to view list of batch employees'>".$status_label."</td>								
						<td style='font-family: Euphemia; text-align: center;' title='Double click to view list of batch employees'>".$btn_view_remarks."</td>
						<td style='text-align: center; font-size: 14px;' title='Double click to view list of batch employees'>".$row['Emp_Name']."</td>
						<td style='text-align: center; font-size: 13px;' title='Double click to view list of batch employees'>".date('F d, Y',strtotime($row['date_created']))."</td>
						<td style='text-align: center; font-size: 14px;' title='Double click to view list of batch employees'>".$leave_applied."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$btn_edit_batch_leave." ".$btn_edit_date_batch_leave." ".$btn_cancel_batch_leave."</td>
					</tr>
					";
					// <td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$btn_edit_batch_leave." ".$btn_edit_date_batch_leave." ".$btn_cancel_batch_leave."</td>

		}
		?>
		</tbody>
		</table>
	</form>
	</div>
</div> 

<!-- Modal new leave-->	
<div class="modal fade" id="BatchLeave_application_modal" role="dialog">
	<div class="modal-dialog" style="width:70%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4>EMPLOYEE BATCH LEAVE APPLICATION</h4>
			</div>
		<div class="modal-body" id="cont">	
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
					<label class="FormBatchLabel">Requestor Name:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="txt-FullName" name="txt-FullName" readonly>
					<br>
					<label class="FormBatchLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="EmpNo" name="EmpNo" readonly>
					<br>
					<label class="FormBatchLabel">Division:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="Division" name="Division" readonly>	
					<br>
					<label class="FormBatchLabel" for="cmb_approver2">Dept. Head:</label>
						<?php
						echo "<select id='cmb_approver2' name='cmb_approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' readonly>"; 
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
					<div id="panel_status" style="border:1px solid green;width:90%;height:8%;">
					<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="rbtn_wd" name="day_type" value="0"><b>&nbsp;&nbsp;WHOLE DAY</b>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="rbtn_hd" name="day_type" value="1"><b>&nbsp;&nbsp;HALF DAY</b>
					<br>
					<br>
					</div>
					
					<label class="FormBatchLabel">Date Absent:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText">
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From: *</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="date_absent_from" name="date_absent_from" autocomplete="off"  readonly>
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To: *</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="date_absent_to" name="date_absent_to" autocomplete="off"  readonly> 
					<br>
					<label class="FormBatchLabel">No. of days:</label>
					<input type="text" style="width:50px; height:5%;" class="FormBatchText" id="no_of_days" name="no_of_days" readonly>
					<br>
					<label class="FormBatchLabel">Reason/s:</label>
					<select id="reason" name="reason" style="width:220px; height:5%;" class="FormBatchText" readonly>	
						<option value="">--Select--</option>
						<option value="Special Holiday">Special Holiday</option>
						<option value="Shut-Down">Shut-Down</option>
					</select> 
					<br>
					<label class="FormBatchLabel"></label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText" id="leave_applied" name="leave_applied" value="1" Placeholder="Vacation Leave" readonly>	
					<br>
				</div>
				
			
			</div><!-- end row -->
			<div class="modal-footer">
				<button type="button" id="btn_save_batch_leave" data-confirm="Are you sure you want to save this leave?"  class="btn btn-primary" >SAVE</button>
				<button type="button" class="btn btn-danger" id="btn_close_leave" data-dismiss="modal">CLOSE</button>
			</div>
			</form>	
		</div>
		</div>
	</div>
</div>

<!-- Modal update leave-->	
<div class="modal fade" id="BatchLeave_application_update_modal" role="dialog">
	<div class="modal-dialog" style="width:70%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4>EMPLOYEE BATCH LEAVE APPLICATION</h4>
			</div>
		<div class="modal-body" id="cont">	
			<form action="#"> 
				<center><div id="alert_msg1" style="display:none;color:white;font-size: 14px;text-align:center;width:100%" class="row alert alert-danger"></div></center>
					<input type="hidden" id="update_txt_pkid" name="update_txt_pkid" value="<?php echo $pkid; ?>"> 
					<input type="hidden" id="update_txt_username" name="update_txt_username" value="<?php echo $username; ?>"> 
					<input type="hidden" id="update_fkEmployee" name="update_fkEmployee" value="<?php echo $fkEmployee; ?>"> 

			<div class="row">
				<div class="col-sm-6">	
					
					<br>
					<label class="FormBatchLabel">Date Created:</label>
					<input type="date" style="width:220px; height:5%;" class="FormBatchText" id="update_date_created" name="update_date_created" readonly>	
					<br>
					<label class="FormBatchLabel">Requestor Name:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_empName" name="update_empName" readonly>
					<br>
					<label class="FormBatchLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_EmpNo" name="update_EmpNo" readonly>
					<br>
					<label class="FormBatchLabel">Division:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_division" name="update_division" readonly>	
					<br>
					<label class="FormBatchLabel" for="update_cmb_approver2">Dept. Head:</label>
						<?php
						echo "<select id='update_cmb_approver2' name='update_cmb_approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' required readonly>"; 
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
					<input type="radio" id="update_rbtn_wd" name="update_day_type" value="0"><b>&nbsp;&nbsp;WHOLE DAY</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="update_rbtn_hd" name="update_day_type" value="1"><b>&nbsp;&nbsp;HALF DAY</b>
					<br>
					<br>
					
					<label class="FormBatchLabel">Date Absent:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText">
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_date_absent_from" name="update_date_absent_from" autocomplete="off"  readonly>
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="update_date_absent_to" name="update_date_absent_to" autocomplete="off"  readonly> 
					<br>
					<label class="FormBatchLabel">No. of days:</label>
					<input type="text" style="width:50px; height:5%;" class="FormBatchText" id="update_no_of_days" name="update_no_of_days" readonly>
					<br>
					<label class="FormBatchLabel">Reason/s:</label>
					<select id="update_reason" name="update_reason" style="width:220px; height:5%;" class="FormBatchText" readonly>	
						<option value=""></option>
						<option value="Special Holiday">Special Holiday</option>
						<option value="Shut-Down">Shut-Down</option>
					</select> 
					<br>
					<label class="FormBatchLabel"></label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText" id="update_leave_applied" name="update_leave_applied" value="1" Placeholder="Vacation Leave" readonly>	
					<br>
				</div>
				
			
			</div><!-- end row -->
			<div class="modal-footer">
				<button type="button" id="btn_update_batch_leave" data-confirm="Are you sure you want to update this leave?"  class="btn btn-success" >UPDATE</button>
				<button type="button" class="btn btn-danger" id="btn_close_batch_leave" data-dismiss="modal">CLOSE</button>
			</div>
			</form>	
		</div>
		</div>
	</div>
</div>

<!-- Modal Show remarks -->
<div class="modal fade" tabindex="-1" id="batch_show_remarks_modal" role="dialog">
	<div class="modal-dialog" style="width:35%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Leave Status Remarks</h4>
			</div>
		<div class="modal-body" id="cont">

		<label style="font-size: 14px;" >Disapproved by Dept. Head:</label>
		<center><textarea rows="3" id="DH_disapproved_remarks_show"  style="width:420px;" placeholder="N/A" readonly></textarea></center>
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

<!-- Modal cancelled leave-->	
<div class="modal fade" id="cancelled_leave_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-default">
          <h4 style="font-family:Euphemia">Cancel Leave Application</h4>
        </div>
		<div class="modal-body">
			<center><div id="alert_msg" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>
			<input type="hidden" id="cancel_txt_pkid" name="cancel_txt_pkid" value="<?php echo $pkid; ?>"> 

			  <label style="font-size: 14px;" for="cancelled_leave_remarks">Remarks</label>
			  <textarea class="form-control" rows="3" id="Cancelled_remarks"></textarea>

	    </div>
		<div class="modal-footer">
			<div style="float:right">
				<button type="button" id="btn_save_cancelled_leave" data-confirm="Are you sure you want to cancel this batch leave application?"  class="btn btn-success" >SAVE</button>
				<button type="button" class="btn btn-danger" id="btn_close_cancelled_leave">CANCEL</button>
			</div>
		</div>
      </div>
    </div>

</div> 

<!-- Modal manage batch leave -->
<div class="modal fade" tabindex="-1" role="dialog" id="manage_batch_emp">
	<div class="modal-dialog" style="width:85%">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">MANAGE BATCH EMPLOYEE </h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txt_EmpNo" name="txt_EmpNo" value="<?php echo $EmpNo; ?>"> <br>
				<input type="hidden" id="txt_hd_id" name="txt_hd_id" value="<?php echo $username; ?>"> <br>
				<table style="text-align:right; width: 100%;">
					<tr>
						<td>
							<form class="form-inline" role="form" method="POST" action="">
								<button type="button" class="btn btn-primary" id="btn_add_employee"> Add Employee</button>
								<button type="button" class="btn btn-warning" id="btn_remove_employee"> Remove Employee</button>
							</form>
						</td>
					</tr>
				</table>

				<div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered" id="tbl_subordinate">
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
			<button type="button" id="btn_close_view_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<!--modals add / remove employee-->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_employee">
  <div class="modal-dialog" role="document" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ADD EMPLOYEE</h4>
      </div>
      <div class="modal-body">
		<div class="error_message"></div>
		<div class="row" id="system_message"></div>
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-bordered" id="tbl_employee_list">
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
        <button type="button" class="btn btn-primary" id="btn-save_subordinate">ADD</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_remove_employee">
  <div class="modal-dialog" role="document" style="width:60%;">
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
        <button type="button" class="btn btn-warning" id="btn-remove_subordinate">REMOVE</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--end modals-->

<!-- Modal Remove Date -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_remove_date">
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
var edit_selected_pkid = "";

	$("#EmpBatchLeave_tbl").dataTable({
		"order": [],
		"columnDefs": [{
	    "targets"  : 'no-sort',
	    "orderable": false,
	}]});
	
	$("tbody tr").click(function() {
		console.log('clicked');
		$(this).addClass('selected').siblings().removeClass("selected");
	});
	
	$('#btn_new_leave').click(function(){
		$('#BatchLeave_application_modal').modal('show'); 
	});	
	
	$("#EmpBatchLeave_tbl tbody").on('click','tr #btn_view_leave', function(e){
		e.preventDefault();
		select_batch_leave_info_by_pkid($(this).val());
	});
	
	$("#EmpBatchLeave_tbl tbody").on('click','tr #btn_cancel_leave', function(e){
		e.preventDefault();
		select_batch_leave_info_for_cancel_by_pkid($(this).val());
	});	
	
	$('#btn_manage_batch_emp').click(function(){
		$('#manage_batch_emp').modal();
	});	

	$('#btn_close_cancelled_leave').click(function(){
		window.location.href = "batch_leave_summary.php";
	});	
	
	$('#btn_close_view_leave').click(function(){
		window.location.href = "batch_leave_summary.php";
	});	
	
	$('#btn_close_leave').click(function(){
		window.location.href = "batch_leave_summary.php";
	});	
		
	$("#EmpBatchLeave_tbl tbody").on('click','tr #btn_show_remarks', function(e){
		e.preventDefault();
		batch_show_remarks($(this).val());
	});
	
	$('#btn_close_batch_leave').click(function(){
		window.location.href = "batch_leave_summary.php";
	});	
		
	$("#EmpBatchLeave_tbl tbody").on('click','tr #btn_add_batch_emp', function(e){
		e.preventDefault();
		select_view_emp_leave($(this).val());
	});
	
	$("#EmpBatchLeave_tbl tbody").on('dblclick', 'tr', function(){
		var id = $(this).find('td:eq(0)').text();
		var status = $(this).find('td:eq(1)').text();
		window.location.href = "batch_emp_list.php?pkid="+id+'&status='+status;
	});	
	
	$('#btn_update_batch_leave').click(function(e){ 
		if($('#update_cmb_approver2').val() == '') { 
			$('#alert_msg1').show();
			$('#alert_msg1').append('Please select your Department Head!<br>');
		} else if($('#update_reason').val() == '') { 
			$('#alert_msg1').show();
			$('#alert_msg1').append('Please select your Reason!<br>');
		} else {
			$('#alert_msg1').hide();
			
		if(confirm($(this).data('confirm'))){
			e.preventDefault();
		} else {
			return false;
		}	
			
		var data = {
			"action"				 : 'update_batch_leave_record',
			"pkid"					 : $('#update_txt_pkid').val(),
			"fkEmployee"		 	 : $('#update_fkEmployee').val(),
			"status"				 : '7',
			"reason"				 : $('#update_reason').val(),
			"approver2"				 : $('#update_cmb_approver2').val(),
			"username"				 : "<?php echo $username; ?>"
		}
		
		data = $.param(data);
		// alert(data);
		$.ajax({
			type	: 'POST',
			dataType: 'json',
			data	: data,
			url		: 'update_batch_leave_record.php',
			success	: function(data){	
		
			var data1 = {
			"action"				 : 'Select_batch_leave_record_for_update',
			"pkid"					 : $('#update_txt_pkid').val(),
			"fkEmployee"		 	 : $('#update_fkEmployee').val(),
			"status"				 : '7',
			"reason"				 : $('#update_reason').val(),
			"approver2"				 : $('#update_cmb_approver2').val()
			}
			
			data1 = $.param(data1);
			// alert(data1);
			$.ajax({
				type	: "POST",
				dataType: "json",
				data	: data1,
				url		:"elfs_handler.php",
				success	: function (result) {			
						
				}, error: function (result) {
				}
			});
			
			alert("Batch Leave Application has been Updated!");
			window.location.href = "batch_leave_summary.php";
			
		}
		// ,error(data){
			// alert('ERROR MAIN');
		// }
	});
		}
	});	 
	
	$("#btn_save_cancelled_leave").click(function(e) {
	var checker = false;
	var status = 8;	

		if($('#Cancelled_remarks').val() == '') {
			alert('Please add remarks!');
			$('#cancelled_leave_modal').modal('show');
		} else {
			checker = true;
		} 
			
			
		if(checker) {	
			if(confirm($(this).data('confirm'))){
				e.preventDefault();
			} else {
				return false;
			}	
			update_batch_cancelled_leave($('#cancel_txt_pkid').val(),status);
		}
		
	});

	$('#btn_save_batch_leave').click(function(e){  	
		if($('#date_absent_from').val() == '') {
			$('#alert_msg').show();
			$('#alert_msg').append('Please select your Day Type and Date From!<br>');
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
			"created_by"		 : "<?php echo $username; ?>",
			"EmpNo"				 : $('#EmpNo').val(),
			"Division"		 	 : $('#Division').val(),
			"leave_applied"		 : '1',
			"day_type"			 : $('input[name="day_type"]:checked').val(),
			"approver2"			 : $('#cmb_approver2').val(),
			"reason"			 : $('#reason').val(),
			"username"			 : "<?php echo $username; ?>"
		}
		
		data = $.param(data);
		// alert(data);
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
				"created_by"		 : "<?php echo $username; ?>",
				"EmpNo"				 : $('#EmpNo').val(),
				"Division"		 	 : $('#Division').val(),
				"leave_applied"		 : '0',
				"day_type"			 : $('input[name="day_type"]:checked').val(),
				"approver2"			 : $('#cmb_approver2').val(),
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
					
						var pkid 			= result['pkid'];
						var created_by 		= result['created_by'];
						var EmpNo 			= result['EmpNo'];
						var leave_applied 	= result['leave_applied'];
					
						var data2 = {
							"pkid"					: result['pkid'],
							"created_by"			: result['created_by'],
							"EmpNo"					: result['EmpNo'],
							"leave_applied"			: result['leave_applied'],
							"date_absent_from"		: $('#date_absent_from').val(),
							"date_absent_to"		: $('#date_absent_to').val(),
							"no_of_days"			: $('#no_of_days').val(),
							"day_type"				: $('input[name="day_type"]:checked').val()
						}	
					
						data2 = $.param(data2);
						// alert(data2);
						$.ajax({
							type	: "post",
							dataType: "json",
							data	: data2,
							url		: "save_batch_leave_dates_as_drafts.php",
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
		minDate: '-2M, -1W',
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
		
		onSelect: function(dateText, inst) {
			$('#date_absent_to').datepicker("option", {
				minDate: new Date(dateText),
			});
		},
	});
	 
	dateTo.datepicker('destroy');
	dateTo.datepicker( { 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
		
		onSelect: function (dateStr) {
			var start = $("#date_absent_from").datepicker("getDate");
			var end = $("#date_absent_to").datepicker("getDate");
			var diff = calcBusinessDays(start,end);
			$("#no_of_days").val(diff);
		}
	});
	
	
	/* dateFrom.datepicker('destroy');
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
	}); */
		
	}  
	
	/* if ($("input[name='day_type']:checked").val() == 0 ){ //WHOLE DAY
		$("input[id='date_absent_from']").prop("disabled", false);
		// $("input[id='date_absent_to']").prop("disabled", true);
		$("input[id='date_absent_to']").prop("disabled", false);
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
			// var half = days / 2;
			$("#no_of_days").val(diff);
	}
	});
	} */

	else if ($("input[name='day_type']:checked").val() == 1 ){ // BIRTHDAY LEAVE
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
	
	$("#EmpBatchLeave_tbl tbody").on('click','tr #btn_remove_leave', function(e){
		e.preventDefault();
		select_batch_dates($(this).val());
	});
	
	var dropdown = document.getElementById("reason");
	dropdown.onchange = function(event){
		if(dropdown.value=="Special Holiday"){
			// alert("All Daily Employees are required to file a leave. And for Monthly and JS/SS no need to file a leave.")
			alert("All Daily Employees are required to file a leave!")
		}
	}

	/* Functions */
	function select_batch_leave_info_by_pkid(pkid) {
		var data1 = {
			"action"			 : "select_batch_leave_info_by_pkid",
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
			
			if(result['status'] == 0 || 
				result['status'] == 1 || 
				result['status'] == 2 || 
				result['status'] == 3 || 
				result['status'] == 5 || 
				result['status'] == 6 ||	
				result['status'] == 8) {	
				$('#update_rbtn_wd').prop('disabled', true);
				$('#update_rbtn_hd').prop('disabled', true);
				$('#update_cmb_approver2').prop('disabled', true);
				$('#update_date_absent_from').prop('disabled', true);
				$('#update_date_absent_to').prop('disabled', true);
				$('#update_reason').prop('disabled', true);
				$('#btn_update_batch_leave').prop('disabled', true);
			} 
			
			if (result['status'] == 7){
				$('#update_rbtn_wd').prop('disabled', true);
				$('#update_rbtn_hd').prop('disabled', true);
				$('#update_date_absent_from').prop('disabled', true);
				$('#update_date_absent_to').prop('disabled', true);
			}
			
			if(result['day_type'] == 0) {
				$('#update_rbtn_wd').prop('checked', true);
			} else if(result['day_type'] == 1) {
				$('#update_rbtn_hd').prop('checked', true);
			} 
			
			$('#update_date_created').val(result['date_created']);
			$('#update_empName').val(result['Emp_Name']);
			$('#update_EmpNo').val(result['EmpNo']);
			$('#update_division').val(result['Division']);
			$('#update_cmb_approver2').val(result['approver2']);
			$('#update_date_absent_from').val(result['date_from']);
			$('#update_date_absent_to').val(result['date_to']);
			$('#update_no_of_days').val(result['total_absent_days']);
			$('#update_reason').val(result['reason']);
			
			$('#update_txt_pkid').val(pkid);	
			$("#BatchLeave_application_update_modal").modal();
			
			}, error	: function (result) {
			alert('ERROR: '+result);
			}
		});
	}

	function select_batch_leave_info_for_cancel_by_pkid(pkid) { 
	var data1 = {
		"action"			 : "select_batch_leave_info_for_cancel_by_pkid",
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
			
		if(result['status'] == 8) {	
			$('#Cancelled_remarks').prop('disabled', true);
			$('#btn_save_cancelled_leave').prop('disabled', true);
		}
				
			$('#Cancelled_remarks').val(result['Cancelled_remarks']);
			$('#cancel_txt_pkid').val(pkid);	
			$("#cancelled_leave_modal").modal();
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
		// alert(data);
		$.ajax({
			type		: "POST",
			dataType	: "json",
			data		: data,
			url			: "elfs_handler.php",
			success		: function (result) {
			
				$('#DH_disapproved_remarks_show').val(result['DH_disapproved_remarks']);
				$('#Cancelled_remarks_show').val(result['Cancelled_remarks']);
				$('#batch_show_remarks_modal').modal('show');
				
			}, error	: function (result) {
				alert('ERROR: '+result);
			}
		});
	}	
	
	function update_batch_cancelled_leave(pkid,status) {
			
		var data = {
			"action"				 : "update_batch_cancelled_leave",
			"pkid"					 : pkid,
			"status"				 : status,
			"Cancelled_remarks"		 : $('#Cancelled_remarks').val(),
			"username"				 : "<?php echo $username; ?>"
		}
		data = $.param(data);
		// alert(data);
		$.ajax({
			type		: "POST",
			dataType	: "json",
			data		: data,
			url			: "update_batch_cancelled_leave.php",
			success		: function (result) {
			
			var data1 = {
					"action": "send_email_cancelled_leave",
					"pkid"	: pkid
				}
				data1 = $.param(data1);
				alert(data1);
				$.ajax({
					type	: "POST",
					dataType: "json",
					data	: data1,
					url		:"elfs_handler.php",
					success	: function (result) {					
					}, error: function (result) {
					}
				});
			
				alert('Successfully Updated!');
				window.location.href = "batch_leave_summary.php";

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
		// alert(data1);
		$.ajax({
			type		: "POST",
			dataType	: "json",
			data		: data1,
			url			: "elfs_handler.php",
			success		: function (result) {
			
			if(result['status'] == 7) {
				$('#txt_pkid_remove_leave').val(pkid);
				$('#modal_remove_date').modal();
				get_remove_leave_dates_summary(pkid);
			}	
			
			if(result['status'] == 0 || result['status'] == 2 || result['status'] == 3 || result['status'] == 6 || result['status'] == 8) {
				$('#txt_pkid_remove_leave').val(pkid);
				$('#modal_remove_date').modal();
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
		// alert(data);
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
							html += '			<th><center><font size="2">REMOVE</font></center></th>';
							html += '		</tr>';
							html += '	</thead>';
							html += '	<tbody>';
							html += '	</tbody>';
							html += '</table>';
						
					$('#remove_date_summary').append(html);	
				
				for(i=0;i<ctr;i++){
				
						if(data['day_type'][i] == 0) {	
							var disable = '';
						} else if (data['day_type'][i] == 1){
							var disable = 'disabled';
						} 
						
						if(data['status'][i] == 0 || data['status'][i] == 2 || data['status'][i] == 3 || data['status'][i] == 6 || data['status'][i] == 8) {	
						// if(data['status'][i] == 0) {	
							var disable = 'disabled';
						} 
						
						
						
					var html  = '<tr id="'+data['pkid'][i]+'">';
						html += '	<td style="text-align: center;font-size: 14px;">'+data['date_absent_from'][i]+ ' - ' +data['date_absent_to'][i]+'</td>';	
						html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_days'][i]+'</td>';	
						// html += '	<td style="text-align: center;font-size: 14px;"><button class="btn btn-warning" id="btn_edit_leave_date" data-confirm="Are you sure you want to set this date as halfday?" style="border-radius: 0px;" value="'+data['pkid_leave_date'][i]+'" title="Click to edit leave date"'+disable+'><span class="glyphicon glyphicon-pencil"></span></button> <button class="btn btn-danger" id="btn_remove_leave_date" data-confirm="Are you sure you want to remove this date?" style="border-radius: 0px;" value='+data['pkid_leave_date'][i]+' title="Click to remove leave date"'+enabled+'><span class="glyphicon glyphicon-trash"></span></button></td>';	
						html += '	<td style="text-align: center;font-size: 14px;"><button class="btn btn-danger" id="btn_remove_leave_date" data-confirm="Are you sure you want to remove this date?" style="border-radius: 0px;" value='+data['pkid_leave_date'][i]+' title="Click to remove leave date"'+disable+'><span class="glyphicon glyphicon-trash"></span></button></td>';	
					 $('#tbl_batch_date tbody').append(html);			
				}
				
				var oTable = $('#tbl_batch_date').DataTable({ 
					"paginate":true, 
					"aaSorting": [],
				});
				edit_table_events();
							
				$("#tbl_batch_date tbody").on('click','#btn_remove_leave_date', function(e){ // edit leave date button
					e.preventDefault();
					alert($(this).val());
					
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

	function edit_table_events(){
	$('#tbl_batch_date tbody tr').click(function(){
		edit_selected_pkid = "";
			$('#tbl_batch_date tbody tr').attr('style','');
			$(this).attr('style','background:teal;color:white;');
		edit_selected_pkid = this.id;
	});
	}
	
	function remove_date(pkid) {
			
		var data = {
			"action"				 : "remove_date",
			"pkid"					 : pkid
		}
		data = $.param(data);
		// alert(data);
		$.ajax({
			type		: "POST",
			dataType	: "json",
			data		: data,
			url			: "remove_date.php",
			success		: function (result) {
			
			alert('Successfully Removed!');
			window.location.href = "batch_leave_summary.php";
			}, error	: function (result) {
				alert('ERROR: '+result);
			}
		});
	}
	
	//End function
		
//////////////////////////////////////////////////////////////////////

var handler = 'handler/handler.php';
var array_empno = [];
var array_subordinate = [];
var username = $('#txt_hd_id').val();
var empno = '';

/* Datatables serverside configuration */
var tbl_emp_selection = $('#tbl_employee_list').DataTable({
	"sAjaxSource": "server_side_scripts/employee_list.php"
});

var tbl_subordinate = '';

/* Get Empno */
get_empno(username,function(result){
	tbl_subordinate = $('#tbl_subordinate').DataTable( {
		"sAjaxSource": "server_side_scripts/subordinate_list.php?SectionHead=" + empno
	});
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
$('#btn-save_subordinate').click(function(){ 
	save_subordinate(); 
});

$('#btn-remove_subordinate').click(function(){ 
	remove_subordinate();
});

$('#btn_add_employee').click(function(){ 
	$('#modal_add_employee').modal('show'); 
});

$('#btn_remove_employee').click(function(){ 
	if( array_subordinate.length == 0 ){
		var message  = '<div class="alert alert-danger">';
			message += ' <center><h3>There are no record selected!</h3></center>';
			message += '</div>';
		system_message_modal(message);
	}
	subordinate_for_removal();
	$('#modal_remove_employee').modal('show');
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
			$('#modal_remove_employee .modal-body .content').empty();
			$('#modal_remove_employee .modal-body .content').append(result['html']);
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
				message += ' <center><h3>The following employee has been removed from your batch list!</h3></center>';
				message += '</div>';
			system_message_modal(message);
			tbl_subordinate.ajax.reload();
			tbl_emp_selection.ajax.reload();
			array_subordinate = [];
			array_empno = [];
			$('#modal_remove_employee .modal-body .content').empty();
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