<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "blog_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}
?>