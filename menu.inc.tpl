<nav class="span4">
    <h3>Menu</h3>

    <form action="recherche.php" method="get" enctype="multipart/form-data" id="form_recherche">
        <div class="clearfix">
            
            <div class="input"><input type="text" name="recherche" id="recherche" placeholder="Votre recherche..." required></div>
        </div>

        <div class="form-inline">
            <input type="submit" name="" value="rechercher" class="btn btn-mini btn-primary">
        </div>

    </form>

    <p><a class="btn btn-primary btn-block" href="index.php" role="button">Accueil</a></p>
    {* test si la variable acces est a true *}
    {if $acces == TRUE} 
        <p><a class="btn btn-primary btn-block" href="article.php" role="button">Rédiger un article</a></p>
        <p><a class="btn btn-primary btn-block" href="index.php?action=true" role="button" >Déconnexion</a></p>
    {* si la variable est a false ou autre etat *}
    {else}
        <p><a class="btn btn-primary btn-block" href="connexion.php" role="button">Connexion</a></p>
    {/if}

</nav>
</div>