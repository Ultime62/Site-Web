<?php


//Vérification de la présence du cookie et qu'il soit conforme
if (isset($_COOKIE['sid'])&& !empty($_COOKIE['sid'])){
    //met le contenu du sid de la variable cookie dans la variable sid
    $sid = $_COOKIE['sid'];
    //requete sql
    $sth = $bdd->prepare("select * from utilisateur where sid = :sid");
    //securisation de la variable
    $sth->bindValue(':sid',$sid, PDO::PARAM_STR);
    //execution de la requete
    $sth->execute();
    //met a true la variable acces
    $acces=TRUE;
} 
//condition si les precedente ne sont pas effectuer
else{
    //affecte la variable acces a false
    $acces=FALSE;
}
?>