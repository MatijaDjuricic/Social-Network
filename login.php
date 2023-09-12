<?php
    require_once 'inc/header.php';
    if (isset($_SESSION['user_id'])) {
        redirect('index.php');
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = clean($_POST['username']);
        $email = validate_email(clean($_POST['email']));
        $password = clean($_POST['password']);
        $result = $user->login($username, $email, $password);
        if ($result) {
            $_SESSION['message']['type'] = "success";
            $_SESSION['message']['text'] = "Success: User was successfully logged in";
            redirect('index.php');
        } else {
            $_SESSION['message']['type'] = "danger";
            $_SESSION['message']['text'] = "Error: Invalid user informations";
            redirect('login.php');
        }
    }
?>
<header class="bg-info">
    <p>Social Network | Log In</p>
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
        <h1>Log in</h1>
        <div class="single-form-container">
            <form class="single-form" action="" method="POST">
                <div class="input-group has-validation item">
                    <span class="input-group-text">required*</span>
                    <div class="form-floating">
                        <input name="username" type="text" class="form-control" id="floatingInputGroup2" placeholder="Username" required>
                        <label for="floatingInputGroup2">Username:</label>
                    </div>
                </div>
                <div class="input-group has-validation item">
                    <span class="input-group-text">required*</span>
                    <div class="form-floating">
                        <input name="email" type="email" class="form-control" id="floatingInputGroup2" placeholder="Email" required>
                        <label for="floatingInputGroup2">Email:</label>
                    </div>
                </div>
                <div class="input-group has-validation item">
                    <span class="input-group-text">required*</span>
                    <div class="form-floating">
                        <input name="password" type="password" class="form-control" id="floatingInputGroup2" placeholder="Password" required>
                        <label for="floatingInputGroup2">Password</label>
                    </div>
                </div><br>
                <div class="forms-buttons">
                    <button type="submit" class="btn btn-primary">log In <i class="fa-solid fa-right-to-bracket"></i></button>
                    <a href="register.php" class="link-underline-success">Register <i class="fa-regular fa-registered"></i></a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'inc/footer.php'; ?>