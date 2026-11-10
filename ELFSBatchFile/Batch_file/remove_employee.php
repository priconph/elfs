<?php
include ('db_hris.php');

		
		$pkid			= $_POST['pkid'];
		$fkid			= $_POST['fkid'];
		$logdel			= $_POST['logdel'];
					
			$query = "UPDATE `tbl_Batch_Emp` SET 
					`logdel`		= 1
					WHERE `pkid` 	= '$pkid'";
		
		mysql_query($query);
	
	$return['query'] = $query;

	$query = "SELECT `pkid` FROM `tbl_Batch_Emp` ORDER BY `pkid` DESC LIMIT 1"; 
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)){
		$pkid = $row['pkid'];
	}
	
	$return['fkid'] = $pkid;
	$return['message'] = 'Successfully Updated!';

  
	echo json_encode($return);

		
?>


