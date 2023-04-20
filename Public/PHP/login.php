<?php
require_once '../../App/Core/Database.php';

class Login extends Database{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function LoginUser($username, $password) {
        // Query untuk menambahkan user baru ke database
        $query = "SELECT * FROM user ($username, $password) VALUES (:username, :password)";

        // Bind data menggunakan method bind()
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $password);

        // Eksekusi query
        $result = $this->db->resultSet();

        // Cek apakah data berhasil ditambahkan
        if ($result() > 0) {
            // Jika berhasil, arahkan ke halaman login atau halaman lain yang sesuai
            header('Location: ../HTML/Home.html');
        } else {
            // Jika gagal, berikan pesan error
            echo "Registrasi gagal";
        }
    }
}

if(isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buat object Login
    $Login = new Login();

    // Panggil method LoginUser()
    $Login->LoginUser($username, $password);
}
?>
