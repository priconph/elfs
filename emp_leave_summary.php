<?php
    include("includes.php");
	require_once("elfs_oop.php");
	session_start();

	$username = $_SESSION['username'];
	// $username = 'margsor';
	
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
		 $Division 			=  $rowEmpInfo['Division'];
		 $CityAddress1 		=  $rowEmpInfo['CityAddress1'];
		 $CityAddress2 		=  $rowEmpInfo['CityAddress2'];
		 $CityAddress3 		=  $rowEmpInfo['CityAddress3'];
		 $SalaryType 		=  $rowEmpInfo['SalaryType'];
		 $DOBirth 			=  $rowEmpInfo['DOBirth'];
	}
	
	$result = ELFS::getInstance()->getEmpLeaveBalance($EmpNo);
		while($rowEmpInfo = mysqli_fetch_array($result)){
		 $regularity_date 		=  $rowEmpInfo['regularity_date'];
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

?>
<html lang="en">
<head>
<style>
	#leaveEmp tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#leaveEmp tr.selected {
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
		margin-left:2%;
		font-size: 14px;
	}
	
	#cont .FormText{
		margin-bottom:4px;
		width:10%;
		font-size: 14px;
	}
	
	#cont .FormLeaveLabel{
		width:35%;
		margin-left:10%;
		font-size: 14px;
	}
		
	#cont .FormLeaveText{
		margin-bottom:4px;
		width:10%;
		margin-left:12%;
		font-size: 14px;
	}
	
	.FormLabel_LB {
		width:31%;
		margin-left:15%;
		font-size: 14px;
	}
		
	.FormText_LB{
		margin-bottom:4px;
		margin-left:3%;
		font-size: 14px;
	}

	#panel_vl{
		margin-left:23%;
	}
	
	#panel_sl{
		margin-left:23%;
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
		color: #FF0000;
		font-weight: bold;
	}
	
	#total_SL_used {
		color: #FF0000;
		font-weight: bold;
	}

	#current_avail_VL {
		color: #0000FF;
		font-weight: bold;
	}
	
	#current_avail_SL {
		color: #0000FF;
		font-weight: bold;
	}
	   
	.modal-body {
		max-height: calc(110vh - 210px);
		overflow-y: auto;
	}
	
	.glyphicon {
		font-size: 13px;
	}
	
	.fa-thumbs-o-down {
	  color: red;
	}

	.fa-thumbs-down {
	  color: red;
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
	
	#hidden_textbox{
		border: 2px solid transparent;
	}
			
</style>
</head>

<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>

<div class="tabbable"> 
	<ul class="nav nav-tabs">
		<li class="active" id="tab_leave_summary">
			<a href="#tab1" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE SUMMARY</a>
		</li>
		<li id="tab_leave_history">
			<a href="#tab2" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE HISTORY</a>
		</li>
		<li id="tab_leave_balance">
			<a href="#tab3" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE BALANCE</a>
		</li>
		<li id="tab_leave_conversion">
			<a href="#tab4" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE CONVERSION</a>
		</li>
	</ul>
	
