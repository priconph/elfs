<?php
    include("includes.php");
	require_once("elfs_oop.php");
	session_start();

	$username = $_SESSION['username'];
	// $username = 'marbonc';

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

<div class="panel panel-primary" style="margin:auto; width:95%;">
	<div class="panel-heading">EMPLOYEE LEAVE SUMMARYs</div>
		<div class="panel-body">
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
	
		<form id="" method="get">
			<table id="leave_tbl" name="leave_tbl" class="display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
						<th style="text-align: center; vertical-align: middle;" class="hide">username</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
						<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" data-original-title="">VIEW</th>
				  </tr>
				</thead>
				<tbody id="leaveEmp">
					<?php
					$result = ELFS::getInstance()->select_amup_leave_summary();
						while($row = mysqli_fetch_array($result)){
						
						// 0-for approval, 1-approved by approver1, 2-approved by approver2, 3-conformed by hrd, 4-revise leave as per hrd, 5-Disapproved by approver1, 6-Disapproved by approver2													
						if($row['status'] == 2) {
							$status_label = '<div class="ui green ribbon label">For Conformance</div>'; 
						}	else if($row['status'] == 3) {
							$status_label = '<div class="ui blue ribbon label">Conformed</div>'; 
						}   else if($row['status'] == 4) {
							$status_label = '<div class="ui yellow ribbon label">For Revision</div>'; 
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
						$leave_applied = '<center>Special Leave Benefit for Women</center>';
						}	
						
						if($row['status'] == 0 || $row['status'] == 1 || $row['status'] == 5) {
								$btn_edit_view = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
						} else 	if($row['status'] == 2 || $row['status'] == 3 || $row['status'] == 6 ) {
								$btn_edit_view = '<button class="btn btn-success" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to view leave application"><span class="glyphicon glyphicon-eye-open"></span></button>';
						} else if ($row['status'] == 4 || $row['status'] == 7) {
								$btn_edit_view = '<button class="btn btn-warning" id="btn_view_leave" style="border-radius: 0px;" value="'.$row['pkid'].'" title="Click to edit leave application"><span class="glyphicon glyphicon-edit"></span></button>';
						} else {
								$btn_edit_view = '<button class="btn btn-default" style="border-radius: 0px;" ><span class="glyphicon glyphicon-eye-close"></span></button>';
						}
											
						$pkid = $row['pkid'];	
						echo "
							<tr title='Double click to view/edit/remove.'>	
								<td style='display:none;'>".$pkid."</td>
								<td style='display:none'>".$row['username']."</td>
								<td style='font-family: Euphemia;'>".$status_label."</td>
								<td style='text-align: center; font-family: Euphemia; font-size: 13px;'>".date('F d, Y',strtotime($row['date_created']))."</td>
								<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['Emp_Name']."</td>
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
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Solo Parent Leave</strong>  - 7 Working days</p>
								  </div>
								</div>
							</div>
						</div> 
						
						<input type="hidden" id="fkEmployee" name="fkEmployee" value="<?php echo $row['pkid']; ?>">	
						<input type="hidden" id="empName" name="empName" value="<?php echo $row['username']; ?>">	
						<br>
						
						<label class="FormLabel">Date Created:</label>
						<input type="date" style="width:220px; height:5%;" class="FormText" id="date_created" name="date_created" value="<?php echo date("Y-m-d") ; ?>" readonly>	
						<br>
						
						<label class="FormLabel">EmpNo.:</label>
						<input class="FormText" style="width:220px; height:5%;" list="id_list_emp_num" name="EmpNo" id="EmpNo" onkeyup="this.value = this.value.toUpperCase();">
						<datalist id="id_list_emp_num"></datalist>
						<br>
						
						<label class="FormLabel">Employee Name:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="Employee_Name" name="Employee_Name" readonly>		
						<br>
						
						<label class="FormLabel">Division:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="Division" name="Division" readonly>	
						<br> 
						
						<label class="FormLabel">Address during leave:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="emp_address" name="emp_address" readonly>	
						<br>
						
						<input class="FormLabel" type="checkbox" id="lbl_radio_otherAdd" name="lbl_radio_otherAdd" value="1">
						<label style="width:220px; font-size: 14px; ">Others <i>(Leave Address)</i></label>
						<br>
						
						<label class="FormLabel"></label>
						<textarea rows="2" style="width:220px;" id="address" name="address" value = "N/A" disabled></textarea>
						<br>

						<label class="FormLabel">Immediate Superior:</label>		
						<input class="FormText" style="width:220px; height:5%;" list="id_list_sechead" name="approver1" id="approver1">
						<datalist id="id_list_sechead"></datalist>
						<input class="FormText" type="text" style="width:220px; height:5%;" id="hidden_sechead" name="name_hidden_sechead" readonly>
						<br> 
						
						<label class="FormLabel">Sec/Department Head:</label>		
						<input class="FormText" style="width:220px; height:5%;" list="id_list_depthead" name="approver2" id="approver2">
						<datalist id="id_list_depthead"></datalist>
						<input class="FormText" type="text" style="width:220px; height:5%;"id="hidden_depthead" name="name_hidden_depthead" readonly>
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
										<label style="font-size: 14px;" id="lbl_sl">Sick Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="rbtn_vl" name="leave_applied" value="1">
										<label style="font-size: 14px;" id="lbl_vl">Vacation Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="rbtn_bdl" name="leave_applied" value="2">
										<label style="font-size: 14px;" id="lbl_bdl">Birthday Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="rbtn_pl" name="leave_applied" value="4">
										<label style="font-size: 14px;" id="lbl_bdl">Paternity Leave</label>
										
									</div>
									<div class="col-sm-6">
										<input class="FormLeaveApplied" type="radio" id="rbtn_bl" name="leave_applied" value="5">
										<label  style="font-size: 14px;" id="lbl_bdl">Bereavement Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="rbtn_sp" name="leave_applied" value="6">
										<label style="font-size: 14px;" id="lbl_bdl">Solo Parent Leave</label>
										<br>
									
										<input class="FormLeaveApplied" type="radio" id="rbtn_ml" name="leave_applied" value="3">
										<label style="font-size: 14px;" id="lbl_bdl">Maternity Leave</label>
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
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="del_date_from" name="del_date_from" autocomplete="off">
						<br>
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
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
						<textarea rows="3" style="width:220px;" class="FormText" id="reason" name="reason" disabled></textarea>
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

<div class="modal fade" id="Leave_application_modal_view" role="dialog">
	<div class="modal-dialog" style="width:85%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4 style="font-family:Euphemia">EMPLOYEE LEAVE APPLICATION</h4>
			</div>
			<div class="modal-body" id="cont">	
				<form action="#" id="form_ViewLeave" data-confirm="Are you sure you want to file this leave?"> 
				 <center><div id="alert_msg2" style="display:none; color:white; font-weight:bold; font-size: 14px; text-align:center; width:100%" class="row alert alert-danger"></div></center>

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
										<p class="text-default" style="font-size: 13px; margin-bottom: 3px;"><strong> Solo Parent Leave</strong>  - 7 Working days</p>
								  </div>
								</div>
							</div>
						</div> 
						<input type="hidden" id="update_txt_pkid" name="update_txt_pkid" value="<?php echo $pkid; ?>"> 
						<input type="hidden" id="update_txt_username" name="update_txt_username" value="<?php echo $username; ?>"> 
						<input type="hidden" id="update_txt_status" name="update_txt_status" value="<?php echo $status; ?>"> 

						<input type="hidden" id="update_fkEmployee" name="update_fkEmployee" value="<?php echo $row['pkid']; ?>">	
						<input type="hidden" id="update_amup_username" name="update_amup_username" value="<?php echo $row['amup_username']; ?>">	
						<br>
						
						<label class="FormLabel">Date Created:</label>
						<input type="date" style="width:220px; height:5%;" class="FormText" id="update_date_created" name="update_date_created" value="<?php echo date("Y-m-d") ; ?>" readonly>	
						<br>
						
						<label class="FormLabel">EmpNo.:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_EmpNo" name="update_EmpNo" readonly>		
						<br>
						
						<label class="FormLabel">Employee Name:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_AMUp_Name" name="update_AMUp_Name" readonly>		
						<br>
						
						<label class="FormLabel">Division:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_division" name="update_division" readonly>	
						<br> 
						
						<label class="FormLabel">Address during leave:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_emp_address" name="update_emp_address" readonly>	
						<br>
						
						<input class="FormLabel" type="radio" id="update_lbl_radio_otherAdd" name="update_lbl_radio_otherAdd" value="1">
						<label style="width:220px; font-size: 14px; ">Others <i>(Leave Address)</i></label>
						<br>
						
						<label class="FormLabel"></label>
						<textarea rows="2" style="width:220px;" id="update_address" name="update_address" value = "N/A" ></textarea>
						<br>

						<label class="FormLabel">Immediate Superior:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_cmb_approver1" name="update_cmb_approver1" readonly>	
						<br>
						
						<label class="FormLabel">Sec/Department Head:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_cmb_approver2" name="update_cmb_approver2" readonly>	
						<br>
						
					<!--	<label class="FormLabel" for="approver2">Sec/Department Head:</label>
							<?php 						
								// echo "<select id='update_cmb_approver2' name='update_cmb_approver2' style='width:220px; height:5%;' class='selectpicker' data-live-search='true' title='Please select your Sec/Department Head...' required>"; 
									// $query = ELFS::getInstance()->getAMUp_Name();
									// while($row = mysqli_fetch_array($query)) {
										// echo '<option value='.$row['username'].'>'.$row['firstname'].' '.$row['lastname'].' </option>';
									// }
								// echo "</select>";	
							?>
					-->
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
										<input class="FormLeaveApplied" type="radio" id="update_rbtn_sl" name="update_leave_applied" value="0">
										<label style="font-size: 14px;" id="lbl_sl">Sick Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="update_rbtn_vl" name="update_leave_applied" value="1">
										<label style="font-size: 14px;" id="lbl_vl">Vacation Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="update_rbtn_bdl" name="update_leave_applied" value="2">
										<label style="font-size: 14px;" id="lbl_bdl">Birthday Leave</label>
										<br>
										<input class="FormLeaveApplied" type="radio" id="update_rbtn_pl" name="update_leave_applied" value="4">
										<label style="font-size: 14px;" id="lbl_bdl">Paternity Leave</label>
								
									</div>
									<div class="col-sm-6">
										<input class="FormLeaveApplied" type="radio" id="update_rbtn_bl" name="update_leave_applied" value="5">
										<label  style="font-size: 14px;" id="lbl_bdl">Bereavement Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="update_rbtn_sp" name="update_leave_applied" value="6">
										<label style="font-size: 14px;" id="lbl_bdl">Solo Parent Leave</label>
										<br>
									
										<input class="FormLeaveApplied" type="radio" id="update_rbtn_ml" name="update_leave_applied" value="3">
										<label style="font-size: 14px;" id="lbl_bdl">Maternity Leave</label>
										<br>
										
										<input class="FormLeaveApplied" type="radio" id="update_rbtn_slbw" name="update_leave_applied" value="7">
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
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_del_date_from" name="update_del_date_from" autocomplete="off">
						<br>
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_del_date_to" name="update_del_date_to" autocomplete="off"> 
						<br>
						
						<label class="FormLabel">Delivery days:</label>
						<input type="text" style="width:50px; height:5%;" class="FormText" id="update_del_days" name="update_del_days" readonly>
						<br>
						</div>
						<br>
						<!-- end delivery date -->
						
						<label style="width:300px; font-size: 14px;" >Date of Absent/s:</label>
						<input type="hidden" style="width:220px; height:5%;" class="FormText">
						<br>
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From *:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_date_absent_from" name="update_date_absent_from" autocomplete="off" readonly="true" required>
						<br>
						
						<label class="FormLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To *:</label>
						<input type="text" style="width:220px; height:5%;" class="FormText" id="update_date_absent_to" name="update_date_absent_to" autocomplete="off" readonly="true" required> 
						<br>
						
						<label class="FormLabel">No. of days:</label>
						<input type="text" style="width:50px; height:5%;" class="FormText" id="update_no_of_days" name="update_no_of_days" readonly>
						<br>
						
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
				</div><!-- end row -->
				
				<div class="modal-footer">
					<button type="button" id="btn_send_update_leave" data-confirm="Are you sure you want to send this leave?" class="btn btn-success">SAVE&SEND </button>
					<button type="button" id="btn_cancel_update_leave_modal" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
				</div>
				
				</form>	
			</div>
		</div>
	</div>
</div>

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

<script>
$(document).ready(function(){
	$("#leave_tbl").dataTable({
		"order": [],
		"columnDefs": [{
		"targets"  : 'no-sort',
		"orderable": false,
	}]});
});

$('#lbl_radio_otherAdd').change(function () {
    if ($(this).is(':checked')) {
			$('#emp_address').prop('disabled', true);
			$('#emp_address').val('N/A');
			$('#address').prop('disabled', false);
    } 
});
	
$("tbody tr").click(function() {
	console.log('clicked');
	$(this).addClass('selected').siblings().removeClass("selected");
});

$("#leave_tbl tbody").on('dblclick', 'tr', function(){
	$("#modal-body input").val("");	
	select_view_emp_leave($(this).find("td:eq(0)").text());
});	

$('#btn_new_leave').click(function(){
	$('#Leave_application_modal').modal('show'); 
});	

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
		
dateFrom.datepicker('destroy');
dateFrom.datepicker({
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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
	
	// minDate: minDate, 
	minDate: '04/01/2023', // For update minDate ( Open last 2 Months )
	
	// beforeShowDay: function(date) {
	// var day = date.getDay();
	// return [(day != 0), ''];
	// },
	
	onSelect: function(dateText, inst) {
		$('#date_absent_to').datepicker("option", {
			minDate: new Date(dateText),
		});
	},
});
 
dateTo.datepicker('destroy');
dateTo.datepicker( { 
	// beforeShowDay: function(date) {
	// var day = date.getDay();
	// return [(day != 0), ''];
	// },
	
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
	changeMonth: true,
	changeYear: true,
	stepMonths: true,
	beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
	},
});
	
