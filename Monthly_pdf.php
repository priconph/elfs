<?php
ob_start();
require_once('tcpdf/tcpdf.php');

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
	
class ELFSPDF extends TCPDF {
	
	public function Header() {
        if ($this->page == 1) {
		// $image_file = K_PATH_IMAGES.'pricon-logo.png';
        // $this->Image($image_file, 12, 10, 85, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // $this->Image($image_file, 15, 50, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
 // Set font
		$this->SetFont('helveticai', '', 15);
		$txt = <<<EOD
LEAVE TRANSACTION REPORT
Monthly Employees
EOD;
		$this->Write(5, $txt, '', 0, 'L', true, 0, false, false, 0);
				
        $this->SetFont('helveticai', '', 10);
        $tDate=date('F j, Y');
        $this->Cell(5, 10, 'As of: '.$tDate, 0, false, 'L', 0, '', 0, false, 'T', 'L');
		} else {
		$this->SetFont('helveticai', '', 9);
		$txt = <<<EOD
			  Employee				Employee																																												Date Absent													No. of						Paid 										Reason/s
			  Number						Name																																									FROM 														TO											days								Leave  	
EOD;
		$this->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
			}
        }

    // Page footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helveticai', '', 10);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new ELFSPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetTitle('Monthly Transaction Report');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+8);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM-5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// --------------------------------------------------------- //
require_once('elfs_oop.php');

$pdf->AddPage();

$styleline = array('width' => 0.4, 'cap' => 'round', 'join' => 'round', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(13, 50, 195, 50, $styleline);
// $pdf->Line(totheright, heightleft, width, heightright, $styleline);

$pdf->SetFont('helveticai', '', 10);
$tbl = '';
$tbl = <<<EOD
<br>
<br>
<br>
<br>

<table>
EOD;

$tbl .= <<<EOD
<tr>
        <td width="3%" align="left"><strong style="font-size: 11px;"></strong></td>
        <td width="10%" align="left"><strong style="font-size: 11px;">Employee</strong></td>
		<td width="26%" align="left"><strong style="font-size: 11px;">Employee</strong></td>
		<td width="26%" align="center"><strong style="font-size: 11px;">Date Absent</strong></td>
		<td width="8%" align="left"><strong style="font-size: 11px;">No. of</strong></td>
		<td width="10%" align="left"><strong style="font-size: 11px;">Paid</strong></td>
		<td width="12%" align="left"><strong style="font-size: 11px;">Reason/s</strong></td>
</tr>
<tr>
        <td width="3%" align="left"><strong style="font-size: 11px;"></strong></td>
        <td width="10%" align="left"><strong style="font-size: 11px;">Number</strong></td>
		<td width="26%" align="left"><strong style="font-size: 11px;">Name</strong></td>
		<td width="12%" align="center"><strong style="font-size: 11px;">FROM</strong></td>
		<td width="13%" align="center"><strong style="font-size: 11px;">TO</strong></td>
		<td width="6%" align="center"><strong style="font-size: 11px;">days</strong></td>
		<td width="11%" align="center"><strong style="font-size: 11px;">Leave</strong></td>
</tr>
	<br>
EOD;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Get Leave Applied
	$leave_applied = 0;
	$Division = 0;

	$result =  ELFS::getInstance()->select_monthly_Leave_applied();
    while ($row = mysqli_fetch_array($result))
	{
		
        $drLeaveApplied[$leave_applied] 	= $row['leave_applied'];
        $drDivision[$Division] 				= $row['Division'];
			
		$leave_applied++;
		$Division++;
    }
	
	$totalLeave = count($drLeaveApplied);

    for($x = 0; $x < $totalLeave; $x++)
    {

	$tbl .= <<<EOD
	<br>
	<tr>
        <td width="83%" align="left"><strong style="font-size: 13px;"><u>$drLeaveApplied[$x]</u></strong></td>
    </tr>
	<tr>
        <td width="83%" align="left"><strong style="font-size: 12px;">$drDivision[$x]</strong></td>
	</tr>
	<tr>
        <td width="100%" align="left">___________________________________________________________________________________________</td>
	</tr>

EOD;

	
$result =  ELFS::getInstance()->select_monthly_pdf($drLeaveApplied[$x], $drDivision[$x], $startDate, $endDate);
$ctr = 0;
$i = 1;

while($row = mysqli_fetch_array($result)){
$EmpNo 				= $row['EmpNo'];
$LastName 			= $row['LastName'];
$FirstName 			= $row['FirstName'];
$MiddleName 		= $row['MiddleName'];
// $date_absent_from 	= $row['date_absent_from'];
// $date_absent_to 	= $row['date_absent_to'];
// $no_of_days 		= $row['no_of_days'];
$date_absent_from 	= $row['date_from'];
$date_absent_to 	= $row['date_to'];
$no_of_days 		= $row['total_absent_days'];
$no_of_paid 		= $row['no_of_paid'];
$reason 			= $row['reason']; 

$tbl .= <<<EOD
    <tr>
        <td width="3%" align="left" ><strong style="font-size: 10px;">$i</strong></td>
        <td width="10%" align="left" ><strong style="font-size: 10px;">$EmpNo</strong></td>
		<td width="29%" align="left" ><strong style="font-size: 10px;">$LastName, $FirstName ($MiddleName)</strong></td>
		<td width="12%" align="left" ><strong style="font-size: 10px;">$date_absent_from</strong></td>
		<td width="13%" align="left" ><strong style="font-size: 10px;">$date_absent_to</strong></td>
		<td width="8%" align="left" ><strong style="font-size: 10px;">$no_of_days</strong></td>
		<td width="8%" align="left" ><strong style="font-size: 10px;">$no_of_paid</strong></td>
		<td width="12%" align="left" ><strong style="font-size: 10px;">$reason</strong></td>
    </tr>
EOD;

$i++;
$ctr++;

}

} //end for loop

////////////////////////////////////////////////////////////////////////////////////////


$pdf->writeHTML($tbl, true, false, false, false, '');
// ---------------------------------------------------------
ob_end_clean();
$pdf->Output('Monthly Transaction Report.pdf', 'I');
