<?php
session_start();
require '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            // Переход на исходную страницу, если указана
            $redirect = $_GET['redirect'] ?? '../index.html';
            header("Location: ../comments.php");
            exit;
        } else {
            $message = "Nesprávné heslo.";
        }
    } else {
        $message = "Uživatel s tímto emailem nebyl nalezen.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <title>Přihlášení</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../style/style.css" />
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
            padding: 2.5rem;
            border-radius: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            color: white;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        label {
            color: #f0e7dd;
        }

        .btn-primary {
            background-color: #cc8100;
            border-color: #cc8100;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #e89a00;
            border-color: #e89a00;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Přihlášení</h2>
        <?php if ($message): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Heslo</label>
                <input type="password" name="password" class="form-control" required />
            </div>

            <button type="submit" class="btn btn-primary">Přihlásit se</button>
        </form>
    </div>
</body>
</html>
