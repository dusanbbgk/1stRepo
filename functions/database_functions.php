<?php

function konekcija()
{
    @$db = mysqli_connect("localhost", "root", "", "webshop");
    if (!$db) {
        echo "Greška pri konekciji: " . mysqli_connect_error();
        exit(1);
    }
    mysqli_set_charset($db, "utf8");
    return $db;
}

function validacija($korisnickoIme, $lozinka)
{
    $db = konekcija();
    $korisnickoIme = addslashes(strip_tags($korisnickoIme));
    $lozinka = addslashes(strip_tags($lozinka));
    $datumDostave1 = Date("Y-m-d");
    $rezultat = mysqli_query($db, "SELECT * FROM korisnici WHERE korisnickoIme = '{$korisnickoIme}' AND lozinka = '{$lozinka}'");
    if (mysqli_num_rows($rezultat) > 0) {
        $red = mysqli_fetch_assoc($rezultat);
        $_SESSION['korisnickoIme'] = $red['korisnickoIme'];
        $_SESSION['idKor'] = $red['id'];
        $_SESSION['admin'] = $red['admin'];
        $proveriNarudzbenicu = mysqli_query($db, "SELECT * FROM narudzbenice WHERE idKor = '{$red['id']}' AND zavrseno = '0' AND poslato = '0'");
        if (mysqli_num_rows($proveriNarudzbenicu)) {
            $red1 = mysqli_fetch_assoc($proveriNarudzbenicu);
            $updateDatum = mysqli_query($db, "UPDATE narudzbenice SET datum = now() WHERE id = '{$red1['id']}')");
            $_SESSION['narudzbenica'] = 1;
        } else {
            $insertNarudzbenica = mysqli_query($db, "INSERT INTO narudzbenice VALUES ('', '{$red['id']}', now(), '0', '0', '0', '0')");
            $_SESSION['narudzbenica'] = 1;
        }
        return true;
    } else return false;
}

function dohvatiIdNarudzbenice()
{
    $db = konekcija();
    $idNarudzbenice = '';
    $rezultat = mysqli_query($db, "SELECT * FROM narudzbenice WHERE idKor = '{$_SESSION['idKor']}' AND zavrseno = '0'");
    if (mysqli_num_rows($rezultat) > 0) {
        $red = mysqli_fetch_assoc($rezultat);
        $idNarudzbenice = $red['id'];
        return $idNarudzbenice;
    } else return 0;
}

function registracija($ime, $prezime, $mail, $korisnickoIme, $lozinka, $ulicaIBr, $gradIPB, $telefon, $datumRodj)
{
    $db = konekcija();
    $korisnickoIme = addslashes(strip_tags($korisnickoIme));
    $lozinka = addslashes(strip_tags($lozinka));
    $provera = mysqli_query($db, "SELECT * FROM korisnici WHERE korisnickoIme = '{$korisnickoIme}'");
    if (mysqli_num_rows($provera) > 0) {
        echo 'zauzeto';
    }
    $rezultat = mysqli_query($db, "INSERT INTO korisnici VALUES ('', '{$ime}', '{$prezime}', '{$korisnickoIme}', '{$lozinka}', '{$datumRodj}', '{$ulicaIBr}', '{$gradIPB}', '{$telefon}', '{$mail}', 0)");
    if ($rezultat)
        echo 'true';
    else echo 'false';
}

function registracijaAdmina($ime, $prezime, $mail, $korisnickoIme, $lozinka, $ulicaIBr, $gradIPB, $telefon, $datumRodj)
{
    $db = konekcija();
    $korisnickoIme = addslashes(strip_tags($korisnickoIme));
    $lozinka = addslashes(strip_tags($lozinka));
    $provera = mysqli_query($db, "SELECT * FROM korisnici WHERE korisnickoIme = '{$korisnickoIme}'");
    if (mysqli_num_rows($provera) > 0) {
        echo 'zauzeto';
    }
    $rezultat = mysqli_query($db, "INSERT INTO korisnici VALUES ('', '{$ime}', '{$prezime}', '{$korisnickoIme}', '{$lozinka}', '{$datumRodj}', '{$ulicaIBr}', '{$gradIPB}', '{$telefon}', '{$mail}', 1)");
    if ($rezultat)
        echo 'true';
    else echo 'false';
}

