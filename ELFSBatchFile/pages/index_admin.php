<?php
include('header.php');
if(isset($_GET['param'])){
	$param = unserialize(base64_decode($_GET['param']));
	$page = $param['page'];
	include($page);
}else{
	include('admin.php');
}
include('footer.php');
?>




