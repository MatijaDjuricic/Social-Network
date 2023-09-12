<?php
    require_once 'inc/header.php';
    $result = $user->read();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $current_password = clean($_POST['current_password']);
        $new_password = clean($_POST['new_password']);
        $confirm_password = clean($_POST['confirm_password']);
        if (password_verify($current_password, $result['password'])) {    
            if ($new_password == $confirm_password) {
                $user->update_password($new_password);
                $_SESSION['message']['type'] = "success";
                $_SESSION['message']['text'] = "Success: User was successfully changed password";
                redirect('index.php');
            } else {
                $_SESSION['message']['type'] = "danger";
                $_SESSION['message']['text'] = "Error: New password and confirm password was not match";
                redirect('edit_password.php');
            }
        } else {
            $_SESSION['message']['type'] = "danger";
            $_SESSION['message']['text'] = "Error: Invalid current password";
            redirect('edit_password.php');
        }
    }
?>
<header class="bg-info">
    <p>Social Network | Change password</p>
</header>
<div class="container">
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
            <?php
                echo $_SESSION['message']['text'];
                unset($_SESSION['message']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row">
        <h1>Change Password</h1>
        <div class="single-form-container">
            <form class="single-form" action="" method="POST">
                <div class="input-group has-validation item">
                    <span class="input-group-text">Current Password:</span>
                    <input name="current_password" type="password" class="form-control" id="floatingInputGroup2" required>
                </div>
                <div class="input-group has-validation item">
                    <span class="input-group-text">New Password:</span>
                    <input name="new_password" type="password" class="form-control" id="floatingInputGroup2" required>
                </div>
                <div class="input-group has-validation item">
                    <span class="input-group-text">Confirm New Password:</span>
                    <input name="confirm_password" type="password" class="form-control" id="floatingInputGroup3" required>
                </div><br>
                <div class="forms-buttons">
                    <button type="submit" class="btn btn-primary">Confirm  <i class="fa-solid fa-pencil"></i></button>
                    <a href="edit_profile.php" class="link-underline-success">Back</a>
                </div>
            </form>
        </div><br>
    </div>
</div>
<?php require_once 'inc/footer.php'; ?>