function dodajKat($nazivKat)
{
    $db = konekcija();
    $nazivKat = addslashes(strip_tags($nazivKat));
    $provera = mysqli_query($db, "SELECT * FROM kategorije WHERE naziv = '{$nazivKat}'");
    if (mysqli_num_rows($provera) > 0) {
        echo "zauzeto";
    } else {
        $rezultat = mysqli_query($db, "INSERT INTO kategorije VALUES ('', '{$nazivKat}')");
        if ($rezultat)
            echo 'true';
        else echo 'false';
    }
}

function kategorije()
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM kategorije");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            echo "<p>{$red['naziv']} --- [<a href='#' class='obrisiKat' data-kat='{$red['id']}'>Obriši</a>]</p>";
        }
    }
}

function obrisiKat($idKat)
{
    $db = konekcija();
    $sql = "DELETE FROM kategorije WHERE id='{$idKat}'";
    $rezultat = mysqli_query($db, $sql);
    if ($rezultat > 0)
        echo "true";
    else
        echo "false";
}

function proizvodi()
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM proizvodi ORDER BY model");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            echo "<p>{$red['model']} --- [<a href='#' class='obrisiPro' data-pro='{$red['id']}'>Obriši</a>] [<a href='azurirajPro.php?id={$red['id']}' class='azurirajPro' data-pro='{$red['id']}'>Ažuriraj</a>]</p>";
        }
    }
}

function obrisiPro($idPro)
{
    $db = konekcija();
    $sql = "DELETE FROM proizvodi WHERE id='{$idPro}'";
    $rezultat = mysqli_query($db, $sql);
    if ($rezultat > 0)
        echo "true";
    else
        echo "false";
}

function formaPro($idPro)
{
    $db = konekcija();
    $sql = "SELECT * FROM proizvodi WHERE id={$idPro}";
    $rezultat = mysqli_query($db, $sql);
    if (mysqli_num_rows($rezultat) > 0) {
        $red = mysqli_fetch_assoc($rezultat);
        echo "
            <h3>Izmena podataka za {$red['model']}</h3>
            <form name='azurirajProForma'>
            Model: <input type='text' name='model' value='{$red['model']}'><br>
            Cena: <input type='text' name='cena' value='{$red['cena']}'><br>
            Specifikacije: <textarea name='karakteristike' rows='6' cols='35'>{$red['karakteristike']}</textarea><br>
            <input type='button' id='potvrdi' value='Potvrdi'>
            </form>
        ";
    } else
        echo "Greska";
}

function azurirajPro($idPro, $model, $cena, $karakteristike)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "UPDATE proizvodi SET model='{$model}', karakteristike='{$karakteristike}', cena='{$cena}' WHERE id='{$idPro}'");
    if ($rezultat > 0) {
        echo 'true';
    } else echo 'false';
}

function dodajPro($idKat, $model, $karakteristike, $cena, $slike)
{
    $db = konekcija();
    $date = date("Y-m-d");
    $date = date("Y-m-d", strtotime($date));
    $provera = mysqli_query($db, "SELECT * FROM proizvodi WHERE model = '{$model}'");
    if (mysqli_num_rows($provera) > 0) {
        echo "zauzeto";
    } else {
        $rezultat = mysqli_query($db, "INSERT INTO proizvodi VALUES ('', '{$idKat}', '{$model}', '{$karakteristike}', '{$cena}', '{$slike}')");
        if ($rezultat > 0)
            echo 'true';
        else echo 'false';
    }
}

function kategorijeInd()
{
    $db = konekcija();
    $rezultat = mysqli_query($db, 'SELECT * FROM kategorije ORDER BY naziv');
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            echo "<a href='proizvodi.php?idKat={$red['id']}'>{$red['naziv']}</a>";
        }
    }
}

