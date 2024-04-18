<?php

namespace Controller;
use Model\Connect;

class CinemaController {

/* ----------------------------------- Manage BDD ---------------------------------------------- */

    // Execution et recuperation donnée par requête
    public function execAndRecovery($requete){
        // Connexion à la base de données voulu
        $pdo = Connect::seConnecter();
        // Execute la requête voulu
        $requete_recovery = $pdo->query("$requete");
        return $requete_recovery;
    }

    // Execution et recuperation donnée par requête avec variable
    public function prepAndExecAndRecovery($requete, $var_exec){
        // Connexion à la base de données voulu
        $pdo = Connect::seConnecter();
        // Prepare la requête
        $requete_recovery = $pdo->prepare("$requete");
        // Execute avec les variables présents dans la requête
        $requete_recovery->execute($var_exec);
        return $requete_recovery;
    }
/* --------------------------------------------------------------------------------------------- */


/* ------------- Ensemble des requêtes contenant des infos utiles pour les views --------------- */

    // Liste Film
    public function listFilms($filtre, $genre) {
        $requete_prepare = "
                SELECT titre, date_sortie, affiche_film, film.id_film AS id
                FROM film
                ";
        $var_exec = array();

        if($genre == "defaut" && $filtre == "defaut")
        {            
            $requete_recovery = $this->execAndRecovery($requete_prepare);
        }
        else{
            if($genre != "defaut")
            {
                $requete_prepare .= '
                    INNER JOIN gestion_genre
                    ON film.id_film = gestion_genre.id_film
                    INNER JOIN genre
                    ON gestion_genre.id_genre = genre.id_genre
                    WHERE genre.genre = :genre';
                $var_exec[":genre"] = "$genre";
            }
            if($filtre != "defaut")
            {
                $requete_prepare .= 'ORDER BY :filtre DESC';
                $var_exec[":filtre"] = "$filtre";
            }
            $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        }
        return $requete_recovery;
    }

    // Liste des personnes présents dans la base de données
    public function listPersonne(){
        $requete = "
                SELECT CONCAT(nom, ' ',prenom) AS personne, personne.id_personne
                FROM personne
                ";
        $requete_recovery = $this->execAndRecovery($requete);
        return $requete_recovery;
    }

    // Liste Realisateur
    public function listRealisateurs($filtre) {
        $requete = "SELECT ";
        if($filtre != "defaut"){
            $requete .= ":filtre AS filtre, ";
        }
         
        $requete .= "CONCAT(nom, ' ',prenom) AS personne, realisateur.id_personne AS id, realisateur.id_realisateur AS id_realisateur, profil
            FROM film
            INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
            INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
            GROUP BY film.id_realisateur
            ";
        if($filtre != "defaut")
        {
            $requete .= "ORDER BY filtre DESC";
            $var_exec["filtre"] = "$filtre";

            $requete_recovery = $this->prepAndExecAndRecovery($requete, $var_exec);
        }
        else
        {
            $requete_recovery = $this->execAndRecovery($requete);
        }
        return $requete_recovery;
    }

    // Liste Acteur
    public function listActeurs() {
        $requete = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, acteur.id_personne AS id, profil
            FROM acteur, personne
            WHERE acteur.id_personne = personne.id_personne
            ";
        $requete_recovery = $this->execAndRecovery($requete);
        return $requete_recovery;
    }

    // Liste de tous les genres de film
    public function listGenre(){
        $requete = "
            SELECT *
            FROM genre
            ";
        $requete_recovery = $this->execAndRecovery($requete);
        return $requete_recovery;
    }

    // Liste de tous les roles présents dans la base de données
    public function listRole(){
        $requete = "
            SELECT *
            FROM role
            ";
        $requete_recovery = $this->execAndRecovery($requete);
        return $requete_recovery;
    }

