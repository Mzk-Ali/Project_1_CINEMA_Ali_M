<?php 
session_start();
ob_start(); ?>


<section class="formulaire_modification">
    <h1>Ajout d'un profil</h1>

    <form action="index.php?action=addPersonne" method="post">
        <div class="container_formFilm">
            <div class="nom">
                <label for="nom">Nom</label>
                <div class="input_form_nom">
                    <input name="nom" id="nom" type="text" placeholder="Entrez le nom">
                </div>
            </div>

            <div class="prenom">
                <label for="prenom">Prenom</label>
                <div class="input_form_prenom">
                    <input name="prenom" id="prenom" type="text" placeholder="Entrez le prenom">
                </div>
            </div>

            <div class="sexe">
                <label for="sexe">Sexe</label>
                <div class="input_form_sexe">
                    <select name="sexe" id="sexe">
                        <option value="" selected hidden>Choisis le sexe</option>
                        <option value="Masculin">Masculin</option>
                        <option value="Feminin">Feminin</option>
                    </select>
                </div>
            </div>

            <div class="dateNaissance">
                <label for="date_naissance">Date de sortie du film</label>
                <div class="input_form_dateNaissance">
                    <input name="date_naissance" id="date_naissance" type="date" value="Date de naissance">
                </div>
            </div>

            <div class="profil">
                <label for="profil">Image de la personne (url de l'image)</label>
                <div class="input_form_urlAffiche">
                    <input name="profil" id="profil" type="url" placeholder="URL du profil">
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