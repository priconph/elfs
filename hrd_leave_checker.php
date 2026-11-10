<?php
    include("includes.php");
	require_once("elfs_oop.php");
	// session_start();

	// $username = $_SESSION['username'];
	// $username = 'marbonc';

	$result = ELFS::getInstance()->getEmpNo($username);
		while($row = mysqli_fetch_array($result)){
		$EmpNo = $row['EmpNo'];
	} 

	$result = ELFS::getInstance()->getEmpInfo($EmpNo);
		while($rowEmpInfo = mysqli_fetch_array($result)){
		 $empName 			= $rowEmpInfo['FirstName'] . " " .$rowEmpInfo['LastName'];
		 $department 		=  $rowEmpInfo['Department'];
		 $division 			=  $rowEmpInfo['Division'];
		 $regularity_date 	=  $rowEmpInfo['regularity_date'];
		 $CityAddress2 		=  $rowEmpInfo['CityAddress2'];
		 $CityAddress3 		=  $rowEmpInfo['CityAddress3'];
	}
	
	$result = ELFS::getInstance()->getEmpLeaveBalance($EmpNo);
		while($rowEmpInfo = mysqli_fetch_array($result)){
		 $previous_balance_VL	=  $rowEmpInfo['previous_balance_VL'];
		 $credit_VL 			=  $rowEmpInfo['credit_VL'];
		 $current_avail_VL 		=  $rowEmpInfo['current_avail_VL'];
		 $total_VL_used 		=  $rowEmpInfo['total_VL_used'];
		 $total_VL_balance 		=  $rowEmpInfo['total_VL_balance'];
		 $previous_balance_SL	=  $rowEmpInfo['previous_balance_SL'];
		 $credit_SL 			=  $rowEmpInfo['credit_SL'];
		 $current_avail_SL 		=  $rowEmpInfo['current_avail_SL'];
		 $total_SL_used 		=  $rowEmpInfo['total_SL_used'];
		 $total_SL_balance 		=  $rowEmpInfo['total_SL_balance'];
	}
				
	if(isset($_GET['month'])){
		$month = $_GET['month'];
	} else {
		$month = '';
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
	
	#total_VL_used {
		color: #DE2A00;
	}
	
	#total_SL_used {
		color: #DE2A00;
	}
	
	.modal-body {
		max-height: calc(110vh - 210px);
		overflow-y: auto;
	}
	
	.glyphicon.glyphicon-remove {
		font-size: 25px;
	}
	
	.glyphicon.glyphicon-ok {
		font-size: 25px;
	}
	
	.glyphicon.glyphicon-remove-sign {
		font-size: 15px;
	}
		
</style>
</head>
<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>

