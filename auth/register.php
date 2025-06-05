<?php
require '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = "user";

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Tento email už je zaregistrovaný.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $role);

        if ($stmt->execute()) {
            header("Location: ../comments.php");
            exit;
        } else {
            $message = "Chyba při registraci.";
        }
        $stmt->close();
    }
    $check->close();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Registrace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        body {
            background-color: #1f1a17;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            background-color: #50321eb3;
            padding: 2rem 2.5rem;
            border-radius: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 500px;
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #cc8100;
            border-color: #cc8100;
        }

        .btn-primary:hover {
            background-color: #e89a00;
            border-color: #e89a00;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Registrace</h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Uživatelské jméno</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Heslo</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrovat se</button>
        </form>
    </div>
</body>
</html>