function prikaziPro($idKat, $sort)
{
    $db = konekcija();
    $link = "";
    if ($sort == "opadajuce")
        $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE idKat='{$idKat}' ORDER BY cena DESC ");
    elseif ($sort == "naziv")
        $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE idKat='{$idKat}' ORDER BY model");
    else
        $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE idKat='{$idKat}' ORDER BY cena");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {

            $slika = scandir("img/" . $red['slike'] . "/")[2];
            $link = "img/" . $red['slike'] . "/" . $slika;

            //$link = "img/" . $red['slike'] . "/1.jpg";
            echo "<div>";
            echo "<a href='prikaziPro.php?id={$red['id']}' style='text-decoration: none;'><p>{$red['model']}</p>";
            echo "<p><img src='$link' width='auto' height='100px'></p></a>";
            echo "<p>{$red['cena']} RSD</p>";
            if (isset($_SESSION['korisnickoIme']))
                echo "<p><a href='#' class='dodajUKorpu' data-korpa='{$red['id']}' style='text-decoration: none;'>Dodaj u korpu</a></p>";
            echo "</div>";
        }
    } else
        echo "Nema u ponudi!";

}

function prikaziProCeo($id)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE id='{$id}'");
    if (mysqli_num_rows($rezultat) > 0) {
        $red = mysqli_fetch_assoc($rezultat);

        $slika = scandir("img/" . $red['slike'] . "/")[2];
        $link = "img/" . $red['slike'] . "/" . $slika;

        //$link = "img/" . $red['slike'] . "/1.jpg";
        echo "<h2>{$red['model']}</h2>";
        echo "<p><img src='$link' width='280px' height='auto'></p></a>";
    }
}

function prikaziKarakteristike($id)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE id='{$id}'");
    if (mysqli_num_rows($rezultat) > 0) {
        $red = mysqli_fetch_assoc($rezultat);
        echo nl2br(htmlspecialchars($red['karakteristike']));
    }
}

function prikaziDodajUKorpu($id)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE id='{$id}'");
    if (mysqli_num_rows($rezultat) > 0) {
        $red = mysqli_fetch_assoc($rezultat);
        echo "<div id='dodajUKorpuFont'><a href='#' class='dodajUKorpu' data-korpa='{$red['id']}' style='text-decoration: none'><b>DODAJ U KORPU</b> <img src='img/cart_icon.png' style='width: 20px'></a></div>";
    }
}

function prikaziCenu($id)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE id='{$id}'");
    if (mysqli_num_rows($rezultat) > 0) {
        $red = mysqli_fetch_assoc($rezultat);
        echo "<div id='cenaFont'><b>{$red['cena']}</b> <font size='2px'>RSD</font></div>";
    }
}

function listaPro($id)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE id != '{$id}' ORDER BY model");
    if (mysqli_num_rows($rezultat) > 0) {
        echo "<select id='drugiPro'>";
        while ($red = mysqli_fetch_assoc($rezultat)) {
            echo "<option value='{$red['id']}'>{$red['model']}</option>";
        }
        echo "</select>";
        echo "<input type='button' id='submitUporedi' value='Uporedi'>";
    }
}

function prikaziPoredjenje($id1, $id2)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE id = '{$id1}' OR id='{$id2}'");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {

            $slika = scandir("img/" . $red['slike'] . "/")[2];
            $link = "img/" . $red['slike'] . "/" . $slika;

            //$link = "img/" . $red['slike'] . "/1.jpg";
            echo "<div>";
            echo "<a href='prikaziPro.php?id={$red['id']}' style='text-decoration: none;'><h3>{$red['model']}</h3>";
            echo "<img src='$link' width='auto' height='200px'></a>";
            echo "<p>" . nl2br(htmlspecialchars($red['karakteristike'])) . "</p>";
            echo "</div>";
        }
    }
}

