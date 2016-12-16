<?php

session_start();
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
require_once('libs/Smarty.class.php');
require_once 'settings/connexion.inc.php';


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
//requete sql
$sth_article = $bdd->prepare("select count(*) as nbArticles from article where publie = :publie"); //preparation de la rêquete
$sth_article->bindValue(':publie', 1, PDO::PARAM_INT); //securisation des variable
$sth_article->execute(); //execute la requete
$tab_page = $sth_article->fetchAll(PDO::FETCH_ASSOC); //pousse le resultat sql dans un tableau php
//print_r($tab_article);
$nbArticle = $tab_page[0]['nbArticles'];//met la partie nbarticles du tableau tab_page dans une variable
//echo "<br>article : " . $nbArticle . "</br>";

$nbPage = ceil($nbArticle / $nbArticlePage); //arrondi au superieur

$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date, '%d/%m/%Y') as date_fr FROM article WHERE publie = :publie Order By id DESC LIMIT $indexDepart, $nbArticlePage"); //preparation de la rêquete

$sth->bindValue(':publie', 1, PDO::PARAM_INT); //securisation des variable

$sth->execute(); //execute la requete

$tab_article = $sth->fetchAll(PDO::FETCH_ASSOC); //pousse le resultat sql dans un tableau php
//print_r($tab_article);

//permet de detruire la connexion suite a l'appuie du bouton deconnexion
if ((isset($_GET['action'])) && ($_GET['action'] == 'true')) {
    //detruit le cookie existant
    setcookie('sid','',-1);
    //affecte la variable decoaction a true
    $decoaction = true;
    //affecte la variable acces a false
    $acces=false;
}

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

//condition qui verifie la session connexion
if (isset($_SESSION['connexion'])) {
    //crée la variable dans smarty
    $smarty->assign('connexion', $_SESSION['connexion']);
}
//detruit la variable session modifier article
unset($_SESSION['connexion']);

//crée la variable dans smarty
$smarty->assign('acces', $acces);
//crée la variable dans smarty
$smarty->assign('tab_article', $tab_article);
//crée la variable dans smarty
$smarty->assign('nbPage', $nbPage);
//crée la variable dans smarty
$smarty->assign('currentPage', $currentPage);

//condition qui verifie la variable decoaction
if (isset($decoaction)) {
    //crée la variable dans smarty
    $smarty->assign('decoaction', $decoaction);
}
//condition qui verifie 
if (isset($_GET['refuser'])) {
    //crée la variable dans smarty
    $smarty->assign('refuser', $_GET['refuser']);
}
//** un-comment the following line to show the debug console
//$smarty->debugging = true;

include_once 'includes/header.inc.php';

$smarty->display('index.tpl');

include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';
?>