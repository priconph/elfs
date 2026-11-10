<?php
include ('db_hris.php');

		
		$pkid					= $_POST['pkid'];
		$no_of_days				= $_POST['no_of_days'];
				
			$query = "UPDATE `tbl_leave_dates` SET 
					`no_of_days`			= '0.5'
					WHERE `pkid` 			= '$pkid' AND logdel='0'";
		
		mysql_query($query);
	
	$return['query'] = $query;

	$query = "SELECT `pkid` FROM `tbl_leave_dates` ORDER BY `pkid` DESC LIMIT 1"; 
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)){
		$pkid = $row['pkid'];
	}
	
	$return['fk_leave_applied'] = $pkid;
	$return['message'] = 'Successfully Updated!';

  
	echo json_encode($return);

		
?>


