<?php 
    require_once '../../Public/init.php';
    class Database {
        private $host = HOST,
                $user = USER,
                $pass = PASSWORD,
                $db_name = TABLE,
            
                $dbh; //berisi koneksi dengan PDO
        private $stmt; // berisi koneksi yang sudah di prepare dan query user maunya apa
        
            
                 
        public function __construct()
        {   
            // data source name untuk koneksi
            $dsn = 'mysql:host='. $this->host .';dbname='. $this->db_name;
    // mysql adalah Relational Database Management System. (RDBMS) Untuk mengelola basis data , Untuk menyimpan, mengelola, dan mengakses data dalam bentuk table terstruktur
            $option = [
                // ini adalah configurasi dari PDO nya
                PDO::ATTR_PERSISTENT => true, //Untuk membuat koneksi pdo kita terjaga terus
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            try {
                // kita buat object PDO
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
                // property ini merupakan koneksi database menggunakan PDO
            } catch(PDOException $e){
                die($e->getMessage());
            }
        }

        // kita buat query nya dapat dipakai secara fleksibel dapat di pakai dimanapun
        public function query($query){ 
            // jadi kita siapkan dulu querynya user mau nya apa , baik itu SELECT , WHERE sesuai pilihan user
            $this->stmt = $this->dbh->prepare($query); //koneksi yang sudah di prepare sesuai permintaan user
            // FUNGSI DARI prepare()Metode ini digunakan untuk menghindari serangan SQL Injection dan memberikan perlindungan terhadap ancaman keamanan pada aplikasi web yang berinteraksi dengan database.
        }

        public function bind($param, $value, $type = null)
        {
            // params disini adalah index , value adalah nilai yang diikat kedalam paramter dalam Pernyataan SQL akan di ikat sesuai dengan index , type adalah type data yang di ikat , dan defaultnya null 
            if( is_null($type) ){
                switch( true ){
                    case is_int($value) :
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value) :
                        $type = PDO::PARAM_NULL;
                        break;
                    default : 
                        $type = PDO::PARAM_STR;
                }
            }

            // misalkan param , value dan typenya adalah Where Id = 1 , maka akan masuk kedalam bindValue akan mengikat nilai ke dalam parameter dalam pernyataan SQL dengan tipe data yang telah ditentukan
            $this->stmt->bindValue($param, $value ,$type);

            // Kenapa kita bind begini , kenapa tidak dimasukkan langsung kedalam querynya , ya supaya aman dan dengan ini kita pasti terhindar dari sql injection , karena query di eksekusi setelah stringnya di bersihkan dulu
        }

            // Setelah kita bersihkan tinggal kita eksekusi
        public function execute()
        {
            $this->stmt->execute();
            // execute() didalam PHP adalah untuk menjalankan fungsi pernyataan SQL yang sudah disiapkan menggunakan object PDO yang di prepare()
        }

        // Lalu setelah kita eksekusi, tinggal kita tentukan kita ingin hasilnya atau datanya hanya satu atau banyak , dan kalau banyak kita fetchAll

        public function resultSet()
        {
            // kita panggil eksekusinya syntax SQL yang sudah di jalankan 
            $this->execute();
            // lalu kita return fetchAll kita buat hasilnya banyak dalam bentu array assoc
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Tapi kalau kita ingin datanya cuma satu kita pakai funtion single ini 

        public function single()
        {
            $this->execute();
            // datanya cuma satu 
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }

        // jadi ini adalah wrapper nya , ini bisa kita pakai untuk table manapun nantinya
        

    }