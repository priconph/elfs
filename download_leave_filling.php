<?php
$file = $_GET['filename'];
if( $file == 'LeaveFilling') {
	$filename = 'attachment/Leave Filling  - User Manual.pdf'; 
} else if( $file == 'MassFilling') {
	$filename = 'attachment/Mass Filling - User Manual.pdf';  
} 
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false); 
header('Content-Type: application/vbs');

header('Content-Disposition: attachment; filename="'. basename($filename) . '";');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($filename));

readfile($filename);

exit;
?>