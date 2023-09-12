<?php
    require_once 'inc/header.php';
    require_once 'app/classes/Like.php';
    require_once 'app/classes/Post.php';
    require_once 'app/classes/Comment.php';
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
    $post = new Post();
    $comment = new Comment();
    $user_info = $user->read();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $content = $_POST['post_text'];
        if (strlen($content) >= 1) {
            $post->create($_SESSION['user_id'], $content);
            redirect('index.php');
        } else {
            $_SESSION['message']['type'] = "danger";
            $_SESSION['message']['text'] = "Error: Message must contain 1 or more characters";
            redirect('index.php');
        }
    }
?>
 <header>
        <nav>
            <p>Social Network</p>
            <div class="nav-buttons">
                <div class="nav-info-wrapper">
                    <p>Hi, <?= $user_info['username']; ?></p>
                    <img src="public/profile_images/<?= $user_info['profile_image']; ?>" alt="profile_image">
                </div>
                <div class="nav-buttons-wrapper">
                    <a href="edit_profile.php"><button class="btn btn-secondary btn-sm">Edit Profle <i class="fa-solid fa-pencil"></i></button></a>
                    <form action="sign_out.php" method="POST">
                        <button type="submit" class="btn btn-danger btn-sm">Sign Out <i class="fa-solid fa-right-from-bracket"></i></button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-<?= $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
                <?php
                    echo $_SESSION['message']['text'];
                    unset($_SESSION['message']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="row">
            <form class="post-form" action="" method="POST">
                <textarea name="post_text" placeholder="Post Text..."></textarea>
                <button title="Send Post" type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
            <div class="all-posts">
                <?php
                    $results = $post->read();
                    foreach($results as $result) :
                ?>
                <div class="users-posts"><hr>
                    <div class="single-post">
                        <p>Author: <i><?php if($result['user_username'] != '') echo $result['user_username']; else echo 'undefined'; ?>
                        <img class="post-image" src="public/profile_images/<?= $result['user_profile_image']; ?>" alt="profile_image"> - <?= display_datetime($result['created_at']); ?></i></p>
                            <div class="post-content"><b><?= $result['post_content']; ?></b></div>
                            <span><i>likes: </i><b><?= $result['post_likes']; ?></b></span>
                            <span><i>comments: </i><b><?= $comment->get_number($result['post_id']); ?></b></span>
                        <div class="post-actions">
                            <div class="post-comments" data-post_id="<?= $result['post_id']; ?>">
                                <?php
                                    $results = $comment->read();
                                    foreach($results as $result_comment) :
                                    if ($result['post_id'] == $result_comment['comments_post_id']) : ?>
                                    <div class="all-comment">
                                        <p>Comment by: <i><?= $result_comment['comment_username']; ?>
                                        <img class="post-image" src="public/profile_images/<?= $result_comment['user_profile_image']; ?>" alt="profile_image"> - <?= display_datetime($result_comment['comment_created_at']); ?></i></p>
                                        <div class="comment-content"><b><?= $result_comment['comment_content']; ?></b></div>
                                        <?php if ($result_comment['comment_username'] == $user_info['username']) :?>
                                            <form class="delete-comment" action="delete_comment.php" method="POST">
                                                <input type="hidden" name="comment_id" value="<?= $result_comment['comment_id']; ?>">
                                                <div title="Delete Comment" class="btn btn-warning btn-sm" onclick="openOverlay(this)"><i class="fa-solid fa-trash"></i></div>
                                                <div class="overlay">
                                                    <div class="overlay-message-wrapper">
                                                        <p>Do you want to delete comment?</p>
                                                        <div class="modal-btn-wrapper">
                                                            <div title="Close" class="btn btn-warning" onclick="closeOverlay(this)">No</div>
                                                            <button title="Delete Comment" type="submit" class="btn btn-primary">Yes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div><hr>
                                <?php endif; endforeach; ?>
                                <form action="comment.php" method="POST">
                                    <input type="hidden" name="post_id" value="<?= $result['post_id']; ?>">
                                    <input name="comment_content" class="form-control comment-input" placeholder="Type comment..." type="text">
                                    <button title="Send Comment" type="submit" class="btn btn-primary btn-sm post-comment-btn"><i class="fa-solid fa-paper-plane paper-plane"></i></button>
                                </form>
                            </div>
                            <div class="post-buttons">
                                <?php if ($_SESSION['user_id'] != $result['user_id']) : ?>
                                    <?php if ($post->is_liked($result['post_id'])) : ?>
                                        <form action="likes.php" method="POST">
                                            <input type="hidden" name="post_id" value="<?= $result['post_id']; ?>">
                                            <input type="hidden" name="post_likes" value="<?= $result['post_likes']; ?>">
                                            <button title="Like Post" type="submit" class="btn btn-success btn-sm"><i class="fa-solid fa-thumbs-up"></i></button>
                                        </form>
                                    <?php elseif ($post->is_disliked($result['post_id'])) :?>
                                        <form action="dislike.php" method="POST">
                                            <input type="hidden" name="post_id" value="<?= $result['post_id']; ?>">
                                            <input type="hidden" name="post_likes" value="<?= $result['post_likes']; ?>">
                                            <button title="Dislike Post (Undo Like)" type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-thumbs-down"></i></button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <button title="Open Comments" onclick="commentPost(this)" data-post_id="<?= $result['post_id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-comment-dots"></i></button>
                                <?php if ($_SESSION['user_id'] == $result['user_id']) : ?>
                                    <form class="delete-post" action="delete_post.php" method="POST">
                                        <input type="hidden" name="post_id" value="<?= $result['post_id']; ?>">
                                        <div title="Delete Post" class="btn btn-danger btn-sm" onclick="openOverlay(this)"><i class="fa-solid fa-trash"></i></div>
                                        <div class="overlay">
                                            <div class="overlay-message-wrapper">
                                                <p>Do you want to delete your post?</p>
                                                <div class="modal-btn-wrapper">
                                                    <div title="Close" class="btn btn-warning" onclick="closeOverlay(this)">No</div>
                                                    <button title="Delete Post" type="submit" class="btn btn-primary">Yes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php require_once 'inc/footer.php'; ?>