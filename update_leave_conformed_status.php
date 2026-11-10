<?php
include ('db_hris.php');		
		$pkid					= $_POST['pkid'];
		$fk_leave_app			= $_POST['pkid'];
		$empno					= $_POST['empno'];
		$status					= $_POST['status'];
		$update_no_of_days		= $_POST['update_no_of_days'];
		$no_of_paid				= $_POST['no_of_paid'];
		$leave_applied			= $_POST['leave_applied'];
		$cutoff					= $_POST['cutoff'];
		$cutoff_date			= $_POST['cutoff_date'];
		$HR_cancel_remarks		= mysql_real_escape_string($_POST['HR_cancel_remarks']);
		$username				= $_POST['username'];

		$query = "SELECT `fk_leave_app` FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid'"; 	
		$result = mysql_query($query);

		$query = "UPDATE `tbl_leave_application` SET 
					`status` 					= '$status', 
					`cutoff` 					= '', 
					`HR_cancel_remarks` 		= '$HR_cancel_remarks', 
					`lastupdate`				= '".date("Y-m-d H:i:s")."',
					`username`					= '$username'
					 WHERE `pkid` 				= '$pkid' AND logdel='0'";
		$result = mysql_query($query);
		
		$query = "UPDATE `tbl_leave_dates` SET 
					`cutoff_date` 				= '', 
					`no_of_paid` 				= ''
					 WHERE `fk_leave_app` 		= '$pkid' AND logdel='0'";
		$result = mysql_query($query);
	
	
	$return['query'] = $query;
	$return['fk_leave_app'] = $pkid;
	$return['message'] = 'Successfully Updated!';
  
	echo json_encode($return);

		
?>

