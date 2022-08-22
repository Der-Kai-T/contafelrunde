<?php


/*
Array
(
    [tr_convention_id] => 1
    [tr_convention_event_id] => 3
    [tr_convention_event_name] => DreieichCon 2022
    [tr_convention_event_location] => Bürgerhaus Sprendlingen, Fichtestraße 55, Dreieieich
    [tr_convention_event_start_date] => 2022-11-26
    [tr_convention_event_start_time] => 10:00
    [tr_convention_event_end_date] => 2022-11-27
    [tr_convention_event_end_time] => 18:00
    [tr_convention_event_text] => Der die das DC in der RW
)

*/


$start_ts                                       = FormTimeToUnix($_POST['tr_convention_event_start_date'] . " " .  $_POST['tr_convention_event_start_time']);
$end_ts                                         = FormTimeToUnix($_POST['tr_convention_event_end_date']   . " " .  $_POST['tr_convention_event_end_time']);


    $data['tr_convention_event_name']       = $_POST['tr_convention_event_name'];
    $data['tr_convention_event_location']   = $_POST['tr_convention_event_location'];
    $data['tr_convention_event_text']       = $_POST['tr_convention_event_text'];
    $data['tr_convention_event_start_ts']   = $start_ts;
    $data['tr_convention_event_end_ts']     = $end_ts ;


    $data['tr_convention_event_modify_id']          = $_SESSION['tr_user_id'];
    $data['tr_convention_event_modify_ts']          = time();

    $where = array();
    $wh['col'] = "tr_convention_event_id";
    $wh['typ'] = "=";
    $wh['val'] = $_POST['tr_convention_event_id'];
    array_push($where, $wh);

    
    $query      = "Event zur Convention bearbeiten"; 
    $db_result  = db_update("tr_convention_event", $data, $where);


        
    $convention_id = $_POST['tr_convention_id'];
    include("admin_convention_edit.php");
?>