dateFrom.datepicker('destroy');
dateFrom.datepicker( { 
	changeMonth: true,
	changeYear: true,
	stepMonths: true,
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
		
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", true);
		$('#other_reason').val('3');
		$('#reason').val('Maternity Leave');

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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
	
	
dateFrom.datepicker('destroy');
dateFrom.datepicker({
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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
		
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", false);
		$('#other_reason').val('3');
		$('#reason').val('');
		
dateFrom.datepicker('destroy');
dateFrom.datepicker({
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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

		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", false);
		$('#other_reason').val('3');
		$('#reason').val('');
		
dateFrom.datepicker('destroy');
dateFrom.datepicker({
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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
		
		$("select[name='other_reason']").attr("disabled", true);
		$("textarea[id='reason']").prop("disabled", false);
		$('#other_reason').val('3');
		$('#reason').val('');

dateFrom.datepicker('destroy');
dateFrom.datepicker({
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )

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
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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
	changeMonth: true,
	changeYear: true,
	stepMonths: true,
	beforeShowDay: function(date) {
		var day = date.getDay();
		return [(day != 0), ''];
	},
});
	
dateFrom.datepicker('destroy');
dateFrom.datepicker( { 
	changeMonth: true,
	changeYear: true,
	stepMonths: true,
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
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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
	minDate: '04/01/2021', // For update minDate ( Open last 2 Months )
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

$('#btn_cancel_leave_modal').click(function(){
	window.location.href = "leave_app_for_amup.php";
});

$('#btn_cancel_update_leave_modal').click(function(){
	window.location.href = "leave_app_for_amup.php";
});

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
				"action"			 : 'Save_AMUp_leave_as_draft',
				"fkEmployee"		 : $('#fkEmployee').val(),
				"status"			 : '7',
				"date_created"		 : $('#date_created').val(),
				"empName"			 : $('#empName').val(),
				"created_by"		 : "<?php echo $username; ?>",
				"EmpNo"				 : $('#EmpNo').val(),
				"Division"		 	 : $('#Division').val(),
				"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
				"address"		 	 : $('#address').val(),
				"emp_address"		 : $('#emp_address').val(),
				"radio_OthersAdd"	 : $('input[name="lbl_radio_otherAdd"]:checked').val(),
				"reason"			 : $('#reason').val(),
				"other_reason"		 : $('#other_reason').val(),
				"approver1"			 : $('#hidden_sechead').val(),
				"approver2"			 : $('#hidden_depthead').val(),
				"username"			 : "<?php echo $username; ?>"
			}
			
			data = $.param(data);
			alert(data);
			$.ajax({
				type	: 'POST',
				dataType: 'json',
				data	: data,
				url		: 'save_amup_leave_record_as_drafts.php',
				success	: function(data){	
				
					var data1 = {
					"action"			 : 'Select_AMUp_leave_as_draft',
					"fkEmployee"		 : $('#fkEmployee').val(),
					"status"			 : '7',
					"date_created"		 : $('#date_created').val(),
					"empName"			 : $('#empName').val(),
					"created_by"		 : "<?php echo $username; ?>",
					"EmpNo"				 : $('#EmpNo').val(),
					"Division"		 	 : $('#Division').val(),
					"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
					"address"		 	 : $('#address').val(),
					"emp_address"		 : $('#emp_address').val(),
					"radio_OthersAdd"	 : $('input[name="lbl_radio_otherAdd"]:checked').val(),
					"reason"			 : $('#reason').val(),
					"other_reason"		 : $('#other_reason').val(),
					"approver1"			 : $('#hidden_sechead').val(),
					"approver2"			 : $('#hidden_depthead').val(),
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
							var empName 		= result['empName'];
							var created_by 		= result['created_by'];
							var EmpNo 			= result['EmpNo'];
							var leave_applied 	= result['leave_applied'];
						
							var data2 = {
								"pkid"					: result['pkid'],
								"empName"				: result['empName'],
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
								url		: "save_amup_leave_dates_as_drafts.php",
								success	: function(result){			
								},error	: function(result){
								}
							});
								
						}, error: function (result) {
						}
					});
					
					alert("Leave Application Saved!");
					window.location.href = "leave_app_for_amup.php";
					
				}
				// ,error(data){
					// alert('ERROR MAIN');
				// }
			});
		}
		
	} // end else
});	

$('#btn_send_leave').click(function(e){ 
	if($('#approver2').val() == '') { 
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
				"action"			 : 'AMUp_leave_as_draft',
				"fkEmployee"		 : $('#fkEmployee').val(),
				"status"			 : '2',
				"date_created"		 : $('#date_created').val(),
				"empName"			 : $('#empName').val(),
				"created_by"		 : "<?php echo $username; ?>",
				"EmpNo"				 : $('#EmpNo').val(),
				"Division"		 	 : $('#Division').val(),
				"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
				"address"		 	 : $('#address').val(),
				"emp_address"		 : $('#emp_address').val(),
				"radio_OthersAdd"	 : $('input[name="lbl_radio_otherAdd"]:checked').val(),
				"reason"			 : $('#reason').val(),
				"other_reason"		 : $('#other_reason').val(),
				"approver1"			 : $('#hidden_sechead').val(),
				"approver2"			 : $('#hidden_depthead').val(),
				"username"			 : "<?php echo $username; ?>"
			}
			
			data = $.param(data);
			// alert(data);
			$.ajax({
				type	: 'POST',
				dataType: 'json',
				data	: data,
				url		: 'send_amup_leave_record.php',
				success	: function(data){	
				
					var data1 = {
					"action"			 : 'Select_AMUp_leave_as_draft',
					"fkEmployee"		 : $('#fkEmployee').val(),
					"status"			 : '2',
					"date_created"		 : $('#date_created').val(),
					"empName"			 : $('#empName').val(),
					"created_by"		 : "<?php echo $username; ?>",
					"EmpNo"				 : $('#EmpNo').val(),
					"Division"		 	 : $('#Division').val(),
					"leave_applied"		 : $('input[name="leave_applied"]:checked').val(),
					"address"		 	 : $('#address').val(),
					"emp_address"		 : $('#emp_address').val(),
					"radio_OthersAdd"	 : $('input[name="lbl_radio_otherAdd"]:checked').val(),
					"reason"			 : $('#reason').val(),
					"other_reason"		 : $('#other_reason').val(),
					"approver1"			 : $('#hidden_sechead').val(),
					"approver2"			 : $('#hidden_depthead').val(),
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
							var empName 		= result['empName'];
							var created_by 		= result['created_by'];
							var EmpNo 			= result['EmpNo'];
							var leave_applied 	= result['leave_applied'];
						
							var data2 = {
								"pkid"					: result['pkid'],
								"empName"				: result['empName'],
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
								url		: "send_amup_leave_dates.php",
								success	: function(result){			
								},error	: function(result){
								}
							});
								
						}, error: function (result) {
						}
					});
					
					alert("Leave Application Saved!");
					window.location.href = "leave_app_for_amup.php";
					
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
		"action"				 : 'update_amup_leave_record',
		"pkid"					 : $('#update_txt_pkid').val(),
		"status"				 : '2',
		"leave_applied"			 : $('input[name="update_leave_applied"]:checked').val(),
		"reason"				 : $('#update_reason').val(),
		"emp_address"			 : $('#update_emp_address').val(),
		"address"				 : $('#update_address').val(),
		"radio_OthersAdd"		 : $('input[name="update_lbl_radio_otherAdd"]:checked').val(),
		"approver1"				 : $('#update_cmb_approver1').val(),
		"approver2"				 : $('#update_cmb_approver2').val(),
		"username"				 : "<?php echo $username; ?>"
	}
	
	data = $.param(data);
	// alert(data);
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		data	: data,
		url		: 'update_amup_leave_record.php',
		success	: function(data){	
	
		var data1 = {
		"action"				 : 'Select_leave_record_for_update',
		"pkid"					 : $('#update_txt_pkid').val(),
		"status"				 : '0',
		"leave_applied"			 : $('input[name="update_leave_applied"]:checked').val(),
		"reason"				 : $('#update_reason').val(),
		"emp_address"			 : $('#update_emp_address').val(),
		"radio_OthersAdd"		 : $('input[name="lbl_radio_otherAdd"]:checked').val(),
		"address"				 : $('#update_address').val(),
		"approver"				 : $('#update_cmb_approver1').val(),
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
		
		alert("Leave Application has been Updated!");
		window.location.href = "leave_app_for_amup.php";
		
	}
});
	}
});	 

