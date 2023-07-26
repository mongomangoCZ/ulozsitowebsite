<?php
// Připojení k databázi (přizpůsobte přístupové údaje dle vašeho nastavení)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "videodb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['like']) || isset($_POST['dislike'])) {
    $videoId = $_POST['video_id'];
    $liked = isset($_POST['like']) ? 1 : 0;
    $disliked = isset($_POST['dislike']) ? 1 : 0;
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    // Ověření, zda uživatel již nehlasoval pro toto video
    $checkSql = "SELECT * FROM video_likes WHERE video_id = '$videoId' AND ip_address = '$ipAddress'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // Uživatel již hlasoval, nebudeme ukládat opakovaný hlas
        echo "Už jste hlasovali pro toto video.";
    } else {
        // Uložení hlasu do databáze
        $insertSql = "INSERT INTO video_likes (video_id, liked, disliked, ip_address) VALUES ('$videoId', '$liked', '$disliked', '$ipAddress')";
        if ($conn->query($insertSql) === TRUE) {
            echo "Hlas byl úspěšně uložen.";
        } else {
            echo "Chyba: " . $insertSql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
