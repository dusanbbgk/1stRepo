<?php
session_start();
require_once 'functions/database_functions.php';
if (!isset($_SESSION['idKor']))
    header('Location: index.php?error=nelegalanPristup1');

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prodavnica mobilnih telefona - Korpa</title>
    <link rel="stylesheet" href="cssmenu/style.css">
    <link rel="stylesheet" href="cssmenu/tables.css">
</head>
<body>

<?php require_once "header.php"; ?>
<div id="divDostava">
    <div>
    <?php
    prikaziKorpu(dohvatiIdNarudzbenice());
    if (!praznaKorpa(dohvatiIdNarudzbenice())) {
        ?>
        <br>Dostava: <select id="dostava" onchange="showDiv(this)" onload="showDiv(this)">
            <option value="1">Isti dan*</option>
            <option value="2" selected>Dva radna dana</option>
            <option value="3">Rezervišite za određeni datum</option>
        </select>
        <br>
        <div id="hidden_div" style="display: none; min-width: 400px">Odaberite datum: <input type="date" id="rezervisano"></div>
        <div id="hidden_div1" style="display: none; min-width: 400px">*Dostava istog dana se naplaćuje 250 dinara na ukupnu cenu</div>
        <br><input type="submit" value="Završi kupovinu" id="potvrdi"><br>

    </div>
    <div>
        <?php licniPodaci($_SESSION['idKor']); ?>
    </div>
    <?php
    }
    ?>
</div>
<?php require_once "footer.php"; ?>
<script src="js/jquery-3.1.1.js"></script>
<script>
    $(document).on('click', '.izbaziIzKorpe', function () {
        var idPro = $(this).attr("data-decPro");
        $.get("functions/funkcije.php?kolicina=true", {
            idPro: idPro
        }).done(function (odgovor) {
            if (odgovor == "true") {
                location.reload();
            }
            else {
                return false;
            }
        });
    });
    $(document).on('click', '#potvrdi', function () {
        var today_3Days = new Date();
        var dd = today_3Days.getDate() + 3;
        var mm = today_3Days.getMonth() + 1;
        var yyyy = today_3Days.getFullYear();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }

        today_3Days = yyyy + '-' + mm + '-' + dd;
        var ukupnaCena = document.getElementById("ukupnaCena").value;
        var idNarudzbenice = <?php echo dohvatiIdNarudzbenice(); ?>;
        var datumDostave = document.getElementById("dostava").value;
        if (datumDostave != "3") var rezervisano = "0";
        else {
            var rezervisano = document.getElementById("rezervisano").value;
            if (rezervisano < today_3Days) {
                alert("Datum rezervacije mora biti minimum 3 dana od današnjeg datuma!");
                return false;
            }
        }
        $.get("functions/funkcije.php?zavrsi=true", {
            idNarudzbenice: idNarudzbenice,
            ukupnaCena: ukupnaCena,
            datumDostave: datumDostave,
            rezervisano: rezervisano
        }).done(function (odgovor) {
            if (odgovor == "true") {
                alert("Uspešno obavljena kupovina!");
                location.href = "index.php";
            }
            else {
                alert("Greška pri kupovini!");
                return false;
            }
        });
    });

    function showDiv(elem) {
        if (elem.value == 3) {
            document.getElementById('hidden_div').style.display = "block";
            document.getElementById('hidden_div1').style.display = "none";
        }
        else if (elem.value == 2) {
            document.getElementById('hidden_div').style.display = "none";
            document.getElementById('hidden_div1').style.display = "none";
        }
        else {
            document.getElementById('hidden_div').style.display = "none";
            document.getElementById('hidden_div1').style.display = "block";
        }
    }

    $("#izmeni").click(function () {
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

</script>

</body>
</html>

