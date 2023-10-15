<?php

$db_host="db";
$db_user="php_docker";
$db_pass="password";
$db_name="attendanceTracker";

$connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// check connection
if($connect->connect_error)
    die("Connection failed".$connect->connect_error);

    

?>