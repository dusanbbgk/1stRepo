<?php
session_start();
require 'database_functions.php';
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$korisnickoIme = $_POST['korisnickoIme'];
$lozinka = $_POST['lozinka'];
$mail = $_POST['mail'];
$ulicaIBr = $_POST['ulicaIBr'];
$gradIPB = $_POST['gradIPB'];
$telefon = $_POST['telefon'];
$datumRodj = $_POST['datumRodj'];
registracijaAdmina($ime, $prezime, $mail, $korisnickoIme, $lozinka, $ulicaIBr, $gradIPB, $telefon, $datumRodj);
?>