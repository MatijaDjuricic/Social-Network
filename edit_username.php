<?php
    require_once 'inc/init.php';
    require_once 'app/classes/User.php';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $user = new User();
        $current_username = clean($_POST['current_username']);
        $new_username = clean($_POST['edit_username_input']);
        if ($new_username !== $current_username) {
            $user->update_username($new_username);
            redirect('edit_profile.php');
        }
        redirect('edit_profile.php');
    }
?>