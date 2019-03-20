<?php
session_start();
require_once("database_functions.php");
if (isset($_GET['obrisiKat']))
    if ($_GET['obrisiKat'] == true)
        obrisiKat($_GET['idKat']);
if (isset($_GET['dodajKat']))
    if ($_GET['dodajKat'] == true)
        dodajKat($_GET['nazivKat']);
if (isset($_GET['obrisiPro']))
    if ($_GET['obrisiPro'] == true)
        obrisiPro($_GET['idPro']);
if (isset($_GET['azurirajPro']))
    if ($_GET['azurirajPro'] == true)
        azurirajPro($_GET['idPro'], $_GET['model'], $_GET['cena'], $_GET['karakteristike']);
if (isset($_GET['dodajPro']))
    if ($_GET['dodajPro'] == true)
        dodajPro($_GET['idKat'], $_GET['model'], $_GET['karakteristike'], $_GET['cena'], $_GET['slike']);
if (isset($_GET['izbaci']))
    if ($_GET['izbaci'] == true)
        izbaci($_GET['idPro'], $_GET['idKor']);
if (isset($_GET['ubaci']))
    if ($_GET['ubaci'] == true)
        ubaci($_GET['idPro'], $_GET['idKor']);
if (isset($_GET['izbaciZelju']))
    if ($_GET['izbaciZelju'] == true)
        izbaciZelju($_GET['idZelje']);
if (isset($_GET['dodajKom']))
    if ($_GET['dodajKom'] == true)
        dodajKom($_GET['idPro'], $_GET['idKor'], $_GET['tekst']);
if (isset($_GET['dodajKomAdm']))
    if ($_GET['dodajKomAdm'] == true)
        dodajKomAdm($_GET['idKom']);
if (isset($_GET['obrisiKomAdm']))
    if ($_GET['obrisiKomAdm'] == true)
        obrisiKomAdm($_GET['idKom']);
if (isset($_GET['dodajUKorpu']))
    if ($_GET['dodajUKorpu'] == true)
        dodajUKorpu($_GET['idPro']);
if (isset($_GET['kolicina']))
    if ($_GET['kolicina'] == true)
        kolicina($_GET['idPro']);
if (isset($_GET['zavrsi']))
    if ($_GET['zavrsi'] == true)
        kupi($_GET['idNarudzbenice'], $_GET['ukupnaCena'], $_GET['datumDostave'], $_GET['rezervisano']);
if (isset($_GET['posalji']))
    if ($_GET['posalji'] == true)
        posalji($_GET['idNarudzbenice']);
if (isset($_GET['statistika']))
    if ($_GET['statistika'] == true)
        statistika($_GET['datum1'], $_GET['datum2']);
if (isset($_GET['statistika1']))
    if ($_GET['statistika1'] == true)
        statistika1($_GET['datum11'], $_GET['datum22']);