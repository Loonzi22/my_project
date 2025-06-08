<?php
session_start();
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Comment.php';

$db = new Database();
$conn = $db->getConnection();
$commentModel = new Comment($conn);

// kontrola user je v loginu
if (!isset($_SESSION["user_id"])) {
    header("Location: AuthController.php?action=login");
    exit;
}

$comment_id = $_GET['id'] ?? null;
$message = "";

if (!$comment_id) {
    header("Location: commentsController.php");
    exit;
}

$comment = $commentModel->getCommentById($comment_id);

// kontrola = patri kommentar konkretnimu useru
if (!$comment || $comment['user_id'] != $_SESSION['user_id']) {
    $message = "Nemáte oprávnění upravovat tento komentář.";
    header("Location: commentsController.php?message=" . urlencode($message));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $updated_comment = trim($_POST["comment"]);
    if (!empty($updated_comment)) {
        if ($commentModel->updateComment($comment_id, $updated_comment)) {
            header("Location: commentsController.php?message=" . urlencode("Komentář byl upraven."));
            exit;
        } else {
            $message = "Chyba při úpravě komentáře.";
        }
    }
}

// forma upravy
require_once __DIR__ . '/../views/edit_comment.php';
