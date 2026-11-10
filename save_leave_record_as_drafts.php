<?php
include('db_hris.php');

		$fkEmployee 		= $_POST['fkEmployee'];
		$status 			= $_POST['status'];
		$date_created 		= $_POST['date_created'];
		$empName			= $_POST['username'];
		$created_by			= $_POST['username'];
		$EmpNo				= $_POST['EmpNo'];				
		$Division			= $_POST['Division'];				
		$leave_applied		= $_POST['leave_applied'];
		$day_type			= $_POST['day_type'];
		$reason				= mysql_real_escape_string($_POST['reason']);
		$other_reason		= mysql_real_escape_string($_POST['other_reason']);
		$emp_address		= mysql_real_escape_string($_POST['emp_address']);
		$radio_OthersAdd	= $_POST['radio_OthersAdd'];
		$address			= mysql_real_escape_string($_POST['address']);
		$approver1			= $_POST['approver1'];
		$approver2			= $_POST['approver2'];
		$username			= $_POST['username'];
					
	$query = "INSERT INTO tbl_leave_application (`fkEmployee`,`status`,`date_created`,`empName`,`created_by`,`EmpNo`,`Division`,`leave_applied`,`day_type`,`reason`,`other_reason`,`emp_address`,`radio_OthersAdd`,`address`,`approver1`,`approver2`,`username`)
			 VALUES ('$fkEmployee','7','$date_created','$empName','$created_by','$EmpNo','$Division','$leave_applied','$day_type','$reason','$other_reason','$emp_address','$radio_OthersAdd','$address','$approver1','$approver2','$username')";
	mysql_query($query);
	
	$return['query'] = $query;
	
	$query = "SELECT `pkid`, `created_by`, `EmpNo`, `leave_applied`, `approver1` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"; 
	$queryIfLeaveDateExisted = "SELECT * FROM tbl_leave_application INNER JOIN tbl_leave_dates
				ON tbl_leave_application.pkid = tbl_leave_dates.fk_leave_app
				ORDER BY tbl_leave_application.pkid DESC"; 
	$result = mysql_query($query);
	while ( $row = mysql_fetch_array($result) ){
	
		$pkid 			= $row['pkid'];
		$created_by 	= $row['created_by'];
		$EmpNo 			= $row['EmpNo'];
		$leave_applied 	= $row['leave_applied'];
		$approver1 		= $row['approver1'];
		
	}

	$return['fk_leave_app'] 	= $pkid;
	$return['created_by']		= $created_by;
	$return['EmpNo'] 			= $EmpNo;
	$return['fk_leave_applied'] = $leave_applied;
	$return['approver1'] 		= $approver1;

	// $queryIfLeaveDateExisted = "SELECT * FROM tbl_leave_application INNER JOIN tbl_leave_dates
	// 			ON tbl_leave_application.pkid = tbl_leave_dates.fk_leave_app
	// 			ORDER BY tbl_leave_application.pkid DESC"; 
	// $queryIfLeaveDateExisted = "SELECT COUNT(*) AS count FROM tbl_leave_dates WHERE EmpNo = '$_POST['EmpNo']' AND leave_date = ?"; 
	// $resultIfLeaveDateExisted = mysql_query($queryIfLeaveDateExisted);
	// $tempoArray = array();
	// while ( $rowIfLeaveDateExisted = mysql_fetch_array($resultIfLeaveDateExisted) ){
	// 	$innerArray = array(
	// 		$pkid             => $rowIfLeaveDateExisted['pkid'],
	// 		$fkEmployee       => $rowIfLeaveDateExisted['fkEmployee'],
	// 		$date_absent_from => $rowIfLeaveDateExisted['date_absent_from'],
	// 		$fk_leave_app     => $rowIfLeaveDateExisted['fk_leave_app '],
	// 	);
	// 	array_push($tempoArray, $innerArray);
	// }
	// $return['queryIfLeaveDateExisted'] = $tempoArray;

	echo json_encode($return);
?>

