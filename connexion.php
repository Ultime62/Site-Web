<?php

session_start();

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
require_once('libs/Smarty.class.php');
require_once 'settings/connexion.inc.php';

//verifie que la variable post connexion existe et est non NULL
if (isset($_POST['connexion'])) {
    //requete qui verifie la conformité des données
    $sth_connex = $bdd->prepare("SELECT *  FROM utilisateur WHERE email = :email and mdp = :mdp");
    $sth_connex->bindValue(':email', $_POST['email'], PDO::PARAM_STR); //securise les variables
    $sth_connex->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR); //securise les variables
    $sth_connex->execute(); //execute la requete
    $count = $sth_connex->rowCount(); //calcul le nombre de resultat de la requete et met le nombre dans la variable count
    //condition si la variable count est superieur a 0
    if ($count > 0) {
        $tab_connexion = $sth_connex->fetchAll(PDO::FETCH_ASSOC); //pousse le resultat sql dans un tableau php
        $email = $tab_connexion[0]['email']; //Met le contenue du champ email de la bd dans une variable email
        $sid = md5($email . time()); //Cree la variable sid
        //requete pour injecter le sid dans la base
        $sth_connex = $bdd->prepare("UPDATE utilisateur SET sid = :sid WHERE email = :email ");
        $sth_connex->bindValue(':sid', $sid, PDO::PARAM_STR); //securise les variables
        $sth_connex->bindValue(':email', $email, PDO::PARAM_STR); //securise les variables
        $sth_connex->execute(); //execute la requete
        //definie le cookie
        setcookie('sid', $sid, time() + 3600);
        //redirige vers l'index et met la valeur de la session a true
        $_SESSION['connexion'] = TRUE;
        header("Location: index.php"); //redirige vers la page index
    }
    //condition sinon
    else {
        //affecte la variable session connexion a false 
        $_SESSION['connexion'] = FALSE;
        //print_r($_SESSION);
        //redirige vers la page connexion car la connexion est incorrect
        header("Location: connexion.php");
    }
}
//condition sinon
else {

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
//detruit la variable session ajout article
    unset($_SESSION['connexion']);

    //** un-comment the following line to show the debug console
    //$smarty->debugging = true;

    include_once 'includes/header.inc.php';

    $smarty->display('connexion.tpl');

    include_once 'includes/menu.inc.php';
    include_once 'includes/footer.inc.php';
}
?>