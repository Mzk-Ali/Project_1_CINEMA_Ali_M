<?php 
session_start();
ob_start(); 
$requete = $requete_ficheFilm->fetch();?>


<section class="formulaire_modification">
    <h1>Modification du film : <br><?=$requete["titre"]?></h1>

    <form action="index.php?action=modifFilm&id=<?=$requete["id"]?>" method="post">
        <div class="container_formFilm">
            <div class="realisateurFilm">
                <label for="personne">Réalisateur</label>
                <div class="input_form_realisateur">
                    <select name="personne" id="personne" value="<?=$requete["personne"]?>">
                        <option value=""></option>
                        <option value="<?=$requete["personne"]?>" selected hidden><?=$requete["personne"]?></option>
                    <?php
                        foreach($requete_listRealisateurs->fetchAll() as $keys) { ?>
                            <option value="<?=$keys["id"]?>"><?=$keys["personne"]?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="titleFilm">
                <label for="titre">Titre du film</label>
                <div class="input_form_title">
                    <input name="titre" id="titre" type="text" value="<?=$requete["titre"]?>">
                </div>
            </div>

            <div class="dateFilm">
                <label for="date_sortie">Date de sortie du film</label>
                <div class="input_form_date">
                    <input name="date_sortie" id="date_sortie" type="date" value="<?=$requete["date_sortie"]?>">
                </div>
            </div>

            <div class="dureeFilm">
                <label for="duree">Durée (en minutes)</label>
                <div class="input_form_duree">
                    <input name="duree" id="duree" type="number" value="<?=$requete["duree"]?>">
                </div>
            </div>

            <div class="synopsisFilm">
                <label for="synopsis">Synopsis</label>
                <div class="input_form_synopsis">
                    <textarea name="synopsis" id="synopsis"><?=$requete["synopsis"]?></textarea>
                </div>
            </div>

            <div class="urlAffiche">
                <label for="affiche_film">Affiche du film (url de l'image)</label>
                <div class="input_form_urlAffiche">
                    <input name="affiche_film" id="affiche_film" type="url" value="<?=$requete["affiche_film"]?>">
                </div>
            </div>

            <fieldset>
                <legend>Choisis un ou plusieurs genres du Film</legend>
                <ul>
                    <?php foreach($requete_listGenre->fetchAll() as $keys) { ?>
                        <li>
                            <input type="checkbox" id="<?=$keys["id_genre"]?>" name="check_list[]" value="<?=$keys["id_genre"]?>">
                            <label for="<?=$keys["id_genre"]?>"><?=$keys["genre"]?></label>
                        </li>
                    <?php }?>
                </ul>
            </fieldset>
        </div>
        
        
        <div class="formulaire_modif_button">
            <input class="button_delete" type="submit" name="delete" value="Supprimer">
            <input class="button_validate" type="submit" name="submit" value="Valider">
        </div>
    </form>
</section>

<section class="return_fiche">
    <a href="index.php?action=film_fiche_view&id=<?=$requete["id"]?>">
    <div class="logo_return">
            <i class="ri-arrow-left-line"></i>
        </div>
    </a>
</section>


<?php

$titre = "";
$titre_secondaire = $titre;
$contenu = ob_get_clean();
require_once "template.php";