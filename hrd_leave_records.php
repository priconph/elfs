<?php
    include("includes.php");
	require_once("elfs_oop.php");
	// session_start();

	$username = $_SESSION['username'];
	// $username = 'marbonc';

	$result = ELFS::getInstance()->getEmpNo($username);
		while($row = mysqli_fetch_array($result)){
		$EmpNo = $row['EmpNo'];
	} 

	$result = ELFS::getInstance()->getEmpInfo($EmpNo);
		while($rowEmpInfo = mysqli_fetch_array($result)){
		 $empName 			= $rowEmpInfo['FirstName'] . " " .$rowEmpInfo['LastName'];
		 $department 		=  $rowEmpInfo['Department'];
		 $division 			=  $rowEmpInfo['Division'];
		 $regularity_date 	=  $rowEmpInfo['regularity_date'];
	}
	
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<style>
		
	#leaveEmpRecords tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#leaveEmpRecords tr.selected {
		background-color: #36747a;
		color: #FFF;
	}
		
	#cont .FormLabel{
		width:12%;
		margin-left:13%;
		font-size: 14px;
	}
	
	#cont .FormText{
		margin-bottom:4px;
		margin-right:2%;
		font-size: 14px;
	}
	
	#cont .FormLeaveLabel{
		width:35%;
		margin-left:10%;
		font-size: 14px;
	}
		
	#cont .FormLeaveText{
		margin-bottom:4px;
		width:10%;
		margin-left:12%;
		font-size: 14px;
	}
	
	.FormLabel_LB {
		width:30%;
		margin-left:15%;
		font-size: 14px;
	}
		
	.FormText_LB{
		margin-bottom:4px;
		margin-left:3%;
		font-size: 14px;
	}
	
	
	#panel_vl{
		margin-left:23%;
	}
	
	#panel_sl{
		margin-left:23%;
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
	
	#cont .FormLeaveApplied{
		width:10%;
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
	
	#total_VL_used {
		color: #DE2A00;
	}
	
	#total_SL_used {
		color: #DE2A00;
	}
	
	.modal-body {
		max-height: calc(110vh - 210px);
		overflow-y: auto;
	}
	
	.fixed-panel {
		max-height: 300;
		overflow-y: scroll;
	}
	
	#hidden_textbox{
		border: 2px solid transparent;
	}
		
</style>
</head>

<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>

<div class="panel panel-success" style="margin:auto; width:95%;">
	<div class="panel-heading">EMPLOYEE LEAVE RECORDS</div>
	<div class="panel-body">
	<br>
	<form id="" method="get">
		<table id="leaverecords_tbl_hrd" name="leaverecords_tbl_hrd" class="display nowrap" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Status" data-original-title="">STATUS</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by EmpNo." data-original-title="">EMPLOYEE NO.</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Position" data-original-title="">POSITION</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Division" data-original-title="">DIVISION</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Department" data-original-title="">DEPARTMENT</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Section" data-original-title="">SECTION</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date Hired" data-original-title="">DATE HIRED</th>
		  </tr>
		</thead>
		<tbody id="leaveEmpRecords">
			<?php
			$result = ELFS::getInstance()->select_emp_leave_records();
				while($row = mysqli_fetch_array($result)){
				
				if($row['HiringStatus'] == 2) {
					$status_label = '<div class="ui red ribbon label">Without Leave</div>'; 
				} else if($row['HiringStatus'] == 3) {
					$status_label = '<div class="ui blue ribbon label">With Leave</div>'; 
				}
				
				echo "
					<tr>	
						<td style='display:none'>".$row['pkid']."</td>
						<td style='font-family: Euphemia; font-size: 16px;'>".$status_label."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['EmpNo']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['LastName'].", ".$row['FirstName']." (".$row['MiddleName'].")</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['Position']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['Division']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['Department']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 14px;'>".$row['Section']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 13px;'>".date('F d, Y',strtotime($row['DateHired']))."</td>
					</tr>
					";
					}
			?>
		</tbody>
		</table>
	</form>
</div>
</div>