    // Liste Acteur et son rôle selon l'id d'un film
    public function listActeursAndRoleperFilm($id) {
        $requete_prepare = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, nom_personnage, acteur.id_personne AS id, profil
            FROM contrat
            INNER JOIN acteur
            ON contrat.id_acteur = acteur.id_acteur
            INNER JOIN personne
            ON acteur.id_personne = personne.id_personne
            INNER JOIN role
            ON contrat.id_role = role.id_role
            WHERE id_film = :id";
        $var_exec["id"] = "$id";

        $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        return $requete_recovery;
    }

    // Liste Film et rôle joué selon l'id de la personne
    public function listFilmsAndRoleperActeur($id){
        $requete_prepare = "
            SELECT titre, nom_personnage, affiche_film, film.id_film AS id
            FROM film
            INNER JOIN contrat
            ON film.id_film = contrat.id_film
            INNER JOIN role
            ON contrat.id_role = role.id_role
            INNER JOIN acteur
            ON contrat.id_acteur = acteur.id_acteur
            WHERE acteur.id_personne = :id
        ";
        $var_exec["id"] = "$id";

        $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        return $requete_recovery;
    }

    // Liste genre d'un Film selon son id
    public function genreFilm($id){
        $requete_prepare = "
            SELECT genre.genre
            FROM gestion_genre, genre
            WHERE gestion_genre.id_genre = genre.id_genre
            AND gestion_genre.id_film = :id";
        $var_exec["id"] = "$id";
        
        $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        return $requete_recovery;
    }

    // Fiche Film
    public function ficheFilm($id){
        $requete_prepare = "
            SELECT titre, affiche_film, note, synopsis, date_sortie, duree, CONCAT(nom, ' ',prenom) AS personne, film.id_film AS id
            FROM film
            INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
            INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
            WHERE film.id_film = :id";
        $var_exec["id"] = "$id";

        $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        return $requete_recovery;
    }

    // Fiche Personne
    public function fichePersonne($id) {
        $requete_prepare = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, sexe,  date_naissance, profil, personne.id_personne AS id
            FROM personne
            WHERE personne.id_personne = :id";
        $var_exec["id"] = "$id";

        $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        return $requete_recovery;
    }

    // Filmographie en tant que réalisateur
    public function listFilmsPerRealisateur($id){
        $requete_prepare = "
            SELECT titre, affiche_film, film.id_film AS id
            FROM film
            INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
            INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
            WHERE realisateur.id_personne = :id";
        $var_exec["id"] = "$id";

        $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        return $requete_recovery;
    }

    // Filmographie en tant qu'acteur
    public function listFilmsPerActeur($id){
        $requete_prepare = "
            SELECT titre, affiche_film, film.id_film AS id
            FROM film
            INNER JOIN contrat
            ON film.id_film = contrat.id_film
            INNER JOIN acteur
            ON contrat.id_acteur = acteur.id_acteur
            INNER JOIN personne
            ON acteur.id_personne = personne.id_personne
            WHERE personne.id_personne = :id";
        $var_exec["id"] = "$id";

        $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        return $requete_recovery;
    }