$("#leave_tbl tbody").on('click','tr #btn_view_leave', function(e){
	e.preventDefault();
	select_leave_info_by_pkid($(this).val());
});

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

$('#EmpNo').keyup(function(e){
	var key_pressed = e.which;
	if(key_pressed != 38 && key_pressed != 40){
		var pattern = $(this).val();
		get_empno(pattern);
	}
	empno_check_db();
});

$('#approver1').keyup(function(e){
	
	var key_sechead = e.which;
	if(key_sechead != 38 && key_sechead != 40){
		var sechead_pattern = $(this).val();
		getsechead(sechead_pattern);
	}
	
});

$('#approver2').keyup(function(e){
	var key_depthead = e.which;
	if(key_depthead != 38 && key_depthead != 40){
		var depthead_pattern = $(this).val();
		getdepthead(depthead_pattern);
	}

});
	
/* Function */
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
					$('#update_lbl_radio_otherAdd').prop('disabled', true);
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
			}  else if(result['leave_applied'] == 7) {
				$('#update_rbtn_slbw').prop('checked', true);
			} 
			
			if(result['radio_OthersAdd'] == 1) {
				$('#update_lbl_radio_otherAdd').prop('checked', true);
			} else {
				$('#update_lbl_radio_otherAdd').prop('checked', false);
			}
	
			$('#update_date_created').val(result['date_created']);
			$('#update_AMUp_Name').val(result['Emp_Name']);
			$('#update_EmpNo').val(result['EmpNo']);
			$('#update_division').val(result['Division']);				
			$('#update_date_absent_from').val(result['date_from']);
			$('#update_date_absent_to').val(result['date_to']);
			$('#update_no_of_days').val(result['total_absent_days']);
			$('#update_emp_address').val(result['emp_address']);
			$('#update_cmb_approver1').val(result['approver1_name']);
			$('#update_cmb_approver2').val(result['approver2_name']);
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
			
			$('#update_lbl_radio_otherAdd').click(function(){
				$('#update_emp_address').prop('disabled', true);
				$('#update_emp_address').val('N/A');
				$('#update_address').prop('disabled', false);
			});		
				
			$("#Leave_application_modal_view").modal();
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
		
		if(result['status'] == 0 || result['status'] == 1 || result['status'] == 2 || result['status'] == 3 || result['status'] == 4 || result['status'] == 5 ||	result['status'] == 6 || result['status'] == 8) {		
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
				
			var ctr = data['ctr'];
				$('#ViewLeave_summary').empty();	
					var html  = '<table id="tbl_leave_view_records" class="table table-bordered">';
						html += '	<thead>';
						html += '		<tr>';
						html += '			<th><center><font size="2">DATE ABSENT</font></center></th>';
						html += '			<th><center><font size="2">NO. OF DAYS</font></center></th>';
						html += '			<th><center><font size="2">PAID LEAVE</font></center></th>';
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
					html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_paid'][i]+'</td>';	
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
		window.location.href = "leave_app_for_amup.php";
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
		window.location.href = "leave_app_for_amup.php";
		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}

