<?php
session_start();
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Comment.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: AuthController.php?action=login");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: commentsController.php");
    exit;
}

$commentId = intval($_GET["id"]);
$userId = $_SESSION["user_id"];

$db = new Database();
$conn = $db->getConnection();

$commentModel = new Comment($conn);

// kontrola = patri ten komentar useru nebo ne
if ($commentModel->isUserCommentOwner($commentId, $userId)) {
    $commentModel->deleteComment($commentId);
}

header("Location: commentsController.php");
exit;
