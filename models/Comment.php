<?php
class Comment {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addComment($userId, $comment) {
        $stmt = $this->conn->prepare("INSERT INTO comments (user_id, comment) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $comment);
        return $stmt->execute();
    }

    public function getAllComments() {
        $sql = "SELECT c.comment, u.username, c.created_at FROM comments c JOIN users u ON c.user_id = u.id ORDER BY c.created_at DESC";
        return $this->conn->query($sql);
    }
}
