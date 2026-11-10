<?php
include ('db_hris.php');
				$fk_leave_app		= $_POST['pkid'];
				$created_by			= $_POST['created_by'];
				$EmpNo				= $_POST['EmpNo'];
				$fk_leave_applied	= $_POST['leave_applied'];
				$date_absent_from	= date('Y-m-d', strtotime($_POST['date_absent_from']));
				$date_absent_to		= date('Y-m-d', strtotime($_POST['date_absent_to']));
				$no_of_days			= $_POST['no_of_days'];
    
	$date_ctr = $date_absent_from;
	$infinite_loop_terminator = 0;
	
	while( strtotime($date_ctr) <= strtotime($date_absent_to) ){
		$valid = true;
		if( date('D',strtotime($date_ctr)) == 'Sun'){
			$valid = false;
		}
		//ML
		if( date('D',strtotime($date_ctr)) == 'Sun' && $fk_leave_applied == 3){
			$valid = true;
		}
		//SLBW
		if( date('D',strtotime($date_ctr)) == 'Sun' && $fk_leave_applied == 7){
			$valid = true;
		}

		if($valid){
			mysql_query("INSERT INTO `tbl_leave_dates` (fk_leave_app, created_by, EmpNo, fk_leave_applied, date_absent_from, date_absent_to, no_of_days) 
			VALUES ('$fk_leave_app', '$created_by', '$EmpNo', '$fk_leave_applied', '$date_ctr', '$date_ctr', '1')");
		}	
		
		$infinite_loop_terminator ++;
		$date_ctr = date('Y-m-d',strtotime("+1 day", strtotime($date_ctr)));
		
		if ($infinite_loop_terminator >= 200) {
			$return = array();
			$return['message'] = 'infinite loop' .$date_ctr .'fk_leave_app='. $date_ctr .'created_by='. $date_ctr .'EmpNo='. $date_ctr .'fk_leave_applied='. $date_ctr .'date_absent_from='. $date_ctr .'date_absent_to='. $date_ctr .'no_of_days=' ;
			echo json_encode($return);
			exit;
		}
	}
	
	// for($i=0; $i <= $no_of_days; $i++) {
		// if( date('D',strtotime($date_ctr)) == 'Sun' && $fk_leave_applied != 3){
			// $valid = false;
		// } else {
			// mysql_query("INSERT INTO `tbl_leave_dates` (fk_leave_app, fk_leave_applied, date_absent_from, date_absent_to, no_of_days) 
			// VALUES ('$fk_leave_app', '$fk_leave_applied', '$date_ctr', '$date_ctr', '1')");
		// } 	
		// $date_ctr = date('Y-m-d',strtotime("+1 day", strtotime($date_ctr)));
	// }
	
	$return = array();
	$return['message'] = "Saved";
	echo json_encode($return);
?>