<div class="panel panel-primary" style="margin:auto; width:95%;">
	<div class="panel-heading">EMPLOYEE LEAVE CHECKER</div>
		<div class="panel-body">	
		<br>
	
		<form id="" method="get">
			<table id="leave_app_tbl" name="leave_app_tbl" class="display nowrap" cellspacing="0" width="100%">
				 <thead>
					<tr>
						<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Remarks" data-original-title="">REMARKS</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee No." data-original-title="">EMPLOYEE NO.</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
						<!--
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Adress during leave" data-original-title="">ADDRESS DURING LEAVE</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Other address during leave" data-original-title="">OTHER ADDRESS DURING LEAVE</th>
						-->
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Reason/s" data-original-title="">REASON</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Other Reason/s" data-original-title="">OTHER REASON</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total # of leaves" data-original-title="">TOTAL # OF LEAVE(S)</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Immediate Superior" data-original-title="">IMMEDIATE SUPERIOR</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Sec/Dept. Head" data-original-title="">SEC/DEPT. HEAD</th>
					</tr>
				  </thead>
				  <tbody id="leaveHistory">
					<?php
					$result = ELFS::getInstance()->select_all_leave_application();
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
						}	
					
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
						}	else if($row['status'] == 9) {
							$status_label = '<div class="ui red ribbon label">Cancelled by HR</div>'; 
						}	

						if($row['IS_disapproved_remarks'] != "" || $row['DH_disapproved_remarks'] != "" || $row['HR_revised_remarks'] !="" || $row['HR_cancel_remarks'] !="" || $row['Cancelled_remarks'] !="" ) {
								$hbtn_view_remarks = '<button class="btn btn-danger" id="cbtn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
						} else {
								$hbtn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found." disabled><span class="glyphicon glyphicon-comment"></span></button>';
						}
						
						if($row['status'] == 3) {
								$btn_cancel = '<button class="btn btn-danger" id="btn_cancel" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to cancel leave application"><span class="glyphicon glyphicon-remove"></span></button>';
						} else {
								$btn_cancel = '<button class="btn btn-default" style="border-radius: 0px;" ><span class="glyphicon glyphicon-remove"></span></button>';
						} 
						
						if($row['approver1'] == '0') {
								$approver1_name = 'N/A';
						} else {
								$approver1_name = $row['approvername1']; 
						} 
						
						if($row['address'] == '') {
								$address_lbl = 'N/A';
						} else {
								$address_lbl = $row['address']; 
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
						
						$pkid = $row['pkid'];	
						echo "
							<tr title='Double click to view leave dates.'>	
								<td style='display:none'>".$pkid."</td>
								<td style='font-size: 13px;'>".$status_label."</td>
								<td style='text-align: center; font-size: 13px;'>".$hbtn_view_remarks."</td>
								<td style='text-align: center; font-size: 13px;'>".date('F d, Y',strtotime($row['date_created']))."</td>
								<td style='text-align: center; font-size: 13px;'>".$row['EmpNo']."</td>
								<td style='text-align: left; font-size: 13px;'>".$row['FirstName']." ".$row['LastName']."  </td>
								<td style='text-align: center; font-size: 13px;'>".$leave_applied."</td>
								<td style='text-align: center; font-size: 13px;'>".$reason_label."</td>
								<td style='text-align: left; font-size: 13px;'>".$row['reason']."</td>
								<td style='text-align: center; font-size: 13px;'>".$row['total_absent_days']."</td>
								<td style='text-align: center; font-size: 13px;'>".$approver1_name."</td>
								<td style='text-align: center; font-size: 13px;'>".$row['approvername2']."</td>
							</tr>
							";

							}
								// <td style='text-align: center; font-size: 13px;'>".$row['emp_address']."</td>
								// <td style='text-align: center; font-size: 13px;'>".$address_lbl."</td>

					?>
				</tbody>
			</table>  
		</form>  
	</div>
</div> 