function get_empno(pattern){

	var data = {
		'action'		: 'get_empno_info',
		'pattern'		: pattern
	}

	data = $.param(data) + "&" + $(this).serialize();

	$.ajax({
		type	: 'post',
		dataType: 'json',
		data	: data,
		url		: 'elfs_handler.php',
		success	: function(data){
			

			var ctr = data['ctr'];

			$('#id_list_emp_num').empty();

			for(i=0;i<ctr;i++){
				var html = '<option>'+data['EmpNo'][i]+'</option>';
				$('#id_list_emp_num').append(html);
			}

		},
		error	: function(data){
			alert("Handler Failed!");
			console.log(data);
		}

	});

}

function empno_check_db(){
	var empno = $('#EmpNo').val();

	var data = {
		'action'		: 'check_empno_details',
		'empno'			: empno
	}

	data = $.param(data) + "&" + $(this).serialize();

	$.ajax({
		type	: 'post',
		dataType: 'json',
		data	: data,
		url		: 'elfs_handler.php',
		success	: function(data){
				
				var LN = data['LastName'];
				var FN = data['FirstName'];
				var employee_name = LN+', '+FN;
				$('#Employee_Name').val(employee_name);

				var add_1 = data['CityAddress1'];
				var add_2 = data['CityAddress2'];
				var add_3 = data['CityAddress3'];
				var CityAddress = add_1+', '+add_2+', '+add_3;
				$('#emp_address').val(CityAddress);

				$('#Division').val(data['Division']);
				
				$('#fkEmployee').val(data['pkid']);
				$('#empName').val(data['username']);

		},
		error	: function(data){
			alert('check details failed!');
			console.log(data);
		}
	});
}

