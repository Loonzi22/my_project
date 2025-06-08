<?php
session_start();
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Comment.php';

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../controllers/AuthController.php?action=login&redirect=comments.php");
    exit;
}

$message = "";
$commentModel = new Comment($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = trim($_POST["comment"]);
    if (!empty($comment)) {
        if ($commentModel->addComment($_SESSION["user_id"], $comment)) {
            $message = "Komentář byl přidán.";
        } else {
            $message = "Chyba při přidávání komentáře.";
        }
    }
}

$comments = $commentModel->getAllComments();

require_once __DIR__ . '/../views/comments.php';
