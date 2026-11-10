<?php
    include("includes.php");
	require_once("elfs_oop.php");
	session_start();

	$username = $_SESSION['username'];
	// $username = 'jangeco';
	
?>
<html lang="en">
<head>
  
 <style>
		
	#tbody_leave_conversion tr:hover{
		background-color: #36747a;
		color: #FFF;
	}

	#tbody_leave_conversion tr.selected {
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
	
	.fa:hover {
		font-size: 20px;
		color: #FFF;
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
<div class="panel-heading">VL CONVERSION</div>
	<div class="panel-body">	
	<br>
		<a href="#" class="btn btn-warning pull-right" id="btn_new_leave_conversion" name="btn_new_leave_conversion" style="border-radius: 0px; height: 35px;">&nbsp; ADD VL CONVERSION &nbsp;</a>
		<br>
		<br>
		<br>

		<table id="tbl_leave_conversion" name="tbl_leave_conversion" class="table table-bordered" width="100%">
		<thead>
			<tr>
				<th style="text-align: center; vertical-align: middle;" class="hide">pkid</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee No." data-original-title="">EMP NO.</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Name" data-original-title="">EMPLOYEE NAME</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Employee Type" data-original-title="">EMPLOYEE TYPE</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Date of Conversion" data-original-title="">DATE OF CONVERSION</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total VL Balance" data-original-title="">VL BALANCE</th>
				<th style="text-align: center; vertical-align: middle; font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Sort by Total VL Balance" data-original-title="">VL CONVERTIBLE TO CASH</th>
			</tr>
		</thead>
		<tbody id="tbody_leave_conversion">
			<?php
			$result = ELFS::getInstance()->select_leave_conversion();
				while($row = mysqli_fetch_array($result)){
					
					if ( $row['SalaryType'] == 1){
						$SalaryType = 'Daily';
					}else if ( $row['SalaryType'] == 2){
						$SalaryType = 'Monthly';
					}else if ( $row['SalaryType'] == 3){
						$SalaryType = 'Confidential';
					}else if ( $row['SalaryType'] == 4){
						$SalaryType = 'JS/SS';
					}		
					
				echo "
					<tr>	
						<td style='display:none'>".$row['pkid']."</td>
						<td style='text-align: center; font-size: 13px;'>".$row['EmpNo']."</td>
						<td style='text-align: center; font-size: 13px;'>".$row['empName']."</td>
						<td style='text-align: center; font-size: 13px;'>".$SalaryType."</td>
						<td style='text-align: center; font-size: 13px;'>".date('F d, Y',strtotime($row['date_conversion']))."</td>
						<td style='text-align: center; font-size: 13px;'><font color='blue'>".$row['vl_balance']."</font></td>
						<td style='text-align: center; font-size: 13px;'><font color='blue'>".$row['vl_convertible']."</font></td>
					</tr>
					";
				}
			?>
		</tbody>
		</table>

	</div>
</div> 

<div class="modal fade" id="id_new_leave_conversion" role="dialog">
	<div class="modal-dialog" style="width:40%">
		<div class="modal-content">
		
			<div class="modal-header modal-header-default">
				<h4>VL CONVERSION</h4>
			</div>
			
		<div class="modal-body" id="cont">	
		
			<form action="#" id="form_new_leave_conversion" data-confirm="Are you sure you want to save this leave conversion?">
				<input type="hidden" id="id_pkid_empInfo" name="name_pkid_empInfo" value="<?php echo $row['pkid']; ?>">	
				<input type="hidden" id="id_salaryType" name="name_salaryType" value="<?php echo $row['SalaryType']; ?>">	
				<input type="hidden" id="id_username" name="name_username" value="<?php echo $row['username']; ?>">	
				<br>
				
				<label class="FormLabel">Date Created:</label>
				<input type="text" style="width:220px; height:4%;" class="FormText" id="id_date_conversion" name="name_date_conversion" value="<?php echo date("Y-m-d") ; ?>" readonly>	
				<br>

				<label class="FormLabel">EmpNo.:</label>
				<select class="FormText" id="id_empNo" name="name_empNo" style="width:220px; height:4%;"> 
					<option value='0'>--Select--</option>
					<?php
						$query = ELFS::getInstance()->select_empNo();
							while($row = mysqli_fetch_array($query)) {
							echo '<option value='.$row['pkid'].'>'.$row['EmpNo'].'</option>';
						}					
					?>
				</select>			
				<br>

				<label class="FormLabel">Employee Name:</label>
				<input type="text" style="width:220px; height:4%;" class="FormText" id="id_empName" name="name_empName" readonly>	
				<br>
				
				<label class="FormLabel">VL BALANCE:</label>
				<input type="text" style="width:220px; height:4%;" class="FormText" id="id_leave_balance" name="name_leave_balance" >	
				<br>
				
				<!-- 10272020 -->
				<label class="FormLabel">VL RETENTION FY 2020:</label>
				<input type="text" style="width:220px; height:4%; color:blue;" class="FormText" id="id_leave_retention" name="name_leave_retention" value="2" readonly>	
				<br>

				<label class="FormLabel">VL CONVERTIBLE:</label>
				<input type="text" style="width:220px; height:4%; color:green;" class="FormText" id="id_leave_convertible" name="name_leave_convertible" >	
				<br>

				<div class="modal-footer">
					<button type="submit" id="btn_add_leave_conversion" class="btn btn-primary" style="border-radius: 0px;font-family: Euphemia;width:80px; height: 40px;">SAVE</button>
					<button type="button" id="btn_cancel_leave_conversion" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia;width:80px; height: 40px;" data-dismiss="modal">CANCEL</button>
				</div>
				
			</form>	
		</div>
		
		</div>
	</div>
</div>

<div class="modal fade" id="id_update_leave_conversion" role="dialog">
	<div class="modal-dialog" style="width:50%">
		<div class="modal-content">
		
			<div class="modal-header modal-header-default">
				<h4>UPDATE VL CONVERTION</h4>
			</div>
			
		<div class="modal-body" id="cont">	
		
			<form action="#" id="form_update_leave_conversion">
				<input type="hidden" id="id_update_pkid" name="name_update_pkid" value="<?php echo $pkid; ?>"> 
				<br>
				
					<label class="FormLabel">EmpNo.:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="id_update_EmpNo" name="name_update_EmpNo" >
					<br>
					
					<label class="FormLabel">Employee Name:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="id_update_empName" name="name_update_empName" readonly>
					<br>
					
					<label class="FormLabel">Date:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="id_update_date_conversion" name="name_update_date_conversion" readonly>	
					<br>
					
					<label class="FormLabel">VL BALANCE:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="id_update_leave_balance" name="name_update_leave_balance" >	
					<br>
					
					<label class="FormLabel">VL CONVERTIBLE:</label>
					<input type="text" style="width:220px; height:4%;" class="FormText" id="id_update_leave_convertible" name="name_update_leave_convertible" >	
					<br>
				
			<div class="modal-footer">
				<button type="submit" id="btn_update_leave_conversion" class="btn btn-danger" style="border-radius: 0px;font-family: Euphemia;width:80px;">UPDATE</button>
				<button type="button" id="btn_cancel_update_leave_conversion" class="btn btn-primary" style="border-radius: 0px;font-family: Euphemia;width:80px;" data-dismiss="modal">CANCEL</button>
			</div>
			
			</form>	
		</div>
		
		</div>
	</div>
</div>

</body>

<script type="text/javascript">

$(document).ready(function(){
	
	$("#tbl_leave_conversion").dataTable({"order": [],
		"columnDefs": [{
		  "targets"  : 'no-sort',
		  "orderable": false,
		}]
	});
	
	$("#tbl_leave_conversion tbody").on('dblclick', 'tr', function(){
		$("#modal-body input").val("");	
		select_leave_conversion_info($(this).find("td:eq(0)").text());
	});
	
	$('#btn_new_leave_conversion').click(function(){
		$('#id_new_leave_conversion').modal('show'); 
	});	

	$('#btn_cancel_leave_conversion').click(function(){
		location.reload();
	});
	
	$('#btn_cancel_update_leave_conversion').click(function(){
		location.reload();
	});	

	$("#btn_update_leave_conversion").click(function(){			
		update_leave_conversion($('#id_update_pkid').val());
	});

});

// Get empInfo. pkid 
$('#id_empNo').change(function () {
	if($('#id_empNo').val() != 0) {
		var data = {
			"action": "select_EmpNo_list_by_pkid",
			"pkid"	: $('#id_empNo').val()
		}
		data = $.param(data);
		// alert(data);
		$.ajax({
			type	: "POST",
			dataType: "json",
			data	: data,
			url		: "elfs_handler.php",
			success	: function (result) {
				
				$('#id_pkid_empInfo').val(result['pkid']);
				$('#id_salaryType').val(result['SalaryType']);
				$('#id_username').val(result['username']);
				
			}, error: function (result) {
				alert("ERROR: "+result);
			}
		});
	} else {
		$('#id_pkid_empInfo').val('');
		$('#id_salaryType').val('');
		$('#id_username').val('');
	}
}); 

// Get empName 
$('#id_empNo').change(function () {
	if($('#id_empNo').val() != 0) {
		var data = {
			"action": "select_EmpNo_list_by_pkid",
			"pkid"	: $('#id_empNo').val()
		}
		data = $.param(data);
		// alert(data);
		$.ajax({
			type	: "POST",
			dataType: "json",
			data	: data,
			url		: "elfs_handler.php",
			success	: function (result) {
				
				$('#id_empName').val(result['empName']);
				$('#id_leave_balance').val(result['total_VL_balance']);
				
				var total_VL_convertible = (parseFloat(result['total_VL_balance']) - 2 ); //- 10272020 - Requested for FY 2020
				// var total_VL_convertible = (parseFloat(result['total_VL_balance']) - 6 ); //-Orig convertion
				
				if ( result['total_VL_balance'] < 2){
					$('#id_leave_convertible').val('N/A');
				}else{
					$('#id_leave_convertible').val((total_VL_convertible).toFixed(1));
				}
	
	
	
			}, error: function (result) {
				alert("ERROR: "+result);
			}
		});
	} else {
		$('#id_empName').val('');
		$('#id_leave_balance').val('');
	}
});
 
 
function select_leave_conversion_info(pkid) {
	
	var data1 = {
		"action"			 : "select_leave_conversion_info",
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
		
			$('#id_update_EmpNo').val(result['EmpNo']);
			$('#id_update_empName').val(result['empName']);
			$('#id_update_date_conversion').val(result['date_conversion']);
			$('#id_update_leave_balance').val(result['vl_balance']);
			$('#id_update_leave_convertible').val(result['vl_convertible']);

			$('#id_update_pkid').val(pkid);	
			$("#id_update_leave_conversion").modal();
		}, error	: function (result) {
		alert('ERROR: '+result);
		}
	});
}	

