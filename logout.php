<?php
session_start();
require_once "functions/database_functions.php";
if (isset($_SESSION['narudzbenica'])) {
    if ($_SESSION['narudzbenica'] == 1) {
        $db = konekcija();
        $idNarudzbenice = dohvatiIdNarudzbenice();
        $rezultat = mysqli_query($db, "DELETE FROM korpa WHERE idNarudzbenice = '{$idNarudzbenice}'");
        $rezultat2 = mysqli_query($db, "DELETE FROM narudzbenice WHERE id = '{$idNarudzbenice}' AND idKor = '{$_SESSION['idKor']}' AND zavrseno = '0'");
    }
}
session_destroy();
header("Location: index.php");
?>