<div class="tab-content">

	<div class="tab-pane active" id="tab1">
	<br>
	<br>

	<div class="panel panel-primary" style="margin:auto; width:95%;">
		<div class="panel-heading">EMPLOYEE LEAVE SUMMARY</div>
			<div class="panel-body">
			
			<div align='left'>
				<button type='submit' class="btn btn-primary" onClick="window.location = 'download_leave_filling.php?filename=LeaveFilling'">USER MANUAL &nbsp;<img src='images/pdf_download.png' height='30' width='35'></img> </button>
			</div>

				<table style="text-align:right; width: 100%;">
					<tr>
						<td>
							<form class="form-inline" role="form" method="POST" action="">
								<a href="#" class="btn btn-primary" id="btn_new_leave" name="btn_new_leave"  title="Click this to add new leave">&nbsp; ADD NEW LEAVE &nbsp;</a>
								<br/>
							</form>
						</td>
					</tr>
				</table>

				<table id="leave_tbl" name="leave_tbl" class="display nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
							<th style="text-align: center; vertical-align: middle;" class="hide">username</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status Remarks" data-original-title="">REMARKS</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" data-original-title="">VIEW/CANCEL</th>
					  </tr>
					</thead>
					<tbody id="leaveEmp">
						<?php
						$result = ELFS::getInstance()->select_leave_emp_summary($username);
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
							}	else if($row['leave_applied'] == 7) {
							$leave_applied = '<center>Special Leave Benefit for Woman</center>';
							}	
							
							if($row['IS_disapproved_remarks'] != "" || $row['DH_disapproved_remarks'] != "" || $row['HR_revised_remarks'] !="" || $row['Cancelled_remarks'] !="") {
									$btn_view_remarks = '<button class="btn btn-danger" id="btn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
							} else {
									$btn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found." disabled><span class="glyphicon glyphicon-comment"></span></button>';
							}

							if($row['status'] == 0 || $row['status'] == 1 || $row['status'] == 5) {
									$btn_edit_view = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
									$btn_cancel = '<button class="btn btn-danger" id="btn_cancel" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to cancel leave application"><span class="glyphicon glyphicon-remove"></span></button>';
							} else 	if($row['status'] == 2 || $row['status'] == 6 ) {
									$btn_edit_view = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
									$btn_cancel = '<button class="btn btn-default" style="border-radius: 0px;" disabled><span class="glyphicon glyphicon-remove"></span></button>';
							} else if ($row['status'] == 4 || $row['status'] == 7) {
									$btn_edit_view = '<button class="btn btn-warning" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to edit leave application"><span class="glyphicon glyphicon-edit"></span></button>';
									$btn_cancel = '<button class="btn btn-danger" id="btn_cancel" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to cancel leave application"><span class="glyphicon glyphicon-remove"></span></button>';
							} else {
									$btn_edit_view = '<button class="btn btn-default" style="border-radius: 0px;" ><span class="glyphicon glyphicon-eye-close"></span></button>';
									$btn_cancel = '<button class="btn btn-default" style="border-radius: 0px;" ><span class="glyphicon glyphicon-remove"></span></button>';
							}
												
							$pkid = $row['pkid'];	
							echo "
								<tr title='Double click to view/edit/remove.'>	
									<td style='display:none;'>".$pkid."</td>
									<td style='display:none'>".$row['username']."</td>
									<td style='font-family: Euphemia;'>".$status_label."</td>
									<td style='text-align: center; font-family: Euphemia;'>".$btn_view_remarks."</td>
									<td style='text-align: center; font-family: Euphemia; font-size: 13px;'>".date('F d, Y',strtotime($row['date_created']))."</td>
									<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$leave_applied."</td>
									<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$btn_edit_view." ".$btn_cancel." </td> 
									
								</tr>
								";
							}
						?>
					</tbody>
				</table>
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
			<!--<table id="leave_history_tbl" name="leave_history_tbl" class="table table-bordered" width="100%" >-->
				<table id="leave_history_tbl" name="leave_history_tbl" class="display nowrap" cellspacing="0" width="100%">
					 <thead>
						<tr>
							<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Remarks" data-original-title="">REMARKS</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Adress during leave" data-original-title="">ADDRESS DURING LEAVE</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Other address during leave" data-original-title="">OTHER ADDRESS DURING LEAVE</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Reason/s" data-original-title="">REASON</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Other Reason/s" data-original-title="">OTHER REASON</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total # of leaves" data-original-title="">TOTAL # OF LEAVE(S)</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Paid leaves" data-original-title="">PAID LEAVE(S)</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Immediate Superior" data-original-title="">IMMEDIATE SUPERIOR</th>
							<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Sec/Dept. Head" data-original-title="">SEC/DEPT. HEAD</th>
						</tr>
					  </thead>
					  <tbody id="leaveHistory">
						<?php
						$result = ELFS::getInstance()->select_leave_history($username);
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
							$leave_applied = '<center>Special Leave Benefit for Woman</center>';
							}	
												
							if($row['status'] == 0) {
								$status_label = '<div class="ui gray ribbon label">Pending for Approval</div>'; 
							} 	else if($row['status'] == 1) {
								$status_label = '<div class="ui green ribbon label">Approved by Immediate Supr.</div>'; 
							}	else if($row['status'] == 2) {
								$status_label = '<div class="ui green ribbon label">Approved by Dept. Head</div>'; 
							}	else if($row['status'] == 3) {
								$status_label = '<div class="ui blue ribbon label">Conformed by HRD</div>'; 
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

							if($row['IS_disapproved_remarks'] != "" || $row['DH_disapproved_remarks'] != "" || $row['HR_revised_remarks'] !="" || $row['Cancelled_remarks'] !="" || $row['HR_cancel_remarks'] !="") {
									$hbtn_view_remarks = '<button class="btn btn-danger" id="hbtn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
							} else {
									$hbtn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found." disabled><span class="glyphicon glyphicon-comment"></span></button>';
							}
							
							if($row['status'] == 3 || $row['status'] == 8) {
									$btn_cancel = '<button class="btn btn-default" style="border-radius: 0px;" ><span class="glyphicon glyphicon-remove"></span></button>';
							} 
							
							if($row['other_reason'] == 0) {										
							$reason_label = '<center>---</center>';
							} 	else if($row['other_reason'] == 1) {
							$reason_label = '<center>Shut-down</center>';
							}	else if($row['other_reason'] == 2) {
							$reason_label = '<center>Special Non-working Holiday</center>';
							}	else if($row['other_reason'] == 3) {
							$reason_label = '<center>Others</center>';
							}	
							
							if($row['approvername1'] == '') {
								$approver1_name = '---';
							} else {
								$approver1_name = $row['approvername1'] ;
							}	

							if($row['address'] == '') {
								$address = '---';
							} else if($row['address'] == 'N/A') {
								$address = '---';
							} else {
								$address = $row['address'] ;
							}

							if($row['total_absent_days'] == $row['no_of_paid']) {
								$no_of_paid = '<font color="blue">'.$row['no_of_paid'].'</font>';
							} else {
								$no_of_paid = '<font color="red">'.$row['no_of_paid'].'</font>';
							}
							
							$pkid = $row['pkid'];	
							echo "
								<tr title='Double click to view leave dates.'>	
									<td style='display:none'>".$pkid."</td>
									<td style='font-size: 16px;'>".$status_label."</td>
									<td style='text-align: center; font-size: 16px;'>".$hbtn_view_remarks."</td>
									<td style='text-align: center; font-size: 13px;'>".date('F d, Y',strtotime($row['date_created']))."</td>
									<td style='text-align: center; font-size: 14px;'>".$leave_applied."</td>
									<td style='text-align: center; font-size: 14px;'>".$row['emp_address']."</td>
									<td style='text-align: center; font-size: 14px;'>".$address."</td>
									<td style='text-align: center; font-size: 14px;'>".$reason_label."</td>
									<td style='text-align: center; font-size: 14px;'>".$row['reason']."</td>
									<td style='text-align: center; font-size: 14px;'>".$row['total_absent_days']."</td>
									<td style='text-align: center; font-size: 14px;'>".$no_of_paid."</td>
									<td style='text-align: center; font-size: 14px;'>".$approver1_name."</td>
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
	</div><!-- tab2 -->

	<div class="tab-pane" id="tab3">
	<br>
	<br>
	
	<div class="panel panel-primary" style="margin:auto; width:95%;">
		<div class="panel-heading">EMPLOYEE LEAVE BALANCE</div>
			<div class="panel-body" id="cont">	
			<br>
		
				<form action="#" id="form_leaveBalance">
					<input type="hidden" id="txt_usernameLB" name="txt_usernameLB" value="<?php echo $username; ?>"> 
					
				<div class="row">
					<div class="col-md-5">
						<label class="FormLabel_LB">Employee Name:</label>
						<input type="text" style="width:200px; height:5%;" class="FormText_LB" id="empName" name="empName" value="<?php echo $empName; ?>" readonly>
						<br>
						<label class="FormLabel_LB">Regularity Date:</label>
						<input type="text" style="width:200px; height:5%;" class="FormText_LB" id="regularity_date" name="regularity_date" value="<?php echo date('F d, Y',strtotime($regularity_date)); ?>" readonly>	
						<br>
						<br>
						<br>
					<div class="panel panel-info" style="width:90%;" id="panel_vl">
						<div class="panel-heading">
							<b>VACATION LEAVE</b>
						</div>
					<div class="panel-body">
						<label class="FormLeaveLabel">Previous Balance:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="previous_balance_VL" name="previous_balance_VL" value="<?php echo $previous_balance_VL; ?>" readonly>
						<br>
						<label class="FormLeaveLabel">Credit VL for 1 year:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="credit_VL" name="credit_VL" value="<?php echo $credit_VL; ?>" readonly>
						<br>
						<label class="FormLeaveLabel">Credit VL to avail for the month:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="current_avail_VL" name="current_avail_VL" value="<?php echo $current_avail_VL; ?>" readonly>	
						<br>
						<label class="FormLeaveLabel">Total VL used:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_VL_used" name="total_VL_used" value="<?php echo $total_VL_used; ?>" readonly>	
						<br>
						<label class="FormLeaveLabel">Remaining VL balance for the year:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_VL_balance" name="total_VL_balance" value="<?php echo $total_VL_balance; ?>" readonly>	
						<br>
					</div>			
					</div>	
					</div>
					<div class="col-md-5">
						<label class="FormLabel_LB">Employee number:</label>
						<input type="text" style="width:200px; height:5%;" class="FormText_LB" id="EmpNo" name="EmpNo" value="<?php echo $EmpNo; ?>" readonly>
						<br>
						<label class="FormLabel_LB"></label>
						<input type="text" style="width:200px; height:5%;" class="FormText_LB" id="hidden_textbox" readonly>	
						<br>
						<br>
						<br> 
					<div class="panel panel-info" style="width:90%;" id="panel_sl">
					<div class="panel-heading">
						<b>SICK LEAVE</b>
					</div>
					<div class="panel-body">
						<label class="FormLeaveLabel">Previous Balance:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="previous_balance_SL" name="previous_balance_SL" value="<?php echo $previous_balance_SL; ?>" readonly>
						<br>
						<label class="FormLeaveLabel">Credit SL for 1 year:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="credit_SL" name="credit_SL" value="<?php echo $credit_SL; ?>" readonly>
						<br>
						<label class="FormLeaveLabel">Credit SL to avail for the month:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="current_avail_SL" name="current_avail_SL" value="<?php echo $current_avail_SL; ?>" readonly>	
						<br>
						<label class="FormLeaveLabel">Total SL used:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_SL_used" name="total_SL_used" value="<?php echo $total_SL_used; ?>" readonly>	
						<br>
						<label class="FormLeaveLabel">Remaining SL balance for the year:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_SL_balance" name="total_SL_balance" value="<?php echo $total_SL_balance; ?>" readonly>	
						<br>
					</div>			
					</div>	
					</div>
				</div>
				</form>	
		</div>
	</div> 
	</div><!-- tab3-->
	
	<div class="tab-pane" id="tab4">
	<br>
	<br>

	<div class="panel panel-primary" style="margin:auto; width:95%;">
		<div class="panel-heading">VL CONVERSION</div>
			<div class="panel-body">	
			<br>
			
		<table id="tbl_leave_conversion" name="tbl_leave_conversion" class="display nowrap" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date" data-original-title="">DATE OF CONVERSION</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total VL Balance" data-original-title="">VL BALANCE</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total VL Balance" data-original-title="">VL CONVERTIBLE TO CASH</th>
			</tr>
		</thead>
		<tbody id="tbody_leave_conversion">
			<?php
			$result = ELFS::getInstance()->select_leave_conversion_summary($username);
				while($row = mysqli_fetch_array($result)){
					
					if ( $row['SalaryType'] == 1){
						$SalaryType = 'Daily';
					}else if ( $row['SalaryType'] == 2){
						$SalaryType = 'Monthly';
					}else if ( $row['SalaryType'] == 3){
						$SalaryType = 'Confidential';
					}else if ( $row['SalaryType'] == 4){
						$SalaryType = 'JS/SS';
					}		
					
				echo "
					<tr>	
						<td style='display:none'>".$row['pkid']."</td>
									<td style='text-align: center; font-size: 13px;'>".date('F d, Y',strtotime($row['date_conversion']))."</td>
						<td style='text-align: center; font-size: 13px;'><font color='blue'>".$row['vl_balance']."</font></td>
						<td style='text-align: center; font-size: 13px;'><font color='blue'>".$row['vl_convertible']."</font></td>
					</tr>
					";
				}
			?>
		</tbody>
		</table>

			</div>
	</div> 
	</div><!-- tab4 -->

</div><!-- tab content-->

</div><!-- tabbable-->
	
<!-- Modal New leave-->
<div class="modal fade" id="Leave_application_modal" role="dialog">
	<div class="modal-dialog" style="width:85%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4 style="font-family:Euphemia">EMPLOYEE LEAVE APPLICATION</h4>
			</div>
			<div class="modal-body" id="cont">	
				<form action="#" id="form_addNewLeave" data-confirm="Are you sure you want to file this leave?"> 
				 <center><div id="alert_msg" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>

				<div class="row">
					<div class="col-sm-6">
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<div class="panel panel-danger">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color: white;">
										  <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>&nbsp; Additional Information 
										</a>
									</h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Cut-off Information:</strong></p>
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;30 - 14 and 15 - 29</p><br>
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Birthday Leave</strong>	- 1 Day (Birth Month Only)</p>
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Bereavement Leave</strong>  - 3 Days</p>
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Maternity Leave</strong>  - Normal (60 Days) and CS (78 Days) <b>Without pay from PMI.</b></p>
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Paternity Leave </strong>  - 7 Working days</p>
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Solo Parent Leave</strong>  - 7 Working days (Must present SOLO parent ID card from DSWD)</p>
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> *Special Leave Benefit for Women (SLBW) </strong>  - 60 days for every instance of surgery.</p>
								  </div>
								</div>
							</div>
						</div> 
						
						<input type="hidden" id="txt_username" name="txt_username" value="<?php echo $username; ?>"> 
						<input type="hidden" id="fkEmployee" name="fkEmployee" value="<?php echo $fkEmployee; ?>"> 
						<input type="hidden" id="SalaryType" name="SalaryType" value="<?php echo $SalaryType; ?>"> 
						<br>
						
						<label class="FormLabel">Date Created:</label>
						<input type="date" style="width:220px; height:5%;" class="FormText" id="date_created" name="date_created" value="<?php echo date("Y-m-d") ; ?>" readonly>	
						<br>
						
						<label class="FormLabel">Employee Name:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="empName" name="empName" value="<?php echo $empName; ?>" readonly>
						<br>
						
						<label class="FormLabel">EmpNo.:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="EmpNo" name="EmpNo" value="<?php echo $EmpNo; ?>" readonly>
						<br>
						
						<label class="FormLabel">Division:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="Division" name="Division" value="<?php echo $Division; ?>" readonly>	
						<br> 
						
						<label class="FormLabel">Department:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="Department" name="Department" value="<?php echo $Department; ?>" readonly>	
						<br> 
						
						<label class="FormLabel">Address during leave:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="emp_address" name="emp_address" value="<?php echo $CityAddress2, ', ', $CityAddress3; ?>" readonly>	
						<br>
						
						<input class="FormLabel" type="checkbox" id="lbl_radio_otherAdd" name="lbl_radio_otherAdd" value="1">
						<label style="width:220px; font-size: 14px; ">Others <i>(Leave Address)</i></label>
						<br>
						
						<label class="FormLabel"></label>
						<textarea rows="2" style="width:220px;" id="address" name="address" disabled>N/A</textarea>
						<br>
						
						<label class="FormLabel" for="approver1">Immediate Superior:</label>
							<?php 												
								echo "<select id='approver1' name='approver1' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Immediate Superior...' required>"; 
									$result = ELFS::getInstance()->getSectionHead($username);
										echo "<option value=''></option>";
										echo "<option value='0'>N/A</option>";
									while($row = mysqli_fetch_array($result)){
										$get_emp_info = ELFS::getInstance()->getSectionHeadName($row['approver_username']);
										if ($username == 'rlnolasco'){
											echo "<option value='mcmaguilera'>Ma. Cecilia Aguilera</option>";
										}else{
											if($row_emp_info = mysqli_fetch_array($get_emp_info)) {
												echo "<option value='".$row['approver_username']."'>".$row_emp_info['FirstName']." ".$row_emp_info['LastName']."</option>";
											} 
										}
									}
								echo "</select>";	
							?>
						<br>
						
						<label class="FormLabel" for="approver2">Sec/Department Head *:</label>
							<?php 						
								echo "<select id='approver2' name='approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Sec/Department Head...' required>"; 
									$result = ELFS::getInstance()->getApproverList($username);
										echo "<option value=''></option>";
									while($row = mysqli_fetch_array($result)){
										$get_emp_info = ELFS::getInstance()->getEmpName($row['approver_username']);
										if ($username == 'rlnolasco'){
											echo "<option value='rorahl'>Robert Jr.	Rahl</option>";
										}else{
											if($row_emp_info = mysqli_fetch_array($get_emp_info)) {
												echo "<option value='".$row['approver_username']."'>".$row_emp_info['FirstName']." ".$row_emp_info['LastName']."</option>";
											}
										}
									}
								echo "</select>";	
							?>
						<br>
					</div>
					
					<div class="col-sm-5">
						<div class="panel panel-success" id="leave_applied_category">
							<div class="panel-heading">
								<div class="row">
									<div class="col-sm-12"><b>LEAVE APPLIED *</b></div>
								</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<input class="FormLeaveApplied" type="radio" id="rbtn_sl" name="leave_applied" value="0">
										<label style="font-size: 14px;" id="lbl_sl">Sick Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="rbtn_vl" name="leave_applied" value="1" disabled>
										<label style="font-size: 14px;" id="lbl_vl">Vacation Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="rbtn_bdl" name="leave_applied" value="2">
										<label style="font-size: 14px;" id="lbl_bdl">Birthday Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="rbtn_pl" name="leave_applied" value="4">
										<label style="font-size: 14px;" id="lbl_pl">Paternity Leave</label>

									</div>
									<div class="col-sm-6">
										<input class="FormLeaveApplied" type="radio" id="rbtn_bl" name="leave_applied" value="5">
										<label  style="font-size: 14px;" id="lbl_bl">Bereavement Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="rbtn_sp" name="leave_applied" value="6">
										<label style="font-size: 14px;" id="lbl_sp">Solo Parent Leave</label>
										<br>
									
										<input class="FormLeaveApplied" type="radio" id="rbtn_ml" name="leave_applied" value="3">
										<label style="font-size: 14px;" id="lbl_ml">Maternity Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="rbtn_slbw" name="leave_applied" value="7">
										<label style="font-size: 14px;" id="lbl_slbw">SLBW</label>
										
										<br>
									</div>			
								 </div>			
							</div>			
						</div>
						
						<!-- Delivery Date -->
						<div id="textboxes" style="display: none">
							<label style="width:300px; font-size: 14px;" ><b>Delivery Date:</b></label>
							<input type="hidden" style="width:220px; height:5%;" class="FormText">
							<br>
							
							<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From *:</label>
							<input type="text" style="width:220px; height:5%;" class="FormText" id="del_date_from" name="del_date_from" autocomplete="off">
							<br>
							
							<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To *:</label>
							<input type="text" style="width:220px; height:5%;" class="FormText" id="del_date_to" name="del_date_to" autocomplete="off"> 
							<br>
							
							<label class="FormLabel">Delivery days:</label>
							<input type="text" style="width:50px; height:5%;" class="FormText" id="del_days" name="del_days" readonly>
							<br>
						</div>
						<br>
						<!-- end delivery date -->
						
						<label style="width:300px; font-size: 14px;" >Date of Absent/s:</label>
						<input type="hidden" style="width:220px; height:5%;" class="FormText">
						<br>
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From *:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="date_absent_from" name="date_absent_from" autocomplete="off" readonly="true" required>
						<br>
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To *:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="date_absent_to" name="date_absent_to" autocomplete="off" readonly="true" required> 
						<br>
						
						<label class="FormLabel">No. of days:</label>
						<input type="text" style="width:50px; height:5%;" class="FormText" id="no_of_days" name="no_of_days" readonly>
						<br>
						
						<label class="FormLabel">Reason/s *:</label>
						<select style="width:220px; height:5%;" class="FormText" id="other_reason" name="other_reason" disabled>
						  <option value="0"></option>
						  <option value="1">Shut-down</option>
						  <option value="2">Special Non-working Holiday</option>
						  <option value="3">Others</option>
						</select>						
						<br>
						
						<label class="FormLabel"></label>
						<textarea rows="3" style="width:220px;" class="FormText" id="reason" name="reason" required disabled></textarea>
						<br>
					</div>
				</div><!-- end row -->
				
				<div class="modal-footer">
					<button type="button" id="btn_save_leave" data-confirm="Are you sure you want to save this leave? ** Once you click 'OK' you're not able to change the date." class="btn btn-primary">SAVE</button>
					<button type="button" id="btn_send_leave" data-confirm="Are you sure you want to send this leave?" class="btn btn-success">SAVE&SEND </button>
					<button type="button" id="btn_cancel_leave_modal" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
				</div>
				
				</form>	
			</div>
		</div>
	</div>
</div>

<!-- Modal update leave-->	
<div class="modal fade" id="Leave_application_modal_update" role="dialog">
	<div class="modal-dialog" style="width:85%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4 style="font-family:Euphemia">EMPLOYEE LEAVE APPLICATION</h4>
			</div>
		<div class="modal-body" id="cont">	
			<form action="#">
			 <center><div id="alert_msg2" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>
				<input type="hidden" id="update_txt_pkid" name="update_txt_pkid" value="<?php echo $pkid; ?>"> 
				<input type="hidden" id="update_txt_username" name="update_txt_username" value="<?php echo $username; ?>"> 
				<input type="hidden" id="update_fkEmployee" name="update_fkEmployee" value="<?php echo $fkEmployee; ?>"> 
				<input type="hidden" id="update_txt_status" name="update_txt_status" value="<?php echo $status; ?>"> 
				
			<div class="row">
				<div class="col-sm-6">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-danger">
							<div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="color: white;">
									  <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>&nbsp; Additional Information
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
							  <div class="panel-body">
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Cut-off Information:</strong></p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;30 - 14 and 15 - 29</p><br>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Birthday Leave</strong>	- 1 Day (Birth Month)</p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Bereavement Leave</strong>  - 3 Days</p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Maternity Leave</strong>  - Normal (60 Days) and CS (78 Days) <b>without pay.</b></p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Paternity Leave </strong>  - 7 Working days</p>
									<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Solo Parent Leave</strong>  - 7 Working days</p>
							  </div>
							</div>
						</div>
					</div> 
					<br>
					
					<label class="FormLabel">Date Created:</label>
					<input type="date" style="width:220px; height:5%;" class="FormText" id="update_date_created" name="update_date_created" readonly>	
					<br>
					
					<label class="FormLabel">Employee Name:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="update_empName" name="update_empName"  readonly>
					<br>
					
					<label class="FormLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="update_EmpNo" name="update_EmpNo"  readonly>
					<br>
					
					<label class="FormLabel">Division:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="update_division" name="update_division" readonly>	
					<br>
					
					<label class="FormLabel">Address during leave:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="update_emp_address" name="update_emp_address" readonly>	
					<br>
					
					<input class="FormLabel" type="checkbox" id="lbl_radio_update_otherAdd" name="lbl_radio_update_otherAdd" readonly>
						<label style="width:220px; font-size: 14px; ">Others <i>(Leave Address)</i></label>
					<br>
					
					<label class="FormLabel"></label>
					<textarea rows="2" style="width:220px;" id="update_address" name="update_address" disabled ></textarea>
					<br>
					
					<label class="FormLabel" for="update_cmb_approver1">Immediate Superior:</label>
						<?php 
							echo "<select id='update_cmb_approver1' name='update_cmb_approver1' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Immediate Superior...' required>"; 
									$result = ELFS::getInstance()->getSectionHead($username);
										echo "<option value=''></option>";
										echo "<option value='0'>N/A</option>";
									while($row = mysqli_fetch_array($result)){
										$get_emp_info = ELFS::getInstance()->getSectionHeadName($row['approver_username']);
										if($row_emp_info = mysqli_fetch_array($get_emp_info)) {
											echo "<option value='".$row['approver_username']."'>".$row_emp_info['FirstName']." ".$row_emp_info['LastName']."</option>";
										} 
									}
							echo "</select>";				
						?>
					<br>
						
					<label class="FormLabel" for="update_cmb_approver2">Sec/Department Head:</label>
						<?php 
							echo "<select id='update_cmb_approver2' name='update_cmb_approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Sec/Department Head...' required>"; 
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
				
				<div class="col-sm-5">
					<div class="panel panel-success" id="update_leave_applied_category" style="width:100%;">
						<div class="panel-heading">
							<div class="row">
								<div class="col-sm-12"><b>LEAVE APPLIED</b></div>
							</div>
						</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-6">
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_sl" name="update_leave_applied" value="0">
								<label style="font-size: 14px;" id="lbl_sl">Sick Leave</label>
								<br>
								
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_vl" name="update_leave_applied" value="1" disabled>
								<label style="font-size: 14px;" id="lbl_vl">Vacation Leave</label>
								<br>
								
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_bdl" name="update_leave_applied" value="2">
								<label style="font-size: 14px;" id="lbl_bdl">Birthday Leave</label>
								<br>
								
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_pl" name="update_leave_applied" value="4">
								<label style="font-size: 14px;" id="lbl_pl">Paternity Leave</label>

							</div>
							<div class="col-sm-6">
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_bl" name="update_leave_applied" value="5">
								<label style="font-size: 14px;" id="lbl_bl">Bereavement Leave</label>
								<br>
								
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_sp" name="update_leave_applied" value="6">
								<label style="font-size: 14px;" id="lbl_spl">Solo Parent Leave</label>
								<br>
								
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_ml" name="update_leave_applied" value="3">
								<label style="font-size: 14px;" id="lbl_ml">Maternity Leave</label>
								<br>
								
								<input class="FormLeaveApplied" type="radio" id="update_rbtn_slbw" name="update_leave_applied" value="7">
								<label style="font-size: 14px;" id="lbl_slbw">SLBW</label>
							</div>			
						</div>			
					</div>
					
					</div>					
						<label class="FormLabel">Date of Absent/s:</label>
						<input type="hidden" style="width:220px; height:5%;" class="FormText">
						<br>
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_date_absent_from" name="update_date_absent_from" autocomplete="off" readonly="true">
						<br>
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_date_absent_to" name="update_date_absent_to" autocomplete="off" readonly="true">
						<br>
						
						<label class="FormLabel">No. of days:</label>
						<input type="text" style="width:50px; height:5%;" class="FormText" id="update_no_of_days" name="update_no_of_days" readonly>
						<br>
						
						<label class="FormLabel">Reason/s *:</label>
						<select style="width:220px; height:5%;" class="FormText" id="update_other_reason" name="update_other_reason" >
						  <option value="0"></option>
						  <option value="1">Shut-down</option>
						  <option value="2">Special Non-working Holiday</option>
						  <option value="3">Others</option>
						</select>						
						<br>
						
						<label class="FormLabel"></label>
						<textarea rows="3" style="width:220px;" class="FormText" id="update_reason" name="update_reason" required></textarea>
						<br>
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" id="btn_send_update_leave" data-confirm="Are you sure you want to send this leave?"  class="btn btn-success" >SAVE&SEND </button>
				<button type="button" id="btn_cancel_update_leave" class="btn btn-danger" data-dismiss="modal">CANCEL</button> 
			</div>
			
			</form>	
		</div>
		</div>
	</div>
</div>

<!-- Modal Edit Leave -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_emp_leave">
	<div class="modal-dialog" style="width:85%">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">EMPLOYEE LEAVE DATES</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txt_pkid_edit_leave" name="txt_pkid_edit_leave" value="<?php echo $pkid; ?>"> <br>
			<div id="EditLeave_summary" style="padding: 13px;" ></div> 
			</div>
			
			<div class="modal-footer">
			<button type="button" id="btn_close_view_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

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
	<div class="modal-dialog" style="width:30%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Leave Status Remarks</h4>
			</div>
		<div class="modal-body" id="cont">
		<input type="hidden" id="pkid_remarks" name="pkid_remarks" value="<?php echo $pkid; ?>"> 

		<label style="font-size: 14px;" >Disapproved by Dept. Head:</label>
		<center><textarea rows="3" id="IS_disapproved_remarks_show"  style="width:420px;" placeholder="N/A" readonly></textarea></center>
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
		<br>
		<br>

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
			<center><div id="alert_msg3" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>
			<input type="hidden" id="cancel_txt_pkid" name="cancel_txt_pkid" value="<?php echo $pkid; ?>"> 

			  <label style="font-size: 14px;" for="cancelled_leave_remarks">REASON</label>
			  <textarea class="form-control" rows="3" id="Cancelled_remarks"></textarea>

	    </div>
		<div class="modal-footer">
			<div style="float:right">
				<button type="button" id="btn_save_cancelled_leave" data-confirm="Are you sure you want to cancel this leave application?"  class="btn btn-success" >SAVE</button>
				<button type="button" class="btn btn-danger" id="btn_close_cancelled_leave">CANCEL</button>
			</div>
		</div>
      </div>
    </div>
</div> 

</body>

<script>
var edit_selected_pkid = "";
var view_selected_pkid = "";
var emp_address = "<?php echo $CityAddress2, ', ', $CityAddress3; ?>";

// alert('Please be reminded that parallel testing is still on-going until end of February 2017. Make sure that you have leave filed thru leave form (Paper based) and thru SystemOne.\nThankyou!');
$(document).ready(function(){
	$("#leave_tbl").dataTable({
		"order": [],
		"columnDefs": [{
		"targets"  : 'no-sort',
		"orderable": false,
		}]
	});

	$("#leave_history_tbl").dataTable({"order": [],
		"columnDefs": [{
		"targets"  : 'no-sort',
		"orderable": false,
		}]
	});

	$("#tbl_leave_conversion").dataTable({"order": [],
		"columnDefs": [{
		  "targets"  : 'no-sort',
		  "orderable": false,
		}]
	});

});
		
$("#leave_tbl tbody").on('click','tr #btn_show_remarks', function(e){ 
	e.preventDefault();
	show_remarks($(this).val());
});

$("#leave_history_tbl tbody").on('click','tr #hbtn_show_remarks', function(e){ 
	e.preventDefault();
	show_remarks($(this).val());
});

$("#leave_tbl tbody").on('click','tr #btn_view_leave', function(e){
	e.preventDefault();
	select_leave_info_by_pkid($(this).val());
});

$("#leave_tbl tbody").on('click','tr #btn_cancel', function(e){
	e.preventDefault();
	select_leave_info_for_cancel_by_pkid($(this).val());
});

$('#btn_close_cancelled_leave').click(function(){
	window.location.href = "emp_leave_summary.php";
});	
	
$("#leave_tbl tbody").on('dblclick', 'tr', function(){
	$("#modal-body input").val("");	
	select_view_emp_leave($(this).find("td:eq(0)").text());
});	

$("#leave_history_tbl tbody").on('dblclick', 'tr', function(){
	$("#modal-body input").val("");	
	select_view_emp_leave($(this).find("td:eq(0)").text());
});	
		
$("tbody tr").click(function() {
	console.log('clicked');
	$(this).addClass('selected').siblings().removeClass("selected");
});

$('#btn_new_leave').click(function(){
	$('#Leave_application_modal').modal('show'); 
});	

$('#btn_close_view_leave').click(function(){
	window.location.href = "emp_leave_summary.php";
});	

$('#btn_cancel_batch_leave').click(function(){
	window.location.href = "emp_leave_summary.php";
});	

$('#btn_cancel_update_leave').click(function(){
	window.location.href = "emp_leave_summary.php";
});	

$('#btn_cancel_leave_modal').click(function(){
	window.location.href = "emp_leave_summary.php";
});	

$('#btn_cancel_LB_modal').click(function(){
	window.location.href = "emp_leave_summary.php";
});	

$('#btn_close_leave_remarks').click(function(){
	window.location.href = "emp_leave_summary.php";
});	

$('#lbl_radio_otherAdd').change(function () {
    if ($(this).is(':checked')) {
        // alert("Enable other address!");
			$('#emp_address').prop('disabled', true);
			$('#emp_address').val('N/A');
			$('#address').prop('disabled', false);
			$('#address').val('');

    } else {
        // alert("disabled other address!");
			$('#emp_address').val(emp_address);
			$('#emp_address').prop('disabled', false);
			$('#address').prop('disabled', true);
			$('#address').val('N/A');
    }
});
		
$('#lbl_radio_update_otherAdd').click(function(){
	$('#update_emp_address').prop('disabled', true);
	$('#update_emp_address').val('');
	$('#update_address').prop('disabled', false);
});

// Leave Applied	
$("input[name='leave_applied']").click(function() { 
	leave_applied = this.value;
	var dateFrom = $('#date_absent_from');
	var dateTo = $('#date_absent_to');
	var delFrom = $('#del_date_from');
	var delTo = $('#del_date_to');
	
	// Get Month
	var currentTime = new Date() 
	var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), +1);

if ($("input[name='leave_applied']:checked").val() == 0 ){ //SICK LEAVE
	$('#textboxes').hide();
	$("input[id='date_absent_from']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", false);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');
	
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", false);
		$('#other_reason').val('3');
		$('#reason').val('');

var minDate = new Date();
minDate.setMonth(minDate.getMonth() - 3); // Set minDate to 3 months ago

dateFrom.datepicker('destroy');
dateFrom.datepicker({

	/* OLD CODE */
	// minDate: '-2M, -1W',
	//minDate: '03/01/2024', // For update minDate ( Open last 2 Months )

	//beforeShowDay: function(date) {
	//var day = date.getDay();
	//return [(day != 0), ''];
	//},
	
	//onSelect: function(dateText, inst) {
	//	$('#date_absent_to').datepicker("option", {
	//		minDate: new Date(dateText),
	//	});
	//},
	/* UP TO HERE */

	minDate: minDate,

    beforeShowDay: function(date) {
        var day = date.getDay();
        return [(day != 0), '']; // Disable Sundays
    },

    onSelect: function(dateText) {
        $('#date_absent_to').datepicker("option", {
            minDate: new Date(dateText)
        });
    }
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

} 
else if ($("input[name='leave_applied']:checked").val() == 1 ){ //VACATION LEAVE
	$('#textboxes').hide();
	$("input[id='date_absent_from']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", false);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');
		
		$("select[name='other_reason']").attr("disabled", false);
		$('#other_reason').val('');

		$('#other_reason').change(function(){   
		if($('#other_reason').val() === '3') {   
			$("textarea[id='reason']").prop("disabled", false);
			$('#reason').val('');
		} else {
			$("textarea[id='reason']").prop("disabled", true);
			$('#reason').val('N/A');
		}

		if($('#other_reason').val() === '0' || $('#other_reason').val() === '1' || $('#other_reason').val() === '2') {   
			$('#reason').val('N/A');
			$("textarea[id='reason']").prop("disabled", true);
		} else {
			$("textarea[id='reason']").prop("disabled", false);
			$('#reason').val('');
		}

		});  
	
dateFrom.datepicker('destroy');
dateFrom.datepicker({

	minDate: minDate, 
	// minDate: '06/25/2017', 

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
	
} 
else if ($("input[name='leave_applied']:checked").val() == 2 ){ // BIRTHDAY LEAVE
	$('#textboxes').hide();
	$("input[id='date_absent_from']").prop("disabled", false);
	// $("input[id='date_absent_to']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", true);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');
		
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", true);
		$('#other_reason').val('3');
		$('#reason').val('Birthday Leave');		
		
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
dateFrom.datepicker( { 
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
		$("#no_of_days").val(days);
}
});

} 
else if ($("input[name='leave_applied']:checked").val() == 3 ){ //MATERNITY LEAVE
	$('#textboxes').hide();
	$("input[id='date_absent_from']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", false);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');
	$('#reason').val('');
	
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", true);
		$('#other_reason').val('3');
		$('#reason').val('Maternity Leave');

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	// minDate: '-2M, -1W', 
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 119);
		$('#date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
		});
	},
});
 
