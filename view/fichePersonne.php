<?php 
session_start();
ob_start(); 
include "function.php";
$requete = $requete_fichePersonne->fetch();
//var_dump($requete);?>


<section class="section_info_personne">
    <div class="personne_profil">
        <img src="<?php echo $requete["profil"];?>" alt="">
    </div>
    <div class="personne_info">
        <span>Métier :</span>
        <span>Date de Naissance : <?= $requete["date_naissance"]?></span>
        <span>1ère Réalisation :</span>
        <span>Dernière Réalisation : </span>
    </div>
    <div class="icon_chiffre">
        <div class="logo"><i class="ri-edit-box-line"></i></div>
        <div class="chiffre">
            <div class="chiffre_film">
                <span>Film réalisé</span>
            </div>
            <div class="chiffre_acteur">
                <span>Acteur</span>
                <span>fois</span>
            </div>
        </div>
    </div>
</section>

<?php
    list_defilement("listFilms", "film_fiche_view", "Filmographie", $requete_listFilmsPerRealisateur);
    list_defilement("listFilms", "film_fiche_view", "Filmographie", $requete_listFilmsPerActeur);
?>

<?php

$titre = $requete["personne"];
$titre_secondaire = $titre;
$contenu = ob_get_clean();
require_once "template.php";