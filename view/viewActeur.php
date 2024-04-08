<?php 
session_start();
ob_start(); 
include "function.php";?>

<?php
    list_defilement("listRealisateurs", "personne_fiche_view", "Acteurs", $requete_listActeurs, "defaut");
?>

<?php

$titre = "Catégorie : Acteurs";
// $titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require_once "template.php";