dateTo.datepicker('destroy');
dateTo.datepicker( { 
	onSelect: function (dateStr) {
		var start = $("#date_absent_from").datepicker("getDate");
		var end = $("#date_absent_to").datepicker("getDate");
		var diff = 1; 
		var days = diff + (end - start) / (1000 * 60 * 60 * 24);
		$("#no_of_days").val(days);
	}
});
	
} 
else if ($("input[name='leave_applied']:checked").val() == 4 ){ //PATERNITY LEAVE
	// $('#textboxes').show();
	$("input[id='date_absent_from']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", false);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');
	$('#reason').val('');
		
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", false);
		$('#other_reason').val('3');
		$('#reason').val('');
	
// delFrom.datepicker('destroy');
// delFrom.datepicker({
	// minDate: '-2M, -1W', 
	// onSelect: function(dateText, inst) {
		// var nyd = new Date(dateText);
		// nyd.setDate(nyd.getDate() + 59);
		// $('#del_date_to').datepicker("option", {
			// minDate: new Date(dateText),
			// maxDate: nyd
		// });
	// },
// });
 
// delTo.datepicker('destroy');
// delTo.datepicker( { 
	// onSelect: function (dateStr) {
		// var delstart = $("#del_date_from").datepicker("getDate");
		// var delend = $("#del_date_to").datepicker("getDate");
		// var deldiff = 1; 
		// var deldays = deldiff + (delend - delstart) / (1000 * 60 * 60 * 24);
		// $("#del_days").val(deldays);
	// }
// });
	
var minDate = new Date();
minDate.setMonth(minDate.getMonth() - 1); // Set minDate to 1 month ago

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	
	minDate: minDate,
	
	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
	
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 7);
		$('#date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
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
	
} 
else if ($("input[name='leave_applied']:checked").val() == 5 ){ //BEREAVEMENT LEAVE
	$('#textboxes').hide();
	$("input[id='date_absent_from']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", false);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');
	$('#reason').val('');
	
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", false);
		$('#other_reason').val('3');
		$('#reason').val('');

var minDate = new Date();
minDate.setMonth(minDate.getMonth() - 1); // Set minDate to 1 month ago

dateFrom.datepicker('destroy');
dateFrom.datepicker({

	minDate: minDate,

	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
	
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 2);
		$('#date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
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
	
} 
else if ($("input[name='leave_applied']:checked").val() == 6 ){ //SOLO PARENT LEAVE
	$('#textboxes').hide();
	$("input[id='date_absent_from']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", false);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');
	$('#reason').val('');
	
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", false);
		$('#other_reason').val('3');
		$('#reason').val('');

var minDate = new Date();
minDate.setMonth(minDate.getMonth() - 1); // Set minDate to 1 month ago

dateFrom.datepicker('destroy');
dateFrom.datepicker({

	minDate: minDate,
	
	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
	
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 7);
		$('#date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
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
	
} 
else if ($("input[name='leave_applied']:checked").val() == 7 ){ //SPECIAL LEAVE BENEFIT FOR WOMEN
	$('#textboxes').hide();
	$("input[id='date_absent_from']").prop("disabled", false);
	$("input[id='date_absent_to']").prop("disabled", false);
	$('#date_absent_from').val('');
	$('#date_absent_to').val('');
	$('#no_of_days').val('');
	$('#reason').val('');
	
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", false);
		$('#other_reason').val('3');
		$('#reason').val('');

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	// minDate: '-2M, -1W', 
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 59);
		$('#date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
		});
	},
});
 