<!-- Modal update leave-->	
<div class="modal fade" id="Leave_application_modal_update" role="dialog">
	<div class="modal-dialog" style="width:85%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4>EMPLOYEE LEAVE APPLICATION</h4>
			</div>
			<div class="modal-body" id="cont">	
			<form action="#" id="form_UpdateLeave">
			 <center><div id="alert_msg" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>
				<input type="hidden" id="update_txt_pkid" name="update_txt_pkid" value="<?php echo $pkid; ?>"> 
				<input type="hidden" id="update_txt_username" name="update_txt_username" value="<?php echo $username; ?>"> 
				
			<div class="row">
				<div class="col-sm-6">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-danger">
							<div class="panel-heading" role="tab" id="headingOne">
							  <h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="color: white;">
								  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp; Additional Information
								</a>
							  </h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
							  <div class="panel-body">
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Cut-off Information:</strong></p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;30 - 14 and 15 - 29</p><br>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Birthday Leave</strong>	- 1 Day (Birth Month)</p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Bereavement Leave</strong>  - 3 Days</p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Maternity Leave</strong>  - Normal (60 Days) and CS (78 Days) <b>Without pay.</b></p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Paternity Leave </strong>  - 7 Working days</p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Solo Parent Leave</strong>  - 7 Working days (Must present SOLO parent ID card from DSWD)</p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> *Special Leave Benefit for Women (SLBW) </strong>  - 60 days for every instance of surgery.</p>
							  </div>
							</div>
						</div>
					</div> 
					<br>
				
					<label class="FormLabel">Date Created:</label>
					<input type="date/time" style="width:220px; height:4%;" class="FormText" id="update_date_created" name="update_date_created" readonly>	
					<br>
					
					<label class="FormLabel">Employee Name:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="update_empName" name="update_empName" readonly>
					<br>
					
					<label class="FormLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="update_EmpNo" name="update_EmpNo" readonly>
					<br>
					
					<label class="FormLabel">Division:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="update_division" name="update_division" readonly>	
					<br>
					
					<label class="FormLabel">Address during leave:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="update_emp_address" name="update_emp_address" readonly>	
					<br>
					
					<input class="FormLabel" type="radio" id="lbl_radio_update_otherAdd" name="update_radio_OthersAdd" value="1" disabled>
					<label style="width:220px; font-size: 14px; ">Others <i>(Leave Address)</i></label>
					<br>
					
					<label class="FormLabel"></label>
					<textarea rows="2" style="width:220px;" id="update_address" name="update_address" readonly ></textarea>
					<br>
					
					<label class="FormLabel">Date of Absent/s:</label>
					<input type="hidden" style="width:220px; height:4%;" class="FormText" >
					<br>
					
					<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
					<input type="date" style="width:220px; height:4%;" class="FormText" id="update_date_absent_from" name="update_date_absent_from" readonly >
					<br>
					
					<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
					<input type="date" style="width:220px; height:4%;" class="FormText" id="update_date_absent_to" name="update_date_absent_to" readonly>
					<br>
					
					<label class="FormLabel">No. of days:</label>
					<input type="text" style="width:50px; height:4%;" class="FormText" id="update_no_of_days" name="update_no_of_days" readonly>
					<br>
					<label class="FormLabel">Immediate Superior:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="update_cmb_approver1" name="update_cmb_approver1" readonly>	
					<br> 					
					<label class="FormLabel">Sec/Department Head:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="update_cmb_approver2" name="update_cmb_approver2" readonly>	
					<br>
				</div>

				<div class="col-sm-5">
					<div class="panel panel-warning" id="update_leave_status" style="width:100%;">
						<div class="panel-heading">
							<div class="row">
								<div class="col-sm-12"><b>LEAVE STATUS</b></div>
							</div>
						</div>
					<div class="panel-body">
					<div class="row">
					<div class="col-sm-12">
							
					<div class="panel panel-warning" id="update_leave_status" style="width:100%;">
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-12">
									
									<input class="FormLeaveApplied" type="radio" id="update_rbtn_conformed" name="status" value="3">
									<label style="font-size: 14px;" id="lbl_comformed">Conformed Leave</label>
									<input class="FormLeaveApplied" type="radio" id="update_rbtn_cancel" name="status" value="9">
									<label style="font-size: 14px;" id="lbl_revise">Cancel Leave</label>
									<br>
									<input class="FormLeaveApplied" type="radio" id="update_rbtn_revise" name="status" value="4">
									<label style="font-size: 14px;" id="lbl_cancel">Revise Leave</label>
								</div>
							</div>			
						</div>			
					</div>
											
					<center><label class="FormLabel" id ="select_month">Select a Month:</label>
					<br>
				<!--	<input type="month" pattern="[0-9]*" id="cutoff_date" value="<?php echo $month; ?>" disabled>-->
					<input type="month" pattern="[0-9]*" id="cutoff_date" value="<?php echo $month; ?>" disabled>
					</center>
					<br>
					&nbsp;&nbsp;
					<input class="FormLeaveApplied" type="radio" id="first_cutoff" name="cutoff" value="1" disabled>
					<label style="font-size: 14px;" id="lbl_first_cutoff">1st Cut-Off</label>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input class="FormLeaveApplied" type="radio" id="second_cutoff" name="cutoff" value="2" disabled>
					<label style="font-size: 14px;" id="lbl_second_cutoff">2nd Cut-Off</label>
					<br>						
							
					</div>
					</div>			
					</div>			
					</div>	
					<div class="panel panel-success" id="update_leave_applied" style="width:100%;">
						<div class="panel-heading">
							<div class="row">
								<div class="col-sm-12"><b>LEAVE APPLIED</b></div>
							</div>
						</div>
					<div class="panel-body">
					<div class="row" id="div_leave_type">
						<div class="col-sm-6">
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_sl" name="leave_applied" value="0" disabled>
							<label style="font-size: 14px;" id="lbl_sl">Sick Leave</label>
							<br>
							
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_vl" name="leave_applied" value="1" disabled>
							<label style="font-size: 14px;" id="lbl_vl">Vacation Leave</label>
							<br>
							
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_bdl" name="leave_applied" value="2" disabled>
							<label style="font-size: 14px;" id="lbl_bdl">Birthday Leave</label>
							<br>
							
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_pl" name="leave_applied" value="4" disabled>
							<label style="font-size: 14px;" id="lbl_bdl">Paternity Leave</label>
							<br>

						</div>
						<div class="col-sm-6">														
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_bl" name="leave_applied" value="5" disabled>
							<label style="font-size: 14px;" id="lbl_bdl">Bereavement Leave</label>
							<br>
							
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_sp" name="leave_applied" value="6" disabled>
							<label style="font-size: 14px;" id="lbl_bdl">Solo Parent Leave</label>
							<br>
							
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_ml" name="leave_applied" value="3" disabled>
							<label style="font-size: 14px;" id="lbl_bdl">Maternity Leave</label>
							<br>
							
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_slbw" name="leave_applied" value="7" disabled>
							<label style="font-size: 14px;" id="lbl_slbw">SLBW</label>

						</div>			
					</div>			
					</div>			
					</div>		
					<label class="FormLabel">Reason/s *:</label>
					<select style="width:220px; height:5%;" class="FormText" id="update_other_reason" name="update_other_reason" disabled>
					  <option value="0"></option>
					  <option value="1">Shut-down</option>
					  <option value="2">Special Non-working Holiday</option>
					  <option value="3">Others</option>
					</select>						
					<br>
					
					<label class="FormLabel"></label>
					<textarea rows="3" style="width:220px;" class="FormText" id="update_reason" name="update_reason" disabled></textarea>
					<br>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_send_update_leave" data-confirm="Are you sure you want to conformed / for revision / cancel this leave application?" class="btn btn-primary">SEND</button>
				<button type="button" id="btn_cancel_update_leave" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
			</div>
			</form>	
		</div>
		</div>
	</div>
