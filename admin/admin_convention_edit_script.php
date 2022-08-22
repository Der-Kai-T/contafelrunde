<?php



$data['tr_convention_name']	            	= $_POST['tr_convention_name'];
$data['tr_convention_text']            		= $_POST['tr_convention_text'];

$data['tr_convention_modify_id']      		= $_SESSION['tr_user_id'];
$data['tr_convention_modify_ts']       		= time();

$where = array();
$wh['col'] = "tr_convention_id";
$wh['typ'] = "=";
$wh['val'] = $_POST['convention_id'];
array_push($where, $wh);

$query		= "Convention bearbeiten";
$db_result 	= db_update("tr_convention", $data, $where);




$convention_id = htmlspecialchars($_POST['convention_id']);
include("admin_convention_edit.php");



?>
