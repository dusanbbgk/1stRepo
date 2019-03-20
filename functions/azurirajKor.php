<?php
session_start();
require_once 'database_functions.php';
azurirajKor($_POST['id'], $_POST['ime'], $_POST['prezime'], $_POST['mail'], $_POST['datumRodj'], $_POST['telefon'], $_POST['ulicaIBr'], $_POST['gradIPB']);

