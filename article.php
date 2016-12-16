<?php

session_start();

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
require_once('libs/Smarty.class.php');
require_once 'settings/connexion.inc.php';

//condition qui empeche l'acces a la page si la personne n'est pas connecter
if ($acces == false) {
    header("Location: index.php?refuser=true"); //redirige vers l'accueil en ajoutant refuser=true dans l'url
}

//condition qui permet d'afficher le formulaire si le bouton n'as pas était cliquer
if (isset($_POST['ajouter']) OR isset($_POST['modifier'])) {

    //print_r($_FILES); //debug
    $date_ajout = date("Y-m-d"); //création de la date
    $_POST['date_ajout'] = $date_ajout; //ajout de la date dans le formulaire


    if (isset($_POST['publie'])) {
        $_POST['publie'] = 1;
    } //condition si la case publié est cocher pour envoyer a la bd de le mettre en publication.
    else {
        $_POST['publie'] = 0;
    }//sinon la valeur est mise a 0 pour que l'article ne soit pas publié
//condition ternaire
    $_POST['publie'] = isset($_POST['publie']) ? 1 : 0;

    //print_r($_POST); //debug
    //condition qui verifie si une image a bien etait mise
    if ($_FILES['image']['error'] == 0) {

        //condition si on ajoute un nouvelle article
        if (isset($_POST['ajouter'])) {
            //requete sql
            $sth = $bdd->prepare("INSERT INTO article (titre, texte, publie, date) Values(:titre, :texte, :publie, :date)");
            $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR); //securisation des variable
            $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR); //securisation des variable
            $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_INT); //securisation des variable
            $sth->bindValue(':date', $_POST['date_ajout'], PDO::PARAM_STR); //securisation des variable

            $sth->execute(); //execute la requete

            $id = $bdd->lastInsertId(); //retourne l'id qui vient d'etre inserer
            //echo '<br/> <b><u>' .$id. '</u></b>' ;

            move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$id.jpg"); //permet le transfere de l'image

            $_SESSION['ajout_article'] = TRUE; //met a true la session ajout article
            header("Location: article.php"); //redirige vers la page article
        } //condition qui si on modifie un article
        else if (isset($_POST['modifier'])) {
            $id_current = $_POST['id']; //recupere l'id de l'article que l'on modifie
            //requete sql
            $sth = $bdd->prepare("UPDATE article SET titre = :titre, texte = :texte, publie = :publie WHERE id= $id_current ");

            $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR); //securisation des variable
            $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR); //securisation des variable
            $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_INT); //securisation des variable

            $sth->execute(); //execute la requete

            $id = $_POST['id']; //retourne l'id de l'article modifier
            //echo '<br/> <b><u>' .$id. '</u></b>' ;

            move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$id.jpg"); //permet le transfere de l'image

            $_SESSION['modifier_article'] = TRUE; //met a true la session modifier article
            header("Location: article.php"); //redirige vers la page article
        }
    } //condition qui est effectuer si aucun autre precedente n'est remplie
    else {
        echo"Image erreur"; //affiche le message Image erreur
        exit(); //sort de la boucle
    }//condition pour verifier si il y a une erreur ou pas pour l'image
} 
//condition qui est effectuer si aucun autre precedente n'est remplie
else {
    //condition qui verifie si l'id existe et est non Null
    if (isset($_GET['id'])) {
        $select = $bdd->prepare("select * from article where id = :id"); //requete sql
        $select->bindValue(':id', $_GET['id'], PDO::PARAM_INT); //securisation des variable
        $select->execute(); //execute la requete
        $tab_id = $select->fetchAll(PDO::FETCH_ASSOC); //pousse le resultat sql dans un tableau php
    }
//exit();

    $smarty = new Smarty();

    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
//condition qui verifie la session ajout article
    if (isset($_SESSION['ajout_article'])) {
        //crée la variable dans smarty
        $smarty->assign('ajout_article', $_SESSION['ajout_article']);
    }
    //detruit la variable session ajout article
    unset($_SESSION['ajout_article']);

    //condition qui verifie la session modifier article
    if (isset($_SESSION['modifier_article'])) {
        //crée la variable dans smarty
        $smarty->assign('modifier_article', $_SESSION['modifier_article']);
    }
    //detruit la variable session modifier article
    unset($_SESSION['modifier_article']);

    //condition qui verifie l'id
    if (isset($_GET['id'])) {
        //crée la variable dans smarty
        $smarty->assign('tab_id', $tab_id);
    }
    //condition qui verifie l'id
    if (isset($_GET['id'])) {
        //crée la variable dans smarty
        $smarty->assign('checked', 'checked');
    }
//condition sinon
    else {
        //crée la variable dans smarty
        $smarty->assign('checked', '');
    }
    //condition qui verifie l'id
    if (isset($_GET['id'])) {
        //crée la variable dans smarty
        $smarty->assign('bouton', 'modifier');
    }
//condition sinon
    else {
        //crée la variable dans smarty
        $smarty->assign('bouton', 'ajouter');
    }

    //$smarty->debugging = true;
    //inclue l'header.inc.php a la page
    include_once 'includes/header.inc.php';

    $smarty->display('article.tpl');
}
//inclue le menu.inc.php a la page
include_once 'includes/menu.inc.php';
//inclue le footer.inc.php a la page
include_once 'includes/footer.inc.php';
?>