function korisnik($idKor)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM korisnici WHERE id='{$idKor}'");
    if (mysqli_num_rows($rezultat) > 0) {
        $red = mysqli_fetch_assoc($rezultat);

        echo "<br>
<form name='formaKor' action='' method='post'>
    <table width='350'>
        <tr>
            <td>Ime:</td>
            <td><input type='text' value='{$red['ime']}' name='ime'></td>
        </tr>
        <tr>
            <td>Prezime: </td>
            <td><input type='text' value='{$red['prezime']}' name='prezime'></td>
        </tr>
        <tr>
            <td>E-mail adresa: </td>
            <td><input type='email' value='{$red['mail']}' name='mail'></td>
        </tr>
        <tr>
            <td>Datum rođenja: </td>
            <td><input type='date' value='{$red['datumRodj']}' name='datumRodj'></td>
        </tr>
        <tr>
            <td>Ulica i broj:</td>
            <td><input type='text' value='{$red['ulicaIBr']}' name='ulicaIBr'></td>
        </tr>
        <tr>
            <td>Grad i poštanski broj:</td>
            <td><input type='text' value='{$red['gradIPB']}' name='gradIPB'></td>
        </tr>
        <tr>
            <td>Telefon:</td>
            <td><input type='text' value='{$red['telefon']}' name='telefon'></td>
        </tr>
        <tr>
            <td colspan=\"2\"><input type='submit' id='potvrdi' value='Izmeni podatke'></td>
        </tr>
    </table>
</form>";
    }
}

function licniPodaci($idKor)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM korisnici WHERE id='{$idKor}'");
    if (mysqli_num_rows($rezultat) > 0) {
        $red = mysqli_fetch_assoc($rezultat);

        echo "<div id='licniPod'>
<form name='formaKor' action='' method='post'>
    <table width='300'>
        <tr>
            <td>Ime:</td>
            <td><input type='text' value='{$red['ime']}' name='ime'></td>
        </tr>
        <tr>
            <td>Prezime: </td>
            <td><input type='text' value='{$red['prezime']}' name='prezime'></td>
        </tr>
        <tr>
            <td colspan='2' style='display: none'><input type='email' value='{$red['mail']}' name='mail'></td>
        </tr>
        <tr>
            <td colspan='2' style='display: none'><input type='date' value='{$red['datumRodj']}' name='datumRodj'></td>
        </tr>
        <tr>
            <td>Ulica i broj:</td>
            <td><input type='text' value='{$red['ulicaIBr']}' name='ulicaIBr'></td>
        </tr>
        <tr>
            <td>Grad i poštanski broj:</td>
            <td><input type='text' value='{$red['gradIPB']}' name='gradIPB'></td>
        </tr>
        <tr>
            <td>Telefon:</td>
            <td><input type='text' value='{$red['telefon']}' name='telefon'></td>
        </tr>
        <tr>
            <td colspan='2'><input type='submit' id='izmeni' value='Izmeni podatke'></td>
        </tr>
    </table>
</form></div>";
    }
}

function azurirajKor($id, $ime, $prezime, $mail, $datum, $telefon, $ulica, $grad)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "UPDATE korisnici SET ime='{$ime}', prezime='{$prezime}', datumRodj='{$datum}', ulicaIBr='{$ulica}', gradIPB='{$grad}', telefon='{$telefon}', mail='{$mail}' WHERE id='{$id}'");
    if ($rezultat > 0) {
        echo 'true';
    } else echo 'false';
}

function azurirajKorLoz($id, $lozinka, $novaLozinka1)
{
    $db = konekcija();
    $provera = mysqli_query($db, "SELECT * FROM korisnici WHERE id = '{$id}'");
    if (mysqli_num_rows($provera) > 0) {
        $red = mysqli_fetch_assoc($provera);
        if ($red['lozinka'] == $lozinka) {
            $rezultat = mysqli_query($db, "UPDATE korisnici SET lozinka = '{$novaLozinka1}' WHERE id = '{$id}'");
            if ($rezultat > 0)
                echo 'true';
            else echo 'false';
        } else echo 'pogresnaLoz';
    } else echo 'false';
}

