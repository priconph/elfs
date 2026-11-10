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

<div class="tabbable"> 
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#tab1" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE FOR APPROVAL</a>
		</li>
		<li>
			<a href="#tab2" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">EMPLOYEE LEAVE HISTORY</a>
		</li>
		<li>
			<a href="#tab3" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">EMPLOYEE LEAVE BALANCE</a>
		</li>
		
	</ul>
<div class="tab-content">
<div class="tab-pane active" id="tab1">
<br>
<br>

<div class="panel panel-primary" style="margin:auto; width:95%;">
<div class="panel-heading">EMPLOYEE LEAVE SUMMARY FOR APPROVAL</div>
	<div class="panel-body">	
	<br>
	<form id="" method="get">
	<!--<table id="Empleave_tbl" name="Empleave_tbl" class="table table-bordered" width="100%">-->
		<table id="Empleave_tbl" name="Empleave_tbl" class="display nowrap" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">REMARKS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" data-original-title="">EDIT</th>
		 </tr>
		</thead>
		<tbody id="leaveEmpForApproval">
			<?php
			$result = ELFS::getInstance()->select_emp_leave_summary_for_approval_DH($username);
				while($row = mysqli_fetch_array($result)){
				
				// 0-for approval, 1-approved by approver1, 2-approved by approver2, 3-conformed by hrd, 4-revise leave as per hrd, 5-Disapproved by approver1, 6-Disapproved by approver2				
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
				}	else if($row['leave_applied'] == 7) {
				$leave_applied = '<center>Special Leave Benefit for Women</center>';
				}	
				
				if($row['IS_disapproved_remarks'] != "" || $row['HR_revised_remarks'] != "" || $row['Cancelled_remarks'] != "" ) {
						$btn_view_remarks = '<button class="btn btn-danger" id="btn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
				} else {
						$btn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found." disabled><span class="glyphicon glyphicon-comment"></span></button>';
				}

						
				if($row['status'] == 0 || $row['status'] == 1 || $row['status'] == 5) {
						$btn_edit_view = '<button class="btn btn-warning" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view leave application"><span class="glyphicon glyphicon-edit"></span></button>';
				} else if($row['status'] == 2) {
						$btn_edit_view = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
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
						<td style='text-align: center; font-size: 14px;' title='Double click to view leave dates'>".$leave_applied."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$btn_edit_view."</td>
					</tr>
					";
		}
		?>
		</tbody>
		</table>
	</form>
	</div>
</div> 
</div><!-- tab1-->

<div class="tab-pane" id="tab2">
	<br>
	<br>

<div class="panel panel-primary" style="margin:auto; width:95%;">
<div class="panel-heading">EMPLOYEE LEAVE HISTORY</div>
	<div class="panel-body">	
	<br>
	
	<form id="" method="get">
	<!--<table id="Empleave_history_tbl" name="Empleave_history_tbl" class="table table-bordered" width="100%" style="font-size: 10pt; border: solid 2px gray;">-->
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
			</tr>
		  </thead>
		  <tbody id="leaveHistory">
			<?php
			$result = ELFS::getInstance()->select_leave_history_for_approver2($username);
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
				
				// 0-for approval, 1-approved by approver1, 2-approved by approver2, 3-conformed by hrd, 4-revise leave as per hrd, 5-Disapproved by approver1, 6-Disapproved by approver2													
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
				}	
				
				if($row['IS_disapproved_remarks'] != "" || $row['DH_disapproved_remarks'] != "" || $row['HR_revised_remarks'] !="") {
						$hbtn_view_remarks = '<button class="btn btn-danger" id="hbtn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
				} else {
						$hbtn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found." disabled><span class="glyphicon glyphicon-comment"></span></button>';
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
				
				echo "
					<tr title='Double click to view leave dates'>	
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
					</tr>
					";
				}
			?>
		</tbody>
		</table>  
	</form> 
	</div>
</div> 

</div><!-- tab2-->

<div class="tab-pane" id="tab3">
	<br>
	<br>

