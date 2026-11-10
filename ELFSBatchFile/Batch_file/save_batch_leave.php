<?php
include('db_hris.php');

		$fkEmployee 		= $_POST['fkEmployee'];
		$status 			= $_POST['status'];
		$date_created 		= $_POST['date_created'];
		$empName			= $_POST['username'];
		$EmpNo				= $_POST['EmpNo'];				
		$Division			= $_POST['Division'];				
		$leave_applied		= $_POST['leave_applied'];
		$reason				= mysql_real_escape_string($_POST['reason']);
		$approver2			= $_POST['approver2'];
		$day_type			= $_POST['day_type'];
		$username			= $_POST['username'];
		
	$query = "INSERT INTO tbl_leave_application (`fkEmployee`,`status`,`date_created`,`empName`,`EmpNo`,`Division`,`leave_applied`,`reason`,`approver2`,`day_type`,`username`)
			 VALUES ('$fkEmployee','0','$date_created','$empName','$EmpNo','$Division','1','$reason','$approver2','$day_type','$username')";
	mysql_query($query);
	
	$return['query'] = $query;
	
	$query = "SELECT `pkid`, `leave_applied` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"; 
	$result = mysql_query($query);
	while ( $row = mysql_fetch_array($result) ){
	
		$pkid 			= $row['pkid'];
		$leave_applied 	= $row['leave_applied'];
		
	}

	$return['fk_leave_app'] 	= $pkid;
	$return['fk_leave_applied'] = $leave_applied;
	
	 echo json_encode($return);

		
?>

