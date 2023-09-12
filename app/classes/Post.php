<?php
class Post extends Like {
    protected $conn;
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    public function create($user_id, $content) {
        $likes = 0;
        $sql = "INSERT INTO posts (user_id, content, likes) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('isi', $user_id, $content, $likes);
        $stmt->execute();
    }
    public function read() {
        $sql = "SELECT posts.*, users.user_id, users.username AS user_username, users.profile_image AS user_profile_image,
                posts.post_id AS post_post_id, posts.content AS post_content, posts.likes AS post_likes
                FROM `posts` LEFT JOIN `users` ON users.user_id = posts.user_id ORDER BY posts.created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }
    public function delete($post_id) {
        $sql = "DELETE FROM posts WHERE post_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $this->delete_likes($post_id);
    }
}