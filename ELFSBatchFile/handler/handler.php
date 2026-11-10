<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				/* do not edit below */
				case "populate_chosen_dropdown"						: populate_chosen_dropdown(); 	break; 
				case "load_employee_information"					: load_employee_information(); 	break; 
				case "encode" 										: encode(); 					break; 
				case "decode" 										: decode(); 					break;
				case "get_empno" 									: get_empno(); 					break; 
				case "get_empno_chosen" 							: get_empno_chosen(); 					break; 
				case "get_fullname_chosen" 							: get_fullname_chosen();				break; 
				case "save_subordinate" 							: save_subordinate(); 			break; 
				case "subordinate_for_removal" 						: subordinate_for_removal();	break; 
				case "subordinate_for_edit" 						: subordinate_for_edit();		break; 
				case "remove_subordinate" 							: remove_subordinate();			break; 
				case "update_superior" 								: update_superior();				break; 
				case "check_session" 								: check_session();				break; 
				case "load_records" 								: load_records(); 				break; 
				case "add_new_record" 								: add_new_record(); 			break; 
				case "update_fetch_record" 							: update_fetch_record(); 		break; 
				case "update_record" 								: update_record(); 				break; 
				case "delete_record" 								: delete_record(); 				break; 
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function populate_chosen_dropdown(){
		require_once('../class/oop.php');
		$empno = $_POST['empno'];
		$list = $_POST['list'];
		$return = array();
		if($list == 'empno'){
			$array_fields = array('EmpNo');
			$field = 'EmpNo';
		}else{
			$array_fields = array('CONCAT(LastName,", ",FirstName) AS FullName');
			$field = 'FullName';
		}
		$table 	   	= 'tbl_EmployeeInfo';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `EmpStatus`="1" OR `EmpStatus`="3"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['html'] = '';
		while($row = mysqli_fetch_array($result)){
			$return['html'] .= '<option>'.$row[$field].'</option>';
		}
		echo json_encode($return);
	}
	
	function load_employee_information(){
		require_once('../class/oop.php');
		$empno = $_POST['empno'];
		$return = array();
		$array_fields = array('*');
		$table 	   	= 'vw_employeeinfo';
		$joins 	   	= '';
		$sql_where 	= 'WHERE EmpNo ="'.$empno.'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['EmpNo'] 		= $row['EmpNo'];
			$return['FullName']		= $row['LastName'].', '.$row['FirstName'];
			$return['Division'] 	= $row['Division'];
			$return['Department'] 	= $row['Department'];
			$return['Section'] 		= $row['Section'];
			$return['Position']		= $row['Position'];
		}
		echo json_encode($return);
	}
	
	
	/* convert an array to encode base64 and serialize */
	function encode(){
		$str = base64_encode(serialize($_POST));
		echo json_encode($str);
	}

	/* revert to normal array, decode str to base64 and unserialize */
	function decode(){
		$array = unserialize(base64_decode($_POST));
		echo json_encode($array);
	}
	
	function get_empno(){
		require_once('../class/oop.php'); 
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'vw_requestor';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username ="'.$_POST['username'].'"';
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['EmpNo'] 		= $row['EmpNo'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function get_empno_chosen(){
		require_once('../class/oop.php'); 
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_EmployeeInfo';
		$joins 	   	= '';
		$sql_where 	= 'WHERE CONCAT(LastName,", ",FirstName) ="'.$_POST['fullname'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['EmpNo'] 		= $row['EmpNo'];
		}
		// $result = SMS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// $return['result'] = $result;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function get_fullname_chosen(){
		require_once('../class/oop.php'); 
		$return = $_POST;
		$result = "";
		$array_fields = array('CONCAT(LastName,", ",FirstName) AS FullName');
		$table 	   	= 'tbl_EmployeeInfo';
		$joins 	   	= '';
		$sql_where 	= 'WHERE EmpNo ="'.$_POST['empno'].'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['FullName'] 		= $row['FullName'];
		}
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function save_subordinate(){
		require_once('../class/oop.php'); 
		$empno = $_POST['user_empno'];
		$array_empno = $_POST['array_empno'];
		$return = array();
		$return['message'] = '';
		for($x=0;$x<count($array_empno);$x++){
			/* check if item already assigned to another */
			$array_fields = array('SectionHead','Subordinate');
			$table 	   	= 'tbl_Subordinate';
			$joins 	   	= '';
			$sql_where 	= 'WHERE Subordinate ="'.$array_empno[$x].'" AND `logdel` = "0"';
			$sql_order 	= 'ORDER BY pkid';
			$sql_limit 	= '';
			$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)){
				/* save to 1 varialbe if employee has already been assigned with section head */
				if( !isset($return['existing']['empno']) ){
					$return['existing']['empno'] = array();
				}
				$return['existing']['SectionHead'][] = $row['SectionHead'];
				$return['existing']['empno'][] = $row['Subordinate'];
			}
		}
		if(isset($return['existing']['empno'])){
			/* Generate system message */
			$return['message'] .= '<h4>Employee with existing superior: </h4>';
			$return['message'] .= '<table class="table table-bordered">';
			$return['message'] .= '	<thead>';
			$return['message'] .= '		<tr>';
			$return['message'] .= '			<th>Section Head</th>';
			$return['message'] .= '			<th>Employee Number</th>';
			$return['message'] .= '		</tr>';
			$return['message'] .= '	</thead>';
			$return['message'] .= '	<tbody>';
			for($x=0;$x<count($return['existing']['empno']);$x++){
				$return['message'] .= '		<tr>';
				$return['message'] .= '			<td>'.$return['existing']['SectionHead'][$x].'</td>';
				$return['message'] .= '			<td>'.$return['existing']['empno'][$x].'</td>';
				$return['message'] .= '		</tr>';
			}
			$return['message'] .= '	</tbody>';
			$return['message'] .= '</table>';
			$return['exist'] = 1;
		}else{
			for($x=0;$x<count($array_empno);$x++){
				/* save data to tbl_subordinate */
				$return 		= $_POST; 
				$result 		= "";
				$table   		= "tbl_Subordinate"; //table name
				$array_fields 	= array('SectionHead','Subordinate','lastupdate'); //table fields
				$array_values 	= array($empno,$array_empno[$x],date('Y-m-d H:i:s')); //values to be saved
				$result 		= SMS::getInstance()->insert_query($table,$array_fields,$array_values);
				$return['exist'] = 0;
			}
		}
		echo json_encode($return);
	}
	
	function subordinate_for_removal(){
		require_once('../class/oop.php'); 
		$SectionHead = $_POST['SectionHead'];
		$array_empno = $_POST['array_empno'];
		$return = array();
		$return['html']  = '<table class="table table-bordered">';
		$return['html'] .= '	<thead>';
		$return['html'] .= '		<tr>';
		$return['html'] .= '			<th>EmpNo</th>';
		$return['html'] .= '			<th>Fullname</th>';
		$return['html'] .= '			<th>Division</th>';
		$return['html'] .= '			<th>Department</th>';
		$return['html'] .= '			<th>Section</th>';
		$return['html'] .= '			<th>Position</th>';
		$return['html'] .= '		</tr>';
		$return['html'] .= '	</thead>';
		$return['html'] .= '	<tbody>';
		for($x=0;$x<count($array_empno);$x++){
			$result = "";
			$array_fields = array('*');
			$table 	   	= 'vw_subordinate_list';
			$joins 	   	= '';
			$sql_where 	= 'WHERE `Subordinate` = "'.$array_empno[$x].'" AND `SectionHead` = "'.$SectionHead.'"';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			while($row = mysqli_fetch_array($result)){
				$return['html'] .= '		<tr>';
				$return['html'] .= '			<td>'.$row['Subordinate'].'</td>';
				$return['html'] .= '			<td>'.$row['FullName'].'</td>';
				$return['html'] .= '			<td>'.$row['Division'].'</td>';
				$return['html'] .= '			<td>'.$row['Department'].'</td>';
				$return['html'] .= '			<td>'.$row['Section'].'</td>';
				$return['html'] .= '			<td>'.$row['Position'].'</td>';
				$return['html'] .= '		</tr>';
			}
		}
		$return['html'] .= '	</tbody>';
		$return['html'] .= '</table>';
		echo json_encode($return);
	}
	
	function subordinate_for_edit(){
		require_once('../class/oop.php'); 
		$array_empno = $_POST['array_empno'];
		$return = array();
		$return['html']  = '<table class="table table-bordered">';
		$return['html'] .= '	<thead>';
		$return['html'] .= '		<tr>';
		$return['html'] .= '			<th>Superior</th>';
		$return['html'] .= '			<th>Employee #</th>';
		$return['html'] .= '			<th>Employee Name</th>';
		$return['html'] .= '			<th>Division</th>';
		$return['html'] .= '			<th>Department</th>';
		$return['html'] .= '			<th>Section</th>';
		$return['html'] .= '			<th>Position</th>';
		$return['html'] .= '		</tr>';
		$return['html'] .= '	</thead>';
		$return['html'] .= '	<tbody>';
		for($x=0;$x<count($array_empno);$x++){
			$result = "";
			$array_fields = array('*');
			$table 	   	= 'vw_subordinate_list_admin';
			$joins 	   	= '';
			$sql_where 	= 'WHERE `Subordinate` = "'.$array_empno[$x].'"';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			while($row = mysqli_fetch_array($result)){
				$return['html'] .= '		<tr>';
				$return['html'] .= '			<td>'.$row['SectionHead'].'</td>';
				$return['html'] .= '			<td>'.$row['Subordinate'].'</td>';
				$return['html'] .= '			<td>'.$row['FullName'].'</td>';
				$return['html'] .= '			<td>'.$row['Division'].'</td>';
				$return['html'] .= '			<td>'.$row['Department'].'</td>';
				$return['html'] .= '			<td>'.$row['Section'].'</td>';
				$return['html'] .= '			<td>'.$row['Position'].'</td>';
				$return['html'] .= '		</tr>';
			}
		}
		$return['html'] .= '	</tbody>';
		$return['html'] .= '</table>';
		echo json_encode($return);
	}

	function remove_subordinate(){
		require_once('../class/oop.php'); 
		$SectionHead = $_POST['SectionHead'];
		$array_empno = $_POST['array_empno'];
		$return = array();
		$return['result'] = '';
		for($x=0;$x<count($array_empno);$x++){
			$table = "tbl_Subordinate";
			$array_fields = array('logdel');
			$array_values = array('1');
			$where 	= 'WHERE `Subordinate` = "'.$array_empno[$x].'" AND `SectionHead` = "'.$SectionHead.'"';
			$result = SMS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
			$result = SMS::getInstance()->update_query_detailed_query($table,$array_fields,$array_values,$where);
			$return['result'] .= $result;
		}
		echo json_encode($return);
	}
	
	function update_superior(){
		require_once('../class/oop.php');
		$superior = $_POST['superior'];
		$array_subordinate = $_POST['array_subordinate'];
		for($x=0;$x<count($array_subordinate);$x++){
			/* check if item already assigned to another */
			$array_fields = array('SectionHead','Subordinate','pkid');
			$table 	   	= 'tbl_Subordinate';
			$joins 	   	= '';
			$sql_where 	= 'WHERE Subordinate ="'.$array_subordinate[$x].'" AND `logdel` = "0"';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)){
				/* save to 1 varialbe if employee has already been assigned with section head */
				if( !isset($return['existing']['empno']) ){
					$return['existing']['pkid'] = array();
					$return['existing']['empno'] = array();
				}
				$return['existing']['pkid'][] = $row['pkid'];
				$return['existing']['empno'][] = $row['Subordinate'];
			}
		}
		for($x=0;$x<count($array_subordinate);$x++){
			if( !isset($return['existing']['empno']) ){
				$return['existing']['pkid'] = array();
				$return['existing']['empno'] = array();
			}
			if( !in_array($array_subordinate[$x],$return['existing']['empno']) ){
				/* save data to tbl_subordinate */
				$result 		= "";
				$table   		= "tbl_Subordinate"; //table name
				$array_fields 	= array('SectionHead','Subordinate','lastupdate'); //table fields
				$array_values 	= array($superior,$array_subordinate[$x],date('Y-m-d H:i:s')); //values to be saved
				$result 		= SMS::getInstance()->insert_query($table,$array_fields,$array_values);
			}
		}
		if( isset($return['existing']['empno']) ){
			for($x=0;$x<count($return['existing']['empno']);$x++){
				$table = "tbl_Subordinate";
				if($superior != ''){
					$array_fields = array('SectionHead');
					$array_values = array($superior);
				}else{
					$array_fields = array('logdel');
					$array_values = array('1');
				}
				$where 	= 'WHERE `pkid` = "'.$return['existing']['pkid'][$x].'"';
				$result = SMS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
			}
		}
		echo json_encode($return);
	}
	
	
	function check_session(){
		session_start();
		$return = array();
		$return['session_expired'] = 0;
		if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
			$return['session_expired'] = 1;
		}		
 		echo json_encode($return);
	}
	
	function encodeURIComponent($str) {
		$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
		return strtr(rawurlencode($str), $revert);
	}
    
	/* function for displaying record */
	function load_records(){
		require_once('../class/oop.php'); 
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 		= $row['pkid'];
			$return['name'][$ctr] 		= $row['name'];
			$return['lastname'][$ctr] 	= $row['lastname'];
			$return['address'][$ctr] 	= $row['address'];
			$return['remarks'][$ctr] 	= $row['remarks'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	/* function for adding record */
	function add_new_record(){
		require_once('../class/oop.php'); 
		$return 		= $_POST; 
		$result 		= "";
		$table   		= "tbl_records"; //table name
		$array_fields 	= array('name','lastname','address','remarks'); //table fields
		$array_values 	= array($return['txt_name'],$return['txt_lastname'],$return['txt_address'],$return['txt_remarks']); //values to be saved
		$result 		= SMS::getInstance()->insert_query($table,$array_fields,$array_values);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for fetching record */
	function update_fetch_record(){
		require_once('../class/oop.php'); 
		$return = $_POST; 
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid` ='.$return['pkid'];
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = SMS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid2'][$ctr] 		= $row['pkid'];
			$return['name'][$ctr] 		= $row['name'];
			$return['lastname'][$ctr] 	= $row['lastname'];
			$return['address'][$ctr] 	= $row['address'];
			$return['remarks'][$ctr] 	= $row['remarks'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return);//json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for updating record */
	function update_record(){
		require_once('../class/oop.php'); 
		$return = $_POST; 
		$result = "";
		$table        = "tbl_records";
		$array_fields = array('name','lastname','address','remarks');
		$array_values = array($return['txt_name_update'],$return['txt_lastname_update'],$return['txt_address_update'],$return['txt_remarks_update']);
		$pkid = $return['txt_pkid'];
		$result = SMS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for deleting a record */
	function delete_record(){
		require_once('../class/oop.php'); 
		$return 	= $_POST;
		$result 	= "";
		$table   	= "tbl_records";
		$pkid 		= $return['pkid'];
		$result 	= SMS::getInstance()->delete_query($table,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
?>