<?php

namespace Controller;
use Model\Connect;

class ModifCinemaController {

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



    // Fonction qui s'occupue de la modification et de la suppression d'un FILM
    public function ModifFilm($id){
        session_start();
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
                $_SESSION["alert_message"]  = "SUCCESS : Le film a bien été modifié";
                $_SESSION["alert_type"]     = "success";
            }
            else
            {
                $_SESSION["alert_message"]  = "WARNING : Veuillez vérifier les données entrées du film et réessayer";
                $_SESSION["alert_type"]     = "warning";
            }
            // Redirection vers la Fiche de ce Film après modification
            //$this->viewFicheFilm($id);
            header("Location:index.php?action=film_fiche_view&id=$id");
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

            $_SESSION["alert_message"]  = "SUCCESS : Le film a bien été supprimé";
            $_SESSION["alert_type"]     = "success";

            // Redirection vers la page HOME après suppression du FILM
            header("Location:index.php?action=home_view");
        }
    }

    // Fonction qui s'occupue de la modification et de la suppression d'une Personne
    public function ModifPersonne($id){
        session_start();
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

            $_SESSION["alert_message"]  = "SUCCESS : La modifcation du profil s'est bien déroulé";
            $_SESSION["alert_type"]   = "success";
            // $this->viewFichePersonne($id);
            header("Location:index.php?action=personne_fiche_view&id=$id");
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

            $_SESSION["alert_message"]  = "SUCCESS : Le profil a bien été supprimé";
            $_SESSION["alert_type"]   = "success";

            // Redirection vers la page HOME après suppression de la personne
            header("Location:index.php?action=home_view");
        }
    }
}