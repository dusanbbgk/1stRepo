<?php
session_start();
require 'database_functions.php';
$korisnickoIme = $_POST['korisnickoIme'];
$lozinka = $_POST['lozinka'];
if (validacija($korisnickoIme, $lozinka)) {
    if ($_SESSION['admin'])
        echo 'admin';
    else
        echo 'true';
} else
    echo 'false';
?>