dateTo.datepicker('destroy');
dateTo.datepicker( { 
	onSelect: function (dateStr) {
		var start = $("#date_absent_from").datepicker("getDate");
		var end = $("#date_absent_to").datepicker("getDate");
		var diff = 1; 
		var days = diff + (end - start) / (1000 * 60 * 60 * 24);
		$("#no_of_days").val(days);
	}
});
	
} 
// end if

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

$("input[name='update_leave_applied']").click(function() { 
	leave_applied = this.value;
	var dateFrom = $('#update_date_absent_from');
	var dateTo = $('#update_date_absent_to');
	
if ($("input[name='update_leave_applied']:checked").val() == 0 ){ //SICK LEAVE

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	
	// minDate: '-2M, -1W',
	minDate: '03/01/2024', // For update minDate ( Open last 2 Months )
	
	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
	
	onSelect: function(dateText, inst) {
		$('#update_date_absent_to').datepicker("option", {
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
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		$("#update_no_of_days").val(diff);
	}
});

} 
else if ($("input[name='update_leave_applied']:checked").val() == 1 ){ //VACATION LEAVE

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	
	minDate: minDate, 
	
	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
	
	onSelect: function(dateText, inst) {
		$('#update_date_absent_to').datepicker("option", {
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
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		$("#update_no_of_days").val(diff);
	}
});
	
} 
else if ($("input[name='update_leave_applied']:checked").val() == 2 ){ // BIRTHDAY LEAVE
		
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
dateFrom.datepicker( { 
	changeMonth: false,
	changeYear: false,
	stepMonths: false,
	beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
	},
	
onSelect: function (dateText, inst) {
		var date = $.datepicker.parseDate($.datepicker._defaults.dateFormat, dateText);
		$("#update_date_absent_to").datepicker("option", "minDate", date)
		$("#update_date_absent_to").datepicker("setDate", date);
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = 1; 
		var days = diff + (end - start) / 86400000;
		$("#update_no_of_days").val(days);
}
});

} 
else if ($("input[name='update_leave_applied']:checked").val() == 3 ){ //MATERNITY LEAVE

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	minDate: '-2M, -1W', 
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 77);
		$('#update_date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
		});
	},
});
 
