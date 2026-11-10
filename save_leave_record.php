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
		$reason				= mysql_real_escape_string($_POST['reason']);
		$other_reason		= mysql_real_escape_string($_POST['other_reason']);
		$emp_address		= mysql_real_escape_string($_POST['emp_address']);
		$radio_OthersAdd	= $_POST['radio_OthersAdd'];
		$address			= mysql_real_escape_string($_POST['address']);
		$approver1			= $_POST['approver1'];
		$approver2			= $_POST['approver2'];
		$username			= $_POST['username'];
					
	$query = "INSERT INTO tbl_leave_application (`fkEmployee`,`status`,`date_created`,`empName`,`created_by`,`EmpNo`,`Division`,`leave_applied`,`reason`,`other_reason`,`emp_address`,`radio_OthersAdd`,`address`,`approver1`,`approver2`, `username`)
			 VALUES ('$fkEmployee','0','$date_created','$empName','$created_by','$EmpNo','$Division','$leave_applied', '$reason','$other_reason','$emp_address','$radio_OthersAdd','$address','$approver1','$approver2', '$username') ";
		mysql_query($query);
	
	$return['query'] = $query;
	
	$query = "SELECT `pkid`, `leave_applied`, `approver1` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"; 
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
	
	 echo json_encode($return);

		
?>

