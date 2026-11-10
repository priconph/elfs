<?php
    include("includes.php");
	require_once("elfs_oop.php");
	session_start();

	$username = $_SESSION['username'];
	$username = 'jangeco';
	
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
		 $regularity_date 	=  $rowEmpInfo['regularity_date'];
		 $CityAddress1 		=  $rowEmpInfo['CityAddress1'];
		 $CityAddress2 		=  $rowEmpInfo['CityAddress2'];
		 $CityAddress3 		=  $rowEmpInfo['CityAddress3'];
		 $SalaryType 		=  $rowEmpInfo['SalaryType'];
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
	<meta charset="utf-8">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
	<script src="dist/js/bootstrap-select.js"></script>
	<link rel="stylesheet" href="dist/css/bootstrap-select.css">

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
		color: #DE2A00;
	}
	
	#total_SL_used {
		color: #DE2A00;
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
			
</style>
</head>
<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>

<div class="tabbable"> 
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#tab1" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE SUMMARY</a>
		</li>
		<li>
			<a href="#tab2" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE HISTORY</a>
		</li>
		<li>
			<a href="#tab3" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE BALANCE</a>
		</li>
	</ul>
<div class="tab-content">
<div class="tab-pane active" id="tab1">
<br>
<br>

<div class="panel panel-primary" style="margin:auto; width:95%;">
	<div class="panel-heading">EMPLOYEE LEAVE SUMMARY</div>
	<div class="panel-body">
	<table style="text-align:right; width: 100%;">
		<tr>
			<td>
				<form class="form-inline" role="form" method="POST" action="">
				
					<a href="#" class="btn btn-primary" id="btn_new_leave" name="btn_new_leave" style="border-radius: 0px; height: 35px;" title="Click this to add new leave">&nbsp; ADD NEW LEAVE &nbsp;</a>
					<a href="#" class="btn btn-warning" id="btn_leave_batch" name="btn_leave_batch" style="border-radius: 0px; height: 35px;" title="Click this to manage employee leave batch">&nbsp; MANAGE LEAVE BATCH &nbsp;</a>
				<!--
					<a href="index.php" class="btn btn-warning" id="btn_leave_batch" name="btn_leave_batch" style="border-radius: 0px; height: 35px;" title="Click this to manage employee leave batch">&nbsp; MANAGE LEAVE BATCH &nbsp;</a>
				-->	
					<br/>
				</form>
			</td>
		</tr>
	</table>
	<form id="" method="get">
		<table id="leave_tbl" name="leave_tbl" class="table table-bordered" width="100%">
		<thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle;" class="hide">username</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status Remarks" data-original-title="">REMARKS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" data-original-title=""></th>
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
					$status_label = '<div class="ui orange ribbon label">DRAFT</div>'; 
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
				
				if($row['IS_disapproved_remarks'] != "" || $row['DH_disapproved_remarks'] != "" || $row['HR_revised_remarks'] !="") {
						$btn_view_remarks = '<button class="btn btn-danger" id="btn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
				} else {
						$btn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found."><span class="glyphicon glyphicon-comment"></span></button>';
				}

				if($row['status'] == 0 || $row['status'] == 1 || $row['status'] == 2 || $row['status'] == 5 || $row['status'] == 6 ) {
						$btn_edit_view = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
				} else if ($row['status'] == 4 || $row['status'] == 7) {
						$btn_edit_view = '<button class="btn btn-warning" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to edit leave application"><span class="glyphicon glyphicon-edit"></span></button>';
				} else {
						$btn_edit_view = '<button class="btn btn-default" style="border-radius: 0px;" ><span class="glyphicon glyphicon-eye-close"></span></button>';
				}
				
				// if ($row['status'] == 4) {
						// $btn_edit_view = '<button class="btn btn-warning" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to edit"><span class="glyphicon glyphicon-edit"></span></button>';
				// } else {
						// $btn_edit_view = '<button class="btn btn-default" style="border-radius: 0px;"><span class="glyphicon glyphicon-ban-circle"></span></button>';
				// }
				
				$pkid = $row['pkid'];	
				echo "
					<tr>	
						<td style='display:none;'>".$pkid."</td>
						<td style='display:none'>".$row['username']."</td>
						<td style='font-family: Euphemia;'>".$status_label."</td>
						<td style='text-align: center; font-family: Euphemia;'>".$btn_view_remarks."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 13px;'>".date('F d, Y',strtotime($row['date_created']))."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$leave_applied."</td>
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
		<table id="leave_history_tbl" name="leave_history_tbl" class="table table-bordered" width="100%" >
		 <thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Remarks" data-original-title="">REMARKS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Absent" data-original-title="">DATE ABSENT</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by No. of days" data-original-title="">NO. OF DAYS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by No. of paid" data-original-title="">NO. OF PAID</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Adress during leave" data-original-title="">ADDRESS DURING LEAVE</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Other address during leave" data-original-title="">OTHER ADDRESS DURING LEAVE</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Reason/s" data-original-title="">REASONS/S</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Immediate Superior" data-original-title="">IMMEDIATE SUPR.</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Department Head" data-original-title="">DEPT. HEAD</th>
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
				}	

				if($row['IS_disapproved_remarks'] != "" || $row['DH_disapproved_remarks'] != "" || $row['HR_revised_remarks'] !="") {
						$hbtn_view_remarks = '<button class="btn btn-danger" id="hbtn_show_remarks" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view remarks"><span class="glyphicon glyphicon-comment"></span></button>';
				} else {
						$hbtn_view_remarks = '<button class="btn btn-default" style="border-radius: 0px;" title="No remarks found."><span class="glyphicon glyphicon-comment"></span></button>';
				}
				
				$pkid = $row['pkid'];	
				echo "
					<tr>	
						<td style='display:none'>".$pkid."</td>
						<td style='font-size: 16px;'>".$status_label."</td>
						<td style='text-align: center; font-size: 16px;'>".$hbtn_view_remarks."</td>
						<td style='text-align: center; font-size: 13px;'>".date('F d, Y',strtotime($row['date_created']))."</td>
						<td style='text-align: center; font-size: 14px;'>".$leave_applied."</td>
						<td style='text-align: center; font-size: 13px;'>".date('F d, Y',strtotime($row['date_from']))." - ".date('F d, Y',strtotime($row['date_to']))."</td>
						<td style='text-align: center; font-size: 14px;'>".$row['total_absent_days']."</td>
						<td style='text-align: center; font-size: 14px;'>".$row['no_of_paid']."</td>
						<td style='text-align: center; font-size: 14px;'>".$row['emp_address']."</td>
						<td style='text-align: center; font-size: 14px;'>".$row['address']."</td>
						<td style='text-align: center; font-size: 14px;'>".$row['reason']."</td>
						<td style='text-align: center; font-size: 14px;'>".$row['ISapprover1']."</td>
						<td style='text-align: center; font-size: 14px;'>".$row['DHapprover2']."</td>
					</tr>
					";
					}
					// <td style='text-align: center; font-size: 13px;'>".date('F d, Y',strtotime($row['date_absent_from']))." - ".date('F d, Y',strtotime($row['date_absent_to']))."</td>
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
				<label class="FormLeaveLabel">Credit VL:</label>
				<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="credit_VL" name="credit_VL" value="<?php echo $credit_VL; ?>" readonly>
				<br>
				<label class="FormLeaveLabel">Credit VL to avail:</label>
				<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="current_avail_VL" name="current_avail_VL" value="<?php echo $current_avail_VL; ?>" readonly>	
				<br>
				<label class="FormLeaveLabel">Total VL used:</label>
				<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_VL_used" name="total_VL_used" value="<?php echo $total_VL_used; ?>" readonly>	
				<br>
				<label class="FormLeaveLabel">Total VL balance:</label>
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
				<input type="hidden" style="width:200px; height:5%;" class="FormText_LB" readonly>	
				<br>
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
				<label class="FormLeaveLabel">Credit SL:</label>
				<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="credit_SL" name="credit_SL" value="<?php echo $credit_SL; ?>" readonly>
				<br>
				<label class="FormLeaveLabel">Credit SL to avail:</label>
				<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="current_avail_SL" name="current_avail_SL" value="<?php echo $current_avail_SL; ?>" readonly>	
				<br>
				<label class="FormLeaveLabel">Total SL used:</label>
				<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_SL_used" name="total_SL_used" value="<?php echo $total_SL_used; ?>" readonly>	
				<br>
				<label class="FormLeaveLabel">Total SL balance:</label>
				<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_SL_balance" name="total_SL_balance" value="<?php echo $total_SL_balance; ?>" readonly>	
				<br>
			</div>			
			</div>	
			</div>
		</div><!-- row3-->
		</form>	

	</div>
