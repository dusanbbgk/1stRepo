<?php
session_start();
require_once "functions/database_functions.php";
if (isset($_SESSION['korisnickoIme'])) {
    if ($_SESSION['admin'] == '0')
        header('Location: index.php?error=nelegalanPristup1');
} else header('Location: index.php?error=nelegalanPristup2');
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prodavnica mobilnih telefona - Administracija</title>
    <link rel="stylesheet" href="cssmenu/style.css">
</head>
<body>
<?php require_once "header.php"; ?>

<h3>Kategorije</h3>
<div class="div1">
    <?php
    kategorije();
    ?>
</div>
<hr size="2">
<h3>Dodavanje nove kategorije</h3>
<form name="dodajKatForma">
    Naziv nove kategorije: <input type="text" name="nazivKat">
    <input type="button" value="Dodaj kategoriju" name="submit" id="submitKat">
</form>
<hr size="2">
<h3>Proizvodi</h3>
<div class="div1">
    <?php
    proizvodi();
    ?>
</div>
<hr size="2">
<h3>Dodavanje novog proizvoda</h3>
<form name="dodajProForma">
    Kategorija: <select name="idKat">
        <?php
        $db = konekcija();
        $rezultat = mysqli_query($db, "SELECT * FROM kategorije");
        if (mysqli_num_rows($rezultat) > 0)
            while ($red = mysqli_fetch_assoc($rezultat)) {
                echo "<option value='{$red['id']}'>{$red['naziv']}</option>";
            }
        ?>
    </select><br>
    Model: <input type="text" name="model"><br>
    Specifikacije: <textarea name="karakteristike" rows="6" cols="35"></textarea><br>
    Cena: <input type="text" name="cena"><br>
    Putanja do slika: <input type="text" name="slike"> (kategorija/model)<br>
    <input type="button" value="Dodaj proizvod" id="submitPro">
</form>
<hr size="2">
<h3>Pristigli komentari</h3>
<div class="div1">
    <?php prikaziKomAdmin(); ?>
</div>
<hr size="2">
<h3>Pristigle narudzbine</h3>
<div class="div1">
    <?php prikaziNarudzbine(); ?>
</div>
<hr size="2">
<h3>Statistika prodatih proizvoda</h3>
Od: <input type="date" id="datum1">
Do: <input type="date" id="datum2">
<input type="button" value="Prikazi" id="submitDatum">
<div id="divStatistika" class="div1">

</div>
<hr size="2">
<h3>Statistika izbora dostave</h3>
Od: <input type="date" id="datum11">
Do: <input type="date" id="datum22">
<input type="button" value="Prikazi" id="submitDatum1">
<div id="divStatistika1" class="div1">

</div>
<hr size="2">
<h3>Dodavanje novog admina</h3>
<form name="regFormaAdmin" action="" method="post">
    <label>Ime:<input type="text" name="ime"></label><br>
    <label>Prezime:<input type="text" name="prezime"></label><br>
    <label>E-mail adresa:<input type="email" name="mail"></label><br>
    <label>Korisničko ime:<input type="text" name="korisnickoIme"></label><br>
    <label>Lozinka:<input type="password" name="lozinka"></label><br>
    <label>Ponovljena lozinka:<input type="password" name="ponLozinka"></label><br>
    <label>Datum rođenja:<input type="date" name="datumRodj"></label><br>
    <label>Ulica i broj:<input type="text" name="ulicaIBr"></label><br>
    <label>Grad i poštanski broj:<input type="text" name="gradIPB"></label><br>
    <label>Telefon:<input type="text" name="telefon"></label><br><br>
    <label>
        <input type="button" value="Dodaj admina" id="submitNewAdmin">
    </label>
