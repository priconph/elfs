<?php
include ('db_hris.php');

		
		$pkid				= $_POST['pkid'];
		$status				= $_POST['status'];
		$reason				= mysql_real_escape_string($_POST['reason']);
		$approver2			= $_POST['approver2'];
		$username			= $_POST['username'];					
		

		$query = "UPDATE `tbl_batch_leave_application` SET 
		`status` 			 = '$status', 
		`reason`		     = '$reason', 
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

