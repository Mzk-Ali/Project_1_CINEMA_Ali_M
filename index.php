<?php
// On utilise le fichier CinemaController
use Controller\CinemaController;
use Controller\AddCinemaController;
use Controller\ModifCinemaController;

// On charge l'ensemble des classes du projet
spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

// On instancie CinemaController
$ctrlCinema             = new CinemaController();
$ctrlAddCinema          = new AddCinemaController();
$ctrlModifCinema        = new ModifCinemaController();


// $_GET['action'].........
if(isset($_GET["action"])){
    switch ($_GET["action"]) {
        // case "listFilms" : $ctrlCinema->listFilms(); break;
        // case "listActeurs" : $ctrlCinema->listActeurs(); break;

        // --------------------- Gestion des vues ----------------------------------
        // Vue principal
        case "home_view"            : $ctrlCinema->viewHome(); break;
        case "film_view"            : $ctrlCinema->viewFilm($_GET["genre"]); break;
        case "realisateur_view"     : $ctrlCinema->viewRealisateur(); break;
        case "acteur_view"          : $ctrlCinema->viewActeur(); break;

        // Vu des fiches (Film et Personne)
        case "film_fiche_view"      : $ctrlCinema->viewFicheFilm($_GET["id"]); break;
        case "personne_fiche_view"  : $ctrlCinema->viewFichePersonne($_GET["id"]); break;

        // Vue pour l'ajout (Menu Add, Film, Personne)
        case "add_view"             : $ctrlCinema->viewAdd(); break;
        case "add_film_view"        : $ctrlCinema->viewAddFilm(); break;
        case "add_personne_view"    : $ctrlCinema->viewAddPersonne(); break;

        // Vue pour la modification (Film, Personne)
        case "modif_film"           : $ctrlCinema->viewModifFilm($_GET["id"]); break;
        case "modif_personne"       : $ctrlCinema->viewModifPersonne($_GET["id"]); break;
        
        // ------------------------ Gestion d'ajout --------------------------------
        case "addFilm"              : $ctrlAddCinema->addFilm(); break;
        case "addPersonne"          : $ctrlAddCinema->addPersonne(); break;

        // ------------ Gestion de modification et suppression ---------------------
        case "modifFilm"            : $ctrlModifCinema->ModifFilm($_GET["id"]); break;
        case "modifPersonne"        : $ctrlModifCinema->ModifPersonne($_GET["id"]); break;

    }
}