function zelja($idPro, $idKor)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM zelje WHERE idPro = '{$idPro}' AND idKor = '{$idKor}'");
    if (mysqli_num_rows($rezultat) > 0) {
        return true;
    } else return false;
}

function izbaci($idPro, $idKor)
{

    $db = konekcija();
    $rezultat = mysqli_query($db, "DELETE FROM zelje WHERE idKor='{$idKor}' AND idPro='{$idPro}'");
    if ($rezultat > 0)
        echo "true";
    else
        echo "false";
}

function ubaci($idPro, $idKor)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "INSERT INTO zelje VALUES ('', '{$idKor}', '{$idPro}')");
    if ($rezultat != 0)
        echo "true";
    else
        echo "false";
}

function zeljeKor($idKor)
{
    $db = konekcija();
    $pronadji = mysqli_query($db, "SELECT * FROM zelje WHERE idKor='{$idKor}'");
    if (mysqli_num_rows($pronadji) > 0) {
        while ($red1 = mysqli_fetch_assoc($pronadji)) {
            $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE id='{$red1['idPro']}'");
            if (mysqli_num_rows($rezultat) > 0) {
                $red = mysqli_fetch_assoc($rezultat);
                echo "<p><a href='prikaziPro.php?id={$red['id']}' style='text-decoration: none;'>{$red['model']}</a> &nbsp;&nbsp; <a href='#' class='obrisiZelju' data-zelja='{$red1['id']}'><img src='img/remove_icon.png' width='15px' title='Izbaci iz liste želja'></a></p>";
            } else echo 'Nije pronađen proizvod u bazi!';
        }
    } else echo 'Nemate izabranih proizvoda u listi želja!';
}

function izbaciZelju($idZelje)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "DELETE FROM zelje WHERE id='{$idZelje}'");
    if ($rezultat > 0)
        echo "true";
    else echo "false";
}

function dodajKom($idPro, $idKor, $tekst)
{
    $db = konekcija();
    strip_tags(addslashes($tekst));
    $sql = "INSERT INTO komentari VALUES ('', '{$idKor}','{$idPro}','{$tekst}', now(), '0')";
    $rezultat = mysqli_query($db, $sql);
    if ($rezultat > 0)
        echo "true";
    else
        echo "false";
}

function prikaziKom($idPro)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM komentari WHERE idPro='{$idPro}' AND odobren='1' ORDER BY id DESC");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $imeKor = mysqli_query($db, "SELECT * FROM korisnici WHERE id = '{$red['idKor']}'");
            if (mysqli_num_rows($imeKor) > 0) {
                $red1 = mysqli_fetch_assoc($imeKor);
            }
            echo "<img src='img/user_icon.png' height='20px'>";
            echo " {$red1['korisnickoIme']} --- [{$red['datum']}]";
            echo "<p class='spanKom'>{$red['tekst']}</p>";
        }
    } else echo "Nema komentara za ovaj proizvod!";
}

function prikaziKomAdmin()
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM komentari WHERE odobren='0' ORDER BY id ASC");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $imeKor = mysqli_query($db, "SELECT * FROM korisnici WHERE id = '{$red['idKor']}'");
            if (mysqli_num_rows($imeKor) > 0) {
                $red1 = mysqli_fetch_assoc($imeKor);
            }
            echo "<p>{$red1['korisnickoIme']} --- [{$red['datum']}]</p>";
            echo "<p>{$red['tekst']}</p>";
            echo "<p><a href='#' class='dodajKom' data-dodajKom='{$red['id']}'>[Odobri]</a>";
            echo " --- <a href='#' class='obrisiKom' data-obrisiKom='{$red['id']}'>[Obriši]</a></p>";
        }
    } else echo "Nema novih komentara za odobravanje!";
}

