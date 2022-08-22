<?php
function generate_password($password_length=16){
    $alphabet           = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890,.-_;:+*,.-_;:+*,.-_;:+*,.-_;:+*';
    $password           = array();
    $length             = strlen($alphabet) -1;

    for($i = 0; $i < $password_length; $i++){
        $c      = rand(0, $length);
        array_push($password, $alphabet[$c]);
    }
    return implode($password);
}

function generate_secret($password_length = 48){
    $alphabet           = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890';
    $password           = array();
    $length             = strlen($alphabet) -1;

    for($i = 0; $i < $password_length; $i++){
        $c      = rand(0, $length);
        array_push($password, $alphabet[$c]);
    }
    return implode($password);
}

?>