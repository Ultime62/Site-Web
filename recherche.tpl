<div class="span8">
    <!-- notifications -->
    <div class='alert alert-info' role='alert'>
        <strong> {$compteur} articles ont été trouvés pour le mot "{$recherche}"</strong>
    </div>
    <!-- contenu -->

    {* permet d'afficher les articles *}
    {foreach from=$tab_search  item='value' }
        {* permet d'afficher le titre *}
        <h2>{$value['titre']}</h2>
        {* permet d'afficher la bonne image *}
        <img src="img/{$value['id']}.jpg" width="100px" alt="{$value['titre']}"/>
        {* permet l'affichage du texte *}
        <p style="text-align: justify;">{$value['texte']}</p>
        {* permet d'afficher la date de publication *}
        <p><em><u>Publié le : {$value['date_fr']} </u></em></p>
        {* permet l'apparition du bouton modifier si on est connecter *}
        <a href ="article.php?id={$value['id']}">{if $acces == TRUE}<input type="submit" name="modifier" value="Modifier" class="btn btn-large btn-primary">{/if}</a>

    {/foreach}
</div>