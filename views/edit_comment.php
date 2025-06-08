<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Upravit komentář</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Upravit komentář</h2>
    <?php if ($message): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="comment" class="form-label">Komentář</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" required><?= htmlspecialchars($comment["comment"]) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Uložit změny</button>
        <a href="commentsController.php" class="btn btn-secondary">Zpět</a>
    </form>
</div>
</body>
</html>
