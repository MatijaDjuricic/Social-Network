<?php
    require_once 'inc/header.php';
    if (isset($_SESSION['user_id'])) {
        redirect('index.php');
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = clean($_POST['username']);
        $email = validate_email(clean($_POST['email']));
        $password = clean($_POST['password']);
        $confirm_password = clean($_POST['confirm_password']);
        if ($password == $confirm_password) {
            $user->create($username, $email, $password);
            $user->login($username, $email, $password);
            $_SESSION['message']['type'] = "success";
            $_SESSION['message']['text'] = "Success: User was successfully registered and automatically logged in";
            redirect('index.php');
        } else {
            $_SESSION['message']['type'] = "danger";
            $_SESSION['message']['text'] = "Error: Invalid password or confirm password";
            redirect('register.php');
        }
    }
?>
<header class="bg-info">
    <p>Social Network | Register</p>
</header>
<div class="container">
    <div class="row">
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
                <?php
                    echo $_SESSION['message']['text'];
                    unset($_SESSION['message']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <h1>Register</h1>
        <div class="single-form-container">
            <form class="single-form" action="register.php" method="POST">
                <div class="input-group has-validation item">
                    <span class="input-group-text">required*</span>
                    <div class="form-floating">
                        <input name="username" type="text" class="form-control" id="floatingInputGroup3" placeholder="Username" required>
                        <label for="floatingInputGroup3">Username:</label>
                    </div>
                </div>
                <div class="input-group has-validation item">
                    <span class="input-group-text">required*</span>
                    <div class="form-floating">
                        <input name="email" type="email" class="form-control" id="floatingInputGroup3" placeholder="Email" required>
                        <label for="floatingInputGroup3">Email:</label>
                    </div>
                </div>
                <div class="input-group has-validation item">
                    <span class="input-group-text">required*</span>
                    <div class="form-floating">
                        <input name="password" type="password" class="form-control" id="floatingInputGroup3" placeholder="Password" required>
                        <label for="floatingInputGroup3">Password</label>
                    </div>
                </div>
                <div class="input-group has-validation item">
                    <span class="input-group-text">required*</span>
                    <div class="form-floating">
                        <input name="confirm_password" type="password" class="form-control" id="floatingInputGroup3" placeholder="Confirm Password" required>
                        <label for="floatingInputGroup3">Confirm Password</label>
                    </div>
                </div><br>
                <div class="forms-buttons">
                    <button type="submit" class="btn btn-primary">Register  <i class="fa-regular fa-registered"></i></button>
                    <a href="login.php" class="link-underline-success">Log In <i class="fa-solid fa-right-to-bracket"></i></a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'inc/footer.php'; ?>