</div>

<!-- Modal revise leave-->	
  <div class="modal fade" id="revise_leave_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-default">
          <h4 style="font-family:Euphemia">Revise Leave Application</h4>
        </div>
		<div class="modal-body">
			<center><div id="alert_msg2" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>
			<div class="form-group">
			  <label style="font-size: 14px;" for="revise_leave_remarks">Remarks</label>
			  <textarea class="form-control" rows="3" id="HR_revised_remarks"></textarea>
			</div>
		</div>
		<div class="modal-footer">
			<div style="float:right">
				<button class="btn btn-primary" id="btn_save_revise_leave" data-save="modal">SAVE</button>
				<button class="btn btn-danger" id="btn_close_revise_leave">CANCEL</button>
			</div>
		</div>
      </div>
    </div>
  </div> 
  
  <!-- Modal cancel leave-->	
  <div class="modal fade" id="cancel_leave_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-default">
          <h4 style="font-family:Euphemia">Cancel Leave Application</h4>
        </div>
		<div class="modal-body">
			<center><div id="alert_msg2" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>
			<div class="form-group">
			  <label style="font-size: 14px;" for="revise_leave_remarks">Remarks</label>
			  <textarea class="form-control" rows="3" id="HR_cancel_remarks"></textarea>
			</div>
		</div>
		<div class="modal-footer">
			<div style="float:right">
				<button class="btn btn-primary" id="btn_save_cancel_leave" data-save="modal">SAVE</button>
				<button class="btn btn-danger" id="btn_close_cancel_leave">CANCEL</button>
			</div>
		</div>
      </div>
    </div>
  </div> 
  
    <!-- Modal cancel leave once conformed-->	
  <div class="modal fade" id="cancel_conformed_leave_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header modal-header-default">
          <h4 style="font-family:Euphemia">Cancel Leave Application</h4>
        </div>
		<div class="modal-body">
			<center><div id="alert_msg3" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>
			<div class="form-group">
			  <input type="hidden" id="cancel_txt_pkid" name="cancel_txt_pkid" value="<?php echo $pkid; ?>"> 

			  <label style="font-size: 14px;" for="revise_leave_remarks">Remarks</label>
			  <textarea class="form-control" rows="3" id="HR_cancel_conformed_leave_remarks"></textarea>
			</div>
		</div>
		<div class="modal-footer">
			<div style="float:right">
				<button class="btn btn-primary" id="btn_save_cancel_conformed_leave" data-confirm="Are you sure you want to cancel this leave application?" data-save="modal">SAVE</button>
				<button class="btn btn-danger" id="btn_close_cancel_conformed_leave">CANCEL</button>
			</div>
		</div>
      </div>
    </div>
  </div> 

<!-- Modal Show remarks -->
<div class="modal fade" tabindex="-1" id="show_remarks_modal" role="dialog">
	<div class="modal-dialog" style="width:40%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Leave Status Remarks</h4>
			</div>
		<div class="modal-body" id="cont">
			<input type="hidden" id="pkid_remarks" name="pkid_remarks" value="<?php echo $pkid; ?>"> 

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
			<br>
			<br>
		
			<label style="font-size: 14px;" >Cancelled Leave by HR:</label>
			<center><textarea rows="3" id="HR_cancel_remarks_show" style="width:420px;" placeholder="N/A" readonly></textarea></center>
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

<!-- Modal View Leave -->
<div class="modal fade" tabindex="-1" role="dialog" id="view_emp_leave">
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
			<button type="button" id="btn_close_view_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