</div> 
</div><!-- tab3-->

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
			 <center><div id="div_msg_new" style="display:none;color:red;font-weight:bold;text-align:center;width:100%" class="row alert alert-danger"></div></center>

			<div class="row">
				<div class="col-sm-6">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-danger">
							<div class="panel-heading" role="tab" id="headingOne">
							  <h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color: #b30000;">
								  <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>&nbsp; Additional Information
								</a>
							  </h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							  <div class="panel-body">
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Birthday Leave</strong>	- 1 Day (Birth Month)</p>
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Bereavement Leave</strong>  - 3 Days</p>
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Maternity Leave</strong>  - Normal (60 Days) and CS (78 Days) without pay</p>
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Paternity Leave </strong>  - 7 Working days</p>
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Solo Parent Leave</strong>  - 7 Working days</p>
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
					<label class="FormLabel">Address during leave:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="emp_address" name="emp_address" value="<?php echo $CityAddress2, ', ', $CityAddress3; ?>" readonly>	
					<br>
					<input class="FormLabel" type="radio" id="lbl_radio_otherAdd" name="lbl_radio_otherAdd" value="1">
					<label style="width:220px;">Others <i>(Leave Address)</i></label>
					<br>
					<label class="FormLabel"></label>
					<textarea rows="2" style="width:220px;" id="address" name="address" value="<?php echo $address; ?>" disabled></textarea>
					<br>
					<label class="FormLabel" for="approver1">Immediate Superior:</label>
						<?php 												
						// echo "<select id='approver1' name='approver1' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Immediate Superior...' required>"; 
							// $result = ELFS::getInstance()->getImmediateSupr();
							// while($row = mysqli_fetch_array($result)){
								// echo "<option value='".$row['username']."'>".$row['firstname']." ".$row['lastname']."</option>";
							// }
						// echo "</select>";	

						echo "<select id='approver1' name='approver1' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Immediate Superior...' required>"; 
							$result = ELFS::getInstance()->getSectionHead($username);
							while($row = mysqli_fetch_array($result)){
								$get_emp_info = ELFS::getInstance()->getSectionHeadName($row['approver_username']);
								if($row_emp_info = mysqli_fetch_array($get_emp_info)) {
									echo "<option value='0'>---Not Applicable---</option>";
									echo "<option value='".$row['approver_username']."'>".$row_emp_info['FirstName']." ".$row_emp_info['LastName']."</option>";
								}
							}
						echo "</select>";	
						?>
					<br>
					<label class="FormLabel" for="approver2">Department Head:</label>
						<?php 
						// echo "<select id='approver2' name='approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Department Head...' required>"; 
							// $result = ELFS::getInstance()->getDeptHeads();
							// while($row = mysqli_fetch_array($result)){
								// echo "<option value='".$row['username']."'>".$row['firstname']." ".$row['lastname']."</option>";
							// }
						// echo "</select>";	
						
						echo "<select id='approver2' name='approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Department Head...' required>"; 
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
				<div class="panel panel-success" id="leave_applied_category">
						<div class="panel-heading">
							<div class="row">
								<div class="col-sm-12"><b>LEAVE APPLIED</b></div>
							</div>
						</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-6">
								<input class="FormLeaveApplied" type="radio" id="rbtn_sl" name="leave_applied" value="0">
								<label id="lbl_sl">Sick Leave</label>
								<br>
								<input class="FormLeaveApplied" type="radio" id="rbtn_vl" name="leave_applied" value="1">
								<label id="lbl_vl">Vacation Leave</label>
								<br>
								<input class="FormLeaveApplied" type="radio" id="rbtn_bdl" name="leave_applied" value="2">
								<label id="lbl_bdl">Birthday Leave</label>
							</div>
							<div class="col-sm-6">
								<input class="FormLeaveApplied" type="radio" id="rbtn_bl" name="leave_applied" value="5">
								<label id="lbl_bdl">Bereavement Leave</label>
								<br>
								<input class="FormLeaveApplied" type="radio" id="rbtn_sp" name="leave_applied" value="6">
								<label id="lbl_bdl">Solo Parent Leave</label>
								<br>
								<input class="FormLeaveApplied" type="radio" id="rbtn_ml" name="leave_applied" value="3">
								<label id="lbl_bdl">Maternity Leave</label>
								<br>
								<input class="FormLeaveApplied" type="radio" id="rbtn_pl" name="leave_applied" value="4">
								<label id="lbl_bdl">Paternity Leave</label>
								<br>
							</div>			
						 </div>			
					</div>			
					</div>
					
					<label style="width:300px;">Date of Absent/s:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormText">
					<br>
					<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="date_absent_from" name="date_absent_from" autocomplete="off" readonly="true" required>
					<br>
					<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
					<input type="text" style="width:220px; height:5%;" class="FormText" id="date_absent_to" name="date_absent_to" autocomplete="off" readonly="true" required> 
					<br>
					<label class="FormLabel">No. of days:</label>
					<input type="text" style="width:50px; height:5%;" class="FormText" id="no_of_days" name="no_of_days" readonly>
					<!--
					<button type="button" id="btn_verify_leaves" class="btn btn-info pull-right" style="border-radius: 0px;font-family: Euphemia;width: 150px;">Verify Leave Dates</button>
					-->
					<br>
					<label class="FormLabel">Reason/s:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormText" >
					<br>
					<label class="FormLabel"></label>
					<textarea rows="3" style="width:220px;" class="FormText" id="reason" name="reason" required></textarea>
					<br>
				</div>
			</div><!-- end row -->
			<div class="modal-footer">
				<button type="button" id="btn_save_leave" data-confirm="Are you sure you want to save as draft this leave?" class="btn btn-primary" style="border-radius: 0px;font-family: Euphemia;width: 130px; height: 35px;">SAVE AS DRAFT</button>
				<button type="button" id="btn_send_leave" data-confirm="Are you sure you want to file this leave?" class="btn btn-success" style="border-radius: 0px;font-family: Euphemia;width: 130px; height: 35px;">SAVE&SEND </button>
				<button type="button" id="btn_cancel_leave_modal" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 130px; height: 35px;" data-dismiss="modal">CANCEL</button> &nbsp;
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
			<form action="#" id="form_UpdateLeave" data-confirm="Are you sure you want to re-file this leave?" >
				<input type="hidden" id="update_txt_pkid" name="update_txt_pkid" value="<?php echo $pkid; ?>"> 
				<input type="hidden" id="update_txt_username" name="update_txt_username" value="<?php echo $username; ?>"> 
				<input type="hidden" id="update_txt_status" name="update_txt_status" value="<?php echo $status; ?>"> 
				
			<div class="row">
				<div class="col-sm-6">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-danger">
							<div class="panel-heading" role="tab" id="headingOne">
							  <h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="color: #b30000;">
								  <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>&nbsp; Additional Information
								</a>
							  </h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
							  <div class="panel-body">
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Birthday Leave</strong>	- 1 Day (Birth Month)</p>
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong>Bereavement Leave</strong>  - 3 Days</p>
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Maternity Leave</strong>  - Normal (60 Days) and CS (78 Days) without pay</p>
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Paternity Leave </strong>  - 7 Working days</p>
								 <p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Solo Parent Leave</strong>  - 7 Working days</p>
							  </div>
							</div>
						</div>
					</div> 
					<br>
					<label class="FormLabel">Date Created:</label>
					<input type="date/time" style="width:220px; height:5%;" class="FormText" id="update_date_created" name="update_date_created" readonly>	
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
					<input class="FormLabel" type="radio" id="lbl_radio_update_otherAdd" name="lbl_radio_update_otherAdd" value="1">
					<label style="width:220px;">Others (Leave Address)</label>
					<br>
					<label class="FormLabel"></label>
					<textarea rows="2" style="width:220px;" id="update_address" name="update_address" value="<?php echo $address; ?>" disabled required></textarea>
					<br>
					<label class="FormLabel" for="update_cmb_approver1">Immediate Superior:</label>
						<?php 
						// echo "<select id='update_cmb_approver1' name='update_cmb_approver1' style='width:220px; height:5%;' class='FormText' required>"; 
							// $result = ELFS::getInstance()->getImmediateSupr();
							// while($row = mysqli_fetch_array($result)){
								// echo "<option value='".$row['username']."'>".$row['firstname']." ".$row['lastname']."</option>";
						
							// }
						// echo "</select>";			
						echo "<select id='update_cmb_approver1' name='update_cmb_approver1' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Immediate Superior...' required>"; 
							$result = ELFS::getInstance()->getSectionHead($username);
							while($row = mysqli_fetch_array($result)){
								$get_emp_info = ELFS::getInstance()->getSectionHeadName($row['username_superior']);
								if($row_emp_info = mysqli_fetch_array($get_emp_info)) {
									echo "<option value='0'>---Not Applicable---</option>";
									echo "<option value='".$row['username_superior']."'>".$row_emp_info['FirstName']." ".$row_emp_info['LastName']."</option>";
								}
							}
						echo "</select>";						
						?>
						<br>
						<label class="FormLabel" for="update_cmb_approver2">Department Head:</label>
						<?php 
						// echo "<select id='update_cmb_approver2' name='update_cmb_approver2' style='width:220px; height:5%;' class='FormText' required>"; 
							// $result = ELFS::getInstance()->getDeptHeads();
							// while($row = mysqli_fetch_array($result)){
								// echo "<option value='".$row['username']."'>".$row['firstname']." ".$row['lastname']."</option>";
							// }
						// echo "</select>";		

						echo "<select id='update_cmb_approver2' name='update_cmb_approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Department Head...' required>"; 
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
							<label id="lbl_sl">Sick Leave</label>
							<br>
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_vl" name="update_leave_applied" value="1">
							<label id="lbl_vl">Vacation Leave</label>
							<br>
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_bdl" name="update_leave_applied" value="2">
							<label id="lbl_bdl">Birthday Leave</label>
						</div>
						<div class="col-sm-6">
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_bl" name="update_leave_applied" value="5">
							<label id="lbl_bdl">Bereavement Leave</label>
							<br>
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_sp" name="update_leave_applied" value="6">
							<label id="lbl_bdl">Solo Parent Leave</label>
							<br>
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_ml" name="update_leave_applied" value="3">
							<label id="lbl_bdl">Maternity Leave</label>
							<br>
							<input class="FormLeaveApplied" type="radio" id="update_rbtn_pl" name="update_leave_applied" value="4">
							<label id="lbl_bdl">Paternity Leave</label>
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
						<label class="FormLabel">Reason/s:</label>
						<input type="hidden" style="width:220px; height:5%;" class="FormText">
						<br>
						<label class="FormLabel"></label>
						<textarea rows="3" style="width:220px;" class="FormText" id="update_reason" name="update_reason" required></textarea>
						<br>
				</div>
			</div><!-- end row -->
			<div class="modal-footer">
				<button type="button" id="btn_send_update_leave" class="btn btn-success" style="border-radius: 0px;font-family: Euphemia;width: 100px; height: 35px;">SAVE&SEND </button>
				<button type="button" id="btn_cancel_update_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 35px;" data-dismiss="modal">CANCEL</button> 
			</div>
			</form>	
		</div>
		</div>
	</div>
