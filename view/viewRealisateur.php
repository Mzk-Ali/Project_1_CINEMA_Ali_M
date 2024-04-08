<?php 
session_start();
ob_start(); 
include "function.php";?>

<?php
    list_defilement("listRealisateurs", "personne_fiche_view", "Liste Réalisateurs :", $requete_listRealisateurs, "defaut");
    list_defilement("listRealisateurs", "personne_fiche_view", "Nombre de film réalisé :", $requete_listRealisateursPerNbr, "defaut");
    list_defilement("listRealisateurs", "personne_fiche_view", "Selon la moyenne de note :", $requete_listRealisateursPerNote, "defaut");
?>

<?php

$titre = "Catégorie : Réalisteurs";
// $titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require_once "template.php";