function dodajKomAdm($idKom)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "UPDATE komentari SET odobren = '1' WHERE id = '{$idKom}'");
    if ($rezultat > 0)
        echo "true";
    else echo "false";
}

function obrisiKomAdm($idKom)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "DELETE FROM komentari WHERE id = '{$idKom}'");
    if ($rezultat > 0)
        echo "true";
    else echo "false";
}

function dodajUKorpu($idPro)
{
    $db = konekcija();
    $idNarudzbenice = dohvatiIdNarudzbenice();
    $proveraKorpe = mysqli_query($db, "SELECT * FROM korpa WHERE idNarudzbenice = '{$idNarudzbenice}' AND idPro = '{$idPro}'");
    if (mysqli_num_rows($proveraKorpe) > 0) {
        $updateRezultat = mysqli_query($db, "UPDATE korpa SET kolicina = kolicina + 1 WHERE idNarudzbenice = '{$idNarudzbenice}' AND idPro = '{$idPro}'");
        if ($updateRezultat > 0) {
            echo "true";
        } else echo "false";
    } else {
        $insertKorpa = mysqli_query($db, "INSERT INTO korpa VALUES ('', '{$idNarudzbenice}', '{$idPro}', '1')");
        if ($insertKorpa > 0) {
            echo "true";
        } else echo "false";
    }
}

function prikaziKorpu($idNarudzbenice)
{
    $db = konekcija();
    $cena = 0;
    $ukupnaCena = 0;
    $rezultat = mysqli_query($db, "SELECT * FROM korpa WHERE idNarudzbenice = '{$idNarudzbenice}'");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $proizvod = mysqli_query($db, "SELECT * FROM proizvodi WHERE id = '{$red['idPro']}'");
            if (mysqli_num_rows($proizvod) > 0) {
                $red1 = mysqli_fetch_assoc($proizvod);
                $cena = $red1['cena'];
                echo "<p>{$red1['model']} &nbsp; x &nbsp;&nbsp;";
            }
            echo "<input type='text' id='kolicina' value='{$red['kolicina']}' data-idPro='{$red['id']}' style='border: none' size='2' disabled>";
            $cenaKolicina = $cena * $red['kolicina'];
            $ukupnaCena += $cenaKolicina;
            echo " &nbsp; $cenaKolicina RSD &nbsp; &nbsp;";
            echo "<a href = '#' class='izbaziIzKorpe' data-decPro='{$red['id']}'><img src='img/remove_icon.png' width='15px' title='Izbaci iz korpe'></a></p>";
        }
        echo "<br>Ukupna cena: <input type='text' id='ukupnaCena' value='$ukupnaCena' style='border: none' size='10' disabled> RSD<br>";
    } else {
        echo "<h2>Korpa je prazna!</h2>";
        echo "<a href='index.php'>Vrati se na početnu stranu ></a>";
    }
}

function kolicina($idPro)
{
    $db = konekcija();
    $provera = mysqli_query($db, "SELECT * FROM korpa WHERE id = '{$idPro}'");
    if (mysqli_num_rows($provera) > 0) {
        $red = mysqli_fetch_assoc($provera);
        if ($red['kolicina'] > 1) {
            $rezultat = mysqli_query($db, "UPDATE korpa SET kolicina = kolicina - 1 WHERE id = '{$idPro}'");
            if ($rezultat > 0)
                echo "true";
            else echo "false";
        } else {
            $rezultat = mysqli_query($db, "DELETE FROM korpa WHERE id = '{$idPro}'");
            if ($rezultat > 0)
                echo "true";
            else echo "false";
        }
    } else echo "false";
}

