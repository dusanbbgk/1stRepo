<?php
session_start();
require_once 'functions/database_functions.php';
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
<br>
<form name="formaSort" action="" method="post">
    Poređaj po: <select name="sortiraj" id="sortiraj">
        <option value="" selected>Izaberi</option>
        <option value="rastuce">Ceni rastuće</option>
        <option value="opadajuce">Ceni opadajuće</option>
        <option value="naziv">Nazivu A-Z</option>
    </select>
    <input type="submit" id="primeniSort" value="Primeni">
</form>
<div id="divSort">
    <?php
    if (!isset($_POST['sortiraj'])) {

        prikaziPro($_GET['idKat'], "rastuce");
    } else {
        $sortiraj = $_POST['sortiraj'];
        prikaziPro($_GET['idKat'], $sortiraj);
    }
    ?>
</div>
<?php require_once "footer.php"; ?>
<?php if (isset($_SESSION['idKor'])) { ?>
    <script src="js/jquery-3.1.1.js"></script>
    <script>
        $(document).on('click', '.dodajUKorpu', function () {
            var idPro = $(this).attr("data-korpa");
            var idKor = <?php echo $_SESSION['idKor']; ?>;
            $.get("functions/funkcije.php?dodajUKorpu=true", {
                idPro: idPro,
                idKor: idKor
            }).done(function (odgovor) {
                if (odgovor = 'true') {
                    $('.korpa').load(location.href + ' .korpa>*', '');
                    /*alert('Proizvod je dodat u korpu!');
                    location.reload();*/
                }
                else {
                    alert('Greška pri dodavanju proizvoda u korpu!');
                    return false;
                }
            });
        });
        $(document).on('click', '#primeniSort', function () {
            $('#divSort').load(location.href + ' #divSort>*', '');
        });
    </script>
<?php } else { ?>
    <script src="js/jquery-3.1.1.js"></script>
    <script>
        $(document).on('click', '#primeniSort', function () {
            $('#divSort').load(location.href + ' #divSort>*', '');
        });
    </script>
<?php } ?>

</body>
</html>

