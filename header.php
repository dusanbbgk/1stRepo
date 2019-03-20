<div id="logo">
    <a href="index.php"><img src="img/logo.png"></a>
    <span style="font-size: 15px; margin-left: 600px; alignment: right; color: #888888; vertical-align: top; display: inline-block">
        <img src="img/phone_icone.png" width="15"> 011 3 555 555
        <img src="img/mobile_icon.png" width="15"> 064 1 12 13 14
    </span>
</div>
<div class="korpa" style="margin-top: 3px; margin-bottom: 3px;">
    <input type="text" id="pretragaTextarea" placeholder="Pretraga" style=" box-shadow:inset 0 0 1px 1px #888;
  background: #fff; width: 300px; height: 40px; font-size: 20px; padding-left: 3px">
    <span style="font-size: 20px; margin-left: 255px">
        <?php
        if (isset($_SESSION['korisnickoIme'])) {
            echo "<a href='logout.php'>Odjavi se ({$_SESSION['korisnickoIme']})</a> &nbsp;&nbsp;";
            echo "<a href='profil.php'>Profil</a> &nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<a href='korpa.php'>Korpa (";
            kolicinaKorpe();
            echo ")</a>  &nbsp;&nbsp;&nbsp;&nbsp;";
        } else
            echo '<a href="login.php">Uloguj se</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="registration.php">Registruj se</a>';
        ?>
    </span>
</div>

<div id="rezultat" style="position: absolute; z-index: 12; background-color: white;">

</div>

<div class="container">
    <a href="index.php">Početna</a>
    <div class="dropdown">
        <button class="dropbtn" onclick="myFunction()">Proizvodi</button>
        <div class="dropdown-content" id="myDropdown">
            <?php kategorijeInd(); ?>
        </div>
    </div>
    <a href="#">Novosti</a>
    <a href="#">O nama</a>
    <a href="kontakt.php">Kontakt</a>
    <a href="#">Podrška/FAQ</a>
    <?php if (isset($_SESSION['idKor'])) {
        if ($_SESSION['admin'])
            echo "<a href='administracija.php'>Administracija</a>";
    } ?>
</div>

<script src="js/jquery-3.1.1.js"></script>
<script>
    prikaz("");
    $("#pretragaTextarea").keyup(function () {
        prikaz($(this).val());
    });
    function prikaz(vrednost) {
        $.get("functions/search_display.php", {pretraga: vrednost})
            .done(function (data) {
                if (data != "") {
                    $('#rezultat').html(data);
                    document.getElementById('rezultat').style.border = "solid 1px lightgrey";
                }
                else {
                    $('#rezultat').html("");
                    document.getElementById('rezultat').style.border = "none";
                }
            });
    }
    /* When the user clicks on the button,
     toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (e) {
        if (!e.target.matches('.dropbtn')) {
            var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
                myDropdown.classList.remove('show');
            }
        }
    }

</script>