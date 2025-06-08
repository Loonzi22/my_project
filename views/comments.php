<?php
$message = $message ?? "";
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <title>Komentáře</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.html">Cestovní Blog</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto"></ul>
            <span class="navbar-text me-3 text-white">Přihlášen: <?= htmlspecialchars($_SESSION["username"]) ?></span>
            <a href="../controllers/LogoutController.php" class="btn btn-outline-light">Odhlásit se</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2>Vítejte, <?= htmlspecialchars($_SESSION["username"]) ?>!</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="comment" class="form-label">Váš komentář</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Odeslat</button>
    </form>

    <h4>Vaše tipy</h4>
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

<footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; 2025 Cestovní Blog. Horokhova_WA_2025
</footer>

</body>
</html>