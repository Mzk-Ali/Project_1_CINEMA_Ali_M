<?php
// On utilise le fichier CinemaController
use Controller\CinemaController;

// On charge l'ensemble des classes du projet
spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

// On instancie CinemaController
$ctrlCinema = new CinemaController();

// $_GET['action'].........
if(isset($_GET["action"])){
    switch ($_GET["action"]) {
        case "listFilms" : $ctrlCinema->listFilms(); break;
        case "listActeurs" : $ctrlCinema->listActeurs(); break;
    }
}