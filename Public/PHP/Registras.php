<?php 
    require_once '../init.php';
    class Register {
        private $table = "user",
                $db,
                $username,
                $password,
                $passwordAcak,
                $sql; //isinya koneksi
        public function __construct()
        {
            $this->username = $_POST["username"];
            $this->password = $_POST["password"];

       // Enkripsi kata sandi menggunakan fungsi password_hash() PHP
        $this->passwordAcak = password_hash($this->password, PASSWORD_DEFAULT);     

        $this->sql = "INSERT INTO $this->table (username , password) VALUES ('$this->username', '$this->passwordAcak')";


            $this->db = new Database();
            $this->db->$this->result = $this->db->query($this->sql);
        }
        public function Registrasi(){
            if(isset($_POST["username"]) && isset($_POST["password"])){
                if($this->db->$this->result->query($this->sql) === TRUE){
                    echo "alert('Register berhasil')";
                } else {
                    echo "Error: " . $this->sql;
                }
                $this->db->$this->stmt->close();
                $this->db->$this->dbh->close();
            }
        }
    }

    $Registrasi = new Register();

    if(isset($_POST["username"]) && isset($_POST["password"])){
        $Registrasi->Registrasi();
    }



    
?>