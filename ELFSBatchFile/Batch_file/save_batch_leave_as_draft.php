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
		$approver2			= $_POST['approver2'];
		$reason				= $_POST['reason'];
		$username			= $_POST['username'];
					
	$query = "INSERT INTO tbl_batch_leave_application (`fkEmployee`,`status`,`date_created`,`empName`,`created_by`,`EmpNo`,`Division`,`leave_applied`,`day_type`,`approver2`,`reason`,`username`)
			 VALUES ('$fkEmployee','7','$date_created','$empName','$created_by','$EmpNo','$Division','1','$day_type','$approver2','$reason','$username')";
	mysql_query($query);
	
	$return['query'] = $query;
	
	$query = "SELECT `pkid`, `leave_applied`, `approver2` FROM `tbl_batch_leave_application` ORDER BY `pkid` DESC LIMIT 1"; 
	$result = mysql_query($query);
	while ( $row = mysql_fetch_array($result) ){
	
		$pkid 			= $row['pkid'];
		$created_by 	= $row['created_by'];
		$EmpNo 			= $row['EmpNo'];
		$leave_applied 	= $row['leave_applied'];
		$approver2 		= $row['approver2'];
		
	}

	$return['fk_batch_leave_app'] 	= $pkid;
	$return['created_by'] 			= $created_by;
	$return['EmpNo'] 				= $EmpNo;
	$return['fk_leave_applied'] 	= $leave_applied;
	$return['approver2'] 			= $approver2;
	
	 echo json_encode($return);

		
?>

