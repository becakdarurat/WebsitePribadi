<?php 
    // Koneksi ke database
    $mysqli = new mysqli("localhost", "root" , "" , "webdevelopment");

    // Periksa koneksi
    if($mysqli->connect_error){
        die("ERROR: Tidak dapat terhubung ke database. " . $mysqli->connect_error);
    };

    if(isset($_POST["login"]) && isset($_POST["password"])){
        // Mengambil data dari form login
        $login = $_POST["login"];
        $password = $_POST["password"];
    
        // Melakukan query ke tabel users untuk memeriksa kecocokan ID pengguna dan kata sandi
        $query = "SELECT * FROM user WHERE username = '$login' AND password = '$password'";
        $result = $mysqli->query($query);
    
        // Memeriksa hasil query
        if($result->num_rows == 1){
            // Jika ID pengguna dan kata sandi cocok, maka login berhasil
            echo "Login berhasil!";
            // Lakukan aksi setelah login berhasil, misalnya redirect ke halaman utama
            // header("Location: index.php");
        } else{
            // Jika ID pengguna dan kata sandi tidak cocok, maka login gagal
            echo "ID Pengguna atau Kata Sandi salah.";
        }
    } else {
        // Jika data dari form login belum dikirimkan, tampilkan pesan error
        echo "Form login belum diisi.";
    }
    
    // Menutup koneksi
    $mysqli->close();
    ?>