function getsechead(sechead_pattern){

	var data = {
		'action'		: 'getsechead',
		'pattern'		: sechead_pattern
	}

	data = $.param(data);

	$.ajax({
		type	: 'post',
		dataType: 'json',
		data	: data,
		url		: 'elfs_handler.php',
		success	: function(data){

			
			
			var ctr = data['ctr'];

			$('#id_list_sechead').empty();
			$('#hidden_sechead').val("");
			for(i=0;i<ctr;i++){
				var html = '<option>'+data['fullname'][i]+'</option>';
				$('#hidden_sechead').val("");
				// $('#hidden_sechead').val(data['email_add'][i]);
				$('#hidden_sechead').val(data['username'][i]);
				$('#id_list_sechead').append(html);
			}
			console.log(data);

		},
		error	: function(data){
			alert("Handler Failed!");
			console.log(data);
		}

	});
}

function getdepthead(depthead_pattern){

	var data = {
		'action'		: 'getdepthead',
		'pattern'		: depthead_pattern
	}

	data = $.param(data);

	$.ajax({
		type	: 'post',
		dataType: 'json',
		data	: data,
		url		: 'elfs_handler.php',
		success	: function(data){

			var ctr = data['ctr'];

			$('#id_list_depthead').empty();
			$('#hidden_depthead').val("");
			for(i=0;i<ctr;i++){
				var html = '<option>'+data['fullname'][i]+'</option>';
				$('#hidden_depthead').val("");
				// $('#hidden_depthead').val(data['email_add'][i]);
				$('#hidden_depthead').val(data['username'][i]);
				$('#id_list_depthead').append(html);
				
			}
			console.log(data);

		},
		error	: function(data){
			alert("Handler Failed!");
			console.log(data);
		}

	});
}

	
</script>
</html>