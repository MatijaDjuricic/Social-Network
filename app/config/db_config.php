<?php
$server_name = 'localhost';
$mysqli_username = 'root';
$mysqli_password = '';
$db_name = 'social_network';
$conn = mysqli_connect($server_name, $mysqli_username, $mysqli_password, $db_name);
if (!$conn) {
    die("connection error");
}