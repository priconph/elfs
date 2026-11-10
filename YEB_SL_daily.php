<?php
ob_start();
require_once('tcpdf/tcpdf.php');
	
class ELFSPDF extends TCPDF {
	
	public function Header() {
        if ($this->page == 1) {
		
 // Set font
		$this->SetFont('helveticai', '', 15);
		$txt = <<<EOD
LEAVE BALANCE REPORT - Sick Leave
Daily Employees
EOD;
		$this->Write(5, $txt, '', 0, 'L', true, 0, false, false, 0);
				
        $this->SetFont('helveticai', '', 10);
        $tDate=date('F j, Y');
        $this->Cell(5, 10, 'As of: '.$tDate, 0, false, 'L', 0, '', 0, false, 'T', 'L');
		} else {
		$this->SetFont('helveticai', '', 9);
		$txt = <<<EOD
								Employee 	 Employee 																																Total Credit 							 Total Leave 							  Total
								Number 		  Name	 	 																																						Leave															 Leave													Balance
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
$pdf->SetTitle('Leave Balance Report');

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
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM+5);

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
$pdf->Line(13, 55, 195, 55, $styleline);
// $pdf->Line(totheright, heightleft, width, heightright, $styleline);

$pdf->SetFont('helveticai', '', 10);
$tbl = '';
$tbl = <<<EOD
<br>
<br>
<br>
<br>
<br>

<table>
EOD;

$tbl .= <<<EOD
<tr>
        <td width="5%" align="left"><strong style="font-size: 11px;"></strong></td>
        <td width="10%" align="left"><strong style="font-size: 11px;">Employee</strong></td>
		<td width="30%" align="left"><strong style="font-size: 11px;">Employee</strong></td>
		<td width="16%" align="left"><strong style="font-size: 11px;">Total Credit</strong></td>
		<td width="16%" align="left"><strong style="font-size: 11px;">Total Used</strong></td>
		<td width="12%" align="left"><strong style="font-size: 11px;">Total</strong></td>
</tr>
<tr>
        <td width="5%" align="left"><strong style="font-size: 11px;"></strong></td>
        <td width="10%" align="left"><strong style="font-size: 11px;">Number</strong></td>
		<td width="27%" align="left"><strong style="font-size: 11px;">Name</strong></td>
		<td width="17%" align="center"><strong style="font-size: 11px;">Leave</strong></td>
		<td width="12%" align="center"><strong style="font-size: 11px;">Leave</strong></td>
		<td width="17%" align="center"><strong style="font-size: 11px;">Balance</strong></td>
</tr>
	<br>
EOD;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$result =  ELFS::getInstance()->select_YEB_SL_daily();
$ctr = 0;
$i = 1;

while($row = mysqli_fetch_array($result)){
$EmpNo 					= $row['EmpNo'];
$LastName 				= $row['LastName'];
$FirstName 				= $row['FirstName'];
$MiddleName 			= $row['MiddleName'];
$credit_SL 				= $row['credit_SL']; 
$total_SL_used 			= $row['total_SL_used']; 
$total_SL_balance 		= $row['total_SL_balance']; 

$tbl .= <<<EOD
    <tr>
        <td width="5%" align="left" ><strong style="font-size: 10px;">$i</strong></td>
        <td width="10%" align="left" ><strong style="font-size: 10px;">$EmpNo</strong></td>
		<td width="34%" align="left" ><strong style="font-size: 10px;">$LastName, $FirstName ($MiddleName)</strong></td>
		<td width="15%" align="left" ><strong style="font-size: 10px;">$credit_SL</strong></td>
		<td width="14%" align="left" ><strong style="font-size: 10px;">$total_SL_used</strong></td>
		<td width="17%" align="left" ><strong style="font-size: 10px;">$total_SL_balance</strong></td>
    </tr>
EOD;

$i++;
$ctr++;


} //end for loop

////////////////////////////////////////////////////////////////////////////////////////


$pdf->writeHTML($tbl, true, false, false, false, '');
// ---------------------------------------------------------
ob_end_clean();
$pdf->Output('Year End SL Report.pdf', 'I');
