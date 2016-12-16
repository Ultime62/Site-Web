<div class="span8">
    <!-- notifications -->
    {* affiche une baniere d'article ajouter *}
    {if isset ($ajout_article)}
        <div class="alert alert-warning alert-dismissible" role="alert">
            <strong>Félicitation!</strong> Votre article à bien été publié.
        </div>
    {/if}
    {* affiche une baniere d'article modifier *}
    {if isset($modifier_article)}
        <div class="alert alert-warning alert-dismissible" role="alert">
            <strong>Félicitation!</strong> Votre article à bien été modifier.
        </div>
    {/if}
    <!-- contenu -->
    <form action="article.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article">
        <input type="hidden" name="id" value="{* permet de mettre la valeur de l'id *}{if isset($tab_id[0]['id'])}{$tab_id[0]['id']}{/if}">
        <div class="clearfix">
            <label for="titre">Titre</label>
            <div class="input"><input type="text" name="titre" id="titre" value="{* permet de mettre la valeur du titre *}{if isset($tab_id[0]['titre'])}{$tab_id[0]['titre']}{/if}">
            </div>
        </div>
        <div class="clearfix">
            <label for="texte">Texte</label>
            <div class="input"><textarea name="texte" id="texte" >{* permet de mettre la valeur du texte*}{if isset($tab_id[0]['texte'])}{$tab_id[0]['texte']}{/if}</textarea>
            </div>
        </div>
            <div class="clearfix">
                <label for="image">Image</label>
                <div class="input"><input type="file" name="image" id="image">
                    {* permet d'afficher l'image *}{if isset($tab_id[0]['id'])}<br><img src="img/{$tab_id[0]['id']}.jpg" width="50px" alt='{$tab_id[0]['id']}'/>{/if}
                </div>
            </div>
                <div class="clearfix">
                    <label for="publie">Publié : </label>
                    <div class="input"><input type="checkbox" name="publie"{* permet de checker ou pas le bouton *}{$checked} id="publie"></div>
                </div>
                <div class="form-actions">
                    <input type="submit" name="{* permet d'affecter le nom du bouton *}{$bouton}" value="{$bouton}" class="btn btn-large btn-primary">
                </div>
    </form>
</div>