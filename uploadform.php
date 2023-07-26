<?php
session_start();

// Kontrola, zda je uživatel přihlášený
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nahrání videa</title>
</head>
<body>
    <h1>Nahrát video</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="title">Název videa:</label>
        <input type="text" name="title" id="title" required>
        <label for="video">Video soubor:</label>
        <input type="file" name="video" id="video" accept="video/*" required>
        <input type="submit" value="Nahrát video" name="submit">
    </form>
    <br>
    <a href="logout.php" class="logout" style="color: #009dff; text-decoration: none;">Odhlásit se</a>
    <a href="index.php" class="videa-button-upload-page" style="color: #009dff; text-decoration: none;">Videa</a>
</body>
<style>
      @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap');

      body {
        background-color: #bfe6ff;
        text-align: center;
      }

      h1 {
        color: #1167b1;
        font-family: 'Oswald', sans-serif;
      }

      label {
        font-family: 'Oswald', sans-serif;
      }

      input {
        font-family: 'Oswald', sans-serif;
      }

      a.logout {
        font-family: 'Oswald', sans-serif;
        position: absolute;
        top: 8px;
        right: 16px;
      }

      a.videa-button-upload-page {
        font-family: 'Oswald', sans-serif;
        position: absolute;
        top: 8px;
        left: 16px;
      }
</style>
</html>