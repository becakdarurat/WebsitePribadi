<?php 
require_once '../../App/Core/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $database->query("SELECT * FROM user WHERE username = :username LIMIT 1");
    $database->bind(':username', $_POST['username']);
    $resultSet = $database->resultSet();
    
    if ($resultSet && password_verify($_POST['password'], $resultSet['password'])) {
        // login berhasil
        header('Location: ../HTML/Home.html');
    } else {
        // login gagal
        echo "Email/Username atau password salah";
    }
}
?>
