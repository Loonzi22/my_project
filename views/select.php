<?php
$redirect = $_GET['redirect'] ?? '/wa/my_project/controllers/commentsController.php';
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Přihlášení nebo Registrace</title>
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
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h2 {
            color: white;
            margin-bottom: 1rem;
        }

        p {
            color: #f0e7dd;
            margin-bottom: 2rem;
        }

        .btn-success {
            background-color: #007b5e;
            border-color: #007b5e;
        }

        .btn-success:hover {
            background-color: #00a375;
            border-color: #00a375;
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
        <h2>Vítejte!</h2>
        <p>Jste nový uživatel nebo už máte účet?</p>

        <a href="../controllers/AuthController.php?action=register" class="btn btn-success m-2">Registrovat se</a>
        <a href="../controllers/AuthController.php?action=login" class="btn btn-primary m-2">Přihlásit se</a>

    </div>
</body>

</html>