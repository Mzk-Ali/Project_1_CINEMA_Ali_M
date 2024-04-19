<?php

namespace Controller;
use Model\Connect;

class AddCinemaController {

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



    // Fonction qui s'occupe de l'ajout d'un film
    public function addFilm(){
        session_start();
        if(isset($_POST['submit']))
        {
            $realisateur    = filter_input(INPUT_POST, "realisateur", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $titre          = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_sortie    = filter_input(INPUT_POST, "date_sortie", FILTER_DEFAULT);
            $duree          = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $synopsis       = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $affiche_film   = filter_input(INPUT_POST, "affiche_film", FILTER_SANITIZE_URL);

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
                $_SESSION["alert_message"]  = "ERROR : Le film existe déjà";
                $_SESSION["alert_type"]     = "error";
                header("Location:index.php?action=add_view");
            }
            else
            {
                // Verification des filtres du réalisateur et de la durée
                if(filter_var($realisateur, FILTER_VALIDATE_INT) && filter_var($duree, FILTER_VALIDATE_INT)){
        
                    $requete_prepare = "
                        INSERT INTO film (id_realisateur, titre, date_sortie, duree, synopsis)
                        VALUES (:id_realisateur, :titre, :date_sortie, :duree, :synopsis)";
                    
                    $var_exec = array("id_realisateur" => "$realisateur",
                            "titre" => "$titre",
                            "date_sortie" => "$date_sortie",
                            "duree" => "$duree",
                            "synopsis" => "$synopsis");
                    
                    $this->prepAndExecAndRecovery($requete_prepare, $var_exec);
                    
                    
                    if(strlen($affiche_film) > 0)
                    {
                        $requete_prepare_affiche = "
                        INSERT INTO film (affiche_film)
                        VALUES (:affiche_film)";
                        $var_exec_affiche = array("affiche_film" => "$affiche_film");
                        $this->prepAndExecAndRecovery($requete_prepare_affiche, $var_exec_affiche);
                    }

                    foreach($_POST['check_list'] as $keys) {
                        $requete_prepare_Genre = "
                            INSERT INTO gestion_genre (id_film, id_genre)
                            VALUES ((SELECT id_film FROM film WHERE film.titre = :titre), :id_genre)
                            ";
                        $var_exec_Genre = array("titre" => "$titre",
                                                "id_genre" => "$keys");
                        
                        $this->prepAndExecAndRecovery($requete_prepare_Genre, $var_exec_Genre);
                    }
                    $_SESSION["alert_message"]  = "SUCCESS : Le film a bien été ajouté";
                    $_SESSION["alert_type"]     = "success";
                }
                header("Location:index.php?action=add_view");
            }
        }
    }

    // Fonction qui s'occupe de l'ajout d'une personne
    public function addPersonne(){
        session_start();
        if(isset($_POST['submit']))
        {
            $nom            = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom         = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe           = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_naissance = filter_input(INPUT_POST, "date_naissance", FILTER_DEFAULT);
            $profil         = filter_input(INPUT_POST, "profil", FILTER_SANITIZE_URL);

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
            $_SESSION["alert_message"]  = "SUCCES : Le profil a bien été ajouté";
            $_SESSION["alert_type"]     = "success";
            header("Location:index.php?action=add_view");
        }
    }


}