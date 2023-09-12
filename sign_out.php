<?php
require_once 'inc/init.php';
require_once 'app/classes/User.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = new User();
    $user->sign_out();
    $_SESSION['message']['type'] = "success";
    $_SESSION['message']['text'] = "Success: User was successfully signed out";
    redirect('login.php');
}