dateTo.datepicker('destroy');
dateTo.datepicker( { 
	onSelect: function (dateStr) {
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = 1; 
		var days = diff + (end - start) / (1000 * 60 * 60 * 24);
		$("#update_no_of_days").val(days);
	}
});
	
} 
else if ($("input[name='update_leave_applied']:checked").val() == 4 ){ //PATERNITY LEAVE

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	
	minDate: '03/01/2024',
	
	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
	
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 7);
		$('#update_date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
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
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		$("#update_no_of_days").val(diff);
	}
});
	
}
else if ($("input[name='update_leave_applied']:checked").val() == 5 ){ //BEREAVEMENT LEAVE

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	
	minDate: '03/01/2024',
	
	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
	
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 2);
		$('#update_date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
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
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		$("#update_no_of_days").val(diff);
	}
});
	
} 
else if ($("input[name='update_leave_applied']:checked").val() == 6 ){ //SOLO PARENT LEAVE

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	
	minDate: '03/01/2024', 
	
	beforeShowDay: function(date) {
	var day = date.getDay();
	return [(day != 0), ''];
	},
	
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 7);
		$('#update_date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
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
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		$("#update_no_of_days").val(diff);
	}
});
	
}
else if ($("input[name='update_leave_applied']:checked").val() == 7 ){ //SPECIAL LEAVE BENEFIT FOR WOMEN

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	
	// minDate: '-2M, -1W', 
	
	onSelect: function(dateText, inst) {
		var nyd = new Date(dateText);
		nyd.setDate(nyd.getDate() + 59);
		$('#update_date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
			maxDate: nyd
		});
	},
});
 
