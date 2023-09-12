<?php
class Like {
    protected $conn;
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    public function create_like($post_id) {
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $_SESSION['user_id'], $post_id);
        $stmt->execute();
    }
    public function update_like($likes, $post_id) {
        $sql = "UPDATE posts SET likes = ? WHERE post_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $likes, $post_id);
        $stmt->execute();
    }
    public function delete_likes($post_id) {
        $sql = "DELETE FROM likes WHERE post_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
    }
    public function is_liked($post_id) {
        $sql = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $post_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
                return false;
            }
        return true;
    }
    public function is_disliked($post_id) {
        $sql = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $post_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
                return true;
            }
        return false;
    }
}