</form>
<?php require_once "footer.php"; ?>
<script src="js/jquery-3.1.1.js"></script>
<script>
    $(".obrisiKat").click(function () {
        var idKat = $(this).attr("data-kat");
        var potvrda = confirm("Da li ste sigurni da želite da obrišete kategoriju?");
        if (potvrda == true)
            $.get("functions/funkcije.php?obrisiKat=true", {
                idKat: idKat
            }).done(function (odgovor) {
                if (odgovor == "true") {
                    alert("Kategorija je obrisana!");
                    location.reload();
                }
                else alert("Greška pri brisanju kategorije!");
            });
        return false;
    });

    $("#submitKat").click(function () {
        var nazivKat = document.dodajKatForma.nazivKat.value;
        if (nazivKat == "") {
            alert("Niste uneli naziv kategorije!");
            return false;
        }
        $.get("functions/funkcije.php?dodajKat=true", {
            nazivKat: nazivKat
        }).done(function (odgovor) {
            if (odgovor == 'true') {
                alert('Kategorija pod nazivom "' + nazivKat + '" je dodata!');
                location.reload();
            }
            else if (odgovor == "zauzeto") {
                alert("Kategorija pod tim nazivom već postoji u bazi!");
                location.reload();
            }
            else {
                alert("Greška pri dodavanju nove kategorije!");
                return false;
            }
        });
    });

    $(".obrisiPro").click(function () {
        var idPro = $(this).attr("data-pro");
        var potvrda = confirm("Da li ste sigurni da želite da obrišete proizvod?");
        if (potvrda == true)
            $.get("functions/funkcije.php?obrisiPro=true", {
                idPro: idPro
            }).done(function (odgovor) {
                if (odgovor == "true") {
                    alert("Proizvod je obrisan!");
                    location.reload();
                }
                else alert("Greška pri brisanju proizvoda!");
            });
        return false;
    });

    $("#submitPro").click(function () {
        var idKat = document.dodajProForma.idKat.value;
        var model = document.dodajProForma.model.value;
        var karakteristike = document.dodajProForma.karakteristike.value;
        var cena = document.dodajProForma.cena.value;
        var slike = document.dodajProForma.slike.value;
        if (model == "") {
            alert("Niste uneli model proizvoda!");
            return false;
        }
        $.get("functions/funkcije.php?dodajPro=true", {
            idKat: idKat,
            model: model,
            karakteristike: karakteristike,
            cena: cena,
            slike: slike
        }).done(function (odgovor) {
            if (odgovor == 'true') {
                alert("Proizvod '" + model + "' je dodat!");
                location.reload();
            }
            else if (odgovor == "zauzeto") {
                alert("Model proizvoda već postoji u bazi!");
                location.reload();
            }
            else {
                alert("Greška pri dodavanju novog proizvoda!");
                return false;
            }
        });
    });

    $('.dodajKom').click(function () {
        var idKom = $(this).attr("data-dodajKom");
        $.get("functions/funkcije.php?dodajKomAdm=true", {
            idKom: idKom
        }).done(function (odgovor) {
            if (odgovor = "true") {
                alert("Komentar je odobren!");
                location.reload();
            }
            else {
                alert("Greška pri odobravanju komentara!");
                return false;
            }
        });
    });

    $('.obrisiKom').click(function () {
        var idKom = $(this).attr("data-obrisiKom");
        var potvrda = confirm("Da li ste sigurni da želite da obrišete komentar?");
        if (potvrda == true) {
            $.get("functions/funkcije.php?obrisiKomAdm=true", {
                idKom: idKom
            }).done(function (odgovor) {
                if (odgovor = "true") {
                    alert("Komentar je obrisan!");
                    location.reload();
                }
                else {
                    alert("Greška pri brisanju komentara!");
                    return false;
                }
            });
        }
        else return false;
    });

    $("#posalji").click(function () {

        var idNarudzbenice = $(this).attr("data-idNarudzbenice");
        $.get("functions/funkcije.php?posalji=true", {
            idNarudzbenice: idNarudzbenice
        }).done(function (odgovor) {
            if (odgovor == "true") {
                alert("Naručeni proizvod je poslat!");
                location.reload();
            }
            else {
                alert("Greška pri slanju!");
                return false;
            }
        });
    });

    $("#submitDatum").click(function () {
        var datum1 = document.getElementById("datum1").value;
        var datum2 = document.getElementById("datum2").value;
        if (datum2 < datum1) {
            alert("Postavljeni datumi nisu dobri!");
            return false;
        }
        $.get("functions/funkcije.php?statistika=true", {
            datum1: datum1,
            datum2: datum2
        }).done(function (data) {
            $('#divStatistika').html(data);
        });
    });

    $("#submitDatum1").click(function () {
        var datum11 = document.getElementById("datum11").value;
        var datum22 = document.getElementById("datum22").value;
        if (datum22 < datum11) {
            alert("Postavljeni datumi nisu dobri!");
            return false;
        }
        $.get("functions/funkcije.php?statistika1=true", {
            datum11: datum11,
            datum22: datum22
        }).done(function (data) {
            $('#divStatistika1').html(data);
        });
    });

    $('#submitNewAdmin').click(function () {
        var ime = document.regFormaAdmin.ime.value;
        var prezime = document.regFormaAdmin.prezime.value;
        var mail = document.regFormaAdmin.mail.value;
        var korisnickoIme = document.regFormaAdmin.korisnickoIme.value;
        var lozinka = document.regFormaAdmin.lozinka.value;
        var ponLozinka = document.regFormaAdmin.ponLozinka.value;
        var ulicaIBr = document.regFormaAdmin.ulicaIBr.value;
        var gradIPB = document.regFormaAdmin.gradIPB.value;
        var telefon = document.regFormaAdmin.telefon.value;
        var datumRodj = document.regFormaAdmin.datumRodj.value;

        //uzorakKorisnickoIme = /^\w{8,}$/;
        uzorakLozinka = /\w{8,}/;
        uzorakMail = /^(\w+|([a-z]+\.[a-z]+))@\w+\.([a-z]{2,4}|[a-z]{2,4}\.[a-z]{2,4})$/;
        uzorakTelefon = /^06\d{7,8}$/;

        if (korisnickoIme == "" || lozinka == "" || ime == "" || prezime == "" || mail == ""
            || ponLozinka == "" || ulicaIBr == "" || gradIPB == "" || telefon == "" || datumRodj == "") {
            alert("Morate popuniti sva polja!");
            return false;
        }
        if (uzorakLozinka.test(lozinka) == false) {
            alert("Greška!!! Lozinka nema minimalno 8 karaktera!");
            return false;

        }
        if (lozinka != ponLozinka) {
            alert("Greška! Niste dobro ponovili lozinku, pokušajte ponovo.");
            return false;
        }
        if (uzorakMail.test(mail) == false) {
            alert("Greška!!! Niste dobro uneli email!");
            return false;
        }
        if (uzorakTelefon.test(telefon) == false) {
            alert("Greška!!! Niste dobro uneli broj mobilnog telefona!");
            return false;
        }
        $.post('functions/dodavanjeAdmina.php', {
            ime: ime,
            prezime: prezime,
            korisnickoIme: korisnickoIme,
            lozinka: lozinka,
            mail: mail,
            ulicaIBr: ulicaIBr,
            gradIPB: gradIPB,
            telefon: telefon,
            datumRodj: datumRodj
        }).done(function (odgovor) {
            if (odgovor == 'true') {
                alert('Uspešno dodat novi admin!');
                location.href = "administracija.php";
            }
            else if (odgovor == 'zauzeto') {
                alert('Korisničko ime je zauzeto!');
                return false;
            }
            else {
                alert('Došlo je do greške!');
                return false;
            }
        });
    });

</script>
</body>
</html>
