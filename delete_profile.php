<?php
require_once 'inc/init.php';
require_once 'app/classes/User.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $confirm_input = $_POST['confirm_delete_input'];
    $confirm_str = 'confirm';
    if (strtolower($confirm_input) == $confirm_str) {
        $user = new User();
        $user->delete();
        $_SESSION['message']['type'] = "success";
        $_SESSION['message']['text'] = "Success: User was successfully deleted";
        redirect('login.php');
    } else {
        $_SESSION['message']['type'] = "danger";
        $_SESSION['message']['text'] = "Error: You are not type CONFIRM in input field correctly";
        redirect('edit_profile.php');
    }
}