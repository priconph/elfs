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
	
</style>
</head>

<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>

<div class="panel panel-success" style="margin:auto; width:95%;">
	<div class="panel-heading">EMPLOYEE LEAVE TRANSACTION REPORTS</div>
	<div class="panel-body">

	<br>
	<!--<form id="transaction_report" method="get" action="http://systemone/elfs/hrd_index.php?page=hrd_leave_transaction_reports.php">-->
	<form id="transaction_report" method="get" action="hrd_leave_transaction_reports.php">
	 <label class="FormLabel">Start Date:</label>
		<input type="date" style="width:200px; height:5%;" class="FormText" id="tbox_startDate" name="tbox_startDate" value="<?php print $_GET['tbox_startDate']; ?>">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button style="border-radius: 0px;font-family: Euphemia;width:100px; height: 40px;" role="button" class="btn btn-primary" id="btn_search" name="btn_search" required data-toggle="tooltip" data-placement="bottom" title="Click this to search between the dates." data-original-title="">SEARCH</button>
		<br>
		<label class="FormLabel">End Date:</label>
		<input type="date" style="width:200px; height:5%;" class="FormText" id="tbox_endDate" name="tbox_endDate" value="<?php print $_GET['tbox_endDate']; ?>">		
		<br>
		<br>
		&nbsp;&nbsp;&nbsp;
	<!--<label  style="width:220px; height:5%;">Choose File to Export (PDF): </label>
		<select id="drp_pdf_report" style="width:250px; height:5%;" class="FormText"> 
			<option value="1">Daily Leave Transaction</option>
			<option value="2">Monthly Leave Transaction</option>
			<option value="3">JS/SS Leave Transaction</option>
			<option value="4">Confidential Leave Transaction</option>
		</select>
		&nbsp;&nbsp;&nbsp;
		<a style="border-radius: 0px;font-family: Euphemia; font-size: 15px; width:100px; height: 40px;" role="button" class="btn btn-success" onClick="exportPDFReport();" data-toggle="tooltip" data-placement="bottom" title="Click this to generate PDF file." data-original-title="">PDF</a>
		-->
		<br>
		&nbsp;&nbsp;&nbsp;
		<label  style="width:220px; height:5%;">Choose File to Export (Excel): </label>
		<select id="drp_excel_report" style="width:250px; height:5%;" class="FormText"> 
			<option value="1">Daily Leave Transaction</option>
			<option value="2">Monthly Leave Transaction</option>
			<option value="3">JS/SS Leave Transaction</option>
			<option value="4">Confidential Leave Transaction</option>
		</select>
		&nbsp;&nbsp;&nbsp;
		<a style="border-radius: 0px;font-family: Euphemia; font-size: 15px; width:100px; height: 40px;" role="button" class="btn btn-warning" onClick="exportExcelReport();" data-toggle="tooltip" data-placement="bottom" title="Click this to generate excel file." data-original-title="">EXCEL</a>

		<br>
		<br>		
		<br>		
		
		<table id="leavereports_tbl_hrd" name="leavereports_tbl_hrd" class="display nowrap" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Created" data-original-title="">DATE CREATED</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by EmpNo." data-original-title="">EMPLOYEE NO.</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Division" data-original-title="">DIVISION</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Leave Applied" data-original-title="">LEAVE APPLIED</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date absent" data-original-title="">DATE ABSENT</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by No. of days" data-original-title="">NO. OF DAYS</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Paid Leave" data-original-title="">PAID LEAVE</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Reason/s" data-original-title="">REASON</th>
					<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Other Reason/s" data-original-title="">OTHER REASON</th>
			  </tr>
			</thead>
			<tbody id="leaveEmpReports">
				<?php
				if(!isset($_GET['tbox_startDate'])){                 
				$result = ELFS::getInstance()->select_leave_transaction_reports();
					while($row = mysqli_fetch_array($result)){
					
				if($row['HiringStatus'] == 2) {
					$status_label = '<div class="ui red ribbon label">Without Leave</div>'; 
				} else if($row['HiringStatus'] == 3) {
					$status_label = '<div class="ui blue ribbon label">With Leave</div>'; 
				}
				
				if($row['leave_applied'] == 0) {										
				$leave_label = '<center>Sick Leave</center>';
				} 	else if($row['leave_applied'] == 1) {
				$leave_label = '<center>Vacation Leave</center>';
				}	else if($row['leave_applied'] == 2) {
				$leave_label = '<center>Birthday Leave</center>';
				}	else if($row['leave_applied'] == 3) {
				$leave_label = '<center>Maternity Leave</center>';
				}	else if($row['leave_applied'] == 4) {
				$leave_label = '<center>Paternity Leave</center>';
				}	else if($row['leave_applied'] == 5) {
				$leave_label = '<center>Bereavement Leave</center>';
				}	else if($row['leave_applied'] == 6) {
				$leave_label = '<center>Solo Parent Leave</center>';
				}	else if($row['leave_applied'] == 7) {
				$leave_label = '<center>Special Leave Benefit for Women</center>';
				}	

				if($row['other_reason'] == 0) {										
				$reason_label = '<center>N/A</center>';
				} 	else if($row['other_reason'] == 1) {
				$reason_label = '<center>Shut-down</center>';
				}	else if($row['other_reason'] == 2) {
				$reason_label = '<center>Special Non-working Holiday</center>';
				}	else if($row['other_reason'] == 3) {
				$reason_label = '<center>Others</center>';
				}				
				
				echo "
					<tr>	
						<td style='display:none'>".$row['pkid']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 16px;'>".$status_label."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".date('F d, Y',strtotime($row['date_created']))."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['EmpNo']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['LastName'].", ".$row['FirstName']." (".$row['MiddleName'].")</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['Division']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$leave_label."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".date('F d, Y',strtotime($row['date_from']))." - ".date('F d, Y',strtotime($row['date_to']))."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['total_absent_days']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['no_of_paid']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$reason_label."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['reason']."</td>
					</tr>
					";
					}
				} else {
				$param1 = $_GET['tbox_startDate'];
				$param2 = $_GET['tbox_endDate'];
				$result = ELFS::getInstance()->getfiltered_leave_transaction_reports($param1, $param2);
				while($row = mysqli_fetch_array($result)){
				
				if($row['HiringStatus'] == 2) {
					$status_label = '<div class="ui red ribbon label">Without Leave</div>'; 
				} else if($row['HiringStatus'] == 3) {
					$status_label = '<div class="ui blue ribbon label">With Leave</div>'; 
				}
				
				if($row['leave_applied'] == 0) {										
				$leave_label = '<center>Sick Leave</center>';
				} 	else if($row['leave_applied'] == 1) {
				$leave_label = '<center>Vacation Leave</center>';
				}

				if($row['other_reason'] == 0) {										
				$reason_label = '<center>N/A</center>';
				} 	else if($row['other_reason'] == 1) {
				$reason_label = '<center>Shut-down</center>';
				}	else if($row['other_reason'] == 2) {
				$reason_label = '<center>Special Non-working Holiday</center>';
				}	else if($row['other_reason'] == 3) {
				$reason_label = '<center>Others</center>';
				}					
				
				echo "
					<tr>	
						<td style='display:none'>".$row['pkid']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 16px;'>".$status_label."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".date('F d, Y',strtotime($row['date_created']))."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['EmpNo']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['LastName'].", ".$row['FirstName']." (".$row['MiddleName'].")</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['Division']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$leave_label."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".date('F d, Y',strtotime($row['date_from']))." - ".date('F d, Y',strtotime($row['date_to']))."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['total_absent_days']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['no_of_paid']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$reason_label."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['reason']."</td>
					</tr>
					";
					}
			}
			?>
			</tbody>
		</table>
	</form>