</div>

<!-- Modal Verify Leave Dates -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_verify_leave_dates">
  <div class="modal-dialog" style="width:85%">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verify Leave Dates with halfday</h4>
      </div>
      <div class="modal-body">
		<form id="" method="get">
		
		<table id="verify_leave_dates_tbl" name="verify_leave_dates_tbl" class="table table-bordered" width="100%" >
		 <thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle;" class="hide">username</th>
				<th style="text-align: center; vertical-align: middle;" data-toggle="tooltip" data-placement="bottom" data-original-title=""></th>
				<th style="text-align: center; vertical-align: middle;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date of absent (FROM)" data-original-title="">Date of absent (FROM)</th>
				<th style="text-align: center; vertical-align: middle;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date of absent (TO)" data-original-title="">Date of absent (TO)</th>
				<th style="text-align: center; vertical-align: middle;" data-toggle="tooltip" data-placement="bottom" title="Sort by Reason/s" data-original-title="">Reason/s</th>
			</tr>
		  </thead>
		  <tbody id="verify_leave">
		</tbody>
		</table>  
	  </form>  
      </div>
      <div class="modal-footer">
		<button type="submit" id="btn_send_verify_leave" class="btn btn-primary" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;">SAVE</button>
		<button type="button" id="btn_cancel_verify_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;" data-dismiss="modal">CANCEL</button>
	  </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- Modal View Leave -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_view_emp_leave">
  <div class="modal-dialog" style="width:85%">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">EMPLOYEE LEAVE</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="txt_pkid_view_leave" name="txt_pkid_view_leave" value="<?php echo $pkid; ?>"> <br>
			<div id="ViewLeave_summary" style="padding: 13px;" ></div> 
      </div>
      <div class="modal-footer">
		<button type="submit" id="btn_save_view_leave" class="btn btn-primary" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;">SAVE</button>
		<button type="button" id="btn_cancel_view_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 40px;" data-dismiss="modal">CANCEL</button>
	  </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- Modal Show remarks -->
