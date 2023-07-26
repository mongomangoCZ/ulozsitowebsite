<!DOCTYPE html>
<html>
<head>
    <title>Registrace</title>
</head>
<body>
    <h1>Registrace nového uživatele</h1>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Připojení k databázi
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "videodb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Zpracování formuláře po odeslání
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Uložení nového uživatele do databáze
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if ($conn->query($sql) === TRUE) {
                echo "Registrace proběhla úspěšně.";
            } else {
                echo "Chyba: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    }
    ?>
    <form method="post" action="register.php">
        <label for="username">Uživatelské jméno:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" value="Registrovat se">
    </form>
</body>
</html>
