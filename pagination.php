<?php

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';

//variable du nombre darticles par page
$nbArticlePage = 2;

//variable qui contient la page courante

$currentPage = isset($_GET['p']) ? $_GET['p'] : 1;

//calculer le nombre de message publiés dans la table
//index de depart
//$debut = ($currentPage - 1) * $nbArticlePage;
//fonction qui permet la pagination
function returnIndex($nbArticlePage, $currentPage) {
    //calcul des elements
    $debut = ($currentPage - 1) * $nbArticlePage;
    //retourne la variable debut
    return $debut;
}

//fait appelle a la fonction returnindex et affecte le resultat a indexdepart
$indexDepart = returnIndex($nbArticlePage, $currentPage);

//requete
$sth = $bdd->prepare("select count(*) as nbArticles from article where publie = :publie");
$sth->bindValue(':publie', 1, PDO::PARAM_INT); //securisation des variable
$sth->execute(); //execute la requete
$tab_article = $sth->fetchAll(PDO::FETCH_ASSOC); //pousse le resultat sql dans un tableau php
//print_r($tab_article);
$nbArticle = $tab_article[0]['nbArticles']; //affecte le contenue de nbaticles du tableau tab_artcile dans la variable nbarticle
echo "<br>article : " . $nbArticle . "</br>"; //affiche le nombre d'article

$nbPage = ceil($nbArticle / $nbArticlePage); //arrondi au superieur

echo "nombre de Pages : " . $nbPage; //affiche le nombre de page
?>


