<?php
session_start();
require_once "database_functions.php";
$db = konekcija();
$pretraga = $_GET['pretraga'];
if(strlen($pretraga) > 3 && $pretraga != ""){
    $rezultat = mysqli_query($db, "SELECT * FROM proizvodi WHERE model LIKE '%" . $pretraga . "%'");
    if (mysqli_num_rows($rezultat) > 0){
        while($red = mysqli_fetch_assoc($rezultat)) {

            $slika = scandir("../img/" . $red['slike'] . "/")[2];
            $link = "img/" . $red['slike'] . "/" . $slika;

            //$link = "img/" . $red['slike'] . "/1.jpg";
            echo "<p><a href='prikaziPro.php?id={$red['id']}'><img src='$link' width='30px'>";
            echo " &nbsp; {$red['model']}</a></p>";
            echo "<p>&nbsp;&nbsp;{$red['cena']} RSD</p>";
        }
    }
}