</body>

<script type="text/javascript">
$(document).ready(function(){
	$("#leave_tbl_hrd").dataTable({"order": [],
	"columnDefs": [ {
	  "targets"  : 'no-sort',
	  "orderable": false,
	}]});
});

/* $("#leave_history_tbl").dataTable({
	"scrollX"		: true
});

$("#leave_app_tbl").dataTable({
	"scrollX"		: true
}); */

$(document).ready(function(){
	$("#leave_history_tbl").dataTable({"order": [],
		"columnDefs": [ {
		"targets"  : 'no-sort',
		"orderable": false,
	}]});
});

$(document).ready(function(){
	$("#leave_app_tbl").dataTable({"order": [],
		"columnDefs": [ {
		"targets"  : 'no-sort',
		"orderable": false,
	}]});
}); 

$("tbody tr").click(function() {
	console.log('clicked');
	$(this).addClass('selected').siblings().removeClass("selected");
});

$('#btn_close_view_leave').click(function(){
	window.location.href = "http://systemone/elfs/hrd_index.php?page=hrd_leave_summary.php";
});

$('#btn_close_cancel_conformed_leave').click(function(){
	window.location.href = "http://systemone/elfs/hrd_index.php?page=hrd_leave_summary.php";
});

$("#leave_tbl_hrd tbody").on('click','tr #btn_show_remarks', function(e){
	e.preventDefault();
	show_remarks($(this).val());
});

$("#leave_history_tbl tbody").on('click','tr #hbtn_show_remarks', function(e){ //leave history button
	e.preventDefault();
	show_remarks($(this).val());
});

$("#leave_app_tbl tbody").on('click','tr #cbtn_show_remarks', function(e){ //leave history button
	e.preventDefault();
	show_remarks($(this).val());
});

$("#leave_tbl_hrd tbody").on('click','tr #btn_view_leave', function(e){
	e.preventDefault();
	select_leave_info_by_pkid($(this).val());
});

$("#leave_tbl_hrd tbody").on('dblclick', 'tr', function(){
	$("#modal-body input").val("");	
	select_view_emp_leave($(this).find("td:eq(0)").text());
});

$("#leave_history_tbl tbody").on('dblclick', 'tr', function(){
	$("#modal-body input").val("");	
	select_view_emp_leave($(this).find("td:eq(0)").text());
});

$("#leave_app_tbl tbody").on('dblclick', 'tr', function(){
	$("#modal-body input").val("");	
	select_view_emp_leave($(this).find("td:eq(0)").text());
});

$("tbody tr").click(function() {
	console.log('clicked');
	$(this).addClass('selected').siblings().removeClass("selected");
});

$('#btn_cancel_update_leave').click(function(){
	window.location.href = "http://systemone/elfs/hrd_index.php?page=hrd_leave_summary.php";
});	

$("#update_rbtn_conformed").click(function(){
	$("input[id='cutoff_date']").prop("disabled", false);
	$("input[id='first_cutoff']").prop("disabled", false);
	$("input[id='second_cutoff']").prop("disabled", false);
});

/* Revise Leave */
$("#update_rbtn_revise").click(function(){
	$("input[id='cutoff_date']").prop("disabled", true);
	$("input[id='first_cutoff']").prop("disabled", true);
	$("input[id='second_cutoff']").prop("disabled", true);
	$('#revise_leave_modal').modal('show');
});

$('#btn_close_revise_leave').click(function(){
	$('#revise_leave_modal').modal('hide');
	$('#update_rbtn_revise').attr("checked", false);
	$('#HR_revised_remarks').val('');
});	

$('#btn_save_revise_leave').click(function(){
	if($('#HR_revised_remarks').val() != '') {
		$('#revise_leave_modal').modal('hide');
	} else {
		$('#alert_msg2').show();
		$('#alert_msg2').append('Please add remarks!<br>');
	}
});	

/* Cancel Leave once Conformed */
$("#leave_history_tbl tbody").on('click','tr #btn_cancel', function(e){
	e.preventDefault();
	cancel_conformed_leave_by_pkid($(this).val());
});

/* Cancel Leave */
$("#update_rbtn_cancel").click(function(){
	$("input[id='cutoff_date']").prop("disabled", true);
	$("input[id='first_cutoff']").prop("disabled", true);
	$("input[id='second_cutoff']").prop("disabled", true);
	$('#cancel_leave_modal').modal('show');
});

