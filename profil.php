<?php
session_start();
require_once 'functions/database_functions.php';
if (!isset($_SESSION['korisnickoIme']))
    header('Location: index.php?error=morateBitiUlogovani');
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prodavnica mobilnih telefona - Profil korisnika</title>
    <link rel="stylesheet" href="cssmenu/style.css">
    <link href="cssmenu/tables.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
require_once "header.php";
?>
<div id="profilDiv">
    <div id="korisnikDiv">
        <?php
        korisnik($_SESSION['idKor']);
        ?>
        <form name="formaKorLoz" action="" method="post">
            <table width="350">
                <tr>
                    <td>Lozinka:</td>
                    <td><input type="password" name="lozinka"></td>
                </tr>
                <tr>
                    <td>Nova Lozinka:</td>
                    <td><input type="password" name="novaLozinka1"></td>
                </tr>
                <tr>
                    <td>Ponovite novu lozinku:</td>
                    <td><input type="password" name="novaLozinka2"></td>
                </tr>
                <tr>
                    <td colspan=2><input type="button" id="potvrdiLoz" value="Izmeni lozinku"></td>
                </tr>
            </table>
        </form>
    </div>
    <div id="slikaDiv">
        <img src="img/user_icon.png"><br>
        <img src="img/login_icon.jpg" width="250">
    </div>

    <div id="divZeljeIstorija">

        <div class="profilZelje">

            <h3>Lista želja</h3>
            <?php zeljeKor($_SESSION['idKor']); ?>
        </div>

        <div>

            <h3>Istorija kupovine</h3>
            <?php istorijaKupovine($_SESSION['idKor']); ?>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
<script src="js/jquery-3.1.1.js"></script>
<script>
    $("#potvrdi").click(function () {
        var ime = document.formaKor.ime.value;
        var prezime = document.formaKor.prezime.value;
        var mail = document.formaKor.mail.value;
        var telefon = document.formaKor.telefon.value;
        var datumRodj = document.formaKor.datumRodj.value;
        var ulicaIBr = document.formaKor.ulicaIBr.value;
        var gradIPB = document.formaKor.gradIPB.value;
        var id = <?php echo $_SESSION['idKor']; ?>;
        var odgovor = confirm("Da li ste sigurni da želite da izmenite podatke?");
        if (odgovor == true) $.post('functions/azurirajKor.php', {
            id: id,
            ime: ime,
            prezime: prezime,
            datumRodj: datumRodj,
            mail: mail,
            telefon: telefon,
            ulicaIBr: ulicaIBr,
            gradIPB: gradIPB
        }).done(function (odgovor) {
            if (odgovor == "true") {
                alert("Podaci su izmenjeni!");
                location.reload();
            }
            else {
                alert("Greška pri izmeni podataka!");
                return false;
            }
        });
    });

    $("#potvrdiLoz").click(function () {
        var lozinka = document.formaKorLoz.lozinka.value;
        var novaLozinka1 = document.formaKorLoz.novaLozinka1.value;
        var novaLozinka2 = document.formaKorLoz.novaLozinka2.value;
        var id = <?php echo $_SESSION['idKor']; ?>;
        if (novaLozinka1 != novaLozinka2) {
            alert("Niste ponovili dobro novu lozinku!");
            return false;
        }
        var odgovor = confirm("Da li ste sigurni da želite da izmenite lozinku?");
        if (odgovor == true) $.post('functions/promenaLoz.php', {
            id: id,
            lozinka: lozinka,
            novaLozinka1: novaLozinka1
        }).done(function (odgovor) {
            if (odgovor == "true") {
                alert("Lozinka je izmenjena!");
                location.reload();
            }
            else if (odgovor == 'pogresnaLoz') {
                alert("Vaša stara lozinka nije dobra!");
                return false;
            }
            else {
                alert("Greška pri izmeni lozinke!");
                return false;
            }
        });
    });

    $(".obrisiZelju").click(function () {

        var idZelje = $(this).attr("data-zelja");
        $.get('functions/funkcije.php?izbaciZelju=true', {
            idZelje: idZelje
        }).done(function (odgovor) {
            if (odgovor == 'true') {
                location.reload();
            }
            else {
                alert("Greška prilikom izbacivanja proizvoda iz liste želja!");
                return false;
            }
        });
    });
</script>

</body>
</html>