function kupi($idNarudzbenice, $ukupnaCena, $datumDostave, $rezervisano)
{
    $db = konekcija();
    if ($datumDostave == "1") {
        $datumDostave1 = Date("Y-m-d");
        $ukupnaCena += 250;
    } elseif ($datumDostave == "2")
        $datumDostave1 = Date('Y-m-d', strtotime("+2 days"));
    else $datumDostave1 = $rezervisano;
    $rezultat = mysqli_query($db, "UPDATE narudzbenice SET datumDostave = '{$datumDostave1}', ukupnaCena = '{$ukupnaCena}', zavrseno = '1' WHERE id = '{$idNarudzbenice}'");
    if ($rezultat) {
        $novaNarudzbenica = mysqli_query($db, "INSERT INTO narudzbenice VALUES ('', '{$_SESSION['idKor']}', now(), '0', '0', '0', '0')");
        $_SESSION['narudzbenica'] = 1;
        echo "true";
    } else echo "false";
}

function istorijaKupovine($idKor)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM narudzbenice WHERE idKor = '{$idKor}' AND zavrseno = '1'");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $rezultat1 = mysqli_query($db, "SELECT * FROM korpa WHERE idNarudzbenice = '{$red['id']}'");
            if (mysqli_num_rows($rezultat1) > 0) {
                while ($red1 = mysqli_fetch_assoc($rezultat1)) {
                    $rezultat2 = mysqli_query($db, "SELECT * FROM proizvodi WHERE id = '{$red1['idPro']}'");
                    if (mysqli_num_rows($rezultat2) > 0) {
                        $red2 = mysqli_fetch_assoc($rezultat2);
                        echo "<p><a href='prikaziPro.php?id={$red2['id']}' style='text-decoration: none;'>{$red2['model']}</a> x";
                    }
                    echo " {$red1['kolicina']}</p>";
                }
            }
            echo "<p>Datum kupovine: {$red['datum']}</p>";
            echo "<p>Ukupna cena: {$red['ukupnaCena']} RSD</p>";
            echo "------------------------------------------------";
        }
    } else echo "Vaša istorija kupovine je prazna!";
}

function praznaKorpa($idNarudzbenice)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM korpa WHERE idNarudzbenice = '{$idNarudzbenice}'");
    if (mysqli_num_rows($rezultat))
        return false;
    else return true;
}

function prikaziNarudzbine()
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM narudzbenice WHERE zavrseno = '1' AND poslato = '0' ORDER BY datumDostave");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $rezultat1 = mysqli_query($db, "SELECT * FROM korisnici WHERE id = '{$red['idKor']}'");
            if (mysqli_num_rows($rezultat1) > 0) {
                $red1 = mysqli_fetch_assoc($rezultat1);
                echo "<p>{$red1['ime']} {$red1['prezime']}, {$red1['ulicaIBr']}, {$red1['gradIPB']}, {$red1['telefon']}</p>";
            }
            echo "<p>Datum naručivanja: {$red['datum']}</p>";
            echo "<p>Datum isporuke: {$red['datumDostave']}</p>";
            $rezultat2 = mysqli_query($db, "SELECT * FROM korpa WHERE idNarudzbenice = '{$red['id']}'");
            if (mysqli_num_rows($rezultat2) > 0) {
                while ($red2 = mysqli_fetch_assoc($rezultat2)) {
                    $rezultat3 = mysqli_query($db, "SELECT * FROM proizvodi WHERE id = '{$red2['idPro']}'");
                    if (mysqli_num_rows($rezultat3) > 0) {
                        $red3 = mysqli_fetch_assoc($rezultat3);
                        echo "<p><a href='prikaziPro.php?id={$red3['id']}'>{$red3['model']}</a> x ";
                    }
                    echo "{$red2['kolicina']}</p>";
                }
            }
            echo "<input type='button' id='posalji' value='Posalji paket' data-idNarudzbenice='{$red['id']}'>";
            echo "<br> _________________________________________________";
        }
    } else echo "Nema novih pristiglih narudžbina!";
}

function posalji($idNarudzbenice)
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "UPDATE narudzbenice SET poslato = '1' WHERE id = '{$idNarudzbenice}'");
    if ($rezultat > 0) echo "true";
    else echo "false";
}

