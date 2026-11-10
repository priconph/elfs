<?php
    require('../media/PHPExcel.php'); 
    //require_once('OOP.php'); //change this with your OOP path
    session_start();
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    $getDate1 = new DateTime(substr_replace($startDate, "01", 8, 2));
    $getDate2 = new DateTime(substr_replace($endDate, "31", 8, 2));

    $intervalYr = $getDate1->diff($getDate2)->format('%Y');
    $intervalMon = $getDate1->diff($getDate2)->format('%M');
    $firstMonth = $getDate1->format('M');
    $firstYr = $getDate1->format('Y');

    $test = $getDate1->format('Y-m-d');

    for($x=$intervalYr; $x != 0; $x--)
    {
        $intervalMon = $intervalMon + 12;
    }

    //Database Connection
    mysql_connect('localhost', 'root', 'newd3v');
    mysql_select_db('db_hris');

    //Create new PHPExcel Page
    $objPHPExcel = new PHPExcel;
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Segoe UI Semibold');
    //Font Size: Global
    $objPHPExcel->getDefaultStyle()->getFont()->setSize(11);

    //Create Sheet
    $objWorkSheet = $objPHPExcel->getActiveSheet();
    $title = "JSSS"; //set title cont.
    $objWorkSheet->setTitle($title); //set title cont.


    //FORMAT
    //Border Style
    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN //set borders
        )
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID, //set back color
        'color' => array('rgb'=>'FFFFFF'),
        )
    );

    $styleHeader = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN //set borders
        )
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID, //set back color
        'color' => array('rgb'=>'AED6F1'),
        )
    );

   //Horizontal
    $objWorkSheet->getStyle('A2:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    //Vertical
    $objWorkSheet->getStyle('A2:L2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 
    //Set width: Static
    $objWorkSheet->getColumnDimension('A')->setWidth(15);
    $objWorkSheet->getColumnDimension('B')->setWidth(20);
    $objWorkSheet->getColumnDimension('C')->setWidth(15);
    $objWorkSheet->getColumnDimension('D')->setWidth(25);
    $objWorkSheet->getColumnDimension('E')->setWidth(20);
    $objWorkSheet->getColumnDimension('F')->setWidth(20);
    $objWorkSheet->getColumnDimension('G')->setWidth(25);
    $objWorkSheet->getColumnDimension('H')->setWidth(25);
    $objWorkSheet->getColumnDimension('I')->setWidth(15);
    $objWorkSheet->getColumnDimension('J')->setWidth(15);
    $objWorkSheet->getColumnDimension('K')->setWidth(25);
    $objWorkSheet->getColumnDimension('L')->setWidth(30);
	
    //Border
    $objWorkSheet->getStyle('A2:L2')->applyFromArray($styleHeader);

    //Wrap Text
    $objWorkSheet->getStyle('A2:L2')->getAlignment()->setWrapText(true);

    //Set height: Static 
    $objWorkSheet->getRowDimension(1)->setRowHeight(19);
    $objWorkSheet->getRowDimension(2)->setRowHeight(19);
    $objWorkSheet->getRowDimension(3)->setRowHeight(19);
	$objPHPExcel->getActiveSheet()->setAutoFilter('A2:L2');
	
    //Set font size
    $objWorkSheet->getStyle('A2:L2')->getFont()->setSize(11);

    //Merge Cells
    $objWorkSheet->mergeCells('A1:I1');
    $objWorkSheet->mergeCells('A2:A2');
    $objWorkSheet->mergeCells('B2:B2');
    $objWorkSheet->mergeCells('C2:C2');
    $objWorkSheet->mergeCells('D2:D2');
    $objWorkSheet->mergeCells('E2:E2');
    $objWorkSheet->mergeCells('F2:F2');
    $objWorkSheet->mergeCells('G2:G2');
    $objWorkSheet->mergeCells('H2:H2');
    $objWorkSheet->mergeCells('I2:I2');
    $objWorkSheet->mergeCells('J2:J2');
    $objWorkSheet->mergeCells('K2:K2');
    $objWorkSheet->mergeCells('L2:L2');
      
    //DEFAULT Values
    $objWorkSheet->setCellValue('A1', 'JS / SS EMPLOYEE - LEAVE TRANSACTION REPORT');
    $objWorkSheet->setCellValue('A2', 'Status');
    $objWorkSheet->setCellValue('B2', 'Date Created');
    $objWorkSheet->setCellValue('C2', 'Employee No.');
    $objWorkSheet->setCellValue('D2', 'Employee Name');
    $objWorkSheet->setCellValue('E2', 'Division');
    $objWorkSheet->setCellValue('F2', 'Leave Applied');
    $objWorkSheet->setCellValue('G2', 'Date Absent (From)');
    $objWorkSheet->setCellValue('H2', 'Date Absent (To)');
    $objWorkSheet->setCellValue('I2', 'No of days');
    $objWorkSheet->setCellValue('J2', 'Paid Leave');
    $objWorkSheet->setCellValue('K2', 'Reason');
    $objWorkSheet->setCellValue('L2', 'Other Reason');
   
		 $ctrRow = 3;
		//Horizontal
		// $objWorkSheet->getStyle('A:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objWorkSheet->getStyle('A:C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objWorkSheet->getStyle('E:K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Vertical
		// $objWorkSheet->getStyle('A:J')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objWorkSheet->getStyle('A:C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objWorkSheet->getStyle('E:K')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	   //Border
		$objWorkSheet->getStyle('A'.$ctrRow.':L'.$ctrRow)->applyFromArray($styleArray);
	
		//Wrap Text
			$objWorkSheet->getStyle('A'.$ctrRow.':L'.$ctrRow)->getAlignment()->setWrapText(true);

        //Set height: Static 
			$objWorkSheet->getRowDimension($ctrRow)->setRowHeight(25);

        //Set font size
		$objWorkSheet->getStyle('A'.$ctrRow)->getFont()->setSize(10);
		// $sql = "SELECT a.*, CONCAT(b.FirstName, ' ', b.LastName) AS Emp_Name, 
				// c.fk_leave_app, 
				// c.date_absent_from, 
				// c.date_absent_to, 
				// c.no_of_days, 
				// c.no_of_paid,
				// b.HiringStatus FROM `tbl_leave_application` a 
				// INNER JOIN tbl_EmployeeInfo b ON a.fkEmployee = b.pkid 
				// INNER JOIN tbl_leave_dates c ON a.pkid = c.fk_leave_app
				// WHERE (a.`date_created` BETWEEN '$startDate' AND '$endDate') 
				// AND (b.SalaryType = '4') 
				// AND (a.status = '3') 
				// AND (a.logdel = '0') ";
			$sql = "SELECT a.*, CONCAT(b.LastName, ', ', b.FirstName) AS Emp_Name, b.SalaryType, b.HiringStatus, c.leave_applied, d.fk_leave_app, d.date_from, d.date_to, d.total_absent_days, d.no_of_paid FROM `tbl_leave_application` a 
					INNER JOIN tbl_EmployeeInfo b ON b .pkid = a.fkEmployee 
					INNER JOIN tbl_leave_applied c ON c.pkid = a.leave_applied 
					 INNER JOIN vw_leave_dates d ON a.pkid = d.fk_leave_app 
					WHERE (b.SalaryType = '4') AND (a.status = '3') AND (a.`date_created` BETWEEN '$startDate' AND '$endDate') ORDER BY a.date_created ASC";
		$result = mysql_query($sql);
        while ($row = mysql_fetch_array($result))
        {
			if($row['HiringStatus'] == 2) {										
				$status_label = 'Without Leave';
			} 	else if($row['HiringStatus'] == 3) {
				$status_label = 'With Leave';
			}	
			
			if($row['other_reason'] == 0) {										
			$reason_label = 'N/A';
			} 	else if($row['other_reason'] == 1) {
			$reason_label = 'Shut-down';
			}	else if($row['other_reason'] == 2) {
			$reason_label = 'Special Non-working Holiday';
			}	else if($row['other_reason'] == 3) {
			$reason_label = 'Others';
			}	
					
			//title  
            $objWorkSheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(12);
			
			//Horizontal
			// $objWorkSheet->getStyle('A:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objWorkSheet->getStyle('A:C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objWorkSheet->getStyle('E:K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			//Vertical
			// $objWorkSheet->getStyle('A:J')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objWorkSheet->getStyle('A:C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objWorkSheet->getStyle('E:K')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			//Border
			$objWorkSheet->getStyle('A'.$ctrRow.':L'.$ctrRow)->applyFromArray($styleArray);
			
           //Wrap Text
            $objWorkSheet->getStyle('A'.$ctrRow.':L'.$ctrRow)->getAlignment()->setWrapText(true);

            //Set height: Static 
            $objWorkSheet->getRowDimension($ctrRow)->setRowHeight(28);

            //Set font size
            $objWorkSheet->getStyle('A'.$ctrRow.':L'.$ctrRow)->getFont()->setSize(10);
		
            // Set value
            // $objWorkSheet->setCellValue('A'.$ctrRow, $row['status']);
            $objWorkSheet->setCellValue('A'.$ctrRow, $status_label);
            $objWorkSheet->setCellValue('B'.$ctrRow, $row['date_created']);
            $objWorkSheet->setCellValue('C'.$ctrRow, $row['EmpNo']);
            $objWorkSheet->setCellValue('D'.$ctrRow, $row['Emp_Name']);
            $objWorkSheet->setCellValue('E'.$ctrRow, $row['Division']);
            $objWorkSheet->setCellValue('F'.$ctrRow, $row['leave_applied']);
            $objWorkSheet->setCellValue('G'.$ctrRow, $row['date_from']);
            $objWorkSheet->setCellValue('H'.$ctrRow, $row['date_to']);
            $objWorkSheet->setCellValue('I'.$ctrRow, $row['total_absent_days']);
            $objWorkSheet->setCellValue('J'.$ctrRow, $row['no_of_paid']);
            $objWorkSheet->setCellValue('K'.$ctrRow, $reason_label);
            $objWorkSheet->setCellValue('L'.$ctrRow, $row['reason']);
			$ctrRow++;
			
        }
	
	ob_end_clean();
	
    //SAVING
    $writer = new PHPExcel_Writer_Excel2007($spreadsheet);
    unset($styleArray);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //header('Content-Disposition: attachment;filename=Finance Data Details.xlsx'); //used for excel 2007 format
    header('Content-Disposition: attachment;filename = Jsss Transacton Report('.date("Y/m/d").').xls'); // used for excel 2003 format
    header('Cache-Control: max-age=0');

    //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); //used for excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // used for excel 2003 format
    $objWriter->save('php://output');
?>