<?php
session_start();
require_once "functions/database_functions.php";
if (isset($_SESSION['idKor']))
    header("Location: index.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prodavnica mobilnih telefona - Login</title>
    <link rel="stylesheet" href="cssmenu/style.css">
    <link href="cssmenu/tables.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once "header.php"; ?>
<div id="loginDiv">
    <div id="loginFormaDiv">
    <form name="loginForma" action="" method="post">
        <table>
            <tr>
                <td>Korisničko ime:</td>
                <td><input type="text" name="korisnickoIme" autofocus></td>
            </tr>
            <tr>
                <td>Lozinka:</td>
                <td><input type="password" name="lozinka" id="TextBoxId"></td>
            </tr>
            <tr>
                <td colspan=2><input type="button" value="Prijavi se" id="submit" name="btnChangeAmountReceived"></td>
            </tr>
        </table>
    </form>
    </div>
    <div id="loginSlika">
        <img src="img/login_icon.jpg">
    </div>
</div>
<?php require_once "footer.php"; ?>
<script src="js/jquery-3.1.1.js"></script>
<script>
    $(document).ready(function () {
        $('#TextBoxId').keypress(function (e) {
            if (e.keyCode == 13)
                $('#submit').click();
        });
    });

    $('#submit').click(function () {
        var korisnickoIme = document.loginForma.korisnickoIme.value;
        var lozinka = document.loginForma.lozinka.value;
        if (korisnickoIme == "" || lozinka == ""/* || (korisnickoIme == "" && lozinka == "")*/) {
            alert("Niste uneli korisničko ime i/ili lozinku!");
            return false;
        }
        $.post('functions/logovanje.php', {
            korisnickoIme: korisnickoIme, lozinka: lozinka
        }).done(function (odgovor) {
            if (odgovor == 'true') {
                location.href = "index.php";
            }
            else if (odgovor == 'admin') {
                location.href = "administracija.php";
            }
            else {
                alert('Podaci nisi dobri!');
                return false;
            }
        });
    })
</script>

</body>
</html>