function statistika($datum1, $datum2)
{
    $db = konekcija();
    $nizPro = array();
    $i = 0;
    $pom = 0;
    $nizKol = array();
    $j = 0;
    $rezultat = mysqli_query($db, "SELECT * FROM narudzbenice WHERE zavrseno = '1' AND poslato = '1' AND datum BETWEEN '{$datum1}' AND '{$datum2}'");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $rezultat1 = mysqli_query($db, "SELECT * FROM korpa WHERE idNarudzbenice = '{$red['id']}'");
            if (mysqli_num_rows($rezultat1) > 0) {
                while ($red1 = mysqli_fetch_assoc($rezultat1)) {
                    $pom = 0;
                    for ($k = 0; $k < count($nizPro); $k++) {
                        if ($red1['idPro'] == $nizPro[$k]) {
                            $nizKol[$k] += $red1['kolicina'];
                            $pom = 1;
                            break;
                        }
                    }
                    if ($pom == 1) continue;
                    else {
                        $nizPro[$i++] = $red1['idPro'];
                        $nizKol[$j++] = $red1['kolicina'];
                    }
                }
            }
        }
        for ($m = 0; $m < count($nizPro); $m++) {
            $rezultat2 = mysqli_query($db, "SELECT * FROM proizvodi WHERE id = '{$nizPro[$m]}'");
            if (mysqli_num_rows($rezultat2)) {
                $red2 = mysqli_fetch_assoc($rezultat2);
                echo "<p><a href='prikaziPro.php?id={$red2['id']}'>{$red2['model']}</a> x {$nizKol[$m]}</p>";
            } else echo 'nema Naziv';
        }
    } else echo 'Nema prodatih proizvoda u tom vremenskom intervalu!';
}

function statistika1($datum1, $datum2)
{
    $db = konekcija();
    $istiDan = 0;
    $dvaDana = 0;
    $rezervisano = 0;
    $rezultat = mysqli_query($db, "SELECT * FROM narudzbenice WHERE zavrseno = '1' AND poslato = '1' AND datum BETWEEN '{$datum1}' AND '{$datum2}'");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            if ($red['datum'] == $red['datumDostave'])
                $istiDan++;
            else if (ceil(abs(strtotime($red['datumDostave']) - strtotime($red['datum'])) / 86400) == 2)
                $dvaDana++;
            else $rezervisano++;
        }
        echo "<p>Dostava istog dana koja se naplaćuje dodatno: " . $istiDan . "</p>";
        echo "<p>Dostava u roku od 2 radna dana: " . $dvaDana . "</p>";
        echo "<p>Dostava rezervisana za određeni datum: " . $rezervisano . "</p>";
    } else
        echo "Nema prodatih proizvoda u tom vremenskom intervalu!";
}

function kolicinaKorpe()
{
    $db = konekcija();
    $kolicina = 0;
    $idNarudzbenice = dohvatiIdNarudzbenice();
    $rezultat = mysqli_query($db, "SELECT * FROM korpa WHERE idNarudzbenice = '{$idNarudzbenice}'");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $kolicina += $red['kolicina'];
        }
        echo $kolicina;
    } else
        echo $kolicina;
}

function poslednjiPro()
{
    $db = konekcija();
    $rezultat = mysqli_query($db, "SELECT * FROM proizvodi ORDER BY id DESC LIMIT 4");
    if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {

            $slika = scandir("img/" . $red['slike'] . "/")[2];
            $link = "img/" . $red['slike'] . "/" . $slika;

            //$link = "img/" . $red['slike'] . "/1.jpg";
            echo "<div>";
            echo "<a href='prikaziPro.php?id={$red['id']}' style='text-decoration: none;'><p>{$red['model']}</p>";
            echo "<p><img src='$link' width='auto' height='100px'></p></a>";
            echo "<p>{$red['cena']} RSD</p>";
            if (isset($_SESSION['korisnickoIme']))
                echo "<p><a href='#' class='dodajUKorpu' data-korpa='{$red['id']}' style='text-decoration: none;'>Dodaj u korpu </a></p>";
            echo "</div>";
        }
    }
}

?>
