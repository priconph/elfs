<?php
//Set Class name here, it's a good practice to Capitalize the first letter, I've just read it somewhere on the internet... so its up to you if will follow...
class ELFS extends mysqli 
{
	private static $instance = null;
	
	//db connection config variables
	private $user = "root";	//Username
	private $pass = "newd3v"; //Password
	private $dbName = "db_hris"; //db_name Note: if you are going to use multiple database just place one here.. use sql to call the other one just in case, for example : database2.tablename
	private $dbHost = "localhost"; //host
	
	//NO NEED TO CHANGE HERE 
	public static function getInstance() {
		if(!self::$instance instanceof self) 
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function __clone()
	{
		trigger_error('Clone is not allowed.',E_USER_ERROR);
	}
	
	public function __wakeup()
	{
		trigger_error('Deserializing is not allowed.',E_USER_ERROR);
	}
	
	private function __construct() {
		parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
		if(mysqli_connect_error())
		{
			exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
		parent::set_charset('utf-8');
	}

	//////////////////////////////////////////////UP TO HERE//////////////////////////////////////////////////////
	////////////////////////////////////PUBLIC FUNCTIONS STARTS HERE//////////////////////////////////////////////
	
	public function select_leave_emp_summary($username) { //Select Emp leave summary 
		$query = ("SELECT * FROM tbl_leave_application WHERE empName = '".$username."' AND (status = '0' OR status = '1' OR status = '2' OR status = '4' OR status = '5' OR status = '6' OR status = '7') AND day_type = '' AND logdel = '0' ORDER BY date_created ASC");
		return $this->query($query);
	}
	
	public function getEmpNo($username) { //Get empno of requestor 
		$query = ("SELECT tbl_EmployeeInfo.EmpNo FROM db_acl.tbl_useraccnt INNER JOIN db_hris.tbl_EmployeeInfo ON tbl_EmployeeInfo.pkid = tbl_useraccnt.fkemployee WHERE tbl_useraccnt.username ='".$username."' ");
		return $this->query($query);
	}
	
	public function getEmpInfo($EmpNo) { //emp info.
		$query = ("SELECT a.*, b.Department, c.Division, d.Section FROM  `tbl_EmployeeInfo` a 
				INNER JOIN tbl_Department b ON a.fkDepartment = b.pkid 
				INNER JOIN `tbl_Division` c ON a.fkDivision = c.pkid  
				INNER JOIN `tbl_Section` d ON a.fkSection = d.pkid  
				WHERE a.`EmpStatus` ='1' AND a.EmpNo = '".$EmpNo."' ");
	return $this->query($query);
	}
	
	public function getApproverList($emp_username) { //Get approver list
		$query = ("SELECT * FROM  `vw_Approver` WHERE username =  '$emp_username' AND EmpStatus = '1' "); 
	return $this->query($query);
	}
	
	public function getEmpName($username) { //Get Emp name
		$query = ("SELECT tbl_EmployeeInfo.`FirstName`,tbl_EmployeeInfo.`LastName` FROM db_acl.tbl_useraccnt INNER JOIN db_hris.tbl_EmployeeInfo ON tbl_EmployeeInfo.pkid = tbl_useraccnt.fkemployee 
			WHERE tbl_useraccnt.username='".$username."' ;");
	return $this->query($query);
	}
	
	public function getApprover($EmpNo) { // Get approver name
		$query = ("SELECT `approver_username`,`EmpNo` FROM `db_hris`.`vw_Approver` WHERE `db_hris`.`vw_Approver`.EmpNo ='".$EmpNo."';");
		return $this->query($query);
	}
	
	public function select_leave_info_by_pkid($pkid) { // Get leave info
		$query = ("SELECT a.*, 
			CONCAT(b.FirstName, ' ',b.LastName) AS Emp_Name, 
				c.fk_leave_app, 
				c.fk_leave_applied,
				c.date_from,
				c.date_to,
				c.total_absent_days
			FROM 
				tbl_leave_application a 
								
			INNER JOIN 
				tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
								
			INNER JOIN 
				vw_leave_dates c ON a.pkid = c.fk_leave_app 
			WHERE
				a.pkid = '$pkid' ");
		return $this->query($query);
	}
	
	public function select_leave_info_for_cancel_by_pkid($pkid) { // Get leave info
		$query = ("SELECT * FROM tbl_leave_application WHERE pkid = '$pkid' ");
		return $this->query($query);
	}
	
	public function cancel_conformed_leave_by_pkid($pkid) { // Get leave info
		$query = ("SELECT * FROM tbl_leave_application WHERE pkid = '$pkid' ");
		return $this->query($query);
	}
	
	public function cancel_leave_app_by_pkid($pkid) { // Get leave info
		$query = ("SELECT * FROM tbl_leave_application WHERE pkid = '$pkid' ");
		return $this->query($query);
	}

	public function select_employee_info_by_username($username) {
		$query = ("SELECT CONCAT(`firstname` , ' ', `lastname`) AS Emp_Name,`Section` FROM db_hris.`vw_EmpInfo_Rapid` WHERE `username`='$username'");
	return $this->query($query);
	}
	
	public function select_email_add($username) {
		$query = ("SELECT `email_add` FROM db_hris.`vw_EmpInfo_Rapid` WHERE `username`='$username'");
	return $this->query($query);
	}
		
	public function getEmpLeaveBalance($EmpNo) { //Emp leave balance info.
		$query = ("SELECT * FROM tbl_leaves_balance WHERE EmpNo = '".$EmpNo."' ");
		return $this->query($query);
	}
	
	public function select_emp_leave_summary_for_approval_IS($approver1) { // emp leave for approval 1
		$query = ("SELECT a.*, 
			CONCAT(b.FirstName, ' ',b.LastName) AS Emp_Name, 
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days
		FROM 
			tbl_leave_application a 
							
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
							
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 

		WHERE
			a.`approver1`='$approver1' AND a.status = '0' AND a.`logdel`=0 ORDER BY a.date_created ASC");
	return $this->query($query);	
	}
	
	public function select_emp_leave_summary_for_approval_DH($approver2) { // emp leave for approval 2
	$query = ("SELECT a.*, 
			CONCAT(b.FirstName, ' ',b.LastName) AS Emp_Name, 
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days
		FROM 
			tbl_leave_application a 
							
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
							
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 
							
		WHERE a.logdel= '0' AND 
			((a.status = '1' OR a.status = '5') AND (a.approver2 = '$approver2')) OR ((a.status = '0') AND (a.approver1 = '0' AND a.approver2 = '$approver2')) ORDER BY a.date_created ASC");
			// ((a.status = '1' OR a.status = '5') AND (a.approver2 = '$approver2')) OR ((a.status = '0' OR a.status = '2') AND (a.approver1 = '0' AND a.approver2 = '$approver2')) ORDER BY a.date_created ASC");
	return $this->query($query);	
	}
	
	public function select_leave_emp_info($username) { //Emp leave  info. for approvers
		$query = ("SELECT * FROM vw_Approver WHERE username = '$username' ");
		return $this->query($query);
	}
	
	public function select_emp_leave_summary_for_conformance() { // emp leave for approval 
		$query = ("SELECT a.*, 
				CONCAT(b.FirstName, ' ',b.LastName) AS Emp_Name, 
				c.fk_leave_app, 
				c.fk_leave_applied,
				c.date_from,
				c.date_to,
				c.total_absent_days
			FROM 
				tbl_leave_application a 
								
			INNER JOIN 
				tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
								
			INNER JOIN 
				vw_leave_dates c ON a.pkid = c.fk_leave_app 
								
			WHERE
				(a.status = '2' OR a.status = '6') AND a.logdel = '0' AND a.date_created >= CURDATE() - INTERVAL 2 YEAR
				ORDER BY a.EmpNo ASC");	
		return $this->query($query);	
			//03302020
			// (a.status = '2' OR a.status = '4' OR a.status = '6') AND a.logdel = '0' ORDER BY a.date_created ASC");	

	}
	
	public function select_emp_leave_records() { //Emp leave records for approvers
		$query = ("SELECT a.pkid, a.EmpNo, a.LastName, a.FirstName, a.MiddleName, a.DateHired, a.HiringStatus, a.fkPosition, b.Position, c.Division, d.Department, e.Section 
					FROM tbl_EmployeeInfo a
					INNER JOIN tbl_Position b ON b.pkid = a.fkPosition 
					INNER JOIN tbl_Division c ON c.pkid = a.fkDivision 
					INNER JOIN tbl_Department d ON d.pkid = a.fkDepartment
					INNER JOIN tbl_Section e ON e.pkid = a.fkSection
					WHERE a.EmpStatus = '1' ORDER BY a.EmpNo ASC");	
		return $this->query($query);
	}
	
	public function select_leave_records($pkid) { //leave  records for approvers
		$query = ("SELECT a.pkid, a.EmpNo, CONCAT(a.LastName, ', ', a.FirstName,' ', '(',a.MiddleName,')') AS Emp_Name, a.DateHired, c.Division, d.Department FROM tbl_EmployeeInfo a
					INNER JOIN tbl_Division c ON c.pkid = a.fkDivision 
					INNER JOIN tbl_Department d ON d.pkid = a.fkDepartment
					WHERE a.pkid = '$pkid' ");
		return $this->query($query);
	}
	
	public function get_leave_summary($pkid) { //leave  records for approvers
		$query = ("SELECT a.*, 
				CONCAT(b.FirstName, ' ',b.LastName) AS Emp_Name, 
				c.fk_leave_app, 
				c.fk_leave_applied,
				c.date_from,
				c.date_to,
				c.total_absent_days,
				c.no_of_paid,
				d.leave_applied
			FROM 
				tbl_leave_application a 
								
			INNER JOIN 
				tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
								
			INNER JOIN 
				vw_leave_dates c ON a.pkid = c.fk_leave_app 
								
			INNER JOIN 
				tbl_leave_applied d ON a.leave_applied = d.pkid 
								
			WHERE
				a.fkEmployee ='$pkid' AND a.status = '3' AND a. logdel = '0' ORDER BY a.date_created ASC");				
		return $this->query($query);
	}
	
	public function getEmpLeaveBalance_records($pkid) { //Emp leave balance records
		$query = ("SELECT a.*, CONCAT(b.LastName, ', ', b.FirstName, ' ', '(', b.MiddleName, ')') AS empName FROM tbl_leaves_balance a INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee WHERE a.fkEmployee = '$pkid'  ");
		return $this->query($query);
	}
	
	public function select_leave_transaction_reports() { //leave  report											
		$query = ("SELECT a.*, 
			b.FirstName, 
			b.LastName, 
			b.MiddleName, 
			b.HiringStatus,
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days,
			c.no_of_paid,
			c.cutoff_date,
		CONCAT(d.firstname, ' ', d.lastname) AS approvername2
		FROM 
			tbl_leave_application a 
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 
		INNER JOIN 
			vw_secheads d ON a.approver2 = d.username 						
		WHERE
			(a.status = '3') AND a.logdel = '0' AND a.date_created = YEAR(CURDATE())  ORDER BY a.date_created ASC");
			// (a.status = '3') AND a.logdel = '0' AND (YEAR(a.date_created) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) OR YEAR(a.date_created) = YEAR(CURDATE()) ) ORDER BY a.date_created ASC");
		return $this->query($query);
	}
	
	public function getfiltered_leave_transaction_reports($date1, $date2) { //filtered leave  report
		// $query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.HiringStatus, b.SalaryType, c.leave_applied, d.fk_leave_app, d.date_absent_from, d.date_absent_to, d.no_of_days FROM `tbl_leave_application` a 
					// INNER JOIN tbl_EmployeeInfo b ON b .pkid = a.fkEmployee 
					// INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
					// INNER JOIN tbl_leave_dates d ON a.pkid = d.fk_leave_app 
					// WHERE (a.date_created BETWEEN '$date1' AND '$date2') AND (a.status = '3') AND a.logdel = '0' ");
		// $query = ("SELECT a.*, 
			// b.FirstName, 
			// b.LastName, 
			// b.MiddleName, 
			// b.HiringStatus,
			// c.fk_leave_app, 
			// c.fk_leave_applied,
			// c.date_from,
			// c.date_to,
			// c.total_absent_days,
			// c.no_of_paid,
			// c.cutoff_date,
		// CONCAT(d.firstname, ' ', d.lastname) AS approvername2
		// FROM 
			// tbl_leave_application a 
		// INNER JOIN 
			// tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		// INNER JOIN 
			// vw_leave_dates c ON a.pkid = c.fk_leave_app 
		// INNER JOIN 
			// vw_secheads d ON a.approver2 = d.username 						
		// WHERE (a.date_created BETWEEN '$date1' AND '$date2') AND (a.status = '3') AND a.logdel = '0'");
		$query = ("SELECT a.*, 
			b.FirstName, 
			b.LastName, 
			b.MiddleName, 
			b.HiringStatus,
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days,
			c.no_of_paid,
			c.cutoff_date,
		CONCAT(d.firstname, ' ', d.lastname) AS approvername2
		FROM 
			tbl_leave_application a 
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 
		INNER JOIN 
			vw_secheads d ON a.approver2 = d.username 						
		WHERE
			(a.status = '3') AND (a.date_created BETWEEN '$date1' AND '$date2')  AND a.logdel = '0' ORDER BY a.date_created ASC");
		return $this->query($query);  // edit this query
	}
	
	public function select_daily_pdf($drLeaveApplied, $drDivision, $startDate, $endDate) { //Daily transaction report
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, c.leave_applied, d.fk_leave_app, d.date_from, d.date_to, d.total_absent_days, d.no_of_paid FROM `tbl_leave_application` a 
					INNER JOIN tbl_EmployeeInfo b ON b .pkid = a.fkEmployee 
					INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
					 INNER JOIN vw_leave_dates d ON a.pkid = d.fk_leave_app 
					WHERE c.`leave_applied` = '$drLeaveApplied' AND a.`Division` = '$drDivision' AND b.SalaryType = '1' AND (a.status = '3') AND (a.`date_created` BETWEEN '$startDate' AND '$endDate') ");
		return $this->query($query);
	}
	
	public function select_daily_Leave_applied() { //Get Daily Leave Applied
		$query = ("SELECT a.Division, b.leave_applied, c.SalaryType FROM tbl_leave_application a 
					INNER JOIN tbl_leave_applied b ON b.pkid = a.leave_applied 
					INNER JOIN tbl_EmployeeInfo c ON c.pkid = a.fkEmployee
					WHERE c.SalaryType = '1' AND a.status = '3' ORDER BY a.Division ASC");
		return $this->query($query);
	}	

	public function select_monthly_pdf($drLeaveApplied, $drDivision, $startDate, $endDate) { //Monthly transaction report
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, c.leave_applied, d.fk_leave_app, d.date_from, d.date_to, d.total_absent_days, d.no_of_paid FROM `tbl_leave_application` a 
					INNER JOIN tbl_EmployeeInfo b ON b .pkid = a.fkEmployee 
					INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
					 INNER JOIN vw_leave_dates d ON a.pkid = d.fk_leave_app 
					WHERE c.`leave_applied` = '$drLeaveApplied' AND a.`Division` = '$drDivision' AND b.SalaryType = '2' AND (a.status = '3') AND (a.`date_created` BETWEEN '$startDate' AND '$endDate') ");
		return $this->query($query);
	}
	
	public function select_monthly_Leave_applied() { //Get Monthly Leave Applied
		$query = ("SELECT a.Division, b.leave_applied, c.SalaryType FROM tbl_leave_application a 
					INNER JOIN tbl_leave_applied b ON b.pkid = a.leave_applied 
					INNER JOIN tbl_EmployeeInfo c ON c.pkid = a.fkEmployee
					WHERE c.SalaryType = '2' AND a.status = '3' ORDER BY a.Division ASC");
		return $this->query($query);
	}	
	
	public function select_confidential_pdf($drLeaveApplied, $drDivision, $startDate, $endDate) { //Confidential transaction report
			$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, c.leave_applied, d.fk_leave_app, d.date_from, d.date_to, d.total_absent_days, d.no_of_paid FROM `tbl_leave_application` a 
					INNER JOIN tbl_EmployeeInfo b ON b .pkid = a.fkEmployee 
					INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
					 INNER JOIN vw_leave_dates d ON a.pkid = d.fk_leave_app 
					WHERE c.`leave_applied` = '$drLeaveApplied' AND a.`Division` = '$drDivision' AND b.SalaryType = '3' AND (a.status = '3') AND (a.`date_created` BETWEEN '$startDate' AND '$endDate') ");
		return $this->query($query);
	}
	
	public function select_confidential_Leave_applied() { //Get Confidential Leave Applied
		$query = ("SELECT a.Division, b.leave_applied, c.SalaryType FROM tbl_leave_application a 
					INNER JOIN tbl_leave_applied b ON b.pkid = a.leave_applied 
					INNER JOIN tbl_EmployeeInfo c ON c.pkid = a.fkEmployee
					WHERE c.SalaryType = '3' AND a.status = '3' ORDER BY a.Division ASC");
		return $this->query($query);
	}	
	
	public function select_jsss_pdf($drLeaveApplied, $drDivision, $startDate, $endDate) { //JS/SS transaction report					
			$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, c.leave_applied, d.fk_leave_app, d.date_from, d.date_to, d.total_absent_days, d.no_of_paid FROM `tbl_leave_application` a 
					INNER JOIN tbl_EmployeeInfo b ON b .pkid = a.fkEmployee 
					INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
					 INNER JOIN vw_leave_dates d ON a.pkid = d.fk_leave_app 
					WHERE (c.`leave_applied` = '$drLeaveApplied') AND (a.`Division` = '$drDivision') AND (b.SalaryType = '4') AND (a.status = '3') AND (a.`date_created` BETWEEN '$startDate' AND '$endDate') ORDER BY a.EmpNo ASC");

		return $this->query($query);
	}
	
	public function select_jsss_Leave_applied() { //Get JS/SS Leave Applied				
			$query =("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, c.leave_applied, d.fk_leave_app, d.date_from, d.date_to, d.total_absent_days, d.no_of_paid FROM `tbl_leave_application` a 
					INNER JOIN tbl_EmployeeInfo b ON b .pkid = a.fkEmployee 
					INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
					 INNER JOIN vw_leave_dates d ON a.pkid = d.fk_leave_app 
					WHERE (b.SalaryType = '4') AND (a.status = '3') ORDER BY a.Division ASC");
					
		return $this->query($query);
	}
	
	public function select_leave_balance_per_superior($EmpNo) { //Get leave balance per department
			$query =("SELECT a.*, b.* FROM `vw_leaves_balance` a INNER JOIN tbl_Subordinate b ON b.Subordinate = a.EmpNo WHERE b.SectionHead = '$EmpNo' ");
		return $this->query($query);
	}
	
	public function select_leave_balance_per_dept($Department) { //Get leave balance per department
		$query = ("SELECT a.*, b.HiringStatus, b.fkDivision, b.LastName, b.FirstName, b.MiddleName, c.Division, d.Department, e.Section FROM tbl_leaves_balance a 
				INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee 
				INNER JOIN tbl_Division c ON c.pkid = b.fkDivision
				INNER JOIN tbl_Department d ON d.pkid = b.fkDepartment
				INNER JOIN tbl_Section e ON e.pkid = b.fkSection
				WHERE (b.HiringStatus = '2' OR b.HiringStatus = '3') AND (b.EmpStatus = '1') AND d.Department = '$Department'");
		return $this->query($query);
	}

	public function select_leaves_balance() { //Get leaves balance
		$query = ("SELECT a.*, b.HiringStatus, b.fkDivision, b.LastName, b.FirstName, b.MiddleName, c.Division FROM tbl_leaves_balance a 
				INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee 
				INNER JOIN tbl_Division c ON c.pkid = b.fkDivision WHERE (b.HiringStatus = '2' OR b.HiringStatus = '3') AND b.EmpStatus = '1' ORDER BY a.EmpNo ASC");
		return $this->query($query);
	}	
	
	public function select_Division() { //Get Division
		$query = ("SELECT Division FROM tbl_Division WHERE logdel = '0'");
		return $this->query($query);
	}	
	
	public function select_sl_balance($drDivision) { //Get sl balance
		// $query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.fkDivision, c.Division FROM tbl_leaves_balance a 
		// $query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.fkDivision, c.Division FROM vw_leaves_balance a 
				// INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee 
				// INNER JOIN tbl_Division c ON c.pkid = b.fkDivision WHERE c.Division = '$drDivision' AND b.HiringStatus = '3' AND b.EmpStatus = '1'");
			$query = ("SELECT * FROM vw_leaves_balance WHERE Division = '$drDivision' AND HiringStatus = '3' AND EmpStatus = '1'");			
		return $this->query($query);
	}	
	
	public function select_vl_balance($drDivision) { //Get vl balance
		// $query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.fkDivision, c.Division FROM tbl_leaves_balance a 
				// INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee 
				// INNER JOIN tbl_Division c ON c.pkid = b.fkDivision WHERE c.Division = '$drDivision' AND b.HiringStatus = '3'");
			$query = ("SELECT * FROM vw_leaves_balance WHERE Division = '$drDivision' AND HiringStatus = '3' AND EmpStatus = '1'");			
		return $this->query($query);
	}	
	
	public function select_YEB_VL_daily() { //Get Year end vl daily 
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, b.EmpStatus FROM tbl_leaves_balance a 
				 INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee WHERE b.SalaryType = '1' AND b.EmpStatus = '1' AND b.HiringStatus = '3'
				 ORDER BY a.EmpNo ASC");
		return $this->query($query);
	}	
	
	public function select_YEB_VL_monthly() { //Get Year end vl monthly 
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, b.EmpStatus FROM tbl_leaves_balance a 
				 INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee WHERE b.SalaryType = '2' AND b.EmpStatus = '1' AND b.HiringStatus = '3' 
				 ORDER BY a.EmpNo ASC");
		return $this->query($query);
	}	
	
	public function select_YEB_VL_jsss() { //Get Year end vl jsss 
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, b.EmpStatus FROM tbl_leaves_balance a 
				 INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee WHERE b.SalaryType = '4' AND b.EmpStatus = '1' AND b.HiringStatus = '3'
				 ORDER BY a.EmpNo ASC");
		return $this->query($query);
	}	
	
	public function select_YEB_VL_confidential() { //Get Year end vl confidential 
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, b.EmpStatus FROM tbl_leaves_balance a 
				 INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee WHERE b.SalaryType = '3' AND b.EmpStatus = '1' AND b.HiringStatus = '3'
				 ORDER BY a.EmpNo ASC");
		return $this->query($query);
	}	
	
	public function select_YEB_SL_daily() { //Get Year end sl daily 
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, b.EmpStatus FROM tbl_leaves_balance a 
				 INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee WHERE b.SalaryType = '1' AND b.EmpStatus = '1' AND b.HiringStatus = '3'
				 ORDER BY a.EmpNo ASC");
		return $this->query($query);
	}	
	
	public function select_YEB_SL_monthly() { //Get Year end sl monthly 
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, b.EmpStatus FROM tbl_leaves_balance a 
				 INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee WHERE b.SalaryType = '2' AND b.EmpStatus = '1' AND b.HiringStatus = '3'
				 ORDER BY a.EmpNo ASC");
		return $this->query($query);
	}	
	
	public function select_YEB_SL_jsss() { //Get Year end sl jsss 
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, b.EmpStatus FROM tbl_leaves_balance a 
				 INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee WHERE b.SalaryType = '4' AND b.EmpStatus = '1' AND b.HiringStatus = '3'
				 ORDER BY a.EmpNo ASC");
		return $this->query($query);
	}	
	
	public function select_YEB_SL_confidential() { //Get Year end sl confidential 
		$query = ("SELECT a.*, b.LastName, b.FirstName, b.MiddleName, b.SalaryType, b.EmpStatus FROM tbl_leaves_balance a 
				 INNER JOIN tbl_EmployeeInfo b ON b.pkid = a.fkEmployee WHERE b.SalaryType = '3' AND b.EmpStatus = '1' AND b.HiringStatus = '3'
				 ORDER BY a.EmpNo ASC");
		return $this->query($query);
	}	

	public function select_leave_dates($pkid) { //select leave dates
		$query = ("SELECT * FROM tbl_leave_dates WHERE fk_leave_app = '$pkid'");
		return $this->query($query);
	}
		
	public function show_remarks($pkid) { //show remarks
		$query = ("SELECT IS_disapproved_remarks, DH_disapproved_remarks, HR_revised_remarks, Cancelled_remarks, HR_cancel_remarks FROM tbl_leave_application WHERE pkid = '$pkid' AND logdel = 0 ");
		// $query = ("SELECT a.*, b.emp_name AS approver1, c.emp_name AS approver2 FROM tbl_leave_application a 
				// INNER JOIN vw_requestor b ON b.username = a.approver1 
				// INNER JOIN vw_requestor c ON c.username = a.approver2 
				// WHERE a.pkid = '$pkid' AND a.logdel = 0");
		return $this->query($query);
	}	

	public function update_leave($pkid, $status, $leave_applied, $reason, $radio_OthersAdd, $address, $approver1, $approver2, $username) { // update leave
		$query = ("UPDATE `tbl_leave_application` SET 
					`status` 			= '$status', 
					`leave_applied` 	= '$leave_applied', 
					`reason` 			= '$reason', 
					`radio_OthersAdd` 	= '$radio_OthersAdd', 
					`address` 			= '$address', 
					`approver1`			= '$approver1', 
					`approver2`			= '$approver2' 
					`username`			= '$username' 
					WHERE `pkid` 		= '$pkid' AND `logdel` = '0'");
		return $this->query($query);
	}	
	
	public function update_approver1_status($pkid, $status, $IS_disapproved_remarks, $username) { //update status approver1
		$query = ("UPDATE `tbl_leave_application` SET 
					`status` 					= '$status', 
					`IS_disapproved_remarks` 	= '$IS_disapproved_remarks', 
					`lastupdate`				= '".date("Y-m-d H:i:s")."',
					`date_time_approved1`		= '".date("Y-m-d H:i:s")."',
					`username`					= '$username'
					WHERE `pkid` 				= '$pkid' AND logdel='0'");
		return $this->query($query);
	}	
	
	public function update_approver2_status($pkid, $status, $DH_disapproved_remarks, $username) { //update status approver2
		$query = ("UPDATE `tbl_leave_application` SET 
					`status` 					= '$status', 
					`DH_disapproved_remarks` 	= '$DH_disapproved_remarks', 
					`lastupdate`				= '".date("Y-m-d H:i:s")."',
					`date_time_approved2`		= '".date("Y-m-d H:i:s")."',
					`username`					= '$username'
					WHERE `pkid` 				= '$pkid' AND logdel='0'");
		return $this->query($query);
	}	
	
	public function update_hrd_status($pkid, $status, $HR_revised_remarks, $HR_cancelled_remarks, $username) { //update status hrd
		$query = ("UPDATE `tbl_leave_application` SET 
					`status` 					= '$status', 
					`HR_revised_remarks` 		= '$HR_revised_remarks', 
					`HR_cancelled_remarks` 		= '$HR_cancelled_remarks', 
					`lastupdate`				= '".date("Y-m-d H:i:s")."',
					`date_time_approved2`		= '".date("Y-m-d H:i:s")."',
					`username`					= '$username'
					WHERE `pkid` 				= '$pkid' AND logdel='0'");
		return $this->query($query);
	}	
	
	public function add_regularity_date($pkid, $regularity_date) { //add regularity
		$query = ("UPDATE `tbl_leaves_balance` SET `regularity_date` = '$regularity_date' WHERE `fkEmployee` = '$pkid'");
	return $this->query($query);
	}	
	
	public function select_hrd_recipients() { //select hrd reciepients
		$query = ("SELECT `username`,`email_address` AS `email_add` FROM `tbl_elfs_email_recipient` WHERE logdel= '0'");
	return $this->query($query);
	}
	
	public function select_leave_history_for_approver1($username) { //Select Emp leave history for approver1 
	$query = ("SELECT a.*, 
			b.FirstName, 
			b.LastName, 
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days,
			c.no_of_paid,
			c.cutoff_date,
		CONCAT(d.firstname, ' ', d.lastname) AS approvername1,
		CONCAT(e.firstname, ' ', e.lastname) AS approvername2
		FROM 
			tbl_leave_application a 
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 
		INNER JOIN 
			vw_secheads d ON a.approver1 = d.username
		INNER JOIN 
			vw_secheads e ON a.approver2 = e.username 						
		WHERE
			(a.status = '3') AND a.approver1 = '$username' AND a.logdel = '0' AND a.date_created >= CURDATE() - INTERVAL 2 YEAR
			ORDER BY a.date_created ASC");
	return $this->query($query);
	}
	
	public function select_leave_history_for_approver2($username) { //Select Emp leave history for approver2 
		$query = ("SELECT a.*, 
			b.FirstName, 
			b.LastName, 
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days
		FROM 
			tbl_leave_application a 
							
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
							
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 
		WHERE
			a.approver2 = '$username'  
			AND a.status = '3'
			AND a.date_created = YEAR(CURDATE())

			ORDER BY a.date_created DESC");	
		return $this->query($query);
	}
	
	public function select_leave_history($username) { //Select Emp leave history for emp 
		$query = ("SELECT a.*, 
			b.FirstName, 
			b.LastName, 
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days,
			c.no_of_paid,
			c.cutoff_date,
			CONCAT(d.firstname, ' ', d.lastname) AS approvername1,
			CONCAT(e.firstname, ' ', e.lastname) AS approvername2
		FROM 
			tbl_leave_application a 
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 
		LEFT JOIN 
			vw_emp_hris d ON a.approver1 = d.username 
		LEFT JOIN 
			vw_emp_hris e ON a.approver2 = e.username 						
		WHERE
			(a.status = '3' OR a.status = '8' OR a.status = '9') AND a.empName = '$username' AND a.logdel = '0' AND a.date_created >= CURDATE() - INTERVAL 2 YEAR
			ORDER BY a.date_created DESC");
			
			
		// SELECT a.*, 
			// b.FirstName, 
			// b.LastName, 
			// c.fk_leave_app, 
			// c.fk_leave_applied,
			// c.date_from,
			// c.date_to,
			// c.total_absent_days,
			// c.no_of_paid,
			// c.cutoff_date,
		// CONCAT(d.firstname, ' ', d.lastname) AS approvername2
		// FROM 
			// tbl_leave_application a 
		// INNER JOIN 
			// tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		// INNER JOIN 
			// vw_leave_dates c ON a.pkid = c.fk_leave_app 
		// INNER JOIN 
			// vw_secheads d ON a.approver2 = d.username 						
		// WHERE
			// (a.status = '3' OR a.status = '8' OR a.status = '9') AND a.empName = '$username' AND a.logdel = '0' ORDER BY a.date_created DESC
	return $this->query($query);
	}
	
	public function select_all_leave_history() { //Select Emp leave history for hrd 
		// $query = ("SELECT a.*, 
			// b.FirstName, 
			// b.LastName, 
			// c.fk_leave_app, 
			// c.fk_leave_applied,
			// c.date_from,
			// c.date_to,
			// c.total_absent_days,
			// c.no_of_paid,
			// c.cutoff_date,
		// CONCAT(d.firstname, ' ', d.lastname) AS approvername2
		// FROM 
			// tbl_leave_application a 
		// INNER JOIN 
			// tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		// INNER JOIN 
			// vw_leave_dates c ON a.pkid = c.fk_leave_app 
		// INNER JOIN 
			// vw_secheads d ON a.approver2 = d.username 						
		// WHERE
			// (a.status = '3') ORDER BY a.date_created DESC");
			
			$query = ("SELECT a.*, 
			b.FirstName, 
			b.LastName, 
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days,
			c.no_of_paid,
			c.cutoff_date,
			CONCAT(d.firstname, ' ', d.lastname) AS approvername1,
			CONCAT(e.firstname, ' ', e.lastname) AS approvername2
		FROM 
			tbl_leave_application a 
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 
		INNER JOIN 
			vw_emp_hris d ON a.approver1 = d.username 
		INNER JOIN 
			vw_secheads e ON a.approver2 = e.username 						
		WHERE
			(a.status = '3') AND a.date_created = YEAR(CURDATE()) ORDER BY `a`.`date_created` DESC");
			// (a.status = '3') AND YEAR(a.date_created) = '2018' ORDER BY `a`.`date_created` DESC");
			// (a.status = '3') ORDER BY `a`.`date_created` DESC");
			// (a.status = '3' OR a.status = '9') ORDER BY a.date_created ASC");
			
	return $this->query($query);
	}
	
	public function select_all_leave_application() { //Select Emp leave history for hrd 
			
		$query = ("SELECT a.*, 
			b.FirstName, 
			b.LastName, 
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days,
			c.no_of_paid,
			c.cutoff_date,
			CONCAT(d.firstname, ' ', d.lastname) AS approvername1,
			CONCAT(e.firstname, ' ', e.lastname) AS approvername2
		FROM 
			tbl_leave_application a 
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 
		LEFT JOIN 
			vw_emp_hris d ON a.approver1 = d.username 
		LEFT JOIN 
			vw_secheads e ON a.approver2 = e.username 						
		WHERE
			(a.status = '0' or a.status = '1' or a.status = '2') AND a.date_created >= CURDATE() - INTERVAL 2 YEAR
			ORDER BY a.status ASC, a.date_created DESC");
			
	return $this->query($query);
	}
	
	public function select_leave_emp_summary_for_hrd($username) { //Select Emp leave summary 
		$query = ("SELECT * FROM tbl_leave_application WHERE status = '2' OR status = '4' OR status = '6' ORDER BY date_created ASC");
	return $this->query($query);
	}
	
	public function select_leave_balance() { //select leave balance
		$query = ("SELECT * FROM vw_leaves_balance WHERE EmpStatus = '1' ORDER BY EmpNo ASC");
	return $this->query($query);
	}
	
	public function select_leave_balance_by_section($section) { //select leave balance
		$query = ("SELECT * FROM vw_leaves_balance");
	return $this->query($query);
	}
		
	public function getDeptHeads() { // Get dept. heads
		$query = ("SELECT * FROM vw_secheads");
	return $this->query($query);
	}

	public function getImmediateSupr() { // Get immediate superior
		$query = ("SELECT * FROM tbl_ISApprover ORDER BY Category DESC ");
	return $this->query($query);
	}

	public function select_view_emp_leave($pkid) { //Select view leave summary 
		$query = ("SELECT * FROM tbl_leave_application WHERE pkid= '$pkid'");
		return $this->query($query);
	}
	
	public function select_batch_dates($pkid) { //Select view leave summary 
		$query = ("SELECT * FROM tbl_batch_leave_application WHERE pkid= '$pkid'");
		return $this->query($query);
	}
	
	public function get_edit_leave_dates_summary($pkid) { //Get edit leave summary 
		$query = ("SELECT a.*, b.pkid AS pkid_leave_date, b.fk_leave_app, b.date_absent_from, b.date_absent_to, b.no_of_days, b.no_of_paid, c.leave_applied
			FROM tbl_leave_application a 
			INNER JOIN tbl_leave_dates b ON b.fk_leave_app = a.pkid 
			INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
			WHERE a.pkid = '$pkid' AND b.logdel = '0'");
		return $this->query($query);
	}
	
	public function get_remove_leave_dates_summary($pkid) { //Get edit leave summary 
		$query = ("SELECT a.*, b.pkid AS pkid_leave_date, b.fk_batch_leave_app, b.date_absent_from, b.date_absent_to, b.no_of_days, b.no_of_paid, b.cutoff_date, c.leave_applied
			FROM tbl_batch_leave_application a 
			INNER JOIN tbl_leave_dates b ON b.fk_batch_leave_app = a.pkid 
			INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
			WHERE a.pkid = '$pkid' AND b.logdel = '0'");
		return $this->query($query);
	}
	
	public function get_view_leave_dates_summary($pkid) { //Get view leave summary 
		$query = ("SELECT a.*, b.pkid AS pkid_leave_date, b.fk_leave_app, b.date_absent_from, b.date_absent_to, b.no_of_days, b.no_of_paid, b.cutoff_date, MONTH(b.cutoff_date) AS cutoff_month, c.leave_applied
			FROM tbl_leave_application a 
			INNER JOIN tbl_leave_dates b ON b.fk_leave_app = a.pkid 
			INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
			WHERE (a.pkid = '$pkid' AND a.logdel = '0') AND b.logdel = '0' ");
		return $this->query($query);
	}
	
	public function get_view_leave_dates_summary_script($pkid) { //Get view leave summary for testing
		$query = ("SELECT a.*, b.pkid AS pkid_leave_date, b.fk_leave_app, b.date_absent_from, b.date_absent_to, b.no_of_days, b.no_of_paid, b.cutoff_date, MONTH(b.cutoff_date) AS cutoff_month, c.leave_applied
			FROM tbl_leave_application a 
			INNER JOIN tbl_leave_dates b ON b.fk_leave_app = a.pkid 
			INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
			WHERE (a.pkid = '$pkid' AND a.logdel = '0') AND b.logdel = '0' ");
		return ($query);
	}
	
	public function update_Leave_balance($pkid, $regularity_date, $previous_balance_VL, $credit_VL, $current_avail_VL, $total_VL_used, $total_VL_balance, $previous_balance_SL, $credit_SL, $current_avail_SL, $total_SL_used, $total_SL_balance) { //update leave balance
		$query = ("UPDATE `tbl_leaves_balance` SET 
					`regularity_date` 			= '$regularity_date', 
					`previous_balance_VL` 		= '$previous_balance_VL', 
					`credit_VL` 				= '$credit_VL', 
					`current_avail_VL` 			= '$current_avail_VL', 
					`total_VL_used` 			= '$total_VL_used', 
					`total_VL_balance` 			= '$total_VL_balance', 
					`previous_balance_SL` 		= '$previous_balance_SL', 
					`credit_SL` 				= '$credit_SL', 
					`current_avail_SL` 			= '$current_avail_SL', 
					`total_SL_used` 			= '$total_SL_used', 
					`total_SL_balance` 			= '$total_SL_balance' 
					WHERE `fkEmployee`			= '$pkid' ");
		return $this->query($query);
	}	
	
	public function select_leave_balance_info($pkid) { // select leave balance info
		// $query = ("SELECT * FROM tbl_leaves_balance WHERE pkid = '$pkid' ");
		$query = ("SELECT * FROM vw_leaves_balance WHERE pkid = '$pkid' ");
	return $this->query($query);
	}

	public function select_EmpNo_list() { //Select Emp list 
		$query = ("SELECT pkid, EmpNo FROM tbl_EmployeeInfo WHERE (`HiringStatus` = '2' OR `HiringStatus` = '3') AND `EmpStatus` = '1' ORDER BY EmpNo Desc");
		return $this->query($query);
	}
	
	public function select_EmpNo_list_by_pkid($pkid) { //Select Emp list by pkid 
		// $query = ("SELECT *, CONCAT(lastname, ', ', firstname) AS empName FROM vw_emp_leave_balance WHERE EmpStatus = '1' AND pkid  = '$pkid'"); //10232018
		$query = ("SELECT *, CONCAT(lastname, ', ', firstname) AS empName FROM vw_emp_leave_balance2 WHERE EmpStatus = '1' AND pkid  = '$pkid'"); //10232018
		return $this->query($query);
	}
	
	public function AddNewLeaveBalance($fkEmployee, $EmpNo, $regularity_date, $previous_balance_VL, $credit_VL, $current_avail_VL, $total_VL_used, $total_VL_balance, $previous_balance_SL, $credit_SL, $current_avail_SL, $total_SL_used, $total_SL_balance) { //Add new leave balance 
		$query = ("INSERT INTO tbl_leaves_balance (`fkEmployee`,`EmpNo`,`regularity_date`,`previous_balance_VL`,`credit_VL`,`current_avail_VL`,`total_VL_used`,`total_VL_balance`,`previous_balance_SL`,`credit_SL`,`current_avail_SL`,`total_SL_used`,`total_SL_balance`) 
				VALUES ('$fkEmployee','$EmpNo','$regularity_date','$previous_balance_VL','$credit_VL','$current_avail_VL','$total_VL_used','$total_VL_balance','$previous_balance_SL','$credit_SL','$current_avail_SL','$total_SL_used','$total_SL_balance')");
		return $this->query($query);
	}
	
	public function savesend_leave_record($fkEmployee, $status, $date_created, $empName, $EmpNo, $Division, $leave_applied, $reason, $emp_address, $radio_OthersAdd, $address, $approver1, $approver2, $username) { 
		$query = ("INSERT INTO tbl_leave_application (`fkEmployee`,`status`,`date_created`,`empName`,`EmpNo`,`Division`,`leave_applied`,`reason`,`emp_address`,`radio_OthersAdd`,`address`,`approver1`,`approver2`, `username`)
			 VALUES ('$fkEmployee','0','$date_created','$empName','$EmpNo','$Division','$leave_applied', '$reason','$emp_address','$radio_OthersAdd','$address','$approver1','$approver2', '$username') ");
		return $this->query($query);
	}

	public function Save_leave_as_draft($fkEmployee, $status, $date_created, $empName, $EmpNo, $Division, $leave_applied, $reason, $emp_address, $radio_OthersAdd, $address, $approver1, $approver2, $username) { 
		$query = ("INSERT INTO tbl_leave_application (`fkEmployee`,`status`,`date_created`,`empName`,`EmpNo`,`Division`,`leave_applied`,`reason`,`emp_address`,`radio_OthersAdd`,`address`,`approver1`,`approver2`, `username`)
			 VALUES ('$fkEmployee','7','$date_created','$empName','$EmpNo','$Division','$leave_applied','$reason','$emp_address','$radio_OthersAdd','$address','$approver1','$approver2', '$username') ");
		return $this->query($query);
	}
	
	public function Save_updated_leave_as_draft($fkEmployee, $status, $date_created, $empName, $EmpNo, $Division, $leave_applied, $reason, $emp_address, $radio_OthersAdd, $address, $approver1, $approver2, $username) { 
		$query = ("INSERT INTO tbl_leave_application (`fkEmployee`,`status`,`date_created`,`empName`,`EmpNo`,`Division`,`leave_applied`,`reason`,`emp_address`,`radio_OthersAdd`,`address`,`approver1`,`approver2`, `username`)
			 VALUES ('$fkEmployee','7','$date_created','$empName','$EmpNo','$Division','$leave_applied','$reason','$emp_address','$radio_OthersAdd','$address','$approver1','$approver2', '$username') ");
		return $this->query($query);
	}
	
	public function Select_leave_record() { // Select_leave_record
		$query = ("SELECT `pkid`, `leave_applied`, `approver1` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"); 
		return $this->query($query);
	}
	
	public function Select_leave_record_for_update() { //Select_leave_record_for_update
		$query = ("SELECT `pkid`, `leave_applied`, `approver1` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"); 
		return $this->query($query);
	}
		
	public function Select_leave_as_draft() { //Select_leave_as_draft
		$query = ("SELECT `pkid`, `created_by`, `EmpNo`, `leave_applied`, `approver1` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"); 
		return $this->query($query);
	}

	public function getSectionHead($emp_username) { //Get Sec head list
		$query = ("SELECT * FROM vw_elfs_approver WHERE username =  '$emp_username' and logdel = '0'"); 	
	return $this->query($query);
	}
	
	public function getSectionHeadName($username) { //Get Sec approver name
		$query = ("SELECT tbl_EmployeeInfo.`FirstName`,tbl_EmployeeInfo.`LastName` FROM db_acl.tbl_useraccnt INNER JOIN db_hris.tbl_EmployeeInfo ON tbl_EmployeeInfo.pkid = tbl_useraccnt.fkemployee 
			WHERE tbl_useraccnt.username='".$username."' ;");
	return $this->query($query);
	}
	
	public function getSecApprover($EmpNo) { // Get Sec approver name
		$query = ("SELECT `approver_username`,`SecEmpNo` FROM vw_elfs_approver WHERE vw_elfs_approver.SecEmpNo ='".$EmpNo."';");
		return $this->query($query);
	}
	
	public function update_leave_record($pkid, $status, $leave_applied, $reason, $address, $approver1, $approver2, $username) { //update_leave_record
		$query = ("UPDATE `tbl_leave_application` SET 
		`status` 			 = '$status', 
		`leave_applied`		 = '$leave_applied', 
		`reason`		     = '$reason', 
		`address`	 		 = '$address', 
		`approver1` 	  	 = '$approver1', 
		`approver2` 	 	 = '$approver2', 
		`username` 		 	 = '$username', 
		`lastupdate`	 	 = '".date("Y-m-d H:i:s")."'  
		WHERE `pkid` 		 = '$pkid' AND logdel = '0'");
		return $this->query($query);
	}
	
	public function cancelled_leave_application($pkid, $status, $Cancelled_remarks, $username) { //cancelled_leave_application
		$query = ("UPDATE `tbl_leave_application` SET 
		`status` 			 = '8', 
		`Cancelled_remarks`	 = '$Cancelled_remarks', 
		`username` 		 	 = '$username', 
		`lastupdate`	 	 = '".date("Y-m-d H:i:s")."'  
		WHERE `pkid` 		 = '$pkid' AND logdel = '0'");
		return $this->query($query);
	}

	public function Select_cancelled_record() { //Select_cancelled_record
		$query = ("SELECT `pkid` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"); 
		return $this->query($query);
	}
	
	public function delete_leave_date($pkid) { //delete_leave_date
		$query = ("UPDATE `tbl_leave_dates` SET 
		`logdel` 		 	 = '1'
		WHERE `pkid` 		 = '$pkid'");
		return $this->query($query);
	}

	public function view_leave_dates($pkid) { //Select view leave summary 
		$query = ("SELECT * FROM tbl_leave_dates WHERE pkid = '$pkid'");
		return $this->query($query);
	}
	
	/* Batch Leave */
	public function get_batch_employee($pkid) { //Select view leave summary 
		$query = ("SELECT * FROM tbl_Subordinate WHERE pkid = '$pkid'");
		return $this->query($query);
	}
	
	public function get_batch_employee_list_by_requestor($pkid) { //Select Emp leave summary 
		// $query = ("SELECT a.pkid, a.SectionHead, a.Subordinate, a.logdel,
					// b.FullName, b.Division, b.Department, b.Section, b.Position, b.fkid, b.SectionHead, b.Subordinate, b.logdel, 
					// c.status
					// FROM tbl_Batch_Emp a 
					// INNER JOIN vw_Batch_Emp_list b ON b.fkid = a.pkid 
					// INNER JOIN tbl_batch_leave_application c ON c.pkid = b.fkid
					// WHERE a.pkid = '$pkid'");
					
		$query = ("SELECT a.pkid, a.status, a.EmpNo, a.leave_applied, a.day_type, 
					b.fk_batch_leave_app, b.date_from, b.date_to, b.no_of_paid, b.total_absent_days, b.cutoff_date, 
					c.FullName, c.Division, c.Department, c.Section, c.Position, c.pkid AS pkidEmp, c.SectionHead, c.Subordinate, c.logdel 
				FROM tbl_batch_leave_application a 
				INNER JOIN vw_batch_leave_dates b ON b.fk_batch_leave_app = a.pkid
				INNER JOIN vw_Batch_Emp_list c ON c.fkid = b.fk_batch_leave_app
				WHERE a.pkid = '$pkid' ");
		return $this->query($query);
	}
	
	public function delete_employee($pkid) { //delete_employee from batch leave
		$query = ("UPDATE `tbl_Batch_Emp` SET `logdel` = '1' WHERE `pkid` = '$pkid'");
	return $this->query($query);
	}

	public function select_batch_leave_summary_for_approval($username) { //Select Emp batch leave summary 
		// $query = ("SELECT a.*, CONCAT(b.lastname, ', ', b.firstname) AS Emp_Name FROM tbl_batch_leave_application a INNER JOIN vw_EmpInfo_Rapid b ON a.empName = b.username WHERE a.empName = '".$username."' AND (a.status = '0' OR a.status = '2' OR a.status = '3' OR a.status = '4' OR a.status = '6' OR a.status = '7' OR a.status = '8') AND (a.reason = 'Shut-Down' OR a.reason = 'Special Holiday') ORDER BY a.date_created ASC");
		$query = ("SELECT a.*, CONCAT(b.lastname, ', ', b.firstname) AS Emp_Name FROM tbl_batch_leave_application a INNER JOIN vw_EmpInfo_Rapid b ON a.empName = b.username WHERE a.empName = '".$username."' AND (a.status = '0' OR a.status = '2' OR a.status = '3' OR a.status = '4' OR a.status = '6' OR a.status = '7' OR a.status = '8') ORDER BY a.date_created ASC");
	return $this->query($query);
	}
	
	public function select_batch_leave_summary_for_approval_DH($approver2) { //Select Emp batch leave summary 
		// $query = ("SELECT a.*, CONCAT(b.lastname, ', ', b.firstname) AS Emp_Name FROM tbl_leave_application a INNER JOIN vw_EmpInfo_Rapid b ON a.empName = b.username WHERE a.approver2 = '".$approver2."' AND (a.status = '0' OR a.status = '2' OR a.status = '4' OR a.status = '6' OR a.status = '8') AND (a.reason = 'Shut-Down' OR a.reason = 'Special Holiday') ORDER BY a.date_created ASC");
		$query = ("SELECT a.*, CONCAT(b.lastname, ', ', b.firstname) AS Emp_Name FROM tbl_batch_leave_application a INNER JOIN vw_EmpInfo_Rapid b ON a.empName = b.username WHERE a.approver2 = '".$approver2."' AND (a.status = '0') AND (a.reason = 'Shut-Down' OR a.reason = 'Special Holiday') ORDER BY a.date_created ASC");
	return $this->query($query);
	}
	
	public function select_batch_leave_summary_for_conformance() { //Select Emp batch leave summary 
		// $query = ("SELECT a.*, CONCAT(b.lastname, ', ', b.firstname) AS Emp_Name FROM tbl_leave_application a INNER JOIN vw_EmpInfo_Rapid b ON a.empName = b.username WHERE (a.status = '2' OR a.status = '3' OR a.status = '4' OR a.status = '6') AND (a.reason = 'Shut-Down' OR a.reason = 'Special Holiday') ORDER BY a.date_created ASC");
		$query = ("SELECT a.*, CONCAT(b.lastname, ', ', b.firstname) AS Emp_Name FROM tbl_batch_leave_application a INNER JOIN vw_EmpInfo_Rapid b ON a.empName = b.username WHERE (a.status = '2' OR a.status = '3' OR a.status = '4' OR a.status = '6') AND (a.reason = 'Shut-Down' OR a.reason = 'Special Holiday') ORDER BY a.date_created ASC");
	return $this->query($query);
	}
	
	public function select_leave_batch($EmpNo) { //Select leave batch 
		$query = ("SELECT a.*, c.EmpNo FROM vw_subordinate_list a INNER JOIN tbl_Subordinate b ON a.pkid = b.pkid INNER JOIN tbl_EmployeeInfo c ON b.SectionHead = c.EmpNo  WHERE a.SectionHead = '".$EmpNo."' ");
		return $this->query($query);
	}
	
	public function select_batch_leave_info_by_pkid($pkid) { // Get leave info
		$query = ("SELECT a.*, 
			CONCAT(b.FirstName, ' ',b.LastName) AS Emp_Name, 
				c.fk_batch_leave_app, 
				c.fk_leave_applied,
				c.date_from,
				c.date_to,
				c.total_absent_days,
				c.cutoff_date
			FROM 
				tbl_batch_leave_application a 
								
			INNER JOIN 
				tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
								
			INNER JOIN 
				vw_batch_leave_dates c ON a.pkid = c.fk_batch_leave_app 
			WHERE
				a.pkid = '$pkid' ");
		return $this->query($query);
	}
	
	public function select_batch_leave_info_for_cancel_by_pkid($pkid) { // Get leave info
		$query = ("SELECT * FROM tbl_batch_leave_application WHERE pkid = '$pkid' ");
		return $this->query($query);
	}
	
	public function batch_show_remarks($pkid) { //show remarks
		$query = ("SELECT DH_disapproved_remarks, Cancelled_remarks FROM tbl_batch_leave_application WHERE pkid = '$pkid' AND logdel = 0 ");
		return $this->query($query);
	}	
	
	public function Select_leave_emp_batch() { //Select_leave_emp_batch
		$query = ("SELECT `pkid`, `leave_applied` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"); 
		return $this->query($query);
	}

	public function get_leave_batch($SectionHead) { //leave  records for approvers
		$query = ("SELECT a.*, b.* FROM tbl_Subordinate a INNER JOIN vw_subordinate_list b ON b.pkid = a.pkid WHERE a.SectionHead = '$SectionHead'");				
		return $this->query($query);
	}
	
	public function Select_batch_leave_record_for_update() { //Select_batch_leave_record_for_update
		$query = ("SELECT `pkid`, `leave_applied`, `approver2` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"); 
		return $this->query($query);
	}
	
	public function Select_batch_leave_as_draft() { //Select_batch_leave_as_draft
		$query = ("SELECT `pkid`, `created_by`, `EmpNo`, `leave_applied`, `approver2` FROM `tbl_batch_leave_application` ORDER BY `pkid` DESC LIMIT 1"); 
		return $this->query($query);
	}
	
	public function Select_batch_leave() { //Select_batch_leave
		$query = ("SELECT `pkid`, `leave_applied`, `approver2` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"); 
		return $this->query($query);
	}
		
	public function save_leave_batch($fkEmployee, $status, $date_created, $empName, $EmpNo, $Division, $leave_applied, $day_type, $reason, $approver2, $username) { 
		$query = ("INSERT INTO tbl_leave_application (`fkEmployee`,`status`,`date_created`,`empName`,`EmpNo`,`Division`,`leave_applied`,`day_type`,`reason`,`approver2`, `username`)
			 VALUES ('$fkEmployee','0','$date_created','$empName','$EmpNo','$Division','1','$day_type','$reason','$approver2', '$username') ");
		return $this->query($query);
	}
			
	public function select_leave_batch_info_by_pkid($pkid) { // Get leave info
		$query = ("SELECT a.*, CONCAT(b.FirstName, ' ',b.LastName) AS Emp_Name
			FROM 
				tbl_leave_application a 
								
			INNER JOIN 
				tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
								
			WHERE
				a.pkid = '$pkid' ");
		return $this->query($query);
	}
	
	public function select_batch_emp($pkid) { // Get leave info
		$query = ("SELECT a.*, 
			CONCAT(b.FirstName, ' ',b.LastName) AS Emp_Name, 
				c.fk_batch_leave_app, 
				c.fk_leave_applied,
				c.date_from,
				c.date_to,
				c.total_absent_days
			FROM 
				tbl_batch_leave_application a 
								
			INNER JOIN 
				tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
								
			INNER JOIN 
				vw_batch_leave_dates c ON a.pkid = c.fk_batch_leave_app 
			WHERE
				a.pkid = '$pkid' ");
		return $this->query($query);
	}
	
	public function select_batch_emp_list($pkid) { //Select Emp list 
		$query = ("SELECT * FROM vw_Batch_Emp_list WHERE logdel = '0' AND fkid ='$pkid' ");
		return $this->query($query);
	}
	
	public function Update_batch_leave($pkid, $status) { // Update_batch_leave
	$query = ("UPDATE `tbl_batch_leave_application` SET 
				`status` = '0' WHERE `pkid` = '$pkid' AND `logdel` = '0'");
	return $this->query($query);
	}	
	
	/* For AM-Up */
	public function select_AMUp_list_by_pkid($pkid) { //Select Emp list by pkid 
		$query = ("SELECT a.*, CONCAT(a.CityAddress2, ', ', a.CityAddress3) AS emp_address, b.Division AS Division, c.username AS amup_username FROM tbl_EmployeeInfo a INNER JOIN tbl_Division b ON b.pkid = a.fkDivision INNER JOIN vw_secheads c ON c.EmpNo = a.EmpNo WHERE a.pkid = '$pkid'");
		return $this->query($query);
	}
	
	public function select_AmUp_list() { //Select Emp list 
		// $query = ("SELECT * FROM vw_secheads");
		$query = ("SELECT * FROM tbl_EmployeeInfo WHERE EmpStatus = '1' AND SalaryType = '3'");
		return $this->query($query);
	}
		
	public function getAMUp_Name() { //Get Emp name
		$query = ("SELECT * FROM vw_secheads");
	return $this->query($query);
	}
	
	public function Select_AMUp_leave_as_draft() { //Select_AMUp_leave_as_draft
		$query = ("SELECT `pkid`, `empName`, `created_by`, `EmpNo`, `leave_applied` FROM `tbl_leave_application` ORDER BY `pkid` DESC LIMIT 1"); 
		return $this->query($query);
	}
	
	public function select_amup_leave_summary() { //Select Emp leave summary 
		// $query = ("SELECT a.*, CONCAT(b.FirstName, ' ', b.LastName) AS Emp_Name, b.SalaryType FROM tbl_leave_application a INNER JOIN tbl_EmployeeInfo b ON b.EmpNo = a.EmpNo WHERE (a.status = '2' OR a.status = '3' OR a.status = '7') AND (a.`created_by` = 'marbonc') AND a.logdel = '0' ORDER BY date_created DESC, status ASC");
		// $query = ("SELECT a.*, CONCAT(b.FirstName, ' ', b.LastName) AS Emp_Name, b.SalaryType FROM tbl_leave_application a INNER JOIN tbl_EmployeeInfo b ON b.EmpNo = a.EmpNo WHERE (a.status = '2' OR a.status = '7') AND (a.`created_by` = 'marbonc') AND a.logdel = '0' ORDER BY date_created DESC, status ASC");
		//- 03262020
		$query = ("SELECT a.*, CONCAT(b.FirstName, ' ', b.LastName) AS Emp_Name, b.SalaryType 
					FROM tbl_leave_application a 
					INNER JOIN tbl_EmployeeInfo b ON b.EmpNo = a.EmpNo 
					WHERE (a.status = '2' OR a.status = '7') AND a.logdel = '0' AND YEAR(a.date_created) = YEAR(CURRENT_DATE())
					ORDER BY date_created DESC, status ASC");

				// WHERE (a.status = '2' OR a.status = '7') AND a.logdel = '0'

	return $this->query($query);
	}

	public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}
	
	public function select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $query;
	}
	
	// 11/2/2017 
	public function select_empNo() { //Select Emp list 
		$query = ("SELECT * FROM tbl_EmployeeInfo WHERE (`HiringStatus` = '2' OR `HiringStatus` = '3') AND `EmpStatus` = '1' ORDER BY EmpNo ASC");
		return $this->query($query);
	}
	
	public function select_leave_conversion() { //select leave conversion
		$query = ("SELECT * FROM tbl_leave_conversion WHERE date_conversion >= CURDATE() - INTERVAL 1 YEAR
			ORDER BY EmpNo ASC");
	return $this->query($query);
	}
	
	public function select_leave_conversion_info($pkid) { // select leave conversion info
		$query = ("SELECT * FROM tbl_leave_conversion WHERE pkid = '$pkid' ");
	return $this->query($query);
	}
	
	public function update_leave_conversion($pkid, $vl_balance, $vl_convertible) { //update leave conversion
		$query = ("UPDATE `tbl_leave_conversion` SET `vl_balance` = '$vl_balance', `vl_convertible` = '$vl_convertible' WHERE `pkid` = '$pkid' ");
		return $this->query($query);
	}	
	
	public function add_new_leave_conversion($fkEmployee, $EmpNo, $username, $empName, $SalaryType, $date_conversion, $vl_balance, $vl_convertible, $lastupdate) { //Add new leave conversion 
		$query = ("INSERT INTO tbl_leave_conversion (`fkEmployee`, `EmpNo`, `username`, `empName`, `SalaryType`, `date_conversion`, `vl_balance`, `vl_convertible`, `lastupdate`) 
				VALUES ('$fkEmployee', '$EmpNo', '$username', '$empName', '$SalaryType', '$date_conversion', '$vl_balance', '$vl_convertible', '$lastupdate')");
		return $this->query($query);
	}

	
	
	public function select_leave_conversion_summary($username) { //select leave conversion
		$query = ("SELECT * FROM tbl_leave_conversion WHERE username = '$username'");
	return $this->query($query);
	}
	
	/* ISS View */
	
	public function select_leave_history_for_iss() { 
	$query = ("SELECT a.*, 
			b.FirstName, 
			b.LastName, 
			c.fk_leave_app, 
			c.fk_leave_applied,
			c.date_from,
			c.date_to,
			c.total_absent_days,
			c.no_of_paid,
			c.cutoff_date,
		CONCAT(d.firstname, ' ', d.lastname) AS approvername1,
		CONCAT(e.firstname, ' ', e.lastname) AS approvername2
		FROM 
			tbl_leave_application a 
		INNER JOIN 
			tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
		INNER JOIN 
			vw_leave_dates c ON a.pkid = c.fk_leave_app 
		INNER JOIN 
			vw_secheads d ON a.approver1 = d.username
		INNER JOIN 
			vw_secheads e ON a.approver2 = e.username 						
		WHERE
			(a.status = '0' OR a.status = '1' OR a.status = '2' OR a.status = '3' OR a.status = '5' OR a.status = '6')  AND (a.EmpNo = 'J005' OR a.EmpNo = 'K010' OR a.EmpNo = 'M131' OR a.EmpNo = 'M132' OR a.EmpNo = 'M138' OR a.EmpNo = 'N110') AND a.logdel = '0' ORDER BY a.date_created ASC");
	return $this->query($query);
	}

	/**
	 * Check if the Leave Date(date_absent_from) is already existed by its employee id
	 * Added by whyRainbowDoesntHaveBlack
	 * 09-04-2024
	 */
	public function checkIfLeaveDateIsExisted($EmpNo, $date_absent_from) {
		/**
		 * Orig Code
		 * Commented by whyRainbowDoesntHaveBlack
		 * 10-11-2024
		 */
		// $query = ("SELECT COUNT(*) AS total_count FROM tbl_leave_dates 
		// 			INNER JOIN tbl_leave_application ON tbl_leave_dates.fk_leave_app = tbl_leave_application.pkid
		// 			WHERE EmpNo = '$EmpNo' 
		// 			AND date_absent_from = '$date_absent_from'");
		// return $this->query($query);

		/**
		 * Add condition for cancelled filed leaves that shouldn't prohibit the user from filing same dates
		 * This will ensure to file same $date_absent_from if its status is cancelled
		 * Added by whyRainbowDoesntHaveBlack
		 * 10-11-2024
		 */
		$query = ("SELECT Count(*) AS total_count
					FROM   tbl_leave_dates
						INNER JOIN tbl_leave_application
								ON tbl_leave_dates.fk_leave_app = tbl_leave_application.pkid
					WHERE  tbl_leave_application.status != 8
						AND tbl_leave_application.status != 9
						AND tbl_leave_application.status != 6
						AND tbl_leave_dates.empno = '$EmpNo' 
						AND tbl_leave_dates.date_absent_from = '$date_absent_from'
		");
		return $this->query($query);
	}
} // end
?>

