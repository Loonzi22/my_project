<?php
session_start();
require '../models/Database.php';

$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'login';
}

$message = "";

if ($action === 'login') {
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

                header("Location: ../controllers/commentsController.php");
                exit;
            } else {
                $message = "Nesprávné heslo.";
            }
        } else {
            $message = "Uživatel s tímto emailem nebyl nalezen.";
        }

        $stmt->close();
    }

    require '../views/login.php';

} elseif ($action === 'register') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $password_confirm = $_POST["password_confirm"];

        if ($password !== $password_confirm) {
            $message = "Hesla se neshodují.";
        } else {
            // kontrola emailu
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $message = "Uživatel s tímto emailem již existuje.";
            } else {
                $stmt->close();
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                if ($stmt->execute()) {
                    //  uspesna regestrace -- stranka login
                    header("Location: ../controllers/AuthController.php?action=login");
                    exit;
                } else {
                    $message = "Registrace se nepodařila.";
                }
            }
            $stmt->close();
        }
    }

    require '../views/register.php';

} else {
    exit;
}
?>