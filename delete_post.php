<?php
require_once 'inc/init.php';
require_once 'app/classes/Like.php';
require_once 'app/classes/Post.php';
require_once 'app/classes/Comment.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $post = new Post();
    $comment = new Comment();
    $post_id = $_POST['post_id'];
    $post->delete($post_id);
    $comment->delete($post_id);
    $_SESSION['message']['type'] = "success";
    $_SESSION['message']['text'] = "Success: Post was successfully deleted";
    redirect('index.php');
}