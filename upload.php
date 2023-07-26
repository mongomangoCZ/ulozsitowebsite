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

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $videoName = $_FILES['video']['name'];
    $videoTmpName = $_FILES['video']['tmp_name'];
    $videoType = $_FILES['video']['type'];
    $videoSize = $_FILES['video']['size'];

    // Ověření, že soubor je video
    $allowedTypes = array('video/mp4', 'video/mpeg', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv');
    if (in_array($videoType, $allowedTypes)) {
        // Přesunutí souboru do umístění pro videa
        $uploadPath = 'uploads/' . $videoName;
        if (move_uploaded_file($videoTmpName, $uploadPath)) {
            // Uložení názvu videa a cesty do databáze
            $sql = "INSERT INTO videos (title, filename) VALUES ('$title', '$uploadPath')";
            if ($conn->query($sql) === TRUE) {
                // Přesměrování na stránku s videi po úspěšném nahrání do databáze
                header('Location: index.php');
            } else {
                echo "Chyba: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Nahrávání souboru selhalo.";
        }
    } else {
        echo "Soubor není podporovaným video formátem.";
    }
}

$conn->close();
?>
