<?php
    require_once 'inc/init.php';
    require_once 'app/classes/Like.php';
    require_once 'app/classes/Post.php';
    $post = new Post();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $post_id = $_POST['post_id'];
        $likes = $_POST['post_likes'];
        $likes++;
        $post->create_like($post_id);
        $post->update_like($likes, $post_id);
        redirect('index.php');
    }
?>