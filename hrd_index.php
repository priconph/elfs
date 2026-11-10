<?php

	require_once('navmenu.php');
	
	if(!isset($_GET['page']))
	{
		$page = "leave_balance_update_module.php";
	}else{
		$page = $_GET['page'];
	}

	require_once($page);

?>

