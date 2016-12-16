<?php
//permet la connexion a la base de données
try {
    $bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u644815701_simon;charset=utf8', 'u644815701_simon', 'Ultime62720');
    $bdd->exec("set names utf8");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