<!-- Modal view leave history / balance-->		
<div class="modal fade" id="Leave_history_balance" role="dialog">
	<div class="modal-dialog" style="width:90%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4 style="font-family:Euphemia">EMPLOYEE LEAVE INFORMATION</h4>
			</div>
		<div class="modal-body" id="cont">	
		<div class="tabbable"> 
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab1" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE HISTORY</a>
					</li>
					<li>
						<a href="#tab2" data-toggle="tab" style="font-size: 14px; font-family: Euphemia;">LEAVE BALANCE</a>
					</li>
				</ul>
			<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<br>
				<form id="" method="get">
					<br>
					<div id="leaveRecords_itemList" style="padding: 12px;" ></div> 				
				</form>  
				</div><!-- tab1-->
			<div class="tab-pane" id="tab2">
				<br>
				<br>
				<br>
				<form action="#" id="form_leaveBalance">
					<input type="hidden" id="txt_pkid_records" name="txt_pkid_records" value="<?php echo $pkid; ?>"> <br>
				<div class="row">
					<div class="col-sm-5">
						<label class="FormLabel_LB">Employee Name:</label>
						<input type="text" style="width:200px; height:5%;" class="FormText_LB" id="empName" name="empName" readonly>
						<br>
						<label class="FormLabel_LB">Employee number:</label>
						<input type="text" style="width:200px; height:5%;" class="FormText_LB" id="Emp_No" name="Emp_No" readonly>
						<br>
						<br>
						<br>
					<div class="panel panel-info" style="width:100%;" id="panel_vl">
						<div class="panel-heading">
							<b>VACATION LEAVE</b>
						</div>
					<div class="panel-body">
						<label class="FormLeaveLabel">Previous Balance:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="previous_balance_VL" name="previous_balance_VL" value="<?php echo $previous_balance_VL; ?>" readonly>
						<br>
						<label class="FormLeaveLabel">Credit VL for 1 year:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="credit_VL" name="credit_VL" value="<?php echo $credit_VL; ?>" readonly>
						<br>
						<label class="FormLeaveLabel">Credit VL to avail for the month:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="current_avail_VL" name="current_avail_VL" value="<?php echo $current_avail_VL; ?>" readonly>	
						<br>
						<label class="FormLeaveLabel">Total VL used:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_VL_used" name="total_VL_used" value="<?php echo $total_VL_used; ?>" readonly>	
						<br>
						<label class="FormLeaveLabel">Remaining VL balance for the year:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_VL_balance" name="total_VL_balance" value="<?php echo $total_VL_balance; ?>" readonly>	
						<br>
					</div>			
					</div>	
					</div>
					 <div class="col-sm-5">
						<label class="FormLabel_LB">Regularity Date:</label>
						<input type="text" style="width:200px; height:5%;" class="FormText_LB" id="regularity_date" name="regularity_date" readonly>	
						<br>
						<label class="FormLabel_LB"></label>
						<input type="text" style="width:200px; height:5%;" class="FormText_LB" id="hidden_textbox" readonly>	
						<br>
						<br>
						<br>
					<div class="panel panel-info" style="width:100%;" id="panel_sl">
					<div class="panel-heading">
						<b>SICK LEAVE</b>
					</div>
					<div class="panel-body">
						<label class="FormLeaveLabel">Previous Balance:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="previous_balance_SL" name="previous_balance_SL" value="<?php echo $previous_balance_SL; ?>" readonly>
						<br>
						<label class="FormLeaveLabel">Credit SL for 1 year:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="credit_SL" name="credit_SL" value="<?php echo $credit_SL; ?>" readonly>
						<br>
						<label class="FormLeaveLabel">Credit SL to avail for the month:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="current_avail_SL" name="current_avail_SL" value="<?php echo $current_avail_SL; ?>" readonly>	
						<br>
						<label class="FormLeaveLabel">Total SL used:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_SL_used" name="total_SL_used" value="<?php echo $total_SL_used; ?>" readonly>	
						<br>
						<label class="FormLeaveLabel">Remaining SL balance for the year:</label>
						<input type="text" style="width:80px; height:5%; text-align:center; font-size:14px;" class="FormLeaveText" id="total_SL_balance" name="total_SL_balance" value="<?php echo $total_SL_balance; ?>" readonly>	
						<br>
					</div>			
					</div>	
					</div>
				</form>	
			</div><!-- row1-->
				</div><!-- tab2-->
			</div><!-- tab content-->
		</div><!-- tabbable-->
		</div><!-- modal body-->
		<div class="modal-footer">
			<button type="button" id="btn_cancel_leave_modal" class="btn btn-warning" style="border-radius: 0px;font-family: Euphemia;width: 80px; height: 40px;" data-dismiss="modal">CLOSE</button>
		</div>

	</div><!-- modal content-->
</div><!-- modal dialog-->
</div><!-- main modal-->

</body>

<script type="text/javascript">
var selected_pkid = "";
$(document).ready(function(){
$("#leaverecords_tbl_hrd").dataTable({"order": [],
		"columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false,
}]});

$("#leaverecords_tbl_hrd tbody").on('dblclick', 'tr', function(){
		$("#modal-body input").val("");	
		select_leave_records($(this).find("td:eq(0)").text());
	});
	
$("tbody tr").click(function() {
		console.log('clicked');
		$(this).addClass('selected').siblings().removeClass("selected");
	});

$('#btn_cancel_leave_modal').click(function(){
		window.location.href = "hrd_index.php?page=hrd_leave_records.php";
	});	

$("#btn_send_leave_modal").click(function(){
		add_regularity_date($('#txt_pkid_records').val(),status);
    });
	