<div class="modal fade" tabindex="-1" id="show_remarks_modal" role="dialog">
<div class="modal-dialog" style="width:30%">
  <div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Leave Status Remarks</h4>
	</div>
	<div class="modal-body" id="cont">

		  <label style="width:280px;">Disapproved by Immediate Superior:</label>
		  <textarea rows="3" id="IS_disapproved_remarks_show" style="width:420px;" placeholder="N/A" readonly></textarea>
		  <br>
		  <br>
		  <label style="width:350px;">Disapproved by Dept. Head:</label>
		  <textarea rows="3" id="DH_disapproved_remarks_show"  style="width:420px;" placeholder="N/A" readonly></textarea>
		  <br>
		  <br>
		  <label style="width:350px;">Revise Leave by HRD:</label>
		  <textarea rows="3" id="HR_revise_remarks_show" style="width:420px;" placeholder="N/A" readonly></textarea>
	
	</div>
	<div class="modal-footer">
		<button type="button" id="btn_close_leave_remarks" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia;width:420px; height: 40px;" data-dismiss="modal">CLOSE</button>
	</div>

  </div>
</div>
</div> 
	
<!-- Modal manage leave batch-->
<div class="modal fade" id="Leave_batch_modal" role="dialog">
	<div class="modal-dialog" style="width:80%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4 style="font-family:Euphemia">EMPLOYEE LEAVE BATCH</h4>
			</div>
		<div class="modal-body" id="cont">	
			<form action="#" id="form_addNewLeaveBatch" data-confirm="Are you sure you want to file this leave batch?"> 

			<div class="row">
				<div class="col-sm-6">	
					<input type="hidden" id="txt_username" name="txt_username" value="<?php echo $username; ?>"> 
					<input type="hidden" id="fkEmployee" name="fkEmployee" value="<?php echo $fkEmployee; ?>"> 
					<input type="hidden" id="txt_EmpNo" name="txt_EmpNo" value="<?php echo $EmpNo; ?>"> 
					<br>
					<label class="FormBatchLabel">Date Created:</label>
					<input type="date" style="width:220px; height:5%;" class="FormBatchText" id="bth_date_created" name="bth_date_created" value="<?php echo date("Y-m-d") ; ?>" readonly>	
					<br>
					<label class="FormBatchLabel">Employee Name:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="bth_empName" name="bth_empName" value="<?php echo $empName; ?>" readonly>
					<br>
					<label class="FormBatchLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="bth_EmpNo" name="bth_EmpNo" value="<?php echo $EmpNo; ?>" readonly>
					<br>
					<label class="FormBatchLabel">Division:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="bth_Division" name="bth_Division" value="<?php echo $Division; ?>" readonly>	
					<br>
					<label class="FormBatchLabel" for="approver2">Dept. Head:</label>
						<?php 
						// echo "<select id='bth_approver2' name='bth_approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Department Head...' required>"; 
							// $result = ELFS::getInstance()->getDeptHeads();
							// while($row = mysqli_fetch_array($result)){
								// echo "<option value='".$row['username']."'>".$row['firstname']." ".$row['lastname']."</option>";
							// }
						// echo "</select>";	

						echo "<select id='bth_approver2' name='bth_approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Department Head...' required>"; 
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
					<input type="radio" id="rbtn_wd" name="day_type" value="0"><b>&nbsp;&nbsp;WHOLE DAY</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="rbtn_hd" name="day_type" value="1"><b>&nbsp;&nbsp;HALF DAY</b>
					<br>
					<br>
					
					<label class="FormBatchLabel">Date Absent:</label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText">
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="bth_date_absent_from" name="bth_date_absent_from" autocomplete="off" readonly="true" required>
					<br>
					<label class="FormBatchLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
					<input type="text" style="width:220px; height:5%;" class="FormBatchText" id="bth_date_absent_to" name="bth_date_absent_to" autocomplete="off" readonly="true" required> 
					<br>
					<label class="FormBatchLabel">No. of days:</label>
					<input type="text" style="width:50px; height:5%;" class="FormBatchText" id="bth_no_of_days" name="bth_no_of_days" readonly>
					<!--
						<button type="button" id="btn_verify_leaves" class="btn btn-info pull-right" style="border-radius: 0px;font-family: Euphemia;width: 150px;">Verify Leave Dates</button>
					-->
					<br>
					<label class="FormBatchLabel">Reason/s:</label>
					<select id="bth_reason" name="bth_reason" style="width:220px; height:5%;" class="FormBatchText" required>	
						<option value="">--Select--</option>
						<option value="Special Holiday">Special Holiday</option>
						<option value="Shut-Down">Shut-Down</option>
					</select> 
					<br>
					<label class="FormBatchLabel"></label>
					<input type="hidden" style="width:220px; height:5%;" class="FormBatchText" id="bth_leave_applied" name="bth_leave_applied" value="0" Placeholder="Vacation Leave" readonly>	
					<br>
					<br>
					<br>
					<br>
			</div> 
				<div id="leave_batch_List" style="padding: 12px;" ></div> 
				
			</div><!-- end row -->
			<div class="modal-footer">
			<!--
				<button type="submit" id="btn_save_batch_leave" class="btn btn-primary" style="border-radius: 0px;font-family: Euphemia;width: 130px; height: 35px;">SAVE AS DRAFT</button>
			-->
				<button type="submit" id="btn_send_batch_leave" class="btn btn-success" style="border-radius: 0px;font-family: Euphemia;width: 100px; height: 35px;">SAVE&SEND </button>
				<button type="button" id="btn_cancel_batch_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia; width: 80px; height: 35px;" data-dismiss="modal">CANCEL</button> &nbsp;
			</div>
			</form>	
		</div>
		</div>
	</div>
</div>

</body>

