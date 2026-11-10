<?php
    include("includes.php");
	require_once("elfs_oop.php");
	// session_start();

	$username = $_SESSION['username'];
	// $username = 'marbonc';
	
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<style>
		
	#leaveEmpReports tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#leaveEmpReports tr.selected {
		background-color: #36747a;
		color: #FFF;
	}
		
	.FormLabel{
		width:8%;
		margin-left:2%;
		font-size: 14px;
	}
	
	.FormText{
		margin-bottom:4px;
		width:10%;
		font-size: 14px;
	}
	
	.fa:hover {
		font-size: 20px;
		color: #FFF;
	}
	
	.fa-thumbs-up {
		color: #0039e6;
	}
	
	.fa-thumbs-down {
		color: #cc0000;
	}
	
	h4 { 
		display: block;
		font-size: 1.3em;
		font-family: Euphemia;
		color: #36747a;
		margin-top: 0;
		margin-bottom: 0;
		margin-left: 0;
		margin-right: 0;
		font-weight: bold;
	}
	
	.modal-body {
		max-height: calc(110vh - 210px);
		overflow-y: auto;
	}
	
	.glyphicon.glyphicon-remove {
		font-size: 25px;
	}
	
	.glyphicon.glyphicon-ok {
		font-size: 25px;
	}

	
</style>
</head>

<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>
<br>
<br>
<br>
<br>

<div class="panel panel-success" style="margin:auto; width:95%;">
	<div class="panel-heading">EMPLOYEE LEAVE BALANCE REPORT</div>
		<div class="panel-body" style="max-height: 700;overflow-y: scroll;">	
	<br>
	<form id="leave_balance" method="get" action="http://systemone/elfs/hrd_index.php?page=hrd_leave_balance_reports.php">
	<label  style="width:200px; height:5%;">Choose File to Export:</label>
	<select id="LeaveBalance" style="width:250px; height:4%;" class="FormText"> 
		<option value="0">--Select--</option>
		<option value="http://systemone/elfs/SL_balance_report.php">SL Balance Report</option>
		<option value="http://systemone/elfs/VL_balance_report.php">VL Balance Report</option>
		  <optgroup label="VL - Year End Balance Report">
			<option value="http://systemone/elfs/YEB_VL_daily.php">Daily</option>
			<option value="http://systemone/elfs/YEB_VL_monthly.php">Monthly</option>
			<option value="http://systemone/elfs/YEB_VL_jsss.php">JS/SS</option>
			<option value="http://systemone/elfs/YEB_VL_confidential.php">Confidential</option>
		  </optgroup>
		  <optgroup label="SL - Year End Balance Report">
			<option value="http://systemone/elfs/YEB_SL_daily.php">Daily</option>
			<option value="http://systemone/elfs/YEB_SL_monthly.php">Monthly</option>
			<option value="http://systemone/elfs/YEB_SL_jsss.php">JS/SS</option>
			<option value="http://systemone/elfs/YEB_SL_confidential.php">Confidential</option>
		  </optgroup>
	</select>
		<br>
		
		<table id="leavebalancereports_tbl_hrd" name="leavebalancereports_tbl_hrd" class="display nowrap" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by EmpNo." data-original-title="">EMPLOYEE NO.</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Division" data-original-title="">DIVISION</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Regularity Date" data-original-title="">REG. DATE</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by VL Previous Balance " data-original-title=""> VL PREV. BAL.</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Credit VL" data-original-title=""> CREDIT VL</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Current Avail VL" data-original-title=""> CURRENT AVAIL VL</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total used VL" data-original-title="">TOTAL USED VL</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total VL Balance" data-original-title="">TOTAL VL BAL.</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by SL Previous Balance " data-original-title=""> SL PREV. BAL.</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Credit SL" data-original-title=""> CREDIT SL</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Current Avail SL" data-original-title=""> CURRENT AVAIL SL</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total used SL" data-original-title="">TOTAL USED SL</th>
					<th style="text-align: center; vertical-align: middle;font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total SL Balance" data-original-title="">TOTAL SL BAL.</th>
			  </tr>
			</thead>
			<tbody id="leaveEmpReports">
				<?php
				$result = ELFS::getInstance()->select_leaves_balance();
					while($row = mysqli_fetch_array($result)){
					
					if($row['HiringStatus'] == 2) {
						$status_label = '<center><span class="glyphicon glyphicon-remove" title="Without Leave" style="color:red"></span></center>'; 
					} else if($row['HiringStatus'] == 3) {
						$status_label = '<center><span class="glyphicon glyphicon-ok" title="With Leave" style="color:blue"></span></center>'; 
					}
					
					echo "
						<tr>	
							<td style='display:none'>".$row['pkid']."</td>
							<td style='text-align: center;font-family: Euphemia; font-size: 13px;'>".$status_label."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['EmpNo']."</td>
							<td style='text-align: left;font-family: Euphemia;font-size: 13px;'>".$row['LastName'].", ".$row['FirstName']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['Division']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['regularity_date']."</td> 
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['previous_balance_VL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['credit_VL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['current_avail_VL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['total_VL_used']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['total_VL_balance']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['previous_balance_SL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['credit_SL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['current_avail_SL']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['total_SL_used']."</td>
							<td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['total_SL_balance']."</td>
						</tr>
						";
							// <td style='text-align: center;font-family: Euphemia;font-size: 13px;'>".$row['LastName'].", ".$row['FirstName']." (".$row['MiddleName'].")</td>

				}
				?>
			</tbody>
		</table>
	</form>
	
</div>
</div>

</body>

<script type="text/javascript">

$(document).ready(function(){
	$("#leavebalancereports_tbl_hrd").dataTable({"order": [],
		"columnDefs": [ {
		"targets"  : 'no-sort',
		"orderable": false,
	}]});
}); 

$("tbody tr").click(function() {
	console.log('clicked');
	$(this).addClass('selected').siblings().removeClass("selected");
});

$(function() {
	$("#LeaveBalance").change(function() {
		if ($(this).val()) {
			window.open($(this).val(), '_blank');
			$("#leave_balance").submit();
		}
	});
});

</script>
	
</html>