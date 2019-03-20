<?php
session_start();
require_once "functions/database_functions.php";
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prodavnica mobilnih telefona - Uporedjivanje proizvoda</title>
    <link rel="stylesheet" href="cssmenu/style.css">
</head>
<body>

<?php
require_once "header.php";
?>
<div id="divPoredjenje">
<?php
prikaziPoredjenje($_GET['id1'], $_GET['id2']);
?>
</div>
<?php require_once "footer.php"; ?>
</body>
</html>