$('#btn_close_cancel_leave').click(function(){
	$('#cancel_leave_modal').modal('hide');
	$('#update_rbtn_cancel').attr("checked", false);
	$('#HR_cancel_remarks').val('');
});	

$('#btn_save_cancel_leave').click(function(){
	if($('#HR_cancel_remarks').val() != '') {
		$('#cancel_leave_modal').modal('hide');
	} else {
		$('#alert_msg2').show();
		$('#alert_msg2').append('Please add remarks!<br>');
	}
});	

$("#btn_send_update_leave").click(function(e) {
	var checker = false;
	if($('#update_rbtn_conformed').is(':checked') || $('#update_rbtn_revise').is(':checked') || $('#update_rbtn_cancel').is(':checked')) {
		 if($('#update_rbtn_conformed').is(':checked')) {
		 var status = 3;
		 checker = true;
			
			if($('#cutoff_date').val() == '') {
				$('#alert_msg').show();
				$('#alert_msg').append('Please select a month!<br>');
				$("#select_month").css("color", 'red');    
			} else {
				$("#select_month").css("color", 'black');    
			}
						
			var checker = false;
			if ($('#first_cutoff').prop('checked') == true) {
				var cutoff = 1;
				checker = true;
			} 
			else if ($('#second_cutoff').prop('checked') == true) {
				var cutoff = 2;
				checker = true;
			} else {
				$('#alert_msg').show();
				$('#alert_msg').append('Please select cut off type!<br>');
				$("#lbl_first_cutoff").css("color", 'red');
				$("#lbl_second_cutoff").css("color", 'red');    
				$("#lbl_comformed").css("color", 'black');
				$("#lbl_revise").css("color", 'black');    
			}	

		} else if($('#update_rbtn_revise').is(':checked')) {
			var status = 4;	
			if($('#HR_revised_remarks').val() == '') {
				alert('Please add remarks!');
				$('#revise_leave_modal').modal('show');
			} else {
				checker = true;
			} 
		} else if($('#update_rbtn_cancel').is(':checked')) {
			var status = 9;	
			if($('#HR_cancel_remarks').val() == '') {
				alert('Please add remarks!');
				$('#cancel_leave_modal').modal('show');
			} else {
				checker = true;
			} 
		}
		if(checker) {	
			if(confirm($(this).data('confirm'))){
				e.preventDefault();
			} else {
				return false;
			}
			update_hrd_status($('#update_txt_pkid').val(),status,cutoff);
		}
		
	} else {
		$('#alert_msg').show();
		$('#alert_msg').append('Please select leave status!<br>');
		$("#lbl_comformed").css("color", 'red');
		$("#lbl_revise").css("color", 'red');    
		$("#lbl_cancel").css("color", 'red');    
	}

});

$("#btn_save_cancel_conformed_leave").click(function(e) {
var checker = false;
var status = 9;	

	if($('#HR_cancel_conformed_leave_remarks').val() == '') {
		$('#alert_msg3').show();
		$('#alert_msg3').append('Please add your remarks!<br>');
		$('#cancel_conformed_leave_modal').modal('show');
	} else {
		checker = true;
	} 
		
	if(checker) {	
	
		if(confirm($(this).data('confirm'))){
			e.preventDefault();
		} else {
			return false;
		}	
		update_leave_conformed_status($('#cancel_txt_pkid').val(),status);
	}
	
});

