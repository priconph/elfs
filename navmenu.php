<?php
    include("includes.php");
	session_start();
	
	$username = $_SESSION['username'];
	// $username = 'marbonc';
	// echo $username;
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
	#custom-bootstrap-menu.navbar-default .navbar-brand {
	color: rgba(255, 255, 255, 1);
	}
	#custom-bootstrap-menu.navbar-default {
		font-size: 14px;
		background-color: rgba(54, 116, 122, 1);
		border-width: 1px;
		border-radius: 4px;
	}
	#custom-bootstrap-menu.navbar-default .navbar-nav>li>a {
		color: rgba(255, 255, 255, 1);
		background-color: rgba(54, 116, 122, 1);
	}
	#custom-bootstrap-menu.navbar-default .navbar-nav>li>a:hover,
	#custom-bootstrap-menu.navbar-default .navbar-nav>li>a:focus {
		color: rgba(255, 255, 255, 1);
		background-color: rgba(84, 179, 50, 1);
	}
	#custom-bootstrap-menu.navbar-default .navbar-nav>.active>a,
	#custom-bootstrap-menu.navbar-default .navbar-nav>.active>a:hover,
	#custom-bootstrap-menu.navbar-default .navbar-nav>.active>a:focus {
		color: rgba(255, 255, 255, 1);
		background-color: rgba(84, 179, 50, 1);
	}
	#custom-bootstrap-menu.navbar-default .navbar-toggle {
		border-color: #54b332;
	}
	#custom-bootstrap-menu.navbar-default .navbar-toggle:hover,
	#custom-bootstrap-menu.navbar-default .navbar-toggle:focus {
		background-color: #54b332;
	}
	#custom-bootstrap-menu.navbar-default .navbar-toggle .icon-bar {
		background-color: #54b332;
	}
	#custom-bootstrap-menu.navbar-default .navbar-toggle:hover .icon-bar,
	#custom-bootstrap-menu.navbar-default .navbar-toggle:focus .icon-bar {
		background-color: #36747a;
	}
	</style>
	</head>

	<body>
	<br>
	
<div id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="http://systemone/elfs/hrd_index.php">EMPLOYEE LEAVE FILE SYSTEM</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-menubuilder">
            <ul class="nav navbar-nav navbar-right">
	<!--		<li>
				<a href="hrd_index.php?page=hrd_leave_summary.php">&nbsp;  Employee Leave Summary <span class="sr-only"></span></a>
			</li>
			<li >
				<a href="hrd_index.php?page=hrd_leave_records.php">&nbsp; Employee Leave Records <span class="sr-only"></span></a>
			</li>
	-->		
			<!-- <li>
				<a href="hrd_index.php?page=leave_balance_update_module.php">&nbsp; Leave Balance Update <span class="sr-only"></span></a>
			</li> -->
			<li>
				<a href="hrd_index.php?page=hrd_leave_balance_reports.php">&nbsp; Leave Balance Records <span class="sr-only"></span></a>
			</li>
			<li>
				<a href="hrd_index.php?page=hrd_leave_transaction_reports.php">&nbsp; Leave Transaction Records <span class="sr-only"></span></a>
			</li>			
	<!--		
			<li>
				<a href="hrd_index.php?page=leave_app_for_amup.php">&nbsp;  Employee Leave Filing <span class="sr-only"></span></a>
			</li>
	-->		
            </ul>
        </div>
    </div>
</div>
</body>
</html>
