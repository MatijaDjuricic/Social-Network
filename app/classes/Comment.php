<?php
class Comment {
    protected $conn;
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    public function create($post_id, $content) {
        $sql = "INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iis', $_SESSION['user_id'], $post_id, $content);
        $stmt->execute();
    }
    public function read() {
        $sql = "SELECT comments.comment_id, comments.user_id AS comment_user_id, comments.post_id AS comments_post_id, comments.content AS comment_content,
                comments.created_at AS comment_created_at, users.username AS comment_username, users.profile_image AS user_profile_image
                FROM `comments` LEFT JOIN `users` ON comments.user_id = users.user_id ORDER BY comments.created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }
    public function delete($post_id) {
        $sql = "DELETE FROM comments WHERE post_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
    }
    public function delete_comment($comment_id) {
        $sql = "DELETE FROM comments WHERE comment_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $comment_id);
        $stmt->execute();
    }
    public function get_number($post_id) {
        $sql = "SELECT * FROM comments WHERE post_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        if ($num != 0) {
            return $num;
        }
        return 0;
    }
}