/* Function */
function update_hrd_status(pkid,status,cutoff) {

var data = {
	"action"				 : "update_hrd_status",
	"pkid"					 : pkid,
	"status"				 : status,
	"cutoff"				 : cutoff,
	"empno"					 : $('#update_EmpNo').val() != '' ? $('#update_EmpNo').val() : '',
	"update_no_of_days"		 : $('#update_no_of_days').val() != '' ? $('#update_no_of_days').val() : '',
	"leave_applied"		 	 : get_selected_leave_applied(),
	"cutoff_date"	 	 	 : cutoff == 1 ? $('#cutoff_date').val()+'-10' : $('#cutoff_date').val()+'-20',
	"HR_revised_remarks"	 : $('#HR_revised_remarks').val(),
	"HR_cancel_remarks"		 : $('#HR_cancel_remarks').val(),
	"username"				 : "<?php echo $username; ?>"
}
data = $.param(data);
// alert(data);
$.ajax({
	type		: "POST",
	dataType	: "json",
	data		: data,
	url			: "update_hrd_status2.php",
	success		: function (result) {
	 	console.log(result);
		
	if(status == 3){
		var data1 = {
		"action": "send_email_from_hrd",
		"pkid"	: pkid
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
	
	} else if(status == 4){
		
		var data2 = {
			"action": "send_email_from_hrd_revise",
			"pkid"	: pkid
		}
		data2 = $.param(data2);
		// alert(data2);
		$.ajax({
			type	: "POST",
			dataType: "json",
			data	: data2,
			url		:"elfs_handler.php",
			success	: function (result) {					
			}, error: function (result) {
			}
		});
	} else if (status == 9){
		
		var data2 = {
			"action": "send_email_from_hrd_cancelled",
			"pkid"	: pkid
		}
		data2 = $.param(data2);
		// alert(data2);
		$.ajax({
			type	: "POST",
			dataType: "json",
			data	: data2,
			url		:"elfs_handler.php",
			success	: function (result) {					
			}, error: function (result) {
			}
		});
	}
	
	alert('Successfully Updated!');
	window.location.href = "http://systemone/elfs/hrd_index.php?page=hrd_leave_summary.php";

	}, error	: function (result) {
		alert('ERROR: '+result);
	}
});
}

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
		
		if(result['status'] == 3) {	
			$('#btn_send_update_leave').prop('disabled', true);
			$('#update_rbtn_conformed').prop('checked', true);
			$('#update_rbtn_conformed').prop('disabled', true);
			$('#update_rbtn_revise').prop('disabled', true);
			$('#update_rbtn_cancel').prop('disabled', true);
			
			$('#cutoff_date').prop('disabled', true);
			$('#first_cutoff').prop('disabled', true);
			$('#second_cutoff').prop('disabled', true);

		} else if(result['status'] == 4) {	
			$('#btn_send_update_leave').prop('disabled', true);
			// $('#update_rbtn_conformed').prop('checked', true);
			$('#update_rbtn_conformed').prop('disabled', true);
			$('#update_rbtn_revise').prop('checked', true);
			$('#update_rbtn_revise').prop('disabled', true);
		} 
	
		if(result['approver1'] == 0) {	
			$('#update_cmb_approver1').val('N/A');
		} else {
			$('#update_cmb_approver1').val(result['approver1_name']);
		}
		
		if(result['address'] == '') {	
			$('#update_address').val('N/A');
		} else {
			$('#update_address').val(result['address']);
		}
		
		$('#update_date_created').val(result['date_created']);
		$('#update_empName').val(result['Emp_Name']);
		$('#update_EmpNo').val(result['EmpNo']);
		$('#update_division').val(result['Division']);
			
		if(result['cutoff'] == 1) {
			$('#first_cutoff').prop('checked', true);
		} else if(result['cutoff'] == 2) {
			$('#second_cutoff').prop('checked', true);
		} 
		
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
		
		
		if(result['radio_OthersAdd'] == 1) {
			$('#lbl_radio_update_otherAdd').prop('checked', true);
		} else {
			$('#lbl_radio_update_otherAdd').prop('checked', false);
		}	
		
		$('#update_date_absent_from').val(result['date_from']);
		$('#update_date_absent_to').val(result['date_to']);
		$('#update_no_of_days').val(result['total_absent_days']);
		// $('#update_reason').val(result['reason']);
		$('#update_emp_address').val(result['emp_address']);
		$('#update_cmb_approver2').val(result['approver2_name']);
		
		if(result['other_reason'] == 0 || result['other_reason'] == 1 || result['other_reason'] == 2 || result['other_reason'] == 3) {	
			$('#update_reason').val(result['reason']);
			$('#update_other_reason').val(result['other_reason']);
		} else {
			$('#update_reason').val(result['reason']);
		}
			
			
		$('#update_txt_status').val(result['status']);	
		$('#update_txt_pkid').val(pkid);	
		$("#Leave_application_modal_update").modal();
	}, error	: function (result) {
	alert('ERROR: '+result);
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
			console.log(result);
			
			$('#IS_disapproved_remarks_show').val(result['IS_disapproved_remarks']);
			// $('#IS_disapproved_remarks_show').val(result['disapproved_label']+ ':' +' '+ result['IS_disapproved_remarks']);
			$('#DH_disapproved_remarks_show').val(result['DH_disapproved_remarks']);
			$('#HR_revise_remarks_show').val(result['HR_revised_remarks']);
			$('#Cancelled_remarks_show').val(result['Cancelled_remarks']);
			$('#HR_cancel_remarks_show').val(result['HR_cancel_remarks']);
			$('#show_remarks_modal').modal('show');
			
		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}

