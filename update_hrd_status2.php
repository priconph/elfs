<?php
include ('db_hris.php');		
		$pkid					= $_POST['pkid'];
		$fk_leave_app			= $_POST['pkid'];
		$empno					= $_POST['empno'];
		$status					= $_POST['status'];
		$update_no_of_days		= $_POST['update_no_of_days'];
		$leave_applied			= $_POST['leave_applied'];
		$cutoff					= $_POST['cutoff'];
		$cutoff_date			= $_POST['cutoff_date'];
		$HR_revised_remarks		= mysql_real_escape_string($_POST['HR_revised_remarks']);
		$HR_cancel_remarks		= mysql_real_escape_string($_POST['HR_cancel_remarks']);
		$username				= $_POST['username'];

		$query = "SELECT `fk_leave_app` FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid'"; 	

		$result = mysql_query($query);
		// `status` 					= '$status', 
		// `status` 					= '2', 
		$query = "UPDATE `tbl_leave_application` SET 
					`status` 					= '$status', 
					`cutoff` 					= '$cutoff', 
					`HR_revised_remarks` 		= '$HR_revised_remarks', 
					`HR_cancel_remarks` 		= '$HR_cancel_remarks', 
					`lastupdate`				= '".date("Y-m-d H:i:s")."',
					`username`					= '$username'
					 WHERE `pkid` 				= '$pkid' AND logdel='0'";
		$result = mysql_query($query);
		
			
		$query = "UPDATE `tbl_leave_dates` SET 
					`cutoff_date` 				= '$cutoff_date'
					 WHERE `fk_leave_app` 		= '$pkid' AND logdel='0'";
		$result = mysql_query($query);
			
	if($status == '3'){
		if($leave_applied == '0'){ //SL
			$query = "SELECT previous_balance_SL, credit_SL, current_avail_SL, total_SL_used, total_SL_balance FROM `tbl_leaves_balance` WHERE EmpNo = '$empno'";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				$previous_balance_SL	= $row['previous_balance_SL'];
				$credit_SL 				= $row['credit_SL'];
				$current_avail_SL 		= $row['current_avail_SL'];
				$total_SL_used 			= $row['total_SL_used'];
				$total_SL_balance 		= $row['total_SL_balance'];
			}
			$current_avail = ($current_avail_SL - $update_no_of_days);
			if($current_avail_SL < $update_no_of_days){
				$total_SL_used += $current_avail_SL;
			}else{
				$total_SL_used += $update_no_of_days;
			}
			
			if($current_avail <= 0){
				$current_avail = 0;
			}
			
			//- Orig Code -//
			
			$query = 'UPDATE tbl_leaves_balance SET previous_balance_SL = "'.$previous_balance_SL.'", credit_SL = "'.$credit_SL.'", current_avail_SL = "'.$current_avail.'", total_SL_used = "'.$total_SL_used.'", total_SL_balance = "'.(($credit_SL+$previous_balance_SL) - ($total_SL_used)).'"   WHERE EmpNo = "'.$empno.'"'; // 01-02-2024
			
			//- up to here -//


			//- Eto ung query after conversion ng SL yearly -// 
			
			// $query = 'UPDATE tbl_leaves_balance SET previous_balance_SL = "'.$previous_balance_SL.'", credit_SL = "'.$credit_SL.'", current_avail_SL = "0", total_SL_used = "'.$total_SL_used.'", total_SL_balance = "0.0"   WHERE EmpNo = "'.$empno.'"';
			
			// - up to here -//

			mysql_query($query);
			
			/* SL */
			$query = "SELECT pkid FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid'"; 
			$result = mysql_query($query);
			$row_count = mysql_num_rows($result);
			
			$return['new_test'] = $row_count;
			$return['new_test2'] = '';
			
			for ( $x=0; $x < $row_count; $x++ ){
				if ($current_avail_SL > 0) {
					$query = "SELECT * FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid' AND no_of_paid = '' AND logdel = '0' LIMIT 0,1";
					$result = mysql_query($query);
					$row_exist = mysql_num_rows($result);
					if($row_exist != 0){
						$row = mysql_fetch_array($result);
						$deduction = $row['no_of_days'];
						if($current_avail_SL - $deduction < 0){
							$additional_deduction = $current_avail_SL - $deduction;
							$query = "UPDATE `tbl_leave_dates` SET 	no_of_paid = '".($deduction+$additional_deduction)."' WHERE `pkid` = '".$row['pkid']."'";
						}else{
							$query = "UPDATE `tbl_leave_dates` SET 	no_of_paid = '$deduction' WHERE `pkid` = '".$row['pkid']."'";
						}
						
						$current_avail_SL = $current_avail_SL - $deduction;
						$result = mysql_query($query);
						$return['new_test'] .= '//'.$query;
					}
				}else{
					$query = "SELECT * FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid' AND no_of_paid = '' AND logdel = '0' LIMIT 0,1";
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
		else if($leave_applied == '1'){
			$query = "SELECT  previous_balance_VL, credit_VL, current_avail_VL, total_VL_used, total_VL_balance FROM `tbl_leaves_balance` WHERE EmpNo = '$empno'"; 
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				$previous_balance_VL	= $row['previous_balance_VL'];
				$credit_VL 				= $row['credit_VL'];
				$current_avail_VL 		= $row['current_avail_VL'];
				$total_VL_used 			= $row['total_VL_used'];
				$total_VL_balance 		= $row['total_VL_balance'];
			}

			$current_avail = ($current_avail_VL - $update_no_of_days);
			if($current_avail_VL < $update_no_of_days){
				$total_VL_used += $current_avail_VL;
			}else{
				$total_VL_used += $update_no_of_days;
			}  
			
			if($current_avail <= 0){
				$current_avail = 0;
			}

			//- Orig Code UNCOMMENT AFTER NEW YEAR -//
			
			// $query = 'UPDATE tbl_leaves_balance SET previous_balance_VL = "'.$previous_balance_VL.'", 
			// 										credit_VL = "'.$credit_VL.'", 
			// 										current_avail_VL = "'.$current_avail.'", 
			// 										total_VL_used = "'.$total_VL_used.'", 
			// 										total_VL_balance = "'.(($credit_VL+$previous_balance_VL) - ($total_VL_used)).'"   
			// 										WHERE EmpNo = "'.$empno.'"'; 
			
			//- up to here -//										
																									
			//- Query after convertion ng VL yearly -//
			
			$query = "SELECT EmpNo, date_conversion, vl_balance, vl_convertible FROM `tbl_leave_conversion` WHERE EmpNo = '$empno' AND YEAR( date_conversion ) = '2026' "; // Yearly 
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				
				$date_conversion		= $row['date_conversion'];
				$vl_balance 			= $row['vl_balance'];
				$vl_convertible 		= $row['vl_convertible'];
			}
			
			$query = 'UPDATE tbl_leaves_balance SET 
						previous_balance_VL = "'.$previous_balance_VL.'", 
						credit_VL = "'.$credit_VL.'", 
						current_avail_VL = "'.$current_avail.'", 
						total_VL_used = "'.$total_VL_used.'", 
						total_VL_balance = "'.(($credit_VL+$previous_balance_VL) - ($total_VL_used+$vl_convertible)).'"   
					WHERE EmpNo = "'.$empno.'"';

			//- up to here -//
			
			
			mysql_query($query);
			
			/* VL */
			$query = "SELECT pkid FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid' AND logdel = '0'"; 
			$result = mysql_query($query);
			$row_count = mysql_num_rows($result);
			
			$return['new_test'] = $row_count;
			$return['new_test2'] = '';
			
			for ( $x=0; $x < $row_count; $x++ ){
				if ($current_avail_VL > 0) {
					$query = "SELECT * FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid' AND no_of_paid = '' AND logdel = '0' LIMIT 0,1";
					$result = mysql_query($query);
					$row_exist = mysql_num_rows($result);
					if($row_exist != 0){
						$row = mysql_fetch_array($result);
						$deduction = $row['no_of_days'];
						// $query = "UPDATE `tbl_leave_dates` SET 	no_of_paid = '$deduction' WHERE `pkid` = '".$row['pkid']."'";
						
						if($current_avail_VL - $deduction < 0){
							$additional_deduction = $current_avail_VL - $deduction;
							$query = "UPDATE `tbl_leave_dates` SET 	no_of_paid = '".($deduction+$additional_deduction)."' WHERE `pkid` = '".$row['pkid']."'";
						}else{
							$query = "UPDATE `tbl_leave_dates` SET 	no_of_paid = '$deduction' WHERE `pkid` = '".$row['pkid']."'";
						}						
						
						$current_avail_VL = $current_avail_VL - $deduction;
						$result = mysql_query($query);
						$return['new_test'] .= '//'.$query;
					}
				}else{
					$query = "SELECT * FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid' AND no_of_paid = '' AND logdel = '0' LIMIT 0,1";
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
		else if( $leave_applied == '2' || $leave_applied == '4' || $leave_applied == '5' || $leave_applied == '6' || $leave_applied == '7' ){ // Auto paid leave based on no. of days
			/* 2 = BDL, 4 = PL, 5 = BL, 6 = SPL, 7 = SLBW */
			$query = "SELECT pkid FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid'"; 
			$result = mysql_query($query);
			$row_count = mysql_num_rows($result);
			
			$return['new_test'] = $row_count;
			
			for ( $x=0; $x < $row_count; $x++ ){

					$query = "SELECT * FROM `tbl_leave_dates` WHERE fk_leave_app = '$pkid' AND no_of_paid = '' AND logdel = '0' LIMIT 0,1";
					$result = mysql_query($query);
					$row_exist = mysql_num_rows($result);
					if($row_exist != 0){
						$row = mysql_fetch_array($result);
						$no_of_days = $row['no_of_days'];
						$query = "UPDATE `tbl_leave_dates` SET 	no_of_paid = '$no_of_days' WHERE `pkid` = '".$row['pkid']."'";
						$result = mysql_query($query);
						$return['new_test1'] .= '//'.$query;
					}
				
			}
		} 
	} 
	
	$return['query'] = $query;
	// $return['test_query'] = '//'.$test_query;
	// $return['a'] = 'sample';
		
	$return['fk_leave_applied'] = $pkid;
	$return['message'] = 'Successfully Updated!';
  
	echo json_encode($return);

		
?>

