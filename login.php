<!DOCTYPE html>
<html>
<head>
    <title>Přihlášení</title>
</head>
<body>
    <h1 style="color: #1167b1; @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap'); font-family: 'Oswald', sans-serif; position: relative; text-align: center;">Přihlášení</h1>
    <?php
    session_start();

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
            $password = $_POST['password'];

            // Získání údajů o uživateli z databáze
            $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    // Úspěšné přihlášení - nastavení session
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    header('Location: uploadform.php');
                    exit();
                } else {
                    echo "<p style='position: relative; text-align: center;'>Nesprávné uživatelské jméno nebo heslo.</p>";
                }
            } else {
                echo "Nesprávné uživatelské jméno nebo heslo.";
            }
        }

        $conn->close();
    }
    ?>
    <form method="post" action="login.php">
        <label for="username">Uživatelské jméno</label><br>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Heslo</label><br>
        <input type="password" name="password" id="password" required><br><br>
        <input type="submit" value="Přihlásit se">
        <p>nemáš učet <a href="register.php" style="color: #009dff; text-decoration: none;">registrovat se</a></p>
    </form>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap');

        body {
            background-color: #bfe6ff;
        }

        label {
            font-family: 'Oswald', sans-serif;
        }

        p {
            font-family: 'Oswald', sans-serif;
        }

        form {
            position: relative;
            text-align: center;
            border: 0px solid #1167b1;
            width: 200px;
            height: 200px;
            left: 692px;
            background-color: #8cd3ff;
            border-radius: 6px;
        }

    </style>
</body>
</html>
