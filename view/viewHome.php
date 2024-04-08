<?php 
session_start();
ob_start(); 
include "function.php";?>


<?php
    list_defilement("listFilms", "film_fiche_view", "Catégorie Film", $requete_listFilms, "defaut");
    list_defilement("listRealisateurs", "personne_fiche_view", "Réalisateurs", $requete_listRealisateurs, "defaut");
    list_defilement("listRealisateurs", "personne_fiche_view", "Acteurs", $requete_listActeurs, "defaut");
?>

<?php

$titre = "PDO Cinema";
// $titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require_once "template.php";
