<?php
    include("includes.php");
	require_once("elfs_oop.php");
	session_start();

	$username = $_SESSION['username'];
	// $username = 'jangeco';
	
?>
<html lang="en">
<head>
  <meta charset="utf-8">
<!--   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
 -->  
 <style>
		
	#leaveBalance_tbody tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#leaveBalance_tbody tr.selected {
		background-color: #36747a;
		color: #FFF;
	}
	
	#cont .FormLabel{
		width:35%;
		margin-right:5%;
		font-size: 14px;
	}
	
	#cont .FormText{
		margin-bottom:4px;
		width:10%;
		font-size: 14px;
	}
	
	#cont .FormLeaveLabel{
		width:35%;
		margin-right:10%;
		font-size: 14px;
	}
	

	#cont .FormLeaveText{
		margin-bottom:4px;
		width:10%;
		font-size: 14px;
	}
	
	.fa:hover {
		font-size: 20px;
		color: #FFF;
	}
	
	#cont .FormLeaveApplied{
		width:10%;
	}
		
	h4 { 
		display: block;
		font-size: 1.5em;
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
	
	.fa-thumbs-o-down {
	  color: red;
	}

	.fa-thumbs-down {
	  color: red;
	}	

		
</style>
</head>
<body style="margin: 0px; padding: 0px; font-family: Euphemia; background-color:white">
<br>
<br>

<div class="panel panel-primary" style="margin:auto; width:95%;">
<div class="panel-heading">EMPLOYEE LEAVE BALANCE SUMMARY </div>
	<div class="panel-body">	
	<br>
		<a href="#" class="btn btn-warning pull-right" id="btn_new_leave" name="btn_new_leave" style="border-radius: 0px; height: 35px;" title="Click this to add new leave">&nbsp; ADD LEAVE BALANCE&nbsp;</a>
		<br>
		<br>
		<br>
	<form id="" method="get">

		<table id="leaveBalance_tbl" name="leaveBalance_tbl" class="table table-bordered" width="100%">
		<thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee No." data-original-title="">EMP NO.</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Regularity Date" data-original-title="">REGULARITY DATE</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Previous Balance VL" data-original-title="">PREV. BALANCE VL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Credit VL" data-original-title="">CREDIT VL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Current Avail VL" data-original-title="">CURRENT AVAIL VL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total VL used" data-original-title="">TOTAL VL USED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total VL Balance" data-original-title="">TOTAL VL BALANCE</th>
				
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Previous Balance SL" data-original-title="">PREV. BALANCE SL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Credit SL" data-original-title="">CREDIT SL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Current Avail SL" data-original-title="">CURRENT AVAIL SL</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total SL used" data-original-title="">TOTAL SL USED</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total SL Balance" data-original-title="">TOTAL SL BALANCE</th>

		  </tr>
		  </tr>
		</thead>
		<tbody id="leaveBalance_tbody">
			<?php
			$result = ELFS::getInstance()->select_leave_balance();
				while($row = mysqli_fetch_array($result)){
				
				$reg_date = $row['regularity_date'];
				if ($reg_date == '' || $reg_date == '0000-00-00'){
					$regularity_date = '---';
				}else{
					$regularity_date = date('F d, Y',strtotime($reg_date));
				}
				
				echo "
					<tr>	
						<td style='display:none'>".$row['pkid']."</td>
						<td style='text-align: center; font-size: 13px;'>".$row['EmpNo']."</td>
						<td style='text-align: center; font-size: 13px;'>".$row['empName']."</td>
						<td style='text-align: center; font-family: Euphemia; font-size: 13px;'>".$regularity_date."</td>
						<td style='text-align: center; font-size: 13px;'>".$row['previous_balance_VL']."</td>
						<td style='text-align: center; font-size: 13px;'>".$row['credit_VL']."</td>
						<td style='text-align: center; font-size: 13px;'>".$row['current_avail_VL']."</td>
						<td style='text-align: center; font-size: 13px;'><font color='red'>".$row['total_VL_used']."</font></td>
						<td style='text-align: center; font-size: 13px;'><font color='blue'>".$row['total_VL_balance']."</font></td>

						<td style='text-align: center; font-size: 13px;'>".$row['previous_balance_SL']."</td>
						<td style='text-align: center; font-size: 13px;'>".$row['credit_SL']."</td>
						<td style='text-align: center; font-size: 13px;'>".$row['current_avail_SL']."</td>
						<td style='text-align: center; font-size: 13px;'><font color='red'>".$row['total_SL_used']."</font></td>
						<td style='text-align: center; font-size: 13px;'><font color='blue'>".$row['total_SL_balance']."</font></td>
					</tr>
					";

		}
			?>
		</tbody>
		</table>
	</form>
	</div>
</div> 

<!-- Modal new balance-->	
<div class="modal fade" id="Leave_balance_modal_new" role="dialog">
	<div class="modal-dialog" style="width:40%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4>LEAVE BALANCE MODULE</h4>
			</div>
		<div class="modal-body" id="cont">	
			<form action="#" id="form_NewLeave" data-confirm="Are you sure you want to save this leave balance?">
				<input type="hidden" id="fkEmployee_new" name="fkEmployee_new" value="<?php echo $row['pkid']; ?>">	

				<br>
					<label class="FormLabel">EmpNo.:</label>
					<select class="FormText" id="EmpNo_new" name="EmpNo_new" style="width:220px; height:4%;"> 
						<option value='0'>--Select--</option>
						<?php
							$query = ELFS::getInstance()->select_EmpNo_list();
							while($row = mysqli_fetch_array($query)) {
								echo '<option value='.$row['pkid'].'>'.$row['EmpNo'].'</option>';
							}					
						?>
					</select>			
					<br>
									
					<label class="FormLabel">Employee Name:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="empName_new" name="empName_new" readonly>	
					<br>
					
					<label class="FormLabel">Regularity date:</label>
					<input type="date" style="width:220px; height:4%;" class="FormText" id="regularity_date_new" name="regularity_date_new" >	
					<br>
					
					<label class="FormLabel">Prevoius balance VL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="previous_balance_VL_new" >	
					<br>

					<label class="FormLabel">Credit VL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="credit_VL_new" >	
					<br>
					
					<label class="FormLabel">Current avail VL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="current_avail_VL_new" >	
					<br>
					
					<label class="FormLabel">Total VL used:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="total_VL_used_new" >	
					<br>
					
					<label class="FormLabel">Total VL balance:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="total_VL_balance_new" readonly>	
					<br>
					<br>

					<label class="FormLabel">Prevoius balance SL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="previous_balance_SL_new" name="previous_balance_SL_new" >	
					<br>

					<label class="FormLabel">Credit SL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="credit_SL_new" name="credit_SL_new" >	
					<br>
					
					<label class="FormLabel">Current avail SL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="current_avail_SL_new" name="current_avail_SL_new" >	
					<br>
					
					<label class="FormLabel">Total SL used:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="total_SL_used_new" name="total_SL_used_new" >	
					<br>
					
					<label class="FormLabel">Total SL balance:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="total_SL_balance_new" name="total_SL_balance_new" readonly>	
					<br>
				
			<div class="modal-footer">
				<button type="submit" id="btn_leave" class="btn btn-primary" style="border-radius: 0px;font-family: Euphemia;width:80px; height: 40px;">SAVE</button>
				<button type="button" id="btn_cancel_leaveBalance" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia;width:80px; height: 40px;" data-dismiss="modal">CANCEL</button>
			</div>
			</form>	
		</div>
		</div>
</div>
</div>

<!-- Modal update leave-->	
<div class="modal fade" id="Leave_balance_modal" role="dialog">
	<div class="modal-dialog" style="width:50%">
		<div class="modal-content">
			<div class="modal-header modal-header-default">
				<h4>LEAVE BALANCE UPDATE MODULE</h4>
			</div>
		<div class="modal-body" id="cont">	
			<form action="#" id="form_UpdateLeave">
				<input type="hidden" id="update_txt_pkid" name="update_txt_pkid" value="<?php echo $pkid; ?>"> 
				<br>
					<label class="FormLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="EmpNo" name="EmpNo" >
					<br>
					<label class="FormLabel">Employee Name:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="empName" name="empName" readonly>
					<br>
					<label class="FormLabel">Regularity date:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="regularity_date" name="regularity_date" >	
					<br>
					<label class="FormLabel">Prevoius balance VL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="previous_balance_VL" name="previous_balance_VL" >	
					<br>

					<label class="FormLabel">Credit VL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="credit_VL" name="credit_VL" >	
					<br>
					
					<label class="FormLabel">Current avail VL:</label> <!-- Update current avial VL -->
					<input type="text" style="width:220px; height:4%;" class="FormText" id="current_avail_VL" name="current_avail_VL" readonly>	
					<br>
					
					<label class="FormLabel">Total VL used:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="total_VL_used" name="total_VL_used" >	
					<br>
					
					<label class="FormLabel">Total VL balance:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="total_VL_balance" name="total_VL_balance" readonly >	
					<br>
					<br>
					
					<label class="FormLabel">Prevoius balance SL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="previous_balance_SL" name="previous_balance_SL" >	
					<br>

					<label class="FormLabel">Credit SL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="credit_SL" name="credit_SL" >	
					<br>
					
					<label class="FormLabel">Current avail SL:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="current_avail_SL" name="current_avail_SL" >	
					<br>
					
					<label class="FormLabel">Total SL used:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="total_SL_used" name="total_SL_used" >	
					<br>
					
					<label class="FormLabel">Total SL balance:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="total_SL_balance" name="total_SL_balance" readonly >	
					<br>

				
			<div class="modal-footer">
				<button type="submit" id="btn_update_leave" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia;width:80px;">UPDATE</button>
				<button type="button" id="btn_cancel_update_leaveBalance" class="btn btn-primary" style="border-radius: 0px;font-family: Euphemia;width:80px;" data-dismiss="modal">CANCEL</button>
			</div>
			</form>	
		</div>
		</div>
</div>
</div>

</body>

<script type="text/javascript">

$(document).ready(function(){
	$("#leaveBalance_tbl").dataTable({"order": [],
	"columnDefs": [ {
	  "targets"  : 'no-sort',
	  "orderable": false,
	}]});
});

$("#leaveBalance_tbl tbody").on('dblclick', 'tr', function(){
	$("#modal-body input").val("");	
	select_leave_balance_info($(this).find("td:eq(0)").text());
});

$(document).ready(function () {
$( "#regularity_date" ).datepicker({
  changeMonth: true,
  changeYear: true 
});
});

$('#btn_cancel_update_leaveBalance').click(function(){
	window.location.href = "leave_balance_update_module.php";
});	

$('#btn_cancel_leaveBalance').click(function(){
	window.location.href = "leave_balance_update_module.php";
});

$("#btn_update_leave").click(function(){			
	update_Leave_balance($('#update_txt_pkid').val());
});

// Select Employee leave balance
function select_leave_balance_info(pkid) {
	var data1 = {
		"action"			 : "select_leave_balance_info",
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
		
			$('#EmpNo').val(result['EmpNo']);
			$('#empName').val(result['empName']);
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

			$('#update_txt_pkid').val(pkid);	
			$("#Leave_balance_modal").modal();
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}	

///////////////////UPDATE BALANCE/////////////////////////////
// Update approver status	
function update_Leave_balance(pkid) {
	var data1 = {
		"action"				 : "update_Leave_balance",
		"pkid"					 : pkid,
		"regularity_date"		 : $('#regularity_date').val(),
		"previous_balance_VL"	 : $('#previous_balance_VL').val(),
		"credit_VL"		 		 : $('#credit_VL').val(),
		"current_avail_VL"		 : $('#current_avail_VL').val(),
		"total_VL_used"			 : $('#total_VL_used').val(),
		"total_VL_balance"		 : $('#total_VL_balance').val(),
		"previous_balance_SL"	 : $('#previous_balance_SL').val(),
		"credit_SL"		 		 : $('#credit_SL').val(),
		"current_avail_SL"		 : $('#current_avail_SL').val(),
		"total_SL_used"			 : $('#total_SL_used').val(),
		"total_SL_balance"		 : $('#total_SL_balance').val()
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
		window.location.href = "leave_balance_update_module.php";

		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}

//Update Emp. VL Balance 	
$('#previous_balance_VL, #credit_VL, #current_avail_VL, #total_VL_used').on('input',function() {
    var previous_balance_VL = $('#previous_balance_VL').val();
    var total_VL_used = $('#total_VL_used').val();
    var credit_VL = $('#credit_VL').val();
    var current_avail_VL = $('#current_avail_VL').val();
	
	var avail_VL = (parseFloat(previous_balance_VL) - parseFloat(total_VL_used));
	$('#current_avail_VL').val((avail_VL).toFixed(1));
			
	var total_VLbalance = (parseFloat(credit_VL) + parseFloat(previous_balance_VL) - parseFloat(total_VL_used));
	$('#total_VL_balance').val((total_VLbalance).toFixed(1));

});

//Update Emp. SL Balance 	
$('#previous_balance_SL, #credit_SL, #current_avail_SL, #total_SL_used').on('input',function() {
    var previous_balance_SL = $('#previous_balance_SL').val();
    var total_SL_used = $('#total_SL_used').val();
    var credit_SL = $('#credit_SL').val();
    var current_avail_SL = $('#current_avail_SL').val();
		

	var total_SLbalance = (parseFloat(credit_SL));
	// var total_SLbalance = (parseFloat(credit_SL) + parseFloat(current_avail_SL) - parseFloat(total_SL_used));
	// var total_SLbalance = (parseFloat(credit_SL) - parseFloat(total_SL_used));
	// var total_SLbalance = (parseFloat(previous_balance_SL) + parseFloat(credit_SL) - parseFloat(total_SL_used));
    $('#total_SL_balance').val((total_SLbalance).toFixed(1));
});
	
//////////////////////NEW BALANCE/////////////////////////////
$('#btn_new_leave').click(function(){
	$('#Leave_balance_modal_new').modal('show'); 
});	

//Update Emp. VL Balance 	
/* $('#previous_balance_VL_new, #credit_VL_new, #current_avail_VL_new, #total_VL_used_new').on('input',function() {
    var previous_balance_VL_new = $('#previous_balance_VL_new').val();
    var total_VL_used_new = $('#total_VL_used_new').val();
    var credit_VL_new = $('#credit_VL_new').val();
    var current_avail_VL_new = $('#current_avail_VL_new').val();
	
	var avail_VL_new = (parseFloat(previous_balance_VL_new) - parseFloat(total_VL_used_new));
	// var avail_VL_new = (parseFloat(previous_balance_VL_new));
	$('#current_avail_VL_new').val((avail_VL_new).toFixed(1));
	
	var total_VLbalance_new = (parseFloat(credit_VL_new) + parseFloat(previous_balance_VL_new));
	$('#total_VL_balance_new').val((total_VLbalance_new).toFixed(1));

}); */

$('#previous_balance_VL_new, #credit_VL_new, #current_avail_VL_new, #total_VL_used_new').on('input',function() {
    var previous_balance_VL_new = $('#previous_balance_VL_new').val();
    var total_VL_used_new = $('#total_VL_used_new').val();
    var credit_VL_new = $('#credit_VL_new').val();
    var current_avail_VL_new = $('#current_avail_VL_new').val();
	
	// var avail_VL_new = (parseFloat(previous_balance_VL_new) - parseFloat(total_VL_used_new));
	// var avail_VL_new = (parseFloat(previous_balance_VL_new));
	// $('#current_avail_VL_new').val((avail_VL_new).toFixed(1));
	
	var total_VLbalance_new = (parseFloat(credit_VL_new) + parseFloat(previous_balance_VL_new));
	$('#total_VL_balance_new').val((total_VLbalance_new).toFixed(1));

}); 

//Update Emp. SL Balance 	
$('#previous_balance_SL_new, #credit_SL_new, #current_avail_SL_new, #total_SL_used_new').on('input',function() {
    var previous_balance_SL_new = $('#previous_balance_SL_new').val();
    var total_SL_used_new = $('#total_SL_used_new').val();
    var credit_SL_new = $('#credit_SL_new').val();
    var current_avail_SL_new = $('#current_avail_SL_new').val();
		

	var total_SLbalance_new = (parseFloat(credit_SL_new));
    $('#total_SL_balance_new').val((total_SLbalance_new).toFixed(1));
});
 
 
$('#EmpNo_new').change(function () {
	if($('#EmpNo_new').val() != 0) {
		var data = {
			"action": "select_EmpNo_list_by_pkid",
			"pkid"	: $('#EmpNo_new').val()
		}
		data = $.param(data);
		// alert(data);
		$.ajax({
			type	: "POST",
			dataType: "json",
			data	: data,
			url		: "elfs_handler.php",
			success	: function (result) {
				$('#fkEmployee_new').val(result['pkid']);
			}, error: function (result) {
				alert("ERROR: "+result);
			}
		});
	} else {
		$('#fkEmployee_new').val('');
	}
}); 
 

 /* Submit Function */ 	
$('#form_NewLeave').submit(function(e){

 if(confirm($(this).data('confirm'))){
	e.preventDefault();
 } else {
	return false;
}
	var data = {
		"action"				 : 'AddNewLeaveBalance',
		"fkEmployee"			 : $('#fkEmployee_new').val(),
		"EmpNo"		 			 : $('#EmpNo_new option:selected').text(),
		"empName"				 : $('#empName_new').val(),
		"regularity_date"		 : $('#regularity_date_new').val(),
		
		"previous_balance_VL"	 : $('#previous_balance_VL_new').val(),
		"credit_VL"				 : $('#credit_VL_new').val(),
		"current_avail_VL"		 : $('#current_avail_VL_new').val(),
		"total_VL_used"			 : $('#total_VL_used_new').val(),
		"total_VL_balance"		 : $('#total_VL_balance_new').val(),

		"previous_balance_SL"	 : $('#previous_balance_SL_new').val(),
		"credit_SL"				 : $('#credit_SL_new').val(),
		"current_avail_SL"		 : $('#current_avail_SL_new').val(),
		"total_SL_used"			 : $('#total_SL_used_new').val(),
		"total_SL_balance"		 : $('#total_SL_balance_new').val()
	}
	data = $.param(data);
	// alert(data);
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		data	: data,
		url		: 'elfs_handler.php',
		success	: function(data){	
		
			alert("Leave balance has been added!");
			window.location.href = "leave_balance_update_module.php";
		},error(data){
			alert('ERROR MAIN');
		}
	});
});

$('#EmpNo_new').change(function () {
		if($('#EmpNo_new').val() != 0) {
			var data = {
				"action": "select_EmpNo_list_by_pkid",
				"pkid"	: $('#EmpNo_new').val()
			}
			data = $.param(data);
			// alert(data);
			$.ajax({
				type	: "POST",
				dataType: "json",
				data	: data,
				url		: "elfs_handler.php",
				success	: function (result) {
					$('#empName_new').val(result['empName']);
				}, error: function (result) {
					alert("ERROR: "+result);
				}
			});
		} else {
			$('#empName_new').val('');
		}
	});


</script>
	
</html>