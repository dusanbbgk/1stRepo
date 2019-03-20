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

<?php
require_once "header.php";

if (isset($_SESSION['idKor'])) {
    ?>
    <div id="divGlavni">
        <div id="divProizvod">
            <?php
            prikaziProCeo($_GET['id']);
            ?>
        </div>
        <div id="divDesno">
            Uporedi sa:
            <?php listaPro($_GET['id']);
            ?>
            <br><br>
            Lista želja
            <div id="divZelja">
                <?php
                if (zelja($_GET['id'], $_SESSION['idKor'])) {
                    echo "<img src='img/insert.png' id='izbaci' title='Izbaci iz liste želja'>";
                } else {
                    echo "<img src='img/remove.png' id='ubaci' title='Dodaj u listu želja'>";
                }
                ?>
            </div>
            <?php
            prikaziCenu($_GET['id']); ?>
            <?php
            prikaziDodajUKorpu($_GET['id']); ?>
        </div>
        <div id="divKarakteristike">
            <br>
            <h3>Specifikacije</h3>
            <hr>
            <?php prikaziKarakteristike($_GET['id']); ?>
        </div>
        <div id="divKomentari1">
            <br>
            <h3>Postavi pitanje/komentar</h3>
            <hr>
            <form name="formaKom">
                <textarea name="tekst" id="textarea" placeholder="Sadržaj komentara" rows="5" cols="25"></textarea><br>
                <input type="button" id="dugmeKom" value="Pošalji >">
            </form>
            <hr>
        </div>
        <div id="divKomentari2">
            <?php prikaziKom($_GET['id']); ?>
        </div>
    </div>
    <?php
} else {
?>
<div id="divGlavni">
    <div id="divProizvod">
        <?php
        prikaziProCeo($_GET['id']);
        ?>
    </div>
    <div id="divSredinaDesno">
        Uporedi sa:
        <?php listaPro($_GET['id']);
        prikaziCenu($_GET['id']); ?>
    </div>
    <div id="divKarakteristike">
        <br>
        <h3>Specifikacije</h3>
        <hr>
        <?php prikaziKarakteristike($_GET['id']); ?>
    </div>
    <div id="divKomentari">
        <br>
        <h3>Pitanja i komentari</h3>
        <hr>
        <?php prikaziKom($_GET['id']); ?>
    </div>
    <?php } ?>
</div>
<?php require_once "footer.php"; ?>
<?php if (isset($_SESSION['idKor'])) { ?>
    <script src="js/jquery-3.1.1.js"></script>
    <script>

        $("#submitUporedi").click(function () {
            var id1 = <?php echo "{$_GET['id']}"; ?>;
            var id2 = document.getElementById("drugiPro").value;
            location.href = "uporediPro.php?id1=" + id1 + "&id2=" + id2;
        });

        $(document).on('click', '#izbaci', function () {
            var idPro =<?php echo $_GET['id']; ?>;
            var idKor =<?php echo $_SESSION['idKor']; ?>;
            $.get('functions/funkcije.php?izbaci=true', {
                idPro: idPro,
                idKor: idKor
            }).done(function (odgovor) {
                if (odgovor == "true") {
                    $('#divZelja').load(location.href + ' #divZelja>*', '');
                }
                else {
                    alert("Greška prilikom izbacivanja iz liste želja!");
                    return false;
                }
            });
        });

        $(document).on('click', '#ubaci', function () {
            var idPro =<?php echo $_GET['id']; ?>;
            var idKor =<?php echo $_SESSION['idKor']; ?>;
            $.get('functions/funkcije.php?ubaci=true', {
                idPro: idPro,
                idKor: idKor
            }).done(function (odgovor) {
                if (odgovor == "true") {
                    $('#divZelja').load(location.href + ' #divZelja>*', '');
                }
                else {
                    alert("Greška prilikom ubacivanja u listu želja!");
                    return false;
                }
            });
        });

        $(document).on('click', '#dugmeKom', function () {
            var idPro =<?php echo $_GET['id']; ?>;
            var idKor =<?php echo $_SESSION['idKor']; ?>;
            var tekst = document.formaKom.tekst.value;
            $.get('functions/funkcije.php?dodajKom=true', {
                idPro: idPro,
                idKor: idKor,
                tekst: tekst
            }).done(function (odgovor) {
                if (odgovor == "true") {
                    alert("Vaš komentar je poslat, ali mora biti odboren pre postavljanja!");
                    document.getElementById('textarea').value = "";
                }
                else {
                    alert("Greška prilikom postavljanja pitanja/komentara!");
                    return false;
                }
            });
        });

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

    </script>
<?php }
else { ?>
    <script src="js/jquery-3.1.1.js"></script>
    <script>

        $("#submitUporedi").click(function () {
            var id1 = <?php echo "{$_GET['id']}"; ?>;
            var id2 = document.getElementById("drugiPro").value;
            location.href = "uporediPro.php?id1=" + id1 + "&id2=" + id2;
        });

    </script>
<?php } ?>

</body>
</html>

