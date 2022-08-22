<?php




$data['tr_convention_name']	            	= $_POST['tr_convention_name'];
$data['tr_convention_text']            		= $_POST['tr_convention_text'];

$data['tr_convention_modify_id']      		= $_SESSION['tr_user_id'];
$data['tr_convention_modify_ts']       		= time();


$query		= "Convention anlegen";
$db_result 	= db_insert("tr_convention", $data);





include("admin_convention.php");



?>
