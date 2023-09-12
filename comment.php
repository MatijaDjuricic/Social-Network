<?php
require_once 'inc/init.php';
require_once 'app/classes/Comment.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $comment = new Comment();
    $post_id = $_POST['post_id'];
    $content = $_POST['comment_content'];
    if (strlen($content) >= 1) {
        $comment->create($post_id, $content);
        $_SESSION['message']['type'] = "success";
        $_SESSION['message']['text'] = "Success: Comment was successfully added";
        redirect('index.php');
    } else {
        $_SESSION['message']['type'] = "danger";
        $_SESSION['message']['text'] = "Error: Comment must contain 1 or more characters";
        redirect('index.php');
    }
}