    // Liste acteurs en fonction du role envoyé par formulaire
    public function acteursPerRole(){
        if(isset($_POST['submit']) && $_POST["role"] != "")
        {
            $nom_personnage    = filter_input(INPUT_POST, "role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $requete_prepare = "
                    SELECT CONCAT(nom, ' ',prenom) AS personne, acteur.id_personne AS id, profil
                    FROM personne
                    INNER JOIN acteur
                    ON personne.id_personne = acteur.id_personne
                    INNER JOIN contrat
                    ON acteur.id_acteur = contrat.id_acteur
                    INNER JOIN role
                    ON contrat.id_role = role.id_role
                    WHERE nom_personnage = :nom_personnage";

            $var_exec["nom_personnage"] = "$nom_personnage";
            $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
            return $requete_recovery;
        }
        else{
            return NULL;
        }
    }

    // Infos supplémentaire du réalisateur
    public function infosRealisateur($id){
        $requete_prepare = "
            SELECT film.titre, film.date_sortie
            FROM film, realisateur
            WHERE film.id_realisateur = realisateur.id_realisateur
            AND realisateur.id_personne = :id
            ORDER BY film.date_sortie";
        $var_exec["id"] = "$id";

        $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        return $requete_recovery;
    }

    // Infos supplémentaire de l'acteur
    public function infosActeur($id){
        $requete_prepare = "
            SELECT film.titre, film.date_sortie
            FROM film
            INNER JOIN contrat
            ON film.id_film = contrat.id_film
            INNER JOIN acteur
            ON contrat.id_acteur = acteur.id_acteur
            INNER JOIN personne
            ON acteur.id_personne = personne.id_personne
            WHERE personne.id_personne = :id
            ORDER BY film.date_sortie";
        $var_exec["id"] = "$id";

        $requete_recovery = $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
        return $requete_recovery;
    }











    // Fonction qui s'occupue de la modification et de la suppression d'un FILM
    public function ModifFilm($id){
        // Requetes de modification des données d'un film lors de l'envoi du formulaire à l'appui du bouton VALIDER
        if(isset($_POST['submit']))
        {
            $id_realisateur = filter_input(INPUT_POST, "personne", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $titre          = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_sortie    = filter_input(INPUT_POST, "date_sortie", FILTER_DEFAULT);
            $duree          = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $synopsis       = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $affiche_film   = filter_input(INPUT_POST, "affiche_film", FILTER_SANITIZE_URL);


            if(filter_var($id_realisateur, FILTER_VALIDATE_INT) && filter_var($duree, FILTER_VALIDATE_INT)){
                // ----------- Modification du realisateur du film -----------------
                $requete_prepare_realisateur = "
                            UPDATE film, realisateur
                            SET film.id_realisateur = realisateur.id_realisateur
                            WHERE realisateur.id_personne = :id_realisateur
                            AND film.id_film = :id
                            ";
                $var_exec_realis = array("id_realisateur" => "$id_realisateur",
                            "id" => "$id");
                
                $this->prepAndExecAndRecovery($requete_prepare_realisateur, $var_exec_realis);

                // ------------ Modification des propriétés du film ----------------
                $requete_prepare = "
                            UPDATE film
                            SET titre = :titre, 
                            date_sortie = :date_sortie,
                            duree = :duree,
                            synopsis = :synopsis,
                            affiche_film = :affiche_film
                            WHERE film.id_film = :id
                            ";
                $var_exec = array("titre" => "$titre",
                            "date_sortie" => "$date_sortie",
                            "duree" => "$duree",
                            "synopsis" => "$synopsis",
                            "affiche_film" => "$affiche_film",
                            "id" => "$id");
                $this->prepAndExecAndRecovery($requete_prepare, $var_exec);

                // Modification si et seulement si les genres du film ont été modifiés
                if(isset($_POST['check_list']))
                {
                    // --------- Suppression des anciens genres du film ------------
                    $requete_prepare_delete_genre = "
                        DELETE FROM gestion_genre
                        WHERE gestion_genre.id_film = :id
                    ";
                    $var_exec_del_genre["id"] = "$id";
                    $this->prepAndExecAndRecovery($requete_prepare_delete_genre, $var_exec_del_genre);

                    // ----------- Ajout des nouveaux genres du film ----------------
                    foreach($_POST['check_list'] as $keys) {
                        $requete_prepare_Genre = "
                            INSERT INTO gestion_genre (id_film, id_genre)
                            VALUES ((SELECT id_film FROM film WHERE film.titre = :titre), :id_genre)
                            ";
                        $var_exec_Genre = array("titre" => "$titre",
                                                "id_genre" => "$keys");
                        
                        $this->prepAndExecAndRecovery($requete_prepare_Genre, $var_exec_Genre);
                    }
                }
                $alert_message  = "SUCCESS : Le film a bien été modifié";
                $alert_type     = "success";
            }
            else
            {
                $alert_message  = "WARNING : Veuillez vérifier les données entrées du film et réessayer";
                $alert_type     = "warning";
            }
            // Redirection vers la Fiche de ce Film après modification
            $this->viewFicheFilm($id);
        }

        // Requetes de suppression des données d'un film lors de l'appui sur le bouton SUPPRIMER
        if(isset($_POST['delete']))
        {
            // ------------- Suppression des genres du film ------------------------
            $requete_prepare_delete_genre = "
                                        DELETE FROM gestion_genre
                                        WHERE gestion_genre.id_film = :id
                                        ";
            $var_exec_del_genre["id"] = "$id";
            $this->prepAndExecAndRecovery($requete_prepare_delete_genre, $var_exec_del_genre);

            // ------------------ Suppression du film ------------------------------
            $requete_prepare_delete_film = "
                                        DELETE FROM film
                                        WHERE film.id_film = :id
                                        ";
            $var_exec_del_film["id"] = "$id";
            $this->prepAndExecAndRecovery($requete_prepare_delete_film, $var_exec_del_film);

            $alert_message  = "SUCCESS : Le film a bien été supprimé";
            $alert_type     = "success";

            // Redirection vers la page HOME après suppression du FILM
            header("Location:index.php?action=home_view");
        }
    }

    // Fonction qui s'occupue de la modification et de la suppression d'une Personne
    public function ModifPersonne($id){
        // Requetes de modification des données d'une personne lors de l'envoi du formulaire à l'appui du bouton VALIDER
        if(isset($_POST['submit']))
        {
            $nom            = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom         = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe           = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_naissance = filter_input(INPUT_POST, "date_naissance", FILTER_DEFAULT);
            $profil         = filter_input(INPUT_POST, "profil", FILTER_SANITIZE_URL);
            
            // ------------ Modification des propriétés de la personne -------------
            $requete_prepare = "
                        UPDATE personne
                        SET nom = :nom, 
                        prenom = :prenom,
                        sexe = :sexe,
                        date_naissance = :date_naissance,
                        profil = :profil
                        WHERE personne.id_personne = :id
                        ";
            $var_exec = array("nom" => "$nom",
                            "prenom" => "$prenom",
                            "sexe" => "$sexe",
                            "date_naissance" => "$date_naissance",
                            "profil" => "$profil",
                            "id" => "$id");
            $this->prepAndExecAndRecovery($requete_prepare, $var_exec);

            $alert_message  = "SUCCESS : La modifcation du profil s'est bien déroulé";
            $type_message   = "success";
            $this->viewFichePersonne($id);
        }

        // Requetes de suppression des données d'une personne lors de l'appui sur le bouton SUPPRIMER
        if(isset($_POST['delete']))
        {
            // ------------------ Suppression de la personne -----------------------
            $requete_prepare_delete_personne = "
                                        DELETE FROM personne
                                        WHERE personne.id_personne = :id
                                        ";
            $var_exec_del_personne["id"] = "$id";
            $this->prepAndExecAndRecovery($requete_prepare_delete_personne, $var_exec_del_personne);

            $alert_message  = "SUCCESS : Le profil a bien été supprimé";
            $type_message   = "success";

            // Redirection vers la page HOME après suppression de la personne
            header("Location:index.php?action=home_view");
        }
    }




    // Fonction qui s'occupe de l'ajout d'un film
    public function addFilm(){
        if(isset($_POST['submit']))
        {
            $realisateur    = filter_input(INPUT_POST, "realisateur", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $titre          = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_sortie    = filter_input(INPUT_POST, "date_sortie", FILTER_DEFAULT);
            $duree          = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $synopsis       = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $affiche_film   = filter_input(INPUT_POST, "affiche_film", FILTER_SANITIZE_URL);

            var_dump($affiche_film); die;
            // requete select avec le titre 
            $requete_prepare_verif = "
                SELECT titre
                FROM film
                WHERE film.titre = :titre";
            
            $var_exec_verif["titre"] = "$titre";
            $requete_verif = $this->prepAndExecAndRecovery($requete_prepare_verif, $var_exec_verif);

            // Boucle vérifiant si le film n'existe pas déjà
            if($requete_verif->fetch())
            {
                $alert_message  = "ERROR : Le film existe déjà";
                $alert_type     = "error";
                header("Location:index.php?action=add_view");
            }
            else
            {
                // Verification des filtres du réalisateur et de la durée
                if(filter_var($realisateur, FILTER_VALIDATE_INT) && filter_var($duree, FILTER_VALIDATE_INT)){
        
                    $requete_prepare = "
                        INSERT INTO film (id_realisateur, titre, date_sortie, duree, synopsis, affiche_film)
                        VALUES (:id_realisateur, :titre, :date_sortie, :duree, :synopsis, :affiche_film)";
                    
                    $var_exec = array("id_realisateur" => "$realisateur",
                            "titre" => "$titre",
                            "date_sortie" => "$date_sortie",
                            "duree" => "$duree",
                            "synopsis" => "$synopsis",
                            "affiche_film" => "$affiche_film");
                    
                    $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
                                
                    foreach($_POST['check_list'] as $keys) {
                        $requete_prepare_Genre = "
                            INSERT INTO gestion_genre (id_film, id_genre)
                            VALUES ((SELECT id_film FROM film WHERE film.titre = :titre), :id_genre)
                            ";
                        $var_exec_Genre = array("titre" => "$titre",
                                                "id_genre" => "$keys");
                        
                        $this->prepAndExecAndRecovery($requete_prepare_Genre, $var_exec_Genre);
                    }
                    $alert_message  = "SUCCESS : Le film a bien été ajouté";
                    $alert_type     = "success";
                }
                header("Location:index.php?action=add_view");
            }
        }
    }

    // Fonction qui s'occupe de l'ajout d'une personne
    public function addPersonne(){
        if(isset($_POST['submit']))
        {
            $nom            = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom         = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe           = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_naissance = filter_input(INPUT_POST, "date_naissance", FILTER_DEFAULT);
            $profil         = filter_input(INPUT_POST, "profil", FILTER_SANITIZE_URL);

            var_dump($date_naissance);
            // Connexion à la base de données voulu
            $pdo = Connect::seConnecter();
            // Prepare la requête
            $requete_prepare = "
                INSERT INTO personne (nom, prenom, sexe, date_naissance, profil)
                VALUES (:nom, :prenom, :sexe, :date_naissance, :profil)
                ";
            $requete_recovery = $pdo->prepare("$requete_prepare");

            // Execute avec les variables présents dans la requête
            $var_exec = array("nom" => "$nom",
                            "prenom" => "$prenom",
                            "sexe" => "$sexe",
                            "date_naissance" => "$date_naissance",
                            "profil" => "$profil");
            $requete_recovery->execute($var_exec);

            // Récupération de la dernière id ajouté dans la table personne
            $id_personne = $pdo->lastInsertId();

            foreach($_POST['check_work'] as $keys) {
                if($keys == "check_realisateur")
                {
                    $requete_prepare_work = "
                        INSERT INTO realisateur (id_personne)
                        VALUES (:id_personne)";
                }
                else if($keys == "check_acteur")
                {
                    $requete_prepare_work = "
                        INSERT INTO acteur (id_personne)
                        VALUES (:id_personne)";
                }
                $var_exec_work["id_personne"] = "$id_personne";
                $this->prepAndExecAndRecovery($requete_prepare_work, $var_exec_work);
            }
            $alert_message  = "SUCCES : Le profil a bien été ajouté";
            $alert_type     = "success";
            header("Location:index.php?action=add_view");
        }
    }

/* --------------------------------------------------------------------------------------------- */






/* ----------------------------------- Control VIEW -------------------------------------------- */

    // Fonction qui retourne toutes les réponses de requête utiles pour la vue HOME
    public function viewHome() {
        // Liste des films 
        $requete_listFilms                  = $this->listFilms("defaut", "defaut");
        // Liste des Réalisateurs
        $requete_listRealisateurs           = $this->listRealisateurs("defaut");
        // Liste des Acteurs
        $requete_listActeurs                = $this->listActeurs();
        require "view/viewHome.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour la vue FILM
    public function viewFilm($genre) {
        // Liste des films selon la base de données SQL
        $requete_listFilms                  = $this->listFilms("defaut", "defaut");
        // Liste des films selon la note
        $requete_listFilmsPerNote           = $this->listFilms("note", "defaut");
        // Liste des films selon la date de sortie
        $requete_listFilmsPerDateSortie     = $this->listFilms("date_sortie", "defaut");
        // Liste des films selon la durée
        $requete_listFilmsPerDuree          = $this->listFilms("duree", "defaut");
        // Liste des films selon la genre
        $requete_listFilmsPerGenre          = $this->listFilms("defaut", $genre);
        // Liste de tous les genres de film
        $requete_listGenre                  = $this->listGenre();
        require "view/viewFilm.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour la vue REALISATEUR
    public function viewRealisateur() {
        // Liste des réalisateurs selon la base de données SQL
        $requete_listRealisateurs           = $this->listRealisateurs("defaut");
        // Liste des réalisateurs selon le nombre de film
        $requete_listRealisateursPerNbr     = $this->listRealisateurs("COUNT(id_film)");
        // Liste des réalisateurs selon la note
        $requete_listRealisateursPerNote    = $this->listRealisateurs("AVG(note)");
        require "view/viewRealisateur.php";
    }

    // Fonction qui retourne toutes les réponses de requête utiles pour la vue ACTEUR
    public function viewActeur(){
        // Liste des Acteurs
        $requete_listActeurs                = $this->listActeurs();
        // Liste des roles
        $requete_listRoles                  = $this->listRole();
        // Liste des acteurs selon le role
        $requete_listActeursPerRole         = $this->acteursPerRole();
        require "view/viewActeur.php";
    }

    public function viewAdd(){
        $alert_message  = "Il s'agit d'un test";
        $alert_type     = "warning";
        require "view/viewAdd.php";
    }

    public function viewAddPersonne(){
        require "view/viewAddPersonne.php";
    }

    public function viewAddFilm(){
        // Liste des realisateurs contenu dans la base de données pour le choix du réalisateur lors de la modification
        $requete_listRealisateurs       = $this->listRealisateurs("defaut");
        // Liste des genres présents dans la base de données
        $requete_listGenre              = $this->listGenre();
        require "view/viewAddFilm.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour l'affichage de la Fiche d'un Film
    public function viewFicheFilm($id) {
        // Ensemble des informations du film
        $requete_ficheFilm              = $this->ficheFilm($id);
        // Liste des genres selon l'id du film
        $requete_genre_film             = $this->genreFilm($id);
        // Liste des Acteurs et leur role dans le film selon l'id du film
        $requete_listActeursThisFilm    = $this->listActeursAndRoleperFilm($id);
        require "view/ficheFilm.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour l'affichage de la Fiche d'une Personne
    public function viewFichePersonne($id) {
        // Ensemble des informations d'une Personne selon son id
        $requete_fichePersonne              = $this->fichePersonne($id);
        // Liste des films réalisés par un réalisateur selon son id
        $requete_listFilmsPerRealisateur    = $this->listFilmsPerRealisateur($id);
        // Liste des films dont un acteur est présent selon son id
        $requete_listFilmsAndRolePerActeur  = $this->listFilmsAndRoleperActeur($id);
        // Informations Réalisateur
        $requete_infosRealisateur           = $this->infosRealisateur($id);
        // Informations Acteur
        $requete_infosActeur                = $this->infosActeur($id);
        require "view/fichePersonne.php";
    }
    

    // Fonction qui retourne toutes les réponses de requête utiles pour l'affichage de la Modification d'un film
    public function viewModifFilm($id){
        // Liste des realisateurs contenu dans la base de données pour le choix du réalisateur lors de la modification
        $requete_listRealisateurs       = $this->listRealisateurs("defaut");
        // Ensemble des données d'un film selon l'id
        $requete_ficheFilm              = $this->ficheFilm($id);
        // Liste des genres présents dans la base de données
        $requete_listGenre              = $this->listGenre();
        require "view/filmModif.php";
    }


    // Fonction qui retourne toutes les réponses de requête utiles pour l'affichage de la Modification d'une Personne
    public function viewModifPersonne($id){
        // Ensemble des informations d'une Personne selon son id
        $requete_fichePersonne          = $this->fichePersonne($id);
        require "view/personneModif.php";
    }

}