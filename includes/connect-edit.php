<?php
$host = '';
$user = '';
$pass = '';
$db = '';
$charset = 'UTF-8';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error)
{
    die ('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . "\n");
}
//echo 'Success... ' . $mysqli->host_info . "\n";
?>
