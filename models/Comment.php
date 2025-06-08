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
        $stmt = $this->conn->prepare("SELECT comments.id, comments.user_id, users.username, comments.comment, comments.created_at FROM comments JOIN users ON comments.user_id = users.id ORDER BY comments.created_at DESC");
        $stmt->execute();
        return $stmt->get_result();
    }
    public function isUserCommentOwner($commentId, $userId) {
        $stmt = $this->conn->prepare("SELECT id FROM comments WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $commentId, $userId);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows === 1;
    }
    
    public function deleteComment($commentId) {
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->bind_param("i", $commentId);
        return $stmt->execute();
    }

    public function getCommentById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function updateComment($id, $newComment) {
        $stmt = $this->conn->prepare("UPDATE comments SET comment = ? WHERE id = ?");
        $stmt->bind_param("si", $newComment, $id);
        return $stmt->execute();
    }
    
    
}
