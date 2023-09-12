<?php
    require_once 'inc/init.php';
    require_once 'app/classes/Comment.php';
    $comment = new Comment();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $comment_id = $_POST['comment_id'];
        $comment->delete_comment($comment_id);
        redirect('index.php');
    }
?>