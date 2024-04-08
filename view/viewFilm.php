<?php 
session_start();
ob_start(); 
include "function.php";?>

<?php
    list_defilement("listFilms", "film_fiche_view", "Catégorie Film", $requete_listFilms, "defaut");
    list_defilement("listFilmsGenre", "film_fiche_view", "Classé selon le genre :", $requete_listFilmsPerGenre, $requete_listGenre);
    list_defilement("listFilms", "film_fiche_view", "Classé selon la note :", $requete_listFilmsPerNote, "defaut");
    list_defilement("listFilms", "film_fiche_view", "Classé selon la date de sortie :", $requete_listFilmsPerDateSortie, "defaut");
    list_defilement("listFilms", "film_fiche_view", "Classé selon la durée :", $requete_listFilmsPerDuree, "defaut");
?>

<?php

$titre = "Catégorie : Films";
// $titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require_once "template.php";