</div>
</div>
</div>

</body>

<script type="text/javascript">
$(document).ready(function(){
	$("#leavereports_tbl_hrd").dataTable({"order": [],
		"columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false,
	}]});

	$("tbody tr").click(function() {
		console.log('clicked');
		$(this).addClass('selected').siblings().removeClass("selected");
	});
});

 function exportExcelReport() {
        var excelVal = $('#drp_excel_report').val();
        var startDate = $("#tbox_startDate").val();
        var endDate = $("#tbox_endDate").val();
        if(startDate == '' || endDate == '') {
            alert("Please check all required fields.");
        } else {
            if(excelVal == "1"){
                window.location.href = "daily_excel.php?startDate="+startDate+"&endDate="+endDate;
            }
			 if(excelVal == "2"){
                window.location.href = "monthly_excel.php?startDate="+startDate+"&endDate="+endDate;
            }
			 if(excelVal == "3"){
                window.location.href = "jsss_excel.php?startDate="+startDate+"&endDate="+endDate;
            }
			 if(excelVal == "4"){
                window.location.href = "confidential_excel.php?startDate="+startDate+"&endDate="+endDate;
            }
        }
    }
	
  function exportPDFReport() {
        var pdfVal = $('#drp_pdf_report').val();
        var startDate = $("#tbox_startDate").val();
        var endDate = $("#tbox_endDate").val();
        if(startDate == '' || endDate == '') {
            alert("Please check all required fields.");
        } else {
            if(pdfVal == "1"){
                window.location.href = "Daily_pdf.php?startDate="+startDate+"&endDate="+endDate;
            }
            if(pdfVal == "2"){
                window.location.href = "Monthly_pdf.php?startDate="+startDate+"&endDate="+endDate;
            }
            if(pdfVal == "3"){
                window.location.href = "jsss_pdf.php?startDate="+startDate+"&endDate="+endDate;
            }
            if(pdfVal == "4"){
                 window.location.href = "confidential_pdf.php?startDate="+startDate+"&endDate="+endDate;
            }
        }
    }
	


</script>
	
</html>