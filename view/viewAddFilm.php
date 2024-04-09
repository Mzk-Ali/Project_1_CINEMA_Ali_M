<?php 
session_start();
ob_start(); ?>


<section class="formulaire_modification">
    <h1>Ajout d'un film</h1>

    <form action="index.php?action=addFilm" method="post">
        <div class="container_formFilm">
            <div class="realisateurFilm">
                <label for="personne">Réalisateur</label>
                <div class="input_form_realisateur">
                    <select name="personne" id="personne">
                        <option value=""></option>
                        <option value="" selected hidden>Sélectionne le réalisateur</option>
                    <?php
                        foreach($requete_listPersonne->fetchAll() as $keys) { ?>
                            <option value="<?=$keys["id_personne"]?>"><?=$keys["personne"]?></option>
                        <?php }?>
                    </select>
                    <p>Si le réalisateur n'est pas présent, veuillez ajouter son profil</p>
                </div>
            </div>

            <div class="titleFilm">
                <label for="titre">Titre du film</label>
                <div class="input_form_title">
                    <input name="titre" id="titre" type="text" placeholder="Insérez le titre">
                </div>
            </div>

            <div class="dateFilm">
                <label for="date_sortie">Date de sortie du film</label>
                <div class="input_form_date">
                    <input name="date_sortie" id="date_sortie" type="date">
                </div>
            </div>

            <div class="dureeFilm">
                <label for="duree">Durée (en minutes)</label>
                <div class="input_form_duree">
                    <input name="duree" id="duree" type="number" placeholder="Insérez la durée du film">
                </div>
            </div>

            <div class="synopsisFilm">
                <label for="synopsis">Synopsis</label>
                <div class="input_form_synopsis">
                    <textarea name="synopsis" id="synopsis" placeholder="Insérez le synopsis du film"></textarea>
                </div>
            </div>

            <div class="urlAffiche">
                <label for="affiche_film">Affiche du film (url de l'image)</label>
                <div class="input_form_urlAffiche">
                    <input name="affiche_film" id="affiche_film" type="url">
                </div>
            </div>

            <div class="genreFilm">
                <label for="genre">Genre</label>
                <div class="input_form_genre">
                    <select name="genre" id="genre">
                        <option value=""></option>
                        <option value="" selected hidden>Sélectionne le genre</option>
                    <?php
                        foreach($requete_listGenre->fetchAll() as $keys) { ?>
                            <option value="<?=$keys["id_genre"]?>"><?=$keys["genre"]?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="formulaire_add_button">
            <!-- <input class="button_delete" type="submit" name="delete" value="Supprimer"> -->
            <input class="button_validate" type="submit" name="submit" value="Valider">
        </div>
    </form>
</section>

<section class="return_fiche">
    <button onclick="history.go(-1);">
        <div class="logo_return">
            <i class="ri-arrow-left-line"></i>
        </div>
    </button>
</section>


<?php

$titre = "";
$titre_secondaire = $titre;
$contenu = ob_get_clean();
require_once "template.php";