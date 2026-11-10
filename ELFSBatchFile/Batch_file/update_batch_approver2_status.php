<?php
include ('db_hris.php');

		
		$pkid					= $_POST['pkid'];
		$status					= $_POST['status'];
		$DH_disapproved_remarks	= mysql_real_escape_string($_POST['DH_disapproved_remarks']);
		$username				= $_POST['username'];

		$query = "UPDATE `tbl_batch_leave_application` SET 
					`status` 					= '$status', 
					`DH_disapproved_remarks` 	= '$DH_disapproved_remarks', 
					`lastupdate`				= '".date("Y-m-d H:i:s")."',
					`date_time_approved2`		= '".date("Y-m-d H:i:s")."',
					`username`					= '$username'
					WHERE `pkid` 				= '$pkid' AND logdel='0'";
		
		mysql_query($query);
	
	$return['query'] = $query;

	$query = "SELECT `pkid` FROM `tbl_batch_leave_application` ORDER BY `pkid` DESC LIMIT 1"; 
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)){
		$pkid = $row['pkid'];
	}
	
	$return['fk_leave_applied'] = $pkid;
	$return['message'] = 'Successfully Updated!';

  
	echo json_encode($return);

		
?>

