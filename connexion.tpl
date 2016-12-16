<div class="span8">
        <!-- notifications -->
        {* affiche une banniere signifiant que la connexion a échouer *}
            {if isset($connexion) and $connexion == FALSE}
            <div class="alert alert-error alert-dismissible" role="alert">
                <strong>Erreur!</strong> réessayer.
            </div>
            {/if}
        <!-- contenu -->
        <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_connexion" name="form_connexion">
            <div class="clearfix">
                <label for="Email">Email</label>
                <div class="input"><input type="text" name="email" id="email" value=""></div>
            </div>

            <div class="clearfix">
                <label for="mdp">Mot de passe</label>
                <div class="input"><input type="password" name="mdp" id="mdp" value=""></div>
            </div>

            <div class="form-actions">
                <input type="submit" name="connexion" value="Connexion" class="btn btn-large btn-primary">
            </div>

        </form>

    </div>