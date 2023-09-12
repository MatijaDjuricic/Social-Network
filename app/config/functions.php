<?php
function redirect($location) {
    ob_start();
    header("location: {$location}");
    ob_end_flush();
    exit();
}
function validate_email($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return $email;
}
function clean($string) {
    return htmlentities($string);
}
function hash_password($password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    return $password;
}
function display_datetime($string) {
    return date("G:i A - F, jS Y.", strtotime($string));
}