dateTo.datepicker('destroy');
dateTo.datepicker( { 
	onSelect: function (dateStr) {
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = 1; 
		var days = diff + (end - start) / (1000 * 60 * 60 * 24);
		$("#update_no_of_days").val(days);
	}
});
	
} 
/* end if */

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
	
}); //End Update function

/**
 * Check if the Leave Date(date_absent_from) is already existed by its employee id
 * Added by whyRainbowDoesntHaveBlack
 * 09-04-2024
 */
function checkIfLeaveDateIsExisted(EmpNo,date_absent_from){
	let isLeaveDateExisted = false;
	let data = {
		"action"				: 'checkIfLeaveDateIsExisted',
		"EmpNo"					: EmpNo,
		"date_absent_from"		: date_absent_from,
		// "date_absent_to"		: date_absent_to,
	}

	data = $.param(data);
	$.ajax({
		async: false,
		type	: "post",
		dataType: "json",
		data	: data,
		url		: "elfs_handler.php",
		success	: function(result){
			let data = result['data'];
			console.log('data ',data);
			if(parseInt(data['total_count']) > 0){
				isLeaveDateExisted = true;
			}
		},
	});

	return isLeaveDateExisted;
}

$('#btn_save_leave').click(function(e){ 
	if($('#date_absent_from').val() == '') {
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your Leave Applied and Date absent From! ** Required in this form.<br>');
	} else if($('#date_absent_to').val() == '') { 
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your Date absent To! ** Required in this form.<br>');
	} else {
		if(confirm($(this).data('confirm'))){
			e.preventDefault();
		} else {
			return false;
		}	

		/**
		 * Check if the Leave Date(date_absent_from) is already existed by its employee id
		 * Added by whyRainbowDoesntHaveBlack
		 * 09-04-2024
		 */
		let isLeaveDateExisted = checkIfLeaveDateIsExisted($('#EmpNo').val(), $('#date_absent_from').val());
		console.log('isLeaveDateExisted ', isLeaveDateExisted);
		if(isLeaveDateExisted){
			$('#alert_msg').show();
			$('#alert_msg').text('');
			$('#alert_msg').append('Please be informed that the Leave Date already existed!');
			return;
		}else{
			var data = {
				"action"			 : 'Save_leave_as_draft',
				"fkEmployee"		 : $('#fkEmployee').val(),
				"status"			 : '7',
				"date_created"		 : $('#date_created').val(),
				"empName"			 : "<?php echo $username; ?>",
				"created_by"		 : "<?php echo $username; ?>",
				"EmpNo"				 : $('#EmpNo').val(),
				"Division"		 	 : $('#Division').val(),
				"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
				"address"		 	 : $('#address').val(),
				"emp_address"		 : $('#emp_address').val(),
				"reason"			 : $('#reason').val(),
				"other_reason"		 : $('#other_reason').val(),
				"radio_OthersAdd"	 : $('input[name="lbl_radio_otherAdd"]:checked').val(),
				"address"			 : $('#address').val(),
				"approver1"			 : $('#approver1').val(),
				"approver2"			 : $('#approver2').val(),
				"username"			 : "<?php echo $username; ?>"
			}
			
			data = $.param(data);
			// alert(data);
			$.ajax({
				type	: 'POST',
				dataType: 'json',
				data	: data,
				url		: 'save_leave_record_as_drafts.php',
				success	: function(data){	
				
					var data1 = {
					"action"			 : 'Select_leave_as_draft',
					"fkEmployee"		 : $('#fkEmployee').val(),
					"status"			 : '7',
					"date_created"		 : $('#date_created').val(),
					"empName"			 : $('#txt_username').val(),
					"created_by"		 : $('#txt_username').val(),
					"EmpNo"				 : $('#EmpNo').val(),
					"Division"		 	 : $('#Division').val(),
					"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
					"emp_address"		 : $('#emp_address').val(),
					"reason"			 : $('#reason').val(),
					"other_reason"		 : $('#other_reason').val(),
					"radio_OthersAdd"	 : $('input[name="lbl_radio_otherAdd"]:checked').val(),
					"address"			 : $('#address').val(),
					"approver1"			 : $('#approver1').val(),
					"approver2"			 : $('#approver2').val()
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
								"no_of_days"			: $('#no_of_days').val()
							}	
						
							data2 = $.param(data2);
							// alert(data2);
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
					
					alert("Leave Application Saved!");
					window.location.href = "emp_leave_summary.php";
					
				}
				// ,error(data){
					// alert('ERROR MAIN');
				// }
			});
		} // end else
	}
});	