<div class="panel panel-primary" style="margin:auto; width:95%;">
<div class="panel-heading">EMPLOYEE LEAVE BALANCE</div>
	<div class="panel-body">	
	<br>
	
	<form id="" method="get">
		<!--<table id="EmpleaveBalance_tbl" name="EmpleaveBalance_tbl" class="table table-bordered" width="100%">-->
		<table id="EmpleaveBalance_tbl" name="EmpleaveBalance_tbl" class="display nowrap" cellspacing="0" width="100%">
		 <thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">LEAVE STATUS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee No." data-original-title="">EMPNO.</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Regularity Date" data-original-title="">REGULARITY DATE</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Previous Balance VL" data-original-title="">PREV. VL BALANCE</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Credit VL" data-original-title="">CREDIT VL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Current Avail VL" data-original-title="">CURRENT AVAIL VL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total VL used" data-original-title="">TOTAL VL USED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total VL Balance" data-original-title="">TOTAL VL BALANCE</th>
				
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Previous Balance SL" data-original-title="">PREV. SL BALANCE</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Credit SL" data-original-title="">CREDIT SL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Current Avail SL" data-original-title="">CURRENT AVAIL SL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total SL used" data-original-title="">TOTAL SL USED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total SL Balance" data-original-title="">TOTAL SL BALANCE</th>
			</tr>
		  </thead>
		  <tbody id="leaveHistory">
			<?php
				$result = ELFS::getInstance()->select_leave_balance_per_dept($Department);
					while($row = mysqli_fetch_array($result)){
					
					if($row['HiringStatus'] == 2) {
						$status_label = '<center><span class="glyphicon glyphicon-remove" title="Without Leave" style="color:red"></span></center>'; 
					} else if($row['HiringStatus'] == 3) {
						$status_label = '<center><span class="glyphicon glyphicon-ok" title="With Leave" style="color:blue"></span></center>'; 
					}
					
					echo "
						<tr>	
							<td style='display:none'>".$row['pkid']."</td>
							<td style='text-align: center;font-family: Euphemia; font-size: 13px;'>".$status_label."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['EmpNo']."</td>
							<td style='text-align: left;font-family: Euphemia;font-size: 13px;'>".$row['LastName'].", ".$row['FirstName']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['regularity_date']."</td> 
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['previous_balance_VL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['credit_VL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['current_avail_VL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['total_VL_used']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['total_VL_balance']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['previous_balance_SL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['credit_SL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['current_avail_SL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['total_SL_used']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['total_SL_balance']."</td>
						</tr>
					 ";
				}
			?>
		</tbody>
		</table>  
	</form> 
	</div>
</div> 

</div><!-- tab2-->

</div><!-- tab content-->
</div><!-- tabbable-->

<!-- Modal update leave-->	
<div class="modal fade" id="Leave_application_modal_update" role="dialog">
	<div class="modal-dialog" style="width:85%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4>EMPLOYEE LEAVE APPLICATION</h4>
			</div>
		<div class="modal-body" id="cont">	
			<form action="#">
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
				
					<label class="FormLabel">Date Created:</label>
					<input type="date/time" style="width:220px; height:5%;" class="FormText" id="update_date_created" name="update_date_created" readonly>	
					<br>
					
					<label class="FormLabel">Employee Name:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="update_empName" name="update_empName" readonly>
					<br>
					
					<label class="FormLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="update_EmpNo" name="update_EmpNo" readonly>
					<br>
					
					<label class="FormLabel">Division:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="update_division" name="update_division" readonly>	
					<br>
					
					<label class="FormLabel">Address during leave:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="emp_address" name="emp_address" readonly>	
					<br>
					
					<input class="FormLabel" type="checkbox" id="lbl_radio_update_otherAdd" name="update_radio_OthersAdd" value="1" disabled>
					<label style="width:220px; font-size: 14px; ">Others <i>(Leave Address)</i></label>
					<br>
					
					<label class="FormLabel"></label>
					<textarea rows="2" style="width:220px;" id="update_address" name="update_address" readonly ></textarea>
					<br>
					
					<label class="FormLabel">Date of Absent/s:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormText" >
					<br>
					
					<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
					<input type="date" style="width:220px; height:5%;" class="FormText" id="update_date_absent_from" name="update_date_absent_from" readonly >
					<br>
					
					<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
					<input type="date" style="width:220px; height:5%;" class="FormText" id="update_date_absent_to" name="update_date_absent_to" readonly>
					<br>
					
					<label class="FormLabel">No. of days:</label>
					<input type="text" style="width:50px; height:5%;" class="FormText" id="update_no_of_days" name="update_no_of_days" readonly>
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
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_approved" name="status" value="2">
							<label style="font-size: 14px;" id="lbl_approved">Approved Leave</label>
							<br>
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_disapproved" name="status" value="6">
							<label style="font-size: 14px;" id="lbl_disapproved">Disapproved Leave</label>
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
					<div class="row">
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
					<select style="width:220px; height:5%;" class="FormText" id="update_other_reason" name="update_other_reason" disabled >
					  <option value="0"></option>
					  <option value="1">Shut-down</option>
					  <option value="2">Special Non-working Holiday</option>
					  <option value="3">Others</option>
					</select>						
					<br>
					
					<label class="FormLabel"></label>
					<textarea rows="3" style="width:220px;" class="FormText" id="update_reason" name="update_reason" disabled></textarea>
					<br>
					
					
			<!--	<label class="FormLabel">Reason/s:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormText">
					<br>
					
					<label class="FormLabel"></label>
					<textarea rows="3" style="width:220px;" class="FormText" id="update_reason" name="update_reason" readonly></textarea>
					<br>
					-->
					<label class="FormLabel" for="update_cmb_approver2">Immediate Superior:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="update_cmb_approver1" name="update_cmb_approver1" readonly>

				</div>
			</div><!-- end row -->
			<div class="modal-footer">
				<button type="button" id="btn_send_update_leave" data-confirm="Are you sure you want to approved / disapproved this leave application?" class="btn btn-primary">SEND</button>
				<button type="button" id="btn_cancel_update_leave" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
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
			<center><div id="alert_msg2" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>
			<div class="form-group">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="FormLeaveApplied" type="radio" id="late_filing" name="disapproved_label" value="3">
				<label style="font-size: 14px;" id="lbl_late_filing">&nbsp;Late Filing</label>
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="FormLeaveApplied" type="radio" id="unauthorized" name="disapproved_label" value="4">
				<label style="font-size: 14px;" id="lbl_unauthorized">&nbsp;Unauthorized</label>
				<br>
				<br>

				<label style="font-size: 14px;" for="disapp_remarks">Remarks</label>
				<textarea class="form-control" rows="3" id="DH_disapproved_remarks"></textarea>
			
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

<!-- Modal Show remarks -->
<div class="modal fade" tabindex="-1" id="show_remarks_modal" role="dialog">
	<div class="modal-dialog" style="width:45%">
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
		<center><textarea rows="3" id="DH_disapproved_remarks_show"  style="width:420px;" placeholder="N/A" readonly></textarea></center>
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
</body>

<script type="text/javascript">
	$("#Empleave_tbl").dataTable({"order": [],
		"columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false,
		}]});
	
	$("#EmpleaveBalance_tbl").dataTable({
		"scrollX"		: true
	});

	$("#Empleave_tbl tbody").on('click','tr #btn_view_leave', function(e){
		e.preventDefault();
		select_leave_info_by_pkid($(this).val());
	});
	
	$("#Empleave_tbl tbody").on('click','tr #btn_show_remarks', function(e){
		e.preventDefault();
		show_remarks($(this).val());
	});
	
	$("#Empleave_history_tbl tbody").on('click','tr #hbtn_show_remarks', function(e){
		e.preventDefault();
		show_remarks($(this).val());
	});
	
	$("#Empleave_history_tbl").dataTable({"order": [],
		"columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false,
		}]});
	
	$("tbody tr").click(function() {
		console.log('clicked');
		$(this).addClass('selected').siblings().removeClass("selected");
	});

	$('#btn_vw_leave_history').click(function(){
		$('#Emp_Leave_History').modal('show'); 
	});
	
	$('#btn_cancel_update_leave').click(function(){
		window.location.href = "DH_leave_summary.php";
	});	

	$("#update_rbtn_disapproved").click(function(){
		$('#disapproved_modal').modal('show');
    });
	
	$('#btn_save_disapproved').click(function(){
		if($('#DH_disapproved_remarks').val() != '') {
			$('#disapproved_modal').modal('hide');
		} else {
		$('#alert_msg2').show();
		$('#alert_msg2').append('Please select disapproved status and add remarks!<br>');
		$('#cancelled_leave_modal').modal('show');
		}
	});	
	
	$('#btn_close_disapproved').click(function(){
		$('#disapproved_modal').modal('hide');
		$('#update_rbtn_disapproved').attr("checked", false);
		$('#late_filing').attr("checked", false);
		$('#unauthorized').attr("checked", false);
		$('#DH_disapproved_remarks').val('');
	});	
	
	$("#btn_send_update_leave").click(function(e){
	var checker = false;
	if($('#update_rbtn_approved').is(':checked') || $('#update_rbtn_disapproved').is(':checked')) {
		if($('#update_rbtn_approved').is(':checked')) {
			var status = 2;
			checker = true;
		} else if($('#update_rbtn_disapproved').is(':checked')) {
			var status = 6;	
			if($('#IS_disapproved_remarks').val() == '') {
				alert('Please add remarks!');
				$('#disapproved_modal').modal('show');
			} else {
				checker = true;
			}

			if($('#late_filing').is(':checked')) {
				var disapproved_label = 3;	
				checker = true;
			} else 	if($('#unauthorized').is(':checked')) {
				var disapproved_label = 4;	
				checker = true;
			}
				
		} 
			if(confirm($(this).data('confirm'))){
				e.preventDefault();
			} else {
				return false;
			}
			
		if(checker) {			
			update_approver2_status($('#update_txt_pkid').val(),status,disapproved_label);
			}
	} else {
		$('#alert_msg').show();
		$('#alert_msg').append('Please select leave status!<br>');
		$("#lbl_approved").css("color", 'red');
		$("#lbl_disapproved").css("color", 'red');    
	} 	
				
    });

	$("#Empleave_history_tbl tbody").on('dblclick', 'tr', function(){
		$("#modal-body input").val("");	
		select_view_emp_leave($(this).find("td:eq(0)").text());
	});

	$("#Empleave_tbl tbody").on('dblclick', 'tr', function(){
		$("#modal-body input").val("");	
		select_view_emp_leave($(this).find("td:eq(0)").text());
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
			
		if(result['status'][i] == 2 || result['status'][i] == 6) {	
					$('#lbl_radio_update_otherAdd').prop('disabled', true);
					$('#update_address').prop('disabled', true);
					$('#update_cmb_approver1').prop('disabled', true);
					$('#update_cmb_approver2').prop('disabled', true);
					$('#update_rbtn_sl').prop('disabled', true);
					$('#update_rbtn_vl').prop('disabled', true);
					$('#update_rbtn_bdl').prop('disabled', true);
					$('#update_rbtn_ml').prop('disabled', true);
					$('#update_rbtn_pl').prop('disabled', true);
					$('#update_rbtn_bl').prop('disabled', true);
					$('#update_rbtn_sp').prop('disabled', true);
					$('#update_rbtn_slbw').prop('disabled', true);
					$('#update_rbtn_approved').prop('disabled', true);
					$('#update_rbtn_disapproved').prop('disabled', true);
					$('#update_date_absent_from').prop('disabled', true);
					$('#update_date_absent_to').prop('disabled', true);
					$('#update_reason').prop('disabled', true);
					$('#btn_save_update_leave').prop('disabled', true);
					$('#btn_send_update_leave').prop('disabled', true);
			}
			
			if(result['status'] == 2) {
				$('#update_rbtn_approved').prop('checked', true);
			} else if(result['status'] == 6) {
				$('#update_rbtn_disaapproved').prop('checked', true);
			} 
			
			// $('#update_rbtn_approved').val(result['status'][i]);
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
			$('#update_reason').val(result['reason'][i]);
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
						html += '		</tr>';
						html += '	</thead>';
						html += '	<tbody>';
						html += '	</tbody>';
						html += '</table>';
					
				$('#ViewLeave_summary').append(html);	
			
			for(i=0;i<ctr;i++){
				var html  = '<tr id="'+data['pkid'][i]+'">';
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
			
		},error	: function(data){
			alert(data);
		}
	});
}

function update_approver2_status(pkid,status,disapproved_label) {
	var data1 = {
		"action"				 : "update_approver2_status",
		"pkid"					 : pkid,
		"status"				 : status,
		"disapproved_label"		 : disapproved_label,
		"DH_disapproved_remarks" : $('#DH_disapproved_remarks').val(),
		"username"				 : "<?php echo $username; ?>"
	}
	data1 = $.param(data1);
	// alert(data1);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data1,
		url			: "update_approver2_status.php",
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
			window.location.href = "DH_leave_summary.php";
		
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
		
			$('#IS_disapproved_remarks_show').val(result['IS_disapproved_remarks']);
			$('#DH_disapproved_remarks_show').val(result['DH_disapproved_remarks']);
			$('#HR_revise_remarks_show').val(result['HR_revised_remarks']);
			$('#Cancelled_remarks_show').val(result['Cancelled_remarks']);
			$('#show_remarks_modal').modal('show');
			
		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}	

</script>
	
</html>