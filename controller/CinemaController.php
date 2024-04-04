<?php

namespace Controller;
use Model\Connect;

class CinemaController {

    // Execution et recuperation donnée par requête
    public function exec_recovery($requete){
        // Connexion à la base de données voulu
        $pdo = Connect::seConnecter();
        // Execute la requête voulu
        $requete_recovery = $pdo->query("$requete");
        return $requete_recovery;
    }

    // Execution et modification par requête
    public function exec_modif($requete){
        // Connexion à la base de données voulu
        $pdo = Connect::seConnecter();
        // Execute la requête voulu
        $pdo->query("$requete");
    }


    // Liste Film
    public function listFilms() {
        $requete = "
            SELECT titre, date_sortie, film.id_film AS id
            FROM film
            ";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Liste Realisateur
    public function listRealisateurs() {
        $requete = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, realisateur.id_personne AS id
            FROM realisateur, personne
            WHERE realisateur.id_personne = personne.id_personne
            ";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Liste Acteur
    public function listActeurs() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT CONCAT(nom, ' ',prenom) AS personne, acteur.id_personne AS id
            FROM acteur, personne
            WHERE acteur.id_personne = personne.id_personne
            ");
        return $requete;
    }

    // Liste Acteur
    public function listActeursAndRoleperFilm($id) {
        $requete = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, nom_personnage, acteur.id_personne AS id
            FROM contrat
            INNER JOIN acteur
            ON contrat.id_acteur = acteur.id_acteur
            INNER JOIN personne
            ON acteur.id_personne = personne.id_personne
            INNER JOIN role
            ON contrat.id_role = role.id_role
            WHERE id_film = $id";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Fiche Film
    public function ficheFilm($id){ //DATE_FORMAT(SEC_TO_TIME(duree*60), '%H:%i') AS duree
        $requete = "
            SELECT titre, affiche_film, note, synopsis, date_sortie, duree, CONCAT(nom, ' ',prenom) AS personne, film.id_film AS id
            FROM film
            INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
            INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
            WHERE film.id_film = $id";
        
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }



    // Fiche Personne
    public function fichePersonne($id) {
        $requete = "
            SELECT CONCAT(nom, ' ',prenom) AS personne, date_naissance, profil
            FROM personne
            WHERE personne.id_personne = $id";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Filmographie en tant que réalisateur
    public function listFilmsPerRealisateur($id){
        $requete = "
            SELECT titre, affiche_film, film.id_film AS id
            FROM film
            INNER JOIN realisateur
            ON film.id_realisateur = realisateur.id_realisateur
            INNER JOIN personne
            ON realisateur.id_personne = personne.id_personne
            WHERE realisateur.id_personne = $id";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }

    // Filmographie en tant qu'acteur
    public function listFilmsPerActeur($id){
        $requete = "
            SELECT titre, affiche_film, film.id_film AS id
            FROM film
            INNER JOIN contrat
            ON film.id_film = contrat.id_film
            INNER JOIN acteur
            ON contrat.id_acteur = acteur.id_acteur
            INNER JOIN personne
            ON acteur.id_personne = personne.id_personne
            WHERE personne.id_personne = $id";
        $requete_recovery = $this->exec_recovery($requete);
        return $requete_recovery;
    }





    public function modifFilm_requete($id){
        if(isset($_POST['submit']))
        {
            $id_realisateur = filter_input(INPUT_POST, "personne", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $titre          = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_sortie    = filter_input(INPUT_POST, "date_sortie", FILTER_DEFAULT);
            $duree          = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $synopsis       = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $affiche_film   = filter_input(INPUT_POST, "affiche_film", FILTER_SANITIZE_URL);
            
            if(filter_var($id_realisateur, FILTER_VALIDATE_INT)){
                $requeteRealisateur = "
                            UPDATE film, realisateur
                            SET film.id_realisateur = realisateur.id_realisateur
                            WHERE realisateur.id_personne = $id_realisateur
                            AND film.id_film = $id
                            ";
                
                $this->exec_modif($requeteRealisateur);
            }
            
            if(filter_var($duree, FILTER_VALIDATE_INT)){
                $requete = "
                            UPDATE film
                            SET titre = '$titre', 
                            date_sortie = '$date_sortie',
                            duree = '$duree',
                            synopsis = '$synopsis',
                            affiche_film = '$affiche_film'
                            WHERE film.id_film = $id
                            ";

                $this->exec_modif($requete);
            }

            $this->viewFicheFilm($id);
        }

        if(isset($_POST['delete'])){
            $requete_delete = "
                                DELETE FROM 'film'
                                WHERE film.id_film = $id
                                ";

            $this->exec_modif($requete_delete);
            $this->viewHome();
        }
    }

    public function modifPersonne_requete($id){
        if(isset($_POST['submit']))
        {
            $nom            = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom         = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe           = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_naissance = filter_input(INPUT_POST, "date_naissance", FILTER_DEFAULT);
            $profil         = filter_input(INPUT_POST, "profil", FILTER_SANITIZE_URL);
            
            $requete = "
                        UPDATE personne
                        SET nom = '$nom', 
                        prenom = '$prenom',
                        sexe = '$sexe',
                        date_naissance = '$date_naissance',
                        profil = '$profil'
                        WHERE personne.id_personne = $id
                        ";
            $this->exec_modif($requete);

            $this->viewFichePersonne($id);
        }

        // if(isset($_POST['delete'])){
        //     $requete_delete = "
        //                         DELETE FROM 'film'
        //                         WHERE film.id_film = $id
        //                         ";

        //     $this->exec_modif($requete_delete);
        //     $this->viewHome();
        // }
    }




    public function viewHome() {
        $pdo = Connect::seConnecter();

        $requete_listFilms = $this->listFilms();
        $requete_listRealisateurs = $this->listRealisateurs();
        require "view/viewHome.php";
    }

    public function viewFilm() {
        $pdo = Connect::seConnecter();

        $requete_listFilms = $this->listFilms();
        require "view/viewFilm.php";
    }

    public function viewFicheFilm($id) {
        $requete_ficheFilm = $this->ficheFilm($id);
        $requete_listActeursThisFilm = $this->listActeursAndRoleperFilm($id);
        require "view/ficheFilm.php";
    }

    public function viewFichePersonne($id) {
        $requete_fichePersonne = $this->fichePersonne($id);
        $requete_listFilmsPerRealisateur = $this->listFilmsPerRealisateur($id);
        $requete_listFilmsPerActeur = $this->listFilmsPerActeur($id);
        require "view/fichePersonne.php";
    }

    public function viewModifFilm($id){
        $requete_listRealisateurs = $this->listRealisateurs();
        $requete_ficheFilm = $this->ficheFilm($id);
        require "view/filmModif.php";
    }

    public function ModifFilm($id){
        $this->modifFilm_requete($id);
    }

    public function ModifPersonne($id){
        $this->modifPersonne_requete($id);
    }
}