$('#btn_send_leave').click(function(e){ 
	
	if($('#approver1').val() == '') {
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your immediate superior!<br>');
	} else if($('#approver2').val() == '') { 
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your Sec/Department Head!<br>');
	} else if($('#date_absent_from').val() == '') { 
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your leave applied and date absent from!<br>');
	} else if($('#date_absent_to').val() == '') { 
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your date absent to!<br>');
	} else if($('#reason').val() == '') { 
		$('#alert_msg').show();
		$('#alert_msg').append('Please select your reason!<br>');
	} 
	// else if (){
	// 	$('#alert_msg').append('You are not allowed to file BDL!<br>');
	// } 
	else {
		$('#alert_msg').hide();
		
		if(confirm($(this).data('confirm'))){
			e.preventDefault();
		} else {
			return false;
		}	
		
		/**
		 * Check if the Leave Date(date_absent_from) is already existed by its employee id
		 * Added by whyRainbowDoesntHaveBlack
		 * 09-04-2024
		 */
		let isLeaveDateExisted = checkIfLeaveDateIsExisted($('#EmpNo').val(), $('#date_absent_from').val());
		console.log('isLeaveDateExisted ', isLeaveDateExisted);
		if(isLeaveDateExisted){
			$('#alert_msg').show();
			$('#alert_msg').text('');
			$('#alert_msg').append('Please be informed that the Leave Date already existed!');
			return;
		}else{
			var data = {
				"action"			 : 'savesend_leave_record',
				"fkEmployee"		 : $('#fkEmployee').val(),
				"status"			 : '0',
				"date_created"		 : $('#date_created').val(),
				"empName"			 : "<?php echo $username; ?>",
				"created_by"		 : "<?php echo $username; ?>",
				"EmpNo"				 : $('#EmpNo').val(),
				"Division"		 	 : $('#Division').val(),
				"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
				"emp_address"		 : $('#emp_address').val(),
				"reason"			 : $('#reason').val(),
				"other_reason"		 : $('#other_reason').val(),
				"radio_OthersAdd"	 : $('input[name="lbl_radio_otherAdd"]:checked').val(),
				"address"			 : $('#address').val(),
				"approver1"			 : $('#approver1').val(),
				"approver2"			 : $('#approver2').val(),
				"username"			 : "<?php echo $username; ?>"
			}
			
			data = $.param(data);
			// alert(data);
			$.ajax({
				type	: 'POST',
				dataType: 'json',
				data	: data,
				url		: 'save_leave_record.php',
				success	: function(data){	
				
					var data1 = {
					"action"			 : 'Select_leave_record',
					"fkEmployee"		 : $('#fkEmployee').val(),
					"status"			 : '0',
					"date_created"		 : $('#date_created').val(),
					"empName"			 : $('#txt_username').val(),
					"created_by"		 : $('#txt_username').val(),
					"EmpNo"				 : $('#EmpNo').val(),
					"Division"		 	 : $('#Division').val(),
					"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
					"emp_address"		 : $('#emp_address').val(),
					"reason"			 : $('#reason').val(),
					"other_reason"		 : $('#other_reason').val(),
					"radio_OthersAdd"	 : $('input[name="lbl_radio_otherAdd"]:checked').val(),
					"address"			 : $('#address').val(),
					"approver1"			 : $('#approver1').val(),
					"approver2"			 : $('#approver2').val()
					}
					
					data1 = $.param(data1);
					// alert(data1);
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
						var approver1 		= result['approver1'];
						
						var data2 = {
							"pkid"					: result['pkid'],
							"created_by"			: result['created_by'],
							"EmpNo"					: result['EmpNo'],
							"leave_applied"			: result['leave_applied'],
							"date_absent_from"		: $('#date_absent_from').val(),
							"date_absent_to"		: $('#date_absent_to').val(),
							"no_of_days"			: $('#no_of_days').val()
						}	
						
						data2 = $.param(data2);
						// alert(data2);
						$.ajax({
							type	: "post",
							dataType: "json",
							data	: data2,
							url		: "save_leave_dates.php",
							success	: function(result){			
							},error	: function(result){
							}
						});
						
						if(result['approver1'] == 0) {
							var data3 = {
								"action"			: "send_email_for_approval_to_DH",
								"pkid"				: result['pkid']
							}
						
							data3 = $.param(data3);
							// alert(data3);
							$.ajax({
								type		: "POST",
								dataType	: "json",
								data		: data3,
								url			: "elfs_handler.php",
								success		: function (result) {
								}, error	: function (result) {
								}
							});
						
						} else {
						
							var data4 = {
								"action"			: "send_email_for_approval",
								"pkid"				: result['pkid']
							}
							
							data4 = $.param(data4);
							// alert(data4);
							$.ajax({
								type		: "POST",
								dataType	: "json",
								data		: data4,
								url			: "elfs_handler.php",
								success		: function (result) {
								}, error	: function (result) {
								}
							});
						} // end else				
								
						}, error: function (result) {
						}
					});
					
					alert("Leave Application has been added!");
					window.location.href = "emp_leave_summary.php";
					
				}
				// ,error(data){
					// alert('ERROR MAIN');
				// }
			});
		}
	} // end else
});	

$('#btn_send_update_leave').click(function(e){ 
	if($('#update_cmb_approver1').val() == '') {
		$('#alert_msg2').show();
		$('#alert_msg2').append('Please select your immediate superior!<br>');
	} else if($('#update_cmb_approver2').val() == '') { 
		$('#alert_msg2').show();
		$('#alert_msg2').append('Please select your Sec/Department Head!<br>');
	} else if($('#update_reason').val() == '') { 
		$('#alert_msg2').show();
		$('#alert_msg2').append('Please select your reason!<br>');
	} else {
		$('#alert_msg2').hide();
		
	if(confirm($(this).data('confirm'))){
		e.preventDefault();
	} else {
		return false;
	}	
		
	var data = {
		"action"				 : 'update_leave_record',
		"pkid"					 : $('#update_txt_pkid').val(),
		"fkEmployee"		 	 : $('#update_fkEmployee').val(),
		"status"				 : '0',
		"leave_applied"			 : $('input[name="update_leave_applied"]:checked').val(),
		"reason"				 : $('#update_reason').val(),
		"other_reason"			 : $('#update_other_reason').val(),
		"emp_address"			 : $('#update_emp_address').val(),
		"address"				 : $('#update_address').val(),
		"approver1"			 	 : $('#update_cmb_approver1').val(),
		"approver2"				 : $('#update_cmb_approver2').val(),
		"username"				 : "<?php echo $username; ?>"
	}
	
	data = $.param(data);
	// alert(data);
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		data	: data,
		url		: 'update_leave_record.php',
		success	: function(data){	
	
		var data1 = {
		"action"				 : 'Select_leave_record_for_update',
		"pkid"					 : $('#update_txt_pkid').val(),
		"fkEmployee"		 	 : $('#update_fkEmployee').val(),
		"status"				 : '0',
		"leave_applied"			 : $('input[name="update_leave_applied"]:checked').val(),
		"reason"				 : $('#update_reason').val(),
		"other_reason"			 : $('#update_other_reason').val(),
		"emp_address"			 : $('#update_emp_address').val(),
		"address"				 : $('#update_address').val(),
		"approver1"			 	 : $('#update_cmb_approver1').val(),
		"approver2"				 : $('#update_cmb_approver2').val()
		}
		
		data1 = $.param(data1);
		$.ajax({
			type	: "POST",
			dataType: "json",
			data	: data1,
			url		:"elfs_handler.php",
			success	: function (result) {
			
			if(result['approver1'] == 0) {
				var data3 = {
					"action"			: "send_email_for_approval_to_DH",
					"pkid"				: result['pkid']
				}
			
			data3 = $.param(data3);
			// alert(data3);
			$.ajax({
				type		: "POST",
				dataType	: "json",
				data		: data3,
				url			: "elfs_handler.php",
				success		: function (result) {
				}, error	: function (result) {
				}
			});
			
			} else {
			
				var data4 = {
					"action"			: "send_email_for_approval",
					"pkid"				: result['pkid']
				}
				
				data4 = $.param(data4);
				// alert(data4);
				$.ajax({
					type		: "POST",
					dataType	: "json",
					data		: data4,
					url			: "elfs_handler.php",
					success		: function (result) {
					}, error	: function (result) {
					}
				});
			}				
					
			}, error: function (result) {
			}
		});
		
		alert("Leave Application has been Updated!");
		window.location.href = "emp_leave_summary.php";
		
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
		$('#alert_msg3').show();
		$('#alert_msg3').append('Please add your reason!<br>');
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
		update_cancelled_status($('#cancel_txt_pkid').val(),status);
	}
	
});

/* $('#other_reason').change(function(){   
if($('#other_reason').val() === '3') {   
	$("textarea[id='reason']").prop("disabled", false);
	$('#reason').val('');
} else {
	$("textarea[id='reason']").prop("disabled", true);
	$('#reason').val('N/A');
}

if($('#other_reason').val() === '0' || $('#other_reason').val() === '1' || $('#other_reason').val() === '2') {   
	$('#reason').val('N/A');
	$("textarea[id='reason']").prop("disabled", true);
} else {
	$("textarea[id='reason']").prop("disabled", false);
	$('#reason').val('');
}

});  */

$('#update_other_reason').change(function(){   
	if($('#update_other_reason').val() === '3') {   
		$("textarea[id='update_reason']").prop("disabled", false);
		$('#update_reason').val('');
	} else {
		$("textarea[id='update_reason']").prop("disabled", true);
		$('#update_reason').val('N/A');
	}
	
	if($('#update_other_reason').val() === '0' || $('#update_other_reason').val() === '1' || $('#update_other_reason').val() === '2') {   
		$('#update_reason').val('N/A');
		$("textarea[id='update_reason']").prop("disabled", true);
	} else {
		$("textarea[id='update_reason']").prop("disabled", false);
	}
	
});
	
/* Function */
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
			// $('#IS_disapproved_remarks_show').val(result['disapproved_label']+ ' - ' +' '+ result['IS_disapproved_remarks']);
			$('#DH_disapproved_remarks_show').val(result['DH_disapproved_remarks']);
			$('#HR_revise_remarks_show').val(result['HR_revised_remarks']);
			$('#Cancelled_remarks_show').val(result['Cancelled_remarks']);
			$('#HR_cancel_remarks_show').val(result['HR_cancel_remarks']);
			$('#pkid_remarks').val(result['pkid']);
			$('#show_remarks_modal').modal('show');
			
		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}

