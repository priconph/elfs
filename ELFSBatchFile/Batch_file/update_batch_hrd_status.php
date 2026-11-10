<?php
include ('db_hris.php');		
		$pkid					= $_POST['pkid'];
		$fk_batch_leave_app		= $_POST['pkid'];
		$empno					= $_POST['empno'];
		$status					= $_POST['status'];
		$update_no_of_days		= $_POST['update_no_of_days'];
		$leave_applied			= $_POST['leave_applied'];
		$cutoff					= $_POST['cutoff'];
		$cutoff_date			= $_POST['cutoff_date'];
		$HR_revised_remarks		= mysql_real_escape_string($_POST['HR_revised_remarks']);
		$HR_cancel_remarks		= mysql_real_escape_string($_POST['HR_cancel_remarks']);
		$username				= $_POST['username'];

		$query = "SELECT `fk_batch_leave_app` FROM `tbl_leave_dates` WHERE fk_batch_leave_app = '$pkid'"; 	

		$result = mysql_query($query);
		// `status` 					= '$status', 
		// `status` 					= '2', 
		$query = "UPDATE `tbl_batch_leave_application` SET 
					`status` 					= '$status', 
					`cutoff` 					= '$cutoff', 
					`lastupdate`				= '".date("Y-m-d H:i:s")."',
					`username`					= '$username'
					 WHERE `pkid` 				= '$pkid' AND logdel='0'";
		$result = mysql_query($query);
		
			
		$query = "UPDATE `tbl_leave_dates` SET 
					`cutoff_date` 				= '$cutoff_date'
					 WHERE `fk_batch_leave_app` 		= '$pkid' AND logdel='0'";
		$result = mysql_query($query);
			
	if($status == '3'){
		if($leave_applied == '1'){
			$query = "SELECT  previous_balance_VL, credit_VL, current_avail_VL, total_VL_used FROM `tbl_leaves_balance` WHERE EmpNo = '$empno'"; 
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				$previous_balance_VL	= $row['previous_balance_VL'];
				$credit_VL 				= $row['credit_VL'];
				$current_avail_VL 		= $row['current_avail_VL'];
				$total_VL_used 			= $row['total_VL_used'];
			}
			$current_avail = ($current_avail_VL - $update_no_of_days);
			if($current_avail <= 0){
				$current_avail = 0;
			}
			$query = 'UPDATE tbl_leaves_balance SET previous_balance_VL = "'.$previous_balance_VL.'", credit_VL = "'.$credit_VL.'", current_avail_VL = "'.$current_avail.'", total_VL_used = "'.($total_VL_used+$update_no_of_days).'", total_VL_balance = "'.($current_avail+$credit_VL).'"  WHERE EmpNo = "'.$empno.'"';
			mysql_query($query);
			
			/* VL */
			$query = "SELECT pkid FROM `tbl_leave_dates` WHERE fk_batch_leave_app = '$pkid'"; 
			$result = mysql_query($query);
			$row_count = mysql_num_rows($result);
			
			$return['new_test'] = $row_count;
			$return['new_test2'] = '';
			
			for ( $x=0; $x < $row_count; $x++ ){
				if ($current_avail_VL > 0) {
					$query = "SELECT * FROM `tbl_leave_dates` WHERE fk_batch_leave_app = '$pkid' AND no_of_paid = '' LIMIT 0,1";
					$result = mysql_query($query);
					$row_exist = mysql_num_rows($result);
					if($row_exist != 0){
						$row = mysql_fetch_array($result);
						$deduction = $row['no_of_days'];
						$query = "UPDATE `tbl_leave_dates` SET 	no_of_paid = '$deduction' WHERE `pkid` = '".$row['pkid']."'";
						$current_avail_VL = $current_avail_VL - $deduction;
						$result = mysql_query($query);
						$return['new_test'] .= '//'.$query;
					}
				}else{
					$query = "SELECT * FROM `tbl_leave_dates` WHERE fk_batch_leave_app = '$pkid' AND no_of_paid = '' LIMIT 0,1";
					$result = mysql_query($query);
					$row_exist = mysql_num_rows($result);
					if($row_exist != 0){
						$row = mysql_fetch_array($result);
						$query = "UPDATE `tbl_leave_dates` SET 	no_of_paid = '0' WHERE `pkid` = '".$row['pkid']."'";
						$result = mysql_query($query);
						$return['new_test2'] .= '//'.$query;
					}
				}
			}
			
		} 
	} 
	$return['query'] = $query;
		
	$return['fk_batch_leave_applied'] = $pkid;
	$return['message'] = 'Successfully Updated!';
  
	echo json_encode($return);

		
?>



