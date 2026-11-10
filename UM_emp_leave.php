<?php
include("includes.php");
session_start();

$username = $_SESSION['username'];
$username = 'jcfeliciano';
?>

</datalist>
<html>
<head>
<title>ELFS | User Manual</title>
<link rel="stylesheet" href="./css/smpopsgStyle.css" >

<style>

</style>

 </head>
<body style="background:white;">
 <div class="container_All">
 	 <div class="container_Buttons">
	 </div>
	 <div class="container_Main" style="height:100%;">
	<br>
		<center><label style="font-size:30px;">Employee Leave File System</label></center>
		<center><label style="font-size:20px;">User's Manual</label></center><br>
		<label style="font-size:20px; padding-left:1%;"><b> ADD NEW LEAVE </b></label><br>
		
		<label style="font-size:16px; padding-left:2%;">1. On Leave Application, Click <b>Add New Leave. </b></label><br>
		<label style="font-size:16px; padding-left:2%;">2. Fill up the required fields. For Halfday, Click <b>'SAVE'</b> button.<br>
		<label style="font-size:16px; padding-left:4%;"><b>**NOTE:</b> Once you click 'OK' from system message, you are not able to change the date.</b></label><br>
		<img src="./user_manual_images/1.Add new leave.PNG" style="width:35%; height:35%; padding-left:2%;">
		
		<img src="./user_manual_images/2.PNG" style="width:45%;height:35%;padding-left:2%;">
		
		<p style="padding-left:2%;">3. Enter Employee Last name. Then, Click <b>Add Request </b>button</p>
		<img src="./user_manual_images/three2.PNG" style="width:45%;height:35%;padding-left:2%;">
		<p>4. Once all required field are filled out. Then, Click <b>Submit Request </b>button.</p>
		<img src="./user_manual_images/4.PNG" style="width:45%;height:35%;padding-left:2%;">
		<br><br>
		<label style="font-size:20px;padding-left:2px;">[Cancel Request]</label>
		<p>1. To cancel a request, double click the specific row (Pending status). Select <b> Cancelled Status </b> and justify your reason then, click <b>Save and Submit request</b> button</b></p>
		<img src="./user_manual_images/five.PNG" style="width:45%;height:35%;padding-left:2%;">
		<img src="./user_manual_images/six.PNG" style="width:45%;height:35%;padding-left:2%;">
		</div>
 </div>
  <script type="text/javascript" src="js/webflow.js"></script>

</body>
</html>