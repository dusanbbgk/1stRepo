<?php
session_start();
require 'database_functions.php';
azurirajKorLoz($_POST['id'], $_POST['lozinka'], $_POST['novaLozinka1']);
?>