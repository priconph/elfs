<?php
include ('db_hris.php');

		
		$pkid				= $_POST['pkid'];
		$status				= $_POST['status'];
		$leave_applied		= $_POST['leave_applied'];
		$reason				= mysql_real_escape_string($_POST['reason']);
		$other_reason		= mysql_real_escape_string($_POST['other_reason']);
		$emp_address		= mysql_real_escape_string($_POST['emp_address']);
		$address			= mysql_real_escape_string($_POST['address']);
		$approver1			= $_POST['approver1'];												
		$approver2			= $_POST['approver2'];
		$username			= $_POST['username'];					
		

		$query = "UPDATE `tbl_leave_application` SET 
		`status` 			 = '$status', 
		`leave_applied`		 = '$leave_applied', 
		`reason`		     = '$reason', 
		`other_reason`	     = '$other_reason', 
		`emp_address`	 	 = '$emp_address', 
		`address`	 		 = '$address', 
		`approver1` 	  	 = '$approver1', 
		`approver2` 	 	 = '$approver2', 
		`username` 		 	 = '$username', 
		`lastupdate`	 	 = '".date("Y-m-d H:i:s")."'  
		WHERE `pkid` 		 = '$pkid' AND logdel = '0'";
		
		mysql_query($query);
	
	$return['query'] = $query;

	$query = "SELECT `pkid` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"; 
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)){
		$pkid = $row['pkid'];
	}
	
	$return['fk_leave_app'] = $pkid;
	$return['message'] = 'Successfully Updated!';

  
	echo json_encode($return);

		
?>

