<?php
$conn = new mysqli("localhost", "root", "", "iletisimveritabani");

// Hata kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
} else {
    echo "Veritabanı bağlantısı başarılı!";
}

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

// Mesajları veritabanından çek
$sql = "SELECT name, email, message FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);

function maskEmail($email) {
    $parts = explode("@", $email);
    return substr($parts[0], 0, 1) . str_repeat("*", strlen($parts[0]) - 1) . "@" . $parts[1];
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesaj Listesi</title>
    <link rel="stylesheet" href="liste.css">
</head>
<body>
    <div class="container">
        <h1>İletişim Formu Mesajları</h1>
        <table>
            <thead>
                <tr>
                    <th>İsim</th>
                    <th>E-posta</th>
                    <th>Mesaj</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . maskEmail($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Henüz mesaj yok.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
