<?php

namespace Controller;
use Model\Connect;

class CinemaController {


    public function listFilms() {
        // Connexion à la base de données voulu
        $pdo = Connect::seConnecter();
        // Execute la requête voulu
        $requete = $pdo->query("
            SELECT titre, date_sortie
            FROM film
            ");

        // On relie à la vue qu'on souhaite dans le dossier view.
        // Tous ce qui se trouve avant ce require sera executé dans le view
        require "view/listFilms.php";
    }
}