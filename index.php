<!DOCTYPE html>
<html>
<head>
    <title>Videa</title>
</head>
<body>
    <h1 style="color: #1167b1; @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap'); font-family: 'Oswald', sans-serif;">Seznam videí</h1>
    <a href="uploadform.php">Nahrát nové video</a>
    <br><br>
    <form method="GET" action="index.php">
        <label for="search">Hledat video:</label>
        <input type="text" name="search" id="search" placeholder="Zadejte název videa">
        <input type="submit" value="Hledat">
    </form>
    <br>
    <?php
    // Připojení k databázi
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "videodb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Pokud byl odeslán vyhledávací formulář, získáme hledaný název videa
    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];

        // Vyhledání videí v databázi podle zadaného názvu
        $sql = "SELECT id, title, filename FROM videos WHERE title LIKE '%$searchTerm%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $videoId = $row['id'];
                $videoTitle = $row['title'];
                $videoPath = $row['filename'];

                echo "<h2>$videoTitle</h2>";
                echo "<video width='320' height='240' controls>";
                echo "<source src='$videoPath' type='video/mp4'>";
                echo "Vaše prohlížeč nepodporuje zobrazení videa.";
                echo "</video><br>";

                // Tlačítka "Like" a "Dislike" s odesláním hodnoty do databáze
                echo "<form method='post' action='like_dislike.php'>";
                echo "<input type='hidden' name='video_id' value='$videoId'>";
                echo "<button type='submit' name='like' value='1'>Like</button>";
                echo "<button type='submit' name='dislike' value='1'>Dislike</button>";
                echo "</form>";

                // Zobrazit počet like a dislike pro toto video
                $sql_likes = "SELECT SUM(liked) as likes, SUM(disliked) as dislikes FROM video_likes WHERE video_id = '$videoId'";
                $result_likes = $conn->query($sql_likes);
                $row_likes = $result_likes->fetch_assoc();
                $likes = $row_likes['likes'];
                $dislikes = $row_likes['dislikes'];
                echo "Likes: $likes, Dislikes: $dislikes<br><br>";
            }
        } else {
            echo "Žádná videa odpovídající hledanému názvu nebyla nalezena.";
        }
    } else {
        // Získání všech videí, pokud nebyl proveden žádný vyhledávací dotaz
        $sql = "SELECT id, title, filename FROM videos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $videoId = $row['id'];
                $videoTitle = $row['title'];
                $videoPath = $row['filename'];

                echo "<h2>$videoTitle</h2>";
                echo "<video width='320' height='240' controls controlsList='nodownload'>";
                echo "<source src='$videoPath' type='video/mp4'>";
                echo "Vaše prohlížeč nepodporuje zobrazení videa.";
                echo "</video><br>";

                // Tlačítka "Like" a "Dislike" s odesláním hodnoty do databáze
                echo "<form method='post' action='like_dislike.php'>";
                echo "<input type='hidden' name='video_id' value='$videoId'>";
                echo "<button type='submit' name='like' value='1'>Like</button>";
                echo "<button type='submit' name='dislike' value='1'>Dislike</button>";
                echo "</form>";

                // Zobrazit počet like a dislike pro toto video
                $sql_likes = "SELECT SUM(liked) as likes, SUM(disliked) as dislikes FROM video_likes WHERE video_id = '$videoId'";
                $result_likes = $conn->query($sql_likes);
                $row_likes = $result_likes->fetch_assoc();
                $likes = $row_likes['likes'];
                $dislikes = $row_likes['dislikes'];
                echo "Likes: $likes, Dislikes: $dislikes<br><br>";
            }
        } else {
            echo "Žádná videa k dispozici.";
        }
    }

    $conn->close();
    ?>
</body>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap');

    body {
        background-color: #bfe6ff;
    }

    a {
        font-family: 'Oswald', sans-serif;
        position: absolute;
        top: 8px;
        right: 16px;
        text-decoration: none;
        color: #009dff;
    }

    h2 {
        font-family: 'Oswald', sans-serif;
        color: #1167b1;
    }

    label {
        font-family: 'Oswald', sans-serif;
    }
</style>
</html>
