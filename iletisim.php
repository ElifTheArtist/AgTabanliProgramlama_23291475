<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iletisimveritabani";

// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Formdan gelen verileri al ve güvenli hale getir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
        $name = $conn->real_escape_string($_POST["name"]);
        $email = $conn->real_escape_string($_POST["email"]);
        $message = $conn->real_escape_string($_POST["message"]);

        // Boş alan kontrolü
        if (empty($name) || empty($email) || empty($message)) {
            die("Hata: Lütfen tüm alanları doldurun!");
        }

        // SQL sorgusu ile mesaj ekle
        $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Mesajınız başarıyla gönderildi!');
                window.location.href='iletisim.html';
            </script>";
        } else {
            echo "Hata: " . $conn->error;  // Hata mesajını ekrana yazdır
        }
    } else {
        die("Hata: Form verileri eksik!");
    }
}

$conn->close();
?>
