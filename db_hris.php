<?php  
	$conn = mysql_connect('localhost', 'root', 'newd3v');
	 if (!$conn)
    {
	 die('Could not connect: ' . mysql_error());
	}
	// mysql_select_db("db_hris_bak", $conn);
	mysql_select_db("db_hris", $conn);
 ?>
