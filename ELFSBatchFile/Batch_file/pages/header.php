<html>
<title>ELFS- Batch Leave</title>
<head>
<?php 
require_once('libraries/includes.php'); 
session_start();
?>
</head>
<body>
<input type="hidden" id="txt_hd_id" value="<?php echo $_SESSION['username']; ?>">