function update_leave_conversion(pkid) {
	var data1 = {
		"action"			 : "update_leave_conversion",
		"pkid"				 : pkid,
		"vl_balance"		 : $('#id_update_leave_balance').val(),
		"vl_convertible"	 : $('#id_update_leave_convertible').val()
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
		location.reload();

		}, error	: function (result) {
			alert('ERROR: '+result);
		}
	});
}

$('#form_new_leave_conversion').submit(function(e){

	if(confirm($(this).data('confirm'))){
		e.preventDefault();
	} else {
		return false;
	}
		
	var data = {
		"action"				 : 'add_new_leave_conversion',
		"fkEmployee"			 : $('#id_pkid_empInfo').val(),
		"EmpNo"		 			 : $('#id_empNo option:selected').text(),
		"username"				 : $('#id_username').val(),
		"empName"				 : $('#id_empName').val(),
		"SalaryType"			 : $('#id_salaryType').val(),
		"date_conversion"		 : $('#id_date_conversion').val(),
		"vl_balance"			 : $('#id_leave_balance').val(),
		"vl_convertible"		 : $('#id_leave_convertible').val()
	}
	data = $.param(data);
	// alert(data);
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		data	: data,
		url		: 'elfs_handler.php',
		success	: function(data){	
		
			alert("Leave conversion has been added!");
			location.reload();
		},error(data){
			alert('ERROR MAIN');
		}
	});
	
});




</script>
	
</html>