function select_leave_info_for_cancel_by_pkid(pkid) { 
	var data1 = {
		"action"			 : "select_leave_info_for_cancel_by_pkid",
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
			
			if(result['status'] == 0 || 
				result['status'] == 1 || 
				result['status'] == 2 || 
				result['status'] == 3 || 
				result['status'] == 5 || 
				result['status'] == 6) {	
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
					$('#update_date_absent_from').prop('disabled', true);
					$('#update_date_absent_to').prop('disabled', true);
					$('#update_reason').prop('disabled', true);
					$('#update_other_reason').prop('disabled', true);
					$('#btn_save_update_leave').prop('disabled', true);
					$('#btn_send_update_leave').prop('disabled', true);
			}
			
			if(result['status'] == 7) {	
				$('#update_rbtn_bdl').prop('disabled', true);
				$('#update_rbtn_ml').prop('disabled', true);
				$('#update_rbtn_pl').prop('disabled', true);
				$('#update_rbtn_bl').prop('disabled', true);
				$('#update_rbtn_sp').prop('disabled', true);
				$('#update_rbtn_slbw').prop('disabled', true);
				$('#update_date_absent_from').prop('disabled', true);
				$('#update_date_absent_to').prop('disabled', true);
			}	
			
			if(result['status'] == 4) {	
				$('#lbl_radio_update_otherAdd').prop('disabled', true);
				$('#update_address').prop('disabled', true);
				$('#update_date_absent_from').prop('disabled', true);
				$('#update_date_absent_to').prop('disabled', true);
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
	
			$('#update_date_created').val(result['date_created']);
			$('#update_empName').val(result['Emp_Name']);
			$('#update_EmpNo').val(result['EmpNo']);
			$('#update_division').val(result['Division']);				
			$('#update_date_absent_from').val(result['date_from']);
			$('#update_date_absent_to').val(result['date_to']);
			$('#update_no_of_days').val(result['total_absent_days']);
			// $('#update_reason').val(result['reason']);
			$('#update_emp_address').val(result['emp_address']);
			$('#update_cmb_approver1').val(result['approver1']);
			$('#update_cmb_approver2').val(result['approver2']);
			$('#update_txt_status').val(result['status']);	
			$('#update_txt_pkid').val(pkid);	
			
			if(result['address'] == '') {	
				$('#update_address').val('N/A');
			} else {
				$('#update_address').val(result['address']);
			}
			
			if(result['other_reason'] == 0 || result['other_reason'] == 1 || result['other_reason'] == 2 || result['other_reason'] == 3) {	
				$('#update_reason').val(result['reason']);
				$('#update_other_reason').val(result['other_reason']);
			} else {
				$('#update_reason').val(result['reason']);
			}
			
			$('#lbl_radio_update_otherAdd').click(function(){
				$('#update_emp_address').prop('disabled', true);
				$('#update_emp_address').val('N/A');
				$('#update_address').prop('disabled', false);
			});		
				
			$("#Leave_application_modal_update").modal();
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
		
		if(result['status'] == 0 || result['status'] == 1 || result['status'] == 2 || result['status'] == 3 || result['status'] == 4 || result['status'] == 5 || result['status'] == 6 || result['status'] == 8 || result['status'] == 9) {
			// if(result['leave_applied'] == 3) {
				// $('#view_emp_leave').modal('disabled', true);
			// }
			
			$('#txt_pkid_view_leave').val(pkid);
			$('#view_emp_leave').modal();
			get_view_leave_dates_summary(pkid);
						
		} else if(result['status'] == 7) {
			$('#txt_pkid_edit_leave').val(pkid);
			$('#modal_edit_emp_leave').modal();
			get_edit_leave_dates_summary(pkid);
		}	
							
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}

function get_edit_leave_dates_summary(){
	var pkid = $("#txt_pkid_edit_leave").val();
	var data = {
		"action"	: "get_edit_leave_dates_summary",
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
				$('#EditLeave_summary').empty();	
					var html  = '<table id="tbl_leave_records" class="table table-bordered">';
						html += '	<thead>';
						html += '		<tr>';
						html += '			<th><center><font size="2">DATE ABSENT</font></center></th>';
						html += '			<th><center><font size="2">NO. OF DAYS</font></center></th>';
						html += '			<th><center><font size="2">HALFDAY / DELETE</font></center></th>';
						html += '		</tr>';
						html += '	</thead>';
						html += '	<tbody>';
						html += '	</tbody>';
						html += '</table>';
					
				$('#EditLeave_summary').append(html);	
			
			for(i=0;i<ctr;i++){
				var html  = '<tr id="'+data['pkid'][i]+'">';
					html += '	<td style="text-align: center;font-size: 14px;">'+data['date_absent_from'][i]+ ' - ' +data['date_absent_to'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_days'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;"><button class="btn btn-warning" id="btn_edit_leave_date" data-confirm="Are you sure you want to set this date as halfday?" style="border-radius: 0px;" value="'+data['pkid_leave_date'][i]+'" title="Click to edit leave date" ><span class="glyphicon glyphicon-pencil"></span></button>	<button class="btn btn-danger" id="btn_remove_leave_date" data-confirm="Are you sure you want to remove this date?" style="border-radius: 0px;" value='+data['pkid_leave_date'][i]+' title="Click to remove leave date"><span class="glyphicon glyphicon-trash"></span></button></td>';	
					html += '</tr>';
				 $('#tbl_leave_records tbody').append(html);			
			}
			
			var oTable = $('#tbl_leave_records').DataTable({ 
				"paginate":true, 
				"aaSorting": [],
			});
			edit_table_events();
			
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
			console.log( data['script'] );
			var ctr = data['ctr'];
				$('#ViewLeave_summary').empty();	
					var html  = '<table id="tbl_leave_view_records" class="table table-bordered">';
						html += '	<thead>';
						html += '		<tr>';
						html += '			<th><center><font size="2">DATE ABSENT</font></center></th>';
						html += '			<th><center><font size="2">NO. OF DAYS</font></center></th>';
						html += '			<th><center><font size="2">PAID LEAVE</font></center></th>';
						html += '			<th><center><font size="2">CUT-OFF</font></center></th>';
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
				 $('#tbl_leave_view_records tbody').append(html);			
			}
			
			var oTable = $('#tbl_leave_view_records').DataTable({ 
				"paginate":true, 
				"aaSorting": [],
			});
			view_table_events();
			
		},error	: function(data){
			alert(data);
		}
	});
} 

function edit_table_events(){
$('#tbl_leave_records tbody tr').click(function(){
	edit_selected_pkid = "";
		$('#tbl_leave_records tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
	edit_selected_pkid = this.id;
});
}

function view_table_events(){
$('#tbl_leave_view_records tbody tr').click(function(){
	view_selected_pkid = "";
		$('#tbl_leave_view_records tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
	view_selected_pkid = this.id;
});
}

function update_halfday(pkid) {
		
	var data = {
		"action"				 : "update_halfday",
		"pkid"					 : pkid
	}
	data = $.param(data);
	// alert(data);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data,
		url			: "update_halfday.php",
		success		: function (result) {
		
		alert('Successfully Updated!');
		window.location.href = "emp_leave_summary.php";
		}, error	: function (result) {
			alert('ERROR: '+result);
		}
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
		window.location.href = "emp_leave_summary.php";
		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}

function update_cancelled_status(pkid,status) {
		
	var data = {
		"action"				 : "update_cancelled_status",
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
		// url			: "elfs_handler.php",
		url			: "update_cancelled_leave.php",
		success		: function (result) {
		
		var data1 = {
				"action": "send_email_cancelled_leave",
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
		
			alert('Successfully Updated!');
			window.location.href = "emp_leave_summary.php";

		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}

</script>
</html>