function select_leave_records(pkid) {
	var data1 = {
		"action"			 : "select_leave_records",
		"pkid"				 : pkid
	}
	data1 = $.param(data1);
	// alert(data1);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data1,
		url			: "elfs_handler.php",
		success		: function (result) {
			$('#Emp_Name').val(result['Emp_Name']);
			$('#Division').val(result['Division']);
			$('#EmpNo').val(result['EmpNo']);
			$('#Department').val(result['Department']);

			$('#txt_pkid_records').val(pkid);
			get_leave_summary(pkid);
			getEmpLeaveBalance_records(pkid);
		$("#Leave_history_balance").modal();
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}

function get_leave_summary(){
	var pkid = $("#txt_pkid_records").val();

	var data = {
		"action"	: "get_leave_summary",
		"pkid"		: pkid
	}
	
	data = $.param(data);
	// alert(data);
	$.ajax({
		type	: "post",
		dataType: "json",
		data	: data,
		url		: "elfs_handler.php",
		success	: function(data){
			
			
			var ctr = data['ctr'];
			$('#leaveRecords_itemList').empty();	
			var html  = '<table id="tbl_leave_records" class="table table-bordered">';
				html += '	<thead>';
				html += '		<tr>';
				html += '			<th><center><font size="2">TYPE OF LEAVE</font></center></th>';
				html += '			<th><center><font size="2">DATE ABSENT </font></center></th>';
				html += '			<th><center><font size="2">NO. OF DAYS</font></center></th>';
				html += '			<th><center><font size="2">PAID LEAVE</font></center></th>';
				html += '			<th><center><font size="2">REASON</font></center></th> ';
				html += '			<th><center><font size="2">OTHER REASON</font></center></th> ';
				html += '		</tr>';
				html += '	</thead>';
				html += '	<tbody>';
				html += '	</tbody>';
				html += '</table>';
				
			$('#leaveRecords_itemList').append(html);	
			
			for(i=0;i<ctr;i++){
			
			if ( data['other_reason'][i] == '0') {
				var reason_label = 'N/A';
			} else if ( data['other_reason'][i] == '1') {
				var reason_label = 'Shut-down';
			} else if ( data['other_reason'][i] == '2') {
				var reason_label = 'Special Non-working Holiday';
			} else if ( data['other_reason'][i] == '3') {
				 var reason_label = 'Others';
			 } 		
			
				var html  = '<tr id="'+data['pkid'][i]+'">';
					html += '   <td style="text-align: center; font-size: 14px;">'+data['leave_applied'][i]+'</td>';
					html += '	<td style="text-align: center;font-size: 13px;">'+data['date_from'][i]+' - '+data['date_to'][i]+'</td>';
					html += '	<td style="text-align: center;font-size: 14px;">'+data['total_absent_days'][i]+'</td>';	
					html += '	<td style="text-align: center;font-size: 14px;">'+data['no_of_paid'][i]+'</td>';	
					html += '	<td style="text-align: left;font-size: 14px;">'+reason_label+'</td>';	
					html += '	<td style="text-align: left;font-size: 14px;">'+data['reason'][i]+'</td>';	
					html += '</tr>';
				 $('#tbl_leave_records tbody').append(html);	
			}
			
			var oTable = $('#tbl_leave_records').DataTable({ 
				paginate:true,
				aaSorting: []				
				});
			table_events();
			
		},error	: function(data){
			alert(data);
		}
	});
}

function table_events(){
	$('#tbl_leave_records tbody tr').click(function(){
		selected_pkid = "";
		$('#tbl_leave_records tbody tr').attr('style','');
		$(this).attr('style','background:teal;color:white;');
		selected_pkid = this.id;
	});
}

function getEmpLeaveBalance_records(pkid) {
	var data1 = {
		"action"			 : "getEmpLeaveBalance_records",
		"pkid"				 : pkid
	}
	data1 = $.param(data1);
	// alert(data1);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data1,
		url			: "elfs_handler.php",
		success		: function (result) {
		
			$('#empName').val(result['empName']);
			$('#Emp_No').val(result['EmpNo']);
			$('#regularity_date').val(result['regularity_date']);
			$('#previous_balance_VL').val(result['previous_balance_VL']);
			$('#credit_VL').val(result['credit_VL']);
			$('#current_avail_VL').val(result['current_avail_VL']);
			$('#total_VL_used').val(result['total_VL_used']);
			$('#total_VL_balance').val(result['total_VL_balance']);
			$('#previous_balance_SL').val(result['previous_balance_SL']);
			$('#credit_SL').val(result['credit_SL']);
			$('#current_avail_SL').val(result['current_avail_SL']);
			$('#total_SL_used').val(result['total_SL_used']);
			$('#total_SL_balance').val(result['total_SL_balance']);

			$('#txt_pkid_records').val(pkid);
		$("#Leave_history_balance").modal();
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}

// Add Regularity date	
function add_regularity_date(pkid) {
	var data1 = {
		"action"				 : "add_regularity_date",
		"pkid"					 : pkid,
		"regularity_date" 		 : $('#regularity_date').val(),
	}
	data1 = $.param(data1);
	// alert(data1);
	$.ajax({
		type		: "POST",
		dataType	: "json",
		data		: data1,
		url			: "elfs_handler.php",
		success		: function (result) {
			
			alert("Successfully updated!");
			window.location.href = "hrd_leave_records.php";

		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}

}); //end 
</script>
	
</html>