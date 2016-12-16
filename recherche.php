<?php

session_start();
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
require_once('libs/Smarty.class.php');
require_once 'settings/connexion.inc.php';

//condition qui verifie que le contenu de recherche existe et est non Null
if (isset($_GET['recherche'])) {
    //met le contenu de recherche qui se trouve dans l'url dans la variable recherche
    $recherche = $_GET['recherche'];
    //requete sql
    $sth = $bdd->prepare("select id, titre,texte,DATE_FORMAT(date, '%d/%m/%Y') as date_fr from article where (titre like :recherche or texte like :recherche)");
    //securisation des variables
    $sth->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
    $sth->execute(); //execute la requete

    //compte le nombre de resultat de la variable sth et affecte se nombre dans la variable compteur
    $compteur = $sth->rowCount();
//print_r($compteur);
    
    //condition si la variable compteur est superieur a 0
    if ($compteur > 0) {
        $tab_search = $sth->fetchAll(PDO::FETCH_ASSOC); //pousse le resultat sql dans un tableau php  

        $smarty = new Smarty();

        $smarty->setTemplateDir('templates/');
        $smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

        //crée la variable dans smarty
        $smarty->assign('tab_search', $tab_search);
        //crée la variable dans smarty
        $smarty->assign('recherche', $recherche);
        //crée la variable dans smarty
        $smarty->assign('compteur', $compteur);
        //crée la variable dans smarty
        $smarty->assign('acces', $acces);

//** un-comment the following line to show the debug console
        //$smarty->debugging = true;

        include_once 'includes/header.inc.php';
        $smarty->display('recherche.tpl');
    } 
    //condition qui est effectuer si la precedente n'est pas effectuer
    else {
        $smarty = new Smarty();
        $smarty->setTemplateDir('templates/');
        $smarty->setCompileDir('templates_c/');

        //crée la variable dans smarty
        $smarty->assign('tab_search', NULL);
        //crée la variable dans smarty
        $smarty->assign('recherche', $recherche);
        //crée la variable dans smarty
        $smarty->assign('compteur', $compteur);
        //crée la variable dans smarty
        $smarty->assign('acces', $acces);

        include_once 'includes/header.inc.php';
        $smarty->display('recherche.tpl');
    }
//print_r($tab_search);
}
include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';
?>