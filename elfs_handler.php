<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action)
			{
				case "select_leave_info_by_pkid" 			: select_leave_info_by_pkid(); break;				
				case "select_employee_info_by_username" 	: select_employee_info_by_username(); break;				
				case "select_leave_records" 				: select_leave_records(); break;				
				case "get_leave_summary" 					: get_leave_summary(); break;				
				case "getEmpLeaveBalance_records" 			: getEmpLeaveBalance_records(); break;				
				case "show_remarks"							: show_remarks(); break;
				case "update_leave"							: update_leave(); break;
				case "update_approver1_status"				: update_approver1_status(); break;
				case "update_approver2_status"				: update_approver2_status(); break;
				case "update_hrd_status"					: update_hrd_status(); break;
				case "add_regularity_date"					: add_regularity_date(); break;
				case "send_email_for_approval" 				: send_email_for_approval(); break;		
				case "send_email_from_approver1"			: send_email_from_approver1(); break;
				case "send_email_from_approver2"			: send_email_from_approver2(); break;
				case "send_email_from_hrd"					: send_email_from_hrd(); break;
				case "send_email_from_hrd_revise"			: send_email_from_hrd_revise(); break;
				case "send_email_from_hrd_cancelled"		: send_email_from_hrd_cancelled(); break;
				case "update_Leave_balance"					: update_Leave_balance(); break;
				case "select_leave_balance_info"			: select_leave_balance_info(); break;
				case "select_view_emp_leave"				: select_view_emp_leave(); break;
				case "select_batch_dates"					: select_batch_dates(); break;
				case "get_edit_leave_dates_summary"			: get_edit_leave_dates_summary(); break;
				case "get_remove_leave_dates_summary"		: get_remove_leave_dates_summary(); break;
				case "get_view_leave_dates_summary"			: get_view_leave_dates_summary(); break;
				case "select_EmpNo_list_by_pkid"			: select_EmpNo_list_by_pkid(); break;
				case "AddNewLeaveBalance"					: AddNewLeaveBalance(); break;
				case "send_email_for_approval_to_DH"		: send_email_for_approval_to_DH(); break;
				case "send_email_cancelled_leave"			: send_email_cancelled_leave(); break;
				case "Save_leave_as_draft"					: Save_leave_as_draft(); break;
				case "Select_leave_as_draft"				: Select_leave_as_draft(); break;
				case "savesend_leave_record"				: savesend_leave_record(); break;
				case "Select_leave_record"					: Select_leave_record(); break;
				case "update_leave_record"					: update_leave_record(); break;
				case "Select_leave_record_for_update"		: Select_leave_record_for_update(); break;
				case "select_leave_info_for_cancel_by_pkid"	: select_leave_info_for_cancel_by_pkid(); break;
				case "cancel_conformed_leave_by_pkid"		: cancel_conformed_leave_by_pkid(); break;
				case "cancelled_leave_application"			: cancelled_leave_application(); break;
				case "Select_cancelled_record"				: Select_cancelled_record(); break;
				case "delete_leave_date"					: delete_leave_date(); break;
				case "view_leave_dates"						: view_leave_dates(); break;
				case "save_updated_leave_record_as_drafts"  : save_updated_leave_record_as_drafts(); break;
				case "cancel_leave_app_by_pkid"				: cancel_leave_app_by_pkid(); break;
				case "delete_employee"						: delete_employee(); break;
				
				case "get_empno_info"						: get_empno_info(); break;
				case "check_empno_details"					: check_empno_details(); break;
				case "getsechead"							: getsechead(); break;
				case "getdepthead"							: getdepthead(); break;
				
				case "select_AMUp_list_by_pkid"				: select_AMUp_list_by_pkid(); break;
				case "Select_AMUp_leave_as_draft"			: Select_AMUp_leave_as_draft(); break;
				
				/* Batch Leave */
				case "Select_batch_leave_record_for_update"	: Select_batch_leave_record_for_update(); break;
				case "get_batch_employee_list_by_requestor"	: get_batch_employee_list_by_requestor(); break;
				case "get_batch_employee"					: get_batch_employee(); break;
				case "Select_leave_emp_batch"				: Select_leave_emp_batch(); break;
				case "get_leave_batch"						: get_leave_batch(); break;
				case "select_batch_leave_info_by_pkid" 		: select_batch_leave_info_by_pkid(); break;				
				case "select_leave_batch_info_by_pkid" 		: select_leave_batch_info_by_pkid(); break;				
				case "Select_batch_leave_as_draft"			: Select_batch_leave_as_draft(); break;
				case "Select_batch_leave"					: Select_batch_leave(); break;
				case "batch_show_remarks"					: batch_show_remarks(); break;
				case "save_leave_batch"						: save_leave_batch(); break;
				case "select_batch_emp"						: select_batch_emp(); break;
				case "Update_batch_leave"					: Update_batch_leave(); break;
				case "select_batch_leave_info_for_cancel_by_pkid"	: select_batch_leave_info_for_cancel_by_pkid(); break;
				case "select_employee_name_by_empno"		: select_employee_name_by_empno(); break;
				case "send_email_batch_for_approval"		: send_email_batch_for_approval(); break;
				case "send_email_batch_from_approver2"		: send_email_batch_from_approver2(); break;
				case "send_email_batch_from_hrd"			: send_email_batch_from_hrd(); break;
				
				//11/2/2017
				case "select_leave_conversion_info"			: select_leave_conversion_info(); break;
				case "update_leave_conversion"				: update_leave_conversion(); break;
				case "add_new_leave_conversion"				: add_new_leave_conversion(); break;

				/**
				 * 09-4-2024
				 * -JD
				 */
				case "checkIfLeaveDateIsExisted"				: checkIfLeaveDateIsExisted(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// select_leave_info_by_pkid();
	function select_leave_info_by_pkid() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$ctr = 0;
		$result = "";
		// $result = ELFS::getInstance()->select_leave_info_by_pkid(1);
		$result = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['fkEmployee'][$ctr]			= $row['fkEmployee'];
			$return['status'][$ctr]				= $row['status'];
			$return['cutoff'][$ctr]				= $row['cutoff'];
			$return['date_created'][$ctr]		= $row['date_created'];
			$return['Emp_Name'][$ctr] 			= $row['Emp_Name'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['Division'][$ctr]			= $row['Division'];
			$return['leave_applied'][$ctr]		= $row['leave_applied'];
			$return['day_type'][$ctr]			= $row['day_type'];
			$return['date_from'][$ctr]			= $row['date_from'];
			$return['date_to'][$ctr]			= $row['date_to'];
			$return['total_absent_days'][$ctr]	= $row['total_absent_days'];
			$return['no_of_paid'][$ctr]			= $row['no_of_paid'];
			$return['reason'][$ctr]				= $row['reason'];
			$return['other_reason'][$ctr]		= $row['other_reason'];
			$return['emp_address'][$ctr]		= $row['emp_address'];
			$return['radio_OthersAdd'][$ctr]	= $row['radio_OthersAdd'];
			$return['address'][$ctr]			= $row['address'];
			$return['approver1'][$ctr]			= $row['approver1'];
			$return['approver2'][$ctr]			= $row['approver2'];			
			$return['conformedby'][$ctr]		= $row['conformedby'];			
			$return['disapproved_label'][$ctr]		= $row['disapproved_label'];			
			$return['IS_disapproved_remarks'][$ctr]		= $row['IS_disapproved_remarks'];			
			$return['DH_disapproved_remarks'][$ctr]		= $row['DH_disapproved_remarks'];			
			$return['HR_revised_remarks'][$ctr]		= $row['HR_revised_remarks'];			
			$return['Cancelled_remarks'][$ctr]		= $row['Cancelled_remarks'];			
			$return['HR_cancel_remarks'][$ctr]		= $row['HR_cancel_remarks'];			
			$return['username'][$ctr]			= $row['username'];			
			
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($row['empName']);
			if($row_req_name = mysqli_fetch_array($emp_name)) {
				$return['Emp_Name'][$ctr] = $row_req_name['Emp_Name'];
			}
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['approver1']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['approver1_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['approver2']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['approver2_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['username']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['hrd_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// select_leave_info_for_cancel_by_pkid ();
	function select_leave_info_for_cancel_by_pkid() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = "";
		// $result = ELFS::getInstance()->select_leave_info_for_cancel_by_pkid(1);
		$result = ELFS::getInstance()->select_leave_info_for_cancel_by_pkid($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['pkid']					= $row['pkid'];
			$return['fkEmployee']			= $row['fkEmployee'];
			$return['status']				= $row['status'];
			$return['Cancelled_remarks']	= $row['Cancelled_remarks'];
			$return['username']				= $row['username'];			
			
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// cancel_conformed_leave_by_pkid ();
	function cancel_conformed_leave_by_pkid() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = "";
		// $result = ELFS::getInstance()->cancel_conformed_leave_by_pkid(1);
		$result = ELFS::getInstance()->cancel_conformed_leave_by_pkid($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['pkid']					= $row['pkid'];
			$return['fkEmployee']			= $row['fkEmployee'];
			$return['status']				= $row['status'];
			$return['HR_cancel_remarks']	= $row['HR_cancel_remarks'];
			$return['username']				= $row['username'];			
			
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
		
	// cancel_leave_app_by_pkid ();
	function cancel_leave_app_by_pkid() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = "";
		$result = ELFS::getInstance()->cancel_leave_app_by_pkid($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['pkid']					= $row['pkid'];
			$return['fkEmployee']			= $row['fkEmployee'];
			$return['status']				= $row['status'];
			$return['Cancelled_remarks']	= $row['Cancelled_remarks'];
			$return['username']				= $row['username'];			
			
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	//Select emp info by username
	function select_employee_info_by_username() {
		require_once('elfs_oop.php');
		$return = $_POST;
		$result = ELFS::getInstance()->select_employee_info_by_username($return['username']);
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
		
	//Emp Records
	function select_leave_records() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = ELFS::getInstance()->select_leave_records($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['Emp_Name'] 		= $row['Emp_Name'];
			$return['Division'] 		= $row['Division'];
			$return['EmpNo'] 			= $row['EmpNo'];
			$return['Department'] 		= $row['Department'];
			
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	// get_leave_summary ();
	function get_leave_summary() {
		require_once("elfs_oop.php");
		$p = $_POST;
		$return = array();
		$result = ELFS::getInstance()->get_leave_summary($p['pkid']);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 				= $row['pkid'];
			$return['leave_applied'][$ctr] 		= $row['leave_applied'];
			$return['date_from'][$ctr] 			= date('F d, Y',strtotime($row['date_from']));
			$return['date_to'][$ctr] 			= date('F d, Y',strtotime($row['date_to']));
			$return['total_absent_days'][$ctr] 	= $row['total_absent_days'];
			$return['no_of_paid'][$ctr] 		= $row['no_of_paid'];
			$return['reason'][$ctr] 			= $row['reason'];
			$return['other_reason'][$ctr] 		= $row['other_reason'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		// $return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Emp Records
	function getEmpLeaveBalance_records() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = ELFS::getInstance()->getEmpLeaveBalance_records($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['empName'] 					= $row['empName'];
			$return['EmpNo'] 					= $row['EmpNo'];
			$return['regularity_date'] 			= $row['regularity_date'];
			$return['previous_balance_VL'] 		= $row['previous_balance_VL'];
			$return['credit_VL'] 				= $row['credit_VL'];
			$return['current_avail_VL'] 		= $row['current_avail_VL'];
			$return['total_VL_used'] 			= $row['total_VL_used'];
			$return['total_VL_balance'] 		= $row['total_VL_balance'];
			$return['previous_balance_SL'] 		= $row['previous_balance_SL'];
			$return['credit_SL'] 				= $row['credit_SL'];
			$return['current_avail_SL'] 		= $row['current_avail_SL'];
			$return['total_SL_used'] 			= $row['total_SL_used'];
			$return['total_SL_balance'] 		= $row['total_SL_balance'];
			
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	// Load Remarks ();
	function show_remarks() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$ctr = 0;
		$result = ELFS::getInstance()->show_remarks($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			
			$return['IS_disapproved_remarks'][$ctr] 		= $row['IS_disapproved_remarks'];
			$return['DH_disapproved_remarks'][$ctr] 		= $row['DH_disapproved_remarks'];
			$return['HR_revised_remarks'][$ctr] 			= $row['HR_revised_remarks'];
			$return['Cancelled_remarks'][$ctr] 			= $row['Cancelled_remarks'];
			$return['HR_cancel_remarks'][$ctr] 			= $row['HR_cancel_remarks'];
			$return['approver1'][$ctr] 					= $row['approver1'];
			$return['approver2'][$ctr] 					= $row['approver2'];
			
			if($row['disapproved_label'] == 1 ){
				$return['disapproved_label'][$ctr] 		= "Late Filling";
			} else if($row['disapproved_label'] == 2 ){
				$return['disapproved_label'][$ctr] 		= "Unauthorized";
			}
			
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Update Leave
	function update_leave(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->update_leave($return['pkid'],
					$return['status'],
					$return['leave_applied'],
					$return['reason'],
					$return['radio_OthersAdd'],
					$return['address'],
					$return['approver1'],
					$return['approver2'],
					$return['username']);
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Update Approver1 Status
	function update_approver1_status(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->update_approver1_status($return['pkid'],
					$return['status'],
					$return['IS_disapproved_remarks'],
					$return['username']);
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Update Approver2 Status
	function update_approver2_status(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->update_approver2_status($return['pkid'],
					$return['status'],
					$return['DH_disapproved_remarks'],
					$return['username']);
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Update HRD Status
	function update_hrd_status(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->update_hrd_status($return['pkid'],
					$return['status'],
					$return['HR_revised_remarks'],
					$return['HR_cancelled_remarks'],
					$return['username']);
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// Add Regularity date	
	function add_regularity_date(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->add_regularity_date($return['pkid'],
					$return['regularity_date'],
					$return['username']);
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	// send_email_for_approval();
	function send_email_for_approval() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$ctr = 0;
		$select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid(18);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$remarks 				= $row['remarks'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_from'];
			$date_absent_to 		= $row['date_to'];
			$no_of_days 			= $row['total_absent_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$other_reason 			= $row['other_reason'];
			$emp_address 			= $row['emp_address'];
			$radio_OthersAdd 		= $row['radio_OthersAdd'];
			$address 				= $row['address'];
			$approver1 				= $row['approver1'];
			$approver2 				= $row['approver2'];
			$conformedby 			= $row['conformedby'];
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver1);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver1_name = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver2);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver2_name = $row_app_name['Emp_Name'];
			}
			
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}
			
			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
			
			if($approver1 == 0) {
				$IS_approver = "N/A";
			} else {
				$IS_approver 	= $row['approver1'];
			} 
			
			if($emp_address == 'N/A') {
				$leave_address 	= $row['address'];
			} else {
				$leave_address 	= $row['emp_address'];
			} 
			
			if($other_reason == '0') {
				$reason_label 	= 'N/A';
			} else if($other_reason == '1') {
				$reason_label 	= 'Shut-down';
			} else if($other_reason == '2') {
				$reason_label 	= 'Special Non-working Holiday';
			} else if($other_reason == '3') {
				$reason_label 	= 'Others';
			}
			
			$subject = "ELFS - Leave Application Approval";
			$body .= "Good day!\n\n";
			$body .= "You have Leave Application waiting for your approval. \n";
			$body .= "Please log on to your systemone account.\n";
			$body .= "Go to http://systemone \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Employee Name: ".$employee_name." \n";
			$body .= "Employee No.: ".$EmpNo." \n";
			$body .= "Division: ".$Division." \n";
			
			$body .= "Leave Applied: <b>".$type_leave_applied."</b> \n";
			$body .= "Date Absent: ".date('M d, Y',strtotime($date_absent_from))." - ".date('M d, Y',strtotime($date_absent_to))."\n";
			$body .= "No of Days: ".$no_of_days."\n";
			$body .= "Reason: ".$reason_label." \n";					
			$body .= "Other Reason: ".$reason." \n";					
			$body .= "Address during leave: ".$leave_address." \n\n";	

			$body .="</table>"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 
			
			
			$ctrFrom = 0;
			$ctrCc = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($Emp_Name);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
					$cc = $row['email_add'];
					$ctrCc++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
				}	
			}
			
			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_email_add($approver1);
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
			// $ctrTo = 0;
			// $select_query_to = ELFS::getInstance()->select_email_add($approver2);
			// while($row = mysqli_fetch_array($select_query_to)) {
				// if($ctrTo == 0) {
					// $to = $row['email_add'];
					// $ctrTo++;
				// } else {
					// $to .= "," . $row['email_add'];
					// $ctrTo++;
				// }	
			// }
			
			// echo $body ; 
			// echo $to.'<br>';
			// echo '<br>';
			// echo $cc.'<br>';
			$php_email = new email();
			// $php_email->send_email("marvald@pricon.ph", "marlope@pricon.ph", "marlope@pricon.ph", $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}
	
	 // send_email_for_approval_to_DH();
	function send_email_for_approval_to_DH() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid(45123);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$remarks 				= $row['remarks'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_from'];
			$date_absent_to 		= $row['date_to'];
			$no_of_days 			= $row['total_absent_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$other_reason 			= $row['other_reason'];
			$emp_address 			= $row['emp_address'];
			$radio_OthersAdd 		= $row['radio_OthersAdd'];
			$address 				= $row['address'];
			$approver1 				= $row['approver1'];
			$approver2 				= $row['approver2'];
			$conformedby 			= $row['conformedby'];
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver1);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver1_name = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver2);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver2_name = $row_app_name['Emp_Name'];
			}
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}

			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
			
			if($approver1 == 0) {
				$IS_approver = "N/A";
			} else {
				$IS_approver 	= $row['approver1'];
			} 
			
			if($emp_address == 'N/A') {
				$leave_address 	= $row['address'];
			} else {
				$leave_address 	= $row['emp_address'];
			} 
			
			if($other_reason == '0') {
				$reason_label 	= 'N/A';
			} else if($other_reason == '1') {
				$reason_label 	= 'Shut-down';
			} else if($other_reason == '2') {
				$reason_label 	= 'Special Non-working Holiday';
			} else if($other_reason == '3') {
				$reason_label 	= 'Others';
			}
			
			$subject = "ELFS - Leave Application Approval";
			$body .= "Good day!\n\n";
			$body .= "You have Leave Application waiting for your approval. \n";
			$body .= "Please log on to your systemone account.\n";
			$body .= "Go to http://systemone \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Employee Name: ".$employee_name." \n";
			$body .= "Employee No.: ".$EmpNo." \n";
			$body .= "Division: ".$Division." \n";
			
			$body .= "Leave Applied: <b>".$type_leave_applied."</b> \n";
			$body .= "Date Absent: ".date('M d, Y',strtotime($date_absent_from))." - ".date('M d, Y',strtotime($date_absent_to))."\n";
			$body .= "No of Days: ".$no_of_days."\n";
			$body .= "Reason: ".$reason_label." \n";					
			$body .= "Other Reason: ".$reason." \n";					
			$body .= "Address during leave: ".$leave_address." \n\n";	

			$body .="</table>"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 
			

			$ctrFrom = 0;
			$ctrCc = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($Emp_Name);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
					$cc = $row['email_add'];
					$ctrCc++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
				}	
			}
					
			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_email_add($approver2);
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
			// echo $body ; 
			// echo $to.'<br>';
			// echo '<br>';
			// echo $cc.'<br>';
			$php_email = new email();
			// $php_email->send_email("jangeco@pricon.ph", $from, "jangeco@pricon.ph", $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}

	 // send_email_from_approver1();
	function send_email_from_approver1() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$ctr = 0;
		$select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid(7);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$remarks 				= $row['remarks'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_from'];
			$date_absent_to 		= $row['date_to'];
			$no_of_days 			= $row['total_absent_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$other_reason 			= $row['other_reason'];
			$emp_address 			= $row['emp_address'];
			$radio_OthersAdd 		= $row['radio_OthersAdd'];
			$address 				= $row['address'];
			$approver1 				= $row['approver1'];
			$approver2 				= $row['approver2'];
			$disapproved_label 		= $row['disapproved_label'];
			$IS_disapproved_remarks = $row['IS_disapproved_remarks'];
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver1);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver1_name = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver2);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver2_name = $row_app_name['Emp_Name'];
			}

			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}
			
			if($status == 0) {
				$status_str = "Pending";
			} else if($status == 1) {
				$status_str = "Approved"; //IS
			} else if($status == 2) {
				$status_str = "Approved"; //DH
			} else if($status == 3) {
				$status_str = "Conformed"; //HRD
			} else if($status == 4) {
				$status_str = "For Revision";
			} else if($status == 5) {
				$status_str = "Disapproved"; //IS
			} else if($status == 6) {
				$status_str = "Disapproved"; //DH
			} else if($status == 7) {
				$status_str = "Draft"; //DH
			} else if($status == 8) {
				$status_str = "Cancelled"; //DH
			} 
			
			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
			
			if($approver1 == 0) {
				$IS_approver = "N/A";
			} else {
				$IS_approver 	= $row['approver1'];
			} 
			
			if($emp_address == 'N/A') {
				$leave_address 	= $row['address'];
			} else {
				$leave_address 	= $row['emp_address'];
			} 
			
			if($disapproved_label == 1) {
				$disapproved_status = "Late Filing";
			} else if($disapproved_label == 2) {
				$disapproved_status  = "Unauthorized";
			} else if($disapproved_label == '') {
				$disapproved_status  = "N/A";
			}
			
			if($IS_disapproved_remarks == '') {
				$IS_remarks = "N/A";
			} else {
				$IS_remarks 	= $row['IS_disapproved_remarks'];
			} 
			
			if($other_reason == '0') {
				$reason_label 	= 'N/A';
			} else if($other_reason == '1') {
				$reason_label 	= 'Shut-down';
			} else if($other_reason == '2') {
				$reason_label 	= 'Special Non-working Holiday';
			} else if($other_reason == '3') {
				$reason_label 	= 'Others';
			}
			
			$subject = "ELFS - Leave Application Approval";
			$body .= "Good day!\n\n";
			$body .= "Please be informed that Leave Application has been ".$status_str." by ".$approver1_name." <i>(Immediate Superior)</i> and waiting for your approval. \n </i>";
			$body .= "Please log on to your systemone account.\n";
			$body .= "Go to http://systemone \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Employee Name: ".$employee_name." \n";
			$body .= "Employee No.: ".$EmpNo." \n";
			$body .= "Division: ".$Division." \n";
			
			$body .= "Leave Applied: <b>".$type_leave_applied."</b> \n";
			$body .= "Date Absent: ".date('M d, Y',strtotime($date_absent_from))." - ".date('M d, Y',strtotime($date_absent_to))."\n";
			$body .= "No of Days: ".$no_of_days."\n";
			$body .= "Reason: ".$reason_label." \n";					
			$body .= "Other Reason: ".$reason." \n";					
			$body .= "Address during leave: ".$leave_address." \n";	
			
			$body .= "------------------------------------------------------------------------------\n";
			$body .= "Disapproved Status: ".$disapproved_status." \n";	
			$body .= "Disapproved Remarks: ".$IS_remarks." \n";	

			$body .="</table>"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 

			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_email_add($approver2); // cc employee
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
			$ctrFrom = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($approver1);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
					$cc = $row['email_add'];
					$ctrCc++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
				}	
			}
			
			$ctrCc = 0;
			$select_query_cc = ELFS::getInstance()->select_email_add($Emp_Name);
			while($row = mysqli_fetch_array($select_query_cc)) {
				$cc .= "," . $row['email_add'];
				$ctrCc++;	
			}		
			
			// echo $body ; 
			// echo $to.'<br>';
			// echo '<br>';
			// echo $cc.'<br>';
			$php_email = new email();
			// $php_email->send_email("jangeco@pricon.ph", $from, "jangeco@pricon.ph", $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}
	
	// send_email_from_approver2();
	function send_email_from_approver2() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$ctr = 0;
		$select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid(7);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$remarks 				= $row['remarks'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_from'];
			$date_absent_to 		= $row['date_to'];
			$no_of_days 			= $row['total_absent_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$other_reason 			= $row['other_reason'];
			$emp_address 			= $row['emp_address'];
			$radio_OthersAdd 		= $row['radio_OthersAdd'];
			$address 				= $row['address'];
			$approver1 				= $row['approver1'];
			$approver2 				= $row['approver2'];
			$conformedby 			= $row['conformedby'];
			$disapproved_label 		= $row['disapproved_label'];
			$IS_disapproved_remarks = $row['IS_disapproved_remarks'];
			$DH_disapproved_remarks = $row['DH_disapproved_remarks'];

			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver1);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver1_name = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver2);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver2_name = $row_app_name['Emp_Name'];
			}

			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}
			
			if($status == 0) {
				$status_str = "Pending";
			} else if($status == 1) {
				$status_str = "Approved"; //IS
			} else if($status == 2) {
				$status_str = "Approved"; //DH
			} else if($status == 3) {
				$status_str = "Conformed"; //HRD
			} else if($status == 4) {
				$status_str = "For Revision";
			} else if($status == 5) {
				$status_str = "Disapproved"; //IS
			} else if($status == 6) {
				$status_str = "Disapproved"; //DH
			} else if($status == 7) {
				$status_str = "Draft"; //DH
			} else if($status == 8) {
				$status_str = "Cancelled"; //DH
			} 
			
			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
			
			if($emp_address == 'N/A') {
				$leave_address 	= $row['address'];
			} else {
				$leave_address 	= $row['emp_address'];
			} 
			
			if($disapproved_label == 3) {
				$disapproved_status = "Late Filing";
			} else if($disapproved_label == 4) {
				$disapproved_status  = "Unauthorized";
			} else if($disapproved_label == '') {
				$disapproved_status  = "N/A";
			}
			
			if($DH_disapproved_remarks == '') {
				$DH_remarks = "N/A";
			} else {
				$DH_remarks 	= $row['DH_disapproved_remarks'];
			} 
			
			if($other_reason == '0') {
				$reason_label 	= 'N/A';
			} else if($other_reason == '1') {
				$reason_label 	= 'Shut-down';
			} else if($other_reason == '2') {
				$reason_label 	= 'Special Non-working Holiday';
			} else if($other_reason == '3') {
				$reason_label 	= 'Others';
			}
			
			$subject = "ELFS - Leave Application for Conformance";
			$body .= "Good day!\n\n";
			// $body .= "You have Leave Application waiting for your conformance. \n";
			$body .= "Please be informed that Leave Application has been ".$status_str." by ".$approver2_name." <i>(Sec/Dept. Head)</i> and waiting for your conformance. \n </i>";
			$body .= "Please log on to your systemone account.\n";
			$body .= "Go to http://systemone \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Employee Name: ".$employee_name." \n";
			$body .= "Employee No.: ".$EmpNo." \n";
			$body .= "Division: ".$Division." \n";
			
			$body .= "Leave Applied: <b>".$type_leave_applied."</b> \n";
			$body .= "Date Absent: ".date('M d, Y',strtotime($date_absent_from))." - ".date('M d, Y',strtotime($date_absent_to))."\n";
			$body .= "No of Days: ".$no_of_days."\n";
			$body .= "Reason: ".$reason_label." \n";					
			$body .= "Other Reason: ".$reason." \n";					
			$body .= "Address during leave: ".$leave_address." \n";	
			
			$body .= "------------------------------------------------------------------------------\n";
			$body .= "Disapproved Status: ".$disapproved_status." \n";	
			$body .= "Disapproved Remarks: ".$DH_remarks." \n";	

					
			$body .="</table>"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 
			
			
			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_hrd_recipients();
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
			$ctrFrom = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($approver2);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
					$cc = $row['email_add'];
					$ctrCc++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
				}	
			}
			
			$ctrCc = 0;
			$select_query_cc = ELFS::getInstance()->select_email_add($Emp_Name);
			while($row = mysqli_fetch_array($select_query_cc)) {
				$cc .= "," . $row['email_add'];
				$ctrCc++;	
			}	
			
			echo $body ; 
			echo $to.'<br>';
			echo '<br>';
			echo $cc.'<br>';
			$php_email = new email();
			// $php_email->send_email("jangeco@pricon.ph", $from, $cc, $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}
	
	// send_email_from_hrd();
	function send_email_from_hrd() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$ctr = 0;
		$select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid(7);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$remarks 				= $row['remarks'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_from'];
			$date_absent_to 		= $row['date_to'];
			$no_of_days 			= $row['total_absent_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$other_reason 			= $row['other_reason'];
			$emp_address 			= $row['emp_address'];
			$radio_OthersAdd 		= $row['radio_OthersAdd'];
			$address 				= $row['address'];
			$approver1 				= $row['approver1'];
			$approver2 				= $row['approver2'];
			$conformedby 			= $row['conformedby'];
			$username 				= $row['username'];
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver1);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver1_name = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver2);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver2_name = $row_app_name['Emp_Name'];
			}

			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}
			
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($username);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$hrd_name = $row_emp_name['Emp_Name'];
			}
		
			if($status == 3) {
				$status_str = "Conformed"; //HRD
			}
			
			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
			
			if($emp_address == 'N/A') {
				$leave_address 	= $row['address'];
			} else {
				$leave_address 	= $row['emp_address'];
			} 
			
			if($other_reason == '0') {
				$reason_label 	= 'N/A';
			} else if($other_reason == '1') {
				$reason_label 	= 'Shut-down';
			} else if($other_reason == '2') {
				$reason_label 	= 'Special Non-working Holiday';
			} else if($other_reason == '3') {
				$reason_label 	= 'Others';
			}
			
			$subject = "ELFS - Leave Application (".$status_str.") ";
			$body .= "Good day!\n\n";
			$body .= "Please be informed that Leave Application has been ".$status_str." by ".$hrd_name.". \n </i>";
			// $body .= "Please be informed that Leave Application has been ".$status_str." by Maria Boncayao \n </i>";
			$body .= "Please log on to your systemone account.\n";
			$body .= "Go to http://systemone \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Employee Name: ".$employee_name." \n";
			$body .= "Employee No.: ".$EmpNo." \n";
			$body .= "Division: ".$Division." \n";
			
			$body .= "Leave Applied: <b>".$type_leave_applied."</b> \n";
			$body .= "Date Absent: ".date('M d, Y',strtotime($date_absent_from))." - ".date('M d, Y',strtotime($date_absent_to))."\n";
			$body .= "No of Days: ".$no_of_days."\n";
			$body .= "Reason: ".$reason_label." \n";					
			$body .= "Other Reason: ".$reason." \n";					
			$body .= "Address during leave: ".$leave_address." \n";	
			
			$body .="</table>"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 

			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_email_add($Emp_Name); 
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
		
			$ctrFrom = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($username);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
					$cc = $row['email_add'];
					$ctrCc++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
				}	
			}
			
			$ctrCc = 0;
			$select_query_cc = ELFS::getInstance()->select_email_add($approver1);
			while($row = mysqli_fetch_array($select_query_cc)) {
				$cc .= "," . $row['email_add'];
				$ctrCc++;					
			}	
			
			$ctrCc = 0;
			$select_query_cc = ELFS::getInstance()->select_email_add($approver2);
			while($row = mysqli_fetch_array($select_query_cc)) {
				$cc .= "," . $row['email_add'];
				$ctrCc++;					
			}				
			
			// echo $body ; 
			// echo $to.'<br>';
			// echo '<br>';
			// echo $cc.'<br>';
			$php_email = new email();
			// $php_email->send_email("jangeco@pricon.ph", $from, "jangeco@pricon.ph", $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}
	
	// send_email_from_hrd_revise();
	function send_email_from_hrd_revise() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$ctr = 0;
		$select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid(7);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$remarks 				= $row['remarks'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_from'];
			$date_absent_to 		= $row['date_to'];
			$no_of_days 			= $row['total_absent_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$other_reason 			= $row['other_reason'];
			$emp_address 			= $row['emp_address'];
			$radio_OthersAdd 		= $row['radio_OthersAdd'];
			$address 				= $row['address'];
			$approver1 				= $row['approver1'];
			$approver2 				= $row['approver2'];
			$HR_revised_remarks 	= $row['HR_revised_remarks'];
			$username 				= $row['username'];
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver1);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver1_name = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver2);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver2_name = $row_app_name['Emp_Name'];
			}

			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}
			
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($username);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$hrd_name = $row_emp_name['Emp_Name'];
			}
		
			if($status == 0) {
				$status_str = "Pending";
			} else if($status == 1) {
				$status_str = "Approved"; //IS
			} else if($status == 2) {
				$status_str = "Approved"; //DH
			} else if($status == 3) {
				$status_str = "Conformed"; //HRD
			} else if($status == 4) {
				$status_str = "For Revision";
			} else if($status == 5) {
				$status_str = "Disapproved"; //IS
			} else if($status == 6) {
				$status_str = "Disapproved"; //DH
			} else if($status == 7) {
				$status_str = "Draft"; //DH
			} else if($status == 8) {
				$status_str = "Cancelled by Employee"; //DH
			} else if($status == 9) {
				$status_str = "Cancelled by HR"; //DH
			} 

			
			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
			
			if($emp_address == 'N/A') {
				$leave_address 	= $row['address'];
			} else {
				$leave_address 	= $row['emp_address'];
			} 
			
			if($other_reason == '0') {
				$reason_label 	= 'N/A';
			} else if($other_reason == '1') {
				$reason_label 	= 'Shut-down';
			} else if($other_reason == '2') {
				$reason_label 	= 'Special Non-working Holiday';
			} else if($other_reason == '3') {
				$reason_label 	= 'Others';
			}
			
			$subject = "ELFS - Leave Application (".$status_str.") ";
			$body .= "Good day!\n\n";
			$body .= "Please be informed that Leave Application is ".$status_str.". \n </i>";
			$body .= "Please log on to your systemone account.\n";
			$body .= "Go to http://systemone \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Employee Name: ".$employee_name." \n";
			$body .= "Employee No.: ".$EmpNo." \n";
			$body .= "Division: ".$Division." \n";
			
			$body .= "Leave Applied: <b>".$type_leave_applied."</b> \n";
			$body .= "Date Absent: ".date('M d, Y',strtotime($date_absent_from))." - ".date('M d, Y',strtotime($date_absent_to))."\n";
			$body .= "No of Days: ".$no_of_days."\n";
			$body .= "Reason: ".$reason_label." \n";					
			$body .= "Other Reason: ".$reason." \n";					
			$body .= "Address during leave: ".$leave_address." \n";	
			
			$body .= "------------------------------------------------------------------------------\n";
			$body .= "Revision remarks: <b>".$HR_revised_remarks."</b> \n\n\n";
			
			$body .="</table>"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 

			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_email_add($Emp_Name); 
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
			
			$ctrFrom = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($username);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
					$cc = $row['email_add'];
					$ctrCc++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
				}	
			}
			
			$ctrCc = 0;
			$select_query_cc = ELFS::getInstance()->select_email_add($approver1);
			while($row = mysqli_fetch_array($select_query_cc)) {
				$cc .= "," . $row['email_add'];
				$ctrCc++;					
			}	
			
			$ctrCc = 0;
			$select_query_cc = ELFS::getInstance()->select_email_add($approver2);
			while($row = mysqli_fetch_array($select_query_cc)) {
				$cc .= "," . $row['email_add'];
				$ctrCc++;					
			}				
			
			// echo $body ; 
			// echo $to.'<br>';
			// echo '<br>';
			// echo $cc.'<br>';
			$php_email = new email();
			// $php_email->send_email("jangeco@pricon.ph", $from, "jangeco@pricon.ph", $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}
	
	// send_email_from_hrd_cancelled();
	function send_email_from_hrd_cancelled() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$ctr = 0;
		$select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid(7);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$remarks 				= $row['remarks'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_from'];
			$date_absent_to 		= $row['date_to'];
			$no_of_days 			= $row['total_absent_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$other_reason 			= $row['other_reason'];
			$emp_address 			= $row['emp_address'];
			$radio_OthersAdd 		= $row['radio_OthersAdd'];
			$address 				= $row['address'];
			$approver1 				= $row['approver1'];
			$approver2 				= $row['approver2'];
			$HR_cancel_remarks 		= $row['HR_cancel_remarks'];
			$username 				= $row['username'];
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver1);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver1_name = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver2);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver2_name = $row_app_name['Emp_Name'];
			}

			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}
			
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($username);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$hrd_name = $row_emp_name['Emp_Name'];
			}
			
			if($status == 9) {
				$status_str = "Cancelled by HRD"; //by HR
			} 
			
			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
			
			if($emp_address == 'N/A') {
				$leave_address 	= $row['address'];
			} else {
				$leave_address 	= $row['emp_address'];
			} 
			
			if($other_reason == '0') {
				$reason_label 	= 'N/A';
			} else if($other_reason == '1') {
				$reason_label 	= 'Shut-down';
			} else if($other_reason == '2') {
				$reason_label 	= 'Special Non-working Holiday';
			} else if($other_reason == '3') {
				$reason_label 	= 'Others';
			}
			
			$subject = "ELFS - Leave Application (".$status_str.") ";
			$body .= "Good day!\n\n";
			$body .= "Please be informed that Leave Application has been <b>".$status_str.".</b> \n </i>";
			$body .= "Please log on to your systemone account for more details.\n";
			$body .= "Go to http://systemone \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Employee Name: ".$employee_name." \n";
			$body .= "Employee No.: ".$EmpNo." \n";
			$body .= "Division: ".$Division." \n";
			
			$body .= "Leave Applied: <b>".$type_leave_applied."</b> \n";
			$body .= "Date Absent: ".date('M d, Y',strtotime($date_absent_from))." - ".date('M d, Y',strtotime($date_absent_to))."\n";
			$body .= "No of Days: ".$no_of_days."\n";
			$body .= "Reason: ".$reason_label." \n";					
			$body .= "Other Reason: ".$reason." \n";					
			$body .= "Address during leave: ".$leave_address." \n";	
			
			$body .= "------------------------------------------------------------------------------\n";
			$body .= "Cancelled remarks: <b>".$HR_cancel_remarks."</b> \n\n\n";
			
			$body .="</table>"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 

			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_email_add($Emp_Name); 
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
			$ctrCc = 0;
			$ctrFrom = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($username);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
					$cc = $row['email_add'];
					$ctrCc++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
					

				}	
			}
			
			$select_query_cc = ELFS::getInstance()->select_email_add($approver1);
			while($row = mysqli_fetch_array($select_query_cc)) {
				$cc .= "," . $row['email_add'];
				$ctrCc++;					
			}	

			$select_query_cc = ELFS::getInstance()->select_email_add($approver2);
			while($row = mysqli_fetch_array($select_query_cc)) {
				$cc .= "," . $row['email_add'];
				$ctrCc++;					
			}				
			
			// echo $body ; 
			// echo $to.'<br>';
			// echo '<br>';
			// echo $cc.'<br>';
			$php_email = new email();
			// $php_email->send_email("jangeco@pricon.ph", $from, "jangeco@pricon.ph", $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}
	
	/* // send_email_revise_for_approval();
	function send_email_revise_for_approval() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$ctr = 0;
		$select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid(3);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$remarks 				= $row['remarks'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_absent_from'];
			$date_absent_to 		= $row['date_absent_to'];
			$no_of_days 			= $row['no_of_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$emp_address 			= $row['emp_address'];
			$radio_OthersAdd 		= $row['radio_OthersAdd'];
			$address 				= $row['address'];
			$approver1 				= $row['approver1'];
			$approver2 				= $row['approver2'];
			$conformedby 			= $row['conformedby'];
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver1);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver1_name = $row_app_name['Emp_Name'];
			}
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}

			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
			
			$subject = "ELFS - Leave Application Approval";
			$body .= "Good day!\n\n";
			$body .= "You have Revise Leave Application waiting for your approval. \n";
			$body .= "Please log on to your systemone account for more details.\n";
			$body .= "Go to http://systemone \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Employee Name: ".$employee_name." \n";
			$body .= "Employee No. : ".$EmpNo." \n";
			$body .= "Leave Applied: <b>".$type_leave_applied."</b> \n";
			$body .= "Reason/s: ".$reason." \n\n";

			$ctrFrom = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($Emp_Name);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
				}	
			}
					
			$body .="</table>"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 

			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_email_add($approver1);
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
			echo $body;
			$php_email = new email();
			// $php_email->send_email("jangeco@pricon.ph", $from, "jangeco@pricon.ph", $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}
	 */
	 
	// send_email_cancelled_leave();
	function send_email_cancelled_leave() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$ctr = 0;
		$select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_leave_info_by_pkid(7);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$remarks 				= $row['remarks'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_from'];
			$date_absent_to 		= $row['date_to'];
			$no_of_days 			= $row['total_absent_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$other_reason 			= $row['other_reason'];
			$emp_address 			= $row['emp_address'];
			$radio_OthersAdd 		= $row['radio_OthersAdd'];
			$address 				= $row['address'];
			$approver1 				= $row['approver1'];
			$approver2 				= $row['approver2'];
			$conformedby 			= $row['conformedby'];
			$Cancelled_remarks		= $row['Cancelled_remarks'];
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver1);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver1_name = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver2);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver2_name = $row_app_name['Emp_Name'];
			}
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}

			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
			
			if($status == 8) {
				$status_str = "Cancelled";
			} 
			
			if($emp_address == 'N/A') {
				$leave_address 	= $row['address'];
			} else {
				$leave_address 	= $row['emp_address'];
			} 
			
			if($other_reason == '0') {
				$reason_label 	= 'N/A';
			} else if($other_reason == '1') {
				$reason_label 	= 'Shut-down';
			} else if($other_reason == '2') {
				$reason_label 	= 'Special Non-working Holiday';
			} else if($other_reason == '3') {
				$reason_label 	= 'Others';
			}
			
			$subject = "ELFS - Cancelled Leave Application";
			$body .= "Good day!\n\n";
			$body .= "Please be informed that Leave Application has been Cancelled. \n";
			$body .= "Please log on to your systemone account for more details.\n";
			$body .= "Go to http://systemone \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Employee Name: ".$employee_name." \n";
			$body .= "Employee No.: ".$EmpNo." \n";
			$body .= "Division: ".$Division." \n";
			
			$body .= "Leave Applied: <b>".$type_leave_applied."</b> \n";
			$body .= "Date Absent: ".date('M d, Y',strtotime($date_absent_from))." - ".date('M d, Y',strtotime($date_absent_to))."\n";
			$body .= "No of Days: ".$no_of_days."\n";
			$body .= "Reason: ".$reason_label." \n";					
			$body .= "Other Reason: ".$reason." \n";					
			$body .= "Address during leave: ".$leave_address." \n";	

			$body .= "------------------------------------------------------------------------------\n";
			$body .= "Cancelled Remarks: <b>".$Cancelled_remarks."</b> \n";
			
			$body .="</table>"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 


			$ctrFrom = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($Emp_Name);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
					$cc = $row['email_add'];
					$ctrCc++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
				}	
			}
					
			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_email_add($approver1);
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
			// echo $body ; 
			// echo $to.'<br>';
			// echo '<br>';
			// echo $cc.'<br>';
			$php_email = new email();
			// $php_email->send_email("jangeco@pricon.ph", $from, "jangeco@pricon.ph", $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}
	
	//update_Leave_balance
	function update_Leave_balance(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->update_Leave_balance($return['pkid'],
					$return['regularity_date'],
					$return['previous_balance_VL'],
					$return['credit_VL'],
					$return['current_avail_VL'],
					$return['total_VL_used'],
					$return['total_VL_balance'],
					$return['previous_balance_SL'],
					$return['credit_SL'],
					$return['current_avail_SL'],
					$return['total_SL_used'],
					$return['total_SL_balance']);
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//select_leave_balance_info
	function select_leave_balance_info() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$ctr = 0;
		$result = "";
		$result = ELFS::getInstance()->select_leave_balance_info($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['EmpNo'][$ctr]				    = $row['EmpNo'];
			$return['fkEmployee'][$ctr]				= $row['fkEmployee'];
			$return['empName'][$ctr]				= $row['empName'];
			$return['regularity_date'][$ctr]		= $row['regularity_date'];
			
			$return['previous_balance_VL'][$ctr]	= $row['previous_balance_VL'];
			$return['credit_VL'][$ctr]				= $row['credit_VL'];
			$return['current_avail_VL'][$ctr]		= $row['current_avail_VL'];
			$return['total_VL_used'][$ctr]			= $row['total_VL_used'];
			$return['total_VL_balance'][$ctr]		= $row['total_VL_balance'];
		
			$return['previous_balance_SL'][$ctr]	= $row['previous_balance_SL'];
			$return['credit_SL'][$ctr]				= $row['credit_SL'];
			$return['current_avail_SL'][$ctr]		= $row['current_avail_SL'];
			$return['total_SL_used'][$ctr]			= $row['total_SL_used'];
			$return['total_SL_balance'][$ctr]		= $row['total_SL_balance'];

			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//View Emp Leave
	function select_view_emp_leave() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = ELFS::getInstance()->select_view_emp_leave($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['status'] 			= $row['status'];
			$return['leave_applied'] 	= $row['leave_applied'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//select_batch_dates
	function select_batch_dates() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = ELFS::getInstance()->select_batch_dates($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['status'] 			= $row['status'];
			$return['leave_applied'] 	= $row['leave_applied'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	// get_edit_leave_dates_summary ();
	function get_edit_leave_dates_summary() {
		require_once("elfs_oop.php");
		$p = $_POST;
		$return = array();
		$result = ELFS::getInstance()->get_edit_leave_dates_summary($p['pkid']);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 				= $row['pkid'];
			$return['status'][$ctr] 			= $row['status'];
			$return['date_created'][$ctr] 		= $row['date_created'];
			$return['empName'][$ctr] 			= $row['empName'];
			$return['FirstName'][$ctr] 			= $row['FirstName'];
			$return['LastName'][$ctr] 			= $row['LastName'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['Division'][$ctr] 			= $row['Division'];
			$return['leave_applied'][$ctr] 		= $row['leave_applied'];
			$return['reason'][$ctr] 			= $row['reason'];
			$return['pkid_leave_date'][$ctr] 	= $row['pkid_leave_date'];
			$return['date_absent_from'][$ctr] 	= date('F d, Y',strtotime($row['date_absent_from']));
			$return['date_absent_to'][$ctr] 	= date('F d, Y',strtotime($row['date_absent_to']));
			$return['no_of_days'][$ctr] 		= $row['no_of_days'];
			$return['no_of_paid'][$ctr] 		= $row['no_of_paid'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		// $return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// get_remove_leave_dates_summary ();
	function get_remove_leave_dates_summary() {
		require_once("elfs_oop.php");
		$p = $_POST;
		$return = array();
		$result = ELFS::getInstance()->get_remove_leave_dates_summary($p['pkid']);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 				= $row['pkid'];
			$return['status'][$ctr] 			= $row['status'];
			$return['date_created'][$ctr] 		= $row['date_created'];
			$return['empName'][$ctr] 			= $row['empName'];
			$return['FirstName'][$ctr] 			= $row['FirstName'];
			$return['LastName'][$ctr] 			= $row['LastName'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['Division'][$ctr] 			= $row['Division'];
			$return['leave_applied'][$ctr] 		= $row['leave_applied'];
			$return['day_type'][$ctr] 			= $row['day_type'];
			$return['reason'][$ctr] 			= $row['reason'];
			$return['pkid_leave_date'][$ctr] 	= $row['pkid_leave_date'];
			$return['date_absent_from'][$ctr] 	= date('F d, Y',strtotime($row['date_absent_from']));
			$return['date_absent_to'][$ctr] 	= date('F d, Y',strtotime($row['date_absent_to']));
			$return['no_of_days'][$ctr] 		= $row['no_of_days'];
			$return['no_of_paid'][$ctr] 		= $row['no_of_paid'];
			$return['cutoff_date'][$ctr] 		= $row['cutoff_date'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		// $return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// get_view_leave_dates_summary ();
	function get_view_leave_dates_summary() {
		require_once("elfs_oop.php");
		$p = $_POST;
		$return = array();
		$result = ELFS::getInstance()->get_view_leave_dates_summary($p['pkid']);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 				= $row['pkid'];
			$return['status'][$ctr] 			= $row['status'];
			$return['date_created'][$ctr] 		= $row['date_created'];
			$return['empName'][$ctr] 			= $row['empName'];
			$return['FirstName'][$ctr] 			= $row['FirstName'];
			$return['LastName'][$ctr] 			= $row['LastName'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['Division'][$ctr] 			= $row['Division'];
			$return['leave_applied'][$ctr] 		= $row['leave_applied'];
			$return['reason'][$ctr] 			= $row['reason'];
			$return['pkid_leave_date'][$ctr] 	= $row['pkid_leave_date'];
			$return['date_absent_from'][$ctr] 	= date('F d, Y',strtotime($row['date_absent_from']));
			$return['date_absent_to'][$ctr] 	= date('F d, Y',strtotime($row['date_absent_to']));
			$return['no_of_days'][$ctr] 		= $row['no_of_days'];
			$return['no_of_paid'][$ctr] 		= $row['no_of_paid'];
			$return['cutoff'][$ctr] 			= $row['cutoff'];
			$return['cutoff_month'][$ctr] 		= $row['cutoff_month'];
			$return['cutoff_date'][$ctr] 		= $row['cutoff_date'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		// $return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// select_EmpNo_list_by_pkid ();
	function select_EmpNo_list_by_pkid() {
		require_once("elfs_oop.php");
		$p = $_POST;
		$return = array();
		$result = ELFS::getInstance()->select_EmpNo_list_by_pkid($p['pkid']);
		// $result = ELFS::getInstance()->select_EmpNo_list_by_pkid(811);
		while($row = mysqli_fetch_array($result)){
			$return['pkid'] 		= $row['pkid'];
			$return['EmpNo'] 		= $row['EmpNo'];
			$return['SalaryType'] 	= $row['SalaryType'];
			$return['lastName'] 	= $row['lastName'];
			$return['firstName'] 	= $row['firstName'];
			$return['empName'] 		= $row['empName'];
			$return['username'] 	= $row['username'];
			$return['total_VL_balance'] 	= $row['total_VL_balance'];
			$return['total_SL_balance'] 	= $row['total_SL_balance'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	// AddNewLeaveBalance
	function AddNewLeaveBalance() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->AddNewLeaveBalance(
					$return['fkEmployee'],
					$return['EmpNo'],
					$return['regularity_date'],
					$return['previous_balance_VL'],
					$return['credit_VL'],
					$return['current_avail_VL'],
					$return['total_VL_used'],
					$return['total_VL_balance'],
					$return['previous_balance_SL'],
					$return['credit_SL'],
					$return['current_avail_SL'],
					$return['total_SL_used'],
					$return['total_SL_balance']);

		$return["result"] = json_encode($result);
		echo json_encode($return);
	}	
	
	//Save_leave_as_draft
	function Save_leave_as_draft() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->Save_leave_as_draft(
					$return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['reason'],
					$return['emp_address'],
					$return['radio_OthersAdd'],
					$return['address'],
					$return['approver1'],
					$return['approver2'],
					$return['username']);

		$return["result"] = json_encode($result);
		echo json_encode($return);
	}
	
	//save_updated_leave_record_as_drafts
	function save_updated_leave_record_as_drafts() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->save_updated_leave_record_as_drafts(
					$return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['reason'],
					$return['emp_address'],
					$return['radio_OthersAdd'],
					$return['address'],
					$return['approver1'],
					$return['approver2'],
					$return['username']);

		$return["result"] = json_encode($result);
		echo json_encode($return);
	}

	//savesend_leave_record
	function savesend_leave_record() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->savesend_leave_record(
					$return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['reason'],
					$return['emp_address'],
					$return['radio_OthersAdd'],
					$return['address'],
					$return['approver1'],
					$return['approver2'],
					$return['username']);

		$return["result"] = json_encode($result);
		echo json_encode($return);
	}		

	//Select_leave_record
	function Select_leave_record(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->Select_leave_record($return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['reason'],
					$return['emp_address'],
					$return['radio_OthersAdd'],
					$return['address'],
					$return['approver1'],
					$return['approver2']);
					
		if($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['leave_applied'] 	= $row['leave_applied'];
			$return['approver1'] 		= $row['approver1'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Select_leave_record_for_update
	function Select_leave_record_for_update(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->Select_leave_record_for_update($return['fkEmployee'],
					$return['pkid'],
					$return['status'],
					$return['leave_applied'],
					$return['reason'],
					$return['other_reason'],
					$return['address'],
					$return['approver1'],
					$return['approver2'],
					$return['username']);
					
		if($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['leave_applied'] 	= $row['leave_applied'];
			$return['approver1'] 		= $row['approver1'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Select_leave_as_draft
	function Select_leave_as_draft(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->Select_leave_as_draft($return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['created_by'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['reason'],
					$return['emp_address'],
					$return['radio_OthersAdd'],
					$return['address'],
					$return['approver1'],
					$return['approver2'],
					$return['username']);
					
		if($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['leave_applied'] 	= $row['leave_applied'];
			$return['approver1'] 		= $row['approver1'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//subordinate_for_removal
	function subordinate_for_removal(){
		require_once('elfs_oop.php'); 
		$SectionHead = $_POST['SectionHead'];
		$array_empno = $_POST['array_empno'];
		$return = array();
		$return['html']  = '<table class="table table-bordered">';
		$return['html'] .= '	<thead>';
		$return['html'] .= '		<tr>';
		$return['html'] .= '			<th>EmpNo</th>';
		$return['html'] .= '			<th>Fullname</th>';
		$return['html'] .= '			<th>Division</th>';
		$return['html'] .= '			<th>Department</th>';
		$return['html'] .= '			<th>Section</th>';
		$return['html'] .= '			<th>Position</th>';
		$return['html'] .= '		</tr>';
		$return['html'] .= '	</thead>';
		$return['html'] .= '	<tbody>';
		for($x=0;$x<count($array_empno);$x++){
			$result = "";
			$array_fields = array('*');
			$table 	   	= 'vw_subordinate_list';
			$joins 	   	= '';
			$sql_where 	= 'WHERE `Subordinate` = "'.$array_empno[$x].'" AND `SectionHead` = "'.$SectionHead.'"';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result = ELFS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			while($row = mysqli_fetch_array($result)){
				$return['html'] .= '		<tr>';
				$return['html'] .= '			<td>'.$row['Subordinate'].'</td>';
				$return['html'] .= '			<td>'.$row['FullName'].'</td>';
				$return['html'] .= '			<td>'.$row['Division'].'</td>';
				$return['html'] .= '			<td>'.$row['Department'].'</td>';
				$return['html'] .= '			<td>'.$row['Section'].'</td>';
				$return['html'] .= '			<td>'.$row['Position'].'</td>';
				$return['html'] .= '		</tr>';
			}
		}
		$return['html'] .= '	</tbody>';
		$return['html'] .= '</table>';
		echo json_encode($return);
	}
	
	// update_leave_record();
	function update_leave_record() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->update_leave_record(
					$return['pkid'],
					$return['status'],
					$return['leave_applied'],
					$return['reason'],
					$return['address'],
					$return['approver1'],
					$return['approver2'],
					$return['username']);
												
		$return["result"] = json_encode($result);
		echo json_encode($return);
	}		
	
	// cancelled_leave_application();
	function cancelled_leave_application() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->cancelled_leave_application(
					$return['pkid'],
					$return['status'],
					$return['Cancelled_remarks'],
					$return['username']);
												
		$return["result"] = json_encode($result);
		echo json_encode($return);
	}
	
	// delete_leave_date();
	function delete_leave_date() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->delete_leave_date($return['pkid']);												
		$return["result"] = json_encode($result);
		echo json_encode($return);
	}
	
	//view_leave_dates
	function view_leave_dates() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = ELFS::getInstance()->view_leave_dates($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['pkid'] 				= $row['pkid'];
			$return['fk_leave_app'] 		= $row['fk_leave_app'];
			$return['fk_leave_applied'] 	= $row['fk_leave_applied'];
			$return['date_absent_from'] 	= $row['date_absent_from'];
			$return['date_absent_to'] 		= $row['date_absent_to'];
			$return['no_of_days'] 			= $row['no_of_days'];
			$return['no_of_paid'] 			= $row['no_of_paid'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	// delete_employee();
	function delete_employee() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->delete_employee($return['pkid']);												
		$return["result"] = json_encode($result);
		echo json_encode($return);
	}
	
	//save_updated_leave_date
	function save_updated_leave_date() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->save_updated_leave_date(
					$return['pkid'],
					$return['date_absent_from'],
					$return['date_absent_to'],
					$return['no_of_days']);

		$return["result"] = json_encode($result);
		echo json_encode($return);
	}
	
	// select_AMUp_list_by_pkid ();
	function select_AMUp_list_by_pkid() {
		require_once("elfs_oop.php");
		$p = $_POST;
		$return = array();
		$result = ELFS::getInstance()->select_AMUp_list_by_pkid($p['pkid']);
		// $result = ELFS::getInstance()->select_AMUp_list_by_pkid(811);
		while($row = mysqli_fetch_array($result)){
			$return['pkid'] 		= $row['pkid'];
			$return['amup_username'] 	= $row['amup_username'];
			$return['EmpNo'] 		= $row['EmpNo'];
			$return['Division'] 	= $row['Division'];
			$return['emp_address'] 	= $row['emp_address'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Select_AMUp_leave_as_draft
	function Select_AMUp_leave_as_draft(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->Select_AMUp_leave_as_draft($return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['created_by'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['reason'],
					$return['emp_address'],
					$return['approver1'],
					$return['approver2'],
					$return['username']);
					
		if($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['empName'] 			= $row['empName'];
			$return['created_by'] 		= $row['created_by'];
			$return['EmpNo'] 			= $row['EmpNo'];
			$return['leave_applied'] 	= $row['leave_applied'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
				
/* Batch Leave  */
	// get_batch_employee ();
	function get_batch_employee(){
		require_once("elfs_oop.php");
		$p = $_POST;
		$return = array();
		// $result = ELFS::getInstance()->get_batch_employee($p['SectionHead']);
		$result = ELFS::getInstance()->get_batch_employee($p['pkid']);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 				= $row['pkid'];
			$return['SectionHead '][$ctr] 		= $row['SectionHead'];
			$return['Subordinate'][$ctr] 		= $row['Subordinate'];
			$return['FullName'][$ctr] 			= $row['FullName'];
			$return['Division'][$ctr] 			= $row['Division'];
			$return['Department'][$ctr] 		= $row['Department'];
			$return['Section'][$ctr] 			= $row['Section'];
			$return['Position'][$ctr] 			= $row['Position'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		// $return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// get_batch_employee_list_by_requestor ();
	function get_batch_employee_list_by_requestor() {
		require_once("elfs_oop.php");
		$p = $_POST;
		$return = array();
		$result = ELFS::getInstance()->get_batch_employee_list_by_requestor($p['pkid']);
		// $result = ELFS::getInstance()->get_batch_employee_list_by_requestor(1);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 				= $row['pkid'];
			$return['fkid'][$ctr] 				= $row['fkid'];
			$return['status'][$ctr] 			= $row['status'];
			$return['Subordinate'][$ctr] 		= $row['Subordinate'];
			$return['FullName'][$ctr] 			= $row['FullName'];
			$return['Division'][$ctr] 			= $row['Division'];
			$return['Department'][$ctr] 		= $row['Department'];
			$return['Section'][$ctr] 			= $row['Section'];
			$return['Position'][$ctr] 			= $row['Position'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		// $return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Select_batch_leave
	function Select_batch_leave(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->Select_batch_leave($return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['reason'],
					$return['approver2'],
					$return['day_type'],
					$return['username']);
					
		if($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['leave_applied'] 	= $row['leave_applied'];
			$return['approver2'] 		= $row['approver2'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Select_batch_leave_as_draft
	function Select_batch_leave_as_draft(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->Select_batch_leave_as_draft($return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['created_by'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['reason'],
					$return['approver2'],
					$return['username']);
					
		if($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['created_by'] 		= $row['created_by'];
			$return['EmpNo'] 			= $row['EmpNo'];
			$return['leave_applied'] 	= $row['leave_applied'];
			$return['approver2'] 		= $row['approver2'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Select_batch_leave_record_for_update
	function Select_batch_leave_record_for_update(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->Select_batch_leave_record_for_update($return['fkEmployee'],
					$return['pkid'],
					$return['status'],
					$return['reason'],
					$return['approver2'],
					$return['username']);
					
		if($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['leave_applied'] 	= $row['leave_applied'];
			$return['approver2'] 		= $row['approver2'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Select_leave_emp_batch
	function Select_leave_emp_batch(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->Select_leave_emp_batch($return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['reason'],
					$return['approver']);
					
		if($row = mysqli_fetch_array($result)) {
			$return['pkid'] 			= $row['pkid'];
			$return['leave_applied'] 	= $row['leave_applied'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
		
	//save_leave_batch
	function save_leave_batch() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->save_leave_batch(
					$return['fkEmployee'],
					$return['status'],
					$return['date_created'],
					$return['empName'],
					$return['EmpNo'],
					$return['Division'],
					$return['leave_applied'],
					$return['day_type'],
					$return['reason'],
					$return['approver2'],
					$return['username']);

		$return["result"] = json_encode($result);
		echo json_encode($return);
	}	
	
	// get_leave_batch ();
	function get_leave_batch() {
		require_once("elfs_oop.php");
		$p = $_POST;
		$return = array();
		$result = ELFS::getInstance()->get_leave_batch($p['SectionHead']);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 			= $row['pkid'];
			$return['SectionHead'][$ctr] 	= $row['SectionHead'];
			$return['Subordinate'][$ctr] 	= $row['Subordinate'];
			$return['FullName'][$ctr] 		= $row['FullName'];
			$return['Division'][$ctr] 		= $row['Division'];
			$return['Department'][$ctr] 	= $row['Department'];
			$return['Section'][$ctr] 		= $row['Section'];
			$return['Position'][$ctr] 		= $row['Position'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		// $return['result'] = json_encode($result);
		echo json_encode($return);
	}
		
	// select_leave_batch_info_by_pkid();
	function select_leave_batch_info_by_pkid() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$ctr = 0;
		$result = "";
		// $result = ELFS::getInstance()->select_leave_batch_info_by_pkid(1);
		$result = ELFS::getInstance()->select_leave_batch_info_by_pkid($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['fkEmployee'][$ctr]			= $row['fkEmployee'];
			$return['status'][$ctr]				= $row['status'];
			$return['remarks'][$ctr]			= $row['remarks'];
			$return['date_created'][$ctr]		= $row['date_created'];
			$return['Emp_Name'][$ctr] 			= $row['Emp_Name'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['Division'][$ctr]			= $row['Division'];
			$return['leave_applied'][$ctr]		= $row['leave_applied'];
			$return['date_from'][$ctr]			= $row['date_from'];
			$return['date_to'][$ctr]			= $row['date_to'];
			$return['total_absent_days'][$ctr]	= $row['total_absent_days'];
			$return['no_of_paid'][$ctr]			= $row['no_of_paid'];
			$return['reason'][$ctr]				= $row['reason'];
			$return['approver'][$ctr]			= $row['approver'];			
			$return['username'][$ctr]			= $row['username'];			
			
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($row['empName']);
			if($row_req_name = mysqli_fetch_array($emp_name)) {
				$return['Emp_Name'][$ctr] = $row_req_name['Emp_Name'];
			}		
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['approver']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['approver_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['username']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['hrd_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// select_batch_leave_info_by_pkid();
	function select_batch_leave_info_by_pkid() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$ctr = 0;
		$result = "";
		// $result = ELFS::getInstance()->select_batch_leave_info_by_pkid(1);
		$result = ELFS::getInstance()->select_batch_leave_info_by_pkid($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['fkEmployee'][$ctr]			= $row['fkEmployee'];
			$return['status'][$ctr]				= $row['status'];
			$return['cutoff'][$ctr]				= $row['cutoff'];
			$return['date_created'][$ctr]		= $row['date_created'];
			$return['Emp_Name'][$ctr] 			= $row['Emp_Name'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['Division'][$ctr]			= $row['Division'];
			$return['leave_applied'][$ctr]		= $row['leave_applied'];
			$return['day_type'][$ctr]			= $row['day_type'];
			$return['date_from'][$ctr]			= $row['date_from'];
			$return['date_to'][$ctr]			= $row['date_to'];
			$return['total_absent_days'][$ctr]	= $row['total_absent_days'];
			$return['no_of_paid'][$ctr]			= $row['no_of_paid'];
			$return['reason'][$ctr]				= $row['reason'];
			$return['emp_address'][$ctr]		= $row['emp_address'];
			$return['address'][$ctr]			= $row['address'];
			$return['approver1'][$ctr]			= $row['approver1'];
			$return['approver2'][$ctr]			= $row['approver2'];			
			$return['username'][$ctr]			= $row['username'];			
			
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($row['empName']);
			if($row_req_name = mysqli_fetch_array($emp_name)) {
				$return['Emp_Name'][$ctr] = $row_req_name['Emp_Name'];
			}
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['approver1']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['approver1_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['approver2']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['approver2_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['username']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['hrd_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// batch_show_remarks ();
	function batch_show_remarks() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = ELFS::getInstance()->batch_show_remarks($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['DH_disapproved_remarks'] 		= $row['DH_disapproved_remarks'];
			$return['Cancelled_remarks'] 			= $row['Cancelled_remarks'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// select_batch_emp();
	function select_batch_emp() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$ctr = 0;
		$result = "";
		// $result = ELFS::getInstance()->select_batch_emp(1);
		$result = ELFS::getInstance()->select_batch_emp($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['fkEmployee'][$ctr]			= $row['fkEmployee'];
			$return['status'][$ctr]				= $row['status'];
			$return['date_created'][$ctr]		= $row['date_created'];
			$return['Emp_Name'][$ctr] 			= $row['Emp_Name'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['Division'][$ctr]			= $row['Division'];
			$return['leave_applied'][$ctr]		= $row['leave_applied'];
			$return['day_type'][$ctr]			= $row['day_type'];
			$return['date_from'][$ctr]			= $row['date_from'];
			$return['date_to'][$ctr]			= $row['date_to'];
			$return['total_absent_days'][$ctr]	= $row['total_absent_days'];
			$return['no_of_paid'][$ctr]			= $row['no_of_paid'];
			$return['reason'][$ctr]				= $row['reason'];
			$return['approver2'][$ctr]			= $row['approver2'];			
			$return['username'][$ctr]			= $row['username'];			
			
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($row['empName']);
			if($row_req_name = mysqli_fetch_array($emp_name)) {
				$return['Emp_Name'][$ctr] = $row_req_name['Emp_Name'];
			}
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['approver1']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['approver1_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['approver2']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['approver2_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			
			$app_name = ELFS::getInstance()->select_employee_info_by_username($row['username']);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$return['hrd_name'][$ctr] = $row_app_name['Emp_Name'];
			}
			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	//Update_batch_leave
	function Update_batch_leave() {
		require_once('elfs_oop.php'); 
		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->Update_batch_leave(
					$return['pkid'],
					$return['fkid'],
					$return['status']);
		$return["result"] = json_encode($result);
		echo json_encode($return);
	}
	
	// select_batch_leave_info_for_cancel_by_pkid ();
	function select_batch_leave_info_for_cancel_by_pkid() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$result = "";
		// $result = ELFS::getInstance()->select_batch_leave_info_for_cancel_by_pkid(1);
		$result = ELFS::getInstance()->select_batch_leave_info_for_cancel_by_pkid($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['pkid']					= $row['pkid'];
			$return['fkEmployee']			= $row['fkEmployee'];
			$return['status']				= $row['status'];
			$return['Cancelled_remarks']	= $row['Cancelled_remarks'];
			$return['username']				= $row['username'];			
			
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	function select_employee_name_by_empno(){
		require_once('elfs_oop.php');
		$return = $_POST;
		$result = "";
		$result = ELFS::getInstance()->select_employee_name_by_empno($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			$return['empName'] 		= $row['empName'];
			$return['EmpNo'] 		= $row['EmpNo'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	// send_email_batch_for_approval();
	function send_email_batch_for_approval() {
		require_once('elfs_oop.php');
		require_once('send_email.php');
		$return = $_POST;
		$ctr = 0;
		$select_leave_info = ELFS::getInstance()->select_batch_emp($return['pkid']);
		// $select_leave_info = ELFS::getInstance()->select_batch_emp(2);
		if($row = mysqli_fetch_array($select_leave_info)) {
			$status				 	= $row['status'];
			$date_created 			= $row['date_created'];
			$Emp_Name 				= $row['empName'];
			$EmpNo					= $row['EmpNo'];
			$Division 				= $row['Division'];
			$leave_applied 			= $row['leave_applied'];
			$date_absent_from 		= $row['date_from'];
			$date_absent_to 		= $row['date_to'];
			$no_of_days 			= $row['total_absent_days'];
			$no_of_paid 			= $row['no_of_paid'];
			$reason 				= $row['reason'];
			$approver2 				= $row['approver2'];
			
		
			$app_name = ELFS::getInstance()->select_employee_info_by_username($approver2);
			if($row_app_name = mysqli_fetch_array($app_name)) {
				$approver2_name = $row_app_name['Emp_Name'];
			}
			
			$emp_name = ELFS::getInstance()->select_employee_info_by_username($Emp_Name);
			if($row_emp_name = mysqli_fetch_array($emp_name)) {
				$employee_name = $row_emp_name['Emp_Name'];
			}
			
			if($leave_applied == 0) {
				$type_leave_applied = "Sick Leave";
			} else if($leave_applied == 1) {
				$type_leave_applied = "Vacation Leave";
			} else if($leave_applied == 2) {
				$type_leave_applied = "Birthday Leave";
			} else if($leave_applied == 3) {
				$type_leave_applied = "Maternity Leave";
			} else if($leave_applied == 4) {
				$type_leave_applied = "Paternity Leave";
			} else if($leave_applied == 5) {
				$type_leave_applied = "Bereavement Leave";
			} else if($leave_applied == 6) {
				$type_leave_applied = "Solo Parent Leave";
			} 
		
			
			$subject = "ELFS - Mass Leave Application";
			$body .= "Good day!\n\n";
			$body .= "You have Mass Leave Application waiting for your approval. \n";
			$body .= "Please log on to your systemone account.\n";
			$body .= "Go to http://systemone >> <b>Employee Leave File System >> Mass Leave Approver</b>  \n\n";
	
			$body .= "<b>Details of Requests</b> \n";
			$body .= "Date Created: ".date('M d, Y',strtotime($date_created))."\n";
			$body .= "Filed by: ".$employee_name." \n";
			$body .= "Employee No.: ".$EmpNo." \n";
			$body .= "Date Absent: ".date('M d, Y',strtotime($date_absent_from))." - ".date('M d, Y',strtotime($date_absent_to))."\n";
			$body .= "No of Days: ".$no_of_days."\n";
			$body .= "Reason/s: ".$reason." \n\n";					
			$body .= "Employee List: \n";					
			
			$body .= "<table border = '1' class='table' id='tbl_emp_list'>";
			$body .=  "<thead>";
			$body .=  "<tr>";
			$body .=  "<td align='center'>EmpNo.</center></td>";		
			$body .=  "<td align='center'>Employee Name</center></td>";
			// $body .=  "<td align='center'>Division</center></td>";
			$body .=  "<td align='center'>Department</center></td>";
			$body .=  "<td align='center'>Section</center></td>";
			$body .=  "<td align='center'>Position</center></td>";
			$body .="</tr>"; 
			$body .="</thead>"; 			
			
				$result = ELFS::getInstance()->select_batch_emp_list($return['pkid']);
				// $result = ELFS::getInstance()->select_batch_emp_list(2);
				while($row = mysqli_fetch_array($result)) {
					$body .= "<tbody>";
					$body .="<tr>";
					$body .= "<td style='text-align: center; font-size: 13px;' >".$row['Subordinate']."</td>";
					$body .= "<td style='text-align: left; font-size: 13px;' >".$row['FullName']."</td>";
					// $body .= "<td style='text-align: center; font-size: 13px;' >".$row['Division']."</td>";
					$body .= "<td style='text-align: left; font-size: 13px;' >".$row['Department']."</td>";
					$body .= "<td style='text-align: left; font-size: 13px;' >".$row['Section']."</td>";
					$body .= "<td style='text-align: left; font-size: 13px;' >".$row['Position']."</td>";
					$body .= "</tr>";
					$body .= "</tbody>";	
				}
							
			$body .="</table> \n\n"; 
			$body .= "***This is automatically generated by Employee Leave File System. Please do not reply.***\n"; 
			
			
			$ctrFrom = 0;
			$ctrCc = 0;
			$select_query_from = ELFS::getInstance()->select_email_add($Emp_Name);
			while($row = mysqli_fetch_array($select_query_from)) {
				if($ctrFrom == 0) {
					$from = $row['email_add'];
					$ctrFrom++;
					$cc = $row['email_add'];
					$ctrCc++;
				} else {
					$from .= "," . $row['email_add'];
					$ctrFrom++;
				}	
			}
			
			$ctrTo = 0;
			$select_query_to = ELFS::getInstance()->select_email_add($approver2);
			while($row = mysqli_fetch_array($select_query_to)) {
				if($ctrTo == 0) {
					$to = $row['email_add'];
					$ctrTo++;
				} else {
					$to .= "," . $row['email_add'];
					$ctrTo++;
				}	
			}
			
			// echo $body ; 
			// echo $to.'<br>';
			// echo '<br>';
			// echo $cc.'<br>';
			$php_email = new email();
			// $php_email->send_email("jangeco@pricon.ph", "jangeco@pricon.ph", "jangeco@pricon.ph", $subject, $body);
			$msg = $php_email->send_email($to, $from, $cc, $subject, $body);
			$return['msg'] = $msg;
			$return['result'] = json_encode($result);
			echo json_encode($return);
		}
	}
	
	function get_empno_info(){

		require_once('elfs_oop.php');

		$return 		= $_POST;
		$pattern 		= $_POST['pattern'];
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_EmployeeInfo';
		$joins 	   		= '';
		$sql_where 		= 'WHERE EmpNo LIKE "%'.$pattern.'%" and EmpStatus = "1"';
		$sql_order 		= '';
		$sql_limit 		= 'LIMIT 0,10';
		$result 		= ELFS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		if (!$result) {
			echo mysql_error();
		}

		$ctr = 0;

		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 			= $row['pkid'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['LastName'][$ctr] 			= $row['LastName'];
			$return['FirstName'][$ctr] 			= $row['FirstName'];
			$ctr++;
		}

		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);

	}
	
	function check_empno_details(){

		require_once('elfs_oop.php');

		$result 		= '';
		$return 		= $_POST;
		$array_fields	= array('*');
		// $table			= 'vw_pminaa';
		$table			= 'vw_detailed_info';
		$sql_where		= "WHERE EmpNo = '".$return['empno']."' AND EmpStatus = '1' ";
		$joins			= '';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 1';
		$result			= ELFS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);

		if(!$result){
			echo mysql_error();
		}

		$ctr = 0;

		while($row = mysqli_fetch_array($result)){
		$return['pkid'][$ctr]					= $row['pkid'];
		$return['username'][$ctr]				= $row['username'];
		$return['LastName'][$ctr]				= $row['LastName'];
		$return['FirstName'][$ctr]				= $row['FirstName'];
		$return['CityAddress1'][$ctr]			= $row['CityAddress1'];
		$return['CityAddress2'][$ctr]			= $row['CityAddress2'];
		$return['CityAddress3'][$ctr]			= $row['CityAddress3'];
		$return['Division'][$ctr]				= $row['Division'];

		$ctr++;
		}

		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}

	function getsechead(){

		require_once('elfs_oop.php');

		$return 		= $_POST;
		$pattern 		= $_POST['pattern'];
		$result 		= '';
		$array_fields 	= array('*');
		// $table 	   		= 'vw_secheads';
		$table 	   		= 'vw_employee';
		$joins 	   		= '';
		$sql_where 		= 'WHERE fullname LIKE "%'.$pattern.'%"';
		$sql_order 		= '';
		$sql_limit 		= 'LIMIT 0,10';
		$result 		= ELFS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// $script 		= ELFS::getInstance()->select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);

		if (!$result) {
			echo mysql_error();
		}

		$ctr = 0;

		if($pattern == ""){
			$return['pkid'][$ctr] 			= '';
			$return['username'][$ctr] 		= '';
			$return['email_add'][$ctr] 		= '';
			$return['fullname'][$ctr] 		= '';
			$return['EmpNo'][$ctr] 			= '';
		}else{
			while($row = mysqli_fetch_array($result)){
				$return['pkid'][$ctr] 			= $row['pkid'];
				$return['username'][$ctr] 		= $row['username'];
				$return['email_add'][$ctr] 		= $row['email_add'];
				$return['fullname'][$ctr] 		= $row['fullname'];
				$return['EmpNo'][$ctr] 			= $row['EmpNo'];
				$ctr++;
			}
		}


		$return['ctr']	  = $ctr;
		$return['script'] = $script;
		$return['result'] = json_encode($result);
		echo json_encode($return);

	}
	
	function getdepthead(){

		require_once('elfs_oop.php');

		$return 		= $_POST;
		$pattern 		= $_POST['pattern'];
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'vw_secheads';
		$joins 	   		= '';
		$sql_where 		= 'WHERE fullname LIKE "%'.$pattern.'%"';
		$sql_order 		= '';
		$sql_limit 		= 'LIMIT 0,10';
		$result 		= ELFS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		if (!$result) {
			echo mysql_error();
		}

		$ctr = 0;

		if($pattern == ""){
			$return['pkid'][$ctr] 			= '';
			$return['username'][$ctr] 		= '';
			$return['email_add'][$ctr] 		= '';
			$return['fullname'][$ctr] 		= '';
			$return['EmpNo'][$ctr] 			= '';
		}else{
			while($row = mysqli_fetch_array($result)){
				$return['pkid'][$ctr] 			= $row['pkid'];
				$return['username'][$ctr] 		= $row['username'];
				$return['email_add'][$ctr] 		= $row['email_add'];
				$return['fullname'][$ctr] 		= $row['fullname'];
				$return['EmpNo'][$ctr] 			= $row['EmpNo'];
				$ctr++;
			}
		}

		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		 
	}
	
	// 11/2/2017
	
	function select_leave_conversion_info() {
		require_once("elfs_oop.php");
		$return = $_POST;
		$ctr = 0;
		$result = "";
		$result = ELFS::getInstance()->select_leave_conversion_info($return['pkid']);
		while($row = mysqli_fetch_array($result)) {
			
			$return['EmpNo'][$ctr]				= $row['EmpNo'];
			$return['fkEmployee'][$ctr]			= $row['fkEmployee'];
			$return['empName'][$ctr]			= $row['empName'];
			$return['date_conversion'][$ctr]	= $row['date_conversion'];
			$return['vl_balance'][$ctr]			= $row['vl_balance'];
			$return['vl_convertible'][$ctr]		= $row['vl_convertible'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function update_leave_conversion(){
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = ELFS::getInstance()->update_leave_conversion($return['pkid'],
					$return['vl_balance'],
					$return['vl_convertible']);
					$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function add_new_leave_conversion() {
		require_once('elfs_oop.php'); 
		
		$lastupdate 	= date("Y-m-d H:i:s");

		$return = $_POST; 
		$result = "";
		$result = ELFS::getInstance()->add_new_leave_conversion(
					$return['fkEmployee'],
					$return['EmpNo'],
					$return['username'],
					$return['empName'],
					$return['SalaryType'],
					$return['date_conversion'],
					$return['vl_balance'],
					$return['vl_convertible'],
					$lastupdate);
		$return["result"] = json_encode($result);
		echo json_encode($return);
	}	

	/**
	 * Check if the Leave Date(date_absent_from) is already existed by its employee id
	 * Added by whyRainbowDoesntHaveBlack
	 * 09-04-2024
	 */
	function checkIfLeaveDateIsExisted() {
		require_once('elfs_oop.php'); 
		$return = $_POST;
		$result = "";
		$dateAbsentTo = date_create($return['date_absent_from']);
		$dateAbsentToFormatted = date_format($dateAbsentTo,"Y-m-d");
		$result = ELFS::getInstance()->checkIfLeaveDateIsExisted($return['EmpNo'], $dateAbsentToFormatted);
		$return["data"] = mysqli_fetch_array($result);
		echo json_encode($return);
	}
	
?>