<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php?redirect=comments.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = trim($_POST["comment"]);
    $user_id = $_SESSION["user_id"];

    if (!empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO comments (user_id, comment) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $comment);
        if ($stmt->execute()) {
            $message = "Komentář byl přidán.";
        } else {
            $message = "Chyba při přidávání komentáře.";
        }
        $stmt->close();
    }
}

// Получение всех комментариев
$comments = $conn->query("
    SELECT c.comment, u.username, c.created_at 
    FROM comments c 
    JOIN users u ON c.user_id = u.id 
    ORDER BY c.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Komentáře</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="images/kompas_logo_white.png" alt="Logo" height="45" class="me-2" />
                Cestovní Blog</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto"></ul>
                <span class="navbar-text me-3 text-white">
                    Přihlášen: <?= htmlspecialchars($_SESSION["username"]) ?>
                </span>
                <a href="auth/logout.php" class="btn btn-outline-light">Odhlásit se</a>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card p-4 shadow w-75">
            <h2 class="mb-4">Vítejte, <?= htmlspecialchars($_SESSION["username"]) ?>!</h2>

            <?php if ($message): ?>
                <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="POST" class="mb-4">
                <div class="mb-3">
                    <label for="comment" class="form-label">Váš komentář</label>
                    <textarea name="comment" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Odeslat</button>
            </form>

            <h4 class="mt-4">Vaše tipy</h4>
            <ul class="list-group">
                <?php while ($row = $comments->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($row["username"]) ?>:</strong>
                        <p><?= htmlspecialchars($row["comment"]) ?></p>
                        <small class="text-muted"><?= $row["created_at"] ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        </div>
        
        <footer class="bg-dark text-white text-center py-3 mt-5">
        &copy; 2025 Cestovní Blog. Horokhova_WA_2025
        </footer>

</body>

</html>