<div class="span8">
    <!-- notifications -->
{* affiche une baniere de connexion reussie si celle ci a reussi *}
{if (isset($connexion) AND $connexion == TRUE)}
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Bienvenue!</strong> Vous êtes connecté.
        </div>
{/if}
{* affiche une baniere de deconnexion reussie si celle ci a reussi *}
{if (isset ($decoaction) and $decoaction == TRUE)}
    <div class="alert alert-warning alert-dismissible" role="alert">
            <strong>A bientot!</strong> Vous êtes maintenant déconnecter.
    </div>
{/if}
{* affiche une baniere d'acces refuser *}
{if (isset($refuser) AND $refuser == TRUE)}
        <div class="alert alert-error alert-dismissible" role="alert">
            <strong>Authentification requise!</strong> Veuillez vous connectez.
        </div>
{/if}
    <!-- contenu -->

    {* permet d'afficher les articles *}
    {foreach from=$tab_article  item='value' }
        <h2>{$value['titre']}</h2>

        <img src="img/{$value['id']}.jpg" width="100px" alt="{$value['titre']}"/>
        <p style="text-align: justify;">{$value['texte']}</p>
        <p><em><u>Publié le : {$value['date_fr']} </u></em></p>
        <a href ="article.php?id={$value['id']}">{if $acces == TRUE}<input type="submit" name="modifier" value="Modifier" class="btn btn-large btn-primary">{/if}</a>

    {/foreach}
    
    <div class="pagination">
        <ul>
            <li> <a> Page : </a></li>
            {*systeme pour le changement de page en bas de page*}
            {for $i = 1 ; $i <= $nbPage ; $i++} 
            <li {if ($currentPage == $i)} class="active"{/if}><a href ="index.php?p={$i}">{$i}</a></li>
            {/for}
        </ul>
    </div>
</div>