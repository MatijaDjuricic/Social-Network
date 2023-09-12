<?php
    require_once 'inc/init.php';
    require_once 'app/classes/User.php';
    if ($_SERVER['REQUEST_METHOD'] == "POST") { 
        $user = new User();
        $current_email = clean($_POST['current_email']);
        $new_email = clean($_POST['edit_email_input']);
        if ($new_email !== $current_email) {
            $user->update_email($new_email);
            redirect('edit_profile.php');
        }
        redirect('edit_profile.php');
    }
?>