<script type="text/javascript">
var selected_pkid = "";
	$(document).ready(function() {
		$('#verify_leave_dates_tbl').DataTable( {
        fixedColumns:   true,
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    } );
	});

	$(document).ready(function(){
		$("#leave_tbl").dataTable({
		"order": [],
		"columnDefs": [ {
		"targets"  : 'no-sort',
		"orderable": false,
		}]});
	});
	
	$(document).ready(function(){
		$("#leave_history_tbl").dataTable({"order": [],
		"columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false,
		}]});
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
	
	$("#leave_tbl tbody").on('dblclick', 'tr', function(){
		$("#modal-body input").val("");	
		select_view_emp_leave($(this).find("td:eq(0)").text());
	});	
	
	function select_view_emp_leave(pkid) {
	var data1 = {
		"action"			 : "select_view_emp_leave",
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
		
			if(result['status'] == 0 || result['status'] == 1 || result['status'] == 2 || result['status'] == 3 || result['status'] == 5 || result['status'] == 6) {
				// $('#btn_save_view_leave').prop('disabled', true);
				$('#modal_view_emp_leave').modal('disabled', true);
			}	
			
			if(result['leave_applied'] == 3) {
				$('#modal_view_emp_leave').modal('disabled', true);
			}
		
			$('#txt_pkid_view_leave').val(pkid);
			$("#modal_view_emp_leave").modal();
			get_view_leave_summary(pkid);
			
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}

	function get_view_leave_summary(){
	var pkid = $("#txt_pkid_view_leave").val();

	var data = {
		"action"	: "get_view_leave_summary",
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
			
			$('#ViewLeave_summary').empty();	
			var html  = '<table id="tbl_leave_records" class="table table-bordered">';
				html += '	<thead>';
				html += '		<tr>';
				html += '			<th><center><font size="2"></font></center></th>';
				html += '			<th><center><font size="2">LEAVE APPLIED</font></center></th>';
				html += '			<th><center><font size="2">REASON</font></center></th>';
				html += '			<th><center><font size="2">DATE ABSENT</font></center></th>';
				html += '			<th><center><font size="2">NO. OF DAYS</font></center></th>';
				// html += '			<th><center><font size="2">PAID LEVE</font></center></th>';
				html += '		</tr>';
				html += '	</thead>';
				html += '	<tbody>';
				html += '	</tbody>';
				html += '</table>';
				
			$('#ViewLeave_summary').append(html);	
			
			for(i=0;i<ctr;i++){
				var html  = '<tr id="'+data['pkid'][i]+'">';
					html +=	'	<td style="text-align:center; vertical-align:middle;"><input type="checkbox" name="checkbox[]" value="" id="checkbox"></td>';
					html += '	<td style="text-align: center;font-size: 14px;">'+data['leave_applied'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['reason'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['date_absent_from'][i]+ ' - ' +data['date_absent_to'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_days'][i]+'</td>';	
					// html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_paid'][i]+'</td>';	
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

	function table_events(){
	$('#tbl_leave_records tbody tr').click(function(){
		selected_pkid = "";
		$('#tbl_leave_records tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
		selected_pkid = this.id;
	});
}

	$("tbody tr").click(function() {
		console.log('clicked');
		$(this).addClass('selected').siblings().removeClass("selected");
	});

	$('#btn_new_leave').click(function(){
		$('#Leave_application_modal').modal('show'); 
	});	
	
	$('#btn_verify_leaves').click(function(){
		$('#modal_verify_leave_dates').modal('show'); 
	});	

	$('#btn_cancel_view_leave').click(function(){
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
	
	$('#approver1').click(function(){
	$('#approver1').val();
	});
	
	$('#lbl_radio_otherAdd').click(function(){
		$('#emp_address').prop('disabled', true);
		$('#emp_address').val('N/A');
		$('#address').prop('disabled', false);
	});
	
	$('#lbl_radio_update_otherAdd').click(function(){
		$('#update_emp_address').prop('disabled', true);
		$('#update_emp_address').val('');
		$('#update_address').prop('disabled', false);
	});
	
	/* New leave datepicker */
	$("input[name='leave_applied']").click(function() {
		leave_applied = this.value;
		var dateFrom = $('#date_absent_from');
		var dateTo = $('#date_absent_to');
		
	if ($("input[name='leave_applied']:checked").val() == 0 ){ //SICK LEAVE
		$("input[id='date_absent_from']").prop("disabled", false);
		$("input[id='date_absent_to']").prop("disabled", false);
		$('#date_absent_from').val('');
		$('#date_absent_to').val('');
		$('#no_of_days').val('');
		$('#reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({ 
		minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
	});
	 
	dateTo.datepicker('destroy');
	dateTo.datepicker( { 
		minDate: '-2M, -1W', 
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
		
	} else if ($("input[name='leave_applied']:checked").val() == 1 ){ //VACATION LEAVE
		$("input[id='date_absent_from']").prop("disabled", false);
		$("input[id='date_absent_to']").prop("disabled", false);
		$('#date_absent_from').val('');
		$('#date_absent_to').val('');
		$('#no_of_days').val('');
		$('#reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({ 
		minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
	});
	 
	dateTo.datepicker('destroy');
	dateTo.datepicker( { 
		minDate: '-2M, -1W', 
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
		
	} else if ($("input[name='leave_applied']:checked").val() == 2 ){ // BIRTHDAY LEAVE
		$("input[id='date_absent_from']").prop("disabled", false);
		$("input[id='date_absent_to']").prop("disabled", false);
		$('#date_absent_from').val('');
		$('#date_absent_to').val('');
		$('#no_of_days').val('');
		$('#reason').val('Birthday.');
			
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

	} else if ($("input[name='leave_applied']:checked").val() == 3 ){ //MATERNITY LEAVE
		$("input[id='date_absent_from']").prop("disabled", false);
		$("input[id='date_absent_to']").prop("disabled", false);
		$('#date_absent_from').val('');
		$('#date_absent_to').val('');
		$('#no_of_days').val('');
		$('#reason').val('Maternity Leave.');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({
		minDate: '-2M, -1W', 
		onSelect: function(dateText, inst) {
			var nyd = new Date(dateText);
			nyd.setDate(nyd.getDate() + 77);
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
		
	} else if ($("input[name='leave_applied']:checked").val() == 4 ){ //PATERNITY LEAVE
		$("input[id='date_absent_from']").prop("disabled", false);
		$("input[id='date_absent_to']").prop("disabled", false);
		$('#date_absent_from').val('');
		$('#date_absent_to').val('');
		$('#no_of_days').val('');
		$('#reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({
		minDate: '-2M, -1W',
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
		
	} else if ($("input[name='leave_applied']:checked").val() == 5 ){ //BEREAVEMENT LEAVE
		$("input[id='date_absent_from']").prop("disabled", false);
		$("input[id='date_absent_to']").prop("disabled", false);
		$('#date_absent_from').val('');
		$('#date_absent_to').val('');
		$('#no_of_days').val('');
		$('#reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({
		minDate: '-2M, -1W',
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
		
		onSelect: function(dateText, inst) {
			var nyd = new Date(dateText);
			nyd.setDate(nyd.getDate() + 3);
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
	// else if ($("input[name='leave_applied']:checked").val() == 5 ){ //BEREAVEMENT LEAVE
		// $("input[id='date_absent_from']").prop("disabled", false);
		// $("input[id='date_absent_to']").prop("disabled", false);
		// $('#date_absent_from').val('');
		// $('#date_absent_to').val('');
		// $('#no_of_days').val('');
		// $('#reason').val('');

	// dateFrom.datepicker('destroy');
	// dateFrom.datepicker({ 
		// minDate: '-2M, -1W', 
		// beforeShowDay: function(date) {
		// var day = date.getDay();
		// return [(day != 0), ''];
		// },
	// });
	 
	// dateTo.datepicker('destroy');
	// dateTo.datepicker( { 
		// minDate: '-2M, -1W', 
		// beforeShowDay: function(date) {
		// var day = date.getDay();
		// return [(day != 0), ''];
		// },
		
	// onSelect: function (dateStr){
		// var start = $("#date_absent_from").datepicker("getDate");
		// var end = $("#date_absent_to").datepicker("getDate");
		// var diff = calcBusinessDays(start,end);
		// $("#no_of_days").val(diff);
		// }
	// });
		
	// } else if ($("input[name='leave_applied']:checked").val() == 6 ){ //SOLO PARENT LEAVE
		// $("input[id='date_absent_from']").prop("disabled", false);
		// $("input[id='date_absent_to']").prop("disabled", false);
		// $('#date_absent_from').val('');
		// $('#date_absent_to').val('');
		// $('#no_of_days').val('');
		// $('#reason').val('');

	// dateFrom.datepicker('destroy');
	// dateFrom.datepicker({ 
		// minDate: '-2M, -1W', 
		// beforeShowDay: function(date) {
		// var day = date.getDay();
		// return [(day != 0), ''];
		// },
	// });
	 
	// dateTo.datepicker('destroy');
	// dateTo.datepicker( { 
		// minDate: '-2M, -1W', 
		// beforeShowDay: function(date) {
		// var day = date.getDay();
		// return [(day != 0), ''];
		// },
		
	// onSelect: function (dateStr){
		// var start = $("#date_absent_from").datepicker("getDate");
		// var end = $("#date_absent_to").datepicker("getDate");
		// var diff = calcBusinessDays(start,end);
		// $("#no_of_days").val(diff);
		// }
	// });
		
	// } 
	else if ($("input[name='leave_applied']:checked").val() == 6 ){ //SOLO PARENT LEAVE
		$("input[id='date_absent_from']").prop("disabled", false);
		$("input[id='date_absent_to']").prop("disabled", false);
		$('#date_absent_from').val('');
		$('#date_absent_to').val('');
		$('#no_of_days').val('');
		$('#reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({
		minDate: '-2M, -1W',
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

	/* Update leave datepicker */
	$("input[name='update_leave_applied']").click(function() {
		leave_applied = this.value;
		var dateFrom = $('#update_date_absent_from');
		var dateTo = $('#update_date_absent_to');
		
	if ($("input[name='update_leave_applied']:checked").val() == 0 ){ //SICK LEAVE
		$("input[id='update_date_absent_from']").prop("disabled", false);
		$("input[id='update_date_absent_to']").prop("disabled", false);
		$('#update_date_absent_from').val('');
		$('#update_date_absent_to').val('');
		$('#update_no_of_days').val('');
		$('#update_reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({ 
		minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
	});
	 
	dateTo.datepicker('destroy');
	dateTo.datepicker( { 
		minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
		
	onSelect: function (dateStr){
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		$("#update_no_of_days").val(diff);
		}
	});
		
	} else if ($("input[name='update_leave_applied']:checked").val() == 1 ){ //VACATION LEAVE
		$("input[id='update_date_absent_from']").prop("disabled", false);
		$("input[id='update_date_absent_to']").prop("disabled", false);
		$('#update_date_absent_from').val('');
		$('#update_date_absent_to').val('');
		$('#update_no_of_days').val('');
		$('#update_reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({ 
		minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
	});
	 
	dateTo.datepicker('destroy');
	dateTo.datepicker( { 
		minDate: '-2M, -1W', 
		beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
		},
		
	onSelect: function (dateStr){
		var start = $("#update_date_absent_from").datepicker("getDate");
		var end = $("#update_date_absent_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		$("#update_no_of_days").val(diff);
		}
	});
		
	} else if ($("input[name='update_leave_applied']:checked").val() == 2 ){ // BIRTHDAY LEAVE
		$("input[id='update_date_absent_from']").prop("disabled", false);
		$("input[id='update_date_absent_to']").prop("disabled", false);
		$('#update_date_absent_from').val('');
		$('#update_date_absent_to').val('');
		$('#update_no_of_days').val('');
		$('#update_reason').val('Birthday Leave.');
			
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

	} else if ($("input[name='update_leave_applied']:checked").val() == 3 ){ //MATERNITY LEAVE
		$("input[id='update_date_absent_from']").prop("disabled", false);
		$("input[id='update_date_absent_to']").prop("disabled", false);
		$('#update_date_absent_from').val('');
		$('#update_date_absent_to').val('');
		$('#update_no_of_days').val('');
		$('#update_reason').val('Maternity Leave.');

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
		
	} else if ($("input[name='update_leave_applied']:checked").val() == 4 ){ //PATERNITY LEAVE
		$("input[id='update_date_absent_from']").prop("disabled", false);
		$("input[id='update_date_absent_to']").prop("disabled", false);
		$('#update_date_absent_from').val('');
		$('#update_date_absent_to').val('');
		$('#update_no_of_days').val('');
		$('#update_reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({
		minDate: '-2M, -1W',
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
		
	} else if ($("input[name='update_leave_applied']:checked").val() == 5 ){ //BEREAVEMENT LEAVE
		$("input[id='update_date_absent_from']").prop("disabled", false);
		$("input[id='update_date_absent_to']").prop("disabled", false);
		$('#update_date_absent_from').val('');
		$('#update_date_absent_to').val('');
		$('#update_no_of_days').val('');
		$('#update_reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({
		minDate: '-2M, -1W',
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
		
	}	else if ($("input[name='update_leave_applied']:checked").val() == 6 ){ //SOLO PARENT LEAVE
		$("input[id='update_date_absent_from']").prop("disabled", false);
		$("input[id='update_date_absent_to']").prop("disabled", false);
		$('#update_date_absent_from').val('');
		$('#update_date_absent_to').val('');
		$('#update_no_of_days').val('');
		$('#update_reason').val('');

	dateFrom.datepicker('destroy');
	dateFrom.datepicker({
		minDate: '-2M, -1W',
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
	// else if ($("input[name='update_leave_applied']:checked").val() == 5 ){ //BEREAVEMENT LEAVE
		// $("input[id='update_date_absent_from']").prop("disabled", false);
		// $("input[id='update_date_absent_to']").prop("disabled", false);
		// $('#update_date_absent_from').val('');
		// $('#update_date_absent_to').val('');
		// $('#update_no_of_days').val('');
		// $('#update_reason').val('');

	// dateFrom.datepicker('destroy');
	// dateFrom.datepicker({ 
		// minDate: '-2M, -1W', 
		// beforeShowDay: function(date) {
		// var day = date.getDay();
		// return [(day != 0), ''];
		// },
	// });
	 
	// dateTo.datepicker('destroy');
	// dateTo.datepicker( { 
		// minDate: '-2M, -1W', 
		// beforeShowDay: function(date) {
		// var day = date.getDay();
		// return [(day != 0), ''];
		// },
		
	// onSelect: function (dateStr){
		// var start = $("#update_date_absent_from").datepicker("getDate");
		// var end = $("#update_date_absent_to").datepicker("getDate");
		// var diff = calcBusinessDays(start,end);
		// $("#update_no_of_days").val(diff);
		// }
	// });
		
	// }
	// else if ($("input[name='update_leave_applied']:checked").val() == 6 ){ //SOLO PARENT LEAVE
		// $("input[id='update_date_absent_from']").prop("disabled", false);
		// $("input[id='update_date_absent_to']").prop("disabled", false);
		// $('#update_date_absent_from').val('');
		// $('#update_date_absent_to').val('');
		// $('#update_no_of_days').val('');
		// $('#update_reason').val('');

	// dateFrom.datepicker('destroy');
	// dateFrom.datepicker({ 
		// minDate: '-2M, -1W', 
		// beforeShowDay: function(date) {
		// var day = date.getDay();
		// return [(day != 0), ''];
		// },
	// });
	 
	// dateTo.datepicker('destroy');
	// dateTo.datepicker( { 
		// minDate: '-2M, -1W', 
		// beforeShowDay: function(date) {
		// var day = date.getDay();
		// return [(day != 0), ''];
		// },
		
	// onSelect: function (dateStr){
		// var start = $("#update_date_absent_from").datepicker("getDate");
		// var end = $("#update_date_absent_to").datepicker("getDate");
		// var diff = calcBusinessDays(start,end);
		// $("#update_no_of_days").val(diff);
		// }
	// });
		
	// }
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
		
	}); //End Update function

	// Select Leave Application
	function select_leave_info_by_pkid(pkid) {
		var data1 = {
			"action"			 : "select_leave_info_by_pkid",
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
				if(result['status'] == 0 || result['status'] == 1 || result['status'] == 2 || result['status'] == 3 || result['status'] == 5 || result['status'] == 6) {
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
					$('#update_date_absent_from').prop('disabled', true);
					$('#update_date_absent_to').prop('disabled', true);
					$('#update_reason').prop('disabled', true);
					$('#btn_send_update_leave').prop('disabled', true);
				}
		
				$('#update_date_created').val(result['date_created']);
				$('#update_empName').val(result['Emp_Name']);
				$('#update_EmpNo').val(result['EmpNo']);
				$('#update_division').val(result['Division']);
					
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
					} 
					
				$('#update_date_absent_from').val(result['date_from']);
				$('#update_date_absent_to').val(result['date_to']);
				$('#update_no_of_days').val(result['total_absent_days']);
				$('#update_reason').val(result['reason']);
				$('#update_emp_address').val(result['emp_address']);
					
				$('#lbl_radio_update_otherAdd').click(function(){
					$('#update_emp_address').prop('disabled', true);
					$('#update_emp_address').val('N/A');
					$('#update_address').prop('disabled', false);
				});
				
				if(result['lbl_radio_otherAdd'] == 1) {
					$('#lbl_radio_update_otherAdd').prop('checked', true);
				} else {
					$('#lbl_radio_update_otherAdd').prop('checked', false);
				}
					
				$('#update_address').val(result['address']);
				$('#update_cmb_approver1').val(result['approver1']);
				$('#update_cmb_approver2').val(result['approver2']);
				
				$('#update_txt_status').val(result['status']);	
				$('#update_txt_pkid').val(pkid);	
				$("#Leave_application_modal_update").modal();
			}, error	: function (result) {
			alert('ERROR: '+result);
			}
		});
	}	

	//Update Leave Data
	$('#form_UpdateLeave').submit(function(e){

	 if(confirm($(this).data('confirm'))){
		e.preventDefault();
	 } else {
		return false;
	}

		var data = {
			"action"			 : 'test',
			"pkid"				 : $('#update_txt_pkid').val()			
		}
		data = $.param(data) + '&' + $(this).serialize();
		alert(data);
		$.ajax({
			type	: 'POST',
			dataType: 'json',
			data	: data,
			url		: 'update_leave_record.php',
			success	: function(data){	
			
					var data2 = {
						"pkid"					: data['fk_leave_app'],
						"date_absent_from"		: $('#update_date_absent_from').val(),
						"date_absent_to"		: $('#update_date_absent_to').val(),
						"no_of_days"			: $('#update_no_of_days').val()
					}	
					
					data2 = $.param(data2);
					alert(data2);
					$.ajax({
						type	: "post",
						dataType: "json",
						data	: data2,
						url		: "update_leave_dates.php",
						success	: function(){			
						},error	: function(){
							alert("ERROR data2");
						}
					});
			
				var data3 = {
					"action"			: "send_email_revise_for_approval",
					"pkid"				: data['fk_leave_app']
				}
				
				data3 = $.param(data3);
				alert(data3);
				$.ajax({
					type		: "POST",
					dataType	: "json",
					data		: data3,
					url			: "elfs_handler.php",
					success		: function (result) {

					}, error	: function (result) {
						alert('ERROR: data3');
					}
				});
				
				alert("Leave Application has been Updated!");
				window.location.href = "emp_leave_summary.php";
			},error(data){
				alert('ERROR MAIN');
			}
		});
	});
	
	// Show Leave Remarks
	function show_remarks(pkid) {
		var data = {
			"action"			: "show_remarks",
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
				$('#DH_disapproved_remarks_show').val(result['DH_disapproved_remarks']);
				$('#HR_revise_remarks_show').val(result['HR_revised_remarks']);
				$('#show_remarks_modal').modal('show');
				
			}, error	: function (result) {
				alert('ERROR: '+result);
			}
		});
	}

	//Save leave as draft
	$('#btn_save_leave').click(function(e){
		if($('#approver1').val() == '') {
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Immediate Superior. ***<br>');
        } else if($('#approver2').val() == '') { 
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Department Head. ***<br>');
		} else if($('#date_absent_from').val() == '') { 
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Date absent from. ***<br>');
		} else if($('#date_absent_to').val() == '') { 
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Date absent to. ***<br>');
		} else if($('#reason').val() == '') { 
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Reason. ***<br>');
		} else {
			$('#div_msg_new').hide();
			
		if(confirm($(this).data('confirm'))){
			e.preventDefault();
		} else {
			return false;
		}	
		
		var data = {
			"action"			 : 'Save_leave_as_draft',
			"fkEmployee"		 : $('#fkEmployee').val(),
			"status"			 : '7',
			"date_created"		 : $('#date_created').val(),
			"empName"			 : $('#txt_username').val(),
			"EmpNo"				 : $('#EmpNo').val(),
			"Division"		 	 : $('#Division').val(),
			"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
			"emp_address"		 : $('#emp_address').val(),
			"reason"			 : $('#reason').val(),
			"radio_OthersAdd"	 : $('#radio_OthersAdd').val(),
			"address"			 : $('#address').val(),
			"approver1"			 : $('#approver1').val(),
			"approver2"			 : $('#approver2').val()
		}
	data = $.param(data);
	alert(data);
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		data	: data,
		url		: 'elfs_handler.php',
		success	: function(data){	
		
			var data1 = {
			"action"			 : 'Select_leave_as_draft',
			"fkEmployee"		 : $('#fkEmployee').val(),
			"status"			 : '7',
			"date_created"		 : $('#date_created').val(),
			"empName"			 : $('#txt_username').val(),
			"EmpNo"				 : $('#EmpNo').val(),
			"Division"		 	 : $('#Division').val(),
			"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
			"emp_address"		 : $('#emp_address').val(),
			"reason"			 : $('#reason').val(),
			"radio_OthersAdd"	 : $('#radio_OthersAdd').val(),
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
				
				var pkid = result['pkid'];
				var leave_applied = result['leave_applied'];
				
				var data2 = {
					"pkid"					: result['pkid'],
					"leave_applied"			: result['leave_applied'],
					"leave_applied"			: $('input[name="leave_applied"]:checked').val(),
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
						alert("ERROR data2");
					}
				});
						
				}, error: function (result) {
				}
			});
			
			alert("Leave Application Save as draft!");
			window.location.href = "emp_leave_summary.php";
			
		},error(data){
			alert('ERROR MAIN');
		}
	});
	}
	});	

	//Save and Send Leave
	$('#btn_send_leave').click(function(e){
		if($('#approver1').val() == '') {
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Immediate Superior. ***<br>');
        } else if($('#approver2').val() == '') { 
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Department Head. ***<br>');
		} else if($('#date_absent_from').val() == '') { 
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Date absent from. ***<br>');
		} else if($('#date_absent_to').val() == '') { 
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Date absent to. ***<br>');
		} else if($('#reason').val() == '') { 
			$('#div_msg_new').show();
            $('#div_msg_new').append('*** Please select your Reason. ***<br>');
		} else {
			$('#div_msg_new').hide();
			
		if(confirm($(this).data('confirm'))){
			e.preventDefault();
		} else {
			return false;
		}	
			
		var data = {
			"action"			 : 'save_leave_record',
			"fkEmployee"		 : $('#fkEmployee').val(),
			"status"			 : '7',
			"date_created"		 : $('#date_created').val(),
			"empName"			 : $('#txt_username').val(),
			"EmpNo"				 : $('#EmpNo').val(),
			"Division"		 	 : $('#Division').val(),
			"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
			"emp_address"		 : $('#emp_address').val(),
			"reason"			 : $('#reason').val(),
			"radio_OthersAdd"	 : $('#radio_OthersAdd').val(),
			"address"			 : $('#address').val(),
			"approver1"			 : $('#approver1').val(),
			"approver2"			 : $('#approver2').val()
		}
		
	data = $.param(data);
	alert(data);
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		data	: data,
		url		: 'elfs_handler.php',
		success	: function(data){	
		
			var data1 = {
			"action"			 : 'Select_leave_record',
			"fkEmployee"		 : $('#fkEmployee').val(),
			"status"			 : '0',
			"date_created"		 : $('#date_created').val(),
			"empName"			 : $('#txt_username').val(),
			"EmpNo"				 : $('#EmpNo').val(),
			"Division"		 	 : $('#Division').val(),
			"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
			"emp_address"		 : $('#emp_address').val(),
			"reason"			 : $('#reason').val(),
			"radio_OthersAdd"	 : $('#radio_OthersAdd').val(),
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
				var leave_applied	= result['leave_applied'];
				var approver1 		= result['approver1'];
				
				var data2 = {
					"pkid"					: result['pkid'],
					"leave_applied"			: result['leave_applied'],
					"leave_applied"			: $('input[name="leave_applied"]:checked').val(),
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
					url		: "save_leave_dates.php",
					success	: function(result){			
					},error	: function(result){
						alert("ERROR data2");
					}
				});
				
				if(result['approver1'] == 0) {
					var data3 = {
						"action"			: "send_email_for_approval_to_DH",
						"pkid"				: result['pkid']
					}
				
				data3 = $.param(data3);
				alert(data3);
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
					alert(data4);
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
			
			alert("Leave Application has been added!");
			window.location.href = "emp_leave_summary.php";
			
		},error(data){
			alert('ERROR MAIN');
		}
	});
	}
	});	

/////////////////////////// LEAVE BATCH ///////////////////////////////
/* New leave datepicker */
/* Submit Function */ 	
	$('#form_addNewLeaveBatch').submit(function(e){

	 if(confirm($(this).data('confirm'))){
		e.preventDefault();
	 } else {
		return false;
	}

		var data = {
			"action"			 : 'test',
			"fkEmployee"		 : $('#fkEmployee').val()
		}
		data = $.param(data) + '&' + $(this).serialize();
		alert(data);
		$.ajax({
			type	: 'POST',
			dataType: 'json',
			data	: data,
			url		: 'save_leave_batch.php',
			success	: function(data){	
			
					// var data2 = {
						// "pkid"					: data['fk_leave_applied'],
						// "date_absent_from"		: $('#date_absent_from').val(),
						// "date_absent_to"		: $('#date_absent_to').val(),
						// "no_of_days"			: $('#no_of_days').val()
					// }	
					
					// data2 = $.param(data2);
					// alert(data2);
					// $.ajax({
						// type	: "post",
						// dataType: "json",
						// data	: data2,
						// url		: "save_leave_batch_dates.php",
						// success	: function(){			
						// },error	: function(){
							// alert("ERROR data2");
						// }
					// });
			
				// var data3 = {
					// "action"			: "send_email_for_approval",
					// "pkid"				: data['fk_leave_applied']
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
						// alert('ERROR: data3');
					// }
				// });
				
				alert("Leave Batch Application has been added!");
				window.location.href = "emp_leave_summary.php";
			},error(data){
				alert('ERROR MAIN');
			}
		});
	});
	
	$("input[name='day_type']").click(function() {
		day_type = this.value;
		var dateFrom = $('#bth_date_absent_from');
		var dateTo = $('#bth_date_absent_to');
		
	if ($("input[name='day_type']:checked").val() == 0 ){ //WHOLE DAY
		$("input[id='bth_date_absent_from']").prop("disabled", false);
		$("input[id='bth_date_absent_to']").prop("disabled", false);
		$('#bth_date_absent_from').val('');
		$('#bth_date_absent_to').val('');
		$('#bth_no_of_days').val('');

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
		var start = $("#bth_date_absent_from").datepicker("getDate");
		var end = $("#bth_date_absent_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		$("#bth_no_of_days").val(diff);
		}
	});
		
	} else if ($("input[name='day_type']:checked").val() == 1 ){ //HALF DAY
		$("input[id='bth_date_absent_from']").prop("disabled", false);
		$("input[id='bth_date_absent_to']").prop("disabled", false);
		$('#bth_date_absent_from').val('');
		$('#bth_date_absent_to').val('');
		$('#bth_no_of_days').val('');

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
		var start = $("#bth_date_absent_from").datepicker("getDate");
		var end = $("#bth_date_absent_to").datepicker("getDate");
		var diff = calcBusinessDays(start,end);
		
		var half = diff / 2;
		$("#bth_no_of_days").val(half);
		
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

	$('#btn_leave_batch').click(function(){
	$('#Leave_batch_modal').modal('show'); 
	get_leave_batch($("#txt_EmpNo").val());
});	
	
function get_leave_batch(){
	var SectionHead = $("#txt_EmpNo").val();

	var data = {
		"action"			: "get_leave_batch",
		"SectionHead"		: SectionHead
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
			
			$('#leave_batch_List').empty();	
			var html  = '<table id="tbl_leave_batch" class="table table-bordered">';
				html += '	<thead>';
				html += '		<tr>';
				html += '			<th><center><font size="2">EMPNO.</font></center></th>';
				html += '			<th><center><font size="2">EMPLOYEE NAME </font></center></th>';
				html += '			<th><center><font size="2">REMOVE</font></center></th>';
				html += '		</tr>';
				html += '	</thead>';
				html += '	<tbody>';
				html += '	</tbody>';
				html += '</table>';
				
			$('#leave_batch_List').append(html);	
			
			for(i=0;i<ctr;i++){
				var html  = '<tr id="'+data['pkid'][i]+'">';
					html += '	<td style="text-align: center;font-size: 14px;">'+data['Subordinate'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['FullName'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;"><button class="btn btn-danger" id="btn_remove_emp" style="border-radius: 0px;" title="Click to remove employee"><span class="glyphicon glyphicon-trash"></span></button></td>';	
					html += '</tr>';
				 $('#tbl_leave_batch tbody').append(html);	
			}
			
			var oTable = $('#tbl_leave_batch').DataTable({ 
				paginate:true,
				aaSorting: []				
				});
			table_events();
			
		},error	: function(data){
			alert(data);
		}
	});
}

function table_events(){
	$('#tbl_leave_batch tbody tr').click(function(){
		selected_pkid = "";
		$('#tbl_leave_batch tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
		selected_pkid = this.id;
	});
}	
</script>
</html>