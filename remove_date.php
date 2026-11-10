<?php
include ('db_hris.php');

		
		$pkid			= $_POST['pkid'];
		$logdel			= $_POST['logdel'];
					
			$query = "UPDATE `tbl_leave_dates` SET 
					`logdel`		= 1
					WHERE `pkid` 	= '$pkid'";
		
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


