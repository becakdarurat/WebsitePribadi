<?php 
    require_once '../init.php';
    class Database {

        private $dbh, //koneksi
                $stmt, //koneksi yang sudah di prepare
                $login,
                $password,
                $result; //hasilnya


        public function __construct()
        {
        $this->login = $_POST["login"];
        $this->password = $_POST["password"];

            // Koneksi ke database
            $this->dbh = new mysqli(HOST, USER , PASSWORD , TABLE);
            
             // Periksa koneksi
             if($this->dbh->connect_error){
                 die("ERROR: Tidak dapat terhubung ke database. " . $this->dbh->connect_error);
             }
        }
        public function loginUser(){

            if(isset($_POST["login"]) && isset($_POST["password"])){

                // melakukan query ke table webdevelopment dan memeriksa kecocokan
                $query ="SELECT * FROM user WHERE username = ? AND password = ?";
                $this->stmt = $this->dbh->prepare($query); //di prepare
                $this->stmt->bind_param("ss", $this->login , $this->password); //di ikat setelah di prepare
                $this->stmt->execute(); //dijalankan setelah di ikat
                $this->result = $this->stmt->get_result();// mendapatkan hasil setelah di jalankan

    if($this->result->num_rows == 1){  
        // Jika ID pengguna dan kata sandi cocok, maka login berhasil
        echo "<script>
        alert('Login berhasil');
        window.location.href = 'Home.html';
        </script>";
    } else {
        // Jika ID pengguna dan kata sandi tidak cocok, maka login gagal
        echo "<script>
        alert('Yang anda masukkan Salah mohon coba lagi');
        window.location.href = '../index.html';
        </script>";
    }
        $this->stmt->close();
        $this->dbh->close();

        }
    }
}

        // Membuat object database
    $database = new Database();

    // Memeriksa pakah data login telah dikirimkan
    if(isset($_POST["login"]) && isset($_POST["password"])){

        $login = $_POST["login"];
        $password = $_POST["password"];

        // Memanggil metode loginUser untuk memeriksa login
        $database->loginUser();
    }


    ?>