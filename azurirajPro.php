<?php
session_start();
require_once("functions/database_functions.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prodavnica mobilnih telefona - Proizvodi</title>
    <link rel="stylesheet" href="cssmenu/style.css">
</head>
<body>
<?php require_once "header.php"; ?>
<?php
formaPro($_GET['id']);
?>
<?php require_once "footer.php"; ?>
<script src="js/jquery-3.1.1.js"></script>
<script>
    $("#potvrdi").click(function () {
        var model = document.azurirajProForma.model.value;
        var cena = document.azurirajProForma.cena.value;
        var karakteristike = document.azurirajProForma.karakteristike.value;
        var idPro =<?php echo $_GET['id']; ?>;
        var odgovor = confirm("Da li ste sigurni da želite da ažurirate proizvod?");
        if (odgovor == true) $.get('functions/funkcije.php?azurirajPro=true', {
            idPro: idPro,
            model: model,
            cena: cena,
            karakteristike: karakteristike
        })
            .done(function (odgovor) {
                if (odgovor == "true") {
                    alert("Podaci proizvoda su ažurirani!");
                    window.location = "administracija.php";
                }
                else alert("Greška pri ažuriranju proizvoda!");
            });
    });
</script>

</body>
</html>