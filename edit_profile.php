<?php
require_once 'inc/header.php';
$result = $user->read();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST['photo_path'] != '') {
        $user->profile_image = $_POST['photo_path'];
    } else {
        $user->profile_image = $result['profile_image'];
    }
    $user->update_image();
    redirect('edit_profile.php');
}
?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<header class="bg-info">
    <p>Social Network | Edit profile</p>
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
    <div class="edit-profile-wrapper">
        <h1>Edit Profile Informations</h1>
        <div class="edit-form-container">
            <div class="edit-form" action="" method="POST">
                <div class="edit-info-wrapper">
                    <div class="current-img-wrapper">
                        <form action="" method="POST">
                        <div class="dropzone-div"></div>
                            <input type="hidden" name="photo_path" id="PhotoPathInput">
                        <div id="dropzone-upload" class="dropzone">
                            <img src=" public/profile_images/<?= $result['profile_image']; ?>" alt="profile_image">
                        </div>
                            <button title="Edit Image(save)" type="submit" class="btn btn-primary">Save Image</button>
                        </form>
                    </div>
                    <div class="input-group has-validation item">
                        <span class="input-group-text">Username:</span>
                        <input type="text" class="form-control" id="floatingInputGroup2" value="<?= $result['username']; ?>" disabled>
                        <div class="btn btn-primary edit-btn" onclick="openOverlay(this)">Edit <i class="fa-solid fa-pencil"></i></div>
                        <div class="overlay">
                            <div class="overlay-message-wrapper long-message">
                                <p>If you want to edit username,<br>please edit your current username.</p>
                                <form action="edit_username.php" method="POST">
                                    <input name="current_username" type="hidden" class="form-control" id="floatingInputGroup2" value="<?= $result['username']; ?>">
                                    <input name="edit_username_input" type="text" class="form-control confirm-input" id="floatingInputGroup2" data-id="<?= $result['username']; ?>" value="<?= $result['username']; ?>">
                                    <div class="modal-btn-wrapper">
                                        <div title="Close" class="btn btn-warning" id="wf" onclick="closeOverlay(this)">Close</div>
                                        <button title="Edit Username" type="submit" class="btn btn-primary">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="input-group has-validation item">
                        <span class="input-group-text">Email:</span>
                        <input type="email" class="form-control email-field" id="floatingInputGroup2" data-content="<?= $result['email']; ?>" disabled>
                        <div class="btn btn-primary edit-btn" onclick="openOverlay(this)">Edit <i class="fa-solid fa-pencil"></i></div>
                        <div class="overlay">
                            <div class="overlay-message-wrapper long-message">
                                <p>If you want to edit email,<br>please edit your current email.</p>
                                <form action="edit_email.php" method="POST">
                                    <input name="current_email" type="hidden" class="form-control email-field" id="floatingInputGroup2" value="<?= $result['email']; ?>">
                                    <input name="edit_email_input" type="email" class="form-control confirm-input" id="floatingInputGroup2" data-id="<?= $result['email']; ?>" value="<?= $result['email']; ?>">
                                    <div class="modal-btn-wrapper">
                                        <div title="Close" class="btn btn-warning" id="wf" onclick="closeOverlay(this)">Close</div>
                                        <button title="Edit Email" type="submit" class="btn btn-primary">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="edit-forms-buttons">
                    <form class="edit-form" action="delete_profile.php" method="POST">
                        <div class="btn btn-danger btn-sm" onclick="openOverlay(this)">Delete Profile <i class="fa-solid fa-trash"></i></div>
                        <div class="overlay">
                            <div class="overlay-message-wrapper long-message">
                                <p>If you want to delete profile,<br>please type CONFIRM to confirm the profile deletion process.</p>
                                <input style="text-transform: uppercase;" name="confirm_delete_input" type="text" placeholder="CONFIRM" class="form-control confirm-input" id="floatingInputGroup2" data-id="">
                                <div class="modal-btn-wrapper">
                                    <div title="Close" class="btn btn-warning" id="wi" onclick="closeOverlay(this)">Close</div>
                                    <button title="Delete Profile" type="submit" class="btn btn-primary">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-links">
                        <a href="edit_password.php" class="link-underline-success">Change password</a>
                        <a href="index.php" class="link-underline-success">Back</a>
                    </div>
                </div>
            </div>
        </div><br>
    </div>
</div>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.options.dropzoneUpload = {
        url: "upload_photo.php",
        paramName: "photo",
        maxFilesize: 20,
        acceptedFiles: "image/*",
        init: function() {
            this.on("success", function(file, response) {
                const jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    document.getElementById('PhotoPathInput').value = jsonResponse.photo_path;
                } else {
                    console.error(jsonResponse.error);
                }
            });
        }
    };
</script>
<?php require_once 'inc/footer.php'; ?>