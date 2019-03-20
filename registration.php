<?php
session_start();
require_once 'functions/database_functions.php';
if (isset($_SESSION['idKor']))
    header("Location: index.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prodavnica mobilnih telefona - Registracija</title>
    <link rel="stylesheet" href="cssmenu/style.css">
    <link href="cssmenu/tables.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php require_once "header.php"; ?>
<div id="registracijaDiv">
    <div id="registracijaFormaDiv">
<form name="regForma" action="" method="post">
    <table>
        <tr>
            <td>Ime:</td>
            <td><input type="text" name="ime" autofocus></td>
        </tr>
        <tr>
            <td>Prezime: </td>
            <td><input type="text" name="prezime"></td>
        </tr>
        <tr>
            <td>E-mail adresa: </td>
            <td><input type="email" name="mail"></td>
        </tr>
        <tr>
            <td>Korisničko ime: </td>
            <td><input type="text" name="korisnickoIme"></td>
        </tr>
        <tr>
            <td>Lozinka: </td>
            <td><input type="password" name="lozinka"></td>
        </tr>
        <tr>
            <td>Ponovljena lozinka: </td>
            <td><input type="password" name="ponLozinka"></td>
        </tr>
        <tr>
            <td>Datum rođenja: </td>
            <td><input type="date" name="datumRodj"></td>
        </tr>
        <tr>
            <td>Ulica i broj:</td>
            <td><input type="text" name="ulicaIBr"></td>
        </tr>
        <tr>
            <td>Grad i poštanski broj:</td>
            <td><input type="text" name="gradIPB"></td>
        </tr>
        <tr>
            <td>Telefon:</td>
            <td><input type="text" name="telefon"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="button" value="Registruj se" id="submit"></td>
        </tr>
    </table>
</form>
    </div>
    <div id="registracijaSlika">
        <img src="img/registration_icon1.jpg">
    </div>
</div>
<?php require_once "footer.php"; ?>
<script src="js/jquery-3.1.1.js"></script>
<script>
    $('#submit').click(function () {
        var ime = document.regForma.ime.value;
        var prezime = document.regForma.prezime.value;
        var mail = document.regForma.mail.value;
        var korisnickoIme = document.regForma.korisnickoIme.value;
        var lozinka = document.regForma.lozinka.value;
        var ponLozinka = document.regForma.ponLozinka.value;
        var ulicaIBr = document.regForma.ulicaIBr.value;
        var gradIPB = document.regForma.gradIPB.value;
        var telefon = document.regForma.telefon.value;
        var datumRodj = document.regForma.datumRodj.value;

        uzorakKorisnickoIme = /^\w{8,}$/;
        uzorakLozinka = /\w{8,}/;
        uzorakMail = /^(\w+|([a-z]+\.[a-z]+))@\w+\.([a-z]{2,4}|[a-z]{2,4}\.[a-z]{2,4})$/;
        uzorakTelefon = /^06\d{7,8}$/;

        if (korisnickoIme == "" || lozinka == "" || ime == "" || prezime == "" || mail == "" || ponLozinka == "" || ulicaIBr == "" || gradIPB == "" || telefon == "" || datumRodj == "") {
            alert("Morate popuniti sva polja!");
            return false;
        }
        if (uzorakKorisnickoIme.test(korisnickoIme) == false) {
            alert("Korisničko ime mora imati barem 8 karaktera!");
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
        $.post('functions/registracija.php', {
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
                alert('Uspešno ste se registrovali!');
                location.href = "index.php";
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
    })
</script>

</body>
</html>