function get_selected_leave_applied(){
	var leave_applied = '';
	$('#div_leave_type input').each(function(){
		var radio_button_prop = $(this).prop('checked');
		if( radio_button_prop ){
			leave_applied = $(this).val();
		}
	});
	return leave_applied;
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
				$('#view_emp_leave').modal('disabled', true);
			}
		
			$('#txt_pkid_view_leave').val(pkid);
			$("#view_emp_leave").modal();
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
							
			var ctr = data['ctr'];
				$('#ViewLeave_summary').empty();	
					var html  = '<table id="tbl_leave_records" class="table table-bordered">';
						html += '	<thead>';
						html += '		<tr>';
						html += '			<th><center><font size="2">DATE ABSENT</font></center></th>';
						html += '			<th><center><font size="2">NO. OF DAYS</font></center></th>';
						html += '			<th><center><font size="2">PAID LEAVE</font></center></th>';
						html += '			<th><center><font size="2">CUT-OFF DATE</font></center></th>';
						html += '		</tr>';
						html += '	</thead>';
						html += '	<tbody>';
						html += '	</tbody>';
						html += '</table>';
					
				$('#ViewLeave_summary').append(html);	
			
			for(i=0;i<ctr;i++){
			
			if ( data['cutoff'][i] == '1' ){
					var cut_off = '1st cut-off of ';
				} else if ( data['cutoff'][i] == '2' ) {
					var cut_off = '2nd cut-off of ';
				} else if ( data['cutoff'][i] == '' ) {
					var cut_off = 'Not';
				}
				
				if ( data['cutoff_month'][i] == '1' ){
					var cut_off_month = 'January';
				} 	else if ( data['cutoff_month'][i] == '2' ) {
					var cut_off_month = 'February';
				}	else if ( data['cutoff_month'][i] == '3' ) {
					var cut_off_month = 'March';
				}	else if ( data['cutoff_month'][i] == '4' ) {
					var cut_off_month = 'April';
				}	else if ( data['cutoff_month'][i] == '5' ) {
					var cut_off_month = 'May';
				}	else if ( data['cutoff_month'][i] == '6' ) {
					var cut_off_month = 'June';
				}	else if ( data['cutoff_month'][i] == '7' ) {
					var cut_off_month = 'July';
				}	else if ( data['cutoff_month'][i] == '8' ) {
					var cut_off_month = 'August';
				}	else if ( data['cutoff_month'][i] == '9' ) {
					var cut_off_month = 'September';
				}	else if ( data['cutoff_month'][i] == '10' ) {
					var cut_off_month = 'October';
				}	else if ( data['cutoff_month'][i] == '11' ) {
					var cut_off_month = 'November';
				}	else if ( data['cutoff_month'][i] == '12' ) {
					var cut_off_month = 'December';
				}	else if ( data['cutoff_month'][i] == '' ) {
					var cut_off_month = 'Applicable';
				}	
				
				var html  = '<tr id="'+data['pkid'][i]+'">';
					html += '	<td style="text-align: center;font-size: 14px;">'+data['date_absent_from'][i]+ ' - ' +data['date_absent_to'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_days'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_paid'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+cut_off+' '+cut_off_month+'</td>';	
					html += '</tr>';
				 $('#tbl_leave_records tbody').append(html);			
			}
			
			var oTable = $('#tbl_leave_records').DataTable({ 
				"paginate":true, 
				"aaSorting": [],
			});
			table_events();
			
		},error	: function(data){
			alert(data);
		}
	});
}

function cancel_conformed_leave_by_pkid(pkid) { 
	var data1 = {
		"action"			 : "cancel_conformed_leave_by_pkid",
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

			$('#cancel_txt_pkid').val(pkid);	
			$("#cancel_conformed_leave_modal").modal();
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}	
	
function update_leave_conformed_status(pkid,status) {
		
	var data = {
		"action"				 : "update_leave_conformed_status",
		"pkid"					 : pkid,
		"status"				 : status,
		"HR_cancel_remarks"		 : $('#HR_cancel_conformed_leave_remarks').val(),
		"username"				 : "<?php echo $username; ?>"
	}
	data = $.param(data);
	// alert(data);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data,
		url			: "update_leave_conformed_status.php",
		success		: function (result) {
		
		var data1 = {
				"action": "send_email_from_hrd_cancelled",
				"pkid"	: pkid
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
		
			alert('Successfully Cancelled Leave!');
			window.location.href = "hrd_leave_summary.php";

		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}

</script>
	
</html>